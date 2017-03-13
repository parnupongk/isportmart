<?php
class ModelAffiliateOrder extends Model {
	public function getTransactions($data = array()) {
		$sql = "SELECT o.*,(
SELECT oa.firstname FROM " . DB_PREFIX . "affiliate oa 
WHERE oa.affiliate_id = o.affiliate_id ) AS affiliate,(
SELECT oad.download_id FROM " . DB_PREFIX . "affiliate_download oad 
WHERE oad.order_id = o.order_id ) AS download_id
,(
SELECT os.name FROM " . DB_PREFIX . "order_status os 
WHERE os.order_status_id = o.order_status_id 
AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status
  FROM " . DB_PREFIX . "order o WHERE  o.affiliate_id = '" . (int)$this->affiliate->getId() . "'";
//nid add 16/3/2016 10:21  fillter by status  
if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
		if($data['filter_status'] == 'Approve'){
			$sql .= " AND o.order_status_id in('15','2') ";
		}else if($data['filter_status'] == 'Transfer'){
			$sql .= " AND o.order_status_id in('16','19','20','22','23','25','26') ";
	  }	
}else{
		  $sql .= " AND o.order_status_id in('2','3','15','16','19','20','21','22','23','24','25','26','27','29') ";
		}	
//nid add 16/3/2016 10:21  fillter by status  
		$sort_data = array(
			//'date_modified',
			'order_id',
			//'affiliate_id',
			'affiliate',
			'download_id',
			'status',
			//'approved'			
			'invoice_no',
			'invoice_prefix',
			'store_id',
			'store_name',
			'store_url',
			'customer_id',
			'customer_group_id',
			'firstname',
			'lastname',
			'email',
			'telephone',
			'fax',
			'custom_field',
			'payment_firstname',
			'payment_lastname',
			'payment_company',
			'payment_address_1',
			'payment_address_2',
			'payment_city',
			'payment_postcode',
			'payment_country',
			'payment_country_id',
			'payment_zone',
			'payment_zone_id',
			'payment_address_format',
			'payment_custom_field',
			'payment_method',
			'payment_code',
			'shipping_firstname',
			'shipping_lastname',
			'shipping_company',
			'shipping_address_1',
			'shipping_address_2',
			'shipping_city',
			'shipping_postcode',
			'shipping_country',
			'shipping_country_id',
			'shipping_zone',
			'shipping_zone_id',
			'shipping_address_format',
			'shipping_custom_field',
			'shipping_method',
			'shipping_code',
			'comment',
			'total',
			'order_status_id',
			'affiliate_id',
			'commission',
			'marketing_id',
			'tracking',
			'language_id',
			'currency_id',
			'currency_code',
			'currency_value',
			'ip',
			'forwarded_ip',
			'user_agent',
			'accept_language',
			'date_added',
			'date_modified'
		
		);
	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date_added";
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
	public function getTotalTransactions() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id in('2','3','15','16','19','20','21','22','23','24','25','26','27','29') and affiliate_id = '" . (int)$this->affiliate->getId() . "'");

		return $query->row['total'];
	}
  public function getTotalTransferForBell() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id in('16','19','20','22','23','25','26','27') and affiliate_id = '" . (int)$this->affiliate->getId() . "'");

		return $query->row['total'];
	}
	public function getTotalApproveForBell() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id in('2','15') and affiliate_id = '" . (int)$this->affiliate->getId() . "'");

		return $query->row['total'];
	}
	public function getBalance() {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM `" . DB_PREFIX . "affiliate_transaction` WHERE affiliate_id = '" . (int)$this->affiliate->getId() . "' GROUP BY affiliate_id");

		if ($query->num_rows) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}
	public function getOrderStatuses($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "order_status WHERE  order_status_id in('20','21','22','23','24','25','26','27','29')  AND language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sql .= " ORDER BY order_status_id";

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
		} else {
			$order_status_data = $this->cache->get('order.' . (int)$this->config->get('config_language_id'));
			//delete cache alter add new lisbox
			//$order_status_datadelete = $this->cache->delete('order.' . (int)$this->config->get('config_language_id'));

			if (!$order_status_data) {
				$query = $this->db->query("SELECT order_status_id, name FROM " . DB_PREFIX . "order_status WHERE order_status_id in('20','21','22','23','24','25','26','27','29')  AND language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY order_status_id");

				$order_status_data = $query->rows;
				$this->cache->set('order.' . (int)$this->config->get('config_language_id'), $order_status_data);
			}

			return $order_status_data;
		}
	}
	public function getAffiliate($affiliate_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "affiliate WHERE affiliate_id = '" . (int)$affiliate_id . "'");

		return $query->row;
	}
	public function getOrderAffiliate($affiliate_id,$order_id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "order  WHERE order_id = ' " . (int)$order_id . " ' "." and affiliate_id = ' " . (int)$affiliate_id." ' " );
		return $query->row;
	}
	public function getCustomerHistory($customer_id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "order_history ");
		return $query->row;
		// WHERE customer_id = ' " . (int)$customer_id . " ' "
	}
	public function getOrderHistory($order_id, $start = 0, $limit = 5) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 5;
		}
		
		$query = $this->db->query("SELECT oh.order_id,oh.order_status_id,oh.date_added, os.name AS status, oh.comment, oh.notify,oh.affiliate_id FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND oh.order_status_id in('2','3','7','10','28','14','15','16','19','20','21','22','23','24','25','26','27','29') AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added DESC  LIMIT " . (int)$start . "," . (int)$limit);
		return $query->rows;
	}
	public function getTotalOrderHistories($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_status_id in('2','3','15','16','19','20','21','22','23','24','25','26','27','29')  AND order_id = '" . (int)$order_id . "'");
		return $query->row['total'];
	}
	public function getOldstatus($order_status_post,$order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_status_id ='".(int)$order_status_post."'  AND order_id = '" . (int)$order_id . "'");
		return $query->row['total'];
	}
	public function addDownload($data) {	
		//------ delete file
		$query_file = $this->db->query("SELECT DISTINCT name FROM " . DB_PREFIX . "affiliate_download d  WHERE d.order_id = '".$this->db->escape($data['order_id_upload'])."'");
		if ($query_file->num_rows) {
			$file_unlink =  $query_file->row['name'];
		} 
		@unlink(DIR_DOWNLOAD.$file_unlink);
		//------ delete file
		//------ rename file
		if (file_exists(DIR_DOWNLOAD.$this->db->escape($data['filename']))) {
		rename(DIR_DOWNLOAD.$this->db->escape($data['filename']),DIR_DOWNLOAD."F".trim($this->db->escape($data['order_id_upload']))."_".trim($this->db->escape($data['mask'])));
		}
		$filemame_upload = "F".trim($this->db->escape($data['order_id_upload']))."_".trim($this->db->escape($data['mask']));
		//------ rename file
		$this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_download WHERE order_id = '" .$this->db->escape($data['order_id_upload']). "'");			
		$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate_download SET name = '" .$filemame_upload. "', mask = '" . $this->db->escape($data['mask']). "', affiliate_id = '" . $this->db->escape($data['affiliate_id_form']) . "', order_id = '" . $this->db->escape($data['order_id_upload']) . "', date_added = NOW()");
		$download_id = $this->db->getLastId();
		return $download_id;
	}
	public function getDownload($order_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "affiliate_download d  WHERE d.order_id = '".(int)$order_id."'");
		return $query->rows;
	}
	public function addCustomerDownload($order_id_upload,$affiliate_id_form,$filemame,$mask) {	
		//------ delete file
		$query_file = $this->db->query("SELECT DISTINCT name FROM " . DB_PREFIX . "customer_download d  WHERE d.order_id = '".$order_id_upload."'");//$this->db->escape($data['order_id_upload'])."'");
		if ($query_file->num_rows) {
			$file_unlink =  $query_file->row['name'];
		} 
		@unlink(DIR_DOWNLOAD.$file_unlink);
		//------ delete file
		//------ rename file
		if (file_exists(DIR_DOWNLOAD.$filemame)) {
		rename(DIR_DOWNLOAD.$filemame,DIR_DOWNLOAD."C".trim($order_id_upload)."_".trim($mask));
		}
		$filemame_upload = "C".trim($order_id_upload)."_".trim($mask);
		//------ rename file
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_download WHERE order_id = '" .$order_id_upload. "'");			
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_download SET name = '" .$filemame_upload. "', mask = '" . $mask. "', affiliate_id = '" . $affiliate_id_form. "', order_id = '" . $order_id_upload . "', date_added = NOW()");
		$download_id = $this->db->getLastId();
		return $download_id;
	}
	public function getCustomerDownload($order_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_download d  WHERE d.order_id = '".(int)$order_id."'");
		return $query->rows;
	}
	public function addAffDownload($order_id_upload,$affiliate_id_form,$filemame,$mask) {	
		//------ delete file
		$query_file = $this->db->query("SELECT DISTINCT name FROM " . DB_PREFIX . "affiliate_download d  WHERE d.order_id = '".$order_id_upload."'");//$this->db->escape($data['order_id_upload'])."'");
		if ($query_file->num_rows) {
			$file_unlink =  $query_file->row['name'];
		} 
		@unlink(DIR_DOWNLOAD.$file_unlink);
		//------ delete file
		//------ rename file
		if (file_exists(DIR_DOWNLOAD.$filemame)) {
		rename(DIR_DOWNLOAD.$filemame,DIR_DOWNLOAD."F".trim($order_id_upload)."_".trim($mask));
		}
		$filemame_upload = "F".trim($order_id_upload)."_".trim($mask);
		//------ rename file
		$this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_download WHERE order_id = '" .$order_id_upload. "'");			
		$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate_download SET name = '" .$filemame_upload. "', mask = '" . $mask. "', affiliate_id = '" . $affiliate_id_form. "', order_id = '" . $order_id_upload . "', date_added = NOW()");
		$download_id = $this->db->getLastId();
		return $download_id;
	}
	public function getCustomerByOrder($order_id){
		$query = $this->db->query("SELECT DISTINCT customer_id FROM " . DB_PREFIX . "order d  WHERE d.order_id = '".(int)$order_id."'");
		return $query->rows;
		}
}