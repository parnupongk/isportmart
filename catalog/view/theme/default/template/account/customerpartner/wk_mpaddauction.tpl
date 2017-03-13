<?php echo $header; ?>
<?php if($chkIsPartner){ ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
<?php if ($error_warning) { ?>
<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="alert alert-success"><i class="fa fa-check-circle"> </i> <?php echo $success; ?></div>
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
      <h1>
        <?php echo $heading_title; ?>
        <div class="pull-right">               
         <a onclick="$('#form-save').submit();" data-toggle="tooltip" class="btn btn-primary" title="<?php echo $button_continue; ?>" id="submit"><i class="fa fa-save"></i></a> 
          <a href="<?php echo $back; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
        </div>
      </h1>
    <fieldset>  
      
      <legend><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></legend>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-save" class="form-horizontal">

          <div class="form-group">
            <label class="col-sm-3 control-label" for="auction_name"><span data-toggle="tooltip" title="">Auction Name</span></label>
            <div class="col-sm-9">
              <input type="text" name="auction_name" class="form-control" value="<?php if(isset($auction_name) && $auction_name) echo $auction_name; ?>"/>              
            </div>
          </div>

         <div class="form-group required">
            <label class="col-sm-3 control-label" ><span data-toggle="tooltip" title=""><?php echo $entry_auproduct; ?></span></label>
            <div class="col-sm-9">
              <input type="text" id="prod_id" name="product_name" class="form-control" value="<?php if(isset($product_name)) if($product_name) echo $product_name; ?>"/>
              <input type="hidden" name="product_id" id="prod_name_id" value="<?php if(isset($product_id)) if($product_id) echo $product_id; ?>"/>
              <input type="hidden" name="seller_id" id="seller_id" value="<?php if(isset($product_id)) if($product_id) echo $product_id; ?>"/>
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-3 control-label" ><span data-toggle="tooltip" title=""><?php echo $entry_aumin; ?></span></label>
            <div class="col-sm-9">
             <input type="text" name="aumin" class="form-control" value="<?php if(isset($aumin)) if($aumin) echo $aumin; ?>" />
             <?php if ($error_price) { ?>
              <div class="text-danger"><?php echo $error_price; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-3 control-label" ><span data-toggle="tooltip" title=""><?php echo $entry_aumax; ?></span></label>
            <div class="col-sm-9">
             <input type="text" name="aumax" class="form-control" value="<?php if(isset($aumax)) if($aumax) echo $aumax; ?>" />
              <?php if ($error_price) { ?>
              <div class="text-danger"><?php echo $error_price; ?></div>
              <?php } ?>
            </div>
          </div>

           <div class="form-group required">
            <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="" data-original-title=""><?php echo $entry_austart; ?></span></label>
            <div class="col-sm-6">
              <div class="input-group datetime">
                      <input type="text" name="austart" value="<?php if(isset($start)) if($start) echo $start; ?>" placeholder="Date Available" data-date-format="YYYY-MM-DD HH:mm:ss" id="input-date-available" class="is-not-empty audt form-control">
                      <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                      </span>
              </div>         
              <?php if ($error_date) { ?>
                        <div class="text-danger"><?php echo $error_date; ?></div>
                      <?php } ?>                               
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="" data-original-title=""><?php echo $entry_auend; ?></span></label>
            <div class="col-sm-6">
              <div class="input-group datetime">
                      <input type="text" name="auend" value="<?php if(isset($end)) if($end) echo $end; ?>" placeholder="Date Available" data-date-format="YYYY-MM-DD HH:mm:ss" id="input-date-available" class="is-not-empty audt form-control">
                      <?php if(isset($id)){ ?>
                        <input type="hidden" name="update" value="yes">
                      <?php } ?>
                      <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                      </span>                      
              </div>         
              <?php if ($error_date) { ?>
                        <div class="text-danger"><?php echo $error_date; ?></div>
                      <?php } ?>                               
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="product_quantity_limit"><span data-toggle="tooltip" title="">Product Quantity Limit</span></label>
            <div class="col-sm-9">
              <input type="text" name="product_quantity_limit" class="form-control" value="<?php if(isset($product_quantity_limit) && $product_quantity_limit) echo $product_quantity_limit; ?>"/>              
            </div>
          </div>

           <div class="form-group">
            <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="" data-original-title="">Voucher Time Limit</span></label>
            <div class="col-sm-6">
              <div class="input-group datetime">
                      <input type="text" name="voucher_expiry" value="<?php if(isset($voucher_time_limit) && $voucher_time_limit) echo $voucher_time_limit; ?>" placeholder="Date Available" data-date-format="YYYY-MM-DD HH:mm" id="input-date-available" class="is-not-empty audt form-control">                     
                      <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                      </span>
              </div>  
              <?php if ($error_voucher) { ?>
                        <div class="text-danger"><?php echo $error_voucher; ?></div>
                      <?php } ?>                                                                     
            </div>
          </div>
      </form>
      <h1><?php echo $entry_productin_auction; ?></h1>
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-general" data-toggle="tab">Auction</a></li>
        <li><a href="#tab-bids" data-toggle="tab">Auction Bids</a></li>
        <li><a href="#tab-history" data-toggle="tab">Winner History</a></li>
      </ul>
      <div class="tab-content">
      <div class="tab-pane active" id="tab-general"> 
      <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <td class="left"><a><?php echo $entry_auproduct; ?></a></td>
                <td class="left"><a><?php echo $entry_aumin; ?></a></td>
                <td class="left"><a><?php echo $entry_aumax; ?></a></td>
                <td class="left"><a><?php echo $entry_austart; ?></a></td>
                <td class="left"><a><?php echo $entry_auend; ?></a></td>
                <td class="left">Action</td>                
              </tr>
            </thead>
            <tbody>
              <?php foreach($auproduct_list as $item) {?>
                <tr>
                  <td class="left"><a href='index.php?route=product/product&product_id=<?php echo $item['product_id'];?>'><?php echo $item['product_name'] ?></a></td>
                  <td class="left"><?php echo $item['min'] ?></td>
                  <td class="left"><?php echo $item['max'] ?></td>
                  <td class="left"><?php echo $item['start'] ?></td>
                  <td class="left"><?php echo $item['end'] ?></td>
                  <td class="center">
                    <a class="btn btn-info" href='index.php?route=account/customerpartner/wk_mpaddauction&product_id=<?php echo $item['product_id'];?>'><span title="" data-toggle="tooltip" data-original-title="<?php echo $entry_edit; ?>"><i class="fa fa-pencil"></i></span></a>
                    <a class="btn btn-danger" href='index.php?route=account/customerpartner/wk_mpaddauction&dauid=<?php echo $item['auction_id'];?>'><span title="" data-toggle="tooltip" data-original-title="<?php echo $entry_delete; ?>"><i class="fa fa-trash-o"></i></span></a>
                  </td>
                </tr>
              <?php }?>
            </tbody>
          </table>
      </div><!--table-responsive-->
    </div><!--tab-general-->
    <div class="tab-pane" id="tab-bids">
      <div class="row">
        <div class="content">      
      <div class="text-right"> 
        <button type="button" data-toggle="tooltip" title="Delete" class="btn btn-danger" onclick="$('#form-deletebids').submit();"><i class="fa fa-trash-o"></i></button>
      </div>  
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-deletebids" class="form-horizontal">
              <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td width="1" style="text-align: center;"><input type="checkbox" class="form-control" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                  <td class="text-left">Product Name</td>
                  <td class="text-left">Auction Start</td>
                     <td class="text-left">Auction End</td>
                    <td class="text-left">Total Normal Bids</td>

                     <!-- Automatic bidding -->
                    <?php if (isset($wkproduct_auction_automatic_auction_status) && $wkproduct_auction_automatic_auction_status) {?>
                      <td class="taxt-left">Total Automatic Bids</td>
                    <?php }?>

                    <td class="text-center">Show</td>                
                </tr>
              </thead>
              <tbody>
              <?php if ($bids) { ?>
              <?php foreach ($bids as $bid) { ?>
              <tr>             
                <td class="text-center"><?php if ($bid['selected']) { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $bid['id']; ?>" checked="checked" class="form-control" />
                  <?php } else { ?>
                  <input class="form-control" type="checkbox" name="selected[]" value="<?php echo $bid['id']; ?>" />
                  <?php } ?></td>
                <td class="text-left"><?php echo $bid['product']; ?></td>
                <td class="text-left"><?php echo $bid['auction_start']; ?></td>
                <td class="text-left"><?php echo $bid['auction_end']; ?></td>
                <td class="text-left"><?php echo $bid['totalBid']; ?></td>

                 <!-- Automatic bidding -->
                <?php if (isset($bid['total_auto_bid']) && isset($wkproduct_auction_automatic_auction_status) && $wkproduct_auction_automatic_auction_status) {?>

                    <td class="text-left"><?php echo $bid['total_auto_bid']; ?></td>

                  <?php }elseif(isset($wkproduct_auction_automatic_auction_status) && $wkproduct_auction_automatic_auction_status){?>

                     <td class="text-left"><?php echo "0"; ?></td>

                  <?php } ?>
                <td class="text-center">[ <a class="displayButton" onclick="showlist(this.id)" id="<?php echo $bid['product_id']; ?>" >View</a> ]</td>
              </tr>
              <tr>
                <td></td>
                <td colspan="4" style="padding:0">
              <div id="listhead<?php echo $bid['product_id']; ?>" class="wklisthead" style="height:auto;margin-top:2px">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <td class="left" style="background-color:#EFEFEF">Bidder Name</td>
                    <td class="left" style="background-color:#EFEFEF">Auction Start</td>
                    <td class="left" style="background-color:#EFEFEF">Auction End</td>
                    <td class="left" style="background-color:#EFEFEF">Normal Bid</td>

                     <!-- Automatic bidding -->
                    <?php if (isset($wkproduct_auction_automatic_auction_status) && $wkproduct_auction_automatic_auction_status) {?>
                      <td class="left" style="background-color:#EFEFEF">Automatic Bid</td>
                    <?php }?>
                  </tr>
                </thead>
               <?php if($productBids) {
              foreach($productBids as $productBid){
                if($productBid['product_id'] == $bid['product_id']) { ?>
               <tr id="" class="wklistrow listrow<?php echo $bid['product_id']; ?>">       
                  <td class="left" style="width:25.4%"><?php echo $productBid['customer_name']; ?></td>
                  <td class="left" style="width:29.2%"><?php echo $productBid['start_date']; ?></td>
                  <td class="left" style="width:29.1%"><?php echo $productBid['end_date']; ?></td>
                  <td class="left" style="width:15.8%"><?php echo $productBid['bid']; ?></td>

                   <!-- Automatic bidding -->
                  <?php if (isset($productBid['auto_bid']) && isset($wkproduct_auction_automatic_auction_status) && $wkproduct_auction_automatic_auction_status) {?>

                    <td class="left" style="width:15.8%"><?php echo $productBid['auto_bid']; ?></td>

                  <?php }elseif(isset($wkproduct_auction_automatic_auction_status) && $wkproduct_auction_automatic_auction_status){?>

                     <td class="center" style="width:15.8%"><?php echo "-"; ?></td>

                  <?php } ?>
               </tr>               
               <?php }               
                  } }  ?>
              </table>
            </div>
              </td>
              <td></td>
            </tr>
          <?php }
                 }else { ?>
            <tr>
              <td class="text-center" colspan="6"><?php echo "No records founds"; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
    </div><!--content-->
     </div><!--row-->
    </div><!--tab-bids-->

    <div class="tab-pane" id="tab-history"> 
      <div class="table-responsive">
          <table class="table table-bordered table-hover">          
          <thead>
            <tr>
              <td width="1" class="text-center">
                <input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" />
              </td>
              <td class="text-left">Winner</td>
              <td class="text-left">Product Name</td>
              <td class="text-left">Auction Start</td>
              <td class="text-left">Auction End</td>
              <td class="text-center">Winning Bid</td>
            </tr>
          </thead>
          <tbody>           
            <?php if ($winners) { ?>
            <?php foreach ($winners as $winner) { ?>
            <tr>             
              <td style="text-align: center;"><?php if ($winner['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $winner['id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $winner['id']; ?>" />
                <?php } ?></td>
              <td class="text-left"><?php echo $winner['customer_name']; ?></td>
               <td class="text-left"><?php echo $winner['product_name'] ?></td>
               <td class="text-left"><?php echo $winner['start_date']; ?></td>
               <td class="text-left"><?php echo $winner['end_date']; ?></td>
               <td class="text-center"><?php echo $winner['bid']; ?></td>
               </tr>
               <?php }
               }else { ?>
            <tr>
              <td class="text-center" colspan="6"><?php echo "No records founds"; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div><!-- table responsive-->

      </div><!--tab-history-->
    </div><!--tab-content-->


    </fieldset>
  <?php echo $content_bottom; ?></div><!--content-->
  <?php echo $column_right; ?></div><!--row-->
  </div><!--container-->
<script>
  $('.datetime').datetimepicker({
    pickDate: true,
    pickTime: true
  });

jQuery(function(){
    jQuery('#prod_id').keyup(function(){

        var inpval=$('#prod_id').val();

        $("#prod_id").autocomplete({
            minLength: 1,
            delay: 101,
            source: function(request, response) {
                $.ajax({
                    data: ({p : inpval}),
                    type: 'POST',
                    url: 'index.php?route=account/customerpartner/wk_mpaddauction/getproduct',
                    dataType: 'json',
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.label,
                                value: item.product_id,
                                sellerid: item.seller_id
                            }
                        }));
                    }
                });
            },
            select: function(item) {
                $( "#prod_id" ).val(item['label'] );
                $( "#prod_name_id" ).val( item['value'] );
                $( "#seller_id" ).val( item['sellerid'] );
                return false;
            },
            focus: function(item) {
                $( "#prod_id" ).val( item['label'] );
                return false;
            }
        });
     });
});

$('.wklisthead').slideUp();
function showlist(id){
  $('.wklisthead').not('#listhead'+id).slideUp('slow');
  $('#listhead'+id).slideToggle('slow');
  $('.displayButton').not('#'+id).text("show");
  if($('#'+id).text() == "show"){
        $('#'+id).text("hide");
  }else{
        $('#'+id).text("show");
  }
}
</script>
<?php }	?>
<?php echo $footer; ?>
