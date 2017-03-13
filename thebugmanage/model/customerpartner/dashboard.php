<?php
class ModelCustomerpartnerDashboard extends Model {	
	
	// Sales

	public function getPaidAmount($customer_id){
		$sql = "SELECT SUM(cp2t.amount) as paid FROM ".DB_PREFIX."customerpartner_to_transaction cp2t WHERE cp2t.customer_id='".$customer_id."' ";
		$result = $this->db->query($sql)->row;
		if(isset($result['paid'])) {
			return $result['paid'];
		} else {
			return false;
		}
	}

	public function getTotalSales($data = array(),$customer_id) {
		$sql = "SELECT SUM(c2o.customer + c2o.admin ) AS total, SUM(c2o.customer) as seller, SUM(c2o.admin) as admin,c2o.price FROM `" . DB_PREFIX . "customerpartner_to_order` c2o LEFT JOIN `".DB_PREFIX ."order` o ON (c2o.order_id = o.order_id) where c2o.customer_id='".$customer_id."' AND o.order_status_id > 0 ";

		if (isset($data['filter_date_added']) AND !empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
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
	public function getTotalCustomers($data = array(),$customer_id) {
		$sql = "SELECT DISTINCT o.customer_id FROM `" . DB_PREFIX . "order_product` op LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (op.product_id = c2o.product_id AND op.order_id = c2o.order_id) LEFT JOIN `".DB_PREFIX ."order` o ON (op.order_id = o.order_id) where c2o.customer_id='".$customer_id."' AND o.order_status_id > 0 ";

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
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

		$query = $this->db->query("SELECT COUNT(*) AS total, HOUR(date_added) AS hour FROM `" . DB_PREFIX . "customer` WHERE DATE(date_added) = DATE(NOW()) GROUP BY HOUR(date_added) ORDER BY date_added ASC");

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

		$query = $this->db->query("SELECT COUNT(*) AS total, date_added FROM `" . DB_PREFIX . "customer` WHERE DATE(date_added) >= DATE('" . $this->db->escape(date('Y-m-d', $date_start)) . "') GROUP BY DAYNAME(date_added)");

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

		$query = $this->db->query("SELECT COUNT(*) AS total, date_added FROM `" . DB_PREFIX . "customer` WHERE DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m') . '-1') . "' GROUP BY DATE(date_added)");

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

		$query = $this->db->query("SELECT COUNT(*) AS total, date_added FROM `" . DB_PREFIX . "customer` WHERE YEAR(date_added) = YEAR(NOW()) GROUP BY MONTH(date_added)");

		foreach ($query->rows as $result) {
			$customer_data[date('n', strtotime($result['date_added']))] = array(
				'month' => date('M', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}

		return $customer_data;
	}

		
	// Map
	public function getTotalOrdersByCountry($customer_id) {
		$query = $this->db->query("SELECT COUNT(DISTINCT c2o.order_id) AS total, SUM(c2o.price) AS amount, c.iso_code_2 FROM `" . DB_PREFIX . "customerpartner_to_order` c2o LEFT JOIN `".DB_PREFIX ."order_product` op ON (op.order_product_id = c2o.order_product_id AND op.order_id = c2o.order_id) LEFT JOIN `".DB_PREFIX ."order` o ON (c2o.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "country` c ON (o.payment_country_id = c.country_id) WHERE c2o.customer_id='".$customer_id."' AND o.order_status_id > '0' GROUP BY o.payment_country_id");
		return $query->rows;
	}
		
	// Orders
	public function getTotalOrdersByDay() {
		$order_data = array();

		for ($i = 0; $i < 24; $i++) {
			$order_data[$i] = array(
				'hour'  => $i,
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, HOUR(date_added) AS hour FROM `" . DB_PREFIX . "order_product` op LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (op.product_id = c2o.product_id AND op.order_id = c2o.order_id) LEFT JOIN `".DB_PREFIX ."order` o ON (op.order_id = o.order_id) WHERE c2o.customer_id='".$customer_id."' AND order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "' AND DATE(date_added) = DATE(NOW()) GROUP BY HOUR(date_added) ORDER BY date_added ASC");

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

		$date_start = strtotime('-' . date('w') . ' days');

		for ($i = 0; $i < 7; $i++) {
			$date = date('Y-m-d', $date_start + ($i * 86400));

			$order_data[date('w', strtotime($date))] = array(
				'day'   => date('D', strtotime($date)),
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, date_added FROM `" . DB_PREFIX . "order_product` op LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (op.product_id = c2o.product_id AND op.order_id = c2o.order_id) LEFT JOIN `".DB_PREFIX ."order` o ON (op.order_id = o.order_id) WHERE c2o.customer_id='".$customer_id."' AND order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "' AND DATE(date_added) >= DATE('" . $this->db->escape(date('Y-m-d', $date_start)) . "') GROUP BY DAYNAME(date_added)");

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

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$order_data[date('j', strtotime($date))] = array(
				'day'   => date('d', strtotime($date)),
				'total' => 0
			);
		}

		$query = $this->db->query("SELECT COUNT(*) AS total, date_added FROM `" . DB_PREFIX . "order_product` op LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (op.product_id = c2o.product_id AND op.order_id = c2o.order_id) LEFT JOIN `".DB_PREFIX ."order` o ON (op.order_id = o.order_id) WHERE c2o.customer_id='".$customer_id."' AND order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "' AND DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m') . '-1') . "' GROUP BY DATE(date_added)");

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

		for ($i = 1; $i <= 12; $i++) {
			$order_data[$i] = array(
				'month' => date('M', mktime(0, 0, 0, $i)),
				'total' => 0
			);
		}
		
		$query = $this->db->query("SELECT COUNT(*) AS total, date_added FROM `" . DB_PREFIX . "order_product` op LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (op.product_id = c2o.product_id AND op.order_id = c2o.order_id) LEFT JOIN `".DB_PREFIX ."order` o ON (op.order_id = o.order_id) WHERE c2o.customer_id='".$customer_id."' AND order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "' AND YEAR(date_added) = YEAR(NOW()) GROUP BY MONTH(date_added)");

		foreach ($query->rows as $result) {
			$order_data[date('n', strtotime($result['date_added']))] = array(
				'month' => date('M', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}

		return $order_data;
	}

}
?>