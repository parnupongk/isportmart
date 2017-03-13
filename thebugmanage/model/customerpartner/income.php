<?php 

class ModelCustomerpartnerIncome extends Model
{
	
	public function getIncomeDetails(){
		$sql = "SELECT cp2o.*,pd.name as product_name FROM ".DB_PREFIX."customerpartner_to_order cp2o LEFT JOIN ".DB_PREFIX."product p ON p.product_id = cp2o.product_id LEFT JOIN ".DB_PREFIX."product_description pd ON  cp2o.product_id = pd.product_id WHERE pd.language_id = ".$this->config->get('config_language_id')." ";
		$result = $this->db->query($sql)->rows;
		return $result;
	}

	public function getSellerList($data_filter){
		$sql = "SELECT cp2c.customer_id as customer_id,cp2c.commission,c.firstname,c.lastname FROM ".DB_PREFIX."customerpartner_to_customer cp2c LEFT JOIN ".DB_PREFIX."customer c ON cp2c.customer_id = c.customer_id WHERE 1 ";

		if($data_filter['seller_name']) {

			$sql .= "AND LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '%" . $this->db->escape(utf8_strtolower($data_filter['seller_name'])) . "%'";
		}

		if($data_filter['commission_from'] && $data_filter['commission_to']){
			$sql .= " AND cp2c.commission > ".$data_filter['commission_from']." AND cp2c.commission < ".$data_filter['commission_to']." ";
		} else if($data_filter['commission_from'] && !$data_filter['commission_to']) {
			$sql .= " AND cp2c.commission > ".$data_filter['commission_from']." ";
		} else if(!$data_filter['commission_from'] && $data_filter['commission_to']) {
			$sql .= " AND cp2c.commission < ".$data_filter['commission_to']."";
		}

		if($data_filter['order'] && ( $data_filter['order'] == 'c.firstname' || $data_filter['order'] == 'cp2c.commission') && $data_filter['sort']) {
			$sql .= " ORDER BY ".$data_filter['order']." ".$data_filter['sort']." ";
		}
		// $sql .= " LIMIT ".$data_filter['start'].",".$data_filter['limit']." ";
		// echo $sql;
		$result = $this->db->query($sql)->rows;
		return $result;
	}

	public function getDetails(){
		// $sql = "SELECT cp2c.customer_id as customer_id,cp2c.commission,c.firstname,c.lastname, SUM(c2o.quantity) quantity,(SUM(c2o.customer) + SUM(c2o.admin)) as total,SUM(c2o.admin) admin,SUM(c2o.customer) customer  FROM ".DB_PREFIX."customerpartner_to_customer cp2c LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON cp2c.customer_id=c2o.customer_id LEFT JOIN ".DB_PREFIX."customer c ON cp2c.customer_id = c.customer_id HAVING SUM(c2o.quantity) >= 0 ";

		$sql = "SELECT DISTINCT cp2c.customer_id,SUM(cp2o.customer+cp2o.admin) as total  FROM ".DB_PREFIX."customerpartner_to_customer cp2c LEFT JOIN ".DB_PREFIX."customerpartner_to_order cp2o ON cp2o.customer_id=cp2c.customer_id WHERE 1 ";

		$result = $this->db->query($sql)->rows;
		// echo "<pre>";
		// print_r($result);
		// echo "</pre>";
		// return $result;
	}

}
?>