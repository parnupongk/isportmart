<?php
class ModelModuleAuctionMod extends Model {

	/**
	 * [getAllAuctionProduct this function is for get all auction's products]
	 * @return [array] [this will return all auction product from wk_auction table]
	 */
	public function getAllAuctionProduct(){
		$query = $this->db->query("SELECT wa.* FROM ".DB_PREFIX."wkauction wa LEFT JOIN ".DB_PREFIX."product p ON (wa.product_id = p.product_id) WHERE wa.isauction = '1' ")->rows;

		return $query;
	}
	
} ?>