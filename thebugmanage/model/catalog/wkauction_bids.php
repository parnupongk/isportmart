<?php
################################################################################################
# Auction Bids  Opencart 2.0.x From Webkul  http://webkul.com 	#
################################################################################################
class ModelCatalogWkauctionbids extends Model {

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

	public function getBidsById($product_id){
		$sql = "SELECT c.customer_id, c.firstname,c.lastname,ab.id,ab.start_date,ab.end_date,ab.user_bid FROM ".DB_PREFIX."wkauctionbids ab LEFT JOIN ".DB_PREFIX."customer c ON c.customer_id = ab.user_id WHERE product_id = '".$product_id."' AND ab.winner != 1 ORDER BY user_bid DESC";
		$result = $this->db->query($sql)->rows;

		//Automatic bidding
        $auto_sql = "SELECT c.customer_id, c.firstname,c.lastname,ab.autoauction_id,ab.start_date,ab.end_date,ab.user_bid FROM ".DB_PREFIX."wk_automatic_auctionbids ab LEFT JOIN ".DB_PREFIX."customer c ON c.customer_id = ab.user_id WHERE product_id = '".$product_id."' AND ab.winner != 1 ORDER BY user_bid DESC";
		$auto_result = $this->db->query($auto_sql)->rows;
        
        //Automatic bidding
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
	public function getBids($filter_data){
		$date = new DateTime('2014-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
		$zone = $date->format('P');
		$query = "SELECT CONVERT_TZ(NOW(), @@session.time_zone, '$zone') as time;";
		$data = $this->db->query($query)->row;
		$time = date("Y-m-d H:i:s", strtotime($data['time']));
		
		$sql="SELECT a.id,a.start_date,a.end_date,a.product_id,p.name FROM ".DB_PREFIX."wkauction As a LEFT JOIN ".DB_PREFIX."product_description As p ON p.product_id = a.product_id WHERE p.language_id='".(int)$this->config->get('config_language_id') ."' AND a.start_date<='".$time."' AND a.end_date>='".$time."' AND a.isauction = 1 ";
			
		if(!empty($filter_data['filter_pname'])){
		  $sql .= "AND p.name like '%".$filter_data['filter_pname']."%' ";
		}

		if(!empty($filter_data['filter_starttime'])){
		  $sql .= "AND a.start_date = '".$filter_data['filter_starttime']."' ";
		}

		if(!empty($filter_data['filter_endtime'])){
		  $sql .= "AND a.end_date = '".$filter_data['filter_endtime']."' ";
		}

		$sort_data = array(
				'p.name',
				'a.start_date',
				'a.end_date'				
			);	
			
		if (isset($filter_data['sort']) && in_array($filter_data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $filter_data['sort'];	
		} else {
			$sql .= " ORDER BY pd.name";	
		}
		
		if (isset($filter_data['order']) && ($filter_data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
	
		if (isset($filter_data['start']) || isset($filter_data['limit'])) {
			if ($filter_data['start'] < 0) {
				$filter_data['start'] = 0;
			}				

			if ($filter_data['limit'] < 1) {
				$filter_data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$filter_data['start'] . "," . (int)$filter_data['limit'];
		}

		// echo "<pre>";
		// print_r($this->db->query($sql));
		// die();

			$result=$this->db->query($sql);
			return $result->rows;
		}

		public function getTotalBids($data = array()){
			$date = new DateTime('2014-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
			$zone = $date->format('P');
			$query = "SELECT CONVERT_TZ(NOW(), @@session.time_zone, '$zone') as time;";
			$data = $this->db->query($query)->row;
			$time = date("Y-m-d H:i:s", strtotime($data['time']));

		$sql="SELECT COUNT(DISTINCT a.id) AS total FROM ".DB_PREFIX."wkauction As a LEFT JOIN ".DB_PREFIX."product_description As p ON p.product_id = a.product_id WHERE p.language_id='".(int)$this->config->get('config_language_id') ."' AND a.start_date<='".$time."' AND a.end_date>='".$time."' AND a.isauction = 1 ";
			
			if(!empty($filter_data['filter_pname'])){
			  $sql .= "AND p.name like '%".$filter_data['filter_pname']."%' ";
			}

			if(!empty($filter_data['filter_starttime'])){
			  $sql .= "AND a.start_date = '".$filter_data['filter_starttime']."' ";
			}

			if(!empty($filter_data['filter_endtime'])){
			  $sql .= "AND a.end_date = '".$filter_data['filter_endtime']."'";
			}

			$query = $this->db->query($sql);

		return $query->row['total'];
		
		}
		
	public function getWinners(){
	      $sql = "SELECT ab.id,ab.user_bid,ab.start_date,ab.end_date ,c.firstname,c.lastname,pd.name FROM ".DB_PREFIX."wkauctionbids ab LEFT JOIN ".DB_PREFIX."product_description pd ON pd.product_id = ab.product_id LEFT JOIN ".DB_PREFIX."customer c ON c.customer_id = ab.user_id WHERE ab.winner = 1 AND pd.language_id = '".$this->config->get('config_language_id')."' ORDER BY end_date DESC LIMIT 0,20 ";
	      $result = $this->db->query($sql)->rows;

	      //Automatic bidding
	      $auto_sql = "SELECT ab.autoauction_id id,ab.user_bid,ab.start_date,ab.end_date ,c.firstname,c.lastname,pd.name FROM ".DB_PREFIX."wk_automatic_auctionbids ab LEFT JOIN ".DB_PREFIX."product_description pd ON pd.product_id = ab.product_id LEFT JOIN ".DB_PREFIX."customer c ON c.customer_id = ab.user_id WHERE ab.winner = 1 AND pd.language_id = '".$this->config->get('config_language_id')."' ORDER BY end_date DESC LIMIT 0,20 ";
	      $auto_result = $this->db->query($auto_sql)->rows;

	     //Automatic bidding
          if ($this->config->get('wkproduct_auction_automatic_auction_status') && !empty($auto_result)) {

	          foreach ($auto_result as $value) {
		      	
		      	array_push($result, $value);
		      }

          }

	      return $result;
	}
	public function getProduct($product) 
	{
		$sql ="SELECT name FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product . "'";
		$result=$this->db->query($sql);
		return $result->rows;
		
	}
	public function getCustomer($customer) 
	{
		$sql ="SELECT * FROM " . DB_PREFIX . "wkauctionbids";
		$result=$this->db->query($sql);
		return $result->rows;
		
	}
	public function getAuction($auction) 
	{
		$sql ="SELECT * FROM " . DB_PREFIX . "wkauctionbids";
		$result=$this->db->query($sql);
		return $result->rows;
		
	}

    public function deleteBid($id) {
		$product_id = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "wkauction WHERE id = '" . (int)$id . "' ")->row;
		$this->db->query("DELETE FROM " . DB_PREFIX . "wkauctionbids WHERE product_id = '" . (int)$product_id['product_id'] . "' ");
		$this->db->query("DELETE FROM " . DB_PREFIX . "wkauction WHERE id = '" . (int)$id . "'");
		$this->cache->delete('wkauctionbids');
		$this->cache->delete('wkauction');
	}

}
?>