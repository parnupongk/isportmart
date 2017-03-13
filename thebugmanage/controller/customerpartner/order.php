<?php
class ControllerCustomerpartnerOrder extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('customerpartner/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customerpartner/order');

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_order_status'])) {
			$filter_order_status = $this->request->get['filter_order_status'];
		} else {
			$filter_order_status = null;
		}

		if (isset($this->request->get['filter_order_access'])) {
			$filter_order_access = $this->request->get['filter_order_access'];
		} else {
			$filter_order_access = null;
		}

		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_order_access'])) {
			$url .= '&filter_order_access=' . $this->request->get['filter_order_access'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('customerpartner/order', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['orders'] = array();

		$filter_data = array(
			'filter_order_id'      => $filter_order_id,
			'filter_customer'	   => $filter_customer,
			'filter_order_status'  => $filter_order_status,
			'filter_order_access'  => $filter_order_access,
			'filter_total'         => $filter_total,
			'filter_date_added'    => $filter_date_added,
			'filter_date_modified' => $filter_date_modified,
			'sort'                 => $sort,
			'order'                => $order,
			'start'                => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_customerpartner_order->getTotalOrders($filter_data);

		$results = $this->model_customerpartner_order->getOrders($filter_data);

		foreach ($results as $result) {
			$data['orders'][] = array(
				'order_id'      => $result['order_id'],
				'customer'      => $result['customer'],
				'status'        => $result['status'],
				'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'shipping_code' => $result['shipping_code'],
				'view'          => $this->url->link('customerpartner/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL'),
				'edit'          => $this->url->link('customerpartner/order/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL'),
				'seller_access' => $result['seller_access'],
				'access'        => $this->url->link('customerpartner/order/access', 'token=' . $this->session->data['token']. '&seller_access=' . $result['seller_access'] . $url, 'SSL'),
			);
		}

		$data['access'] = $this->url->link('customerpartner/order/access', 'token=' . $this->session->data['token'] . '&seller_access=0' . $url, 'SSL');
		$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_missing'] = $this->language->get('text_missing');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_access'] = $this->language->get('text_access');
		$data['text_notaccess'] = $this->language->get('text_notaccess');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_seller_access'] = $this->language->get('column_seller_access');

		$data['entry_return_id'] = $this->language->get('entry_return_id');
		$data['entry_order_id'] = $this->language->get('entry_order_id');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_date_modified'] = $this->language->get('entry_date_modified');

		$data['button_invoice_print'] = $this->language->get('button_invoice_print');
		$data['button_shipping_print'] = $this->language->get('button_shipping_print');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_ip_add'] = $this->language->get('button_ip_add');
		$data['button_access'] = $this->language->get('button_access');
		$data['button_notaccess'] = $this->language->get('button_notaccess');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_save'] = $this->language->get('button_save');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_order'] = $this->url->link('customerpartner/order', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
		$data['sort_customer'] = $this->url->link('customerpartner/order', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('customerpartner/order', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_access'] = $this->url->link('customerpartner/order', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_total'] = $this->url->link('customerpartner/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('customerpartner/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
		$data['sort_date_modified'] = $this->url->link('customerpartner/order', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('customerpartner/order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_order_id'] = $filter_order_id;
		$data['filter_customer'] = $filter_customer;
		$data['filter_order_status'] = $filter_order_status;
		$data['filter_order_access'] = $filter_order_access;
		$data['filter_total'] = $filter_total;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_date_modified'] = $filter_date_modified;

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['store'] = HTTPS_CATALOG;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customerpartner/order_list.tpl', $data));
	}

	public function info() {

		$data = array();
		$data = array_merge($data,$this->load->language('customerpartner/order'));
		$this->load->model('customerpartner/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_customerpartner_order->getOrder($order_id);

		if ($order_info) {

			if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
				if($order_id){

					if(isset($this->request->post['tracking'])){
						$this->model_customerpartner_order->addOdrTracking($order_id,$this->request->post['tracking']);
						$this->session->data['success'] = $this->language->get('text_success');
					}

			 		$this->response->redirect($this->url->link('customerpartner/order/info&order_id='.$order_id,'token=' . $this->session->data['token'], 'SSL'));	
				}			
			
			}

			if(isset($this->session->data['success'])){
				$data['success'] = $this->session->data['success'];
				unset($this->session->data['success']);
			}else{
				$data['success'] = '';
			}

			$data['order_id'] = $order_id;

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$url = '';

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $data['text_home'],
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
			);

			$data['breadcrumbs'][] = array(
				'text' => $data['heading_title'],
				'href' => $this->url->link('customerpartner/order', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);

			$data['cancel'] = $this->url->link('customerpartner/order', 'token=' . $this->session->data['token'] . $url, 'SSL');

			$data['wksellerorderstatus'] = $this->config->get('marketplace_sellerorderstatus'); 

			if ($order_info['invoice_no']) {
				$data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}
	
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
			
			if ($order_info['payment_address_format']) {
      			$format = $order_info['payment_address_format'];
    		} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
		
    		$find = array(
	  			'{firstname}',
	  			'{lastname}',
	  			'{company}',
      			'{address_1}',
      			'{address_2}',
     			'{city}',
      			'{postcode}',
      			'{zone}',
				'{zone_code}',
      			'{country}'
			);
	
			$replace = array(
	  			'firstname' => $order_info['payment_firstname'],
	  			'lastname'  => $order_info['payment_lastname'],
	  			'company'   => $order_info['payment_company'],
      			'address_1' => $order_info['payment_address_1'],
      			'address_2' => $order_info['payment_address_2'],
      			'city'      => $order_info['payment_city'],
      			'postcode'  => $order_info['payment_postcode'],
      			'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
      			'country'   => $order_info['payment_country']  
			);
			
			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

      		$data['payment_method'] = $order_info['payment_method'];
			
			if ($order_info['shipping_address_format']) {
      			$format = $order_info['shipping_address_format'];
    		} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
		
    		$find = array(
	  			'{firstname}',
	  			'{lastname}',
	  			'{company}',
      			'{address_1}',
      			'{address_2}',
     			'{city}',
      			'{postcode}',
      			'{zone}',
				'{zone_code}',
      			'{country}'
			);
	
			$replace = array(
	  			'firstname' => $order_info['shipping_firstname'],
	  			'lastname'  => $order_info['shipping_lastname'],
	  			'company'   => $order_info['shipping_company'],
      			'address_1' => $order_info['shipping_address_1'],
      			'address_2' => $order_info['shipping_address_2'],
      			'city'      => $order_info['shipping_city'],
      			'postcode'  => $order_info['shipping_postcode'],
      			'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
      			'country'   => $order_info['shipping_country']  
			);

			$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['shipping_method'] = $order_info['shipping_method'];
			
			$data['products'] = array();

			$products = $this->model_customerpartner_order->getSellerOrderProducts($order_id);

			// Uploaded files
			$this->load->model('tool/upload');

      		foreach ($products as $product) {
				$option_data = array();
				
				$options = $this->model_customerpartner_order->getOrderOptions($order_id, $product['order_product_id']);

         		 // code changes due to download file error
         		foreach ($options as $option) {
          			if ($option['type'] != 'file') {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $option['value'],
							'type'  => $option['type']
						);
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);
						if ($upload_info) {
							$option_data[] = array(
								'name'  => $option['name'],
								'value' => $upload_info['name'],
								'type'  => $option['type'],
								'href'  => $this->url->link('account/customerpartner/orderinfo/download','&code=' . $upload_info['code'], 'SSL')
							);
						}
					}
        		}

        		$product_tracking = $this->model_customerpartner_order->getOdrTracking($data['order_id'],$product['product_id']);

        		if($product['paid_status'] == 1) {
        			$paid_status = $this->language->get('text_paid');
        		} else {
        			$paid_status = $this->language->get('text_not_paid');
        		}

        		$data['products'][] = array(
          			'product_id'     => $product['product_id'],
          			'name'     => $product['name'],
          			'model'    => $product['model'],
          			'option'   => $option_data,
          			'tracking' => isset($product_tracking['tracking']) ? $product_tracking['tracking'] : '',
          			'quantity' => $product['quantity'],
          			'paid_status' => $paid_status,
          			'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'order_product_status' => $product['order_product_status'],
        		);
      		}

			// Voucher
			$data['vouchers'] = array();
			
			$vouchers = $this->model_customerpartner_order->getOrderVouchers($order_id);
			
			foreach ($vouchers as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}
			
      		$data['totals'] = array();

      		$totals = $this->model_customerpartner_order->getOrderTotals($order_id);

      		if($totals AND isset($totals[0]['total']))      			
				$data['totals'][]['total'] = $this->currency->format($totals[0]['total'], $order_info['currency_code'], 1);
			
			$data['comment'] = nl2br($order_info['comment']);
			
			$data['histories'] = array();

			$results = $this->model_customerpartner_order->getOrderHistories($order_id);

      		foreach ($results as $result) {
        		$data['histories'][] = array(
          			'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
          			'status'     => $result['status'],
          			'comment'    => nl2br($result['comment'])
        		);
      		}      		
      		
      		//list of status

      		$this->load->model('localisation/order_status');
      		
      		if($this->config->get('marketplace_available_order_status')) {
      			$data['marketplace_available_order_status'] = $this->config->get('marketplace_available_order_status');
      			$data['marketplace_order_status_sequence'] = $this->config->get('marketplace_order_status_sequence');
      		}

      		if ($this->config->get('marketplace_cancel_order_status') && $this->config->get('marketplace_available_order_status')) {

      			$data['marketplace_cancel_order_status'] = $this->config->get('marketplace_cancel_order_status');
      	
      			$cancel_order_statusId_key =  array_search($this->config->get('marketplace_cancel_order_status'),$data['marketplace_available_order_status'],true);

      			if ($cancel_order_statusId_key == 0 || $cancel_order_statusId_key) {
      			    
      			    unset($data['marketplace_available_order_status'][$cancel_order_statusId_key]);

      			}

      			foreach ($data['marketplace_order_status_sequence'] as $key => $value) {
      				
                   if ($value['order_status_id'] == $this->config->get('marketplace_cancel_order_status')) {
                   	   
                   	   unset($data['marketplace_order_status_sequence'][$key]);
                   
                   }
      			}

      		}else{
      			$data['marketplace_cancel_order_status'] = '';
      		}

      		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

      		$data['order_status_id'] = $order_info['order_status_id'];

      		$data['token'] = $this->session->data['token'];

      		$data['action'] = $this->url->link('customerpartner/order/info&order_id='.$order_id,'token=' . $this->session->data['token'], 'SSL');

      		$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('customerpartner/order_info.tpl', $data));
			
		} else {
			$this->load->language('error/not_found');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_not_found'] = $this->language->get('text_not_found');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL')
			);

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('error/not_found.tpl', $data));
		}
	}

	public function history() {

		$this->language->load('customerpartner/order');				
		$this->load->model('customerpartner/order');
		$this->load->model('catalog/product');

		$product_names = array();
		$json = array();

		if ($this->config->get('marketplace_cancel_order_status')) {
			$marketplace_cancel_order_status = $this->config->get('marketplace_cancel_order_status');
		}else{
			$marketplace_cancel_order_status = '';
		}

		$this->load->model('localisation/order_status');
        $order_statuses = $this->model_localisation_order_status->getOrderStatuses();
        if (isset($this->request->post['comment']) && !empty($this->request->post['comment']) && empty($this->request->post['product_ids'])) {

            $getOrderStatusId = $this->model_customerpartner_order->getOrderStatusId($this->request->get['order_id']);

        	$this->request->post['order_status_id'] = $getOrderStatusId['order_status_id'];

        	$this->model_customerpartner_order->addOrderHistory($this->request->get['order_id'],$this->request->post);

        	$json['success'] = $this->language->get('text_success_history');


        }elseif(isset($this->request->post['product_ids']) && !empty($this->request->post['product_ids'])){

        	$products = explode(",", $this->request->post['product_ids']);

        	foreach ($products as $value) {
		       	 $product_details = $this->model_catalog_product->getProduct($value);
		       	 $product_names[] = $product_details['name']; 
		    }

            $product_name = implode(",",$product_names);

        	foreach ($order_statuses as $value) {

				if (in_array($this->request->post['order_status_id'], $value)) {
					
					$seller_change_order_status_name = $value['name'];

				}
			}

        	if ($this->request->post['order_status_id'] == $marketplace_cancel_order_status) {
   		 
        		 $this->changeOrderStatus($this->request->get,$this->request->post,$products,$marketplace_cancel_order_status,$seller_change_order_status_name);

        	}else{

        		 $this->changeOrderStatus($this->request->get,$this->request->post,$products,$marketplace_cancel_order_status,$seller_change_order_status_name);
                 
        	}


        	$json['success'] = $this->language->get('text_success_history');

        }else{

        	$json['error'] = $this->language->get('error_product_select');
        }

        $this->response->setOutput(json_encode($json));
	}

	private function changeOrderStatus($get,$post,$products,$marketplace_cancel_order_status,$seller_change_order_status_name){


         /**
          * First step - Add seller changing status for selected products
          */
	     $this->model_customerpartner_order->addsellerorderproductstatus($get['order_id'],$post['order_status_id'],$products);


	     // Second Step - add comment for each selected products
		 $this->model_customerpartner_order->addSellerOrderStatus($get['order_id'],$post['order_status_id'],$post,$products,$seller_change_order_status_name);
        
         // Thired Step - Get status Id that will be the whole order status id after changed the order product status by seller
		 $getWholeOrderStatus = $this->model_customerpartner_order->getWholeOrderStatus($get['order_id'],$marketplace_cancel_order_status);

         
         // Fourth Step - add comment in order_history table and send mails to admin(If admin notify is enable) and customer
		 $this->model_customerpartner_order->addOrderHistory($get['order_id'],$post,$seller_change_order_status_name);
         

         // Fifth Step - Update whole order status in order table
         if ($getWholeOrderStatus) {
             $this->model_customerpartner_order->changeWholeOrderStatus($get['order_id'],$getWholeOrderStatus);	
         }

  	}

  	public function access(){

  		$this->load->language('customerpartner/order');
  		$this->load->model('customerpartner/order');

		if (isset($this->request->post['selected']) && $this->validate()) {
			foreach ($this->request->post['selected'] as $order_id) {

				if ($this->request->get['seller_access']) {
				    
				    $this->model_customerpartner_order->giveAccess($order_id, 0);	
				}else{
					$this->model_customerpartner_order->giveAccess($order_id, 1);	
				}
			}

			$this->session->data['success'] = $this->language->get('text_success_access');

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_order_status'])) {
				$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
			}

			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('customerpartner/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->response->redirect($this->url->link('customerpartner/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
  	}

  	protected function validate() {

		if (!$this->user->hasPermission('modify', 'customerpartner/order')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

}
