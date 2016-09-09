<?php
class ControllerAffiliateStock extends Controller {
public function index() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/stock', '', 'SSL');
			$this->response->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}
		$this->load->language('affiliate/stock');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('affiliate/stock');
		$this->getList();
}
protected function getList() {
	//-------------load model  outside controller
	/* global $loader, $registry;
    $loader->model('catalog/product');
    $model = $registry->get('model_catalog_product');
    */
    //---------------default value---------------------
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
		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.quantity';
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
		

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		
		 $data['products'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_model'	  => $filter_model,
			'filter_quantity' => $filter_quantity,
			'sort'            => $sort,
			'order'           => $order,
			'start' => ($page - 1) * 10,
			'limit' => 10
		);	
	 //---------------default value---------------------		
		$this->load->model('affiliate/stock');
		$this->load->model('tool/image');
		
		//---load model 
		$product_total = $this->model_affiliate_stock->getTotalProducts($filter_data);
		
		$results = $this->model_affiliate_stock->getProducts($filter_data);
		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}
			$special = false;
			$product_specials = $this->model_affiliate_stock->getProductSpecials($result['product_id']);
			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time())) {
					$special = $product_special['price'];

					break;
				}
			}
			$data['products'][] = array(
				'product_id' => $result['product_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'model'      => $result['model'],
				'price'      => $result['price'],
				'special'    => $special,
				'quantity'   => $result['quantity'],
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled')
			);
		}		
		
		
  //------- url sort data---------------
		$url = '';
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_name'] = $this->url->link('affiliate/stock','sort=pd.name' . $url, 'SSL');
		$data['sort_model'] = $this->url->link('affiliate/stock','sort=p.model' . $url, 'SSL');
		$data['sort_price'] = $this->url->link('affiliate/stock','sort=p.price' . $url, 'SSL');
		$data['sort_quantity'] = $this->url->link('affiliate/stock','sort=p.quantity' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('affiliate/stock','sort=p.status' . $url, 'SSL');
		$data['sort_order'] = $this->url->link('affiliate/stock','sort=p.sort_order' . $url, 'SSL');
  //------- url sort data---------------
  //------- url Pagination --------------- 
		$url = '';
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
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

		$pagination->url = $this->url->link('affiliate/stock', $url. '&page={page}', 'SSL');
   //------- url Pagination --------------- 
   		$this->load->language('affiliate/stock');
   		
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
			'text' => $this->language->get('text_stock'),
			'href' => $this->url->link('affiliate/stock', '', 'SSL')
		);
   		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_list'] = $this->language->get('text_list');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_model'] = $this->language->get('entry_model');
		
		$data['button_filter'] = $this->language->get('button_filter');
		
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($product_total - 10)) ? $product_total : ((($page - 1) * 10) + 10), $product_total, ceil($product_total / 10));		
		
		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_no_results'] = $this->language->get('text_no_results');
		
		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_status'] = $this->language->get('column_status');
		
		
		//-------nid 01/04/2016------
		$this->load->language('module/affiliate');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_order_approve'] = $this->language->get('text_order_approve');
		$data['text_order_status'] = $this->language->get('text_order_status');
		$data['text_complete_status'] = $this->language->get('text_complete_status');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_stock'] = $this->language->get('text_stock');
		//---------------------------
		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['header'] = $this->load->controller('common/headeraff');
		//$data['column_left'] = $this->load->controller('common/column_left');
		//$data['column_right'] = $this->load->controller('common/column_right');
		$data['column_left'] = $this->load->controller('common/column_leftaff');
		$data['column_right'] = $this->load->controller('common/column_rightaff');
		
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
							
		//koy fix template to default only! 26/5/2016
		/*if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/stock.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/affiliate/stock.tpl', $data));
		} else {*/
			$this->response->setOutput($this->load->view('default/template/affiliate/stock.tpl', $data));
		//}
}
public function autocomplete() {
 	//-------------load model  outside controller
			/*global $loader, $registry;
		    $loader->model('catalog/option');
		    $model = $registry->get('model_catalog_option');   */
		    	 global $loader, $registry;
    $loader->model('affiliate/option');
    $model = $registry->get('model_affiliate_option');
		$json = array();			
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			echo $this->request->get['filter_name'];
			$this->load->model('affiliate/stock');
		

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}
			
			// one add - begin
			if (isset($this->request->get['filter_affiliate_id'])) {
				$filter_affiliate_id = $this->request->get['filter_affiliate_id'];
			} else {
				$filter_affiliate_id = '';
			}						
			// one add - end
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 10;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_affiliate_stock->getProducts($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$product_options = $this->model_affiliate_stock->getProductOptions($result['product_id']);

				foreach ($product_options as $product_option) {
					$option_info = $model->getOption($product_option['option_id']);

					if ($option_info) {
						$product_option_value_data = array();

						foreach ($product_option['product_option_value'] as $product_option_value) {
							$option_value_info = $model->getOptionValue($product_option_value['option_value_id']);

							if ($option_value_info) {
								$product_option_value_data[] = array(
									'product_option_value_id' => $product_option_value['product_option_value_id'],
									'option_value_id'         => $product_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $product_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'product_option_id'    => $product_option['product_option_id'],
							'product_option_value' => $product_option_value_data,
							'option_id'            => $product_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $product_option['value'],
							'required'             => $product_option['required']
						);
					}
				}

				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);
			}
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}		
}