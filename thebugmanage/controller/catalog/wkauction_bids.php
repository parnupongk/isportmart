<?php
################################################################################################
# Auction Bids Opencart 2.1.x.x From Webkul  http://webkul.com 	#
################################################################################################
class ControllerCatalogWkauctionbids extends Controller {
	
	private $error = array(); 
	
	public function index() {
		$this->language->load('catalog/wkauction_bids');
    	
		$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('catalog/wkauction_bids');

		$this->getList();
  	}

	protected function getList() {	
		$this->language->load('catalog/wkauction_bids');
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/wkauction_bids', 'token=' . $this->session->data['token'] , 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$data['delete'] = $this->url->link('catalog/wkauction_bids/delete', 'token=' . $this->session->data['token'] , 'SSL');
		
		if (isset($this->request->get['filter_pname'])) {
			$filter_pname = $this->request->get['filter_pname'];
		} else {
			$filter_pname = null;
		}
		if (isset($this->request->get['filter_starttime'])) {
			$filter_starttime = $this->request->get['filter_starttime'];
		} else {
			$filter_starttime = null;
		}
		if (isset($this->request->get['filter_endtime'])) {
			$filter_endtime = $this->request->get['filter_endtime'];
		} else {
			$filter_endtime = null;
		}
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.name';
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


		$url = '';

		if (isset($this->request->get['filter_pname'])) {
			$url .= '&filter_pname=' . urlencode(html_entity_decode($this->request->get['filter_pname'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_starttime'])) {
			$url .= '&filter_starttime=' . $this->request->get['filter_starttime'];
		}

		if (isset($this->request->get['filter_endtime'])) {
			$url .= '&filter_endtime=' . $this->request->get['filter_endtime'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$filter_data = array(
			'filter_pname'	  => $filter_pname,
			'filter_starttime'	  => $filter_starttime,
			'filter_endtime'	  => $filter_endtime,	
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);			
		
		$data['bids'] = array();
		$data['winners'] = array();
		$data['productBids'] = array();
		$data1 = array();
		
		$product_total = $this->model_catalog_wkauction_bids->getTotalBids($filter_data);
		$results = $this->model_catalog_wkauction_bids->getBids($filter_data);			
		$data['heading_title'] = $this->language->get('heading_title');		
		$data['entry_name'] = $this->language->get('entry_name');		
		$data['entry_prod'] = $this->language->get('entry_prod');
		$data['entry_start_time'] = $this->language->get('entry_start_time');
		$data['entry_end_time'] = $this->language->get('entry_end_time');		
		$data['entry_amt'] = $this->language->get('entry_amt');	
		$data['entry_cus'] = $this->language->get('entry_cus');	
		$data['entry_dat'] = $this->language->get('entry_dat');		
		$data['entry_start'] = $this->language->get('entry_start');	
		$data['entry_end'] = $this->language->get('entry_end');		
		$data['button_insert'] = $this->language->get('button_insert');		
		$data['button_delete'] = $this->language->get('button_delete');		
		$data['entry_winner'] = $this->language->get('entry_winner');
		$data['entry_sold'] = $this->language->get('entry_sold');
		$data['entry_cur_bid'] = $this->language->get('entry_cur_bid');
		$data['entry_history'] = $this->language->get('entry_history');
		$data['text_view'] = $this->language->get('text_view');
		$data['text_win_bid'] = $this->language->get('text_win_bid');
		$data['text_total_bid'] = $this->language->get('text_total_bid');
		$data['text_bidder'] = $this->language->get('text_bidder');
		$data['text_bid'] = $this->language->get('text_bid');

		//Automatic Bidding
	    $data['text_auto_bid'] = $this->language->get('text_auto_bid');
	    $data['text_total_auto_bid'] = $this->language->get('text_total_auto_bid');
	    $data['wkproduct_auction_automatic_auction_status'] = $this->config->get('wkproduct_auction_automatic_auction_status');
        
        //Automatic Bidding
		foreach ($results as $result) {
		$productBids = $this->model_catalog_wkauction_bids->getBidsById($result['product_id']);
		foreach($productBids as $productBid){

			if (isset($productBid['auto_bid'])) {
			    
			    $data['productBids'][] = array(
				  'selected'=>False,
				  'id' => $productBid['id'],
				  'product_id' => $result['product_id'],
				  'customer_name' => $productBid['firstname']." ".$productBid['lastname'],
				  'start_date' => $productBid['start_date'],
				  'end_date' => $productBid['end_date'],
				  'bid' => $productBid['user_bid'],
				  'auto_bid' => $productBid['auto_bid'],
			  );

			}else{

				$data['productBids'][] = array(
				  'selected'=>False,
				  'id' => $productBid['id'],
				  'product_id' => $result['product_id'],
				  'customer_name' => $productBid['firstname']." ".$productBid['lastname'],
				  'start_date' => $productBid['start_date'],
				  'end_date' => $productBid['end_date'],
				  'bid' => $productBid['user_bid'],
			  );

			}
		}
		$totalBid = $this->model_catalog_wkauction_bids->getTotalBid($result['product_id']);
		$total_auto_bid =  $this->model_catalog_wkauction_bids->getTotalAutoBid($result['product_id']);

		if ($total_auto_bid) {

			$data['bids'][] = array(
				'selected'=>False,
				'id' => $result['id'],
				'product_id' => $result['product_id'],
				'product' => $result['name'],
				'auction_start' => $result['start_date'],
				'auction_end'  => $result['end_date'],
				'totalBid'  => $totalBid,
				'total_auto_bid' => $total_auto_bid,
			);
          	
		}else{
            
            $data['bids'][] = array(
				'selected'=>False,
				'id' => $result['id'],
				'product_id' => $result['product_id'],
				'product' => $result['name'],
				'auction_start' => $result['start_date'],
				'auction_end'  => $result['end_date'],
				'totalBid'  => $totalBid,
			);
          	
		}
      		
		}
	        
	 //    foreach ($results as $result) {
		// $productBids = $this->model_catalog_wkauction_bids->getBidsById($result['product_id']);
		// foreach($productBids as $productBid){
		//   $data['productBids'][] = array(
		// 	  'selected'=>False,
		// 	  'id' => $productBid['id'],
		// 	  'product_id' => $result['product_id'],
		// 	  'customer_name' => $productBid['firstname']." ".$productBid['lastname'],
		// 	  'start_date' => $productBid['start_date'],
		// 	  'end_date' => $productBid['end_date'],
		// 	  'bid' => $productBid['user_bid'],
		//   );
		// }
		// $totalBid = $this->model_catalog_wkauction_bids->getTotalBid($result['product_id']);
  //     		$data['bids'][] = array(
		// 		'selected'=>False,
		// 		'id' => $result['id'],
		// 		'product_id' => $result['product_id'],
		// 		'product' => $result['name'],
		// 		'auction_start' => $result['start_date'],
		// 		'auction_end'  => $result['end_date'],
		// 		'totalBid'  => $totalBid,
		// 	);
          	
		// }
		$winners = $this->model_catalog_wkauction_bids->getWinners();
		foreach($winners as $winner){
		      $data['winners'][] = array(
			      'selected'=>False,
			      'id' => $winner['id'],
			      'customer_name' => $winner['firstname']." ".$winner['lastname'],
			      'product_name' => $winner['name'],
			      'bid' => $winner['user_bid'],
			      'start_date' => $winner['start_date'],
			      'end_date' => $winner['end_date'],
		      );
		}
 		$data['token'] = $this->session->data['token'];
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_pname'])) {
			$url .= '&filter_pname=' . urlencode(html_entity_decode($this->request->get['filter_pname'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_starttime'])) {
			$url .= '&filter_starttime=' . $this->request->get['filter_starttime'];
		}

		if (isset($this->request->get['filter_endtime'])) {
			$url .= '&filter_endtime=' . $this->request->get['filter_endtime'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['sort_name'] = $this->url->link('catalog/wkauction_bids', 'token=' . $this->session->data['token'] . '&sort=p.name' . $url, 'SSL');
		$data['sort_starttime'] = $this->url->link('catalog/wkauction_bids', 'token=' . $this->session->data['token'] . '&sort=a.start_date' . $url, 'SSL');
		$data['sort_endtime'] = $this->url->link('catalog/wkauction_bids', 'token=' . $this->session->data['token'] . '&sort=a.end_date' . $url, 'SSL');

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/wkauction_bids', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

		$data['filter_pname'] = $filter_pname;
		$data['filter_starttime'] = $filter_starttime;
		$data['filter_endtime'] = $filter_endtime;		
		$data['sort'] = $sort;
		$data['order'] = $order;
	
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');	
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/wkauction_bidslist.tpl', $data));	
  	}	
		
  	
  	
  	public function delete() {
    	$this->language->load('catalog/wkauction_bids');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/wkauction_bids');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_catalog_wkauction_bids->deleteBid($id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url='';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('catalog/wkauction_bids', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
  
	protected function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'catalog/wkauction_bids')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
  	
}
?>