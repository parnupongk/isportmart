<?php
class ModelAccountWkmpaddauction extends Model {

	public function addAuction($data){

		    $dat = $this->db->query("SELECT * FROM " . DB_PREFIX . "wkauction WHERE product_id = '" . (int)$this->db->escape($data['product_id']) . "'");
		  
		     $dat=$dat->row;
		    if(count($dat) != 0){

		    	$this->db->query("UPDATE ".DB_PREFIX."wkauction SET product_id = '" . (int)$data['product_id'] . "', name = '" .$data['auction_name']. "', min = '" .$data['aumin'].  "', isauction = '1', max = '" .$data['aumax']. "', start_date = '" .$data['austart']."', end_date = '" .$data['auend']. "', quantity_limit = '" . $data['product_quantity_limit'] . "', voucher_time_limit = '" . $data['voucher_expiry'] . "' WHERE id ='".(int)$dat['id']."'");			   
		    }else{ 

		    $this->db->query("INSERT INTO " . DB_PREFIX . "wkauction SET product_id = '" . (int)$data['product_id'] . "', name = '" .$data['auction_name']. "', min = '" .$data['aumin'].  "', isauction = '1', max = '" .$data['aumax'] ."', start_date = '" .$data['austart'] . "', end_date = '" .$data['auend'] . "', quantity_limit = '" . $data['product_quantity_limit'] . "', voucher_time_limit = '" . $data['voucher_expiry'] . "'");
		    }
		
	}
	
	public function wkauctionsetstatus($status,$seller){
	     
	      $id = $this->db->query("SELECT id FROM ".DB_PREFIX."wkauction_email WHERE seller_id='".(int)$seller."' ")->row; 
	      if(count($id) == 0){
		  $this->db->query("INSERT INTO ".DB_PREFIX."wkauction_email VALUES ('','".(int)$seller."','".(int)$status."') ");
		  $msg = 1;
	      }else{
		  $this->db->query("UPDATE ".DB_PREFIX."wkauction_email SET seller_id = '".(int)$seller."', email_status = '".(int)$status."' WHERE seller_id = '".$seller."'");
		  $msg = 0;
	      }
	      return $msg;
	}
	
	public function getEmailStatus($seller){
		  $status = $this->db->query("SELECT email_status FROM ".DB_PREFIX."wkauction_email WHERE seller_id='".$seller."'")->row;
		  if(isset($status['email_status'])){
		    return $status['email_status'];
		  }
	}
	
	public function getAuctions($cus){
		$date = new DateTime('2014-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
		$zone = $date->format('P');
		$query = "SELECT CONVERT_TZ(NOW(), @@session.time_zone, '$zone') as time;";
		$data = $this->db->query($query)->row;
		$time = date("Y-m-d H:i:s", strtotime($data['time']));

			$dat = $this->db->query("SELECT a.*,pd.name AS product_name FROM " . DB_PREFIX . "wkauction a LEFT JOIN " . DB_PREFIX . "customerpartner_to_product cp2p ON (a.product_id=cp2p.product_id) LEFT JOIN ".DB_PREFIX."product_description pd ON (a.product_id = pd.product_id) WHERE a.isauction=1 and cp2p.customer_id ='" .(int)$this->db->escape($cus) . "' AND end_date >= '".$time."' ");
			return $dat->rows;
	}

	public function deleteAuction($cus){
			
			$dat = $this->db->query("DELETE FROM " . DB_PREFIX . "wkauction WHERE id='" .(int)$this->db->escape($cus) . "'");
			
	}

	//get product using ajax
	public function getMatchProducts($name){

		$results = $this->db->query("SELECT DISTINCT pd.product_id,pd.name,cp2p.customer_id FROM ".DB_PREFIX."product_description pd LEFT JOIN ".DB_PREFIX."customerpartner_to_product cp2p ON (cp2p.product_id = pd.product_id) LEFT JOIN ".DB_PREFIX."customerpartner_to_customer cp2c ON (cp2c.customer_id = cp2c.customer_id) WHERE LOWER(pd.name) LIKE '%".$this->db->escape(utf8_strtolower($name))."%' AND cp2p.customer_id = '".(int)$this->customer->getId()."' AND pd.language_id = '".$this->config->get('config_language_id')."'")->rows;

		return $results;
	}

	public function getSellerBids(){
		$date = new DateTime('2014-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
		$zone = $date->format('P');
		$query = "SELECT CONVERT_TZ(NOW(), @@session.time_zone, '$zone') as time;";
		$data = $this->db->query($query)->row;
		$time = date("Y-m-d H:i:s", strtotime($data['time']));
		
		$results = $this->db->query("SELECT a.id,a.start_date,a.end_date,a.product_id,p.name FROM ".DB_PREFIX."wkauction As a LEFT JOIN ".DB_PREFIX."product_description As p ON p.product_id = a.product_id LEFT JOIN ".DB_PREFIX."customerpartner_to_product cp2p ON a.product_id = cp2p.product_id WHERE cp2p.customer_id = '".(int)$this->customer->getId()."' AND p.language_id='".(int)$this->config->get('config_language_id') ."' AND a.start_date<= '".$time."' AND a.end_date>= '".$time."' AND a.isauction = 1 ")->rows;
		
		
		return $results;
	}

	public function getBidsById($product_id){
		$sql = "SELECT c.firstname,c.lastname,ab.id,ab.start_date,ab.end_date,ab.user_bid FROM ".DB_PREFIX."wkauctionbids ab LEFT JOIN ".DB_PREFIX."customer c ON (c.customer_id = ab.user_id) WHERE product_id = '".$product_id."' AND ab.winner != 1 ORDER BY user_bid DESC";
		$result = $this->db->query($sql)->rows;

		 //Automatic auction
        $auto_sql = "SELECT c.customer_id, c.firstname,c.lastname,ab.autoauction_id,ab.start_date,ab.end_date,ab.user_bid FROM ".DB_PREFIX."wk_automatic_auctionbids ab LEFT JOIN ".DB_PREFIX."customer c ON c.customer_id = ab.user_id WHERE product_id = '".$product_id."' AND ab.winner != 1 ORDER BY user_bid DESC";
		$auto_result = $this->db->query($auto_sql)->rows;

        //Automatic auction
        if ($this->config->get('wkproduct_auction_automatic_auction_status') && !empty($auto_sql)) {
        	
        	foreach ($auto_result as $value) {

				 foreach ($result as $key => $value1) {

				 	if ($value['customer_id'] == $value1['customer_id']) {
				 		
	                       $result[$key]['auto_bid']= $value['user_bid'];
				 	}
				 }
		
            }
        }

		return $result;
	}

	public function getTotalBid($product_id){
		$sql = "SELECT * FROM ".DB_PREFIX."wkauctionbids WHERE product_id = '".$product_id."' AND winner = 0";
		$rows = count($this->db->query($sql)->rows);
		return $rows;
	}

	//Automatic bidding
	public function getTotalAutoBid($product_id){
		$sql = "SELECT * FROM ".DB_PREFIX."wk_automatic_auctionbids WHERE product_id = '".$product_id."' AND winner = 0";
		$rows = count($this->db->query($sql)->rows);
        if ($this->config->get('wkproduct_auction_automatic_auction_status')) {
        	
        	return $rows;
        }else{
             return 0;
        }
		
	}

	public function deleteBid($id){

		$product_id = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "wkauction WHERE id = '" . (int)$id . "' ")->row;

		$this->db->query("DELETE FROM " . DB_PREFIX . "wkauctionbids WHERE product_id = '" . (int)$product_id['product_id'] . "' ");
		$this->db->query("DELETE FROM " . DB_PREFIX . "wkauction WHERE id = '" . (int)$id . "'");		
	}

	public function getWinners(){
	      $sql = "SELECT ab.id,ab.user_bid,ab.start_date,ab.end_date ,c.firstname,c.lastname,pd.name FROM ".DB_PREFIX."wkauctionbids ab LEFT JOIN ".DB_PREFIX."product_description pd ON pd.product_id = ab.product_id LEFT JOIN ".DB_PREFIX."customer c ON c.customer_id = ab.user_id LEFT JOIN ".DB_PREFIX."customerpartner_to_product cp2p ON ab.product_id = cp2p.product_id WHERE cp2p.customer_id = '".(int)$this->customer->getId()."' AND ab.winner = 1 AND pd.language_id = '".$this->config->get('config_language_id')."' ORDER BY end_date DESC LIMIT 0,20 ";
	      $result = $this->db->query($sql)->rows;

	       //Automatic auction
	      $auto_sql = "SELECT ab.autoauction_id id,ab.user_bid,ab.start_date,ab.end_date ,c.firstname,c.lastname,pd.name FROM ".DB_PREFIX."wk_automatic_auctionbids ab LEFT JOIN ".DB_PREFIX."product_description pd ON pd.product_id = ab.product_id LEFT JOIN ".DB_PREFIX."customer c ON c.customer_id = ab.user_id WHERE ab.winner = 1 AND pd.language_id = '".$this->config->get('config_language_id')."' ORDER BY end_date DESC LIMIT 0,20 ";
	      $auto_result = $this->db->query($auto_sql)->rows;

	     //Automatic auction
          if ($this->config->get('wkproduct_auction_automatic_auction_status') && !empty($auto_result)) {

	          foreach ($auto_result as $value) {
		      	
		      	array_push($result, $value);
		      }

          }
          
	      return $result;
	}


}
?>