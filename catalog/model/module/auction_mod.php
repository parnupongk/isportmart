<?php

################################################################################################
# Product auction for Opencart 2.1.x.x From webkul http://webkul.com    #
################################################################################################
class ModelModuleAuctionMod extends Model {
	
	public function getAuctionProduct($product_id){		
	      $result = $this->db->query("SELECT * FROM ".DB_PREFIX."wkauction wa LEFT JOIN ".DB_PREFIX."product p ON (wa.product_id = p.product_id) WHERE wa.product_id = '".(int)$product_id."' AND wa.isauction = '1' ")->row;
	    return $result;
	}

	public function remainProducts($limit, $products){
		
		$new = implode(',',$products);				
		$data = $this->db->query("SELECT wa.product_id FROM ".DB_PREFIX."wkauction wa LEFT JOIN ".DB_PREFIX."product p ON (wa.product_id = p.product_id) WHERE wa.product_id NOT IN (".$new.") ORDER BY wa.end_date ASC LIMIT ".$limit."")->rows;
		
		return $data;
	}
}

?>
