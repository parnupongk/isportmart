<?php
class ControllerAccountCustomerpartnerDashboardsOrderstatus extends Controller {

	public function index() {
		$data = $this->load->language('account/customerpartner/dashboards/order_status');

		// Total order_statuss
		$this->load->model('customerpartner/dashboard');
        
        $data['totalSellerOrder'] = $this->model_customerpartner_dashboard->totalSellerOrder();
		$data['totalProcessing'] = $this->model_customerpartner_dashboard->totalSellerOrder(array('filter_processing_order' => implode(',', $this->config->get('config_processing_status'))));
		$data['totalComplete']   = $this->model_customerpartner_dashboard->totalSellerOrder(array('filter_complete_order' => $this->config->get('marketplace_complete_order_status')));
		$data['totalCancel']   = $this->model_customerpartner_dashboard->totalSellerOrder(array('filter_cancel_order' => $this->config->get('marketplace_cancel_order_status')));

		if ($data['totalSellerOrder']) {
			
            $data['totalProcessingPercent'] =  $data['totalProcessing'] / $data['totalSellerOrder'] * 100 .'%';
		    $data['totalCompletePercent']   =  $data['totalComplete'] / $data['totalSellerOrder'] * 100 .'%';
		    $data['totalCanceledPercent']   =  $data['totalCancel'] / $data['totalSellerOrder'] * 100 .'%';
		}else{
			$data['totalProcessingPercent'] =  '0%';
		    $data['totalCompletePercent']   =  '0%';
		    $data['totalCanceledPercent']   =  '0%';
		}

		$data['processing_order_link'] = $this->url->link('account/customerpartner/orderlist&filter_order_status='.implode(',', $this->config->get('config_processing_status')),'','SSL');
		$data['complete_order_link'] = $this->url->link('account/customerpartner/orderlist&filter_status='.$this->config->get('marketplace_complete_order_status'),'','SSL');
		$data['cancel_order_link'] = $this->url->link('account/customerpartner/orderlist&filter_status='.$this->config->get('marketplace_cancel_order_status'),'','SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/dashboards/order_status.tpl')) {
			return ($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/dashboards/order_status.tpl' , $data));			
		} else {
			return ($this->load->view('default/template/account/customerpartner/dashboards/order_status.tpl' , $data));
		}
	}
}
