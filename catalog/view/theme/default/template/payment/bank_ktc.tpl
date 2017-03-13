<h2><?php echo $text_instruction; ?></h2>
<p><b><?php echo $text_description; ?></b></p>
<div class="well well-sm">
  <p><?php echo $bank; ?></p>
  <p><?php echo $text_payment; ?></p>
	<?php $total; ?>
	<?php foreach($order_detail as $order ) { ?>
	<?php $total=$order['value']; } ?>
</div>
<div class="buttons">
  <!--div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" data-loading-text="<?php echo $text_loading; ?>" />
  </div-->
	   <div class="pull-right">
 <form action="https://paygate.ktc.co.th/ktc/eng/merchandize/payment/payForm.jsp" name="payFormCcard" method="post" >
 <input type="hidden" name="orderRef" value="<?php echo $order_id; ?>">
 <input type="hidden" name="amount" value="<?php echo number_format((float)$total, 2, '.', ''); ?>"> <!-- "<?php echo $total; ?>" -->
 <input type="hidden" name="currCode" value="<?php echo $currCode; ?>">
 <input type="hidden" name="lang" value="<?php echo $lang; ?>">
 <input type="hidden" name="cancelUrl" value="<?php echo $cancelUrl; ?>">
 <input type="hidden" name="failUrl" value="<?php echo $failUrl; ?>">
 <input type="hidden" name="successUrl" value="<?php echo $successUrl; ?>">
 <input type="hidden" name="merchantId"  value="<?php echo $merchantId; ?>">
  <input type="hidden" name="payMethod"  value="<?php echo $payMethod; ?>">
	 <input type="hidden" name="payType"  value="<?php echo $payType; ?>">
	  <input type="hidden" name="TxType"  value="<?php echo $TxType; ?>">

 <input type="submit" value="<?php echo $button_confirm; ?>"  /> <!-- id="button-confirm" class="button" -->
 </form>
     </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=payment/bank_ktc/confirm',
		cache: false,
		beforeSend: function() {
			$('#button-confirm').button('loading');
		},
		complete: function() {
			$('#button-confirm').button('reset');
		},
		success: function() {
			location = '<?php echo $continue; ?>';
		}
	});
});
//--></script>
