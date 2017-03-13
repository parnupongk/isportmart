<?php
const MPIMAGEFOLDER = 'catalog/';

class Modelcustomerpartnercustomerpartner extends Model {

	//Product
	public function chkSellerPoductAccess($product_id){					
		$sql = $this->db->query("SELECT c2p.customer_id FROM ".DB_PREFIX ."customerpartner_to_product c2p LEFT JOIN ".DB_PREFIX ."product p ON (c2p.product_id = p.product_id) WHERE p.product_id = '".(int)$product_id."' ORDER BY c2p.id ASC");

		if($sql->row){
			if($sql->row['customer_id'] == $customer_id)		
				return true;
			else
				return false;
		}else{
			return false;
		}
	}

	public function getProductKeyword($product_id){	
		$result = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'")->row;

		if($result)
			return $result['keyword'];
	}

	// Productlist
	public function getProductSoldQuantity($product_id){
		$sql = $this->db->query("SELECT SUM(c2o.quantity) quantity, SUM(c2o.price) total FROM ".DB_PREFIX ."customerpartner_to_order c2o LEFT JOIN ".DB_PREFIX ."customerpartner_to_product c2p ON (c2o.product_id = c2p.product_id AND c2o.customer_id = c2p.customer_id ) WHERE c2o.customer_id = '".$customer_id."' and c2p.product_id = '".(int)$product_id."'");
		
		return($sql->row);
	}
	
	public function getProduct($product_id) {

		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			return array(
				'product_id'       => $query->row['product_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_title'       => $query->row['meta_title'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'model'            => $query->row['model'],
				'sku'              => $query->row['sku'],
				'upc'              => $query->row['upc'],
				'ean'              => $query->row['ean'],
				'jan'              => $query->row['jan'],
				'isbn'             => $query->row['isbn'],
				'mpn'              => $query->row['mpn'],
				'location'         => $query->row['location'],
				'quantity'         => $query->row['quantity'],
				'stock_status'     => $query->row['stock_status'],
				'image'            => $query->row['image'],
				'manufacturer_id'  => $query->row['manufacturer_id'],
				'manufacturer'     => $query->row['manufacturer'],
				'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
				'special'          => $query->row['special'],
				'reward'           => $query->row['reward'],
				'points'           => $query->row['points'],
				'tax_class_id'     => $query->row['tax_class_id'],
				'date_available'   => $query->row['date_available'],
				'weight'           => $query->row['weight'],
				'weight_class_id'  => $query->row['weight_class_id'],
				'length'           => $query->row['length'],
				'width'            => $query->row['width'],
				'height'           => $query->row['height'],
				'length_class_id'  => $query->row['length_class_id'],
				'subtract'         => $query->row['subtract'],
				'rating'           => round($query->row['rating']),
				'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
				'minimum'          => $query->row['minimum'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed'],

				//for mp
				'shipping'         => $query->row['shipping'],
				'stock_status_id'  => $query->row['stock_status_id'],
			);
		} else {
			return false;
		}
	}

	public function getProductsSeller($data = array()) {

		$sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "customerpartner_to_product c2p ON (c2p.product_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)";

		if (isset($data['filter_category_id']) AND $data['filter_category_id']) {
			$sql .= " LEFT JOIN " . DB_PREFIX ."product_to_category p2c ON (p.product_id = p2c.product_id)";
		}

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 

		if (isset($data['filter_category_id']) AND $data['filter_category_id']) {		
			$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
		}

		if (isset($data['filter_name']) AND !empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_model']) AND !empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (isset($data['filter_price']) AND !empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
		}

		if (isset($data['filter_store']) && !is_null($data['filter_store'])) {
			$sql .= " AND p2s.store_id = '" . (int)$data['filter_store'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		if(!isset($data['customer_id']) || !$data['customer_id'])
			$sql .= " AND c2p.customer_id = ". $customer_id ;
		else		
			$sql .= " AND c2p.customer_id = ". (int)$data['customer_id'] ;

		$sql .= " GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
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

		$product_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}

	public function getTotalProductsSeller($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "customerpartner_to_product c2p ON (c2p.product_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)";

		if (isset($data['filter_category_id']) AND $data['filter_category_id']) {
			$sql .= " LEFT JOIN " . DB_PREFIX ."product_to_category p2c ON (p.product_id = p2c.product_id)";
		}

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 

		if (isset($data['filter_category_id']) AND $data['filter_category_id']) {		
			$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
		}

		if (isset($data['filter_name']) AND !empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_model']) AND !empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (isset($data['filter_store']) && !is_null($data['filter_store'])) {
			$sql .= " AND p2s.store_id = '" . (int)$data['filter_store'] . "'";
		}

		if (isset($data['filter_price']) AND !empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		if(!isset($data['customer_id']) || !$data['customer_id'])
			$sql .= " AND c2p.customer_id = ". $customer_id ;
		else		
			$sql .= " AND c2p.customer_id = ". (int)$data['customer_id'] ;

		$query = $this->db->query($sql);

		return count($query->rows);
	}

	public function deleteProduct($product_id) {

		if($this->chkSellerPoductAccess($product_id)){

			$this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_to_product WHERE product_id = '" . (int)$product_id . "'");

			//if seller can delete product from store
			if($this->config->get('marketplace_sellerdeleteproduct')){   
       	            
				$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
         	}

		}
		
	}

	public function addProduct($data){	

		$data['status'] = $this->config->get('marketplace_productapprov');		

		$renamedImage = '';
		$renamedOImage = array();
		$files = $this->request->files;

		if (isset($files['image']['name']) AND $files['image']['name']) {
			$renamedImage = rand(100000,999999) . basename(preg_replace('~[^\w\./\\\\]+~', '', $files['image']["name"]));
			//upload product base image
			move_uploaded_file($files["image"]["tmp_name"], DIR_IMAGE . MPIMAGEFOLDER .$renamedImage);
		}

		if (isset($files['product_image']['name']) AND $files['product_image']['name']) {
			foreach ($files['product_image']['name'] as $index => $product_image) {				

				$renamedImg = rand(100000,999999) . basename(preg_replace('~[^\w\./\\\\]+~', '', $product_image['image']));
				//upload product images
				move_uploaded_file($files['product_image']["tmp_name"][$index]['image'], DIR_IMAGE . MPIMAGEFOLDER .$renamedImg);

				$renamedOImage[] = $renamedImg;
			}
		}
		
		$sql = "INSERT INTO `" . DB_PREFIX . "product` SET ";

		$sql = $this->productQuery($sql,$data);

		$sql .= " date_added = NOW() ";

		$this->db->query($sql);

		$product_id = $this->db->getLastId();

		if($renamedImage){
			$this->db->query("UPDATE `" . DB_PREFIX . "product` SET image = '" . MPIMAGEFOLDER .$this->db->escape(html_entity_decode($renamedImage, ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");
		}

		if ($renamedOImage) {
			foreach ($renamedOImage as $index => $product_image) {				
				$this->db->query("INSERT INTO " . DB_PREFIX ."product_image SET product_id = '" . (int)$product_id . "', image = '" . MPIMAGEFOLDER . $this->db->escape(html_entity_decode($product_image, ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$data['product_image'][$index]['sort_order'] . "'");
			}
		}
		
		$this->productAddUpdate($product_id,$data);
		

		//for customerpartner_to_product

		$sql = "INSERT INTO `" . DB_PREFIX . "customerpartner_to_product` SET `product_id` = " . (int)$product_id . ",customer_id = '".$customer_id."'";

		if (isset($data['quantity'])) {
			$sql .= ", quantity = '" . $this->db->escape($data['quantity']) . "'";
		}

		if (isset($data['price'])) {
			$sql .= ", price = '" . $this->db->escape($data['price']) . "'";
		}

		$this->db->query($sql);


		$data['name'] = isset($data['product_description'][$this->config->get('config_language_id')]['name']) ? $data['product_description'][$this->config->get('config_language_id')]['name'] : '';

		//send mail to Customer after adding Product
        $this->load->model('customerpartner/mail');
        $this->model_customerpartner_mail->mail($data,'seller_added_product_to_seller');

		if($this->config->get('marketplace_productaddemail')) //add product mail end to admin
        	$this->model_customerpartner_mail->mail($data,'seller_added_product_to_admin');
		
	}

	public function editProduct($data) {

		if(!isset($this->request->get['product_id']))
			return;
		
		// $data['status'] = $this->config->get('marketplace_productapprov');		

		$product_id = $this->request->get['product_id'];
				
		$files = $this->request->files;

		$renamedImage = '';

		if (isset($files['image']['name']) AND $files['image']['name']) {

			$renamedImage = rand(100000,999999) . basename(preg_replace('~[^\w\./\\\\]+~', '', $files['image']["name"]));
			//upload product base image
			move_uploaded_file($files["image"]["tmp_name"], DIR_IMAGE . MPIMAGEFOLDER .$renamedImage);

			if(isset($data['image']) AND $data['image'] AND file_exists(DIR_IMAGE.$data['image']))
					unlink(DIR_IMAGE.$data['image']);

		}

		//to remove previous image from folder	
		if (isset($files['product_image']['name']) AND $files['product_image']['name']) {
			foreach ($files['product_image']['name'] as $index => $product_image) {				

				if($product_image['image']){
					$newImage = rand(100000,999999) . basename(preg_replace('~[^\w\./\\\\]+~', '', $product_image['image']));
					//upload product images
					move_uploaded_file($files['product_image']["tmp_name"][$index]['image'], DIR_IMAGE . MPIMAGEFOLDER .$newImage);

					if(isset($data['product_image'][$index]['image']) AND $data['product_image'][$index]['image'] AND file_exists(DIR_IMAGE.$data['product_image'][$index]['image']))
						unlink(DIR_IMAGE.$data['product_image'][$index]['image']);

					$data['product_image'][$index]['image'] = MPIMAGEFOLDER.$newImage;

				}
			}
		}

		$sql = "UPDATE `" . DB_PREFIX . "product` SET ";

		$sql = $this->productQuery($sql,$data);

		$sql .= " date_modified = NOW() WHERE product_id = '".(int)$product_id."'";

		$this->db->query($sql);

		if($renamedImage)
			$this->db->query("UPDATE `" . DB_PREFIX . "product` SET image = '" . MPIMAGEFOLDER .$this->db->escape(html_entity_decode($renamedImage, ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");

		
		$removeImages = $this->db->query("SELECT image FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'")->rows;

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_image']) AND $data['product_image']) {
		 	foreach ($data['product_image'] as $product_image) {
		 		if($product_image['image'])
		 			$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '".$product_image['sort_order']."'");
		 	}
		}else{
			//remove all images
			if($removeImages){
				foreach ($removeImages as $value) {
					if(file_exists(DIR_IMAGE.$value['image']))
						unlink(DIR_IMAGE.$value['image']);
				}
			}
		}
		
		$this->productAddUpdate($product_id,$data);		

		//for customerpartner_to_product

		if(isset($data['quantity']) || isset($data['price'])){

			$sql = "UPDATE `" . DB_PREFIX . "customerpartner_to_product` SET ";

			if (isset($data['quantity'])) {
				$sql .= " quantity = '" . $this->db->escape($data['quantity']) . "'";
			}

			if (isset($data['price'])) {
				$sql .= ", price = '" . $this->db->escape($data['price']) . "'";
			}

			$sql .= " WHERE `product_id` = " . (int)$this->request->get['product_id'] ." AND customer_id = '".$customer_id."'";

			$this->db->query($sql);

		}

	}

	public function productQuery($sql,$data){

		$implode = array();

		if (isset($data['model'])) {
			$implode[] = "model = '" . $this->db->escape($data['model']) . "'";
		}

		if (isset($data['sku'])) {
			$implode[] = "sku = '" . $this->db->escape($data['sku']) . "'";
		}

		if (isset($data['upc'])) {
			$implode[] = "upc = '" . $this->db->escape($data['upc']) . "'";
		}

		if (isset($data['ean'])) {
			$implode[] = "ean = '" . $this->db->escape($data['ean']) . "'";
		}

		if (isset($data['jan'])) {
			$implode[] = "jan = '" . $this->db->escape($data['jan']) . "'";
		}

		if (isset($data['isbn'])) {
			$implode[] = "isbn = '" . $this->db->escape($data['isbn']) . "'";
		}

		if (isset($data['mpn'])) {
			$implode[] = "mpn = '" . $this->db->escape($data['mpn']) . "'";
		}

		if (isset($data['location'])) {
			$implode[] = "location = '" . $this->db->escape($data['location']) . "'";
		}

		if (isset($data['quantity'])) {
			$implode[] = "quantity = '" . $this->db->escape($data['quantity']) . "'";
		}

		if (isset($data['minimum'])) {
			$implode[] = "minimum = '" . $this->db->escape($data['minimum']) . "'";
		}

		if (isset($data['subtract'])) {
			$implode[] = "subtract = '" . $this->db->escape($data['subtract']) . "'";
		}

		if (isset($data['stock_status_id'])) {
			$implode[] = "stock_status_id = '" . $this->db->escape($data['stock_status_id']) . "'";
		}

		if (isset($data['date_available'])) {
			$implode[] = "date_available = '" . $this->db->escape($data['date_available']) . "'";
		}

		if (isset($data['manufacturer_id'])) {
			$implode[] = "manufacturer_id = '" . $this->db->escape($data['manufacturer_id']) . "'";
		}

		if (isset($data['shipping'])) {
			$implode[] = "shipping = '" . $this->db->escape($data['shipping']) . "'";
		}

		if (isset($data['price'])) {
			$implode[] = "price = '" . $this->db->escape($data['price']) . "'";
		}

		if (isset($data['points'])) {
			$implode[] = "points = '" . $this->db->escape($data['points']) . "'";
		}

		if (isset($data['weight'])) {
			$implode[] = "weight = '" . $this->db->escape($data['weight']) . "'";
		}

		if (isset($data['weight_class_id'])) {
			$implode[] = "weight_class_id = '" . $this->db->escape($data['weight_class_id']) . "'";
		}

		if (isset($data['length'])) {
			$implode[] = "length = '" . $this->db->escape($data['length']) . "'";
		}

		if (isset($data['width'])) {
			$implode[] = "width = '" . $this->db->escape($data['width']) . "'";
		}

		if (isset($data['height'])) {
			$implode[] = "height = '" . $this->db->escape($data['height']) . "'";
		}

		if (isset($data['length_class_id'])) {
			$implode[] = "length_class_id = '" . $this->db->escape($data['length_class_id']) . "'";
		}

		if (isset($data['status'])) {
			$implode[] = "status = '" . $this->db->escape($data['status']) . "'";
		}

		if (isset($data['tax_class_id'])) {
			$implode[] = "tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "'";
		}

		if (isset($data['sort_order'])) {
			$implode[] = "sort_order = '" . $this->db->escape($data['sort_order']) . "'";
		}

		if ($implode) {
			$sql .=  implode(" , ", $implode)." , " ;
		}

		return $sql;
	}

	public function productAddUpdate($product_id,$data){

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

		if(isset($data['product_description'])){
			foreach ($data['product_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_description` SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "'");
			}
		}

		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = 0 ");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {

					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {				
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");

					$product_option_id = $this->db->getLastId();

					if (isset($product_option['product_option_value']) && count($product_option['product_option_value']) > 0 ) {
						foreach ($product_option['product_option_value'] as $product_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
						} 
					}else{
						$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_option_id = '".$product_option_id."'");
					}
				} else { 
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->db->escape($product_option['option_value']) . "', required = '" . (int)$product_option['required'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$product_reward['points'] . "'");
			}
		}
		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");

		if (isset($data['keyword']) AND $data['keyword']) {	
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}		

	}


	public function getProductDescriptions($product_id) {
		$product_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'tag'              => $result['tag']
			);
		}
		
		return $product_description_data;
	}

	public function getProductCategories($product_id) {
		$product_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}

	public function getProductFilters($product_id) {
		$product_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX ."product_filter WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_filter_data[] = $result['filter_id'];
		}

		return $product_filter_data;
	}

	public function getProductAttributes($product_id) {

		$product_attribute_data = array();

		$product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text, ad.language_id FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' ORDER BY a.sort_order, ad.name");

		$product_attribute_description_data = array();

		foreach ($product_attribute_query->rows as $product_attribute) {

			$product_attribute_description_data[$product_attribute['language_id']] = array(
															'name' => $product_attribute['name'],
															'text' => $product_attribute['text']
															);		

			$product_attribute_data[] = array(
				'attribute_id'                  => $product_attribute['attribute_id'],
				'name'                  		=> $product_attribute['name'],
				'product_attribute_description' => $product_attribute_description_data
			);
		}

		return $product_attribute_data;
	}

	public function getProductOptions($product_id,$tabletype = '') {
		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . $tabletype."product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();	

			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . $tabletype."product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");

			foreach ($product_option_value_query->rows as $product_option_value) {
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'option_value_id'         => $product_option_value['option_value_id'],
					'quantity'                => $product_option_value['quantity'],
					'subtract'                => $product_option_value['subtract'],
					'price'                   => $product_option_value['price'],
					'price_prefix'            => $product_option_value['price_prefix'],
					'points'                  => $product_option_value['points'],
					'points_prefix'           => $product_option_value['points_prefix'],						
					'weight'                  => $product_option_value['weight'],
					'weight_prefix'           => $product_option_value['weight_prefix']					
				);
			}

			$product_option_data[] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],			
				'product_option_value' => $product_option_value_data,
				'option_value'         => $product_option['value'],
				'required'             => $product_option['required']				
			);
		}

		return $product_option_data;
	}

	public function getProductDiscounts($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX ."product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

	public function getProductSpecials($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	public function getProductRewards($product_id) {
		$product_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $product_reward_data;
	}

	public function getProductDownloads($product_id) {
		$product_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_download_data[] = $result['download_id'];
		}

		return $product_download_data;
	}

	public function getProductRelated($product_id,$tabletype = '') {
		$product_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . $tabletype."product_related WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}

		return $product_related_data;
	}	

	public function getProductRelatedInfo($product_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}






	// Proifle and seller info
	public function IsApplyForSellership(){
		$query = $this->db->query("SELECT customer_id FROM ".DB_PREFIX ."customerpartner_to_customer WHERE customer_id = '".(int)$customer_id."'")->row;

		if($query){
			return true;
		}else{
			return false;
		}
		
	}

	public function chkIsPartner(){
					
		$sql = $this->db->query("SELECT * FROM ".DB_PREFIX ."customerpartner_to_customer WHERE customer_id = '" . (int)$customer_id . "'");

		if(count($sql->row) && $sql->row['is_partner']==1){
			return true;
		}else{
			return false;
		}
	}

	// Become partner
	public function becomePartner($shop, $message = ''){

        $commission = $this->config->get('marketplace_commission') ? $this->config->get('marketplace_commission') : 0;

        if($this->config->get('marketplace_partnerapprov')){	
        	$this->db->query("INSERT INTO ".DB_PREFIX."customerpartner_to_customer set customer_id = '" .(int)$customer_id."', is_partner='1', commission = '".(float)$commission."', companyname = '".$this->db->escape($shop)."' ");
        }else{        	
        	$this->db->query("INSERT INTO ".DB_PREFIX."customerpartner_to_customer set customer_id = '" .(int)$customer_id."', is_partner='0', companyname = '".$this->db->escape($shop)."'");
        }

        $data = array('message' => $message,
        			  'shop' => $shop,
        			  'commission' => $commission
        			  );

        //send mail to Admin / Customer after request for Partnership
        $this->load->model('customerpartner/mail');
        $this->model_customerpartner_mail->mail($data,'customer_applied_for_partnership_to_seller');
        $this->model_customerpartner_mail->mail($data,'customer_applied_for_partnership_to_admin');
					
	}	

	public function updateProfile($data){

		$impolde = array();

		// foreach ($data as $key => $value) {
		// 	$impolde[] = strtolower($key).'= "'.$this->db->escape($value).'"';
		// }

		if(isset($data['screenName']))
			$impolde[] = 'screenname = "'.$this->db->escape($data['screenName']).'"';

		if(isset($data['gender']))
			$impolde[] = 'gender = "'.$this->db->escape($data['gender']).'"';

		if(isset($data['shortProfile']))
			$impolde[] = 'shortprofile = "'.$this->db->escape($data['shortProfile']).'"';

		if(isset($data['twitterId']))
			$impolde[] = 'twitterid = "'.$this->db->escape($data['twitterId']).'"';

		if(isset($data['facebookId']))
			$impolde[] = 'facebookid = "'.$this->db->escape($data['facebookId']).'"';

		if(isset($data['backgroundcolor']))
			$impolde[] = 'backgroundcolor = "'.$this->db->escape($data['backgroundcolor']).'"';

		if(isset($data['companyLocality']))
			$impolde[] = 'companylocality = "'.$this->db->escape($data['companyLocality']).'"';

		if(isset($data['companyName']))
			$impolde[] = 'companyname = "'.$this->db->escape($data['companyName']).'"';

		if(isset($data['companyDescription']))
			$impolde[] = 'companydescription = "'.$this->db->escape($data['companyDescription']).'"';

		if(isset($data['otherpayment']))
			$impolde[] = 'otherpayment = "'.$this->db->escape($data['otherpayment']).'"';

		if(isset($data['country']))
			$impolde[] = 'country = "'.$this->db->escape($data['country']).'"';

		if(isset($data['countryLogo']))
			$impolde[] = 'countrylogo = "'.$this->db->escape($data['countryLogo']).'"';

		if(isset($data['paypalid']))
			$impolde[] = 'paypalid = "'.$this->db->escape($data['paypalid']).'"';

		if($impolde){

			$sql = "UPDATE ".DB_PREFIX ."customerpartner_to_customer SET ";
			$sql .= implode(", ",$impolde);
			$sql .= " WHERE customer_id = '".$customer_id."'";

			$this->db->query($sql);
		}		

		$files = $this->request->files;
		
		if(isset($files['companyBanner']['name']) AND $files['companyBanner']['name']){
			$files['companyBanner']['name'] = rand(100000,999999) . $files['companyBanner']["name"];
			$this->db->query("UPDATE ".DB_PREFIX ."customerpartner_to_customer set companybanner='catalog/".$this->db->escape($files['companyBanner']['name'])."' where customer_id='".$customer_id."'");
			move_uploaded_file($files['companyBanner']["tmp_name"], DIR_IMAGE . "catalog/" . $files['companyBanner']["name"]);
		}

		if(isset($files['companyLogo']['name']) AND $files['companyLogo']['name']){
			$files['companyLogo']['name'] = rand(100000,999999) . $files['companyLogo']["name"];
			$this->db->query("UPDATE ".DB_PREFIX ."customerpartner_to_customer set companylogo='catalog/".$this->db->escape($files['companyLogo']['name'])."' where customer_id='".$customer_id."'");
			move_uploaded_file($files['companyLogo']["tmp_name"], DIR_IMAGE . "catalog/" . $files['companyLogo']["name"]);
		}
	
		if(isset($files['avatar']['name']) AND $files['avatar']['name']){
			$files['avatar']['name'] = rand(100000,999999) . $files['avatar']["name"];
			$this->db->query("UPDATE ".DB_PREFIX ."customerpartner_to_customer set avatar='catalog/".$this->db->escape($files['avatar']['name'])."' where customer_id='".$customer_id."'");
			move_uploaded_file($files['avatar']["tmp_name"], DIR_IMAGE . "catalog/" . $files['avatar']["name"]);
		}
		
	}
	
	public function getProfile(){
		return $this->db->query("SELECT * FROM ".DB_PREFIX ."customerpartner_to_customer c2c LEFT JOIN ".DB_PREFIX."customer c ON (c2c.customer_id = c.customer_id) where c2c.customer_id = '".$customer_id."'")->row;
	}

	public function getCountry(){
		return $this->db->query("SELECT * FROM ".DB_PREFIX ."country")->rows;
	}		





	// Order
	public function getOrderHistories($order_id) {
		$query = $this->db->query("SELECT date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added");
	
		return $query->rows;
	}	

	public function addOrderHistory($order_id, $data) {

		//$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$data['order_status_id'] . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$data['order_status_id'] . "', notify = '" . (isset($data['notify']) ? (int)$data['notify'] : 0) . "', comment = '" . $this->db->escape(strip_tags($data['comment'])) . "', date_added = NOW()");

		$order_info = $this->getOrder($order_id);

		$sellerEmail = $this->customer->getEmail();

		$this->language->load('account/customerpartner/orderinfo');

      	if ($data['notify']) {

			$subject = sprintf($this->language->get('m_text_subject'), $order_info['store_name'], $order_id);

			$message  = $this->language->get('m_text_order') . ' ' . $order_id . "\n";
			$message .= $this->language->get('m_text_date_added') . ' ' . date($this->language->get('m_date_format_short'), strtotime($order_info['date_added'])) . "\n\n";
			
			$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$data['order_status_id'] . "' AND language_id = '" . (int)$order_info['language_id'] . "'");
				
			if ($order_status_query->num_rows) {
				$message .= $this->language->get('m_text_order_status') . "\n";
				$message .= $order_status_query->row['name'] . "\n\n";
			}
			
			if ($order_info['customer_id']) {
				$message .= $this->language->get('m_text_link') . "\n";
				$message .= html_entity_decode($order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id, ENT_QUOTES, 'UTF-8') . "\n\n";
			}
			
			if ($data['comment']) {
				$message .= $this->language->get('m_text_comment') . "\n\n";
				$message .= strip_tags(html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
			}

			$message .= $this->language->get('m_text_footer');

			$mail = new Mail($this->config->get('config_mail'));			
			$mail->setTo($order_info['email']);
			$mail->setFrom($sellerEmail);
			$mail->setSender($order_info['store_name']);
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
		}

		if ($data['notifyadmin']) {
			
			$subject = sprintf($this->language->get('m_text_subject'), $order_info['store_name'], $order_id);

			$message  = $this->language->get('m_text_order') . ' ' . $order_id . "\n";
			$message .= $this->language->get('m_text_date_added') . ' ' . date($this->language->get('m_date_format_short'), strtotime($order_info['date_added'])) . "\n\n";
			
			$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$data['order_status_id'] . "' AND language_id = '" . (int)$order_info['language_id'] . "'");
				
			if ($order_status_query->num_rows) {
				$message .= $this->language->get('m_text_order_status_admin') . "\n";
				$message .= $order_status_query->row['name'] . "\n\n";
			}
			
			if ($data['comment']) {
				$message .= $this->language->get('m_text_comment') . "\n\n";
				$message .= strip_tags(html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
			}

			$message .= $this->language->get('m_text_footer');

			$mail = new Mail($this->config->get('config_mail'));
			$mail->setTo($this->config->get('marketplace_adminmail'));
			$mail->setFrom($sellerEmail);
			$mail->setSender($order_info['store_name']);
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
		}

		return true;
	}

	// Dashboard + Orderlist + OrderInfo

	public function getSellerOrdersByProduct($product_id,$page){
		$limit = 12;
		$start = ($page-1)*$limit;

		$sql = $this->db->query("SELECT o.order_id ,o.date_added, CONCAT(o.firstname ,' ',o.lastname) name ,os.name orderstatus, c2o.price, c2o.quantity  FROM " . DB_PREFIX ."order_status os LEFT JOIN ".DB_PREFIX ."order o ON (os.order_status_id = o.order_status_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) WHERE c2o.customer_id = '".$customer_id."'  AND os.language_id = '".$this->config->get('config_language_id')."' AND c2o.product_id = '".(int)$product_id."' ORDER BY o.order_id DESC LIMIT $start,$limit ");
		
		return($sql->rows);
	}

	public function getSellerOrdersTotalByProduct($product_id){

		$sql = $this->db->query("SELECT o.order_id ,o.date_added, CONCAT(o.firstname ,' ',o.lastname) name ,os.name orderstatus  FROM " . DB_PREFIX ."order_status os LEFT JOIN ".DB_PREFIX ."order o ON (os.order_status_id = o.order_status_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) WHERE c2o.customer_id = '".$customer_id."'  AND os.language_id = '".$this->config->get('config_language_id')."' AND c2o.product_id = '".(int)$product_id."' ORDER BY o.order_id ");

		return(count($sql->rows));
	}

	public function getSellerOrders($data = array(),$customer_id){
	
		$sql = "SELECT DISTINCT o.order_id ,o.date_added,o.currency_code,o.currency_value, CONCAT(o.firstname ,' ',o.lastname) name ,os.name orderstatus  FROM " . DB_PREFIX ."order_status os LEFT JOIN ".DB_PREFIX ."order o ON (os.order_status_id = o.order_status_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) WHERE c2o.customer_id = '".$customer_id."'  AND os.language_id = '".$this->config->get('config_language_id')."'";
		
		if (isset($data['filter_order']) && !is_null($data['filter_order'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order'] . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND ((o.firstname LIKE '%" . $this->db->escape($data['filter_name']) . "%') OR (o.lastname LIKE '%" . $this->db->escape($data['filter_name']) . "%') OR CONCAT(o.firstname,' ',o.lastname) like '%" . $this->db->escape($data['filter_name']) . "%') ";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND os.name LIKE '%" . $data['filter_status'] . "%'";
		}

		if (!empty($data['filter_date'])) {
			$sql .= " AND o.date_added LIKE '%" . $this->db->escape($data['filter_date']) . "%'";
		}

		$sort_data = array(
			'o.order_id',
			'o.firstname',
			'os.name',
			'o.date_added'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY o.order_id";	
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

	public function getSellerOrdersTotal($data = array(),$customer_id){
					
		$sql = "SELECT COUNT(DISTINCT o.order_id) AS total ,o.date_added, CONCAT(o.firstname ,' ',o.lastname) name ,os.name orderstatus  FROM " . DB_PREFIX ."order_status os LEFT JOIN ".DB_PREFIX ."order o ON (os.order_status_id = o.order_status_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) WHERE c2o.customer_id = '".$customer_id."'  AND os.language_id = '".$this->config->get('config_language_id')."' ";

		if (isset($data['filter_order']) && !is_null($data['filter_order'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order'] . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND ((o.firstname LIKE '%" . $this->db->escape($data['filter_name']) . "%') OR (o.lastname LIKE '%" . $this->db->escape($data['filter_name']) . "%') OR CONCAT(o.firstname,' ',o.lastname) like '%" . $this->db->escape($data['filter_name']) . "%') ";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND os.name LIKE '%" . $data['filter_status'] . "%'";
		}

		if (!empty($data['filter_date'])) {
			$sql .= " AND o.date_added LIKE '%" . $this->db->escape($data['filter_date']) . "%'";
		}

		$sort_data = array(
			'o.order_id',			
			'o.firstname',
			'os.name',
			'o.date_added'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY o.order_id";	
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

		return $query->row['total'];
		
	}

	public function getSellerOrderProducts($order_id){			

		$sql = $this->db->query("SELECT op.*,c2o.price c2oprice FROM " . DB_PREFIX ."customerpartner_to_order c2o LEFT JOIN " . DB_PREFIX . "order_product op ON (c2o.order_product_id = op.order_product_id AND c2o.order_id = op.order_id) WHERE c2o.order_id = '".$order_id."'  AND c2o.customer_id = '".$customer_id."' ORDER BY op.product_id ");

		return($sql->rows);
	}

	public function getOrder($order_id) {

		$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "customerpartner_to_order c2o ON (o.order_id = c2o.order_id) WHERE o.order_id = '" . (int)$order_id . "' AND o.order_status_id > '0' AND c2o.customer_id = '".$customer_id."'");
		
		if ($order_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");
			
			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';				
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");
			
			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}
			
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");
			
			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';				
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");
			
			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}
			
			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],

				'store_url'               => $order_query->row['store_url'],				
				'customer_id'             => $order_query->row['customer_id'],
				'firstname'               => $order_query->row['firstname'],
				'lastname'                => $order_query->row['lastname'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'email'                   => $order_query->row['email'],
				'payment_firstname'       => $order_query->row['payment_firstname'],
				'payment_lastname'        => $order_query->row['payment_lastname'],				
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address_1'       => $order_query->row['payment_address_1'],
				'payment_address_2'       => $order_query->row['payment_address_2'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],	
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_method'          => $order_query->row['payment_method'],
				'shipping_firstname'      => $order_query->row['shipping_firstname'],
				'shipping_lastname'       => $order_query->row['shipping_lastname'],				
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address_1'      => $order_query->row['shipping_address_1'],
				'shipping_address_2'      => $order_query->row['shipping_address_2'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],	
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_method'         => $order_query->row['shipping_method'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'order_status_id'         => $order_query->row['order_status_id'],
				'language_id'             => $order_query->row['language_id'],
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'date_modified'           => $order_query->row['date_modified'],
				'date_added'              => $order_query->row['date_added'],
				'ip'                      => $order_query->row['ip']
			);
		} else {
			return false;	
		}
	}

	// return seller products amount from customerpartner_to_order table
	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT SUM(price) total FROM " . DB_PREFIX . "customerpartner_to_order WHERE order_id = '" . (int)$order_id . "' AND customer_id = '".$customer_id."'");

		return $query->rows;
	}

	public function getOdrTracking($odr,$prod,$cust){		

		$sql = "SELECT tracking FROM " . DB_PREFIX ."customerpartner_sold_tracking where customer_id='".(int)$cust."' AND product_id='".(int)$prod."' AND order_id='".(int)$odr."'";
		
		return($this->db->query($sql)->row);
	}


	public function addOdrTracking($order_id,$tracking){
		//have to add product_order_id condition here too
		
		$comment = '';

		foreach($tracking as $product_id => $tracking_no){

			if($tracking_no){
				$sql = $this->db->query("SELECT c2t.* FROM " . DB_PREFIX ."customerpartner_sold_tracking c2t WHERE c2t.customer_id='".(int)$customer_id."' AND c2t.product_id='".(int)$product_id."' AND c2t.order_id='".(int)$order_id."'")->row;

				if(!$sql){
					$this->db->query("INSERT INTO " . DB_PREFIX ."customerpartner_sold_tracking SET customer_id='".(int)$customer_id."' ,tracking='".$this->db->escape($tracking_no)."' ,product_id='".(int)$product_id."' ,order_id='".(int)$order_id."'");

					$sql = $this->db->query("SELECT name FROM " . DB_PREFIX ."order_product WHERE product_id='".(int)$product_id."' AND order_id='".(int)$order_id."'")->row;

					if($sql)
						$comment .= 'Product - '. $sql['name'].'<br/>'.'Seller Tracking No - '. $tracking_no.'<br/>';
			    }
			}
		}

		if($comment){
			$sql = $this->db->query("SELECT o.order_status_id FROM `" . DB_PREFIX ."order` o WHERE o.order_id = '".(int)$order_id."'")->row;

			if($sql)
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . $sql['order_status_id'] . "', notify = '" .  0 . "', comment = '".$this->db->escape($comment)."', date_added = NOW()");
			
			
			$sql = $this->db->query("SELECT c2p.product_id FROM " . DB_PREFIX ."order_product o LEFT JOIN " . DB_PREFIX ."customerpartner_to_product c2p ON (o.product_id = c2p.product_id) LEFT JOIN " . DB_PREFIX ."customerpartner_sold_tracking cst ON (c2p.product_id = cst.product_id) where o.order_id='".(int)$order_id."' AND c2p.product_id NOT IN (SELECT product_id FROM " . DB_PREFIX . "customerpartner_sold_tracking cst WHERE cst.order_id = '".(int)$order_id."')")->rows;
			

			if(!$sql){
				// $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . $this->config->get('config_complete_status_id') . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
			}
		}
	}



	//for downloads
	
	public function addDownload($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "download SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', date_added = NOW()");

		$download_id = $this->db->getLastId();

		foreach ($data['download_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "download_description SET download_id = '" . (int)$download_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		//for seller table
		$this->db->query("INSERT INTO " . DB_PREFIX . "customerpartner_download SET download_id = '" . (int)$download_id . "', seller_id = '" . $customer_id . "'");
	}

	public function editDownload($download_id, $data) {

		$download_info = $this->getDownload($download_id);
		
		if ($download_info) {
			if (!empty($data['update'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "order_download SET `filename` = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "' WHERE `filename` = '" . $this->db->escape($download_info['filename']) . "'");
			}				

			$this->db->query("UPDATE " . DB_PREFIX . "download SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "' WHERE download_id = '" . (int)$download_id . "'");

			$this->db->query("DELETE FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");

			foreach ($data['download_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "download_description SET download_id = '" . (int)$download_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
			}
		}
	}

	public function deleteDownload($download_id) {

		$download_info = $this->getDownload($download_id);

		if($download_info){

			if(file_exists(DIR_DOWNLOAD.$download_info['filename']))
				unlink(DIR_DOWNLOAD.$download_info['filename']);
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "download WHERE download_id = '" . (int)$download_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_download WHERE download_id = '" . (int)$download_id . "'");
		}
	}	

	public function getDownload($download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customerpartner_download cd LEFT JOIN " . DB_PREFIX . "download d ON (cd.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE d.download_id = '" . (int)$download_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd.seller_id = '".$customer_id."'");

		return $query->row;
	}	

	public function getDownloadProduct($download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "download d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE d.download_id = '" . (int)$download_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getDownloadDescriptions($download_id) {
		$download_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");

		foreach ($query->rows as $result) {
			$download_description_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $download_description_data;
	}

	public function getTotalDownloads() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_download cd LEFT JOIN " . DB_PREFIX . "download d ON (cd.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd.seller_id = '".$customer_id."'");

		return count($query->rows);
	}	

	public function getTotalProductsByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}


	



	// Autocomplete

	// Manufacturer 
	public function getManufacturers($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
			'sort_order'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
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

	public function getManufacturer($manufacturer_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "') AS keyword FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row;
	}

	//category
	public function getCategories($data) {
		$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name, c.parent_id, c.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c ON (cp.path_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (c.category_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.category_id ORDER BY name";

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

	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR ' &gt; ') FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) WHERE cp.category_id = c.category_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.category_id) AS path, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "') AS keyword FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (c.category_id = cd2.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	} 

	//filters
	public function getFilters($data) {
		$sql = "SELECT *, (SELECT name FROM " . DB_PREFIX . "filter_group_description fgd WHERE f.filter_group_id = fgd.filter_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND fd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " ORDER BY f.sort_order ASC";

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

	public function getFilter($filter_id) {
		$query = $this->db->query("SELECT *, (SELECT name FROM " . DB_PREFIX . "filter_group_description fgd WHERE f.filter_group_id = fgd.filter_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id = '" . (int)$filter_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	//downloads
	public function getDownloads($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "customerpartner_download cd LEFT JOIN " . DB_PREFIX . "download d ON (cd.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd.seller_id = '".$customer_id."'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND dd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'dd.name',
			'd.remaining'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY dd.name";	
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

	//attributes
	public function getAttributes($data = array()) {
		$sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute_group FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_attribute_group_id'])) {
			$sql .= " AND a.attribute_group_id = '" . $this->db->escape($data['filter_attribute_group_id']) . "'";
		}

		$sort_data = array(
			'ad.name',
			'attribute_group',
			'a.sort_order'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY attribute_group, ad.name";	
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

	public function getAttribute($attribute_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE a.attribute_id = '" . (int)$attribute_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	//options
	public function getOptions($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "option` o LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE od.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$sql .= " AND od.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'od.name',
			'o.type',
			'o.sort_order'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY od.name";	
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

	public function getOption($option_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "option` o LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE o.option_id = '" . (int)$option_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getOptionValue($option_value_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_value_id = '" . (int)$option_value_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getOptionValues($option_id) {
		$option_value_data = array();

		$option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_id = '" . (int)$option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order ASC");

		foreach ($option_value_query->rows as $option_value) {
			$option_value_data[] = array(
				'option_value_id' => $option_value['option_value_id'],
				'name'            => $option_value['name'],
				'image'           => $option_value['image'],
				'sort_order'      => $option_value['sort_order']
			);
		}

		return $option_value_data;
	}

	//customergroups
	public function getCustomerGroups($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		$sort_data = array(
			'cgd.name',
			'cg.sort_order'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY cgd.name";	
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
?>