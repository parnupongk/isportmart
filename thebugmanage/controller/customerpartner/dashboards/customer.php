<?php
class Controllercustomerpartnerdashboardscustomer extends Controller {

	public function index() {		

		$this->load->language('customerpartner/dashboards/customer');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');

		$customer_id = $this->request->get['customer_id'];
		// Total buyers
		$this->load->model('customerpartner/dashboard');		
		
		$today = $this->model_customerpartner_dashboard->getTotalCustomers(array('filter_date_added' => date('Y-m-d', strtotime('-1 day'))),$customer_id);

		$yesterday = $this->model_customerpartner_dashboard->getTotalCustomers(array('filter_date_added' => date('Y-m-d', strtotime('-2 day'))),$customer_id);

		$difference = $today - $yesterday;

		if ($difference && $today) {
			$data['percentage'] = round(($difference / $today) * 100);
		} else {
			$data['percentage'] = 0;
		}
		
		$customer_total = $this->model_customerpartner_dashboard->getTotalCustomers(array(),$customer_id);
		
		if ($customer_total > 1000000000000) {
			$data['total'] = round($customer_total / 1000000000000, 1) . 'T';
		} elseif ($customer_total > 1000000000) {
			$data['total'] = round($customer_total / 1000000000, 1) . 'B';
		} elseif ($customer_total > 1000000) {
			$data['total'] = round($customer_total / 1000000, 1) . 'M';
		} elseif ($customer_total > 1000) {
			$data['total'] = round($customer_total / 1000, 1) . 'K';						
		} else {
			$data['total'] = $customer_total;
		}
				
		$data['customer'] = $this->url->link('customerpartner/orderlist', '', 'SSL');

		return $this->load->view('customerpartner/customer.tpl', $data);

	}
}
