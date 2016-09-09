<?php
class ControllerPaymentCod extends Controller {
	public function index() {
		
		$data['text_loading'] = $this->language->get('text_loading');
		
		$this->load->language('payment/cod'); // one add
		$data['text_payment'] = $this->language->get('text_payment');  // one add 

		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['text_loading'] = $this->language->get('text_loading');

		$data['continue'] = $this->url->link('checkout/success');

		//koy add 30/5/2016
		if (isset($this->session->data['agent_id'])) {
			return $this->load->view('default/template/payment/cod.tpl', $data);
		} elseif (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/cod.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/cod.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/cod.tpl', $data);
		}
	}

	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'cod') {
						
			$this->load->model('checkout/order');
			
			//koy add 28/4/2016
			if (isset($this->session->data['agent_id'])) {
				$user_id = $this->session->data['agent_id'];
			} else {
				$user_id = '';
			}

			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('cod_order_status_id'),'',false,$user_id);
		}
	}
}