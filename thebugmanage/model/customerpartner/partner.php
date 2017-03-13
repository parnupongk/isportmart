<?php
class ModelCustomerpartnerPartner extends Model {

	private $data = array();

	public function removeCustomerpartnerTable(){

		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_commission_category`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_to_customer`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_to_commission`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_to_product`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_to_feedback`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_to_order`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_to_order_status`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_to_transaction`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_to_payment`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_download`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_flatshipping`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_shipping`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_sold_tracking`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_mail`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."wk_custom_field_description`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."wk_custom_field_options`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."wk_custom_field_option_description`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."wk_custom_field_product`");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."wk_custom_field_product_options`");

		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_download`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_feedbacks`");		
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_flatshipping`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_orders_pay`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product_attributes`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product_description`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product_image`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product_to_category`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_shipping`");		
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_sold_tracking`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_to_customer`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customer_partner_rel`");

		// old v2 tables
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product_attribute`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product_discount`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product_filter`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product_option`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product_option_value`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product_related`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product_reward");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product_special`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_product_to_download`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_commission_manual`");		
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_to_product`");
		// $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX ."customerpartner_mail`");

		// $this->createCustomerpartnerTable();		

	}

	public function upgradeMarketplace(){
        
        /**
         * [$check_product_seller_price uses to check whether seller_price column exists]
         * @var [type]
         */
		$check_product_seller_price = $this->db->query("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND TABLE_NAME = '".DB_PREFIX."customerpartner_to_product' AND COLUMN_NAME = 'seller_price'")->row;

		if (!$check_product_seller_price) {
			
			$this->db->query("ALTER TABLE  " . DB_PREFIX . "customerpartner_to_product
				ADD COLUMN seller_price float NOT NULL AFTER price, 
				ADD COLUMN currency_code varchar(11) NOT NULL AFTER seller_price;
		   ");

		}
        
        /**
         * [$check_feedback_status uses to check whether status column exists]
         * @var [type]
         */
		$check_feedback_status = $this->db->query("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND TABLE_NAME = '".DB_PREFIX."customerpartner_to_feedback' AND COLUMN_NAME = 'status'")->row;

		if (!$check_feedback_status) {
			
			$this->db->query("ALTER TABLE  " . DB_PREFIX . "customerpartner_to_feedback ADD COLUMN status int(1) NOT NULL AFTER review 
		   ");

		}

		$check_order_status_column = $this->db->query("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND TABLE_NAME = '".DB_PREFIX."customerpartner_to_order' AND COLUMN_NAME = 'order_product_status'")->row;

        if (!$check_order_status_column) {

        	$this->db->query("ALTER TABLE  " . DB_PREFIX . "customerpartner_to_order
				ADD COLUMN order_product_status INT(11) NOT NULL AFTER date_added;
		   ");
        	
        	//Table structure for table `customerpartner_to_order_status`
			$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."customerpartner_to_order_status` (
			  `change_orderstatus_id` int(11) NOT NULL AUTO_INCREMENT,
			  `order_id` int(11) NOT NULL,
			  `product_id` int(11) NOT NULL,
			  `customer_id` int(11) NOT NULL,
			  `order_status_id` int(11) NOT NULL,
			  `comment` text NOT NULL,
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY (`change_orderstatus_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1") ;

			$orderStatuses = $this->db->query("SELECT order_id,order_status_id FROM ".DB_PREFIX."order")->rows;

			foreach ($orderStatuses as $key => $value) {
				
				$this->db->query("UPDATE ".DB_PREFIX."customerpartner_to_order SET order_product_status = '".$value['order_status_id']."' WHERE order_id = '".$value['order_id']."'");

			}
	    }

	    $check_order_status = $this->db->query("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND TABLE_NAME = '".DB_PREFIX."customerpartner_to_order' AND COLUMN_NAME = 'shipping_applied'")->row;

		if (!$check_order_status) {
			
			$this->db->query("ALTER TABLE  " . DB_PREFIX . "customerpartner_to_order 
				ADD COLUMN shipping_applied float NOT NULL AFTER customer,
				ADD commission_applied decimal(10,2) NOT NULL AFTER shipping_applied,
				ADD currency_code varchar(10) NOT NULL AFTER commission_applied,  
				ADD currency_value decimal(15,8) NOT NULL AFTER currency_code,
				ADD option_data text NOT NULL AFTER order_product_status,
				ADD seller_access int(1) NOT NULL AFTER option_data  
		   ");

		}
	}

	public function createCustomerpartnerTable(){

		//Table structure for table `customerpartner_commission_category`
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."customerpartner_commission_category` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `category_id` int(100) NOT NULL,
		  `fixed` float NOT NULL,
		  `percentage` float NOT NULL,		  
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1") ;


		//Table structure for table `customerpartner_to_customer`
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."customerpartner_to_customer` (
		  `customer_id` int(11) NOT NULL,
		  `is_partner` int(1) NOT NULL,
		  `screenname` varchar(255) NOT NULL,
		  `gender` varchar(255) NOT NULL,
		  `shortprofile` text NOT NULL,
		  `avatar` varchar(255) NOT NULL,
		  `twitterid` varchar(255) NOT NULL,
		  `paypalid` varchar(255) NOT NULL,
		  `country` varchar(255) NOT NULL,
		  `facebookid` varchar(255) NOT NULL,
		  `backgroundcolor` varchar(255) NOT NULL,
		  `companybanner` varchar(255) NOT NULL,
		  `companylogo` varchar(255) NOT NULL,
		  `companylocality` varchar(255) NOT NULL,
		  `companyname` varchar(255) NOT NULL,
		  `companydescription` text NOT NULL,
		  `countrylogo` varchar(1000) NOT NULL,
		  `otherpayment` text NOT NULL,
		  `commission` decimal(10,2) NOT NULL,
		  PRIMARY KEY (`customer_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1");

		//Table structure for table `customerpartner_to_commission`
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."customerpartner_to_commission` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `customer_id` int(100) NOT NULL,
		  `commission_id` int(100) NOT NULL,		  
		  `fixed` float NOT NULL,
		  `percentage` float NOT NULL,		  
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1") ;

		//Table structure for table `customerpartner_to_product`
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."customerpartner_to_product` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `customer_id` int(100) NOT NULL,
		  `product_id` int(100) NOT NULL,
		  `price` float NOT NULL,
		  `seller_price` float NOT NULL,
		  `currency_code` varchar(11) NOT NULL,
		  `quantity` int(100) NOT NULL,	  
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1") ;

		//Table structure for table `customerpartner_feedbacks`
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."customerpartner_to_feedback` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `customer_id` smallint(6) NOT NULL,
		  `seller_id` smallint(6) NOT NULL,
		  `feedprice` smallint(6) NOT NULL,
		  `feedvalue` smallint(6) NOT NULL,
		  `feedquality` smallint(6) NOT NULL,
		  `nickname` varchar(255) NOT NULL,
		  `summary` text NOT NULL,
		  `review` text NOT NULL,
		  `status` int(1) NOT NULL,
		  `createdate` datetime NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1") ;

		//Table structure for table `customerpartner_orders`
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."customerpartner_to_order` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `order_id` int(11) NOT NULL,
		  `customer_id` int(11) NOT NULL,		  
		  `product_id` int(11) NOT NULL,
		  `order_product_id` int(100) NOT NULL,
		  `price` float NOT NULL,
		  `quantity` float(11) NOT NULL,
		  `shipping` varchar(255) NOT NULL,
		  `shipping_rate` float NOT NULL, 
		  `payment` varchar(255) NOT NULL,
		  `payment_rate` float NOT NULL, 
		  `admin` float NOT NULL,  	
		  `customer` float NOT NULL,
		  `shipping_applied` float NOT NULL, 
		  `commission_applied` decimal(10,2) NOT NULL,
		  `currency_code` varchar(10) NOT NULL,
		  `currency_value` decimal(15,8) NOT NULL,		  	  
		  `details` varchar(255) NOT NULL,
		  `paid_status` tinyint(1) NOT NULL,
		  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `order_product_status` INT(10) NOT NULL,
		  `option_data` varchar(5000),
		  `seller_access` int(1) NOT NULL,
		  PRIMARY KEY (`id`) 
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1") ;

        //Table structure for table `customerpartner_to_order_status`
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."customerpartner_to_order_status` (
		  `change_orderstatus_id` int(11) NOT NULL AUTO_INCREMENT,
		  `order_id` int(11) NOT NULL,
		  `product_id` int(11) NOT NULL,
		  `customer_id` int(11) NOT NULL,
		  `order_status_id` int(11) NOT NULL,
		  `comment` text NOT NULL,
		  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  PRIMARY KEY (`change_orderstatus_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1") ;

		//Table structure for table `customerpartner_transaction`
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."customerpartner_to_transaction` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `customer_id` int(11) NOT NULL,
		  `order_id` varchar(500) NOT NULL,
		  `order_product_id` varchar(500) NOT NULL,
		  `amount` float NOT NULL,
		  `text` varchar(255) NOT NULL,
		  `details` varchar(255) NOT NULL,
		  `date_added` date NOT NULL DEFAULT '0000-00-00',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1") ;

		//Table structure for table `customerpartner_payment`
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."customerpartner_to_payment` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `customer_id` int(11) NOT NULL,		  
		  `amount` float NOT NULL,
		  `text` varchar(255) NOT NULL,
		  `details` varchar(255) NOT NULL,
		  `request_type` varchar(255) NOT NULL,
		  `paid` int(10) NOT NULL,
		  `balance_reduced` int(10) NOT NULL,
		  `payment` varchar(255) NOT NULL,
		  `date_added` date NOT NULL DEFAULT '0000-00-00',
		  `date_modified` date NOT NULL DEFAULT '0000-00-00',
		  `added_by` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1") ;

		//Table structure for table `customerpartner_download
		$this->db->query("CREATE TABLE IF NOT EXISTS ".DB_PREFIX ."customerpartner_download (
		  `download_id` int(11) NOT NULL AUTO_INCREMENT,
		  `seller_id` int(11) NOT NULL,
		  PRIMARY KEY (`download_id`)		  
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

		//Table structure for table `customerpartner_flatshipping
		$this->db->query("CREATE TABLE IF NOT EXISTS ".DB_PREFIX ."customerpartner_flatshipping (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`partner_id` int(11) NOT NULL,
			`amount` float,
			`tax_class_id` float NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci") ;

		//Table structure for table `customerpartner_shipping
		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "customerpartner_shipping (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `seller_id` int(10) NOT NULL ,
            `country_code` varchar(100) NOT NULL ,
            `zip_to` varchar(100) NOT NULL ,
            `zip_from` varchar(100) NOT NULL ,
            `price` float NOT NULL ,
            `weight_from` decimal (10,2) NOT NULL ,
            `weight_to` decimal (10,2) NOT NULL ,                                    
            PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"); 

		//Table structure for table `customerpartner_sold_tracking
		$this->db->query("CREATE TABLE IF NOT EXISTS ".DB_PREFIX ."customerpartner_sold_tracking (
			`product_id` int(11) NOT NULL,
			`order_id` int(11) NOT NULL, 
			`customer_id` int(11) NOT NULL,
			`date_added` date NOT NULL DEFAULT '0000-00-00', 
			`tracking` varchar(100) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci") ;


		//Table structure for table `customerpartner_mail`
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."customerpartner_mail` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(100) NOT NULL,
		  `subject` varchar(1000) NOT NULL,	  
		  `message` varchar(5000) NOT NULL,	  
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1") ;

		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "wk_custom_field (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `forSeller` varchar(10) NOT NULL,
			  `fieldType` varchar(100) NOT NULL,
			  `isRequired` varchar(10) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ");

			$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "wk_custom_field_description (
			  `fieldId` int(10) NOT NULL,
			  `fieldDescription` varchar(5000) NOT NULL,
			  `fieldName` varchar(100) NOT NULL,
			  `language_id` int(10) NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");

			$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "wk_custom_field_options (
			  `optionId` int(11) NOT NULL AUTO_INCREMENT,
			  `fieldId` int(11) NOT NULL,
			  PRIMARY KEY (`optionId`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ");

			$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "wk_custom_field_option_description (
			  `optionId` int(10) NOT NULL,
			  `optionValue` varchar(100) NOT NULL,
			  `language_id` int(10) NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

			$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "wk_custom_field_product (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `fieldId` int(11) NOT NULL,
			  `productId` int(11) NOT NULL,
			  `fieldType` varchar(100) NOT NULL,
			  `fieldDescription` varchar(5000) NOT NULL,
			  `fieldName` varchar(100) NOT NULL,
			  `isRequired` varchar(50) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ");

			$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "wk_custom_field_product_options (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `pro_id` int(100) NOT NULL,
			  `product_id` int(100) NOT NULL,
			  `fieldId` int(100) NOT NULL,
			  `option_id` mediumtext CHARACTER SET utf8 NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ");
	
	}
	
	public function deleteCustomer($customer_id) {		
		$partner_products = $this->db->query("SELECT product_id FROM ".DB_PREFIX."customerpartner_to_product WHERE customer_id = '".(int)$customer_id."'")->rows;

	    $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_download WHERE seller_id = '" . (int)$customer_id . "'");
	    $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_flatshipping WHERE partner_id = '" . (int)$customer_id . "'");
	    $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_shipping WHERE seller_id = '" . (int)$customer_id . "'");
	    $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_to_feedback WHERE seller_id = '" . (int)$customer_id . "'");
	    $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_to_customer WHERE customer_id = '" . (int)$customer_id . "'");
	    $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_sold_tracking WHERE customer_id = '" . (int)$customer_id . "'");
	    $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_to_commission WHERE customer_id = '" . (int)$customer_id . "'");
	    $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_to_order WHERE customer_id = '" . (int)$customer_id . "'");
	    $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_to_order_status WHERE customer_id = '" . (int)$customer_id . "'");
	    $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_to_payment WHERE customer_id = '" . (int)$customer_id . "'");
	    $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_to_product WHERE customer_id = '" . (int)$customer_id . "'");
	    $this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_to_transaction WHERE customer_id = '" . (int)$customer_id . "'");

	    if($partner_products){
	      	foreach($partner_products as $products){
		      	if($this->config->get('wk_mpaddproduct_status')) {
			      	$this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_to_product WHERE product_id = '" . (int)$products['product_id'] . "' AND customer_id = '" . $customer_id . "' ");
			    } else if(!$this->config->get('marketplace_sellerproductdelete')){
		        	$this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_to_product WHERE product_id = '" . (int)$products['product_id'] . "'");

		        	$this->db->query("UPDATE " . DB_PREFIX . "product SET status = '0' WHERE product_id = '" . (int)$products['product_id'] . "'");
		       	}else{
                    
                    $this->load->model('catalog/product');
                    $this->model_catalog_product->deleteProduct($products['product_id']);
		       	}
	      	}
	    }

	}
	
	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
	
		return $query->row;
	}


	public function getAllCustomers() {

		$sql = $this->db->query("SELECT c.email FROM " . DB_PREFIX . "customerpartner_to_customer c2c LEFT JOIN " . DB_PREFIX . "customer c ON (c2c.customer_id = c.customer_id) WHERE c2c.is_partner = '1'");

		return $sql->rows;

	}
				
	public function getCustomers($data = array()) {

		if(isset($data['filter_all']) AND $data['filter_all'] == '1'){
			$add = '';
		}elseif(isset($data['filter_all']) AND $data['filter_all'] == '2'){
			$add = ' c2c.is_partner = 0 AND';
		}else{
			$add = ' c2c.is_partner = 1 AND';
		}

		$sql = "SELECT *,c.status, CONCAT(c.firstname, ' ', c.lastname) AS name,c.customer_id AS customer_id, c2c.is_partner,cgd.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) LEFT JOIN ". DB_PREFIX . "customerpartner_to_customer c2c ON (c2c.customer_id = c.customer_id) WHERE ". $add ." cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$implode = array();
		
		if (!empty($data['filter_name'])) {
			$implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (!empty($data['filter_email'])) {
			$implode[] = "LCASE(c.email) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_email'])) . "%'";
		}

		if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
			$implode[] = "c.newsletter = '" . (int)$data['filter_newsletter'] . "'";
		}	
				
		if (isset($data['filter_customer_group_id']) && !empty($data['filter_customer_group_id'])) {
			$implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}	
			
		if (isset($data['filter_ip']) && !empty($data['filter_ip'])) {
			$implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}	
				
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}	
		
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}	
				
		if (isset($data['filter_date_added']) && !empty($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'c.customer_id',
			'name',
			'c.email',
			'customer_group',
			'c.status',
			'c.approved',
			'c.ip',
			'c.date_added'
		);	


		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY c.customer_id";	
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

	public function getTotalCustomers($data = array()) {

      	if(isset($data['filter_all']) AND $data['filter_all'] == '1'){
			$add = '';
		}elseif(isset($data['filter_all']) AND $data['filter_all'] == '2'){
			$add = ' c2c.is_partner = 0 AND';
		}else{
			$add = ' c2c.is_partner = 1 AND';
		}

		$sql = "SELECT *,c.status, CONCAT(c.firstname, ' ', c.lastname) AS name,c.customer_id AS customer_id, c2c.is_partner,cgd.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) LEFT JOIN ". DB_PREFIX . "customerpartner_to_customer c2c ON (c2c.customer_id = c.customer_id) WHERE ". $add ." cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$implode = array();

		$implode = array();
		
		if (!empty($data['filter_name'])) {
			$implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (!empty($data['filter_email'])) {
			$implode[] = "LCASE(c.email) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_email'])) . "%'";
		}

		if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
			$implode[] = "c.newsletter = '" . (int)$data['filter_newsletter'] . "'";
		}	
				
		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}	
			
		if (!empty($data['filter_ip'])) {
			$implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}	
				
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}	
		
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}	
				
		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'c.customer_id',
			'name',
			'c.email',
			'customer_group',
			'c.status',
			'c.approved',
			'c.ip',
			'c.date_added'
		);
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY c.customer_id";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}	
	
		$query = $this->db->query($sql);
				
		return count($query->rows);
	}
	
	public function approve($customer_id,$setstatus = 1) {
            
		$customer_info = $this->getCustomer($customer_id);

		if ($customer_info) {
			
			$commission = $this->config->get('marketplace_commission') ? $this->config->get('marketplace_commission') : 0;

			$seller_info = $this->getPartner($customer_id);

			if($seller_info){
				$this->db->query("UPDATE " . DB_PREFIX . "customerpartner_to_customer SET is_partner='".(int)$setstatus."',commission = '".(float)$commission."' WHERE customer_id = '" . (int)$customer_id . "'");

				// membership modification after partner
	        	if($this->config->get('wk_seller_group_status')) {
			        $this->load->model('customerpartner/sellergroup');
			        $freeMembership = $this->db->query("SELECT * FROM ".DB_PREFIX."seller_group WHERE autoApprove = 1 ")->row;

			        if($freeMembership && isset($freeMembership['product_id']) && $freeMembership['product_id']) {
				        $sellerDetails = array (
							'seller_id' => $customer_id,
							'product_id' => $freeMembership['product_id'],
							'doMail' => true,
						);

						$quantity = $freeMembership['gquantity'];
						$customerid = $customer_id;
						$group_id = $freeMembership['groupid'];
						$status = 'paid';
						$price = $freeMembership['gprice'];
						$this->model_customerpartner_sellergroup->update_customer_quantity($quantity,$customerid,$group_id,$status,$price);
						$this->model_customerpartner_sellergroup->insert_payment($customerid,$group_id);
					}
				}

			}else{
				$this->db->query("INSERT INTO " . DB_PREFIX . "customerpartner_to_customer SET customer_id = '" . (int)$customer_id . "', is_partner='".(int)$setstatus."', commission = '".(float)$commission."', screenname = '" . $customer_info['firstname'].'-'.$customer_info['lastname'].'-'.token(50) . "'");	

				// membership modification after partner
	        	if($this->config->get('wk_seller_group_status')) {
			        $this->load->model('customerpartner/sellergroup');
			        $freeMembership = $this->db->query("SELECT * FROM ".DB_PREFIX."seller_group WHERE autoApprove = 1 ")->row;

			        if($freeMembership && isset($freeMembership['product_id']) && $freeMembership['product_id']) {
				        $sellerDetails = array (
							'seller_id' => $customer_id,
							'product_id' => $freeMembership['product_id'],
							'doMail' => true,
						);

						$quantity = $freeMembership['gquantity'];
						$customerid = $customer_id;
						$group_id = $freeMembership['groupid'];
						$status = 'paid';
						$price = $freeMembership['gprice'];
						$this->model_customerpartner_sellergroup->update_customer_quantity($quantity,$customerid,$group_id,$status,$price);
						$this->model_customerpartner_sellergroup->insert_payment($customerid,$group_id);
					}
				}

			}

			if(!$this->config->get('marketplace_mail_partner_approve'))
				return;

			$data = array_merge($customer_info,$seller_info);

			//send mail to Customer after request for Partnership
	        $this->load->model('customerpartner/mail');
	        $this->model_customerpartner_mail->mail($data,'customer_applied_for_partnership_to_seller');
	    }

	}	
	
	//for get commission
	public function getPartner($partner_id){
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX ."customerpartner_to_customer where customer_id='".$partner_id."'");
		return($query->row);	
	}

	public function getPartnerCustomerInfo($partner_id){
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX ."customerpartner_to_customer c2c LEFT JOIN ".DB_PREFIX."customer c ON (c2c.customer_id = c.customer_id) where c.customer_id='".$partner_id."'");
		return($query->row);	
	}

	public function updatePartner($partner_id,$data){	

		if(isset($data['customer']) AND $data['customer']){

			$data = $data['customer'];		

			$sql = "UPDATE ".DB_PREFIX ."customerpartner_to_customer SET ";

			foreach ($data as $key => $value) {
				$sql .= $key." = '".$this->db->escape($value)."' ,";
			}

			$sql = substr($sql,0,-2);
			$sql .= " WHERE customer_id = '".(int)$partner_id."'";

			$this->db->query($sql);
		}
		
	}

	//for update product seller
	public function updateProductSeller($partner_id,$product){

		$product_ids = array();

		if($product AND is_array($product)){
			foreach($product as $individual_product){
				$product_ids[] = $individual_product['selected'];
			}
		}else
			$product_ids[] = $product;

		foreach($product_ids as $product_id){		

			$status = $this->chkProduct($product_id);			

			if($status==1){
				$this->db->query( "INSERT INTO ".DB_PREFIX ."customerpartner_to_product SET product_id = '".(int)$product_id."', customer_id = '".(int)$partner_id."'");

			}else{
				$this->db->query( "UPDATE ".DB_PREFIX ."customerpartner_to_product SET customer_id = '".(int)$partner_id."' WHERE product_id = '".(int)$product_id."' ORDER BY id ASC LIMIT 1 ");

			}

		}
			
	}
	
	public function addproduct($partner_id,$data){

		$product_ids = $data['product_ids'];

		foreach($product_ids as $product_id){

			$status = $this->chkProduct($product_id);			

			if($status==1){
				$this->db->query( "INSERT INTO ".DB_PREFIX ."customerpartner_to_product SET product_id = '".(int)$product_id."', customer_id = '".(int)$partner_id."'");

			}elseif($status>1){
				$this->db->query( "UPDATE ".DB_PREFIX ."customerpartner_to_product SET customer_id = '".(int)$partner_id."' WHERE product_id = '".(int)$product_id."' ORDER BY id ASC LIMIT 1 ");
			}

		}
			
	}


	public function chkProduct($pid){

		$sql = $this->db->query("SELECT quantity FROM ".DB_PREFIX ."product WHERE product_id='".(int)$pid."'");

		if(isset($sql->row['quantity'])){
			$sql = $this->db->query("SELECT customer_id FROM ".DB_PREFIX ."customerpartner_to_product WHERE product_id='".(int)$pid."'");
			if(isset($sql->row['customer_id'])){
				if($sql->row['customer_id'])
					return 0; //already exists
				else
					return 2; //for update return cp product id
			}else{
				return 1; //not exists so copy
			}
		}else{
			return 0; //already exists
		}

	}
	
	public function getPartnerAmount($partner_id){		
		$total = $this->db->query("SELECT SUM(c2o.quantity) quantity,SUM(c2o.price) total,SUM(c2o.admin) admin,SUM(c2o.customer) customer FROM ".DB_PREFIX ."customerpartner_to_order c2o WHERE c2o.customer_id ='".(int)$partner_id."'")->row;

		$paid = $this->db->query("SELECT SUM(c2t.amount) total FROM ".DB_PREFIX ."customerpartner_to_transaction c2t WHERE c2t.customer_id ='".(int)$partner_id."'")->row;
		
		$total['paid'] = $paid['total'];

		return($total);
	}

	public function getPartnerTotal($partner_id,$filter_data = array() ) {		
		
		$sub_query = "(SELECT SUM(c2t.amount) as total FROM ".DB_PREFIX ."customerpartner_to_transaction c2t WHERE c2t.customer_id ='".(int)$partner_id."'";

		if(isset($filter_data['date_added_from']) || isset($filter_data['date_added_to'])) {
			if($filter_data['date_added_from'] && $filter_data['date_added_to']){
				$sub_query .= " AND c2t.date_added >= '".$filter_data['date_added_from']."' && c2t.date_added <= '".$filter_data['date_added_to']."' ";
			} else if($filter_data['date_added_from'] && !$filter_data['date_added_to']) {
				$sub_query .= " AND c2t.date_added >= '".$filter_data['date_added_from']."' ";
			} else if(!$filter_data['date_added_from'] && $filter_data['date_added_to']) {
				$sub_query .= " AND c2t.date_added <= '".$filter_data['date_added_to']."' ";
			}
		}

		if(isset($filter_data['paid_to_seller_from']) || isset($filter_data['paid_to_seller_to']) ) {
			if($filter_data['paid_to_seller_from'] && $filter_data['paid_to_seller_to']) {
				$sub_query .= " HAVING SUM(c2t.amount) > ".$filter_data['paid_to_seller_from']." && SUM(c2t.amount) < ".$filter_data['paid_to_seller_to']." )";
			} else if($filter_data['paid_to_seller_from'] && !$filter_data['paid_to_seller_to']) {
				$sub_query .= " HAVING SUM(c2t.amount) > ".$filter_data['paid_to_seller_from']." )";
			} else if(!$filter_data['paid_to_seller_from'] && $filter_data['paid_to_seller_to']) {
				$sub_query .= " HAVING SUM(c2t.amount) > ".$filter_data['paid_to_seller_to']." )";
			} else {
				$sub_query .= " )";
			}
		} else {
			$sub_query .= " )";
		}

		$sql = "SELECT SUM(c2o.quantity) quantity,(SUM(c2o.customer) + SUM(c2o.admin)) as total,SUM(c2o.admin) admin,SUM(c2o.customer) as customer, ".$sub_query." as paid FROM ".DB_PREFIX ."customerpartner_to_order c2o WHERE c2o.customer_id ='".(int)$partner_id."' ";

		if(isset($filter_data['date_added_from']) || isset($filter_data['date_added_to'])) {
			if($filter_data['date_added_from'] && $filter_data['date_added_to']){
				$sql .= " AND c2o.date_added >= '".$filter_data['date_added_from']."' && c2o.date_added <= '".$filter_data['date_added_to']."' ";
			} else if($filter_data['date_added_from'] && !$filter_data['date_added_to']) {
				$sql .= " AND c2o.date_added >= '".$filter_data['date_added_from']."' ";
			} else if(!$filter_data['date_added_from'] && $filter_data['date_added_to']) {
				$sql .= " AND c2o.date_added <= '".$filter_data['date_added_to']."' ";
			}
		}

		$sql .= " HAVING SUM(c2o.quantity) >= 0 ";

		if(isset($filter_data['total_amount_from']) || isset($filter_data['total_amount_to']) ) {
			if($filter_data['total_amount_from'] && $filter_data['total_amount_to']){
				$sql .= " AND (SUM(c2o.customer) + SUM(c2o.admin)) > ".$filter_data['total_amount_from']." && (SUM(c2o.customer) + SUM(c2o.admin)) < ".$filter_data['total_amount_to']." ";
			} else if($filter_data['total_amount_from'] && !$filter_data['total_amount_to']) {
				$sql .= " AND (SUM(c2o.customer) + SUM(c2o.admin)) > ".$filter_data['total_amount_from']." ";
			} else if(!$filter_data['total_amount_from'] && $filter_data['total_amount_to']) {
				$sql .= " AND (SUM(c2o.customer) + SUM(c2o.admin)) < ".$filter_data['total_amount_to']."";
			}
		}

		if(isset($filter_data['seller_amount_from']) || isset($filter_data['seller_amount_to']) ) {
			if($filter_data['seller_amount_from'] && $filter_data['seller_amount_to']){
				$sql .= " AND SUM(c2o.customer) > ".$filter_data['seller_amount_from']." && SUM(c2o.customer) < ".$filter_data['seller_amount_to']." ";
			} else if($filter_data['seller_amount_from'] && !$filter_data['seller_amount_to']) {
				$sql .= " AND SUM(c2o.customer) > ".$filter_data['seller_amount_from']." ";
			} else if(!$filter_data['seller_amount_from'] && $filter_data['seller_amount_to']) {
				$sql .= " AND SUM(c2o.customer) < ".$filter_data['seller_amount_to']."";
			}
		}

		if(isset($filter_data['admin_amount_from']) || isset($filter_data['admin_amount_to']) ) {
			if($filter_data['admin_amount_from'] && $filter_data['admin_amount_to']){
				$sql .= " AND SUM(c2o.admin) > ".$filter_data['admin_amount_from']." && SUM(c2o.admin) < ".$filter_data['admin_amount_to']." ";
			} else if($filter_data['admin_amount_from'] && !$filter_data['admin_amount_to']) {
				$sql .= " AND SUM(c2o.admin) > ".$filter_data['admin_amount_from']." ";
			} else if(!$filter_data['admin_amount_from'] && $filter_data['admin_amount_to']) {
				$sql .= " AND SUM(c2o.admin) < ".$filter_data['admin_amount_to']."";
			}
		}

		// echo $sql;
		$total = $this->db->query($sql)->row;
		
		return($total);
	}

	public function getPartnerAmountTotal($partner_id,$filter_data = array() ){		
		$sql = "SELECT SUM(c2o.quantity) quantity,SUM(c2o.price) total,SUM(c2o.admin) admin,SUM(c2o.customer) customer FROM ".DB_PREFIX ."customerpartner_to_order c2o WHERE c2o.customer_id ='".(int)$partner_id."' ";		
		echo $sql;

		if($filter_data['commission_from'] && $filter_data['commission_to']){
			$url .= '';
		} else if($filter_data['commission_from'] && !$filter_data['commission_to']) {
			$url .= '';
		} else if(!$filter_data['commission_from'] && $filter_data['commission_to']) {
			$url .= '';
		}
		
		$total = $this->db->query($sql)->row;

		$paid = $this->db->query("SELECT SUM(c2t.amount) total FROM ".DB_PREFIX ."customerpartner_to_transaction c2t WHERE c2t.customer_id ='".(int)$partner_id."'")->row;
		
		$total['paid'] = $paid['total'];

		return(count($total));
	}

	public function getSellerOrdersList($seller_id,$filter_data){

		$sql = "SELECT DISTINCT op.order_id,c2o.paid_status,c2o.commission_applied,c2o.customer as need_to_pay,o.date_added, CONCAT(o.firstname ,' ',o.lastname) name ,os.name orderstatus,op.*, (SELECT group_concat( concat( value) SEPARATOR ', ') FROM ".DB_PREFIX."order_option oo WHERE oo.order_product_id=c2o.order_product_id ) as value  FROM " . DB_PREFIX ."order_status os LEFT JOIN ".DB_PREFIX ."order o ON (os.order_status_id = o.order_status_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) LEFT JOIN ".DB_PREFIX."order_product op ON op.order_product_id=c2o.order_product_id WHERE c2o.customer_id = '".(int)$seller_id."' AND os.language_id = '".$this->config->get('config_language_id')."' ";

		if(isset($filter_data['date_added_from']) || isset($filter_data['date_added_to'])) {
			if($filter_data['date_added_from'] && $filter_data['date_added_to']){
				$sql .= " AND o.date_added >= '".$filter_data['date_added_from']."' && o.date_added <= '".$filter_data['date_added_to']."' ";
			} else if($filter_data['date_added_from'] && !$filter_data['date_added_to']) {
				$sql .= " AND o.date_added >= '".$filter_data['date_added_from']."' ";
			} else if(!$filter_data['date_added_from'] && $filter_data['date_added_to']) {
				$sql .= " AND o.date_added <= '".$filter_data['date_added_to']."' ";
			}
		}

		if($filter_data['order_id']) {
			$sql .= " AND op.order_id = '".$filter_data['order_id']."' " ;
		}

		if($filter_data['payable_amount']) {
			$sql .= " AND c2o.customer = ".(float)$filter_data['payable_amount']." " ;
		}

		if($filter_data['quantity']) {
			$sql .= " AND op.quantity = '".$filter_data['quantity']."' " ;
		}

		if($filter_data['order_status']) {
			$sql .= " AND os.name = '".$filter_data['order_status']."' " ;
		}

		if($filter_data['paid_status']) {
			if($filter_data['paid_status'] == 'paid')
				$filter_data['paid_status'] = 1;
			else
				$filter_data['paid_status'] = 0;
			$sql .= " AND c2o.paid_status = '".$filter_data['paid_status']."' " ;
		}
		if($filter_data['order_by'] && $filter_data['sort_by']) {
			$sql .= "ORDER BY ".$filter_data['order_by']." ".$filter_data['sort_by']." LIMIT ".$filter_data['start'].", ".$filter_data['limit']."";
		} else {
			$sql .= "ORDER BY o.order_id asc LIMIT ".$filter_data['start'].", ".$filter_data['limit']."";
		}
		$result = $this->db->query($sql);
		return($result->rows);
	}
    
	public function getProductOptions($order_product_id){
		return $this->db->query("SELECT oo.value FROM ".DB_PREFIX."order_option oo WHERE oo.order_product_id = '".(int)$order_product_id."'")->rows;
	}

	public function getSellerOrders($seller_id){
			
		$sql = $this->db->query("SELECT DISTINCT o.order_id ,o.date_added, CONCAT(o.firstname ,' ',o.lastname) name ,os.name orderstatus  FROM " . DB_PREFIX ."order_status os LEFT JOIN ".DB_PREFIX ."order o ON (os.order_status_id = o.order_status_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) WHERE c2o.customer_id = '".(int)$seller_id."' AND os.language_id = '".$this->config->get('config_language_id')."' ORDER BY o.order_id DESC ");

		return($sql->rows);
	}

	public function getTotalSellerOrders($seller_id,$filter_data){
			
		$sql = "SELECT DISTINCT op.order_id,c2o.paid_status,c2o.customer as need_to_pay,o.date_added, CONCAT(o.firstname ,' ',o.lastname) name ,os.name orderstatus,op.*, (SELECT group_concat( concat( value) SEPARATOR ', ') FROM ".DB_PREFIX."order_option oo WHERE oo.order_product_id=c2o.order_product_id ) as value  FROM " . DB_PREFIX ."order_status os LEFT JOIN ".DB_PREFIX ."order o ON (os.order_status_id = o.order_status_id) LEFT JOIN ".DB_PREFIX ."customerpartner_to_order c2o ON (o.order_id = c2o.order_id) LEFT JOIN ".DB_PREFIX."order_product op ON op.order_product_id=c2o.order_product_id WHERE c2o.customer_id = '".(int)$seller_id."' AND os.language_id = '".$this->config->get('config_language_id')."' ";

		if(isset($filter_data['date_added_from']) || isset($filter_data['date_added_to'])) {
			if($filter_data['date_added_from'] && $filter_data['date_added_to']){
				$sql .= " AND o.date_added >= '".$filter_data['date_added_from']."' && o.date_added <= '".$filter_data['date_added_to']."' ";
			} else if($filter_data['date_added_from'] && !$filter_data['date_added_to']) {
				$sql .= " AND o.date_added >= '".$filter_data['date_added_from']."' ";
			} else if(!$filter_data['date_added_from'] && $filter_data['date_added_to']) {
				$sql .= " AND o.date_added <= '".$filter_data['date_added_to']."' ";
			}
		}
		
		if($filter_data['order_id']) {
			$sql .= " AND op.order_id = '".$filter_data['order_id']."' " ;
		}

		if($filter_data['payable_amount']) {
			$sql .= " AND c2o.customer = '".$filter_data['payable_amount']."' " ;
		}

		if($filter_data['quantity']) {
			$sql .= " AND op.quantity = '".$filter_data['quantity']."' " ;
		}

		if($filter_data['order_status']) {
			$sql .= " AND os.name = '".$filter_data['order_status']."' " ;
		}

		if($filter_data['paid_status']) {
			$sql .= " AND c2o.paid_status = '".$filter_data['paid_status']."' " ;
		}

		$result = $this->db->query($sql);

		return(count($result->rows));
	}
	
	public function getSellerOrderProducts($order_id){			

		$sql = $this->db->query("SELECT op.*,c2o.price c2oprice FROM " . DB_PREFIX ."customerpartner_to_order c2o LEFT JOIN " . DB_PREFIX . "order_product op ON (c2o.order_product_id = op.order_product_id AND c2o.order_id = op.order_id) WHERE c2o.order_id = '".$order_id."' ORDER BY op.product_id ");

		return($sql->rows);
	}

	public function getCategories($data = array(), $allowed_categories){

		if ($allowed_categories) {

			$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cp.category_id NOT IN (" . $allowed_categories . ")";
			
		}else{
            
            $sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.category_id";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getAdminProducts($seller_id){

		$sql = "SELECT DISTINCT p.product_id,p.*,pd.name FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id NOT IN (SELECT product_id FROM ".DB_PREFIX."customerpartner_to_product) GROUP BY p.product_id ORDER BY pd.name";

		$query = $this->db->query($sql)->rows;

		return $query;
	}
}
?>