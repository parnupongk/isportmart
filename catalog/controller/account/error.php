<?php
class ControllerAccountError extends Controller {
	public function index() {

		//$eno = $this->request->get['eno'];
		
		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_logout'),
			'href' => $this->url->link('account/logout', '', 'SSL')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = $this->language->get('text_message');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/headertv');
		
		
		$data['error_warning'] = 'ไม่พบ user นี้ในระบบ';

		//koy add 26/5/2016
		if (isset($this->session->data['agent_id'])) {
			$this->response->setOutput($this->load->view('default/template/account/error.tpl', $data));
		} elseif (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/error.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/error.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/error.tpl', $data));
		}
	}
}