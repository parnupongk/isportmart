<?php
class ControllerAccountCustomerpartnerAddproduct extends Controller {
	private $error = array();

	private $membershipData = array();

	public function index() {
	
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/customerpartner/addproduct', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}	

		$this->load->model('account/customerpartner');
        
        // membership codes starts here
		if($this->config->get('wk_seller_group_status')) {
		  $data['wk_seller_group_status'] = true;
		  $data['wk_seller_group_single_category'] = true;
		  if($this->config->get('wk_seller_group_membership_type') == 'product') {
		  	$data['wk_seller_group_membership_type'] = 'product';
		  	$remaining_quantity = $this->model_account_customerpartner->getRamainingQuantity();

		  	if (isset($this->request->get['product_id'])) {
		  		
		  		$remaining_quantity = 0;
		  	}

		  	if($remaining_quantity < 0) {
		  		$this->session->data['warning'] = " Warning: You don't have more products to add, please upgrade your memberhsip";
		  		$this->response->redirect($this->url->link('account/customerpartner/productlist', '', 'SSL'));
		  	}
		  } else {
		  	$data['wk_seller_group_status'] = true;
		  	$this->document->addscript("catalog/view/javascript/sellergroup/function.js");
		  	$data['wk_seller_group_membership_type'] = 'quantity';
		  	$data['remaining_quantity'] = true;
		  	$sellerDetail = $this->model_account_customerpartner->getSellerDetails();
		    foreach($sellerDetail as $detail){
		    	$data['sellerDetail'][] = array(
		      		'product_id' => $detail['product_id'],
		      		'group_id' => $detail['groupid'],
		      		'name'     => $detail['name'],
		      		'quantity' => $detail['gquantity'],
		      		'price'    => $this->currency->format($detail['gprice'], $this->session->data['currency']),
		      	);
		    }
		  }
	    } else {
	    	$data['wk_seller_group_status'] = false;
	    	$data['wk_seller_group_single_category'] = false;
	    	$data['wk_seller_group_membership_type'] = false;
	    }
	     // membership codes ends here
	    
		$this->load->model('catalog/product');

		$data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();

		if(!$data['chkIsPartner'])
			$this->response->redirect($this->url->link('account/account'));

		$this->language->load('account/customerpartner/addproduct');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('thebugmanage/view/javascript/summernote/summernote.js');
		$this->document->addStyle('thebugmanage/view/javascript/summernote/summernote.css');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/MP/sell.css');						

		if (($this->request->server['REQUEST_METHOD'] == 'POST') AND $this->validate() AND $this->validateForm()) {
			if($this->config->get('wk_seller_group_status') && ($this->request->post['quantity'] != $this->request->post['prevQuantity'])) {
				if($this->membershipData && isset($this->membershipData['remain'])) {
					$this->load->model('account/wk_membership_catalog');
					$this->model_account_wk_membership_catalog->insertInPay($this->membershipData['remain']);
				}
			}
			
			if(isset($this->request->post['clone']) && $this->request->post['clone']) {
				$this->model_account_customerpartner->addProduct($this->request->post);
			} else if(!isset($this->request->get['product_id'])){
                $this->model_account_customerpartner->addProduct($this->request->post);
                $this->session->data['success'] = $this->language->get('text_success');
			}else{

                $this->model_account_customerpartner->editProduct($this->request->post);
                $this->session->data['success'] = $this->language->get('text_success_update');
			}

			$this->response->redirect($this->url->link('account/customerpartner/productlist', '', 'SSL'));
			// if(!isset($this->request->get['product_id']))
			// 	$this->response->redirect($this->url->link('account/customerpartner/addproduct', '', 'SSL'));
		}		

		$data['text_change_base'] = $this->language->get('text_change_base');

		// from product
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_plus'] = $this->language->get('text_plus');
		$data['text_minus'] = $this->language->get('text_minus');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');
		$data['text_option'] = $this->language->get('text_option');
		$data['text_option_value'] = $this->language->get('text_option_value');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_sku'] = $this->language->get('entry_sku');
		$data['entry_upc'] = $this->language->get('entry_upc');
		$data['entry_ean'] = $this->language->get('entry_ean');
		$data['entry_jan'] = $this->language->get('entry_jan');
		$data['entry_isbn'] = $this->language->get('entry_isbn');
		$data['entry_mpn'] = $this->language->get('entry_mpn');
		$data['entry_location'] = $this->language->get('entry_location');
		$data['entry_minimum'] = $this->language->get('entry_minimum');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$data['entry_shipping'] = $this->language->get('entry_shipping');
		$data['entry_date_available'] = $this->language->get('entry_date_available');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_stock_status'] = $this->language->get('entry_stock_status');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_points'] = $this->language->get('entry_points');
		$data['entry_option_points'] = $this->language->get('entry_option_points');
		$data['entry_subtract'] = $this->language->get('entry_subtract');
		$data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$data['entry_weight'] = $this->language->get('entry_weight');
		$data['entry_dimension'] = $this->language->get('entry_dimension');
		$data['entry_length'] = $this->language->get('entry_length');
		$data['entry_image'] = ' <span data-toggle="tooltip" title="'.$this->config->get('marketplace_imageex').'">'.$this->language->get('entry_image').'</span>';
		$data['entry_download'] = $this->language->get('entry_download');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_related'] = $this->language->get('entry_related');
		$data['entry_attribute'] = $this->language->get('entry_attribute');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_option'] = $this->language->get('entry_option');
		$data['entry_option_value'] = $this->language->get('entry_option_value');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_priority'] = $this->language->get('entry_priority');
		$data['entry_tag'] = $this->language->get('entry_tag');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_profile'] = $this->language->get('entry_profile');

		$data['text_recurring_help'] = $this->language->get('text_recurring_help');
		$data['text_recurring_title'] = $this->language->get('text_recurring_title');
		$data['text_recurring_trial'] = $this->language->get('text_recurring_trial');
		$data['entry_recurring'] = $this->language->get('entry_recurring');
		$data['entry_recurring_price'] = $this->language->get('entry_recurring_price');
		$data['entry_recurring_freq'] = $this->language->get('entry_recurring_freq');
		$data['entry_recurring_cycle'] = $this->language->get('entry_recurring_cycle');
		$data['entry_recurring_length'] = $this->language->get('entry_recurring_length');
		$data['entry_trial'] = $this->language->get('entry_trial');
		$data['entry_trial_price'] = $this->language->get('entry_trial_price');
		$data['entry_trial_freq'] = $this->language->get('entry_trial_freq');
		$data['entry_trial_length'] = $this->language->get('entry_trial_length');
		$data['entry_trial_cycle'] = $this->language->get('entry_trial_cycle');

		$data['text_length_day'] = $this->language->get('text_length_day');
		$data['text_length_week'] = $this->language->get('text_length_week');
		$data['text_length_month'] = $this->language->get('text_length_month');
		$data['text_length_month_semi'] = $this->language->get('text_length_month_semi');
		$data['text_length_year'] = $this->language->get('text_length_year');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_back'] = $this->language->get('button_back');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_add_attribute'] = $this->language->get('button_add_attribute');
		$data['button_add_option'] = $this->language->get('button_add_option');
		$data['button_add_option_value'] = $this->language->get('button_add_option_value');
		$data['button_add_discount'] = $this->language->get('button_add_discount');
		$data['button_add_special'] = $this->language->get('button_add_special');
		$data['button_add_image'] = $this->language->get('button_add_image');
		$data['button_remove'] = $this->language->get('button_remove');

	    $data['entry_name'] = $this->language->get('entry_name');
	    $data['entry_price'] = $this->language->get('entry_price');
	    $data['entry_quantity'] = $this->language->get('entry_quantity');
	    $data['entry_list_header'] = $this->language->get('entry_list_header');
	    $data['entry_action'] = $this->language->get('entry_action');
	    $data['button_cart'] = $this->language->get('button_cart');
			

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_attribute'] = $this->language->get('tab_attribute');
		$data['tab_option'] = $this->language->get('tab_option');	
		$data['tab_discount'] = $this->language->get('tab_discount');
		$data['tab_special'] = $this->language->get('tab_special');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_links'] = $this->language->get('tab_links');
		$data['text_access'] = $this->language->get('text_access');

		$data['error_warning_mandetory'] = $this->language->get('error_warning_mandetory');
		$data['entry_select_option'] = $this->language->get('entry_select_option');
		$data['entry_select_date'] = $this->language->get('entry_select_date');
		$data['entry_select_datetime'] = $this->language->get('entry_select_datetime');
		$data['entry_select_time'] = $this->language->get('entry_select_time');
		$data['entry_enter_text'] = $this->language->get('entry_enter_text');
		$data['text_custom_field'] = $this->language->get('text_custom_field');	
		$data['clone_info'] = $this->language->get('clone_info');
		$data['entry_expiring_date'] = $this->language->get('entry_expiring_date');
		$data['entry_relist_duration'] = $this->language->get('entry_relist_duration');
		$data['entry_auto_relist'] = $this->language->get('entry_auto_relist');
		$data['entry_auto_relist_lable'] = $this->language->get('entry_auto_relist_lable');		

		$help = array(
			'help_keyword',
			'help_sku',
			'help_upc',
			'help_ean',
			'help_jan',
			'help_isbn',
			'help_mpn',
			'help_manufacturer',
			'help_minimum',
			'help_stock_status',
			'help_points',
			'help_category',
			'help_filter',
			'help_download',
			'help_related',
			'help_tag',
			'help_length',
			'help_width',
			'help_height',
			'help_weight',
			'help_image',
			);

		foreach ($help as $value) {
			$data[$value] = $this->language->get($value);
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['customFieldError'])) {
			$data['customFieldError'] = $this->error['customFieldError'];
		} else {
			$data['customFieldError'] = array();
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['error_meta_title'])) {
			$data['error_meta_title'] = $this->error['error_meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}	
		
		if (isset($this->error['model'])) {
			$data['error_model'] = $this->error['model'];
		} else {
			$data['error_model'] = '';
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}			

		if (!isset($this->request->get['product_id'])) {
			$data['product_id'] = '';
			$data['action'] = $this->url->link('account/customerpartner/addproduct', '', 'SSL');
		} else {
			$data['product_id'] = $this->request->get['product_id'];
			$data['action'] = $this->url->link('account/customerpartner/addproduct&product_id='.$this->request->get['product_id'], '', 'SSL');
		}

		$data['cancel'] = $this->url->link('account/customerpartner/productlist', '', 'SSL');

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
        	'text'      => $this->language->get('heading_title_productlist'),
			'href'      => $this->url->link('account/customerpartner/productlist'),     	
        	'separator' => $this->language->get('text_separator')
      	); 
		
      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_product'),
			'href'      => $data['action'],       	
        	'separator' => $this->language->get('text_separator')
      	);	
      	
      	$data['mp_allowproducttabs'] = array();
      	$data['isMember'] = false;

      	 // membership codes starts here
		if($this->config->get('wk_seller_group_status')) {
	    	$data['wk_seller_group_status'] = true;
	      	$this->load->model('account/customer_group');
			$isMember = $this->model_account_customer_group->getSellerMembershipGroup($this->customer->getId());
			if($isMember) {
				$allowedProductTabs = $this->model_account_customer_group->getproductTab($isMember['gid']);
				if($allowedProductTabs['value']) {
					$allowedProductTab = explode(',',$allowedProductTabs['value']);
						foreach ($allowedProductTab as $key => $tab) {
							$ptab = explode(':', $tab);	
							$data['mp_allowproducttabs'][$ptab[0]] = $ptab[1];
						}
					}
					$data['isMember'] = true;
			} else {
				$data['isMember'] = false;
			}
	    }

	    if(!$this->config->get('wk_seller_group_status')) {
      		$data['mp_allowproducttabs'] = $this->config->get('marketplace_allowedproducttabs');
      	}

      	 // membership codes ends here

      	$data['marketplace_account_menu_sequence'] = $this->config->get('marketplace_account_menu_sequence');

      	$data['marketplace_product_reapprove'] = false;
      	if($this->config->get('marketplace_product_reapprove')) {
      		if(!$this->config->get('marketplace_productapprov')) {
      			$data['marketplace_product_reapprove'] = ' As auto approve is not enabled, your product will be disabled for cross checking of changes.';
      		}
      	}

      	$data['mp_allowproductcolumn'] = $this->config->get('marketplace_allowedproductcolumn');

      	$tabletype = '';

		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$data['heading_title'] = $this->language->get('heading_title_update');
			$this->document->setTitle($this->language->get('heading_title_update'));
            
             // membership codes starts here
			if($this->config->get('wk_seller_group_status') && (isset($this->request->get['clone']) || isset($this->request->post['clone']) && $this->request->post['clone']) ) {
				$data['heading_title'] = $this->language->get('heading_title_clone');
				$this->document->setTitle($this->language->get('heading_title_clone'));
			}

			 // membership codes ends here

			if(! $this->model_account_customerpartner->chkSellerPoductAccess($this->request->get['product_id']))
				$data['access_error'] = true;
			else{
				$product_info = $this->model_account_customerpartner->getProduct($this->request->get['product_id']);
				if(!$product_info)
					$data['access_error'] = true;
			}
		}

		if (isset($this->request->post['product_description'])) {
			$data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_description'] = $this->model_account_customerpartner->getProductDescriptions($this->request->get['product_id']);
		} else {
			$data['product_description'] = array();
		}

		if (isset($this->request->post['model'])) {
			$data['model'] = $this->request->post['model'];
		} elseif (!empty($product_info)) {
			$data['model'] = $product_info['model'];
		} else {
			$data['model'] = '';
		}

		if (isset($this->request->post['sku'])) {
			$data['sku'] = $this->request->post['sku'];
		} elseif (!empty($product_info)) {
			$data['sku'] = $product_info['sku'];
		} else {
			$data['sku'] = '';
		}

		if (isset($this->request->post['upc'])) {
			$data['upc'] = $this->request->post['upc'];
		} elseif (!empty($product_info)) {
			$data['upc'] = $product_info['upc'];
		} else {
			$data['upc'] = '';
		}

		if (isset($this->request->post['ean'])) {
			$data['ean'] = $this->request->post['ean'];
		} elseif (!empty($product_info)) {
			$data['ean'] = $product_info['ean'];
		} else {
			$data['ean'] = '';
		}

		if (isset($this->request->post['jan'])) {
			$data['jan'] = $this->request->post['jan'];
		} elseif (!empty($product_info)) {
			$data['jan'] = $product_info['jan'];
		} else {
			$data['jan'] = '';
		}

		if (isset($this->request->post['isbn'])) {
			$data['isbn'] = $this->request->post['isbn'];
		} elseif (!empty($product_info)) {
			$data['isbn'] = $product_info['isbn'];
		} else {
			$data['isbn'] = '';
		}

		if (isset($this->request->post['mpn'])) {
			$data['mpn'] = $this->request->post['mpn'];
		} elseif (!empty($product_info)) {
			$data['mpn'] = $product_info['mpn'];
		} else {
			$data['mpn'] = '';
		}

		if (isset($this->request->post['location'])) {
			$data['location'] = $this->request->post['location'];
		} elseif (!empty($product_info)) {
			$data['location'] = $product_info['location'];
		} else {
			$data['location'] = '';
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($product_info)) {
			$data['keyword'] = $this->model_account_customerpartner->getProductKeyword($product_info['product_id']);
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($product_info)) {
			$data['image'] = $product_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('localisation/language');		
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && $this->request->post['image'] && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($product_info) && $product_info['image'] && file_exists(DIR_IMAGE . $product_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['shipping'])) {
			$data['shipping'] = $this->request->post['shipping'];
		} elseif (!empty($product_info)) {
			$data['shipping'] = $product_info['shipping'];
		} else {
			$data['shipping'] = 1;
		}

		if (isset($this->request->post['price'])) {
			$data['price'] = $this->request->post['price'];
		} elseif (!empty($product_info)) {
			$data['price'] = $this->currency->convert($product_info['price'],$this->config->get('config_currency'),$this->session->data['currency']);
			$data['price'] = number_format($data['price'],2, '.', '');
		} else {
			$data['price'] = '';
		}

		// membership code
		
		if (isset($this->request->post['expiry_date'])) {
			$data['expiry_date'] = $this->request->post['expiry_date'];
		} elseif (!empty($product_info) && isset($product_info['expiry_date'])) {
			$data['expiry_date'] = $product_info['expiry_date'];
		} else {
			$data['expiry_date'] = '';
		}

		if (isset($this->request->post['relist_duration'])) {
			$data['relist_duration'] = $this->request->post['relist_duration'];
		} elseif (!empty($product_info) && isset($product_info['relist_duration'])) {
			$data['relist_duration'] = $product_info['relist_duration'];
		} else {
			$data['relist_duration'] = '';
		}

		if (isset($this->request->post['auto_relist'])) {
			$data['auto_relist'] = $this->request->post['auto_relist'];
		} elseif (!empty($product_info) && isset($product_info['auto_relist'])) {
			$data['auto_relist'] = $product_info['auto_relist'];
		} else {
			$data['auto_relist'] = '';
		}

		if (isset($this->request->get['relist'])) {
			
			$data['isRelist'] = true;
		}else{
			$data['isRelist'] = false;
		}

		if (isset($this->request->get['edit'])) {
			
			$data['isEdit'] = true;
		}else{
			$data['isEdit'] = false;
		}

		//end membership code

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['tax_class_id'])) {
			$data['tax_class_id'] = $this->request->post['tax_class_id'];
		} elseif (!empty($product_info)) {
			$data['tax_class_id'] = $product_info['tax_class_id'];
		} else {
			$data['tax_class_id'] = 0;
		}

		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($product_info)) {
			$data['date_available'] = date('Y-m-d', strtotime($product_info['date_available']));
		} else {
			$data['date_available'] = date('Y-m-d', time() - 86400);
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($product_info)) {
			$data['quantity'] = $product_info['quantity'];
		} else {
			$data['quantity'] = 0;
		}

		if (isset($this->request->post['minimum'])) {
			$data['minimum'] = $this->request->post['minimum'];
		} elseif (!empty($product_info)) {
			$data['minimum'] = $product_info['minimum'];
		} else {
			$data['minimum'] = 1;
		}

		if (isset($this->request->post['subtract'])) {
			$data['subtract'] = $this->request->post['subtract'];
		} elseif (!empty($product_info)) {
			$data['subtract'] = $product_info['subtract'];
		} else {
			$data['subtract'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($product_info)) {
			$data['sort_order'] = $product_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (isset($this->request->post['stock_status_id'])) {
			$data['stock_status_id'] = $this->request->post['stock_status_id'];
		} elseif (!empty($product_info)) {
			$data['stock_status_id'] = $product_info['stock_status_id'];
		} else {
			$data['stock_status_id'] = $this->config->get('config_stock_status_id');
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($product_info)) {
			$data['status'] = $product_info['status'];
		} else {
			$data['status'] = 1;
		}

		if (isset($this->request->post['weight'])) {
			$data['weight'] = $this->request->post['weight'];
		} elseif (!empty($product_info)) {
			$data['weight'] = $product_info['weight'];
		} else {
			$data['weight'] = '';
		}

		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['weight_class_id'])) {
			$data['weight_class_id'] = $this->request->post['weight_class_id'];
		} elseif (!empty($product_info)) {
			$data['weight_class_id'] = $product_info['weight_class_id'];
		} else {
			$data['weight_class_id'] = $this->config->get('config_weight_class_id');
		}

		if (isset($this->request->post['length'])) {
			$data['length'] = $this->request->post['length'];
		} elseif (!empty($product_info)) {
			$data['length'] = $product_info['length'];
		} else {
			$data['length'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($product_info)) {	
			$data['width'] = $product_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($product_info)) {
			$data['height'] = $product_info['height'];
		} else {
			$data['height'] = '';
		}

		$this->load->model('localisation/length_class');

		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		if (isset($this->request->post['length_class_id'])) {
			$data['length_class_id'] = $this->request->post['length_class_id'];
		} elseif (!empty($product_info)) {
			$data['length_class_id'] = $product_info['length_class_id'];
		} else {
			$data['length_class_id'] = $this->config->get('config_length_class_id');
		}

		if (isset($this->request->post['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($product_info)) {
			$data['manufacturer_id'] = $product_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($product_info)) {		
			$data['manufacturer'] = $product_info['manufacturer'];			
		} else {
			$data['manufacturer'] = '';
		}
		
		// Categories
		$this->load->model('setting/store');
        $data['stores'] = $this->model_setting_store->getStores();

        $data['marketplace_seller_product_store'] = $this->config->get('marketplace_seller_product_store');

		if (isset($this->request->post['product_store'])) {
			$data['product_store'] = $this->request->post['product_store'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_store'] = $this->model_account_customerpartner->getProductStores($this->request->get['product_id']);
		} else {
			$data['product_store'] = array(0);
		}


		if (isset($this->request->post['product_category'])) {
			$categories = $this->request->post['product_category'];
		} elseif (isset($this->request->get['product_id'])) {		
			$categories = $this->model_account_customerpartner->getProductCategories($this->request->get['product_id']);
		} else {
			$categories = array();
		}

		$data['product_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_account_customerpartner->getCategory($category_id);

			if ($category_info) {
				$data['product_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name']
				);
			}
		}

		// Filters

		if (isset($this->request->post['product_filter'])) {
			$filters = $this->request->post['product_filter'];
		} elseif (isset($this->request->get['product_id'])) {
			$filters = $this->model_account_customerpartner->getProductFilters($this->request->get['product_id']);
		} else {
			$filters = array();
		}

		$data['product_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_account_customerpartner->getFilter($filter_id);

			if ($filter_info) {
				$data['product_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}		

		// Attributes
		if (isset($this->request->post['product_attribute'])) {
			$product_attributes = $this->request->post['product_attribute'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_attributes = $this->model_account_customerpartner->getProductAttributes($this->request->get['product_id']);
		} else {
			$product_attributes = array();
		}

		$data['product_attributes'] = array();

		foreach ($product_attributes as $product_attribute) {

			if ($product_attribute) {
				$data['product_attributes'][] = array(
					'attribute_id'                  => $product_attribute['attribute_id'],
					'name'                          => $product_attribute['name'],
					'product_attribute_description' => $product_attribute['product_attribute_description']
				);
			}
		}		

		// Options
		if (isset($this->request->post['product_option'])) {
			$product_options = $this->request->post['product_option'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_options = $this->model_account_customerpartner->getProductOptions($this->request->get['product_id']);	
		} else {
			$product_options = array();
		}			

		$data['product_options'] = array();

		foreach ($product_options as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				$product_option_value_data = array();

				foreach ($product_option['product_option_value'] as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => number_format($this->currency->convert($product_option_value['price'],$this->config->get('config_currency'),$this->session->data['currency']),2, '.', ''),
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],						
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']	
					);
				}

				$data['product_options'][] = array(
					'product_option_id'    => $product_option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $product_option['option_id'],
					'name'                 => $product_option['name'],
					'type'                 => $product_option['type'],
					'required'             => $product_option['required']
				);				
			} else {
				$data['product_options'][] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'name'              => $product_option['name'],
					'type'              => $product_option['type'],
					'option_value'      => $product_option['option_value'],
					'required'          => $product_option['required']
				);				
			}
		}

		$data['option_values'] = array();

		foreach ($data['product_options'] as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				if (!isset($data['option_values'][$product_option['option_id']])) {
					$data['option_values'][$product_option['option_id']] = $this->model_account_customerpartner->getOptionValues($product_option['option_id']);
				}
			}
		}

		$data['customer_groups'] = $this->model_account_customerpartner->getCustomerGroups();

		if (isset($this->request->post['product_discount'])) {
			$data['product_discounts'] = $this->request->post['product_discount'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_discounts'] = $this->model_account_customerpartner->getProductDiscounts($this->request->get['product_id'],$tabletype);
		} else {
			$data['product_discounts'] = array();
		}

		foreach ($data['product_discounts'] as $key => $value) {
			
			$data['product_discounts'][$key]['price'] = number_format($this->currency->convert($value['price'],$this->config->get('config_currency'),$this->session->data['currency']),2, '.', '');
		}


		if (isset($this->request->post['product_special'])) {
			$data['product_specials'] = $this->request->post['product_special'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_specials'] = $this->model_account_customerpartner->getProductSpecials($this->request->get['product_id'],$tabletype);
		} else {
			$data['product_specials'] = array();
		}

		foreach ($data['product_specials'] as $key => $value) {
			
			$data['product_specials'][$key]['price'] = number_format($this->currency->convert($value['price'],$this->config->get('config_currency'),$this->session->data['currency']),2, '.', '');
		}

		// Images
		if (isset($this->request->post['product_image'])) {
			$product_images = $this->request->post['product_image'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_images = $this->model_catalog_product->getProductImages($this->request->get['product_id'],$tabletype);
		} else {
			$product_images = array();
		}

		$data['product_images'] = array();

		foreach ($product_images as $product_image) {
			if ($product_image['image'] && file_exists(DIR_IMAGE . $product_image['image'])) {
				$image = $product_image['image'];
			} else {
				$image = 'no_image.jpg';
			}

			$data['product_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($image, 100, 100),
				'sort_order' => $product_image['sort_order']
			);
		}

		$data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		// Downloads

		if (isset($this->request->post['product_download'])) {
			$product_downloads = $this->request->post['product_download'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_downloads = $this->model_account_customerpartner->getProductDownloads($this->request->get['product_id'],$tabletype);
		} else {
			$product_downloads = array();
		}

		$data['product_downloads'] = array();

		foreach ($product_downloads as $download_id) {
			$download_info = $this->model_account_customerpartner->getDownloadProduct($download_id,$tabletype);

			if ($download_info) {
				$data['product_downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				);
			}
		}


		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($this->request->get['product_id'])) {		
			$products = $this->model_account_customerpartner->getProductRelated($this->request->get['product_id']);
		} else {
			$products = array();
		}

		$data['product_relateds'] = array();
		foreach ($products as $product_id) {
			$related_info = $this->model_account_customerpartner->getProductRelatedInfo($product_id,$tabletype);

			if ($related_info) {
				$data['product_relateds'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				);
			}
		}

		$this->load->model('account/wkcustomfield');
        $wkcustomFields = array();
		$data['wkcustomFields'] = $this->model_account_wkcustomfield->getOptionList();
		if(isset($this->request->get['product_id']) || isset($this->request->post['product_custom_field'])){
			if(isset($this->request->get['product_id'])){
				$product_id = $this->request->get['product_id'];
			} else {
				$product_id = 0;
			}
			$data['wkPreCustomFields'] = array();
			$wkPreCustomFieldOptions = array();
			$wkPreCustomFields = $this->model_account_wkcustomfield->getProductFields($product_id);
			if(isset($this->request->post['product_custom_field'])){
				foreach ($this->request->post['product_custom_field'] as $key => $value) {
					if(!isset($wkPreCustomFields[$key])){
						$wkPreCustomFields[] = array(
							'fieldId' => $value['custom_field_id'],
							'fieldName' => $value['custom_field_name'],
							'fieldType' => $value['custom_field_type'],
							'fieldDescription' => $value['custom_field_des'],
							'id' => '',
							'isRequired' => $value['custom_field_is_required'],
						);
					}
				}
			}
			foreach($wkPreCustomFields as $field){
            	$wkPreCustomFieldOptions = $this->model_account_wkcustomfield->getOptions($field['fieldId']);
                if($field['fieldType'] == 'select' || $field['fieldType'] == 'checkbox' || $field['fieldType'] == 'radio' ){
                	$wkPreCustomProductFieldOptions = $this->model_account_wkcustomfield->getProductFieldOptions($product_id,$field['fieldId'],$field['id']);
                } else {
                    $wkPreCustomProductFieldOptions = $this->model_account_wkcustomfield->getProductFieldOptionValue($product_id,$field['fieldId'],$field['id']);
                }
                $data['wkPreCustomFields'][] = array(
                	'fieldId'       => $field['fieldId'],
                    'fieldName'     => $field['fieldName'],
                    'fieldType'     => $field['fieldType'],
                    'fieldDes'      => $field['fieldDescription'],
                    'productFieldId'      => $field['id'],
                    'isRequired'    => $field['isRequired'],
                    'fieldOptions'  => $wkPreCustomProductFieldOptions,
                    'preFieldOptions' => $wkPreCustomFieldOptions,
                );
            }
        }
        
        $customPost = array();

        if (isset($this->request->post['product_custom_field']) && $this->request->post['product_custom_field']) {
	        foreach ($this->request->post['product_custom_field'] as $customwk) {
	        	if (isset($customwk['custom_field_value']) && $customwk['custom_field_value']) {
	        		$customPost[$customwk['custom_field_id']] = $customwk['custom_field_value'];
	        	}	        		
	        }        	
        }

        $data['customPost'] = $customPost;

		if (isset($this->request->post['points'])) {
			$data['points'] = $this->request->post['points'];
		} elseif (!empty($product_info)) {
			$data['points'] = $product_info['points'];
		} else {
			$data['points'] = '';
		}
		
		$data['isMember'] = true;

		 // membership codes starts here
		if($this->config->get('wk_seller_group_status')) {
      		$data['wk_seller_group_status'] = true;
      		$this->load->model('account/customer_group');
			$isMember = $this->model_account_customer_group->getSellerMembershipGroup($this->customer->getId());
			if($isMember) {
				$allowedAccountMenu = $this->model_account_customer_group->getaccountMenu($isMember['gid']);
				if($allowedAccountMenu['value']) {
					$accountMenu = explode(',',$allowedAccountMenu['value']);
					if($accountMenu && !in_array('addproduct:addproduct', $accountMenu)) {
						$data['isMember'] = false;
					}
				}
			} else {
				$data['isMember'] = false;
			}
      	} else {
      		if(!in_array('addproduct', $this->config->get('marketplace_allowed_account_menu'))) {
      			$this->response->redirect($this->url->link('account/account','', 'SSL'));
      		}
      	}

      	 // membership codes ends here
   
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');	

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/addproduct.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/customerpartner/addproduct.tpl' , $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/customerpartner/addproduct.tpl' , $data));
		}
	}
	
	public function getOptions(){
		if($this->request->server['REQUEST_METHOD'] == 'POST' && $this->request->post['value'] != ''){
        	$this->language->load("account/customerpartner/wkcustomfield");
            $this->load->model("account/wkcustomfield");
            $options = array();
			$options = $this->model_account_wkcustomfield->getOptions($this->request->post['value']);
            $this->response->setOutput(json_encode($options));
        }
    }

	private function validate() {

		$error = true;
		$files = $this->request->files;	

		if($files){
			foreach ($files as $value) {
				if(is_array($value['name'])){
					if(count($files['product_image']['name']) > (int)$this->config->get('marketplace_noofimages')){
						$this->error['warning'] = $this->language->get('error_no_of_images').$this->config->get('marketplace_noofimages');	
						return false;		
					}

					foreach ($value['name'] as $key => $v2) {

						$file_data =array(
							'name'     => $v2['image'],
							'type'     => $value['type'][$key]['image'],
							'tmp_name' => $value['tmp_name'][$key]['image'],
							'error'    => $value['error'][$key]['image'],
							'size'     => $value['size'][$key]['image'],
						); 
						
						if($v2['image'] AND !$this->checkext($file_data)){
							return false;
						}
					}
				}else{
					if($value['name'] AND !$this->checkext($value)){
						return false;
					}
				}
			}
		}

		return $error;
	}

	private function checkext($value){
		$error = true;

		$this->load->language('account/customerpartner/addProduct');
		
		if (isset($value['name']) && !empty($value['name']) && is_file($value['tmp_name'])) {
			// Sanitize the filename
			$filename = basename(html_entity_decode($value['name'], ENT_QUOTES, 'UTF-8'));
      
			// Validate the filename length
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 255)) {
				$this->error['warning'] = $this->language->get('error_filename');
				$error = false;
			}

			// Allowed file extension types
			$allowed = explode(',',$this->config->get('marketplace_imageex'));

			if (!in_array(utf8_strtolower(utf8_substr(strrchr($filename, '.'), 1)), $allowed)) {
				$this->error['warning'] = $this->language->get('error_filetype');
				$error = false;
			}

			if ($value['size'] > ($this->config->get('marketplace_imagesize') ? $this->config->get('marketplace_imagesize')*1000 : 200000 )) { //1000 = 1kb	
				
				$this->error['warning'] = $this->language->get('error_size').( $this->config->get('marketplace_imagesize') ? $this->config->get('marketplace_imagesize')  : 200 ).' kb';
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


	protected function validateForm() {

		foreach ($this->request->post['product_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 1) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['error_meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}
		
		if($this->config->get('marketplace_allowedproductcolumn') AND in_array('model',$this->config->get('marketplace_allowedproductcolumn'))) {
			if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
				$this->error['model'] = $this->language->get('error_model');
			}
		}

		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$url_alias_info = $this->model_account_customerpartner->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['product_id']) && $url_alias_info['query'] != 'product_id=' . $this->request->get['product_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['product_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

        $customfielddata = array();
        if(isset($this->request->post['product_custom_field'])){
        	$customfielddata = $this->request->post['product_custom_field'];
        }
        foreach ($customfielddata as $key => $value) {
        	if(($value['custom_field_is_required'] == 'yes' && isset($value['custom_field_value']) && $value['custom_field_value'][0] == '' ) || ($value['custom_field_is_required'] == 'yes' && !isset($value['custom_field_value']))) {
            	$this->error['customFieldError'][] = $value['custom_field_id'];
            }
        }
        if(isset($this->error['customFieldError'])) {
        	$this->error['warning'] = $this->language->get('error_warning');
        }
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		if($this->config->get('wk_seller_group_status')) {
			$this->load->model('account/wk_membership_catalog');
			$this->load->language('account/customerpartner/wk_membership_catalog');

			if ($this->config->get('wk_seller_group_membership_type') == 'quantity') {
				
			    if(isset($this->request->post['clone']) && $this->request->post['clone']) {
					$quantity = $this->request->post['quantity'];
				} else if($this->request->post['quantity'] > $this->request->post['prevQuantity']) {
					$quantity = $this->request->post['quantity'] - $this->request->post['prevQuantity'];
				} else {
					$quantity = 0;
				}

				if($this->request->post['price'] > $this->request->post['prevPrice']) {
					$price = $this->request->post['price'] - $this->request->post['prevPrice'];
				} else {
					$price = 0;
				}

				// modification
				if ($quantity && !$price && isset($this->request->post['prevPrice']) && $this->request->post['prevPrice']) {
					
					$price = $this->request->post['prevPrice'];
				}

				if ($price && !$quantity && isset($this->request->post['prevQuantity']) && $this->request->post['prevQuantity']) {
					
					$quantity = $this->request->post['prevQuantity'];
				}

				// modification

				if(isset($this->request->post['product_category']) && is_array($this->request->post['product_category']) ) {
					$category_id = $this->request->post['product_category'];
				} else {
					$category_id[] = 0;
				}

				$seller_id = $this->customer->getId();

				foreach ($category_id as $key => $value) {

					$check[] = $this->model_account_wk_membership_catalog->checkAvailabilityToAdd($quantity, $seller_id, $price, $value);

					if(in_array('', $check)) {
						$result = '';
					} else {
						$result = $check;
					}

				}
			}elseif((isset($this->request->post['edit']) && $this->request->post['edit']) || (isset($this->request->post['relist']) && $this->request->post['relist'])){
                 
                 if(isset($this->request->post['product_category']) && is_array($this->request->post['product_category']) ) {
					$category_id = $this->request->post['product_category'];
				 } else {
					$category_id[] = 0;
				 }


				foreach ($category_id as $key => $value) {

					$check[] = $this->model_account_wk_membership_catalog->checkAvailabilityProductToAdd($value,$this->request->post);

					if(in_array('', $check)) {
						$result = '';
					} else {
						$result = $check;
					}

				} 



			}else{

				if(isset($this->request->post['product_category']) && is_array($this->request->post['product_category']) ) {
					$category_id = $this->request->post['product_category'];
				} else {
					$category_id[] = 0;
				}


				foreach ($category_id as $key => $value) {

					$check[] = $this->model_account_wk_membership_catalog->checkAvailabilityProductToAdd($value);

					if(in_array('', $check)) {
						$result = '';
					} else {
						$result = $check;
					}

				}
			}

			if($result) {
				if($this->error) {
					return false;
				}else {
					return $this->membershipData['remain'] = $result;
				}
			} else {
				$this->error['warning'] = " Warning: ".$this->language->get('error_insufficient_bal');
			}	
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

    /**
     * [uploadSummernoteImage uses for uploading images by summernote for the seller]
     * @return [type] [json]
     */
	public function uploadSummernoteImage (){

		$this->load->language('account/customerpartner/addproduct');

		$dir=$this->customer->getFirstName().$this->customer->getId();


		if (!file_exists(DIR_IMAGE.'wkseller/'.$dir)) {
			    mkdir(DIR_IMAGE.'wkseller/'.$dir, 0777, true);
		}

		$json = array();

		if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
			// Sanitize the filename
			$filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));

			// Validate the filename length
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 255)) {
				$json['error'] = $this->language->get('error_filename');
			}

			// Allowed file extension types
			$allowed = array(
				'jpg',
				'jpeg',
				'gif',
				'png'
			);

			if (!in_array(utf8_strtolower(utf8_substr(strrchr($filename, '.'), 1)), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Allowed file mime types
			$allowed = array(
				'image/jpeg',
				'image/pjpeg',
				'image/png',
				'image/x-png',
				'image/gif'
			);

			if (!in_array($this->request->files['file']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Check to see if any PHP files are trying to be uploaded
			$content = file_get_contents($this->request->files['file']['tmp_name']);

			if (preg_match('/\<\?php/i', $content)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Return any upload error
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}

		if (!$json) {
			move_uploaded_file($this->request->files['file']['tmp_name'],DIR_IMAGE.'wkseller/'.$dir.'/'.$this->request->files['file']['name']);

			$json['image'] = HTTP_SERVER.'image/wkseller/'.$dir.'/'.$this->request->files['file']['name'];

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}
}
?>
