<?php  
class ControllerModuleMarketplace extends Controller { 

	private $data = array();

	public function index() {

		$this->load->model('account/customerpartner');

		$this->load->model('customerpartner/master');

		$this->language->load('module/marketplace');
		
    	$data['heading_title'] = $this->language->get('heading_title');

		$data['text_my_profile'] = $this->language->get('text_my_profile');
		$data['text_addproduct'] = $this->language->get('text_addproduct');
		$data['text_wkshipping'] = $this->language->get('text_wkshipping');
		$data['text_productlist'] = $this->language->get('text_productlist');
		$data['text_dashboard'] = $this->language->get('text_dashboard');
		$data['text_orderhistory'] = $this->language->get('text_orderhistory');
		$data['text_becomePartner'] = $this->language->get('text_becomePartner');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_transaction'] = $this->language->get('text_transaction');		

		$data['text_ask_admin'] = $this->language->get('text_ask_admin');
		$data['text_ask_question'] = $this->language->get('text_ask_question');
		$data['text_close'] = $this->language->get('text_close');
		$data['text_subject'] = $this->language->get('text_subject');
		$data['text_ask'] = $this->language->get('text_ask');
		$data['text_send'] = $this->language->get('text_send');
		$data['text_error_mail'] = $this->language->get('text_error_mail');		
		$data['text_success_mail'] = $this->language->get('text_success_mail');		
		$data['text_ask_seller']	=	$this->language->get('text_ask_seller');

		$data['text_welcome'] = $this->language->get('text_welcome');
		$data['text_low_stock']	=	$this->language->get('text_low_stock');
		$data['text_most_viewed']	=	$this->language->get('text_most_viewed');
		$data['text_productname'] = $this->language->get('text_productname');
		$data['text_model']	=	$this->language->get('text_model');
		$data['text_views']	=	$this->language->get('text_views');
		$data['text_quantity']	=	$this->language->get('text_quantity');
		$data['text_more_work']	=	$this->language->get('text_more_work');
		
		//for mp		
		$data['text_from']	=	$this->language->get('text_from');
		$data['text_seller']	=	$this->language->get('text_seller');
		$data['text_total_products']	=	$this->language->get('text_total_products');
		$data['text_tax']	=	$this->language->get('text_tax');
		$data['text_latest_product']	=	$this->language->get('text_latest_product');

		$data['button_cart']	=	$this->language->get('button_cart');
		$data['button_wishlist']	=	$this->language->get('button_wishlist');
		$data['button_compare']	=	$this->language->get('button_compare');
		
		$data['logged'] = $this->customer->isLogged();
		$data['contact_mail'] = true;

		$data['send_mail'] = $this->url->link('account/customerpartner/sendmail','','SSL'); 
		$data['redirect_user'] = $this->url->link('account/login','','SSL'); 

		$data['launchModal'] = false;

		if($this->config->get('config_template') == 'journal2' || $this->config->get('config_template') == 'hodeco') {
			if(isset($this->session->data['openModal2']) && $this->session->data['openModal2']) {
				$this->session->data['openModal2'] = false;
				$data['launchModal'] = true;
		    }

			if($this->model_account_customerpartner->chkIsPartner()) {
				if(!isset($this->session->data['openModal']) || $this->session->data['openModal']) {
					$this->session->data['openModal'] = false;
					$this->session->data['openModal2'] = true;
				}
			}
		} else {
			$data['launchModal'] = false;
			if($this->model_account_customerpartner->chkIsPartner()) {
				if(!isset($this->session->data['openModal']) || $this->session->data['openModal']) {
					$this->session->data['openModal'] = false;
					$data['launchModal'] = true;
				}
			}
		}

		$mp_language = array();

		if(isset($this->request->get['route']) AND (substr($this->request->get['route'],0,8)=='account/')) {

			if($this->config->get('marketplace_account_menu_sequence')) {
				foreach ($this->config->get('marketplace_account_menu_sequence') as $key => $lang_value) {
					$mp_language[$key] = $this->language->get('text_'.$key);
				}
				$data['marketplace_account_menu_sequence'] = $mp_language;
			}
			
			$data['isMember'] = false;
			if($this->config->get('wk_seller_group_status')) {
	      		$data['wk_seller_group_status'] = true;
	      		$this->load->model('account/customer_group');
				$isMember = $this->model_account_customer_group->getSellerMembershipGroup($this->customer->getId());
				if($isMember) {
					$allowedAccountMenu = $this->model_account_customer_group->getaccountMenu($isMember['gid']);
					if($allowedAccountMenu['value']) {
						$accountMenu = explode(',',$allowedAccountMenu['value']);
						foreach ($accountMenu as $key => $menu) {
							$aMenu = explode(':', $menu);	
							$data['marketplace_allowed_account_menu'][$aMenu[0]] = $aMenu[1];
						}
					}
					$data['isMember'] = true;
				} else {
					$data['isMember'] = false;
				}
	      	}

	      	if ($this->model_account_customerpartner->chkIsPartner() && !$data['isMember'] && $this->config->get('wk_seller_group_status')) {
	      		
	      		$data['marketplace_allowed_account_menu']['membership'] = 'membership';
	      	}

	      	if($this->config->get('marketplace_allowed_account_menu') && !$this->config->get('wk_seller_group_status')) {
				$data['marketplace_allowed_account_menu'] = $this->config->get('marketplace_allowed_account_menu');
			}
			
			$data['mail_for'] = '&contact_admin=true';
			$data['want_partner'] = $this->url->link('account/customerpartner/become_partner','','SSL');

			$data['account_menu_href'] = array(
				'profile' => $this->url->link('account/customerpartner/profile', '', 'SSL'),
				'dashboard' => $this->url->link('account/customerpartner/dashboard', '', 'SSL'),
				'orderhistory' => $this->url->link('account/customerpartner/orderlist', '', 'SSL'),
				'transaction' => $this->url->link('account/customerpartner/transaction', '', 'SSL'),
				'productlist' => $this->url->link('account/customerpartner/productlist', '', 'SSL'),
				'addproduct' => $this->url->link('account/customerpartner/addproduct', '', 'SSL'),
				'downloads' => $this->url->link('account/customerpartner/download', '', 'SSL'),
				'manageshipping' => $this->url->link('account/customerpartner/add_shipping_mod', '', 'SSL'),
				'asktoadmin' => $this->url->link('account/customerpartner/addproduct', '', 'SSL'),
			);


        	/*
			Membership code
			add link to existing account menu array
			 */
			if($this->config->get('wk_seller_group_status')) {
	        	$data['wk_seller_group_status'] = true;
	        	$data['account_menu_href']['membership'] = $this->url->link('account/customerpartner/wk_membership_catalog','','SSL');
	        } else {
	        	$data['wk_seller_group_status'] = false;
	        	if(isset($data['account_menu_href']['membership'])) {
	        		unset($data['account_menu_href']['membership']);
	        	}
	        	if(isset($data['marketplace_account_menu_sequence']['membership'])) {
	        		unset($data['marketplace_account_menu_sequence']['membership']);
	        	}
	        }
	    	/*
	    	end here
	    	 */ 
            
	    	$data['mostViewedProducts'] = $this->model_account_customerpartner->getMostViewedProducts($this->customer->getId());
	    	$data['lowStockProducts'] = $this->model_account_customerpartner->getLowStockProducts($this->customer->getId());
	    	$data['totalProductsLowStock'] = $data['lowStockProducts']['count'];
	    	
	    	$data['sellerProfile'] = $this->model_account_customerpartner->getProfile();

            $this->load->model("tool/image");

	    	if ($data['sellerProfile']) {
		    	if(isset($data['sellerProfile']['avatar']) && $data['sellerProfile']['avatar']) {
		    		$data['sellerProfile']['avatar'] = $this->model_tool_image->resize($data['sellerProfile']['avatar'], 100, 100);
		    	} else if($this->config->get('marketplace_default_image_name')) {
		    		$data['sellerProfile']['avatar'] = $this->model_tool_image->resize($this->config->get('marketplace_default_image_name'), 100, 100);
		    	} else {
		    		$data['sellerProfile']['avatar'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		    	}
	    	}else{

	    		$data['sellerProfile']['avatar'] = $this->model_tool_image->resize('no_image.png', 100, 100);
	    		$data['sellerProfile']['firstname'] = '';
	    		$data['sellerProfile']['lastname'] = '';
	    	}
	    

	    	$data['moreProductUrl'] = $this->url->link('account/customerpartner/productlist', '', '');

			$data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();

		} elseif(isset($this->request->get['route']) AND $this->request->get['route']=='product/product' AND isset($this->request->get['product_id']) && $this->config->get('marketplace_seller_info_by_module') && !$this->config->get('marketplace_seller_info_hide')) {

			$data['mail_for'] = '&contact_seller=true';
			$data['text_ask_question'] = $this->language->get('text_ask_seller');

			if(!$data['logged'])
				$data['text_ask_seller'] = $this->language->get('text_ask_seller_log');
			
			$id = $this->model_customerpartner_master->getPartnerIdBasedonProduct($this->request->get['product_id']);

			if (isset($id['id']) && ($id['id'] == $this->customer->getId())) {
				
				$data['contact_mail'] = false;
			}else{
				$data['contact_mail'] = $this->config->get('marketplace_customercontactseller');
			}

			if($this->config->get('marketplace_product_show_seller_product')) {
				$data['show_seller_product'] = $this->config->get('marketplace_product_show_seller_product');
			} else {
				$data['show_seller_product'] = false;
			}
			$this->load->model('tool/image');
			if(isset($id['id']) AND $id['id']){

				$partner = $this->model_customerpartner_master->getProfile($id['id']);
				if($partner){

					if($this->config->get('marketplace_product_name_display')) {
						if($this->config->get('marketplace_product_name_display') == 'sn') {
							$data['displayName'] = $partner['firstname']." ".$partner['lastname'];
						} else if($this->config->get('marketplace_product_name_display') == 'cn') {
							$data['displayName'] = $partner['companyname'];
						} else {
							$data['displayName'] = $partner['companyname']." (".$partner['firstname']." ".$partner['lastname'].")";
						}
					}

					if($this->config->get('marketplace_product_image_display')) {
						$partner['companylogo'] = $partner[$this->config->get('marketplace_product_image_display')];
					}

					if ($partner['companylogo'] && file_exists(DIR_IMAGE . $partner['companylogo'])) {
						$partner['thumb'] = $this->model_tool_image->resize($partner['companylogo'], 120, 120);
						// $partner['avatar'] = HTTP_SERVER.'image/'.$partner['avatar'];			
					} else if($this->config->get('marketplace_default_image_name')) {
						$partner['thumb'] = $this->model_tool_image->resize($this->config->get('marketplace_default_image_name'), $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					} else {
						$partner['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
					}

					$data['seller_id'] = $id['id'];

					$partner['sellerHref'] = $this->url->link('customerpartner/profile&id='.$id['id'],'','SSL');
					$data['collectionHref'] = $this->url->link('customerpartner/profile&id='.$id['id'],'&collection','SSL');
					$partner['name'] = $partner['firstname'].' '.$partner['lastname'];
					$partner['total_products'] = $this->model_customerpartner_master->getPartnerCollectionCount($id['id']);
					$partner['feedback_total'] = round($this->model_customerpartner_master->getAverageFeedback($id['id']));

					$data['partner'] = $partner;

					$filter_array = array( 'start' => 0,
										   'limit' => 4,
										   'customer_id' => $id['id'],
										   'filter_status' => 1,
										   'filter_store' => $this->config->get('config_store_id')

										   );

					$latest = $this->model_account_customerpartner->getProductsSeller($filter_array);

					$data['latest'] = array();

					if($latest)
						foreach($latest as $key => $result){

							if($result['product_id']==$this->request->get['product_id'])
								continue;						

							if ($result['image']) {
								$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
							} else {
								$image = $this->model_tool_image->resize('no_image.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
							}

							if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
								$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
							} else {
								$price = false;
							}

							if ((float)$result['special']) {
								$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
							} else {
								$special = false;
							}

							if ($this->config->get('config_tax')) {
								$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
							} else {
								$tax = false;
							}

							if ($this->config->get('config_review_status')) {
								$rating = (int)$result['rating'];
							} else {
								$rating = false;
							}

							$data['latest'][] = array(
								'product_id'  => $result['product_id'],
								'thumb'       => $image,
								'name'        => $result['name'],
								'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
								'price'       => $price,
								'special'     => $special,
								'tax'         => $tax,
								'rating'      => $result['rating'],
								'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
							);

						}
				}

			}else
				return;

		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/marketplace.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/marketplace.tpl', $data);
		} else {
			return $this->load->view('default/template/module/marketplace.tpl', $data);
		}

	}
    
 
}
?>
