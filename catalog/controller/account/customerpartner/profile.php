<?php
class ControllerAccountCustomerpartnerProfile extends Controller {

	private $error = array();

	public function index() {

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/customerpartner/profile', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/customerpartner');

		$data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();	
			
		if(!$data['chkIsPartner'])
			$this->response->redirect($this->url->link('account/account'));

		$this->language->load('account/customerpartner/profile');		
		$this->document->setTitle($this->language->get('heading_title'));
			
		$this->document->addScript('thebugmanage/view/javascript/summernote/summernote.js');
		$this->document->addStyle('thebugmanage/view/javascript/summernote/summernote.css');		
		$this->document->addStyle('catalog/view/theme/default/stylesheet/MP/sell.css');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load->model('account/customerpartner');			
			$this->model_account_customerpartner->updateProfile($this->request->post);			
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('account/customerpartner/profile', '', 'SSL'));
		}

		$partner = $this->model_account_customerpartner->getProfile();
		
		if($partner) {

			$this->load->model('tool/image');

			if ($partner['avatar'] && file_exists(DIR_IMAGE . $partner['avatar'])) {
					$partner['avatar'] = $this->model_tool_image->resize($partner['avatar'], 100, 100);
			} else if($this->config->get('marketplace_default_image_name') && file_exists(DIR_IMAGE . $this->config->get('marketplace_default_image_name'))) {
				if($partner['avatar'] != 'removed') {
					$partner['avatar'] = $this->model_tool_image->resize($this->config->get('marketplace_default_image_name'), 100, 100);
				} else {
					$partner['avatar'] = '';
				}
			} else {
				$partner['avatar'] = '';
			}

			if ($partner['companybanner'] && file_exists(DIR_IMAGE . $partner['companybanner'])) {
					$partner['companybanner'] = $this->model_tool_image->resize($partner['companybanner'], 100, 100);
			} else if($this->config->get('marketplace_default_image_name') && file_exists(DIR_IMAGE . $this->config->get('marketplace_default_image_name'))) {
				if($partner['companybanner'] != 'removed') {
					$partner['companybanner'] = $this->model_tool_image->resize($this->config->get('marketplace_default_image_name'), 100, 100);
				} else {
					$partner['companybanner'] = '';
				}
			} else {
				$partner['companybanner'] = '';
			}

			if ($partner['companylogo'] && file_exists(DIR_IMAGE . $partner['companylogo'])){
				$partner['companylogo'] = $this->model_tool_image->resize($partner['companylogo'], 100, 100);
			} else if($this->config->get('marketplace_default_image_name') && file_exists(DIR_IMAGE . $this->config->get('marketplace_default_image_name'))) {
				if($partner['companylogo'] != 'removed') {
					$partner['companylogo'] = $this->model_tool_image->resize($this->config->get('marketplace_default_image_name'), 100, 100);
				} else {
					$partner['companylogo'] = '';
				}
			} else {
				$partner['companylogo'] = '';
			}
			
			$partner['countrylogo'] = $partner['countrylogo'];
			$data['storeurl'] =$this->url->link('customerpartner/profile&id='.$this->customer->getId(),'','SSL');
		}
		
		if($this->config->get('wk_seller_group_status')) {
			$this->load->model('account/customer_group');
			$isMember = $this->model_account_customer_group->getSellerMembershipGroup($this->customer->getId());
			if($isMember) {
				$allowedAccountMenu = $this->model_account_customer_group->getprofileOption($isMember['gid']);
				if($allowedAccountMenu['value']) {
					$accountMenu = explode(',',$allowedAccountMenu['value']);
					if($accountMenu) {
						foreach ($accountMenu as $key => $value) {
							$values = explode(':',$value);
							$data['allowed'][$values[0]] = $values[1];
						}
					}
				}
			}
		} else if($this->config->get('marketplace_allowedprofilecolumn')) {
			$data['allowed']  = $this->config->get('marketplace_allowedprofilecolumn');
		}

		$data['partner'] = $partner;

		$data['countries'] = $this->model_account_customerpartner->getCountry();

      	$data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),     	
        	'separator' => false
      	); 

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account'),     	
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/customerpartner/profile', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_firstname'] = $this->language->get('text_firstname');
		$data['text_lastname'] = $this->language->get('text_lastname');
		$data['text_email'] = $this->language->get('text_email');

		// Tab
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_profile_details'] = $this->language->get('tab_profile_details');
		$data['tab_paymentmode'] = $this->language->get('tab_paymentmode');
		$data['text_general'] = $this->language->get('text_general');
		$data['text_profile_info'] = $this->language->get('text_profile_info');
		$data['text_paymentmode'] = $this->language->get('text_paymentmode');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_remove'] = $this->language->get('text_remove');		
		
		//profile		
		$data['text_screen_name']=$this->language->get('text_screen_name');
		$data['text_gender']=$this->language->get('text_gender');
		$data['text_short_profile']=$this->language->get('text_short_profile');
		$data['text_avatar']=$this->language->get('text_avatar');
		$data['text_twitter_id']=$this->language->get('text_twitter_id');
		$data['text_facebook_id']=$this->language->get('text_facebook_id');
		$data['text_theme_background_color']=$this->language->get('text_theme_background_color');
		$data['text_company_banner']=$this->language->get('text_company_banner');
		$data['text_company_logo']=$this->language->get('text_company_logo');
		$data['text_company_locality']=$this->language->get('text_company_locality');
		$data['text_company_name']=$this->language->get('text_company_name');
		$data['text_company_description']=$this->language->get('text_company_description');
		$data['text_country_logo']=$this->language->get('text_country_logo');
		$data['text_otherpayment']=$this->language->get('text_otherpayment');
		$data['text_payment_mode']=$this->language->get('text_payment_mode');
		$data['text_profile']=$this->language->get('text_profile');
		$data['text_payment_detail']=$this->language->get('text_payment_detail');
		$data['text_account_information']=$this->language->get('text_account_information');
		$data['hover_avatar']=$this->language->get('hover_avatar');
		$data['hover_banner']=$this->language->get('hover_banner');
		$data['hover_company_logo']=$this->language->get('hover_company_logo');		
		$data['text_sef_url'] = $this->language->get('text_sef_url');
		$data['text_male'] = $this->language->get('text_male');
		$data['text_female'] = $this->language->get('text_female');
		$data['text_view_profile'] = $this->language->get('text_view_profile');

		$data['warning_become_seller'] = $this->language->get('warning_become_seller');
		$data['text_product_details'] = $this->language->get('text_product_details');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');

		$data['customer_details'] = array(
									'firstname' => $this->customer->getFirstName(),
									'lastname' => $this->customer->getLastName(),
									'email' => $this->customer->getEmail()
									);
		
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['screenname_error'])) {
			$data['screenname_error'] = $this->error['screenname_error'];
		} else {
			$data['screenname_error'] = '';
		}

		if (isset($this->error['companyname_error'])) {
			$data['companyname_error'] = $this->error['companyname_error'];
		} else {
			$data['companyname_error'] = '';
		}

		if (isset($this->error['paypal_error'])) {
			$data['paypal_error'] = $this->error['paypal_error'];
		} else {
			$data['paypal_error'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';			
		}
	
		$data['action'] = $this->url->link('account/customerpartner/profile', '', 'SSL');
		$data['back'] = $this->url->link('account/account', '', 'SSL');
		$data['view_profile'] = $this->url->link('customerpartner/profile&id='.$this->customer->getId(), '', 'SSL');

		$data['isMember'] = true;
		if($this->config->get('wk_seller_group_status')) {
      		$data['wk_seller_group_status'] = true;
      		$this->load->model('account/customer_group');
			$isMember = $this->model_account_customer_group->getSellerMembershipGroup($this->customer->getId());
			if($isMember) {
				$allowedAccountMenu = $this->model_account_customer_group->getaccountMenu($isMember['gid']);
				if($allowedAccountMenu['value']) {
					$accountMenu = explode(',',$allowedAccountMenu['value']);
					if($accountMenu && !in_array('profile:profile', $accountMenu)) {
						$data['isMember'] = false;
					}
				}
			} else {
				$data['isMember'] = false;
			}
      	} else {
      		if(!in_array('profile', $this->config->get('marketplace_allowed_account_menu'))) {
      			$this->response->redirect($this->url->link('account/account','', 'SSL'));
      		}
      	}
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/profile.tpl')) {
			$this->response->setOutput($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/profile.tpl' , $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/customerpartner/profile.tpl', $data));
		}		
			
	}

	public function validateForm() {
		$error = false;
		$this->language->load('account/customerpartner/profile');
		if(strlen($this->request->post['screenName']) < 1) {
			$this->error['screenname_error'] = $this->language->get('error_seo_keyword');
			$this->error['warning'] = $this->language->get('error_check_form');
			$error = true;
		}

		if (isset($this->request->post['paypalid']) && $this->request->post['paypalid']) {
			if(!filter_var($this->request->post['paypalid'], FILTER_VALIDATE_EMAIL)) {
				$this->error['paypal_error'] = $this->language->get('error_paypal');
				$this->error['warning'] = $this->language->get('error_check_form');
				$error = true;
			}			
		}

		if(strlen($this->request->post['companyName']) < 1) {
			$this->error['companyname_error'] = $this->language->get('error_company_name');
			$this->error['warning'] = $this->language->get('error_check_form');
			$error = true;
		}

		$files = $this->request->files;

		foreach ($files as $key => $value) {
	  		if (isset($value['name']) && !empty($value['name']) && is_file($value['tmp_name'])) {
				// Sanitize the filename
				$filename = basename(html_entity_decode($value['name'], ENT_QUOTES, 'UTF-8'));
          
				// Validate the filename length
				if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 255)) {
					$this->error['warning'] = $this->language->get('error_filename');
					$error = true;
				}

				// Allowed file extension types
				$allowed = array(
					'jpg',
					'jpeg',
					'gif',
					'png'
				);

				if (!in_array(utf8_strtolower(utf8_substr(strrchr($filename, '.'), 1)), $allowed)) {
					$this->error['warning'] = $this->language->get('error_filetype');
					$error = true;
				}

				// Allowed file mime types
				$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png',
					'image/gif'
				);

				if (!in_array($value['type'], $allowed)) {
					$this->error['warning'] = $this->language->get('error_filetype');
					$error = true;
				}

				// Check to see if any PHP files are trying to be uploaded
				$content = file_get_contents($value['tmp_name']);

				if (preg_match('/\<\?php/i', $content)) {
					$this->error['warning'] = $this->language->get('error_filetype');
					$error = true;
				}

				// Return any upload error
				if ($value['error'] != UPLOAD_ERR_OK) {
					$this->error['warning'] = $this->language->get('error_upload_' . $value['error']);
					$error = true;
				}

			}
		}
		
		if($error) {
			return false;
		} else {
			return true;
		}

	}
	
}
?>
