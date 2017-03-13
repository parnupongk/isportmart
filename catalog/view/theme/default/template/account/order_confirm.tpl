<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
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
      <h2><?php echo $heading_title; ?></h2>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left" colspan="2"><?php echo $text_order_detail; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left" style="width: 40%;">
              <b><?php echo $text_order_id; ?></b> #<?php echo $order_id; ?><br />
              <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?><br />
			  <?php if ($payment_method) { ?>
              <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
              <?php } ?>
              <?php if ($shipping_method) { ?>
              <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
              <?php } ?><br />
			  <b><?php echo $column_total; ?> : </b><?php echo $totals; ?>
			</td>
			<td>
				<table class="table table-bordered table-hover" border=0>
					<thead>
					<tr>
					<td class="text-left"><?php echo $column_name; ?></td>
					<td class="text-left"><?php echo $column_model; ?></td>
					<td class="text-right"><?php echo $column_quantity; ?></td>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($products as $product) { ?>
					<tr>
					<td class="text-left"><?php echo $product['name']; ?></td>
					<td class="text-left"><?php echo $product['model']; ?></td>
					<td class="text-right"><?php echo $product['quantity']; ?></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
			</td>
          </tr>
        </tbody>
      </table>

	  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-ddate"><?php echo $entry_date; ?> </label>
            <div class="col-sm-10">
              <input type="text" name="ddate" value="<?php echo $ddate; ?>" placeholder="<?php echo $entry_date; ?>" id="input-ddate" class="form-control" />
              <?php if ($error_date) { ?>
              <div class="text-danger"><?php echo $error_date; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-dtime"><?php echo $entry_time; ?> </label>
            <div class="col-sm-10">
              <input type="text" name="dtime" value="<?php echo $dtime; ?>" placeholder="<?php echo $entry_time; ?>" id="input-dtime" class="form-control" />
              <?php if ($error_time) { ?>
              <div class="text-danger"><?php echo $error_time; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-total"><?php echo $entry_total; ?></label>
            <div class="col-sm-10">
              <input type="text" name="total" value="<?php echo $total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
              <?php if ($error_total) { ?>
              <div class="text-danger"><?php echo $error_total; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-ctype"><?php echo $entry_type; ?></label>
            <div class="col-sm-10">
			<select name="ctype" id="input-ctype">
				<option value="Inform">Inform</option>
				<option value="Fax">Fax</option>
				<option value="Pic">Pic</option>
			</select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remark"><?php echo $entry_remark; ?></label>
            <div class="col-sm-10">
              <input type="text" name="remark" value="<?php echo $remark; ?>" placeholder="<?php echo $entry_remark; ?>" id="input-remark" class="form-control" />
			  <font color='blue'>ระบุธนาคารและสาขาที่ทำการโอน หรือรายละเอียดที่ต้องการเพิ่มเติม</font>
            </div>
          </div>
        </fieldset>
        <div class="buttons clearfix">
          <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default"><?php echo $button_back; ?></a></div>
		  <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
		  <input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>" />
          <div class="pull-right">
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
          </div>
        </div>
      </form>
	  
  <?php foreach ($file_down as $file_download) { ?>
  <div style="page-break-after: always;">
<?php  
    echo "Date added:" . $file_download['name'].$file_download['date_added'] . "<br><img src=http://" . $_SERVER['HTTP_HOST'] . "/system/download/".$file_download['name']."><br>"; 
  ?>
  <?php } ?>
</div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
<?php echo $footer; ?>