<?php
class ControllerReportCustomerHistory extends Controller {
	public function index() {
		$this->load->language('report/customer_history');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_comment'])) {
			$filter_comment = $this->request->get['filter_comment'];
		} else {
			$filter_comment = null;
		}

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode($this->request->get['filter_customer']);
		}

		if (isset($this->request->get['filter_comment'])) {
			$url .= '&filter_comment=' . $this->request->get['filter_comment'];
		}

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_home')
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('report/customer_history', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'text' => $this->language->get('heading_title')
		);

		$this->load->model('report/customer');

		$data['histories'] = array();

		$filter_data = array(
			'filter_customer'   => $filter_customer,
			'filter_comment'         => $filter_comment,
			'filter_date_start'	=> $filter_date_start,
			'filter_date_end'	=> $filter_date_end,
			'start'             => ($page - 1) * 20,
			'limit'             => 20
		);

		$history_total = $this->model_report_customer->getTotalCustomerHistory($filter_data);

		$results = $this->model_report_customer->getCustomerHistory($filter_data);

		foreach ($results as $result) {
			//$custinfo = vsprintf($this->language->get('text_' . $result['key']), unserialize($result['data']));
			//$custinfo = $result['customer_name'];
			
			if ( strlen( $result['user_info'] ) == 0 ) {
				$user_info = $result['user_id'];
			} else {
				$user_info = $result['user_info'];
			} 
			
			if ($result['order_id'] == '0' ) {
				$custinfo = "<a href='customer_id=".$result['customer_id']."'>" . $result['customer_name'] . "</a>  ";
				//$custinfo = "<a href='customer_id=".$result['customer_id']."'>" . $result['customer_name'] . "</a>  with  <a href='order_id=".$result['order_id']."'>Order_ID#" .$result['order_id'] . "</a> ";
				$custinfo_order = "";
			} else {
				//$custinfo = "<a href='customer_id=".$result['customer_id']."'>" . $result['customer_name'] . "</a>  with  <a href='order_id=".$result['order_id']."'>Order_ID#" .$result['order_id'] . "</a> ";
				$custinfo = "<a href='customer_id=".$result['customer_id']."'>" . $result['customer_name'] . "</a>  ";
				$custinfo_order = "<a href='order_id=".$result['order_id']."'>Order_ID#" .$result['order_id'] . "</a> ";
			}
			
			$find = array(
				'customer_id=',
				'order_id='
			);

			$replace = array(
				$this->url->link('sale/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=', 'SSL'),
				$this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=', 'SSL')
			);

			$data['histories'][] = array(
				//'comment'    => str_replace($find, $replace, $comment),
				'customer_name'    => str_replace($find, $replace, $custinfo),
				'customer_order'    => str_replace($find, $replace, $custinfo_order), //Kit Add 9/4/2106
				'comment'         => $result['comment'],
				'user_info'         => $user_info,
				'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added']))
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_customer_name'] = $this->language->get('column_customer_name');
		$data['column_customer_order'] = $this->language->get('column_customer_order'); // Kit add 9/4/2106
		$data['column_comment'] = $this->language->get('column_comment');
		$data['column_user_info'] = $this->language->get('column_user_info');
		//$data['column_ip'] = $this->language->get('column_ip');
		$data['column_date_added'] = $this->language->get('column_date_added');

		$data['entry_customer'] = $this->language->get('entry_customer');
		//$data['entry_ip'] = $this->language->get('entry_ip');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');

		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		$url = '';

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode($this->request->get['filter_customer']);
		}

		if (isset($this->request->get['filter_comment'])) {
			$url .= '&filter_comment=' . $this->request->get['filter_comment'];
		}

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('report/customer_history', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($history_total - $this->config->get('config_limit_admin'))) ? $history_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $history_total, ceil($history_total / $this->config->get('config_limit_admin')));

		$data['filter_customer'] = $filter_customer;
		$data['filter_comment'] = $filter_comment;
		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('report/customer_history.tpl', $data));
	}
}