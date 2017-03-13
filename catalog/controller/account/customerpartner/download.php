<?php
class ControllerAccountCustomerpartnerDownload extends Controller {

	private $error = array();

	public function index() {

		if (!$this->customer->isLogged()) {
			$this->session->data['response'] = $this->url->link('account/customerpartner/download', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/customerpartner');

		$data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();
		
		if(!$data['chkIsPartner'])
			$this->response->redirect($this->url->link('account/account'));

		$this->language->load('account/customerpartner/download');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/customerpartner');

		$this->getList($data);
	}

	public function insert() {
		
		if (!$this->customer->isLogged()) {
			$this->session->data['response'] = $this->url->link('account/customerpartner/download/insert', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/customerpartner');

		$data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();

		if(!$data['chkIsPartner'])
			$this->response->redirect($this->url->link('account/account'));

		$this->language->load('account/customerpartner/download');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_account_customerpartner->addDownload($this->request->post);

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

			$this->response->redirect($this->url->link('account/customerpartner/download', '' . $url, 'SSL'));
		}

		$this->getForm($data);
	}

	public function update() {

		if (!$this->customer->isLogged()) {
			$this->session->data['response'] = $this->url->link('account/customerpartner/download/update', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/customerpartner');

		$data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();	
			
		if(!$data['chkIsPartner'])
			$this->response->redirect($this->url->link('account/account'));

		$this->language->load('account/customerpartner/download');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_account_customerpartner->editDownload($this->request->get['download_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('account/customerpartner/download', '' . $url, 'SSL'));
		}

		$this->getForm($data);
	}

	public function delete() {

		$this->language->load('account/customerpartner/download');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/customerpartner');

		$data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			
			foreach ($this->request->post['selected'] as $download_id) {
				$this->model_account_customerpartner->deleteDownload($download_id);
			}

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
			
			$this->response->redirect($this->url->link('account/customerpartner/download', '' . $url, 'SSL'));
		}

		$this->getList($data);
	}

	protected function getList($data) {
		
		$this->document->addStyle('catalog/view/theme/default/stylesheet/MP/sell.css');	

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'dd.name';
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

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL')			
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '' . $url, 'SSL')			
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/customerpartner/download', '' . $url, 'SSL')			
		);
		$data['chkIsPartner'] = $this->model_account_customerpartner->chkIsPartner();
		$data['insert'] = $this->url->link('account/customerpartner/download/insert', '' . $url, 'SSL');
		$data['delete'] = $this->url->link('account/customerpartner/download/delete', '' . $url, 'SSL');

		$data['downloads'] = array();

		$data['sorting'] = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * 10,
			'limit' => 10
		);

		$download_total = $this->model_account_customerpartner->getTotalDownloads();

		$results = $this->model_account_customerpartner->getDownloads($data['sorting']);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('account/customerpartner/download/update', '' . '&download_id=' . $result['download_id'] . $url, 'SSL')
			);

			$data['downloads'][] = array(
				'download_id' => $result['download_id'],
				'name'        => $result['name'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['download_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_remaining'] = $this->language->get('column_remaining');
		$data['column_action'] = $this->language->get('column_action');
		$data['text_downloadableItems'] = $this->language->get('text_downloadableItems');
		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_delete'] = $this->language->get('button_delete');

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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('account/customerpartner/download', '' . '&sort=dd.name' . $url, 'SSL');		

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $download_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/customerpartner/download', '' . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($download_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($download_total - 10)) ? $download_total : ((($page - 1) * 10) + 10), $download_total, ceil($download_total / 10));

		$data['sort'] = $sort;
		$data['order'] = $order;
		
		$data['isMember'] = true;
		if($this->config->get('wk_seller_group_status')) {
      		$data['wk_seller_group_status'] = true;
      		$this->load->model('account/customer_group');
			$isMember = $this->model_account_customer_group->getSellerMembershipGroup($this->customer->getId());
			if($isMember) {
				$allowedAccountMenu = $this->model_account_customer_group->getaccountMenu($isMember['gid']);
				if($allowedAccountMenu['value']) {
					$accountMenu = explode(',',$allowedAccountMenu['value']);
					if($accountMenu && !in_array('downloads:downloads', $accountMenu)) {
						$data['isMember'] = false;
					}
				}
			} else {
				$data['isMember'] = false;
			}
      	} else {
      		if(!in_array('downloads', $this->config->get('marketplace_allowed_account_menu'))) {
      			$this->response->redirect($this->url->link('account/account','', 'SSL'));
      		}
      	}

		$data['column_left'] = $this->load->Controller('common/column_left');
		$data['column_right'] = $this->load->Controller('common/column_right');
		$data['content_top'] = $this->load->Controller('common/content_top');
		$data['content_bottom'] = $this->load->Controller('common/content_bottom');
		$data['footer'] = $this->load->Controller('common/footer');		
		$data['header'] = $this->load->Controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/download_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/customerpartner/download_list.tpl' , $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/customerpartner/download_list.tpl' , $data));
		}

	}

	protected function getForm($data) {

		$data['heading_title'] = $this->language->get('heading_title');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_filename'] = $this->language->get('entry_filename');
		$data['entry_mask'] = $this->language->get('entry_mask');
		$data['entry_remaining'] = $this->language->get('entry_remaining');
		$data['text_downloadableInsert'] = $this->language->get('text_downloadableInsert');
		$data['help_fileDetails'] = $this->language->get('help_fileDetails');
		$data['help_mask'] = $this->language->get('help_mask');
		$data['help_update'] = $this->language->get('help_update');	
		$data['text_loading'] = $this->language->get('text_loading');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_upload'] = $this->language->get('button_upload');
		$data['text_access'] = $this->language->get('text_access');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['filename'])) {
			$data['error_filename'] = $this->error['filename'];
		} else {
			$data['error_filename'] = '';
		}

		if (isset($this->error['mask'])) {
			$data['error_mask'] = $this->error['mask'];
		} else {
			$data['error_mask'] = '';
		}

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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '' . $url, 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/customerpartner/download', '' . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['download_id'])) {
			$data['action'] = $this->url->link('account/customerpartner/download/insert', '' . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('account/customerpartner/download/update', '' . '&download_id=' . $this->request->get['download_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('account/customerpartner/download', '' . $url, 'SSL');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->get['download_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$download_info = $this->model_account_customerpartner->getDownload($this->request->get['download_id']);
			if(!$download_info)
				$data['access_error'] = true;				
		}		

		if (isset($this->request->post['download_description'])) {
			$data['download_description'] = $this->request->post['download_description'];
		} elseif (isset($this->request->get['download_id'])) {
			$data['download_description'] = $this->model_account_customerpartner->getDownloadDescriptions($this->request->get['download_id']);
		} else {
			$data['download_description'] = array();
		}

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
		
		if (isset($this->request->post['update'])) {
			$data['update'] = $this->request->post['update'];
		} else {
			$data['update'] = false;
		}

		$data['column_left'] = $this->load->Controller('common/column_left');
		$data['column_right'] = $this->load->Controller('common/column_right');
		$data['content_top'] = $this->load->Controller('common/content_top');
		$data['content_bottom'] = $this->load->Controller('common/content_bottom');
		$data['footer'] = $this->load->Controller('common/footer');		
		$data['header'] = $this->load->Controller('common/header');

		$data['isMember'] = true;
		if($this->config->get('wk_seller_group_status')) {
      		$data['wk_seller_group_status'] = true;
      		$this->load->model('account/customer_group');
			$isMember = $this->model_account_customer_group->getSellerMembershipGroup($this->customer->getId());
			if($isMember) {
				$allowedAccountMenu = $this->model_account_customer_group->getaccountMenu($isMember['gid']);
				if($allowedAccountMenu['value']) {
					$accountMenu = explode(',',$allowedAccountMenu['value']);
					if($accountMenu && !in_array('downloads:downloads', $accountMenu)) {
						$data['isMember'] = false;
					}
				}
			} else {
				$data['isMember'] = false;
			}
      	}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customerpartner/download_form.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/customerpartner/download_form.tpl' , $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/customerpartner/download_form.tpl' , $data));
		}
		
	}

	protected function validateForm() {		

		foreach ($this->request->post['download_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 64)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if ((utf8_strlen($this->request->post['filename']) < 3) || (utf8_strlen($this->request->post['filename']) > 128)) {
			$this->error['filename'] = $this->language->get('error_filename');
		}

		if (!file_exists(DIR_DOWNLOAD . $this->request->post['filename']) && !is_file(DIR_DOWNLOAD . $this->request->post['filename'])) {
			$this->error['filename'] = $this->language->get('error_exists');
		}

		if ((utf8_strlen($this->request->post['mask']) < 3) || (utf8_strlen($this->request->post['mask']) > 128)) {
			$this->error['mask'] = $this->language->get('error_mask');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {		

		$this->load->model('account/customerpartner');

		foreach ($this->request->post['selected'] as $download_id) {
			$product_total = $this->model_account_customerpartner->getTotalProductsByDownloadId($download_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function upload() {

		$this->language->load('account/customerpartner/download');
		$this->load->model('account/customerpartner');

		$json = array();
			
		if (!$this->model_account_customerpartner->chkIsPartner()) {
			$json['error'] = $this->language->get('error_permission');
		}				

		if (!isset($json['error'])) {
			
			if (!empty($this->request->files['file']['name'])) {
				$filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));

				if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 128)) {
					$json['error'] = $this->language->get('error_filename');
				}

				$filesize = $this->request->files['file']['size'];
			
				if ($filesize < $this->config->get('marketplace_downloadsize')) {
					$json['error'] = $this->language->get('error_filesize');
				}

				// Allowed file extension types
				$allowed = array();

				$filetypes = explode(",", $this->config->get('marketplace_downloadex'));

				foreach ($filetypes as $filetype) {
					$allowed[] = trim($filetype);
				}

				if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				// Allowed file mime types
				$allowed = array();
				$filetypes = explode("\n", $this->config->get('config_file_mime_allowed'));

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

				if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
				}
			} else {
				$json['error'] = $this->language->get('error_upload');
			}
		}

		if (!isset($json['error'])) {
			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
				$ext = md5(mt_rand());

				$json['filename'] = $filename . '.' . $ext;
				$json['mask'] = $filename;

				move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $filename . '.' . $ext);
			}

			$json['success'] = $this->language->get('text_upload');
		}

		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('account/customerpartner');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_account_customerpartner->getDownloads($data);

			foreach ($results as $result) {
				$json[] = array(
					'download_id' => $result['download_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);
		
		$this->response->setOutput(json_encode($json));
	}
}
?>