<?php    
class ControllerCustomerpartnerTransaction extends Controller { 

	private $error = array();
	private $data = array();
  
  	public function index() {		
    	$this->getlist();
  	}  	  
  	
  	public function getlist() {	

		$this->load->language('customerpartner/transaction');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('customerpartner/transaction');

		$filter_array = array(
							  'filter_id',
							  'filter_name',
							  'filter_details',
							  'filter_date',
							  'filter_amount',
							  'page',
							  'sort',
							  'order',
							  'start',
							  'limit',							  
							  );
		
		$url = '';

		foreach ($filter_array as $unsetKey => $key) {

			if (isset($this->request->get[$key])) {
				$filter_array[$key] = $this->request->get[$key];				
			} else {
				if ($key=='page')
					$filter_array[$key] = 1;
				elseif($key=='sort')
					$filter_array[$key] = 'cc.id';
				elseif($key=='order')
					$filter_array[$key] = 'ASC';
				elseif($key=='start')
					$filter_array[$key] = ($filter_array['page'] - 1) * $this->config->get('config_limit_admin');
				elseif($key=='limit')
					$filter_array[$key] = $this->config->get('config_limit_admin');				
				else
					$filter_array[$key] = null;
			}
			unset($filter_array[$unsetKey]);	

			if(isset($this->request->get[$key])){
				if ($key=='filter_name' || $key=='filter_details' || $key=='filter_date') 
					$url .= '&'.$key.'=' . urlencode(html_entity_decode($filter_array[$key], ENT_QUOTES, 'UTF-8'));
				else
					$url .= '&'.$key.'='. $filter_array[$key];
			}
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token']. $url, 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('customerpartner/transaction', 'token=' . $this->session->data['token']. $url, 'SSL'), 		
      		'separator' => ' :: '
   		);		
				
		$this->data['delete'] = $this->url->link('customerpartner/transaction/delete', 'token=' . $this->session->data['token'] , 'SSL');
		$this->data['insert'] = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token'] , 'SSL');

    	$results = $this->model_customerpartner_transaction->viewtotal($filter_array);
    	
		$product_total = $this->model_customerpartner_transaction->viewtotalentry($filter_array);				

		$lang_array = array('heading_title',
							'entry_id',
							'entry_transaction',
							'entry_details',
							'entry_amount',
							'entry_date',
							'entry_seller',

							'text_confirm',

							'button_back',
							'button_save',
							'button_cancel',
							'button_insert',
							'button_delete',
							'button_filter',
							);

		foreach($lang_array as $language){
			$this->data[$language] = $this->language->get($language);
		}

		$this->data['transactions'] = array();

	    foreach ($results as $result) {		
			
	      	$this->data['transactions'][] = array(
				'selected'=>False,
				'id' => $result['id'],
				'name' => $result['name'],
				'value' => $result['text'],
				'details' => $result['details'],			
				'date' => $result['date_added'],	
			);
          	
		}		
		
 		$this->data['token'] = $this->session->data['token'];
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = '';

		foreach ($filter_array as $key => $value) {
			if(isset($this->request->get[$key])){
				if(!isset($this->request->get['order']) AND isset($this->request->get['sort']))
					$url .= '&order=DESC';
				if ($key=='filter_name' || $key=='filter_details' || $key=='filter_date') 
					$url .= '&'.$key.'=' . urlencode(html_entity_decode($filter_array[$key], ENT_QUOTES, 'UTF-8'));
				elseif($key=='order')				
					$url .= $value=='ASC' ? '&order=DESC' : '&order=ASC';			
				elseif($key!='start' AND $key!='limit' AND $key!='sort')
					$url .= '&'.$key.'='. $filter_array[$key];
			}
		}

		$this->data['sort_name'] = $this->url->link('customerpartner/transaction', 'token=' . $this->session->data['token'] . '&sort=c.firstname' . $url, 'SSL');
		$this->data['sort_id'] = $this->url->link('customerpartner/transaction', 'token=' . $this->session->data['token'] . '&sort=ct.id' . $url, 'SSL');
		$this->data['sort_date'] = $this->url->link('customerpartner/transaction', 'token=' . $this->session->data['token'] . '&sort=ct.date_added' . $url, 'SSL');
		$this->data['sort_details'] = $this->url->link('customerpartner/transaction', 'token=' . $this->session->data['token'] . '&sort=ct.details' . $url, 'SSL');
		$this->data['sort_amount'] = $this->url->link('customerpartner/transaction', 'token=' . $this->session->data['token'] . '&sort=ct.amount' . $url, 'SSL');

		$url = '';

		foreach ($filter_array as $key => $value) {			
			if(isset($this->request->get[$key])){
				if(!isset($this->request->get['order']) AND isset($this->request->get['sort']))
					$url .= '&order=DESC';
				if ($key=='filter_name' || $key=='filter_details' || $key=='filter_date') 
					$url .= '&'.$key.'=' . urlencode(html_entity_decode($filter_array[$key], ENT_QUOTES, 'UTF-8'));						
				elseif($key!='page')
					$url .= '&'.$key.'='. $filter_array[$key];
			}
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $filter_array['page'];
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('customerpartner/transaction', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($filter_array['page'] - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($filter_array['page'] - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($filter_array['page'] - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));
		
		foreach ($filter_array as $key => $value) {
			if($key!='start' AND $key!='end')
				$this->data[$key] = $value;
		}

		// if(isset($this->request->get['action']) && $this->request->get['action'] == '')
			$this->data['header'] = $this->load->controller('common/header');		
			$this->data['footer'] = $this->load->controller('common/footer');	
			$this->data['column_left'] = $this->load->controller('common/column_left');
			$this->response->setOutput($this->load->view('customerpartner/transaction.tpl',$this->data));
  	}
  
  	public function addtransaction() {

  		$this->load->language('customerpartner/transaction');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customerpartner/transaction');

    	$lang_array = array('heading_title',

							'entry_order_id',
							'entry_product_name',
							'entry_payable_amount',
							'entry_quantity',
							'entry_order_date',
							'entry_order_status',
							'entry_transaction_status',
							'entry_details',
							'entry_commission_applied',

							'entry_total',
							'entry_paid',
							'entry_from',
							'entry_to',
							'entry_admin',
							'entry_customer',
							'entry_left_amount',
							'entry_show_limit',

							'text_seller',
							'text_seller_info',
							'text_paid',
							'text_not_paid',
							'text_no_record',

							'button_back',
							'button_save',
							'button_cancel',
							'button_insert',
							'button_delete',
							'button_filter',

							'info_transaction_select',
							'entry_seller_name',
							'entry_seller_email',
							'entry_payable_amount',
							);

		foreach($lang_array as $language){
			$this->data[$language] = $this->language->get($language);
		}

		$post_data = array(
							'customer_id',
							'details',
							'amount',
							);

		$this->data['token'] = $this->session_data['token'];

		$this->load->model('localisation/order_status');
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$url = '';

		if(isset($this->request->get['seller_id'])){
			$this->request->post['customer_id'] = $this->request->get['seller_id'];
			$url .= '&seller_id='.$this->request->get['seller_id'];
		}

		if(isset($this->request->get['order_id'])) {
			$this->data['order_id'] = $filter_array['order_id'] = $this->request->get['order_id'];
			$url .= '&seller_id='.$this->request->get['seller_id'];
		} else{
			$this->data['order_id'] = $filter_array['order_id'] = null;
		}

		if(isset($this->request->get['payable_amount'])) {
			$this->data['payable_amount'] = $filter_array['payable_amount'] = $this->request->get['payable_amount'];
			$url .= '&seller_id='.$this->request->get['seller_id'];
		} else{
			$this->data['payable_amount'] = $filter_array['payable_amount'] = null;
		}

		if(isset($this->request->get['quantity'])) {
			$this->data['quantity'] = $filter_array['quantity'] = $this->request->get['quantity'];
			$url .= '&seller_id='.$this->request->get['seller_id'];
		} else{
			$this->data['quantity'] = $filter_array['quantity'] = null;
		}

		if(isset($this->request->get['date_added_from'])) {
			$this->data['date_added_from'] = $filter_array['date_added_from'] = $this->request->get['date_added_from'];
			$url .= '&seller_id='.$this->request->get['seller_id'];
		} else{
			$this->data['date_added_from'] = $filter_array['date_added_from'] = null;
		}

		if(isset($this->request->get['date_added_to'])) {
			$this->data['date_added_to'] = $filter_array['date_added_to'] = $this->request->get['date_added_to'];
			$url .= '&seller_id='.$this->request->get['seller_id'];
		} else{
			$this->data['date_added_to'] = $filter_array['date_added_to'] = null;
		}

		if(isset($this->request->get['order_status'])) {
			$this->data['order_status'] = $filter_array['order_status'] = $this->request->get['order_status'];
			$url .= '&seller_id='.$this->request->get['seller_id'];
		} else{
			$this->data['order_status'] = $filter_array['order_status'] = null;
		}

		if(isset($this->request->get['paid_status'])) {
			$this->data['paid_status'] = $filter_array['paid_status'] = $this->request->get['paid_status'];
			$url .= '&seller_id='.$this->request->get['seller_id'];
		} else{
			$this->data['paid_status'] = $filter_array['paid_status'] = null;
		}

		if(isset($this->request->get['page'])) {
			$filter_array['page'] = $this->request->get['page'];
			$url .= '&seller_id='.$this->request->get['seller_id'];
		} else{
			$filter_array['page'] = 1;
		}

		if(isset($this->request->get['sort'])) {
			if($this->request->get['sort'] == 'asc') {
				$sort = 'desc';
			} else {
				$sort = 'asc';
			}
		} else {
			$sort = 'asc';
		}
		$this->data['sort'] = $sort;

		if(isset($this->request->get['sort_order'])) {
			$sort_order = $this->request->get['sort_order'];
			$this->data['sort_order'] = $sort_order;
		} else {
			$sort_order = '';
		}

		if(isset($this->request->get['sort_limit'])) {
			$limit = $this->data['limit'] = $this->request->get['sort_limit'];
		} else {
			$limit = $this->data['limit'] = 10;
		}
		// $url .= '&sort_limit='.$limit;

		foreach($post_data as $post){
			if(isset($this->request->post[$post])){
				$this->data[$post] = $this->request->post[$post];
			}else{
				$this->data[$post] = '';
			}
		}

		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		// $url = '';

		$filter_data = array(
			'order_id'           => $filter_array['order_id'],
			'payable_amount'           => $filter_array['payable_amount'],
			'quantity'           => $filter_array['quantity'],
			'date_added_from'           => $filter_array['date_added_from'],
			'date_added_to'           => $filter_array['date_added_to'],
			'order_status'           => $filter_array['order_status'],
			'paid_status'           => $filter_array['paid_status'],
			'start'           => ($filter_array['page'] - 1) * $limit,
			'limit'           => $limit,
			'order_by' => $sort_order,
			'sort_by' => $sort,
		);

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('customerpartner/transaction', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		  
    	$this->data['cancel'] = $this->url->link('customerpartner/income', 'token=' . $this->session->data['token'] , 'SSL');
		$this->data['save'] = $this->url->link('customerpartner/transaction/transactionSave', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if($this->config->get('marketplace_complete_order_status')){
			$this->data['marketplace_complete_order_status'] = $this->config->get('marketplace_complete_order_status');
		} else {
			$this->data['marketplace_complete_order_status']	= '';
		}

		$this->load->model('customerpartner/partner');		

		$this->data['customers'] = $this->model_customerpartner_partner->getCustomer($this->request->get['seller_id']);

		$total_orders = $this->model_customerpartner_partner->getTotalSellerOrders($this->request->get['seller_id'],$filter_data);

		$orders = $this->model_customerpartner_partner->getSellerOrdersList($this->request->get['seller_id'],$filter_data);

		$this->load->model('tool/image');
		
		$this->data['amount'] = 0;
		$this->data['currency_symbol'] = $this->session->data['currency'];
		$this->data['orders'] = array();

		if($orders) {
			foreach ($orders as $key => $order) {

				if($order['paid_status'] == 1) {
					$paid_status = $this->language->get('text_paid');
				} else {
					$paid_status = $this->language->get('text_not_paid');
					if($order['orderstatus']==$this->data['marketplace_complete_order_status'])
						$this->data['amount'] = round( ($this->data['amount'] + $order['need_to_pay']),2 );
				}

				$this->data['orders'][] = array(
					'product_name' => $order['name'],
					'product_value' => $this->model_customerpartner_partner->getProductOptions($order['order_product_id']),
					'price' => $order['need_to_pay'],
					'commission_applied' => $order['commission_applied'],
					'quantity' => $order['quantity'],
					'order_id' => $order['order_id'],
					'order_product_id' => $order['order_product_id'],
					'date_added' => $order['date_added'],
					// 'customer_name' => $order['name'],
					'order_status' => $order['orderstatus'],
					'status' => $order['paid_status'],
					'paid_status' => $paid_status,
				);
			}
		}

		$pagination = new Pagination();
		$pagination->total = $total_orders;
		$pagination->page = $filter_array['page'];
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token'] . '&page={page}' . '&seller_id='.$this->request->get['seller_id'], 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($total_orders) ? (($filter_array['page'] - 1) * $limit) + 1 : 0, ((($filter_array['page'] - 1) * $this->limit) > ($total_orders - $limit)) ? $total_orders : ((($filter_array['page'] - 1) * $limit) + $limit), $total_orders, ceil($total_orders / $limit));

		$this->data['limit_ten'] = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token'] .'&sort_limit=10' . $url , 'SSL');

		$this->data['limit_twentyfive'] = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token']  . '&sort_limit=25' . $url, 'SSL');

		$this->data['limit_fifty'] = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token']  . '&sort_limit=50' . $url, 'SSL');

		$this->data['limit_hundred'] = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token']  . '&sort_limit=100' . $url, 'SSL');

		$this->data['order_id_url'] = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token'] . "&sort_order=op.order_id&sort=". $sort . $url , 'SSL');

		$this->data['product_name_url'] = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token']  . "&sort_order=o.firstname&sort=". $sort . $url, 'SSL');

		$this->data['payable_amount_url'] = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token']  . "&sort_order=c2o.customer&sort=". $sort . $url, 'SSL');

		$this->data['quantity_url'] = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token']  . "&sort_order=op.quantity&sort=". $sort . $url, 'SSL');

		$this->data['date_added_url'] = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token']  . "&sort_order=o.date_added&sort=". $sort . $url , 'SSL');

		$this->data['order_status_url'] = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token']  . "&sort_order=os.name&sort=". $sort . $url, 'SSL');

		$this->data['paid_status_url'] = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token']  . "&sort_order=c2o.paid_status&sort=". $sort . $url, 'SSL');

		$this->data['commission_applied_url'] = $this->url->link('customerpartner/transaction/addtransaction', 'token=' . $this->session->data['token']  . "&sort_order=c2o.commission_applied&sort=". $sort . $url, 'SSL');

		// echo "<pre>";
		// print_r($this->data);
		// die();


		$this->data['header'] = $this->load->controller('common/header');		
		$this->data['footer'] = $this->load->controller('common/footer');	
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->response->setOutput($this->load->view('customerpartner/transaction_form.tpl',$this->data));

	}
	
	public function transactionSave() {
        

    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

    		$this->load->language('customerpartner/transaction');
		
			$this->load->model('customerpartner/transaction');
			
            $amount2pay = 0;
			if (isset($this->request->post['select']) && $this->request->post['select']) {

				foreach ($this->request->post['select'] as $key => $value) {

					foreach ($value as $key => $order_product_id) {
					    
					   $getSellerOrderProductDetails = $this->model_customerpartner_transaction->getSellerOrderProductDetails($order_product_id);
                       
                       /**
                        * check order product must be not paid and order status must be equal to the marketplace complete order status
                        */
					   if (!$getSellerOrderProductDetails['paid_status'] && ($getSellerOrderProductDetails['order_status_name'] == $this->config->get('marketplace_complete_order_status'))) {
					       
					       $amount2pay = round( ($amount2pay + $getSellerOrderProductDetails['customer']),2 );
                           
					   }else{
					   	 $this->error['warning'] = $this->language->get('error_warning');
					   }
					}
				}
			}else{
				$this->error['warning'] = $this->language->get('error_select');
			}
            
            /**
             * check whether the payable amount is equal to the selected order product payable amount
             */
			if ($amount2pay != $this->request->post['amount']) {
				
				$this->error['warning'] = $this->language->get('error_warning');

			}
			
			if ((utf8_strlen($this->request->post['customer_id']) < 1)) {
	      		$this->error['warning'] = $this->language->get('error_seller');
	    	}	

	    	if (!(float)$this->request->post['amount']) {
	      		$this->error['warning'] = $this->language->get('error_amount');
	    	}	
			
			$post = $this->request->post;


			if(!isset($this->error['warning'])){

				$this->model_customerpartner_transaction->addTransaction($this->request->post);

				$this->session->data['success'] = $this->language->get('text_success');
						
				$this->response->redirect($this->url->link('customerpartner/transaction', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->addtransaction();
  	} 

	public function delete() {

    	$this->language->load('customerpartner/transaction');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('customerpartner/transaction');
		
		if (isset($this->request->post['selected']) && $this->validate()) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_customerpartner_transaction->deleteentry($id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url='';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('customerpartner/transaction', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->index();
  	}  	

	private function validate() {

		if (!$this->user->hasPermission('modify', 'customerpartner/transaction')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

}
?>