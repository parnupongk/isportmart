<style type="text/css">
  .popover{
    color: #666;
  }
</style>
<div class="tile">
  <div class="tile-heading"><?php echo $heading_title; ?> <span class="pull-right">
    <?php if ($percentage > 0) { ?>
    <i class="fa fa-caret-up"></i>
    <?php } elseif ($percentage < 0) { ?>
    <i class="fa fa-caret-down"></i>
    <?php } ?>
    <?php echo $percentage; ?>% </span></div>
  <div class="tile-body" id="popover" data-toggle="popover" data-trigger="hover"><i class="fa fa-credit-card"></i>
    <h2 class="pull-right"><?php echo $total; ?></h2>
  </div>
  <div class="tile-footer"><a href="<?php echo $sale; ?>"><?php echo $text_view; ?></a></div>
</div>

<script type="text/javascript">

  $('#toggle-order').on('click',function(){
    $('a[href="#tab-order"]').trigger('click');
  })

  jQuery(document).ready(function(){
    html = '';
    html += '<table class="table">';
    html += '<tr><td>Seller Amount</td><td><?php echo $seller_amount; ?></td></tr>';
    html += '<tr><td>Admin Amount</td><td><?php echo $admin_amount; ?></td></tr>';
    html += '<tr><td>Paid Amount</td><td><?php echo $paid_amount; ?></td></tr>';
    html += '<tr><td>Payable Amount</td><td><?php echo $payable_amount; ?></td></tr>';
    html += '</table>';
    $('#popover').popover(
              {
                html : true,
                content : html,              
                placement : 'top',
              }
          );
  })

</script>

