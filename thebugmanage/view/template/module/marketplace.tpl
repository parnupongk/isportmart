<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <style type="text/css">
  .img-thumbnail-default{
    height: 100px;
    width: 100px;
    background-color: #ffffff;
    border: 1px solid #dddddd;
    border-radius: 3px;
    line-height: 1.42857;
    max-width: 100px;
    padding: 4px;
    transition: all 0.2s ease-in-out 0s;
    cursor: pointer;
  }

  #text-mp{
    font-size: 30px;
  }

  #text-version{
    font-size: 12px;
  }

  .mp-button{
    background-color: #0667B4;
    color: white;
    border-radius: 2px;
    font-size: 12px;
  }

  .mp-button:focus{
    outline: none !important;
  }

  .mp-demo{
    background-color: #2196F3;
  }

  .mp-save{
    background-color: rgb(77, 188, 96);
  }

  .mp-cancel{
    background-color: #E15959;
  }

  .mp-addon{
    background-color: #4285F4;
    color: #FFF;
    border-color: #4285F4;
  }

  .nav-tabs {
      border-bottom: 1px solid #4285F4;
  }

  .nav.nav-tabs > li > a:hover, .nav-tabs > li > a:hover{
    background-color: #4285F4;
    border-color: #4285F4;
    color: white;
    outline: medium none !important;
  }

  .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus {
    background-color: #FFFFFF;
    border: 1px solid #4285F4;
    border-bottom-color: #FFFFFF !important; 
    outline: medium none !important;
    color: black;
  }

  .fa-minus-circle{
    cursor: pointer;
  }
</style>
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="http://webkul.com/blog/opencart-marketplace-multi-vendor-module/" target="_blank" title="<?php echo $text_blog;?>" data-toggle="tooltip" class="btn btn-lg mp-button"><?php echo $text_blog;?></a>
        <a href="https://webkul.uvdesk.com/" target="_blank" title="<?php echo $text_ticket;?>" data-toggle="tooltip" class="btn btn-lg mp-button mp-demo"><?php echo $text_ticket;?></a>
        <button type="submit" form="form-product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-lg mp-button mp-save"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-lg mp-button mp-cancel"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 text-center">
        <div class="text-center" id="text-mp"><?php echo $heading_title; ?></div>
      </div>
      <div class="col-sm-12 text-center">
        <div class="text-center" id="text-version">Version 2.1.3.0</div>
      </div>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>

      <div class="panel-body">

      <!--   <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_info; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div> -->

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-marketplace_status"><?php echo $text_status; ?></label>
            <div class="col-sm-10">
              <select name="marketplace_status" id="input-marketplace_status" class="form-control">
                <option value="0" <?php if(!$marketplace_status) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                <option value="1" <?php if($marketplace_status) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
              </select>
            </div>
          </div>

          <br/>

          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-commission" data-toggle="tab"><?php echo $tab_commission; ?></a></li>
            <li><a href="#tab-product" data-toggle="tab"><?php echo $tab_product; ?></a></li>
            <li><a href="#tab-order" data-toggle="tab"><?php echo $tab_order; ?></a></li>
            <li><a href="#tab-seo" data-toggle="tab"><?php echo $tab_seo; ?></a></li>
            <li><a href="#tab-sell" data-toggle="tab"><?php echo $tab_sell; ?></a></li>
            <li><a href="#tab-profile" data-toggle="tab"><?php echo $tab_profile; ?></a></li>
            <li><a href="#tab-mod-config" data-toggle="tab"><?php echo $tab_mod_config; ?></a></li>
            <li><a href="#tab-mail" data-toggle="tab"><?php echo $tab_mail; ?></a></li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail"><span data-toggle="tooltip" title="<?php echo $entry_admin_mailinfo; ?>"><?php echo $entry_admin_mail; ?></span></label>
                <div class="col-sm-9">
                  <input type="text" name="marketplace_adminmail" value="<?php echo $marketplace_adminmail; ?>" placeholder="" id="input-mail" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-contactseller"><span data-toggle="tooltip" title="<?php echo $entry_default_imageinfo; ?>"><?php echo $entry_default_image; ?></span></label>
                <div class="col-sm-9">
                  <input type="file" class="hide" name="marketplace_default_image" />
                  <input type="hidden" name="marketplace_default_image_name" value="<?php if(isset($marketplace_default_image_name)) echo $marketplace_default_image_name; ?>" />
                  <div class="img-thumbnail-default" id="default-image">
                    <?php if(isset($marketplace_default_image) && $marketplace_default_image ) { ?>
                      <img src="<?php echo $marketplace_default_image; ?>" id="default-image-view" />
                    <?php } ?>
                  </div>
                  <?php if(isset($marketplace_default_image) && $marketplace_default_image ) { ?>
                    <div style="width:100px">
                      <button class="btn btn-danger btn-sm" id="removeimg" type="button" style="margin-top: 5px;width: 100%;"><?php echo $entry_remove; ?></button>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-becomepartnerinfo"><span data-toggle="tooltip" title="<?php echo $entry_becomepartnerinfo; ?>"><?php echo $entry_becomepartner; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_becomepartnerregistration" id="input-becomepartnerinfo" class="form-control">
                    <option value="0" <?php if(!$marketplace_becomepartnerregistration) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_becomepartnerregistration) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-partnerapprove"><span data-toggle="tooltip" title="<?php echo $entry_partnerapprovinfo; ?>"><?php echo $entry_partnerapprov; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_partnerapprov" id="input-partnerapprove" class="form-control">
                    <option value="0" <?php if(!$marketplace_partnerapprov) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_partnerapprov) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-productapprove"><span data-toggle="tooltip" title="<?php echo $entry_productapprovinfo; ?>"><?php echo $entry_productapprov; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_productapprov" id="input-productapprove" class="form-control">
                    <option value="0" <?php if(!$marketplace_productapprov) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_productapprov) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mailtosellerinfo"><span data-toggle="tooltip" title="<?php echo $entry_mailtosellerinfo; ?>"><?php echo $wkentry_mailtoseller; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_mailtoseller" id="input-mailtosellerinfo" class="form-control">
                    <option value="0" <?php if(!$marketplace_mailtoseller) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_mailtoseller) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-contactseller"><span data-toggle="tooltip" title="<?php echo $entry_customer_contact_sellerinfo; ?>"><?php echo $entry_customer_contact_seller; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_customercontactseller" id="input-contactseller" class="form-control">
                    <option value="0" <?php if(!$marketplace_customercontactseller) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_customercontactseller) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-sellernamecart"><span data-toggle="tooltip" title="<?php echo $entry_seller_name_cart_info; ?>"><?php echo $entry_seller_name_cart; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_seller_name_cart_status" id="input-sellernamecart" class="form-control">
                    <option value="0" <?php if(!$marketplace_seller_name_cart_status) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_seller_name_cart_status) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-admincustomercontactseller"><span data-toggle="tooltip" title="<?php echo $entry_mail_admin_customer_contact_sellerinfo; ?>"><?php echo $entry_mail_admin_customer_contact_seller; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_mailadmincustomercontactseller" id="input-admincustomercontactseller" class="form-control">
                    <option></option>
                    <option value="0" <?php if(!$marketplace_mailadmincustomercontactseller) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_mailadmincustomercontactseller) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>
              <!-- <div class="form-group">
                <label class="col-sm-3 control-label" >
                  <span data-toggle="tooltip" data-original-title="<?php echo $entry_divide_shipping_costinfo; ?>">
                    <?php echo $entry_divide_shipping_cost; ?>
                  </span>
                </label>
                <div class="col-sm-9">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="marketplace_divide_shipping" value="yes" <?php if(isset($marketplace_divide_shipping) && $marketplace_divide_shipping == 'yes') echo "checked"; ?> />
                      <?php echo $entry_divide_shipping_cost; ?>
                    </label>
                  </div>
                </div>
              </div> -->
            </div>


            <!-- comission tab -->
            <div class="tab-pane" id="tab-commission">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-commission"><span data-toggle="tooltip" title="<?php echo $entry_commission_info; ?>"><?php echo $entry_commission; ?></span></label>
                <div class="col-sm-9">
                  <div class="input-group"><span class="input-group-addon mp-addon mp-addon">%</span>
                     <input type="text" name="marketplace_commission" value="<?php echo $marketplace_commission; ?>" placeholder="" id="input-commission" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-commission-tax"><span data-toggle="tooltip" title="<?php echo $entry_commission_tax_info; ?>"><?php echo $entry_commission_tax; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_commission_tax" id="input-commission-tax" class="form-control">
                    <option value="0" <?php if(!$marketplace_commission_tax) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_commission_tax) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-commissionworkedon"><span data-toggle="tooltip" title="<?php echo $entry_commission_workedinfo; ?>"><?php echo $entry_commission_worked; ?></span></label>                
                <div class="col-sm-9">
                  <input type="checkbox" name="marketplace_commissionworkedon" value="1" <?php if($marketplace_commissionworkedon) echo 'checked'; ?> id="input-commissionworkedon" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label"><span data-toggle="tooltip"  title="<?php echo $entry_commission_addinfo; ?>"><?php echo $entry_commission_add; ?></span></label>                
                <div class="col-sm-9">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (is_array($marketplace_commission_add) && in_array('category', $marketplace_commission_add)) { ?>
                        <input type="checkbox" name="marketplace_commission_add[category]" value="category" checked="checked" />
                        <?php } else { ?>
                        <input type="checkbox" name="marketplace_commission_add[category]" value="category" />
                        <?php } ?>
                        <?php echo $entry_category; ?>
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                         <?php if (is_array($marketplace_commission_add) && in_array('category_child', $marketplace_commission_add)) { ?>
                        <input type="checkbox" name="marketplace_commission_add[category_child]" value="category_child" checked="checked" />
                        <?php } else { ?>
                        <input type="checkbox" name="marketplace_commission_add[category_child]" value="category_child" />
                        <?php } ?>
                        <?php echo $entry_category_child; ?>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $entry_priority_commissioninfo; ?>"><?php echo $entry_priority_commission; ?></span></label>                
                <div class="col-sm-9">

                  <ul class="nav nav-pills nav-stacked" id="sortable">
                    <?php if(!$marketplace_boxcommission){ ?>
                      <li><a><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                        <input type="hidden" name="marketplace_boxcommission[fixed]" value="fixed" />                    
                        <?php echo $entry_fixed; ?></a>
                      </li>
                      <li><a><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                        <input type="hidden" name="marketplace_boxcommission[category]" value="fixed" />                    
                        <?php echo $entry_category; ?></a>
                      </li>
                      <li><a><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                        <input type="hidden" name="marketplace_boxcommission[category_child]" value="fixed"/>                    
                        <?php echo $entry_category_child; ?></a>
                      </li>
                    <?php }else{ ?>
                      <?php foreach($marketplace_boxcommission as $key => $box){ ?>
                        <li><a><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                          <input type="hidden" name="marketplace_boxcommission[<?php echo $key; ?>]" value="<?php echo $key; ?>"/>
                          <?php if($key=='fixed'){ ?>
                            <?php echo $entry_fixed; ?>
                          <?php }elseif($key=='category'){ ?>
                            <?php echo $entry_category; ?>
                          <?php }elseif($key=='category_child'){ ?>
                            <?php echo $entry_category_child; ?>
                          <?php } ?></a>
                        </li>
                      <?php } ?>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            </div>


            <!-- product tab -->
            <div class="tab-pane" id="tab-product">



              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-sellerProductStore"><span data-toggle="tooltip" title="<?php echo $entry_seller_product_store_info; ?>"><?php echo $entry_seller_product_store; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_seller_product_store" id="input-sellerProductStore" class="form-control">
                   <?php foreach ($seller_product_store as $key => $value) {?>
                    <option value="<?php echo $key;?>" <?php if ($key == $marketplace_seller_product_store) {echo "selected";}?> ><?php echo $value;?></option>
                   <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-auto-generate-sku"><span data-toggle="tooltip" title="<?php echo $entry_auto_generate_sku_info; ?>"><?php echo $entry_auto_generate_sku; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_auto_generate_sku" id="input-auto-generate-sku" class="form-control">
                    <option value="0" <?php if(!$marketplace_auto_generate_sku) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_auto_generate_sku) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-low-stock-info"><span data-toggle="tooltip" title="<?php echo $entry_low_stock_notification_info; ?>"><?php echo $entry_low_stock_notification; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_low_stock_notification" id="input-low-stock-info" class="form-control">
                    <option value="0" <?php if(!$marketplace_low_stock_notification) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_low_stock_notification) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

               <div class="form-group">
                <label class="col-sm-3 control-label" for="input-low-stock-quantity"><span data-toggle="tooltip" title="<?php echo $entry_low_stock_quantity_info; ?>"><?php echo $entry_low_stock_quantity; ?></span></label>
                <div class="col-sm-9">
                  <input type="text" name="marketplace_low_stock_quantity" value="<?php echo $marketplace_low_stock_quantity; ?>" id ="input-low-stock-quantity" class="form-control"/>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $entry_alowed_product_columnsinfo; ?>"><?php echo $entry_alowed_product_columns; ?></span></label>                
                <div class="col-sm-9">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">                    
                    <?php foreach($product_table as $value){ ?>
                      <div class="checkbox">
                        <label>
                          <?php if(is_array($marketplace_allowedproductcolumn) && in_array($value, $marketplace_allowedproductcolumn)) { ?>
                          <input type="checkbox" name="marketplace_allowedproductcolumn[<?php echo $value; ?>]" value="<?php echo $value; ?>" checked="checked" />
                          <?php }else{ ?>
                           <input type="checkbox" name="marketplace_allowedproductcolumn[<?php echo $value; ?>]" value="<?php echo $value; ?>" />
                          <?php } ?>
                          <?php echo ucwords(str_replace('_',' ',$value)); ?>
                        </label>
                      </div>
                    <?php } ?>
                  </div>
                  <a class="selectAll"><?php echo $entry_selectall;?></a> &nbsp;&nbsp; <a class="deselectAll"><?php echo $entry_deselectall;?></a>
                </div>
              </div>


              <div class="form-group">
                <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $entry_alowed_product_tabsinfo; ?>"><?php echo $entry_alowed_product_tabs; ?></span></label>                
                <div class="col-sm-9">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach($product_tabs as $value){?>
                      <div class="checkbox">
                        <label>
                          <?php if(is_array($marketplace_allowedproducttabs) && in_array($value, $marketplace_allowedproducttabs)) { ?>
                          <input type="checkbox" name="marketplace_allowedproducttabs[<?php echo $value; ?>]" value="<?php echo $value; ?>" checked="checked" />
                          <?php }else{ ?>
                           <input type="checkbox" name="marketplace_allowedproducttabs[<?php echo $value; ?>]" value="<?php echo $value; ?>" />
                          <?php } ?>
                          <?php echo ucwords(str_replace('_',' ',$value)); ?>
                        </label>                   
                      </div>
                    <?php } ?>

                  </div>
                  <a class="selectAll"><?php echo $entry_selectall;?></a> &nbsp;&nbsp; <a class="deselectAll"><?php echo $entry_deselectall;?></a>

                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-allowed-category"><span data-toggle="tooltip" title="<?php echo $entry_seller_category_info; ?>"><?php echo $entry_seller_category; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_allowed_seller_category_type" id="input-allowed-category" class="form-control">
                    <?php if ($marketplace_allowed_seller_category_type) { ?>
                    <option value="1" selected="selected"><?php echo $text_all_category; ?></option>
                    <option value="0"><?php echo $text_selected_category; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_all_category; ?></option>
                    <option value="0" selected="selected"><?php echo $text_selected_category; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-9 col-sm-offset-3">
                  <input type="text" name="category" value="" placeholder="" class="form-control" />
                  <div id="allowed-category" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php if ($marketplace_allowed_categories) {?>
                       <?php foreach ($marketplace_allowed_categories as $key => $marketplace_allowed_category) { ?>
                          <div id="allowed-category<?php echo $key; ?>"><i class="fa fa-minus-circle"></i> <?php echo $marketplace_allowed_category; ?>
                            <input type="hidden" name="marketplace_allowed_categories[<?php echo $key;?>]" value="<?php echo $marketplace_allowed_category; ?>" />
                            <input class="allowed_categories" type="hidden" value="<?php echo $key; ?>" />
                          </div>
                      <?php } ?>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-noofimages"><?php echo $entry_no_of_images; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="marketplace_noofimages" value="<?php echo $marketplace_noofimages; ?>" placeholder="<?php echo $text_in_kbs; ?>" id="input-noofimages" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-imageex"><span data-toggle="tooltip" title="<?php echo $entry_image_exinfo; ?>"><?php echo $entry_image_ex; ?></span></label>
                <div class="col-sm-9">
                  <input type="text" name="marketplace_imageex" value="<?php echo $marketplace_imageex; ?>" placeholder="jpg,jpeg,png" id="input-imageex" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-imagesize"><span data-toggle="tooltip" title="<?php echo $wkentry_pimagesizeinfo; ?>"><?php echo $wkentry_pimagesize; ?></span></label>
                <div class="col-sm-9">
                  <input type="text" name="marketplace_imagesize" value="<?php echo $marketplace_imagesize; ?>" placeholder="<?php echo $text_in_kbs; ?>" id="input-imagesize" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-download_ex"><span data-toggle="tooltip" title="<?php echo $entry_download_exinfo; ?>"><?php echo $entry_download_ex; ?></span></label>
                <div class="col-sm-9">
                  <input type="text" name="marketplace_downloadex" value="<?php echo $marketplace_downloadex; ?>" placeholder="zip,jpg,jpeg" id="input-download_ex" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-download_size"><span data-toggle="tooltip" title="<?php echo $entry_download_sizeinfo; ?>"><?php echo $entry_download_size; ?></span></label>
                <div class="col-sm-9">
                  <input type="text" name="marketplace_downloadsize" value="<?php echo $marketplace_downloadsize; ?>" placeholder="<?php echo $text_in_kbs; ?>" id="input-download_size" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-productaddemail"><span data-toggle="tooltip" title="<?php echo $entry_product_add_emailinfo; ?>"><?php echo $entry_product_add_email; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_productaddemail" id="input-productaddemail" class="form-control">
                    <option value="0" <?php if(!$marketplace_productaddemail) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_productaddemail) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-product-reapprove"><span data-toggle="tooltip" title="<?php echo $entry_product_reapproveinfo; ?>"><?php echo $entry_product_reapprove; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_product_reapprove" id="input-product-reapprove" class="form-control">
                    <option value="0" <?php if(!$marketplace_product_reapprove) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_product_reapprove) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-sellerdeleteproduct"><span data-toggle="tooltip" title="<?php echo $entry_customer_delete_productinfo; ?>"><?php echo $entry_customer_delete_product; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_sellerdeleteproduct" id="input-sellerdeleteproduct" class="form-control">
                    <option value="0" <?php if(!$marketplace_sellerdeleteproduct) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_sellerdeleteproduct) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-sellerproductdelete"><span data-toggle="tooltip" title="<?php echo $entry_sellerProductDeleteInfo; ?>"><?php echo $entry_sellerProductDelete; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_sellerproductdelete" id="input-sellerproductdelete" class="form-control">
                    <option value="0" <?php if(!$marketplace_sellerproductdelete) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_sellerproductdelete) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

               <div class="form-group">
                <label class="col-sm-3 control-label" for="input-sellerproductshow"><span data-toggle="tooltip" title="<?php echo $entry_sellerProductVisibleInfo; ?>"><?php echo $entry_sellerProductVisible; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_sellerproductshow" id="input-sellerproductshow" class="form-control">
                    <option value="0" <?php if(!$marketplace_sellerproductshow) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_sellerproductshow) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

               <div class="form-group">
                <label class="col-sm-3 control-label" for="input-sellerbuyproduct"><span data-toggle="tooltip" title="<?php echo $entry_sellerBuyProductInfo; ?>"><?php echo $entry_sellerBuyProduct; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_sellerbuyproduct" id="input-sellerbuyproduct" class="form-control">
                    <option value="0" <?php if(!$marketplace_sellerbuyproduct) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_sellerbuyproduct) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

            </div>

            <!-- order tab -->
            <div class="tab-pane" id="tab-order">
             <div class="form-group">
                <label class="col-sm-3 control-label" for="input-seller-manage-order"><span data-toggle="tooltip" title="<?php echo $entry_seller_manage_order_info; ?>"><?php echo $entry_seller_manage_order; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_seller_manage_order" id="input-seller-manage-order" class="form-control">
                    <option value="0" <?php if(!$marketplace_seller_manage_order) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_seller_manage_order) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
             </div>
             <div class="form-group">
                <label class="col-sm-3 control-label" for="input-orderstatusinfo"><span data-toggle="tooltip" title="<?php echo $wkentry_seller_order_statusinfo; ?>"><?php echo $wkentry_seller_order_status; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_sellerorderstatus" id="input-orderstatusinfo" class="form-control">
                    <option value="0" <?php if(!$marketplace_sellerorderstatus) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_sellerorderstatus) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>

               <div class="form-group">
                <label class="col-sm-3 control-label" for="input-orderstatusnotifyadmin"><span data-toggle="tooltip" title="<?php echo $wkentry_seller_order_status_notify_admin_info; ?>"><?php echo $wkentry_seller_order_status_notify_admin; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_adminnotify" id="input-orderstatusnotifyadmin" class="form-control">
                    <option value="0" <?php if(!$marketplace_adminnotify) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_adminnotify) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>


              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-availableorderstatusinfo"><span data-toggle="tooltip" title="<?php echo $wkentry_seller_available_order_statusinfo; ?>"><?php echo $wkentry_seller_available_order_status; ?></span></label>
                <div class="col-sm-9">
                  <div class="well well-sm" style="height:150px;overflow:auto">
                    <?php if($order_statuses) { ?>
                      <?php foreach ($order_statuses as $key => $order_status) { ?>
                        <div class="checkbox available_order_status">
                          <label for="available_order_status_<?php echo $order_status['order_status_id']; ?>">
                            <input type="checkbox" name="marketplace_available_order_status[]" value="<?php echo $order_status['order_status_id']; ?>" id="available_order_status_<?php echo $order_status['order_status_id']; ?>" <?php if($marketplace_available_order_status && in_array($order_status['order_status_id'], $marketplace_available_order_status)) { echo "checked"; } ?> />
                            <?php echo $order_status['name']; ?>
                          </label>
                        </div>
                      <?php } ?>
                    <?php } ?>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">
                  <span data-toggle="tooltip" data-original-title="<?php echo $wkentry_seller_order_status_sequenceinfo; ?>">
                    <?php echo $wkentry_seller_order_status_sequence; ?>
                  </span>
                </label>
                <div class="col-sm-9">
                  <div class="well well-sm" style="height:150px;overflow:auto">
                    <ul class="nav nav-pills nav-stacked" id="orderstatus">
                      <?php if($marketplace_order_status_sequence) { ?>
                        <?php foreach ($marketplace_order_status_sequence as $key => $value) { ?>
                          <li id='<?php echo "order_status_sequence_".$value["order_status_id"]; ?>' >
                            <a style="cursor:grab">
                              <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                              <input type="hidden" name="marketplace_order_status_sequence[<?php echo $value['order_status_id']; ?>][order_status_id]" value="<?php echo $value['order_status_id']; ?>"/>
                              <input type="hidden" name="marketplace_order_status_sequence[<?php echo $value['order_status_id']; ?>][name]" value="<?php echo $value['name']; ?>" />
                              <?php echo $value['name']; ?>
                            </a>
                          </li>
                        <?php } ?>
                      <?php } ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-admincustomercontactseller"><span data-toggle="tooltip" title="<?php echo $entry_complete_order_statusinfo; ?>"><?php echo $entry_complete_order_status; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_complete_order_status" id="input-admincustomercontactseller" class="form-control">
                    <option></option>
                    <?php foreach ($order_statuses as $key => $order_status) { ?>
                      <option value="<?php echo $order_status['name']; ?>" <?php if(isset($marketplace_complete_order_status) && $marketplace_complete_order_status == $order_status['name']) echo "selected"; ?> ><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
               <div class="form-group">
                <label class="col-sm-3 control-label" for="input-cancelorderstatus"><span data-toggle="tooltip" title="<?php echo $entry_cancel_order_statusinfo; ?>"><?php echo $entry_cancel_order_status; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_cancel_order_status" id="input-cancelorderstatus" class="form-control">
                    <option></option>
                    <?php foreach ($order_statuses as $key => $order_status) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" <?php if(isset($marketplace_cancel_order_status) && $marketplace_cancel_order_status == $order_status['order_status_id']) echo "selected"; ?> ><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-admincustomercontactseller"><span data-toggle="tooltip" title="<?php echo $entry_seller_shipping_methodinfo; ?>"><?php echo $entry_seller_shipping_method; ?></span></label>
                <div class="col-sm-9">
                  <div class="well well-sm"  style="height:150px;overflow:auto">
                    <?php foreach ($shipping_methods as $key => $shipping_method) { ?>
                      <div class="checkbox">
                        <label>
                          <input name="marketplace_allowed_shipping_method[]" type="checkbox" value="<?php echo $shipping_method['code'].'.'.$shipping_method['code']; ?>" <?php if(isset($marketplace_allowed_shipping_method) && in_array($shipping_method['code'].'.'.$shipping_method['code'], $marketplace_allowed_shipping_method)) echo "checked"; ?>  />
                          <?php echo $shipping_method['name']; ?>
                        </label>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>

            <!-- seo tab -->
            <div class="tab-pane" id="tab-seo">
              <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $entry_mpinfo; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-useseo"><span data-toggle="tooltip" title="<?php echo $entry_mpinfo; ?>"><?php echo $entry_useseo; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_useseo" id="input-useseo" class="form-control">
                    <option value="0" <?php if(!$marketplace_useseo) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_useseo) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>


              <ul class="nav nav-tabs">
                <!-- <li ><a href="#tab-seochild" data-toggle="tab"><?php echo $tab_mpseo; ?></a></li> -->
                <li class="active"><a href="#tab-seoauto" data-toggle="tab"><?php echo $tab_defaultseo; ?></a></li>
                <li ><a href="#tab-productseo" data-toggle="tab"><?php echo $tab_productseo; ?></a></li>
              </ul>

              <div class="tab-content">    

                <!-- <div class="tab-pane" id="tab-seochild">                </div> -->

                <div class="tab-pane active" id="tab-seoauto">
                  <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $entry_addseomoreinfo; ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                  </div>

                  <table id="route" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <td class="text-left"><?php echo $entry_route; ?></td>                      
                        <td class="text-left"><?php echo $entry_store; ?></td>
                        <td></td>
                      </tr>
                    </thead>
                    <tbody>

                      <?php $seoCount = 0; ?>
                      <?php if(is_array($marketplace_SefUrlspath) AND $marketplace_SefUrlspath){ ?>
                        <?php foreach($marketplace_SefUrlspath as $key => $wkSefUrls){ ?>
                          <tr id="tr-<?php echo $seoCount ;?>">                        
                            <td class="text-left">
                              <select name="marketplace_SefUrlspath[<?php echo $seoCount; ?>]" class="form-control">
                                <?php foreach($paths as $path){ ?>
                                  <?php if($path==$wkSefUrls){ ?>
                                    <option value="<?php echo $wkSefUrls; ?>" selected >  <?php echo $wkSefUrls; ?> </option>
                                  <?php }else{ ?>
                                    <option value="<?php echo $path; ?>">  <?php echo $path; ?> </option>
                                  <?php } ?>
                                <?php } ?>
                              </select> 
                            </td>

                            <td class="text-left">
                              <input type="text" class="form-control" name="marketplace_SefUrlsvalue[<?php echo $seoCount; ?>]" value="<?php echo $marketplace_SefUrlsvalue[$key]; ?>"/>
                            </td>

                            <td class="text-left"><button type="button" onclick="$('#tr-<?php echo $seoCount; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                          </tr>
                        <?php $seoCount++; } ?>
                      <?php } ?> 
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="2"></td>
                        <td class="text-left"><button type="button" id="addSeo" data-toggle="tooltip" title="<?php echo $entry_addmore; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div id="tab-productseo" class="tab-pane">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">
                      <span data-toggle="tooltip" data-original-title="<?php echo $entry_seo_seller_detailsinfo; ?>">
                        <?php echo $entry_seo_seller_details; ?>
                      </span>
                    </label>
                    <div class="col-sm-9">
                      <select class="form-control" name="marketplace_product_seo_name">
                        <option value="sellername" <?php if(isset($marketplace_product_seo_name) && $marketplace_product_seo_name == 'sellername') echo "selected"; ?>><?php echo $entry_seo_seller_name; ?></option>
                        <option value="companyname" <?php if(isset($marketplace_product_seo_name) && $marketplace_product_seo_name == 'companyname') echo "selected"; ?>><?php echo $entry_seo_company_name; ?></option>
                        <option value="screenname" <?php if(isset($marketplace_product_seo_name) && $marketplace_product_seo_name == 'screenname') echo "selected"; ?>><?php echo $entry_seo_screen_name; ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">
                      <span data-toggle="tooltip" data-original-title="<?php echo $entry_seo_display_formatinfo; ?>">
                        <?php echo $entry_seo_display_format; ?>
                      </span>
                    </label>
                    <div class="col-sm-9">
                      <select class="form-control" name="marketplace_product_seo_format">
                        <option value="1" <?php if(isset($marketplace_product_seo_format) && $marketplace_product_seo_format == '1') echo "selected"; ?> ><?php echo $entry_only_product; ?></option>
                        <option value="2" <?php if(isset($marketplace_product_seo_format) && $marketplace_product_seo_format == '2') echo "selected"; ?>><?php echo $entry_seller_and_product; ?></option>
                        <option value="3" <?php if(isset($marketplace_product_seo_format) && $marketplace_product_seo_format == '3') echo "selected"; ?>><?php echo $entry_product_and_seller; ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">
                      <span data-toggle="tooltip" data-original-title="<?php echo $entry_seo_default_nameinfo; ?>">
                        <?php echo $entry_seo_default_name; ?>
                      </span>
                    </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="marketplace_product_seo_default_name" value="<?php if(isset($marketplace_product_seo_default_name) && $marketplace_product_seo_default_name) echo $marketplace_product_seo_default_name; ?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">
                      <span data-toggle="tooltip" data-original-title="<?php echo $entry_seo_default_name_productinfo; ?>">
                        <?php echo $entry_seo_default_name_product; ?>
                      </span>
                    </label>
                    <div class="col-sm-9">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="marketplace_product_seo_product_name"  value="1" <?php if(isset($marketplace_product_seo_product_name) && $marketplace_product_seo_product_name) echo "checked"; ?> />
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">
                      <span data-toggle="tooltip" data-original-title="<?php echo $entry_seo_add_page_extensioninfo; ?>">
                        <?php echo $entry_seo_add_page_extension; ?>
                      </span>
                    </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="marketplace_product_seo_page_ext" value="<?php if(isset($marketplace_product_seo_page_ext) && $marketplace_product_seo_page_ext) echo $marketplace_product_seo_page_ext; ?>" />
                    </div>
                  </div>
                </div>
              </div>

            </div>


            <!-- sell tab -->
            <div class="tab-pane" id="tab-sell">

              <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $entry_sellinfo; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>

              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-sellgeneral" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                <li><a href="#tab-selltab" data-toggle="tab"><?php echo $tab_tab; ?></a></li>
              </ul>

              <div class="tab-content">    

                <div class="tab-pane active" id="tab-sellgeneral">

                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $wkentry_sellh; ?></label>
                    <div class="col-sm-9">
                      <?php foreach ($languages as $language) { ?>
                        <div class="input-group" style="margin-bottom:10px;"><span class="input-group-addon mp-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                          <input type="text" name="marketplace_sellheader[<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_text; ?>" class="form-control" value="<?php echo isset($marketplace_sellheader[$language['language_id']]) ? $marketplace_sellheader[$language['language_id']] : ''; ?>" />
                        </div>
                      <?php } ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $wkentry_sellb; ?></label>
                    <div class="col-sm-9">
                      <?php foreach ($languages as $language) { ?>
                        <div class="input-group" style="margin-bottom:10px;"><span class="input-group-addon mp-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                          <input type="text" name="marketplace_sellbuttontitle[<?php echo $language['language_id']; ?>]" placeholder="<?php echo $entry_text; ?>" class="form-control" value="<?php echo isset($marketplace_sellbuttontitle[$language['language_id']]) ? $marketplace_sellbuttontitle[$language['language_id']] : ''; ?>" />
                        </div>
                      <?php } ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="input-showpartners"><?php echo $wkentry_show_partner; ?></label>
                    <div class="col-sm-9">
                      <select name="marketplace_showpartners" id="input-showpartners" class="form-control">
                        <option value="0" <?php if(!$marketplace_showpartners) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                        <option value="1" <?php if($marketplace_showpartners) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="input-showproducts"><?php echo $wkentry_show_products; ?></label>
                    <div class="col-sm-9">
                      <select name="marketplace_showproducts" id="input-showproducts" class="form-control">
                        <option value="0" <?php if(!$marketplace_showproducts) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                        <option value="1" <?php if($marketplace_showproducts) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">
                      <span data-toggle="tooltip" data-original-title="<?php echo $entry_partner_list_limit_info; ?>">
                        <?php echo $entry_partner_list_limit; ?>
                      </span>
                    </label>
                    <div class="col-sm-9">
                      <input type="text" name="marketplace_seller_list_limit" value="<?php echo $marketplace_seller_list_limit; ?>" placeholder="" id="input-sellerlist" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">
                      <span data-toggle="tooltip" data-original-title="<?php echo $entry_partner_product_list_limit_info; ?>">
                        <?php echo $entry_partner_product_list_limit; ?>
                      </span>
                    </label>
                    <div class="col-sm-9">
                      <input type="text" name="marketplace_seller_product_list_limit" value="<?php echo $marketplace_seller_product_list_limit; ?>" placeholder="" id="input-sellerlist" class="form-control" />
                    </div>
                  </div>
                  
                </div>     

                <div class="tab-pane" id="tab-selltab">            
                  <div class="row">
                    <div class="col-sm-3">
                      <ul class="nav nav-pills nav-stacked" id="module">
                        <?php if(isset($marketplace_tab['heading'])){ ?>
                          <?php ksort($marketplace_tab['heading']); ?>
                          <?php ksort($marketplace_tab['description']); ?>
                          <?php foreach ($marketplace_tab['heading'] as $tabRow => $tabtitle) { ?>
                          <li>
                            <a href="#tab-module<?php echo $tabRow; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('a[href=\'#tab-module<?php echo $tabRow; ?>\']').parent().remove(); $('#tab-module<?php echo $tabRow; ?>').remove(); $('#module a:first').tab('show');"></i> <?php echo isset($tabtitle[$config_language_id]) ? $tabtitle[$config_language_id] : $tab_module.' '.$tabRow; ?></a>
                          </li>
                          <?php } ?>
                        <?php } ?>                      
                        <li id="module-add"><a onclick="addModule();"><i class="fa fa-plus-circle"></i> <?php echo $wkentry_add_tab; ?></a></li>
                      </ul>
                    </div>

                    <div class="col-sm-9">
                      <div class="tab-content">
                        <?php if(isset($marketplace_tab['heading'])){ ?>                    
                        <?php foreach ($marketplace_tab['heading'] as $tabRow => $tabtitle) { ?>
                        <div class="tab-pane" id="tab-module<?php echo $tabRow; ?>">
                          <ul class="nav nav-tabs" id="language<?php echo $tabRow; ?>">
                            <?php foreach ($languages as $language) { ?>
                            <li><a href="#tab-module<?php echo $tabRow; ?>-language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                            <?php } ?>
                          </ul>
                          <div class="tab-content">
                            <?php foreach ($languages as $language) { ?>
                            <div class="tab-pane" id="tab-module<?php echo $tabRow; ?>-language<?php echo $language['language_id']; ?>">
                              <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-heading<?php echo $tabRow ?>-language<?php echo $language['language_id']; ?>"><?php echo $text_tab_title; ?></label>
                                <div class="col-sm-10">
                                  <input type="text" name="marketplace_tab[heading][<?php echo $tabRow; ?>][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $text_tab_title; ?>" value="<?php echo isset($tabtitle[$language['language_id']]) ? $tabtitle[$language['language_id']] : ''; ?>" class="form-control" id="input-heading<?php echo $tabRow ?>-language<?php echo $language['language_id']; ?>" />
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-description<?php echo $tabRow; ?>-language<?php echo $language['language_id']; ?>"><?php echo $wkentry_selld; ?></label>
                                <div class="col-sm-10">
                                  <textarea name="marketplace_tab[description][<?php echo $tabRow; ?>][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $wkentry_selld; ?>" id="input-description<?php echo $tabRow; ?>-language<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($marketplace_tab['description'][$tabRow][$language['language_id']]) ? $marketplace_tab['description'][$tabRow][$language['language_id']] : ''; ?></textarea>
                                </div>
                              </div>
                            </div>
                            <?php } ?>
                          </div>
                        </div>
                        <?php } ?>
                        <?php } ?>                    
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- profile tab -->
            <div class="tab-pane" id="tab-profile">

              <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_info_profile; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $entry_alowed_profile_columnsinfo; ?>"><?php echo $entry_alowed_profile_columns; ?></span></label>                
                <div class="col-sm-9">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">                    
                    <?php foreach($profile_table as $value){ ?>
                      <div class="checkbox">
                        <label>
                          <?php if(is_array($marketplace_allowedprofilecolumn) && in_array($value, $marketplace_allowedprofilecolumn)) { ?>
                          <input type="checkbox" name="marketplace_allowedprofilecolumn[<?php echo $value; ?>]" value="<?php echo $value; ?>" checked="checked" />
                          <?php }else{ ?>
                           <input type="checkbox" name="marketplace_allowedprofilecolumn[<?php echo $value; ?>]" value="<?php echo $value; ?>" />
                          <?php } ?>
                          <?php echo ucwords(str_replace('_',' ',$value)); ?>
                        </label>
                      </div>
                    <?php } ?>
                  </div>
                  <a class="selectAll"><?php echo $entry_selectall;?></a> &nbsp;&nbsp; <a class="deselectAll"><?php echo $entry_deselectall;?></a>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $entry_allowed_public_profile_columnsinfo; ?>"><?php echo $entry_allowed_public_profile_columns; ?></span></label>                
                <div class="col-sm-9">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">                    
                    <?php foreach($publicSellerProfile as $key => $option) { ?>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="marketplace_allowed_public_seller_profile[<?php echo $key; ?>]" value="<?php echo $key; ?>" <?php if(isset($marketplace_allowed_public_seller_profile) && in_array($key,$marketplace_allowed_public_seller_profile) ) { echo "checked"; } ?> />
                                <?php echo $option; ?>
                        </label>
                      </div>
                    <?php } ?>
                  </div>
                  <a class="selectAll"><?php echo $entry_selectall;?></a> &nbsp;&nbsp; <a class="deselectAll"><?php echo $entry_deselectall;?></a>
                </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label">
                    <?php echo $entry_seller_email; ?>
                  </label>
                  <div class="col-sm-9">
                    <select class="form-control" name="marketplace_profile_email">
                      <option value="0" <?php if(isset($marketplace_profile_email) && !$marketplace_profile_email) echo "selected"; ?>><?php echo $text_disabled ?></option>
                      <option value="1" <?php if(isset($marketplace_profile_email) && $marketplace_profile_email) echo "selected"; ?> ><?php echo $text_enabled ?></option>
                    </select>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label">
                    <?php echo $entry_seller_telephone; ?>
                  </label>
                  <div class="col-sm-9">
                    <select class="form-control" name="marketplace_profile_telephone">
                      <option value="0" <?php if(isset($marketplace_profile_telephone) && !$marketplace_profile_telephone) echo "selected"; ?>><?php echo $text_disabled ?></option>
                      <option value="1" <?php if(isset($marketplace_profile_telephone) && $marketplace_profile_telephone) echo "selected"; ?> ><?php echo $text_enabled ?></option>
                    </select>
                  </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-review-only-order"><span data-toggle="tooltip" title="<?php echo $entry_review_only_order_info; ?>"><?php echo $entry_review_only_order; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_review_only_order" id="input-review-only-order" class="form-control">
                    <option value="0" <?php if(!$marketplace_review_only_order) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_review_only_order) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-seller-info-hide"><span data-toggle="tooltip" title="<?php echo $entry_seller_info_hide_info; ?>"><?php echo $entry_seller_info_hide; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_seller_info_hide" id="input-seller-info-hide" class="form-control">
                    <option value="0" <?php if(!$marketplace_seller_info_hide) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                    <option value="1" <?php if($marketplace_seller_info_hide) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                  </select>
                </div>
              </div>
              <!-- <fieldset>
                <legend><?php echo $entry_customer_seller_profile; ?></legend>
                <!-- <div class="form-group">
                  <label class="col-sm-3 control-label">
                    <?php echo $entry_profile_tab; ?>
                  </label>
                  <div class="col-sm-9">
                    <select class="form-control" name="marketplace_profile_profile">
                      <option value="1" <?php if(isset($marketplace_profile_profile) && $marketplace_profile_profile) echo "selected"; ?> ><?php echo $text_enabled ?></option>
                      <option value="0" <?php if(isset($marketplace_profile_profile) && !$marketplace_profile_profile) echo "selected"; ?>><?php echo $text_disabled ?></option>
                    </select>
                  </div>
                </div> -->
                <!-- <div class="form-group">
                  <label class="col-sm-3 control-label">
                    <?php echo $entry_store_tab; ?>
                  </label>
                  <div class="col-sm-9">
                    <select class="form-control" name="marketplace_profile_store">
                      <option value="1" <?php if(isset($marketplace_profile_store) && $marketplace_profile_store) echo "selected"; ?> ><?php echo $text_enabled ?></option>
                      <option value="0" <?php if(isset($marketplace_profile_store) && !$marketplace_profile_store) echo "selected"; ?>><?php echo $text_disabled ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">
                    <?php echo $entry_collection_tab; ?>
                  </label>
                  <div class="col-sm-9">
                    <select class="form-control" name="marketplace_profile_collection">
                      <option value="1" <?php if(isset($marketplace_profile_collection) && $marketplace_profile_collection) echo "selected"; ?> ><?php echo $text_enabled ?></option>
                      <option value="0" <?php if(isset($marketplace_profile_collection) && !$marketplace_profile_collection) echo "selected"; ?>><?php echo $text_disabled ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">
                    <?php echo $entry_review_tab; ?>
                  </label>
                  <div class="col-sm-9">
                    <select class="form-control" name="marketplace_profile_review">
                      <option value="1" <?php if(isset($marketplace_profile_review) && $marketplace_profile_review) echo "selected"; ?> ><?php echo $text_enabled ?></option>
                      <option value="0" <?php if(isset($marketplace_profile_review) && !$marketplace_profile_review) echo "selected"; ?>><?php echo $text_disabled ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">
                    <?php echo $entry_product_review_tab; ?>
                  </label>
                  <div class="col-sm-9">
                    <select class="form-control" name="marketplace_profile_product_review">
                      <option value="1" <?php if(isset($marketplace_profile_product_review) && $marketplace_profile_product_review) echo "selected"; ?> ><?php echo $text_enabled ?></option>
                      <option value="0" <?php if(isset($marketplace_profile_product_review) && !$marketplace_profile_product_review) echo "selected"; ?>><?php echo $text_disabled ?></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">
                    <?php echo $entry_location_tab; ?>
                  </label>
                  <div class="col-sm-9">
                    <select class="form-control" name="marketplace_profile_location">
                      <option value="1" <?php if(isset($marketplace_profile_location) && $marketplace_profile_location) echo "selected"; ?> ><?php echo $text_enabled ?></option>
                      <option value="0" <?php if(isset($marketplace_profile_location) && !$marketplace_profile_location) echo "selected"; ?>><?php echo $text_disabled ?></option>
                    </select>
                  </div>
                </div>
              </fieldset> -->
            </div>

            <!-- module configuration tab -->

            <div class="tab-pane" id="tab-mod-config">
              <ul class="nav nav-tabs">
                <li class="active">
                  <a href="#mod-account" data-toggle="tab">
                    <?php echo $tab_mod_config_account; ?>
                  </a>
                </li>
                <li>
                  <a href="#mod-product" data-toggle="tab">
                    <?php echo $tab_mod_config_product; ?>
                  </a>
                </li>
              </ul>
                <div class="tab-content">
                  <div id="mod-account" class="tab-pane active">
                    <div class="form-group">
                      <label class="col-sm-3 control-label">
                        <span data-toggle="tooltip" data-original-title="<?php  echo $entry_allowed_account_menuinfo; ?>">
                          <?php echo $entry_allowed_account_menu; ?>
                        </span>
                      </label>
                      <div class="col-sm-9">
                        <div class="well well-sm" style="height:150px;overflow:auto" >
                          <?php foreach ($account_menu as $key => $value) { ?>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="marketplace_allowed_account_menu[<?php echo $key; ?>]" value="<?php echo $key; ?>" <?php if(isset($marketplace_allowed_account_menu) && in_array($key,$marketplace_allowed_account_menu) ) { echo "checked"; } ?> />
                                <?php echo $value; ?>
                              </label>
                            </div>
                          <?php } ?>
                        </div>
                        <a class="selectAll"><?php echo $entry_selectall;?></a> &nbsp;&nbsp; <a class="deselectAll"><?php echo $entry_deselectall;?></a>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">
                        <span data-toggle="tooltip" data-original-title="<?php  echo $entry_account_menu_sequenceinfo; ?>">
                          <?php echo $entry_account_menu_sequence; ?>
                        </span>
                      </label>
                      <div class="col-sm-9">
                        <div class="well">
                          <ul class="nav nav-pills nav-stacked" id="acct_menu_sortable">
                            <?php if(!isset($marketplace_account_menu_sequence)) { 
                                  foreach ($account_menu as $key => $value) { ?>
                                    <li>
                                      <a style="cursor:grab">
                                        <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                        <input type="hidden" name="marketplace_account_menu_sequence[<?php echo $key ?>]" value="<?php echo $key; ?>" />                    
                                        <?php echo $value; ?>
                                      </a>
                                    </li>
                            <?php } ?>        
                            <?php } else { ?>
                              <?php foreach($marketplace_account_menu_sequence as $key => $sequence){ ?>
                                <li>
                                  <a style="cursor:grab">
                                    <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                    <input type="hidden" name="marketplace_account_menu_sequence[<?php echo $key; ?>]" value="<?php echo $account_menu[$key]; ?>"/>
                                    <?php echo $account_menu[$key]; ?>
                                  </a>
                                </li>
                              <?php } ?>
                            <?php } ?>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="mod-product" class="tab-pane">
                    <div class="form-group">
                      <label class="col-sm-3 control-label" ><span data-toggle="tooltip" title="<?php echo $entry_product_name_displayinfo; ?>"><?php echo $entry_product_name_display; ?></span></label>
                      <div class="col-sm-9">
                        <select name="marketplace_product_name_display" class="form-control">
                          <option value="sn" <?php if(isset($marketplace_product_name_display) && $marketplace_product_name_display == 'sn') echo "selected"; ?> ><?php echo "Seller Name"; ?></option>
                          <option value="cn" <?php if(isset($marketplace_product_name_display) && $marketplace_product_name_display == 'cn') echo "selected"; ?>><?php echo "Company Name"; ?></option>
                          <option value="sncn" <?php if(isset($marketplace_product_name_display) && $marketplace_product_name_display == 'sncn') echo "selected"; ?>><?php echo "Seller and Company Name"; ?></option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $entry_product_show_seller_productinfo; ?>"><?php echo $entry_product_show_seller_product; ?></span></label>
                      <div class="col-sm-9">
                        <select name="marketplace_product_show_seller_product" class="form-control">
                          <option value="1" <?php if(isset($marketplace_product_show_seller_product) && $marketplace_product_show_seller_product) echo 'selected';?> ><?php echo $text_enabled; ?> </option>
                          <option value="0" <?php if(isset($marketplace_product_show_seller_product) && !$marketplace_product_show_seller_product) echo 'selected';?> ><?php echo $text_disabled; ?> </option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $entry_product_image_displayinfo; ?>"><?php echo $entry_product_image_display; ?></span></label>
                      <div class="col-sm-9">
                        <select name="marketplace_product_image_display" id="input-mail_partner_request" class="form-control">
                          <option value="avatar" <?php if(isset($marketplace_product_image_display) && $marketplace_product_image_display == 'avatar') echo 'selected';?> ><?php echo "Avatar"; ?> </option>
                          <option value="companylogo" <?php if(isset($marketplace_product_image_display) && $marketplace_product_image_display == 'companylogo') echo 'selected';?> ><?php echo "Company Logo"; ?> </option>
                          <option value="companybanner" <?php if(isset($marketplace_product_image_display) && $marketplace_product_image_display == 'companybanner') echo 'selected';?> ><?php echo "Company banner"; ?> </option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="input-seller-info-by-module"><span data-toggle="tooltip" title="<?php echo $entry_seller_info_by_module_info; ?>"><?php echo $entry_seller_info_by_module; ?></span></label>
                      <div class="col-sm-9">
                        <select name="marketplace_seller_info_by_module" id="input-seller-info-by-module" class="form-control">
                          <option value="0" <?php if(!$marketplace_seller_info_by_module) echo 'selected';?>>  <?php echo $text_disabled; ?> </option>
                          <option value="1" <?php if($marketplace_seller_info_by_module) echo 'selected';?>>  <?php echo $text_enabled; ?> </option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

            <!-- mail tab -->
            <div class="tab-pane" id="tab-mail">

              <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_info_mail; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>              

              <div class="form-group">
                <label class="col-sm-3 control-label">
                  <span data-toggle="tooltip" data-original-title="<?php echo "Mail Keywords"; ?>" >
                    <?php echo "Mail Keywords"; ?>
                  </span>
                </label>
                <div class="col-sm-9">
                  <textarea class="form-control" name="marketplace_mail_keywords" style="height:150px"><?php if(isset($marketplace_mail_keywords)) { echo $marketplace_mail_keywords; } else { ?>{order}
{message}
{subject}
{commission}
{product_name}
{product_quantity}
{customer_name}
{seller_name}
{config_logo}
{config_icon}
{config_currency}
{config_image}
{config_name}
{config_owner}
{config_address}
{config_geocode}
{config_email}
{config_telephone}<?php } ?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail_partner_request"><span data-toggle="tooltip" title="<?php echo $entry_mail_partner_request_info; ?>"><?php echo $entry_mail_partner_request; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_mail_partner_request" id="input-mail_partner_request" class="form-control">
                    <option value=""></option>
                    <?php if($mails){ ?>
                    <?php foreach($mails as $mail){ ?>
                      <option value="<?php echo $mail['id']; ?>" <?php if($marketplace_mail_partner_request==$mail['id']) echo 'selected';?>>  <?php echo $mail['name']; ?> </option>
                    <?php } ?>
                    <?php } ?>                    
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail_partner_admin"><span data-toggle="tooltip" title="<?php echo $entry_mail_partner_admin_info; ?>"><?php echo $entry_mail_partner_admin; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_mail_partner_admin" id="input-mail_partner_admin" class="form-control">
                    <option value=""></option>
                    <?php if($mails){ ?>
                    <?php foreach($mails as $mail){ ?>
                      <option value="<?php echo $mail['id']; ?>" <?php if($marketplace_mail_partner_admin==$mail['id']) echo 'selected';?>>  <?php echo $mail['name']; ?> </option>
                    <?php } ?>
                    <?php } ?>                    
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail_partner_approve"><span data-toggle="tooltip" title="<?php echo $entry_mail_partner_approve_info; ?>"><?php echo $entry_mail_partner_approve; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_mail_partner_approve" id="input-mail_partner_approve" class="form-control">
                    <option value=""></option>
                    <?php if($mails){ ?>
                    <?php foreach($mails as $mail){ ?>
                      <option value="<?php echo $mail['id']; ?>" <?php if($marketplace_mail_partner_approve==$mail['id']) echo 'selected';?>>  <?php echo $mail['name']; ?> </option>
                    <?php } ?>
                    <?php } ?>                    
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail_product_request"><span data-toggle="tooltip" title="<?php echo $entry_mail_product_request_info; ?>"><?php echo $entry_mail_product_request; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_mail_product_request" id="input-mail_product_request" class="form-control">
                    <option value=""></option>
                    <?php if($mails){ ?>
                    <?php foreach($mails as $mail){ ?>
                      <option value="<?php echo $mail['id']; ?>" <?php if($marketplace_mail_product_request==$mail['id']) echo 'selected';?>>  <?php echo $mail['name']; ?> </option>
                    <?php } ?>
                    <?php } ?>                    
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail_product_admin"><span data-toggle="tooltip" title="<?php echo $entry_mail_product_admin_info; ?>"><?php echo $entry_mail_product_admin; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_mail_product_admin" id="input-mail_product_admin" class="form-control">
                    <option value=""></option>
                    <?php if($mails){ ?>
                    <?php foreach($mails as $mail){ ?>
                      <option value="<?php echo $mail['id']; ?>" <?php if($marketplace_mail_product_admin==$mail['id']) echo 'selected';?>>  <?php echo $mail['name']; ?> </option>
                    <?php } ?>
                    <?php } ?>                    
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail_product_approve"><span data-toggle="tooltip" title="<?php echo $entry_mail_product_approve_info; ?>"><?php echo $entry_mail_product_approve; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_mail_product_approve" id="input-mail_product_approve" class="form-control">
                    <option value=""></option>
                    <?php if($mails){ ?>
                    <?php foreach($mails as $mail){ ?>
                      <option value="<?php echo $mail['id']; ?>" <?php if($marketplace_mail_product_approve==$mail['id']) echo 'selected';?>>  <?php echo $mail['name']; ?> </option>
                    <?php } ?>
                    <?php } ?>                    
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail_transaction"><span data-toggle="tooltip" title="<?php echo $entry_mail_transaction_info; ?>"><?php echo $entry_mail_transaction; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_mail_transaction" id="input-mail_transaction" class="form-control">
                    <option value=""></option>
                    <?php if($mails){ ?>
                    <?php foreach($mails as $mail){ ?>
                      <option value="<?php echo $mail['id']; ?>" <?php if($marketplace_mail_transaction==$mail['id']) echo 'selected';?>>  <?php echo $mail['name']; ?> </option>
                    <?php } ?>
                    <?php } ?>                    
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail_order"><span data-toggle="tooltip" title="<?php echo $entry_mail_order_info; ?>"><?php echo $entry_mail_order; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_mail_order" id="input-mail_order" class="form-control">
                    <option value=""></option>
                    <?php if($mails){ ?>
                    <?php foreach($mails as $mail){ ?>
                      <option value="<?php echo $mail['id']; ?>" <?php if($marketplace_mail_order==$mail['id']) echo 'selected';?>>  <?php echo $mail['name']; ?> </option>
                    <?php } ?>
                    <?php } ?>                    
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail_cutomer_to_seller"><span data-toggle="tooltip" title="<?php echo $entry_mail_cutomer_to_seller_info; ?>"><?php echo $entry_mail_cutomer_to_seller; ?></span></label>
                <div class="col-sm-9">
                  <select name="marketplace_mail_cutomer_to_seller" id="input-mail_cutomer_to_seller" class="form-control">
                    <option value=""></option>
                    <?php if($mails){ ?>
                    <?php foreach($mails as $mail){ ?>
                      <option value="<?php echo $mail['id']; ?>" <?php if($marketplace_mail_cutomer_to_seller==$mail['id']) echo 'selected';?>>  <?php echo $mail['name']; ?> </option>
                    <?php } ?>
                    <?php } ?>                    
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail_seller_to_admin"><span data-toggle="tooltip" title="<?php echo $entry_mail_seller_to_admin_info; ?>"><?php echo $entry_mail_seller_to_admin; ?></label>
                <div class="col-sm-9">
                  <select name="marketplace_mail_seller_to_admin" id="input-mail_seller_to_admin" class="form-control">
                    <option value=""></option>
                    <?php if($mails){ ?>
                    <?php foreach($mails as $mail){ ?>
                      <option value="<?php echo $mail['id']; ?>" <?php if($marketplace_mail_seller_to_admin==$mail['id']) echo 'selected';?>>  <?php echo $mail['name']; ?> </option>
                    <?php } ?>
                    <?php } ?>                    
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail_admin_on_edit">
                  <span data-toggle="tooltip" data-original-title="<?php echo $entry_mail_edit_product_admininfo; ?>">
                    <?php echo $entry_mail_edit_product_admin; ?>
                  </span>
                </label>
                <div class="col-sm-9">
                  <select name="marketplace_mail_admin_on_edit" id="input-mail_admin_on_edit" class="form-control">
                    <option value=""></option>
                    <?php if($mails){ ?>
                    <?php foreach($mails as $mail) { ?>
                      <option value="<?php echo $mail['id']; ?>" <?php if($marketplace_mail_admin_on_edit==$mail['id']) echo 'selected';?> ><?php echo $mail['name']; ?></option>
                    <?php } ?>
                    <?php } ?>                    
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail_seller_on_edit">
                  <span data-toggle="tooltip" data-original-title="<?php echo $entry_mail_edit_product_sellerinfo; ?>">
                    <?php echo $entry_mail_edit_product_seller; ?>
                  </span>
                </label>
                <div class="col-sm-9">
                  <select name="marketplace_mail_seller_on_edit" id="input-mail_seller_on_edit" class="form-control">
                    <option value=""></option>
                    <?php if($mails){ ?>
                    <?php foreach($mails as $mail) { ?>
                      <option value="<?php echo $mail['id']; ?>" <?php if($marketplace_mail_seller_on_edit==$mail['id']) echo 'selected';?>>  <?php echo $mail['name']; ?> </option>
                    <?php } ?>
                    <?php } ?>                    
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-mail_seller_on_edit">
                  <span data-toggle="tooltip" data-original-title="<?php echo $entry_mail_low_stock_sellerinfo; ?>">
                    <?php echo $entry_mail_low_stock_seller; ?>
                  </span>
                </label>
                <div class="col-sm-9">
                  <select name="marketplace_mail_seller_low_stock" id="input-mail_seller_on_edit" class="form-control">
                    <option value=""></option>
                    <?php if($mails){ ?>
                    <?php foreach($mails as $mail) { ?>
                      <option value="<?php echo $mail['id']; ?>" <?php if($marketplace_mail_seller_low_stock == $mail['id']) echo 'selected';?>>  <?php echo $mail['name']; ?> </option>
                    <?php } ?>
                    <?php } ?>                    
                  </select>
                </div>
              </div>

            </div>

          </div>
        </form>
      </div>
    </div>
  </div>         
<script type="text/javascript"><!--

$('.available_order_status > label > input[type="checkbox"]').on('click', function(){
  order_status_id = $(this).val();
  order_status_name = $.trim($(this).parent('label').text());
  if($(this).is(':checked')) {
    html = '';
    html += '<li id="order_status_sequence_'+order_status_id+'"><a style="cursor:grab"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input type="hidden" name="marketplace_order_status_sequence['+order_status_id+'][order_status_id]" value="'+order_status_id+'"/><input type="hidden" name="marketplace_order_status_sequence['+order_status_id+'][name]" value="'+order_status_name+'"/>'+order_status_name+'</a></li>';
    console.log(html);
    $('#orderstatus').append(html);
  } else {
    $('#order_status_sequence_'+order_status_id).remove();
  }
});

$('#default-image').on('click',function(){
  $(this).prevAll('input[type="file"]').trigger('click');
});

$('#removeimg').on('click',function(){
  confirmation = confirm("Are you sure?");
  if(confirmation) {
    $('#default-image-view').remove();
    $('input[name="marketplace_default_image_name"]').val('');
  }
});

$(function(){
  $("input[name='marketplace_default_image']").on("change", function()
   {
    $.this = this;
       var files = !!this.files ? this.files : [];
       if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

       if (/^image/.test( files[0].type)){ // only image file
           var reader = new FileReader(); // instance of the FileReader
           reader.readAsDataURL(files[0]); // read the local file

           reader.onloadend = function(){ // set image to display only
              $($.this).nextAll('#default-image').html();
              $($.this).nextAll('#default-image').html('<img src="" id="default-image-view" height="90px" width="90px" />');
               src = this.result;
               $($.this).nextAll('div').children('img').attr('src',src);
           }
       }
   });
})

$('input[name="marketplace_divide_shipping"]').on('change',function(){
  $('.alert').remove();
  if($(this).is(':checked')){
    $('.panel').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $text_divide_shipping; ?><button class="close" data-dismiss="alert" type="button">×</button></div>');
    $('html, body').animate({scrollTop:0},'slow');
  }
})

//To print tab name from current used language's text box
$("body").on("keyup",".row .tab-content input[type='text']",function(){
  tabId = $(this).attr('id').split('-')[1].replace('heading','');
  html = '<i class="fa fa-minus-circle" onclick="$(\'a[href=\\\'#tab-module'+tabId+'\\\']\').parent().remove(); $(\'#tab-module'+tabId+'\').remove(); $(\'#module a:first\').tab(\'show\');"></i> ';
  html += $(this).val();
  $('a[href=#tab-module'+tabId+']').html(html);
});

<?php if(isset($marketplace_tab['description'])){ ?>
  <?php foreach ($marketplace_tab['description'] as $key=>$description) { ?>
    <?php foreach ($languages as $language) { ?>
      $('#input-description<?php echo $key; ?>-language<?php echo $language['language_id']; ?>').summernote({
        height: 300
      });
    <?php } ?>
  <?php } ?>
<?php } ?>

$('#module li:first-child a').tab('show');
  <?php if(isset($marketplace_tab['heading'])){ ?>
    <?php foreach ($marketplace_tab['heading'] as $key=>$module) { ?>
      $('#language<?php echo $key; ?> li:first-child a').tab('show');
    <?php } ?>
<?php } ?>

var module_row = <?php echo isset($marketplace_tab['heading']) ? (max(array_keys($marketplace_tab['heading'])) + 1) : 0; ?>;
  
function addModule() {
  var token = Math.random().toString(36).substr(2);
  
  html  = '<div class="tab-pane" id="tab-module' + token + '">';
  html += '  <ul class="nav nav-tabs" id="language' + token + '">';
    <?php foreach ($languages as $language) { ?>
    html += '    <li><a href="#tab-module' + token + '-language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>';
    <?php } ?>
  html += '  </ul>';

  html += '  <div class="tab-content">';

  <?php foreach ($languages as $language) { ?>
  html += '    <div class="tab-pane" id="tab-module' + token + '-language<?php echo $language['language_id']; ?>">';
  html += '      <div class="form-group">';
  html += '        <label class="col-sm-3 control-label" for="input-heading' + token + '-language<?php echo $language['language_id']; ?>"><?php echo $text_tab_title; ?></label>';
  html += '        <div class="col-sm-9"><input type="text" name="marketplace_tab[heading]['+module_row+'][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $text_tab_title; ?>" id="input-heading' + token + '-language<?php echo $language['language_id']; ?>" value="" class="form-control"/></div>';
  html += '      </div>';
  html += '      <div class="form-group">';
  html += '        <label class="col-sm-3 control-label" for="input-description' + token + '-language<?php echo $language['language_id']; ?>"><?php echo $wkentry_selld; ?></label>';
  html += '        <div class="col-sm-9"><textarea name="marketplace_tab[description]['+module_row+'][<?php echo $language['language_id']; ?>]" placeholder="<?php echo $wkentry_selld; ?>" id="input-description' + token + '-language<?php echo $language['language_id']; ?>"></textarea></div>';
  html += '      </div>';
  html += '    </div>';
  <?php } ?>

  html += '  </div>';
  html += '</div>';

  $('.tab-content:first-child').prepend(html);

  <?php foreach ($languages as $language) { ?>
  $('#input-description' + token + '-language<?php echo $language['language_id']; ?>').summernote({
    height: 300
  });
  <?php } ?>
  
  $('button[data-event=\'showImageDialog\']').attr('data-toggle', 'image').removeAttr('data-event');

  $('#module-add').before('<li><a href="#tab-module' + token + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$(\'a[href=\\\'#tab-module' + token + '\\\']\').parent().remove(); $(\'#tab-module' + token + '\').remove(); $(\'#module a:first\').tab(\'show\');"></i> <?php echo $tab_module; ?> ' + module_row + '</a></li>');

  $('#module a[href=\'#tab-module' + token + '\']').tab('show');

  $('#language' + token + ' li:first-child a').tab('show');

  module_row++;
}
//--></script> 

<script type="text/javascript"><!--
seoCount = '<?php echo $seoCount; ?>';
$('#addSeo').on('click',function(){
  html = '<tr id="tr-'+seoCount+'">';
  html +=   '<td class="text-left">';
  html +=     '<select name="marketplace_SefUrlspath['+seoCount+']" class="form-control">';
  html +=          '<?php if($paths){ ?>';
  html +=            '<?php foreach($paths as $path){ ?>';
  html +=               '<option value="<?php echo $path; ?>">  <?php echo $path; ?> </option>';
  html +=             '<?php } ?>';
  html +=           '<?php } ?>';
  html +=      '</select>';
  html +=   '</td><td class="text-left">';  
  html +=      ' <input type="text" name="marketplace_SefUrlsvalue['+seoCount+']" class="form-control" value=""/>';
  html +=   '</td><td class="text-left">';
  html +=      '<button type="button" onclick="$(\'#tr-'+seoCount+'\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>';  
  html +=   '</td>';
  html += '</tr>';

  $('#route tbody').append(html);
  seoCount++;
});

$('.selectAll').on('click',function(){
  $(this).prev('div').find('input[type="checkbox"]').prop('checked',true);
})

$('.deselectAll').on('click',function(){
  $(this).prevAll('div').find('input[type="checkbox"]').prop('checked',false);
})
</script>
<script src="view/javascript/jquery-ui/jquery-sortable-min.js"></script>
<script type="text/javascript"><!--
$(function() {
  $( "#sortable" ).sortable();
  $( "#sortable" ).disableSelection();
  $( "#orderstatus" ).sortable();
  $( "#orderstatus" ).disableSelection();
  $( "#acct_menu_sortable" ).sortable();
  $( "#acct_menu_sortable" ).disableSelection();
});
//--></script>
<script>
  // Allowed Seller Category
  var allowed_categories = [];
  $('input[name = \'category\']').on('click', function(){

    allowed_categories = [];
    $('.allowed_categories').each(function(){
      
      allowed_categories.push($(this).val());
      console.log(allowed_categories);
    });
  });
  $('input[name=\'category\']').autocomplete({
    'source': function(request, response) {
      $.ajax({
        url: 'index.php?route=module/marketplace/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        type: 'post',
        dataType: 'json',
        data: {allowed_categories},
        success: function(json) {
          response($.map(json, function(item) {
            return {
              label: item['name'],
              value: item['category_id']
            }
          }));
        }
      });
    },
    'select': function(item) {
      $('input[name=\'category\']').val('');

      $('#allowed-category' + item['value']).remove();

      $('#allowed-category').append('<div id="allowed-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="marketplace_allowed_categories[' +item['value'] +']" value="' + item['label'] + '" /><input class="allowed_categories" type="hidden" value="' + item['value'] + '" /></div>');
    }
  });
  $('#allowed-category').delegate('.fa-minus-circle', 'click', function() {
    $(this).parent().remove();
  });
</script> 

<?php echo $footer; ?>