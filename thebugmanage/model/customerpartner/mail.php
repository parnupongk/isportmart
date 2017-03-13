<?php
class ModelCustomerpartnerMail extends Model {	

	private $data;
	private $customer_applied_for_partnership_to_seller = 'customer_applied_for_partnership_to_seller';
	private $seller_product_approve = 'seller_product_approve';
	private $seller_transaction_add = 'seller_transaction_add';

	public function getMailData($id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_mail WHERE id='".(int)$id."'");		
		return $query->row;
	}

	public function deleteentry($id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_mail WHERE id='".(int)$id."'");		
	}

	public function gettotal(){

		$sql ="SELECT * FROM " . DB_PREFIX . "customerpartner_mail WHERE 1 ";	
		
		$result = $this->db->query($sql);

		return $result->rows;
	}

	public function viewtotal($data){

		$sql ="SELECT * FROM " . DB_PREFIX . "customerpartner_mail WHERE 1 ";	
		 			
		if (!empty($data['filter_id'])) {
			$sql .= " AND id = '" . (float)$this->db->escape($data['filter_id']) . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_subject'])) {
			$sql .= " AND LCASE(subject) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_subject'])) . "%'";
		}

		if (!empty($data['filter_message'])) {
			$sql .= " AND LCASE(message) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_message'])) . "%'";
		}
						
		$sort_data = array(
			'id',
			'name',
			'subject',			
			'message',	
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY id";	
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

		$sql ="SELECT * FROM " . DB_PREFIX . "customerpartner_mail WHERE 1 ";	
		 			
		if (!empty($data['filter_id'])) {
			$sql .= " AND id = '" . (float)$this->db->escape($data['filter_id']) . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_subject'])) {
			$sql .= " AND LCASE(subject) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_subject'])) . "%'";
		}

		if (!empty($data['filter_message'])) {
			$sql .= " AND LCASE(message) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_message'])) . "%'";
		}

		$result = $this->db->query($sql);	

		return count($result->rows);		
	}

	public function addMail($data) {

		if($data['mail_id'])
			$this->db->query("UPDATE " . DB_PREFIX . "customerpartner_mail SET name = '" . $this->db->escape($data['name']) . "', message = '" . $this->db->escape($data['message']) . "', subject = '" . $this->db->escape($data['subject']) . "' WHERE id='".(int)$data['mail_id']."'");
		else
			$this->db->query("INSERT INTO " . DB_PREFIX . "customerpartner_mail SET name = '" . $this->db->escape($data['name']) . "', message = '" . $this->db->escape($data['message']) . "', subject = '" . $this->db->escape($data['subject']) . "'");
		
	}

	public function mail($data, $mail_type = ''){

		$value_index = array();

		$this->load->model('customerpartner/partner');

		switch($mail_type){

			//customer applied for sellership to customer
			case $this->customer_applied_for_partnership_to_seller :
				$mail_id = $this->config->get('marketplace_mail_partner_approve');

				$seller_info = $data;
				$mail_from = $this->config->get('marketplace_adminmail');
				$mail_to = $data['email'];

				$value_index = array(
									'commission' => isset($data['commission'])?$data['commission']:$this->config->get('marketplace_commission'),									
									);
				break;

			//seller product approve
			case $this->seller_product_approve :
				$mail_id = $this->config->get('marketplace_mail_product_approve');

				$this->load->model('customerpartner/partner');				
				$seller_info = $this->model_customerpartner_partner->getPartnerCustomerInfo($data['customer_id']);
				$mail_from = $this->config->get('marketplace_adminmail');
				$mail_to = $seller_info['email'];

				$value_index = array(
									'commission' => $seller_info['commission'],	
									'product_name' => $data['name'],
									);
				break;

			//seller transaction add
			case $this->seller_transaction_add :
				$mail_id = $this->config->get('marketplace_mail_transaction');

				$this->load->model('customerpartner/partner');				
				$seller_info = $this->model_customerpartner_partner->getPartnerCustomerInfo($data['customer_id']);
				$mail_from = $this->config->get('marketplace_adminmail');
				$mail_to = $seller_info['email'];

				$value_index = array(
									'commission' => $seller_info['commission'],	
									'transaction_message' => $data['message'],
									'transaction_amount' => $data['amount'],
									);
				break;

			default :
				return;
		}

		$mail_details = $this->getMailData($mail_id);		

		if($mail_details){

			$this->data['store_name'] = $this->config->get('config_name');
			$this->data['store_url'] = HTTP_SERVER;
			$this->data['logo'] = HTTP_SERVER.'image/' . $this->config->get('config_logo');	

			$find = array(				
				'{order}',
				'{seller_message}',
				'{customer_message}',
				'{commission}',			
				'{product_name}',
				'{transaction_message}',
				'{transaction_amount}',
				'{seller_name}',
				'{config_logo}',
				'{config_icon}',
				'{config_currency}',
				'{config_image}',
				'{config_name}',
				'{config_owner}',
				'{config_address}',
				'{config_geocode}',
				'{config_email}',
				'{config_telephone}',
				);

			$replace = array(			
				'order' => '',
				'seller_message' => '',
				'customer_message' => '',
				'commission' => '',
				'product_name' => '',
				'transaction_message' => '',
				'transaction_amount' => '',
				'seller_name' => $seller_info['firstname'].' '.$seller_info['lastname'],
				'config_logo' => '<a href="'.HTTP_SERVER.'" title="'.$this->data['store_name'].'"><img src="'.HTTP_SERVER.'image/' . $this->config->get('config_logo').'" alt="'.$this->data['store_name'].'" /></a>',
				'config_icon' => '<img src="'.HTTP_SERVER.'image/' . $this->config->get('config_icon').'">',
				'config_currency' => $this->config->get('config_currency'),
				'config_image' => '<img src="'.HTTP_SERVER.'image/' . $this->config->get('config_image').'">',
				'config_name' => $this->config->get('config_name'),
				'config_owner' => $this->config->get('config_owner'),
				'config_address' => $this->config->get('config_address'),
				'config_geocode' => $this->config->get('config_geocode'),
				'config_email' => $this->config->get('config_email'),
				'config_telephone' => $this->config->get('config_telephone'),
			);

			$replace = array_merge($replace,$value_index);			

			$mail_details['message'] = trim(str_replace($find, $replace, $mail_details['message']));

			$this->data['subject'] = $mail_details['subject'];
			$this->data['message'] = $mail_details['message'];	

			$html = $this->load->view('customerpartner/mail.tpl', $this->data);	

			if (preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $mail_to) AND preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $mail_from) ) {

				
				if(VERSION == '2.0.0.0' || VERSION == '2.0.1.0' || VERSION == '2.0.1.1'  ) {
					/*Old mail code*/
					$mail = new Mail($this->config->get('config_mail'));
					$mail->setTo($mail_to);
					$mail->setFrom($mail_from);
					$mail->setSender($this->data['store_name']);
					$mail->setSubject($mail_details['subject']);
					$mail->setHtml($html);
					$mail->setText(strip_tags($html));
					$mail->send();
				} else {
					$mail = new Mail();
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
					$mail->smtp_username = $this->config->get('config_mail_smtp_username');
					$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port = $this->config->get('config_mail_smtp_port');
					$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
					$mail->setTo($mail_to);
					$mail->setFrom($mail_from);
					$mail->setSender($this->data['store_name']);
					$mail->setSubject($mail_details['subject']);
					$mail->setHtml($html);
					$mail->setText(strip_tags($html));
					$mail->send();
				}

			}

		}
	}

}
?>