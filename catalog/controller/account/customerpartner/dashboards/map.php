<?php
class ControllerAccountCustomerpartnerDashboardsMap extends Controller {

	public function index() {
		$this->load->language('account/customerpartner/dashboards/map');

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_order'] = $this->language->get('text_order');
		$data['text_sale'] = $this->language->get('text_sale');
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/dashboards/map.tpl')) {
			return ($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/dashboards/map.tpl' , $data));			
		} else {
			return ($this->load->view('default/template/account/customerpartner/dashboards/map.tpl' , $data));
		}
	}
	
	public function map() {
		$json = array();
		
		$this->load->model('customerpartner/dashboard');
		
		$results = $this->model_customerpartner_dashboard->getTotalOrdersByCountry();
		
		foreach ($results as $result) {
			$json[strtolower($result['iso_code_2'])] = array(
				'total'  => $result['total'],
				'amount' => $this->currency->format($result['amount'], $this->config->get('currency_code'))
			);
		}
	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}