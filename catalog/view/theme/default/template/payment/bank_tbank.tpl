<h2><?php echo $text_instruction; ?><img src="catalog/view/theme/default/image/bank_tbank_sm.png" /></h2>
<p><b><?php echo $text_description; ?></b></p>
<div class="well well-sm">
  <p><?php echo $bank; ?></p>
  <p><?php echo $text_payment; ?></p>

</div>

<div class="buttons">  
   <!--div class="pull-left"-->	
	<!--form id="TheForm" method="post" action="http://<?php //echo $_SERVER['HTTP_HOST'] ?>/accsmsback.php" target="SMS - Phone confirm" -->   
		<!--input type="submit" value="ส่ง SMS เลขที่บัญชี" id="button-sms" class="btn btn-primary" onclick="popup('SMS - Phone confirm',400,400)"/-->
	<!--input type="hidden" name="ani" value="<?php echo '66'.$ani; ?>" /-->
	<!--input type="hidden" name="msg" value="<?php echo rawurldecode($bank); ?>" /-->
<!--/form-->		
	<!--/div-->

  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" />
  </div>
</div>

<script type="text/javascript">  
function popup(name,windowWidth,windowHeight){      
    myleft=(screen.width)?(screen.width-windowWidth)/2:100;   
    mytop=(screen.height)?(screen.height-windowHeight)/2:100;     
    properties = "width="+windowWidth+",height="+windowHeight;  
    properties +=",scrollbars=yes, top="+mytop+",left="+myleft;   

	map = window.open("",name,properties);
	document.TheForm.submit();
}  
</script> 

<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({ 
		type: 'get',
		url: 'index.php?route=payment/bank_tbank/confirm',
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
