<?php
class ControllerAffiliateChartPie extends Controller {
    
    public function index() {
        $this->load->language('affiliate/chart');
        
        if (!$this->affiliate->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('affiliate/stock', '', 'SSL');
            $this->response->redirect($this->url->link('affiliate/login', '', 'SSL'));
        }
        $data['affiliate_id'] = $this->affiliate->isLogged();
        $data['heading_title'] = $this->language->get('heading_title');
        
        $data['text_day'] = $this->language->get('text_day');
        $data['text_week'] = $this->language->get('text_week');
        $data['text_month'] = $this->language->get('text_month');
        $data['text_year'] = $this->language->get('text_year');
        $data['text_view'] = $this->language->get('text_view');
        
        $this->document->setTitle($this->language->get('heading_title'));
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_home'),
        'href' => $this->url->link('affiliate/order')
        );
        $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_account'),
        'href' => $this->url->link('affiliate/account', '', 'SSL')
        );
        $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_chart'),
        'href' => $this->url->link('affiliate/chart_pie', '', 'SSL')
        );
        //$data['column_left'] = $this->load->controller('common/column_left');
        //$data['column_right'] = $this->load->controller('common/column_right');
        $data['column_left'] = $this->load->controller('common/column_leftaff');
        $data['column_right'] = $this->load->controller('common/column_rightaff');
        
        //$data['content_top'] = $this->load->controller('common/content_top');
        //$data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/headeraff');
        
        //koy fix template to default only! 26/5/2016
        //$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/affiliate/chart_pie.tpl', $data));
        
        $this->response->setOutput($this->load->view('default/template/affiliate/chart_pie.tpl', $data));
    }
    /*public function chart() {
    $this->load->language('affiliate/chart');
    $json = array();
    $this->load->model('affiliate/sale');
    $this->load->model('account/customer');
    $this->load->model('affiliate/chart');
    
    $json['order']['data'] = array();
    if (isset($this->request->get['range'])) {
    $range = $this->request->get['range'];
    } else {
    $range = 'day';
    }
    switch ($range) {
    default:
    case 'day':
    $results = $this->model_affiliate_chart->getTotalOrdersByDay();
    foreach ($results as $key => $value) {
    $arr[] = array($key, $value['total']);
    }
    break;
    case 'week':
    $results = $this->model_affiliate_chart->getTotalOrdersByWeek();
    
    foreach ($results as $key => $value) {
    //$json['order']['data'][] = array($key, $value['total']);
    $arr[] = array($key, $value['total']);
    }
    $date_start = strtotime('-' . date('w') . ' days');
    
    for ($i = 0; $i < 7; $i++) {
    $date = date('Y-m-d', $date_start + ($i * 86400));
    
    $json['xaxis'][] = array(date('w', strtotime($date)), date('D', strtotime($date)));
    }
    break;
    case 'month':
    $results = $this->model_affiliate_chart->getTotalOrdersByMonth();
    
    foreach ($results as $key => $value) {
    //$arr[] = array($key, $value['total']);
    $json['order']['data'][] = array($key, $value['total']);
    }
    break;
    case 'year':
    $results = $this->model_affiliate_chart->getTotalOrdersByYear();
    
    foreach ($results as $key => $value) {
    //$json['order']['data'][] = array($key, $value['total']);
    $arr[] = array($key, $value['total']);
    }
    for ($i = 1; $i <= 12; $i++) {
    $json['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i)));
    }
    break;
    }
    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
    //$this->response->setOutput(json_encode($arr));
    }*/
    /*public function chart() {
    $this->load->language('affiliate/chart');
    $this->load->model('affiliate/chart');
    
    $json['order'] = array();
    $json['cancel'] = array();
    $json['during'] = array();
    $json['deliver'] = array();
    $json['delivercancel'] = array();
    $json['claim'] = array();
    $json['completed'] = array();
    //$json['other'] = array();
    $json['customer'] = array();
    $json['xaxis'] = array();
    
    $json['order']['label'] = $this->language->get('text_order');
    $json['cancel']['label'] = $this->language->get('text_cancel');
    $json['during']['label'] = $this->language->get('text_during');
    $json['deliver']['label'] = $this->language->get('text_deliver');
    $json['delivercancel']['label'] = $this->language->get('text_delivercancel');
    $json['claim']['label'] = $this->language->get('text_claim');
    $json['completed']['label'] = $this->language->get('text_completed');
    //$json['other']['label'] = $this->language->get('text_other');
    
    $json['customer']['label'] = $this->language->get('text_customer');
    $json['order']['data'] = array();
    $json['customer']['data'] = array();
    
    if (isset($this->request->get['range'])) {
    $range = $this->request->get['range'];
    } else {
    $range = 'day';
    }
    
    switch ($range) {
    default:
    case 'day':
    $results = $this->model_affiliate_sale->getTotalOrdersByDay();
    return false;
    foreach ($results as $key => $value) {
    $json['order']['data'][] = array($key, $value['total']);
    }
    
    $results = $this->model_account_customer->getTotalCustomersByDay();
    
    foreach ($results as $key => $value) {
    $json['customer']['data'][] = array($key, $value['total']);
    }
    
    for ($i = 0; $i < 24; $i++) {
    $json['xaxis'][] = array($i, $i);
    }
    break;
    case 'week':
    $results = $this->model_affiliate_sale->getTotalOrdersByWeek();
    
    foreach ($results as $key => $value) {
    $json['order']['data'][] = array($key, $value['total']);
    }
    
    $results = $this->model_account_customer->getTotalCustomersByWeek();
    
    foreach ($results as $key => $value) {
    $json['customer']['data'][] = array($key, $value['total']);
    }
    
    $date_start = strtotime('-' . date('w') . ' days');
    
    for ($i = 0; $i < 7; $i++) {
    $date = date('Y-m-d', $date_start + ($i * 86400));
    
    $json['xaxis'][] = array(date('w', strtotime($date)), date('D', strtotime($date)));
    }
    break;
    case 'month':
    $results = $this->model_affiliate_sale->getTotalOrdersByMonth();
    foreach ($results as $key => $value) {
    $json['order']['data'][] = array($key, $value['total']);
    }
    $results = $this->model_affiliate_chart->getTotalOrdersByMonthCancel();
    foreach ($results as $key => $value) {
    $json['cancel']['data'][] = array($key, $value['total']);
    }
    $results = $this->model_affiliate_chart->getTotalOrdersByMonthDuring();
    //print_r($results);
    foreach ($results as $key => $value) {
    $json['during']['data'][] = array($key, $value['total']);
    }
    $results = $this->model_affiliate_chart->getTotalOrdersByMonthDeliver();
    foreach ($results as $key => $value) {
    $json['deliver']['data'][] = array($key, $value['total']);
    }
    $results = $this->model_affiliate_chart->getTotalOrdersByMonthDeliverCancel();
    foreach ($results as $key => $value) {
    $json['delivercancel']['data'][] = array($key, $value['total']);
    }
    $results = $this->model_affiliate_chart->getTotalOrdersByMonthDeliverClaim();
    foreach ($results as $key => $value) {
    $json['claim']['data'][] = array($key, $value['total']);
    }
    $results = $this->model_affiliate_chart->getTotalOrdersByMonthDeliverCompleted();
    foreach ($results as $key => $value) {
    $json['completed']['data'][] = array($key, $value['total']);
    }
    for ($i = 1; $i <= date('t'); $i++) {
    $date = date('Y') . '-' . date('m') . '-' . $i;
    
    $json['xaxis'][] = array(date('j', strtotime($date)), date('d', strtotime($date)));
    }
    break;
    case 'year':
    $results = $this->model_affiliate_sale->getTotalOrdersByYear();
    
    foreach ($results as $key => $value) {
    $json['order']['data'][] = array($key, $value['total']);
    }
    
    $results = $this->model_account_customer->getTotalCustomersByYear();
    
    foreach ($results as $key => $value) {
    $json['customer']['data'][] = array($key, $value['total']);
    }
    
    for ($i = 1; $i <= 12; $i++) {
    $json['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i)));
    }
    break;
    }
    
    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
    }*/
}