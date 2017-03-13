<?php
class ControllerCustomerpartnerAddshipping extends Controller {

	private $error = array(); 
	private $data = array();

	public function index() {  	

		$this->load->language('customerpartner/addshipping');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if(!isset($this->session->data['csv_file_shipping']))
			$this->session->data['csv_file_shipping'] = array();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$files = $this->request->files;			

			if(isset($files['up_file']['tmp_name']) AND $files['up_file']['tmp_name']){

				// csv check
				$csv_extention = explode('.', $files['up_file']['name']);

				if(isset($csv_extention[1]) AND $csv_extention[1] == 'csv'){					
			
					$this->session->data['csv_post_shipping'] = $this->request->post;
					if ( $file = fopen( $files['up_file']['tmp_name'] , 'r' ) ) {	
						
						// necessary if a large csv file
		            	set_time_limit(0);
		            	$separator = 'webkul';
		            	if(isset($this->request->post['separator']))
							$separator = $this->request->post['separator'];	

						if(strlen($separator)>1){
							$this->error['warning'] = $this->language->get('entry_error_separator');
						}else{	
							// remove chracters from separator
							$separator = preg_replace('/[a-z A-Z .]+/', ' ',$separator);
							if(strlen($separator)<1 || $separator==' ')
								$separator = ';';					
							
							$this->session->data['csv_file_shipping'] = array();
							while ( ($line = fgetcsv ($file, 4096, $separator)) !== FALSE) {											
								$this->session->data['csv_file_shipping'][] = $line;
							}
							
						}
					}					
					$this->response->redirect($this->url->link('customerpartner/addshipping/matchdata', 'token=' . $this->session->data['token'], 'SSL'));
				}else{					
					$this->error['warning'] = $this->language->get('entry_error_csv');
				}
			}else{
				$this->error['warning'] = $this->language->get('entry_error_csv');
			}
		}
	
		$this->data['heading_title'] = $this->language->get('heading_title'). $this->language->get('heading_title_1');		
		$this->data['button_continue']=$this->language->get('button_continue');	
		$this->data['entry_csv']=$this->language->get('entry_csv');			
		$this->data['entry_separator'] = $this->language->get('entry_separator');		
		$this->data['entry_col_separator'] = $this->language->get('entry_col_separator');		
		$this->data['entry_col_info'] = $this->language->get('entry_col_info');
		$this->data['entry_sep_manually'] = $this->language->get('entry_sep_manually');		
		$this->data['entry_info'] = $this->language->get('entry_info');			
		$this->data['button_next'] = $this->language->get('button_next');
		$this->data['button_upload']=$this->language->get('button_upload');				
		$this->data['button_back'] = $this->language->get('button_back');
		$this->data['entry_data_info'] = $this->language->get('entry_data_info');	
		$this->data['entry_error_csv']=$this->language->get('entry_error_csv');				

		if (isset($this->session->data['error_warning'])) {
			$this->error['warning'] = $this->session->data['error_warning'];
			unset($this->session->data['error_warning']);
		}

		if (isset($this->session->data['attention'])) {
			$this->data['attention'] = $this->session->data['attention'];
			unset($this->session->data['attention']);
		}else{
			$this->data['attention'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}else{
			$this->data['success'] = '';
		}			

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('wk_shipping_modadmin'),
			'href'      => $this->url->link('customerpartner/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('customerpartner/addshipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);	
		
		$this->data['back'] = $this->url->link('customerpartner/shipping', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action'] = $this->url->link('customerpartner/addshipping', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['header'] = $this->load->controller('common/header');		
		$this->data['footer'] = $this->load->controller('common/footer');	
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->response->setOutput($this->load->view('customerpartner/addshipping.tpl',$this->data));

	}

	public function matchdata(){			

		$this->load->language('customerpartner/addshipping');				

		if (isset($this->session->data['csv_post_shipping']) AND isset($this->session->data['csv_file_shipping'])) {	

			$post = $this->session->data['csv_post_shipping'];
			$files = $this->session->data['csv_file_shipping'];			
			$fields = false;
			if(isset($files[0]))		
				$fields = $files[0];

		    $num = count($fields);			    
		    //separator check
		    if($num < 2 ){
		    	$this->error['warning'] = $this->language->get('entry_error_separator');
		    	$this->index();		    	
		    }else{	
			    $this->stepTwo($fields);		
			}			
		}else{
			$this->error['warning'] = $this->language->get('error_somithing_wrong');
			$this->index();
		}	
	
	}

	public function stepTwo($fields = array()) { 

		$this->load->model('customerpartner/addshipping'); 

		$this->load->language('customerpartner/addshipping');

		$this->document->setTitle($this->language->get('heading_title'));		
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $fields == array()) {	

			//insert shipping
			foreach ($this->request->post as $chkpost) {
				if($chkpost==''){
					$this->error['warning'] = $this->language->get('error_fileds');
					break;
				}
			} 
			
			if(isset($this->error['warning']) AND $this->error['warning']){					
				$fields = $this->session->data['csv_file_shipping'][0];			
			}else{
				
				$message = $this->matchDataTwo();
				if($message['success'])
					$this->session->data['success'] = $this->language->get('text_shipping').$message['success'];
				if($message['warning'])
					$this->session->data['error_warning'] = $this->language->get('fields_error').$message['warning'];
				if($message['update'])
					$this->session->data['attention'] = $this->language->get('text_attention').$message['update'];

				unset($this->session->data['csv_file_shipping']);
				unset($this->session->data['csv_post_shipping']);				
							
				$this->response->redirect($this->url->link('customerpartner/addshipping', 'token=' . $this->session->data['token'], 'SSL'));
				
			}
			
		}		
	
		$this->data['heading_title'] = $this->language->get('heading_title'). $this->language->get('heading_title_2');				
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_back');
		$this->data['text_separator_info'] = $this->language->get('text_separator_info');					
	
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['attention'])) {
			$this->data['attention'] = $this->session->data['attention'];
			unset($this->session->data['attention']);
		}else{
			$this->data['attention'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}else{
			$this->data['success'] = '';
		}	

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('customerpartner/addshipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		// send fields data
		$this->data['fields'] = $fields;

		// shipping data	
		$this->data['shippingTable'] = array('country_code','seller_id','zip_to','zip_from','price','weight_to','weight_from');

		$this->data['action'] = $this->url->link('customerpartner/addshipping/stepTwo', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('customerpartner/addshipping', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['header'] = $this->load->controller('common/header');		
		$this->data['footer'] = $this->load->controller('common/footer');	
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->response->setOutput($this->load->view('customerpartner/addshipping_next.tpl',$this->data));

	}	

	private function matchDataTwo(){
		
		$this->load->model('customerpartner/addshipping');
		$this->load->language('customerpartner/addshipping');

		if(!isset($this->session->data['csv_file_shipping']))
			$this->response->redirect($this->url->link('customerpartner/addshipping', 'token=' . $this->session->data['token'], 'SSL'));
		
		$files = $this->session->data['csv_file_shipping'];	
		$post = $this->request->post;

		// remove index line from array
		$fields = $files[0];
		$files = array_slice($files, 1);		
		
		$shippingDatas = array();
		$i = 0;	
		$num = count($files);			

	    foreach ($files as $line) {	    	
	    	$entry = true;

	    	foreach($post as $postchk){
	    		if(!isset($line[$postchk]) || trim($line[$postchk])==''){
	    			$entry = false;
	    			break;
	    		}
	    	}

	    	if($entry){
	    		$shippingDatas[$i] = array();
	    		foreach($post as $key=>$postchk){			
		    		$shippingDatas[$i][$key] = $line[$postchk]; 			    	
	    		}
	    		$i++;
	    	}	    	
		    	    	       
	    }
	    $updatechk = 0;
	    foreach ($shippingDatas as $newShipping) {   	    
	    	$result = $this->model_customerpartner_addshipping->addShipping($newShipping);
	    	if($result)
	    		$updatechk++;
	    }
	    
	    return array('success' => $i-$updatechk,
	    			 'warning' => $num-$i,
	    			 'update' => $updatechk,
	    			);
	}	
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'customerpartner/addshipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>
