<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <!-- <a href="<?php echo $insert; ?>" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a> -->
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-transaction').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
                <label class="control-label" for="input-id"><?php echo $entry_id; ?></label>
                <input type="text" name="filter_id" value="<?php echo $filter_id; ?>" placeholder="<?php echo $entry_id; ?>" id="input-id" class="form-control" />
              </div>

              <div class="form-group">
                <label class="control-label" for="input-amount"><?php echo $entry_amount; ?></label>
                <input type="text" name="filter_amount" value="<?php echo $filter_amount; ?>" placeholder="<?php echo $entry_amount; ?>" id="input-amount" class="form-control" />
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_seller; ?></label>
                <div class='input-group'>
                    <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_seller; ?>" id="input-name" class="form-control" />                    
                    <span class="input-group-addon"><span class="fa fa-angle-double-down"></span>
                    </span>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label" for="input-details"><?php echo $entry_details; ?></label>
                <input type="text" name="filter_details" value="<?php echo $filter_details; ?>" placeholder="<?php echo $entry_details; ?>" id="input-details" class="form-control" />
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-date"><?php echo $entry_date; ?></label>
                <div class='input-group date' id='datetimepicker2'>
                    <input type='text' name="filter_date" value="<?php echo $filter_date; ?>" placeholder="<?php echo $entry_date; ?>" id="input-date" class="form-control date" />
                    <span class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </span>
                </div>
              </div>
              <button type="button" onclick="filter();" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>

          </div>
        </div>

        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-transaction">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
              <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>

                <td class="text-left">
                  <?php if ($sort == 'ct.id') { ?>
                  <a href="<?php echo $sort_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_id; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_id; ?>"><?php echo $entry_id; ?></a>
                  <?php } ?>                
                </td>
                <td class="text-left">
                  <?php if ($sort == 'c.firstname') { ?>
                  <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_seller; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_name; ?>"><?php echo $entry_seller; ?></a>
                  <?php } ?>               
                </td>

                <td class="text-left">
                  <?php if ($sort == 'ct.amount') { ?>
                  <a href="<?php echo $sort_amount; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_amount; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_amount; ?>"><?php echo $entry_amount; ?></a>
                  <?php } ?>               
                </td>

                <td class="text-left">
                  <?php if ($sort == 'ct.details') { ?>
                  <a href="<?php echo $sort_details; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_details; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_details; ?>"><?php echo $entry_details; ?></a>
                  <?php } ?>               
                </td>
                <td class="text-left">
                  <?php if ($sort == 'ct.date_added') { ?>
                  <a href="<?php echo $sort_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_date; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_date; ?>"><?php echo $entry_date; ?></a>
                  <?php } ?>  
                </td>            
              </tr>
            </thead>

            <tbody>
              <?php if ($transactions) { ?>
              <?php foreach ($transactions as $result) { ?>
                <tr>             
                  <td style="text-align: center;"><?php if ($result['selected']) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $result['id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $result['id']; ?>" />
                    <?php } ?>
                  </td>              
                  <td class="text-left" ><?php echo $result['id']; ?></td>
                  <td class="text-left"><?php echo  $result['name']; ?></td>
                  <td class="text-left"><?php echo $result['value']; ?></td>
                  <td class="text-left"><?php echo $result['details']; ?></td>  
                  <td class="text-left"><?php echo $result['date']; ?></td>
                </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="6"><?php echo "No records founds"; ?></td>
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
<script type="text/javascript"><!--

$('#form input').keydown(function(e) {
  if (e.keyCode == 13) {
    filter();
  }
});

$('.date').datetimepicker({
  pickTime: false,
  format:"YYYY-MM-DD"
});

function filter() {

  url = 'index.php?route=customerpartner/transaction&token=<?php echo $token; ?>';
  
  var filter_name = $('input[name=\'filter_name\']').val();
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }
  
  var filter_id = $('input[name=\'filter_id\']').val();
  
  if (filter_id) {
    url += '&filter_id=' + encodeURIComponent(filter_id);
  }

  var filter_date = $('input[name=\'filter_date\']').val();
  
  if (filter_date) {
    url += '&filter_date=' + encodeURIComponent(filter_date);
  }

  var filter_details = $('input[name=\'filter_details\']').val();
  
  if (filter_details) {
    url += '&filter_details=' + encodeURIComponent(filter_details);
  }

  var filter_amount = $('input[name=\'filter_amount\']').val();
  
  if (filter_amount) {
    url += '&filter_amount=' + encodeURIComponent(filter_amount);
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
