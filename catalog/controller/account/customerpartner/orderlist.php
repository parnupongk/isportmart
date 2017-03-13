<?php
class ControllerAccountCustomerpartnerOrderlist extends Controller {

	private $error = array();
	private $data = array();

	public function index() {
		
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/customerpartner/orderlist', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/customerpartner');

		$this->data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();	
			
		if(!$this->data['chkIsPartner'])
			$this->response->redirect($this->url->link('account/account'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');		
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/MP/sell.css');	

		$this->language->load('account/customerpartner/orderlist');
		$this->document->setTitle($this->language->get('heading_title'));

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),     	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account'),     	
        	'separator' => $this->language->get('text_separator')
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_productlist'),
			'href'      => $this->url->link('account/customerpartner/orderlist', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);

		$this->load->model('tool/image');

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');		
		$this->data['text_orderid'] = $this->language->get('text_orderid');
		$this->data['text_added_date'] = $this->language->get('text_added_date');
		$this->data['text_products'] = $this->language->get('text_products');
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_action'] = $this->language->get('text_action');
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['text_processing'] = $this->language->get('text_processing');
		$this->data['text_shipped'] = $this->language->get('text_shipped');
		$this->data['text_canceled'] = $this->language->get('text_canceled');
		$this->data['text_complete'] = $this->language->get('text_complete');
		$this->data['text_denied'] = $this->language->get('text_denied');
		$this->data['text_canceled_reversal'] = $this->language->get('text_canceled_reversal');
		$this->data['text_failed'] = $this->language->get('text_failed');
		$this->data['text_refunded'] = $this->language->get('text_refunded');
		$this->data['text_reversed'] = $this->language->get('text_reversed');
		$this->data['text_chargeback'] = $this->language->get('text_chargeback');
		$this->data['text_pending'] = $this->language->get('text_pending');
		$this->data['text_voided'] = $this->language->get('text_voided');
		$this->data['text_processed'] = $this->language->get('text_processed');
		$this->data['text_expired'] = $this->language->get('text_expired');

		$this->data['button_filter'] = $this->language->get('button_filter');
		
		if (isset($this->request->get['filter_order'])) {
			$filter_order = $this->request->get['filter_order'];
		} else {
			$filter_order = null;
		}

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_date'])) {
			$filter_date = $this->request->get['filter_date'];
		} else {
			$filter_date = null;
		}

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
		
		$data = array(
			'filter_order'    => $filter_order,
			'filter_name'	  => $filter_name,		
			'filter_status'   => $filter_status,
			'filter_date'	  => $filter_date,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * 10,
			'limit'           => 10
		);
				
		$orders = $this->model_account_customerpartner->getSellerOrders($data);
		
		$orderstotal = $this->model_account_customerpartner->getSellerOrdersTotal($data);	

		if($orders){
		
			foreach($orders as $key => $order_list){

				$products = $this->model_account_customerpartner->getSellerOrderProducts($order_list['order_id']);

				$marketplace_complete_order_status = $this->config->get('marketplace_complete_order_status');
				$marketplace_cancel_order_status = $this->config->get('marketplace_cancel_order_status');

				$order_product_status = array();

				$orders[$key]['products'] = $products;
				$orders[$key]['productname'] = '';
				$orders[$key]['total'] = 0;

				if($products){
					foreach ($products as $key2 => $value) {
						$orders[$key]['productname'] = $orders[$key]['productname'].$value['name'].' x '.$value['quantity'].' , ';
						$orders[$key]['total'] += $value['c2oprice'];

						// array_push($order_product_status, $value['order_product_status']);
					}
				}

				// case -1
				// $check_equal_order_status = array_unique($order_product_status);

				// if (count($check_equal_order_status) == 1) {
					
				// 	$data['seller_whole_order_status'] = $check_equal_order_status[0];
				// }else{



				// }	

				$orders[$key]['total'] = $this->currency->format($orders[$key]['total'],$orders[$key]['currency_code'],$orders[$key]['currency_value']);
				$orders[$key]['productname'] = substr($orders[$key]['productname'], 0, -2);

				$orders[$key]['orderidlink']= $this->url->link('account/customerpartner/orderinfo&order_id='.$order_list['order_id'],'','SSL');			
				
			}
			
		}

		$this->data['orders'] = $orders;

		$this->load->model('localisation/order_status');
		$this->data['status'] = $this->model_localisation_order_status->getOrderStatuses();

		$url = '';

		if (isset($this->request->get['filter_order'])) {
			$url .= '&filter_order=' . $this->request->get['filter_order'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_order'] = $this->url->link('account/customerpartner/orderlist', '' . '&sort=o.order_id' . $url, 'SSL');		
		$this->data['sort_name'] = $this->url->link('account/customerpartner/orderlist', '' . '&sort=o.firstname' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('account/customerpartner/orderlist', '' . '&sort=os.name' . $url, 'SSL');		
		$this->data['sort_date'] = $this->url->link('account/customerpartner/orderlist', '' . '&sort=o.date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_order'])) {
			$url .= '&filter_order=' . $this->request->get['filter_order'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

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

		$this->data['pagination'] = $pagination->render();
		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($orderstotal) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($orderstotal - 10)) ? $orderstotal : ((($page - 1) * 10) + 10), $orderstotal, ceil($orderstotal / 10));		

		$this->data['filter_order'] = $filter_order;	
		$this->data['filter_name'] = $filter_name;		
		$this->data['filter_status'] = $filter_status;	
		$this->data['filter_date'] = $filter_date;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;		
			
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['current'] = $this->url->link('account/customerpartner/orderlist', '', 'SSL');

		$this->data['back'] = $this->url->link('account/account', '', 'SSL');

		$this->data['isMember'] = true;
		if($this->config->get('wk_seller_group_status')) {
      		$this->data['wk_seller_group_status'] = true;
      		$this->load->model('account/customer_group');
			$isMember = $this->model_account_customer_group->getSellerMembershipGroup($this->customer->getId());
			if($isMember) {
				$allowedAccountMenu = $this->model_account_customer_group->getaccountMenu($isMember['gid']);
				if($allowedAccountMenu['value']) {
					$accountMenu = explode(',',$allowedAccountMenu['value']);
					if($accountMenu && !in_array('orderhistory:orderhistory', $accountMenu)) {
						$this->data['isMember'] = false;
					}
				}
			} else {
				$this->data['isMember'] = false;
			}
      	} else {
      		if(!in_array('orderhistory', $this->config->get('marketplace_allowed_account_menu'))) {
      			$this->response->redirect($this->url->link('account/account','', 'SSL'));
      		}
      	}

		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['column_right'] = $this->load->controller('common/column_right');
		$this->data['content_top'] = $this->load->controller('common/content_top');
		$this->data['content_bottom'] = $this->load->controller('common/content_bottom');
		$this->data['footer'] = $this->load->controller('common/footer');
		$this->data['header'] = $this->load->controller('common/header');
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/orderlist.tpl')) {
			$this->response->setOutput($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/orderlist.tpl' , $this->data));			
		} else {
			$this->response->setOutput($this->load->view('default/template/account/customerpartner/orderlist.tpl' , $this->data));
		}

	}
}
?>
