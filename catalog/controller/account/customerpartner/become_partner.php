<?php
class ControllerAccountCustomerpartnerBecomePartner extends Controller {

	private $error = array();
	private $data = array();

	public function index() {

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/customerpartner/become_partner', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}	
		
		$this->language->load('account/customerpartner/become_partner');
		
		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('account/customerpartner');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$country_id = $this->model_account_customerpartner->CustomerCountry_Id($this->customer->getId());

			if (empty($country_id)) {
				
				$this->model_account_customerpartner->becomePartner($this->request->post['shoppartner'],$customer_country_id='',$this->customer->getId(),$this->request->post['description']);
			}else{

				$this->model_account_customerpartner->becomePartner($this->request->post['shoppartner'],$country_id['country_id'],$this->customer->getId(),$this->request->post['description']);
			}
            $this->session->data['success'] = $this->language->get('text_success');                        
			$this->response->redirect($this->url->link('account/customerpartner/become_partner', '', 'SSL'));
		}	

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
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/customerpartner/become_partner', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);
		
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

		$this->data['in_process'] = false;		
		
		$hasApplied = $this->model_account_customerpartner->IsApplyForSellership();		

		if($hasApplied){

			if($this->model_account_customerpartner->chkIsPartner())
				$this->response->redirect($this->url->link('account/customerpartner/dashboard', '', 'SSL'));
			else{
				$this->data['in_process'] = true;
				$this->data['text_delay'] = $this->language->get('text_delay');
			}

		}else{

			if(isset($this->error['error_shoppartner'])) {
		        $this->data['error_shoppartner'] = $this->error['error_shoppartner'];                       
		    }else{
				$this->data['error_shoppartner'] = '';
		    }

		    if(isset($this->error['error_description'])) {
		        $this->data['error_description'] = $this->error['error_description'];                       
		    }else{
				$this->data['error_description'] = '';
		    }

		    if(isset($this->request->post['shoppartner'])) {
		        $this->data['shoppartner'] = $this->request->post['shoppartner'];                       
		    }else{
				$this->data['shoppartner'] = '';
		    }  
			
			if(isset($this->request->post['description'])) {
		        $this->data['description'] = $this->request->post['description'];                       
		    }else{
				$this->data['description'] = '';
		    } 
		    
			$this->data['text_say'] = $this->language->get('text_say');
			$this->data['text_shop_name_info'] = $this->language->get('text_shop_name_info');
			$this->data['text_say_info'] = $this->language->get('text_say_info');
			$this->data['error_text'] = $this->language->get('error_text');
			$this->data['text_shop_name'] = $this->language->get('text_shop_name');
			$this->data['text_avaiable'] = $this->language->get('text_avaiable');
			$this->data['text_no_avaiable'] = $this->language->get('text_no_avaiable');	
		}
		
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

		$this->data['action'] = $this->url->link('account/customerpartner/become_partner', '', 'SSL');
		$this->data['back'] = $this->url->link('account/account', '', 'SSL');

		$this->data['isMember'] = true;

		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['column_right'] = $this->load->controller('common/column_right');
		$this->data['content_top'] = $this->load->controller('common/content_top');
		$this->data['content_bottom'] = $this->load->controller('common/content_bottom');
		$this->data['footer'] = $this->load->controller('common/footer');
		$this->data['header'] = $this->load->controller('common/header');
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/become_partner.tpl')) {
			$this->response->setOutput($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/become_partner.tpl' , $this->data));			
		} else {
			$this->response->setOutput($this->load->view('default/template/account/customerpartner/become_partner.tpl' , $this->data));
		}

	}

	private function validateForm() {

		if(utf8_strlen($this->request->post['shoppartner'])<=3){
            $this->error['error_shoppartner'] = $this->language->get('error_validshop');
        }elseif(utf8_strlen($this->request->post['description'])<=3){
            $this->error['error_description'] = $this->language->get('error_noshop');
        }else{
            $this->load->model('customerpartner/master');                           
            if(!$this->model_customerpartner_master->getShopData($this->request->post['shoppartner'])){
                $this->error['error_shoppartner'] = $this->language->get('error_message');
            }
        }
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	} 
	
	
}
?>
