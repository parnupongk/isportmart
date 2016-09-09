<?php
class ControllerPaymentBankKtc extends Controller {
    public function index() {
        $this->load->language('payment/bank_ktc');
        
        $data['text_instruction'] = $this->language->get('text_instruction');
        $data['text_description'] = $this->language->get('text_description');
        $data['text_payment'] = $this->language->get('text_payment');
        $data['text_loading'] = $this->language->get('text_loading');
        
        $data['button_confirm'] = $this->language->get('button_confirm');
        
        $data['bank'] = nl2br($this->config->get('bank_ktc_bank' . $this->config->get('config_language_id')));
        
        $data['continue'] = $this->url->link('checkout/success');
        
        
        $data['currCode'] = $this->language->get('currCode');
        $data['lang'] = $this->language->get('lang');
        $data['cancelUrl'] = $this->language->get('cancelUrl');
        $data['failUrl'] = $this->language->get('failUrl');
        $data['successUrl'] = $this->language->get('successUrl');
        $data['merchantId'] = $this->language->get('merchantId');
        $data['payType'] = $this->language->get('payType');
        $data['payMethod'] = $this->language->get('payMethod');
        $data['TxType'] = $this->language->get('TxType');
        
        
        $data['order_id'] = $this->session->data['order_id'];       
        $data['totals'] = array();
        //foreach ($this->session->data['order_detail']['totals'] as $total) {
            
            //$data['total']  = $this->currency->format($total['value']);
            
        //}
        
        $data['order_detail'] = $this->session->data['order_detail'];

        
        //koy add 27/5/2016
        if (isset($this->session->data['agent_id'])) {
            return $this->load->view('default/template/payment/bank_ktc.tpl', $data);
        } elseif (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/bank_ktc.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/payment/bank_ktc.tpl', $data);
        } else {
            return $this->load->view('default/template/payment/bank_ktc.tpl', $data);
        }
    }
    
    public function confirm() {
        if ($this->session->data['payment_method']['code'] == 'bank_ktc') {
            $this->load->language('payment/bank_ktc');
            
            $this->load->model('checkout/order');
            
            $comment  = $this->language->get('text_instruction') . "\n\n";
            $comment .= $this->config->get('bank_ktc_bank' . $this->config->get('config_language_id')) . "\n\n";
            $comment .= $this->language->get('text_payment');
            
            $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('bank_ktc_order_status_id'), $comment, true);
        }
    }
}