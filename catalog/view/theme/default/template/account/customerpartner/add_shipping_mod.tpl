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
  <?php if ($attention) { ?>
    <div class="alert alert-info"><?php echo $attention; ?></div>
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
        <button type="submit" form="form-shipping" data-toggle="tooltip" title="<?php echo $button_next; ?>" class="btn btn-primary"><i class="fa fa-share"></i></button>
        <a href="<?php echo $back; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
        <a onclick="$('#form-delete').submit();" data-toggle="tooltip" class="btn btn-danger"  title="<?php echo $button_delete; ?>"><i class="fa fa-trash-o"></i></a>
      </div>
    </h1>
    
    <legend><i class="fa fa-list"></i> <?php echo $text_mpshipping; ?></legend>
      <?php if($isMember) { ?>
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $entry_info; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-shipping" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-flatrate"><span data-toggle="tooltip" title="<?php echo $add_flatrate; ?>"><?php echo $add_flatrate; ?></span></label>
            <div class="col-sm-9">
              <div class="input-group">                
              <input type="text" name="shipping_add_flatrate" value="<?php if(isset($shipping_add_flatrate_amount)){ echo $shipping_add_flatrate_amount; } ?>" placeholder="<?php echo $add_flatrate; ?>" id="input-flatrate" class="form-control" />  
              <span class="input-group-addon"><?php echo $shipping_add_flatrate; ?></span>       
              </div>     
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $entry_csv_info; ?>"><?php echo $entry_csv; ?></span></label>
            <div class="col-sm-9">
              <div class="input-group">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary" onclick="$('input[name=\'up_file\']').trigger('click');"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                </span>
                <input type="text" id="input-csv-name" class="form-control" disabled/>

              </div>
              <input type="file" name="up_file" class="form-control" style="display:none;"> 
              <div class="hide csv-warning">
                <?php echo $entry_error_csv; ?>
              </div>        
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $entry_separator_info; ?>"><?php echo $entry_separator; ?></span></label>
            <div class="col-sm-9">
              <div class="input-group">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary separator"><i class="fa fa-keyboard-o"></i> <?php echo $entry_sep_manually; ?></button>
                </span> 
                <div>
                  <select name="separator" id="separator" class="form-control">
                    <option value=";">Semicolon ; </option>
                    <option value=" ">Tab</option>
                    <option value=",">Comma ,</option>
                    <option value=":">Colon : </option>
                    <option value="|">Vertical bar</option>
                  </select> 
                </div>
              </div>           
            </div>
          </div>  

          </form>

          <div class="well">
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="input-country"><?php echo $shipping_country; ?></label>
                  <input type="text" name="filter_country" value="<?php echo $filter_country; ?>" placeholder="<?php echo $filter_country; ?>" id="input-country" class="form-control" />
                </div>
                <div class="form-group">
                  <label class="control-label" for="input-price"><?php echo $price; ?></label>
                  <input type="text" name="filter_price" value="<?php echo $filter_price; ?>" placeholder="<?php echo $filter_price; ?>" id="input-price" class="form-control" />
                </div>
              </div>

               <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="input-zipto"><?php echo $zip_to; ?></label>
                  <input type="text" name="filter_zip_to" value="<?php echo $filter_zip_to; ?>" placeholder="<?php echo $filter_zip_to; ?>" id="input-zipto" class="form-control" />
                </div>
                <div class="form-group">
                  <label class="control-label" for="input-weightto"><?php echo $weight_to; ?></label>
                  <input type="text" name="filter_weight_to" value="<?php echo $filter_weight_to; ?>" placeholder="<?php echo $filter_weight_to; ?>" id="input-weightto" class="form-control" />
                </div>      
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="input-zipfrom"><?php echo $zip_from; ?></label>
                  <input type="text" name="filter_zip_from" value="<?php echo $filter_zip_from; ?>" placeholder="<?php echo $filter_zip_from; ?>" id="input-zipfrom" class="form-control" />
                </div>                   
                <div class="form-group">
                  <label class="control-label" for="input-weightfrom"><?php echo $weight_from; ?></label>            
                  <input type="text" name="filter_weight_from" value="<?php echo $filter_weight_from; ?>" placeholder="<?php echo $filter_weight_from; ?>" id="input-weightfrom" class="form-control" />   
                </div>             
              </div>            
              <a onclick="filter();"  class="btn btn-primary pull-right" data-toggle="tooltip" title="<?php echo $button_filtering; ?>"><?php echo $button_filtering; ?></a> 
            </div>
          </div>

          <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-delete">            
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                    <td width="1" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>              
                      <td class="text-left">
                        <?php if ($sort == 'cs.country_code') { ?>
                        <a href="<?php echo $sort_country_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $shipping_country; ?></a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_country_code; ?>"><?php echo $shipping_country; ?></a>
                        <?php } ?>                
                      </td>
                      <td class="text-left">
                        <?php if ($sort == 'cs.zip_from') { ?>
                        <a href="<?php echo $sort_zip_from; ?>" class="<?php echo strtolower($order); ?>"><?php echo $zip_from; ?></a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_zip_from; ?>"><?php echo $zip_from; ?></a>
                        <?php } ?>                
                      </td>
                      <td class="text-left">
                        <?php if ($sort == 'cs.zip_to') { ?>
                        <a href="<?php echo $sort_zip_to; ?>" class="<?php echo strtolower($order); ?>"><?php echo $zip_to; ?></a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_zip_to; ?>"><?php echo $zip_to; ?></a>
                        <?php } ?>                 
                      </td>
                      <td class="text-left">
                        <?php if ($sort == 'cs.price') { ?>
                        <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $price; ?></a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_price; ?>"><?php echo $price; ?></a>
                        <?php } ?> 
                      </td>
                      <td class="text-left">
                        <?php if ($sort == 'cs.weight_from') { ?>
                        <a href="<?php echo $sort_weight_from; ?>" class="<?php echo strtolower($order); ?>"><?php echo $weight_from; ?></a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_weight_from; ?>"><?php echo $weight_from; ?></a>
                        <?php } ?>                 
                      </td>
                      <td class="text-left">
                        <?php if ($sort == 'cs.weight_to') { ?>
                        <a href="<?php echo $sort_weight_to; ?>" class="<?php echo strtolower($order); ?>"><?php echo $weight_to; ?></a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_weight_to; ?>"><?php echo $weight_to; ?></a>
                        <?php } ?>                
                      </td>
                    </tr>
                </thead>
                <tbody>
                      <?php if ($result_shipping) { ?>
                      <?php foreach ($result_shipping as $result_shippings) { ?>
                        <tr>
                          <td class="text-center"><?php if ($result_shippings['selected']) { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $result_shippings['id']; ?>" checked="checked" />
                            <?php } else { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $result_shippings['id']; ?>" />
                            <?php } ?>
                          </td>
                          <td class="text-left"><?php echo  $result_shippings['country']; ?></td>
                          <td class="text-left" ><?php echo $result_shippings['zip_from']; ?></td>
                          <td class="text-left"><?php echo $result_shippings['zip_to']; ?></td>
                          <td class="text-left"><?php echo  $result_shippings['price']; ?></td>
                          <td class="v"><?php echo $result_shippings['weight_from']; ?></td>
                          <td class="text-left"><?php echo $result_shippings['weight_to']; ?></td>
                        </tr>
                      <?php } ?>
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="12"><?php echo $no_records_found; ?></td>
                      </tr>
                      <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="text-right"><?php echo $pagination; ?></div>
        <div class="text-right"><?php echo $results; ?></div>
        <?php } else { ?>
          <div class="text-danger">
            Warning: You are not authorised to view this page, Please contact to site administrator!
          </div>
        <?php } ?>
    
<?php echo $content_bottom; ?></div>
<?php }else{  echo "<h2 style='color:#F93D49;'>Please inform Admin</h2>";   } ?>
<?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>

<script type="text/javascript">
jQuery('input[name=up_file]').change(function(){
  csv_val = jQuery(this).val().split('.').pop();  
    $('#input-csv-name').val(jQuery(this).val().replace(/C:\\fakepath\\/i, ''));
    if(csv_val!='csv'){
      jQuery('.csv-warning').addClass('text-danger').removeClass('hide');            
    }else{
      jQuery('.csv-warning').addClass('hide').removeClass('text-danger');            
    } 
});

nextHtml = false;
prevHtml = $("<input type='text' class=\"form-control\"/>").attr({ name: 'separator' });
jQuery('.separator').click(function(){  
  catchDiv = $(this).parent().next();
  nextHtml = catchDiv.html();
  catchDiv.html(prevHtml);
  prevHtml = nextHtml;
});

$('#form-delete').submit(function(){
    if ($(this).attr('action').indexOf('delete',1) != -1) {
        if (!confirm('<?php echo $text_confirm; ?>')) {
            return false;
        }
    }
});

function filter() {

  url = 'index.php?route=account/customerpartner/add_shipping_mod';
  
  var filter_name = $('input[name=\'filter_name\']').val();
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }
  
  var filter_country = $('input[name=\'filter_country\']').val();
  
  if (filter_country) {
    url += '&filter_country=' + encodeURIComponent(filter_country);
  }
  
  var filter_price = $('input[name=\'filter_price\']').val();
  
  if (filter_price) {
    url += '&filter_price=' + encodeURIComponent(filter_price);
  }
  
  var filter_zip_to = $('input[name=\'filter_zip_to\']').val();
  
  if (filter_zip_to) {
    url += '&filter_zip_to=' + encodeURIComponent(filter_zip_to);
  }

  var filter_zip_from = $('input[name=\'filter_zip_from\']').val();
  
  if (filter_zip_from) {
    url += '&filter_zip_from=' + encodeURIComponent(filter_zip_from);
  }

  var filter_weight_to = $('input[name=\'filter_weight_to\']').val();
  
  if (filter_weight_to) {
    url += '&filter_weight_to=' + encodeURIComponent(filter_weight_to);
  }

  var filter_weight_from = $('input[name=\'filter_weight_from\']').val();
  
  if (filter_weight_from) {
    url += '&filter_weight_from=' + encodeURIComponent(filter_weight_from);
  }

  location = url;
}
</script>