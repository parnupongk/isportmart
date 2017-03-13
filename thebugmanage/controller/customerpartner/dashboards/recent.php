<?php
class Controllercustomerpartnerdashboardsrecent extends Controller {

	public function index() {		

		$this->load->language('customerpartner/dashboards/recent');
		$this->load->model('customerpartner/customerpartner');
		$this->load->model('customerpartner/dashboard');

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_no_results'] = $this->language->get('text_no_results');
		
		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_view'] = $this->language->get('button_view');

		// Last 5 Orders
		$data['orders'] = array();

		$filter_data = array(
			'sort'  => 'o.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 5
		);
		$customer_id = $this->request->get['customer_id'];
		$results = $this->model_customerpartner_customerpartner->getSellerOrders($filter_data,$customer_id);

		foreach ($results as $result) {
			$order_total = $this->model_customerpartner_dashboard->getTotalSales(array('filter_order_id' => $result['order_id']),$customer_id);

			$data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'customer'   => $result['name'],
				'status'     => $result['orderstatus'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'total'      => $this->currency->format($order_total['total'], $result['currency_code'], $result['currency_value']),
				'view'       => $this->url->link('sale/order/info','token='. $this->session->data['token'] . '&order_id=' . $result['order_id'], '' ,'SSL'),
			);
		}
		
		return $this->load->view('dashboard/recent.tpl', $data);
	}
}
