<?php

/**
* @version 2.2.0.0
* @copyright Webkul Software Pvt Ltd
*/

class ControllerCustomerpartnerProfile extends Controller {

	/**
	 * [$error description] Array to contain all errors
	 * @var array
	 */
	private $error = array();
	
	public function index() {

		if(!isset($this->request->get['id']))
			$this->request->get['id'] = 0;
		
		$data['id'] = $this->request->get['id'];

		$this->load->model('tool/image');	

		$this->load->model('customerpartner/master');	

		$this->language->load('customerpartner/profile');
		
		$this->document->setTitle($this->language->get('heading_title'));
				
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_collection'] = $this->language->get('text_collection');
		$data['text_location'] = $this->language->get('text_location');
		$data['text_reviews'] = $this->language->get('text_reviews');
		$data['text_product_reviews'] = $this->language->get('text_product_reviews');
		$data['text_profile'] = $this->language->get('text_profile');
		$data['text_from']	=	$this->language->get('text_from');
		$data['text_seller']	=	$this->language->get('text_seller');
		$data['text_total_products']	=	$this->language->get('text_total_products');		

		$this->language->load('customerpartner/feedback');
	
		$data['text_write'] = $this->language->get('text_write');
		$data['text_note'] = $this->language->get('text_note');
		$data['entry_bad'] = $this->language->get('entry_bad');
		$data['entry_good'] = $this->language->get('entry_good');
		$data['entry_captcha'] = $this->language->get('entry_captcha');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_nickname'] = $this->language->get('text_nickname');
		$data['text_review'] = $this->language->get('text_review');
		$data['text_no_feedbacks'] = $this->language->get('text_no_feedbacks');		
		$data['text_price'] = $this->language->get('text_price');
		$data['text_value'] = $this->language->get('text_value');
		$data['text_quality'] = $this->language->get('text_quality');		
		$data['button_continue'] = $this->language->get('button_continue');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_write_review'] = $this->language->get('text_write_review');
		$data['text_login_contact'] = $this->language->get('text_login_contact');
		$data['text_login_review'] = $this->language->get('text_login_review');


		$this->language->load('module/marketplace');

		$data['text_ask_admin'] = $this->language->get('text_ask_admin');
		$data['text_ask_question'] = $this->language->get('text_ask_question');
		$data['text_close'] = $this->language->get('text_close');
		$data['text_subject'] = $this->language->get('text_subject');
		$data['text_ask'] = $this->language->get('text_ask');
		$data['text_send'] = $this->language->get('text_send');
		$data['text_error_mail'] = $this->language->get('text_error_mail');		
		$data['text_success_mail'] = $this->language->get('text_success_mail');		
		$data['text_ask_seller']	=	$this->language->get('text_ask_seller');

		$data['logged'] = $this->customer->isLogged();
		$data['send_mail'] = $this->url->link('account/customerpartner/sendmail','','SSL'); 
		$data['mail_for'] = '&contact_seller=true';
		
		$this->document->addStyle('catalog/view/theme/default/stylesheet/MP/profile.css');

      	if(isset($this->request->get['collection'])) {
      		$data['showCollection'] = true;
      	} else {
      		$data['showCollection'] = false;
      	}

      	$data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),     	
        	'separator' => false
      	);	

      	/**
      	 * Code for marketplace membership if module is installed the only it will work
      	 */
		if($this->config->get('wk_seller_group_status')) {
			$this->load->model('account/customer_group');
			$isMember = $this->model_account_customer_group->getSellerMembershipGroup($this->request->get['id']);
			if($isMember) {
				$allowedAccountMenu = $this->model_account_customer_group->getpublicSellerProfile($isMember['gid'], $this->request->get['id']);
				if($allowedAccountMenu['value']) {
					$accountMenu = explode(',',$allowedAccountMenu['value']);
					if($accountMenu) {
						foreach ($accountMenu as $key => $value) {
							$values = explode(':',$value);
							$data['public_seller_profile'][$values[0]] = $values[1];
						}
					}
				}
			}
		} else if($this->config->get('marketplace_allowed_public_seller_profile')) {
			$data['public_seller_profile'] = $this->config->get('marketplace_allowed_public_seller_profile');
		}

		$partner = $this->model_customerpartner_master->getProfile($this->request->get['id']);

		if(!$partner)
			$this->response->redirect($this->url->link('error/not_found'));
		
		if ($partner['companybanner'] && file_exists(DIR_IMAGE . $partner['companybanner'])) {
			$partner['companybanner'] = HTTP_SERVER.'image/'.$partner['companybanner'];
		} else {
			if($partner['companybanner'] != 'removed') {
				$partner['companybanner'] = HTTP_SERVER.'image/'.$this->config->get('marketplace_default_image_name');
			} else {
				$partner['companybanner'] = '';
			}
		}

		if ($partner['companylogo'] && file_exists(DIR_IMAGE . $partner['companylogo'])) {
			$partner['companylogo'] = $this->model_tool_image->resize($partner['companylogo'], 300, 80 );
		} else if($this->config->get('marketplace_default_image_name') && file_exists(DIR_IMAGE . $this->config->get('marketplace_default_image_name'))) {
			if($partner['companylogo'] != 'removed') {
				$partner['companylogo'] = $this->model_tool_image->resize($this->config->get('marketplace_default_image_name'), 300, 80 );
			} else {
				$partner['companylogo'] = '';
			}
		}

		if ($partner['avatar'] && file_exists(DIR_IMAGE . $partner['avatar'])) {
			$partner['avatar'] = $this->model_tool_image->resize($partner['avatar'], 120, 120);
		} else if($this->config->get('marketplace_default_image_name') && file_exists(DIR_IMAGE . $this->config->get('marketplace_default_image_name'))) {
			if($partner['avatar'] != 'removed') {
				$partner['avatar'] = $this->model_tool_image->resize($this->config->get('marketplace_default_image_name'), 100, 100);
			} else {
				$partner['avatar'] = '';
			}
		}

		if ($this->config->get('marketplace_profile_email')) {
			$data['email'] = 1;
		} else {
			$data['email'] = 0;
		}

		if ($this->config->get('marketplace_profile_telephone')) {
			$data['telephone'] = 1;
		} else {
			$data['telephone'] = 0;
		}
		
		$data['customer_id'] = $this->customer->getId();
		
		$data['partner'] = $partner;

		$data['feedback_total'] = $this->model_customerpartner_master->getAverageFeedback($this->request->get['id']);
		$data['seller_total_products'] = $this->model_customerpartner_master->getPartnerCollectionCount($this->request->get['id']);

		$data['loadLocation'] = $this->url->link('customerpartner/profile/loadLocation&location='.$partner['companylocality'],'','SSL');
		$data['feedback'] = $this->url->link('customerpartner/profile/feedback&id='.$this->request->get['id'],'','SSL');
		$data['writeFeedback'] = $this->url->link('customerpartner/profile/writeFeedback&id='.$this->request->get['id'],'','SSL');
		$data['product_feedback'] = $this->url->link('customerpartner/profile/productFeedback&id='.$this->request->get['id'],'','SSL');
		$data['collection'] = $this->url->link('customerpartner/profile/collection&id='.$this->request->get['id'],'','SSL');

		$data['product_feedback_total'] = $this->model_customerpartner_master->getTotalProductFeedbackList($this->request->get['id']);
		$data['collection_total'] = $this->model_customerpartner_master->getPartnerCollectionCount($this->request->get['id']);

		$this->session->data['redirect'] = $this->url->link('customerpartner/profile&id='.$this->request->get['id'],'','SSL');
		$data['login'] = $this->url->link('account/login','','SSL');
		$data['seller_id'] = $this->request->get['id'];
		$data['isLogged'] = $this->customer->isLogged();

		$data['marketplace_customercontactseller'] = $this->config->get('marketplace_customercontactseller');
        
        $data['give_review'] = true;
		if ($this->config->get('marketplace_review_only_order')) {
			
			if ($this->customer->isLogged() && ($this->request->get['id'] != $this->customer->getId())) {
				$check_customer = $this->model_customerpartner_master->checkCustomerBought($this->request->get['id']);

				if (!$check_customer && isset($data['public_seller_profile']['review'])) {
                	$data['give_review'] = false;
                }
			}else{
                
                if (isset($data['public_seller_profile']['review'])) {
                	$data['give_review'] = false;
                }
			}
		}

        $data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/customerpartner/profile.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/customerpartner/profile.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/customerpartner/profile.tpl', $data));
		}

	}

	/**
	 * [loadLocation To load the location of store entered by seller on the google map]
	 * @return [map|string] [It will return google map with the location if location found else no location entered by seller string]
	 */
	public function loadLocation(){
		if($this->request->get['location']){
			$location = '<iframe id="seller-location" width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q='.$this->request->get['location'].'&amp;output=embed"></iframe>';
			$this->response->setOutput($location);
		}else{
			$this->load->language('customerpartner/profile');
			$this->response->setOutput($this->language->get('text_no_location_added'));
		}
	}

	/**
	 * [feedback to load all the feedbacks about the seller]
	 * @return [html] [it will return html file]
	 */
	public function feedback(){

		if(!isset($this->request->get['id']))
			$this->request->get['id'] = 0;

		$page = 1;

		$this->language->load('customerpartner/feedback');
	
		$data['text_write'] = $this->language->get('text_write');
		$data['text_note'] = $this->language->get('text_note');
		$data['entry_bad'] = $this->language->get('entry_bad');
		$data['entry_good'] = $this->language->get('entry_good');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_nickname'] = $this->language->get('text_nickname');
		$data['text_review'] = $this->language->get('text_review');

		$data['text_no_feedbacks'] = $this->language->get('text_no_reivew');		
		$data['text_price'] = $this->language->get('text_price');
		$data['text_value'] = $this->language->get('text_value');
		$data['text_quality'] = $this->language->get('text_quality');		
		$data['button_continue'] = $this->language->get('button_continue');
		$data['text_login'] = $this->language->get('text_login');
		
		$data['action'] = $this->url->link('customerpartner/profile/feedback','&id='.$this->request->get['id'],'SSL');

		$this->load->model('customerpartner/master');

		$feedbacks = $this->model_customerpartner_master->getFeedbackList($this->request->get['id']);

		echo '<script>
		 $(document).ready(function () {
		 createCookie("time_diff");
		 });

		 function createCookie(name) {
			var rightNow = new Date();
			var jan1 = new Date(rightNow.getFullYear(), 0, 1, 0, 0, 0, 0);
			var temp = jan1.toGMTString();
			var jan2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
			var std_time_offset = (jan1 - jan2) / (1000 * 60 * 60);
		  	document.cookie = escape(name) + "=" + std_time_offset + "; path=/";
		 }
		</script>';

		if (isset($_COOKIE['time_diff'])) {			
			$time_diff = $_COOKIE['time_diff'] * 3600;
		}

		$data['feedbacks'] = array();

		if ($feedbacks) {
			foreach ($feedbacks as $key => $feedback) {
				$date = strtotime($feedback['createdate']);
				if (isset($time_diff) && $time_diff) {			
					$date = $date + $time_diff;
				}
				$data['feedbacks'][] = array(					
		            'id' => $feedback['id'],
		            'customer_id' => $feedback['customer_id'],
		            'seller_id' => $feedback['seller_id'],
		            'feedprice' => $feedback['feedprice'],
		            'feedvalue' => $feedback['feedvalue'],
		            'feedquality' => $feedback['feedquality'],
		            'nickname' => $feedback['nickname'],
		            'summary' => $feedback['summary'],		            
		            'review' => $feedback['review'],
		            'createdate' => date('Y/m/d H:i:s', $date)
				);	
			}
		}

		$feedback_total = $this->model_customerpartner_master->getTotalFeedback($this->request->get['id']);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($feedback_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($feedback_total - 5)) ? $feedback_total : ((($page - 1) * 5) + 5), $feedback_total, ceil($feedback_total / 5));

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/customerpartner/feedback.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/customerpartner/feedback.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/customerpartner/feedback.tpl', $data));
		}
	}

	/**
	* [productFeedback to get feedback on seller's product]
	* @return [html] [It will return html file]
	*/
	public function productFeedback() {

		if(!isset($this->request->get['id']))
			$this->request->get['id'] = 0;

		$page = 1;

		$this->language->load('customerpartner/feedback');
	
		$data['text_write'] = $this->language->get('text_write');
		$data['text_note'] = $this->language->get('text_note');
		$data['entry_bad'] = $this->language->get('entry_bad');
		$data['entry_good'] = $this->language->get('entry_good');
		$data['entry_captcha'] = $this->language->get('entry_captcha');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_nickname'] = $this->language->get('text_nickname');
		$data['text_review'] = $this->language->get('text_review');

		$data['text_no_reviews'] = $this->language->get('text_no_reivew');		
		$data['text_price'] = $this->language->get('text_price');
		$data['text_value'] = $this->language->get('text_value');
		$data['text_quality'] = $this->language->get('text_quality');		
		$data['button_continue'] = $this->language->get('button_continue');
		$data['text_login'] = $this->language->get('text_login');
		
		$this->load->model('customerpartner/master');

		$reviews = $this->model_customerpartner_master->getProductFeedbackList($this->request->get['id']);

		$data['reviews'] = array();
		if($reviews) {
			foreach ($reviews as $key => $review) {
				$d = date_create($review['date_added']);
				$data['reviews'][] = array(
					'author' => $review['author'],
					'name' => $review['name'],
					'text' => $review['text'],
					'rating' => $review['rating'],
					'date_added' => date_format($d, 'jS F Y g:ia '),
				);
			}
		}

		$product_feedback_total = $this->model_customerpartner_master->getTotalProductFeedbackList($this->request->get['id']);

		$data['pagination'] = '';

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_feedback_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($product_feedback_total - 5)) ? $product_feedback_total : ((($page - 1) * 5) + 5), $product_feedback_total, ceil($product_feedback_total / 5));

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/customerpartner/review.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/customerpartner/review.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/customerpartner/review.tpl', $data));
		}

	}

	/**
	 * [writeFeedback to store customers feedbacks]
	 * @return [json] [string containing successful/unsuccessful message]
	 */
	public function writeFeedback() {

		$this->load->language('customerpartner/feedback');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}

			if (empty($this->request->post['quality_rating']) || $this->request->post['quality_rating'] < 0 || $this->request->post['quality_rating'] > 5) {
				$json['error'] = $this->language->get('error_quality_rating');
			}

			if (empty($this->request->post['price_rating']) || $this->request->post['price_rating'] < 0 || $this->request->post['price_rating'] > 5) {
				$json['error'] = $this->language->get('error_price_rating');
			}

			if (empty($this->request->post['value_rating']) || $this->request->post['value_rating'] < 0 || $this->request->post['value_rating'] > 5) {
				$json['error'] = $this->language->get('error_value_rating');
			}

			if (!isset($json['error'])) {			
				$this->load->model('customerpartner/master');
				$this->model_customerpartner_master->saveFeedback($this->request->post,$this->request->get['id']);
				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');

		$this->response->setOutput(json_encode($json));
	}

	/**
	* [collection to get seller's product's collection]
	* @return [html] [It will return html file containing seller's products]
	*/
	public function collection() {

		if(!isset($this->request->get['id']))
			$this->request->get['id'] = 0;
		
		$this->load->model('tool/image');

		$this->load->model('catalog/category');

		$this->load->model('account/customerpartner');

		$this->load->model('customerpartner/master');

		$this->language->load('customerpartner/collection');

		$this->language->load('product/category');

		$data['text_refine'] = $this->language->get('text_refine');
		$data['text_empty'] = $this->language->get('text_no_products');
		$data['text_quantity'] = $this->language->get('text_quantity');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_model'] = $this->language->get('text_model');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_points'] = $this->language->get('text_points');
		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$data['text_sort'] = $this->language->get('text_sort');
		$data['text_limit'] = $this->language->get('text_limit');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_list'] = $this->language->get('button_list');
		$data['button_grid'] = $this->language->get('button_grid');

		$partner = $this->model_customerpartner_master->getProfile($this->request->get['id']);

		if(!$partner)
			$this->response->redirect($this->url->link('error/not_found'));		

		$data['compare'] = $this->url->link('product/compare' , '' . 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$url = "&id=".$this->request->get['id'];	


		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}	
							
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = 10;
		}
	
		$filter_data = array(
			'customer_id'		 => $this->request->get['id'],
			'filter_category_id' => 0,
			'sort'               => $sort,
			'order'              => $order,
			'start'              => ($page - 1) * $limit,
			'limit'              => $limit,
			'filter_store' 		 => $this->config->get('config_store_id'),
			'filter_status'		 => 1
		);

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			$children_data = array();

			$children = $this->model_catalog_category->getCategories($category['category_id']);

			foreach ($children as $child) {

				$filter_data ['filter_category_id']  = $child['category_id'];

				$products_in_category = $this->model_account_customerpartner->getTotalProductsSeller($filter_data);

				if($products_in_category)
					$children_data[] = array(
						'category_id' => $child['category_id'],
						'name'        => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $products_in_category . ')' : ''),
						'href'        => $this->url->link('customerpartner/profile/collection', 'path=' . $category['category_id'] . '_' . $child['category_id'].$url)
					);
			}

			$filter_data ['filter_category_id']  = $category['category_id'];

			$products_in_category = $this->model_account_customerpartner->getTotalProductsSeller($filter_data);

			if($products_in_category){			
				$data['categories'][] = array(
					'category_id' => $category['category_id'],
					'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $products_in_category . ')' : ''),
					'children'    => $children_data,
					'href'        => $this->url->link('customerpartner/profile/collection', 'path=' . $category['category_id'].$url)
				);
			}elseif ($children_data) {					
				$data['categories'][] = array(
					'category_id' => $category['category_id'],
					'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . count($children_data) . ')' : ''),
					'children'    => $children_data,
					'href'        => $this->url->link('customerpartner/profile/collection', 'path=' . $category['category_id'].$url)
				);		
			}
		}		


		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $category_id = $parts[0];
		} else {
			$data['category_id'] = $category_id = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $category_id = $parts[1];
		} else {
			$data['child_id'] = 0;
		}
			
		$filter_data ['filter_category_id']  = $category_id;

		if (isset($this->request->get['path'])) {
			$url .= '&path=' . $this->request->get['path'];
		}

		$results = $this->model_account_customerpartner->getProductsSeller($filter_data);

		$product_total = $this->model_account_customerpartner->getTotalProductsSeller($filter_data);

		$data['products'] = array();

		foreach ($results as $result) {

			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
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

			$data['products'][] = array(
				'product_id'  => $result['product_id'],
				'thumb'       => $image,
				'name'        => $result['name'],
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
				'price'       => $price,
				'special'     => $special,
				'tax'         => $tax,
				'rating'      => $result['rating'],
				'href'        => $this->url->link('product/product', '&product_id=' . $result['product_id'] )
			);
		}				
								
		$data['sorts'] = array();
		
		$data['sorts'][] = array(
			'text'  => $this->language->get('text_default'),
			'value' => 'p.sort_order-ASC',
			'href'  => $this->url->link('customerpartner/profile/collection', '&sort=p.sort_order&order=ASC' . $url)
		);
		
		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_asc'),
			'value' => 'pd.name-ASC',
			'href'  => $this->url->link('customerpartner/profile/collection','&sort=pd.name&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_desc'),
			'value' => 'pd.name-DESC',
			'href'  => $this->url->link('customerpartner/profile/collection', '&sort=pd.name&order=DESC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_asc'),
			'value' => 'p.price-ASC',
			'href'  => $this->url->link('customerpartner/profile/collection','&sort=p.price&order=ASC' . $url)
		); 

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_desc'),
			'value' => 'p.price-DESC',
			'href'  => $this->url->link('customerpartner/profile/collection', '&sort=p.price&order=DESC' . $url)
		); 
		
		if ($this->config->get('config_review_status')) {
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href'  => $this->url->link('customerpartner/profile/collection', '&sort=rating&order=DESC' . $url)
			); 
			
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href'  => $this->url->link('customerpartner/profile/collection', '&sort=rating&order=ASC' . $url)
			);
		}
		
		$data['sorts'][] = array(
			'text'  => $this->language->get('text_model_asc'),
			'value' => 'p.model-ASC',
			'href'  => $this->url->link('customerpartner/profile/collection','&sort=p.model&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_model_desc'),
			'value' => 'p.model-DESC',
			'href'  => $this->url->link('customerpartner/profile/collection','&sort=p.model&order=DESC' . $url)
		);

		$url = "id=".$this->request->get['id'];

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['path'])) {
			$url .= '&path=' . $this->request->get['path'];
		}

		$data['limits'] = array();

		$limits = array_unique(array(10, 25, 50, 75, 100));

		sort($limits);

		foreach($limits as $value) {
			$data['limits'][] = array(
				'text'  => $value,
				'value' => $value,
				'href'  => $this->url->link('customerpartner/profile/collection', $url . '&limit=' . $value)
			);
		}
					
		$url = "id=".$this->request->get['id'];

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}	

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		if (isset($this->request->get['path'])) {
			$url .= '&path=' . $this->request->get['path'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('customerpartner/profile/collection' , $url . '&page={page}');

		$data['pagination'] = $pagination->render();

		$this->document->addLink($this->url->link('customerpartner/profile/collection', $url . '&page=' . $pagination->page), 'canonical');

		if ($pagination->limit && ceil($pagination->total / $pagination->limit) > $pagination->page) {
			$this->document->addLink($this->url->link('customerpartner/profile/collection', $url . '&page=' . ($pagination->page + 1)), 'next');
		}

		if ($pagination->page > 1) {
			$this->document->addLink($this->url->link('customerpartner/profile/collection', $url . '&page=' . ($pagination->page - 1)), 'prev');
		}
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/customerpartner/collection.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/customerpartner/collection.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/customerpartner/collection.tpl', $data));
		}
	}

}
?>
