<?php
class ControllerCustomerpartnerSell extends Controller {

	private $error = array();
	private $data = array();

	public function index() {

		$this->language->load('customerpartner/sell');
		
		$this->document->setTitle($this->language->get('heading_title'));		
		
      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),     	
        	'separator' => false
      	); 		

		$this->document->addStyle('catalog/view/theme/default/stylesheet/MP/sell.css');

		$buttontitle = $this->config->get('marketplace_sellbuttontitle');
		$sellerHeader = $this->config->get('marketplace_sellheader');

		$this->data['sell_title'] = $buttontitle[$this->config->get('config_language_id')];
		$this->data['sell_header'] = $sellerHeader[$this->config->get('config_language_id')];
		$this->data['showpartners'] = $this->config->get('marketplace_showpartners');
		$this->data['showproducts'] = $this->config->get('marketplace_showproducts');

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_long_time_seller'] =	$this->language->get('text_long_time_seller');
		$this->data['text_latest_product']	=	$this->language->get('text_latest_product');

		$this->data['text_tax']	=	$this->language->get('text_tax');
		$this->data['text_from']	=	$this->language->get('text_from');
		$this->data['text_seller']	=	$this->language->get('text_seller');
		$this->data['text_total_products']	=	$this->language->get('text_total_products');

		$this->data['button_cart']	=	$this->language->get('button_cart');
		$this->data['button_wishlist']	=	$this->language->get('button_wishlist');
		$this->data['button_compare']	=	$this->language->get('button_compare');

		$this->data['tabs'] = array();
		
		$marketplace_tab = $this->config->get('marketplace_tab');
		
		if(isset($marketplace_tab['heading']) AND $marketplace_tab['heading']){
			ksort($marketplace_tab['heading']);
			ksort($marketplace_tab['description']);
			foreach ($marketplace_tab['heading'] as $key => $value) {
				$text = $marketplace_tab['description'][$key][$this->config->get('config_language_id')];
			    $text = trim(html_entity_decode($text));
				$this->data['tabs'][] = array(
					'id' => $key,
					'hrefValue' => $value[$this->config->get('config_language_id')],
					'description' => $text,
				);	
			}
		}

		$this->load->model('tool/image');
		$this->load->model('customerpartner/master');

		$partners = $this->model_customerpartner_master->getOldPartner();

		$this->data['partners'] = array();

		foreach ($partners as $key => $result) {

			if ($result['avatar']) {
				$image = $this->model_tool_image->resize($result['avatar'], 100, 100);
			} else if($result['avatar'] == 'removed') {
				$image = '';
			} else if($this->config->get('marketplace_default_image_name')) {
				$image = $this->model_tool_image->resize($this->config->get('marketplace_default_image_name'), 100, 100);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 100, 100);
			}

			$this->data['partners'][] = array(
				'customer_id' 		=> $result['customer_id'],
				'name' 		  		=> $result['firstname'].' '.$result['lastname'],
				'companyname' 		=> $result['companyname'],
				'backgroundcolor' 		=> $result['backgroundcolor'],
				'country'  	  		=> $result['country'],
				'sellerHref'  		=> $this->url->link('customerpartner/profile', 'id=' . $result['customer_id']),
				'thumb'       		=> $image,
				'total_products'    => $this->model_customerpartner_master->getPartnerCollectionCount($result['customer_id']),
			);

		}
		
		//products
		$latest = $this->model_customerpartner_master->getLatest();
		$this->data['latest'] = array();
		
		foreach($latest as $key => $result){

			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('no_image.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			}

			if ($result['avatar']) {
				$avatar = $this->model_tool_image->resize($result['avatar'], 70, 70);
			} else if($result['avatar'] == 'removed') {
				$avatar = '';
			} else if($this->config->get('marketplace_default_image_name')) {
				$avatar = $this->model_tool_image->resize($this->config->get('marketplace_default_image_name'), 50, 50);
			} else {
				$avatar = $this->model_tool_image->resize('no_image.png', 50, 50);
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

			$this->data['latest'][] = array(
				'product_id'  => $result['product_id'],
				'seller_name' => $result['seller_name'],
				'country'  	  => $result['country'],
				'avatar'  	  => $avatar,
				'backgroundcolor'  	  => $result['backgroundcolor'],
				'sellerHref'  => $this->url->link('customerpartner/profile', 'id=' . $result['customer_id']),
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

		if ($this->config->get('marketplace_seller_info_hide')) {
			
			$this->data['showpartners'] = false;
			$this->data['showpartnerdetails'] = false;
		}else{
			$this->data['showpartnerdetails'] = true;
		}

		$this->data['footer'] = $this->load->controller('common/footer');
		$this->data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/customerpartner/sell.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/customerpartner/sell.tpl', $this->data));
		} else {
			$this->response->setOutput($this->load->view('default/template/customerpartner/sell.tpl', $this->data));
		}

	}

	public function wkmpregistation(){

		$this->load->model('customerpartner/master');

		$json = array();

		if(isset($this->request->post['shop'])){					
			$data = urldecode(html_entity_decode($this->request->post['shop'], ENT_QUOTES, 'UTF-8'));				
			if($this->model_customerpartner_master->getShopData($data)){
				$json['success'] = true;
			}else{							
				$json['error'] = true;		    	
		    }			 
		}

		$this->response->setOutput(json_encode($json));		
	}
}
?>
