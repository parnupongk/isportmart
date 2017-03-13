<?php
class ControllerAccountAccount extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/account');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		if (isset($this->session->data['agent_id'])) {
			$data['agent_id'] = $this->session->data['agent_id'];
		} else {
			$data['agent_id'] = '0';
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_my_account'] = $this->language->get('text_my_account');
		$data['text_my_orders'] = $this->language->get('text_my_orders');
		$data['text_my_newsletter'] = $this->language->get('text_my_newsletter');
		$data['text_edit'] = $this->language->get('text_edit');
		//nid add 24/03/2016 11:44
		$data['text_history'] = $this->language->get('text_history');
		//nid add 24/03/2016 11:44
			$data['text_password'] = $this->language->get('text_password');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_reward'] = $this->language->get('text_reward');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_recurring'] = $this->language->get('text_recurring');
		
		//nid add 24/03/2016 11:44
		$data['history'] = $this->url->link('account/history', '', 'SSL');
		//nid add 24/03/2016 11:44
		$data['edit'] = $this->url->link('account/edit', '', 'SSL');
		$data['password'] = $this->url->link('account/password', '', 'SSL');
		$data['address'] = $this->url->link('account/address', '', 'SSL');
		$data['wishlist'] = $this->url->link('account/wishlist');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		// begin - remark out 13/07/2016
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['return'] = $this->url->link('account/return', '', 'SSL');
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');
		$data['recurring'] = $this->url->link('account/recurring', '', 'SSL');

		if ($this->config->get('reward_status')) {
			$data['reward'] = $this->url->link('account/reward', '', 'SSL');
		} else {
			$data['reward'] = '';
		}
		// end - remark out 13/07/2016

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		//koy add 26/5/2016
		if (isset($this->session->data['agent_id'])) {
			$this->response->setOutput($this->load->view('default/template/account/account.tpl', $data));
		} elseif (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/account.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/account.tpl', $data));
		}
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	// one add - begin
	public function signbyagent() {

		//$log = new Log('onedebug_acc.log');
				
		$this->load->model('account/customer');		
		
		$ani = $this->request->get['ani'];
		
		if (isset($this->request->get['dnis'])) {
			$dnis = $this->request->get['dnis'];
		} else {
			$dnis = '025026505';
		}
		
		//$order = $this->request->get['order'];
		$agent_id = base64_decode($this->request->get['agent_id']);
		
		$this->customer->logout();
		$this->cart->clear();

		unset($this->session->data['wishlist']);
		unset($this->session->data['payment_address']);
		unset($this->session->data['payment_method']);
		unset($this->session->data['payment_methods']);
		unset($this->session->data['shipping_address']);
		unset($this->session->data['shipping_method']);
		unset($this->session->data['shipping_methods']);
		unset($this->session->data['comment']);
		unset($this->session->data['order_id']);
		unset($this->session->data['coupon']);
		unset($this->session->data['reward']);
		unset($this->session->data['voucher']);
		unset($this->session->data['vouchers']);
		
		unset($this->session->data['cust_ani']);
		unset($this->session->data['agent_id']);
		unset($this->session->data['cust_step']);
		unset($this->session->data['dnis']);
		
		$user_id = $this->model_account_customer->getUserid( $agent_id );
		//koy add 11/4/2016 - user agent login success
		if ($user_id != '0') {
			
			$customer_info = $this->model_account_customer->getCustomerByANI($ani);	
			//add new customer
			if (!isset($customer_info['email']) ) {
				$customer_id = $this->model_account_customer->addCustomerByANI( $ani, $user_id );
				$customer_info = $this->model_account_customer->getCustomer( $customer_id );
				$customer_id = $customer_info['customer_id'];
			}	
			//$log->write( '(acc) customer_id = ' . $customer_info['customer_id']  ); 
			
			$email = $customer_info['email'];
			$password = $ani;
		
			//*****************
			// Login override for agent users request
			//if (!empty($this->request->get['agent_id'])) {
			$this->event->trigger('pre.customer.login');
			
			//if ($order == '0') {
			$customer_info = $this->model_account_customer->getCustomerByANI($this->request->get['ani']);
			/*} else { 
				$customer_info = $this->model_account_customer->getCustomerByOrder($this->request->get['order']);
				$ani = $customer_info['telephone'];
			}*/

			if ($customer_info && $this->customer->login($customer_info['email'], '', true)) {
				// Default Addresses
				$this->load->model('account/address');

				if ($this->config->get('config_tax_customer') == 'payment') {
					$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				if ($this->config->get('config_tax_customer') == 'shipping') {
					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				$this->event->trigger('post.customer.login');
				// add session cust_ani 
				$this->session->data['cust_ani'] = $ani;
				$this->session->data['agent_id'] = $user_id;
				$this->session->data['cust_step'] = '1';
				$this->session->data['dnis'] = $dnis;

				//$vorder = $this->model_account_customer->getOrderNumber( $customer_info['customer_id'] );
								
				//logevent 
				$this->load->model('account/activity');
				$log_data = array(
					'customer_id' => $this->customer->getId()
				);

				$this->model_account_activity->logActivity('account/account/signbyagent','Login by agent',$log_data);
				
				//$log->write( '(acc) vorder = ' . $customer_info['customer_id'] . ' - ' . $vorder  ); 
				//if ( $vorder > 0  ) {
					$this->response->redirect($this->url->link('account/order', '', 'SSL'));  // order history
				/*} else {
					$this->response->redirect($this->url->link('account/account', '', 'SSL'));  // customer menu
				}*/
			//}
		}
		//*****************			
	} else {
		//$this->session->data['cust_ani'] = '0';
		$this->response->redirect($this->url->link('account/error', '', 'SSL'));
	}
		/*if ($order == '0') {
			$customer_info = $this->model_account_customer->getCustomerByANI($ani);	
		} else { 
			$customer_info = $this->model_account_customer->getCustomerByOrder($order);
			if (empty($customer_info)) {
				$this->response->redirect($this->url->link('account/error', '', 'SSL'));
			}else{
				$ani = $customer_info['telephone'];
			}
			
		}*/

	}
	// one add - end

	// nid add - begin
	public function orderinfo() {

		//$log = new Log('nicdebug_acc.log');
				
		$this->load->model('account/customer');		
		$this->load->model('affiliate/order');
		$affiliate_id = $this->request->get['affiliate_id'];
		$order_id = $this->request->get['order_id'];
		
		$customer_id_find = $this->model_affiliate_order->getCustomerByOrder($order_id);
		//echo $customer_id_find['0']['customer_id'];
		$customer_info = $this->model_account_customer->getCustomer($customer_id_find['0']['customer_id']);
		//print_r($customer_info);
		
		//*****************
		if (!empty($customer_id_find['0']['customer_id'])) {
			$this->event->trigger('pre.affiliate.login');

			$this->customer->logout();
			$this->cart->clear();

			unset($this->session->data['wishlist']);
			unset($this->session->data['payment_address']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['shipping_address']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);

			$customer_info = $this->model_account_customer->getCustomer($customer_id_find['0']['customer_id']);
//print_r($customer_info);
			if ($customer_info && $this->customer->login($customer_info['email'], '', true)) {
				// Default Addresses
				$this->load->model('account/address');

				if ($this->config->get('config_tax_customer') == 'payment') {
					$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				if ($this->config->get('config_tax_customer') == 'shipping') {
					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				$this->event->trigger('post.affiliate.login');
				$this->response->redirect($this->url->link('affiliate/account', '', 'SSL'));  // customer menu
				
			}
		}
		// Login override for agent users request
		/*if (!empty($this->request->get['agent_id'])) {
			$this->event->trigger('pre.customer.login');

			$this->customer->logout();
			$this->cart->clear();

			unset($this->session->data['wishlist']);
			unset($this->session->data['payment_address']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['shipping_address']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['cust_ani']);
			unset($this->session->data['agent_id']);
			unset($this->session->data['cust_step']);

			$customer_info = $this->model_account_customer->getCustomerByANI($this->request->get['ani']);

			if ($customer_info && $this->customer->login($customer_info['email'], '', true)) {
				// Default Addresses
				$this->load->model('account/address');

				if ($this->config->get('config_tax_customer') == 'payment') {
					$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				if ($this->config->get('config_tax_customer') == 'shipping') {
					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				$this->event->trigger('post.customer.login');
				// add session cust_ani 
				$this->session->data['cust_ani'] = $ani;
				$this->session->data['agent_id'] = $agent_id;
				$this->session->data['cust_step'] = '1';

				$vorder = $this->model_account_customer->getOrderNumber( $customer_info['customer_id'] );
				
				//logevent 
				$this->load->model('account/activity');
				$log_data = array(
					'customer_id' => $this->customer->getId(),
					'data_id'    => $this->session->data['order_id']
				);

				$this->model_account_activity->logActivity('account/account/signbyagent','Login by agent',$log_data);
				
				//$log->write( '(acc) vorder = ' . $customer_info['customer_id'] . ' - ' . $vorder  ); 
				if (  $vorder > 0  ) {
					$this->response->redirect($this->url->link('account/order', '', 'SSL'));  // order history
				} else {
					$this->response->redirect($this->url->link('account/account', '', 'SSL'));  // customer menu
				}
			}
		}*/
		//*****************
	}
	// nid add - end		
}