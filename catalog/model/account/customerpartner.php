<?php
const MPIMAGEFOLDER = 'catalog/';

class ModelAccountCustomerpartner extends Model {

		/*Membership functions*/

	/**
	 * [checkIsMember to check that logged in seller is a member or not and if a member then membership expiry date and other details]
	 * @param  [integer] $seller_id [customer id of seller]
	 * @return [array|boolean]            [details about membership|false]
	 */
	public function checkIsMember($seller_id) {
		$membershipDetails = $this->db->query("SELECT * FROM ".DB_PREFIX."seller_group_customer sgc LEFT JOIN ".DB_PREFIX."seller_group_name sgn ON (sgc.gid = sgn.id) WHERE sgc.customer_id = '".(int)$seller_id."' AND sgn.language_id = '".$this->config->get('config_language_id')."' ")->row;
		if($membershipDetails && isset($membershipDetails['membership_expiry'])) {
			return $membershipDetails;
		} else {
			return false;
		}
	}

	/**
	 * [checkSellerOwnProduct to check whether the product belongs to the logged in seller]
	 * @param  [integer] $product_id [id of product]
	 * @return [boolean]             [product belongs to seller or not (true/false)]
	 */
	public function checkSellerOwnProduct($product_id) {
		$result = $this->db->query("SELECT product_id FROM ".DB_PREFIX."customerpartner_to_product WHERE product_id = '".$product_id."' AND customer_id = '".$this->customer->getId()."' ")->row;
		if($result) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * [publishProduct to publish particular product]
	 * @param  [integer] $product_id [id of product]
	 * @return [boolean]             [true]
	 */
	public function publishProduct($product_id) {
		$this->db->query("UPDATE ".DB_PREFIX."customerpartner_to_product SET current_status = 'active' WHERE product_id = '".(int)$product_id."' ");
		// $this->db->query("UPDATE ".DB_PREFIX."product SET status = '1' WHERE product_id = '".(int)$product_id."' ");
		return true;
	}

	/**
	 * [unpublishProduct to unpublish particular product]
	 * @param  [integer] $product_id [id of product]
	 * @return [boolean]             [true]
	 */
	public function unpublishProduct($product_id) {
		$this->db->query("UPDATE ".DB_PREFIX."customerpartner_to_product SET current_status = 'inactive' WHERE product_id = '".(int)$product_id."' ");
	}

	/**
	 * [relist to relist any product]
	 * @param  [integer] $product_id [id of product]
	 * @return [boolean]             [true/false]
	 */
	public function relist($product_id) {
		$relist = $this->db->query("SELECT relist_count FROM ".DB_PREFIX."customerpartner_to_product WHERE product_id = '".(int)$product_id."' AND customer_id = '".(int)$this->customer->getId()."' ")->row;
		$category = $this->getProductCategory($product_id);

		$relist_count = $relist['relist_count'] + 1;

		$this->db->query("UPDATE ".DB_PREFIX."customerpartner_to_product SET current_status = 'active', relist_count = '".$relist_count."' WHERE product_id = '".(int)$product_id."' AND customer_id = '".(int)$this->customer->getId()."' ");
		
		if(isset($category) && $category) {
			foreach ($category as $key => $value) {
				
				$result = $this->db->query("SELECT sgpl.quantity,sgpld.days FROM ".DB_PREFIX."seller_group_product_listing sgpl LEFT JOIN ".DB_PREFIX."seller_group_product_listing_duration sgpld ON (sgpld.seller_id=sgpl.seller_id) WHERE sgpl.seller_id = '".(int)$this->customer->getId()."' AND sgpl.category_id = '".(int)$value['category_id']."' ")->row;

				if($result && isset($result['quantity']) && $result['quantity']) {
					$quantity = $result['quantity'] - 1;
					$this->db->query("UPDATE ".DB_PREFIX."seller_group_product_listing SET quantity = '".$quantity."' WHERE seller_id = '".(int)$this->customer->getId()."' AND category_id = '".$value['category_id']."' ");

				} else {
					$result = $this->db->query("SELECT customerDefaultNoOfListing, customerDefaultListingDuration FROM ".DB_PREFIX."seller_group_customer WHERE customer_id = '".(int)$this->customer->getId()."' ")->row;

					if($result && isset($result['customerDefaultNoOfListing']) && $result['customerDefaultNoOfListing']) {
						$customerDefaultNoOfListing = $result['customerDefaultNoOfListing'] - 1;
						$this->db->query("UPDATE ".DB_PREFIX."seller_group_customer SET customerDefaultNoOfListing = '".$customerDefaultNoOfListing."' WHERE customer_id = '".(int)$this->customer->getId()."' ");

					} else {
						return false;
					}
				}
			}
		} else {
			$result = $this->db->query("SELECT customerDefaultNoOfListing, customerDefaultListingDuration FROM ".DB_PREFIX."seller_group_customer WHERE customer_id = '".(int)$this->customer->getId()."' ")->row;
			if($result && isset($result['customerDefaultNoOfListing']) && $result['customerDefaultNoOfListing']) {
				$customerDefaultNoOfListing = $result['customerDefaultNoOfListing'] - 1;
				
				$this->db->query("UPDATE ".DB_PREFIX."seller_group_customer SET customerDefaultNoOfListing = '".$customerDefaultNoOfListing."' WHERE customer_id = '".(int)$this->customer->getId()."' ");
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * [getProductCategory to get category of any product]
	 * @param  [integer] $product_id [id of product]
	 * @return [integer|boolean]             [category id or false]
	 */
	public function getProductCategory($product_id) {
		$result = $this->db->query("SELECT category_id FROM ".DB_PREFIX."product_to_category p2c WHERE product_id = '".(int)$product_id."' ")->rows;
		if($result) {
			return $result;
		} else {
			return false;
		}
	}
	/**/

	/**
	 * [checkProductInCartWishlist to check whether the product is in cart or in wishlist of logged in customer ]
	 * @param  [integer] $product_id [id pf product]
	 * @return [boolean]             [product exist in cart/wishlist or not (true/false)]
	 */
	public function checkProductInCartWishlist($product_id) {
		$product = $this->db->query("SELECT current_status FROM ".DB_PREFIX."customerpartner_to_product WHERE product_id = '".(int)$product_id."' ")->row;
		if($product && ( $product['current_status'] == 'expired' || $product['current_status'] == 'inactive' || $product['current_status'] == 'disabled' || $product['current_status'] == 'deleted' ) ) {
			if(!$this->customer->isLogged()) {
				return false;
			}
			$result = $this->db->query("SELECT wishlist FROM ".DB_PREFIX."customer WHERE customer_id = '".$this->customer->getId()."' ")->row;
			
			if($result && unserialize($result['wishlist'])) {
				$wishlist = unserialize($result['wishlist']);
				if($this->cart->getProducts()) {
					foreach ($this->cart->getProducts() as $key => $product) {
						if($product['product_id'] == $product_id || ( is_array($wishlist) && in_array($product['product_id'], $wishlist) )) {
							return false;
						}
					}
				}
				if(in_array($product_id, $wishlist)) {
					return false;
				}
			}
			return false;
		} else {
			return true;
		}
	}

	/**
	 * [getLowStockProducts to get low stock products]
	 * @param  [integer] $seller_id [seller is of logged in seller]
	 * @return [array] [list of low stock products]
	 */
	public function getLowStockProducts($seller_id) {
		$result['products'] = $this->db->query("SELECT p.model,pd.name,p.quantity FROM ".DB_PREFIX."customerpartner_to_product cp2p LEFT JOIN ".DB_PREFIX."product p ON (p.product_id=cp2p.product_id) LEFT JOIN ".DB_PREFIX."product_description pd ON (p.product_id=pd.product_id) WHERE cp2p.customer_id = '".(int)$seller_id."' AND p.quantity <= '". (int)$this->config->get('marketplace_low_stock_quantity') ."' AND pd.language_id = '".(int)$this->config->get('config_language_id')."' ORDER BY p.quantity ASC LIMIT 0,5 ")->rows;

		$result['count'] = count($this->db->query("SELECT p.model,pd.name,p.quantity FROM ".DB_PREFIX."customerpartner_to_product cp2p LEFT JOIN ".DB_PREFIX."product p ON (p.product_id=cp2p.product_id) LEFT JOIN ".DB_PREFIX."product_description pd ON (p.product_id=pd.product_id) WHERE cp2p.customer_id = '".(int)$seller_id."' AND p.quantity <= '". (int)$this->config->get('marketplace_low_stock_quantity') ."' AND pd.language_id = '".(int)$this->config->get('config_language_id')."' ORDER BY p.quantity ASC ")->rows);
		
		if($result) {
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * [getMostViewedProducts to get top 5 viewed products]
	 * @param  [integer] $seller_id [seller is of logged in seller]
	 * @return [array]            [list of top 5 viewed products]
	 */
	public function getMostViewedProducts($seller_id) {
		$products = $this->db->query("SELECT p.model,pd.name,p.viewed FROM ".DB_PREFIX."customerpartner_to_product cp2p LEFT JOIN ".DB_PREFIX."product p ON (p.product_id=cp2p.product_id) LEFT JOIN ".DB_PREFIX."product_description pd ON (p.product_id=pd.product_id) WHERE cp2p.customer_id = '".(int)$seller_id."' AND p.viewed >= 5 AND pd.language_id = '".(int)$this->config->get('config_language_id')."' ORDER BY p.viewed DESC LIMIT 0,5 ")->rows;
		if($products) {
			return $products;
		} else {
			return false;
		}	
	}

	/**
	 * [getSellerDetails to get membership groups with their details]
	 * @return [array] [list of all membership groups]
	 */
	public function getSellerDetails() {
		$query_detail = $this->db->query("SELECT * FROM ".DB_PREFIX."seller_group sg LEFT JOIN ".DB_PREFIX."seller_group_name sgn ON (sg.groupid=sgn.id) ")->rows;
		if($query_detail) {
			return $query_detail;
		} else {
			return false;
		}
	}

	/**
	 * For membership only
	 * [getRamainingQuantity to get quantity of remaining products that a seller can add]
	 * @return [integer] [exact quantity that is left and seller can add that much more products]
	 */
	public function getRamainingQuantity(){
        $products = $this->getTotalProductsSeller();
        $sql = "SELECT gcquantity FROM ".DB_PREFIX."seller_group_customer WHERE customer_id = '".$this->customer->getId()."' ";
        $inStock = $this->db->query($sql)->row;
        if($inStock && $inStock['gcquantity'] == 0) {
            return $inStock['gcquantity'];
        } else if(isset($inStock['gcquantity']) && $inStock['gcquantity'] > $products) {
            return ($inStock['gcquantity'] - $products);
        }
    }

	/**
	 * [chkSellerPoductAccess to check seller has access over that product or not]
	 * @param  [integer] $product_id [product id of any product]
	 * @return [boolean]             [true or false]
	 */
	public function chkSellerPoductAccess($product_id) {
		$sql = $this->db->query("SELECT c2p.customer_id FROM ".DB_PREFIX ."customerpartner_to_product c2p LEFT JOIN ".DB_PREFIX ."product p ON (c2p.product_id = p.product_id) WHERE p.product_id = '".(int)$product_id."' ORDER BY c2p.id ASC");

		if($sql->row){
			if($sql->row['customer_id'] == $this->customer->getId())		
				return true;
			else
				return false;
		}else{
			return false;
		}
	}

	/**
	 * [getProductKeyword to get product's keywords]
	 * @param  [integer] $product_id [product id of product]
	 * @return [string]             [keyword related to that particular product]
	 */
	public function getProductKeyword($product_id){	
		$result = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'")->row;

		if($result)
			return $result['keyword'];
	}

	/**
	 * [getProductSoldQuantity to get total sold quantity of any product]
	 * @param  [integer] $product_id [product id of product]
	 * @return [array]             [detail about total sold quantity of particular product]
	 */
	public function getProductSoldQuantity($product_id){
		$sql = $this->db->query("SELECT SUM(c2o.quantity) quantity, SUM(c2o.price) total FROM ".DB_PREFIX ."customerpartner_to_order c2o LEFT JOIN ".DB_PREFIX ."customerpartner_to_product c2p ON (c2o.product_id = c2p.product_id AND c2o.customer_id = c2p.customer_id ) WHERE c2o.customer_id = '".$this->customer->getId()."' and c2p.product_id = '".(int)$product_id."'");
		
		return($sql->row);
	}
	
	/**
	 * [getProduct to get detail of particular product]
	 * @param  [integer] $product_id [product id of product]
	 * @return [array]             [detail of particular product]
	 */
	public function getProduct($product_id) {

		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		$result = $this->db->query("SELECT * FROM ".DB_PREFIX."customerpartner_to_product WHERE product_id = '".$product_id."' ")->row;

		
			if(!isset($result['expiry_date'])) {
				$result['expiry_date'] = '';
			}
			if(!isset($result['relist_duration'])) {
				$result['relist_duration'] = '';
			}
			if(!isset($result['auto_relist'])) {
				$result['auto_relist'] = '';
			}
			if(!isset($result['current_status'])) {
				$result['current_status'] = '';
			}
		

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
				/*Membership code*/
				'expiry_date'	   => $result['expiry_date'],
				'relist_duration'  => $result['relist_duration'],
				'auto_relist'	   => $result['auto_relist'],
				'current_status'   => $result['current_status'],
				/**/
			);
		} else {
			return false;
		}
	}

	/**
	 * [getProductsSeller to get seller's product]
	 * @param  [array]  $data [filter keywords]
	 * @return [array]       [product's details]
	 */
	public function getProductsSeller($data = array()) {

		$sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "customerpartner_to_product c2p ON (c2p.product_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)";

		if (isset($data['filter_category_id']) AND $data['filter_category_id']) {
			$sql .= " LEFT JOIN " . DB_PREFIX ."product_to_category p2c ON (p.product_id = p2c.product_id)";
		}

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() "; 

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

		if (isset($data['filter_low_stock'])) {
			$sql .= " AND p.quantity <= '" . (int)$this->config->get('marketplace_low_stock_quantity') . "'";
		}



		if(!isset($data['customer_id']) || !$data['customer_id'])
			$sql .= " AND c2p.customer_id = ". $this->customer->getId() ;
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

	/**
	 * [getTotalProductsSeller total count seller's products]
	 * @param  [array]  $data [filter keywords]
	 * @return [integer]       [number of products]
	 */
	public function getTotalProductsSeller($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "customerpartner_to_product c2p ON (c2p.product_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)";

		if (isset($data['filter_category_id']) AND $data['filter_category_id']) {
			$sql .= " LEFT JOIN " . DB_PREFIX ."product_to_category p2c ON (p.product_id = p2c.product_id)";
		}

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() "; 

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
			$sql .= " AND c2p.customer_id = ". $this->customer->getId() ;
		else		
			$sql .= " AND c2p.customer_id = ". (int)$data['customer_id'] ;

		$query = $this->db->query($sql);

		return count($query->rows);
	}

	/**
	 * [deleteProduct to delete product]
	 * @param  [integer] $product_id [product id of particular product]
	 */
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

	/**
	 * [addProduct to add product by seller only]
	 * @param [array] $data [detail about the product that is going to be added]
	 * @return [integer] [product id of added product]
	 */
	public function addProduct($data){	

		$data['status'] = $this->config->get('marketplace_productapprov');		

		$renamedImage = '';
		$renamedOImage = array();
		$files = $this->request->files;

		if (isset($files['image']['name']) AND $files['image']['name']) {
			$renamedImage = rand(100000,999999) . basename(preg_replace('~[^\w\./\\\\]+~', '', $files['image']["name"]));
			/**
			 * upload product base image
			 */
			move_uploaded_file($files["image"]["tmp_name"], DIR_IMAGE . MPIMAGEFOLDER .$renamedImage);
		}

		if (isset($files['product_image']['name']) AND $files['product_image']['name']) {
			foreach ($files['product_image']['name'] as $index => $product_image) {				

				$renamedImg = rand(100000,999999) . basename(preg_replace('~[^\w\./\\\\]+~', '', $product_image['image']));
				//upload product images
				move_uploaded_file($files['product_image']["tmp_name"][$index]['image'], DIR_IMAGE . MPIMAGEFOLDER .$renamedImg);

				$renamedOImage[$index] = $renamedImg;
			}
		}
		
		$sql = "INSERT INTO `" . DB_PREFIX . "product` SET ";

		$sql = $this->productQuery($sql,$data);

		$sql .= " date_added = NOW() ";

		$this->db->query($sql);

		$product_id = $this->db->getLastId();

		/*
		Code to add custom fields
		*/
	
		if(isset($data['product_custom_field'])) {
			$this->load->model("account/wkcustomfield");
			$this->model_account_wkcustomfield->addCustomFields($data['product_custom_field'],$product_id);
		}

		/*
		end here
		*/
	
		if($renamedImage){
			$this->db->query("UPDATE `" . DB_PREFIX . "product` SET image = '" . MPIMAGEFOLDER .$this->db->escape(html_entity_decode($renamedImage, ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
	
		if ($renamedOImage) {
			foreach ($renamedOImage as $index => $product_image) {				
				$this->db->query("INSERT INTO " . DB_PREFIX ."product_image SET product_id = '" . (int)$product_id . "', image = '" . MPIMAGEFOLDER . $this->db->escape(html_entity_decode($product_image, ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$data['product_image'][$index]['sort_order'] . "'");
			}
		}
		
		$this->productAddUpdate($product_id,$data);
		

		/**
		 * for customerpartner_to_product
		 */
		
		$current_status = 'active';

		if ($this->config->get('wk_seller_group_status')) {

			if(isset($data['relist_duration']) && $data['relist_duration']) {
			$date = date('y-m-d');
			$date = strtotime($date);
			$date = strtotime("+".$data['relist_duration']." day", $date);
			$expiry_date = date('Y-m-d', $date);
			} else if(isset($data['relist_duration'])) {
				$expiry_date = '0000:00:00';
			}

			if(!$data['status']) {
				$current_status = 'inactive';
			}
			
			$sql = "INSERT INTO `" . DB_PREFIX . "customerpartner_to_product` SET `product_id` = " . (int)$product_id . ",customer_id = '".$this->customer->getId()."',current_status = '".$current_status."', expiry_date = '".$expiry_date."',seller_price = '".(float)$this->db->escape($data['price'])."',currency_code = '".$this->session->data['currency']."' ";

			if (isset($data['quantity'])) {
				$sql .= ", quantity = '" . $this->db->escape($data['quantity']) . "'";
			}

			if (isset($data['price'])) {
				$sql .= ", price = '" .(float)$this->db->escape($this->currency->convert($data['price'],$this->session->data['currency'], $this->config->get('config_currency'))) . "'";
			}

			if (isset($data['relist_duration'])) {
				$sql .= ", relist_duration = '".$data['relist_duration']."' ";
			}

			if (isset($data['auto_relist'])) {
				$sql .= ", auto_relist = '1' ";
			}

			$this->db->query($sql);

			$this->relist($product_id);
			
		}else{

			$sql = "INSERT INTO `" . DB_PREFIX . "customerpartner_to_product` SET `product_id` = " . (int)$product_id . ",customer_id = '".$this->customer->getId()."',currency_code = '".$this->session->data['currency']."'";

			if (isset($data['quantity'])) {
				$sql .= ", quantity = '" . $this->db->escape($data['quantity']) . "'";
			}

			if (isset($data['price'])) {
				$sql .= ", price = '" .(float)$this->db->escape($this->currency->convert($data['price'],$this->session->data['currency'], $this->config->get('config_currency'))) . "',seller_price = '".(float)$this->db->escape($data['price'])."'";
			}

			$this->db->query($sql);

		}


		$mailData = array(
			'name' => isset($data['product_description'][$this->config->get('config_language_id')]['name']) ? $data['product_description'][$this->config->get('config_language_id')]['name'] : '',
			'seller_id' => $this->customer->getId(),
        	'customer_id' => false,
        	'mail_id' => $this->config->get('marketplace_mail_product_request'),
        	'mail_from' => $this->config->get('marketplace_adminmail'),
        	'mail_to' => $this->customer->getEmail(),
        );

		$commission = $this->getSellerCommission($this->customer->getId());

        $values = array(
        	'product_name' => $mailData['name'],
			'commission' => $commission."%",
        );

		/**
		 * send maila after product added
		 */
        $this->load->model('customerpartner/mail');

		/**
		 * add product mail to seller
		 */
        $this->model_customerpartner_mail->mail($mailData,$values);

        /**
         * add product mail end to admin
         */
		$mailData['mail_id'] = $this->config->get('marketplace_mail_product_admin');
        $mailData['mail_from'] = $this->customer->getEmail();
        $mailData['mail_to'] = $this->config->get('marketplace_adminmail');

		if($this->config->get('marketplace_productaddemail')) 
        	$this->model_customerpartner_mail->mail($mailData,$values);
		
		return $product_id;
	}

	/**
	 * [getSellerCommission to get seller's commission]
	 * @param  [integer] $seller_id [particular seller id]
	 * @return [integer, boolean]            [seller's commission or false value]
	 */
	public function getSellerCommission($seller_id){
		$result = $this->db->query("SELECT commission FROM ".DB_PREFIX."customerpartner_to_customer WHERE customer_id = '".$seller_id."' AND is_partner = 1 ")->row;
		if(isset($result['commission'])) {
			return $result['commission'];
		} else {
			return false;
		}
	}

	/**
	 * [editProduct to edit any product]
	 * @param  [array] $data [detail regarding the product that has to be updated]
	 */
	public function editProduct($data) {

		if(!isset($this->request->get['product_id']))
			return;

		if($this->config->get('marketplace_product_reapprove')) {
			$data['status'] = $this->config->get('marketplace_productapprov');
		}

		$product_id = $this->request->get['product_id'];
		
		if(isset($data['product_custom_field'])) {
			$this->load->model("account/wkcustomfield");
			$this->model_account_wkcustomfield->editCustomFields($data['product_custom_field'],$product_id);
		} else if(isset($data['wkcustomfield'])) {
			$this->load->model("account/wkcustomfield");
			$this->model_account_wkcustomfield->removeFromProduct($product_id);
		}
				
		$files = $this->request->files;

		$renamedImage = '';

		if (isset($files['image']['name']) AND $files['image']['name']) {

			$renamedImage = rand(100000,999999) . basename(preg_replace('~[^\w\./\\\\]+~', '', $files['image']["name"]));
			/**
			 * upload product base image
			 */
			move_uploaded_file($files["image"]["tmp_name"], DIR_IMAGE . MPIMAGEFOLDER .$renamedImage);

			if(isset($data['image']) AND $data['image'] AND file_exists(DIR_IMAGE.$data['image']))
					unlink(DIR_IMAGE.$data['image']);

		}

		/**
		 * to remove previous image from folder	
		 */
		if (isset($files['product_image']['name']) AND $files['product_image']['name']) {
			foreach ($files['product_image']['name'] as $index => $product_image) {				

				if($product_image['image']){
					$newImage = rand(100000,999999) . basename(preg_replace('~[^\w\./\\\\]+~', '', $product_image['image']));
					/**
					 * upload product images
					 */
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
			/**
			 * remove all images
			 */
			if($removeImages){
				foreach ($removeImages as $value) {
					if(file_exists(DIR_IMAGE.$value['image']))
						unlink(DIR_IMAGE.$value['image']);
				}
			}
		}
		
		$this->productAddUpdate($product_id,$data);		

		/**
		 * for customerpartner_to_product
		 */
		
		if ($this->config->get('wk_seller_group_status')) {
					$sql = "UPDATE `" . DB_PREFIX . "customerpartner_to_product` SET ";
			
					if (isset($data['quantity'])) {
						$sql .= " quantity = '" . $this->db->escape($data['quantity']) . "'";
					}

					$sql .= ", currency_code = '".$this->session->data['currency']."'";

					if (isset($data['price'])) {
						$sql .= ", price = '" .(float)$this->db->escape($this->currency->convert($data['price'],$this->session->data['currency'], $this->config->get('config_currency'))) . "',seller_price = '".(float)$this->db->escape($data['price'])."'";
					}

					if (isset($data['relist_duration']) && $data['relist_duration']) {
						$date = date('y-m-d');
						$date = strtotime($date);
						$date = strtotime("+".$data['relist_duration']." day", $date);
						$expiry_date = date('Y-m-d', $date);
						$sql .= ", relist_duration = '" . (int)$data['relist_duration'] . "', current_status = 'active', expiry_date = '".$expiry_date."' ";
					} else if(isset($data['relist_duration'])) {
						$sql .= ", relist_duration = '', current_status = 'active', expiry_date = '0000-00-00' ";
					}

					if (isset($data['auto_relist'])) {
						$sql .= ", auto_relist = '1' ";
					}

					$sql .= " WHERE `product_id` = " . (int)$this->request->get['product_id'] ." AND customer_id = '".$this->customer->getId()."' ";
					
					if(isset($data['quantity']) || isset($data['price']) || isset($data['relist_duration']) || isset($data['auto_relist']) ) {
						$this->db->query($sql);
					}

					if(isset($data['relist']) && $data['relist']) {
						$this->db->query("UPDATE ".DB_PREFIX."product SET status = 1 WHERE product_id = '".(int)$product_id."' ");
						
					   $this->relist($product_id);
					}
		}else{

			
			if(isset($data['quantity']) || isset($data['price'])){

				$sql = "UPDATE `" . DB_PREFIX . "customerpartner_to_product` SET ";

				if (isset($data['quantity'])) {
					$sql .= " quantity = '" . $this->db->escape($data['quantity']) . "'";
				}

				if (isset($data['price'])) {
					$sql .= ", price = '" .(float)$this->db->escape($this->currency->convert($data['price'],$this->session->data['currency'], $this->config->get('config_currency'))) . "',seller_price = '".(float)$this->db->escape($data['price'])."',currency_code = '".$this->session->data['currency']."'";
				}

				$sql .= " WHERE `product_id` = " . (int)$this->request->get['product_id'] ." AND customer_id = '".$this->customer->getId()."'";

				$this->db->query($sql);

			}

		}

		/**
		 * Mail to admin and seller if disapprove on edit is enabled
		 */
		if(isset($data['status']) && !$data['status']) {
			$this->load->model('customerpartner/mail');

			$mailData = array (
				'name' => isset($data['product_description'][$this->config->get('config_language_id')]['name']) ? $data['product_description'][$this->config->get('config_language_id')]['name'] : '',
				'seller_id' => $this->customer->getId(),
	        	'customer_id' => false,
	        	'mail_id' => $this->config->get('marketplace_mail_seller_on_edit'),
	        	'mail_from' => $this->config->get('marketplace_adminmail') ? $this->config->get('marketplace_adminmail') : $this->config->get('config_email'),
	        	'mail_to' => $this->customer->getEmail(),
			);

			$commission = $this->getSellerCommission($this->customer->getId());

	        $values = array(
	        	'product_name' => $mailData['name'],
				'commission' => $commission."%",
	        );

			/**
			 * mail to seller
			 */
			$this->model_customerpartner_mail->mail($mailData, $values);

			/**
			 * mail to admin
			 */
			$mailData['mail_id'] = $this->config->get('marketplace_mail_admin_on_edit');
			$mailData['mail_from'] = $this->customer->getEmail();
			$mailData['mail_to'] = $this->config->get('marketplace_adminmail') ? $this->config->get('marketplace_adminmail') : $this->config->get('config_email');
			$this->model_customerpartner_mail->mail($mailData, $values);
		}
	}

	/**
	 * [productQuery sub function to create query that will be executed in calling function]
	 * @param  [string] $sql  [base sql query]
	 * @param  [array] $data [filter keyword]
	 * @return [string]       [sql query string]
	 */
	public function productQuery($sql,$data){

		$implode = array();

		if (isset($data['model'])) {
			$implode[] = "model = '" . $this->db->escape($data['model']) . "'";
		}

		if (isset($data['sku'])) {

			if ($data['sku']) {
			   
			   $implode[] = "sku = '" . $this->db->escape($data['sku']) . "'";	
			}elseif (isset($data['model']) && $data['model'] && $this->config->get('marketplace_auto_generate_sku')){
               $implode[] = "sku = '" . $this->db->escape($data['model']) . "'";	
			}
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
			$implode[] = "price = '" . $this->db->escape($this->currency->convert($data['price'],$this->session->data['currency'], $this->config->get('config_currency'))) . "'";
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
    
  
	/**
	 * [productAddUpdate to add the updated data to particular product]
	 * @param  [integer] $product_id [product id of any product]
	 * @param  [array] $data       [detail of product that will be added to particular product]
	 */
	public function productAddUpdate($product_id,$data){

		$this->load->model('customerpartner/htmlfilter');
		$htmlfilter = $this->model_customerpartner_htmlfilter;

		if(isset($data['product_description'])){
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
			foreach ($data['product_description'] as $language_id => $value) {

				if (!$value['meta_description'] && $this->config->get('marketplace_auto_generate_sku')) {
					 
					 $value['meta_description'] = $value['name'];
				}

				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_description` SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_keyword = '" . $this->db->escape(htmlentities($htmlfilter->HTMLFilter(html_entity_decode($value['meta_keyword']),'',true))) . "', meta_description = '" . $value['meta_description'] . "', description = '" . $this->db->escape(htmlentities($htmlfilter->HTMLFilter(html_entity_decode($value['description']),'',true))) . "', tag = '" . $this->db->escape($value['tag']) . "'");
			}
		}

		if ($this->config->get('marketplace_seller_product_store')) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
	
		   if ($this->config->get('marketplace_seller_product_store') == 'choose_store') {

				foreach ($data['product_store'] as $store_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
				}
			}elseif($this->config->get('marketplace_seller_product_store') == 'own_store'){
              $seller_store_id = $this->db->query("SELECT store_id FROM " . DB_PREFIX . "customer WHERE customer_id = '".(int)$this->customer->getId(). "'")->row;   

              $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$seller_store_id['store_id']. "'");
			}else{
              $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = 0 ");
              $this->load->model('setting/store');
              $stores = $this->model_setting_store->getStores();

              foreach ($stores as $key => $store) {
              	$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '".$store['store_id']."'");
              }
			}	
		}else{
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = 0 ");
		}


		if (isset($data['product_attribute_tab']) && $data['product_attribute_tab']) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		}

		if (isset($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {

					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {				
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape(htmlentities($htmlfilter->HTMLFilter(html_entity_decode($product_attribute_description['text']),'',true))) . "'");
					}
				}
			}
		}

		if (isset($data['product_option_tab']) && $data['product_option_tab']) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		    $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
		}

		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");

					$product_option_id = $this->db->getLastId();

					if (isset($product_option['product_option_value']) && count($product_option['product_option_value']) > 0 ) {
						foreach ($product_option['product_option_value'] as $product_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" .(float)$this->currency->convert($product_option_value['price'],$this->session->data['currency'], $this->config->get('config_currency')). "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
						} 
					}else{
						$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_option_id = '".$product_option_id."'");
					}
				} else { 
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->db->escape(htmlentities($htmlfilter->HTMLFilter(html_entity_decode($product_option['option_value']),'',true))) . "', required = '" . (int)$product_option['required'] . "'");
				}
			}
		}

		if (isset($data['product_discount_tab']) && $data['product_discount_tab']) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
		}

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$this->currency->convert($product_discount['price'],$this->session->data['currency'], $this->config->get('config_currency')). "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}

		if (isset($data['product_special_tab']) && $data['product_special_tab']) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		}

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$this->currency->convert($product_special['price'],$this->session->data['currency'], $this->config->get('config_currency')). "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}

		if (isset($data['product_link_tab']) && $data['product_link_tab']) {
        	$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
        	$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");
        	$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
        	$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		    $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
        }

		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}
   
		if (isset($data['keyword']) AND $data['keyword']) {	
			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}		

	}

	/**
	 * [getProductDescriptions to get description of particular product]
	 * @param  [integer] $product_id [product id of product]
	 * @return [array]             [description of particular product]
	 */
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

	/**
	 * [getProductCategories to get categories of product]
	 * @param  [integer] $product_id [product id of product]
	 * @return [array]             [categories of particular product]
	 */
	public function getProductCategories($product_id) {
		$product_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}

	/**
	 * [getProductFilters to get filters of any product]
	 * @param  [integer] $product_id [product id of product]
	 * @return [array]             [filters of particular product]
	 */
	public function getProductFilters($product_id) {
		$product_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX ."product_filter WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_filter_data[] = $result['filter_id'];
		}

		return $product_filter_data;
	}

	/**
	 * [getProductAttributes to get attributes of particular product]
	 * @param  [integer] $product_id [product id of product]
	 * @return [array]             [attributes of particular product]
	 */
	public function getProductAttributes($product_id) {

	    $product_attribute_data = array();

	    $product_attribute_query = $this->db->query("SELECT DISTINCT a.attribute_id, ad.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

	    foreach ($product_attribute_query->rows as $product_attribute) {

	        $product_attribute_description_data = array();

	        $product_attribute_description_query = $this->db->query("SELECT pa.language_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (pa.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND pa.attribute_id = '" . (int)$product_attribute['attribute_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

	        foreach ($product_attribute_description_query->rows as $product_attribute_description) {

	            $product_attribute_description_data[$product_attribute_description['language_id']] = array(
	                                                            'name' => $product_attribute_description['name'],
	                                                            'text' => $product_attribute_description['text']
	                                                            );      
	        }

	        $product_attribute_data[] = array(
	            'attribute_id'                  => $product_attribute['attribute_id'],
	            'name'                          => $product_attribute['name'],
	            'product_attribute_description' => $product_attribute_description_data
	        );
	    }

	    return $product_attribute_data;
	}

	/**
	 * [getProductOptions to get options of particular product]
	 * @param  [integer] $product_id [product id of product]
	 * @param  [string] $tabletype  [to define marketplace's tables or opencart's tables]
	 * @return [array]             [options of particular product]
	 */
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

	/**
	 * [getProductDiscounts to get discount of particular product]
	 * @param  [integer] $product_id [product id of product]
	 * @return [array]             [discounts of particular product]
	 */
	public function getProductDiscounts($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX ."product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

	/**
	 * [getProductSpecials to get specials of particular product]
	 * @param  [integer] $product_id [product id of product]
	 * @return [array]             [specials of particular product]
	 */
	public function getProductSpecials($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	/**
	 * [getProductDownloads to get downloads of particular product]
	 * @param  [integer] $product_id [product id of product]
	 * @return [array]             [downloads of particular product]
	 */
	public function getProductDownloads($product_id) {
		$product_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_download_data[] = $result['download_id'];
		}

		return $product_download_data;
	}

	/**
	 * [getProductRelated to get rewards of particular product]
	 * @param  [integer] $product_id [product id of product]
	 * @param  [string] $tabletype  [to define marketplace's tables or opencart's tables]
	 * @return [array]             [rewards of particular product]
	 */
	public function getProductRelated($product_id,$tabletype = '') {
		$product_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . $tabletype."product_related WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}

		return $product_related_data;
	}	

	/**
	 * [getProductRelatedInfo to get related products of particular product]
	 * @param  [integer] $product_id [product id of product]
	 * @return [array]             [related products of particular product]
	 */
	public function getProductRelatedInfo($product_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	/**
	 * [IsApplyForSellership to check that a customer is already applied for sellership/partnership or not]
	 */
	public function IsApplyForSellership(){
		$query = $this->db->query("SELECT customer_id FROM ".DB_PREFIX ."customerpartner_to_customer WHERE customer_id = '".(int)$this->customer->getId()."'")->row;

		if($query){
			return true;
		}else{
			return false;
		}
		
	}

	/**
	 * [chkIsPartner to check customer is partner or not]
	 * @return [boolean] [true or false]
	 */
	public function chkIsPartner(){
					
		$sql = $this->db->query("SELECT * FROM ".DB_PREFIX ."customerpartner_to_customer WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		if(count($sql->row) && $sql->row['is_partner']==1){
			return true;
		}else{
			return false;
		}
	}
    
    /**
     * [CustomerCountry_Id fetch current customer's country id]
     * @param [type] $customer_id [current customer's customer_id]
     */
	public function CustomerCountry_Id($customer_id){

		$countryid = $this->db->query("SELECT country_id FROM ".DB_PREFIX."address WHERE customer_id = '".(int)$customer_id."' ")->row;

		return $countryid;

	}

	/**
	 * [becomePartner to register as a seller/partner]
	 * @param  [string] $shop       [shopname of seller]
	 * @param  [integer] $country_id [country id of registered customer]
	 * @param  [string] $message    [just a meesage while registering]
	 */
	public function becomePartner($shop, $country_id, $customer_id, $message = ''){

		$country = $this->db->query("SELECT iso_code_2 FROM ".DB_PREFIX."country WHERE country_id = '".(int)$country_id."' ")->row;

		$countryCode = '';
		$countryCodeFlag = '';
		if($country && isset($country['iso_code_2'])) {
			$countryCode = $country['iso_code_2'];
			$countryCodeFlag = 'image/flags/'.strtolower($countryCode).'.png';
		}

        $commission = $this->config->get('marketplace_commission') ? $this->config->get('marketplace_commission') : 0;

        if($this->config->get('marketplace_partnerapprov')) {
        	$this->db->query("INSERT INTO ".DB_PREFIX."customerpartner_to_customer set customer_id = '" .(int)$customer_id."', is_partner='1', country = '".$this->db->escape($countryCode)."', commission = '".(float)$commission."', companyname = '".$this->db->escape($shop)."', screenname = '".$this->db->escape($shop)."', countrylogo = '".$this->db->escape($countryCodeFlag)."' ");
            
            // membership modification : if partner approve enable then membership automatic membershhip will be assigned
        	if($this->config->get('wk_seller_group_status')) {
		        $this->load->model('account/wk_membership_catalog');
		        $freeMembership = $this->db->query("SELECT product_id FROM ".DB_PREFIX."seller_group WHERE autoApprove = 1 ")->row;
		        if($freeMembership && isset($freeMembership['product_id']) && $freeMembership['product_id']) {
			        $sellerDetails = array (
						'seller_id' => $this->customer->getId(),
						'product_id' => $freeMembership['product_id'],
						'doMail' => true,
					);
					$this->model_account_wk_membership_catalog->update_customer_quantity($sellerDetails);
					$this->model_account_wk_membership_catalog->insert_payment($sellerDetails);
				}
			}
			// membership code ends

        } else {        	
        	$this->db->query("INSERT INTO ".DB_PREFIX."customerpartner_to_customer set customer_id = '" .(int)$customer_id."', is_partner='0', country = '".$this->db->escape($countryCode)."', countrylogo = '".$this->db->escape($countryCodeFlag)."', companyname = '".$this->db->escape($shop)."', screenname = '".$this->db->escape($shop)."' ");
        }

  //       if($this->config->get('wk_seller_group_status')) {
	 //        $this->load->model('account/wk_membership_catalog');
	 //        $freeMembership = $this->db->query("SELECT product_id FROM ".DB_PREFIX."seller_group WHERE autoApprove = 1 ")->row;
	 //        if($freeMembership && isset($freeMembership['product_id']) && $freeMembership['product_id']) {
		//         $sellerDetails = array (
		// 			'seller_id' => $this->customer->getId(),
		// 			'product_id' => $freeMembership['product_id'],
		// 			'doMail' => true,
		// 		);
		// 		$this->model_account_wk_membership_catalog->update_customer_quantity($sellerDetails);
		// 		$this->model_account_wk_membership_catalog->insert_payment($sellerDetails);
		// 	}
		// }

        $data = array(
        	'message' => $message,
        	'shop' => $shop,
        	'commission' => $commission,
        	'seller_id' => $customer_id,
        	'customer_id' => false,
        	'mail_id' => $this->config->get('marketplace_mail_partner_request'),
        	'mail_from' => $this->config->get('marketplace_adminmail'),
        	'mail_to' => $this->customer->getEmail(),
        );

        $values = array(
        	'message' => $data['message'],
			'commission' => $data['commission']."%",
        );
        
        /**
         * send mail to Admin / Customer after request for Partnership
         */
        $this->load->model('customerpartner/mail');
        
       	/**
       	 * customer applied for sellership to customer
       	 */
        $this->model_customerpartner_mail->mail($data,$values);
        
        /**
         * customer applied for sellership to admin
         */
        $data['mail_id'] = $this->config->get('marketplace_mail_partner_admin');
        $data['mail_from'] = $this->customer->getEmail();
        $data['mail_to'] = $this->config->get('marketplace_adminmail');

        $this->model_customerpartner_mail->mail($data,$values);
					
	}	

	/**
	 * [updateProfile to update the existing seller's profile]
	 * @param  [array] $data [details about the seller's profile]
	 */
	public function updateProfile($data){

		$this->load->model('customerpartner/htmlfilter');
		$htmlfilter = $this->model_customerpartner_htmlfilter;

		$impolde = array();

		if(isset($data['screenName']))
			$impolde[] = 'screenname = "'.$this->db->escape($data['screenName']).'"';

		if(isset($data['gender']))
			$impolde[] = 'gender = "'.$this->db->escape($data['gender']).'"';

		if(isset($data['shortProfile']))
			$impolde[] = 'shortprofile = "'.$this->db->escape(htmlentities($htmlfilter->HTMLFilter(html_entity_decode($data['shortProfile']),'',true))).'"';

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
			$impolde[] = 'companydescription = "'.$this->db->escape(htmlentities($htmlfilter->HTMLFilter(html_entity_decode($data['companyDescription']),'',true))).'"';

		if(isset($data['otherpayment']))
			$impolde[] = 'otherpayment = "'.$this->db->escape(htmlentities($htmlfilter->HTMLFilter(html_entity_decode($data['otherpayment']),'',true))).'"';

		if(isset($data['country']))
			$impolde[] = 'country = "'.$this->db->escape($data['country']).'"';

		if(isset($data['countryLogo']))
			$impolde[] = 'countrylogo = "'.$this->db->escape($data['countryLogo']).'"';

		if(isset($data['paypalid']))
			$impolde[] = 'paypalid = "'.$this->db->escape($data['paypalid']).'"';

		if($impolde){

			$sql = "UPDATE ".DB_PREFIX ."customerpartner_to_customer SET ";
			$sql .= implode(", ",$impolde);
			$sql .= " WHERE customer_id = '".$this->customer->getId()."'";

			$this->db->query($sql);
		}		

		$files = $this->request->files;
		
		if(isset($files['companyBanner']['name']) AND $files['companyBanner']['name']){
			$files['companyBanner']['name'] = rand(100000,999999) . $files['companyBanner']["name"];
			$this->db->query("UPDATE ".DB_PREFIX ."customerpartner_to_customer set companybanner='catalog/".$this->db->escape($files['companyBanner']['name'])."' where customer_id='".$this->customer->getId()."'");
			move_uploaded_file($files['companyBanner']["tmp_name"], DIR_IMAGE . "catalog/" . $files['companyBanner']["name"]);
		} else if(isset($data['companybannerremove']) && $data['companybannerremove']) {
			$this->db->query("UPDATE ".DB_PREFIX ."customerpartner_to_customer set companybanner='removed' where customer_id='".$this->customer->getId()."'");
		}

		if(isset($files['companyLogo']['name']) AND $files['companyLogo']['name']){
			$files['companyLogo']['name'] = rand(100000,999999) . $files['companyLogo']["name"];
			$this->db->query("UPDATE ".DB_PREFIX ."customerpartner_to_customer set companylogo='catalog/".$this->db->escape($files['companyLogo']['name'])."' where customer_id='".$this->customer->getId()."'");
			move_uploaded_file($files['companyLogo']["tmp_name"], DIR_IMAGE . "catalog/" . $files['companyLogo']["name"]);
		} else if(isset($data['companylogoremove']) && $data['companylogoremove']) {
			$this->db->query("UPDATE ".DB_PREFIX ."customerpartner_to_customer set companylogo='removed' where customer_id='".$this->customer->getId()."'");
		}
	
		if(isset($files['avatar']['name']) AND $files['avatar']['name']){
			$files['avatar']['name'] = rand(100000,999999) . $files['avatar']["name"];
			$this->db->query("UPDATE ".DB_PREFIX ."customerpartner_to_customer set avatar='catalog/".$this->db->escape($files['avatar']['name'])."' where customer_id='".$this->customer->getId()."'");
			move_uploaded_file($files['avatar']["tmp_name"], DIR_IMAGE . "catalog/" . $files['avatar']["name"]);
		} else if(isset($data['avatarremove']) && $data['avatarremove']) {
			$this->db->query("UPDATE ".DB_PREFIX ."customerpartner_to_customer set avatar='removed' where customer_id='".$this->customer->getId()."'");
		}		
	}
	
	/**
	 * [getProfile to get seller's profile]
	 * @return [array] [details of seller]
	 */
	public function getProfile(){
		return $this->db->query("SELECT * FROM ".DB_PREFIX ."customerpartner_to_customer c2c LEFT JOIN ".DB_PREFIX."customer c ON (c2c.customer_id = c.customer_id) where c2c.customer_id = '".$this->customer->getId()."'")->row;
	}

	/**
	 * [getsellerEmail to get the seller's email id]
	 * @param  [integer] $seller_id [customer id of particuler seller]
	 * @return [string|boolean]            [email of false value]
	 */
	public function getsellerEmail($seller_id){
		$result = $this->db->query("SELECT email FROM ".DB_PREFIX ."customerpartner_to_customer c2c LEFT JOIN ".DB_PREFIX."customer c ON (c2c.customer_id = c.customer_id) where c2c.customer_id = '".$seller_id."'")->row;
		if(isset($result['email'])) {
			return $result['email'];
		} else {
			return false;
		}
	}

	/**
	 * [getCountry to get seller's country]
	 * @return [string] [country of seller]
	 */
	public function getCountry(){
		return $this->db->query("SELECT * FROM ".DB_PREFIX ."country")->rows;
	}

	/**
	 * [getOrderHistories to get histories of an order]
	 * @param  [integer] $order_id [order id of particular order]
	 * @return [array]           [order histories of particular order]
	 */
	public function getOrderHistories($order_id) {
		$query = $this->db->query("SELECT date_added, os.name AS status, oh.comment FROM " . DB_PREFIX . "customerpartner_to_order_status oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND oh.customer_id = '" . (int)$this->customer->getId() . "' OR oh.customer_id ='0' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added");
	
		return $query->rows;
	}	

	/**
	 * [addOrderHistory to add history to an order]
	 * @param [integer] $order_id [order id on particular order]
	 * @param [array] $data     [detail about what have to added to order history]
	 */
	public function addOrderHistory($order_id,$data,$seller_change_order_status_name = '') {

        if (isset($data['product_ids']) && $data['product_ids']) {

        	$products = explode(",", $data['product_ids']);

			foreach ($products as $value) {
	       	  $product_details = $this->getProduct($value);
	       	  $product_names[] = $product_details['name']; 
	        }

	        $product_name = implode(",",$product_names);

	         if ($data['comment']) {
        	
	        	$comment = $product_name.'status has been changed to'.' '.$seller_change_order_status_name. "\n\n";
	        	$comment .= strip_tags(html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
	        }else{
	        	$comment = $product_name.'status has been changed to'.' '.$seller_change_order_status_name;
	        }

        }else{

        	$comment = strip_tags(html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
        }

		$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$data['order_status_id'] . "', notify = '1', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

		$order_info = $this->getOrder($order_id);

		$sellerEmail = $this->customer->getEmail();
		$seller_details = $this->getProfile();

		$this->language->load('account/customerpartner/orderinfo');


		$subject = sprintf($this->language->get('m_text_subject'), $order_info['store_name'], $order_id);

		$message  = $this->language->get('m_text_order') . ' ' . $order_id . "\n";
		$message .= $this->language->get('m_text_date_added') . ' ' . date($this->language->get('m_date_format_short'), strtotime($order_info['date_added'])) . "\n\n";
		
		$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$data['order_status_id'] . "' AND language_id = '" . (int)$order_info['language_id'] . "'");
			
		if ($order_status_query->num_rows && isset($product_name) && $product_name) {
			$message .= sprintf($this->language->get('m_text_order_status'),$product_name) . "\n";
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

		if(version_compare(VERSION, '2.0.1.1', '<=')) {

			/*Old mail code*/
			$mail = new Mail($this->config->get('config_mail'));
			$mail->setTo($order_info['email']);
			$mail->setFrom($sellerEmail);
			$mail->setSender($order_info['store_name']);
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
		}else{

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($order_info['email']);
			$mail->setFrom($sellerEmail);
			$mail->setSender($order_info['store_name']);
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();

		}
		

		if ($this->config->get('marketplace_adminnotify')) {
			
			$subject = sprintf($this->language->get('m_text_subject'), $order_info['store_name'], $order_id);

			$message  = $this->language->get('m_text_order') . ' ' . $order_id . "\n";
			$message .= $this->language->get('m_text_date_added') . ' ' . date($this->language->get('m_date_format_short'), strtotime($order_info['date_added'])) . "\n\n";
			
			$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$data['order_status_id'] . "' AND language_id = '" . (int)$order_info['language_id'] . "'");
				
			if ($order_status_query->num_rows && isset($product_name) && $product_name) {
				$message .= sprintf($this->language->get('m_text_order_status_admin'),$product_name) . "\n";
				$message .= $order_status_query->row['name'] . "\n\n";
			}
			
			if ($data['comment']) {
				$message .= $this->language->get('m_text_comment') . "\n\n";
				$message .= strip_tags(html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
			}

			$message .= $this->language->get('m_text_footer');
			
			if(version_compare(VERSION, '2.0.1.1', '<=')) {

				/*Old mail code*/
				$mail = new Mail($this->config->get('config_mail'));
				$mail->setTo($this->config->get('marketplace_adminmail'));
				$mail->setFrom($sellerEmail);
				$mail->setSender($order_info['store_name']);
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
				$mail->send();
			}else{

				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($this->config->get('marketplace_adminmail'));
				$mail->setFrom($sellerEmail);
				$mail->setSender($order_info['store_name']);
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
				$mail->send();
			}
		}

		return true;
	}

	/**
	 * [getSellerOrdersByProduct to get all orders by particular product]
	 * @param  [type] $product_id [product id of particular product]
	 * @param  [integer] $page       [fetched data limit start and end]
	 * @return [array]             [order details]
	 */
	public function getSellerOrdersByProduct($product_id,$page){
		$limit = 12;
		$start = ($page-1)*$limit;

		$sql = $this->db->query("SELECT o.order_id ,o.date_added, CONCAT(o.firstname ,' ',o.lastname) name ,os.name orderstatus, c2o.price, c2o.quantity, c2o.paid_status  FROM " . DB_PREFIX ."order_status os LEFT JOIN `".DB_PREFIX ."order` o ON (os.order_status_id = o.order_status_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) WHERE c2o.customer_id = '".$this->customer->getId()."'  AND os.language_id = '".$this->config->get('config_language_id')."' AND c2o.product_id = '".(int)$product_id."' ORDER BY o.order_id DESC LIMIT $start,$limit ");
		return($sql->rows);
	}

	/**
	 * [getSellerOrdersTotalByProduct total count of orders as per the particular product]
	 * @param  [integer] $product_id [product id of particular product]
	 * @return [integer]             [total number of products]
	 */
	public function getSellerOrdersTotalByProduct($product_id){
		$sql = $this->db->query("SELECT o.order_id ,o.date_added, CONCAT(o.firstname ,' ',o.lastname) name ,os.name orderstatus  FROM " . DB_PREFIX ."order_status os LEFT JOIN `".DB_PREFIX ."order` o ON (os.order_status_id = o.order_status_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) WHERE c2o.customer_id = '".$this->customer->getId()."'  AND os.language_id = '".$this->config->get('config_language_id')."' AND c2o.product_id = '".(int)$product_id."' ORDER BY o.order_id ");

		return(count($sql->rows));
	}

	/**
	 * [getSellerOrders to get orders according to sellers]
	 * @param  [array]  $data [filter keywords]
	 * @return [array]       [order details]
	 */
	public function getSellerOrders($data = array()){
	
		$sql = "SELECT DISTINCT o.order_id ,o.date_added,c2o.currency_code,c2o.currency_value, CONCAT(o.firstname ,' ',o.lastname) name ,os.name orderstatus  FROM " . DB_PREFIX ."order_status os LEFT JOIN `".DB_PREFIX ."order` o ON (os.order_status_id = o.order_status_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) WHERE c2o.customer_id = '".$this->customer->getId()."'  AND os.language_id = '".$this->config->get('config_language_id')."' AND c2o.seller_access = '1'";
		
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

		if (isset($data['order']) && ($data['order'] == ' ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
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

	/**
	 * [getSellerOrdersTotal total count of orders of particular seller]
	 * @param  [array]  $data [filter keywords]
	 * @return [integer]       [total number of orders]
	 */
	public function getSellerOrdersTotal($data = array()){
					
		$sql = "SELECT DISTINCT o.order_id ,o.date_added,c2o.currency_code,c2o.currency_value, CONCAT(o.firstname ,' ',o.lastname) name ,os.name orderstatus  FROM " . DB_PREFIX ."order_status os LEFT JOIN `".DB_PREFIX ."order` o ON (os.order_status_id = o.order_status_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) WHERE c2o.customer_id = '".$this->customer->getId()."'  AND os.language_id = '".$this->config->get('config_language_id')."' AND c2o.seller_access = '1'";

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

		$query = $this->db->query($sql);

		return count($query->rows);
	}

	/**
	 * [getSellerOrderProducts to get products by order]
	 * @param  [integer] $order_id [order id of particular order]
	 * @return [array]           [details of products]
	 */
	public function getSellerOrderProducts($order_id){			

		$sql = $this->db->query("SELECT op.*,c2o.price c2oprice, c2o.paid_status,c2o.order_product_status FROM " . DB_PREFIX ."customerpartner_to_order c2o LEFT JOIN " . DB_PREFIX . "order_product op ON (c2o.order_product_id = op.order_product_id AND c2o.order_id = op.order_id) WHERE c2o.order_id = '".$order_id."'  AND c2o.customer_id = '".$this->customer->getId()."' ORDER BY op.product_id ");

		return($sql->rows);
	}

	/**
	 * [getOrder to get details of a particular order]
	 * @param  [integer] $order_id [order id of particular order]
	 * @return [array|boolean]           [details of particular order|false]
	 */
	public function getOrder($order_id) {

		$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "customerpartner_to_order c2o ON (o.order_id = c2o.order_id) WHERE o.order_id = '" . (int)$order_id . "' AND o.order_status_id > '0' AND c2o.customer_id = '".$this->customer->getId()."'");

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

				'shipping_applied'             => $order_query->row['shipping_applied'],

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

	/**
	 * [getOrderTotals to get particular order's total]
	 * @param  [integer] $order_id [order id of particular order]
	 * @return [integer]           [sum of order]
	 */
	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT SUM(price) total FROM " . DB_PREFIX . "customerpartner_to_order WHERE order_id = '" . (int)$order_id . "' AND customer_id = '".$this->customer->getId()."'");

		return $query->rows;
	}

	/**
	 * [getOdrTracking to get tracking of an order]
	 * @param  [integer] $order_id  [order_id]
	 * @param  [integer] $product_id [product id of product]
	 * @param  [integer] $customer_id [customer id of customer]
	 * @return [array]       [tracking details of an order]
	 */
	public function getOdrTracking($order_id,$product_id,$customer_id){		

		$sql = "SELECT tracking FROM " . DB_PREFIX ."customerpartner_sold_tracking where customer_id='".(int)$customer_id."' AND product_id='".(int)$product_id."' AND order_id='".(int)$order_id."'";
		
		return($this->db->query($sql)->row);
	}

	/**
	 * [addOdrTracking to add tracking number to an order]
	 * @param [integer] $order_id [order id of order]
	 * @param [string|number] $tracking [tracking number/string]
	 */
	public function addOdrTracking($order_id,$tracking){
		/**
		 * have to add product_order_id condition here too
		 */
		$comment = '';

		foreach($tracking as $product_id => $tracking_no){

			if($tracking_no){
				$sql = $this->db->query("SELECT c2t.* FROM " . DB_PREFIX ."customerpartner_sold_tracking c2t WHERE c2t.customer_id='".(int)$this->customer->getId()."' AND c2t.product_id='".(int)$product_id."' AND c2t.order_id='".(int)$order_id."'")->row;

				if(isset($sql) && !$sql){
					$this->db->query("INSERT INTO " . DB_PREFIX ."customerpartner_sold_tracking SET customer_id='".(int)$this->customer->getId()."' ,tracking='".$this->db->escape($tracking_no)."' ,product_id='".(int)$product_id."' ,order_id='".(int)$order_id."'");

					$sql = $this->db->query("SELECT name FROM " . DB_PREFIX ."order_product WHERE product_id='".(int)$product_id."' AND order_id='".(int)$order_id."'")->row;

					if($sql){
						$comment .= 'Product - '. $sql['name'].'<br/>'.'Seller Tracking No - '. $tracking_no.'<br/>';

						$commentForproduct = 'Product - '. $sql['name'].'<br/>'.'Seller Tracking No - '. $tracking_no.'<br/>';

						$productOrderStatus = $this->db->query("SELECT os.order_status_id FROM " . DB_PREFIX ."customerpartner_to_order c2o LEFT JOIN  ". DB_PREFIX ."order_status os ON (c2o.order_product_status = os.order_status_id) WHERE c2o.product_id='".(int)$product_id."' AND c2o.customer_id='".(int)$this->customer->getId()."'")->row;

						$this->db->query("INSERT INTO " . DB_PREFIX . "customerpartner_to_order_status SET order_id = '" . (int)$order_id . "',product_id = '".$product_id."',customer_id='".(int)$this->customer->getId()."',order_status_id = '".$productOrderStatus['order_status_id']."',comment = '".$this->db->escape($commentForproduct)."', date_added = NOW()");
					}
			    }
			}
		}


		if($comment){
			$sql = $this->db->query("SELECT o.order_status_id FROM `" . DB_PREFIX ."order` o WHERE o.order_id = '".(int)$order_id."'")->row;

			if($sql)
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . $sql['order_status_id'] . "', notify = '" .  1 . "', comment = '".$this->db->escape($comment)."', date_added = NOW()");
			
			
			$sql = $this->db->query("SELECT c2p.product_id FROM " . DB_PREFIX ."order_product o LEFT JOIN " . DB_PREFIX ."customerpartner_to_product c2p ON (o.product_id = c2p.product_id) LEFT JOIN " . DB_PREFIX ."customerpartner_sold_tracking cst ON (c2p.product_id = cst.product_id) where o.order_id='".(int)$order_id."' AND c2p.product_id NOT IN (SELECT product_id FROM " . DB_PREFIX . "customerpartner_sold_tracking cst WHERE cst.order_id = '".(int)$order_id."')")->rows;
		}
	}

	/**
	 * [addDownload to add download option]
	 * @param [array] $data [detail about the download]
	 */
	public function addDownload($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "download SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', date_added = NOW()");

		$download_id = $this->db->getLastId();

		foreach ($data['download_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "download_description SET download_id = '" . (int)$download_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		/**
		 * for seller table
		 */
		$this->db->query("INSERT INTO " . DB_PREFIX . "customerpartner_download SET download_id = '" . (int)$download_id . "', seller_id = '" . $this->customer->getId() . "'");
	}

	/**
	 * [editDownload to update download]
	 * @param  [integer] $download_id [id of particular download]
	 * @param  [array] $data        [detail about the download]
	 */
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

	/**
	 * [deleteDownload to delete added download]
	 * @param  [integer] $download_id [id of particular download]
	 */
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

	/**
	 * [getDownload to get particular download]
	 * @param  [integer] $download_id [id of particular download]
	 * @return [array]              [detail about download]
	 */
	public function getDownload($download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customerpartner_download cd LEFT JOIN " . DB_PREFIX . "download d ON (cd.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE d.download_id = '" . (int)$download_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd.seller_id = '".$this->customer->getId()."'");

		return $query->row;
	}	

	/**
	 * [getDownloadProduct to get product for the download]
	 * @param  [integer] $download_id [id of download]
	 * @return [array]              [detail about download]
	 */
	public function getDownloadProduct($download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "download d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE d.download_id = '" . (int)$download_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	/**
	 * [getDownloadDescriptions to get description about download]
	 * @param  [integer] $download_id [id of particular download]
	 * @return [array]              [description detail of download]
	 */
	public function getDownloadDescriptions($download_id) {
		$download_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");

		foreach ($query->rows as $result) {
			$download_description_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $download_description_data;
	}

	/**
	 * [getTotalDownloads to get total number of downloads]
	 * @return [integer] [total number of downloads]
	 */
	public function getTotalDownloads() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_download cd LEFT JOIN " . DB_PREFIX . "download d ON (cd.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd.seller_id = '".$this->customer->getId()."'");

		return count($query->rows);
	}	

	/**
	 * [getTotalProductsByDownloadId to get total products by a particular download]
	 * @param  [integer] $download_id [id of particular download]
	 * @return [integer]              [number of download]
	 */
	public function getTotalProductsByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}

	/**
	 * [getManufacturers to get manufacturers]
	 * @param  [array]  $data [filter keywords]
	 * @return [array]       [details about manufacturer]
	 */
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

	/**
	 * [getManufacturer to get particular manufacturer]
	 * @param  [integer] $manufacturer_id [id of manufacturer]
	 * @return [array]                  [details of manufacturer]
	 */
	public function getManufacturer($manufacturer_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "') AS keyword FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row;
	}

	/**
	 * [getCategories to get categories]
	 * @param  [array] $data [filter keywords]
	 * @return [array]       [details of categories]
	 */
	public function getCategories($data) {

		$marketplace_allowed_categories = '';
		foreach ($this->config->get('marketplace_allowed_categories') as $key => $categories) {
			$marketplace_allowed_categories .= ','. $key;
		}
		if ($marketplace_allowed_categories) {
			$marketplace_allowed_categories = ltrim($marketplace_allowed_categories, ',');
		}

        if (!$this->config->get('marketplace_allowed_seller_category_type') && $marketplace_allowed_categories) {
        	
        	$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name, c.parent_id, c.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c ON (cp.path_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (c.category_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cp.category_id IN (".$marketplace_allowed_categories.")";
        }else{

        	$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name, c.parent_id, c.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c ON (cp.path_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (c.category_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        }

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

		if (!$this->config->get('marketplace_allowed_seller_category_type') && !$marketplace_allowed_categories) {

			return array();
		}else{
			$query = $this->db->query($sql);
			return $query->rows;
		}
	}

	/**
	 * [getCategory to get particular category details]
	 * @param  [integer] $category_id [category id of particular category]
	 * @return [array]              [category details]
	 */
	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR ' &gt; ') FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) WHERE cp.category_id = c.category_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.category_id) AS path, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "') AS keyword FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (c.category_id = cd2.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	} 

	/**
	 * [getFilters to get filters]
	 * @param  [array] $data [filter keywords]
	 * @return [array]       [detail about filters]
	 */
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

	/**
	 * [getFilter to get detail about particular filter]
	 * @param  [integer] $filter_id [id of particular filter]
	 * @return [array]            [detail of particular filter]
	 */
	public function getFilter($filter_id) {
		$query = $this->db->query("SELECT *, (SELECT name FROM " . DB_PREFIX . "filter_group_description fgd WHERE f.filter_group_id = fgd.filter_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id = '" . (int)$filter_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	/**
	 * [getDownloads to get downloads]
	 * @param  [array]  $data [filter keywords]
	 * @return [array]       [details of downloads]
	 */
	public function getDownloads($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "customerpartner_download cd LEFT JOIN " . DB_PREFIX . "download d ON (cd.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd.seller_id = '".$this->customer->getId()."'";

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

	/**
	 * [getAttributes to get attributes]
	 * @param  [array]  $data [filter keyowrds]
	 * @return [array]       [details of attributes]
	 */
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

	/**
	 * [getAttribute to get detail for particular attribute]
	 * @param  [integer] $attribute_id [id of an attribute]
	 * @return [array]               [details of attribute]
	 */
	public function getAttribute($attribute_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE a.attribute_id = '" . (int)$attribute_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	/**
	 * [getOptions to get options]
	 * @param  [array]  $data [filter keywords]
	 * @return [array]       [details of options]
	 */
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

	/**
	 * [getOption to get detail of particular option]
	 * @param  [integer] $option_id [id of an option]
	 * @return [array]            [detail of particular option]
	 */
	public function getOption($option_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "option` o LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE o.option_id = '" . (int)$option_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	/**
	 * [getOptionValue to get value of an option]
	 * @param  [integer] $option_value_id [id of option's value]
	 * @return [array]                  [detail about the option value]
	 */
	public function getOptionValue($option_value_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_value_id = '" . (int)$option_value_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	/**
	 * [getOptionValues to get option's values]
	 * @param  [integer] $option_id [id of an option]
	 * @return [array]            [detail of option values]
	 */
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

	/**
	 * [getCustomerGroups to get customer groups]
	 * @param  [array]  $data [filter keywords]
	 * @return [array]       [detail of customer groups]
	 */
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
    
    /**
     * [getProductSellerDetails Uses to check whether this product is a seller product or admin product and if seller product then return seller details]
     * @param  [type] $productId [product Id]
     * @return [type]            [array]
     */
	public function getProductSellerDetails($productId){
         
         $query = $this->db->query("SELECT * FROM ".DB_PREFIX."customerpartner_to_product c2p LEFT JOIN ".DB_PREFIX."customer oc ON (c2p.customer_id = oc.customer_id) WHERE c2p.product_id = '".$productId."'")->row;

         return $query;
	}
    
    /**
     * [addsellerorderproductstatus uses to change the order product status when seller changes his the order product status ]
     * @param  [type] $order_id      [order Id]
     * @param  [type] $orderstatusid [order status id]
     * @param  [type] $product_ids   [product Ids ]
     * @return [type]                [false]
     */
	public function addsellerorderproductstatus($order_id,$orderstatusid,$product_ids){

       foreach ($product_ids as $value) {
       	 $this->db->query("UPDATE " . DB_PREFIX . "customerpartner_to_order SET order_product_status = '".$orderstatusid."' WHERE order_id = '".$order_id."' AND product_id = '".$value."'");
       }

       return false;
		
	}

	private function getWholeOrderStatusId($data = array()){

        $allOrderStatus = array();
		foreach ($data as $key => $value) {
          	 
          	 array_push($allOrderStatus,$value['order_product_status']);
          }

        $isSameSatus = array_unique($allOrderStatus);

        if (count($isSameSatus) == 1) {
      	  
      	    return $isSameSatus[0];
        }else{
        	return false;
        }  

	}

   /**
	 * [getWholeOrderStatus get order status in which that
	 *  
	 * 1) if all the order product status of that order is same status then whole order status of that order will be that status
	 * 2) if some order prodcut status are canceled and rest product status are same then whole order status is same as rest product status
	 * 3)if some order prodcut status are canceled and rest product status are not same then whole order status will be the previous status
     * @param  [type] $order_id                  [INT]
     * @param  [type] $admin_cancel_order_status [INT]
     * @return [type]                            [INT]
     */
	public function getWholeOrderStatus($order_id,$admin_cancel_order_status){
          
          $allOrderStatus = array();
        
          $getAllStatus =  $this->db->query("SELECT order_product_status FROM " . DB_PREFIX . "customerpartner_to_order WHERE order_id = '".$order_id."'")->rows;

          foreach ($getAllStatus as $key => $value) {
          	 
          	 array_push($allOrderStatus,$value['order_product_status']);
          }

          $isSameSatus = array_unique($allOrderStatus);

          if (count($isSameSatus) == 1) {
          	  
          	  return $isSameSatus[0];

          }else{

             $check_cancel = $this->db->query("SELECT order_product_status FROM " . DB_PREFIX . "customerpartner_to_order WHERE order_id = '".$order_id."' AND order_product_status != '".$admin_cancel_order_status."'")->rows;

             $id = $this->getWholeOrderStatusId($check_cancel);

             return $id;

             
             // $check_cancel = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_to_order WHERE order_id = '".$order_id."' AND order_product_status = '".$admin_cancel_order_status."'")->num_rows;

             // $check_total_order = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_to_order WHERE order_id = '".$order_id."'")->num_rows;
             

             // if ($check_total_order - $check_cancel == 1) {
             	
             // 	 $getOtherStatus = $this->db->query("SELECT order_product_status FROM " . DB_PREFIX . "customerpartner_to_order WHERE order_id = '".$order_id."' AND order_product_status != '".$admin_cancel_order_status."'")->row;

             // 	 return $getOtherStatus['order_product_status'];

             // }else{

             // 	 return $this->config->get('config_order_status_id');
             // }
             

          }
	}  
    
    /**
     * [changeWholeOrderStatus uses to update the whole order status]
     * @param [type] $order_id        [order Id]
     * @param [type] $order_status_id [order status Id]
     */
	public function changeWholeOrderStatus($order_id,$order_status_id){

		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

	}
    
    /**
     * [addSellerOrderStatus uses to update seller order product status]
     * @param [type] $order_id      [order Id]
     * @param [type] $orderstatusid [order status Id]
     * @param string $comment       [comment]
     */
	public function addSellerOrderStatus($order_id,$orderstatusid,$post,$products = array(),$seller_change_order_status_name = ''){
        
        if ($products) {
        	
			foreach ($products as $value) {
	       	  $product_details = $this->getProduct($value);

			  if ($post['comment']) {
			  	  
			  	  $comment = $product_details['name'].' '.'status has been changed to'.' '.$seller_change_order_status_name. "\n\n";
			  	  $comment .= strip_tags(html_entity_decode($post['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
			  }else{
			  	  $comment = $product_details['name'].' '.'status has been changed to'.' '.$seller_change_order_status_name;
			  }

	       	  $this->db->query("INSERT INTO " . DB_PREFIX . "customerpartner_to_order_status SET order_id = '".$order_id."',order_status_id = '".$orderstatusid."',comment = '".$comment."',product_id = '".$product_details['product_id']."',customer_id = '".$this->customer->getId()."',date_added = NOW()");

	       	  
	        }

	    }else{
	    	$this->db->query("INSERT INTO " . DB_PREFIX . "customerpartner_to_order_status SET order_id = '".$order_id."',comment = '".$post['comment']."',customer_id = '".$this->customer->getId()."',date_added = NOW()");
	    }
        return false;
		
	}
    
    
    /**
     * [getOrderDetails uses to fetch the order details of an order]
     * @param  array  $data       [filter variable]
     * @param  [type] $order_id   [order Id]
     * @param  [type] $product_id [product Id]
     * @return [type]             [array]
     */
	public function getOrderDetails($data = array(),$order_id,$product_id){
	
		$sql = "SELECT * FROM " . DB_PREFIX . "customerpartner_to_order_status WHERE order_id = '".$order_id."' AND product_id = '".$product_id."'";
		
		$sort_data = array(
			'date_added',
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY change_orderstatus_id";	
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

    /**
     * [getOrderDetailsTotal uses to count the total order changed status]
     * @param  array  $data       [filter variable]
     * @param  [type] $order_id   [Order Id]
     * @param  [type] $product_id [Product Id]
     * @return [type]             [array]
     */
	public function getOrderDetailsTotal($data = array(),$order_id,$product_id){
	
		$sql = "SELECT * FROM " . DB_PREFIX . "customerpartner_to_order_status WHERE order_id = '".$order_id."' AND product_id = '".$product_id."'";
		
		$sort_data = array(
			'date_added',
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY change_orderstatus_id";	
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
		
		return count($query->rows);
	}
    
    /**
     * [getOrderStatusId uses to get order status id of an order]
     * @param  [type] $order_id [order Id]
     * @return [type]           [array]
     */
	public function getOrderStatusId($order_id){
        
        $query = $this->db->query("SELECT order_status_id FROM " . DB_PREFIX . "order WHERE order_id = '".$order_id."'")->row;

        return $query;

	}
    
    /**
     * [getProductStores uses to get store of the product]
     * @param  [type] $product_id [Product Id]
     * @return [type]             [array]
     */
	public function getProductStores($product_id) {
		$product_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_store_data[] = $result['store_id'];
		}

		return $product_store_data;
	}
    
    /**
     * [getUrlAlias uses to get seo url through keyword]
     * @param  [type] $keyword [keyword]
     * @return [type]          [array]
     */
	public function getUrlAlias($keyword) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "'");

		return $query->row;
	}
}
?>