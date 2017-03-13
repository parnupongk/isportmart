<?php
class ModelShippingwkcustomshipping extends Model {

	function getQuote($address,$seller = array()) {

		//to stop it's default functionality
		if($this->config->get('wk_multi_shipping_status') AND !$seller){
			return false;	
		}

		$method_data = $result_csv = array();
		$error = false;	

		$this->language->load('shipping/wk_custom_shipping');
			
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('wk_custom_shipping_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
	
		if (!$this->config->get('wk_custom_shipping_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$shipping_postcode = $address;
		
		if(isset($shipping_postcode['postcode'])){
			$zipcod = $shipping_postcode['postcode'];
		}else{
			$zipcod = 0;
		}

		if(!$this->config->get('wk_multi_shipping_status') AND !$seller){
			$this->load->model('account/customerpartnerorder');
			$seller = $this->model_account_customerpartnerorder->sellerAdminData($this->cart->getProducts());
		}

		$total = $totalfortext = 0;		
		$addSeller = '';
		
		if($this->config->get('wk_custom_shipping_method')=='flat'){
			foreach($seller as $pro_det){

				$seller_name = $this->db->query("SELECT CONCAT(firstname ,' ',lastname) seller_name FROM " . DB_PREFIX . "customer WHERE customer_id = '".$pro_det['seller']."'")->row;

				if($this->config->get('wk_multi_shipping_status')){
					$addSeller = $pro_det['seller'].'_';
				}

				$res_error = false;
				
				if($pro_det['seller']=='Admin'){
					$result_csv[] = array('shipping_price' => $this->config->get('wk_custom_shipping_admin_flatrate'));
				}else{
					$csv_id = $pro_det['seller'];
					$res_csv = $this->db->query("SELECT amount as shipping_price,tax_class_id FROM " . DB_PREFIX . "customerpartner_flatshipping WHERE partner_id = '$csv_id'" );
					if(isset($res_csv->row['shipping_price'])){
						$result_csv[] = $res_csv->row;
					}else{			
						$res_error = true;
					}
				}

				if($res_error){
					$error = '';
					if($this->config->get('wk_custom_shipping_error_msg')!=''){
						$error = $error. $this->config->get('wk_custom_shipping_error_msg');	
					}
					else{
						$error = $error. 'For Shipping method "'.$this->config->get('wk_custom_shipping_title').'" : '. $seller_name['seller_name']." Vendor does not provide services for zip : ".$zipcod.', so this method is not selectable.';
					}
				}

			}
			
		}

		if($this->config->get('wk_custom_shipping_method')=='matrix'){
			foreach($seller as $pro_det){

				$seller_name = $this->db->query("SELECT CONCAT(firstname ,' ',lastname) seller_name FROM " . DB_PREFIX . "customer WHERE customer_id = '".$pro_det['seller']."'")->row;

				if($this->config->get('wk_multi_shipping_status')){
					$addSeller = $pro_det['seller'].'_';
				}

				$csv_id = $pro_det['seller'];
				$pro_weight = $pro_det['weight'];	

				$res_csv = $this->db->query("SELECT price as shipping_price FROM " . DB_PREFIX . "customerpartner_shipping WHERE seller_id = '".(int)$csv_id."' AND weight_to >= '".(float)$pro_weight."' AND  weight_from <= '".(float)$pro_weight."' AND country_code = '".$this->db->escape($shipping_postcode['iso_code_2'])."' AND ( (convert(zip_to,unsigned) >= '".(int)$zipcod."' AND convert(zip_from,unsigned) <= '".(int)$zipcod."') or (zip_to LIKE '%".$zipcod."' OR zip_from LIKE '%".$zipcod."'))");
				$result_csv[] = $res_csv->row;

				if(!isset($res_csv->row['shipping_price']) AND $csv_id == 'Admin'){
					$result_csv[] = array('shipping_price' => $this->config->get('wk_custom_shipping_admin_flatrate'));
				}else{
					$res_error = true;
					if(!isset($res_csv->row['shipping_price']))
						$res_error = false;
					
					// $res_error = $this->db->query("SELECT price as shipping_price FROM " . DB_PREFIX . "customerpartner_shipping WHERE seller_id = '".(int)$csv_id."' AND ( (convert(zip_to,unsigned) <= '".(int)$zipcod."' AND convert(zip_from,unsigned) >= '".(int)$zipcod."') or (zip_to LIKE '%".$zipcod."' OR zip_from LIKE '%".$zipcod."'))")->row;
					
					//if zip not exists in seller data then error generate else price with add that will be + or zero if not within weights

					if(!$res_error){
						$error = '';
						if($this->config->get('wk_custom_shipping_error_msg')!=''){
							$error = $error.$this->config->get('wk_custom_shipping_error_msg');	
						}
						else{
							$error = $error.'For Shipping method "'.$this->config->get('wk_custom_shipping_title').'" : '. $seller_name['seller_name']." Vendor does not provide services for zip : ".$zipcod.', so this method is not selectable.';
						}
					}
				}
			}
			
		}

		if($this->config->get('wk_custom_shipping_method')=='both'){
			foreach($seller as $pro_det){

				$seller_name = $this->db->query("SELECT CONCAT(firstname ,' ',lastname) seller_name FROM " . DB_PREFIX . "customer WHERE customer_id = '".$pro_det['seller']."'")->row;

				if($this->config->get('wk_multi_shipping_status')){
					$addSeller = $pro_det['seller'].'_';
				}

				$res_error = false;
				$csv_id = $pro_det['seller'];
				$pro_weight = $pro_det['weight'];

				$res_csv = $this->db->query("SELECT price as shipping_price FROM " . DB_PREFIX . "customerpartner_shipping WHERE seller_id = '".(int)$csv_id."' AND weight_to <= '".(float)$pro_weight."' AND  weight_from >= '".(float)$pro_weight."' AND country_code = '".$this->db->escape($shipping_postcode['iso_code_2'])."' AND ( (convert(zip_to,unsigned) <= '".(int)$zipcod."' AND convert(zip_from,unsigned) >= '".(int)$zipcod."') or (zip_to LIKE '%".$zipcod."' OR zip_from LIKE '%".$zipcod."'))");

				if(isset($res_csv->row['shipping_price'])){
					$result_csv[] = $res_csv->row;
				}else{
					if($pro_det['seller']=='Admin'){
						$result_csv[] = array('shipping_price' => $this->config->get('wk_custom_shipping_admin_flatrate'));
					}else{
						$res_csv = $this->db->query("SELECT amount as shipping_price,tax_class_id FROM " . DB_PREFIX . "customerpartner_flatshipping WHERE partner_id = '".$csv_id."'" );
						if(isset($res_csv->row['shipping_price'])){
							$result_csv[] = $res_csv->row;
						}else{			
							$res_error = true;
						}
					}
				}
							
				//if price is not avilable in both table matrix and flat then error generate
				if($res_error){
					$error = '';
					if($this->config->get('wk_custom_shipping_error_msg')!=''){
						$error =  $error.$this->config->get('wk_custom_shipping_error_msg');	
					}
					else{
						$error =  $error. 'For Shipping method "'.$this->config->get('wk_custom_shipping_title').'" : '. $seller_name['seller_name']." Vendor does not provide services for zip : ".$zipcod.', so this method is not selectable.';
					}
				}

			}
			
		}

		if($result_csv)			
			foreach($result_csv as $res_res){
				if(isset($res_res['shipping_price'])){
					$total 	 =  $total + $res_res['shipping_price'];					
					$totalfortext += $this->tax->calculate($res_res['shipping_price'], $this->config->get('wk_custom_shipping_tax_class_id'), $this->config->get('config_tax'));
				}
			}


		if ($status) {
			$quote_data = array();
			//small bug fixed to display prices correctly can display amount difference but persons will get correct price..
			$total += $totalfortext - $this->tax->calculate($total, $this->config->get('wk_custom_shipping_tax_class_id'), $this->config->get('config_tax'));
      		$quote_data['wk_custom_shipping'] = array(
        		'code'         => $addSeller.'wk_custom_shipping.wk_custom_shipping',
        		'title'        => $this->config->get('wk_custom_shipping_title'),
        		'cost'         => $total,
        		'tax_class_id' => $this->config->get('wk_custom_shipping_tax_class_id'),
				'text'         => $this->currency->format($totalfortext)
      		);

      		$method_data = array(
        		'code'       => $addSeller.'wk_custom_shipping',
        		'title'      => $this->config->get('wk_custom_shipping_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('wk_custom_shipping_sort_order'),
        		'error'      => $error,
        		
      		);
		}
		
		return $method_data;
	}
}
?>