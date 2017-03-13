<?php
class ControllerCatalogWkallauctions extends Controller {
	private $error = array();

	public function index() {

		$this->language->load('catalog/wkallauctions');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/customer');
		$this->load->model('tool/image');

		$data['text_currentAuct'] = $this->language->get('text_currentAuct');
  		$data['text_recentWinner'] = $this->language->get('text_recentWinner');
  		$data['text_allProduct'] = $this->language->get('text_allProduct');
  		$data['text_sTime'] = $this->language->get('text_sTime');
  		$data['text_eTime'] = $this->language->get('text_eTime');
  		$data['text_minBid'] = $this->language->get('text_minBid');
  		$data['text_maxBid'] = $this->language->get('text_maxBid');
  		$data['text_bidNow'] = $this->language->get('text_bidNow');
  		
  		$data['text_winnerBid'] = $this->language->get('text_winnerBid');
  		$data['text_winnerName'] = $this->language->get('text_winnerName');

      	$data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home')        	
      	); 
      	$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_wkauction'),
			'href' => $this->url->link('catalog/wkallauctions', '', 'SSL')
		);
	    
		$this->document->addScript('catalog/view/javascript/wkproduct_auction/jquery.lwtCountdown-1.0.js'); 
		$this->document->addStyle('catalog/view/theme/default/stylesheet/wkauction/main.css');
		$this->document->addScript('catalog/view/javascript/wkproduct_auction/jquery.countdown.js');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/wkauction/wkallauctions.css'); 
		$this->document->addScript('catalog/view/javascript/wkproduct_auction/jquery.quick.pagination.min.js');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['entry_empty'] = $this->language->get('entry_empty');
		
		date_default_timezone_set($this->config->get('wkproduct_auction_timezone_set'));
		$this->load->model('catalog/wkallauctions');

		$data['allauctions']=array();
		$data['recentWinners']=array();
		
		if (isset($this->request->get['category'])) {
			$category = $this->request->get['category'];
		} else {
			$category = null;
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$filterValues = array(
		    'start' => ($page - 1) * 12,
		    'limit' => 12,
		    'category' => $category,
		);
		
		$wkauctions=$this->model_catalog_wkallauctions->getAuctions($filterValues);
		$recentWinners = $this->model_catalog_wkallauctions->getRecentAuctions();
		$product_total = $this->model_catalog_wkallauctions->getAuctionsCount($filterValues);
		$this->load->model("catalog/category");
		$data['categories'] = $this->model_catalog_category->getCategories();
		foreach($wkauctions as $wkau)
		{
			$data['allauctions'][]=array(
					'product_id'=>$wkau['product_id'],
					'aumin'=>$this->currency->format($wkau['min']),
					'aumax'=>$this->currency->format($wkau['max']),
					'austart'=>$wkau['start_date'],
					'auend'=>$wkau['end_date'],
					'name'=>$wkau['name'],
					'image'=>$this->model_tool_image->resize($wkau['image'],220,200),
					'href'=> $this->url->link('product/product', 'product_id=' . $wkau['product_id'])
				);
		}		
		foreach($recentWinners as $winner){
			$data['recentWinners'][] = array(
				'winningBid' => $this->currency->format($winner['user_bid']),
				'winnerName' => $winner['firstname']." ".$winner['lastname'],
				'productImage' => $this->model_tool_image->resize($winner['image'], 225, 200),
				'productName' => $winner['name'],
			);
		}
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_product_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/wkallauctions', 'page={page}', 'SSL');
		
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_product_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_product_limit')) > ($product_total - $this->config->get('config_product_limit'))) ? $product_total : ((($page - 1) * $this->config->get('config_product_limit')) + $this->config->get('config_product_limit')), $product_total, ceil($product_total / $this->config->get('config_product_limit')));

	
		$data['footer']	=	$this->load->controller('common/footer');
		$data['header']	=	$this->load->controller('common/header');
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/catalog/wkallauctions.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/catalog/wkallauctions.tpl' , $data));			
		} else {
			$this->response->setOutput($this->load->view('default/template/catalog/wkallauctions.tpl' , $data));
		}
	}
}
?>