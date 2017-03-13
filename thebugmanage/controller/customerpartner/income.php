<?php 

class ControllerCustomerpartnerincome extends Controller {
	
	function index() {
		// loading language
		$this->load->language("customerpartner/income");
		// loading model
		$this->load->model("customerpartner/income");
		$this->load->model('customerpartner/partner');

		$this->document->setTitle($this->language->get('heading_title'));

		// language

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_seller_name'] = $this->language->get('text_seller_name');
		$data['text_dashboard'] = $this->language->get('text_dashboard');
		$data['text_commission'] = $this->language->get('text_commission');
		$data['text_total_amount'] = $this->language->get('text_total_amount');
		$data['text_seller_amount'] = $this->language->get('text_seller_amount');
		$data['text_paid_to_seller'] = $this->language->get('text_paid_to_seller');
		$data['text_rem_amount'] = $this->language->get('text_rem_amount');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['text_admin_amount'] = $this->language->get('text_admin_amount');
		$data['text_grand_total'] = $this->language->get('text_grand_total');
		$data['text_grand_paid'] = $this->language->get('text_grand_paid');
		$data['text_grand_rem'] = $this->language->get('text_grand_rem');
		$data['text_action'] = $this->language->get('text_action');
		$data['text_from'] = $this->language->get('text_from');
		$data['text_to'] = $this->language->get('text_to');
		$data['no_records'] = $this->language->get('no_records');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_reset_filter'] = $this->language->get('button_reset_filter');

		$data['token'] = $this->session->data['token'];

		$url = '';
		if(isset($this->request->get['seller_name'])){
			$data['seller_name'] = $this->request->get['seller_name'];
			$url .= '&seller_name='.$this->request->get['seller_name'];
		} else {
			$data['seller_name'] = '';
		}
		if(isset($this->request->get['commission_from'])){
			$data['commission_from'] = $this->request->get['commission_from'];
			$url .= '&commission_from='.$this->request->get['commission_from'];
		} else {
			$data['commission_from'] = '';
		}
		if(isset($this->request->get['commission_to'])){
			$data['commission_to'] = $this->request->get['commission_to'];
			$url .= '&commission_to='.$this->request->get['commission_to'];
		} else {
			$data['commission_to'] = '';
		}
		if(isset($this->request->get['total_amount_from'])){
			$data['total_amount_from'] = $this->request->get['total_amount_from'];
			$url .= '&total_amount_from='.$this->request->get['total_amount_from'];
		} else {
			$data['total_amount_from'] = '';
		}
		if(isset($this->request->get['total_amount_to'])){
			$data['total_amount_to'] = $this->request->get['total_amount_to'];
			$url .= '&total_amount_to='.$this->request->get['total_amount_to'];
		} else {
			$data['total_amount_to'] = '';
		}
		if(isset($this->request->get['seller_amount_from'])){
			$data['seller_amount_from'] = $this->request->get['seller_amount_from'];
			$url .= '&seller_amount_from='.$this->request->get['seller_amount_from'];
		} else {
			$data['seller_amount_from'] = '';
		}
		if(isset($this->request->get['seller_amount_to'])){
			$data['seller_amount_to'] = $this->request->get['seller_amount_to'];
			$url .= '&seller_amount_to='.$this->request->get['seller_amount_to'];
		} else {
			$data['seller_amount_to'] = '';
		}
		if(isset($this->request->get['admin_amount_from'])){
			$data['admin_amount_from'] = $this->request->get['admin_amount_from'];
			$url .= '&admin_amount_from='.$this->request->get['admin_amount_from'];
		} else {
			$data['admin_amount_from'] = '';
		}
		if(isset($this->request->get['admin_amount_to'])){
			$data['admin_amount_to'] = $this->request->get['admin_amount_to'];
			$url .= '&admin_amount_to='.$this->request->get['admin_amount_to'];
		} else {
			$data['admin_amount_to'] = '';
		}
		if(isset($this->request->get['paid_to_seller_from'])){
			$data['paid_to_seller_from'] = $this->request->get['paid_to_seller_from'];
			$url .= '&paid_to_seller_from='.$this->request->get['paid_to_seller_from'];
		} else {
			$data['paid_to_seller_from'] = '';
		}
		if(isset($this->request->get['paid_to_seller_to'])){
			$data['paid_to_seller_to'] = $this->request->get['paid_to_seller_to'];
			$url .= '&paid_to_seller_to='.$this->request->get['paid_to_seller_to'];
		} else {
			$data['paid_to_seller_to'] = '';
		}
		if(isset($this->request->get['rem_amount_from'])){
			$data['rem_amount_from'] = $this->request->get['rem_amount_from'];
			$url .= '&rem_amount_from='.$this->request->get['rem_amount_from'];
		} else {
			$data['rem_amount_from'] = '';
		}
		if(isset($this->request->get['rem_amount_to'])){
			$data['rem_amount_to'] = $this->request->get['rem_amount_to'];
			$url .= '&rem_amount_to='.$this->request->get['rem_amount_to'];
		} else {
			$data['rem_amount_to'] = '';
		}

		if(isset($this->request->get['date_added_from'])){
			$data['date_added_from'] = $this->request->get['date_added_from'];
			$url .= '&date_added_from='.$this->request->get['date_added_from'];
		} else {
			$data['date_added_from'] = '';
		}
		if(isset($this->request->get['date_added_to'])){
			$data['date_added_to'] = $this->request->get['date_added_to'];
			$url .= '&date_added_to='.$this->request->get['date_added_to'];
		} else {
			$data['date_added_to'] = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['order'])) {
			$data['order'] = $this->request->get['order'];
		} else {
			$data['order'] = 'c.firstname';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
			if($sort == "asc") {
				$sort = "desc";
			} else {
				$sort = "asc";
			}
			$data['sort'] = $sort;
		} else {
			$sort = "asc";
			$data['sort'] = $sort;
		}

		$filter_data = array(
			'seller_name' => $data['seller_name'],
			'commission_from' => $data['commission_from'],
			'commission_to' => $data['commission_to'],
			'total_amount_from' => $data['total_amount_from'],
			'total_amount_to' => $data['total_amount_to'],
			'seller_amount_from' => $data['seller_amount_from'],
			'seller_amount_to' => $data['seller_amount_to'],
			'admin_amount_from' => $data['admin_amount_from'],
			'admin_amount_to' => $data['admin_amount_to'],
			'paid_to_seller_from' => $data['paid_to_seller_from'],
			'paid_to_seller_to' => $data['paid_to_seller_to'],
			'rem_amount_from' => $data['rem_amount_from'],
			'rem_amount_to' => $data['rem_amount_to'],
			'date_added_from' => $data['date_added_from'],
			'date_added_to' => $data['date_added_to'],
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin'),
			'sort' => $sort,
			'order' => $data['order'],
		);

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('customerpartner/income', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['remove_url'] = $this->url->link('customerpartner/income', 'token=' . $this->session->data['token'] , 'SSL');

		$data['income_details'] = array();
		$data['grand_total_admin'] = 0;
		$data['grand_total_paid'] = 0;
		$data['grand_total_rem'] = 0;
		$data['grand_total_seller'] = 0;
		$data['grand_total'] = 0;
		$total_row = 0;
		$this->model_customerpartner_income->getDetails();
		$sellers = $this->model_customerpartner_income->getSellerList($filter_data);
		foreach ($sellers as $key => $seller) {
			$partner_amount = $this->model_customerpartner_partner->getPartnerTotal($seller['customer_id'],$filter_data);
			if(!$partner_amount){
				continue;
			}
			$total = $partner_amount['total'];
			$admin = $partner_amount['admin'];
			$selleramount = $partner_amount['customer'];
			$paid = $partner_amount['paid'];
			$rem = round($total-($paid+$admin),2);
			$button_status = true;
			if($rem){
				$button_status = false;
			}
			$data['income_details'][] = array(
				'firstname' => $seller['firstname'],
				'seller_name' => $seller['firstname']." ".$seller['lastname'],
				'dashborad_url' => $this->url->link("customerpartner/partner/update","token=".$this->session->data['token']."&customer_id=".$seller['customer_id']."&amount=".$rem, "SSL"),
				'commission' => $seller['commission']."%",
				'total' => number_format($total,2),
				'seller_total' => number_format($selleramount,2),
				'admin_total' => number_format($admin,2),
				'paid_total' => number_format($paid,2),
				'amount_to_pay' => number_format($rem,2),
				'pay_link' => $this->url->link("customerpartner/transaction/addtransaction","token=".$this->session->data['token']."&seller_id=".$seller['customer_id'], "SSL"),
				'pay' => $this->language->get('button_pay')." ".number_format($rem,2),
				'button_status' => $button_status,
			);
			
			$data['grand_total'] = $data['grand_total'] + $total;
			$data['grand_total_seller'] = $data['grand_total_seller'] + $selleramount;
			$data['grand_total_paid'] = $data['grand_total_paid'] + $paid;
			$data['grand_total_admin'] = $data['grand_total_admin'] + $admin;
			$data['grand_total_rem'] = $data['grand_total_rem'] + $rem;

			$total_row++;
		}

		if($data['order'] == 'customer' || $data['order'] == 'admin' || $data['order'] == 'total') {
			if($sort == 'asc') {
				sort($data['income_details']);
			} else {
				rsort($data['income_details']);
			}
		}

		$data['grand_total'] = number_format($data['grand_total'],2);
		$data['grand_total_seller'] = number_format($data['grand_total_seller'],2);
		$data['grand_total_paid'] = number_format($data['grand_total_paid'],2);
		$data['grand_total_admin'] = number_format($data['grand_total_admin'],2);
		$data['grand_total_rem'] = number_format($data['grand_total_rem'],2);

		$pagination = new Pagination();
		$pagination->total = $total_row;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('customerpartner/income', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($total_row) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($total_row - $this->config->get('config_limit_admin'))) ? $total_row : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $total_row, ceil($total_row / $this->config->get('config_limit_admin')));


		$data['seller_name_url'] = $this->url->link("customerpartner/income","token=".$this->session->data['token'] . $url ."&order=c.firstname&sort=".$sort, 'SSL');

		$data['seller_commission_url'] = $this->url->link("customerpartner/income","token=".$this->session->data['token'] . $url ."&order=cp2c.commission&sort=".$sort, 'SSL');

		$data['total_url'] = $this->url->link("customerpartner/income","token=".$this->session->data['token'] . $url ."&order=total&sort=".$sort, 'SSL');

		$data['customer_url'] = $this->url->link("customerpartner/income","token=".$this->session->data['token'] . $url ."&order=customer&sort=".$sort, 'SSL');

		$data['admin_url'] = $this->url->link("customerpartner/income","token=".$this->session->data['token'] . $url ."&order=admin&sort=".$sort, 'SSL');

		// $data['seller_name_url'] = $this->url->link("customerpartner/income","token=".$this->session->data['token'] . $url ."&order=cp2c.commission&sort=".$sort, 'SSL');
        
        // echo "<pre>";
        // print_r($data);
        // die();
		$data['header'] = $this->load->Controller('common/header');
		$data['footer'] = $this->load->Controller('common/footer');
		$data['column_left'] = $this->load->Controller('common/column_left');

		$this->response->setOutput($this->load->view("customerpartner/income.tpl",$data));
	}

}
?>