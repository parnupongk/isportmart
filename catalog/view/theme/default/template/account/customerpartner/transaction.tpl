<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>

  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>

  <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"> </i> <?php echo $success; ?></div>
  <?php } ?>

  <div id="content" class="<?php echo $class; ?>">
  <?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <fieldset>
    <legend><i class="fa fa-list"></i> <?php echo $text_transactionList; ?></legend>
      <?php if($isMember) { ?>
      <div class="well">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-id"><?php echo $entry_id; ?></label>
                <input type="text" name="filter_id" value="<?php echo $filter_id; ?>" placeholder="<?php echo $text_transactionId; ?>" id="input-id" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-amount"><?php echo $entry_amount; ?></label>
                <input type="text" name="filter_amount" value="<?php echo $filter_amount; ?>" placeholder="<?php echo $text_transactionAmount; ?>" id="input-amount" class="form-control" />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-details"><?php echo $entry_details; ?></label>
                <input type="text" name="filter_details" value="<?php echo $filter_details; ?>" placeholder="<?php echo $text_transactionDetails; ?>" id="input-details" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-date"><?php echo $entry_date; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date" value="<?php echo $filter_date; ?>" data-date-format="YYYY-MM-DD" placeholder="<?php echo $text_transactionDate; ?>" id="input-date" class="form-control date" />
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span>
                </div>
              </div>
              <a onclick="filter();" class="btn btn-primary pull-right"><?php echo $button_filter; ?></a> 
            </div>
          </div>
        </div>

        <form method="post" enctype="multipart/form-data" id="form-transaction">
        <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left">
                <?php if ($sort == 'ct.id') { ?>
                <a href="<?php echo $sort_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_id; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_id; ?>"><?php echo $entry_id; ?></a>
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
                <td class="text-left" ><?php echo $result['id']; ?></td>
                <td class="text-left"><?php echo $result['value']; ?></td>
                <td class="text-left"><?php echo $result['details']; ?></td>  
                <td class="text-left"><?php echo $result['date']; ?></td>
              </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="text-center" colspan="4"><?php echo "No records founds"; ?></td>
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
    </fieldset>
  <?php echo $content_bottom; ?>  
  </div> 
  <?php echo $column_right; ?>
  </div>
</div>

<script type="text/javascript">
$('.date').datetimepicker({
  pickTime: false
});

$('#form-transaction input').keydown(function(e) {
  if (e.keyCode == 13) {
    filter();
  }
});

function filter() {

  url = 'index.php?route=account/customerpartner/transaction';

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
//--></script> 
<?php echo $footer; ?>
