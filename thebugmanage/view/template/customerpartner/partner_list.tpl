<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <select id="partnet_status" class="form-control" style="display: inline-block;width: auto;">
          <option value="0"><?php echo $text_isnotpartner; ?></option>
          <option value="1"><?php echo $text_ispartner; ?></option>
        </select>

        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_create_seller; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button id="prs_action" type="submit" form="form-seller" formaction="<?php echo $approve; ?>" data-toggle="tooltip" title="<?php echo $button_approve; ?>" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-seller').submit() : false;"><i class="fa fa-trash-o"></i></button>

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
                <label class="control-label" for="input-name"><?php echo $column_name; ?></label>                
                <div class='input-group'>
                    <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $column_name; ?>" id="input-name" class="form-control" />                    
                    <span class="input-group-addon"><span class="fa fa-angle-double-down"></span>
                    </span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-model"><?php echo $column_email; ?></label>
                <input type="text" name="filter_email" value="<?php echo $filter_email; ?>" placeholder="<?php echo $column_email; ?>" id="input-model" class="form-control" />
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-customer_group"><?php echo $column_customer_group; ?></label>
                <select name="filter_customer_group_id" id="input-customer_group" class="form-control" >
                  <option value="*"></option>
                  <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php if ($customer_group['customer_group_id'] == $filter_customer_group_id) { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $column_status; ?></label>
                <select name="filter_status" id="input-status" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (($filter_status !== null) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-approved"><?php echo $column_approved; ?></label>
                <select name="filter_approved" id="input-approved" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_approved) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_approved) && !$filter_approved) { ?>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_no; ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label class="control-label" for="input-approved"><span data-toggle="tooltip" title="<?php echo $entry_customer_type_info; ?>"><?php echo $entry_customer_type; ?></span></label>
                <select id="view_all" name="wk_viewall" class="form-control">
                  <option <?php if(!$wk_viewall){ echo 'selected';} ?> value="0"><?php echo $text_view_partners; ?></option>
                  <option <?php if($wk_viewall AND $wk_viewall=='2'){ echo 'selected';} ?> value="2"><?php echo $text_view_requested; ?></option>
                  <option <?php if($wk_viewall AND $wk_viewall=='1'){ echo 'selected';} ?> value="1"><?php echo $text_view_all; ?></option>
                </select>
              </div>

              <button type="button" onclick="filter();" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>

        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-seller">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
              <tr>
                <td width="1" style="text-align: center;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>

                <td class="text-left"><?php if ($sort == 'customer_id') { ?>
                  <a href="<?php echo $sort_customerId; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sellerId; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_customerId; ?>"><?php echo $column_sellerId; ?></a>
                  <?php } ?></td>


                <td class="text-left"><?php if ($sort == 'name') { ?>
                  <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                  <?php } ?></td>
                <td class="text-left"><?php if ($sort == 'c.email') { ?>
                  <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
                  <?php } ?></td>
                <td class="text-left"><?php if ($sort == 'customer_group') { ?>
                  <a href="<?php echo $sort_customer_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_group; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_customer_group; ?>"><?php echo $column_customer_group; ?></a>
                  <?php } ?></td>
                <td class="text-left"><?php if ($sort == 'c.status') { ?>
                  <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                  <?php } ?></td>
                <td class="text-left"><?php if ($sort == 'c.approved') { ?>
                  <a href="<?php echo $sort_approved; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_approved; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_approved; ?>"><?php echo $column_approved; ?></a>
                  <?php } ?></td>
                <td class="text-left"><?php if ($sort == 'c.ip') { ?>
                  <a href="<?php echo $sort_ip; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ip; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_ip; ?>"><?php echo $column_ip; ?></a>
                  <?php } ?></td>
                <td class="text-left"><?php if ($sort == 'c.date_added') { ?>
                  <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                  <?php } ?></td>
                <td class="text-left"><?php echo $column_login; ?></td>
  			        <td class="text-left"><?php echo $entry_partner_commission; ?></td>
                <td class="text-right"><?php echo $column_action; ?></td>
              </tr>
            </thead>

            <tbody>            
              <?php if ($customers) { ?>
              <?php foreach ($customers as $customer) { ?>
              <tr>
                <td style="text-align: center;" class="text-center"><?php if ($customer['selected']) { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" />
                  <?php } ?></td>
                  <td class="text-left"><?php echo $customer['customer_id']; ?></td>
                <?php if (version_compare(VERSION, '2.1', '>=')) { ?>
                  <td class="text-left"><a href="index.php?route=customer/customer/edit&token=<?php echo $token; ?>&customer_id=<?php echo $customer['customer_id']; ?>"><?php echo $customer['name']; ?></a></td>     
                <?php } else { ?>
                  <td class="text-left"><a href="index.php?route=sale/customer/edit&token=<?php echo $token; ?>&customer_id=<?php echo $customer['customer_id']; ?>"><?php echo $customer['name']; ?></a></td>
                <?php } ?>
                <td class="text-left"><?php echo $customer['email']; ?></td>
                <td class="text-left"><?php echo $customer['customer_group']; ?></td>
                <td class="text-left"><?php echo $customer['status']; ?></td>
                <td class="text-left"><?php echo $customer['approved']; ?></td>
                <td class="text-left"><?php echo $customer['ip']; ?></td>
                <td class="text-left"><?php echo $customer['date_added']; ?></td>


                <td class="text-left">
                  <b><?php echo $customer['is_partner']?></b>          
                </td>

                <?php if($customer['is_partner']!="Normal customer"){?>
                  <td class="text-left"><?php echo $customer['commission']?>%</td>
                <?php }else{ ?>
                  <td class="text-left"></td>
                <?php } ?>

                <td class="text-right">
                  <?php if ($customer['is_partner']=="Normal customer") { ; ?>
                  <a onclick="$(this).parents('tr').find('input[type=\'checkbox\']').prop('checked',true);$('form').attr('action', '<?php echo $approve; ?>&set_status=1'); $('form').submit();" data-toggle="tooltip" title="<?php echo $button_approve; ?>" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i></a>
                  <?php } else { ?>
                  <button type="button" class="btn btn-success" disabled><i class="fa fa-thumbs-o-up"></i></button>
                  <?php } ?>
                  <div class="btn-group" data-toggle="tooltip" title="<?php echo $text_login; ?>">
                    <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="fa fa-lock"></i></button>
                    <ul class="dropdown-menu pull-right">
                      <?php if (version_compare(VERSION, '2.1', '>=')) { ?>
                        <li><a href="index.php?route=customer/customer/login&token=<?php echo $token; ?>&customer_id=<?php echo $customer['customer_id']; ?>&store_id=0" target="_blank"><?php echo $text_default; ?></a></li>
                      <?php } else { ?>
                        <li><a href="index.php?route=sale/customer/login&token=<?php echo $token; ?>&customer_id=<?php echo $customer['customer_id']; ?>&store_id=0" target="_blank"><?php echo $text_default; ?></a></li>
                      <?php } ?>
                      <?php foreach ($stores as $store) { ?>
                      <?php if (version_compare(VERSION, '2.1', '>=')) { ?>
                        <li><a href="index.php?route=customer/customer/login&token=<?php echo $token; ?>&customer_id=<?php echo $customer['customer_id']; ?>&store_id=<?php echo $store['store_id']; ?>" target="_blank"><?php echo $store['name']; ?></a></li>
                      <?php } else { ?>
                        <li><a href="index.php?route=sale/customer/login&token=<?php echo $token; ?>&customer_id=<?php echo $customer['customer_id']; ?>&store_id=<?php echo $store['store_id']; ?>" target="_blank"><?php echo $store['name']; ?></a></li>
                      <?php } ?>
                      <?php } ?>
                    </ul>
                  </div>

                  <?php if ($customer['is_partner']!="Normal customer") { ; ?>
                    <?php foreach ($customer['action'] as $action) { ?>
                      <a href="<?php echo $action['href']; ?>" data-toggle="tooltip" title="<?php echo $action['text']; ?>" class="btn btn-primary" > <i class="fa fa-pencil"></i></a>
                    <?php } ?>
                  <?php } ?>

                </td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="11"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>

          </table>
        </div>

      </form>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo "$results"; ?></div>
      </div>

    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=customerpartner/partner&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').val();
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_email = $('input[name=\'filter_email\']').val();
	
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
	
	var filter_customer_group_id = $('select[name=\'filter_customer_group_id\']').val();
	
	if (filter_customer_group_id != '*') {
		url += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
	}	
	
	var filter_status = $('select[name=\'filter_status\']').val();
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status); 
	}	
	
	var filter_approved = $('select[name=\'filter_approved\']').val();
	
	if (filter_approved != '*') {
		url += '&filter_approved=' + encodeURIComponent(filter_approved);
	}	
	
	var filter_ip = $('input[name=\'filter_ip\']').val();
	
	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}
		
	var filter_date_added = $('input[name=\'filter_date_added\']').val();
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

  var filter_view_all = jQuery('#view_all').val();
  
  if (filter_view_all) {
    url += '&view_all=' + encodeURIComponent(filter_view_all);
  }
	
	location = url;
}
//--></script>

<script><!--//
var url = $('#prs_action').attr('formaction');

$('#partnet_status').on('change',function(){
  tmpurl = url+"&set_status="+$(this).val();
	$('#prs_action').attr('formaction',tmpurl);
});	

</script>
<script type="text/javascript">

// jQuery('#view_all').change(function(){
//     view_all_customers();
// })

// function view_all_customers() {
//   view_all = jQuery('#view_all').val();
//   location = 'index.php?route=customerpartner/partner&token=<?php echo $token; ?>&view_all='+view_all;
// }

$('input[name=\'filter_name\']').autocomplete({
  delay: 0,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=customerpartner/partner/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request)+'&filter_view=' +  jQuery('#view_all').val(),
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
  'select': function(item) {
    $('input[name=\'filter_name\']').val(item['label']);
  }

});

$('input[name=\'filter_email\']').autocomplete({
  delay: 0,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=customerpartner/partner/autocomplete&token=<?php echo $token; ?>&filter_email=' +  encodeURIComponent(request)+'&filter_view=' +  jQuery('#view_all').val(),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item.email,
            value: item.id
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_email\']').val(item['label']);
  }
});
</script>
<?php echo $footer; ?> 