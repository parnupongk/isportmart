<?php
class ModelAccountActivity extends Model {
	public function addActivity($key, $data) {
		if (isset($data['customer_id'])) {
			$customer_id = $data['customer_id'];
		} else {
			$customer_id = 0;
		}

		// one add @ 1-6-2016
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {			 
		    $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}

		//$this->db->query("INSERT INTO `" . DB_PREFIX . "customer_activity` SET `customer_id` = '" . (int)$customer_id . "', `key` = '" . $this->db->escape($key) . "', `data` = '" . $this->db->escape(serialize($data)) . "', `ip` = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', `date_added` = NOW()");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "customer_activity` SET `customer_id` = '" . (int)$customer_id . "', `key` = '" . $this->db->escape($key) . "', `data` = '" . $this->db->escape(serialize($data)) . "', `ip` = '" . $this->db->escape($ipAddress) . "', `date_added` = NOW()");
	}
	
	public function logActivity($desc, $act, $data) {
		if (isset($data['customer_id'])) {
			$customer_id = $data['customer_id'];
		} else {
			$customer_id = 0;
		}
		
		if (isset($data['data'])) {
			$log_data = $data['data'];
		} else {
			$log_data = 0;
		}
		
		if (isset($this->session->data['cust_ani'])) {
			$customer_ani = $this->session->data['cust_ani'];
		} else {
			$customer_ani = 0;
		}
		
		if (isset($this->session->data['agent_id'])) {
			$agent_id = $this->session->data['agent_id'];
		} else {
			$agent_id = 0;
		}		
		
		// one add @ 1-6-2016
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {			 
		    $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}

		//$this->db->query("INSERT INTO `" . DB_PREFIX . "customer_logevent` SET `customer_id` = '" . (int)$customer_id . "', `agent_id` = '" . (int)$agent_id . "',`customer_ani` = '" . $customer_ani . "', `log_action` = '" . $this->db->escape($act) . "', `log_desc` = '" . $this->db->escape($desc) . "', `log_data` = '" . $log_data . "', `ip` = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', `date_added` = NOW()");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "customer_logevent` SET `customer_id` = '" . (int)$customer_id . "', `agent_id` = '" . (int)$agent_id . "',`customer_ani` = '" . $customer_ani . "', `log_action` = '" . $this->db->escape($act) . "', `log_desc` = '" . $this->db->escape($desc) . "', `log_data` = '" . $log_data . "', `ip` = '" . $this->db->escape($ipAddress) . "', `date_added` = NOW()");
	}
	/* 
	login by agent
	add product
	edit product
	remove product
	checkout
	checkout payment address
	checkout shipping address
	checkout shipping method
	checkout payment method
	checkout success
	*/
}