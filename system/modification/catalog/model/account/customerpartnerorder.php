<?php
class ModelAccountCustomerpartnerOrder extends Model {
    
    /**
     * [customerpartner uses to entry marketplace order related datas at the time of check out and also to send order mail to respective order product seller. It is called from the Opencart default addOrderHistory function]
     * @param  [type] $order_info   [Order details]
     * @param  [type] $order_status [order status which is set at the time checkout]
     * @param  string $comment      [comment which customer want to comment at the of check out]
     * @return [type]               [none]
     */
	public function customerpartner($order_info,$order_status, $comment = ''){

		$order_id = $order_info['order_id'];

		// Shipping Address
		$this->load->model('shipping/wk_custom_shipping');


	    $shipping_address = array(
			'country_id' => $order_info['shipping_country_id'],
			'zone_id'    => $order_info['shipping_zone_id'],
			'postcode'   => $order_info['shipping_postcode'],
			'iso_code_2' => $order_info['shipping_iso_code_2']
		);

		$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

		$mailToSellers = array()  ;
		
		$shipping = 0;
		$paid_shipping = false;
		$admin_shipping_method = false;
		$resultData = $this->sellerAdminData($this->cart->getProducts());

		if($this->config->get('marketplace_allowed_shipping_method')) {
			if(in_array($order_info['shipping_code'],$this->config->get('marketplace_allowed_shipping_method'))) {
				$admin_shipping_method = true;
				$sellers_count = count($resultData);
				foreach ($resultData as $key => $value) {
					if($value['seller'] == 'admin') {
						$sellers_count = count($resultData) - 1;
					}
				}
				if($sellers_count == 1) {
					$shipping = $this->session->data['shipping_method']['cost'];
				}
			}
		}


		foreach ($order_product_query->rows as $product) {		

			$prsql = '';

			$mpSellers = $this->db->query("SELECT c.email,c.customer_id,p.product_id,p.subtract,c2c.commission FROM ".DB_PREFIX."product p LEFT JOIN ".DB_PREFIX."customerpartner_to_product c2p ON (p.product_id = c2p.product_id) LEFT JOIN ".DB_PREFIX."customer c ON (c2p.customer_id = c.customer_id) LEFT JOIN ".DB_PREFIX."customerpartner_to_customer c2c ON (c2c.customer_id = c2p.customer_id) WHERE p.product_id = '".$product['product_id']."' $prsql ORDER BY c2p.id ASC ")->row;

			if(isset($mpSellers['email']) AND !empty($mpSellers['email'])){

				$option_data = array();

				$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

				foreach ($order_option_query->rows as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				/**
                 * IF admin set that commission will be calculated on the tax then the product total price with the tax 
                 */
				if ($this->config->get('marketplace_commission_tax')) {
					$product_total = $product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0);

        if ($this->config->get('wkproduct_auction_status')) {

                    $order_coupon = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '".$order_id."'");

                  foreach ($order_coupon->rows as $value) {
                      
                      if ($value['code'] == 'coupon') {
                        
                          $coupon_code= $value['title'];
                      }
                  }

                    $trim_coupon = ltrim($coupon_code,"Coupon");

                    $final_trim = ltrim($trim_coupon);

                    $aa=ltrim($final_trim,"(");
                    $coupon=rtrim($aa,")");

                    $this->load->model('checkout/coupon');
                    $coupon_info = $this->getCouponDetail($coupon,$order_id);
                          
                }else{

                  $coupon_info='';
                }
                        
         
                if ($coupon_info) {

                    $data['auction_module_status'] = $this->config->get('wkproduct_auction_status');
                      
                    foreach ($coupon_info['product'] as $value) {
                              
                        if ($value == $product['product_id']) {
                                
                            $product_total = $product_total - $coupon_info['discount'];
                        }
                    } 
                }
                        
                        
				}else{
					$product_total = $product['total'];

				}


                           if ($coupon_info) {
                  
                      foreach ($coupon_info['product'] as $value) {
                
                          if ($value==$product['product_id']) {
                            
                            $products = array(
                              'product_id' => $product['product_id'],
                              'name'     => $product['name'],
                              'model'    => $product['model'],
                              'option'   => $option_data,
                              'quantity' => $product['quantity'],
                              'product_total' => $product_total,  // without symbol       
                              'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                              'sub_total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
                              'coupon_price' => $this->currency->format('-'.$coupon_info['discount'], $order_info['currency_code']),
                              'total' => $this->currency->format($product_total, $order_info['currency_code']),
                            );
                          }else{
                                           
                            $products = array(
                              'product_id' => $product['product_id'],
                              'name'     => $product['name'],
                              'model'    => $product['model'],
                              'option'   => $option_data,
                              'quantity' => $product['quantity'],
                              'product_total' => $product_total,  // without symbol       
                              'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                              'sub_total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
                              'coupon_price' => $this->currency->format('-0', $order_info['currency_code']),
                              'total' => $this->currency->format($product_total, $order_info['currency_code']),

                            );

                          }
                        } 
                 } else {

                    if ($this->config->get('wkproduct_auction_status')) {
                    
                     $products = array(
                            'product_id' => $product['product_id'],
                            'name'     => $product['name'],
                            'model'    => $product['model'],
                            'option'   => $option_data,
                            'quantity' => $product['quantity'],
                            'product_total' => $product_total,  // without symbol       
                            'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                            'sub_total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
                            'coupon_price' => $this->currency->format('-0', $order_info['currency_code']),
                            'total' => $this->currency->format($product_total, $order_info['currency_code']),

                          );
                  }else{

                        
				$products = array(
					'product_id' => $product['product_id'],
					'name'     => $product['name'],
					'model'    => $product['model'],
					'option'   => $option_data,
					'quantity' => $product['quantity'],
					'product_total' => $product_total,	// without symbol				
					'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
				);

                         }
                        

				$i = 0;

				if($mpSellers['subtract'])
					$this->db->query("UPDATE " . DB_PREFIX . "customerpartner_to_product SET quantity = quantity-'".(int)$product['quantity']."' WHERE product_id = '".(int)$mpSellers['product_id']."' AND customer_id = '".(int)$mpSellers['customer_id']."'");
                
                /**
                 * updated code to use to send low stock quantity mail to respective seller if rest product quantity below or equal to the marketplace low stock quantity]
                 */
				$product_current_quantity = $this->db->query("SELECT quantity FROM " . DB_PREFIX . "product WHERE product_id = '".(int)$mpSellers['product_id']."'")->row;

	            if ($this->config->get('marketplace_low_stock_notification') && $this->config->get('marketplace_low_stock_quantity') && $product_current_quantity['quantity'] <= $this->config->get('marketplace_low_stock_quantity')) {
	            	
	            	$this->load->model('customerpartner/mail');

	            	$mailData = array(
						'seller_id' => $mpSellers['customer_id'],
			        	'customer_id' => false,
			        	'mail_id' => $this->config->get('marketplace_mail_seller_low_stock'),
			        	'mail_from' => $this->config->get('marketplace_adminmail'),
			        	'mail_to' => $mpSellers['email'],
					);

					$values = array(
			        	'product_name' => $product['name'],
			        	'product_quantity' => $product_current_quantity['quantity'],
			        );

					$this->model_customerpartner_mail->mail($mailData,$values);
	            }

	            // update marketplace code ends here

				//add commission entry
				$commission_array = $this->calculateCommission($products,$mpSellers['customer_id']);

                $shipping_applied = '';

				if($order_info['shipping_code'] != 'wk_custom_shipping.wk_custom_shipping' && $admin_shipping_method) {
					if(!$paid_shipping) {
						$commission_array['customer'] = $commission_array['customer'] + $shipping;
						$paid_shipping = true;

						$shipping_applied = $shipping;
					}
				} else if($admin_shipping_method) {
					$sellerDetails = array();

					$sellerDetails[$mpSellers['customer_id']] = $resultData[$mpSellers['customer_id']];

					$shipping_quote = $this->model_shipping_wk_custom_shipping->getQuote($shipping_address, $sellerDetails);
				}
				
				if(isset($shipping_quote['quote']['wk_custom_shipping']['cost']) && $shipping_quote['quote']['wk_custom_shipping']['cost']) {
					$commission_array['customer'] = $commission_array['customer'] + $shipping_quote['quote']['wk_custom_shipping']['cost'];

					$shipping_applied = $shipping_quote['quote']['wk_custom_shipping']['cost'];
				}




        if ($coupon_info) {
                  
                    foreach ($coupon_info['product'] as $value) {
                    
                        if ($value == $product['product_id']) {

                             $this->db->query("INSERT INTO ".DB_PREFIX."customerpartner_to_order SET `order_id` = '".(int)$order_id."',`customer_id` = '".(int)$mpSellers['customer_id']."',`product_id` = '".(int)$product['product_id']."',`order_product_id` = '".(int)$product['order_product_id']."',`price` = '".(float)$product_total."',`quantity` = '".(int)$product['quantity']."',`shipping` = '".$this->db->escape($order_info['shipping_method'])."',`payment` = '".$this->db->escape($order_info['payment_method'])."',`details` = '".$this->db->escape($commission_array['type'])."',`customer` = '".$commission_array['customer']."',`admin` = '".$commission_array['commission']."',currency_code = '".$this->db->escape($order_info['currency_code'])."',currency_value = '".$this->db->escape($order_info['currency_value'])."',commission_applied = '".$this->db->escape($mpSellers['commission'])."',shipping_applied = '".$this->db->escape($shipping_applied)."',`date_added` = NOW(),order_product_status = '".$this->config->get('config_order_status_id')."',`coupon_price` = '".$coupon_info['discount']."'");
                         }else{

                             $this->db->query("INSERT INTO ".DB_PREFIX."customerpartner_to_order SET `order_id` = '".(int)$order_id."',`customer_id` = '".(int)$mpSellers['customer_id']."',`product_id` = '".(int)$product['product_id']."',`order_product_id` = '".(int)$product['order_product_id']."',`price` = '".(float)$product_total."',`quantity` = '".(int)$product['quantity']."',`shipping` = '".$this->db->escape($order_info['shipping_method'])."',`payment` = '".$this->db->escape($order_info['payment_method'])."',`details` = '".$this->db->escape($commission_array['type'])."',`customer` = '".$commission_array['customer']."',`admin` = '".$commission_array['commission']."',currency_code = '".$this->db->escape($order_info['currency_code'])."',currency_value = '".$this->db->escape($order_info['currency_value'])."',commission_applied = '".$this->db->escape($mpSellers['commission'])."',shipping_applied = '".$this->db->escape($shipping_applied)."',`date_added` = NOW(),order_product_status = '".$this->config->get('config_order_status_id')."' ");

                          }
                        
                        }
                    }
                }else{
                        
				$check_order_exists = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_to_order WHERE order_id = '" . (int)$order_id . "' AND product_id = '" . (int)$product['product_id'] . "' AND customer_id = '". (int)$mpSellers['customer_id'] ."' AND option_data = '".json_encode($option_data)."'")->row;

				if ($check_order_exists) {


        if ($coupon_info) {
                  
                    foreach ($coupon_info['product'] as $value) {
                    
                        if ($value == $product['product_id']) {

                             $this->db->query("INSERT INTO ".DB_PREFIX."customerpartner_to_order SET `order_id` = '".(int)$order_id."',`customer_id` = '".(int)$mpSellers['customer_id']."',`product_id` = '".(int)$product['product_id']."',`order_product_id` = '".(int)$product['order_product_id']."',`price` = '".(float)$product_total."',`quantity` = '".(int)$product['quantity']."',`shipping` = '".$this->db->escape($order_info['shipping_method'])."',`payment` = '".$this->db->escape($order_info['payment_method'])."',`details` = '".$this->db->escape($commission_array['type'])."',`customer` = '".$commission_array['customer']."',`admin` = '".$commission_array['commission']."',currency_code = '".$this->db->escape($order_info['currency_code'])."',currency_value = '".$this->db->escape($order_info['currency_value'])."',commission_applied = '".$this->db->escape($mpSellers['commission'])."',shipping_applied = '".$this->db->escape($shipping_applied)."',`date_added` = NOW(),order_product_status = '".$this->config->get('config_order_status_id')."',`coupon_price` = '".$coupon_info['discount']."'");
                         }else{

                             $this->db->query("INSERT INTO ".DB_PREFIX."customerpartner_to_order SET `order_id` = '".(int)$order_id."',`customer_id` = '".(int)$mpSellers['customer_id']."',`product_id` = '".(int)$product['product_id']."',`order_product_id` = '".(int)$product['order_product_id']."',`price` = '".(float)$product_total."',`quantity` = '".(int)$product['quantity']."',`shipping` = '".$this->db->escape($order_info['shipping_method'])."',`payment` = '".$this->db->escape($order_info['payment_method'])."',`details` = '".$this->db->escape($commission_array['type'])."',`customer` = '".$commission_array['customer']."',`admin` = '".$commission_array['commission']."',currency_code = '".$this->db->escape($order_info['currency_code'])."',currency_value = '".$this->db->escape($order_info['currency_value'])."',commission_applied = '".$this->db->escape($mpSellers['commission'])."',shipping_applied = '".$this->db->escape($shipping_applied)."',`date_added` = NOW(),order_product_status = '".$this->config->get('config_order_status_id')."' ");

                          }
                        
                        }
                    }
                }else{
                        
					$this->db->query("UPDATE ".DB_PREFIX."customerpartner_to_order SET `order_product_id` = '".(int)$product['order_product_id']."',`price` = '".(float)$product_total."',`quantity` = '".(int)$product['quantity']."',`shipping` = '".$this->db->escape($order_info['shipping_method'])."',`payment` = '".$this->db->escape($order_info['payment_method'])."',`details` = '".$this->db->escape($commission_array['type'])."',`customer` = '".$commission_array['customer']."',`admin` = '".$commission_array['commission']."',currency_code = '".$this->db->escape($order_info['currency_code'])."',currency_value = '".$this->db->escape($order_info['currency_value'])."',commission_applied = '".$this->db->escape($mpSellers['commission'])."',shipping_applied = '".$this->db->escape($shipping_applied)."',`date_added` = NOW(),order_product_status = '".$this->config->get('config_order_status_id')."', `seller_access` = '" . (int)$this->config->get('marketplace_seller_manage_order') . "' WHERE order_id = '" . (int)$order_id . "' AND product_id = '" . (int)$product['product_id'] . "' AND customer_id = '". (int)$mpSellers['customer_id'] ."' AND option_data = '".json_encode($option_data)."'");
				 	

				 }else{


        if ($coupon_info) {
                  
                    foreach ($coupon_info['product'] as $value) {
                    
                        if ($value == $product['product_id']) {

                             $this->db->query("INSERT INTO ".DB_PREFIX."customerpartner_to_order SET `order_id` = '".(int)$order_id."',`customer_id` = '".(int)$mpSellers['customer_id']."',`product_id` = '".(int)$product['product_id']."',`order_product_id` = '".(int)$product['order_product_id']."',`price` = '".(float)$product_total."',`quantity` = '".(int)$product['quantity']."',`shipping` = '".$this->db->escape($order_info['shipping_method'])."',`payment` = '".$this->db->escape($order_info['payment_method'])."',`details` = '".$this->db->escape($commission_array['type'])."',`customer` = '".$commission_array['customer']."',`admin` = '".$commission_array['commission']."',currency_code = '".$this->db->escape($order_info['currency_code'])."',currency_value = '".$this->db->escape($order_info['currency_value'])."',commission_applied = '".$this->db->escape($mpSellers['commission'])."',shipping_applied = '".$this->db->escape($shipping_applied)."',`date_added` = NOW(),order_product_status = '".$this->config->get('config_order_status_id')."',`coupon_price` = '".$coupon_info['discount']."'");
                         }else{

                             $this->db->query("INSERT INTO ".DB_PREFIX."customerpartner_to_order SET `order_id` = '".(int)$order_id."',`customer_id` = '".(int)$mpSellers['customer_id']."',`product_id` = '".(int)$product['product_id']."',`order_product_id` = '".(int)$product['order_product_id']."',`price` = '".(float)$product_total."',`quantity` = '".(int)$product['quantity']."',`shipping` = '".$this->db->escape($order_info['shipping_method'])."',`payment` = '".$this->db->escape($order_info['payment_method'])."',`details` = '".$this->db->escape($commission_array['type'])."',`customer` = '".$commission_array['customer']."',`admin` = '".$commission_array['commission']."',currency_code = '".$this->db->escape($order_info['currency_code'])."',currency_value = '".$this->db->escape($order_info['currency_value'])."',commission_applied = '".$this->db->escape($mpSellers['commission'])."',shipping_applied = '".$this->db->escape($shipping_applied)."',`date_added` = NOW(),order_product_status = '".$this->config->get('config_order_status_id')."' ");

                          }
                        
                        }
                    }
                }else{
                        
				 	$this->db->query("INSERT INTO ".DB_PREFIX."customerpartner_to_order SET `order_id` = '".(int)$order_id."',`customer_id` = '".(int)$mpSellers['customer_id']."',`product_id` = '".(int)$product['product_id']."',`order_product_id` = '".(int)$product['order_product_id']."',`price` = '".(float)$product_total."',`quantity` = '".(int)$product['quantity']."',`shipping` = '".$this->db->escape($order_info['shipping_method'])."',`payment` = '".$this->db->escape($order_info['payment_method'])."',`details` = '".$this->db->escape($commission_array['type'])."',`customer` = '".$commission_array['customer']."',`admin` = '".$commission_array['commission']."',currency_code = '".$this->db->escape($order_info['currency_code'])."',currency_value = '".$this->db->escape($order_info['currency_value'])."',commission_applied = '".$this->db->escape($mpSellers['commission'])."',shipping_applied = '".$this->db->escape($shipping_applied)."',`date_added` = NOW(),order_product_status = '". $this->config->get('config_order_status_id') ."',`option_data` = '".json_encode($option_data)."', `seller_access` = '" . (int)$this->config->get('marketplace_seller_manage_order') . "'");

				} 


				//for adaptive paypal transaction
				if($order_info['payment_code'] == 'wk_adaptive_pay') {
		           $this->db->query("INSERT INTO " . DB_PREFIX . "customerpartner_to_transaction SET `customer_id` = '".(int)$mpSellers['customer_id']."',`amount` = '" . $commission_array['customer'] . "',`text` = '" . $this->currency->format($commission_array['customer'],$order_info['currency_code']) . "',`details` = '".$this->db->escape($commission_array['type'])."',`date_added` = NOW()");
		        }

				if($mailToSellers){

					foreach($mailToSellers as $key => $value) {
						foreach($value as $key1 => $value1) {
							$i = 0;
							if($key1=='email' AND $value1==$mpSellers['email']){                        
								$mailToSellers[$key]['products'][] = $products;
								$mailToSellers[$key]['total'] = $product_total + $mailToSellers[$key]['total'];
								break;
							}else{
								$i++;
							}
						}              
					}  
				}else{
					$mailToSellers[] = array('email' => $mpSellers['email'],
							'customer_id' => $mpSellers['customer_id'],
							'seller_email' => $mpSellers['email'],
							'products' => array(0 => $products),
							'total' => $product_total
							);
				}  

				if($i>0){
					$mailToSellers[] = array('email' => $mpSellers['email'],
						'customer_id' => $mpSellers['customer_id'],
						'seller_email' => $mpSellers['email'],
						'products' => array(0 => $products),
						'total' => $product_total
						);
				}
			}

		}  


		if($this->config->get('marketplace_mailtoseller')){

			// Send out order confirmation mail
			$language = new Language($order_info['language_directory']);
			$language->load($order_info['language_directory']);
			$language->load('default');

                          $language->load('default');
                        
			$language->load('mail/order');

			$subject = sprintf($language->get('text_new_subject'), $order_info['store_name'], $order_id);

			// HTML Mail for seller
			$data = array();

			$data['title'] = sprintf($language->get('text_new_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

			$data['text_greeting'] = '';
			$data['text_link'] = $language->get('text_new_link');
			$data['text_download'] = $language->get('text_new_download');
			$data['text_order_detail'] = $language->get('text_new_order_detail');
			$data['text_order_status'] = $language->get('text_new_order_detail');

			$data['text_instruction'] = $language->get('text_new_instruction');
			$data['text_order_id'] = $language->get('text_new_order_id');
			$data['text_date_added'] = $language->get('text_new_date_added');
			$data['text_payment_method'] = $language->get('text_new_payment_method'); 
			$data['text_shipping_method'] = $language->get('text_new_shipping_method');
			$data['text_email'] = $language->get('text_new_email');
			$data['text_telephone'] = $language->get('text_new_telephone');
			$data['text_ip'] = $language->get('text_new_ip');
			$data['text_payment_address'] = $language->get('text_new_payment_address');
			$data['text_shipping_address'] = $language->get('text_new_shipping_address');
			$data['text_product'] = $language->get('text_new_product');
			$data['text_model'] = $language->get('text_new_model');
			$data['text_quantity'] = $language->get('text_new_quantity');
			$data['text_price'] = $language->get('text_new_price');
			$data['text_total'] = $language->get('text_new_total');
			$data['text_footer'] = $language->get('text_new_footer');
			$data['text_powered'] = $language->get('text_new_powered');

                         
                        $data['text_subtotal'] = $language->get('text_new_subtotal');
                        $data['text_coupon'] = $language->get('text_new_coupon');
                        $data['text_grand'] = $language->get('text_new_grandtotal');
                        $data['mpauction_status']= $this->config->get('wkproduct_auction_status');
                        

			$data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');    
			$data['store_name'] = $order_info['store_name'];
			$data['store_url'] = $order_info['store_url'];
			$data['customer_id'] = $order_info['customer_id'];
			$data['link'] = $order_info['store_url'] . 'index.php?route=account/customerpartner/orderinfo&order_id=' . $order_id;

			$data['download'] = '';

			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

			foreach ($order_product_query->rows as $order_product) {
				// Check if there are any linked downloads
				$product_download_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_to_download` WHERE product_id = '" . (int)$order_product['product_id'] . "'");

				if ($product_download_query->row['total']) {
					$data['download'] = $order_info['store_url'] . 'index.php?route=account/customerpartner/download';					
				}
			}

			$data['order_id'] = $order_id;
			$data['date_added'] = date($language->get('date_format_short'), strtotime($order_info['date_added']));      
			$data['payment_method'] = $order_info['payment_method'];
			$data['shipping_method'] = $order_info['shipping_method'];
			$data['email'] = $order_info['email'];
			$data['telephone'] = $order_info['telephone'];
			$data['ip'] = $order_info['ip'];
			$data['order_status'] = $order_status;
			
			if ($comment) {
				$data['comment'] = nl2br($comment);
			} else {
				$data['comment'] = '';
			}

			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['payment_firstname'],
				'lastname'  => $order_info['payment_lastname'],
				'company'   => $order_info['payment_company'],
				'address_1' => $order_info['payment_address_1'],
				'address_2' => $order_info['payment_address_2'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
				'country'   => $order_info['payment_country']  
			);

			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));           

			if ($order_info['shipping_address_format']) {
				$format = $order_info['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['shipping_firstname'],
				'lastname'  => $order_info['shipping_lastname'],
				'company'   => $order_info['shipping_company'],
				'address_1' => $order_info['shipping_address_1'],
				'address_2' => $order_info['shipping_address_2'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
				'country'   => $order_info['shipping_country']  
			);

			$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			// Products
			$data['products'] = array();

			// Text Mail for seller
			$textBasic = $language->get('text_new_order_id') . ' ' . $order_id . "\n";
			$textBasic .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
			$textBasic .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n"; 

			$data['vouchers'] = array();          
			// $this->load->model('payment/amazon_checkout');
			// if (!$this->model_payment_amazon_checkout->isAmazonOrder($order_info['order_id'])) {

				$this->load->model('customerpartner/mail');
				$this->load->model('account/customerpartner');
				
				foreach ($mailToSellers as $value) {
					$data['totals'] = array();

					//for template for seller
					$data['products'] = $value['products'];
					$data['totals'][] = array('title' => 'Total' ,'text' => $this->currency->format($value['total'], $order_info['currency_code'], 1));

					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/order.tpl')) {
						$html = $this->load->view($this->config->get('config_template') . '/template/mail/order.tpl', $data);
					} else {
						$html = $this->load->view('default/template/mail/order.tpl', $data);
					}

					//for text for seller
					$products = $value['products'];
					$text = $textBasic;
					foreach ($products as $product) {
						$text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($product['total']) . "\n";                

						foreach ($product['option'] as $option) {
							$text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($option['value'])) . "\n";
						}
					}       

					$text .= $language->get('text_new_order_total') . "\n";

					$text .= $this->currency->format($value['total'], $order_info['currency_code'], 1) . ': ' . html_entity_decode($this->currency->format($value['total'], $order_info['currency_code'], 1), ENT_NOQUOTES, 'UTF-8') . "\n";

					$text .= $language->get('text_new_footer') . "\n\n";

					$mailData = array(
						'seller_id' => $value['customer_id'],
						'text' => $text,
						// 'html' => $html,
			        	'customer_id' => false,
			        	'mail_id' => $this->config->get('marketplace_mail_order'),
			        	'mail_from' => $this->config->get('marketplace_adminmail'),
			        	'mail_to' => $value['seller_email'],
					);

					$commission = $this->model_account_customerpartner->getSellerCommission($value['customer_id']);

					$values = array(
			        	'order' => $html,
						'commission' => $commission,
			        );
					$this->model_customerpartner_mail->mail($mailData,$values);

				}
			// }
		}
	}


                          public function getCouponDetail($code,$order_id){

                                $coupon_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon` WHERE code = '" . $this->db->escape($code) . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) AND status = '1'");

                                $coupon_product_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon_product` WHERE coupon_id = '" . (int)$coupon_query->row['coupon_id'] . "'");

                                foreach ($coupon_product_query->rows as $product) {
                                    $coupon_product_data[] = $product['product_id'];
                                  }

                                $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

                                foreach ($order_product_query->rows as $value) {
                                  
                                  if (in_array($value['product_id'], $coupon_product_data)) {
                                        $product_data[] = $product['product_id'];

                                        continue;
                                      }
                                }

                                return array(
                                    'coupon_id'     => $coupon_query->row['coupon_id'],
                                    'code'          => $coupon_query->row['code'],
                                    'name'          => $coupon_query->row['name'],
                                    'type'          => $coupon_query->row['type'],
                                    'discount'      => $coupon_query->row['discount'],
                                    'shipping'      => $coupon_query->row['shipping'],
                                    'total'         => $coupon_query->row['total'],
                                    'product'       => $product_data,
                                    'date_start'    => $coupon_query->row['date_start'],
                                    'date_end'      => $coupon_query->row['date_end'],
                                    'uses_total'    => $coupon_query->row['uses_total'],
                                    'uses_customer' => $coupon_query->row['uses_customer'],
                                    'status'        => $coupon_query->row['status'],
                                    'date_added'    => $coupon_query->row['date_added']
                                  );  
                              }
                        
	public function calculateCommission($product,$customer_id) {
		
		if($product) {
			$categories_array = $this->db->query("SELECT p2c.category_id,c.parent_id FROM ".DB_PREFIX."product_to_category p2c LEFT JOIN ".DB_PREFIX."category c ON (p2c.category_id = c.category_id) WHERE p2c.product_id = '".(int)$product['product_id']."' ORDER BY p2c.product_id ");

			if($this->config->get('marketplace_commissionworkedon'))
				$categories = $categories_array->rows;
			else
				$categories = array($categories_array->row);

			//get commission array for priority
			$commission = $this->config->get('marketplace_boxcommission');	
			$commission_amount = 0;
			$commission_type = '';

			if($commission)
				foreach($commission as $various) {
					switch ($various) {
						case 'category': //get all parent category according to product and process
							if(isset($categories[0]) && $categories[0]){

								foreach($categories as $category) {
									if($category['parent_id']==0){
										$category_commission = $this->getCategoryCommission($category['category_id']);
										if($category_commission){
											$commission_amount += ( $category_commission['percentage'] ? ($category_commission['percentage']*$product['product_total']/100) : 0 ) + $category_commission['fixed'];
										}
									}
								}
								$commission_type = 'Category Based';
								if($commission_amount)
									break;	
							}			

						case 'category_child': //get all child category according to product and process
							if(isset($categories[0]) && $categories[0]){

								foreach($categories as $category){
									if($category['parent_id'] > 0){
										$category_commission = $this->getCategoryCommission($category['category_id']);
										if($category_commission){
											$commission_amount += ( $category_commission['percentage'] ? ($category_commission['percentage']*$product['product_total']/100) : 0 ) + $category_commission['fixed'];
										}
									}
								}	

								$commission_type = 'Category Child Based';									
								if($commission_amount)
									break;	
							}	
							
						default: //just get all amount and process on that (precentage based)
							$customer_commission = $this->getCustomerCommission($customer_id);
							if($customer_commission) {
								$commission_amount += $customer_commission['commission'] ? ($customer_commission['commission']*$product['product_total']/100) : 0;
							}

							$commission_type = 'Partner Fixed Based';									
							break;
					}
					if($commission_amount)
						break;
				}

		/**
		 * To calculate commission as per membership of seller
		 */

		if($this->config->get('wk_seller_group_status')) {
      		$this->load->model('account/customer_group');
      		$isMember = $this->model_account_customer_group->getSellerMembershipGroup($customer_id);
			if($isMember) {
				$membershipCommission = $this->model_account_customer_group->getMembershipGroupCommission($isMember['gid'],$product['product_id']);
				if($membershipCommission) {
					$commission_amount += ( $membershipCommission['percentage'] ? ($membershipCommission['percentage']*$product['product_total']/100) : 0 ) + $membershipCommission['fixed'];
				}
				$commission_type = 'Membership Based';									
			}
		}

			$return_array = array(
				'commission' => $commission_amount,
				'customer' => $product['product_total']- $commission_amount,
				'type' => $commission_type,
			);
			return($return_array);	
		}	
	}

	public function sellerAdminData($cart, $zip = '',$payment = false ){
		//price for payment
		//total for shipping

		$seller = array();

		if($cart AND is_array($cart))
			foreach($cart as $product){

				$entry = 0;

				if(!$product['weight_class_id'])
					$product['weight_class_id'] = $this->config->get('config_weight_class_id');

				if($product['weight'])
					$weight = $this->weight->convert($product['weight'], $product['weight_class_id'],$this->config->get('config_weight_class_id'));
				else
					$weight = 0;	
				
				$weight = ($weight < 0.1 ? 0.1 : $weight);
				
				$seller_zip = $this->db->query("SELECT a.postcode,a.customer_id,a.city,c.iso_code_2 as country,z.code as state,c2c.paypalid FROM ".DB_PREFIX."product p LEFT JOIN ".DB_PREFIX."customerpartner_to_product c2p ON (p.product_id = c2p.product_id) LEFT JOIN ".DB_PREFIX."customer cu ON(cu.customer_id = c2p.customer_id) LEFT JOIN ".DB_PREFIX."address a ON(cu.address_id = a.address_id) LEFT JOIN ".DB_PREFIX."zone z ON (a.zone_id = z.code) LEFT JOIN ".DB_PREFIX."country c ON (a.country_id = c.country_id) RIGHT JOIN " . DB_PREFIX . "customerpartner_to_customer c2c ON (c2c.customer_id = a.customer_id) WHERE p.product_id='".$product['product_id']."'")->row;

				if($seller_zip){
                    
                    /**
                     * IF admin set that commission will be calculated on the tax then send the product total price with the tax 
                     */
					if ($this->config->get('marketplace_commission_tax')) {
						
						$commission_array = $this->calculateCommission(array('product_id'=> $product['product_id'], 'product_total'=> $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']),$seller_zip['customer_id']);

					}else{

						$commission_array = $this->calculateCommission(array('product_id'=>$product['product_id'], 'product_total'=>$product['total']),$seller_zip['customer_id']);

					}


					//add taxes to seller amount
					if($this->config->get('config_tax')){
						$commission_array['customer'] += $this->tax->getTax($product['total'], $product['tax_class_id']); //comment me
						$product['total'] = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'];									
					} // after me

					if($seller){
						foreach($seller as $index => $sellers) {
					        if($sellers['seller'] == $seller_zip['customer_id']) {
					        	$seller[$index]['weight'] = (float)$sellers['weight']+(float)$weight;
					        	$seller[$index]['name'] = $sellers['name'].', '.$product['name'];
							    $seller[$index]['total'] = $sellers['total'] + $product['total'];
				        		$seller[$index]['price'] = (float)$commission_array['customer']+(float)$sellers['price'];
					        	$entry = 1;
					         }
					    }
					    if($entry == 0){		
					    	$zipCode = substr($seller_zip['postcode'], 0, 8);
					    	$seller[$seller_zip['customer_id']] = array(
										  'seller' => $seller_zip['customer_id'],					    		
					    				  'zip' => $zipCode,
										  'weight' => $weight,
										  'name' => $product['name'],
										  'city' => $seller_zip['city'],
										  'country' => $seller_zip['country'],
										  'state' => $seller_zip['state'],									  
									  	  'price' => $commission_array['customer'],
										  'total' => $product['total'],
										  'paypalid' => $seller_zip['paypalid'],
										  'primary'=> false
										  );
					    }
					}else{
					 	$zipCode = substr($seller_zip['postcode'], 0, 8);
						$seller[$seller_zip['customer_id']] = array(
										  'seller' => $seller_zip['customer_id'],							
										  'zip' => $zipCode,
										  'weight' => $weight,
										  'name' => $product['name'],
										  'city' => $seller_zip['city'],
										  'country' => $seller_zip['country'],
										  'state' => $seller_zip['state'],										  
									  	  'price' => $commission_array['customer'],
										  'total' => $product['total'],									  	  
										  'paypalid' => $seller_zip['paypalid'],
										  'primary'=> false										  
										  );
					}

					//admin -> if exists seller 			
					if($payment){
						foreach($seller as $index => $sellers) {					
					        if($sellers['seller'] == 'Admin') {
					        	$seller[$index]['price'] = (float)$sellers['price']+(float)$commission_array['commission'];
					        	// $seller[$index]['total'] = (float)$sellers['total'] + (float)$commission_array['commission'];	
					        	$seller[$index]['name'] = $sellers['name'].', Commission';
					        	$entry = 1;
					         }
					    }
					    if($entry == 0){		
					 		$zipCode = substr($this->config->get($zip), 0, 8);					    		 	
							$seller[] = array(
											  'seller' => 'Admin',								
					    				  	  'zip' => $zipCode,
											  'weight' => 0,											  
											  'name' => 'Commission',											  
											  'city' => $this->config->get('wkmpups_city'),
											  'country' => $this->config->get('wkmpups_country'),
											  'state' => $this->config->get('wkmpups_state'),
											  'price' => (float)$commission_array['commission'],
										  	  'total' => 0,
											  'paypalid'=> $this->config->get('wk_adaptive_pay_email'),
											  'primary'=> true
											  );
					 	}
					}

				}else{
					//add taxes to seller amount
					if($this->config->get('config_tax'))
						$product['total'] = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'];									
						// $product['total'] += $this->tax->getTax($product['total'], $product['tax_class_id']);

					if($seller){
						foreach($seller as $index => $sellers) {
					        if($sellers['seller'] == 'Admin') {
							    $seller[$index]['total'] = $sellers['total'] + $product['total'];
					        	$seller[$index]['weight'] = (float)$sellers['weight']+(float)$weight;
					        	$seller[$index]['name'] = $sellers['name'].', '.$product['name'];
				        		$seller[$index]['price'] = (float)$sellers['price']+(float)$product['total'];	        	
					        	$entry = 1;
					         }
					    }
					    if($entry == 0){
					 		$zipCode = substr($this->config->get($zip), 0, 8);
							$seller[] = array(
										  'seller' => 'Admin',								
										  'zip' => $zipCode,
										  'weight' => $weight,
									  	  'name' => $product['name'],
										  'city' => $this->config->get('wkmpups_city'),
										  'country' => $this->config->get('wkmpups_country'),
										  'state' => $this->config->get('wkmpups_state'),
									  	  'price' => $product['total'],											  
										  'total' => $product['total'],										  
										  'paypalid' => $this->config->get('wk_adaptive_pay_email'),									  
										  'primary' => true,
										  );
					 	}
					}else{
					 	$zipCode = substr($this->config->get($zip), 0, 8);
						$seller[] = array(
										  'seller' => 'Admin',								
										  'zip' => $zipCode,
										  'weight' => $weight,
									  	  'name' => $product['name'],
										  'city' => $this->config->get('wkmpups_city'),
										  'country' => $this->config->get('wkmpups_country'),
										  'state' => $this->config->get('wkmpups_state'),
									  	  'price' => $product['total'],											  
										  'total' => $product['total'],										  
										  'paypalid' => $this->config->get('wk_adaptive_pay_email'),									  
										  'primary' => true,
										);
					}
					 			
				}

				
			}


		return $seller;
	}

	public function getCategoryCommission($category_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."customerpartner_commission_category WHERE category_id = '" . (int)$category_id . "'");
		return $query->row;
	}

	public function getCustomerCommission($customer_id) {
		$query = $this->db->query("SELECT commission FROM ".DB_PREFIX."customerpartner_to_customer WHERE customer_id = '" . (int)$customer_id . "'");
		return $query->row;
	}

	public function getShippingAddressId($order_id){
		$sql = "SELECT * FROM ".DB_PREFIX."order o LEFT JOIN ".DB_PREFIX."customer c ON o.customer_id=c.customer_id WHERE order_id = '".$order_id."'  ";

		$result = $this->db->query($sql)->row;
		return $result;
	}

	
}

?>