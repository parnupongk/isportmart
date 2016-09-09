<?php
class ControllerDashboardRecent extends Controller {
	public function index() {
		$this->load->language('dashboard/recent');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_view'] = $this->language->get('button_view');

		$data['token'] = $this->session->data['token'];
		$data['user_group'] = $this->session->data['user_group'];
		// nid 18/03/2016 10:10
    if (isset($this->session->data['user_group'])) {
			$filter_user_group = $this->session->data['user_group'];
		} else {
			$filter_user_group = null;
		}
		if (isset($this->request->get['filter_order_status'])) {
			$filter_order_status = $this->request->get['filter_order_status'];
		} else {
			$filter_order_status = null;
		}
		// Last 5 Orders
		$data['orders'] = array();

		$filter_data = array(
			'sort'  => 'o.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 10,
			'filter_user_group'    => $filter_user_group, // nid 18/03/2016 10:10
			'filter_order_status'    => $filter_order_status // nid 18/03/2016 10:10
		);

		$results = $this->model_sale_order->getOrders($filter_data);
//echo "<pre>";print_r($results);
		foreach ($results as $result) {
			$data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'customer'   => $result['customer'],
				'payment_code'   => $result['payment_code'], // one add @ 23/05/2016
				'status'     => $result['status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'view'       => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id']. '&filter_user_group=' .$this->session->data['user_group']. '&filter_order_status=' . $result['order_status_id'], 'SSL'),
			);
		}

		return $this->load->view('dashboard/recent.tpl', $data);
	}
}