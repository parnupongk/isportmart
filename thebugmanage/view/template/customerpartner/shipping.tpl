<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $addshipping; ?>" data-toggle="tooltip" title="<?php echo $button_shipping; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>

      <div class="panel-body">
        <div class="well">
          <div class="row">

            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $customer_name; ?></label>
                <div class='input-group'>
                  <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $customer_name; ?>" id="input-name" class="form-control" />
                  <span class="input-group-addon"><span class="fa fa-angle-double-down"></span>
                    </span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-country"><?php echo $shipping_country; ?></label>
                <input type="text" name="filter_country" value="<?php echo $filter_country ?>" placeholder="<?php echo $shipping_country; ?>" id="input-country" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-weight_from"><?php echo $weight_from; ?></label>
                <input type='text' name="filter_weight_from" value="<?php echo $filter_weight_from; ?>" placeholder="<?php echo $weight_from; ?>" id="input-weight_from" class="form-control date" />
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-zip_to"><?php echo $zip_to; ?></label>
                <input type="text" name="filter_zip_to" value="<?php echo $filter_zip_to; ?>" placeholder="<?php echo $zip_to; ?>" id="input-zip_to" class="form-control" />
              </div>        
              <div class="form-group">
                <label class="control-label" for="input-zip_from"><?php echo $zip_from; ?></label>
                <input type="text" name="filter_zip_from" value="<?php echo $filter_zip_from; ?>" placeholder="<?php echo $zip_from; ?>" id="input-zip_from" class="form-control" />
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">              
                <label class="control-label" for="input-price"><?php echo $price; ?></label>
                <input type="text" name="filter_price" value="<?php echo $filter_price; ?>" placeholder="<?php echo $price; ?>" id="input-price" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-weight_to"><?php echo $weight_to; ?></label>
                <input type="text" name="filter_weight_to" value="<?php echo $filter_weight_to; ?>" placeholder="<?php echo $weight_to; ?>" id="input-weight_to" class="form-control" />
              </div>
              <button type="button" onclick="filter();" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>

        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                  <td class="text-left">
                    <?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $customer_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $customer_name; ?></a>
                    <?php } ?>               
                  </td>
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
                    <td style="text-align: center;"><?php if ($result_shippings['selected']) { ?>
                      <input type="checkbox" name="selected[]" value="<?php echo $result_shippings['id']; ?>" checked="checked" />
                      <?php } else { ?>
                      <input type="checkbox" name="selected[]" value="<?php echo $result_shippings['id']; ?>" />
                      <?php } ?>
                    </td>              
                      <td class="text-left" ><?php echo $result_shippings['name']; ?></td>
                      <td class="text-left"><?php echo  $result_shippings['countey']; ?></td>
                      <td class="text-left" ><?php echo $result_shippings['zip_from']; ?></td>
                      <td class="text-left"><?php echo $result_shippings['zip_to']; ?></td>
                      <td class="text-left"><?php echo  $result_shippings['price']; ?></td>
                      <td class="text-left"><?php echo $result_shippings['weight_from']; ?></td>
                      <td class="text-left"><?php echo $result_shippings['weight_to']; ?></td>
                  </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="12"><?php echo "no records founds"; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>       
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--

$('#form input').keydown(function(e) {
  if (e.keyCode == 13) {
    filter();
  }
});

function filter() {

  url = 'index.php?route=customerpartner/shipping&token=<?php echo $token; ?>';
  
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

$('input[name=\'filter_name\']').autocomplete({
  delay: 0,
  source: function(request, response) {

    $.ajax({
      url: 'index.php?route=customerpartner/partner/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.id
          }
        }));
      }
    });
  }, 
  select: function(item) {
    $('input[name=\'filter_name\']').val(item.label);
            
    return false;
  },
  focus: function(item) {
      return false;
  }
});
//--></script> 
<?php echo $footer; ?>
