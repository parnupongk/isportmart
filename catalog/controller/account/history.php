<?php
class ControllerAccountHistory extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/history', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		$this->load->model('account/customer');
			$customer_search = $this->model_account_customer->getCustomerByANI($this->session->data['cust_ani']);	
		$this->load->language('account/account');
		$this->document->setTitle($this->language->get('heading_title_history'));
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_history'),
			'href'      => $this->url->link('account/history', '', 'SSL')
		);
		
	$this->load->model('account/order');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')&& $this->validate()) {
			$this->model_account_order->AddCustomerHistories($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('account/history', '', 'SSL'));
		}
		$data['heading_title_history'] = $this->language->get('heading_title_history');
//nid add 24/03/2016 11:44
if (isset($this->error['comment'])) {
			$data['error_comment'] = $this->error['comment'];
		} else {
			$data['error_comment'] = '';
		}
if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
			$this->session->data['order_id'] = $order_id;
		} else {
			$order_id = 0;
		}
if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$filter_data = array(
			'customer_id' => $customer_search['customer_id'],
			'order_id' => $order_id, 
			'order' => 'DESC',
			'start' => ($page - 1) * 5,
			'limit' => 5
		);
		$data['cust_ani'] = $this->session->data['cust_ani'];
		$data['agent_id'] = $this->session->data['agent_id'];
		$data['cust_id'] = $customer_search['customer_id'];
		$data['order_id'] = $order_id;
		
		$data['history_title'] = $this->language->get('history_title');
    $data['button_history_add'] = $this->language->get('button_history_add');
		$data['text_history'] = $this->language->get('text_history');
		$data['text_detail'] = $this->language->get('text_detail');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');
		//nid add 30/3/2016 11:18
		$this->load->language('account/order');
		$data['column_date_added']	= $this->language->get('column_date_added');
		$data['column_comment']	= $this->language->get('column_comment');
		$data['column_userid']	= $this->language->get('column_userid');
		$data['column_orderid']	= $this->language->get('column_orderid');
		//nid add 30/3/2016 11:18
		$data['history'] = $this->url->link('account/history', '', 'SSL');
		$this->load->model('account/order');
		$data['histories'] = array();
		$results = $this->model_account_order->getCustomerHistories($filter_data);

			foreach ($results as $result) {
				$data['histories'][] = array(
				  'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added'])),//date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'comment'    => nl2br(utf8_encode($result['comment'])),
					'user_id'    => $result['user_id'],
					'order_id'    => $result['order_id']
				);
			}
		$transaction_total = $this->model_account_order->getTotalHistories($filter_data);
	  $data['action'] = $this->url->link('account/history', '', 'SSL');
	  $data['back'] = $this->url->link('account/account', '', 'SSL');
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->url = $this->url->link('account/history','agent_id='.$this->session->data['agent_id'].'&ani='.$this->session->data['cust_ani'].'&order_id='.$order_id. '&page={page}', 'SSL');
		
		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($transaction_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($transaction_total - 5)) ? $transaction_total : ((($page - 1) * 5) + 5), $transaction_total, ceil($transaction_total / 5));

		//koy add 26/5/2016
		if (isset($this->session->data['agent_id'])) {
			$this->response->setOutput($this->load->view('default/template/account/history.tpl', $data));
		} elseif (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/history.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/history.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/history.tpl', $data));
		}
	}
	protected function validate() {
		if ((utf8_strlen(trim($this->request->post['comment'])) < 1) || (utf8_strlen(trim($this->request->post['comment'])) > 32)) {
			$this->error['comment'] = $this->language->get('error_comment');
		}
		return !$this->error;
	}
}