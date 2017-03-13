<?php
################################################################################################
#  Product auction for Opencart 1.5.1.x From webkul http://webkul.com  	  	       #
################################################################################################
class ModelModuleWkproductauction extends Model {
	
	public function createEventTable() 
	{
		$sql="CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "wkauction(id INT PRIMARY KEY AUTO_INCREMENT, product_id integer,name varchar(50), isauction varchar(5), min varchar(25),max varchar(25),start_date varchar(30),end_date varchar(30),quantity_limit int(5),voucher_time_limit varchar(30))";
		$this->db->query($sql);
		$sql="CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "wkauctionbids(id INT PRIMARY KEY AUTO_INCREMENT, product_id integer, auction_id integer,user_id integer,date varchar(30),start_date varchar(30),end_date varchar(30), user_bid double,winner varchar(2),sold varchar(2))";
		$this->db->query($sql);

		//Automatic bidding
	    $sql="CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "wk_automatic_auctionbids(autoauction_id INT PRIMARY KEY AUTO_INCREMENT, product_id integer, auction_id integer,user_id integer,date varchar(30),start_date varchar(30),end_date varchar(30), user_bid double,winner varchar(2),sold varchar(2))";
		$this->db->query($sql);
	}

	public function createCoulumn(){

		$query= $this->db->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`= '".DB_DATABASE."' AND `TABLE_NAME`='" . DB_PREFIX . "customerpartner_to_order';")->rows;

        foreach ($query as $value) {
            
            if ($value['COLUMN_NAME'] =='coupon_price') {

                return false;
                
            }
            
        }

        $query=$this->db->query("ALTER TABLE  ".DB_PREFIX ."customerpartner_to_order ADD coupon_price TEXT");

        return false;
	}

}
?>
