<?php
class ControllerShippingwkcustomshipping extends Controller {
	
	private $error = array(); 
	private $data = array(); 
	
	public function index() {   
		$this->language->load('shipping/wk_custom_shipping');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('wk_custom_shipping', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_edit'] = $this->language->get('text_edit');
		
		$this->data['entry_cost'] = $this->language->get('entry_cost');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['title'] = $this->language->get('title');
		$this->data['method_title'] = $this->language->get('method_title');
		$this->data['cal_handling_fee'] = $this->language->get('cal_handling_fee');
		$this->data['error_msg'] = $this->language->get('error_msg');
		$this->data['method_select'] = $this->language->get('method_select');
		$this->data['admin_flatrate'] = $this->language->get('admin_flatrate');
		$this->data['texclass'] = $this->language->get('texclass');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/wk_custom_shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('shipping/wk_custom_shipping', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->error['method_name'])) {
			$this->data['error_method_name'] = $this->error['method_name'];
		} else {
			$this->data['error_method_name'] = '';
		}

		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}

		if (isset($this->error['method'])) {
			$this->data['error_method'] = $this->error['method'];
		} else {
			$this->data['error_method'] = '';
		}

		if (isset($this->error['admin_flatrate'])) {
			$this->data['error_admin_flatrate'] = $this->error['admin_flatrate'];
		} else {
			$this->data['error_admin_flatrate'] = '';
		}
		
		if (isset($this->request->post['wk_custom_shipping_admin_flatrate'])) {
			$this->data['wk_custom_shipping_admin_flatrate'] = $this->request->post['wk_custom_shipping_admin_flatrate'];
		} else {
			$this->data['wk_custom_shipping_admin_flatrate'] = $this->config->get('wk_custom_shipping_admin_flatrate');
		}

		if (isset($this->request->post['wk_custom_shipping_method'])) {
			$this->data['wk_custom_shipping_method'] = $this->request->post['wk_custom_shipping_method'];
		} else {
			$this->data['wk_custom_shipping_method'] = $this->config->get('wk_custom_shipping_method');
		}
		
		if (isset($this->request->post['wk_custom_shipping_cost'])) {
			$this->data['wk_custom_shipping_cost'] = $this->request->post['wk_custom_shipping_cost'];
		} else {
			$this->data['wk_custom_shipping_cost'] = $this->config->get('wk_custom_shipping_cost');
		}

		if (isset($this->request->post['wk_custom_shipping_title'])) {
			$this->data['wk_custom_shipping_title'] = $this->request->post['wk_custom_shipping_title'];
		} else {
			$this->data['wk_custom_shipping_title'] = $this->config->get('wk_custom_shipping_title');
		}
		
		if (isset($this->request->post['wk_custom_shipping_method_title'])) {
			$this->data['wk_custom_shipping_method_title'] = $this->request->post['wk_custom_shipping_method_title'];
		} else {
			$this->data['wk_custom_shipping_method_title'] = $this->config->get('wk_custom_shipping_method_title');
		}

		if (isset($this->request->post['wk_custom_shipping_cal_handling_fee'])) {
			$this->data['wk_custom_shipping_cal_handling_fee'] = $this->request->post['wk_custom_shipping_cal_handling_fee'];
		} else {
			$this->data['wk_custom_shipping_cal_handling_fee'] = $this->config->get('wk_custom_shipping_cal_handling_fee');
		}

		if (isset($this->request->post['wk_custom_shipping_error_msg'])) {
			$this->data['wk_custom_shipping_error_msg'] = $this->request->post['wk_custom_shipping_error_msg'];
		} else {
			$this->data['wk_custom_shipping_error_msg'] = $this->config->get('wk_custom_shipping_error_msg');
		}

		if (isset($this->request->post['wk_custom_shipping_geo_zone_id'])) {
			$this->data['wk_custom_shipping_geo_zone_id'] = $this->request->post['wk_custom_shipping_geo_zone_id'];
		} else {
			$this->data['wk_custom_shipping_geo_zone_id'] = $this->config->get('wk_custom_shipping_geo_zone_id');
		}

		$this->load->model('localisation/tax_class');

		if (isset($this->request->post['wk_custom_shipping_tax_class_id'])) {
			$this->data['wk_custom_shipping_tax_class_id'] = $this->request->post['wk_custom_shipping_tax_class_id'];
		} else {
			$this->data['wk_custom_shipping_tax_class_id'] = $this->config->get('wk_custom_shipping_tax_class_id');
		}
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['wk_custom_shipping_status'])) {
			$this->data['wk_custom_shipping_status'] = $this->request->post['wk_custom_shipping_status'];
		} else {
			$this->data['wk_custom_shipping_status'] = $this->config->get('wk_custom_shipping_status');
		}
		
		if (isset($this->request->post['wk_custom_shipping_sort_order'])) {
			$this->data['wk_custom_shipping_sort_order'] = $this->request->post['wk_custom_shipping_sort_order'];
		} else {
			$this->data['wk_custom_shipping_sort_order'] = $this->config->get('wk_custom_shipping_sort_order');
		}				

		$this->data['header'] = $this->load->controller('common/header');
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/wk_custom_shipping.tpl', $this->data));

	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/wk_custom_shipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['wk_custom_shipping_method_title']) {
			$this->error['method_name'] = $this->language->get('error_method_name');
		}

		if (!$this->request->post['wk_custom_shipping_title']) {
			$this->error['title'] = $this->language->get('error_title');
		}
		
		if (!$this->request->post['wk_custom_shipping_method']) {
			$this->error['method'] = $this->language->get('error_method');
		}elseif(($this->request->post['wk_custom_shipping_method']=='flat' OR $this->request->post['wk_custom_shipping_method']=='both') AND (!(int)$this->request->post['wk_custom_shipping_admin_flatrate'])){
			$this->error['admin_flatrate'] = $this->language->get('error_admin_flatrate');
		}

		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>