<?php
class ModelCustomerpartnerMaster extends Model {
	

	public function getPartnerIdBasedonProduct($productid){
		return $this->db->query("SELECT c2p.customer_id as id FROM " . DB_PREFIX . "customerpartner_to_product c2p LEFT JOIN ".DB_PREFIX."product p ON(c2p.product_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) WHERE c2p.product_id = '".(int)$productid."' AND p.status = 1 AND p2s.store_id = '".$this->config->get('config_store_id')."' ORDER BY c2p.id ASC ")->row;
	}	

	public function getLatest() {
		$sql = "SELECT p.product_id,pd.description,p.image,p.price,p.tax_class_id,pd.name,c2c.avatar,c2c.backgroundcolor,c.customer_id,CONCAT(c.firstname ,' ',c.lastname) seller_name,co.name country, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special FROM " . DB_PREFIX . "customerpartner_to_product c2p LEFT JOIN ".DB_PREFIX ."product p ON (c2p.product_id = p.product_id) LEFT JOIN ".DB_PREFIX ."product_description pd ON (pd.product_id = p.product_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_customer c2c ON (c2c.customer_id = c2p.customer_id) LEFT JOIN ".DB_PREFIX ."customer c ON (c2c.customer_id = c.customer_id) LEFT JOIN ".DB_PREFIX ."country co ON (c2c.country = co.iso_code_2) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) WHERE c2c.is_partner = '1' AND p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '".$this->config->get('config_language_id')."' AND p2s.store_id = '".$this->config->get('config_store_id')."'";

		if ($this->config->get('marketplace_seller_product_list_limit')) {
			$sql .= 'ORDER BY c2p.product_id DESC limit '.$this->config->get('marketplace_seller_product_list_limit').'';
		}else{
			$sql .= 'ORDER BY c2p.product_id DESC limit 8';
		}
		
		$query = $this->db->query($sql);

		$products = array();
		foreach ($query->rows as $key => $value) {
			$products[$value['product_id']] = $value;
		}

		return $products;			
	}

	public function getPartnerCollectionCount($customerid){
		return count($this->db->query("SELECT DISTINCT p.product_id FROM " . DB_PREFIX . "customerpartner_to_product c2p LEFT JOIN ".DB_PREFIX ."product p ON (c2p.product_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) WHERE c2p.customer_id='".$customerid."' AND p.status='1' AND p.date_available <= NOW() AND p2s.store_id = '".$this->config->get('config_store_id')."' ORDER BY c2p.product_id ")->rows);
	}

	public function getOldPartner(){	

	    if ($this->config->get('marketplace_seller_list_limit')) {
			return $this->db->query("SELECT *,co.name as country,companylocality FROM " . DB_PREFIX . "customerpartner_to_customer c2c LEFT JOIN ".DB_PREFIX ."customer c ON (c2c.customer_id = c.customer_id) LEFT JOIN ".DB_PREFIX ."country co ON (c2c.country = co.iso_code_2) WHERE is_partner = 1 AND c.status = '1' ORDER BY c2c.customer_id ASC LIMIT ".$this->config->get('marketplace_seller_list_limit')."")->rows;	
		}else{
			return $this->db->query("SELECT *,co.name as country,companylocality FROM " . DB_PREFIX . "customerpartner_to_customer c2c LEFT JOIN ".DB_PREFIX ."customer c ON (c2c.customer_id = c.customer_id) LEFT JOIN ".DB_PREFIX ."country co ON (c2c.country = co.iso_code_2) WHERE is_partner = 1 AND c.status = '1' ORDER BY c2c.customer_id ASC LIMIT 4")->rows;	
		}	
		
	}

	public function getProfile($customerid){
		$sql = "SELECT *,c.firstname,c.lastname,co.name as country FROM " . DB_PREFIX . "customerpartner_to_customer c2c LEFT JOIN ".DB_PREFIX ."customer c ON (c2c.customer_id = c.customer_id) LEFT JOIN ".DB_PREFIX ."address a ON (c.address_id = a.address_id) LEFT JOIN ".DB_PREFIX ."country co ON (c2c.country = co.iso_code_2) WHERE c2c.customer_id = '".(int)$customerid."' AND c2c.is_partner = '1' AND c.status = '1'";

		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getFeedbackList($customerid) {
		$sql = "SELECT c2f.* FROM " . DB_PREFIX . "customerpartner_to_feedback c2f LEFT JOIN ".DB_PREFIX ."customer c ON (c2f.customer_id = c.customer_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_customer cpc ON (cpc.customer_id = c.customer_id) where c2f.seller_id = '".(int)$customerid."' AND c2f.status = '1'";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getTotalFeedback($customerid){
		$query = $this->db->query("SELECT id FROM " . DB_PREFIX . "customerpartner_to_feedback c2f where c2f.seller_id='".(int)$customerid."' AND c2f.status = '1'");
		return count($query->rows);
	}

	public function getAverageFeedback($customerid){

		 $sum = 0;

		$avg = $this->db->query("SELECT avg(feedprice) AS p,avg(feedvalue) AS v,avg(feedquality) AS q FROM `" . DB_PREFIX . "customerpartner_to_feedback` WHERE seller_id='".(int)$customerid."' AND status = '1'")->row;

		foreach ($avg as $value) {
			
              $sum += $value;
		}

		$rating = $sum / 3;

	  return $rating ;


	}

	public function getProductFeedbackList($customerid) {
		$query = $this->db->query("SELECT r.*,pd.name,r.text FROM " . DB_PREFIX . "customerpartner_to_product c2p INNER JOIN ".DB_PREFIX ."review r ON (c2p.product_id = r.product_id) LEFT JOIN ".DB_PREFIX."product_description pd ON (pd.product_id = c2p.product_id) WHERE c2p.customer_id = '".(int)$customerid."' AND pd.language_id = '".$this->config->get('config_language_id')."' AND r.status = 1 ");
		return $query->rows;
	}

	public function getTotalProductFeedbackList($customerid){
		$query = $this->db->query("SELECT r.* FROM " . DB_PREFIX . "customerpartner_to_product c2p INNER JOIN ".DB_PREFIX ."review r ON (c2p.product_id = r.product_id) WHERE c2p.customer_id = '".(int)$customerid."' AND r.status = 1 ");			
		return count($query->rows);
	}

	
	public function saveFeedback($data,$seller_id){
	
		$result = $this->db->query("SELECT id FROM ".DB_PREFIX ."customerpartner_to_feedback WHERE customer_id = ".$this->customer->getId()." AND seller_id = '".(int)$seller_id."'")->row;

		if(!$result){
			$this->db->query("INSERT INTO ".DB_PREFIX ."customerpartner_to_feedback SET customer_id = '".$this->customer->getId()."',seller_id = '".(int)$seller_id."', feedprice = '".(int)$this->db->escape($data['price_rating'])."',feedvalue = '".$this->db->escape($data['value_rating'])."',feedquality = '".$this->db->escape($data['quality_rating'])."', nickname = '".$this->db->escape($data['name'])."',  review = '".$this->db->escape($data['text'])."', createdate = NOW(), status = '0'");
		}else{
			$this->db->query("UPDATE ".DB_PREFIX ."customerpartner_to_feedback set feedprice='".$this->db->escape($data['price_rating'])."',feedvalue='".$this->db->escape($data['value_rating'])."',feedquality='".$this->db->escape($data['quality_rating'])."', nickname='".$this->db->escape($data['name'])."', review='".$this->db->escape($data['text'])."',createdate = NOW(), status = '0' WHERE id = '".$result['id']."'");			
		}

	}	
	
	public function getShopData($shop){
		$sql = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_to_customer where companyname = '" .$this->db->escape($shop)."'")->row;		
		if($sql)
			return false;		
		return true;
	}

	public function checkCustomerBought($seller_id){
         
         $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order o LEFT JOIN " . DB_PREFIX . "customerpartner_to_order c2o ON (o.order_id = c2o.order_id) where  o.customer_id = '" .$this->db->escape($this->customer->getId())."' AND c2o.customer_id = '" . (int)$this->db->escape($seller_id) . "'")->row;	

         return $query;
	}
    
    /**
     * [getAllAverageFeedback uses to fetch average feedprice, feedvalue, feedquality of the seller]
     * @return [type] [array]
     */
	public function getAllAverageFeedback($seller_id){
         
         $query = $this->db->query("SELECT round(avg(feedprice)) as avgprice, round(avg(feedvalue)) as avgvalue, round(avg(feedquality)) as avgquality FROM `" . DB_PREFIX . "customerpartner_to_feedback` WHERE seller_id='".(int)$seller_id."' AND status = '1'")->row;

        return $query;
	}


}
?>