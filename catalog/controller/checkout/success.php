<?php
class ControllerCheckoutSuccess extends Controller {
    public function index() {
        $this->load->language('checkout/success');
        // bom update payment KTC
        if(isset($_REQUEST['Ref']))$order_id = $_REQUEST['Ref'];

        if (isset($this->session->data['order_id']) || isset($order_id) ) {
            $this->cart->clear();
            if( isset($order_id) )$this->session->data['order_id'] = $order_id;
            // Add to activity log
            $this->load->model('account/activity');
            
            if ($this->customer->isLogged()) {
                $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
                'order_id'    => $this->session->data['order_id']
                );
                
                $this->model_account_activity->addActivity('order_account', $activity_data);
            } else {

                $isGuest = true;
                if( isset($this->session->data['guest']) ) $isGuest =false;
				$firsName = ( $isGuest) ?"guest": $this->session->data['guest']['firstname'];
				$lastName = ( $isGuest) ?"guest":$this->session->data['guest']['lastname'];

                $activity_data = array(
                'name'     => $firsName . ' ' . $lastName,
                'order_id' => $this->session->data['order_id']
                );
                
                $this->model_account_activity->addActivity('order_guest', $activity_data);
            }
            
            // bom update bank ktc return success
            /*if( isset($order_id) != null )
            {
                $this->load->language('payment/bank_ktc');
                $this->load->model('checkout/order');
                $comment  = $this->language->get('text_instruction') . "\n\n";
                $comment .= $this->config->get('bank_ktc_bank' . $this->config->get('config_language_id')) . "\n\n";
                $comment .= $this->language->get('text_payment');
                
                $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('bank_ktc_order_status_id'), $comment, true);
            }*/
            
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['guest']);
            unset($this->session->data['comment']);
            unset($this->session->data['order_id']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['voucher']);
            unset($this->session->data['vouchers']);
            unset($this->session->data['totals']);
        }
        
        
        
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_home'),
        'href' => $this->url->link('common/home')
        );
        
        $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_basket'),
        'href' => $this->url->link('checkout/cart')
        );
        
        $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_checkout'),
        'href' => $this->url->link('checkout/checkout', '', 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_success'),
        'href' => $this->url->link('checkout/success')
        );
        
        $data['heading_title'] = $this->language->get('heading_title');
        
        if ($this->customer->isLogged()) {
            $data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
        } else {
            $data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
        }
        
        $data['button_continue'] = $this->language->get('button_continue');
        
        $data['continue'] = $this->url->link('common/home');
        
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
        }
    }
}