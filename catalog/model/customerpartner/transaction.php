<?php
class ModelCustomerpartnerTransaction extends Model {	
	
	public function viewtotal($data){

		$sql ="SELECT ct.*,cc.*,CONCAT(c.firstname, ' ', c.lastname) name FROM " . DB_PREFIX . "customerpartner_to_transaction ct LEFT JOIN " . DB_PREFIX . "customerpartner_to_customer cc ON (ct.customer_id = cc.customer_id) LEFT JOIN " . DB_PREFIX . "customer c ON (ct.customer_id = c.customer_id) WHERE c.customer_id = '".$this->customer->getId()."' ";	
		 			
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_details'])) {
			$sql .= " AND LCASE(ct.details) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_details'])) . "%'";
		}

		if (!empty($data['filter_date'])) {
			$sql .= " AND LCASE(ct.date_added) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_date'])) . "%'";
		}

		if (!empty($data['filter_id'])) {
			$sql .= " AND ct.id = '" . (float)$this->db->escape($data['filter_id']) . "'";
		}

		if (!empty($data['filter_amount'])) {
			$sql .= " AND ct.amount = '" . (float)$this->db->escape($data['filter_amount']) . "'";
		}
						
		$sort_data = array(
			'ct.id',
			'ct.details',
			'ct.amount',			
			'ct.date_added',	
			'c.firstname',			

		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY ct.id";	
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

		$result=$this->db->query($sql);

		return $result->rows;		
	}

	public function viewtotalentry($data){

		$sql ="SELECT ct.*,cc.*,CONCAT(c.firstname, ' ', c.lastname) name FROM " . DB_PREFIX . "customerpartner_to_transaction ct LEFT JOIN " . DB_PREFIX . "customerpartner_to_customer cc ON (ct.customer_id = cc.customer_id) LEFT JOIN " . DB_PREFIX . "customer c ON (ct.customer_id = c.customer_id) WHERE c.customer_id = '".$this->customer->getId()."'  ";	
		 			
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_id'])) {
			$sql .= " AND ct.id = '" . (float)$this->db->escape($data['filter_id']) . "'";
		}

		$result = $this->db->query($sql);	

		return count($result->rows);		
	}


	public function getPartnerAmount($partner_id){		
		$total = $this->db->query("SELECT SUM(c2o.quantity) quantity,SUM(c2o.price) total,SUM(c2o.admin) admin,SUM(c2o.customer) customer FROM ".DB_PREFIX ."customerpartner_to_order c2o WHERE c2o.customer_id ='".(int)$partner_id."'")->row;

		$paid = $this->db->query("SELECT SUM(c2t.amount) total FROM ".DB_PREFIX ."customerpartner_to_transaction c2t WHERE c2t.customer_id ='".(int)$partner_id."'")->row;
		
		$total['paid'] = $paid['total'];

		return($total);
	}


	public function getTransactions($customer_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}
		
		if ($limit < 1) {
			$limit = 10;
		}	
				
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_to_transaction WHERE customer_id = '" . (int)$customer_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
	
		return $query->rows;
	}

	public function getTotalTransactions($customer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total  FROM " . DB_PREFIX . "customerpartner_to_transaction WHERE customer_id = '" . (int)$customer_id . "'");
	
		return $query->row['total'];
	}
			
	public function getTransactionTotal($customer_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customerpartner_to_transaction WHERE customer_id = '" . (int)$customer_id . "'");
	
		return $query->row['total'];
	}

}
?>