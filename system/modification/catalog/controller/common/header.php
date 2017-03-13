<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		$data['title'] = $this->document->getTitle();

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');			
		}

		$data['cust_id'] = $this->customer->getId();
		
		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		if ($this->config->get('config_google_analytics_status')) {
			$data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		} else {
			$data['google_analytics'] = '';
		}

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$data['icon'] = $server . 'image/' . $this->config->get('config_icon');
		} else {
			$data['icon'] = '';
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');
		$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_history'] = $this->language->get('text_history');		
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');
		$data['text_delivery'] = $this->language->get('text_delivery');
		//$data['text_condition'] = $this->language->get('text_condition');
		$data['text_policy'] = $this->language->get('text_policy');
		$data['text_payment'] = $this->language->get('text_payment');
		$data['text_returnprd'] = $this->language->get('text_returnprd');
		$data['text_checktracking'] = $this->language->get('text_checktracking');

		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['register'] = $this->url->link('account/register', '', 'SSL');
		$data['login'] = $this->url->link('account/login', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['history'] = $this->url->link('account/history', '', 'SSL');		
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['logout'] = $this->url->link('account/logout', '', 'SSL');
		$data['shopping_cart'] = $this->url->link('checkout/cart');

                          $data['wkget_timezone'] = $this->config->get('wkproduct_auction_timezone_set');
                      if($data['wkget_timezone']){
                          $data['menuauction'] = $this->url->link('catalog/wkallauctions', '', 'SSL');
                        }
                        
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

        $data['menusell'] = $this->url->link('customerpartner/sell', '', 'SSL');
        $this->language->load('module/marketplace');
        $data['marketplace_status'] = $this->config->get('marketplace_status');
        $data['text_sell_header'] = $this->language->get('text_sell_header');
        $data['text_my_profile'] = $this->language->get('text_my_profile');
        $data['text_addproduct'] = $this->language->get('text_addproduct');
        $data['text_wkshipping'] = $this->language->get('text_wkshipping');
        $data['text_productlist'] = $this->language->get('text_productlist');
        $data['text_dashboard'] = $this->language->get('text_dashboard');
        $data['text_orderhistory'] = $this->language->get('text_orderhistory');
        $data['text_becomePartner'] = $this->language->get('text_becomePartner');
        $data['text_download'] = $this->language->get('text_download');
        $data['text_transaction'] = $this->language->get('text_transaction'); 
        $data['marketplace_allowed_account_menu'] = $this->config->get('marketplace_allowed_account_menu');
        $data['mp_addproduct'] = $this->url->link('account/customerpartner/addproduct', '', 'SSL');
        $data['mp_productlist'] = $this->url->link('account/customerpartner/productlist', '', 'SSL');
        $data['mp_dashboard'] = $this->url->link('account/customerpartner/dashboard', '', 'SSL');
        $data['mp_add_shipping_mod'] = $this->url->link('account/customerpartner/add_shipping_mod','', 'SSL');
        $data['mp_orderhistory'] = $this->url->link('account/customerpartner/orderlist','', 'SSL');
        $data['mp_download'] = $this->url->link('account/customerpartner/download','', 'SSL');
        $data['mp_profile'] = $this->url->link('account/customerpartner/profile','','SSL');      
        $data['mp_want_partner'] = $this->url->link('account/customerpartner/become_partner','','SSL'); 
        $data['mp_transaction'] = $this->url->link('account/customerpartner/transaction','','SSL'); 
        $this->load->model('account/customerpartner');   
        if($this->config->get('marketplace_status')){            
            $data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner(); 
        }
                    
		$data['contact'] = $this->url->link('information/contact');
		$data['policy'] = $this->url->link('information/information', 'information_id=5', 'SSL');
		$data['delivery'] = $this->url->link('information/information', 'information_id=6', 'SSL');
		//$data['condition'] = $this->url->link('information/information', 'information_id=3', 'SSL');
		$data['payment'] = $this->url->link('information/information', 'information_id=7', 'SSL');
		//$data['return'] = $this->url->link('account/return/add', '', 'SSL');
		$data['return'] = $this->url->link('information/information', 'information_id=8', 'SSL');
		if (isset($this->session->data['agent_id'])) {
			$data['agent_id'] = $this->session->data['agent_id'];
		} else {
			$data['agent_id'] = '0';
		}
		
		if (isset($this->session->data['cust_ani'])) {
			$data['telephone'] = $this->session->data['cust_ani'];
		} else {
			$this->session->data['cust_ani'] = '0000000000';
			$data['telephone'] = '025026505';
		}
		
		if (isset($this->session->data['cust_step'])) {
			$data['cust_step'] = $this->session->data['cust_step'];
		} else {
			$this->session->data['cust_step'] = '1';
			$data['cust_step'] = '1';
		}
		
				

		$status = true;

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;

					break;
				}
			}
		}

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');
		
		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
			
		} else {
			$data['class'] = 'common-home';
		}

		//koy add 27/5/2016
		if (isset($this->session->data['agent_id'])) {
			return $this->load->view('default/template/common/header.tpl', $data);
		} elseif (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/header.tpl', $data);
		} else {
			return $this->load->view('default/template/common/header.tpl', $data);
		}
	}
}