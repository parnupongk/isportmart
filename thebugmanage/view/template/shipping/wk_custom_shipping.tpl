<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-flat" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-flat" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-title"><?php echo $title; ?></label>
            <div class="col-sm-10">
              <input type="text" name="wk_custom_shipping_title" value="<?php echo $wk_custom_shipping_title; ?>" placeholder="<?php echo $title; ?>" id="input-title" class="form-control" />
              <?php if ($error_title) { ?>
                <div class="text-danger"><?php echo $error_title; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-method_title"><?php echo $method_title; ?></label>
            <div class="col-sm-10">
              <input type="text" name="wk_custom_shipping_method_title" value="<?php echo $wk_custom_shipping_method_title; ?>" placeholder="<?php echo $method_title; ?>" id="input-method_title" class="form-control" />
              <?php if ($error_method_name) { ?>
                <div class="text-danger"><?php echo $error_method_name; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-method_select"><?php echo $method_select; ?></label>
            <div class="col-sm-10">
              <select name="wk_custom_shipping_method" id="input-method_select" class="form-control">
                 <option value="">Select</option>
                 <option value="flat" <?php if($wk_custom_shipping_method=='flat'){ echo "selected"; } ?>>Flat Shipping</option>
                 <option value="matrix" <?php if($wk_custom_shipping_method=='matrix'){ echo "selected"; } ?>>Matrix Based Shipping</option>
                 <option value="both" <?php if($wk_custom_shipping_method=='both'){ echo "selected"; } ?>>Mix Shipping</option>
              </select>
              <?php if ($error_method) { ?>
                <div class="text-danger"><?php echo $error_method; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-admin_flatrate"><?php echo $admin_flatrate; ?></label>
            <div class="col-sm-10">
              <input type="text" name="wk_custom_shipping_admin_flatrate" value="<?php echo $wk_custom_shipping_admin_flatrate; ?>" placeholder="<?php echo $admin_flatrate; ?>" id="input-admin_flatrate" class="form-control" />
              <?php if ($error_admin_flatrate) { ?>
                <div class="text-danger"><?php echo $error_admin_flatrate; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-texclass"><?php echo $texclass; ?></label>
            <div class="col-sm-10">
              <select name="wk_custom_shipping_tax_class_id" id="input-texclass" class="form-control" >
                <option value="">Select</option>
                <?php foreach ($tax_classes as $tax_class) { ?>
                <?php if ($tax_class['tax_class_id'] == $wk_custom_shipping_tax_class_id) { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-wk_custom_shipping_error_msg"><?php echo $error_msg; ?></label>
            <div class="col-sm-10">
              <textarea name="wk_custom_shipping_error_msg" id="input-wk_custom_shipping_error_msg" rows="3" class="form-control"><?php echo $wk_custom_shipping_error_msg; ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-wk_custom_shipping_geo_zone_id"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="wk_custom_shipping_geo_zone_id" id="input-wk_custom_shipping_geo_zone_id" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $wk_custom_shipping_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-wk_custom_shipping_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="wk_custom_shipping_status" id="input-wk_custom_shipping_status" class="form-control">
                <?php if ($wk_custom_shipping_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-wk_custom_shipping_sort_order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="wk_custom_shipping_sort_order" value="<?php echo $wk_custom_shipping_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-wk_custom_shipping_sort_order" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?> 