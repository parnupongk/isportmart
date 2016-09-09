<?php
class ControllerAffiliateAccount extends Controller {
	public function index() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/account', '', 'SSL');

			$this->response->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		$this->load->language('affiliate/account');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('affiliate/order')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('affiliate/account', '', 'SSL')
		);

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_my_account'] = $this->language->get('text_my_account');
		$data['text_my_tracking'] = $this->language->get('text_my_tracking');
		$data['text_my_transactions'] = $this->language->get('text_my_transactions');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_payment'] = $this->language->get('text_payment');
		$data['text_tracking'] = $this->language->get('text_tracking');
		$data['text_transaction'] = $this->language->get('text_transaction');
//-----01/04/2016
$this->load->language('module/affiliate');
		$data['text_order_management'] = $this->language->get('text_order_management');
		$data['quota_of_stock'] = $this->language->get('quota_of_stock');
		$data['sale_summary'] = $this->language->get('sale_summary');
		$data['chart'] = $this->language->get('chart');
		$data['chart_pie'] = $this->language->get('chart_pie');
		$data['text_logout'] = $this->language->get('text_logout');
		
		$data['transaction'] = $this->url->link('affiliate/transaction', '', 'SSL');
		$data['order_management'] = $this->url->link('affiliate/order', '', 'SSL');
		$data['quota_of_stock'] = $this->url->link('affiliate/stock', '', 'SSL');
		$data['sale_summary'] = $this->url->link('affiliate/sale', '', 'SSL');
		$data['chart'] = $this->url->link('affiliate/chart', '', 'SSL');
		$data['chart_pie'] = $this->url->link('affiliate/chart_pie', '', 'SSL');
		$data['chart_pie'] = $this->url->link('affiliate/chart_pie', '', 'SSL');
		$data['logout'] = $this->url->link('affiliate/logout', '', 'SSL');
//----------
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['edit'] = $this->url->link('affiliate/edit', '', 'SSL');
		$data['password'] = $this->url->link('affiliate/password', '', 'SSL');
		$data['payment'] = $this->url->link('affiliate/payment', '', 'SSL');
		$data['tracking'] = $this->url->link('affiliate/tracking', '', 'SSL');
		$data['transaction'] = $this->url->link('affiliate/transaction', '', 'SSL');

		//$data['column_left'] = $this->load->controller('common/column_left');
		//$data['column_right'] = $this->load->controller('common/column_right');
		$data['column_left'] = $this->load->controller('common/column_leftaff');
		$data['column_right'] = $this->load->controller('common/column_rightaff');
		
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/headeraff');
		
		$this->load->model('affiliate/activity');		
		$data['entry_firstname'] = $this->affiliate->getFirstName() . ' ' . $this->affiliate->getLastName();
		
		//koy fix template to default only! 26/5/2016
		/*if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/account.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/affiliate/account.tpl', $data));
		} else {*/
			$this->response->setOutput($this->load->view('default/template/affiliate/account.tpl', $data));
		//}
	}
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

				$this->event->trigger('post.customer.login');
				$this->response->redirect($this->url->link('affiliate/order','', 'SSL'));
				/*$this->load->model('account/order');
				$order_info = $this->model_account_order->getOrder_affiliate($order_id);
				//print_r($order_info);
				if ($order_info) {
					$this->response->redirect($this->url->link('affiliate/order/invoice', 'affiliate_id=' .$affiliate_id. '&order_id=' .$order_id,'', 'SSL'));
				} else {
					$this->response->redirect($this->url->link('affiliate/order','', 'SSL'));
				}*/
				
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