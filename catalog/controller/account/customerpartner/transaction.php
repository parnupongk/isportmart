<?php    
class ControllerAccountCustomerpartnerTransaction extends Controller { 

	private $error = array();
  
  	public function index() {	

  		if (!$this->customer->isLogged()) {
			$this->session->data['response'] = $this->url->link('account/customerpartner/transaction', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}	
		
		$this->load->model('account/customerpartner');

		$data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();

		if(!$data['chkIsPartner'])
			$this->response->redirect($this->url->link('account/account'));

    	$this->getlist();
  	}  	  
  	
  	public function getlist() {	

		$this->load->language('account/customerpartner/transaction');
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
					$filter_array[$key] = ($filter_array['page'] - 1) * $this->config->get('config_product_limit');
				elseif($key=='limit')
					$filter_array[$key] = $this->config->get('config_product_limit');				
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

  		$data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home')        	
      	); 

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account')      
      	); 
		
      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/customerpartner/transaction')      	
     	);			

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');		
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/MP/sell.css');

    	$results = $this->model_customerpartner_transaction->viewtotal($filter_array);
    	
		$product_total = $this->model_customerpartner_transaction->viewtotalentry($filter_array);				

		$lang_array = array('heading_title',
							'entry_id',
							'entry_transaction',
							'entry_details',
							'entry_amount',
							'entry_date',
							'entry_seller',

							'button_back',
							'button_save',
							'button_cancel',
							'button_insert',
							'button_delete',
							'button_filter',
							'text_transactionList',
							'text_transactionId',
							'text_transactionAmount',
							'text_transactionDetails',
							'text_transactionDate',
							);

		foreach($lang_array as $language){
			$data[$language] = $this->language->get($language);
		}

		$data['transactions'] = array();

	    foreach ($results as $result) {		
			
	      	$data['transactions'][] = array(
				'selected'=>False,
				'id' => $result['id'],
				'name' => $result['name'],
				'value' => $result['text'],
				'details' => $result['details'],			
				'date' => $result['date_added'],	
			);
          	
		}		
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
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

		$data['sort_name'] = $this->url->link('account/customerpartner/transaction', '' . '&sort=c.firstname' . $url, 'SSL');
		$data['sort_id'] = $this->url->link('account/customerpartner/transaction', '' . '&sort=ct.id' . $url, 'SSL');
		$data['sort_date'] = $this->url->link('account/customerpartner/transaction', ''  . '&sort=ct.date_added' . $url, 'SSL');
		$data['sort_details'] = $this->url->link('account/customerpartner/transaction', ''  . '&sort=ct.details' . $url, 'SSL');
		$data['sort_amount'] = $this->url->link('account/customerpartner/transaction', ''  . '&sort=ct.amount' . $url, 'SSL');

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
		$pagination->limit = $this->config->get('config_product_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('account/customerpartner/transaction', ''  . $url . '&page={page}', 'SSL');
			
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($filter_array['page'] - 1) * $this->config->get('config_product_limit')) + 1 : 0, ((($filter_array['page'] - 1) * $this->config->get('config_product_limit')) > ($product_total - $this->config->get('config_product_limit'))) ? $product_total : ((($filter_array['page'] - 1) * $this->config->get('config_product_limit')) + $this->config->get('config_product_limit')), $product_total, ceil($product_total / $this->config->get('config_product_limit')));
		
		foreach ($filter_array as $key => $value) {
			if($key!='start' AND $key!='end')
				$data[$key] = $value;
		}			

		$data['isMember'] = true;
		if($this->config->get('wk_seller_group_status')) {
      		$data['wk_seller_group_status'] = true;
      		$this->load->model('account/customer_group');
			$isMember = $this->model_account_customer_group->getSellerMembershipGroup($this->customer->getId());
			if($isMember) {
				$allowedAccountMenu = $this->model_account_customer_group->getaccountMenu($isMember['gid']);
				if($allowedAccountMenu['value']) {
					$accountMenu = explode(',',$allowedAccountMenu['value']);
					if($accountMenu && !in_array('transaction:transaction', $accountMenu)) {
						$data['isMember'] = false;
					}
				}
			} else {
				$data['isMember'] = false;
			}
      	} else {
      		if(!in_array('transaction', $this->config->get('marketplace_allowed_account_menu'))) {
      			$this->response->redirect($this->url->link('account/account','', 'SSL'));
      		}
      	}
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/transaction.tpl')) {
			$this->response->setOutput($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/transaction.tpl' , $data));			
		} else {
			$this->response->setOutput($this->load->view('default/template/account/customerpartner/transaction.tpl' , $data));
		}	

	}  	

}
?>