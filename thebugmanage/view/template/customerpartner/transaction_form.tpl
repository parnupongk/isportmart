<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <div class="dropdown pull-left" style="margin-right:5px">
          <label for="limit_dropdown"><?php echo $entry_show_limit; ?></label>
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
            <?php echo $limit; ?>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" id="limit_dropdown" role="menu" aria-labelledby="dropdownMenu1">
            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $limit_ten; ?>">10</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $limit_twentyfive; ?>">25</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $limit_fifty; ?>">50</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $limit_hundred; ?>">100</a></li>
          </ul>
        </div>
        <button type="submit" form="form-transaction" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>

  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>

      <div class="panel-body">

        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $info_transaction_select; ?> <br>
        &nbsp;&nbsp; &nbsp;You can see Transaction Price changing after selecting / deselecting order products (with order status which you selected Complete in Marketplace module)
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>

        <form action="<?php echo $save; ?>" method="post" enctype="multipart/form-data" id="form-transaction" class="form-horizontal">

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-amount">
              <?php echo $entry_seller_name; ?>
            </label>
            <div class="col-sm-10">             
              <input name="customer_id" type="hidden" value="<?php if($customers) echo $customers['customer_id']; ?>" />
              <label class="control-label" name="" value="" >
                <?php if($customers) echo $customers['firstname']." ".$customers['lastname']; ?>
              </label>
            </div>
          </div> 

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-amount">
              <?php echo $entry_seller_email; ?>
            </label>
            <div class="col-sm-10">             
              <!-- <input type="text" id="input-amount" readonly class="form-control" name="amount" value="<?php echo $amount; ?>" /> -->
              <label class="control-label" name="" value="" >
                <?php if($customers) echo $customers['email']; ?>
              </label>
            </div>
          </div> 

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-amount">
              <?php echo $entry_payable_amount; ?>
            </label>
            <div class="col-sm-10">             
              <input type="hidden" id="input-amount" readonly class="form-control" name="amount" value="<?php echo $amount; ?>" />
              <label class="control-label" name="amount" value="" >
                <?php echo $amount; ?>
              </label>
            </div>
          </div> 

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-details">
              <?php echo $entry_details; ?>
            </label>
            <div class="col-sm-10">             
              <textarea id="input-details" class="form-control" name="details" rows="3"><?php echo $details; ?></textarea>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <th width="1"></th>
                <th>
                  <a href="<?php echo $order_id_url; ?>" class="<?php if(isset($sort_order) && $sort_order == 'op.order_id') echo $sort; ?>" >
                    <?php echo $entry_order_id; ?>
                  </a>
                </th>
                <th>
                  <a href="<?php echo $product_name_url; ?>" class="<?php if(isset($sort_order) && $sort_order == 'o.firstname') echo $sort; ?>" >
                    <?php echo $entry_product_name; ?>
                  </a>
                </th>

                <th>
                  <a href="<?php echo $commission_applied_url; ?>" class="<?php if(isset($sort_order) && $sort_order == 'c2o.commission_applied') echo $sort; ?>" >
                    <?php echo $entry_commission_applied; ?>
                  </a>
                </th>


                <th>
                  <a href="<?php echo $payable_amount_url; ?>" class="<?php if(isset($sort_order) && $sort_order == 'c2o.customer') echo $sort; ?>" >
                    <?php echo $entry_payable_amount; ?>
                  </a>
                </th>
                <th>
                  <a href="<?php echo $quantity_url; ?>" class="<?php if(isset($sort_order) && $sort_order == 'op.quantity') echo $sort; ?>" >
                    <?php echo $entry_quantity; ?>
                  </a>
                </th>
                <th>
                  <a href="<?php echo $date_added_url; ?>" class="<?php if(isset($sort_order) && $sort_order == 'o.date_added') echo $sort; ?>" >
                    <?php echo $entry_order_date; ?>
                  </a>
                </th>
                <th>
                  <a href="<?php echo $order_status_url; ?>" class="<?php if(isset($sort_order) && $sort_order == 'os.name') echo $sort; ?>" >
                    <?php echo $entry_order_status; ?>
                  </a>
                </th>
                <th>
                  <a href="<?php echo $paid_status_url; ?>" class="<?php if(isset($sort_order) && $sort_order == 'c2o.paid_status') echo $sort; ?>" >
                    <?php echo $entry_transaction_status; ?>
                  </a>
                </th>
                <th></th>
              </thead>
              <tbody>
                <tr>
                  <td></td>
                  <td><input type="text" name="filter_order_id" value="<?php echo $order_id; ?>" class="form-control"></td>
                  <td></td>
                  <td></td>
                  <td><input type="text" class="form-control" name="filter_payable_amount" value="<?php if(isset($payable_amount)) echo $payable_amount; ?>"></td>
                  <td><input type="text" class="form-control" name="filter_quantity" value="<?php if(isset($quantity)) echo $quantity; ?>"></td>
                  <td>
                    <input type="text" class="datetime form-control" name="filter_date_added_from" value="<?php if(isset($date_added_from)) echo $date_added_from; ?>" placeholder="<?php echo $entry_from; ?>">
                    <br/>
                    <input type="text" class="datetime form-control" name="filter_date_added_to" value="<?php if(isset($date_added_to)) echo $date_added_to; ?>" placeholder="<?php echo $entry_to; ?>">
                  </td>
                  <td>
                    <select name="filter_order_status" class="form-control">
                      <option></option>
                      <?php if($order_statuses) {
                          foreach ($order_statuses as $key => $status) { ?>
                            <option value="<?php echo $status['name']; ?>" <?php if($status['name'] == $order_status) { echo "selected"; } ?> >
                              <?php echo $status['name'];  ?>
                            </option>
                      <?php } 
                        }
                      ?>
                    </select>
                  </td>
                  <td>
                    <select name="filter_paid_status" class="form-control">
                      <option></option>
                      <option value="paid" <?php if($paid_status == 'paid') echo "selected"; ?> ><?php echo $text_paid; ?></option>
                      <option value="notpaid" <?php if($paid_status == 'notpaid') echo "selected"; ?>><?php echo $text_not_paid; ?></option>
                    </select>
                  </td>
                  <td><button type="button" class="btn btn-primary" onclick="filter();"><i class="fa fa-filter"></i> Filter</button></td>
                </tr>
                <?php if($orders) { 
                  foreach ($orders as $key => $order) { ?>
                    <tr>
                      <td class="text-center" width="1">
                        <input type="checkbox" name="select[<?php echo $order['order_id'] ?>][]" value="<?php echo $order['order_product_id']; ?>" <?php if($order['status']){ echo "disabled='true'"; }elseif ($order['order_status'] == $marketplace_complete_order_status){ echo "checked='true'";} ?> />
                        <!-- <input type="hidden" name="order_id[]" value="<?php echo $order['order_id'] ?>"> -->
                      </td>
                      <td class="text-left"><?php echo $order['order_id'] ?></td>
                      <td class="text-left">
                        <?php echo $order['product_name'] ?>
                        <br/>
                        <?php if($order['product_value']){ ?>
                            <?php foreach ($order['product_value'] as $option) { ?>
                              - <small><?php echo $option['value'] ?></small>
                            <br/>
                            <?php } ?> 
                        <?php } ?> 
                      </td>
                      <td class="text-left"><?php echo $order['commission_applied'].'%' ?></td>
                      <td class="text-left">
                      <input type="hidden" value="<?php echo $order['price'] ?>" id="price-<?php echo $order['order_product_id'] ?>" />
                        <?php echo $order['price'] ?>
                      </td>
                      <td class="text-left"><?php echo $order['quantity'] ?></td>
                      <td class="text-left"><?php echo $order['date_added'] ?></td>
                      <td class="text-left">
                        <input type="hidden" value="<?php echo $order['order_status']; ?>" id="order-status-<?php echo $order['order_product_id']; ?>" />
                        <?php echo $order['order_status']; ?>
                      </td>
                      <td class="text-left" colspan="2">
                        <input type="hidden" value="<?php echo $order['status']; ?>" id="paid-status-<?php echo $order['order_product_id']; ?>" />
                        <?php echo $order['paid_status']; ?>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                    <tr><td colspan="9" class="text-center"><?php echo $text_no_record; ?></td></tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
            <div class="col-sm-6 text-right"><?php echo $results; ?></div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>

<script type="text/javascript">


function filter() {
  url = "index.php?route=customerpartner/transaction/addtransaction&token=<?php echo $token; ?>&seller_id=<?php if($customers) echo $customers['customer_id']; ?>";

  order_id = $('input[name=\'filter_order_id\']').val();
  if(order_id) {
    url += '&order_id='+order_id;
  }

  payable_amount = $('input[name="filter_payable_amount"]').val();
  if(payable_amount) {
    url += '&payable_amount='+payable_amount;
  }

  quantity = $('input[name="filter_quantity"]').val();
  if(quantity) {
    url += '&quantity='+quantity;
  }

  date_added_from = $('input[name="filter_date_added_from"]').val();
  if(date_added_from) {
    url += '&date_added_from='+date_added_from;
  }

  date_added_to = $('input[name="filter_date_added_to"]').val();
  if(date_added_to) {
    url += '&date_added_to='+date_added_to;
  }

  order_status = $('select[name="filter_order_status"]').val();
  if(order_status) {
    url += '&order_status='+order_status;
  }

  paid_status = $('select[name="filter_paid_status"]').val();

  if(paid_status) {
    url += '&paid_status='+paid_status;
  }
  // console.log(url);
  location = url;
}

// $('input[name="date_added"]').datetimepicker(function(){
//   pickDate:true,
//   pickTime:true,
// })

$('.datetime').datetimepicker({
  pickTime:true,
  format:"YYYY-MM-DD HH:MM:SS",
});

amount = <?php if($amount) echo $amount; else echo 0; ?>;
mp_order_status = '<?php if($marketplace_complete_order_status) echo $marketplace_complete_order_status;  ?>';
$('table input[type="checkbox"]').on('change',function(){
  order_id = $(this).val();
  price = $('#price-'+order_id).val();
  order_status = $('#order-status-'+order_id).val();
  paid_status = $('#paid-status-'+order_id).val();
  if(order_status == mp_order_status && paid_status == 0){
    if( $(this).is(":checked") ){
      amount = parseFloat(amount) + parseFloat(price);
    }else{
      amount = parseFloat(amount - price);
    }
    $('label[name="amount"]').text(amount.toFixed(2));
    $('input[name="amount"]').val(amount.toFixed(2));
  }
})


// function addPopover(){
//   $('#popover').popover({
//     placement : 'top',
//     title : '<?php echo $text_seller; ?>',  
//     content : '<?php echo $text_seller_info; ?>'
//   });
// }

// addPopover();

// $('select[name=\'customer_id\']').change(function(){
//   $('#popover').popover('destroy');

//   if(this.value){
//     $.ajax({
//         url: 'index.php?route=customerpartner/partner/sellerCommission&token=<?php echo $token; ?>&customer_id=' +  encodeURIComponent(this.value),
//         dataType: 'json',
//         success: function(json) {   

//           html = '<?php echo $entry_total ;?>' + json['total'];
//           html += '<br/><?php echo $entry_admin ;?>' + json['admin_amount'];
//           html += '<br/><?php echo $entry_customer ;?>' + json['partner_amount'];        
//           html += '<br/><?php echo $entry_paid ;?>' + json['paid'];
//           html += '<br/><?php echo $entry_left_amount ;?>' + json['left_amount'];

//           $('#popover').popover(
//               {
//                 html : true,
//                 title : '<?php echo $text_seller; ?>',  
//                 content : html,              
//                 placement : 'top',
//               }
//           );

//         }
//       });
//   }else{
//     addPopover();
//   }
// })

</script>