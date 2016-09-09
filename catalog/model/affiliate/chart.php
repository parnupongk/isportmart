<?php
class ModelAffiliateChart extends Model {
	public function getDataChartMonth(){
		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}
		$query = $this->db->query("select order_type, count(*) Number_Order from (
select (case when (order_status_id in (7,10,14,16)) THEN '1. Cancel' 
 ELSE 
    (case when (order_status_id in (2,15,19,20,22,23,25,26)) THEN '2. During Delivery' 
    ELSE
      (case when (order_status_id in (21,24,3)) THEN '3. Deliver to Customer' 
      ELSE
  (case when (order_status_id in (27)) THEN '4. Deliver cancel' 
  else
     (case when (order_status_id in (11)) THEN '5. Claim+Refund' 
     else
          (case when (order_status_id in (5)) THEN '6. Completed (Warranty)'
   else '7. Other' end)
     end)
  end)
      END)
    END)
 END)  order_type 
FROM `" . DB_PREFIX . "order` where order_status_id > 0 
and DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m') . '-1') ."' ) Z
group by order_type order by order_type ");
//echo $sql;
$order_data = array();
	foreach ($query->rows as $result) {
			$order_data[$result['order_type']] = array(
				'day'  => $result['order_type'],
				'total' => $result['Number_Order']
			);
		}
		return $order_data;
	}
	public function getTotalOrdersByDay() {
			
	$query = $this->db->query("select order_type, count(*) Number_Order from (
select (case when (order_status_id in (7,10,14,16)) THEN '1. Cancel' 
 ELSE 
    (case when (order_status_id in (2,15,19,20,22,23,25,26)) THEN '2. During Delivery' 
    ELSE
      (case when (order_status_id in (21,24,3)) THEN '3. Deliver to Customer' 
      ELSE
  (case when (order_status_id in (27)) THEN '4. Deliver cancel' 
  else
     (case when (order_status_id in (11)) THEN '5. Claim+Refund' 
     else
          (case when (order_status_id in (5)) THEN '6. Completed (Warranty)'
   else '7. Other' end)
     end)
  end)
      END)
    END)
 END)  order_type 
FROM `" . DB_PREFIX . "order` where order_status_id > 0 
AND DATE(date_added) > DATE_SUB(NOW(), INTERVAL 1 MONTH)) Z
group by order_type order by order_type ");
$order_data = array();
	foreach ($query->rows as $result) {
			$order_data[$result['order_type']] = array(
				'day'  => $result['order_type'],
				'total' => $result['Number_Order']
			);
		}
		return $order_data;
	}

	public function getTotalOrdersByWeek() {
		$query = $this->db->query("select order_type, count(*) Number_Order from (
select (case when (order_status_id in (7,10,14,16)) THEN '1. Cancel' 
 ELSE 
    (case when (order_status_id in (2,15,19,20,22,23,25,26)) THEN '2. During Delivery' 
    ELSE
      (case when (order_status_id in (21,24,3)) THEN '3. Deliver to Customer' 
      ELSE
  (case when (order_status_id in (27)) THEN '4. Deliver cancel' 
  else
     (case when (order_status_id in (11)) THEN '5. Claim+Refund' 
     else
          (case when (order_status_id in (5)) THEN '6. Completed (Warranty)'
   else '7. Other' end)
     end)
  end)
      END)
    END)
 END)  order_type 
FROM `" . DB_PREFIX . "order` where order_status_id > 0 
AND DATE(date_added) > DATE_SUB(NOW(), INTERVAL 1 MONTH)) Z
group by order_type order by order_type ");
$order_data = array();
	foreach ($query->rows as $result) {
			$order_data[$result['order_type']] = array(
				'day'  => $result['order_type'],
				'total' => $result['Number_Order']
			);
		}
		return $order_data;
	}

	public function getTotalOrdersByMonth() {
		
		$query = $this->db->query("select order_type, count(*) Number_Order from (
select (case when (order_status_id in (7,10,14,16)) THEN '1. Cancel' 
 ELSE 
    (case when (order_status_id in (2,15,19,20,22,23,25,26)) THEN '2. During Delivery' 
    ELSE
      (case when (order_status_id in (21,24,3)) THEN '3. Deliver to Customer' 
      ELSE
  (case when (order_status_id in (27)) THEN '4. Deliver cancel' 
  else
     (case when (order_status_id in (11)) THEN '5. Claim+Refund' 
     else
          (case when (order_status_id in (5)) THEN '6. Completed (Warranty)'
   else '7. Other' end)
     end)
  end)
      END)
    END)
 END)  order_type 
FROM `" . DB_PREFIX . "order` where order_status_id > 0 
AND DATE(date_added) > DATE_SUB(NOW(), INTERVAL 1 MONTH) ) Z
group by order_type order by order_type ");
//echo $sql;
$order_data = array();
	foreach ($query->rows as $result) {
			$order_data[$result['order_type']] = array(
				'total' => $result['Number_Order']
			);
		}
		return $order_data;
	}

	public function getTotalOrdersByYear() {
		
		$query = $this->db->query("select order_type, count(*) Number_Order from (
select (case when (order_status_id in (7,10,14,16)) THEN '1. Cancel' 
 ELSE 
    (case when (order_status_id in (2,15,19,20,22,23,25,26)) THEN '2. During Delivery' 
    ELSE
      (case when (order_status_id in (21,24,3)) THEN '3. Deliver to Customer' 
      ELSE
  (case when (order_status_id in (27)) THEN '4. Deliver cancel' 
  else
     (case when (order_status_id in (11)) THEN '5. Claim+Refund' 
     else
          (case when (order_status_id in (5)) THEN '6. Completed (Warranty)'
   else '7. Other' end)
     end)
  end)
      END)
    END)
 END)  order_type 
FROM `" . DB_PREFIX . "order` where order_status_id > 0 
AND YEAR(date_added) = YEAR(NOW())) Z
group by order_type order by order_type ");
//echo $sql;
$order_data = array();
	foreach ($query->rows as $result) {
			$order_data[$result['order_type']] = array(
				'month'  => $result['order_type'],
				'total' => $result['Number_Order']
			);
		}
		return $order_data;
	}
	public function getOrders($data = array()) {
		$sql = "SELECT MIN(o.date_added) AS date_start, MAX(o.date_added) AS date_end, COUNT(*) AS `orders`, SUM((SELECT SUM(op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)) AS products, SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'tax' GROUP BY ot.order_id)) AS tax, SUM(o.total) AS `total` FROM `" . DB_PREFIX . "order` o";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added)";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY YEAR(o.date_added), WEEK(o.date_added)";
				break;
			case 'month':
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added)";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added)";
				break;
		}

		$sql .= " ORDER BY o.date_added DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	public function getTotalOrders($data = array()) {
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added), MONTH(date_added), DAY(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;
			default:
			case 'week':
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added), WEEK(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;
			case 'month':
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added), MONTH(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;
			case 'year':
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;
		}

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	public function getTotalOrdersByMonthCancel() {
		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		$order_data = array();

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$order_data[date('j', strtotime($date))] = array(
				'day'   => date('d', strtotime($date)),
				'total' => 0
			);
		}
$query = $this->db->query("SELECT date_added, count( * ) Number_Order
 FROM `" . DB_PREFIX . "order`  WHERE order_status_id IN ( 7, 10, 14, 16 )
 and  DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m')-1 . '-1') . "'
GROUP BY DATE(date_added)
ORDER BY date_added ");
	
		foreach ($query->rows as $result) {

			$order_data[date('j', strtotime($result['date_added']))] = array(
				'day'   => date('d', strtotime($result['date_added'])),				
				'total' => $result['Number_Order']
			);
			
		}

		return $order_data;
	}
	public function getTotalOrdersByMonthDuring() {
		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		$order_data = array();

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$order_data[date('j', strtotime($date))] = array(
				'day'   => date('d', strtotime($date)),
				'total' => 0
			);
		}
$query = $this->db->query("SELECT date_added, count( * ) Number_Order
 FROM `" . DB_PREFIX . "order`  WHERE order_status_id IN ( 2,15,19,20,22,23,25,26 )
 and  DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m')-1 . '-1') . "'
GROUP BY DATE(date_added)
ORDER BY date_added ");
	
		foreach ($query->rows as $result) {

			$order_data[date('j', strtotime($result['date_added']))] = array(
				'day'   => date('d', strtotime($result['date_added'])),				
				'total' => $result['Number_Order']
			);
			
		}

		return $order_data;
	}
	public function getTotalOrdersByMonthDeliver() {
		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		$order_data = array();

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$order_data[date('j', strtotime($date))] = array(
				'day'   => date('d', strtotime($date)),
				'total' => 0
			);
		}
$query = $this->db->query("SELECT date_added, count( * ) Number_Order
 FROM `" . DB_PREFIX . "order`  WHERE order_status_id IN (21,24,3)
 and  DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m')-1 . '-1') . "'
GROUP BY DATE(date_added)
ORDER BY date_added ");

		foreach ($query->rows as $result) {

			$order_data[date('j', strtotime($result['date_added']))] = array(
				'day'   => date('d', strtotime($result['date_added'])),				
				'total' => $result['Number_Order']
			);
			
		}

		return $order_data;
	}
	public function getTotalOrdersByMonthDeliverCancel() {
		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		$order_data = array();

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$order_data[date('j', strtotime($date))] = array(
				'day'   => date('d', strtotime($date)),
				'total' => 0
			);
		}
$query = $this->db->query("SELECT date_added, count( * ) Number_Order
 FROM `" . DB_PREFIX . "order`  WHERE order_status_id IN (27)
 and  DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m')-1 . '-1') . "'
GROUP BY DATE(date_added)
ORDER BY date_added ");

		foreach ($query->rows as $result) {

			$order_data[date('j', strtotime($result['date_added']))] = array(
				'day'   => date('d', strtotime($result['date_added'])),				
				'total' => $result['Number_Order']
			);
			
		}

		return $order_data;
	}
	public function getTotalOrdersByMonthDeliverClaim() {
		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		$order_data = array();

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$order_data[date('j', strtotime($date))] = array(
				'day'   => date('d', strtotime($date)),
				'total' => 0
			);
		}
$query = $this->db->query("SELECT date_added, count( * ) Number_Order
 FROM `" . DB_PREFIX . "order`  WHERE order_status_id IN (11)
 and  DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m')-1 . '-1') . "'
GROUP BY DATE(date_added)
ORDER BY date_added ");
	
		foreach ($query->rows as $result) {

			$order_data[date('j', strtotime($result['date_added']))] = array(
				'day'   => date('d', strtotime($result['date_added'])),				
				'total' => $result['Number_Order']
			);
			
		}

		return $order_data;
	}
	public function getTotalOrdersByMonthDeliverCompleted() {
		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		$order_data = array();

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$order_data[date('j', strtotime($date))] = array(
				'day'   => date('d', strtotime($date)),
				'total' => 0
			);
		}
$query = $this->db->query("SELECT date_added, count( * ) Number_Order
 FROM `" . DB_PREFIX . "order`  WHERE order_status_id IN (5)
 and  DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m')-1 . '-1') . "'
GROUP BY DATE(date_added)
ORDER BY date_added ");

		foreach ($query->rows as $result) {

			$order_data[date('j', strtotime($result['date_added']))] = array(
				'day'   => date('d', strtotime($result['date_added'])),				
				'total' => $result['Number_Order']
			);
			
		}

		return $order_data;
	}
	public function getTotalOrdersByMonthDeliverOther() {
		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}

		$order_data = array();

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$order_data[date('j', strtotime($date))] = array(
				'day'   => date('d', strtotime($date)),
				'total' => 0
			);
		}
$query = $this->db->query("SELECT date_added, count( * ) Number_Order
 FROM `" . DB_PREFIX . "order`  WHERE order_status_id NOT IN (7,10,14,16,2,15,19,20,22,23,25,26,21,24,3,27,11,5)
 and  DATE(date_added) >= '" . $this->db->escape(date('Y') . '-' . date('m')-1 . '-1') . "'
GROUP BY DATE(date_added)
ORDER BY date_added ");
		foreach ($query->rows as $result) {

			$order_data[date('j', strtotime($result['date_added']))] = array(
				'day'   => date('d', strtotime($result['date_added'])),				
				'total' => $result['Number_Order']
			);
			
		}

		return $order_data;
	}
}