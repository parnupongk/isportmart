<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"> <?php echo $content_top; ?>
      <h1>
        <?php echo $heading_title; ?>
        <div class="pull-right">
          <button type="submit" form="form-shipping" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
          <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>            
        </div>
      </h1>

      <fieldset>
      <legend><i class="fa fa-list"></i> <?php echo $text_mpshipping; ?></legend>
      <?php if($isMember) { ?>
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
      <?php } else { ?>
        <div class="text-danger">
          Warning: You are not authorised to view this page, Please contact to site administrator!
        </div>
      <?php } ?>
    </fieldset>

    <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
  </div>
<?php echo $footer; ?>
