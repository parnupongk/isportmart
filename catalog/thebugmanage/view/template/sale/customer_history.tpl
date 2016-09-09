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
<table class="table table-bordered">
  <thead>
    <tr>
      <td class="text-left"><?php echo $column_date_added; ?></td>
      <td class="text-left"><?php echo $column_comment; ?></td>
      <td class="text-left">User</td> <!-- Kit Add 25/3/2016 -->
      <td class="text-left">Order ID</td> <!-- One Add 11/4/2016 -->
    </tr>
  </thead>
  <tbody>
    <?php if ($histories) { ?>
    <?php foreach ($histories as $history) { ?>
    <tr>
      <td class="text-left"><?php echo $history['date_added']; ?></td>
      <td class="text-left"><?php echo $history['comment']; ?></td>
      <?php if($history['user_info'] != ""){ ?>
      <td class="text-left"><?php echo $history['user_info']; ?></td> <!-- Kit Add 29/3/2016 -->
      <?php } else {?>
      <td class="text-left"><?php echo $history['user_id']; ?></td> <!-- Kit Add 25/3/2016 -->
      <?php } ?>
      <td class="text-left"><?php 
      	if ($history['order_id']==0) {
      		echo "-";
      	} else {
      		echo $history['order_id']; 
      	}
      ?>
      </td> <!-- one Add 11/4/2016 -->
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<div class="row">
  <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
  <div class="col-sm-6 text-right"><?php echo $results; ?></div>
</div>
