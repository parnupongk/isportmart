<!-- nid add 10/02/2016 notification popup -->
 <?php if ($logged) { ?>
 <!--meta http-equiv="refresh" content="0"--> 
 <!--<ul class="nav">
    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><span class="label label-danger pull-left"><?php echo $alerts; ?></span> <i class="fa fa-bell fa-lg"></i></a>
      <ul class="dropdown-menu dropdown-menu-right alerts-dropdown">
        <li class="dropdown-header"><?php echo $text_order; ?></li>
        <li><a href="<?php echo $alerts_status; ?>" style="display: block; overflow: auto;"><span class="label label-danger pull-right"><?php echo $alerts; ?></span><?php echo $text_order_approve; ?></a></li>
        <li><a href="<?php echo $order_status; ?>" style="display: block; overflow: auto;"><span class="label label-warning pull-right"><?php echo $order_status_total; ?></span><?php echo $text_order_status; ?></a></li>
        <li class="divider"></li>
        <li class="dropdown-header"><?php echo $text_product; ?></li>
        <li><a href="<?php echo $product; ?>"><span class="label label-danger pull-right"><?php echo $product_total; ?></span><?php echo $text_stock; ?></a></li>
      </ul>
    </li>
  </ul>-->
  <?php } ?>
  <!-- nid add 10/02/2016 notification popup -->
  <div class="list-group">
  <?php if (!$logged) { ?>
	  <a href="<?php echo $login; ?>" class="list-group-item"><?php echo $text_login; ?></a> 
	  <!--a href="<?php echo $register; ?>" class="list-group-item"><?php echo $text_register; ?></a--> 
	  <a href="<?php echo $forgotten; ?>" class="list-group-item"><?php echo $text_forgotten; ?></a>
  <?php }  ?>  
  <?php if ($logged) { ?>
  	<a href="<?php echo $account; ?>" class="list-group-item"><?php echo $text_account; ?></a>  	
  	<a href="<?php echo $edit; ?>" class="list-group-item"><?php echo $text_edit; ?></a> 
  	<a href="<?php echo $password; ?>" class="list-group-item"><?php echo $text_password; ?></a>  
	  <!--a href="<?php echo $payment; ?>" class="list-group-item"><?php echo $text_payment; ?></a--> 
	  <!--a href="<?php echo $tracking; ?>" class="list-group-item"><?php echo $text_tracking; ?></a--> 
	  <!--a href="<?php echo $transaction; ?>" class="list-group-item"><?php echo $text_transaction; ?></a-->  	  	
	<a href="<?php echo $order_management; ?>" class="list-group-item"><?php echo $text_order_management; ?></a>
	<a href="<?php echo $quota_of_stock; ?>" class="list-group-item">Quota of Stock</a>
	<a href="<?php echo $sale_summary; ?>" class="list-group-item">Sale Summary Report</a>
	<a href="<?php echo $chart; ?>" class="list-group-item">Chart</a>
	<a href="<?php echo $chart_pie; ?>" class="list-group-item">Chart Pie</a>
	<a href="<?php echo $logout; ?>" class="list-group-item"><?php echo $text_logout; ?></a>
  <?php } ?>
</div>
