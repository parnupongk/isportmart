<?php
class ModelCustomerpartnerDashboard extends Model {	
	
	// Sales

	public function getPaidAmount(){
		$sql = "SELECT SUM(cp2t.amount) as paid FROM ".DB_PREFIX."customerpartner_to_transaction cp2t WHERE cp2t.customer_id='".$this->customer->getId()."' ";
		$result = $this->db->query($sql)->row;
		if(isset($result['paid'])) {
			return $result['paid'];
		} else {
			return false;
		}
	}

	public function getTotalSales($data = array()) {
		$sql = "SELECT SUM(c2o.price) AS total, SUM(c2o.customer) as seller, SUM(c2o.admin) as admin FROM `" . DB_PREFIX . "customerpartner_to_order` c2o LEFT JOIN `".DB_PREFIX ."order` o ON (c2o.order_id = o.order_id) where c2o.customer_id='".$this->customer->getId()."' AND o.order_status_id > 0 ";

		if (isset($data['filter_date_added']) AND !empty($data['filter_date_added'])) {
			$sql .= " AND DATE(c2o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (isset($data['filter_order_id']) AND $data['filter_order_id']) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		$query = $this->db->query($sql);

		if(isset($query->row['total']))
			return $query->row;
		else
			return 0;
	}

	// customer
	public function getTotalCustomers($data = array()) {
		$sql = "SELECT DISTINCT o.customer_id FROM `" . DB_PREFIX . "order_product` op LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (op.product_id = c2o.product_id AND op.order_id = c2o.order_id) LEFT JOIN `".DB_PREFIX ."order` o ON (op.order_id = o.order_id) where c2o.customer_id='".$this->customer->getId()."' AND o.order_status_id > 0 ";

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(c2o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return count($query->rows);
	}

	public function getTotalCustomersByDay() {
		$customer_data = array();

		for ($i = 0; $i < 24; $i++) {
			$customer_data[$i] = array(
				'hour'  => $i,
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, HOUR(date_added) AS hour FROM `" . DB_PREFIX . "customer` WHERE customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "order WHERE order_id IN (SELECT order_id FROM " . DB_PREFIX . "customerpartner_to_order WHERE customer_id = ".$this->customer->getId().")) AND DATE(date_added) = DATE(NOW()) GROUP BY HOUR(date_added) ORDER BY date_added ASC");
		
		foreach ($query->rows as $result) {
			$customer_data[$result['hour']] = array(
				'hour'  => $result['hour'],
				'total' => $result['total']
			);
		}

		return $customer_data;
	}

	public function getTotalCustomersByWeek() {
		$customer_data = array();

		$date_start = strtotime('-' . date('w') . ' days');

		for ($i = 0; $i < 7; $i++) {
			$date = date('Y-m-d', $date_start + ($i * 86400));

			$order_data[date('w', strtotime($date))] = array(
				'day'   => date('D', strtotime($date)),
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, date_added FROM `" . DB_PREFIX . "customer` WHERE customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "order WHERE order_id IN (SELECT order_id FROM " . DB_PREFIX . "customerpartner_to_order WHERE customer_id = ".$this->customer->getId().")) AND DATE(date_added) >= DATE('" . $this->db->escape(date('Y-m-d', $date_start)) . "') GROUP BY DAYNAME(date_added)");

		foreach ($query->rows as $result) {
			$customer_data[date('w', strtotime($result['date_added']))] = array(
				'day'   => date('D', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}

		return $customer_data;
	}

	public function getTotalCustomersByMonth() {
		$customer_data = array();

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$customer_data[date('j', strtotime($date))] = array(
				'day'   => date('d', strtotime($date)),
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, date_added FROM `" . DB_PREFIX . "customer` WHERE customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "order WHERE order_id IN (SELECT order_id FROM " . DB_PREFIX . "customerpartner_to_order WHERE customer_id = ".$this->customer->getId().")) AND DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m') . '-1') . "' GROUP BY DATE(date_added)");

		foreach ($query->rows as $result) {
			$customer_data[date('j', strtotime($result['date_added']))] = array(
				'day'   => date('d', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}

		return $customer_data;
	}

	public function getTotalCustomersByYear() {
		$customer_data = array();

		for ($i = 1; $i <= 12; $i++) {
			$customer_data[$i] = array(
				'month' => date('M', mktime(0, 0, 0, $i)),
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, date_added FROM `" . DB_PREFIX . "customer` WHERE customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "order WHERE order_id IN (SELECT order_id FROM " . DB_PREFIX . "customerpartner_to_order WHERE customer_id = ".$this->customer->getId().")) AND YEAR(date_added) = YEAR(NOW()) GROUP BY MONTH(date_added)");

		foreach ($query->rows as $result) {
			$customer_data[date('n', strtotime($result['date_added']))] = array(
				'month' => date('M', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}

		return $customer_data;
	}

		
	// Map
	public function getTotalOrdersByCountry() {
		// $query = $this->db->query("SELECT COUNT(DISTINCT c2o.order_id) AS total, SUM(op.total + op.tax) AS amount, c.iso_code_2 FROM `" . DB_PREFIX . "order_product` op LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (op.product_id = c2o.product_id AND op.order_id = c2o.order_id) LEFT JOIN `".DB_PREFIX ."order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "country` c ON (o.payment_country_id = c.country_id) WHERE c2o.customer_id='".$this->customer->getId()."' AND o.order_status_id > '0' GROUP BY o.payment_country_id");

		$query = $this->db->query("SELECT COUNT(DISTINCT c2o.order_id) AS total, SUM(c2o.price) AS amount, c.iso_code_2 FROM `" . DB_PREFIX . "customerpartner_to_order` c2o LEFT JOIN `".DB_PREFIX ."order_product` op ON (op.order_product_id = c2o.order_product_id AND op.order_id = c2o.order_id) LEFT JOIN `".DB_PREFIX ."order` o ON (c2o.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "country` c ON (o.payment_country_id = c.country_id) WHERE c2o.customer_id='".$this->customer->getId()."' AND o.order_status_id > '0' GROUP BY o.payment_country_id");
		return $query->rows;
	}
		
	// Orders
	public function getTotalOrdersByDay() {
		$order_data = array();

		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		for ($i = 0; $i < 24; $i++) {
			$order_data[$i] = array(
				'hour'  => $i,
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, HOUR(c2o.date_added) AS hour FROM `" . DB_PREFIX . "order_product` op LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (op.product_id = c2o.product_id AND op.order_id = c2o.order_id) LEFT JOIN `".DB_PREFIX ."order` o ON (op.order_id = o.order_id) WHERE c2o.customer_id='".$this->customer->getId()."' AND o.order_status_id IN(" . implode(",", $implode) . ") AND DATE(c2o.date_added) = DATE(NOW()) GROUP BY HOUR(c2o.date_added) ORDER BY c2o.date_added ASC");

		foreach ($query->rows as $result) {
			$order_data[$result['hour']] = array(
				'hour'  => $result['hour'],
				'total' => $result['total']
			);
		}

		return $order_data;
	}

	public function getTotalOrdersByWeek() {
		$order_data = array();

		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		$date_start = strtotime('-' . date('w') . ' days');

		for ($i = 0; $i < 7; $i++) {
			$date = date('Y-m-d', $date_start + ($i * 86400));

			$order_data[date('w', strtotime($date))] = array(
				'day'   => date('D', strtotime($date)),
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, c2o.date_added FROM `" . DB_PREFIX . "order_product` op LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (op.product_id = c2o.product_id AND op.order_id = c2o.order_id) LEFT JOIN `".DB_PREFIX ."order` o ON (op.order_id = o.order_id) WHERE c2o.customer_id='".$this->customer->getId()."' AND o.order_status_id IN(" . implode(",", $implode) . ") AND DATE(c2o.date_added) >= DATE('" . $this->db->escape(date('Y-m-d', $date_start)) . "') GROUP BY DAYNAME(c2o.date_added)");

		foreach ($query->rows as $result) {
			$order_data[date('w', strtotime($result['date_added']))] = array(
				'day'   => date('D', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}

		return $order_data;
	}

	public function getTotalOrdersByMonth() {
		$order_data = array();

		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$order_data[date('j', strtotime($date))] = array(
				'day'   => date('d', strtotime($date)),
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, c2o.date_added FROM `" . DB_PREFIX . "order_product` op LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (op.product_id = c2o.product_id AND op.order_id = c2o.order_id) LEFT JOIN `".DB_PREFIX ."order` o ON (op.order_id = o.order_id) WHERE c2o.customer_id='".$this->customer->getId()."' AND o.order_status_id IN(" . implode(",", $implode) . ") AND DATE(c2o.date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m') . '-1') . "' GROUP BY DATE(c2o.date_added)");

		foreach ($query->rows as $result) {
			$order_data[date('j', strtotime($result['date_added']))] = array(
				'day'   => date('d', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}

		return $order_data;
	}

	public function getTotalOrdersByYear() {
		$order_data = array();

		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		for ($i = 1; $i <= 12; $i++) {
			$order_data[$i] = array(
				'month' => date('M', mktime(0, 0, 0, $i)),
				'total' => 0
			);
		}
		
		$query = $this->db->query("SELECT COUNT(*) AS total, c2o.date_added FROM `" . DB_PREFIX . "order_product` op LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (op.product_id = c2o.product_id AND op.order_id = c2o.order_id) LEFT JOIN `".DB_PREFIX ."order` o ON (op.order_id = o.order_id) WHERE c2o.customer_id='".$this->customer->getId()."' AND o.order_status_id IN(" . implode(",", $implode) . ") AND YEAR(c2o.date_added) = YEAR(NOW()) GROUP BY MONTH(c2o.date_added)");

		foreach ($query->rows as $result) {
			$order_data[date('n', strtotime($result['date_added']))] = array(
				'month' => date('M', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}

		return $order_data;
	}

	public function totalSellerOrder($data = array()){

		$sql = "SELECT * FROM `".DB_PREFIX ."order` o LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) LEFT JOIN ".DB_PREFIX ."order_status os ON (o.order_status_id = os.order_status_id) WHERE c2o.customer_id = '".$this->customer->getId()."' AND os.language_id = '".$this->config->get('config_language_id')."' AND c2o.seller_access = '1'";

		if (isset($data['filter_pending_order']) && $data['filter_pending_order']) {
			
			$sql .= 'AND o.order_status_id ="'.$data['filter_pending_order'].'"';
		}

		if (isset($data['filter_processing_order']) && $data['filter_processing_order']) {
			
			$sql .= 'AND o.order_status_id IN ("'.$data['filter_processing_order'].'")';
		}

		if (isset($data['filter_complete_order']) && $data['filter_complete_order']) {
			
			$sql .= 'AND os.name ="'.$data['filter_complete_order'].'"';
		}

		if (isset($data['filter_cancel_order']) && $data['filter_cancel_order']) {
			
			$sql .= 'AND o.order_status_id ="'.$data['filter_cancel_order'].'"';
		}

        $query = $this->db->query($sql)->rows;

		return count($query);
	}

	public function totalPendingOrder(){
        
        $query = $this->db->query("SELECT * FROM `".DB_PREFIX ."order` o LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) WHERE c2o.customer_id = '".$this->customer->getId()."' AND seller_access = '1'")->rows;

		// $sql = "SELECT DISTINCT o.order_id ,o.date_added,c2o.currency_code,c2o.currency_value, CONCAT(o.firstname ,' ',o.lastname) name ,os.name orderstatus  FROM " . DB_PREFIX ."order_status os LEFT JOIN `".DB_PREFIX ."order` o ON (os.order_status_id = o.order_status_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) WHERE c2o.customer_id = '".$this->customer->getId()."'  AND os.language_id = '".$this->config->get('config_language_id')."' AND c2o.seller_access = '1'";
		

		return count($query);
	}

	public function totalPocessingOrder(){

		echo "<pre>";
		print_r(implode(',', $this->config->get('config_processing_status')));
		echo "</pre>";
		die();

	}

}
?>