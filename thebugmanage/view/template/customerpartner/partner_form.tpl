<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>

      <div class="panel-body">

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
        <ul class="nav nav-tabs">
          <!-- <li><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li> -->
          <li class="active"><a href="#tab-dashboard" data-toggle="tab"><?php echo "Dashboard"; ?>  <i class="fa fa-spinner fa-spin remove-me"></i></a></li> 
          <li class=""><a href="#tab-profile" data-toggle="tab"><?php echo $tab_info; ?></a></li> 
          <li><a href="#tab-commission" data-toggle="tab"><?php echo $tab_commission; ?></a></li>   
          <li><a href="#tab-order" data-toggle="tab"><?php echo $tab_order; ?></a></li>                 
          <!-- <li><a href="#tab-transaction" data-toggle="tab"><?php echo $tab_transaction; ?></a></li> -->
          <li><a href="#tab-location" data-toggle="tab"><?php echo $tab_location; ?></a></li>
          <li><a href="#tab-product" data-toggle="tab"><?php echo $tab_product; ?></a></li>
        </ul>

        <div class="tab-content">

          <!-- <div class="tab-pane active" id="tab-general"></div> -->

          <div id="tab-dashboard" class="tab-pane active">
            
          </div>

          <div class="tab-pane " id="tab-profile">

            <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $tab_profile_info; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-screenname"><span data-toggle="tooltip" title="<?php echo $entry_screenname_info; ?>"><?php echo $entry_screenname; ?></span></label>
              <div class="col-sm-10">
                <input type="text" name="customer[screenname]" value="<?php echo $screenname; ?>" placeholder="" id="input-screenname" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-image"><span data-toggle="tooltip" title="<?php echo $entry_avatar_info; ?>"><?php echo $entry_avatar; ?></span></label>
              <div class="col-sm-10">
                <a href="" id="thumb-image-avatar" data-toggle="image" class="img-thumbnail">
                  <img src="<?php echo $avatar_placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                </a>
                <input type="hidden" name="customer[avatar]" value="<?php echo $avatar; ?>" id="input-image-avatar" />
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-gender"><?php echo $entry_gender; ?></label>
              <div class="col-sm-10">
                <select name="customer[gender]" class="form-control">
                  <option> </option>
                  <option value="M" <?php if($gender=='M') echo 'selected'; ?> > Male </option>
                  <option value="F" <?php if($gender=='F') echo 'selected'; ?>> Female </option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-shortprofile"><?php echo $entry_profile; ?></label>
              <div class="col-sm-10">
                <textarea name="customer[shortprofile]" id="input-shortprofile" class="form-control"><?php echo $shortprofile; ?></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-companyname"><?php echo $entry_company; ?></label>
              <div class="col-sm-10">
                <input type="text" name="customer[companyname]" value="<?php echo $companyname; ?>" placeholder="" id="input-companyname" class="form-control" />
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-twitterid"><?php echo $entry_twitter; ?></label>
              <div class="col-sm-10">
                <input type="text" name="customer[twitterid]" value="<?php echo $twitterid; ?>" placeholder="" id="input-twitterid" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-facebookid"><?php echo $entry_facebook; ?></label>
              <div class="col-sm-10">
                <input type="text" name="customer[facebookid]" value="<?php echo $facebookid; ?>" placeholder="" id="input-facebookid" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-companylocality"><?php echo $entry_locality; ?></label>
              <div class="col-sm-10">
                <input type="text" name="customer[companylocality]" value="<?php echo $companylocality; ?>" placeholder="" id="input-companylocality" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-country"><?php echo $entry_country; ?></label>
              <div class="col-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i>
                    <?php if(file_exists(DIR_IMAGE.'../image/flags/'.strtolower($country).'.png')){ ?>
                      <img src="../image/flags/<?php echo strtolower($country); ?>.png" id="country">
                    <?php }else{ ?>
                      <img src="" id="country">
                    <?php } ?>
                  </i></span>              
                  <select name="customer[country]" id="input-country" class="form-control">
                    <option value=""></option>
                    <?php if($countries){ ?>
                      <?php foreach($countries as $value_country){ ?>
                        <?php if($value_country['iso_code_2'] == $country){ ?>
                            <option value="<?php echo $value_country['iso_code_2']; ?>" selected><?php echo $value_country['name']; ?></option>
                        <?php }else{ ?>                    
                            <option value="<?php echo $value_country['iso_code_2']; ?>"><?php echo $value_country['name']; ?></option>
                        <?php } ?>
                      <?php } ?>
                    <?php } ?>
                  </select>                       
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-backgroundcolor"><span data-toggle="tooltip" title="<?php echo $entry_theme; ?>"><?php echo $entry_theme; ?></span></label>
              <div class="col-sm-10">
                <div class="input-group colorpicker">
                  <span class="input-group-addon"><i></i></span>                      
                  <input type="text" name="customer[backgroundcolor]" value="<?php echo $backgroundcolor; ?>" placeholder="" id="input-backgroundcolor" class="form-control" />                        
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-image"><span data-toggle="tooltip" title="<?php echo $entry_banner_info; ?>"><?php echo $entry_banner; ?></span></label>
              <div class="col-sm-10">
                <a href="" id="thumb-image-companybanner" data-toggle="image" class="img-thumbnail">
                  <img src="<?php echo $companybanner_placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />     
                </a>
                <input type="hidden" name="customer[companybanner]" value="<?php echo $companybanner; ?>" id="input-image-companybanner" />
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-image"><span data-toggle="tooltip" title="<?php echo $entry_logo_info; ?>"><?php echo $entry_logo; ?></span></label>
              <div class="col-sm-10">
                <a href="" id="thumb-image-companylogo" data-toggle="image" class="img-thumbnail">
                  <img src="<?php echo $companylogo_placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                </a>
                <input type="hidden" name="customer[companylogo]" value="<?php echo $companylogo; ?>" id="input-image-companylogo" />
              </div>
            </div> 

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-companydescription"><?php echo $entry_store; ?></label>
              <div class="col-sm-10">
                <textarea name="customer[companydescription]" id="input-companydescription" class="form-control"><?php echo $companydescription; ?></textarea>
              </div>
            </div>

          </div>          

          <!-- transaction -->
          <!-- <div class="tab-pane" id="tab-transaction">

            <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $tab_transaction_info; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>            
            
            <div id="transaction"></div>
            <br/>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-description"><?php echo $entry_description; ?></label>
              <div class="col-sm-10">
                <input type="text" name="description" placeholder="<?php echo $entry_description; ?>" id="input-description" class="form-control" />
              </div>
            </div>

            <div class="form-group">
             <label class="col-sm-2 control-label" for="input-amount"><?php echo $entry_amount; ?></label>
              <div class="col-sm-10">
                <input type="text" name="amount" placeholder="<?php echo $entry_amount; ?>" id="input-amount" class="form-control" />
              </div>
            </div>

            <div class="text-right">
              <button type="button" id="button-transaction" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_add_transaction; ?></button>
            </div>
          </div> -->

          <!-- order -->
          <div class="tab-pane" id="tab-order">

            <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $tab_order_info; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>            
            
            <div class="panel panel-default">

              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> <?php echo $tab_order; ?></h3>
              </div>

              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <td class="text-right"><?php echo $entry_orderid; ?></td>
                      <td class="text-left"><?php echo $entry_name; ?></td>
                      <td class="text-left"><?php echo $entry_products; ?></td>
                      <td class="text-left"><?php echo $column_date_added; ?></td>              
                      <td class="text-left"><?php echo str_replace(':','',$entry_status); ?></td>
                      <td class="text-left"><?php echo $entry_total; ?></td>
                      <td class="text-left"><?php echo $column_action; ?></td>  
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($partner_orders) AND $partner_orders){ ?>
                      <?php foreach($partner_orders as $partner_order){ ?>
                        <tr>
                          <td class="text-right"><?php echo $partner_order['order_id']; ?></td>
                          <td class="text-left"><?php echo $partner_order['name']; ?></td> 
                          <td class="text-left"><?php if(isset($partner_order['productname'])){ echo substr($partner_order['productname'],0,-2); }?></td> 
                          <td class="text-left"><?php echo $partner_order['date_added']; ?></td>                   
                          <td class="text-left"><?php echo $partner_order['orderstatus']; ?></td> 
                          <td class="text-left"><?php if(isset($partner_order['total'])){ echo $partner_order['total']; }?></td> 
                          <td class="text-left">
                            <a href="<?php echo $partner_order['view']; ?>" data-toggle="tooltip" title="<?php echo $text_view; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>                          
                            <a href="<?php echo $partner_order['edit']; ?>" data-toggle="tooltip" title="<?php echo $text_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                          </td>
                        </tr>
                      <?php } ?>
                    <?php }else{ ?>
                      <tr><td class="text-center" colspan="7"><?php echo $text_no_results; ?></td></tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>

          </div>

          <!-- tab commission -->
          <div class="tab-pane" id="tab-commission">
            <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $tab_commission_info; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div> 
            <div class="form-group">
             <label class="col-sm-2 control-label" for="input-commission"><?php echo $entry_commission; ?></label>
              <div class="col-sm-10">
                <div class="input-group">                
                  <input type="text" name="customer[commission]" value="<?php echo $commission; ?>" placeholder="<?php echo $entry_commission; ?>" id="input-commission" class="form-control" />
                  <span class="input-group-addon"> <b>%</b> </span>
                </div>
              </div>
            </div>
            <div class="form-group">
             <label class="col-sm-2 control-label" for="input-paypalid"><?php echo $entry_paypalid; ?></label>
              <div class="col-sm-10">
                <input type="text" name="customer[paypalid]" value="<?php echo $paypalid; ?>"  placeholder="<?php echo $entry_paypalid; ?>" id="input-paypalid" class="form-control" />
              </div>
            </div>
            <div class="form-group">
             <label class="col-sm-2 control-label" for="input-otherpayment"><?php echo $entry_otherinfo; ?></label>
              <div class="col-sm-10">
                <textarea name="customer[otherpayment]" placeholder="<?php echo $entry_otherinfo; ?>" id="input-otherpayment" class="form-control"><?php echo $otherpayment; ?></textarea>
              </div>
            </div>
          </div>

          <!-- tab product -->
          <div class="tab-pane" id="tab-product">
            <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $tab_product_info; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div> 
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="<?php echo $entry_product_id_info; ?>"><?php echo $entry_product_id; ?></span></label>
              <div class="col-sm-9">
                <div class="well well-sm" style="height:300px;overflow:auto">
                  <?php if($admin_products) { ?>
                    <?php foreach ($admin_products as $key => $admin_product) { ?>
                      <div class="checkbox">
                        <label for="admin_product<?php echo $admin_product['product_id']; ?>">
                          <input type="checkbox" name="product_ids[]" value="<?php echo $admin_product['product_id']; ?>" id="admin_product<?php echo $admin_product['product_id']; ?>" <?php if($product_ids && in_array($admin_product['product_id'], $product_ids)) { echo "checked"; } ?> />
                          <?php echo $admin_product['name']; ?>
                        </label>
                      </div>
                    <?php } ?>
                  <?php }else{?>
                  <?php echo $text_no_product_assign; ?>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>

          <!-- tab location -->
          <div class="tab-pane" id="tab-location">

          </div>

        </div>
        
      </form>
    </div>
  </div>
</div>


<script type="text/javascript"><!--

$('#tab-dashboard').load("index.php?route=customerpartner/dashboard&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>",function(){
      $('.remove-me').remove();
    });

$('#input-shortprofile, #input-companydescription').summernote({height: 300});

// Product
$('input[name=\'product\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=customerpartner/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request)+'&filter_for_seller=1',
      dataType: 'json',     
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['product_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'product\']').val('');
    
    $('#product-product' + item['value']).remove();
    
    $('#product-product').append('<div id="product-id' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_ids[]" value="' + item['value'] + '" /></div>'); 
  }
});

$('#product-product').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});


$('#transaction').delegate('.pagination a', 'click', function(e) {
  $('#transaction').load(this.href);
  
  return false;
});     

$('#transaction').load('index.php?route=customerpartner/partner/transaction&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>');

$('#button-transaction').on('click', function() {
  $.ajax({
    url: 'index.php?route=customerpartner/partner/transaction&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>',
    type: 'post',
    dataType: 'html',
    data: 'description=' + encodeURIComponent($('#tab-transaction input[name=\'description\']').val()) + '&amount=' + encodeURIComponent($('#tab-transaction input[name=\'amount\']').val()),
    beforeSend: function() {
      $('#button-transaction').button('loading');
    },
    complete: function() {
      $('#button-transaction').button('reset');
    },
    success: function(html) {
      $('#tab-transaction .alert').remove();

      $('#transaction').html(html);

      $('#tab-transaction input[name=\'amount\']').val('');
      $('#tab-transaction input[name=\'description\']').val('');
    }
  });
});

$('#input-country').on('change',function(){
  newSrc = "../image/flags/"+this.value+".png";
  $('#country').attr('src',newSrc.toLowerCase());
})

localocation = false;
$('a[href=\'#tab-location\']').on('click',function(){
  if(!localocation){
    $(this).append(' <i class="fa fa-spinner fa-spin remove-me"></i>');

     $.ajax({
      url: '<?php echo $loadLocation; ?>',
      dataType: 'html',
      success: function(response) {
        $('#tab-location').html(response);
        $('.remove-me').remove();
      }
    });
    localocation = true;
  }
})

//--></script> 
<link href="view/javascript/color-picker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="view/javascript/color-picker/js/bootstrap-colorpicker.min.js"></script>
<script type="text/javascript">
$(function(){
    $('.colorpicker').colorpicker();
});
</script>
<?php echo $footer; ?>