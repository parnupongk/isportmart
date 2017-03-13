<?php

Class ModelWkcustomfieldWkcustomfield extends Model{

	public function getProductFieldOptionValue($pro_id,$fieldId,$id){
		$sql = "SELECT * FROM ".DB_PREFIX."wk_custom_field_product_options cfpo WHERE cfpo.product_id = '".(int)$pro_id."' AND cfpo.fieldId = '".(int)$fieldId."' AND cfpo.pro_id = '".(int)$id."' ";
		$result = $this->db->query($sql)->row;

		return $result;		
	}

	public function getProductFields($id){
		$sql = "SELECT cfd.fieldId,cfd.fieldName,cf.fieldType,cfd.fieldDescription,cfp.id,cfp.isRequired FROM ".DB_PREFIX."wk_custom_field_product cfp LEFT JOIN ".DB_PREFIX."wk_custom_field cf ON cf.id=cfp.fieldId LEFT JOIN ".DB_PREFIX."wk_custom_field_description cfd ON cfd.fieldId=cfp.fieldId  WHERE cfp.productId = '".(int)$id."' AND cfd.language_id = '".(int)$this->config->get('config_language_id')."' ORDER BY cfp.id ASC ";
		$result = $this->db->query($sql)->rows;
		return $result;
	}

	public function getProductFieldOptions($pro_id,$fieldId,$id){
		$sql = "SELECT * FROM ".DB_PREFIX."wk_custom_field_product_options cfpo LEFT JOIN ".DB_PREFIX."wk_custom_field_option_description cfpd ON cfpd.optionId=cfpo.option_id WHERE cfpo.product_id = '".(int)$pro_id."' AND cfpo.fieldId = '".(int)$fieldId."' AND cfpo.pro_id = '".(int)$id."' AND cfpd.language_id = '".(int)$this->config->get('config_language_id')."' ";
		$result = $this->db->query($sql)->rows;
		return $result;				
	}

	public function addCustomFields($data,$id){

			foreach ($data as $key => $value) {
				$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field_product VALUES ('', '".(int)$value['custom_field_id']."', '".(int)$id."', '".$this->db->escape($value['custom_field_type'])."', '".$this->db->escape($value['custom_field_des'])."', '".$this->db->escape($value['custom_field_name'])."','".$this->db->escape($value['custom_field_is_required'])."'  ) ");

				$lastid = $this->db->getLastId();

				if(isset($value['custom_field_value'])){
					foreach ($value['custom_field_value'] as $index => $option) {
						$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field_product_options VALUES ('', '".(int)$lastid."', '".(int)$id."', '".(int)$value['custom_field_id']."','".$this->db->escape($option)."' ) ");
					}
				}
			}
	}

	public function editCustomFields($data,$id){
			
			$this->db->query("DELETE FROM ".DB_PREFIX."wk_custom_field_product WHERE productId = '".(int)$id."' ");
			$this->db->query("DELETE FROM ".DB_PREFIX."wk_custom_field_product_options WHERE product_id = '".(int)$id."' ");
			if($data != ''){
				foreach ($data as $key => $value) {
					$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field_product VALUES ('', '".(int)$value['custom_field_id']."', '".(int)$id."', '".$this->db->escape($value['custom_field_type'])."', '".$this->db->escape($value['custom_field_des'])."', '".$this->db->escape($value['custom_field_name'])."', '".$this->db->escape($value['custom_field_is_required'])."'  ) ");

					$lastid = $this->db->getLastId();

					if(isset($value['custom_field_value'])){
						foreach ($value['custom_field_value'] as $index => $option) {
							$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field_product_options VALUES ('', '".(int)$lastid."', '".(int)$id."', '".(int)$value['custom_field_id']."','".$this->db->escape($option)."' ) ");
						}
					}
				}
			}
	}

	public function getOptions($fieldId){
		$result = $this->db->query("SELECT * FROM ".DB_PREFIX."wk_custom_field_options cfo LEFT JOIN ".DB_PREFIX."wk_custom_field_option_description cfod ON cfod.optionId=cfo.optionId WHERE cfo.fieldId = '".(int)$fieldId."' AND cfod.language_id = '".(int)$this->config->get('config_language_id')."' ORDER BY cfod.optionId ASC ")->rows;
		return $result;
	}

	public function getOptionList($filterValue = ''){
		$sql = "SELECT cf.*,cfd.* FROM ".DB_PREFIX."wk_custom_field cf LEFT JOIN ".DB_PREFIX."wk_custom_field_description cfd ON cf.id=cfd.fieldId WHERE cfd.language_id= '".$this->config->get('config_language_id')."' ";
		if(!empty($filterValue['fieldName'])){
			$sql .= " AND cfd.fieldName like '".$this->db->escape($filterValue['fieldName'])."%' ";

		}
		if(!empty($filterValue['fieldType'])){
			$sql .= " AND cf.fieldType like '".$this->db->escape($filterValue['fieldType'])."%' ";
		}
		if(!empty($filterValue['forSeller'])){
			$sql .= " AND cf.forSeller = '".$this->db->escape($filterValue['forSeller'])."' ";
		}

		if(!empty($filterValue['sort'])){
			$sql .= "ORDER BY ".$filterValue['order']." ".$filterValue['sort'];
		}else{
			$sql .= "ORDER BY cfd.fieldName ASC ";
		}
		$result = $this->db->query($sql)->rows;
		return $result;
	}

	public function getOptionListTotals($filterValue = ''){
		$sql = "SELECT cf.*,cfd.* FROM ".DB_PREFIX."wk_custom_field cf LEFT JOIN ".DB_PREFIX."wk_custom_field_description cfd ON cf.id=cfd.fieldId WHERE cfd.language_id= '".$this->config->get('config_language_id')."' ";
		if(!empty($filterValue['fieldName'])){
			$sql .= " AND cfd.fieldName like '".$this->db->escape($filterValue['fieldName'])."%' ";

		}
		if(!empty($filterValue['fieldType'])){
			$sql .= " AND cf.fieldType like '".$this->db->escape($filterValue['fieldType'])."%' ";
		}
		if(!empty($filterValue['forSeller'])){
			$sql .= " AND cf.forSeller = '".$this->db->escape($filterValue['forSeller'])."' ";
		}

		if(!empty($filterValue['sort'])){
			$sql .= "ORDER BY ".$filterValue['order']." ".$filterValue['sort'];
		}else{
			$sql .= "ORDER BY cfd.fieldName ASC ";
		}
		$result = $this->db->query($sql)->num_rows;
		return $result;
	}

	public function getOptionDetails($id){
		$sql = "SELECT cf.*,cfd.* FROM ".DB_PREFIX."wk_custom_field cf LEFT JOIN ".DB_PREFIX."wk_custom_field_description cfd ON cf.id=cfd.fieldId WHERE cf.id='".$id."'";
		$result = $this->db->query($sql)->rows;

		return $result;
	}

	public function getFieldOptions($id){
		$sql = "SELECT * FROM ".DB_PREFIX."wk_custom_field_options cfo WHERE fieldId = '".$id."' ORDER BY cfo.optionId ASC ";
		$result = $this->db->query($sql)->rows;
		$result1 = array();
		foreach ($result as $key => $value) {
			$result1[] = $this->db->query("SELECT * FROM ".DB_PREFIX."wk_custom_field_option_description WHERE optionId = '".$value['optionId']."' ORDER BY language_id ASC ")->rows;
		}

		return $result1;	
	}

	public function insertField($data){

		$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field VALUES ('', '".$this->db->escape($data['forSeller'])."', '".$this->db->escape($data['fieldType'])."', '".$this->db->escape($data['isRequired'])."' ) ");
			
		$id = $this->db->getLastId();

		foreach ($data['fieldName'] as $key => $value) {
			$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field_description VALUES ('".(int)$id."', '".$this->db->escape($data['fieldDes'][$key])."', '".$this->db->escape($value)."', '".$this->db->escape($key)."' ) ");

		}
		if(isset($data['optionValue'])){
			foreach ($data['optionValue'] as $index => $option) {
				$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field_options VALUES ('', '".(int)$id."' ) ");
				$Optionid = $this->db->getLastId();
				foreach ($option as $key => $value) {
					$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field_option_description VALUES ('".(int)$Optionid."', '".$this->db->escape($value)."', '".(int)$key."' ) ");
				}
			}
		}

		if(isset($data['preOptionValue']) && !empty($data['preOptionValue'])){
			foreach ($data['preOptionValue'] as $index => $option) {
				$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field_options VALUES ('', '".(int)$id."' ) ");
				$Optionid = $this->db->getLastId();
				foreach ($option as $key => $value) {
					$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field_option_description VALUES ('".(int)$Optionid."', '".$this->db->escape($value)."', '".(int)$key."' ) ");
				}
			}
		}
	}

	public function updateField($data){

		$this->db->query("UPDATE ".DB_PREFIX."wk_custom_field SET forSeller = '".$this->db->escape($data['forSeller'])."', fieldType = '".$this->db->escape($data['fieldType'])."', isRequired = '".$this->db->escape($data['isRequired'])."' WHERE id = '".$data['fieldId']."' ");

		foreach ($data['fieldName'] as $key => $value) {
			$this->db->query("UPDATE ".DB_PREFIX."wk_custom_field_description SET fieldDescription = '".$this->db->escape($data['fieldDes'][$key])."', fieldName = '".$this->db->escape($value)."', language_id = '".$this->db->escape($key)."' WHERE fieldId = '".$data['fieldId']."' AND language_id = '".(int)$key."' ");

		}

		$optionIds = $this->db->query("SELECT optionId FROM ".DB_PREFIX."wk_custom_field_options WHERE fieldId = '".(int)$data['fieldId']."' ")->rows;

		$this->db->query("DELETE FROM ".DB_PREFIX."wk_custom_field_options WHERE fieldId = '".(int)$data['fieldId']."' ");

		foreach ($optionIds as $key => $value) {
			$this->db->query("DELETE FROM ".DB_PREFIX."wk_custom_field_option_description WHERE optionId = '".(int)$value['optionId']."' ");
		}
		


		if(isset($data['preOptionValue']) && !empty($data['preOptionValue'])){
			foreach ($data['preOptionValue'] as $index => $option) {
				$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field_options VALUES ('".(int)$data['optionId'][$index]."', '".(int)$data['fieldId']."' ) ");
				// $Optionid = $this->db->getLastId();
				foreach ($option as $key => $value) {
					$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field_option_description VALUES ('".(int)$data['optionId'][$index]."', '".$this->db->escape($value)."', '".(int)$key."' ) ");
				}
			}
		}

		if(isset($data['optionValue']) && !empty($data['optionValue'])){
			foreach ($data['optionValue'] as $index => $option) {
				$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field_options VALUES ('', '".(int)$data['fieldId']."' ) ");
				$Optionid = $this->db->getLastId();
				foreach ($option as $key => $value) {
					$this->db->query("INSERT INTO ".DB_PREFIX."wk_custom_field_option_description VALUES ('".(int)$Optionid."', '".$this->db->escape($value)."', '".(int)$key."' ) ");
				}
			}
		}
				
	}

	public function deleteFieldDetails($id){
		
		$fieldName = $this->db->query("SELECT fieldName FROM ".DB_PREFIX."wk_custom_field_description WHERE fieldId = '".$id."' AND language_id = '".$this->config->get('config_language_id')."' ")->row;
		$this->db->query("DELETE FROM ".DB_PREFIX."wk_custom_field WHERE id = '".(int)$id."' ");		

		$this->db->query("DELETE FROM ".DB_PREFIX."wk_custom_field_options WHERE fieldId = '".(int)$id."' ");

		$optionIds = $this->db->query("SELECT optionId FROM ".DB_PREFIX."wk_custom_field_options WHERE fieldId = '".(int)$id."' ")->rows;

		$this->db->query("DELETE FROM ".DB_PREFIX."wk_custom_field_options WHERE fieldId = '".(int)$id."' ");

		foreach ($optionIds as $key => $value) {
			$this->db->query("DELETE FROM ".DB_PREFIX."wk_custom_field_option_description WHERE optionId = '".(int)$value['optionId']."' ");
		}

		return $fieldName['fieldName'];

	}


}


?>