<?php
class ControllerPaymentBankKbank extends Controller {
	public function index() {
		$this->load->language('payment/bank_kbank');

		$data['text_instruction'] = $this->language->get('text_instruction');
		$data['text_description'] = $this->language->get('text_description');
		$data['text_payment'] = $this->language->get('text_payment');

		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['bank'] = nl2br($this->config->get('bank_kbank_bank' . $this->config->get('config_language_id')));

		$data['continue'] = $this->url->link('checkout/success');
		//koy update 2/12/2015
		$data['ani'] = $this->session->data['cust_ani'];

		//koy add 27/5/2016
		if (isset($this->session->data['agent_id'])) {
			return $this->load->view('default/template/payment/bank_kbank.tpl', $data);
		} elseif (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/bank_kbank.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/bank_kbank.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/bank_kbank.tpl', $data);
		}
	}

	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'bank_kbank') {
			$this->load->language('payment/bank_kbank');

			$this->load->model('checkout/order');

			$comment  = $this->language->get('text_instruction') . "\n\n";
			$comment .= $this->config->get('bank_kbank_bank' . $this->config->get('config_language_id')) . "\n\n";
			$comment .= $this->language->get('text_payment');
			
			//koy add 28/4/2016
			if (isset($this->session->data['agent_id'])) {
				$user_id = $this->session->data['agent_id'];
			} else {
				$user_id = '';
			}			

			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('bank_kbank_order_status_id'), $comment, true, $user_id);
		}
	}
}
