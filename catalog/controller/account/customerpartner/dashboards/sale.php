<?php
class ControllerAccountCustomerpartnerDashboardsSale extends Controller {

	public function index() {		

		$this->load->language('account/customerpartner/dashboards/sale');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');

		$this->load->model('customerpartner/dashboard');		

		$today = $this->model_customerpartner_dashboard->getTotalSales(array('filter_date_added' => date('Y-m-d', strtotime('-1 day'))));

		$yesterday = $this->model_customerpartner_dashboard->getTotalSales(array('filter_date_added' => date('Y-m-d', strtotime('-2 day'))));

		$difference = $today['total'] - $yesterday['total'];

		if ($difference && $today['total']) {
			$data['percentage'] = round(($difference / $today['total']) * 100);
		} else {
			$data['percentage'] = 0;
		}

		$paid_amount = $this->model_customerpartner_dashboard->getPaidAmount();
		$sales = $this->model_customerpartner_dashboard->getTotalSales();
		$sale_total = number_format((float)$sales['total'],2);
		$sale_total = number_format((float)$sales['total'],2);
		$admin_amount = number_format((float)$sales['admin'],2);
		$seller_amount = number_format((float)$sales['seller'],2);

		if($paid_amount) {
			$payable_amount = round($sales['total']-($paid_amount+$sales['admin']),2);
			$payable_amount = number_format((float)$payable_amount,2);
		} else {
			$payable_amount = 0;
		}
		
		$paid_amount = number_format((float)$paid_amount,2);

		if ($sale_total > 1000000000000) {
			$data['total'] = round($sale_total / 1000000000000, 1) . 'T';
		} elseif ($sale_total > 1000000000) {
			$data['total'] = round($sale_total / 1000000000, 1) . 'B';
		} elseif ($sale_total > 1000000) {
			$data['total'] = round($sale_total / 1000000, 1) . 'M';
		} elseif ($sale_total > 1000) {
			$data['total'] = round($sale_total / 1000, 1) . 'K';
		} else {
			$data['total'] = $sale_total;
		}

		if ($admin_amount > 1000000000000) {
			$data['admin_amount'] = round($admin_amount / 1000000000000, 1) . 'T';
		} elseif ($admin_amount > 1000000000) {
			$data['admin_amount'] = round($admin_amount / 1000000000, 1) . 'B';
		} elseif ($admin_amount > 1000000) {
			$data['admin_amount'] = round($admin_amount / 1000000, 1) . 'M';
		} elseif ($admin_amount > 1000) {
			$data['admin_amount'] = round($admin_amount / 1000, 1) . 'K';
		} else {
			$data['admin_amount'] = $admin_amount;
		}

		if ($seller_amount > 1000000000000) {
			$data['seller_amount'] = round($seller_amount / 1000000000000, 1) . 'T';
		} elseif ($seller_amount > 1000000000) {
			$data['seller_amount'] = round($seller_amount / 1000000000, 1) . 'B';
		} elseif ($seller_amount > 1000000) {
			$data['seller_amount'] = round($seller_amount / 1000000, 1) . 'M';
		} elseif ($seller_amount > 1000) {
			$data['seller_amount'] = round($seller_amount / 1000, 1) . 'K';
		} else {
			$data['seller_amount'] = $seller_amount;
		}

		if ($payable_amount > 1000000000000) {
			$data['payable_amount'] = round($payable_amount / 1000000000000, 1) . 'T';
		} elseif ($payable_amount > 1000000000) {
			$data['payable_amount'] = round($payable_amount / 1000000000, 1) . 'B';
		} elseif ($payable_amount > 1000000) {
			$data['payable_amount'] = round($payable_amount / 1000000, 1) . 'M';
		} elseif ($payable_amount > 1000) {
			$data['payable_amount'] = round($payable_amount / 1000, 1) . 'K';
		} else {
			$data['payable_amount'] = $payable_amount;
		}

		if ($paid_amount > 1000000000000) {
			$data['paid_amount'] = round($paid_amount / 1000000000000, 1) . 'T';
		} elseif ($paid_amount > 1000000000) {
			$data['paid_amount'] = round($paid_amount / 1000000000, 1) . 'B';
		} elseif ($paid_amount > 1000000) {
			$data['paid_amount'] = round($paid_amount / 1000000, 1) . 'M';
		} elseif ($paid_amount > 1000) {
			$data['paid_amount'] = round($paid_amount / 1000, 1) . 'K';
		} else {
			$data['paid_amount'] = $paid_amount;
		}

		$data['sale'] = $this->url->link('account/customerpartner/orderlist', '', 'SSL');
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/dashboards/sale.tpl')) {
			return ($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/dashboards/sale.tpl' , $data));			
		} else {
			return ($this->load->view('default/template/account/customerpartner/dashboards/sale.tpl' , $data));
		}
	}
}
