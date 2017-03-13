<?php
class ModelCustomerpartnerProduct extends Model {

	public function getProduct($product_id) {
		if($product_id) {
			$product = $this->db->query("SELECT *,pd.name as product_name,ss.name as stock_status_name FROM ".DB_PREFIX."product p LEFT JOIN ".DB_PREFIX."product_description pd ON (p.product_id=pd.product_id) LEFT JOIN ".DB_PREFIX."stock_status ss ON (p.stock_status_id=ss.stock_status_id) WHERE p.product_id = '".(int)$product_id."' ")->row;
			if($product) {
				return $product;
			} else {
				return false;
			}
		}
	}

	private $data = array();

	//to clear products which are not in product table (currently code adding using xml file so used return)
	public function clearProductGarbage(){
		return;
		$removed_products = $this->db->query("SELECT DISTINCT product_id FROM ".DB_PREFIX."customerpartner_to_product WHERE product_id NOT IN (SELECT DISTINCT c2p.product_id FROM ".DB_PREFIX."customerpartner_to_product c2p INNER JOIN ".DB_PREFIX."product p ON (c2p.product_id=p.product_id))")->rows;

		foreach($removed_products as $product){
			$this->deleteProduct($product['product_id']);
		}
	}

	public function addProduct($data) {

		$this->db->query("UPDATE " . DB_PREFIX . "product SET status = 1 WHERE product_id = '".(int)$data['product_id']."'");

		if(!$this->config->get('marketplace_mail_product_approve'))
			return;

		$mail_id = $this->config->get('marketplace_mail_product_approve');

		//get product details
		$this->load->model('catalog/product');
		$data = $this->model_catalog_product->getProduct($data['product_id']);

		//add seller id with product data
		$data['customer_id'] = $this->getSellerbasedonProduct($data['product_id']);

		if(!$data['customer_id'])
			return;

		$this->load->model('customerpartner/mail');
	    $this->model_customerpartner_mail->mail($data,'seller_product_approve');

	}	
	
	public function deleteProduct($product_id) {

       $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_to_product WHERE product_id = '" . (int)$product_id . "'");
       $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_sold_tracking WHERE product_id = '" . (int)$product_id . "'");
	
	}
		
	public function getProducts($data = array()) {

		$this->clearProductGarbage();

		if ($data) {		
			//for product autocomplete at time of allocated to seller
			if(isset($data['filter_for_seller']) AND $data['filter_for_seller'])
				$sql = "SELECT DISTINCT p.product_id,p.*,pd.name,c2p.customer_id  FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN ".DB_PREFIX."customerpartner_to_product c2p ON (c2p.product_id = p.product_id) ";
			else // work as default to return product
				$sql = "SELECT DISTINCT p.product_id,p.*,pd.name,c.firstname,c.lastname,c.customer_id FROM " . DB_PREFIX . "customerpartner_to_product c2p LEFT JOIN ".DB_PREFIX."product p ON (p.product_id = c2p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN ".DB_PREFIX."customer c ON (c2p.customer_id = c.customer_id) ";			
			$sql .= "WHERE 1 ";

			if (!empty($data['filter_name'])) {
				$sql .= " AND LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
			}

			if (!empty($data['filter_seller'])) {
				$sql .= " AND LCASE(CONCAT(c.firstname,' ',c.lastname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_seller'])) . "%'";
			}

			if (!empty($data['filter_model'])) {
				$sql .= " AND LCASE(p.model) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_model'])) . "%'";
			}
			
			if (!empty($data['filter_price'])) {
				$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
			}
			
			if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
				$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
			}
			

			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
			}
						
			$sql .= " GROUP BY p.product_id";
						
			$sort_data = array(
				'pd.name',
				'p.model',
				'p.price',
				'p.quantity',
				'p.product_id',
				'p.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY pd.name";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
			

			$query = $this->db->query($sql);

			return $query->rows;
		}
	}
	

	public function getTotalProducts($data = array()) {

		$sql = "SELECT p.*,pd.name,c.firstname,c.lastname,c.customer_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) RIGHT JOIN ".DB_PREFIX."customerpartner_to_product c2p ON (p.product_id = c2p.product_id) LEFT JOIN ".DB_PREFIX."customer c ON (c2p.customer_id = c.customer_id) ";						
		
		$sql .= "WHERE 1 ";

		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_seller'])) {
			$sql .= " AND LCASE(CONCAT(c.firstname,' ',c.lastname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_seller'])) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND LCASE(p.model) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_model'])) . "%'";
		}
		
		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}
		
		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}		
		
		$sql .= " GROUP BY p.product_id";

		$query = $this->db->query($sql);

		return count($query->rows);
	}		

	public function getDownload($download_id) {
		$query = $this->db->query("SELECT CONCAT(c.firstname,' ',c.lastname) name FROM " . DB_PREFIX . "customerpartner_download cd LEFT JOIN " . DB_PREFIX . "customer c ON (cd.seller_id = c.customer_id) WHERE cd.download_id = '" . (int)$download_id . "'")->row;
		if(isset($query['name']))
			return $query['name'];
		else			
			return false;
	}

	public function getSellerbasedonProduct($product_id) {
		$result = $this->db->query("SELECT customer_id FROM ".DB_PREFIX."customerpartner_to_product WHERE product_id = '".(int)$product_id."' ORDER BY id ASC LIMIT 1")->row;
		if($result)
			return $result['customer_id'];
		else			
			return false;
	}
	
}
?>