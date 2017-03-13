<?php    
class ControllerCustomerpartnerPartner extends Controller { 

	private $error = array();
	private $data = array();
  
  	public function index() {

		$this->load->language('customerpartner/partner');
		 
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('customerpartner/partner');
		
    	$this->getList();
  	}  
    
  	private function getList() {

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$filter_customer_group_id = $this->request->get['filter_customer_group_id'];
		} else {
			$filter_customer_group_id = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$filter_approved = $this->request->get['filter_approved'];
		} else {
			$filter_approved = null;
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = null;
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['view_all'])) {
			$filter_all = $this->request->get['view_all'];
		} else {
			$filter_all = 0;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'customer_id'; 
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
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

		if (isset($this->request->get['view_all'])) {
			$url .= '&view_all=' . $this->request->get['view_all'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['approve'] = $this->url->link('customerpartner/partner/approve', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (version_compare(VERSION, '2.1', '>=')) { 
			$this->data['insert'] = $this->url->link('customer/customer/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['insert'] = $this->url->link('sale/customer/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		}
		$this->data['delete'] = $this->url->link('customerpartner/partner/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['customers'] = array();

		$data = array(
			'filter_name'              => $filter_name, 
			'filter_email'             => $filter_email, 
			'filter_all'               => $filter_all, 
			'filter_customer_group_id' => $filter_customer_group_id, 
			'filter_status'            => $filter_status, 
			'filter_approved'          => $filter_approved, 
			'filter_date_added'        => $filter_date_added,
			'filter_ip'                => $filter_ip,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);		
		
		$customer_total = $this->model_customerpartner_partner->getTotalCustomers($data);
	
		$results = $this->model_customerpartner_partner->getCustomers($data);
 		
    	foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('customerpartner/partner/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'] . $url, 'SSL')
			);
			
			if($result['is_partner']){
				$is_partner = ($result['is_partner'] == 0) ? "Not Partner" : "Partner";
				$commission = $result['commission'];
			}
			else{
				$is_partner = "Normal customer";
				$commission = '';
			}
			
			$this->data['customers'][] = array(
				'customer_id'    => $result['customer_id'],
				'name'           => $result['name'],
				'email'          => $result['email'],
				'customer_group' => $result['customer_group'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'approved'       => ($result['approved'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'ip'             => $result['ip'],
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'       => isset($this->request->post['selected']) && in_array($result['customer_id'], $this->request->post['selected']),
				'action'         => $action,
				'is_partner'	 => $is_partner,
				'commission'	=>	$commission
			);
		}	

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');	
		$this->data['text_select'] = $this->language->get('text_select');	
		$this->data['text_default'] = $this->language->get('text_default');	
		$this->data['text_isnotpartner']=$this->language->get('text_isnotpartner');
		$this->data['text_ispartner']=$this->language->get('text_ispartner');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_view_requested']=$this->language->get('text_view_requested');
		$this->data['text_view_all'] = $this->language->get('text_view_all');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_login'] = $this->language->get('text_login');
		$this->data['text_view_partners'] = $this->language->get('text_view_partners');

		$this->data['entry_partner_commission'] = $this->language->get('entry_partner_commission');
		$this->data['entry_customer_type'] = $this->language->get('entry_customer_type');
		$this->data['entry_customer_type_info'] = $this->language->get('entry_customer_type_info');
        
        $this->data['column_sellerId'] = $this->language->get('column_sellerId');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_approved'] = $this->language->get('column_approved');
		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_login'] = $this->language->get('column_login');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_approve'] = $this->language->get('button_approve');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_create_seller'] = $this->language->get('button_create_seller');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->session->data['error_warning'])) {
			$this->error['warning'] = $this->session->data['error_warning'];
			unset($this->session->data['error_warning']);			
		}

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
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['view_all'])) {
			$url .= '&view_all=' . $this->request->get['view_all'];
		}
		
		$this->data['sort_customerId'] = $this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . '&sort=customer_id' . $url, 'SSL');
		$this->data['sort_name'] = $this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_email'] = $this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . '&sort=c.email' . $url, 'SSL');
		$this->data['sort_customer_group'] = $this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . '&sort=customer_group' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . '&sort=c.status' . $url, 'SSL');
		$this->data['sort_approved'] = $this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . '&sort=c.approved' . $url, 'SSL');
		$this->data['sort_ip'] = $this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . '&sort=c.ip' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['view_all'])) {
			$url .= '&view_all=' . $this->request->get['view_all'];
			$this->data['customer_type'] = $this->request->get['view_all'];
		}

		$pagination = new Pagination();
		$pagination->total = $customer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($customer_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($customer_total - $this->config->get('config_limit_admin'))) ? $customer_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $customer_total, ceil($customer_total / $this->config->get('config_limit_admin')));

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_customer_group_id'] = $filter_customer_group_id;
		$this->data['filter_status'] = $filter_status;
		$this->data['filter_approved'] = $filter_approved;
		$this->data['filter_ip'] = $filter_ip;
		$this->data['filter_date_added'] = $filter_date_added;
		$this->data['wk_viewall'] = $filter_all;

		if (version_compare(VERSION, '2.1', '>=')) {		
			$this->load->model('customer/customer_group');			
	    	$this->data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();			
		} else {		
			$this->load->model('sale/customer_group');			
	    	$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();			
		}

		$this->data['add']  = $this->url->link('customer/customer/add', 'token=' . $this->session->data['token'] . $url. '&create_seller', 'SSL');

		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->data['header'] = $this->load->controller('common/header');		
		$this->data['footer'] = $this->load->controller('common/footer');	
		$this->data['column_left'] = $this->load->controller('common/column_left');
		
		$this->response->setOutput($this->load->view('customerpartner/partner_list.tpl',$this->data));
		
  	}

  	public function delete() {

		$this->load->language('customerpartner/partner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customerpartner/partner');

		if (isset($this->request->post['selected']) && $this->validateForm()) {
			foreach ($this->request->post['selected'] as $customer_id) {
				$this->model_customerpartner_partner->deleteCustomer($customer_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}
			
			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}
					
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
				
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
													
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['view_all'])) {
				$url .= '&view_all=' . $this->request->get['view_all'];
			}			

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function approve() {

		$this->load->language('customerpartner/partner');
    	
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('customerpartner/partner');
		
		if (!$this->user->hasPermission('modify', 'customerpartner/partner')) {
			$this->error['warning'] = $this->language->get('error_permission');

		} elseif (isset($this->request->post['selected'])) {

			$approved = $setstatus = 0;
			
			foreach ($this->request->post['selected'] as $customer_id) {	
				
				if(isset($this->request->get['set_status']))
					$setstatus = $this->request->get['set_status'];

				$customer_info = $this->model_customerpartner_partner->approve($customer_id,$setstatus);

				$approved++;
				
				//to do send mail to seller after set status..
			} 
			
			$this->session->data['success'] = sprintf($this->language->get('text_approved'), $approved);	
			
			$url = '';
		
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}
				
			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}
						
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

			if (isset($this->request->get['view_all'])) {
				$url .= '&view_all=' . $this->request->get['view_all'];
			}


			$this->response->redirect($this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
					
		}
		
		$this->getList();
	} 
   
  	public function update() {

		$this->load->language('customerpartner/partner');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('customerpartner/partner');

		if (version_compare(VERSION, '2.1', '>=')) {		
			$this->load->language('customer/customer');
			$this->load->model('customer/customer');			
		} else {		
			$this->load->language('sale/customer');
			$this->load->model('sale/customer');			
		}
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
    		
			//for mp
			$this->model_customerpartner_partner->updatePartner($this->request->get['customer_id'],$this->request->post);

			if(isset($this->request->post['product_ids']) AND $this->request->post['product_ids']){
				$this->model_customerpartner_partner->addproduct($this->request->get['customer_id'],$this->request->post);			
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}
			
			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}
					
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
			
			$this->response->redirect($this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	} 
  
  	private function getForm() {

    	$this->data['heading_title'] = $this->language->get('text_form');
 	
		$this->data['text_form'] = $this->language->get('text_form');		 	
    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
    	$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_add_blacklist'] = $this->language->get('text_add_blacklist');
		$this->data['text_loading'] = $this->language->get('text_loading');
		$this->data['text_no_product_assign'] = $this->language->get('text_no_product_assign');
		
		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_company'] = $this->language->get('entry_company');
 		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_amount'] = $this->language->get('entry_amount');

		$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_transaction'] = $this->language->get('button_transaction_add');
    	$this->data['button_remove'] = $this->language->get('button_remove');
	
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_address'] = $this->language->get('tab_address');
		$this->data['tab_transaction'] = $this->language->get('tab_transaction');
		$this->data['tab_reward'] = $this->language->get('tab_reward');
		$this->data['tab_order'] = $this->language->get('tab_order');

		//from partner language
 		$this->data['entry_partner_commission'] = $this->language->get('entry_partner_commission');
		$this->data['entry_quantity_sold'] = $this->language->get('entry_quantity_sold');
		$this->data['entry_income'] = $this->language->get('entry_income');
		$this->data['entry_partner_income'] = $this->language->get('entry_partner_income');
		$this->data['entry_admin_income'] = $this->language->get('entry_admin_income');
		$this->data['entry_total_paid'] = $this->language->get('entry_total_paid');
		$this->data['entry_left_paid'] = $this->language->get('entry_left_paid');		
		$this->data['entry_product_id'] = $this->language->get('entry_product_id');
		$this->data['entry_commission'] = $this->language->get('entry_commission');
 		$this->data['entry_paypalid'] = $this->language->get('entry_paypalid');
 		$this->data['entry_otherinfo'] = $this->language->get('entry_otherinfo');

 		$this->data['entry_screenname'] = $this->language->get('entry_screenname');
		$this->data['entry_gender'] = $this->language->get('entry_gender');
		$this->data['entry_profile'] = $this->language->get('entry_profile');
		$this->data['entry_store'] = $this->language->get('entry_store');		
		$this->data['entry_twitter'] = $this->language->get('entry_twitter');
		$this->data['entry_facebook'] = $this->language->get('entry_facebook');
 		$this->data['entry_theme'] = $this->language->get('entry_theme');
 		$this->data['entry_banner'] = $this->language->get('entry_banner');
 		$this->data['entry_logo'] = $this->language->get('entry_logo');
		$this->data['entry_avatar'] = $this->language->get('entry_avatar');
 		$this->data['entry_locality'] = $this->language->get('entry_locality');
 		$this->data['entry_country'] = $this->language->get('entry_country'); 		
 		$this->data['entry_total'] = $this->language->get('entry_total');
 		$this->data['entry_products'] = $this->language->get('entry_products');
 		$this->data['entry_banner_info'] = $this->language->get('entry_banner_info');
 		$this->data['entry_logo_info'] = $this->language->get('entry_logo_info');
 		$this->data['entry_screenname_info'] = $this->language->get('entry_screenname_info');
 		$this->data['entry_avatar_info'] = $this->language->get('entry_avatar_info');

 		$this->data['entry_name'] = $this->language->get('entry_name');
 		$this->data['entry_orderid'] = $this->language->get('entry_orderid');
		$this->data['text_edit'] = $this->language->get('text_edit');
 		$this->data['text_view'] = $this->language->get('text_view');

		$this->data['tab_info'] = $this->language->get('tab_info');
		$this->data['tab_location'] = $this->language->get('tab_location');
		$this->data['tab_commission'] = $this->language->get('tab_commission');
		$this->data['tab_transaction_info'] = $this->language->get('tab_transaction_info');
		$this->data['tab_profile_info'] = $this->language->get('tab_profile_info');
		$this->data['tab_order_info'] = $this->language->get('tab_order_info');
		$this->data['tab_commission_info'] = $this->language->get('tab_commission_info');
		$this->data['entry_product_id_info'] = $this->language->get('entry_product_id_info');

		$this->data['tab_product'] = $this->language->get('tab_product');
		$this->data['tab_product_info'] = $this->language->get('tab_product_info');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['customer_id'])) {
			$this->data['customer_id'] = $this->request->get['customer_id'];
		} else {
			$this->data['customer_id'] = 0;
		}

		$this->data['admin_products'] = $this->model_customerpartner_partner->getAdminProducts($this->data['customer_id']);

		if (isset($this->request->post['product_ids'])) {
			$this->data['product_ids'] = $this->request->post['product_ids'];
		}else{
			$this->data['product_ids'] = array();
		}

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$url = '';
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		if (isset($this->data['customer_id']))
			$this->data['action'] = $this->url->link('customerpartner/partner/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->data['customer_id'] . $url, 'SSL');		
		  
    	$this->data['cancel'] = $this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$partner_info = $this->model_customerpartner_partner->getPartner($this->data['customer_id']);   	

    	if($partner_info){

    		$this->data['partner_orders'] = $this->model_customerpartner_partner->getSellerOrders($this->request->get['customer_id']);
    		
    		foreach ($this->data['partner_orders'] as $key => $value) {	    		

    			$products = $this->model_customerpartner_partner->getSellerOrderProducts($value['order_id']);

				$this->data['partner_orders'][$key]['productname'] = '';
				$this->data['partner_orders'][$key]['total'] = 0;

				if($products){
					foreach ($products as $key2 => $value) {
						$this->data['partner_orders'][$key]['productname'] = $this->data['partner_orders'][$key]['productname'].$value['name'].' x '.$value['quantity'].' , ';
						$this->data['partner_orders'][$key]['total'] += $value['c2oprice'];
					}
				}

				$this->data['partner_orders'][$key]['total'] = $this->currency->format($this->data['partner_orders'][$key]['total'] ,$this->config->get('config_currency_id'));

				$this->data['partner_orders'][$key]['view'] = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id='.$value['order_id'], 'SSL');
    			$this->data['partner_orders'][$key]['edit'] = $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&order_id='.$value['order_id'], 'SSL');
    		}

    		$this->load->model('tool/image');
    		$this->data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

    		foreach ($partner_info as $key => $value) {

    			$this->data[$key] = $value;

    			if($key=='avatar' || $key=='companylogo' || $key=='companybanner'){

    				if(is_file(DIR_IMAGE.$value))
						$this->data[$key.'_placeholder'] = $this->model_tool_image->resize($value, 100, 100);
					else
						$this->data[$key.'_placeholder'] = $this->data['placeholder'];
    			}
    			
    		} 
			
			$this->data['loadLocation'] = $this->url->link('customerpartner/partner/loadLocation&location='.$partner_info['companylocality'].'&token='. $this->session->data['token'] ,'SSL');

    		$this->data['partner_amount'] = $this->sellerCommission($partner_info['commission']);

    	}else{
    		$this->session->data['error_warning'] = $this->language->get('error_seller');
			$this->response->redirect($this->url->link('customerpartner/partner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
		
		if (isset($this->request->post['commission'])) {
      		$this->data['commission'] = $this->request->post['commission'];
    	} elseif (!empty($partner_info)) { 
			$this->data['commission'] = $partner_info['commission'];
		} else {
      		$this->data['commission'] = '';
    	}

    	if (isset($this->request->post['paypalid'])) {
      		$this->data['paypalid'] = $this->request->post['paypalid'];
    	} elseif (!empty($partner_info)) { 
			$this->data['paypalid'] = $partner_info['paypalid'];
		} else {
      		$this->data['paypalid'] = '';
    	}
    	
    	if (isset($this->request->post['otherpayment'])) {
      		$this->data['otherpayment'] = $this->request->post['otherpayment'];
    	} elseif (!empty($partner_info)) { 
			$this->data['otherpayment'] = $partner_info['otherpayment'];
		} else {
      		$this->data['otherpayment'] = '';
    	}
		
    	$this->data['transactionTab'] = $this->url->link('customerpartner/transaction/addtransaction','token='.$this->session->data['token'].'seller_id='.$this->request->get['customer_id'].'action=partner' , 'SSL');

		$this->load->model('localisation/country');		
		$this->data['countries'] = $this->model_localisation_country->getCountries();

		$this->data['header'] = $this->load->controller('common/header');		
		$this->data['footer'] = $this->load->controller('common/footer');	
		$this->data['column_left'] = $this->load->controller('common/column_left');
				
		$this->response->setOutput($this->load->view('customerpartner/partner_form.tpl',$this->data));
	}

  	public function transaction() {

		$this->language->load('customerpartner/partner');

		$this->load->model('customerpartner/partner');
		$this->load->model('customerpartner/transaction');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'customerpartner/partner')){		 
			$this->model_customerpartner_transaction->addPartnerTransaction($this->request->get['customer_id'], $this->request->post['description'], $this->request->post['amount']);

			$this->data['success'] = $this->language->get('text_success');
		} else {
			$this->data['success'] = '';
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->user->hasPermission('modify', 'customerpartner/partner')) {
			$this->data['error_warning'] = $this->language->get('error_permission');
		} else {
			$this->data['error_warning'] = '';
		}		

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_balance'] = $this->language->get('text_balance');

		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_description'] = $this->language->get('column_description');
		$this->data['column_amount'] = $this->language->get('column_amount');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  

		$this->data['transactions'] = array();

		$results = $this->model_customerpartner_transaction->getTransactions($this->request->get['customer_id'], ($page - 1) * $this->config->get('config_limit_admin'), $this->config->get('config_limit_admin'));

		foreach ($results as $result) {
			$this->data['transactions'][] = array(
				'amount'      => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'description' => $result['details'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$this->data['balance'] = $this->currency->format($this->model_customerpartner_transaction->getTransactionTotal($this->request->get['customer_id']), $this->config->get('config_currency'));

		$transaction_total = $this->model_customerpartner_transaction->getTotalTransactions($this->request->get['customer_id']);

		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('customerpartner/partner/transaction', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'), ($transaction_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($transaction_total - $this->config->get('config_limit_admin'))) ? $transaction_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $transaction_total, ceil($transaction_total / $this->config->get('config_limit_admin')));

		if (version_compare(VERSION, '2.1', '>=')) {
			$this->response->setOutput($this->load->view('customer/customer_transaction.tpl', $this->data));
		} else {
			$this->response->setOutput($this->load->view('sale/customer_transaction.tpl', $this->data));
		}

	} 

	public function autocomplete() {

		$json = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_email'])) {

			$this->load->model('customerpartner/partner');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_view'])) {
				$filter_view = $this->request->get['filter_view'];
			} else {
				$filter_view = 0 ;
			}
						
			if (isset($this->request->get['filter_email'])) {
				$filter_email = $this->request->get['filter_email'];
			} else {
				$filter_email = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_name'         => $filter_name,
				'filter_all'         => $filter_view,
				'filter_email'  	  => $filter_email,
				'start'               => 0,
				'limit'               => $limit
			);
			
			$results = $this->model_customerpartner_partner->getCustomers($data);
			
			foreach ($results as $result) {

				$option_data = array();				
					
				$json[] = array(
					'id' 		 => $result['customer_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),	
					'email'      => $result['email'],
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	public function updateProductSeller() {

		$json = array();
		
		$this->language->load('customerpartner/partner');
		
		if ($this->validateForm() AND isset($this->request->get['product_id']) AND isset($this->request->get['partner_id'])) {

			$this->load->model('customerpartner/partner');
			
			$results = $this->model_customerpartner_partner->updateProductSeller($this->request->get['partner_id'],$this->request->get['product_id']);

			$json['success'] = $this->language->get('text_success_seller');

		}elseif(isset($this->error['warning'])){
			$json['success'] = $this->error['warning'];			
		}

		$this->response->setOutput(json_encode($json));
	}

	public function sellerCommission($commission = 0){

		//get commission for seller
		$this->load->model('customerpartner/partner');
		$partner_amount = $this->model_customerpartner_partner->getPartnerAmount($this->request->get['customer_id']);

		if($partner_amount){
			$total = $partner_amount['total'];
			$admin_part = $partner_amount['admin'];
			$partner_part = $partner_amount['customer'];
			$paid = $partner_amount['paid'];    			
			$left = $partner_part - $partner_amount['paid'];	    			

			$partner_amount = array(
				'commission' => $commission,
				'qty_sold' => $partner_amount['quantity'] ? $partner_amount['quantity'] : ' 0 ',
				'total' => $this->currency->format($total ,$this->config->get('config_currency_id')) ,
				'paid' => $this->currency->format($paid ,$this->config->get('config_currency_id')) ,
				'left_amount' => $this->currency->format($left, $this->config->get('config_currency_id')) ,
				'admin_amount' => $this->currency->format($admin_part,$this->config->get('config_currency_id')), 
				'partner_amount' => $this->currency->format($partner_part,$this->config->get('config_currency_id')),
			);
		}

		$this->response->setOutput(json_encode($partner_amount));		

		// return $partner_amount;
	}

	private function validateForm() {

    	if (!$this->user->hasPermission('modify', 'customerpartner/partner')) {
      		$this->error['warning'] = $this->language->get('error_permission');
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

  	//for location tab
	public function loadLocation(){

		if($this->request->get['location']){
			$location = '<iframe id="seller-location" width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q='.$this->request->get['location'].'&amp;output=embed"></iframe>';

			$this->response->setOutput($location);
		}else{
			$this->response->setOutput('No location added by Seller.');
		}
	} 
	
}
?>