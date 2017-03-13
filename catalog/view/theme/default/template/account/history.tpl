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
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title_history; ?></h1>  
   <div class="table-responsive">
 	<table class="table table-striped table-bordered table-hover" border = "1">
  <thead>
    <tr>
      <td class="text-left"><?php echo $column_date_added; ?></td>
      <td class="text-left"><?php echo $column_comment; ?></td>
      <td class="text-left"><?php echo $column_userid; ?></td>
      <td class="text-left"><?php echo $column_orderid; ?></td>
    </tr>
  </thead>
  <tbody>
    <?php if ($histories) { ?>
    <?php foreach ($histories as $history) { ?>
    <tr>
     <td class="text-left"><?php echo $history['date_added']; ?></td>
     <td class="text-left"><?php echo utf8_decode($history['comment']); ?></td>
     <td class="text-left"><?php echo $history['user_id']; ?></td>
      <td class="text-left"><?php echo $history['order_id']; ?></td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</div> 
<div class="row">
  <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
  <div class="col-sm-6 text-right"><?php echo $results; ?></div>
</div>
 <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
<input type="hidden" id="cust_ani" name="cust_ani" value="<?php echo $cust_ani; ?>">
<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $cust_id; ?>">   
<input type="hidden" id="agent_id" name="agent_id" value="<?php echo $agent_id; ?>">   
<input type="hidden" id="order_id" name="order_id" value="<?php echo $order_id; ?>">                                                  
  <div class="form-group">
  	<label class="col-sm-2 control-label" for="input-detail"><?php echo $text_detail; ?> </label>
    <div class="col-sm-10">
      <textarea name="comment" rows="10" id="input-comment" class="form-control"></textarea>
      <?php if ($error_comment) { ?>
              <div class="text-danger"><?php echo $error_comment; ?></div>
              <?php } ?>
    </div>
    
  </div>
<div class="buttons clearfix">
          <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default"><?php echo $button_back; ?></a></div>
          <div class="pull-right">
          <button id="button-history" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_history_add; ?></button>
          </div>
        </div>
</form>
<?php echo $content_bottom; ?></div>
<?php echo $column_right; ?></div></div>
<?php echo $footer; ?>
