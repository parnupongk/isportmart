<?php
class Controllercustomerpartnerdashboard extends Controller {

	private $error = array();
	private $data = array();

	public function index() {

		// if (!$this->customer->isLogged()) {
		// 	$this->session->data['redirect'] = $this->url->link('account/customerpartner/dashboard', '', 'SSL');
		// 	$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		// }

		$this->load->model('customerpartner/customerpartner');

		// $this->data['chkIsPartner'] = $this->model_customerpartner->chkIsPartner();	
			
		// if(!$this->data['chkIsPartner'])
		// 	$this->response->redirect($this->url->link('account/account'));

    	// $this->document->addStyle('catalog/view/theme/default/stylesheet/MP/sell.css');

		$this->language->load('customerpartner/dashboard');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_sale'] = $this->language->get('text_sale');
		$this->data['text_map'] = $this->language->get('text_map');
		$this->data['text_activity'] = $this->language->get('text_activity');
		$this->data['text_recent'] = $this->language->get('text_recent');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),     	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_dashboard'),
			'href'      => $this->url->link('account/customerpartner/dashboard', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

      	$this->data['order'] = $this->load->controller('customerpartner/dashboards/order');
		$this->data['sale'] = $this->load->controller('customerpartner/dashboards/sale');
		$this->data['customer'] = $this->load->controller('customerpartner/dashboards/customer');

		// $this->data['seller_sale'] = '';
		$this->data['seller_map'] = $this->load->controller('customerpartner/map');
		
		$this->data['chart'] = $this->load->controller('customerpartner/dashboards/chart');
		// $this->data['activity'] = $this->load->controller('account/customerpartner/dashboards/activity');
		$this->data['recent'] = $this->load->controller('customerpartner/dashboards/recent');

		// $this->data['footer'] = $this->load->controller('common/footer');
		// $this->data['header'] = $this->load->controller('common/header');	
		// $this->data['column_left'] = $this->load->controller('common/column_left');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/customerpartner/dashboard.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/customerpartner/dashboard.tpl' , $this->data));
		} else {
			$this->response->setOutput($this->load->view('customerpartner/dashboard.tpl' , $this->data));
		}
		
	}

	public function changereview(){
		
		$this->language->load('account/customerpartner/dashboard');
		
		$this->load->model('account/customerpartner');
		
		$json = array();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST' AND $this->customer->getID()) {

			if ($this->model_account_customerpartner->chkIsPartner() AND isset($this->request->post['review'])) {
				$latestcomment=$this->model_account_customerpartner->UpdateReview($this->request->post['review']);	
				$json['success'] = $this->language->get('text_change_review');	
			}else{
				$json['error'] = $this->language->get('text_error');
			}		    	    
			
		}
		
		$this->response->setOutput(json_encode($json));

	}	
}
?>
