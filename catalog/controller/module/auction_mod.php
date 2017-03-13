<?php
class ControllerModuleAuctionMod extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->language('module/auction_mod');
		$this->load->model('catalog/product');

		$data['heading_title'] = $this->language->get('heading_title');

		
		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');

		$this->document->addScript('catalog/view/javascript/wkproduct_auction/jquery.lwtCountdown-1.0.js'); 
		$this->document->addStyle('catalog/view/theme/default/stylesheet/wkauction/main.css');
		$this->document->addScript('catalog/view/javascript/wkproduct_auction/jquery.countdown.js');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/wkauction/wkallauctions.css'); 
		$this->document->addScript('catalog/view/javascript/wkproduct_auction/jquery.quick.pagination.min.js');

		$this->load->model('module/auction_mod');
		$this->load->model('tool/image');

		date_default_timezone_set($this->config->get('wkproduct_auction_timezone_set'));

		$data['text_bidnow'] = $this->language->get('text_bidnow');
		$data['text_minbid'] = $this->language->get('text_minbid');
		$data['text_maxbid'] = $this->language->get('text_maxbid');
		
		$new_arr = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		if(count($setting['product']) >= $setting['limit']){
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);					
		}else{
			$new_limit = $setting['limit'] - count($setting['product']);

			$remain_products = $this->model_module_auction_mod->remainProducts($new_limit,$setting['product']);
			
			foreach ($remain_products as $key => $value) {
				$new_arr[] = $value['product_id'];
			}			
			
			$products = array_merge($setting['product'] ,$new_arr);
		}
		
		if($this->config->get('wkproduct_auction_status')){
			foreach ($products as $product_id) {
				$product_info = $this->model_module_auction_mod->getAuctionProduct($product_id);
				
				if ($product_info) {

					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}
					
				

					$data['auction_products'][] = array(
						'product_id'  	=> $product_info['product_id'],
						'thumb'       	=> $image,
						'name'        	=> $product_info['name'],					
						'price'       	=> $price,
						'aumin'			=>$this->currency->format($product_info['min']),
						'aumax'			=>$this->currency->format($product_info['max']),
						'austart'		=>$product_info['start_date'],
						'auend'			=>$product_info['end_date'],					
						'href'        	=> $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
						'pricebid'		=> $this->model_catalog_product->getProductPriceBids($product_info['product_id'])
					);
					
				}
			}
		}

		$data['module'] = $module++;				
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/auction_mod.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/auction_mod.tpl', $data);
			} else {
				return $this->load->view('default/template/module/auction_mod.tpl', $data);
			}
		
	}
}