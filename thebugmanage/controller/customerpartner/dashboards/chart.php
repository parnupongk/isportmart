<?php
class Controllercustomerpartnerdashboardschart extends Controller {

	public function index() {
		$this->load->language('dashboard/chart');

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_day'] = $this->language->get('text_day');
		$data['text_week'] = $this->language->get('text_week');
		$data['text_month'] = $this->language->get('text_month');
		$data['text_year'] = $this->language->get('text_year');
		$data['text_view'] = $this->language->get('text_view');
		$data['token'] = $this->session->data['token'];
		return $this->load->view('dashboard/chart.tpl', $data);
	}
	
	public function chart() {
		$this->load->language('dashboards/chart');

		$json = array();
		
		$this->load->model('customerpartner/dashboard');
		// $this->load->model('report/customer');
		$data['token'] = $this->session->data['token'];

		$json['order'] = array();
		$json['customer'] = array();
		$json['xaxis'] = array();
		$customer_id = $this->request->get['customer_id'];
		$json['order']['label'] = $this->language->get('text_order');
		$json['customer']['label'] = $this->language->get('text_customer');
		$json['order']['data'] = array();
		$json['customer']['data'] = array();

		if (isset($this->request->get['range'])) {
			$range = $this->request->get['range'];
		} else {
			$range = 'day';
		}

		switch ($range) {
			default:
			case 'day':
				$results = $this->model_customerpartner_dashboard->getTotalOrdersByDay($customer_id);

				foreach ($results as $key => $value) {
					$json['order']['data'][] = array($key, $value['total']);
				}

				$results = $this->model_customerpartner_dashboard->getTotalCustomersByDay($customer_id);

				foreach ($results as $key => $value) {
					$json['customer']['data'][] = array($key, $value['total']);
				}

				for ($i = 0; $i < 24; $i++) {
					$json['xaxis'][] = array($i, $i);
				}
				break;
			case 'week':
				$results = $this->model_customerpartner_dashboard->getTotalOrdersByWeek($customer_id);

				foreach ($results as $key => $value) {
					$json['order']['data'][] = array($key, $value['total']);
				}
				
				$results = $this->model_customerpartner_dashboard->getTotalCustomersByWeek($customer_id);

				foreach ($results as $key => $value) {
					$json['customer']['data'][] = array($key, $value['total']);
				}

				$date_start = strtotime('-' . date('w') . ' days');

				for ($i = 0; $i < 7; $i++) {
					$date = date('Y-m-d', $date_start + ($i * 86400));

					$json['xaxis'][] = array(date('w', strtotime($date)), date('D', strtotime($date)));
				}
				break;
			case 'month':
				$results = $this->model_customerpartner_dashboard->getTotalOrdersByMonth($customer_id);

				foreach ($results as $key => $value) {
					$json['order']['data'][] = array($key, $value['total']);
				}

				$results = $this->model_customerpartner_dashboard->getTotalCustomersByMonth($customer_id);

				foreach ($results as $key => $value) {
					$json['customer']['data'][] = array($key, $value['total']);
				}

				for ($i = 1; $i <= date('t'); $i++) {
					$date = date('Y') . '-' . date('m') . '-' . $i;

					$json['xaxis'][] = array(date('j', strtotime($date)), date('d', strtotime($date)));
				}
				break;
			case 'year':
				$results = $this->model_customerpartner_dashboard->getTotalOrdersByYear();

				foreach ($results as $key => $value) {
					$json['order']['data'][] = array($key, $value['total']);
				}

				$results = $this->model_customerpartner_dashboard->getTotalCustomersByYear();

				foreach ($results as $key => $value) {
					$json['customer']['data'][] = array($key, $value['total']);
				}

				for ($i = 1; $i <= 12; $i++) {
					$json['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i)));
				}
				break;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}