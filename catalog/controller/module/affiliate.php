<?php
class ControllerModuleAffiliate extends Controller {
	public function index() {
		$this->load->language('module/affiliate');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_forgotten'] = $this->language->get('text_forgotten');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_payment'] = $this->language->get('text_payment');
		$data['text_tracking'] = $this->language->get('text_tracking');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_order_management'] = $this->language->get('text_order_management');
		$data['quota_of_stock'] = $this->language->get('quota_of_stock');
		$data['sale_summary'] = $this->language->get('sale_summary');
		$data['chart'] = $this->language->get('chart');
		$data['chart_pie'] = $this->language->get('chart_pie');

		//-------nid 10/2/2016------
		$data['text_order'] = $this->language->get('text_order');
		$data['text_order_approve'] = $this->language->get('text_order_approve');
		$data['text_order_status'] = $this->language->get('text_order_status');
		$data['text_complete_status'] = $this->language->get('text_complete_status');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_stock'] = $this->language->get('text_stock');
		$this->load->model('affiliate/order');
		// Processing Orders
		$order_status_total = $this->model_affiliate_order->getTotalTransferForBell();
		$data['order_status_total'] = $order_status_total;
		$data['order_status'] = $this->url->link('affiliate/order','filter_status=Transfer', 'SSL');
		$this->load->model('affiliate/stock');
	    $product_total = $this->model_affiliate_stock->getTotalProducts(array('filter_quantity' => 0));
        $data['product_total'] = $product_total;
        $data['product'] = $this->url->link('affiliate/stock','filter_quantity=0', 'SSL');
    //16/3/2016 09:56 nid add
    $alerts = $this->model_affiliate_order->getTotalApproveForBell();     
    $data['alerts'] = $alerts;
    $data['alerts_status'] = $this->url->link('affiliate/order','filter_status=Approve', 'SSL');
      //  $data['alerts'] = $order_status_total + $product_total;
		//-------nid 10/2/2016------
		$data['logged'] = $this->affiliate->isLogged();
		$data['register'] = $this->url->link('affiliate/register', '', 'SSL');
		$data['login'] = $this->url->link('affiliate/login', '', 'SSL');
		$data['logout'] = $this->url->link('affiliate/logout', '', 'SSL');
		$data['forgotten'] = $this->url->link('affiliate/forgotten', '', 'SSL');
		$data['account'] = $this->url->link('affiliate/account', '', 'SSL');
		$data['edit'] = $this->url->link('affiliate/edit', '', 'SSL');
		$data['password'] = $this->url->link('affiliate/password', '', 'SSL');
		$data['payment'] = $this->url->link('affiliate/payment', '', 'SSL');
		$data['tracking'] = $this->url->link('affiliate/tracking', '', 'SSL');
		$data['transaction'] = $this->url->link('affiliate/transaction', '', 'SSL');
		$data['order_management'] = $this->url->link('affiliate/order', '', 'SSL');
		$data['quota_of_stock'] = $this->url->link('affiliate/stock', '', 'SSL');
		$data['sale_summary'] = $this->url->link('affiliate/sale', '', 'SSL');
		$data['chart'] = $this->url->link('affiliate/chart', '', 'SSL');
		$data['chart_pie'] = $this->url->link('affiliate/chart_pie', '', 'SSL');

		//koy add 27/5/2016
		/*if (isset($this->session->data['agent_id'])) {
			return $this->load->view('default/template/module/affiliate.tpl', $data);
		} elseif (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/affiliate.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/affiliate.tpl', $data);
		} else { */
			// fixed 
			return $this->load->view('default/template/module/affiliate.tpl', $data);
		//}
	}
}