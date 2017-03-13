<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-shipping" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
	<?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($attention) { ?>
    <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $attention; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>

      <div class="panel-body">

        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $text_separator_info; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-shipping" class="form-horizontal">

        	<?php if($shippingTable){ ?>
        		<?php foreach ($shippingTable as $value) { ?>
        			<div class="form-group">
            			<label class="col-sm-2 control-label"><span data-toggle="tooltip" title=""><?php echo ucfirst(str_replace('_',' ',$value)); ?></span></label>


			            <div class="col-sm-10">
				            <select name="<?php echo $value; ?>" class="form-control">
		                		<option value=""></option>
		                		<?php foreach ($fields as $key => $field) { ?>
		                			<option value="<?php echo $key; ?>" <?php if(strtolower($field) == strtolower($value)) echo 'selected'; ?> ><?php echo $field; ?></option>
		                		<?php } ?>		                		
		                   	</select>
            			</div>
            		</div>
        		<?php } ?>
        	<?php } ?>       

	    </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>