<?php

################################################################################################
# Product auction for Opencart 2.1.x.x From webkul http://webkul.com    #
################################################################################################
class ModelModuleWkproductauction extends Model {

	public function getProductBids($product_id){
		$date = new DateTime('2014-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
		$zone = $date->format('P');
		$query = "SELECT CONVERT_TZ(NOW(), @@session.time_zone, '$zone') as time;";
		$data = $this->db->query($query)->row;
		$time = date("Y-m-d H:i:s", strtotime($data['time']));

	      $result = $this->db->query("SELECT  wab.user_bid,c.firstname,c.lastname FROM ".DB_PREFIX."wkauctionbids wab LEFT JOIN ".DB_PREFIX."customer c ON wab.user_id=c.customer_id WHERE wab.product_id = '".$product_id."' AND wab.start_date <= '".$time."' AND wab.end_date >= '".$time."' AND winner != 1 ORDER BY wab.user_bid DESC LIMIT 0,10")->rows;
	    return $result;
	}

	 /**
     * [getProductBids fetch autometic bid details]
     * @param  [type] $product_id [product id]
     * @return [type]             [array]
     */
	public function getAutoProductBids($product_id){

		$date = new DateTime('2014-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
		$zone = $date->format('P');
		$query = "SELECT CONVERT_TZ(NOW(), @@session.time_zone, '$zone') as time;";
		$data = $this->db->query($query)->row;
		$time = date("Y-m-d H:i:s", strtotime($data['time']));

	      $result = $this->db->query("SELECT wab.user_id,wab.user_bid,c.firstname,c.lastname FROM ".DB_PREFIX."wk_automatic_auctionbids wab LEFT JOIN ".DB_PREFIX."customer c ON wab.user_id=c.customer_id WHERE wab.product_id = '".$product_id."' AND wab.start_date <= '".$time."' AND wab.end_date >= '".$time."' AND winner != 1 ORDER BY wab.user_bid DESC LIMIT 0,10")->rows;
	     
	    return $result;
	}

	 //Automatic bidding
	public function getEmailId($customer_id){
       
       $result = $this->db->query("SELECT email FROM ".DB_PREFIX."customer WHERE customer_id = '".$customer_id."'");

       return $result->row;
	}

	public function getProductAuction(){
		$date = new DateTime('2014-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
		$zone = $date->format('P');
		$query = "SELECT CONVERT_TZ(NOW(), @@session.time_zone, '$zone') as time;";
		$data = $this->db->query($query)->row;
		$time = date("Y-m-d H:i:s", strtotime($data['time']));

	      $result = $this->db->query("SELECT * FROM ".DB_PREFIX."wkauction WHERE start_date <= '".$time."' AND end_date >= '".$time."' AND isauction = 1 ")->rows;
	      return $result; 
	}
	public function getAuction($product_id) {
		$date = new DateTime('2014-06-1');
		if($this->config->get('wkproduct_auction_timezone_set')) {
			$date = new DateTime('2014-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
		}
		$zone = $date->format('P');
		$query = "SELECT CONVERT_TZ(NOW(), @@session.time_zone, '$zone') as time;";
		$data = $this->db->query($query)->row;
		$time = date("Y-m-d H:i:s", strtotime($data['time']));

		$data = $this->db->query("SELECT MAX(wab.user_bid) atleast,wa.* FROM " . DB_PREFIX . "wkauction wa LEFT JOIN ". DB_PREFIX . "wkauctionbids wab ON (wa.id=wab.auction_id)  WHERE wa.product_id = '" . (int)$product_id . "' AND isauction=1");
		
		return $data->rows;
	}
	public function getAuctionbids($auction_id) {
		$data = $this->db->query("SELECT * FROM " . DB_PREFIX . "wkauctionbids WHERE sold=0 AND auction_id = '" . (int)$auction_id . "' ORDER BY user_bid");
		return $data->rows;
	}
	public function getauctionendTime($product_id){
		$data = $this->db->query("SELECT end_date FROM ".DB_PREFIX."wkauction WHERE product_id = '".$product_id."'");
		
		return $data->row;
	}
	
	public function totalBidsOnProduct($product_id){
		$countBids = $this->db->query("SELECT wa.end_date FROM ".DB_PREFIX."wkauction wa LEFT JOIN ".DB_PREFIX."wkauctionbids wab ON wa.end_date=wab.end_date WHERE wab.product_id='".$product_id."'")->rows;
		return count($countBids);
	}

	 // Automatic bidding
	public function totalAutoBidsOnProduct($product_id){
		$countBids = $this->db->query("SELECT wa.end_date FROM ".DB_PREFIX."wkauction wa LEFT JOIN ".DB_PREFIX."wk_automatic_auctionbids wab ON wa.end_date=wab.end_date WHERE wab.product_id='".$product_id."'")->rows;
		return count($countBids);
	}

	public function updateAuctionbids($auction_id) {
		$date = new DateTime('2014-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
		$zone = $date->format('P');
		$query = "SELECT CONVERT_TZ(NOW(), @@session.time_zone, '$zone') as time;";
		$data = $this->db->query($query)->row;
		$time = date("Y-m-d H:i:s", strtotime($data['time']));

		$check = $this->db->query("SELECT wab.id FROM ".DB_PREFIX."wkauction wa LEFT JOIN ".DB_PREFIX."wkauctionbids wab ON wa.end_date=wab.end_date WHERE wa.id='".$auction_id."' ")->row;

        // Automatic bidding
		$auto_bid_check = $this->db->query("SELECT wab.auction_id FROM ".DB_PREFIX."wkauction wa LEFT JOIN ".DB_PREFIX."wk_automatic_auctionbids wab ON wa.end_date=wab.end_date WHERE wa.id='".$auction_id."' ")->row;
		
		if(!empty($check['id']) || !empty($auto_bid_check['auction_id'])){
		$this->language->load('module/wkproduct_auction');

		$bids=$this->db->query("SELECT MAX(user_bid) id FROM " . DB_PREFIX . "wkauctionbids WHERE auction_id = '" . (int)$auction_id . "'");
		$bid_id=$bids->row;
		
		//Automatic bidding
		$auto_max_bids=$this->db->query("SELECT MAX(user_bid) id FROM " . DB_PREFIX . "wk_automatic_auctionbids WHERE auction_id = '" . (int)$auction_id . "'");
		$auto_bid_max=$auto_max_bids->row;


        //Automatic bidding
		if (!empty($auto_bid_max['id']) && !empty($bid_id['id']) && $this->config->get('wkproduct_auction_automatic_auction_status')) {
			
			if ($auto_bid_max['id'] > $bid_id['id']) {
			    
			    $ids=$this->db->query("SELECT * FROM " . DB_PREFIX . "wk_automatic_auctionbids WHERE user_bid='" . (double)$auto_bid_max['id'] . "'");
	            $record=$ids->row;

			}else{

				$ids=$this->db->query("SELECT * FROM " . DB_PREFIX . "wkauctionbids WHERE user_bid='" . (double)$bid_id['id'] . "'");
	            $record=$ids->row;

			}

		}elseif (!empty($bid_id['id'])) {
			
			$ids=$this->db->query("SELECT * FROM " . DB_PREFIX . "wkauctionbids WHERE user_bid='" . (double)$bid_id['id'] . "'");
	            $record=$ids->row;

		}elseif (!empty($auto_bid_max['id']) && $this->config->get('wkproduct_auction_automatic_auction_status')) {
			
			$ids=$this->db->query("SELECT * FROM " . DB_PREFIX . "wk_automatic_auctionbids WHERE user_bid='" . (double)$auto_bid_max['id'] . "'");
	            $record=$ids->row;
		}else{
			return false;
		}

        // $ids=$this->db->query("SELECT * FROM " . DB_PREFIX . "wkauctionbids WHERE user_bid='" . (int)$bid_id['id'] . "'");
        // $record=$ids->row;

        if(!isset($record['product_id'])){
        	$this->db->query("UPDATE " . DB_PREFIX . "wkauction SET isauction=0 WHERE id = '" .(int)$auction_id . "'");
        	return true;
        }
        $price=$this->db->query("SELECT price FROM " . DB_PREFIX . "product WHERE product_id='" . (int)$record['product_id'] . "'");
		$price=$price->row;
		
		$code=rand();

		//Automatic bidding
		if (!empty($auto_bid_max['id']) && !empty($bid_id['id']) && $this->config->get('wkproduct_auction_automatic_auction_status')) {
			
			if ($auto_bid_max['id'] > $bid_id['id']) {
			    
			   $discount=$price['price']-$bid_id['id'];

			}else{

				$discount=$price['price']-$bid_id['id'];

			}

		}elseif (!empty($bid_id['id'])) {
			
			$discount=$price['price']-$bid_id['id'];

		}elseif (!empty($auto_bid_max['id']) && $this->config->get('wkproduct_auction_automatic_auction_status')) {
			
			$discount=$price['price']-$auto_bid_max['id'];
		}

		// $discount=$price['price']-$bid_id['id'];
		
		$quantity = $this->db->query("SELECT quantity_limit ,product_id FROM " . DB_PREFIX . "wkauction WHERE id =".(int)$auction_id ." ")->row;
		
		if(isset($quantity) && $quantity['quantity_limit'] != 0)		
			$total=$price['price']*$quantity['quantity_limit'];
		else
			$total=$price['price']*1;
		

		$voucher_limit= $this->db->query("SELECT voucher_time_limit FROM " . DB_PREFIX . "wkauction WHERE id = '" .(int)$auction_id . "'")->row;
	
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "coupon SET name ='Bid Coupon',uses_total=1,uses_customer='1',type='F',status=1,code = '" .$code. "',discount = '" .$discount. "',total = '" .$total. "', date_start = '".$time."' ,date_end = '" . $voucher_limit['voucher_time_limit'] . "'");

		$coupen=$this->db->query("SELECT MAX(coupon_id) id, date_end FROM " . DB_PREFIX . "coupon")->row;
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "coupon_product SET coupon_id = '" .(int)$coupen['id']. "',product_id = '" .(int)$record['product_id']. "'");

		// Automatic bidding
		if (!empty($auto_bid_max['id']) && !empty($bid_id['id']) && $this->config->get('wkproduct_auction_automatic_auction_status')) {
			
			if ($auto_bid_max['id'] > $bid_id['id']) {
			    
			   $this->db->query("UPDATE " . DB_PREFIX . "wk_automatic_auctionbids SET winner=1,user_bid='".$bid_id['id']."' WHERE user_bid='" . (double)$auto_bid_max['id'] . "'");

			}else{

				$this->db->query("UPDATE " . DB_PREFIX . "wkauctionbids SET winner=1 WHERE user_bid='" . (double)$bid_id['id'] . "'");

			}

		}elseif (!empty($bid_id['id'])) {
			
			$this->db->query("UPDATE " . DB_PREFIX . "wkauctionbids SET winner=1 WHERE user_bid='" . (double)$bid_id['id'] . "'");

		}elseif (!empty($auto_bid_max['id']) && $this->config->get('wkproduct_auction_automatic_auction_status')) {
			
			$this->db->query("UPDATE " . DB_PREFIX . "wk_automatic_auctionbids SET winner=1,user_bid='".$bid_id['id']."' WHERE user_bid='" . (double)$auto_bid_max['id'] . "'");
		}

		// $this->db->query("UPDATE " . DB_PREFIX . "wkauctionbids SET winner=1 WHERE user_bid='" . (int)$bid_id['id'] . "'");
        $this->db->query("UPDATE " . DB_PREFIX . "wkauction SET isauction=0 WHERE id = '" .(int)$auction_id . "'");

        $prod=$this->db->query("SELECT product_id, name FROM " . DB_PREFIX . "product_description WHERE product_id='" . (int)$record['product_id'] . "'")->row;
        
        $productlink = '<a href="'.$this->url->link('product/product','product_id='.$prod["product_id"].'&showcart=y').'">here</a>';
		
        $detail= $this->language->get('bid_message_customer_message1').$prod['name'].$this->language->get('bid_message_customer_message2').$productlink. $this->language->get('bid_message_customer_message3') .$code . $this->language->get('bid_message_customer_message4').date('d-m-Y', strtotime($coupen['date_end']));

        $customer=$this->db->query("SELECT * FROM ".DB_PREFIX ."customer WHERE customer_id='" . (int)$record['user_id'] . "'")->row;



		$admindetail= $this->language->get('bid_message_admin_message1').$customer['firstname']." ".$customer['lastname'] .$this->language->get('bid_message_admin_message2').$prod['name'].$this->language->get('bid_message_admin_message3').$code.$this->language->get('bid_message_admin_message4').$coupen['date_end'].'.';
		
		$mp_seller = $this->db->query("SELECT c.firstname,c.lastname,c.email FROM ".DB_PREFIX."customer c LEFT JOIN ".DB_PREFIX."customerpartner_to_customer cp2c ON (c.customer_id = cp2c.customer_id) LEFT JOIN ".DB_PREFIX."customerpartner_to_product cp2p ON (c.customer_id = cp2p.customer_id) WHERE cp2p.product_id = '".(int)$record['product_id']."' ")->row;

		$sellerDetails = $this->language->get('bid_message_seller_message1').$prod['name'].$this->language->get('bid_message_seller_message2').$customer['firstname']." ".$customer['lastname'] .$this->language->get('bid_message_seller_message3') .$code. $this->language->get('bid_message_seller_message4').$coupen['date_end'];
		
		$language = new Language('catalog/');
		
		$language->load('catalog/mail');

		$data['text_hello'] = $language->get('text_hello');	
		$data['text_name'] = $language->get('entry_name');	
		$data['text_email'] = $language->get('email');					
		$data['text_pname'] = $language->get('entry_pname').$prod['name'];		
		$data['text_to_admin'] = html_entity_decode($admindetail, ENT_QUOTES, 'UTF-8');
		$data['text_to_seller'] = html_entity_decode($detail, ENT_QUOTES, 'UTF-8');
		$data['text_to_sellermail'] = html_entity_decode($sellerDetails, ENT_QUOTES, 'UTF-8');
		$data['text_auto'] = false;		
		$data['text_sellersubject'] = $language->get('ptext_sellersubject');
		$data['text_adminsubject'] = $language->get('ptext_adminsubject');
		$data['text_mpsellersubject'] = $language->get('ptext_mpsellersubject');

		$data['text_thanksadmin'] = $language->get('text_thanksadmin');	

		$data['autoApprove'] = false;	
		$data['name'] = $this->config->get('config_name');

		$data['store_name'] = $this->config->get('store_name');
		$data['store_url'] = HTTP_SERVER;
		$data['logo'] = HTTP_SERVER.'image/' . $this->config->get('config_logo');			
		$data['customer'] = $customer;

		$data['mp_seller'] = $mp_seller;
		
		//seller mail
		if($this->config->get('wkproduct_auction_sellermail')){
			if(isset($mp_seller['email']) && $mp_seller['email']){
				$data['mpseller'] = true;

				$html = $this->load->view('default/template/catalog/pmail.tpl', $data);		

				$tompseller = array();

				$tompseller['emailto']=$mp_seller['email'];
				$tompseller['message']=$html;
				$tompseller['mailfrom']=$this->config->get('config_email');
				$tompseller['subject']=$this->language->get('bid_message_seller_subject');
				$tompseller['name']=$this->config->get('config_name');
				
				$this->sendMail($tompseller);

				$data['mpseller'] = false;
			}
		}

		$data['seller'] = true;		

		$html = $this->load->view('default/template/catalog/pmail.tpl', $data);	
		
		$toAdmin=array();
		$toseller=array();

		$toseller['emailto'] = $customer['email'];
		$toseller['message'] = $html;
		$toseller['mailfrom']= $this->config->get('config_email');
		$toseller['subject'] = $this->language->get('bid_message_customer_subject');
		$toseller['name']    = $this->config->get('config_name');

		
		$this->sendMail($toseller);
	
		$data['seller'] = false;			
		$data['admin'] = true;

		$html = $this->load->view('default/template/catalog/pmail.tpl', $data);
		$toAdmin['emailto']=$this->config->get('config_email');
		$toAdmin['message']=$html;
		$toAdmin['mailfrom']=$this->config->get('config_email');
		$toAdmin['subject']=$this->language->get('bid_message_customer_subject');
		$toAdmin['name']=$customer['firstname']." ".$customer['lastname'];
		
		$this->sendMail($toAdmin);
		return True;
		}
	}

    public function sendMail($data){
    	if(VERSION == '2.0.0.0' || VERSION == '2.0.1.0' || VERSION == '2.0.1.1'  ) {
			/*Old mail code*/
			$mail = new Mail($this->config->get('config_mail'));
			$mail->setTo($data['emailto']);
			$mail->setFrom($data['mailfrom']);
			$mail->setSender($data['name']);
			$mail->setSubject(html_entity_decode($data['subject'], ENT_QUOTES, 'UTF-8'));
			$mail->setHtml(html_entity_decode($data['message'], ENT_QUOTES, 'UTF-8'));
			$mail->setText(strip_tags($html));
			$mail->send();
		} else {
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
			
			$mail->setTo($data['emailto']);
			$mail->setFrom($data['mailfrom']);
			$mail->setSender($data['name']);
			$mail->setSubject(html_entity_decode($data['subject'], ENT_QUOTES, 'UTF-8'));
			$mail->setHtml(html_entity_decode($data['message'], ENT_QUOTES, 'UTF-8'));
			$mail->setText(strip_tags($data['message']));
			$mail->send();
		}	
	}

	public function wkauctionbids_viewbids($auction){
			$query =$this->db->query("SELECT c.firstname,c.lastname,wa.user_bid FROM " . DB_PREFIX . "wkauctionbids wa LEFT JOIN ". DB_PREFIX ."customer c ON (c.customer_id=wa.user_id) WHERE wa.auction_id = '" . (int)$auction . "' AND winner != 1 ORDER BY wa.user_bid DESC");
		        return $query->rows;
	}

	public function wkauctionbids_insertbids($data,$user){

		$date = new DateTime('2014-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
		$zone = $date->format('P');
		$query = "SELECT CONVERT_TZ(NOW(), @@session.time_zone, '$zone') as time;";
		$data_details = $this->db->query($query)->row;
		$time = date("Y-m-d H:i:s", strtotime($data_details['time']));


		$userExist = $this->db->query("SELECT user_id,product_id FROM ".DB_PREFIX."wkauctionbids WHERE user_id = '".$data['user']."' AND product_id='".$data['product_id']."' AND winner = 0 " )->row;

        $sql=$this->db->query("SELECT MAX(wab.user_bid) id,wa.min,wa.max,wa.product_id FROM " . DB_PREFIX . "wkauction wa LEFT JOIN ". DB_PREFIX . "wkauctionbids wab ON (wa.id=wab.auction_id) WHERE wa.id = '" . (int)$data['auction'] . "' AND wab.winner = 0 AND wab.start_date<= '".$time."' AND wab.end_date>= '".$time."' ")->row;

        $range = $this->db->query("SELECT min,max FROM ".DB_PREFIX."wkauction WHERE id='".$data['auction']."' ")->row;

            if($data['amount']>=$range['max'] || $data['amount']<=$range['min']){
			  return 'not done';
			}
               
            if(isset($sql['product_id'])){
				  if(count($sql)!=0 && $data['amount']<=$sql['id']){
				      return 'not'; //only for checking not messages
				  }
            }

	  if($userExist){
	  		$sql = "UPDATE " . DB_PREFIX . "wkauctionbids SET winner='0',sold='0',auction_id = '" . (int)$data['auction']. "', user_id = '" .(int)$user."', product_id = '" .(int)$data['product_id']."', start_date = '" .$this->db->escape($data['start_date']). "', end_date = '" .$this->db->escape($data['end_date'])."', date = '".$time."', user_bid = '" .(double)$data['amount']."' WHERE user_id = '".$userExist['user_id']."' AND product_id = '".$userExist['product_id']."' AND winner = 0 ";
	      	$query=$this->db->query($sql);
	  }else{
	  		$sql = "INSERT INTO " . DB_PREFIX . "wkauctionbids SET winner='0',sold='0',auction_id = '" . (int)$data['auction']. "', user_id = '" .(int)$user."', product_id = '" .(int)$data['product_id']."', start_date = '" .$this->db->escape($data['start_date']). "', end_date = '" .$this->db->escape($data['end_date'])."', date = '".$time."', user_bid = '" .(double)$data['amount']."'";
	     	$query=$this->db->query($sql);
	  }
               return 'done';  //only for checking not mesaages
	}

	/**
     * [wkauto_auctionbids_insertbids inserts automatic bids]
     * @param  [type] $data [bid detail]
     * @param  [type] $user [user details]
     * @return [type]       [string]
     */
	public function wkauto_auctionbids_insertbids($data,$user){

		$date = new DateTime('2014-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
		$zone = $date->format('P');
		$query = "SELECT CONVERT_TZ(NOW(), @@session.time_zone, '$zone') as time;";
		$data_time = $this->db->query($query)->row;
		
		$time = date("Y-m-d H:i:s", strtotime($data_time['time']));
		
		$userExist = $this->db->query("SELECT user_id,product_id FROM ".DB_PREFIX."wk_automatic_auctionbids WHERE user_id = '".$data['user']."' AND product_id='".$data['product_id']."' AND winner = 0 " )->row;

        $sql=$this->db->query("SELECT MAX(wab.user_bid) id,wa.min,wa.max,wa.product_id FROM " . DB_PREFIX . "wkauction wa LEFT JOIN ". DB_PREFIX . "wk_automatic_auctionbids wab ON (wa.id=wab.auction_id) WHERE wa.id = '" . (int)$data['auction'] . "' AND wab.winner = 0 AND wab.start_date<='".$time."' AND wab.end_date>='".$time."' ")->row;

        $normal_max_bid=$this->db->query("SELECT MAX(wab.user_bid) id,wa.min,wa.max,wa.product_id FROM " . DB_PREFIX . "wkauction wa LEFT JOIN ". DB_PREFIX . "wkauctionbids wab ON (wa.id=wab.auction_id) WHERE wa.id = '" . (int)$data['auction'] . "' AND wab.winner = 0 AND wab.start_date<='".$time."' AND wab.end_date>='".$time."' ")->row;

        $range = $this->db->query("SELECT min,max FROM ".DB_PREFIX."wkauction WHERE id='".$data['auction']."' ")->row;

            if($data['amount']>=$range['max'] || $data['amount']<=$range['min']){
			  return 'not done';
			}

			if(isset($normal_max_bid['product_id'])){
				  if(count($normal_max_bid)!=0 && $data['amount']<=$normal_max_bid['id']){
				      return 'not_min_auction'; //only for checking not messages
				  }

            }

            if(isset($sql['product_id'])){

				  if(count($sql)!=0 && $data['amount']<=$sql['id']){
				      return 'not'; //only for checking not messages
				  }
            }
         
	  if($userExist) {
	  		$sql = "UPDATE " . DB_PREFIX . "wk_automatic_auctionbids SET winner='0',sold='0',auction_id = '" . (int)$data['auction']. "', user_id = '" .(int)$user."', product_id = '" .(int)$data['product_id']."', start_date = '" .$this->db->escape($data['start_date']). "', end_date = '" .$this->db->escape($data['end_date'])."', date = '".$time."', user_bid = '" .(double)$data['amount']."' WHERE user_id = '".$userExist['user_id']."' AND product_id = '".$userExist['product_id']."' AND winner = 0 ";
	  	
	      	$query=$this->db->query($sql);
	  }else{
	  		$sql = "INSERT INTO " . DB_PREFIX . "wk_automatic_auctionbids SET winner='0',sold='0',auction_id = '" . (int)$data['auction']. "', user_id = '" .(int)$user."', product_id = '" .(int)$data['product_id']."', start_date = '" .$this->db->escape($data['start_date']). "', end_date = '" .$this->db->escape($data['end_date'])."', date = '".$time."', user_bid = '" .(double)$data['amount']."'";
	  		
	     	$query=$this->db->query($sql);
	  }
               return 'done';  //only for checking not mesaages
	}

}

?>
