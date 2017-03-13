<?php
class ModelCheckoutOrder extends Model {
	public function shorturl($longUrl){
		$apiKey = 'AIzaSyBWUw33hp42BDojv7AzVeMV1MnTo6eT74w'; 
		//$longUrl = base64_decode($longUrl);
		$jsonData = json_encode(array('longUrl' => $longUrl));
		
		$curlObj = curl_init();
		
		curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$apiKey );
		curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curlObj, CURLOPT_HEADER, 0);
		curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
		curl_setopt($curlObj, CURLOPT_POST, 1);
		curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
		 
		$response = curl_exec($curlObj);
		curl_close($curlObj);
		//echo $response . "<br/>";
		$json = json_decode($response);
		//echo 'Shortened URL is: '.$json->id;
		return $json->id;
	}
	
	public function addOrder($data) {
		$this->event->trigger('pre.order.add', $data);

		$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) ."', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', dnis = '" . $this->db->escape(   isset($data['dnis']) ? $data['dnis'] : '0') . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? serialize($data['custom_field']) : '') . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_custom_field = '" . $this->db->escape(isset($data['payment_custom_field']) ? serialize($data['payment_custom_field']) : '') . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_custom_field = '" . $this->db->escape(isset($data['shipping_custom_field']) ? serialize($data['shipping_custom_field']) : '') . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float)$data['total'] . "', affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', marketing_id = '" . (int)$data['marketing_id'] . "', tracking = '" . $this->db->escape($data['tracking']) . "', language_id = '" . (int)$data['language_id'] . "', currency_id = '" . (int)$data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float)$data['currency_value'] . "', ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" .  $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', date_added = NOW(), date_modified = NOW()");
		//$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET affiliate_id= '" . $this->db->escape($data['affiliate_id']) . "',  invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? serialize($data['custom_field']) : '') . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_custom_field = '" . $this->db->escape(isset($data['payment_custom_field']) ? serialize($data['payment_custom_field']) : '') . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_custom_field = '" . $this->db->escape(isset($data['shipping_custom_field']) ? serialize($data['shipping_custom_field']) : '') . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float)$data['total'] . "', affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', marketing_id = '" . (int)$data['marketing_id'] . "', tracking = '" . $this->db->escape($data['tracking']) . "', language_id = '" . (int)$data['language_id'] . "', currency_id = '" . (int)$data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float)$data['currency_value'] . "', ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" .  $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', date_added = NOW(), date_modified = NOW()");

		$order_id = $this->db->getLastId();
    //short url
    //base64_encode($data['affiliate_id']);
    //$url_bupass = "http://www.goorulife.com/ishop/index.php?route=affiliate/order/invoice_tracking&affiliate_id=".(int)$data['affiliate_id']."&order_id=".(int)$order_id."";
    $url_bupass = "https://www.isportmart.com/index.php?route=affiliate/order/invoice_tracking&affiliate_id=".base64_encode($data['affiliate_id'])."&order_id=".base64_encode($order_id)."";

    $shorturl = $this->shorturl($url_bupass);
    $this->db->query("UPDATE `" . DB_PREFIX . "order` SET short_url = '" .$shorturl."' WHERE order_id = '" . (int)$order_id . "'");

		// one add - begin @ 16/09/2016  -- #1/2
		$coupon_code = '';
		if (isset($data['totals'])) {
			foreach ($data['totals'] as $total) {							
				if ($total['code']=="coupon") {				
					$start = strpos($total['title'], '(') + 1;
					$end = strrpos($total['title'], ')');				
					if ($start && $end) {
						$coupon_code = substr($total['title'], $start, $end - $start);
					}
				}				
			}
		}
		//$log = new Log('coupon_addOrder.log');
		//$log->write( "addOrder : coupon  = " . $coupon_code );		
		// one add - end @ 16/09/2016  -- #1/2  	
		
		
		// Products
		if (isset($data['products'])) {
			foreach ($data['products'] as $product) {
				
				#$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'");   // org.
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax']*(int)$product['quantity']  . "', reward = '" . (int)$product['reward'] . "' 
				, margintype=(select p.margintype from oc_product p where p.product_id= '" . (int)$product['product_id'] . "' )
				, marginvalue=(select  p.marginvalue from oc_product p where p.product_id= '" . (int)$product['product_id'] . "' )  
				");  // one mo - 1/3 @20/09/2016
												
				$order_product_id = $this->db->getLastId();

				foreach ($product['option'] as $option) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
				}
				
				// one add - begin @ 16/09/2016  -- #2/2
				if (!empty($coupon_code)) {
					//$log->write( "addOrder : empty(coupon_code) = " . $coupon_code );	
					$this->db->query("UPDATE  " . DB_PREFIX . "order_product op SET 
					 	discount=( SELECT if ( c.type = 'P', " . (float)$product['total'] . " * (c.discount /100) , " .(int)$product['quantity']  ." *c.discount  )  
					 					FROM oc_coupon c, oc_coupon_product cp  
					 				      where c.coupon_id = cp.coupon_id and c.code='" . $this->db->escape($coupon_code) . "'  
					 				      and cp.product_id= '". (int)$product['product_id'] ."' ) 
						where op.order_id='" . (int)$order_id . "' and  op.order_product_id='". (int)$order_product_id ."'  ");  
				}
				// one add - end @ 16/09/2016  -- #2/2				
				
			}  // foreach ($data['products'] as $product) {
			
			// update margin for accouting -- one add 
			$this->db->query("UPDATE  oc_order_product op SET 
						op.tax=if (op.tax=0,  0, round( op.tax-(op.discount*0.07),2) ), 
	 					op.margin_gross= if( op.margintype='F',  op.marginvalue*op.quantity,  round(  op.total*op.marginvalue/100,2)   ) - op.discount 
						where op.order_id='" . (int)$order_id . "'  ");  // one mo - 2/3 @20/09/2016

			$this->db->query("UPDATE  oc_order_product op SET 
						op.margin_net=  if (op.tax=0,  (op.margin_gross-round( op.margin_gross*0.07/1.07,2) ), (op.margin_gross-round( op.margin_gross*0.07/100,2) )   )  ,
						op.vat =  if (op.tax=0,  round( op.margin_gross*0.07/1.07,2) ,   round( op.margin_gross*0.07/100,2)  ) , 
						op.WHT=  if ((select a.commission from oc_order o, oc_affiliate a where  o.affiliate_id=a.affiliate_id and o.order_id=op.order_id) =0, 0, round(    
						 	( 
						 	   if (op.tax=0,  (op.margin_gross-round( op.margin_gross*0.07/1.07,2) ), (op.margin_gross-round( op.margin_gross*0.07/100,2) )   ) 
						   	 )*(select a.commission from oc_order o, oc_affiliate a where  o.affiliate_id=a.affiliate_id and o.order_id=op.order_id)/100,2)    ) 
						where op.order_id='" . (int)$order_id . "'  ");  // one mo - 3/3 @20/09/2016
		}

		// Gift Voucher
		$this->load->model('checkout/voucher');

		// Vouchers
		if (isset($data['vouchers'])) {
			foreach ($data['vouchers'] as $voucher) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($voucher['description']) . "', code = '" . $this->db->escape($voucher['code']) . "', from_name = '" . $this->db->escape($voucher['from_name']) . "', from_email = '" . $this->db->escape($voucher['from_email']) . "', to_name = '" . $this->db->escape($voucher['to_name']) . "', to_email = '" . $this->db->escape($voucher['to_email']) . "', voucher_theme_id = '" . (int)$voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($voucher['message']) . "', amount = '" . (float)$voucher['amount'] . "'");

				$order_voucher_id = $this->db->getLastId();

				$voucher_id = $this->model_checkout_voucher->addVoucher($order_id, $voucher);

				$this->db->query("UPDATE " . DB_PREFIX . "order_voucher SET voucher_id = '" . (int)$voucher_id . "' WHERE order_voucher_id = '" . (int)$order_voucher_id . "'");
			}
		}

		// Totals
		if (isset($data['totals'])) {
			foreach ($data['totals'] as $total) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
			}
		}

		$this->event->trigger('post.order.add', $order_id);

		return $order_id;
	}
	
	public function editOrder($order_id, $data) {
		$this->event->trigger('pre.order.edit', $data);

		// Void the order first
		$this->addOrderHistory($order_id, 0);

		//$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(serialize($data['custom_field'])) . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_custom_field = '" . $this->db->escape(serialize($data['payment_custom_field'])) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_custom_field = '" . $this->db->escape(serialize($data['shipping_custom_field'])) . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float)$data['total'] . "', affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");  // one remark @ 30/05/2019
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(serialize($data['custom_field'])) . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_custom_field = '" . $this->db->escape(serialize($data['payment_custom_field'])) . "', payment_method = '" . $this->db->escape($data['payment_method']) . 
								  "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_custom_field = '" . $this->db->escape(serialize($data['shipping_custom_field'])) . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float)$data['total'] . "', affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");  // one add @ 30/05/2019 - remove customer_group_id

		$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "'");
		
		// one add - begin @ 16/09/2016  -- #1/2
		$coupon_code = '';
		if (isset($data['totals'])) {
			foreach ($data['totals'] as $total) {							
				if ($total['code']=="coupon") {				
					$start = strpos($total['title'], '(') + 1;
					$end = strrpos($total['title'], ')');				
					if ($start && $end) {
						$coupon_code = substr($total['title'], $start, $end - $start);
					}
				}				
			}
		}
		//$log = new Log('coupon_addOrder.log');
		//$log->write( "addOrder : coupon  = " . $coupon_code );		
		// one add - end @ 16/09/2016  -- #1/2  	
		
		// Products
		if (isset($data['products'])) {
			foreach ($data['products'] as $product) {
//				$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'");  // org.

				$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax']*(int)$product['quantity']  . "', reward = '" . (int)$product['reward'] . "' 
				, margintype=(select p.margintype from oc_product p where p.product_id= '" . (int)$product['product_id'] . "' )
				, marginvalue=(select  p.marginvalue from oc_product p where p.product_id= '" . (int)$product['product_id'] . "' )  
				");  // one mo - 1/3 @20/09/2016

				$order_product_id = $this->db->getLastId();

				foreach ($product['option'] as $option) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");										
				}
				// one add - begin @ 16/09/2016  -- #2/2
				if (!empty($coupon_code)) {
					//$log->write( "addOrder : empty(coupon_code) = " . $coupon_code );	
					$this->db->query("UPDATE  " . DB_PREFIX . "order_product op SET 
					 	discount=( SELECT if ( c.type = 'P', " . (float)$product['total'] . " * (c.discount /100) , " .(int)$product['quantity']  ." *c.discount  )  
					 					FROM oc_coupon c, oc_coupon_product cp  
					 				      where c.coupon_id = cp.coupon_id and c.code='" . $this->db->escape($coupon_code) . "'  
					 				      and cp.product_id= '". (int)$product['product_id'] ."' ) 
						where op.order_id='" . (int)$order_id . "' and  op.order_product_id='". (int)$order_product_id ."'  ");  
				}
				// one add - end @ 16/09/2016  -- #2/2	
				
			}
			// update margin for accouting -- one add
			$this->db->query("UPDATE  oc_order_product op SET 
						op.tax=if (op.tax=0,  0, round( op.tax-(op.discount*0.07),2) ), 
	 					op.margin_gross= if( op.margintype='F',  op.marginvalue*op.quantity,  round(  op.total*op.marginvalue/100,2)   ) - op.discount 
						where op.order_id='" . (int)$order_id . "'  ");  // one mo - 2/3 @20/09/2016

			$this->db->query("UPDATE  oc_order_product op SET 
						op.margin_net=  if (op.tax=0,  (op.margin_gross-round( op.margin_gross*0.07/1.07,2) ), (op.margin_gross-round( op.margin_gross*0.07/100,2) )   )  ,
						op.vat =  if (op.tax=0,  round( op.margin_gross*0.07/1.07,2) ,   round( op.margin_gross*0.07/100,2)  ) , 
						op.WHT=  if ((select a.commission from oc_order o, oc_affiliate a where  o.affiliate_id=a.affiliate_id and o.order_id=op.order_id) =0, 0, round(    
						 	( 
						 	   if (op.tax=0,  (op.margin_gross-round( op.margin_gross*0.07/1.07,2) ), (op.margin_gross-round( op.margin_gross*0.07/100,2) )   ) 
						   	 )*(select a.commission from oc_order o, oc_affiliate a where  o.affiliate_id=a.affiliate_id and o.order_id=op.order_id)/100,2)    ) 
						where op.order_id='" . (int)$order_id . "'  ");  // one mo - 3/3 @20/09/2016	
									
		}		

		// Gift Voucher
		$this->load->model('checkout/voucher');

		$this->model_checkout_voucher->disableVoucher($order_id);

		// Vouchers
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

		if (isset($data['vouchers'])) {
			foreach ($data['vouchers'] as $voucher) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($voucher['description']) . "', code = '" . $this->db->escape($voucher['code']) . "', from_name = '" . $this->db->escape($voucher['from_name']) . "', from_email = '" . $this->db->escape($voucher['from_email']) . "', to_name = '" . $this->db->escape($voucher['to_name']) . "', to_email = '" . $this->db->escape($voucher['to_email']) . "', voucher_theme_id = '" . (int)$voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($voucher['message']) . "', amount = '" . (float)$voucher['amount'] . "'");

				$order_voucher_id = $this->db->getLastId();

				$voucher_id = $this->model_checkout_voucher->addVoucher($order_id, $voucher);

				$this->db->query("UPDATE " . DB_PREFIX . "order_voucher SET voucher_id = '" . (int)$voucher_id . "' WHERE order_voucher_id = '" . (int)$order_voucher_id . "'");
			}
		}

		// Totals
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "'");

		if (isset($data['totals'])) {
			foreach ($data['totals'] as $total) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
			}
		}

		$this->event->trigger('post.order.edit', $order_id);
	}

	public function deleteOrder($order_id) {
		$this->event->trigger('pre.order.delete', $order_id);

		// Void the order first
		$this->addOrderHistory($order_id, 0);

		$this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_product` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_option` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_history` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE `or`, ort FROM `" . DB_PREFIX . "order_recurring` `or`, `" . DB_PREFIX . "order_recurring_transaction` `ort` WHERE order_id = '" . (int)$order_id . "' AND ort.order_recurring_id = `or`.order_recurring_id");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "affiliate_transaction` WHERE order_id = '" . (int)$order_id . "'");

		// Gift Voucher
		$this->load->model('checkout/voucher');

		$this->model_checkout_voucher->disableVoucher($order_id);


        if($this->config->get('marketplace_status')) {
             $this->db->query("DELETE FROM ".DB_PREFIX."customerpartner_to_order WHERE order_id = '".(int)$order_id."' ");
             $this->db->query("DELETE FROM ".DB_PREFIX."customerpartner_to_order_status WHERE order_id = '".(int)$order_id."' ");
             $this->db->query("DELETE FROM ".DB_PREFIX."customerpartner_sold_tracking WHERE order_id = '".(int)$order_id."' ");
        }
            
		$this->event->trigger('post.order.delete', $order_id);
	}

	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT *, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = o.language_id) AS order_status FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}

			$this->load->model('localisation/language');

			$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

			if ($language_info) {
				$language_code = $language_info['code'];
				$language_directory = $language_info['directory'];
			} else {
				$language_code = '';
				$language_directory = '';
			}

			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $order_query->row['customer_id'],
				'firstname'               => $order_query->row['firstname'],
				'lastname'                => $order_query->row['lastname'],
				'email'                   => $order_query->row['email'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'custom_field'            => unserialize($order_query->row['custom_field']),
				'payment_firstname'       => $order_query->row['payment_firstname'],
				'payment_lastname'        => $order_query->row['payment_lastname'],
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address_1'       => $order_query->row['payment_address_1'],
				'payment_address_2'       => $order_query->row['payment_address_2'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_custom_field'    => unserialize($order_query->row['payment_custom_field']),
				'payment_method'          => $order_query->row['payment_method'],
				'payment_code'            => $order_query->row['payment_code'],
				'shipping_firstname'      => $order_query->row['shipping_firstname'],
				'shipping_lastname'       => $order_query->row['shipping_lastname'],
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address_1'      => $order_query->row['shipping_address_1'],
				'shipping_address_2'      => $order_query->row['shipping_address_2'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_custom_field'   => unserialize($order_query->row['shipping_custom_field']),
				'shipping_method'         => $order_query->row['shipping_method'],
				'shipping_code'           => $order_query->row['shipping_code'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'order_status_id'         => $order_query->row['order_status_id'],
				'order_status'            => $order_query->row['order_status'],
				'affiliate_id'            => $order_query->row['affiliate_id'],
				'commission'              => $order_query->row['commission'],
				'language_id'             => $order_query->row['language_id'],
				'language_code'           => $language_code,
				'language_directory'      => $language_directory,
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'ip'                      => $order_query->row['ip'],
				'forwarded_ip'            => $order_query->row['forwarded_ip'],
				'user_agent'              => $order_query->row['user_agent'],
				'accept_language'         => $order_query->row['accept_language'],
				'date_modified'           => $order_query->row['date_modified'],
				'date_added'              => $order_query->row['date_added']
			);
		} else {
			return false;
		}
	}
	
	public function sendSMS($vani, $v_msg) {
		
		//$v_msg = str_replace('http://', ' ', $v_msg);
		
		//$v_msg = htmlentities($v_msg, ENT_QUOTES);
		$v_msg = urlencode($v_msg );
		
		// one add - 20160823 - begin0897998987
		if ( $vani == '66897998987' || $vani == '0897998987' ){
			return "OK";
		}
		// one add - 20160823 - end
		
		$sms_url = "http://app.bug1113.com/tv/sms_send.php?ani=" . $vani ."&msg=" . $v_msg ;
		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		$context = stream_context_create($opts);		
		$response_data = file_get_contents( $sms_url, false,$context);		
	
		return $response_data;		
	}

	public function createInvoiceNo($order_id) {  // one add
		$order_info = $this->getOrder($order_id);

		if ($order_info && !$order_info['invoice_no']) {
			//$query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "order` WHERE invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "'");
			$query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "order` WHERE invoice_prefix  like DATE_FORMAT(NOW(),'%Y%m%')");

			if ($query->row['invoice_no']) {
				$invoice_no = $query->row['invoice_no'] + 1;
			} else {
				$invoice_no = 1;
			}

			//$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_no = '" . (int)$invoice_no . "', invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "' WHERE order_id = '" . (int)$order_id . "'");
			//$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_no = '" . (int)$invoice_no . "', invoice_prefix = DATE_FORMAT(NOW(),'%Y%m-%d-0000')  WHERE order_id = '" . (int)$order_id . "'");   // one remark @ 20160519
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET date_paid = NOW(),  invoice_no = '" . (int)$invoice_no . "', invoice_prefix = DATE_FORMAT(NOW(),'%Y%m-%d-0000')  WHERE order_id = '" . (int)$order_id . "'"); // one add @ 20160519
			

			return $order_info['invoice_prefix'] . $invoice_no;
		}
	}	
	
	public function addOrderHistory($order_id, $order_status_id, $comment = '', $notify = false, $v_user_id = '0') {
//	public function addOrderHistory($order_id, $order_status_id, $comment = '', $notify =true) {  // one add
		$this->event->trigger('pre.order.history.add', $order_id);

		$order_info = $this->getOrder($order_id);
		//$v_user_id = '0';
		$vani ='';
		
		if ($order_info) {
			// Fraud Detection
			$this->load->model('account/customer');


            $toAdmin = false;
            if(isset($comment) && $comment) {
                $get_comment = explode('___',$comment);
                if($get_comment[0] == 'wk_admin_comment' ) {
                    $comment = ($get_comment[1]);
                    $toAdmin = true;
                    $this->config->set('config_email',$this->customer->getEmail());
                    if($this->config->get('marketplaceadminmail')) {
                        $order_info['email'] = $this->config->get('marketplace_adminmail');
                    } else {
                        $order_info['email'] = $this->config->get('config_email');
                    }
                }
            }
            
			$customer_info = $this->model_account_customer->getCustomer($order_info['customer_id']);

			if ($customer_info && $customer_info['safe']) {
				$safe = true;
			} else {
				$safe = false;
			}

			if (!$safe) {
				// Ban IP
				$status = false;
				 // one remark - no need @ 17/03/2016 // set back 11/07/2016
				if ($order_info['customer_id']) {
					$results = $this->model_account_customer->getIps($order_info['customer_id']);
					foreach ($results as $result) {
						if ($this->model_account_customer->isBanIp($result['ip'])) {
							$status = true;
							break;
						}
					}
				} else {
					$status = $this->model_account_customer->isBanIp($order_info['ip']);
				}
				
				/* // one add - remark because today no need
				if ( strpos( $ipAddress, '203.149.37.') >= 0 || 		// 203.149.37.146 // proxy fl.24
					strpos( $ipAddress, '210.246.156.') >= 0 || 	//	210.246.156.80,  210.246.156.91  // proxy IT 
					strpos( $ipAddress, '210.246.157.') >= 0 ||		//	210.246.157.22	// proxy IT 
					strpos( $ipAddress, '172.21.8.1') >= 0 ||		// x forward IP
					strpos( $ipAddress, '192.168.64.') >= 0 )
					$status = false;
				} else {
					$status = true;  // block 
				}
				*/


				if ($status) {
					$order_status_id = $this->config->get('config_order_status_id');
				}

				// Anti-Fraud
				/* // one remark - no need @ 17/03/2016
				$this->load->model('extension/extension');

				$extensions = $this->model_extension_extension->getExtensions('fraud');

				foreach ($extensions as $extension) {
					if ($this->config->get($extension['code'] . '_status')) {
						$this->load->model('fraud/' . $extension['code']);

						$fraud_status_id = $this->{'model_fraud_' . $extension['code']}->check($order_info);

						if ($fraud_status_id) {
							$order_status_id = $fraud_status_id;
						}
					}
				} 
				*/
			}
			
			$customer_status_list = array(1,2,7,10,15,16,20,3);  // one add
			if ( in_array( $order_status_id, $customer_status_list )  ) {	 // one add
				$notify = true;  // one add
			}  // one add
			
			if ( $order_info['payment_code'] == 'cod' && $order_status_id == '1' )  {  // bank to cod support @ 10/11/2016 by one
				$order_status_id = '2';
			}

			//if ( (strpos( $order_info['payment_code'] , 'bank') >= 0) && $order_status_id == '2' )  {  // cod to bank support @ 10/11/2016 by one
			//	$order_status_id = '1';
			//}				

			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

			//$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify. "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . 
			(int)$order_status_id . "', notify = '" . (int)$notify. "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()"
			. " , user_id='".(int)$v_user_id . "' "			);
			
			// one add - begin @ 20160519
			if ( ( $order_status_id == '3') || ( $order_status_id == '29') || ( $order_status_id == '21') ||( $order_status_id == '24') ) {  // one add
				if ( $order_info['payment_code'] == 'cod' )  {
					$this->db->query("UPDATE `" . DB_PREFIX . "order` SET date_shipped = NOW() , date_paid = NOW() WHERE order_id = '" . (int)$order_id . "'");	
 				} else {
 					$this->db->query("UPDATE `" . DB_PREFIX . "order` SET  date_shipped = NOW() WHERE order_id = '" . (int)$order_id . "'");	
 				}
 			}
			// one add - end  @20160519
			
			if ($order_status_id == '15') { // one add
				$invoice_no = $this->createInvoiceNo($order_id); // one add
			}



			// one add - begin log
//				$log = new Log('smsdebug201609.log');
				//$log->write( $order_id . '(Mail) order_info[order_status_id] = ' . $order_info['order_status_id'] .' , order_status_id = ' . $order_status_id   .' , notify = ' . $notify  );
//				$log->write( "user = " . $v_user_id );

			// one add - begin: query affiliate name, email 				
			$affiliate_query = $this->db->query("SELECT a.firstname, a.email, a.address_1, a.city, b.name, b.code FROM oc_affiliate a, oc_zone b where a.zone_id=b.zone_id and a.country_id=b.country_id and a.affiliate_id=" . $order_info['affiliate_id'] );
			if ($affiliate_query->num_rows) {
					$affiliate_name = $affiliate_query->row['firstname'];
					$affiliate_email = $affiliate_query->row['email'];
					$affiliate_addr = $affiliate_query->row['address_1'] . ' ' . $affiliate_query->row['city'] . ' ' . $affiliate_query->row['name']  . ' ' . $affiliate_query->row['code'];
			}			
			$affiliate_status_list = array(15,2,16,27,3);
			$sms_status_list  = array(1,2,7,10,15,16,20,3);  //sms-1/8
			// one add - end: query affiliate name, email 

			// If current order status is not processing or complete but new status is processing or complete then commence completing the order
			if (!in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) && in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
				// Stock subtraction
				$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

				foreach ($order_product_query->rows as $order_product) {
					$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND subtract = '1'");

					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");

					foreach ($order_option_query->rows as $option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
					}
				}

				// Redeem coupon, vouchers and reward points
				$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");

				foreach ($order_total_query->rows as $order_total) {
					$this->load->model('total/' . $order_total['code']);

					if (method_exists($this->{'model_total_' . $order_total['code']}, 'confirm')) {
						$this->{'model_total_' . $order_total['code']}->confirm($order_info, $order_total);
					}
				}

				// Add commission if sale is linked to affiliate referral.
				if ($order_info['affiliate_id'] && $this->config->get('config_affiliate_auto')) {
					$this->load->model('affiliate/affiliate');

					$this->model_affiliate_affiliate->addTransaction($order_info['affiliate_id'], $order_info['commission'], $order_id);
				}
			}

			// If old order status is the processing or complete status but new status is not then commence restock, and remove coupon, voucher and reward history
			if (in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) && !in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
				// Restock
				$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

				foreach($product_query->rows as $product) {
					$this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");

					$option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

					foreach ($option_query->rows as $option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
					}
				}

				// Remove coupon, vouchers and reward points history
				$this->load->model('account/order');

				$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");

				foreach ($order_total_query->rows as $order_total) {
					$this->load->model('total/' . $order_total['code']);

					if (method_exists($this->{'model_total_' . $order_total['code']}, 'unconfirm')) {
						$this->{'model_total_' . $order_total['code']}->unconfirm($order_id);
					}
				}

				// Remove commission if sale is linked to affiliate referral.
				if ($order_info['affiliate_id']) {
					$this->load->model('affiliate/affiliate');

					$this->model_affiliate_affiliate->deleteTransaction($order_id);
				}
			}

			$this->cache->delete('product');


			// If order status is 0 then becomes greater than 0 send main html email
			//$log->write( $order_id . '(Mail) if admin = bef : ' . $order_info['order_status_id'] . ', '.$order_status_id ); // one add			
			if (!$order_info['order_status_id'] && $order_status_id) {
				//$log->write( $order_id . '(Mail) if admin = true = ' . $order_info['order_status_id'] . ', '.$order_status_id ); // one add			
				// Check for any downloadable products
				$download_status = false;

				// remark for reduce process --- one remark @ 2016-0404  -- begin
				//nid open 20160408 15:10
				$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

				//foreach ($order_product_query->rows as $order_product) {
				//	// Check if there are any linked downloads
				//	$product_download_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_to_download` WHERE product_id = '" . (int)$order_product['product_id'] . "'");

				//	if ($product_download_query->row['total']) {
				//		$download_status = true;
				//	}
				//} // foreach
				// remark for reduce process --- one remark @ 2016-0404  -- end

				// Load the language for any mails that might be required to be sent out
				$language = new Language($order_info['language_directory']);
				$language->load($order_info['language_directory']);
				$language->load('mail/order');

				$order_status_query1 = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

				if ($order_status_query1->num_rows) {
					$order_status = $order_status_query1->row['name'];
				} else {
					$order_status = '';
				}

				$subject = sprintf($language->get('text_new_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

				// HTML Mail
				$data = array();

				$data['title'] = sprintf($language->get('text_new_subject'), $order_info['store_name'], $order_id);

				$data['text_greeting'] = sprintf($language->get('text_new_greeting'), $order_info['store_name']);
				$data['text_link'] = $language->get('text_new_link');
				$data['text_download'] = $language->get('text_new_download');
				$data['text_order_detail'] = $language->get('text_new_order_detail');
				$data['text_instruction'] = $language->get('text_new_instruction');
				$data['text_order_id'] = $language->get('text_new_order_id');
				$data['text_date_added'] = $language->get('text_new_date_added');
				$data['text_payment_method'] = $language->get('text_new_payment_method');
				$data['text_shipping_method'] = $language->get('text_new_shipping_method');
				$data['text_email'] = $language->get('text_new_email');
				$data['text_telephone'] = $language->get('text_new_telephone');
				$data['text_ip'] = $language->get('text_new_ip');
				$data['text_order_status'] = $language->get('text_new_order_status');
				$data['text_payment_address'] = $language->get('text_new_payment_address');
				$data['text_shipping_address'] = $language->get('text_new_shipping_address');
				$data['text_product'] = $language->get('text_new_product');
				$data['text_model'] = $language->get('text_new_model');
				$data['text_quantity'] = $language->get('text_new_quantity');
				$data['text_price'] = $language->get('text_new_price');
				$data['text_total'] = $language->get('text_new_total');
				$data['text_footer'] = $language->get('text_new_footer');

				//$data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
				$data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_icon');
				
				$data['store_name'] = $order_info['store_name'];
				$data['store_url'] = $order_info['store_url'];
				$data['customer_id'] = $order_info['customer_id'];
				$data['link'] = ''; //$order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id;

				if ($download_status) {
					$data['download'] = $order_info['store_url'] . 'index.php?route=account/download';
				} else {
					$data['download'] = '';
				}

				$data['order_id'] = $order_id;
				$data['date_added'] = date($language->get('date_format_short'), strtotime($order_info['date_added']));
				$data['payment_method'] = $order_info['payment_method'];
				$data['shipping_method'] = $order_info['shipping_method'];
				$data['email'] = $order_info['email'];
				$data['telephone'] = $order_info['telephone'];
				$data['ip'] = $order_info['ip'];
				$data['order_status'] = $order_status;

				//if ($comment && $notify) {
				if ($comment || $notify) { // one modify 17/03/2016
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

				$this->load->model('tool/upload');

				// Products
				$data['products'] = array();


						

				foreach ($order_product_query->rows as $product) {
					
					//$option_text1 .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";  // one add
					//$option_text2 .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";  // one add
					
					$option_data = array();

					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");					
					foreach ($order_option_query->rows as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

							if ($upload_info) {
								$value = $upload_info['name'];
							} else {
								$value = '';
							}
							//$value2 = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.')); // one add							
						}
						
						//$option_text1 .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value) . "\n";  // one add 
						//$option_text2 .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($value2) > 20 ? utf8_substr($value2, 0, 20) . '..' : $value2) . "\n";  // one add 

						$option_data[] = array(
							'name'  => $option['name'],
							'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
						);
					}
					

					$data['products'][] = array(
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				// Vouchers
				$data['vouchers'] = array();

				$order_voucher_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

				foreach ($order_voucher_query->rows as $voucher) {
					$data['vouchers'][] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
					);
				}

				// Order Totals
				$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");

				foreach ($order_total_query->rows as $total) {
					$data['totals'][] = array(
						'title' => $total['title'],
						'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
					);
				}

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/order.tpl')) {
					$html = $this->load->view($this->config->get('config_template') . '/template/mail/order.tpl', $data);
				} else {
					$html = $this->load->view('default/template/mail/order.tpl', $data);
				}

				// Can not send confirmation emails for CBA orders as email is unknown
				//$this->load->model('payment/amazon_checkout');

				//if (!$this->model_payment_amazon_checkout->isAmazonOrder($order_info['order_id']) && 
				//if  ( $order_status_id == '1' )  {	// one add // subject of mail = order number
				if  ( $order_status_id == '1' || $order_status_id == '2' )  {	// one add // subject of mail = order number

					// Text Mail
					$text  = sprintf($language->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8')) . "\n\n";
					$text .= $language->get('text_new_order_id') . ' ' . $order_id . "\n";
					$text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
					$text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";

					//if ($comment && $notify) {  // one modify 17/03/2016
					if ($comment || $notify) {  // one modify 17/03/2016
						$text .= $language->get('text_new_instruction') . "\n\n";
						$text .= $comment . "\n\n";
					}

					// Products
					$text .= $language->get('text_new_products') . "\n";
					
					foreach ($order_product_query->rows as $product) {
						$text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";						
						$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $product['order_product_id'] . "'");
						foreach ($order_option_query->rows as $option) {
							if ($option['type'] != 'file') {
								$value = $option['value'];
							} else {
								$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);
								if ($upload_info) {
									$value = $upload_info['name'];
								} else {
									$value = '';
								}
							}
							$text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value) . "\n";
						}  // foreach						
					}
					
					//$text .= $option_text1;  // one add

					foreach ($order_voucher_query->rows as $voucher) {
						$text .= '1x ' . $voucher['description'] . ' ' . $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
					}

					$text .= "\n";

					$text .= $language->get('text_new_order_total') . "\n";

					foreach ($order_total_query->rows as $total) {
						$text .= $total['title'] . ': ' . html_entity_decode($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
					}

					$text .= "\n";

					//if ($order_info['customer_id']) {
						//$text .= $language->get('text_new_link') . "\n";
						//$text .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";
					//}

					if ($download_status) {
						$text .= $language->get('text_new_download') . "\n";
						$text .= $order_info['store_url'] . 'index.php?route=account/download' . "\n\n";
					}

					// Comment
					if ($order_info['comment']) {
						$text .= $language->get('text_new_comment') . "\n\n";
						$text .= $order_info['comment'] . "\n\n";
					}

					$text .= $language->get('text_new_footer') . "\n\n";

					$mail = new Mail();
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
					$mail->smtp_username = $this->config->get('config_mail_smtp_username');
					$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port = $this->config->get('config_mail_smtp_port');
					$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

					$mail->setTo($order_info['email']);
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
					$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
					$mail->setHtml($html);
					$mail->setText($text);
					$mail->send();
				}  //if  ( $order_status_id == '1' )  {	// one add


				

                //for Marketplace management
                if ($this->config->get('marketplace_status')){
                   $this->load->model('account/customerpartnerorder');
                   $this->model_account_customerpartnerorder->customerpartner($order_info,$order_status, $comment);
                }
            
				// Admin Alert Mail	
				$conf_order_mail = $this->config->get('config_order_mail');  // one add
				//$log->write( $order_id . '(Mail) config_order_mail = bef : ' . $conf_order_mail ); // one add

                //for Marketplace management
                if ($this->config->get('marketplace_status')){
                   $this->load->model('account/customerpartnerorder');
                   $this->model_account_customerpartnerorder->customerpartner($order_info,$order_status, $comment);
                }
            
				//if ($this->config->get('config_order_mail')) {  // Admin Alert Mail // one add
				if ( $conf_order_mail ) { // one add
					$subject = sprintf($language->get('text_new_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_id);

					// HTML Mail
					$data['text_greeting'] = $language->get('text_new_received');

					if ($comment) {
						if ($order_info['comment']) {
							$data['comment'] = nl2br($comment) . '<br/><br/>' . $order_info['comment'];
						} else {
							$data['comment'] = nl2br($comment);
						}
					} else {
						if ($order_info['comment']) {
							$data['comment'] = $order_info['comment'];
						} else {
							$data['comment'] = '';
						}
					}

					$data['text_download'] = '';

					$data['text_footer'] = '';

					$data['text_link'] = '';
					$data['link'] = '';
					$data['download'] = '';

					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/order.tpl')) {
						$html = $this->load->view($this->config->get('config_template') . '/template/mail/order.tpl', $data);
					} else {
						$html = $this->load->view('default/template/mail/order.tpl', $data);
					}

					// Text
					$text  = $language->get('text_new_received') . "\n\n";
					$text .= $language->get('text_new_order_id') . ' ' . $order_id . "\n";
					$text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
					$text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";
					$text .= $language->get('text_new_products') . "\n";
										
					foreach ($order_product_query->rows as $product) {
						$text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";

						$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $product['order_product_id'] . "'");
						foreach ($order_option_query->rows as $option) {
							if ($option['type'] != 'file') {
								$value = $option['value'];
							} else {
								$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
							}
							$text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value) . "\n";
						}
					}
					
					//$text .= $option_text2;  // one add

					foreach ($order_voucher_query->rows as $voucher) {
						$text .= '1x ' . $voucher['description'] . ' ' . $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
					}

					$text .= "\n";

					$text .= $language->get('text_new_order_total') . "\n";

					foreach ($order_total_query->rows as $total) {
						$text .= $total['title'] . ': ' . html_entity_decode($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
					}

					$text .= "\n";

					if ($order_info['comment']) {
						$text .= $language->get('text_new_comment') . "\n\n";
						$text .= $order_info['comment'] . "\n\n";
					}

					$mail = new Mail();
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
					$mail->smtp_username = $this->config->get('config_mail_smtp_username');
					$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port = $this->config->get('config_mail_smtp_port');
					$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

					$mail->setTo($this->config->get('config_email'));
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
					$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
					$mail->setHtml($html);
					$mail->setText($text);
					$mail->send();

					// Send to additional alert emails
					// one add - begin : apply to send mail to affiliate  
					//print $order_status_id;
					//print_r $affiliate_status_list;
					//$log->write( $order_id . '(Mail) in array aff  = bef : ' . $order_status_id );
					if (in_array( $order_status_id, $affiliate_status_list) ) {  
						//$log->write( $order_id . '(Mail) in array aff  = true = ' . $order_status_id );
						$emails = explode(',', $affiliate_email);

						//$emails = explode(',', $this->config->get('config_mail_alert'));  // one add
	
						foreach ($emails as $email) {
							if ($email && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
								$mail->setTo($email);
								$mail->send();
							}
						} // for each
					} //if (in_array($order_status_id, $affiliate_status_list) ) 
					// one add - end : apply to send mail to affiliate 
						

                //for Marketplace management
                if ($this->config->get('marketplace_status')){
                   $this->load->model('account/customerpartnerorder');
                   $this->model_account_customerpartnerorder->customerpartner($order_info,$order_status, $comment);
                }
            
				}  //if ($this->config->get('config_order_mail')) {  // Admin Alert Mail
				
			}  //if (!$order_info['order_status_id'] && $order_status_id) {
			
			// If order status is not 0 then send update text email
			// mail to customer	// one add					
			//$log->write( $order_id . '(** ) in array cust  = bef : ' . $order_status_id . ' - ' .$order_info['order_status_id']);	
			//if ($order_info['order_status_id'] && $order_status_id && $notify) {  // original
			//if ($order_status_id && $notify) {  // one add				
			//if  ( ($order_info['order_status_id'] && $order_status_id) || $notify) {  // one modify 17/03/2016			
			if  ( $order_status_id || $notify) {  // one modify 22/04/2016			
			   //$log->write( $order_id . '(*** ) in array cust  = bef : ' . $order_status_id . ' - ' .$order_info['order_status_id']);	
			  //if ( in_array( $order_status_id, $customer_status_list ) ) {	// one add			  
			  if ( in_array( $order_status_id, $customer_status_list ) || $notify) {	// one add			  
			  	 
				  	//$log->write( $order_id . '(Mail) in array cust  = true = ' . $order_status_id );				  	
					$language = new Language($order_info['language_directory']);
					$language->load($order_info['language_directory']);
					$language->load('mail/order');
	
					$subject = sprintf($language->get('text_update_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);
	
					$message  = $language->get('text_update_order') . ' ' . $order_id . "\n";					
					$message .= $language->get('text_update_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";
	
					//sms - add by one - begin1  //sms-2/8
					//$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");					
					
					// -- wrong if orcer entry via backoffice with no customer first (like guest) -- one mo @ 12/07/2016 -begin 
					//$order_status_query = $this->db->query(
					//		"select a.value msg, c.mobile, c.informtype, b.short_url, round(b.total,0) baht, d.name, d.order_status_id  from oc_setting a, oc_order b, oc_customer c, oc_order_status d ".
					//		"where b.payment_code=a.code and b.customer_id=c.customer_id and d.order_status_id=b.order_status_id and d.language_id= '" . (int)$order_info['language_id'] . "' ".
					//		"and a.key=concat(a.code,'_bank1') and b.order_id= '" . (int)$order_id . "' "  );
					$order_status_query = $this->db->query(
							"select a.value msg, IFNULL(c.mobile, '0') mobile, IFNULL(c.informtype, 'E') informtype, b.short_url, round(b.total,0) baht, d.name, d.order_status_id  from oc_setting a, oc_order_status d, oc_order b  LEFT JOIN oc_customer c ON b.customer_id=c.customer_id  " . 
							"where b.payment_code=a.code and d.order_status_id=b.order_status_id and d.language_id= '" . (int)$order_info['language_id'] . "' ".
							"and a.key=concat(a.code,'_bank1') and b.order_id= '" . (int)$order_id . "' "  );
							
					// -- wrong if orcer entry via backoffice with no customer first (like guest) -- one mo @ 12/07/2016 -end							
					//} else {	// one add 22/04/2016  // status_id =2					 
					//	$order_status_query = $this->db->query(
					//		"select c.mobile, c.informtype, b.short_url, round(b.total,0) baht, d.name, d.order_status_id  from oc_order b, oc_customer c, oc_order_status d ".
					//		"where b.customer_id=c.customer_id and d.order_status_id=b.order_status_id and d.language_id= '" . (int)$order_info['language_id'] . "' ".
					//		"and  b.order_id= '" . (int)$order_id . "' "  );
					//}
					//sms - add by one - end2
					
					
					if ($order_status_query->num_rows) {
						
                    if(isset($toAdmin) && $toAdmin) {
                        $message .= $language->get('text_update_order_status_admin') . "\n\n";
                    } else {
                        $message .= $language->get('text_update_order_status') . "\n\n";
                    }
            
						$message .= $order_status_query->row['name'] . "\n\n";
						
						//sms : prepare - add by one - begin2  //sms-3/8
						$vani = $order_status_query->row['mobile'];
						$vinformtype = $order_status_query->row['informtype'];
						//$log->write( '2'. $order_id . '(SMS) with  '.$vinformtype.' to ' . $vani  );
						if ($order_status_id =='1' && $vinformtype=='S' && strlen($vani)>=9 ) {
							if (substr($vani,0,1)=='0') {
								$vani = '66' . substr($vani,1,9);
							} else {
								$vani = '66' . $vani;
							}
							$vmsg =  $order_status_query->row['msg'];  
							$vmsg = str_replace('%O', $order_id, $vmsg);
							$vmsg = str_replace('%B', $order_status_query->row['baht'], $vmsg);
							
						}elseif ($order_status_id =='2' && $vinformtype=='S' && strlen($vani)>=9 ) { // one add
							if (substr($vani,0,1)=='0') {
								$vani = '66' . substr($vani,1,9);
							} else {
								$vani = '66' . $vani;
							}							
							$vstr =  substr( $order_status_query->row['msg'], 0, strpos($order_status_query->row['msg'],'%O') );  							
							$vmsg =  $vstr . $order_id . ' ' .$order_status_query->row['name'] .' '. $order_status_query->row['short_url']; 
							
						} else {
							$vstr =  substr( $order_status_query->row['msg'], 0, strpos($order_status_query->row['msg'],'%O') );  							
							$vmsg =  $vstr . $order_id . ' ' .$order_status_query->row['name'] .' '. $order_status_query->row['short_url']; 
						}
						//sms : prepare - add by one - end2
					}
	
					if ($order_info['customer_id']) {

                    if(isset($toAdmin) && !$toAdmin) {
            
						$message .= $language->get('text_update_link') . "\n";
						//$message .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";

                    }
            
						$message .= $order_status_query->row['short_url']  . "\n\n";						
					}
					
	
					if ($comment) {
						
                    if(isset($toAdmin) && $toAdmin) {
                        $message .= $language->get('text_update_comment_admin') . "\n\n";
                    } else {
                        $message .= $language->get('text_update_comment') . "\n\n";
                    }
            
						$message .= strip_tags($comment) . "\n\n";
					}
	
					$message .= $language->get('text_update_footer');
					
					//sms send - add by one - begin3 //sms-4/8
					//$log->write( '*3'. $order_status_id . '-  '.$vinformtype.' to ' . $vani . ' : ' . $vmsg );			  			
					if ( (in_array( $order_status_id, $sms_status_list ) || $notify )&& strlen( $vani )>=10 && $vinformtype=='S' && $order_info['order_status_id'] !== $order_status_id ){ // one add @31/5/2016
			  			//$log->write( '3'. $order_id . '(SMS) with  '.$vinformtype.' to ' . $vani . ' : ' . $vmsg );			  			
						$resdata = $this->sendSMS( $vani, $vmsg );
						//$log->write( '*'. $order_id . '(SMS) ['.$vinformtype.']=>' . $vani . '=>' . $vmsg .'=//=' .$resdata );
			  		 } //else {
			  		//sms send  - add by one - end3
			  					  							
						// begin mail 
						$mail = new Mail();
						$mail->protocol = $this->config->get('config_mail_protocol');
						$mail->parameter = $this->config->get('config_mail_parameter');
						$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
						$mail->smtp_username = $this->config->get('config_mail_smtp_username');
						$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
						$mail->smtp_port = $this->config->get('config_mail_smtp_port');
						$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
		
						$mail->setTo($order_info['email']);
						$mail->setFrom($this->config->get('config_email'));
						$mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
						$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
						$mail->setText($message);
						$mail->send();
						// end mail 
						
					//} // end if informtype
			  } //if ( in_array($order_status_id, $customer_status_list) ){ // one add
			}

			// If order status in the complete range create any vouchers that where in the order need to be made available.
			if (in_array($order_info['order_status_id'], $this->config->get('config_complete_status'))) {
				// Send out any gift voucher mails
				$this->load->model('checkout/voucher');

				$this->model_checkout_voucher->confirm($order_id);
			}
		}

		$this->event->trigger('post.order.history.add', $order_id);
	}


//  $order_status_id = current update status,  $order_info['order_status_id'] = previous status
	// this function created for affiliate/order.php 
	public function updateOrderStatus($order_id, $order_status_id, $comment = '',$affiliate_id ='', $notify =false) {
		//$this->event->trigger('pre.order.history.add', $order_id);

		$order_info = $this->getOrder($order_id);

		if ($order_info) {
			if ( ( $order_status_id == '3') || ( $order_status_id == '29') || ( $order_status_id == '21') ||( $order_status_id == '24') ) {  // one add				
				//$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW(),date_shipped = NOW() WHERE order_id = '" . (int)$order_id . "'");	 // one remark @ 20160519
				// one add - begin @ 20160519
				if ( $order_info['payment_code'] == 'cod' )  {
					$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW(),date_shipped = NOW(), date_paid = NOW() WHERE order_id = '" . (int)$order_id . "'");	
 				} else {
 					$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW(),date_shipped = NOW() WHERE order_id = '" . (int)$order_id . "'");	
 				}
 				// one add - end @ 20160519
			}else{
				$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");	
			}		
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify  . "', affiliate_id = '" . (int)$affiliate_id . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

			// one add - begin log
				//$log = new Log('smsdebug_up.log');
				//$log->write( $order_id . '(updateOrderStatus) order_info[order_status_id] = ' . $order_info['order_status_id'] );
				//$log->write( $order_id . '(updateOrderStatus) order_status_id = ' . $order_status_id  ); 
				//$log->write( $order_id . '(updateOrderStatus) notify = ' . $notify  );
				//$log->write( $order_id . '(updateOrderStatus) config_order_mail = ' . $this->config->get('config_order_mail') ); 
			// one add - begin log
			
			// one add - begin: query affiliate name, email 				
			$affiliate_query = $this->db->query("SELECT a.firstname, a.email, a.address_1, a.city, b.name, b.code  FROM oc_affiliate a, oc_zone b where a.zone_id=b.zone_id and a.country_id=b.country_id and a.affiliate_id=" . $order_info['affiliate_id'] );
			if ($affiliate_query->num_rows) {
					$affiliate_name = $affiliate_query->row['firstname'];
					$affiliate_email = $affiliate_query->row['email'];
					$affiliate_addr = $affiliate_query->row['address_1'] . ' ' . $affiliate_query->row['city'] . ' ' . $affiliate_query->row['name']  . ' ' . $affiliate_query->row['code'];
			}
			//$customer_status_list = array(1,7,10,15,14,16,19,20,3);
			$customer_status_list = array(1,2,7,10,15,16,20,3);
			$affiliate_status_list = array(15,2,16,27,3);
			$sms_status_list  = array(1,2,7,10,15,16,20,3);  //sms-5/8
			// one add - end: query affiliate name, email 

			// If current order status is not processing or complete but new status is processing or complete then commence completing the order
			if (!in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) && in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
			//if ( $order_info['order_status_id'] == '15' && $order_status_id == '19') {
				// Stock subtraction
				$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

				foreach ($order_product_query->rows as $order_product) {
					$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND subtract = '1'");

					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");

					foreach ($order_option_query->rows as $option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
					}
				}

				// Redeem coupon, vouchers and reward points
				$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");

				foreach ($order_total_query->rows as $order_total) {
					$this->load->model('total/' . $order_total['code']);

					if (method_exists($this->{'model_total_' . $order_total['code']}, 'confirm')) {
						$this->{'model_total_' . $order_total['code']}->confirm($order_info, $order_total);
					}
				}

				// Add commission if sale is linked to affiliate referral.
				if ($order_info['affiliate_id'] && $this->config->get('config_affiliate_auto') &&  $order_status_id == '3') {
					$this->load->model('affiliate/affiliate');

					$this->model_affiliate_affiliate->addTransaction($order_info['affiliate_id'], $order_info['commission'], $order_id);
				}
			}

			// If old order status is the processing or complete status but new status is not then commence restock, and remove coupon, voucher and reward history
			if (in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) && !in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
			//if ( $order_status_id == '27') {
				// Restock
				$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

				foreach($product_query->rows as $product) {
					$this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");

					$option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

					foreach ($option_query->rows as $option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
					}
				}

				// Remove coupon, vouchers and reward points history
				$this->load->model('account/order');

				$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");

				foreach ($order_total_query->rows as $order_total) {
					$this->load->model('total/' . $order_total['code']);

					if (method_exists($this->{'model_total_' . $order_total['code']}, 'unconfirm')) {
						$this->{'model_total_' . $order_total['code']}->unconfirm($order_id);
					}
				}

				// Remove commission if sale is linked to affiliate referral.
				// if ($order_info['affiliate_id']) {
				if ($order_info['affiliate_id'] && $order_status_id == '27') {
					$this->load->model('affiliate/affiliate');

					$this->model_affiliate_affiliate->deleteTransaction($order_id);
				}
			}

			$this->cache->delete('product');


			// If order status is 0 then becomes greater than 0 send main html email
			//if (!$order_info['order_status_id'] && $order_status_id) {
			if ( $order_status_id ) {			
				//$log->write( $order_id . '(updateOrderStatus) if admin = true = ' . $order_info['order_status_id'] . ', '.$order_status_id ); // one add			
				// Check for any downloadable products
				$download_status = false;
				$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

				foreach ($order_product_query->rows as $order_product) {
					// Check if there are any linked downloads
					$product_download_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_to_download` WHERE product_id = '" . (int)$order_product['product_id'] . "'");

					if ($product_download_query->row['total']) {
						$download_status = true;
					}
				}

				// Load the language for any mails that might be required to be sent out
				$language = new Language($order_info['language_directory']);
				$language->load($order_info['language_directory']);
				$language->load('mail/order');
				
				//sms - add by one - begin1 //sms-6/8
				//$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");
				
				$order_status_query = $this->db->query(
					"select a.value msg, c.mobile, c.informtype, b.short_url, round(b.total,0) baht, d.name, d.order_status_id  from oc_setting a, oc_order b, oc_customer c, oc_order_status d ".
					"where b.payment_code=a.code and b.customer_id=c.customer_id and d.order_status_id=b.order_status_id and d.language_id= '" . (int)$order_info['language_id'] . "' ".
					"and a.key=concat(a.code,'_bank1') and b.order_id= '" . (int)$order_id . "' "  );
					
				//sms - add by one - end2
				

				if ($order_status_query->num_rows) {
					$order_status = $order_status_query->row['name'];
					
					//sms : prepare - add by one - begin2  // //sms-7/8
					$vani = $order_status_query->row['mobile'];
					$vinformtype = $order_status_query->row['informtype'];
					$vshorturl = $order_status_query->row['short_url'];
					//$log->write( '2'. $order_id . '(SMS) with  '.$vinformtype.' to ' . $vani  );
					if ($order_status_id =='1' && $vinformtype=='S' && strlen($vani)>=9 ) {
						if (substr($vani,0,1)=='0') {
							$vani = '66' . substr($vani,1,9);
						} else {
							$vani = '66' . $vani;
						}
						$vmsg =  $order_status_query->row['msg'];  
						$vmsg = str_replace('%O', $order_id, $vmsg);
						$vmsg = str_replace('%B', $order_status_query->row['baht'], $vmsg);

					}elseif ($order_status_id =='2' && $vinformtype=='S' && strlen($vani)>=9 ) { // one add
						if (substr($vani,0,1)=='0') {
							$vani = '66' . substr($vani,1,9);
						} else {
							$vani = '66' . $vani;
						}													
						$vstr =  substr( $order_status_query->row['msg'], 0, strpos($order_status_query->row['msg'],'%O') );  							
						$vmsg =  $vstr . $order_id . ' ' .$order_status_query->row['name'] . ' ' . $order_status_query->row['short_url'];
						
					} else {
						$vstr =  substr( $order_status_query->row['msg'], 0, strpos($order_status_query->row['msg'],'%O') );  							
						$vmsg =  $vstr . $order_id . ' ' .$order_status_query->row['name'] . ' ' . $order_status_query->row['short_url'];
					}
					//sms : prepare - add by one - end2
					
				} else {
					$order_status = '';
				}

				//sms send - add by one - begin3 //sms-8/8
				if ( in_array( $order_status_id, $sms_status_list ) && strlen( $vani )>=10 && $vinformtype=='S' 
					&& $order_info['order_status_id'] !== $order_status_id ){ // one add @31/5/2016
		  			//$log->write( '3'. $order_id . '(SMS) with  '.$vinformtype.' to ' . $vani . ' : ' . $vmsg );			  			
					$resdata = $this->sendSMS( $vani, $vmsg );
					//$log->write( '*-Update-* '. $order_id . '(SMS) ['.$vinformtype.']=>' . $vani . '=>' . $vmsg .'=' .$resdata );
		  		 } //else {
		  		//sms send  - add by one - end3

				$subject = sprintf($language->get('text_new_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

				// HTML Mail
				$data = array();

				$data['title'] = sprintf($language->get('text_new_subject'), $order_info['store_name'], $order_id);

				$data['text_greeting'] = sprintf($language->get('text_new_greeting'), $order_info['store_name']);
				$data['text_link'] = $language->get('text_new_link');
				$data['text_download'] = $language->get('text_new_download');
				$data['text_order_detail'] = $language->get('text_new_order_detail');
				$data['text_instruction'] = $language->get('text_new_instruction');
				$data['text_order_id'] = $language->get('text_new_order_id');
				$data['text_date_added'] = $language->get('text_new_date_added');
				$data['text_payment_method'] = $language->get('text_new_payment_method');
				$data['text_shipping_method'] = $language->get('text_new_shipping_method');
				$data['text_email'] = $language->get('text_new_email');
				$data['text_telephone'] = $language->get('text_new_telephone');
				$data['text_ip'] = $language->get('text_new_ip');
				$data['text_order_status'] = $language->get('text_new_order_status');
				$data['text_payment_address'] = $language->get('text_new_payment_address');
				$data['text_shipping_address'] = $language->get('text_new_shipping_address');
				$data['text_product'] = $language->get('text_new_product');
				$data['text_model'] = $language->get('text_new_model');
				$data['text_quantity'] = $language->get('text_new_quantity');
				$data['text_price'] = $language->get('text_new_price');
				$data['text_total'] = $language->get('text_new_total');
				$data['text_footer'] = $language->get('text_new_footer');

				//$data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
				$data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_icon');
				
				$data['store_name'] = $order_info['store_name'];
				$data['store_url'] = $order_info['store_url'];
				$data['customer_id'] = $order_info['customer_id'];
				$data['link'] = $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id;

				if ($download_status) {
					$data['download'] = $order_info['store_url'] . 'index.php?route=account/download';
				} else {
					$data['download'] = '';
				}

				$data['order_id'] = $order_id;
				$data['date_added'] = date($language->get('date_format_short'), strtotime($order_info['date_added']));
				$data['payment_method'] = $order_info['payment_method'];
				$data['shipping_method'] = $order_info['shipping_method'];
				$data['email'] = $order_info['email'];
				$data['telephone'] = $order_info['telephone'];
				$data['ip'] = $order_info['ip'];
				$data['order_status'] = $order_status;

				if ($comment && $notify) {
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

				$this->load->model('tool/upload');

				// Products
				$data['products'] = array();

				foreach ($order_product_query->rows as $product) {
					$option_data = array();

					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

					foreach ($order_option_query->rows as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

							if ($upload_info) {
								$value = $upload_info['name'];
							} else {
								$value = '';
							}
						}

						$option_data[] = array(
							'name'  => $option['name'],
							'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
						);
					}

					$data['products'][] = array(
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				// Vouchers
				$data['vouchers'] = array();

				$order_voucher_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

				foreach ($order_voucher_query->rows as $voucher) {
					$data['vouchers'][] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
					);
				}

				// Order Totals
				$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");

				foreach ($order_total_query->rows as $total) {
					$data['totals'][] = array(
						'title' => $total['title'],
						'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
					);
				}

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/order.tpl')) {
					$html = $this->load->view($this->config->get('config_template') . '/template/mail/order.tpl', $data);
				} else {
					$html = $this->load->view('default/template/mail/order.tpl', $data);
				}
				

                //for Marketplace management
                if ($this->config->get('marketplace_status')){
                   $this->load->model('account/customerpartnerorder');
                   $this->model_account_customerpartnerorder->customerpartner($order_info,$order_status, $comment);
                }
            
				// Admin Alert Mail	

                //for Marketplace management
                if ($this->config->get('marketplace_status')){
                   $this->load->model('account/customerpartnerorder');
                   $this->model_account_customerpartnerorder->customerpartner($order_info,$order_status, $comment);
                }
            
				if ($this->config->get('config_order_mail')) {  // Admin Alert Mail // one add				
					$subject = sprintf($language->get('text_new_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_id);

					// HTML Mail
					$data['text_greeting'] = $language->get('text_new_received');

					if ($comment) {
						if ($order_info['comment']) {
							$data['comment'] = nl2br($comment) . '<br/><br/>' . $order_info['comment'];
						} else {
							$data['comment'] = nl2br($comment);
						}
					} else {
						if ($order_info['comment']) {
							$data['comment'] = $order_info['comment'];
						} else {
							$data['comment'] = '';
						}
					}

					$data['text_download'] = '';

					$data['text_footer'] = '';

					$data['text_link'] = '';
					$data['link'] = '';
					$data['download'] = '';

					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/order.tpl')) {
						$html = $this->load->view($this->config->get('config_template') . '/template/mail/order.tpl', $data);
					} else {
						$html = $this->load->view('default/template/mail/order.tpl', $data);
					}

					// Text
					$text  = $language->get('text_new_received') . "\n\n";
					$text .= $language->get('text_new_order_id') . ' ' . $order_id . "\n";
					$text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
					$text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";
					$text .= $language->get('text_new_products') . "\n";

					foreach ($order_product_query->rows as $product) {
						$text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";

						$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $product['order_product_id'] . "'");

						foreach ($order_option_query->rows as $option) {
							if ($option['type'] != 'file') {
								$value = $option['value'];
							} else {
								$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
							}

							$text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value) . "\n";
						}
					}

					foreach ($order_voucher_query->rows as $voucher) {
						$text .= '1x ' . $voucher['description'] . ' ' . $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
					}

					$text .= "\n";

					$text .= $language->get('text_new_order_total') . "\n";

					foreach ($order_total_query->rows as $total) {
						$text .= $total['title'] . ': ' . html_entity_decode($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
					}

					$text .= "\n";

					if ($order_info['comment']) {
						$text .= $language->get('text_new_comment') . "\n\n";
						$text .= $order_info['comment'] . "\n\n";
					}

					$mail = new Mail();
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
					$mail->smtp_username = $this->config->get('config_mail_smtp_username');
					$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port = $this->config->get('config_mail_smtp_port');
					$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

					$mail->setTo($this->config->get('config_email'));
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
					$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
					$mail->setHtml($html);
					$mail->setText($text);
					$mail->send();

					// Send to additional alert emails
					if (in_array( $order_status_id, $affiliate_status_list) ) {  
						//$log->write( $order_id . '(updateOrderStatus) in array aff  = true = ' . $order_status_id );
						$emails = explode(',', $affiliate_email);

						//$emails = explode(',', $this->config->get('config_mail_alert'));  // one add
	
						foreach ($emails as $email) {
							if ($email && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
								$mail->setTo($email);
								$mail->send();
							}
						} // for each
					} //if (in_array($order_status_id, $affiliate_status_list) ) 
					// one add - end : apply to send mail to affiliate 
						

                //for Marketplace management
                if ($this->config->get('marketplace_status')){
                   $this->load->model('account/customerpartnerorder');
                   $this->model_account_customerpartnerorder->customerpartner($order_info,$order_status, $comment);
                }
            
				}  //if ($this->config->get('config_order_mail')) {  // Admin Alert Mail
			}  //if (!$order_info['order_status_id'] && $order_status_id) {
			
			// mail to customer	
			//if ($order_info['order_status_id'] && $order_status_id && $notify) { 
			if ( in_array( $order_status_id, $customer_status_list ) ) {	// one add
			//if (  $order_status_id =='1'  ) {	// one add
			  	//$log->write( $order_id . '(updateOrderStatus) in array cust  = true = ' . $order_status_id );
			  	
				$language = new Language($order_info['language_directory']);
				$language->load($order_info['language_directory']);
				$language->load('mail/order');

				$subject = sprintf($language->get('text_update_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

				$message  = $language->get('text_update_order') . ' ' . $order_id . "\n";
				$message .= $language->get('text_update_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";

				$order_status_query1 = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

				if ($order_status_query1->num_rows) {
					
                    if(isset($toAdmin) && $toAdmin) {
                        $message .= $language->get('text_update_order_status_admin') . "\n\n";
                    } else {
                        $message .= $language->get('text_update_order_status') . "\n\n";
                    }
            
					$message .= $order_status_query1->row['name'] . "\n\n";
				}

				if ($order_info['customer_id']) {

                    if(isset($toAdmin) && !$toAdmin) {
            
					$message .= $language->get('text_update_link') . "\n";
					//$message .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";

                    }
            
					$message .= $vshorturl  . "\n\n";					
				}

				if ($comment) {
					
                    if(isset($toAdmin) && $toAdmin) {
                        $message .= $language->get('text_update_comment_admin') . "\n\n";
                    } else {
                        $message .= $language->get('text_update_comment') . "\n\n";
                    }
            
					$message .= strip_tags($comment) . "\n\n";
				}

				$message .= $language->get('text_update_footer');

				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($order_info['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setText($message);
				$mail->send();
			} //if ( in_array($order_status_id, $customer_status_list) ){ // one add
			

			// If order status in the complete range create any vouchers that where in the order need to be made available.
			if (in_array($order_info['order_status_id'], $this->config->get('config_complete_status'))) {
				// Send out any gift voucher mails
				$this->load->model('checkout/voucher');

				$this->model_checkout_voucher->confirm($order_id);
			}
		}

		//$this->event->trigger('post.order.history.add', $order_id);
	}  //updateOrderStatus
} // class
