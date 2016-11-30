<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		$data['title'] = $this->document->getTitle();

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		// nid 18/03/2016 09:54
		$this->load->model('user/user');
		$user_info = $this->model_user_user->getUser($this->user->getId());
		// nid 18/03/2016 09:54
		$this->load->language('common/header');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_order_status'] = $this->language->get('text_order_status');
		$data['text_complete_status'] = $this->language->get('text_complete_status');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_customer'] = $this->language->get('text_customer');
		$data['text_online'] = $this->language->get('text_online');
		$data['text_approval'] = $this->language->get('text_approval');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_stock'] = $this->language->get('text_stock');
		$data['text_review'] = $this->language->get('text_review');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_front'] = $this->language->get('text_front');
		$data['text_help'] = $this->language->get('text_help');
		$data['text_homepage'] = $this->language->get('text_homepage');
		$data['text_documentation'] = $this->language->get('text_documentation');
		$data['text_support'] = $this->language->get('text_support');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());
		$data['text_logout'] = $this->language->get('text_logout');
		 //nid add 17/3/2016 16:00 for cs
		$data['text_order_wait'] = $this->language->get('text_order_wait');
		$data['text_aff_wait']   = $this->language->get('text_aff_wait'); 
		
		if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
			$data['logged'] = '';

			$data['home'] = $this->url->link('common/dashboard', '', 'SSL');
		} else {
			$data['logged'] = true;

			$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
			$data['logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], 'SSL');

			// Orders
			$this->load->model('sale/order');
      //nid add 17/3/2016 16:48 for cs
      //Vendors wait for action
      $data['pending_payment_total'] = $this->model_sale_order->getTotalOrders(array('filter_order_status' => '28','filter_user_group'=> $user_info['user_group']));
			$data['pending_payment'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&filter_order_status=28'.'&filter_user_group='.$user_info['user_group'], 'SSL');
			
			$data['wait_vendors_action_total'] = $this->model_sale_order->getTotalOrders(array('filter_order_status' => '15,2','filter_user_group'=> $user_info['user_group']));
			$data['wait_vendors_action'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] .'&filter_order_status=15,2'.'&filter_user_group='.$user_info['user_group'], 'SSL');
			
			$data['pending_return_total'] = $this->model_sale_order->getTotalOrders(array('filter_order_status' => '27','filter_user_group'=> $user_info['user_group']));
			$data['pending_return'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&filter_order_status=27'.'&filter_user_group='.$user_info['user_group'], 'SSL');
			
			// nid 18/03/2016 10:47
			// Processing Orders
			$data['order_status_total'] = $this->model_sale_order->getTotalOrders(array('filter_order_status' => implode(',', $this->config->get('config_processing_status'))));
			$data['order_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&filter_order_status=' . implode(',', $this->config->get('config_processing_status')), 'SSL');

			// Complete Orders
			$data['complete_status_total'] = $this->model_sale_order->getTotalOrders(array('filter_order_status' => implode(',', $this->config->get('config_complete_status'))));
			$data['complete_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&filter_order_status=' . implode(',', $this->config->get('config_complete_status')), 'SSL');

			// Returns
			$this->load->model('sale/return');
			$return_total = $this->model_sale_return->getTotalReturns(array('filter_return_status_id' => $this->config->get('config_return_status_id')));

			$data['return_total'] = $return_total;

			$data['return'] = $this->url->link('sale/return', 'token=' . $this->session->data['token'], 'SSL');
		  
			// Customers
			$this->load->model('report/customer');

			$data['online_total'] = $this->model_report_customer->getTotalCustomersOnline();

			$data['online'] = $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], 'SSL');

			$this->load->model('sale/customer');

			$customer_total = $this->model_sale_customer->getTotalCustomers(array('filter_approved' => false));

			$data['customer_total'] = $customer_total;
			$data['customer_approval'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&filter_approved=0', 'SSL');

			// Products
			$this->load->model('catalog/product');

			$product_total = $this->model_catalog_product->getTotalProducts(array('filter_quantity' => 0));

			$data['product_total'] = $product_total;

			$data['product'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&filter_quantity=0', 'SSL');

			// Reviews
			$this->load->model('catalog/review');

			$review_total = $this->model_catalog_review->getTotalReviews(array('filter_status' => false));

			$data['review_total'] = $review_total;

			$data['review'] = $this->url->link('catalog/review', 'token=' . $this->session->data['token'] . '&filter_status=0', 'SSL');

			// Affliate
			$this->load->model('marketing/affiliate');

			$affiliate_total = $this->model_marketing_affiliate->getTotalAffiliates(array('filter_approved' => false));

			$data['affiliate_total'] = $affiliate_total;
			$data['affiliate_approval'] = $this->url->link('marketing/affiliate', 'token=' . $this->session->data['token'] . '&filter_approved=1', 'SSL');
			if (!empty($user_info)&&$user_info['user_group']==='CustService' || $user_info['user_group']==='Agent') {
			$data['alerts'] =	$data['pending_payment_total'];
			}else{
			$data['alerts'] = $customer_total + $product_total + $review_total + $return_total + $affiliate_total;
		  }
			// Online Stores
			$data['stores'] = array();

			$data['stores'][] = array(
				'name' => $this->config->get('config_name'),
				'href' => HTTP_CATALOG
			);

			$this->load->model('setting/store');

			$results = $this->model_setting_store->getStores();

			foreach ($results as $result) {
				$data['stores'][] = array(
					'name' => $result['name'],
					'href' => $result['url']
				);
			}
		}
		
		// one add - begin
		//$this->load->model('user/user');//nid hide
		//$user_info = $this->model_user_user->getUser($this->user->getId());
		/*if(!empty($user_info)){
			if ($user_info['user_group']==='CustService') {
				return $this->load->view('common/headercs.tpl', $data);
			}	
		}else {
			return $this->load->view('common/header.tpl', $data);
		}*/
// nid add 19/4/2016 16:46
if(!empty($this->request->get['order_id'])){
	if (!empty($this->session->data['user_group'])&& $this->session->data['user_group'] =='CustService') {
			return $this->load->view('common/headercs.tpl', $data);
		}else if (!empty($this->session->data['user_group'])&& $this->session->data['user_group'] =='Agent') {
			return $this->load->view('common/headercs.tpl', $data);
		} else {
			return $this->load->view('common/header.tpl', $data);
		}
}else{
	if (!empty($this->session->data['user_group'])&& $this->session->data['user_group'] =='CustService') {
			return $this->load->view('common/headercs_bell.tpl', $data);
		}else if (!empty($this->session->data['user_group'])&& $this->session->data['user_group'] =='Agent') {
			return $this->load->view('common/headercs_bell.tpl', $data);
		}else if (!empty($this->session->data['user_group'])&& $this->session->data['user_group'] =='NarLabs') {
			// bom update 20161025
			return $this->load->view('common/headercs_bell.tpl', $data);
		}else if (!empty($this->session->data['user_group'])&& $this->session->data['user_group'] =='DNA') {
			// bom update 2016/11/29
			return $this->load->view('common/headercs_bell.tpl', $data);
		}else {
			return $this->load->view('common/header.tpl', $data);
		}
}		
// nid add 19/4/2016 16:46		
		// one add - end
		//return $this->load->view('common/header.tpl', $data);
	}
}