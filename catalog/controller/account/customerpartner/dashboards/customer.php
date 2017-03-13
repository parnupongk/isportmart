<?php
class ControllerAccountCustomerpartnerDashboardsCustomer extends Controller {

	public function index() {		

		$this->load->language('account/customerpartner/dashboards/customer');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');

		// Total buyers
		$this->load->model('customerpartner/dashboard');		
		
		$today = $this->model_customerpartner_dashboard->getTotalCustomers(array('filter_date_added' => date('Y-m-d', strtotime('-1 day'))));

		$yesterday = $this->model_customerpartner_dashboard->getTotalCustomers(array('filter_date_added' => date('Y-m-d', strtotime('-2 day'))));

		$difference = $today - $yesterday;

		if ($difference && $today) {
			$data['percentage'] = round(($difference / $today) * 100);
		} else {
			$data['percentage'] = 0;
		}
		
		$customer_total = $this->model_customerpartner_dashboard->getTotalCustomers();
		
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
				
		$data['customer'] = $this->url->link('account/customerpartner/orderlist', '', 'SSL');
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/dashboards/customer.tpl')) {
			return ($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/dashboards/customer.tpl' , $data));			
		} else {
			return ($this->load->view('default/template/account/customerpartner/dashboards/customer.tpl' , $data));
		}

	}
}
