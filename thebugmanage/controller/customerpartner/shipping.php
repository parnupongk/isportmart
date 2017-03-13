<?php
################################################################################################
# Shipping Opencart 1.5.1.x From Webkul  http://webkul.com 	#
################################################################################################
class ControllerCustomerpartnerShipping extends Controller {
	
	private $error = array(); 
	private $data = array();
	
	public function index() {
		$this->language->load('customerpartner/shipping');    	
		$this->document->setTitle($this->language->get('heading_title')); 
		$this->load->model('customerpartner/addshipping');
		$this->getList();
  	}  	
  
	protected function getList() {	

		$filter_array = array(
							  'filter_name',
							  'filter_country',
							  'filter_zip_to',
							  'filter_zip_from',
							  'filter_price',
							  'filter_weight_to',
							  'filter_weight_from',
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
					$filter_array[$key] = 'cs.id';
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
				if ($key=='filter_name' || $key=='filter_country') 
					$url .= '&'.$key.'=' . urlencode(html_entity_decode($filter_array[$key], ENT_QUOTES, 'UTF-8'));
				else
					$url .= '&'.$key.'='. $filter_array[$key];
			}
		}

		$this->language->load('customerpartner/shipping');
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token']. $url, 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('customerpartner/shipping', 'token=' . $this->session->data['token']. $url, 'SSL'),       		
      		'separator' => ' :: '
   		);		
				
		$this->data['delete'] = $this->url->link('customerpartner/shipping/delete', 'token=' . $this->session->data['token'] , 'SSL');
    	$this->data['addshipping'] = $this->url->link('customerpartner/addshipping', 'token=' . $this->session->data['token'] , 'SSL');

    	$results = $this->model_customerpartner_addshipping->viewtotal($filter_array);
    	
		$product_total = $this->model_customerpartner_addshipping->viewtotalentry($filter_array);				

		$this->data['heading_title'] = $this->language->get('heading_title');		
		$this->data['button_shipping'] = $this->language->get('button_shipping');				
		$this->data['button_insert'] = $this->language->get('button_insert');		
		$this->data['button_delete'] = $this->language->get('button_delete');		
		$this->data['button_filter'] = $this->language->get('button_filter');
		//user
		$this->data['customer_name'] = $this->language->get('customer_name');
		$this->data['shipping_country'] = $this->language->get('shipping_country');		
		$this->data['zip_from'] = $this->language->get('zip_from');
		$this->data['zip_to'] = $this->language->get('zip_to');		
		$this->data['price'] = $this->language->get('price');
		$this->data['weight_to'] = $this->language->get('weight_to');
		$this->data['weight_from'] = $this->language->get('weight_from');
		$this->data['text_confirm'] = $this->language->get('text_confirm');

		$this->data['result_shipping']=array();

	    foreach ($results as $result) {		
		
	      	$this->data['result_shipping'][] = array(
				'selected'=>False,
				'id' => $result['id'],
				'name' => $result['name'] ? $result['name'] : 'Admin',
				'price' => $result['price'],
				'countey' => $result['country_code'],
				'zip_from' => $result['zip_from'],
				'zip_to' => $result['zip_to'],
				'weight_from' => $result['weight_from'],
				'weight_to' => $result['weight_to'],				
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
				if ($key=='filter_name' || $key=='filter_country') 
					$url .= '&'.$key.'=' . urlencode(html_entity_decode($filter_array[$key], ENT_QUOTES, 'UTF-8'));
				elseif($key=='order')				
					$url .= $value=='ASC' ? '&order=DESC' : '&order=ASC';			
				elseif($key!='start' AND $key!='limit' AND $key!='sort')
					$url .= '&'.$key.'='. $filter_array[$key];
			}
		}

		$this->data['sort_name'] = $this->url->link('customerpartner/shipping', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_country_code'] = $this->url->link('customerpartner/shipping', 'token=' . $this->session->data['token'] . '&sort=cs.country_code' . $url, 'SSL');
		$this->data['sort_price'] = $this->url->link('customerpartner/shipping', 'token=' . $this->session->data['token'] . '&sort=cs.price' . $url, 'SSL');
		$this->data['sort_zip_to'] = $this->url->link('customerpartner/shipping', 'token=' . $this->session->data['token'] . '&sort=cs.zip_to' . $url, 'SSL');
		$this->data['sort_zip_from'] = $this->url->link('customerpartner/shipping', 'token=' . $this->session->data['token'] . '&sort=cs.zip_from' . $url, 'SSL');		
		$this->data['sort_weight_to'] = $this->url->link('customerpartner/shipping', 'token=' . $this->session->data['token'] . '&sort=cs.weight_to' . $url, 'SSL');
		$this->data['sort_weight_from'] = $this->url->link('customerpartner/shipping', 'token=' . $this->session->data['token'] . '&sort=cs.weight_from' . $url, 'SSL');

		$url = '';

		foreach ($filter_array as $key => $value) {			
			if(isset($this->request->get[$key])){
				if(!isset($this->request->get['order']) AND isset($this->request->get['sort']))
					$url .= '&order=DESC';
				if ($key=='filter_name' || $key=='filter_country') 
					$url .= '&'.$key.'=' . urlencode(html_entity_decode($filter_array[$key], ENT_QUOTES, 'UTF-8'));						
				elseif($key!='page')
					$url .= '&'.$key.'='. $filter_array[$key];
			}
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $filter_array['page'];
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('customerpartner/shipping', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($filter_array['page'] - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($filter_array['page'] - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($filter_array['page'] - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));
		
		foreach ($filter_array as $key => $value) {
			if($key!='start' AND $key!='end')
				$this->data[$key] = $value;
		}

		$this->data['header'] = $this->load->controller('common/header');		
		$this->data['footer'] = $this->load->controller('common/footer');	
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->response->setOutput($this->load->view('customerpartner/shipping.tpl',$this->data));

  	}

  	
  	public function delete() {
    	$this->language->load('customerpartner/shipping');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('customerpartner/addshipping');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_customerpartner_addshipping->deleteentry($id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url='';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('customerpartner/shipping', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
  	
	private function validateForm() { 
		if (!$this->user->hasPermission('modify', 'customerpartner/shipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}		
			
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
						
		if (!$this->error) {
				return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'customerpartner/shipping')) {
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