<?php
class ControllerCommonLogin extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('common/login');

		$this->document->setTitle($this->language->get('heading_title'));

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
		//create session user_group for dashbord used  22/03/2016 14:46
		
			$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'].'&user_group=' . $this->session->data['user_group'], 'SSL'));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->session->data['token'] = md5(mt_rand());
			//nid add 22/03/2016 15:10
			$this->load->model('user/user');
			$user_info = $this->model_user_user->getUser($this->user->getId());
			$this->session->data['user_group'] = $user_info['user_group'];
			$this->session->data['user_id'] = $user_info['user_id']; // one add
			//nid add 22/03/2016 15:10
			if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], HTTP_SERVER) === 0 || strpos($this->request->post['redirect'], HTTPS_SERVER) === 0 )) {
				$this->response->redirect($this->request->post['redirect'] . '&token=' . $this->session->data['token']);
			} else {
				$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_login'] = $this->language->get('text_login');
		$data['text_forgotten'] = $this->language->get('text_forgotten');

		$data['entry_username'] = $this->language->get('entry_username');
		$data['entry_password'] = $this->language->get('entry_password');

		$data['button_login'] = $this->language->get('button_login');

		if ((isset($this->session->data['token']) && !isset($this->request->get['token'])) || ((isset($this->request->get['token']) && (isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token']))))) {
			$this->error['warning'] = $this->language->get('error_token');
		}

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

		$data['action'] = $this->url->link('common/login', '', 'SSL');

		if (isset($this->request->post['username'])) {
			$data['username'] = $this->request->post['username'];
		} else {
			$data['username'] = '';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];

			unset($this->request->get['route']);
			unset($this->request->get['token']);

			$url = '';

			if ($this->request->get) {
				$url .= http_build_query($this->request->get);
			}

			$data['redirect'] = $this->url->link($route, $url, 'SSL');
		} else {
			$data['redirect'] = '';
		}

		if ($this->config->get('config_password')) {
			$data['forgotten'] = $this->url->link('common/forgotten', '', 'SSL');
		} else {
			$data['forgotten'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('common/login.tpl', $data));
	}

	protected function validate() {
		if (!isset($this->request->post['username']) || !isset($this->request->post['password']) || !$this->user->login($this->request->post['username'], $this->request->post['password'])) {
			$this->error['warning'] = $this->language->get('error_login');
		}

		return !$this->error;
	}

	public function check() {
		$route = isset($this->request->get['route']) ? $this->request->get['route'] : '';

		$ignore = array(
			'common/login',
			'common/forgotten',
			'common/reset',
			'common/login/directlogin',  // one add
			'common/login/directcust'  // koy add
		);

//		if (!$this->user->isLogged() && !in_array($route, $ignore)) {
		if (!$this->user->isLogged() && !in_array($route, $ignore) &&
		     !isset($this->request->get['username']) && !isset($this->request->get['password']) 
		   ) {
			return new Action('common/login');
		}

		if (isset($this->request->get['route'])) {
			$ignore = array(
				'common/login',
				'common/logout',
				'common/forgotten',
				'common/reset',
				'error/not_found',
				'error/permission',
			'common/login/directlogin',  // one add
			'common/login/directcust'  // koy add
			);

			if (!in_array($route, $ignore) && (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token']))) {
				return new Action('common/login');
			}
		} else {
			if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
				return new Action('common/login');
			}
		}
	}
	
	public function directlogin() {

		$this->load->language('common/login');

		$this->document->setTitle($this->language->get('heading_title'));

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
		//create session user_group for dashbord used  22/03/2016 14:46
		
			$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'].'&user_group=' . $this->session->data['user_group'], 'SSL'));
		}
	
		if (!isset($this->request->get['username']) || !isset($this->request->get['password']) || 
			!$this->user->login_direct( base64_decode( $this->request->get['username']), base64_decode( $this->request->get['password']) )) {

//		if ( !$this->user->login_direct($this->request->get['username'], $this->request->get['password']) ) {  // pornthip.t
			
			
			$this->error['warning'] = $this->language->get('error_login');
			
		} else {
				
			$this->session->data['token'] = md5(mt_rand());
			//nid add 22/03/2016 15:10
			$this->load->model('user/user');
			$user_info = $this->model_user_user->getUser($this->user->getId());
			$this->session->data['user_group'] = $user_info['user_group'];
			$this->session->data['user_id'] = $user_info['user_id']; // one add
			//nid add 22/03/2016 15:10
			
			//if (isset($this->request->get['redirect']) && (strpos($this->request->get['redirect'], HTTP_SERVER) === 0 || strpos($this->request->get['redirect'], HTTPS_SERVER) === 0 )) {
			//	$this->response->redirect($this->request->get['redirect'] . '&token=' . $this->session->data['token']);
			//} else {
				$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'));
			//}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_login'] = $this->language->get('text_login');
		$data['text_forgotten'] = $this->language->get('text_forgotten');

		$data['entry_username'] = $this->language->get('entry_username');
		$data['entry_password'] = $this->language->get('entry_password');

		$data['button_login'] = $this->language->get('button_login');

		if ((isset($this->session->data['token']) && !isset($this->request->get['token'])) || ((isset($this->request->get['token']) && (isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token']))))) {
			$this->error['warning'] = $this->language->get('error_token');
		}

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

		$data['action'] = $this->url->link('common/login', '', 'SSL');

		if (isset($this->request->get['username'])) {
			$data['username'] = $this->request->get['username'];
		} else {
			$data['username'] = '';
		}

		if (isset($this->request->get['password'])) {
			$data['password'] = $this->request->get['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];

			unset($this->request->get['route']);
			unset($this->request->get['token']);

			$url = '';

			if ($this->request->get) {
				$url .= http_build_query($this->request->get);
			}

			$data['redirect'] = $this->url->link($route, $url, 'SSL');
		} else {
			$data['redirect'] = '';
		}

		if ($this->config->get('config_password')) {
			$data['forgotten'] = $this->url->link('common/forgotten', '', 'SSL');
		} else {
			$data['forgotten'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('common/login.tpl', $data));
	}

	//koy add 19/4/2016
	public function directcust() {
		
		$this->load->language('common/login');

		$this->document->setTitle($this->language->get('heading_title'));

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
		//create session user_group for dashbord used  22/03/2016 14:46
		
			$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'].'&user_group=' . $this->session->data['user_group'], 'SSL'));
		}

		if (!isset($this->request->get['user']) || 
			!$this->user->loginbyid( base64_decode($this->request->get['user']))) {
			
			$this->error['warning'] = $this->language->get('error_login');
			
		} else {
				
			$this->session->data['token'] = md5(mt_rand());

			$this->load->model('user/user');
			$user_info = $this->model_user_user->getUser($this->user->getId());
			$this->session->data['user_group'] = $user_info['user_group'];
			$this->session->data['user_id'] = $user_info['user_id'];  // one add
			
			$this->response->redirect($this->url->link('sale/customer/edit', 'token=' . $this->session->data['token'].'&customer_id='.$this->request->get['cust'].'&filter_user_group='.$this->session->data['user_group'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_login'] = $this->language->get('text_login');
		$data['text_forgotten'] = $this->language->get('text_forgotten');

		$data['entry_username'] = $this->language->get('entry_username');
		$data['entry_password'] = $this->language->get('entry_password');

		$data['button_login'] = $this->language->get('button_login');

		if ((isset($this->session->data['token']) && !isset($this->request->get['token'])) || ((isset($this->request->get['token']) && (isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token']))))) {
			$this->error['warning'] = $this->language->get('error_token');
		}

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

		$data['action'] = $this->url->link('common/login', '', 'SSL');

		if (isset($this->request->get['username'])) {
			$data['username'] = $this->request->get['username'];
		} else {
			$data['username'] = '';
		}

		if (isset($this->request->get['password'])) {
			$data['password'] = $this->request->get['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];

			unset($this->request->get['route']);
			unset($this->request->get['token']);

			$url = '';

			if ($this->request->get) {
				$url .= http_build_query($this->request->get);
			}

			$data['redirect'] = $this->url->link($route, $url, 'SSL');
		} else {
			$data['redirect'] = '';
		}

		if ($this->config->get('config_password')) {
			$data['forgotten'] = $this->url->link('common/forgotten', '', 'SSL');
		} else {
			$data['forgotten'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('common/login.tpl', $data));
	}




}