<?php
class ControllerAccountCustomerpartnerDashboardsLowstock extends Controller {

	public function index() {
		
		$data = $this->load->language('account/customerpartner/dashboards/low_stock');

		// Total low_stocks
		$this->load->model('customerpartner/dashboard');
		$this->load->model('account/customerpartner');

		$getLowStockProducts = $this->model_account_customerpartner->getLowStockProducts($this->customer->getId());

		if ($getLowStockProducts) {
		    
		    $data['low_stock_quantity'] = $getLowStockProducts['count'];	
		}else{
			$data['low_stock_quantity'] = 0;
		}

		$data['low_stock_view_more'] = $this->url->link('account/customerpartner/productlist&low_stock', '', 'SSL');	
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/dashboards/low_stock.tpl')) {
			return ($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/dashboards/low_stock.tpl' , $data));			
		} else {
			return ($this->load->view('default/template/account/customerpartner/dashboards/low_stock.tpl' , $data));
		}
	}
}
