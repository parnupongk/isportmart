<?php
class ModelCustomerpartnerCommission extends Model {	
	
	public function getCategories() {
		$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name, (SELECT parent_id FROM ".DB_PREFIX."category WHERE category_id = cp.category_id) as parent_id, c.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c ON (cp.path_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (c.category_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sql .= " GROUP BY cp.category_id ORDER BY name";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getAddedCategories() {
		$query = $this->db->query("SELECT category_id FROM ".DB_PREFIX."customerpartner_commission_category GROUP BY id");
		return $query->rows;
	}		

	public function categorySave($data){	
		$this->db->query("INSERT INTO " .DB_PREFIX ."customerpartner_commission_category SET `category_id` = '".(int)$data['category_id']."',`fixed` = '".(float)$data['fixed']."',`percentage` = '".(float)$data['percentage']."' ");	
	}

	public function categoryUpdate($data){	
		$this->db->query("UPDATE " .DB_PREFIX ."customerpartner_commission_category SET `category_id` = '".(int)$data['category_id']."',`fixed` = '".(float)$data['fixed']."',`percentage` = '".(float)$data['percentage']."' WHERE id ='".(int)$data['id']."'");	
	}

	public function getCategoryData($id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_commission_category WHERE id='".(int)$id."'");		
		return $query->row;
	}

	public function deleteentry($id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_commission_category WHERE id='".(int)$id."'");		
	}

	public function viewtotal($data){

		$sql ="SELECT cd.name, cc.* FROM " . DB_PREFIX . "customerpartner_commission_category cc LEFT JOIN " . DB_PREFIX . "category_description cd ON (cc.category_id = cd.category_id) WHERE cd.language_id = '".$this->config->get('config_language_id')."'  ";	
		 			
		if (!empty($data['filter_name'])) {
			$data['filter_name'] = explode('&gt;', $data['filter_name']);
			$sql .= " AND LCASE(cd.name) LIKE '%" . $this->db->escape(utf8_strtolower(substr(end($data['filter_name']),4))) . "%'";
		}

		if (!empty($data['filter_id'])) {
			$sql .= " AND cc.id = '" . (float)$this->db->escape($data['filter_id']) . "'";
		}
						
		$sort_data = array(
			'cc.id',
			'cd.name',			
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY cc.id";	
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

		$result=$this->db->query($sql);

		return $result->rows;		
	}

	public function viewtotalentry($data){

		$sql ="SELECT cd.name, cc.* FROM " . DB_PREFIX . "customerpartner_commission_category cc LEFT JOIN " . DB_PREFIX . "category_description cd ON (cc.category_id = cd.category_id) WHERE cd.language_id = '".$this->config->get('config_language_id')."' ";	
		 			
		if (!empty($data['filter_name'])) {		
			$data['filter_name'] = explode('&gt;', $data['filter_name']);
			$sql .= " AND LCASE(cd.name) LIKE '%" . $this->db->escape(utf8_strtolower(substr(end($data['filter_name']),4))) . "%'";
		}

		if (!empty($data['filter_id'])) {
			$sql .= " AND cc.id = '" . (float)$this->db->escape($data['filter_id']) . "'";
		}

		$result = $this->db->query($sql);	
		return count($result->rows);		
	}

	// Manual based commission

	public function viewtotalManual($data){

		$sql ="SELECT * FROM " . DB_PREFIX . "customerpartner_commission_manual WHERE 1 ";	
		 			
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_id'])) {
			$sql .= " AND id = '" . (float)$this->db->escape($data['filter_id']) . "'";
		}
						
		$sort_data = array(
			'id',
			'name',			
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY id";	
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

		$result=$this->db->query($sql);

		return $result->rows;		
	}

	public function viewtotalentryManual($data){

		$sql ="SELECT * FROM " . DB_PREFIX . "customerpartner_commission_manual WHERE 1 ";	
		 			
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_id'])) {
			$sql .= " AND id = '" . (float)$this->db->escape($data['filter_id']) . "'";
		}

		$result = $this->db->query($sql);	

		return count($result->rows);		
	}

	public function deleteentryManual($id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "customerpartner_commission_manual WHERE id='".(int)$id."'");		
	}

	public function manualSave($data){	
		$this->db->query("INSERT INTO " .DB_PREFIX ."customerpartner_commission_manual SET `name` = '".$this->db->escape($data['name'])."',`fixed` = '".(float)$data['fixed']."',`percentage` = '".(float)$data['percentage']."' ");	
	}

	public function manualUpdate($data){	
		$this->db->query("UPDATE " .DB_PREFIX ."customerpartner_commission_manual SET `name` = '".$this->db->escape($data['name'])."',`fixed` = '".(float)$data['fixed']."',`percentage` = '".(float)$data['percentage']."' WHERE id ='".(int)$data['id']."'");	
	}

	public function getManualData($id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customerpartner_commission_manual WHERE id='".(int)$id."'");		
		return $query->row;
	}

}
?>