<?php
class ControllerCommonDashboard extends Controller {
	public function index() {
		$this->load->language('common/dashboard');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_sale'] = $this->language->get('text_sale');
		$data['text_map'] = $this->language->get('text_map');
		$data['text_activity'] = $this->language->get('text_activity');
		$data['text_recent'] = $this->language->get('text_recent');
    //nid add 22/03/2016 15:31
    //print_r ($this->session->data['user_group']);
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'].'&user_group=' . $this->session->data['user_group'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'].'&user_group=' . $this->session->data['user_group'], 'SSL')
		);

		// Check install directory exists
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$data['error_install'] = $this->language->get('error_install');
		} else {
			$data['error_install'] = '';
		}

		$data['token'] = $this->session->data['token'];
		 //nid add 22/03/2016 15:31
    $data['user_group'] = $this->session->data['user_group'];
    
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['order'] = $this->load->controller('dashboard/order');
		$data['sale'] = $this->load->controller('dashboard/sale');
		$data['customer'] = $this->load->controller('dashboard/customer');
		$data['online'] = $this->load->controller('dashboard/online');
		$data['map'] = $this->load->controller('dashboard/map');
		$data['chart'] = $this->load->controller('dashboard/chart');
		$data['activity'] = $this->load->controller('dashboard/activity');
		$data['recent'] = $this->load->controller('dashboard/recent');
		$data['footer'] = $this->load->controller('common/footer');

		// Run currency update
		if ($this->config->get('config_currency_auto')) {
			$this->load->model('localisation/currency');

			$this->model_localisation_currency->refresh();
		}
		
		// one add - begin
		$this->load->model('user/user');
		$user_info = $this->model_user_user->getUser($this->user->getId());
		
			if ($this->session->data['user_group'] =='CustService' || $this->session->data['user_group'] =='Agent') {
			$this->response->setOutput($this->load->view('common/dashboardcs.tpl', $data));
		}else if ($this->session->data['user_group'] =='NarLabs' || $this->session->data['user_group'] =='DNA' || $this->session->data['user_group'] == 'SKINREPCIPE') {
			// bom update 20161025 // bom update 20170522
			//print_r ($this->session->data['user_group']);
			$this->response->setOutput($this->load->view('common/dashboardcs.tpl', $data));
		}else {
			$this->response->setOutput($this->load->view('common/dashboard.tpl', $data));
		}
		// one add - end
		//$this->response->setOutput($this->load->view('common/dashboard.tpl', $data));
	}
}