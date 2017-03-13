<?php
class ControllerAccountCustomerpartnerOrderdetail extends Controller {

	private $error = array();

	public function index() {

		$data = array();
		$data = array_merge($data,$this->load->language('account/customerpartner/order_detail'));

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/customerpartner/order_detail', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/customerpartner');

		$this->document->setTitle($data['heading_title']);

      	$data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
        	'text'      => $data['text_home'],
			'href'      => $this->url->link('common/home'),     	
      	); 

      	$data['breadcrumbs'][] = array(
        	'text'      => $data['text_account'],
			'href'      => $this->url->link('account/account'),     	
      	); 

      	$data['breadcrumbs'][] = array(
			'text' => $data['text_orderinfo'],
			'href' => $this->url->link('account/order/info', 'order_id=' . $this->request->get['order_id'], 'SSL')
		);

      	$data['breadcrumbs'][] = array(
        	'text'      => $data['text_orderdetaillist'],
			'href'      => $this->url->link('account/customerpartner/order_detail', '', 'SSL'),       	
      	);

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.firstname';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$filter_array = array(
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * 10,
			'limit'           => 10
		);
				
		$orders = $this->model_account_customerpartner->getOrderDetails($filter_array,$this->request->get['order_id'],$this->request->get['product_id']);

		$orderstotal = $this->model_account_customerpartner->getOrderDetailsTotal($filter_array,$this->request->get['order_id'],$this->request->get['product_id']);	

		$data['orders'] = $orders;

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_dateadded'] = $this->url->link('account/customerpartner/order_detail', '' . '&sort=date_added&order_id='.$this->request->get['order_id'].'&product_id='.$this->request->get['product_id'].'' . $url, 'SSL');		

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $orderstotal;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/customerpartner/orderlist'.$url,'&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($data['text_pagination'], ($orderstotal) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($orderstotal - 10)) ? $orderstotal : ((($page - 1) * 10) + 10), $orderstotal, ceil($orderstotal / 10));		

		$data['sort'] = $sort;
		$data['order'] = $order;		

		$data['current'] = $this->url->link('account/customerpartner/order_detail', '', 'SSL');

		$data['back'] = $this->url->link('account/account', '', 'SSL');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/order_detail.tpl')) {
			$this->response->setOutput($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/order_detail.tpl' , $data));			
		} else {
			$this->response->setOutput($this->load->view('default/template/account/customerpartner/order_detail.tpl' , $data));
		}

	}
}
?>
