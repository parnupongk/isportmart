<?php
class ModelCatalogWkallauctions extends Model {

	public function getAuctions($filterValues){
		$date = new DateTime('2014-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
		$zone = $date->format('P');
		$query = "SELECT CONVERT_TZ(NOW(), @@session.time_zone, '$zone') as time;";
		$data_time = $this->db->query($query)->row;
		$time = date("Y-m-d H:i:s", strtotime($data_time['time']));

		$url = "SELECT cp.product_id,cp.image,a.name,a.min,a.max,a.start_date,a.end_date FROM " . DB_PREFIX . "wkauction a LEFT JOIN " . DB_PREFIX . "product cp ON (a.product_id=cp.product_id) ";
		if(!empty($filterValues['category'])){
		  $url .= "LEFT JOIN ".DB_PREFIX."product_to_category p2c ON p2c.product_id=a.product_id WHERE p2c.category_id ='".$filterValues['category']."' AND a.isauction=1 AND a.start_date <= '".$time."' AND end_date >= '".$time."' ORDER BY a.end_date ASC LIMIT ".$filterValues['start'].",".$filterValues['limit'];
		}else{
		  $url .="WHERE a.isauction=1 AND a.start_date <= '".$time."' AND end_date >= '".$time."' ORDER BY a.end_date ASC LIMIT ".$filterValues['start'].",".$filterValues['limit'];
		}

		$dat = $this->db->query($url);
		return $dat->rows;
	}
	
	public function getAuctionsCount($filterValues){
		$date = new DateTime('2014-06-1', new DateTimeZone($this->config->get('wkproduct_auction_timezone_set')));
		$zone = $date->format('P');
		$query = "SELECT CONVERT_TZ(NOW(), @@session.time_zone, '$zone') as time;";
		$data_time = $this->db->query($query)->row;
		$time = date("Y-m-d H:i:s", strtotime($data_time['time']));
		
		$url = "SELECT cp.product_id,cp.image,a.name,a.min,a.max,a.start_date,a.end_date FROM " . DB_PREFIX . "wkauction a LEFT JOIN " . DB_PREFIX . "product cp ON (a.product_id=cp.product_id) ";
		if(!empty($filterValues['category'])){
		  $url .= "LEFT JOIN ".DB_PREFIX."product_to_category p2c ON p2c.product_id=a.product_id WHERE p2c.category_id ='".$filterValues['category']."' AND a.isauction=1 AND a.start_date <= '".$time."' AND end_date >= '".$time."' ORDER BY a.end_date ASC LIMIT ".$filterValues['start'].",".$filterValues['limit'];
		}else{
		  $url .="WHERE a.isauction=1 AND a.start_date <= '".$time."' AND end_date >= '".$time."' ORDER BY a.end_date ASC LIMIT ".$filterValues['start'].",".$filterValues['limit'];
		}
		
		$dat = $this->db->query($url);
		return count($dat->rows);
	}
	
	public function getRecentAuctions(){
		$auc = $this->db->query("SELECT wab.user_bid,c.firstname,c.lastname,p.image,pd.name FROM ".DB_PREFIX."wkauctionbids wab LEFT JOIN ".DB_PREFIX."customer c ON wab.user_id =c.customer_id LEFT JOIN ".DB_PREFIX."product p ON  wab.product_id=p.product_id LEFT JOIN ".DB_PREFIX."product_description pd ON p.product_id=pd.product_id WHERE winner = 1 ORDER BY wab.end_date DESC LIMIT 0,3")->rows;

        // automatic auction
		$auto_auc = $this->db->query("SELECT wab.user_bid,c.firstname,c.lastname,p.image,pd.name FROM ".DB_PREFIX."wk_automatic_auctionbids wab LEFT JOIN ".DB_PREFIX."customer c ON wab.user_id =c.customer_id LEFT JOIN ".DB_PREFIX."product p ON  wab.product_id=p.product_id LEFT JOIN ".DB_PREFIX."product_description pd ON p.product_id=pd.product_id WHERE winner = 1 ORDER BY wab.end_date DESC LIMIT 0,3")->rows;
		
// automatic auction
        foreach ($auto_auc as $value) {
        	
        	 array_push($auc, $value);
        }
			return $auc;
	}
}
?>