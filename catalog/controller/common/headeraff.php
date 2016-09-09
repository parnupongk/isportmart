<?php
class ControllerCommonHeaderaff extends Controller {
	public function index() {
		$data['title'] = $this->document->getTitle();

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');			
		}

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

		$this->load->language('common/headeraff');

		$data['text_home'] = $this->language->get('text_home');
		$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');
		$data['text_delivery'] = $this->language->get('text_delivery');
		$data['text_condition'] = $this->language->get('text_condition');
		$data['text_policy'] = $this->language->get('text_policy');
		$data['text_payment'] = $this->language->get('text_payment');
		$data['text_returnprd'] = $this->language->get('text_returnprd');

		//-------nid 01/04/2016------
		$data['text_order'] = $this->language->get('text_order');
		$data['text_order_approve'] = $this->language->get('text_order_approve');
		$data['text_order_status'] = $this->language->get('text_order_status');
		$data['text_complete_status'] = $this->language->get('text_complete_status');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_stock'] = $this->language->get('text_stock');
		//-----------------------------------
		$this->load->model('affiliate/order');
		// Processing Orders
		$order_status_total = $this->model_affiliate_order->getTotalTransferForBell();
		$data['order_status_total'] = $order_status_total;
		$data['order_status'] = $this->url->link('affiliate/order','filter_status=Transfer', 'SSL');
		$this->load->model('affiliate/stock');
	    $product_total = $this->model_affiliate_stock->getTotalProducts(array('filter_quantity' => 0));
        $data['product_total'] = $product_total;
        $data['product'] = $this->url->link('affiliate/stock','filter_quantity=0', 'SSL');
    //16/3/2016 09:56 nid add
    $alerts = $this->model_affiliate_order->getTotalApproveForBell();     
    $data['alerts'] = $alerts;
    $data['alerts_status'] = $this->url->link('affiliate/order','filter_status=Approve', 'SSL');
      //  $data['alerts'] = $order_status_total + $product_total;
		//-------nid 01/04/2016------

		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['logged'] = $this->affiliate->isLogged();
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['register'] = $this->url->link('account/register', '', 'SSL');
		$data['login'] = $this->url->link('account/login', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['logout'] = $this->url->link('account/logout', '', 'SSL');
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		$data['contact'] = $this->url->link('information/contact');
		$data['delivery'] = $this->url->link('information/information', 'information_id=6', 'SSL');
		$data['condition'] = $this->url->link('information/information', 'information_id=3', 'SSL');
		$data['policy'] = $this->url->link('information/information', 'information_id=5', 'SSL');
		$data['payment'] = $this->url->link('information/information', 'information_id=7', 'SSL');
		$data['return'] = $this->url->link('account/return/add', '', 'SSL');
		
		if (isset($this->session->data['cust_ani'])) {
			$data['telephone'] = $this->session->data['cust_ani'];
		} else {
			$this->session->data['cust_ani'] = '0000000000';
			$data['telephone'] = '0000000000';
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
// nid add 19/4/2016 15:00
if(!empty($this->request->get['order_id'])){


			return $this->load->view('default/template/common/headeraff.tpl', $data);

	}else{
		//koy add 27/5/2016
		if (isset($this->session->data['agent_id'])) {
			return $this->load->view('default/template/common/headeraff_bell.tpl', $data);
		} elseif (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/headeraff_bell.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/headeraff_bell.tpl', $data);
		} else {
			return $this->load->view('default/template/common/headeraff_bell.tpl', $data);
		}
	}
	// nid add 19/4/2016 15:00
	}
}