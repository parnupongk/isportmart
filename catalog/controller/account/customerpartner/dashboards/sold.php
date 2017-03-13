<?php
class ControllerAccountCustomerpartnerDashboardsSold extends Controller {

	public function index() {
		// return;

		$this->load->language('account/customerpartner/dashboards/sold');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');

		// Total solds
		$this->load->model('customerpartner/dashboard');
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/dashboards/sold.tpl')) {
			return ($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/dashboards/sold.tpl' , $data));			
		} else {
			return ($this->load->view('default/template/account/customerpartner/dashboards/sold.tpl' , $data));
		}
	}
}
