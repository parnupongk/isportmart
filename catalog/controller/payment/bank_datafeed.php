<?php
class ControllerPaymentBankDataFeed extends Controller {
    public function index() {
        //$this->load->language('payment/bank_ktc');
        $this->load->language('payment/bank_ktc');
        $this->load->model('payment/bank_ktc');
        echo 'OK';
        //$data['text_instruction'] = $this->language->get('text_instruction');
        //$data['text_description'] = $this->language->get('text_description');
        //$data['text_payment'] = $this->language->get('text_payment');
        //$data['text_loading'] = $this->language->get('text_loading');
        
        $data['ktc_status'] = $_REQUEST['successcode']; //0- succeeded, 1- failure, Others - error
        $order_data = array();

        //$order_data['oc_pktc_id'] =$_REQUEST['oc_pktc_id'];
        $order_data['src'] =$_REQUEST['src'];
        $order_data['prc'] =$_REQUEST['prc'];
        $order_data['ord'] =$_REQUEST['ord'];
        $order_data['holder'] =$_REQUEST['holder'];
        $order_data['successcode'] =$_REQUEST['successcode'];
        $order_data['ref'] =$_REQUEST['ref'];
        $order_data['payRef'] =$_REQUEST['payRef'];
        $order_data['amt'] =$_REQUEST['amt'];
        $order_data['cur'] =$_REQUEST['cur'];
        $order_data['remark'] =$_REQUEST['remark'];
        $order_data['authId'] =$_REQUEST['authId'];
        $order_data['eci'] =$_REQUEST['eci'];
        $order_data['payerAuth'] =$_REQUEST['payerAuth'];
        $order_data['sourceIp'] =$_REQUEST['sourceIp'];
        $order_data['TxType'] =$_REQUEST['TxType'];
        $order_data['interestRate'] =$_REQUEST['interestRate'];
        $order_data['totalInterestAmtDue'] =$_REQUEST['totalInterestAmtDue'];
        $order_data['totalAmtDue'] =$_REQUEST['totalAmtDue'];
        $order_data['monthlyAmtDue'] =$_REQUEST['monthlyAmtDue'];
        $order_data['supplierName'] =$_REQUEST['supplierName'];

        $order_data['productName'] =$_REQUEST['productName'];
        $order_data['productModel'] =$_REQUEST['productModel'];
        $order_data['totalUsedPoint'] =$_REQUEST['totalUsedPoint'];
        $order_data['totalBalancePoint'] =$_REQUEST['totalBalancePoint'];
        $order_data['minimumPoint'] =$_REQUEST['minimumPoint'];
        $order_data['totalCostValue'] =$_REQUEST['totalCostValue'];
        $order_data['mTerm'] =$_REQUEST['mTerm'];
        $order_data['cardNo'] =$_REQUEST['cardNo'];


        
        $this->model_payment_bank_ktc->logPayment($order_data);
        //echo($this->config->get('config_template') . '/template/payment/bank_datafeed.tpl');
        //return $this->load->view('default/template/payment/bank_ktc_datafeed.tpl', $data);

            $this->load->model('checkout/order');
            $comment  = $this->language->get('text_instruction') . "\n\n";
            $comment .= $this->config->get('bank_ktc_bank' . $this->config->get('config_language_id')) . "\n\n";
            $comment .= $this->language->get('text_payment');
            //    $comment .= "KTC Status : " . $data['ktc_status'];
            if( $data['ktc_status'] == '0' )
            {
                $this->model_checkout_order->addOrderHistory($_REQUEST['ref'], 15, $comment, true);
            }else{
                $this->model_checkout_order->addOrderHistory($_REQUEST['ref'], 10, $comment, true);
            }

        return $this->load->view($this->config->get('config_template') . '/template/payment/bank_datafeed.tpl', $data);
    }
    
}