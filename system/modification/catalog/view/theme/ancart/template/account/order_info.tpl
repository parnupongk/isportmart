<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2><?php echo $heading_title; ?></h2>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left" colspan="2"><?php echo $text_order_detail; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left" style="width: 50%;"><?php if ($invoice_no) { ?>
              <b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br />
              <?php } ?>
              <b><?php echo $text_order_id; ?></b> #<?php echo $order_id; ?><br />
              <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?></td>
            <td class="text-left"><?php if ($payment_method) { ?>
              <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
              <?php } ?>
              <?php if ($shipping_method) { ?>
              <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
              <?php } ?></td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left" style="width: 50%;"><?php echo $text_payment_address; ?></td>
            <?php if ($shipping_address) { ?>
            <td class="text-left"><?php echo $text_shipping_address; ?></td>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left"><?php echo $payment_address; ?></td>
            <?php if ($shipping_address) { ?>
            <td class="text-left"><?php echo $shipping_address; ?></td>
            <?php } ?>
          </tr>
        </tbody>
      </table>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left"><?php echo $column_name; ?></td>
              <td class="text-left"><?php echo $column_model; ?></td>
              <td class="text-right"><?php echo $column_quantity; ?></td>
              <td class="text-right"><?php echo $column_price; ?></td>
              <td class="text-right"><?php echo $column_total; ?></td>
              <?php if ($products) { ?>
              <td style="width: 20px;"></td>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
              <td class="text-left"><?php echo $product['name']; ?>
                <?php foreach ($product['option'] as $option) { ?>
                <br />
                &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                <?php } ?></td>
              <td class="text-left"><?php echo $product['model']; ?></td>
              <td class="text-right"><?php echo $product['quantity']; ?></td>
              <td class="text-right"><?php echo $product['price']; ?></td>
              <td class="text-right"><?php echo $product['total']; ?></td>
              <td class="text-right" style="white-space: nowrap;"><?php if ($product['reorder']) { ?>
                <a href="<?php echo $product['reorder']; ?>" data-toggle="tooltip" title="<?php echo $button_reorder; ?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i></a>
                <?php } ?>

                        <!-- marketplace -->
                <a onclick = "getProductOrderStatus(<?php echo $product['order_id'];?>,<?php echo $product['product_id'];?>)" data-toggle="tooltip" title="<?php echo $button_order_detail; ?>" class="btn btn-primary"><i class="fa fa-truck"></i></a>
                 <button class="hide" href="#orderProductStatusModal" data-toggle="modal" id="statusButton"></button>
                              
                <a href="<?php echo $product['return']; ?>" data-toggle="tooltip" title="<?php echo $button_return; ?>" class="btn btn-danger"><i class="fa fa-reply"></i></a></td>
            </tr>
            <?php } ?>
            <?php foreach ($vouchers as $voucher) { ?>
            <tr>
              <td class="text-left"><?php echo $voucher['description']; ?></td>
              <td class="text-left"></td>
              <td class="text-right">1</td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
              <?php if ($products) { ?>
              <td></td>
              <?php } ?>
            </tr>
            <?php } ?>
          </tbody>
          <tfoot>
            <?php foreach ($totals as $total) { ?>
            <tr>
              <td colspan="3"></td>
              <td class="text-right"><b><?php echo $total['title']; ?></b></td>
              <td class="text-right"><?php echo $total['text']; ?></td>
              <?php if ($products) { ?>
              <td></td>
              <?php } ?>
            </tr>
            <?php } ?>
          </tfoot>
        </table>
      </div>
      <?php if ($comment) { ?>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left"><?php echo $text_comment; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left"><?php echo $comment; ?></td>
          </tr>
        </tbody>
      </table>
      <?php } ?>
      <?php if ($histories) { ?>
      <h3><?php echo $text_history; ?></h3>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left"><?php echo $column_date_added; ?></td>
            <td class="text-left"><?php echo $column_status; ?></td>
            <td class="text-left"><?php echo $column_comment; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($histories as $history) { ?>
          <tr>
            <td class="text-left"><?php echo $history['date_added']; ?></td>
            <td class="text-left"><?php echo $history['status']; ?></td>
            <td class="text-left"><?php echo $history['comment']; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>

<!-- marketplace -->
<?php if ($marketplace_status) {?>
<div id="orderProductStatusModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title"><?php echo $text_tracking; ?></h3>
        </div>
        <div class="modal-body" id="orderProductStatusModalBody">

        </div>
        <div class="modal-footer">
          <button class="btn closebtn" data-dismiss="modal" aria-hidden="true" id="closeButton">Close</button>
        </div>
      </div>
  </div>
</div> 
<script>
  function getProductOrderStatus (order_id,product_id) {
          $.ajax({
            url: 'index.php?route=account/customerpartner/order_detail&order_id='+order_id+'&product_id='+product_id,
            type: 'get',
            methodType: 'html',
            success: function(html) {
              $('#orderProductStatusModalBody').html(html);
              $('#statusButton').click();
            }
          });
  }
</script>
<?php } ?>
<!-- marketplace -->
                              
<?php echo $footer; ?>