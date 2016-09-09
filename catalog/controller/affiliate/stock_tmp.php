<?php
class ControllerAffiliateStock extends Controller {
public function index() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/stock', '', 'SSL');
			$this->response->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}
		$this->load->language('affiliate/stock');
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
			'text' => $this->language->get('text_stock'),
			'href' => $this->url->link('affiliate/stock', '', 'SSL')
		);
		$this->load->model('affiliate/stock');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/headeraff');
					
		//koy fix template to default only! 26/5/2016
		/*if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/stock.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/affiliate/stock.tpl', $data));
		} else {*/
			$this->response->setOutput($this->load->view('default/template/affiliate/stock.tpl', $data));
		//}
}		
}