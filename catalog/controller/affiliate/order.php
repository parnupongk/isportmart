<?php
class ControllerAffiliateOrder extends Controller {
public function index() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/order', '', 'SSL');
			$this->response->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}
		$this->load->language('affiliate/order');
		$this->document->setTitle($this->language->get('heading_title'));
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('affiliate/order')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('affiliate/account', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_transaction'),
			'href' => $this->url->link('affiliate/order', '', 'SSL')
		);

		$this->load->model('affiliate/order');
		$data['heading_title'] = $this->language->get('heading_title');		
		$data['date_modified'] = $this->language->get('date_modified');
		$data['order_id'] = $this->language->get('order_id');
		$data['affiliate'] = $this->language->get('affiliate');
		$data['status'] = $this->language->get('status'); 
		
		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_affiliate'] = $this->language->get('column_affiliate');
		$data['column_status'] = $this->language->get('column_status'); 
		
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_description'] = $this->language->get('column_description');
		$data['column_amount'] = sprintf($this->language->get('column_amount'), $this->config->get('config_currency'));

		$data['text_balance'] = $this->language->get('text_balance');
		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_action'] = $this->language->get('text_action');
		$data['text_DocDelivery'] = $this->language->get('text_DocDelivery');
		$data['text_remark'] = $this->language->get('text_remark');
		$data['text_loading'] = $this->language->get('text_loading');
		
		$data['button_approve'] = $this->language->get('button_approve');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_file'] = $this->language->get('button_file');
		$data['button_invoice_print'] = $this->language->get('button_invoice_print');
		$data['button_shipping_print'] = $this->language->get('button_shipping_print');
						
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		//nid add 16/3/2016 10:21  fillter by status 
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}
		$data['transactions'] = array();
		$filter_data = array(
			'filter_status' => $filter_status,////nid add 16/3/2016 10:21  fillter by status 
			'sort'  => 't.date_modified',
			'order' => 'DESC',
			'start' => ($page - 1) * 10,
			'limit' => 10
		);
		$transaction_total = $this->model_affiliate_order->getTotalTransactions();
		$results = $this->model_affiliate_order->getTransactions($filter_data);

		$url = '';
		foreach ($results as $result) {
			$affiliate_id = $result['affiliate'];
			$order_id = $result['order_id'];
				
			if ($result['order_status_id'] == 15) {
				$approve = $this->url->link('affiliate/order/approved', 'affiliate_id=' .$result['affiliate_id']. '&order_id=' . $result['order_id']. '&order_status_id=' . $result['order_status_id'] .'&page='.$page,'', 'SSL');
				$shipping = '';
				$invoice = '';
				$updateStatusID ='';
				$showHistory='';
				$showDownload ='';
				$addressPrint = '';
				$updateBarcodeStock='';
			/*if($order_status_id != 3 and $order_status_id != 27){*/	
			}else if ($result['order_status_id'] == 2) {
				$approve = $this->url->link('affiliate/order/approved', 'affiliate_id=' .$result['affiliate_id']. '&order_id=' . $result['order_id']. '&order_status_id=' . $result['order_status_id'] .'&page='.$page,'', 'SSL');
				$shipping = '';
				$invoice = '';
				$updateStatusID ='';
				$showHistory='';
				$showDownload ='';
				$addressPrint='';
				$updateBarcodeStock='';
			/*if($order_status_id != 3 and $order_status_id != 27){*/	
			}else if($result['order_status_id'] == 3 || $result['order_status_id'] == 27) {
				$updateStatusID =$this->url->link('affiliate/order/approved', 'affiliate_id=' .$result['affiliate_id']. '&order_id=' . $result['order_id']. '&order_status_id=' . $result['order_status_id'] .'&page='.$page,'', 'SSL');
				$approve = '';
				$showHistory =$this->url->link('affiliate/order/OrderHistory','affiliate_id=' .$result['affiliate_id']. '&order_id=' . $result['order_id']. '&order_status_id=' . $result['order_status_id'],'', 'SSL');			
				$showDownload =$this->url->link('affiliate/order/Download_file','affiliate_id=' .$result['affiliate_id']. '&order_id=' . $result['order_id']. '&order_status_id=' . $result['order_status_id'],'', 'SSL');							
				$shipping = $this->url->link('affiliate/order/shipping', 'affiliate_id=' .$result['affiliate_id']. '&order_id=' .$result['order_id'],'', 'SSL');			
				$invoice = $this->url->link('affiliate/order/invoice', 'affiliate_id=' .$result['affiliate_id']. '&order_id=' .$result['order_id'],'', 'SSL');
				$addressPrint = $this->url->link('affiliate/order/addressprint', 'affiliate_id=' .$result['affiliate_id']. '&order_id=' .$result['order_id'],'', 'SSL');
				$updateBarcodeStock= $this->url->link('affiliate/order/OrderStockHistory', 'affiliate_id=' .$result['affiliate_id']. '&order_id=' .$result['order_id']. '&order_status_id=' . $result['order_status_id'],'', 'SSL');
			}else {
				$updateStatusID =$this->url->link('affiliate/order/approved', 'affiliate_id=' .$result['affiliate_id']. '&order_id=' . $result['order_id']. '&order_status_id=' . $result['order_status_id'] .'&page='.$page,'', 'SSL');
				$approve = '';
				$showHistory =$this->url->link('affiliate/order/OrderHistory','affiliate_id=' .$result['affiliate_id']. '&order_id=' . $result['order_id']. '&order_status_id=' . $result['order_status_id'],'', 'SSL');			
				$showDownload ='';
				//$showDownload =$this->url->link('affiliate/order/Download_file','affiliate_id=' .$result['affiliate_id']. '&order_id=' . $result['order_id']. '&order_status_id=' . $result['order_status_id'],'', 'SSL');							
				$shipping = $this->url->link('affiliate/order/shipping', 'affiliate_id=' .$result['affiliate_id']. '&order_id=' .$result['order_id'],'', 'SSL');			
				$invoice = $this->url->link('affiliate/order/invoice', 'affiliate_id=' .$result['affiliate_id']. '&order_id=' .$result['order_id'],'', 'SSL');
				$addressPrint = $this->url->link('affiliate/order/addressprint', 'affiliate_id=' .$result['affiliate_id']. '&order_id=' .$result['order_id'],'', 'SSL');
				$updateBarcodeStock= $this->url->link('affiliate/order/OrderStockHistory', 'affiliate_id=' .$result['affiliate_id']. '&order_id=' .$result['order_id']. '&order_status_id=' . $result['order_status_id'],'', 'SSL');
			}
			$data['transactions'][] = array(
				'order_id'      		=> $result['order_id'],
				'status' 				=> $result['status'],
				'affiliate' 			=> $result['affiliate'],
				'download_id' 	=> $result['download_id'],
				'affiliate_id' 		=> $result['affiliate_id'],
				'order_status_id' => $result['order_status_id'],
				'approve'     		=> $approve,
				'updateStatusID' => $updateStatusID,
				'shipping'			=> $shipping,
				'invoice'			=> $invoice,
				'addressPrint' 		=> $addressPrint,
				'updateBarcodeStock' => $updateBarcodeStock,
				'showHistory' 	=> $showHistory,
				'showDownload' => $showDownload,
				'date_modified'  => date($this->language->get('datetime_format'), strtotime($result['date_modified']))
			);
		}
		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('affiliate/order', 'page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($transaction_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($transaction_total - 10)) ? $transaction_total : ((($page - 1) * 10) + 10), $transaction_total, ceil($transaction_total / 10));

		$data['balance'] = $this->currency->format($this->model_affiliate_order->getBalance());
		$data['total_trans'] = $this->model_affiliate_order->getTotalTransactions();
		$data['order_statuses'] = $this->model_affiliate_order->getOrderStatuses();
		
		//$data['column_left'] = $this->load->controller('common/column_left');
		//$data['column_right'] = $this->load->controller('common/column_right');
		$data['column_left'] = $this->load->controller('common/column_leftaff');
		$data['column_right'] = $this->load->controller('common/column_rightaff');
		
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/headeraff');
					
		//koy fix template to default only! 26/5/2016
		/*if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/order.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/affiliate/order.tpl', $data));
		} else {*/
			$this->response->setOutput($this->load->view('default/template/affiliate/order.tpl', $data));
		//}
}

public function updateProductBarcode()
{
	$this->load->model('affiliate/order');
	$this->model_affiliate_order->updateProductBarcode($this->request->post['orderProductId'],$this->request->post['barcode']);
	echo $this->request->post['orderProductId'];
	echo $this->request->post['barcode'];
}

public function approved() {
	$this->load->language('checkout/order');
	$this->load->model('checkout/order');
	$order_info = $this->model_checkout_order->getOrder($this->request->get['order_id']);			
	if($order_info){
		if($this->request->get['order_status_id'] == 15 || $this->request->get['order_status_id'] == 2){
			$history_order_status_id = $this->request->get['order_status_id'];//15		
			$history_affiliate_id = $this->request->get['affiliate_id'];
			$history_order_status_id = 19;
$this->load->language('checkout/order');
$this->load->model('checkout/order');
$this->load->model('affiliate/order');
				$count_status = $this->model_affiliate_order->getOldstatus($history_order_status_id,$order_info['order_id']);
			if($count_status == '0'){
			$this->model_checkout_order->updateOrderStatus($order_info['order_id'], $history_order_status_id,'',$history_affiliate_id);	
		}
		//$log = new Log('niddebug.log');	
			//$log->write($this->request->get['order_id'] . '(Mail) order_info[order_status_id] = ' . $order_info['order_status_id'] );			
		}

		//$this->index();  // nid
		$this->response->redirect($this->url->link('affiliate/order', '', 'SSL')); // wan
	}			
}
public function addOrderHistory() {
$this->load->language('checkout/order');
$this->load->model('checkout/order');
$this->load->model('affiliate/order');
$order_info = $this->model_checkout_order->getOrder($this->request->get['order_id']);	
$comment= $this->request->get['comment'];
if($order_info){
//updateOrderStatus($order_id, $order_status_id, $comment = '', $notify =true,$affiliate_id =''
		if($this->request->get['order_status_id'] == 19){
		$history_order_status_id = 20;
			$count_status = $this->model_affiliate_order->getOldstatus($history_order_status_id,$order_info['order_id']);
		//	if($count_status == '0'){
			$this->model_checkout_order->updateOrderStatus($order_info['order_id'], $history_order_status_id,$comment,$this->request->get['affiliate_id']);	
		//	}
		}else if($this->request->get['order_status_id'] == 21){
		  $history_order_status_id = $this->request->get['order_status_id'];
			$count_status = $this->model_affiliate_order->getOldstatus($history_order_status_id,$order_info['order_id']);
		//	if($count_status == '0'){
			$this->model_checkout_order->updateOrderStatus($order_info['order_id'], $history_order_status_id,$comment,$this->request->get['affiliate_id']);	
			$history_order_status_id = 3;
			$this->model_checkout_order->updateOrderStatus($order_info['order_id'], $history_order_status_id,$comment,$this->request->get['affiliate_id']);	
		//	}
		}else if($this->request->get['order_status_id'] == 24){
		 $history_order_status_id = $this->request->get['order_status_id'];
		 $count_status = $this->model_affiliate_order->getOldstatus($history_order_status_id,$order_info['order_id']);
		//	if($count_status == '0'){
			$this->model_checkout_order->updateOrderStatus($order_info['order_id'], $history_order_status_id,$comment,$this->request->get['affiliate_id']);	
			$history_order_status_id = 3;
			$this->model_checkout_order->updateOrderStatus($order_info['order_id'], $history_order_status_id,$comment,$this->request->get['affiliate_id']);	
		//	}
	}else if($this->request->get['order_status_id'] == 29){
		 $history_order_status_id = $this->request->get['order_status_id'];
		  $count_status = $this->model_affiliate_order->getOldstatus($history_order_status_id,$order_info['order_id']);
		//	if($count_status == '0'){
			$this->model_checkout_order->updateOrderStatus($order_info['order_id'], $history_order_status_id,$comment,$this->request->get['affiliate_id']);	
			$history_order_status_id = 3;
			$this->model_checkout_order->updateOrderStatus($order_info['order_id'], $history_order_status_id,$comment,$this->request->get['affiliate_id']);	
		//	}
	}else{
		$history_order_status_id = $this->request->get['order_status_id'];
		$count_status = $this->model_affiliate_order->getOldstatus($history_order_status_id,$order_info['order_id']);
	//		if($count_status == '0'){			
			$this->model_checkout_order->updateOrderStatus($order_info['order_id'], $history_order_status_id,$comment,$this->request->get['affiliate_id']);			
	//		}
	}
//$this->index();
$this->response->redirect($this->url->link('affiliate/order', '', 'SSL')); // wan
	}			
}
// bom add update order and update stock 
public function OrderStockHistory() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/order', '', 'SSL');

			$this->response->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}
		$this->load->language('account/order');
		$this->load->language('affiliate/order');
		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('affiliate/account', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_transaction'),
			'href' => $this->url->link('affiliate/order', '', 'SSL')
		);
			
		$this->load->model('affiliate/order');

		$data['text_order_detail'] = '';//$this->language->get('text_order_detail');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_order'] = $this->language->get('text_order');
		$data['history_title'] = $this->language->get('history_title');
		$data['text_history'] = $this->language->get('text_history');
		$data['text_upload_head'] = $this->language->get('text_upload_head');		
		$data['text_loading'] = $this->language->get('text_loading');
		
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_filename'] = $this->language->get('entry_filename');
		
		$data['back'] = $this->url->link('affiliate/order', '', 'SSL');		
		
		$data['button_back'] = $this->language->get('button_back');
		$data['button_history_add'] = $this->language->get('button_history_add');
		$data['button_upload'] = $this->language->get('button_upload');
		$data['button_save'] = $this->language->get('button_save');	
			
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_notify'] = $this->language->get('column_notify');
		$data['column_comment'] = $this->language->get('column_comment');
				
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$data['histories'] = array();
		$results = $this->model_affiliate_order->getOrderHistory($this->request->get['order_id'], ($page - 1) * 5, 5);
		foreach ($results as $result) {
			$data['histories'][] = array(
				'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'status'     => $result['status'],
				'affiliate_id'	=> $result['affiliate_id'],
				'order_id'     => $result['order_id'],
				'order_status_id'     => $result['order_status_id'],
				'comment'    => nl2br($result['comment']),
				'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added']))
			);
		}
		$history_total = $this->model_affiliate_order->getTotalOrderHistories($this->request->get['order_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->url = $this->url->link('affiliate/order/OrderHistory','affiliate_id=' .$result['affiliate_id']. '&order_id=' . $result['order_id']. '&order_status_id=' . $result['order_status_id']. '&page={page}', 'SSL');
			
		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($history_total - 5)) ? $history_total : ((($page - 1) * 5) + 5), $history_total, ceil($history_total / 5));
		
		$data['order_status_id'] = $this->request->get['order_status_id'];
		$data['order_id'] = $this->request->get['order_id'];
		$data['affiliate_id'] = $this->request->get['affiliate_id'];
		$data['order_statuses'] = $this->model_affiliate_order->getOrderStatuses();
		$data['showOrder'] = $this->request->get['order_id'];
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/headeraff');
		
		if (isset($this->request->post['filename'])) {
			$data['filename'] = $this->request->post['filename'];
		} elseif (!empty($download_info)) {
			$data['filename'] = $download_info['filename'];
		} else {
			$data['filename'] = '';
		}
		if (isset($this->request->post['mask'])) {
			$data['mask'] = $this->request->post['mask'];
		} elseif (!empty($download_info)) {
			$data['mask'] = $download_info['mask'];
		} else {
			$data['mask'] = '';
		}
		if (isset($this->error['filename'])) {
			$data['error_filename'] = $this->error['filename'];
		} else {
			$data['error_filename'] = '';
		}		

		if (!isset($this->request->get['download_id'])) {		
			$data['action'] = $this->url->link('affiliate/order/add','', 'SSL');
		}

			$this->load->model('account/order');
			$this->load->model('catalog/product');
			$this->load->model('tool/upload');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

			// Products
			$data['products'] = array();
						$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price_affiliate');
			$data['column_total'] = $this->language->get('column_total_affiliate');
			$data['column_action'] = $this->language->get('column_action');
			$data['column_date_added'] = $this->language->get('column_date_added');
			$data['column_status'] = $this->language->get('column_status');
			$data['column_comment'] = $this->language->get('column_comment');
$order_info = $this->model_account_order->getOrder_affiliate($order_id);
			$products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$product_info = $this->model_catalog_product->getProduct($product['product_id']);

				if ($product_info) {
					$reorder = $this->url->link('account/order/reorder', 'order_id=' . $order_id . '&order_product_id=' . $product['order_product_id'], 'SSL');
				} else {
					$reorder = '';
				}

				$data['products'][] = array(
					'name'     => $product['name'],
					'model'    => $product['model'],
					'option'   => $option_data,
					'quantity' => $product['quantity'],
					'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'reorder'  => $reorder,
					'return'   => $this->url->link('account/return/add', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], 'SSL'),
					'order_product_id' => $product['order_product_id']
				);
			}

		//koy fix template to default only! 26/5/2016
		/*if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/order_history.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/affiliate/order_history.tpl', $data));
		} else {*/
			$this->response->setOutput($this->load->view('default/template/affiliate/order_stock_history.tpl', $data));
		//}
}


// end update order and stock
public function OrderHistory() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/order', '', 'SSL');

			$this->response->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		$this->load->language('affiliate/order');
		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('affiliate/account', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_transaction'),
			'href' => $this->url->link('affiliate/order', '', 'SSL')
		);
			
		$this->load->model('affiliate/order');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_order'] = $this->language->get('text_order');
		$data['history_title'] = $this->language->get('history_title');
		$data['text_history'] = $this->language->get('text_history');
		$data['text_upload_head'] = $this->language->get('text_upload_head');		
		$data['text_loading'] = $this->language->get('text_loading');
		
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_filename'] = $this->language->get('entry_filename');
		
		$data['back'] = $this->url->link('affiliate/order', '', 'SSL');		
		
		$data['button_back'] = $this->language->get('button_back');
		$data['button_history_add'] = $this->language->get('button_history_add');
		$data['button_upload'] = $this->language->get('button_upload');
		$data['button_save'] = $this->language->get('button_save');	
			
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_notify'] = $this->language->get('column_notify');
		$data['column_comment'] = $this->language->get('column_comment');
				
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$data['histories'] = array();
		$results = $this->model_affiliate_order->getOrderHistory($this->request->get['order_id'], ($page - 1) * 5, 5);
		foreach ($results as $result) {
			$data['histories'][] = array(
				'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'status'     => $result['status'],
				'affiliate_id'	=> $result['affiliate_id'],
				'order_id'     => $result['order_id'],
				'order_status_id'     => $result['order_status_id'],
				'comment'    => nl2br($result['comment']),
				'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added']))
			);
		}
		$history_total = $this->model_affiliate_order->getTotalOrderHistories($this->request->get['order_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('affiliate/order/OrderHistory','affiliate_id=' .$result['affiliate_id']. '&order_id=' . $result['order_id']. '&order_status_id=' . $result['order_status_id']. '&page={page}', 'SSL');
			
		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));
		
		$data['order_status_id'] = $this->request->get['order_status_id'];
		$data['order_id'] = $this->request->get['order_id'];
		$data['affiliate_id'] = $this->request->get['affiliate_id'];
		$data['order_statuses'] = $this->model_affiliate_order->getOrderStatuses();
		$data['showOrder'] = $this->request->get['order_id'];
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/headeraff');
		
		if (isset($this->request->post['filename'])) {
			$data['filename'] = $this->request->post['filename'];
		} elseif (!empty($download_info)) {
			$data['filename'] = $download_info['filename'];
		} else {
			$data['filename'] = '';
		}
		if (isset($this->request->post['mask'])) {
			$data['mask'] = $this->request->post['mask'];
		} elseif (!empty($download_info)) {
			$data['mask'] = $download_info['mask'];
		} else {
			$data['mask'] = '';
		}
		if (isset($this->error['filename'])) {
			$data['error_filename'] = $this->error['filename'];
		} else {
			$data['error_filename'] = '';
		}		

		if (!isset($this->request->get['download_id'])) {		
			$data['action'] = $this->url->link('affiliate/order/add','', 'SSL');
		}

		//koy fix template to default only! 26/5/2016
		/*if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/order_history.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/affiliate/order_history.tpl', $data));
		} else {*/
			$this->response->setOutput($this->load->view('default/template/affiliate/order_history.tpl', $data));
		//}
}
//----upload file 31/10/2015  nid
public function upload() {
	$this->load->language('affiliate/order');

	$json = array();
	if (!$json) {
		if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
			// Sanitize the filename
			$filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));

			// Validate the filename length
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 128)) {
				$json['error'] = $this->language->get('error_filename');
			}

			// Allowed file extension types
			$allowed = array();

			$extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));

			$filetypes = explode("\n", $extension_allowed);

			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}

			if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Allowed file mime types
			$allowed = array();

			$mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));

			$filetypes = explode("\n", $mime_allowed);

			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}

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
	}

	if (!$json) {
		//$file = $filename . '.' . md5(mt_rand());		
		if(strlen($filename) < 5){
			$filename = "images".$filename;
		} 
		$file = $filename;		
		move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);
		$json['filename'] = $file;
		$json['mask'] = $filename;
		$json['success'] = $this->language->get('text_upload');
	}

	$this->response->addHeader('Content-Type: application/json');
	$this->response->setOutput(json_encode($json));
}
public function Download_file(){
	if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/order', '', 'SSL');

			$this->response->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}
		$this->load->language('affiliate/order');
		$data['back'] = $this->url->link('affiliate/order', '', 'SSL');				
		$data['button_back'] = $this->language->get('button_back');		
		$this->load->model('affiliate/order');
		$data['file_down'] = array();
		$results = $this->model_affiliate_order->getDownload($this->request->get['order_id']);
		foreach ($results as $result) {
			$data['file_down'][] = array(
				'download_id'     => $result['download_id'],
				'name'     => nl2br($result['name']),
				'mask'     => $result['mask'],
				'affiliate_id'     => $result['affiliate_id'],
				'order_id'     => $result['order_id'],
			     'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added']))
			);
		}
	$this->response->setOutput($this->load->view('default/template/affiliate/order_download.tpl', $data));		
}
protected function validateForm() {

		if ((utf8_strlen($this->request->post['filename']) < 3) || (utf8_strlen($this->request->post['filename']) > 128)) {
			$this->error['filename'] = $this->language->get('error_filename');
		}
		if (!is_file(DIR_DOWNLOAD . $this->request->post['filename'])) {
			$this->error['filename'] = $this->language->get('error_exists');
		}
		if ((utf8_strlen($this->request->post['mask']) < 3) || (utf8_strlen($this->request->post['mask']) > 128)) {
			$this->error['mask'] = $this->language->get('error_mask');
		}
		return !$this->error;
}
public function add() {
	
		$this->load->language('affiliate/order');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('affiliate/order');			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {	
			$this->model_affiliate_order->addDownload($this->request->post);			
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('affiliate/order','', 'SSL'));
		}
		//$this->index();
		$this->response->redirect($this->url->link('affiliate/order', '', 'SSL')); // wan
}
public function add_pay() {
	
		$this->load->language('affiliate/order');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('affiliate/order');	
		

		if ((utf8_strlen($this->request->post['filename']) < 3) || (utf8_strlen($this->request->post['filename']) > 128)) {
			$this->error['filename'] = $this->language->get('error_filename');
		}
		if (!is_file(DIR_DOWNLOAD . $this->request->post['filename'])) {
			$this->error['filename'] = $this->language->get('error_exists');
		}
		if ((utf8_strlen($this->request->post['mask']) < 3) || (utf8_strlen($this->request->post['mask']) > 128)) {
			$this->error['mask'] = $this->language->get('error_mask');
		}
		
		$this->model_affiliate_order->addAffDownload($this->request->post['order_id_upload'],$this->request->post['affiliate_id_form'],$this->request->post['filename'],$this->request->post['mask']);		
		$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('affiliate/order','', 'SSL'));
			//$this->index();
}
public function confirm_pay() {
	
		$this->load->language('affiliate/order');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('affiliate/order');	
		$this->load->model('checkout/order');
		if ((utf8_strlen($this->request->post['filename']) < 3) || (utf8_strlen($this->request->post['filename']) > 128)) {
			$this->error['filename'] = $this->language->get('error_filename');
		}
		if (!is_file(DIR_DOWNLOAD . $this->request->post['filename'])) {
			$this->error['filename'] = $this->language->get('error_exists');
		}
		if ((utf8_strlen($this->request->post['mask']) < 3) || (utf8_strlen($this->request->post['mask']) > 128)) {
			$this->error['mask'] = $this->language->get('error_mask');
		}
		// customer upload file 
		$result_upload = $this->model_affiliate_order->addCustomerDownload($this->request->post['order_id_upload'],$this->request->post['affiliate_id_form'],$this->request->post['filename'],$this->request->post['mask']);		
        // update history order status by customer
		$history_order_status_id = 28;
		$comment = "หากมีข้อสงสัยสอบถามที่เบอร์ 02-502-6505";
		$this->model_checkout_order->updateOrderStatus($this->request->post['order_id_upload'], $history_order_status_id,$comment,$this->request->post['affiliate_id_form']);	
		
		//$this->index();
		$this->response->redirect($this->url->link('affiliate/order', '', 'SSL')); // wan
}
public function invoice(){
		$this->load->language('account/order');
		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');
		
		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}
		
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/order', '', 'SSL');
			$this->response->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}
				
		$this->load->model('affiliate/order');
		$this->load->model('account/order');
		$this->load->model('setting/setting');
		$order_info = $this->model_account_order->getOrder_affiliate($order_id);
		//echo "<pre>"; print_r($order_info);
		if ($order_info) {
			$this->document->setTitle($this->language->get('text_order'));
			$data['heading_title'] = $this->language->get('text_invoice');

			$data['text_order_detail'] = $this->language->get('text_order_detail');
			$data['text_invoice_no'] = $this->language->get('text_invoice_no');
			$data['text_order_id'] = $this->language->get('text_order_id');
			$data['text_date_added'] = $this->language->get('text_date_added_affiliate');
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$data['text_shipping_address'] = $this->language->get('text_ship_to');
			$data['text_payment_method'] = $this->language->get('text_payment_method');
			$data['text_payment_address'] = $this->language->get('text_to');
			$data['text_history'] = $this->language->get('text_history');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_telephone'] = $this->language->get('text_telephone');
			$data['text_fax'] = $this->language->get('text_fax');
			$data['text_email'] = $this->language->get('text_email');
			$data['text_website'] = $this->language->get('text_website');
			$data['text_confirm_invoice'] = $this->language->get('text_confirm_invoice');
			$data['text_change_invoice'] = $this->language->get('text_change_invoice');
			$data['text_reject_invoice'] = $this->language->get('text_reject_invoice');
			$data['text_reciever'] = $this->language->get('text_reciever');
			$data['text_approve_invoice'] = $this->language->get('text_approve_invoice');
			$data['text_approve_invoice_name'] = $this->language->get('text_approve_invoice_name');
						
			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price_affiliate');
			$data['column_total'] = $this->language->get('column_total_affiliate');
			$data['column_action'] = $this->language->get('column_action');
			$data['column_date_added'] = $this->language->get('column_date_added');
			$data['column_status'] = $this->language->get('column_status');
			$data['column_comment'] = $this->language->get('column_comment');

			$data['button_reorder'] = $this->language->get('button_reorder');
			$data['button_return'] = $this->language->get('button_return');
			$data['button_continue'] = $this->language->get('button_continue');

			if (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];

				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}
			$store_affiliate = $this->model_affiliate_order->getAffiliate($this->request->get['affiliate_id']);
			if($store_affiliate){
				$data['cheque'] = $store_affiliate['cheque'];
			}
		//store
			if ($order_info['store_url']) {
				$data['store_url'] = $order_info['store_url'];
			} else {
				$data['store_url'] = '';
			}
			$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

			if ($store_info) {
				$data['store_name'] = $store_info['config_name'];
				$data['store_address'] = nl2br($store_info['config_address']);
				$data['store_email'] = $store_info['config_email'];
				$data['store_telephone'] = $store_info['config_telephone'];
				$data['store_fax'] = $store_info['config_fax'];
				$data['store_invoice_prefix'] = $store_info['config_invoice_prefix'];  // one add
				$data['store_owner'] = $store_info['config_owner'];				 // one add
			} else {
				$data['store_name'] = $this->config->get('config_name');
				$data['store_address'] = $this->config->get('config_address');
				$data['store_email'] = $this->config->get('config_email');
				$data['store_telephone'] = $this->config->get('config_telephone');
				$data['store_fax'] = $this->config->get('config_fax');
				$data['store_invoice_prefix'] = $this->config->get('config_invoice_prefix');  // one add
				$data['store_owner'] = $this->config->get('config_owner');  // one add

			}
	   // store
			if ($order_info['invoice_no']) {
				$data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}

			$data['order_id'] = $this->request->get['order_id'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
                $data['cust_telephone'] = $order_info['telephone'];
                $data['cust_comment'] = $order_info['comment'];
			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' ;//. "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}'
				//,'{country}'
			);

			$replace = array(
				'firstname' => $order_info['payment_firstname'],
				'lastname'  => $order_info['payment_lastname'],
				'company'   => $order_info['payment_company'],
				'address_1' => $order_info['payment_address_1'],
				'address_2' => $order_info['payment_address_2'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code']
				//,'country'   => $order_info['payment_country']
			);

			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['payment_method'] = $order_info['payment_method'];
			//nid add 21/04/2016 14:30
      $data['payment_code'] = $order_info['payment_code'];
			if ($order_info['shipping_address_format']) {
				$format = $order_info['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' ;//. "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}'
				//,'{country}'
			);

			$replace = array(
				'firstname' => $order_info['shipping_firstname'],
				'lastname'  => $order_info['shipping_lastname'],
				'company'   => $order_info['shipping_company'],
				'address_1' => $order_info['shipping_address_1'],
				'address_2' => $order_info['shipping_address_2'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code']
				//,'country'   => $order_info['shipping_country']
			);
			$data['shipping_customer_name'] = $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'];  // one add
			$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['shipping_method'] = $order_info['shipping_method'];

			$this->load->model('catalog/product');
			$this->load->model('tool/upload');

			// Products
			$data['products'] = array();

			$products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$product_info = $this->model_catalog_product->getProduct($product['product_id']);

				if ($product_info) {
					$reorder = $this->url->link('account/order/reorder', 'order_id=' . $order_id . '&order_product_id=' . $product['order_product_id'], 'SSL');
				} else {
					$reorder = '';
				}

				$data['products'][] = array(
					'name'     => $product['name'],
					'model'    => $product['model'],
					'option'   => $option_data,
					'quantity' => $product['quantity'],
					'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'reorder'  => $reorder,
					'return'   => $this->url->link('account/return/add', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], 'SSL')
				);
			}

			// Voucher
			$data['vouchers'] = array();

			$vouchers = $this->model_account_order->getOrderVouchers($this->request->get['order_id']);

			foreach ($vouchers as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}

			// Totals
			$data['totals'] = array();

			$totals = $this->model_account_order->getOrderTotals($this->request->get['order_id']);

			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
				);
			}

			$data['comment'] = nl2br($order_info['comment']);

			// History
			$data['histories'] = array();

			$results = $this->model_account_order->getOrderHistories($this->request->get['order_id']);

			foreach ($results as $result) {
				$data['histories'][] = array(
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'status'     => $result['status'],
					'comment'    => $result['notify'] ? nl2br($result['comment']) : ''
				);
			}

			$data['continue'] = $this->url->link('account/order', '', 'SSL');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/headeraff');

			//koy fix template to default only! 26/5/2016
			/*if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/invoice.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/affiliate/invoice.tpl', $data));
			} else {*/
				$this->response->setOutput($this->load->view('default/template/affiliate/invoice.tpl', $data));
			//}
		} 
		
}		
/// bom add 02/09/2016
public function addressprint(){
		$this->load->language('account/order');
		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');
		
		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}
		
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/order', '', 'SSL');
			$this->response->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}
				
		$this->load->model('affiliate/order');
		$this->load->model('account/order');
		$this->load->model('setting/setting');
		$order_info = $this->model_account_order->getOrder_affiliate($order_id);
		//echo "<pre>"; print_r($order_info);
		if ($order_info) {
			$this->document->setTitle($this->language->get('text_order'));
			$data['heading_title'] = $this->language->get('text_invoice');

			$data['text_order_detail'] = $this->language->get('text_order_detail');
			$data['text_invoice_no'] = $this->language->get('text_invoice_no');
			$data['text_order_id'] = $this->language->get('text_order_id');
			$data['text_date_added'] = $this->language->get('text_date_added_affiliate');
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$data['text_shipping_address'] = $this->language->get('text_ship_to');
			$data['text_payment_method'] = $this->language->get('text_payment_method');
			$data['text_payment_address'] = $this->language->get('text_to');
			$data['text_history'] = $this->language->get('text_history');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_telephone'] = $this->language->get('text_telephone');
			$data['text_fax'] = $this->language->get('text_fax');
			$data['text_email'] = $this->language->get('text_email');
			$data['text_website'] = $this->language->get('text_website');
			$data['text_confirm_invoice'] = $this->language->get('text_confirm_invoice');
			$data['text_change_invoice'] = $this->language->get('text_change_invoice');
			$data['text_reject_invoice'] = $this->language->get('text_reject_invoice');
			$data['text_reciever'] = $this->language->get('text_reciever');
			$data['text_approve_invoice'] = $this->language->get('text_approve_invoice');
			$data['text_approve_invoice_name'] = $this->language->get('text_approve_invoice_name');
						
			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price_affiliate');
			$data['column_total'] = $this->language->get('column_total_affiliate');
			$data['column_action'] = $this->language->get('column_action');
			$data['column_date_added'] = $this->language->get('column_date_added');
			$data['column_status'] = $this->language->get('column_status');
			$data['column_comment'] = $this->language->get('column_comment');

			$data['button_reorder'] = $this->language->get('button_reorder');
			$data['button_return'] = $this->language->get('button_return');
			$data['button_continue'] = $this->language->get('button_continue');

			if (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];

				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}
			$store_affiliate = $this->model_affiliate_order->getAffiliate($this->request->get['affiliate_id']);
			if($store_affiliate){
				$data['cheque'] = $store_affiliate['cheque'];
			}
		//store
			if ($order_info['store_url']) {
				$data['store_url'] = $order_info['store_url'];
			} else {
				$data['store_url'] = '';
			}
			$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

			if ($store_info) {
				$data['store_name'] = $store_info['config_name'];
				$data['store_address'] = nl2br($store_info['config_address']);
				$data['store_email'] = $store_info['config_email'];
				$data['store_telephone'] = $store_info['config_telephone'];
				$data['store_fax'] = $store_info['config_fax'];
				$data['store_invoice_prefix'] = $store_info['config_invoice_prefix'];  // one add
				$data['store_owner'] = $store_info['config_owner'];				 // one add
			} else {
				$data['store_name'] = $this->config->get('config_name');
				$data['store_address'] = $this->config->get('config_address');
				$data['store_email'] = $this->config->get('config_email');
				$data['store_telephone'] = $this->config->get('config_telephone');
				$data['store_fax'] = $this->config->get('config_fax');
				$data['store_invoice_prefix'] = $this->config->get('config_invoice_prefix');  // one add
				$data['store_owner'] = $this->config->get('config_owner');  // one add

			}
	   // store
			if ($order_info['invoice_no']) {
				$data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}

			$data['order_id'] = $this->request->get['order_id'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
                $data['cust_telephone'] = $order_info['telephone'];
                $data['cust_comment'] = $order_info['comment'];
			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' ;//. "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}'
				//,'{country}'
			);

			$replace = array(
				'firstname' => $order_info['payment_firstname'],
				'lastname'  => $order_info['payment_lastname'],
				'company'   => $order_info['payment_company'],
				'address_1' => $order_info['payment_address_1'],
				'address_2' => $order_info['payment_address_2'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code']
				//,'country'   => $order_info['payment_country']
			);

			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['payment_method'] = $order_info['payment_method'];
			//nid add 21/04/2016 14:30
      $data['payment_code'] = $order_info['payment_code'];
			if ($order_info['shipping_address_format']) {
				$format = $order_info['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "" . '{address_2}' . "" . '{city} {zone}' . "\n" . ' {postcode}' ;//. "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}'
				//,'{country}'
			);

			$replace = array(
				'firstname' => $order_info['shipping_firstname'],
				'lastname'  => $order_info['shipping_lastname'],
				'company'   => $order_info['shipping_company'],
				'address_1' => $order_info['shipping_address_1'],
				'address_2' => $order_info['shipping_address_2'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code']
				//,'country'   => $order_info['shipping_country']
			);
			$data['shipping_customer_name'] = $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'];  // one add
			$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['shipping_method'] = $order_info['shipping_method'];

			$this->load->model('catalog/product');
			$this->load->model('tool/upload');

			// Products
			$data['products'] = array();

			$products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$product_info = $this->model_catalog_product->getProduct($product['product_id']);

				if ($product_info) {
					$reorder = $this->url->link('account/order/reorder', 'order_id=' . $order_id . '&order_product_id=' . $product['order_product_id'], 'SSL');
				} else {
					$reorder = '';
				}

				$data['products'][] = array(
					'name'     => $product['name'],
					'model'    => $product['model'],
					'option'   => $option_data,
					'quantity' => $product['quantity'],
					'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'reorder'  => $reorder,
					'return'   => $this->url->link('account/return/add', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], 'SSL')
				);
			}

			// Voucher
			$data['vouchers'] = array();

			$vouchers = $this->model_account_order->getOrderVouchers($this->request->get['order_id']);

			foreach ($vouchers as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}

			// Totals
			$data['totals'] = array();

			$totals = $this->model_account_order->getOrderTotals($this->request->get['order_id']);

			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
				);
			}

			$data['comment'] = nl2br($order_info['comment']);

			// History
			$data['histories'] = array();

			$results = $this->model_account_order->getOrderHistories($this->request->get['order_id']);

			foreach ($results as $result) {
				$data['histories'][] = array(
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'status'     => $result['status'],
					'comment'    => $result['notify'] ? nl2br($result['comment']) : ''
				);
			}

			$data['continue'] = $this->url->link('account/order', '', 'SSL');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/headeraff');

			//koy fix template to default only! 26/5/2016
			/*if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/invoice.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/affiliate/invoice.tpl', $data));
			} else {*/
				$this->response->setOutput($this->load->view('default/template/affiliate/addressprint.tpl', $data));
			//}
		} 
		
}		


// end bom 
// Kit Add 7/1/2016 //////////////////////
public function invoice_tracking(){
		$this->load->language('account/order');
		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');
		
		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}
		
		if (isset($this->request->get['order_id'])) {
			$order_id = base64_decode($this->request->get['order_id']);
			//$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}
		/*if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/order', '', 'SSL');
			$this->response->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}*/
				
		$this->load->model('affiliate/order');
		$this->load->model('account/order');
		$this->load->model('setting/setting');
		
		//Text History
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_notify'] = $this->language->get('column_notify');
		$data['column_comment'] = $this->language->get('column_comment');
		$data['text_order'] = $this->language->get('text_order');
		$data['history_title'] = $this->language->get('history_title');	
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$data['histories'] = array();
		$results = $this->model_affiliate_order->getOrderHistory(base64_decode($this->request->get['order_id']), ($page - 1) * 5, 5);
		foreach ($results as $result) {
			$data['histories'][] = array(
				'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'status'     => $result['status'],
				'affiliate_id'	=> $result['affiliate_id'],
				'order_id'     => $result['order_id'],
				'order_status_id'     => $result['order_status_id'],
				'comment'    => nl2br($result['comment']),
				'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added']))
			);
		}
		$history_total = $this->model_affiliate_order->getTotalOrderHistories(base64_decode($this->request->get['order_id']));
		//
		$order_info = $this->model_account_order->getOrder_affiliate($order_id);
		if ($order_info) {
			$this->document->setTitle($this->language->get('text_order'));
			$data['heading_title'] = $this->language->get('text_invoice');
			$data['text_order_detail'] = $this->language->get('text_order_detail');
			$data['text_invoice_no'] = $this->language->get('text_invoice_no');
			$data['text_order_id'] = $this->language->get('text_order_id');
			$data['text_date_added'] = $this->language->get('text_date_added_affiliate');
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$data['text_shipping_address'] = $this->language->get('text_ship_to');
			$data['text_payment_method'] = $this->language->get('text_payment_method');
			$data['text_payment_address'] = $this->language->get('text_to');
			$data['text_history'] = $this->language->get('text_history');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_telephone'] = $this->language->get('text_telephone');
			$data['text_fax'] = $this->language->get('text_fax');
			$data['text_email'] = $this->language->get('text_email');
			$data['text_website'] = $this->language->get('text_website');
			$data['text_confirm_invoice'] = $this->language->get('text_confirm_invoice');
			$data['text_change_invoice'] = $this->language->get('text_change_invoice');
			$data['text_reject_invoice'] = $this->language->get('text_reject_invoice');
			$data['text_reciever'] = $this->language->get('text_reciever');
			$data['text_approve_invoice'] = $this->language->get('text_approve_invoice');
			$data['text_approve_invoice_name'] = $this->language->get('text_approve_invoice_name');
						
			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price_affiliate');
			$data['column_total'] = $this->language->get('column_total_affiliate');
			$data['column_action'] = $this->language->get('column_action');
			$data['column_date_added'] = $this->language->get('column_date_added');
			$data['column_status'] = $this->language->get('column_status');
			// add
			//$order_tracking_status_id = $data['column_status'];
			//
			$data['column_comment'] = $this->language->get('column_comment');

			$data['button_reorder'] = $this->language->get('button_reorder');
			$data['button_return'] = $this->language->get('button_return');
			$data['button_continue'] = $this->language->get('button_continue');

			if (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];

				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}
			$store_affiliate = $this->model_affiliate_order->getAffiliate($this->request->get['affiliate_id']);
			if($store_affiliate){
				$data['cheque'] = $store_affiliate['cheque'];
			}
		//store
			if ($order_info['store_url']) {
				$data['store_url'] = $order_info['store_url'];
			} else {
				$data['store_url'] = '';
			}
			$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

			if ($store_info) {
				$data['store_name'] = $store_info['config_name'];
				$data['store_address'] = nl2br($store_info['config_address']);
				$data['store_email'] = $store_info['config_email'];
				$data['store_telephone'] = $store_info['config_telephone'];
				$data['store_fax'] = $store_info['config_fax'];
			} else {
				$data['store_name'] = $this->config->get('config_name');
				$data['store_address'] = $this->config->get('config_address');
				$data['store_email'] = $this->config->get('config_email');
				$data['store_telephone'] = $this->config->get('config_telephone');
				$data['store_fax'] = $this->config->get('config_fax');
			}
	   // store
			if ($order_info['invoice_no']) {
				$data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}

			$data['order_id'] = base64_decode($this->request->get['order_id']);
			$data['affiliate_id'] = base64_decode($this->request->get['affiliate_id']);
			//$data['order_id'] = $this->request->get['order_id'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));

			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}';// . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['payment_firstname'],
				'lastname'  => $order_info['payment_lastname'],
				'company'   => $order_info['payment_company'],
				'address_1' => $order_info['payment_address_1'],
				'address_2' => $order_info['payment_address_2'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
				'country'   => $order_info['payment_country']
			);

			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
			$data['order_status_id'] = $order_info['order_status_id'];
			$data['payment_method'] = $order_info['payment_method'];

			if ($order_info['shipping_address_format']) {
				$format = $order_info['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' ;//. "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['shipping_firstname'],
				'lastname'  => $order_info['shipping_lastname'],
				'company'   => $order_info['shipping_company'],
				'address_1' => $order_info['shipping_address_1'],
				'address_2' => $order_info['shipping_address_2'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
				'country'   => $order_info['shipping_country']
			);

			$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['shipping_method'] = $order_info['shipping_method'];

			$this->load->model('catalog/product');
			$this->load->model('tool/upload');

			// Products
			$data['products'] = array();

			$products = $this->model_account_order->getOrderProducts(base64_decode($this->request->get['order_id']));

			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_account_order->getOrderOptions(base64_decode($this->request->get['order_id']), $product['order_product_id']);

				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$product_info = $this->model_catalog_product->getProduct($product['product_id']);

				if ($product_info) {
					$reorder = $this->url->link('account/order/reorder', 'order_id=' . $order_id . '&order_product_id=' . $product['order_product_id'], 'SSL');
				} else {
					$reorder = '';
				}

				$data['products'][] = array(
					'name'     => $product['name'],
					'model'    => $product['model'],
					'option'   => $option_data,
					'quantity' => $product['quantity'],
					'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'reorder'  => $reorder,
					'return'   => $this->url->link('account/return/add', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], 'SSL')
				);
			}

			// Voucher
			$data['vouchers'] = array();

			$vouchers = $this->model_account_order->getOrderVouchers($this->request->get['order_id']);

			foreach ($vouchers as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}

			// Totals
			$data['totals'] = array();

			$totals = $this->model_account_order->getOrderTotals(base64_decode($this->request->get['order_id']));

			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
				);
			}

			$data['comment'] = nl2br($order_info['comment']);

			//text upload
		$this->load->language('affiliate/order');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_upload_head'] = $this->language->get('text_upload_head');		
		$data['text_loading'] = $this->language->get('text_loading');
		
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_filename'] = $this->language->get('entry_filename');
	
		$data['button_upload'] = $this->language->get('button_upload');
		$data['button_save'] = $this->language->get('button_save');	
			//file upload 
		if (isset($this->request->post['filename'])) {
			$data['filename'] = $this->request->post['filename'];
		} elseif (!empty($download_info)) {
			$data['filename'] = $download_info['filename'];
		} else {
			$data['filename'] = '';
		}
		if (isset($this->request->post['mask'])) {
			$data['mask'] = $this->request->post['mask'];
		} elseif (!empty($download_info)) {
			$data['mask'] = $download_info['mask'];
		} else {
			$data['mask'] = '';
		}
		if (isset($this->error['filename'])) {
			$data['error_filename'] = $this->error['filename'];
		} else {
			$data['error_filename'] = '';
		}		
		if (!isset($this->request->get['download_id'])) {		
			$data['action'] = $this->url->link('affiliate/order/confirm_pay','', 'SSL');
		}
			
		//koy fix template to default only! 26/5/2016
		/*if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/customer_tracking.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/affiliate/customer_tracking.tpl', $data));
		} else {*/
			$this->response->setOutput($this->load->view('default/template/affiliate/customer_tracking.tpl', $data));
		//}
	} 
}

}