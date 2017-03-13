<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>

  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>

  <?php if($chkIsPartner){ ?>
  <div id="content" class="<?php echo $class; ?>">
    <?php echo $content_top; ?>    
    <h1>
      <?php echo $heading_title; ?>
      <div class="pull-right">
        <a href="<?php echo $back; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
    </h1>

    <fieldset>
      <legend><i class="fa fa-list"></i> <?php echo $heading_title." ".$product_id; ?></legend>
      <?php if(!isset($access_error) && isset($isMember) && $isMember) { ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
        	<tr>
        		<td class="text-left"><a><?php echo $entry_wkorder ?></a></td>
        		<td class="text-left"><a><?php echo $entry_wkcustomer ?></a></td>
        		<td class="text-left"><a><?php echo $entry_wkqty ?></a></td>
        		<td class="text-eft"><a><?php echo $entry_wkprice ?></a></td>
        		<td class="text-left"><a><?php echo $entry_wksold ?></a></td>
            <td class="text-center"><a><?php echo $entry_transaction_status ?></a></td>
        		<td class="text-left"></td>
        	</tr>
          </thead>
          <tbody>
            <?php if($orders){ ?>    
              <?php foreach($orders as $order) {?>
                <tr>
              		<td class="text-left"><?php echo "#".$order['order_id'] ?></td>
              		<td class="text-left"><?php echo $order['name'] ?></td>
              		<td class="text-left"><?php echo $order['quantity']?></td>
              		<td class="text-left"><?php echo $order['price']; ?></td>
              		<td class="text-left"><?php echo $order['date_added'];?></td>
                  <td class="text-center"><?php echo $order['paid_status'];?></td>
              		<td class="text-center"> <a href="<?php echo $order['link'];?>" class="btn btn-primary btn-xs" data-toggle="tooltip" title="<?php echo $text_invoice; ?>"> <i class="fa fa-eye"></i></a></td>
                <tr>
          		<?php } ?>
            <?php }else{ ?>
            <tr>
              <td colspan="6" class="text-left"></td>
            </tr>
            <?php } ?> 
          </tbody>
        </table>
        <div class="text-right"><?php echo $pagination ;?></div>
        <div class="text-right"><?php echo $results ;?></div>
      </div>
    </fieldset>
    <?php }else{ ?>
      <?php echo $text_access; ?>
    <?php } ?>
    <?php echo $content_bottom; ?>      
  </div>
  <?php } ?>
  <?php echo $column_right; ?>  
  </div>
</div>
<?php echo $footer; ?>
