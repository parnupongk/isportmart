<?php
class ModelCustomerpartnerMail extends Model {	

	private $data;

	private $customer_applied_for_partnership_to_seller = 'customer_applied_for_partnership_to_seller';
	private $customer_applied_for_partnership_to_admin = 'customer_applied_for_partnership_to_admin';
	private $seller_added_product_to_seller = 'seller_added_product_to_seller';
	private $seller_added_product_to_admin = 'seller_added_product_to_admin';
	private $seller_contact_admin = 'seller_contact_admin';
	private $customer_contact_seller_to_seller = 'customer_contact_seller_to_seller';
	private $customer_contact_seller_to_admin = 'customer_contact_seller_to_admin';
	private $order_mail_to_seller = 'order_mail_to_seller';

	public function getMailData($id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_mail WHERE id='".(int)$id."'");		
		return $query->row;
	}

	public function getCustomer($id){
		return $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '".(int)$id."'")->row;	
	}

	public function getSeller($id){
		return $this->db->query("SELECT * FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customerpartner_to_customer c2c ON (c.customer_id = c2c.customer_id) WHERE c.customer_id = '".(int)$id."'")->row;		
	}

	public function mail($data, $values) {

		$value_index = array();

		$mail_id = $data['mail_id'];
		$mail_from = $data['mail_from'];
		$mail_to = $data['mail_to'];

		if(isset($data['seller_id']) AND $data['seller_id']){
			$seller_info = $this->getSeller($data['seller_id']);
		} else {
			$seller_info['firstname'] = '';
			$seller_info['lastname'] = '';
		}
		
		if(isset($data['customer_id']) AND $data['customer_id']){
			$customer_info = $this->getCustomer($data['customer_id']);
		}
		
		$value_index = $values;

		$mail_details = $this->getMailData($mail_id);
		if($mail_details){

			$this->data['store_name'] = $this->config->get('config_name');
			$this->data['store_url'] = HTTP_SERVER;
			$this->data['logo'] = HTTP_SERVER.'image/' . $this->config->get('config_logo');
			
			$mailValues = str_replace('<br />', ',', nl2br($this->config->get('marketplace_mail_keywords')));
			$mailValues = explode(',', $mailValues);
			$find = array();
			$replace = array();
			foreach ($mailValues as $key => $value) {
				$value = str_replace('{','',$value);
				$value = str_replace('}','',$value);
				$find[trim($value)] = '{'.trim($value).'}';
				$replace[trim($value)] = '';
			}

			$replace['seller_name'] = $seller_info['firstname'].' '.$seller_info['lastname'];
			$replace['config_logo'] = '<a href="'.HTTP_SERVER.'" title="'.$this->data['store_name'].'"><img src="'.HTTP_SERVER.'image/' . $this->config->get('config_logo').'" alt="'.$this->data['store_name'].'" /></a>';
			$replace['config_icon'] = '<img src="'.HTTP_SERVER.'image/' . $this->config->get('config_icon').'">';
			$replace['config_currency'] = $this->config->get('config_currency');
			$replace['config_image'] = '<img src="'.HTTP_SERVER.'image/' . $this->config->get('config_image').'">';
			$replace['config_name'] = $this->config->get('config_name');
			$replace['config_owner'] = $this->config->get('config_owner');
			$replace['config_address'] = $this->config->get('config_address');
			$replace['config_geocode'] = $this->config->get('config_geocode');
			$replace['config_email'] = $this->config->get('config_email');
			$replace['config_telephone'] = $this->config->get('config_telephone');

			$replace = array_merge($replace,$value_index);
			ksort($find);
			ksort($replace);

			$mail_details['message'] = trim(str_replace($find, $replace, $mail_details['message']));

			$this->data['subject'] = $mail_details['subject'];
			$this->data['message'] = $mail_details['message'];
			
			$html = $this->load->view('default/template/customerpartner/mail.tpl', $this->data);
			
			if (preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $mail_to) AND preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $mail_from) ) {
				
				if(version_compare(VERSION, '2.0.1.1', '<=')) {
					/*Old mail code*/
					$mail = new Mail($this->config->get('config_mail'));
					$mail->setTo($mail_to);
					$mail->setFrom($mail_from);
					$mail->setSender($this->data['store_name']);
					$mail->setSubject($mail_details['subject']);
					$mail->setHtml($html);
					$mail->setText(strip_tags($html));

					// if ($this->config->get('marketplace_pdf_order_invoice')) {

					// 	$pdfFilename = DIR_CACHE .'invoice#'.token(5).'.pdf';
					// 	require_once(DIR_SYSTEM . 'library/mp_pdf/mpdf.php');
					// 	set_error_handler('var_dump', 0);
					// 	$mpdf = new mPDF();
					// 	$mpdf->WriteHTML($values['order']);
					// 	$mpdf->Output($pdfFilename, 'F');
					// 	$mail->addAttachment($pdfFilename);
					// 	restore_error_handler();
					// }

					$status = $mail->send();
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

					// if ($this->config->get('marketplace_pdf_order_invoice')) {

					// 	$pdfFilename = DIR_CACHE .'invoice#'.token(5).'.pdf';
					// 	require_once(DIR_SYSTEM . 'library/mp_pdf/mpdf.php');
					// 	set_error_handler('var_dump', 0);
					// 	$mpdf = new mPDF();
					// 	$mpdf->WriteHTML($values['order']);
					// 	$mpdf->Output($pdfFilename, 'F');
					// 	$mail->addAttachment($pdfFilename);
					// 	restore_error_handler();
					// }
					
					$mail->send();
				}
			}

		}
	}

}
?>