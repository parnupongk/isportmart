<?php
class ControllerAccountCustomerpartnerWkmpaddauction extends Controller {
	private $error = array();
	private $data = array();

	public function index() {
	
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/customerpartner');
		$this->data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();

		if(!$this->data['chkIsPartner'])
			$this->response->redirect($this->url->link('account/account'));

		$this->language->load('account/customerpartner/wk_mpaddauction');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/MP/sell.css');						
		
		$this->data['heading_title']=$this->language->get('heading_title');
		$this->data['button_back']=$this->language->get('button_back');
		$this->data['button_continue']=$this->language->get('button_continue');
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/customer');
		
		if(isset($this->request->get['dauid'])){
			$this->load->model('account/wk_mpaddauction');
			$this->model_account_wk_mpaddauction->deleteAuction($this->request->get['dauid']);
			$this->response->redirect($this->url->link('account/customerpartner/wk_mpaddauction', '', 'SSL'));
		}
		date_default_timezone_set($this->config->get('wkproduct_auction_timezone_set'));

		$post_data = array(
        'auction_name',
        'product_name',
        'aumin',
        'aumax',
        'product_quantity_limit',
        );
            
        foreach ($post_data as $post) {
            if (isset($this->request->post[$post])) {
                $this->data[$post] = $this->request->post[$post];
            } else {
                $this->data[$post] = '';
            }
        }

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			

			$this->load->model('account/wk_mpaddauction');
			$date = date('Y-m-d H:i:s');
				$car=$this->currency->getValue($_SESSION['default']['currency']);
   				$this->request->post['aumin']=$this->request->post['aumin']/$car;
   				$this->request->post['aumax']=$this->request->post['aumax']/$car;
   				
   				$this->model_account_wk_mpaddauction->addAuction($this->request->post);
				if(isset($this->request->post['update'])){
				      $this->session->data['success'] = $this->language->get('text_success_update');
				}else{
				      $this->session->data['success'] = $this->language->get('text_success');
				}
			
				$this->response->redirect($this->url->link('account/customerpartner/wk_mpaddauction', '', 'SSL'));
	    }
		
      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),     	
        	'separator' => false
      	); 
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account'),     	
        	'separator' => $this->language->get('text_separator')
      	); 
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_addproduct'),
			'href'      => $this->url->link('account/customerpartner/wk_mpaddauction', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);
		$this->data['auproduct_list']=array();
		
		$this->data['text_addproduct']=$this->language->get('text_addproduct');
		$this->data['entry_productin_auction']=$this->language->get('entry_productin_auction');
		$this->data['entry_auproduct']=$this->language->get('entry_auproduct');
		$this->data['entry_aumin']=$this->language->get('entry_aumin');
		$this->data['entry_aumax']=$this->language->get('entry_aumax');
		$this->data['entry_austart']=$this->language->get('entry_austart');
		$this->data['entry_auend']=$this->language->get('entry_auend');
		$this->data['entry_delete']=$this->language->get('entry_delete');
		$this->data['entry_edit']=$this->language->get('entry_edit');
		$this->data['entry_update']=$this->language->get('entry_update');

		// Automatic bidding
		$this->data['wkproduct_auction_automatic_auction_status'] = $this->config->get('wkproduct_auction_automatic_auction_status');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		if (isset($this->error['price'])) {
			$this->data['error_price'] = $this->error['price'];
		} else {
			$this->data['error_price'] = '';
		}	

		if (isset($this->error['date'])) {
			$this->data['error_date'] = $this->error['date'];
		} else {
			$this->data['error_date'] = '';
		}	

		if (isset($this->error['error_voucher'])) {
			$this->data['error_voucher'] = $this->error['error_voucher'];
		} else {
			$this->data['error_voucher'] = '';
		}	

		
		

		$this->load->model('account/wk_mpaddauction');
        $aures=$this->model_account_wk_mpaddauction->getAuctions($this->customer->getId());
        //$this->data['status'] = $this->model_account_wk_mpaddauction->getEmailStatus($this->customer->getId());
	
	    foreach($aures as $au){

	    	$this->data['auproduct_list'][]=array(
	    			'auction_id'=> $au['id'],
	    			'product_id'=> $au['product_id'],
	    			'auction_name' => $au['name'],
	    			'product_name'=> $au['product_name'],
	    			'min'=> $this->currency->format($au['min']),
	    			'max'=> $this->currency->format($au['max']),
	    			'start'=> $au['start_date'],
	    			'end'=> $au['end_date'],
	    			'quantity_limit' => $au['quantity_limit'],
	    			'voucher_exp' => $au['voucher_time_limit']
	    		);
		    if(isset($this->request->get['product_id'])){
				if($au['product_id']==$this->request->get['product_id']){

					$this->data['auction_name'] = $au['name'];	
				  	$this->data['productName'] = $au['product_name'];
				  	$this->data['min'] = $au['min'];
				  	$this->data['max'] = $au['max'];
				  	$this->data['start'] = $au['start_date'];
				 	$this->data['end'] = $au['end_date'];
				  	$this->data['id'] = $au['id'];
				  	$this->data['product_id'] = $au['product_id'];
				  	$this->data['quantity_limit'] = $au['quantity_limit'];
			    	$this->data['voucher_time_limit'] = $au['voucher_time_limit'];
				}
		    }
	    }

	    $this->data['delete'] = $this->url->link('account/customerpartner/wk_mpaddauction/deletebids', '', 'SSL');

	    $this->data['bids'] = array();
		$this->data['winners'] = array();
		$this->data['productBids'] = array();
		$this->data1 = array();
		
		// $product_total = $this->model_account_->getTotalBids();
		$results = $this->model_account_wk_mpaddauction->getSellerBids();

		foreach ($results as $result) {
		$productBids = $this->model_account_wk_mpaddauction->getBidsById($result['product_id']);
		foreach($productBids as $productBid){
		  if (isset($productBid['auto_bid'])) {
			    
			    $this->data['productBids'][] = array(
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

				$this->data['productBids'][] = array(
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
		$totalBid = $this->model_account_wk_mpaddauction->getTotalBid($result['product_id']);
		$total_auto_Bid = $this->model_account_wk_mpaddauction->getTotalAutoBid($result['product_id']);
      		if ($total_auto_Bid) {

			$this->data['bids'][] = array(
				'selected'=>False,
				'id' => $result['id'],
				'product_id' => $result['product_id'],
				'product' => $result['name'],
				'auction_start' => $result['start_date'],
				'auction_end'  => $result['end_date'],
				'totalBid'  => $totalBid,
				'total_auto_bid' => $total_auto_Bid,
			);
          	
		}else{
            
            $this->data['bids'][] = array(
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
		
		// foreach ($results as $result) {
		// $productBids = $this->model_account_wk_mpaddauction->getBidsById($result['product_id']);
		// foreach($productBids as $productBid){
		//   $this->data['productBids'][] = array(
		// 	  'selected'=>False,
		// 	  'id' => $productBid['id'],
		// 	  'product_id' => $result['product_id'],
		// 	  'customer_name' => $productBid['firstname']." ".$productBid['lastname'],
		// 	  'start_date' => $productBid['start_date'],
		// 	  'end_date' => $productBid['end_date'],
		// 	  'bid' => $productBid['user_bid'],
		//   );
		// }
		// $totalBid = $this->model_account_wk_mpaddauction->getTotalBid($result['product_id']);
  		// 		$this->data['bids'][] = array(
		// 		'selected'=>False,
		// 		'id' => $result['id'],
		// 		'product_id' => $result['product_id'],
		// 		'product' => $result['name'],
		// 		'auction_start' => $result['start_date'],
		// 		'auction_end'  => $result['end_date'],
		// 		'totalBid'  => $totalBid,
		// 	);
          	
		// }
		$winners = $this->model_account_wk_mpaddauction->getWinners();
		foreach($winners as $winner){
		      $this->data['winners'][] = array(
			      'selected'=>False,
			      'id' => $winner['id'],
			      'customer_name' => $winner['firstname']." ".$winner['lastname'],
			      'product_name' => $winner['name'],
			      'bid' => $winner['user_bid'],
			      'start_date' => $winner['start_date'],
			      'end_date' => $winner['end_date'],
		      );
		}

		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
	
		$this->data['action'] = $this->url->link('account/customerpartner/wk_mpaddauction', '', 'SSL');


		$this->data['back'] = $this->url->link('account/account', '', 'SSL');


		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['column_right'] = $this->load->controller('common/column_right');
		$this->data['content_top'] = $this->load->controller('common/content_top');
		$this->data['content_bottom'] = $this->load->controller('common/content_bottom');
		$this->data['footer'] = $this->load->controller('common/footer');
		$this->data['header'] = $this->load->controller('common/header');	

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/wk_mpaddauction.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/customerpartner/wk_mpaddauction.tpl' , $this->data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/customerpartner/wk_mpaddauction.tpl' , $this->data));
		}

	}

	public function getproduct(){

  		$this->load->model('account/wk_mpaddauction');
  		$json = array();

  		if(isset($this->request->post['p']) AND $this->customer->getId()){	

			$name = $this->request->post['p'];			
			$user = $this->model_account_wk_mpaddauction->getMatchProducts($name);
			
			foreach ($user as $key => $row) {
				$json[] = array('product_id' => $row['product_id'],
							    'label' => $row['name'],
							    'seller_id' => $row['customer_id'],
							   );
			}
			 
	    }

	    $this->response->setOutput(json_encode($json));
  	}
	
	public function wkauctionbidsinsert(){

		$this->load->model('module/wkproduct_auction');
		$this->language->load('module/wkproduct_auction');
		
		    if($this->customer->getId() AND isset($this->request->post['check'])){
			    		    	
			    	$name= $this->request->post['name'];
			    	$cus = $this->customer->getId();
			    	$result = $this->model_module_wkproduct_auction->wkauctionbids_viewproducts($name,$cus);
			    	$rep="";
			        foreach($result as $row){
			            $rep=$rep.$row['oc_product_id'].'-'.$row['name'].'=';
					}
					print_r($rep);
			 }

	     	//$this->response->setOutput(json_encode($json));
			// print_r('expression');
	    
	}
	
	public function wkauctionmailstatus(){

		$this->load->model('account/wkaddauction');
		//$this->language->load('module/wkproduct_auction');
		
		    if($this->customer->getId() AND isset($this->request->post['sellerMail'])){
			    	$status= $this->request->post['sellerMail'];
			    	$seller = $this->customer->getId();
			    	$result = $this->model_account_wkaddauction->wkauctionsetstatus($status,$seller);
			    	if($result == 0){
				  echo "Status has been updated.";
			    	}else{
				  echo "Successfully inserted email status.";
			    	}
			 }

	     	//$this->response->setOutput(json_encode($json));
			// print_r('expression');
	    
	}

	public function deletebids(){
		$this->language->load('account/customerpartner/wk_mpaddauction');

		$this->load->model('account/wk_mpaddauction');
		
		if (isset($this->request->post['selected'])) {
			
			foreach ($this->request->post['selected'] as $id) {
				$this->model_account_wk_mpaddauction->deleteBid($id);
	  		}

			$this->session->data['success'] = $this->language->get('text_bidsuccess');
			
			$this->response->redirect($this->url->link('account/customerpartner/wk_mpaddauction', '', 'SSL'));
		}
	}

	private function validate() {

		$this->load->language('account/customerpartner/wk_mpaddauction');
  		if ((utf8_strlen($this->request->post['product_name']) < 1) || (utf8_strlen($this->request->post['product_name']) > 255)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (empty($this->request->post['aumin']) || empty($this->request->post['aumax'])) {
			$this->error['price'] = $this->language->get('error_price');
		}
		date_default_timezone_set($this->config->get('wkproduct_auction_timezone_set'));
		// $date = new DateTime('2015-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
		// $zone = $date->format('P');
		
		// $newtimestamp = strtotime($this->request->post['austart'].$zone." minute");
		// $correctTime = date("Y-m-d H:i",$newtimestamp);
		$date = date("Y-m-d H:i:s");

		

		if(!(isset($this->error['error_voucher'])) && $this->request->post['auend'] >= $this->request->post['voucher_expiry']) {
	        $this->error['warning'] = $this->language->get('error_warning');
	        $this->error['error_voucher'] = $this->language->get('error_voucher'); 
	    }
	
		if(isset($this->request->post['austart']) && $this->request->post['austart']){
			if($this->request->post['auend']>$date){
				//return true;
	  		}else{
	  			$this->error['date'] = $this->language->get('error_date');
	  		}	
		}
  		
    	if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
}
?>