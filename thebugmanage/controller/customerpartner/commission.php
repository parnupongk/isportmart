<?php    
class ControllerCustomerpartnerCommission extends Controller { 

	private $error = array();
	private $data = array();
  
  	public function index() {		
    	$this->category();
  	}  	  
  	
  	public function category() {	

		$this->load->language('customerpartner/commission');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('customerpartner/commission');

		$filter_array = array(
							  'filter_id',
							  'filter_name',
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
				if($key=='page')
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
				if ($key=='filter_name') 
					$url .= '&'.$key.'=' . urlencode(html_entity_decode($filter_array[$key], ENT_QUOTES, 'UTF-8'));
				else
					$url .= '&'.$key.'='. $filter_array[$key];
			}
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token']. $url, 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('customerpartner/commission', 'token=' . $this->session->data['token']. $url, 'SSL'), 		
      		'separator' => ' :: '
   		);		
				
		$data['delete'] = $this->url->link('customerpartner/commission/delete', 'token=' . $this->session->data['token'] , 'SSL');
		$data['insert'] = $this->url->link('customerpartner/commission/addcategory', 'token=' . $this->session->data['token'] , 'SSL');

    	$results = $this->model_customerpartner_commission->viewtotal($filter_array);
    	
		$product_total = $this->model_customerpartner_commission->viewtotalentry($filter_array);				

		$lang_array = array('heading_title',
							'heading_title_category',
							'heading_title_manual',

							'entry_id',
							'entry_category',
							'entry_name',
							'entry_value',
							'entry_fixed',
							'entry_percentage',
							'entry_edit',
							'entry_action',

							'text_confirm',
							
							'button_back',
							'button_save',
							'button_cancel',
							'button_insert',
							'button_delete',
							'button_filter',
							);

		foreach($lang_array as $language){
			$data[$language] = $this->language->get($language);
		}

		$data['commission'] = array();

	    foreach ($results as $result) {		
			
	      	$data['commission'][] = array(
				'selected'=>False,
				'id' => $result['id'],
				'name' => $result['name'],
				'value' => '<span class="fixed">'.$data['entry_fixed'].'</span> - ' .$result['fixed'] .' + <span class="percentage">'.$data['entry_percentage'].'</span> - ' .$result['percentage'].' %',
				'action' => $this->url->link('customerpartner/commission/addcategory&id='.$result['id'],'token='.$this->session->data['token']),			
			);
          	
		}		
		
 		$data['token'] = $this->session->data['token'];
		
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
				if ($key=='filter_name') 
					$url .= '&'.$key.'=' . urlencode(html_entity_decode($filter_array[$key], ENT_QUOTES, 'UTF-8'));
				elseif($key=='order')				
					$url .= $value=='ASC' ? '&order=DESC' : '&order=ASC';			
				elseif($key!='start' AND $key!='limit' AND $key!='sort')
					$url .= '&'.$key.'='. $filter_array[$key];
			}
		}

		$data['sort_name'] = $this->url->link('customerpartner/commission', 'token=' . $this->session->data['token'] . '&sort=cd.name' . $url, 'SSL');
		$data['sort_id'] = $this->url->link('customerpartner/commission', 'token=' . $this->session->data['token'] . '&sort=cc.id' . $url, 'SSL');

		$url = '';

		foreach ($filter_array as $key => $value) {			
			if(isset($this->request->get[$key])){
				if(!isset($this->request->get['order']) AND isset($this->request->get['sort']))
					$url .= '&order=DESC';
				if ($key=='filter_name') 
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
		$pagination->url = $this->url->link('customerpartner/commission', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($filter_array['page'] - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($filter_array['page'] - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($filter_array['page'] - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));
		
		foreach ($filter_array as $key => $value) {
			if($key!='start' AND $key!='end')
				$data[$key] = $value;
		}

		$data['header'] = $this->load->controller('common/header');		
		$data['footer'] = $this->load->controller('common/footer');	
		$data['column_left'] = $this->load->controller('common/column_left');
		$this->response->setOutput($this->load->view('customerpartner/commission_category.tpl',$data));
				
  	}
  
  	public function addcategory() {

  		$this->load->language('customerpartner/commission');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('customerpartner/commission');

    	$lang_array = array('heading_title',
							'heading_title_category',
							'heading_title_manual',

							'entry_id',
							'entry_category',
							'entry_name',
							'entry_value',
							'entry_fixed',
							'entry_percentage',
							'entry_edit',
							'entry_commission',
							'entry_commission_info',

							'button_back',
							'button_save',
							'button_cancel',
							'button_insert',
							'button_delete',
							'button_filter',

							'info_category_select'
							);

		foreach($lang_array as $language){
			$data[$language] = $this->language->get($language);
		}

		$data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		$url = '';

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('customerpartner/commission', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		  
    	$data['cancel'] = $this->url->link('customerpartner/commission', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['save'] = $this->url->link('customerpartner/commission/categorySave', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$post_array = array('category_id',
							'fixed',
							'percentage',
							'id'
						   );

		foreach($post_array as $postdata){
			if(isset($this->request->post[$postdata]))
				$data[$postdata] = $this->request->post[$postdata];
			else
				$data[$postdata] = '';
		}
		
		if(isset($this->request->get['id'])){
			$result = $this->model_customerpartner_commission->getCategoryData($this->request->get['id']);
			if($result){
				foreach($result as $key => $resultdata){
					$data[$key] = $resultdata;
				}
			}
		}

		$data['category'] = $this->model_customerpartner_commission->getCategories(array());
		$added_category = $this->model_customerpartner_commission->getAddedCategories();
		$data['added_category'] = array();
		foreach ($added_category as $value) {
			$data['added_category'][] = $value['category_id'];
		}
		
		$data['commission_add'] = $this->config->get('marketplace_commission_add');

		$data['header'] = $this->load->controller('common/header');		
		$data['footer'] = $this->load->controller('common/footer');	
		$data['column_left'] = $this->load->controller('common/column_left');

		$this->response->setOutput($this->load->view('customerpartner/commission_category_form.tpl',$data));
	}
	
	public function categorySave() {

    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

    		$this->load->language('customerpartner/commission');
		
			$this->load->model('customerpartner/commission');

			if (empty($this->request->post['category_id']) || (utf8_strlen($this->request->post['category_id']) < 1)) {
	      		$this->error['warning'] = $this->language->get('error_category');
	    	}	
			
			if(!isset($this->error['warning'])){	

				if($this->request->post['id']) //update
					$this->model_customerpartner_commission->categoryUpdate($this->request->post);
				else //save
					$this->model_customerpartner_commission->categorySave($this->request->post);

				$this->session->data['success'] = $this->language->get('text_success');
						
				$this->response->redirect($this->url->link('customerpartner/commission', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->addcategory();
  	} 

	public function delete() {

    	$this->language->load('customerpartner/commission');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('customerpartner/commission');
		
		if (isset($this->request->post['selected']) && $this->validate()) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_customerpartner_commission->deleteentry($id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url='';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('customerpartner/commission', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->category();
  	}

  	public function manual() {	

		$this->load->language('customerpartner/commission');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('customerpartner/commission');

		$filter_array = array(
							  'filter_id',
							  'filter_name',
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
				if($key=='sort')
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
				if ($key=='filter_name') 
					$url .= '&'.$key.'=' . urlencode(html_entity_decode($filter_array[$key], ENT_QUOTES, 'UTF-8'));
				else
					$url .= '&'.$key.'='. $filter_array[$key];
			}
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token']. $url, 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('customerpartner/commission/manual', 'token=' . $this->session->data['token']. $url, 'SSL'), 		
      		'separator' => ' :: '
   		);		
				
		$data['delete'] = $this->url->link('customerpartner/commission/deleteManual', 'token=' . $this->session->data['token'] , 'SSL');
		$data['insert'] = $this->url->link('customerpartner/commission/addManual', 'token=' . $this->session->data['token'] , 'SSL');

    	$results = $this->model_customerpartner_commission->viewtotalManual($filter_array);
    	
		$product_total = $this->model_customerpartner_commission->viewtotalentryManual($filter_array);				

		$lang_array = array('heading_title',
							'heading_title_category',
							'heading_title_manual',

							'entry_id',
							'entry_manual',
							'entry_name',
							'entry_value',
							'entry_fixed',
							'entry_percentage',
							'entry_edit',

							'button_back',
							'button_save',
							'button_cancel',
							'button_insert',
							'button_delete',
							'button_filter',
							);

		foreach($lang_array as $language){
			$data[$language] = $this->language->get($language);
		}

		$data['commission'] = array();

	    foreach ($results as $result) {		
			
	      	$data['commission'][] = array(
				'selected'=>False,
				'id' => $result['id'],
				'name' => $result['name'],
				'value' => '<span class="fixed">'.$data['entry_fixed'].'</span> - ' .$result['fixed'] .' + <span class="percentage">'.$data['entry_percentage'].'</span> - ' .$result['percentage'].' %',
				'action' => $this->url->link('customerpartner/commission/addManual&id='.$result['id'],'token='.$this->session->data['token']),			
			);
          	
		}		
		
 		$data['token'] = $this->session->data['token'];
		
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
				if ($key=='filter_name') 
					$url .= '&'.$key.'=' . urlencode(html_entity_decode($filter_array[$key], ENT_QUOTES, 'UTF-8'));
				elseif($key=='order')				
					$url .= $value=='ASC' ? '&order=DESC' : '&order=ASC';			
				elseif($key!='start' AND $key!='limit' AND $key!='sort')
					$url .= '&'.$key.'='. $filter_array[$key];
			}
		}

		$data['sort_name'] = $this->url->link('customerpartner/commission/manual', 'token=' . $this->session->data['token'] . '&sort=cd.name' . $url, 'SSL');
		$data['sort_id'] = $this->url->link('customerpartner/commission/manual', 'token=' . $this->session->data['token'] . '&sort=cc.id' . $url, 'SSL');

		$url = '';

		foreach ($filter_array as $key => $value) {			
			if(isset($this->request->get[$key])){
				if(!isset($this->request->get['order']) AND isset($this->request->get['sort']))
					$url .= '&order=DESC';
				if ($key=='filter_name') 
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
		$pagination->url = $this->url->link('customerpartner/commission/manual', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$data['pagination'] = $pagination->render();
		
		foreach ($filter_array as $key => $value) {
			if($key!='start' AND $key!='end')
				$data[$key] = $value;
		}

		$this->template = 'customerpartner/commission_manual.tpl';

		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}

  	public function addManual() {

  		$this->load->language('customerpartner/commission');
		$this->document->setTitle($this->language->get('heading_title_manual'));

		$this->load->model('customerpartner/commission');

    	$lang_array = array('heading_title',
							'heading_title_category',
							'heading_title_manual',

							'entry_id',
							'entry_manual',
							'entry_name',
							'entry_value',
							'entry_fixed',
							'entry_percentage',
							'entry_edit',
							'entry_commission',

							'button_back',
							'button_save',
							'button_cancel',
							'button_insert',
							'button_delete',
							'button_filter',

							'info_category_select'
							);

		foreach($lang_array as $language){
			$data[$language] = $this->language->get($language);
		}

		$data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		$url = '';

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('customerpartner/commission/manual', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		  
    	$data['cancel'] = $this->url->link('customerpartner/commission/manual', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['save'] = $this->url->link('customerpartner/commission/manualSave', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$post_array = array('name',
							'fixed',
							'percentage',
							'id'
						   );

		foreach($post_array as $postdata){
			if(isset($this->request->post[$postdata]))
				$data[$postdata] = $this->request->post[$postdata];
			else
				$data[$postdata] = '';
		}
		
		if(isset($this->request->get['id'])){
			$result = $this->model_customerpartner_commission->getManualData($this->request->get['id']);
			if($result){
				foreach($result as $key => $resultdata){
					$data[$key] = $resultdata;
				}
			}
		}
		
		$this->template = 'customerpartner/commission_manaul_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}


	public function manualSave() {

    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

    		$this->load->language('customerpartner/commission');
		
			$this->load->model('customerpartner/commission');

			if ((utf8_strlen($this->request->post['name']) < 1)) {
	      		$this->error['warning'] = $this->language->get('error_name');
	    	}

	    	if (!(float)$this->request->post['fixed'] && !(float)$this->request->post['percentage']) {
	      		$this->error['warning'] = $this->language->get('error_amount');
	    	}	
			
			if(!isset($this->error['warning'])){	

				if($this->request->post['id']) //update
					$this->model_customerpartner_commission->manualUpdate($this->request->post);
				else //save
					$this->model_customerpartner_commission->manualSave($this->request->post);

				$this->session->data['success'] = $this->language->get('text_success');
						
				$this->redirect($this->url->link('customerpartner/commission/manual', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->addManual();
  	} 

	public function deleteManual() {

    	$this->language->load('customerpartner/commission');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('customerpartner/commission');
		
		if (isset($this->request->post['selected']) && $this->validate()) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_customerpartner_commission->deleteentryManual($id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url='';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('customerpartner/commission/manual', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->manual();
  	}

	private function validate() {

		if (!$this->user->hasPermission('modify', 'customerpartner/commission')) {
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