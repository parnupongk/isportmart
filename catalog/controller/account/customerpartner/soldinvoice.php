<?php
class ControllerAccountCustomerpartnerSoldinvoice extends Controller {

	private $error = array();
	private $data = array();

	public function index() {

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/customerpartner/soldinvoice&order_id='.$this->request->get['order_id'], '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/customerpartner');
		$this->load->model('account/order');

		$this->data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();	
			
		if(!$this->data['chkIsPartner'])
			$this->response->redirect($this->url->link('account/account'));

		$this->language->load('account/customerpartner/soldinvoice');
		$this->document->setTitle($this->language->get('heading_title'));

      	$order_id = 0;

      	if(isset($this->request->get['order_id'])){
			$order_id = $this->request->get['order_id'];
		}

		$this->data['order_id'] = $order_id;
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_order_info'] = $this->language->get('text_order_info');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_order_status'] = $this->language->get('text_order_status');
		$this->data['text_order_date'] = $this->language->get('text_order_date');
		$this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$this->data['text_name'] = $this->language->get('text_name');
		$this->data['text_email'] = $this->language->get('text_email');
		$this->data['text_billing_address'] = $this->language->get('text_billing_address');
		$this->data['text_shipping_address'] = $this->language->get('text_shipping_address');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['entry_model'] = $this->language->get('entry_model');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['text_qty'] = $this->language->get('text_qty');
		$this->data['text_total_row'] = $this->language->get('text_total_row');
		$this->data['text_tracking_no'] = $this->language->get('text_tracking_no');
		$this->data['text_total_order'] = $this->language->get('text_total_order');
	
		$this->data['text_order_id'] = $this->language->get('text_order_id');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$this->data['text_telephone'] = $this->language->get('text_telephone');
		$this->data['text_fax'] = $this->language->get('text_fax');
		$this->data['text_website'] = $this->language->get('text_website');
		$this->data['text_print_invoice'] = $this->language->get('text_print_invoice');

		$this->data['errorPage'] = true;
		$this->data['direction'] = 'ltr';
		$this->data['lang'] = 'en';
		$this->data['base'] = HTTP_SERVER;

		$order_info = $this->model_account_customerpartner->getOrder($order_id);


		if($order_id AND $order_info){

			$this->data['errorPage'] = false;
			$this->data['name'] = $order_info['firstname'].' '.$order_info['lastname'];
			$this->data['email'] = $order_info['email'];

			if ($order_info['invoice_no']) {
				$this->data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$this->data['invoice_no'] = '';
			}
	
			$this->data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
			
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
			
			$this->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$this->load->model('account/address');
			$store_address = $this->model_account_address->getAddress($this->customer->getAddressId());
			$seller_details = $this->model_account_customerpartner->getProfile();

			$replace_store_address = array(
					'firstname' => $store_address['firstname'],
					'lastname' => $store_address['lastname'],
					'company' => $seller_details['companyname'],
					'address_1' => $store_address['address_1'],
					'address_2' => $store_address['address_2'],
					'city' => $store_address['city'],
					'postcode' => $store_address['postcode'],
					'zone' => $store_address['zone'],
					'zone_code' => $store_address['zone_code'],
					'country' => $store_address['country']
			);

			$formatted_store_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace_store_address, $format))));
      		$this->data['payment_method'] = $order_info['payment_method'];
			$order_info['store_address'] = $formatted_store_address;
			$order_info['store_email'] = $this->customer->getEmail();
			$order_info['store_fax'] = $this->customer->getFax();
			$order_info['store_telephone'] = $this->customer->getTelephone();
			$order_info['store_url'] = $this->url->link('customerpartner/profile&id='.$this->customer->getId());

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

			$this->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$this->data['shipping_method'] = $order_info['shipping_method'];
			
			$this->data['products'] = array();
			
			$products = $this->model_account_customerpartner->getSellerOrderProducts($order_id);

            $sub_total = 0;
            $sub_tax   = 0;
            $shipping  = 0;
      		foreach ($products as $product) {						
        						

        		$this->data['products'][] = array(
        			'product_id' => $product['product_id'],
          			'name'     => $product['name'],
          			'model'    => $product['model'],
          			'quantity' => $product['quantity'],
          			'option'   => $this->model_account_order->getOrderOptions($order_id,$product['order_product_id']),
          			'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					);

        		$sub_total += $product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0);
        		// $sub_tax   += $this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0;
      		}	
			
      		$this->data['totals'] = array();

      		$totals = $this->model_account_customerpartner->getOrderTotals($order_id);

      		if($totals AND isset($totals[0]['total'])){
      		    $this->data['totals']['sub_total'] = array(

      		    	'title' => 'SubTotal',
      		    	'text'  => $this->currency->format($sub_total, $order_info['currency_code'], $order_info['currency_value']),
      		    );

      		    if ($order_info['shipping_applied']) {
					
					$this->data['totals']['shipping']  = array(

						'title' => $order_info['shipping_method'],
						'text'  => $this->currency->format($order_info['shipping_applied'], $order_info['currency_code'], $order_info['currency_value']),
					);
					$shipping = $order_info['shipping_applied'];
				}

  		        // if ($sub_tax) {
  		        //  	$this->data['totals']['sub_tax'] = array(

  		        //  		'title' => 'Total Tax',
  		        //  		'text'  => $this->currency->format($sub_tax, $order_info['currency_code'], $order_info['currency_value']),
  		        //     );
  		        // }           			

				$this->data['totals']['total'] = array(

					   'title'  => 'Total',
					   'text'   => $this->currency->format($totals[0]['total']+$shipping, $order_info['currency_code'], $order_info['currency_value']),
			    );
			}
		    
		}
		
		$this->data['order'] = $order_info;

		$this->data['action'] = $this->url->link('account/customerpartner/soldinvoice&order_id='.$order_id, '', 'SSL');
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['back'] = $this->url->link('account/account', '', 'SSL');
   
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['column_right'] = $this->load->controller('common/column_right');
		$this->data['content_top'] = $this->load->controller('common/content_top');
		$this->data['content_bottom'] = $this->load->controller('common/content_bottom');
		$this->data['footer'] = $this->load->controller('common/footer');
		$this->data['header'] = $this->load->controller('common/header');
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/soldinvoice.tpl')) {
			$this->response->setOutput($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/soldinvoice.tpl' , $this->data));			
		} else {
			$this->response->setOutput($this->load->view('default/template/account/customerpartner/soldinvoice.tpl' , $this->data));
		}	
	}
}
?>
