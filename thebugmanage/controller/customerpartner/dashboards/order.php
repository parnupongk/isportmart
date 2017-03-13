<?php
class Controllercustomerpartnerdashboardsorder extends Controller {

	public function index() {
		// return;

		$this->load->language('customerpartner/dashboards/order');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');

		// Total Orders
		$this->load->model('customerpartner/customerpartner');
		$customer_id = $this->request->get['customer_id'];
		$today = $this->model_customerpartner_customerpartner->getSellerOrdersTotal(array('filter_date' => date('Y-m-d', strtotime('-1 day'))),$customer_id);

		$yesterday = $this->model_customerpartner_customerpartner->getSellerOrdersTotal(array('filter_date' => date('Y-m-d', strtotime('-2 day'))),$customer_id);

		$difference = $today - $yesterday;

		if ($difference && $today) {
			$data['percentage'] = round(($difference / $today) * 100);
		} else {
			$data['percentage'] = 0;
		}
		
		$order_total = $this->model_customerpartner_customerpartner->getSellerOrdersTotal(array(),$customer_id);
		
		if ($order_total > 1000000000000) {
			$data['total'] = round($order_total / 1000000000000, 1) . 'T';
		} elseif ($order_total > 1000000000) {
			$data['total'] = round($order_total / 1000000000, 1) . 'B';
		} elseif ($order_total > 1000000) {
			$data['total'] = round($order_total / 1000000, 1) . 'M';
		} elseif ($order_total > 1000) {
			$data['total'] = round($order_total / 1000, 1) . 'K';						
		} else {
			$data['total'] = $order_total;
		}
				
		$data['order'] = $this->url->link('customerpartner/orderlist', '', 'SSL');

		return $this->load->view('customerpartner/order.tpl', $data);
	}
}
