<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-review" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_add; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-review" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-customer"><span data-toggle="tooltip" title="<?php echo $help_customer; ?>"><?php echo $entry_customer; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="customer" value="<?php echo $customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
              <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
              <?php if ($error_customer) { ?>
              <div class="text-danger"><?php echo $error_customer; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-seller"><span data-toggle="tooltip" title="<?php echo $help_seller; ?>"><?php echo $entry_seller; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="seller" value="<?php echo $seller; ?>" placeholder="<?php echo $entry_seller; ?>" id="input-seller" class="form-control" />
              <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>" />
              <?php if ($error_seller) { ?>
              <div class="text-danger"><?php echo $error_seller; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-text"><?php echo $entry_text; ?></label>
            <div class="col-sm-10">
              <textarea name="text" cols="60" rows="8" placeholder="<?php echo $entry_text; ?>" id="input-text" class="form-control"><?php echo $text; ?></textarea>
              <?php if ($error_text) { ?>
              <div class="text-danger"><?php echo $error_text; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_rating_price; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <?php if ($rating_price == 1) { ?>
                <input type="radio" name="rating_price" value="1" checked="checked" />
                1
                <?php } else { ?>
                <input type="radio" name="rating_price" value="1" />
                1
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating_price == 2) { ?>
                <input type="radio" name="rating_price" value="2" checked="checked" />
                2
                <?php } else { ?>
                <input type="radio" name="rating_price" value="2" />
                2
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating_price == 3) { ?>
                <input type="radio" name="rating_price" value="3" checked="checked" />
                3
                <?php } else { ?>
                <input type="radio" name="rating_price" value="3" />
                3
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating_price == 4) { ?>
                <input type="radio" name="rating_price" value="4" checked="checked" />
                4
                <?php } else { ?>
                <input type="radio" name="rating_price" value="4" />
                4
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating_price == 5) { ?>
                <input type="radio" name="rating_price" value="5" checked="checked" />
                5
                <?php } else { ?>
                <input type="radio" name="rating_price" value="5" />
                5
                <?php } ?>
              </label>
              <?php if ($error_rating_price) { ?>
              <div class="text-danger"><?php echo $error_rating_price; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_rating_value; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <?php if ($rating_value == 1) { ?>
                <input type="radio" name="rating_value" value="1" checked="checked" />
                1
                <?php } else { ?>
                <input type="radio" name="rating_value" value="1" />
                1
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating_value == 2) { ?>
                <input type="radio" name="rating_value" value="2" checked="checked" />
                2
                <?php } else { ?>
                <input type="radio" name="rating_value" value="2" />
                2
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating_value == 3) { ?>
                <input type="radio" name="rating_value" value="3" checked="checked" />
                3
                <?php } else { ?>
                <input type="radio" name="rating_value" value="3" />
                3
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating_value == 4) { ?>
                <input type="radio" name="rating_value" value="4" checked="checked" />
                4
                <?php } else { ?>
                <input type="radio" name="rating_value" value="4" />
                4
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating_value == 5) { ?>
                <input type="radio" name="rating_value" value="5" checked="checked" />
                5
                <?php } else { ?>
                <input type="radio" name="rating_value" value="5" />
                5
                <?php } ?>
              </label>
              <?php if ($error_rating_value) { ?>
              <div class="text-danger"><?php echo $error_rating_value; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_rating_quality; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <?php if ($rating_quality == 1) { ?>
                <input type="radio" name="rating_quality" value="1" checked="checked" />
                1
                <?php } else { ?>
                <input type="radio" name="rating_quality" value="1" />
                1
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating_quality == 2) { ?>
                <input type="radio" name="rating_quality" value="2" checked="checked" />
                2
                <?php } else { ?>
                <input type="radio" name="rating_quality" value="2" />
                2
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating_quality == 3) { ?>
                <input type="radio" name="rating_quality" value="3" checked="checked" />
                3
                <?php } else { ?>
                <input type="radio" name="rating_quality" value="3" />
                3
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating_quality == 4) { ?>
                <input type="radio" name="rating_quality" value="4" checked="checked" />
                4
                <?php } else { ?>
                <input type="radio" name="rating_quality" value="4" />
                4
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if ($rating_quality == 5) { ?>
                <input type="radio" name="rating_quality" value="5" checked="checked" />
                5
                <?php } else { ?>
                <input type="radio" name="rating_quality" value="5" />
                5
                <?php } ?>
              </label>
              <?php if ($error_rating_quality) { ?>
              <div class="text-danger"><?php echo $error_rating_quality; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
  <?php if ($customer_id) {?>
     var customer_id = <?php echo $customer_id; ?>;
  <?php }else{?>
     var customer_id = '';
  <?php } ?>

   <?php if ($seller_id) {?>
     var seller_id = <?php echo $seller_id; ?>;
  <?php }else{?>
     var seller_id = '';
  <?php } ?>
  // var customer_id = '';
  // var seller_id = '';
  $('input[name=\'customer\']').autocomplete({
  	'source': function(request, response) {
  		$.ajax({
  			url: 'index.php?route=customerpartner/review/autocomplete&token=<?php echo $token; ?>&filter_customer=' +  encodeURIComponent(request)+'&seller_id='+seller_id,
  			dataType: 'json',			
  			success: function(json) {
  				response($.map(json, function(item) {
  					return {
  						label: item['name'],
  						value: item['customer_id']
  					}
  				}));
  			}
  		});
  	},
  	'select': function(item) {
      console.log(item);
  		$('input[name=\'customer\']').val(item['label']);
  		$('input[name=\'customer_id\']').val(item['value']);
      customer_id = item['value']; 		
  	}	
  });

  $('input[name=\'seller\']').autocomplete({
    'source': function(request, response) {
      $.ajax({
        url: 'index.php?route=customerpartner/review/autocomplete&token=<?php echo $token; ?>&filter_seller=' +  encodeURIComponent(request)+'&customer_id='+customer_id,
        dataType: 'json',     
        success: function(json) {
          response($.map(json, function(item) {
            return {
              label: item['name'],
              value: item['customer_id']
            }
          }));
        }
      });
    },
    'select': function(item) {
      console.log(item);
      $('input[name=\'seller\']').val(item['label']);
      $('input[name=\'seller_id\']').val(item['value']);
      seller_id = item['value'];    
    } 
  });
//--></script></div>
<?php echo $footer; ?>
