<?php
class ModelCustomerpartnerOrder extends Model {
	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT *, (SELECT CONCAT(c.firstname, ' ', c.lastname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = o.customer_id) AS customer FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {
			$reward = 0;

			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

			foreach ($order_product_query->rows as $product) {
				$reward += $product['reward'];
			}

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

			if ($order_query->row['affiliate_id']) {
				$affiliate_id = $order_query->row['affiliate_id'];
			} else {
				$affiliate_id = 0;
			}

			$this->load->model('marketing/affiliate');

			$affiliate_info = $this->model_marketing_affiliate->getAffiliate($affiliate_id);

			if ($affiliate_info) {
				$affiliate_firstname = $affiliate_info['firstname'];
				$affiliate_lastname = $affiliate_info['lastname'];
			} else {
				$affiliate_firstname = '';
				$affiliate_lastname = '';
			}

			$this->load->model('localisation/language');

			$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

			if ($language_info) {
				$language_code = $language_info['code'];
				$language_directory = $language_info['directory'];
			} else {
				$language_code = '';
				$language_directory = '';
			}

			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $order_query->row['customer_id'],
				'customer'                => $order_query->row['customer'],
				'customer_group_id'       => $order_query->row['customer_group_id'],
				'firstname'               => $order_query->row['firstname'],
				'lastname'                => $order_query->row['lastname'],
				'email'                   => $order_query->row['email'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'custom_field'            => json_decode($order_query->row['custom_field'], true),
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
				'payment_custom_field'    => json_decode($order_query->row['payment_custom_field'], true),
				'payment_method'          => $order_query->row['payment_method'],
				'payment_code'            => $order_query->row['payment_code'],
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
				'shipping_custom_field'   => json_decode($order_query->row['shipping_custom_field'], true),
				'shipping_method'         => $order_query->row['shipping_method'],
				'shipping_code'           => $order_query->row['shipping_code'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'reward'                  => $reward,
				'order_status_id'         => $order_query->row['order_status_id'],
				'affiliate_id'            => $order_query->row['affiliate_id'],
				'affiliate_firstname'     => $affiliate_firstname,
				'affiliate_lastname'      => $affiliate_lastname,
				'commission'              => $order_query->row['commission'],
				'language_id'             => $order_query->row['language_id'],
				'language_code'           => $language_code,
				'language_directory'      => $language_directory,
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'ip'                      => $order_query->row['ip'],
				'forwarded_ip'            => $order_query->row['forwarded_ip'],
				'user_agent'              => $order_query->row['user_agent'],
				'accept_language'         => $order_query->row['accept_language'],
				'date_added'              => $order_query->row['date_added'],
				'date_modified'           => $order_query->row['date_modified']
			);
		} else {
			return;
		}
	}

	public function getOrders($data = array()) {
		$sql = "SELECT DISTINCT o.order_id, CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status, o.shipping_code, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified, c2o.seller_access FROM " . DB_PREFIX . "customerpartner_to_order c2o LEFT JOIN `" . DB_PREFIX . "order` o ON (c2o.order_id = o.order_id)";

		if (isset($data['filter_order_status'])) {
			$implode = array();

			$order_statuses = explode(',', $data['filter_order_status']);

			foreach ($order_statuses as $order_status_id) {
				$implode[] = "o.order_status_id = '" . (int)$order_status_id . "'";
			}

			if ($implode) {
				$sql .= " WHERE (" . implode(" OR ", $implode) . ")";
			}
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (isset($data['filter_order_access'])) {
			$sql .= " AND c2o.seller_access = '" . (int)$data['filter_order_access'] . "'";
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		$sort_data = array(
			'o.order_id',
			'customer',
			'status',
			'o.date_added',
			'o.date_modified',
			'o.total'
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

	public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->rows;
	}

	public function getOrderVouchers($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderVoucherByVoucherId($voucher_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE voucher_id = '" . (int)$voucher_id . "'");

		return $query->row;
	}

	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT SUM(price) total FROM " . DB_PREFIX . "customerpartner_to_order WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getTotalOrders($data = array()) {
		$sql = "SELECT DISTINCT o.order_id, CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status, o.shipping_code, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified, c2o.seller_access FROM " . DB_PREFIX . "customerpartner_to_order c2o LEFT JOIN `" . DB_PREFIX . "order` o ON (c2o.order_id = o.order_id)";

		if (isset($data['filter_order_status'])) {
			$implode = array();

			$order_statuses = explode(',', $data['filter_order_status']);

			foreach ($order_statuses as $order_status_id) {
				$implode[] = "o.order_status_id = '" . (int)$order_status_id . "'";
			}

			if ($implode) {
				$sql .= " WHERE (" . implode(" OR ", $implode) . ")";
			}
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (isset($data['filter_order_access'])) {
			$sql .= " AND c2o.seller_access = '" . (int)$data['filter_order_access'] . "'";
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		$sort_data = array(
			'o.order_id',
			'customer',
			'status',
			'o.date_added',
			'o.date_modified',
			'o.total'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY o.order_id";
		}

		$query = $this->db->query($sql);

		return count($query->rows);
	}

	public function getTotalOrdersByStoreId($store_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE store_id = '" . (int)$store_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrdersByOrderStatusId($order_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$order_status_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function getTotalOrdersByProcessingStatus() {
		$implode = array();

		$order_statuses = $this->config->get('config_processing_status');

		foreach ($order_statuses as $order_status_id) {
			$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
		}

		if ($implode) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE " . implode(" OR ", $implode));

			return $query->row['total'];
		} else {
			return 0;
		}
	}

	public function getTotalOrdersByCompleteStatus() {
		$implode = array();

		$order_statuses = $this->config->get('config_complete_status');

		foreach ($order_statuses as $order_status_id) {
			$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
		}

		if ($implode) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE " . implode(" OR ", $implode) . "");

			return $query->row['total'];
		} else {
			return 0;
		}
	}

	public function getTotalOrdersByLanguageId($language_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE language_id = '" . (int)$language_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function getTotalOrdersByCurrencyId($currency_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE currency_id = '" . (int)$currency_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function createInvoiceNo($order_id) {
		$order_info = $this->getOrder($order_id);

		if ($order_info && !$order_info['invoice_no']) {
			$query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "order` WHERE invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "'");

			if ($query->row['invoice_no']) {
				$invoice_no = $query->row['invoice_no'] + 1;
			} else {
				$invoice_no = 1;
			}

			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_no = '" . (int)$invoice_no . "', invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "' WHERE order_id = '" . (int)$order_id . "'");

			return $order_info['invoice_prefix'] . $invoice_no;
		}
	}

	public function getOrderHistories($order_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT oh.date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalOrderHistories($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrderHistoriesByOrderStatusId($order_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_status_id = '" . (int)$order_status_id . "'");

		return $query->row['total'];
	}

	public function getEmailsByProductsOrdered($products, $start, $end) {
		$implode = array();

		foreach ($products as $product_id) {
			$implode[] = "op.product_id = '" . (int)$product_id . "'";
		}

		$query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0' LIMIT " . (int)$start . "," . (int)$end);

		return $query->rows;
	}

	public function getTotalEmailsByProductsOrdered($products) {
		$implode = array();

		foreach ($products as $product_id) {
			$implode[] = "op.product_id = '" . (int)$product_id . "'";
		}

		$query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0'");

		return $query->row['total'];
	}

	/**
	 * [getSellerOrderProducts to get products by order]
	 * @param  [integer] $order_id [order id of particular order]
	 * @return [array]           [details of products]
	 */
	public function getSellerOrderProducts($order_id){			

		$sql = $this->db->query("SELECT op.*,c2o.price c2oprice, c2o.paid_status,c2o.order_product_status FROM " . DB_PREFIX ."customerpartner_to_order c2o LEFT JOIN " . DB_PREFIX . "order_product op ON (c2o.order_product_id = op.order_product_id AND c2o.order_id = op.order_id) WHERE c2o.order_id = '".$order_id."' ORDER BY op.product_id ");

		return($sql->rows);
	}

	/**
	 * [getOdrTracking to get tracking of an order]
	 * @param  [integer] $order_id  [order_id]
	 * @param  [integer] $product_id [product id of product]
	 * @param  [integer] $customer_id [customer id of customer]
	 * @return [array]       [tracking details of an order]
	 */
	public function getOdrTracking($order_id,$product_id){		

		$sql = "SELECT tracking FROM " . DB_PREFIX ."customerpartner_sold_tracking where product_id='".(int)$product_id."' AND order_id='".(int)$order_id."'";
		
		return($this->db->query($sql)->row);
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

/**
	 * [getWholeOrderStatus get order status in which that
	 *  
	 * 1) if all the order product status of that order is same status then whole order status of that order will be that status
	 * 2) If one order product status is complete and other product status are cancel then whole order status will be complete
	 * 3) If all the order product status are complete then whole order status will be complete
	 * 4) If all the order product status are cancel then whole order status will be cancel]
	 * @param  [type] $order_id                    [int]
	 * @param  [type] $admin_complete_order_status [int]
	 * @param  [type] $admin_cancel_order_status   [int]
	 * @param  [type] $seller_orderstatus_id       [int]
	 * @return [type]                              [int]
	 */
	public function getWholeOrderStatus($order_id,$admin_complete_order_status,$admin_cancel_order_status,$seller_orderstatus_id){
          
          $allOrderStatus = array();
        
          $getAllStatus =  $this->db->query("SELECT order_product_status FROM " . DB_PREFIX . "customerpartner_to_order WHERE order_id = '".$order_id."'")->rows;

          foreach ($getAllStatus as $key => $value) {
          	 
          	 array_push($allOrderStatus,$value['order_product_status']);
          }

          $isSameSatus = array_unique($allOrderStatus);

          if (count($isSameSatus) == 1) {
          	  
          	  return $isSameSatus[0];

          }else{
             
             $check_cancel = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_to_order WHERE order_id = '".$order_id."' AND order_product_status = '".$admin_cancel_order_status."'")->num_rows;

             $check_total_order = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_to_order WHERE order_id = '".$order_id."'")->num_rows;
             

             if ($check_total_order - $check_cancel == 1) {
             	
             	 $getOtherStatus = $this->db->query("SELECT order_product_status FROM " . DB_PREFIX . "customerpartner_to_order WHERE order_id = '".$order_id."' AND order_product_status != '".$admin_cancel_order_status."'")->row;

             	 return $getOtherStatus['order_product_status'];

             }else{

             	 return $this->config->get('config_order_status_id');
             }
             

          }

          
	} 

	/**
     * [addSellerOrderStatus uses to update seller order product status]
     * @param [type] $order_id      [order Id]
     * @param [type] $orderstatusid [order status Id]
     * @param string $comment       [comment]
     */
	public function addSellerOrderStatus($order_id,$orderstatusid,$post,$products,$seller_change_order_status_name){

		foreach ($products as $value) {
       	  $product_details = $this->getProduct($value);

       	  $seller_id = $this->getSellerbasedonProduct($value);

		  $seller_id = $this->getSellerbasedonProduct($value);
		  if ($post['comment']) {
		  	  
		  	  $comment = $product_details['product_name'].' '.'status has been changed to'.' '.$seller_change_order_status_name. "\n\n";
		  	  $comment .= strip_tags(html_entity_decode($post['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
		  }else{
		  	  $comment = $product_details['product_name'].''.'status has been changed to'.' '.$seller_change_order_status_name;
		  }

       	  $this->db->query("INSERT INTO " . DB_PREFIX . "customerpartner_to_order_status SET order_id = '".$order_id."',order_status_id = '".$orderstatusid."',comment = '".$comment."',product_id = '".$product_details['product_id']."',customer_id = '".$seller_id."',date_added = NOW()");


       	  
        }
        return false;
		
	}

	public function getSellerbasedonProduct($product_id) {
		$result = $this->db->query("SELECT customer_id FROM ".DB_PREFIX."customerpartner_to_product WHERE product_id = '".(int)$product_id."' ORDER BY id ASC LIMIT 1")->row;
		if($result)
			return $result['customer_id'];
		else			
			return false;
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
	       	  $product_names[] = $product_details['product_name']; 
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
			$mail->setFrom($adminMail);
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
			$mail->setFrom($this->config->get('marketplace_adminmail'));
			$mail->setSender($order_info['store_name']);
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();

		}
		
		return true;
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

			$seller_id = $this->getSellerbasedonProduct($product_id);

			if($tracking_no){
				$sql = $this->db->query("SELECT c2t.* FROM " . DB_PREFIX ."customerpartner_sold_tracking c2t WHERE c2t.customer_id='".(int)$seller_id."' AND c2t.product_id='".(int)$product_id."' AND c2t.order_id='".(int)$order_id."'")->row;

				if(!$sql){
					$this->db->query("INSERT INTO " . DB_PREFIX ."customerpartner_sold_tracking SET customer_id='".(int)$seller_id."' ,tracking='".$this->db->escape($tracking_no)."' ,product_id='".(int)$product_id."' ,order_id='".(int)$order_id."'");

					$sql = $this->db->query("SELECT name FROM " . DB_PREFIX ."order_product WHERE product_id='".(int)$product_id."' AND order_id='".(int)$order_id."'")->row;

					if($sql){
						$comment .= 'Product - '. $sql['name'].'<br/>'.'Seller Tracking No - '. $tracking_no.'<br/>';

						$commentForproduct = 'Product - '. $sql['name'].'<br/>'.'Seller Tracking No - '. $tracking_no.'<br/>';

						$productOrderStatus = $this->db->query("SELECT os.order_status_id FROM " . DB_PREFIX ."customerpartner_to_order c2o LEFT JOIN  ". DB_PREFIX ."order_status os ON (c2o.order_product_status = os.order_status_id) WHERE c2o.product_id='".(int)$product_id."' AND c2o.customer_id='".(int)$seller_id."'")->row;

						$this->db->query("INSERT INTO " . DB_PREFIX . "customerpartner_to_order_status SET order_id = '" . (int)$order_id . "',product_id = '".$product_id."',customer_id='".(int)$seller_id."',order_status_id = '".$productOrderStatus['order_status_id']."',comment = '".$this->db->escape($commentForproduct)."', date_added = NOW()");
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

	public function getOrderStatusId($order_id){
        
        $query = $this->db->query("SELECT order_status_id FROM " . DB_PREFIX . "order WHERE order_id = '".$order_id."'")->row;

        return $query;

	}

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

	public function giveAccess($order_id, $access){

		$this->db->query("UPDATE `" . DB_PREFIX . "customerpartner_to_order` SET seller_access = '" . (int)$access . "' WHERE order_id = '" . (int)$order_id . "'");

	}
}
