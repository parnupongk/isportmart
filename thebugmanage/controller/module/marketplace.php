<?php
class ControllerModuleMarketplace extends Controller {

	private $error = array(); 
	private $files_array = array();
	private $data = array();

	public function install() {
		$this->load->model('customerpartner/partner');
		$this->load->model('user/user_group');
		$this->model_customerpartner_partner->createCustomerpartnerTable();

		$this->load->model('user/user_group');
		$controllers = array(
			'customerpartner/addshipping',
			'customerpartner/commission',
			'customerpartner/dashboard',
			'customerpartner/mails',
			'customerpartner/map',
			'customerpartner/partner',
			'customerpartner/product',
			'customerpartner/order',
			'customerpartner/shipping',
			'customerpartner/transaction',
			'customerpartner/income',
			'customerpartner/dashboards/chart',
			'customerpartner/dashboards/customer',
			'customerpartner/dashboards/map',
			'customerpartner/dashboards/order',
			'customerpartner/dashboards/recent',
			'customerpartner/dashboards/sale',
			'wkcustomfield/wkcustomfield',
			'catalog/wk_customfield',
			'shipping/wk_custom_shipping',
		);

		foreach ($controllers as $key => $controller) {
			$this->model_user_user_group->addPermission($this->user->getId(),'access',$controller);
			$this->model_user_user_group->addPermission($this->user->getId(),'modify',$controller);
		}
		
	}

	public function uninstall() {
		$this->load->model('customerpartner/partner');
	    $this->model_customerpartner_partner->removeCustomerpartnerTable();
	}	

	public function getdir($controller_path = ''){

		$copy = $controller_path;
		$path = DIR_CATALOG.'controller';
		if($path != $controller_path)
			$controller_path = $path.'/'.$controller_path;

		if(is_dir($controller_path)){
			if($controller_path_files = opendir($controller_path)){
				while(($new_file = readdir($controller_path_files)) !== false){
					if($new_file != '.' AND $new_file!= '..'){
						if(is_dir($controller_path.'/'.$new_file)){
							if($copy)
								$new_file = $copy.'/'.$new_file;
								$this->getdir($new_file);
						}elseif($copy!='module' AND $copy!='payment' AND $copy!='shipping' AND $copy!='api' AND $copy!='feed' AND $copy!='tool'){ // to discard folders
							$chk = explode(".",$new_file);
							if(end($chk)=='php')
								$this->files_array [] = $copy.'/'.prev($chk);
						}
					}
				}
			}
		}
	}

	public function index() {

		// upgradation code
		$this->load->model('customerpartner/partner');
		$this->model_customerpartner_partner->upgradeMarketplace();
		// upgradation code

	    $data = array();
	    $data = array_merge($data,$this->load->language('module/marketplace'));   

		$this->document->setTitle($data['heading_title1']);
		
		$this->load->model('localisation/language');
		$this->load->model('setting/setting');

		$data['seller_product_store'] = array(

			'own_store' => $data['entry_ownstore'],
			'choose_store' => $data['entry_choosestore'],
			'multi_store' => $data['entry_mulistore'],
		);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->files['marketplace_default_image']) && $this->imageValidation($this->request->files['marketplace_default_image']) && $this->validate()) {

			if (!isset($this->request->post['marketplace_allowed_categories'])) {
				
				$this->request->post['marketplace_allowed_categories'] = array();
			}

			if(isset($this->request->files['marketplace_default_image']) && $this->request->files['marketplace_default_image']['name']) {
				move_uploaded_file($this->request->files['marketplace_default_image']["tmp_name"], DIR_IMAGE . "catalog/" . $this->request->files['marketplace_default_image']["name"]);
				$this->request->post['marketplace_default_image_name'] = "catalog/".$this->request->files['marketplace_default_image']["name"];
			}

			if(isset($this->request->post['marketplace_SefUrlspath']))
				$this->request->post['marketplace_SefUrlspath'] = array_values($this->request->post['marketplace_SefUrlspath']);
			if(isset($this->request->post['marketplace_SefUrlsvalue']))
				$this->request->post['marketplace_SefUrlsvalue'] = array_values($this->request->post['marketplace_SefUrlsvalue']);	

			//remove blank tabs - checked heading
			if(isset($this->request->post['marketplace_tab']['heading'])){
				foreach ($this->request->post['marketplace_tab']['heading'] as $key => $value) {
					$left_this = false;
					foreach($value as $language_key => $language_value){
						if($language_value)
							$left_this = true;
					}
					if(!$left_this){
						unset($this->request->post['marketplace_tab']['heading'][$key]);
						unset($this->request->post['marketplace_tab']['description'][$key]);
					}
				}
			}

			$this->model_setting_setting->editSetting('marketplace', $this->request->post);			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('module/marketplace', 'token=' . $this->session->data['token'], 'SSL'));
		}

		
		$config_data = array(

				'marketplace_status',

				//general
				'marketplace_mailtoseller',
				'marketplace_mailadmincustomercontactseller',
				'marketplace_customercontactseller',	
				'marketplace_hideselleremail',
				'marketplace_adminmail',								
				'marketplace_productapprov',
				'marketplace_partnerapprov',
				'marketplace_sellerorderstatus',
				'marketplace_available_order_status',
				'marketplace_order_status_sequence',
				'marketplace_becomepartnerregistration',
				'marketplace_allowed_shipping_method',
				'marketplace_complete_order_status',
				'marketplace_divide_shipping',
				'marketplace_default_image_name',
				'marketplace_cancel_order_status',
				'marketplace_seller_name_cart_status',
				'marketplace_seller_list_limit',
				'marketplace_seller_product_list_limit',

				//product tab
				'marketplace_allowedproductcolumn',
				'marketplace_allowedproducttabs',
				'marketplace_imagesize',	
				'marketplace_noofimages',
				'marketplace_imageex',
				'marketplace_noofdownload',	
				'marketplace_downloadex',
				'marketplace_downloadsize',
				'marketplace_productaddemail',
				'marketplace_product_reapprove',
				'marketplace_sellerdeleteproduct',
				'marketplace_sellerproductdelete',
				'marketplace_sellerproductshow',
				'marketplace_sellerbuyproduct',
				'marketplace_adminnotify',
				'marketplace_seller_product_store',

				//seo tab
				'marketplace_useseo',
				'marketplace_wksell',
				'marketplace_productlist',
				'marketplace_profile',
				'marketplace_addproduct',
				'marketplace_add_shipping_mod',
				'marketplace_dashboard',
				'marketplace_orderlist',
				'marketplace_order_info',
				'marketplace_soldlist',
				'marketplace_soldinvoice',
				'marketplace_editproduct',
				'marketplace_storeprofile',
				'marketplace_collection',
				'marketplace_feedback',
				'marketplace_store',
				'marketplace_downloads',
				'marketplace_transactions',
				//sef tab 2
				'marketplace_SefUrlspath',
				'marketplace_SefUrlsvalue',
				// sef product tab
				'marketplace_product_seo_name',
				'marketplace_product_seo_format',
				'marketplace_product_seo_default_name',
				'marketplace_product_seo_product_name',
				'marketplace_product_seo_page_ext',

				//commission
				'marketplace_boxcommission',
				'marketplace_commission_add',
				'marketplace_commission',
				'marketplace_commissionworkedon',

				//sell tab				
				'marketplace_sellheader',
				'marketplace_sellbuttontitle',
				'marketplace_selldescription',
				'marketplace_showpartners',
				'marketplace_showproducts',
				'marketplace_tab',	

				//profile tab
				'marketplace_allowedprofilecolumn',
				'marketplace_allowed_public_seller_profile',
				'marketplace_profile_email',
				'marketplace_profile_telephone',

				// 'marketplace_profile_profile',
				'marketplace_profile_store',
				'marketplace_profile_collection',
				'marketplace_profile_review',
				'marketplace_profile_product_review',
				'marketplace_profile_location',

				// module Configuration
				'marketplace_allowed_account_menu',
				'marketplace_account_menu_sequence',
				'marketplace_product_name_display',
				'marketplace_product_show_seller_product',
				'marketplace_product_image_display',

				//mail tab
				'marketplace_mail_keywords',
				'marketplace_mail_partner_request',
				'marketplace_mail_product_request',
				'marketplace_mail_transaction',
				'marketplace_mail_order',
				'marketplace_mail_partner_admin',
				'marketplace_mail_product_admin',
				'marketplace_mail_cutomer_to_seller',
				'marketplace_mail_seller_to_admin',
				'marketplace_mail_partner_approve',
				'marketplace_mail_product_approve',
				'marketplace_mail_admin_on_edit',
				'marketplace_mail_seller_on_edit',

				// update in marketplace
				'marketplace_seller_manage_order',
				'marketplace_low_stock_notification',
				'marketplace_low_stock_quantity',
				'marketplace_review_only_order',
				'marketplace_seller_info_by_module',
				// 'marketplace_seller_address_invoice',
				'marketplace_pdf_order_invoice',
				'marketplace_commission_tax',
				'marketplace_seller_info_hide',
				'marketplace_allowed_seller_category_type',
				'marketplace_allowed_categories',
				'marketplace_mail_seller_low_stock',
				'marketplace_auto_generate_sku',
		);

		foreach ($config_data as $conf) {
			if (isset($this->request->post[$conf])) {
				$data[$conf] = $this->request->post[$conf];
			} else {
				$data[$conf] = $this->config->get($conf);
			}
		}

		$this->load->model('tool/image');

		if($this->config->get('marketplace_default_image_name')) {
			$data['marketplace_default_image_name'] = $this->config->get('marketplace_default_image_name');
			$data['marketplace_default_image'] = $this->model_tool_image->resize($this->config->get('marketplace_default_image_name'), 90, 90);
		}

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if(isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/marketplace', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('module/marketplace', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
				
		$product_table = $this->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND table_name = '".DB_PREFIX."product'")->rows;
		
		$product_table = array_slice($product_table, 1, -3);

		$data['product_table'] = array();

		foreach($product_table as $key => $value){
			$data['product_table'][] = $value['COLUMN_NAME'];
		}
		
		$data['product_table'][] = 'keyword';

		$data['product_tabs'] = array('special','discount','attribute','links','options','custom-field');
	
		//folder path for SEF urls		
		$this->getdir();
		$data['paths'] = $this->files_array;		

		$data['profile_table'] = array();
		$profile_table = $this->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND table_name = '".DB_PREFIX."customerpartner_to_customer'")->rows;

		$profile_table = array_slice($profile_table, 3, -1);
		if($profile_table[11]['COLUMN_NAME'] == 'companyname') {
			unset($profile_table[11]);
		}
		foreach($profile_table as $key => $value){
			$data['profile_table'][] = $value['COLUMN_NAME'];
		}

		$data['account_menu'] = array(
			'profile' => $this->language->get('entry_mod_profile'),
			'dashboard' => $this->language->get('entry_mod_dashboard'),
			'orderhistory' => $this->language->get('entry_mod_order'),
			'transaction' => $this->language->get('entry_mod_transaction'),
			'productlist' => $this->language->get('entry_mod_productlist'),
			'addproduct' => $this->language->get('entry_mod_addproduct'),
			'downloads' => $this->language->get('entry_mod_downloads'),
			'manageshipping' => $this->language->get('entry_mod_manageshipping'),
			'asktoadmin' => $this->language->get('entry_mod_asktoadmin'),
		);

		$data['publicSellerProfile'] = array(
			'store' => $this->language->get('entry_store_tab'),
			'collection' => $this->language->get('entry_collection_tab'),
			'review' => $this->language->get('entry_review_tab'),
			'productReview' => $this->language->get('entry_product_review_tab'),
			'location' => $this->language->get('entry_location_tab'),
		);


		/*
		Membership code
		Add memebership option to existing array
		 */
		if($this->config->get('wk_seller_group_status')) {
        	$data['wk_seller_group_status'] = true;
        	$data['account_menu']['membership'] = $this->language->get('entry_mod_membership');
        	$data['marketplace_account_menu_sequence']['membership'] = $this->language->get('entry_mod_membership');
        } else {
        	$data['wk_seller_group_status'] = false;
        	if(isset($data['account_menu']['membership'])) {
        		unset($data['account_menu']['membership']);
        	}
        	if(isset($data['marketplace_account_menu_sequence']['membership'])) {
        		unset($data['marketplace_account_menu_sequence']['membership']);
        	}
        }
        /*
        end here
         */
 			
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['config_language_id'] = $this->config->get('config_language_id');

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->load->model('extension/extension');

		$shipping_methods = $this->model_extension_extension->getInstalled('shipping');
		foreach ($shipping_methods as $key => $shipping_method) {
			$file = glob(DIR_APPLICATION . 'controller/shipping/'.$shipping_method.'.php');
			if($file){
				$this->load->language('shipping/'.$shipping_method);
				$data['shipping_methods'][] = array(
					'code' => $shipping_method,
					'name' => $this->language->get('heading_title'),
				);
			}
		}

		//get total mail
		$this->load->model('customerpartner/mail');
		$data['mails'] = $this->model_customerpartner_mail->gettotal();

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');		
		$data['footer'] = $this->load->controller('common/footer');	
		$data['column_left'] = $this->load->controller('common/column_left');
				
		$this->response->setOutput($this->load->view('module/marketplace.tpl',$data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/marketplace')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	private function imageValidation($value){
        
        $this->load->language('module/marketplace');
		$error = true;

  		if (isset($value['name']) && !empty($value['name']) && is_file($value['tmp_name'])) {
			// Sanitize the filename
			$filename = basename(html_entity_decode($value['name'], ENT_QUOTES, 'UTF-8'));
      
			// Validate the filename length
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 255)) {
				$this->error['warning'] = $this->language->get('error_filename');
				$error = false;
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
				$error = false;
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
				$error = false;
			}

			// Check to see if any PHP files are trying to be uploaded
			$content = file_get_contents($value['tmp_name']);

			if (preg_match('/\<\?php/i', $content)) {
				$this->error['warning'] = $this->language->get('error_filetype');
				$error = false;
			}

			// Return any upload error
			if ($value['error'] != UPLOAD_ERR_OK) {
				$this->error['warning'] = $this->language->get('error_upload_' . $value['error']);
				$error = false;
			}
		}

		return $error;
	}

	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {

			$allowed_categories = '';
			if (isset($this->request->post['allowed_categories']) && $this->request->post['allowed_categories']) {
				foreach ($this->request->post['allowed_categories'] as $categories) {
					
					$allowed_categories .= ','. $categories;
				}

				if ($allowed_categories) {
					$allowed_categories = ltrim($allowed_categories, ',');
				}
			}

			$this->load->model('customerpartner/partner');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'name',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_customerpartner_partner->getCategories($filter_data, $allowed_categories);

			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
?>