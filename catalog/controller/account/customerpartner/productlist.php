<?php
class ControllerAccountCustomerpartnerProductlist extends Controller {

	private $error = array();
	private $data = array();

	public function index() {

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/customerpartner/productlist', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/customerpartner');

		$this->data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();

		if(!$this->data['chkIsPartner'])
			$this->response->redirect($this->url->link('account/account'));

		$this->document->addStyle('catalog/view/theme/default/stylesheet/MP/sell.css');	
		
		$this->language->load('account/customerpartner/addproduct');

		$this->document->setTitle($this->language->get('heading_title_productlist'));		

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
        	'text'      => $this->language->get('heading_title_productlist'),
			'href'      => $this->url->link('account/customerpartner/productlist', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}		

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

		if($this->config->get('wkmpuseseo'))
			$url = '';

		/**
		 * Memberhship code
		 */
		$this->data['wk_seller_group_publish_unpublish_product'] = false;
		if($this->config->get('wk_seller_group_publish_unpublish_product')) {
			$this->data['wk_seller_group_publish_unpublish_product'] = true;
		}
		/**/

		$this->data['insert'] = $this->url->link('account/customerpartner/addproduct', '' , 'SSL');
		// $this->data['copy'] = $this->url->link('account/customerpartner/productlist/copy', '' . $url, 'SSL');	
		$this->data['delete'] = $this->url->link('account/customerpartner/productlist/delete', '' . $url, 'SSL');

		$data = array(
			'filter_name'	  => $filter_name, 
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * 10,
			'limit'           => 10
		);

		if (isset($this->request->get['low_stock'])) {
			$data['filter_low_stock'] = true;
		}

		$this->load->model('tool/image');

		$product_total = $this->model_account_customerpartner->getTotalProductsSeller($data);

		$results = $this->model_account_customerpartner->getProductsSeller($data);

		foreach ($results as $key => $result) {

			if(!$results[$key]['product_id'])
				$results[$key]['product_id'] = $result['product_id'] = $key;

			$action = array();
            
             // membership codes starts here
			if($this->config->get('wk_seller_group_status')) {
				$action[] = array(
					'text_edit' => $this->language->get('text_edit'),
					'text_relist' => $this->language->get('text_relist'),
					'text_publish' => $this->language->get('text_publish'),
					'text_unpublish' => $this->language->get('text_unpublish'),
					'text_clone_product' => $this->language->get('text_clone_product'),
					'href_edit' => $this->url->link('account/customerpartner/addproduct', '' . '&edit&product_id=' . $result['product_id'] , 'SSL'),
					'href_relist' => $this->url->link('account/customerpartner/addproduct', '' . '&relist&product_id=' . $result['product_id'] , 'SSL'),
					'href_active_deactive' => $this->url->link('account/customerpartner/addproduct', '' . '&active_deactive&product_id=' . $result['product_id'] , 'SSL'),
					'href_clone' => $this->url->link('account/customerpartner/addproduct', '' . '&clone&product_id=' . $result['product_id'] , 'SSL'),
					'href_publish' => $this->url->link('account/customerpartner/productlist/publish', '' . '&product_id=' . $result['product_id'] , 'SSL'),
					'href_unpublish' => $this->url->link('account/customerpartner/productlist/unpublish', '' . '&product_id=' . $result['product_id'] , 'SSL'),
				);
			} else {
				$action[] = array(
					'text' => $this->language->get('text_edit'),
					'href' => $this->url->link('account/customerpartner/addproduct', '' . '&product_id=' . $result['product_id'] , 'SSL')
				);
			}

			 // membership codes ends here

			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$thumb = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$thumb = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}	
			
			$product_sold_quantity = array();
			$sold = $totalearn = 0;

			$product_sold_quantity = $this->model_account_customerpartner->getProductSoldQuantity($result['product_id']);

			if($product_sold_quantity){
				$sold = $product_sold_quantity['quantity'] ? $product_sold_quantity['quantity'] : 0;
				$totalearn = $product_sold_quantity['total'] ? $product_sold_quantity['total'] : 0;
			}
			$results[$key]['price'] = $this->currency->format($result['price']);
			$results[$key]['special'] = $result['special'] ? $this->currency->format($result['special']): '';
			$results[$key]['thumb'] = $thumb;
			$results[$key]['sold'] = $sold;
			$results[$key]['soldlink'] = $this->url->link('account/customerpartner/soldlist&product_id='.$result['product_id'],'','SSL');
			$results[$key]['totalearn'] = $this->currency->format($totalearn);
			$results[$key]['selected'] =  isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected']);
			$results[$key]['totalearn'] = $this->currency->format($totalearn);
			$results[$key]['action'] = $action;
			$results[$key]['productLink'] = $this->url->link('product/product' , 'product_id='.$key, 'SSL');
		}

		$this->data['products'] = $results;

		$this->data['heading_title'] = $this->language->get('heading_title_productlist');
		$this->data['text_enabled'] = $this->language->get('text_enabled');		
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');		
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');	
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_soldlist_info'] = $this->language->get('text_soldlist_info');		
		$this->data['column_image'] = $this->language->get('column_image');		
		$this->data['column_name'] = $this->language->get('column_name');		
		$this->data['column_model'] = $this->language->get('column_model');		
		$this->data['column_price'] = $this->language->get('column_price');		
		$this->data['column_quantity'] = $this->language->get('column_quantity');		
		$this->data['column_status'] = $this->language->get('column_status');		
		$this->data['column_action'] = $this->language->get('column_action');	
		$this->data['column_earned'] = $this->language->get('column_earned');		
		$this->data['column_sold'] = $this->language->get('column_sold');	
		$this->data['button_copy'] = $this->language->get('button_copy');		
		$this->data['button_insert'] = $this->language->get('button_insert');		
		$this->data['button_delete'] = $this->language->get('button_delete');		
		$this->data['button_filter'] = $this->language->get('button_filter');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['warning'])) {
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('account/customerpartner/productlist', '' . '&sort=pd.name' . $url, 'SSL');
		$this->data['sort_model'] = $this->url->link('account/customerpartner/productlist', '' . '&sort=p.model' . $url, 'SSL');
		$this->data['sort_price'] = $this->url->link('account/customerpartner/productlist', '' . '&sort=p.price' . $url, 'SSL');
		$this->data['sort_quantity'] = $this->url->link('account/customerpartner/productlist', '' . '&sort=p.quantity' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('account/customerpartner/productlist', '' . '&sort=p.status' . $url, 'SSL');
		$this->data['sort_order'] = $this->url->link('account/customerpartner/productlist', '' . '&sort=p.sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/customerpartner/productlist', '' . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($product_total - 10)) ? $product_total : ((($page - 1) * 10) + 10), $product_total, ceil($product_total / 10));

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_model'] = $filter_model;
		$this->data['filter_price'] = $filter_price;
		$this->data['filter_quantity'] = $filter_quantity;
		$this->data['filter_status'] = $filter_status;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->data['back'] = $this->url->link('account/account', '', 'SSL');

		$this->data['isMember'] = true;
		 // membership codes starts here
		if($this->config->get('wk_seller_group_status')) {
      		$this->data['wk_seller_group_status'] = true;
      		$this->load->model('account/customer_group');
			$isMember = $this->model_account_customer_group->getSellerMembershipGroup($this->customer->getId());
			if($isMember) {
				$allowedAccountMenu = $this->model_account_customer_group->getaccountMenu($isMember['gid']);
				if($allowedAccountMenu['value']) {
					$accountMenu = explode(',',$allowedAccountMenu['value']);
					if($accountMenu && !in_array('productlist:productlist', $accountMenu)) {
						$this->data['isMember'] = false;
					}
				}
			} else {
				$this->data['isMember'] = false;
			}
      	} else {
      		if(!in_array('productlist', $this->config->get('marketplace_allowed_account_menu'))) {
      			$this->response->redirect($this->url->link('account/account','', 'SSL'));
      		}
      	}
      	 // membership codes ends here

		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['column_right'] = $this->load->controller('common/column_right');
		$this->data['content_top'] = $this->load->controller('common/content_top');
		$this->data['content_bottom'] = $this->load->controller('common/content_bottom');
		$this->data['footer'] = $this->load->controller('common/footer');
		$this->data['header'] = $this->load->controller('common/header');
						
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/productlist.tpl')) {
			$this->response->setOutput($this->load->view( $this->config->get('config_template') . '/template/account/customerpartner/productlist.tpl' , $this->data));			
		} else {
			$this->response->setOutput($this->load->view('default/template/account/customerpartner/productlist.tpl' , $this->data));
		}

	}

	public function copy() {

		$this->language->load('account/customerpartner/addproduct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/customerpartner');

		if (isset($this->request->post['selected']) && $this->validate()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_account_customerpartner->copyProduct($product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('account/customerpartner/productlist', '' . $url, 'SSL'));
		}

		$this->index();
	}

	public function delete() {

		$this->load->language('account/customerpartner/productlist'); 

		$this->document->setTitle($this->language->get('heading_title_productlist'));

		$this->load->model('account/customerpartner');
		
		if (isset($this->request->post['selected']) && $this->validate()) {
			
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_account_customerpartner->deleteProduct($product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('account/customerpartner/productlist', '' . $url, 'SSL'));
		}

		$this->index();
	}

  	private function validate() {

  		$this->load->language('account/customerpartner/addproduct');

    	if (!$this->customer->getId()) {    		
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

  	public function publish(){

  	    $this->load->model('account/customerpartner');

  		$this->model_account_customerpartner->publishProduct($this->request->get['product_id']);

  		$this->response->redirect($this->url->link('account/customerpartner/productlist'));
  	}

  	public function unpublish(){
  		$this->load->model('account/customerpartner');

  		$this->model_account_customerpartner->unpublishProduct($this->request->get['product_id']);

  		$this->response->redirect($this->url->link('account/customerpartner/productlist'));
  	}
}
?>
