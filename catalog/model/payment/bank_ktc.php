<?php
class ModelPaymentBankKtc extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/bank_ktc');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('bank_ktc_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('bank_ktc_total') > 0 && $this->config->get('bank_ktc_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('bank_ktc_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'bank_ktc',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('bank_ktc_sort_order')
			);
		}

		return $method_data;
	}

	public function logPayment($data) {
		
//`oc_pktc_id` = '" . $data["oc_pktc_id"] . "',
		//$this->db->query("INSERT INTO `" . DB_PREFIX . "customer_logevent` SET `customer_id` = '" . (int)$customer_id . "', `agent_id` = '" . (int)$agent_id . "',`customer_ani` = '" . $customer_ani . "', `log_action` = '" . $this->db->escape($act) . "', `log_desc` = '" . $this->db->escape($desc) . "', `log_data` = '" . $log_data . "', `ip` = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', `date_added` = NOW()");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "pay_ktc` SET  `src` = '" . $data["src"] . "',`prc` = '" . $data["prc"] . "', `ord` = '" . $data["ord"] . "', `holder` = '" . $data["holder"] . "', `successcode` = '" . $data["successcode"] . "', `ref` = '" . $data["ref"] . "', `payRef` = ". $data["payRef"] ." ,`amt` = '" . $data["amt"] . "', `cur` = '" . $data["cur"] . "',`remark` = '" . $data["remark"] . "',`authId` = '" . $data["authId"] . "',`eci` = '" . $data["eci"] . "',`payerAuth` = '" . $data["payerAuth"] . "',`sourceIp` = '" . $data["sourceIp"] . "',`TxType` = '" . $data["TxType"] . "',`interestRate` = '" . $data["interestRate"] . "',`totalInterestAmtDue` = '" . $data["totalInterestAmtDue"] . "',`totalAmtDue` = '" . $data["totalAmtDue"] . "',`monthlyAmtDue` = '" . $data["monthlyAmtDue"] . "',`supplierName` = '" . $data["supplierName"] . "',`productName` = '" . $data["productName"] . "',`productModel` = '" . $data["productModel"] . "',`totalUsedPoint` = '" . $data["totalUsedPoint"] . "',`totalBalancePoint` = '" . $data["totalBalancePoint"] . "',`minimumPoint` = '" . $data["minimumPoint"] . "',`totalCostValue` = '" . $data["totalCostValue"] . "',`mTerm` = '" . $data["mTerm"] . "',`cardNo` = '" . $data["cardNo"] . "'");
	}
}