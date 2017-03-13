<?php
class ModelCustomerpartnerReview extends Model {

	public function getTotalReviews($data = array()) {
		$sql = "SELECT c2f.*, CONCAT(c1.firstname,' ',c1.lastname) as customer_name, CONCAT(c2.firstname,' ',c2.lastname) as seller_name FROM " . DB_PREFIX . "customerpartner_to_feedback c2f LEFT JOIN " . DB_PREFIX . "customer c1 ON (c2f.customer_id = c1.customer_id) LEFT JOIN " . DB_PREFIX . "customer c2 ON (c2f.seller_id = c2.customer_id) WHERE 1";

		if (isset($data['filter_seller']) && !is_null($data['filter_seller'])) {
			$sql .= " AND LCASE(CONCAT(c2.firstname, ' ', c2.lastname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_seller'])) . "%'";
		}

		if (isset($data['filter_customer']) && !is_null($data['filter_customer'])) {
			$sql .= " AND LCASE(CONCAT(c1.firstname, ' ', c1.lastname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_customer'])) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND c2f.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_createdate'])) {
			$sql .= " AND DATE(c2f.createdate) = DATE('" . $this->db->escape($data['filter_createdate']) . "')";
		}

		$query = $this->db->query($sql);

		return count($query->rows);
	}

	public function getReviews($data = array()) {
		$sql = "SELECT c2f.*, CONCAT(c1.firstname,' ',c1.lastname) as customer_name, CONCAT(c2.firstname,' ',c2.lastname) as seller_name FROM " . DB_PREFIX . "customerpartner_to_feedback c2f LEFT JOIN " . DB_PREFIX . "customer c1 ON (c2f.customer_id = c1.customer_id) LEFT JOIN " . DB_PREFIX . "customer c2 ON (c2f.seller_id = c2.customer_id) WHERE 1";

		if (isset($data['filter_seller']) && !is_null($data['filter_seller'])) {
			$sql .= " AND LCASE(CONCAT(c2.firstname, ' ', c2.lastname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_seller'])) . "%'";
		}

		if (isset($data['filter_customer']) && !is_null($data['filter_customer'])) {
			$sql .= " AND LCASE(CONCAT(c1.firstname, ' ', c1.lastname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_customer'])) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND c2f.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_createdate'])) {
			$sql .= " AND DATE(c2f.createdate) = DATE('" . $this->db->escape($data['filter_createdate']) . "')";
		}

		$sort_data = array(
			'c2f.seller_id',
			'c2f.customer_id',
			'c2f.rating_price',
			'c2f.rating_value',
			'c2f.rating_quality',
			'c2f.status',
			'c2f.createdate'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY c2f.createdate";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function deleteReview($review_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_to_feedback WHERE id = '" . (int)$review_id . "'");
	}

	public function getReview($review_id) {
		$query = $this->db->query("SELECT c2f.*, CONCAT(c1.firstname,' ',c1.lastname) as customer_name, CONCAT(c2.firstname,' ',c2.lastname) as seller_name FROM " . DB_PREFIX . "customerpartner_to_feedback c2f LEFT JOIN " . DB_PREFIX . "customer c1 ON (c2f.customer_id = c1.customer_id) LEFT JOIN " . DB_PREFIX . "customer c2 ON (c2f.seller_id = c2.customer_id) WHERE c2f.id = '" . (int)$review_id . "'");

		return $query->row;
	}

	public function getCustomers($data = array()) {
		
		if (!$data['filter_seller_field']) {
           
           $sql = "SELECT CONCAT(c.firstname, ' ', c.lastname) AS name,c.customer_id AS customer_id FROM " . DB_PREFIX . "customer c WHERE 1";			
		}else{

		   $sql = "SELECT CONCAT(c.firstname, ' ', c.lastname) AS name,c.customer_id AS customer_id FROM " . DB_PREFIX . "customer c RIGHT JOIN ". DB_PREFIX . "customerpartner_to_customer c2c ON (c2c.customer_id = c.customer_id) WHERE 1";		
		}

		$implode = array();
		
		if (!empty($data['filter_customer'])) {
			$implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_customer'])) . "%'";
		}

		if (!empty($data['filter_seller'])) {
			$implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_seller'])) . "%'";
		}
		
		if (isset($data['filter_customer_id']) && !is_null($data['filter_customer_id'])) {
			$implode[] = "c.customer_id != '" . (int)$data['filter_customer_id'] . "'";
		}

		if (isset($data['filter_seller_id']) && !is_null($data['filter_seller_id'])) {
			$implode[] = "c.customer_id != '" . (int)$data['filter_seller_id'] . "'";
		}	
		
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sql .= " ORDER BY c.customer_id";

		$query = $this->db->query($sql);

		return $query->rows;	
	}

	public function addReview($data) {
        
        $check = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_to_feedback WHERE customer_id = '" . (int)$this->db->escape($data['customer_id']) . "' AND seller_id = '" . (int)$this->db->escape($data['seller_id']) . "'")->row;

        if ($check) {

        	$this->db->query("UPDATE `" . DB_PREFIX . "customerpartner_to_feedback` SET feedprice = '" . (int)$this->db->escape($data['rating_price']) . "', feedvalue = '" . (int)$this->db->escape($data['rating_value']) . "', feedquality = '" . (int)$this->db->escape($data['rating_quality']) . "', nickname = '" . $this->db->escape($data['customer']) . "', review = '" . $this->db->escape($data['text']) . "', status = '" . (int)$data['status'] . "', createdate = NOW() WHERE customer_id = '" . (int)$this->db->escape($data['customer_id']) . "' AND seller_id = '" . (int)$this->db->escape($data['seller_id']) . "'");
        	
        }else{

        	$this->db->query("INSERT INTO `" . DB_PREFIX . "customerpartner_to_feedback` SET `customer_id` = '" . (int)$this->db->escape($data['customer_id']) . "', `seller_id` = '" . (int)$this->db->escape($data['seller_id']) . "', feedprice = '" . (int)$this->db->escape($data['rating_price']) . "', feedvalue = '" . (int)$this->db->escape($data['rating_value']) . "', feedquality = '" . (int)$this->db->escape($data['rating_quality']) . "', nickname = '" . $this->db->escape($data['customer']) . "', review = '" . $this->db->escape($data['text']) . "', status = '" . (int)$data['status'] . "', createdate = NOW()");
        }
	}
}