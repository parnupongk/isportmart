<?php echo $header; ?>
<div class="container">
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> 
  		<?php echo $error_warning;  ?>
  		
  		<?php 
  			// one add @ 3/6/2016
	  		$ipAddress = $_SERVER['REMOTE_ADDR'];
			if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {			 
			    $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}	
			echo "<br/>Or IP not Allow = " . $ipAddress;
			echo "<br/>Please contact System administrator";
		?>
  	</div>
  <?php } ?>
</div>