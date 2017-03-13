<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
      <div class="container-fluid">
        <div class="pull-right">
          <button type="submit" onclick="$('#form-save').submit();"  data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
          <h3 class="panel-title"><i class="fa fa-pencil"></i>Product Auction</h3>
        </div>
        <div class="panel-body">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-save" class="form-horizontal">
          <!-- automatic auction -->
          <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_generalfields" data-toggle="tab"><?php echo $tab_generalfields; ?></a></li>
                <li><a href="#tab_automatic_auction" data-toggle="tab"><?php echo $tab_automatic_auction; ?></a></li>
            </ul>
            <div class="tab-content">
            <div class="tab-pane active" id="tab_generalfields">
            <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="wkproduct_auction_status" id="input-status" class="form-control">
                <?php if ($wkproduct_auction_status) { ?>
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
            <label class="col-sm-2 control-label" for="input-zone" >
              <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_ur_timezone; ?>"><?php echo $ur_timezone; ?></span></label>
            <div class="col-sm-10">
              <select name="wkproduct_auction_timezone_set" id="input-zone" class="form-control">
                <?php foreach($wk_zonelist as $key=>$value){ ?>
                  <option value="<?php echo $key; ?>" <?php if($key==$wkproduct_auction_timezone_set){ echo 'selected';} ?> ><?php echo $value; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            </div> 
            <div class="form-group">
            <label class="col-sm-2 control-label" for="input-zone" >
              <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_cart; ?>"><?php echo $text_addToCart; ?></span></label>
            <div class="col-sm-10">
              <select name="wkproduct_auction_cartstatus" id="input-addToCart-status" class="form-control">
                <?php if ($wkproduct_auction_cartstatus) { ?>
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
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_sellermail; ?></label>
            <div class="col-sm-10">
              <select name="wkproduct_auction_sellermail" id="input-status" class="form-control">
                <?php if ($wkproduct_auction_sellermail) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
            </div> 
            </div>

            <!-- automatic auction -->
            <div class="tab-pane" id="tab_automatic_auction">
            <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="" data-original-title="<?php echo $help_automatic_status; ?>"><?php echo $automatic_status; ?></span></label>
            <div class="col-sm-10">
              <select name="wkproduct_auction_automatic_auction_status" id="input-status" class="form-control">
                <?php if ($wkproduct_auction_automatic_auction_status) { ?>
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
            <label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="" data-original-title="<?php echo $help_customer_autobid_change_status; ?>"><?php echo $customer_autobid_change_status; ?></span></label>
            <div class="col-sm-10">
              <select name="wkproduct_auction_customer_autobid_change_status" id="input-status" class="form-control">
                <?php if ($wkproduct_auction_customer_autobid_change_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
            </div> 

            <!-- <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="" data-original-title="<?php echo $help_vendor_auto_bid_change_status; ?>"><?php echo $vendor_auto_bid_change_status; ?></span></label>
            <div class="col-sm-10">
              <select name="wkproduct_auction_vendor_auto_bid_change_status" id="input-status" class="form-control">
                <?php if ($wkproduct_auction_vendor_auto_bid_change_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
            </div>  -->

            <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="" data-original-title="<?php echo $help_automatic_bidders_detail_status; ?>"><?php echo $automatic_bidders_detail_status; ?></span></label>
            <div class="col-sm-10">
              <select name="wkproduct_auction_automatic_bidders_detail_status" id="input-status" class="form-control">
                <?php if ($wkproduct_auction_automatic_bidders_detail_status) { ?>
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
            <label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="" data-original-title="<?php echo $help_Mail_outbid_status; ?>"><?php echo $Mail_outbid_status; ?></span></label>
            <div class="col-sm-10">
              <select name="wkproduct_auction_Mail_outbid_status" id="input-status" class="form-control">
                <?php if ($wkproduct_auction_Mail_outbid_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
            </div> 

            </div>
          </form>
        </div><!--panel-body-->
      </div><!--panel-default-->
    </div><!--container-fluid-->
</div><!--content-->
<?php echo $footer; ?>
