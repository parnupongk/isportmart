<?php echo $header; ?>
<style type="text/css">
  .order-info-buttons{
    background-color: blue;
    padding: 10px;
  }
</style>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="row" id="main-content"><?php echo $column_left; ?>
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
        <a href="<?php echo $continue; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
        <a href="<?php echo $order_invoice; ?>" data-toggle="tooltip" class="btn btn-primary" target="_blank" title="<?php echo $button_invoice; ?>"><i class="fa fa-print"></i></a>

        <?php if ($marketplace_cancel_order_status) {?>
          <button onclick="cancel_order()" class="btn btn-danger cancel-button" data-toggle="tooltip" title="<?php echo $button_cancel; ?>">Cancel</button>
        <?php } ?>
      </div>
    </h1>

    <fieldset>
      <legend><i class="fa fa-list"></i> <?php echo $heading_title; ?></legend>

      <?php if(!$errorPage && $isMember) { ?> 
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
              <td class="text-left" style="width: 50%;"><?php if ($payment_method) { ?>
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
              <td class="text-left"><?php echo $text_payment_address; ?></td>
              <?php if ($shipping_address) { ?>
              <td class="text-left"><?php echo $text_shipping_address; ?></td>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="left"><?php echo $payment_address; ?></td>
              <?php if ($shipping_address) { ?>
              <td class="text-left"><?php echo $shipping_address; ?></td>
              <?php } ?>
            </tr>
          </tbody>
        </table>

        <form class="form-horizontal" action="<?php echo $action; ?>" method="post" id="main-form">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
               <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked); checked" /></td>
                <td class="text-left"><?php echo $column_name; ?></td>
                <td class="text-left"><?php echo $column_model; ?></td>
                <td class="text-right"><?php echo $column_quantity; ?></td>
                <td class="text-right"><?php echo $column_transaction_status; ?></td>
                <td class="text-center"><?php echo $column_seller_order_status; ?></td> 
                <td class="text-right"><?php echo $column_price; ?></td>
                <td class="text-right"><?php echo $column_total; ?></td>        
                <td class="text-left"><?php echo $column_tracking_no; ?></td> 
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product) { ?>
              <tr>
             <?php if (($product['order_product_status'] == $marketplace_cancel_order_status) || (isset($marketplace_complete_order_status) && $product['order_product_status'] == $marketplace_complete_order_status)) { ?>
                <td></td>
              <?php }else{?>
                <td style="text-align: center;">
                  <input data-status-id="<?php echo $product['order_product_status'];?>" class="selection" type="checkbox" name="selected" value="<?php echo $product['product_id']; ?>"/>
                </td>
              <?php } ?>
                <!-- file download code added -->
                <td class="text-left"><?php echo $product['name']; ?>
                  <?php foreach ($product['option'] as $option) { ?>
                  <br />
                  <?php if ($option['type'] != 'file') { ?>
                  &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                  <?php } else { ?>
                  &nbsp;<small> - <?php echo $option['name']; ?>: <a href="<?php echo $option['href']; ?>"><?php echo $option['value']; ?></a></small>
                  <?php } ?>
                <?php } ?>
                </td>
                <td class="text-left"><?php echo $product['model']; ?></td>
                <td class="text-right"><?php echo $product['quantity']; ?></td>
                <td class="text-right"><?php echo $product['paid_status']; ?></td>
                 <?php foreach ($order_statuses as $key => $order_status) { ?>
                 <?php if (in_array($product['order_product_status'], $order_status)) {?>
                  <td class="text-center"><?php echo $order_status['name']; ?></td>
                 <?php } ?>
                 <?php } ?>
                <td class="text-right"><?php echo $product['price']; ?></td>
                <td class="text-right"><?php echo $product['total']; ?></td>  
                <td class="text-left">
                  <?php if($product['tracking']){ ?>
                    <?php echo $product['tracking']; ?>
                  <?php }else{ ?>
                    <input type="text" class="form-control" name="tracking[<?php echo $product['product_id'];?>]" placeholder="<?php echo $column_tracking_no; ?>" />
                  <?php $i = true; } ?>
                </td>
                <!-- <td class="text-center"><button id="<?php echo $product['product_id']; ?>" class="btn btn-danger cancel-button">Cancel</button></td>           -->
              </tr>
              <?php } ?>
              <?php foreach ($vouchers as $voucher) { ?>
              <tr>
                <td class="text-left"><?php echo $voucher['description']; ?></td>
                <td class="text-left"></td>
                <td class="text-right">1</td>
                <td class="text-right"><?php echo $voucher['amount']; ?></td>
                <td class="text-right"><?php echo $voucher['amount']; ?></td>        
              </tr>
              <?php }  ?>
            </tbody>
          <tfoot>
              <?php foreach ($totals as $total) { ?>
              <tr>
                <td class="text-right" colspan="7"><b><?php echo $column_total; ?></b></td>
                <td class="text-right"><?php echo $total['total']; ?></td>     
                <td class="text-right"><?php if(isset($i)){ ?><input type="submit" style="width:100%" class="btn btn-info"/><?php } ?></td>
              </tr>
              <?php } ?>
            </tfoot>
          </table>
        </form>
        <?php if ($wksellerorderstatus) {?>
        <div class="col-xs-12">
          <div class="col-sm-6 text-center"><div id="order-status-button" class="order-info-buttons btn-primary">Order Status</div></div>
          <div class="col-sm-6 text-center"><div id="order-comment-button" class="order-info-buttons btn-primary">Add Comment</div></div>
        </div>

        <div class="col-xs-12" style="margin-top:20px;">
            <?php if(isset($marketplace_available_order_status) && $marketplace_available_order_status) { ?>
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $history_info; ?></div>
          <?php } else { ?>
            <div class="alert alert-danger" id=""><i class="fa fa-exclamation-circle"></i> <?php echo $order_status_info; ?><button type="button" class="close" data-dismiss="alert" >&times;</button></div>
          <?php } ?>
          <form>
            <div class="form-group" id="change-order-status">
              <label class="col-sm-2 control-label" for="input-order"><?php echo $entry_order_status; ?></label>
              <div class="col-sm-10">
                <select id="order_status_id" name="order_status_id" class="form-control">
                  <?php if($wksellerorderstatus){ ?>
                    <?php foreach ($marketplace_order_status_sequence as $key => $order_status) { ?>
                        <?php if ($order_status['order_status_id'] == $order_status_id) { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                        <?php } else { ?>
                          <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                        <?php } ?>
         
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group" id="add-order-comment" style="display:none">
              <label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
              <div class="col-sm-10">
                <textarea name="comment" cols="40" rows="8" class="form-control" id="input-comment"></textarea>
              </div>
            </div>
              <a id="button-history" class="btn btn-primary pull-right" style="margin-top:20px;"><?php echo $button_submit; ?></a>
          </form>
        </div>
        <?php } ?>

        <div class="clear"></div>

        <?php if ($histories) { ?>
        <h2><?php echo $text_history; ?></h2>
        <table class="table table-bordered table-hover" id="history">
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
        <?php }else{ ?>
        <div>
          <?php echo $error_page_order; ?>
        </div>
        <?php } ?>

    </fieldset>
      <?php echo $content_bottom; ?> 
    </div>
    <?php }else{
          echo "<h2 class='text-danger'> For Become Seller inform Admin </h2>"; 
    } ?>
    <?php echo $column_right; ?>  
  </div>
</div>

<script>
var order_status_sequence = [];
<?php if(isset($marketplace_order_status_sequence) && $marketplace_order_status_sequence) { ?>
  <?php foreach ($marketplace_order_status_sequence as $key => $sequence) { ?>
    order_status_sequence.push(<?php echo $sequence["order_status_id"]; ?>);
  <?php } ?>
<?php } ?>

  $(':checkbox').change(function(){
    var status_ids = [];
    var index_array = [];

    $(".selection:checked").each(function(){
      status_ids.push($(this).attr('data-status-id'));
    });

    if (status_ids.length > 0) {
      $("#order_status_id").children('option').remove();
      $.each(order_status_sequence,function(index,value){
        $.each(status_ids,function(i,v){
           if (value == v) {
              index_array.push(index);
           }
        });
      });

      max_change_status_id = Math.max.apply(null, index_array); 
      changeOrderStatusSequence(max_change_status_id);
    }
  });

function changeOrderStatusSequence (max_change_status_id){
    var final_order_sequence = [];
    $.each(order_status_sequence,function(index,value){
      if (index >= max_change_status_id) {
          final_order_sequence.push(value);
      }
    });

    $.each(final_order_sequence,function(index,value){
      <?php foreach ($marketplace_order_status_sequence as $key => $value) {?>
        if (<?php echo $value['order_status_id'];?> == value) {
           $("#order_status_id").append('<option value="<?php echo $value['order_status_id']; ?>"><?php echo $value['name']; ?></option>');
        }
      <?php } ?>
    });
}
</script>

<script>
<?php if ($marketplace_cancel_order_status) {?>
  function cancel_order(){
    var order_id = <?php echo $order_id; ?>;
    var order_status_id =  <?php echo $marketplace_cancel_order_status; ?>;
    var comment = '';
    var product_ids = [];
    $(".selection:checked").each(function(){
      
      product_ids.push($(this).val())
    });

    change_order_status(order_id,order_status_id,product_ids,comment);
  }
 <?php } ?> 

  function change_order_status(order_id,order_status_id,product_ids,comment){
      $.ajax({
      url: 'index.php?route=account/customerpartner/orderinfo/history&order_id='+order_id+'',
      type: 'post',
      dataType: 'json',
      data: 'order_status_id=' +order_status_id+ '&comment=' +comment+'&product_ids='+product_ids,
      beforeSend: function() {
        $('.alert-success, .alert-warning').remove();
        $('#history').before('<div class="alert alert-warning"><i class="fa fa-refresh fa-spin"></i> <?php echo $text_wait; ?></div>');
        
      },
      complete: function() {
        $('.alert-warning').remove();
      },
      success: function(json) {
        $('.alert-danger').remove();
        if(json['success']){
          $('#history').before('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> ' + json['success'] + '</div>');

          var d = new Date();
          var strDate = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear();

          $('#history').append('<tr><td class="text-left">'+strDate+'</td><td class="text-left">'+$('select[name=\'order_status_id\'] option:selected').text()+'</td><td class="text-left">'+$('textarea[name=\'comment\']').val()+'</td></tr>');  
          $('textarea[name=\'comment\']').val('');
          location.reload();           
        }else{
           $('#main-content').before('<div class="alert alert-danger" id="order_status_error" ><i class="fa fa-exclamation-circle"></i>'+json['error']+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
           $('html, body').animate({ scrollTop: 0 }, 'slow');
        }
      }
    });

  }
</script>

<script>
  
  $('#order-status-button').click(function(){
    $('#add-order-comment').hide();
    $('#change-order-status').show();
  });

  $('#order-comment-button').click(function(){
    $('#change-order-status').hide();
    $('#add-order-comment').show();
  });
  
</script>

<script>


$('#button-history').on('click', function() {
    var order_id = <?php echo $order_id; ?>;
    var order_status_id =  encodeURIComponent($('select[name=\'order_status_id\']').val());
    var comment = encodeURIComponent($('textarea[name=\'comment\']').val());
    var product_ids = [];
    $(".selection:checked").each(function(){
      
      product_ids.push($(this).val())
    });

    change_order_status(order_id,order_status_id,product_ids,comment);
});
</script> 
<?php echo $footer; ?> 





















