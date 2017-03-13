<?php
class ControllerAccountCustomerpartnerSoldlist extends Controller {

	private $error = array();
	private $data = array();
	
	public function index() {

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/customerpartner/soldlist&product_id='.$this->request->get['product_id'], '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/customerpartner');

		$data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();	
			
		if(!$data['chkIsPartner'])
			$this->response->redirect($this->url->link('account/account'));

		if(isset($this->request->get['product_id']))
			$product_id = $this->request->get['product_id'];
		else
			$this->response->redirect($this->url->link('YouAreNotAuthorized'));

		$this->language->load('account/customerpartner/soldlist');
		$this->document->setTitle($this->language->get('heading_title'));
		
      	$data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),     	
        	'separator' => false
      	); 

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_productlist'),
			'href'      => $this->url->link('account/customerpartner/productlist', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_soldlist'),
			'href'      => $this->url->link('account/customerpartner/soldlist&product_id='.$product_id, '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['button_back'] = $this->language->get('button_back');
		$data['entry_wkorder'] = $this->language->get('entry_wkorder');
		$data['entry_wkcustomer'] = $this->language->get('entry_wkcustomer');
		$data['entry_wkqty'] = $this->language->get('entry_wkqty');
		$data['entry_wkprice'] = $this->language->get('entry_wkprice');
		$data['entry_wksold'] = $this->language->get('entry_wksold');
		$data['text_invoice'] = $this->language->get('text_invoice');
		$data['text_access'] = $this->language->get('text_access');
		$data['entry_transaction_status'] = $this->language->get('entry_transaction_status');

		if(isset($this->request->get['page'])){
			$page = $this->request->get['page'];
		}else{
			$page = 1;
		}

		if (isset($product_id)) {
			
			$data['product_id'] = $product_id;

			$orders = $this->model_account_customerpartner->getSellerOrdersByProduct($product_id,$page);

			$totalorders = $this->model_account_customerpartner->getSellerOrdersTotalByProduct($product_id);
			
			if($orders)
				foreach ($orders as $key => $value) {
					$orders[$key]['link'] = $this->url->link('account/customerpartner/orderinfo&order_id='.$value['order_id']);
					$orders[$key]['price'] = $this->currency->format($value['price']);
					if($value['paid_status'] == 1) {
						$orders[$key]['paid_status']	=	$this->language->get('text_paid');
					} else {
						$orders[$key]['paid_status']	=	$this->language->get('text_no_paid');
					}
				}	
			else
				$data['access_error'] = true;
				
			$url = '&product_id=' . $product_id;

			$pagination = new Pagination();
			$pagination->total = $totalorders;
			$pagination->page = $page;
			$pagination->limit = 10;
			$pagination->url = $this->url->link('account/customerpartner/soldlist', $url . '&page={page}', 'SSL');

			$data['pagination'] = $pagination->render();
			$data['results'] = sprintf($this->language->get('text_pagination'), ($totalorders) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($totalorders - 10)) ? $totalorders : ((($page - 1) * 10) + 10), $totalorders, ceil($totalorders / 10));			
			
			$data['orders'] = $orders;
						
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

			$data['back'] = $this->url->link('account/customerpartner/productlist', '', 'SSL');

			$data['isMember'] = true;
			if($this->config->get('wk_seller_group_status')) {
	      		$data['wk_seller_group_status'] = true;
	      		$this->load->model('account/customer_group');
				$isMember = $this->model_account_customer_group->getSellerMembershipGroup($this->customer->getId());
				if($isMember) {
					$allowedAccountMenu = $this->model_account_customer_group->getaccountMenu($isMember['gid']);
					if($allowedAccountMenu['value']) {
						$accountMenu = explode(',',$allowedAccountMenu['value']);
						if($accountMenu && !in_array('orderhistory:orderhistory', $accountMenu)) {
							$data['isMember'] = false;
						}
					}
				} else {
					$data['isMember'] = false;
				}
	      	}
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
							
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/soldlist.tpl')) {
				$this->response->setOutput($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/soldlist.tpl' , $data));			
			} else {
				$this->response->setOutput($this->load->view('default/template/account/customerpartner/soldlist.tpl' , $data));
			}

		}
	}
}
?>
