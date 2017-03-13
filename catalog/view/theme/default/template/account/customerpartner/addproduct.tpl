<?php echo $header; ?>
<?php if($chkIsPartner){ ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
<?php if ($error_warning) { ?>
<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $error_warning; ?></div>
<?php } ?>

<?php if($marketplace_product_reapprove) { ?>
  <div class="alert alert-info">
    <i class="fa fa-info-circle"></i>
    <?php echo $marketplace_product_reapprove; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
<?php } ?>
<?php if ($success) { ?>
<div class="alert alert-success"><i class="fa fa-check-circle"> </i> <?php echo $success; ?></div>
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
      <h1>
        <?php echo $heading_title; ?>
        <div class="pull-right">           
          <a onclick="$('#form-save').submit();" data-toggle="tooltip" class="btn <?php echo $product_id ? 'btn-info' : 'btn-success'; ?>" title="<?php echo $button_continue; ?>" id="submit"><i class="fa fa-save"></i></a>
          <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
        </div>
      </h1>
         
      <legend><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></legend>
    
    <?php if(!isset($access_error) && $isMember) { ?>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-save" class="form-horizontal">
     <!-- membership codes starts here -->
     <?php if(isset($wk_seller_group_status) && $wk_seller_group_status) { ?>
        <input type="hidden" value="<?php if(isset($isClone) && $isClone) echo $isClone; ?>" name="clone">
        <input type="hidden" value="<?php if(isset($isRelist) && $isRelist) echo $isRelist; ?>" name="relist">
        <input type="hidden" value="<?php if(isset($isEdit) && $isEdit) echo $isEdit; ?>" name="edit">
      <?php } ?>
       <!-- membership codes ends here -->
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
        <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>

        <?php if(isset($mp_allowproducttabs['links'])){ ?>
          <li><a href="#tab-links" data-toggle="tab"><?php echo $tab_links; ?></a></li>
        <?php } ?>

        <?php if(isset($mp_allowproducttabs['attribute'])){ ?>
         <li> <a href="#tab-attribute" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
        <?php } ?>

        <?php if(isset($mp_allowproducttabs['options'])){ ?>
          <li><a href="#tab-option" data-toggle="tab"><?php echo $tab_option; ?></a></li>
        <?php } ?>

        <?php if(isset($mp_allowproducttabs['discount'])){ ?>
         <li> <a href="#tab-discount" data-toggle="tab"><?php echo $tab_discount; ?></a></li>
        <?php } ?>

        <?php if(isset($mp_allowproducttabs['special'])){ ?>
          <li><a href="#tab-special" data-toggle="tab"><?php echo $tab_special; ?></a></li>
        <?php } ?>

       <li> <a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a>   </li>     
     
        <?php if(isset($mp_allowproducttabs['custome-field'])) { ?>
          <li><a href="#tab-custom-field" data-toggle="tab"><?php echo $text_custom_field; ?></a></li>
        <?php } ?>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="tab-general">        
          <ul class="nav nav-tabs" id="languages">
            <?php $count = 0; foreach ($languages as $language) { ?>
            <li class="<?php if($count == 0) echo 'active'; $count++; ?>">
              <a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab">
                <img src="thebugmanage/view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                <?php echo $language['name']; ?></a>
            </li>
            <?php } ?>
          </ul>
          <div class="tab-content">
            <?php $count = 0; foreach ($languages as $language) { ?>
            <div class="tab-pane <?php if($count == 0) echo 'active'; $count++; ?>" id="language<?php echo $language['language_id']; ?>">
              <div class="form-group required">
                <label class="col-sm-3 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="product_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" />
                  <?php if (isset($error_name[$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                <div class="col-sm-9">
                  <textarea name="product_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['description'] : ''; ?></textarea>
                </div>
              </div>   

              <div class="form-group required">
                <label class="col-sm-3 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="product_description[<?php echo $language['language_id']; ?>][meta_title]"  placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_title'] : ''; ?>" />
                  <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                <div class="col-sm-9">
                  <textarea name="product_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                <div class="col-sm-9">
                  <textarea name="product_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-tag<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_tag; ?>"><?php echo $entry_tag; ?></span></label>
                <div class="col-sm-9">
                  <input class="form-control" type="text" name="product_description[<?php echo $language['language_id']; ?>][tag]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['tag'] : ''; ?>" placeholder="<?php echo $entry_tag; ?>" id="input-tag<?php echo $language['language_id']; ?>" />
                </div>
              </div>      
            </div>
            <?php } ?>
          </div><!--tab-content-language-->
        </div>

        <div class="tab-pane" id="tab-data">     
          <?php if(isset($mp_allowproductcolumn['model'])) { ?>      
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="input-model"><?php echo $entry_model; ?></label>
            <div class="col-sm-9">
              <input type="text" name="model" value="<?php echo $model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
              <?php if ($error_model) { ?>
              <div class="text-danger"><?php echo $error_model; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
          <?php if(isset($mp_allowproductcolumn['sku'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-sku"><span data-toggle="tooltip" title="<?php echo $help_sku; ?>"><?php echo $entry_sku; ?></span></label>
            <div class="col-sm-9">
              <input type="text" name="sku" value="<?php echo $sku; ?>" placeholder="<?php echo $entry_sku; ?>" id="input-sku" class="form-control" />
            </div>
          </div>
          <?php } ?>
          <?php if(isset($mp_allowproductcolumn['upc'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-upc"><span data-toggle="tooltip" title="<?php echo $help_upc; ?>"><?php echo $entry_upc; ?></span></label>
            <div class="col-sm-9">
              <input type="text" name="upc" value="<?php echo $upc; ?>" placeholder="<?php echo $entry_upc; ?>" id="input-upc" class="form-control" />
            </div>
          </div>
           <?php } ?>
          <?php if(isset($mp_allowproductcolumn['ean'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-ean"><span data-toggle="tooltip" title="<?php echo $help_ean; ?>"><?php echo $entry_ean; ?></span></label>
            <div class="col-sm-9">
              <input type="text" name="ean" value="<?php echo $ean; ?>" placeholder="<?php echo $entry_ean; ?>" id="input-ean" class="form-control" />
            </div>
          </div>
           <?php } ?>
          <?php if(isset($mp_allowproductcolumn['jan'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-jan"><span data-toggle="tooltip" title="<?php echo $help_jan; ?>"><?php echo $entry_jan; ?></span></label>
            <div class="col-sm-9">
              <input type="text" name="jan" value="<?php echo $jan; ?>" placeholder="<?php echo $entry_jan; ?>" id="input-jan" class="form-control" />
            </div>
          </div>
           <?php } ?>
          <?php if(isset($mp_allowproductcolumn['isbn'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-isbn"><span data-toggle="tooltip" title="<?php echo $help_isbn; ?>"><?php echo $entry_isbn; ?></span></label>
            <div class="col-sm-9">
              <input type="text" name="isbn" value="<?php echo $isbn; ?>" placeholder="<?php echo $entry_isbn; ?>" id="input-isbn" class="form-control" />
            </div>
          </div>
           <?php } ?>
          <?php if(isset($mp_allowproductcolumn['mpn'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-mpn"><span data-toggle="tooltip" title="<?php echo $help_mpn; ?>"><?php echo $entry_mpn; ?></span></label>
            <div class="col-sm-9">
              <input type="text" name="mpn" value="<?php echo $mpn; ?>" placeholder="<?php echo $entry_mpn; ?>" id="input-mpn" class="form-control" />
            </div>
          </div>
           <?php } ?>
          <?php if(isset($mp_allowproductcolumn['location'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-location"><?php echo $entry_location; ?></label>
            <div class="col-sm-9">
              <input type="text" name="location" value="<?php echo $location; ?>" placeholder="<?php echo $entry_location; ?>" id="input-location" class="form-control" />
               <input type="hidden" name="prevPrice" value="<?php echo $price; ?>" />
            </div>
          </div>
           <?php } ?>
          <?php if(isset($mp_allowproductcolumn['price'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-price"><?php echo $entry_price; ?></label>
            <div class="col-sm-9">
              <input type="text" name="price" value="<?php echo $price; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />
              <input type="hidden" name="prevPrice" value="<?php echo $price; ?>" />
            </div>
          </div>
           <?php } ?>
            <!-- membership codes starts here -->
            <?php if($wk_seller_group_status) { ?>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="input-expiring-date"><?php echo $entry_expiring_date; ?></label>
              <div class="col-sm-9">
                <input type="text" name="price" value="<?php echo $expiry_date; ?>" placeholder="<?php echo $entry_expiring_date; ?>" id="input-expiring-date" class="form-control" disabled/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="input-expiring-date"><?php echo $entry_relist_duration; ?></label>
              <div class="col-sm-9">
                <select name="relist_duration" class="form-control" id="input-relist-duration">
                  
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="input-auto-relist"><?php echo $entry_auto_relist; ?></label>
              <div class="col-sm-9">
                <div class="checkbox">
                  <label for="input-auto-relist">
                    <input type="checkbox" name="auto_relist" id="input-auto-relist">
                    <?php echo $entry_auto_relist_lable; ?>
                  </label>
                </div>
              </div>
            </div>
           <?php } ?>
            <!-- membership codes ends here -->
          <?php if(isset($mp_allowproductcolumn['tax_class_id'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>
            <div class="col-sm-9">
              <select name="tax_class_id" id="input-tax-class" class="form-control">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($tax_classes as $tax_class) { ?>
                <?php if ($tax_class['tax_class_id'] == $tax_class_id) { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
           <?php } ?>
          <?php if(isset($mp_allowproductcolumn['quantity'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
            <div class="col-sm-9">
              <input type="text" name="quantity" value="<?php echo $quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity" class="form-control" />
  
               <!-- Membership code -->
              <?php if(isset($wk_seller_group_status) && isset($marketplace_account_menu_sequence) && array_key_exists('membership', $marketplace_account_menu_sequence)) {  ?>
                <input type="hidden" name="prevQuantity" id="prevQuantity" value="<?php echo $quantity; ?>"/>  
                <a href="#myModalanswer" id="showerror" role="button" class="hide tfbutton tfbuttonborder asub" data-toggle="modal"></a>
              <?php } ?>
              <!--  -->
            </div>
          </div>
           <?php } ?>
          <?php if(isset($mp_allowproductcolumn['minimum'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-minimum"><span data-toggle="tooltip" title="<?php echo $help_minimum; ?>"><?php echo $entry_minimum; ?></span></label>
            <div class="col-sm-9">
              <input type="text" name="minimum" value="<?php echo $minimum; ?>" placeholder="<?php echo $entry_minimum; ?>" id="input-minimum" class="form-control" />
            </div>
          </div>
           <?php } ?>
          <?php if(isset($mp_allowproductcolumn['subtract'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-subtract"><?php echo $entry_subtract; ?></label>
            <div class="col-sm-9">
              <select name="subtract" id="input-subtract" class="form-control">
                <?php if ($subtract) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
           <?php } ?>

           <?php if(isset($mp_allowproductcolumn['status'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-9">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <?php } ?>

          <?php if(isset($mp_allowproductcolumn['stock_status_id'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-stock-status"><span data-toggle="tooltip" title="<?php echo $help_stock_status; ?>"><?php echo $entry_stock_status; ?></span></label>
            <div class="col-sm-9">
              <select name="stock_status_id" id="input-stock-status" class="form-control">
                <?php foreach ($stock_statuses as $stock_status) { ?>
                <?php if ($stock_status['stock_status_id'] == $stock_status_id) { ?>
                <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <?php } ?>
          <?php if(isset($mp_allowproductcolumn['shipping'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo $entry_shipping; ?></label>
            <div class="col-sm-9">
              <label class="radio-inline">
                <?php if ($shipping) { ?>
                <input type="radio" name="shipping" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="shipping" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if (!$shipping) { ?>
                <input type="radio" name="shipping" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="shipping" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
            </div>
          </div>
           <?php } ?>
          <?php if(isset($mp_allowproductcolumn['keyword'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
            <div class="col-sm-9">
              <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
              <?php if ($error_keyword) { ?>
                <div class="text-danger"><?php echo $error_keyword; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
          <?php if(isset($mp_allowproductcolumn['image'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-keyword"><?php echo $entry_image; ?></label>
            <div class="col-sm-9">
              <?php if(!$thumb){ ?>
                <input type="file" name="image" value="" accept="image/*" class="form-control"/></td>
              <?php }else{ ?>
                <input type="file" name="image" value="" id="1stimg" class="hide" accept="image/*" class="form-control"/>
                <img src="<?php echo $thumb; ?>" class="img-thumbnail click-file"/>
                <input type="hidden" name="image" value="<?php echo $image; ?>" class="form-control"/>
              <?php } ?>                  
            </div>
          </div>
          <?php } ?>               
          <?php if(isset($mp_allowproductcolumn['date_available'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-date-available"><?php echo $entry_date_available; ?></label>
            <div class="col-sm-9">
              <div class="input-group data-date">
                <input type="text" name="date_available" value="<?php echo $date_available; ?>" placeholder="<?php echo $entry_date_available; ?>" data-date-format="YYYY-MM-DD" id="input-date-available" class="form-control" />
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
          </div>
          <?php } ?>
          <?php if(isset($mp_allowproductcolumn['length'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-length"><?php echo $entry_dimension; ?></label>
            <div class="col-sm-9">
              <div class="row">
                <div class="col-sm-4">
                  <input type="text" name="length" value="<?php echo $length; ?>" placeholder="<?php echo $help_length; ?>" id="input-length" class="form-control" />
                </div>
                <div class="col-sm-4">
                  <input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $help_width; ?>" id="input-width" class="form-control" />
                </div>
                <div class="col-sm-4">
                  <input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $help_height; ?>" id="input-height" class="form-control" />
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
          <?php if(isset($mp_allowproductcolumn['length_class_id'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-length-class"><?php echo $entry_length; ?></label>
            <div class="col-sm-9">
              <select name="length_class_id" id="input-length-class" class="form-control">
                <?php foreach ($length_classes as $length_class) { ?>
                <?php if ($length_class['length_class_id'] == $length_class_id) { ?>
                <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <?php } ?>
          <?php if(isset($mp_allowproductcolumn['weight'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-weight"><?php echo $entry_weight; ?></label>
            <div class="col-sm-9">
              <input type="text" name="weight" value="<?php echo $weight; ?>" placeholder="<?php echo $help_weight; ?>" id="input-weight" class="form-control" />
            </div>
          </div>
          <?php } ?>
          <?php if(isset($mp_allowproductcolumn['weight_class_id'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-weight-class"><?php echo $entry_weight_class; ?></label>
            <div class="col-sm-9">
              <select name="weight_class_id" id="input-weight-class" class="form-control">
                <?php foreach ($weight_classes as $weight_class) { ?>
                <?php if ($weight_class['weight_class_id'] == $weight_class_id) { ?>
                <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <?php } ?>

          <?php if(isset($mp_allowproductcolumn['sort_order'])) { ?> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-9">
              <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
          <?php } ?>           

        </div>

        <!-- link tab -->
        <?php if(isset($mp_allowproducttabs['links'])){ ?>
        <input type="hidden" name="product_link_tab" value="1">
        <div class="tab-pane" id="tab-links">         
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-manufacturer"><span data-toggle="tooltip" title="<?php echo $help_manufacturer; ?>"><?php echo $entry_manufacturer; ?></span></label>
            <div class="col-sm-9">
              <input type="text" name="manufacturer" value="<?php echo $manufacturer ?>" placeholder="<?php echo $entry_manufacturer; ?>" id="input-manufacturer" class="form-control" />
              <input type="hidden" name="manufacturer_id" value="<?php echo $manufacturer_id; ?>" />
            </div>
          </div>         
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
            <div class="col-sm-9">
              <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
              <div id="product-category" class="well well-sm" style="height: 150px; overflow: auto;">               
                <?php foreach ($product_categories as $product_category) { ?>
                <div id="product-category<?php echo $product_category['category_id']; ?>" ><i class="fa fa-minus-circle "></i><?php echo $product_category['name']; ?>
                  <input type="hidden" name="product_category[]" value="<?php echo $product_category['category_id']; ?>" />
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-filter"><span data-toggle="tooltip" title="<?php echo $help_filter; ?>"><?php echo $entry_filter; ?></span></label>
            <div class="col-sm-9">
              <input type="text" name="filter" value="" placeholder="<?php echo $entry_filter; ?>" id="input-filter" class="form-control" />
              <div id="product-filter" class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($product_filters as $product_filter) { ?>
                <div id="product-filter<?php echo $product_filter['filter_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_filter['name']; ?>
                  <input type="hidden" name="product_filter[]" value="<?php echo $product_filter['filter_id']; ?>" />
                </div>
                <?php } ?>
              </div>
            </div>
          </div> 
         <?php if (isset($marketplace_seller_product_store) && $marketplace_seller_product_store && $marketplace_seller_product_store == 'choose_store') {?>
         <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo $entry_store; ?></label>
              <div class="col-sm-9">
                <div class="well well-sm" style="height: 150px; overflow: auto;">
                  <div class="checkbox">
                    <label>
                      <?php if (in_array(0, $product_store)) { ?>
                      <input type="checkbox" name="product_store[]" value="0" checked="checked" />
                      <?php echo $text_default; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="product_store[]" value="0" />
                      <?php echo $text_default; ?>
                      <?php } ?>
                    </label>
                  </div>
                  <?php foreach ($stores as $store) { ?>
                  <div class="checkbox">
                    <label>
                      <?php if (in_array($store['store_id'], $product_store)) { ?>
                      <input type="checkbox" name="product_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                      <?php echo $store['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="product_store[]" value="<?php echo $store['store_id']; ?>" />
                      <?php echo $store['name']; ?>
                      <?php } ?>
                    </label>
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
           <?php } ?>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-download"><span data-toggle="tooltip" title="<?php echo $help_download; ?>"><?php echo $entry_download; ?></span></label>
            <div class="col-sm-9">
              <input type="text" name="download" value="" placeholder="<?php echo $entry_download; ?>" id="input-download" class="form-control" />
              <div id="product-download" class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($product_downloads as $product_download) { ?>
                <div id="product-download<?php echo $product_download['download_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_download['name']; ?>
                  <input type="hidden" name="product_download[]" value="<?php echo $product_download['download_id']; ?>" />
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-related"><span data-toggle="tooltip" title="<?php echo $help_related; ?>"><?php echo $entry_related; ?></span></label>
            <div class="col-sm-9">
              <input type="text" name="related" value="" placeholder="<?php echo $entry_related; ?>" id="input-related" class="form-control" />
              <div id="product-related" class="well well-sm" style="height: 150px; overflow: auto;">
                <?php $class = 'odd'; ?>
                <?php foreach ($product_relateds as $product_related) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div id="product-related<?php echo $product_related['product_id']; ?>" class="<?php echo $class; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_related['name']; ?>
                  <input type="hidden" name="product_related[]" value="<?php echo $product_related['product_id']; ?>" />
                </div>
                <?php } ?>
              </div>
            </div>
          </div>     
           
        </div>
        <?php } ?>

        <!-- attribute tab -->
        <?php if(isset($mp_allowproducttabs['attribute'])){ ?>
        <input type="hidden" name="product_attribute_tab" value="1">
        <div class="tab-pane" id="tab-attribute">
          <div class="table-responsive">
            <table id="attribute" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php echo $entry_attribute; ?></td>
                  <td class="text-left"><?php echo $entry_text; ?></td>
                  <td></td>
                </tr>
              </thead>

              <?php $attribute_row = 0; ?>
              <?php foreach ($product_attributes as $product_attribute) { ?>
                <tbody id="attribute-row<?php echo $attribute_row; ?>">
                  <tr>
                    <td class="text-left">
                      <input type="text" name="product_attribute[<?php echo $attribute_row; ?>][name]" value="<?php echo $product_attribute['name']; ?>" placeholder="<?php echo $entry_attribute; ?>" class="form-control"  />
                      <input type="hidden" name="product_attribute[<?php echo $attribute_row; ?>][attribute_id]" value="<?php echo $product_attribute['attribute_id']; ?>" />
                    </td>
                    <td class="text-left">
                      <?php foreach ($languages as $language) { ?>
                      <div class="input-group">
                      <span class="input-group-addon">
                        <img src="thebugmanage/view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                      </span>
                      <textarea name="product_attribute[<?php echo $attribute_row; ?>][product_attribute_description][<?php echo $language['language_id']; ?>][text]" cols="40" rows="5" class="form-control"><?php echo isset($product_attribute['product_attribute_description'][$language['language_id']]) ? $product_attribute['product_attribute_description'][$language['language_id']]['text'] : ''; ?></textarea>
                    </div>                     
                      <?php } ?>
                    </td>
                    <td class="text-left">
                      <button type="button" onclick="$('#attribute-row<?php echo $attribute_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                    </td>
                  </tr>
                </tbody>
              <?php $attribute_row++; ?>
              <?php } ?>
              <tfoot>
                <tr>
                  <td colspan="2"></td>
                  <td class="text-left">
                    <button type="button" onclick="addAttribute();" data-toggle="tooltip" title="<?php echo $button_add_attribute; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div><!--table-responsive-->
        </div>
        <?php } ?>

        <!-- option tab -->
        <?php if(isset($mp_allowproducttabs['options'])){ ?>
        <input type="hidden" name="product_option_tab" value="1">
        <div class="tab-pane" id="tab-option">
          <div class="row">
            <div class="col-sm-3">
              <ul class="nav nav-pills nav-stacked" id="option">
                <?php $option_row = 0; ?>
                <?php foreach ($product_options as $product_option) { ?>

                <li><a href="#tab-option<?php echo $option_row; ?>" data-toggle="tab" id="option<?php echo $option_row; ?>"><i class="fa fa-minus-circle" onclick="$('a[href=\'#tab-option<?php echo $option_row; ?>\']').parent().remove(); $('#tab-option<?php echo $option_row; ?>').remove(); $('#option a:first').tab('show');"></i> <?php echo $product_option['name']; ?></a></li>
                <?php $option_row++; ?>
                <?php } ?>
                <li>
                  <input type="text" name="option" value="" placeholder="<?php echo $button_add_option; ?>" id="input-option" class="form-control" />                                     
                </li>
              </ul>
            </div>
            <div class="col-sm-9">
              <div class="tab-content">
                <?php $option_row = 0; ?>
                <?php $option_value_row = 0;?>
                <?php foreach ($product_options as $product_option) { ?>
                <div class="tab-pane" id="tab-option<?php echo $option_row; ?>">
                  <input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_id]" value="<?php echo $product_option['product_option_id']; ?>" />
                  <input type="hidden" name="product_option[<?php echo $option_row; ?>][name]" value="<?php echo $product_option['name']; ?>" />
                  <input type="hidden" name="product_option[<?php echo $option_row; ?>][option_id]" value="<?php echo $product_option['option_id']; ?>" />
                  <input type="hidden" name="product_option[<?php echo $option_row; ?>][type]" value="<?php echo $product_option['type']; ?>" />
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="input-required<?php echo $option_row; ?>"><?php echo $entry_required; ?></label>
                    <div class="col-sm-9">
                      <select name="product_option[<?php echo $option_row; ?>][required]" id="input-required<?php echo $option_row; ?>" class="form-control">
                        <?php if ($product_option['required']) { ?>
                        <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                        <option value="0"><?php echo $text_no; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_yes; ?></option>
                        <option value="0" selected="selected"><?php echo $text_no; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                     <?php if ($product_option['type'] == 'text') { ?>
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                    <div class="col-sm-9">
                      <input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php } ?>
                  <?php if ($product_option['type'] == 'textarea') { ?>
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                    <div class="col-sm-9">
                      <textarea name="product_option[<?php echo $option_row; ?>][option_value]" rows="5" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control"><?php echo $product_option['option_value']; ?></textarea>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if ($product_option['type'] == 'file') { ?>
                  <div class="form-group" style="display: none;">
                    <label class="col-sm-3 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                    <div class="col-sm-9">
                      <input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control" />
                    </div>
                  </div>
                  <?php } ?>
                  <?php if ($product_option['type'] == 'date') { ?>
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                    <div class="col-sm-3">
                      <div class="input-group date">
                        <input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD" id="input-value<?php echo $option_row; ?>" class="form-control" />
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                        </span></div>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if ($product_option['type'] == 'time') { ?>
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                    <div class="col-sm-9">
                      <div class="input-group time">
                        <input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="HH:mm" id="input-value<?php echo $option_row; ?>" class="form-control" />
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                        </span></div>
                    </div>
                  </div>
                  <?php } ?>
                   <?php if ($product_option['type'] == 'datetime') { ?>
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                    <div class="col-sm-9">
                      <div class="input-group datetime">
                        <input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-value<?php echo $option_row; ?>" class="form-control" />
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                        </span></div>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') { ?>
                  <div class="table-responsive">
                    <table id="option-value<?php echo $option_row; ?>" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <td class="text-left"><?php echo $entry_option_value; ?></td>
                          <td class="text-right"><?php echo $entry_quantity; ?></td>
                          <td class="text-left"><?php echo $entry_subtract; ?></td>
                          <td class="text-right"><?php echo $entry_price; ?></td>
                          <td class="text-right"><?php echo $entry_option_points; ?></td>
                          <td class="text-right"><?php echo $entry_weight; ?></td>
                          <td></td>
                        </tr>
                      </thead>
                      <?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
                      <tbody id="option-value-row<?php echo $option_value_row; ?>">                          
                        <tr>
                        <td class="text-left"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][option_value_id]" class="form-control">
                              <?php if (isset($option_values[$product_option['option_id']])) { ?>
                                <?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
                                <?php if ($option_value['option_value_id'] == $product_option_value['option_value_id']) { ?>
                               <option value="<?php echo $option_value['option_value_id']; ?>" selected="selected"><?php echo $option_value['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                                <?php } ?>
                            </select>
                             <input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][product_option_value_id]" value="<?php echo $product_option_value['product_option_value_id']; ?>" /></td>
                        <td class="text-right"><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][quantity]" value="<?php echo $product_option_value['quantity']; ?>" class="form-control"/></td>
                        <td class="text-left"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]" class="form-control">
                                <?php if ($product_option_value['subtract']) { ?>
                                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                <option value="0"><?php echo $text_no; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_yes; ?></option>
                                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                <?php } ?>
                              </select></td>
                        <td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price_prefix]" class="form-control">
                            <?php if ($product_option_value['price_prefix'] == '+') { ?>
                            <option value="+" selected="selected">+</option>
                            <?php } else { ?>
                            <option value="+">+</option>
                            <?php } ?>
                            <?php if ($product_option_value['price_prefix'] == '-') { ?>
                            <option value="-" selected="selected">-</option>
                            <?php } else { ?>
                            <option value="-">-</option>
                            <?php } ?>
                          </select>

                          <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price]" value="<?php echo $product_option_value['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
                        <td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points_prefix]" class="form-control">
                            <?php if ($product_option_value['points_prefix'] == '+') { ?>
                            <option value="+" selected="selected">+</option>
                            <?php } else { ?>
                            <option value="+">+</option>
                            <?php } ?>
                            <?php if ($product_option_value['points_prefix'] == '-') { ?>
                            <option value="-" selected="selected">-</option>
                            <?php } else { ?>
                            <option value="-">-</option>
                            <?php } ?>
                          </select>
                          <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points]" value="<?php echo $product_option_value['points']; ?>" placeholder="<?php echo $entry_points; ?>" class="form-control"  /></td>
                        <td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight_prefix]" class="form-control">
                            <?php if ($product_option_value['weight_prefix'] == '+') { ?>
                            <option value="+" selected="selected">+</option>
                            <?php } else { ?>
                            <option value="+">+</option>
                            <?php } ?>
                            <?php if ($product_option_value['weight_prefix'] == '-') { ?>
                            <option value="-" selected="selected">-</option>
                            <?php } else { ?>
                            <option value="-">-</option>
                            <?php } ?>
                          </select>
                          <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight]" value="<?php echo $product_option_value['weight']; ?>" placeholder="<?php echo $entry_weight; ?>" class="form-control"  /></td>
                        <td class="text-left">                             
                          <button type="button" onclick="$('#option-value-row<?php echo $option_value_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                        </td>
                      </tr>
                    </tbody>
                    <?php $option_value_row++; ?>
                    <?php } ?>
                    <tfoot>
                        <tr>
                          <td colspan="6"></td>
                          <td class="text-left">
                            <button type="button" onclick="addOptionValue('<?php echo $option_row; ?>');" data-toggle="tooltip" title="<?php echo $button_add_option_value; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                          </td>
                        </tr>
                      </tfoot>
                      </table>
                    </div>
                      <select id="option-values<?php echo $option_row; ?>" style="display: none;">
                        <?php if (isset($option_values[$product_option['option_id']])) { ?>
                        <?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
                        <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                      <?php } ?>
                      </div><!--tab-pane-->
                    <?php $option_row++; ?>
                    <?php } ?>                        
              </div><!--tab-content-->
            </div><!--col-sm-9-->
          </div><!--Row-->
        </div>
        <?php } ?>

        <!-- discount tab -->        
        <?php if(isset($mp_allowproducttabs['discount'])){ ?>
        <input type="hidden" name="product_discount_tab" value="1">
        <div class="tab-pane" id="tab-discount">
          <div class="table-responsive">
            <table id="discount" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php echo $entry_customer_group; ?></td>
                  <td class="text-right"><?php echo $entry_quantity; ?></td>
                  <td class="text-right" style="min-width:70px"><?php echo $entry_priority; ?></td>
                  <td class="text-right" style="min-width:80px"><?php echo $entry_price; ?></td>
                  <td class="text-left"><?php echo $entry_date_start; ?></td>
                  <td class="text-left"><?php echo $entry_date_end; ?></td>
                  <td></td>              
                </tr>
              </thead>             
              <?php $discount_row = 0; ?>
              <?php foreach ($product_discounts as $product_discount) { ?>
              <tbody id="discount-row<?php echo $discount_row; ?>">
              <tr>
                <td class="text-left"><select name="product_discount[<?php echo $discount_row; ?>][customer_group_id]" class="form-control">
                    <?php foreach ($customer_groups as $customer_group) { ?>
                    <?php if ($customer_group['customer_group_id'] == $product_discount['customer_group_id']) { ?>
                    <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
                <td class="text-right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][quantity]" value="<?php echo $product_discount['quantity']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>
                <td class="text-right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][priority]" value="<?php echo $product_discount['priority']; ?>" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>
                <td class="text-right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][price]" value="<?php echo $product_discount['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
                <td class="text-left"><div class="input-group date">
                    <input type="text" name="product_discount[<?php echo $discount_row; ?>][date_start]" value="<?php echo $product_discount['date_start']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                    </span></div></td>
                <td class="text-left"><div class="input-group date">
                    <input type="text" name="product_discount[<?php echo $discount_row; ?>][date_end]" value="<?php echo $product_discount['date_end']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                    </span></div></td>
                <td class="text-left"><button type="button" onclick="$('#discount-row<?php echo $discount_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
              </tr>
              </tbody>
              <?php $discount_row++; ?>
              <?php } ?>
              <tfoot>
                <tr>
                  <td colspan="6"></td>
                  <td class="text-left"><button type="button" onclick="addDiscount();" data-toggle="tooltip" title="<?php echo $button_add_discount; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                </tr>
              </tfoot>            
            </table>
          </div>
        </div><!--tab-discount-->
        <?php } ?>

        <!--tab-special-->
        <?php if(isset($mp_allowproducttabs['special'])){ ?>
        <input type="hidden" name="product_special_tab" value="1">
        <div class="tab-pane" id="tab-special">
          <div class="table-responsive">
            <table id="special" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php echo $entry_customer_group; ?></td>
                  <td class="text-right" style="min-width:70px"><?php echo $entry_priority; ?></td>
                  <td class="text-right" style="min-width:80px"><?php echo $entry_price; ?></td>
                  <td class="text-left"><?php echo $entry_date_start; ?></td>
                  <td class="text-left"><?php echo $entry_date_end; ?></td>
                  <td></td>
                </tr>
              </thead>                  
                <?php $special_row = 0; ?>
                <?php foreach ($product_specials as $product_special) { ?>
                <tbody id="special-row<?php echo $special_row; ?>">
                <tr>
                  <td class="text-left"><select name="product_special[<?php echo $special_row; ?>][customer_group_id]" class="form-control">
                      <?php foreach ($customer_groups as $customer_group) { ?>
                      <?php if ($customer_group['customer_group_id'] == $product_special['customer_group_id']) { ?>
                      <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select></td>
                  <td class="text-right"><input type="text" name="product_special[<?php echo $special_row; ?>][priority]" value="<?php echo $product_special['priority']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>
                  <td class="text-right"><input type="text" name="product_special[<?php echo $special_row; ?>][price]" value="<?php echo $product_special['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
                  <td class="text-left"><div class="input-group date">
                      <input type="text" name="product_special[<?php echo $special_row; ?>][date_start]" value="<?php echo $product_special['date_start']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                      <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                      </span></div></td>
                  <td class="text-left"><div class="input-group date">
                      <input type="text" name="product_special[<?php echo $special_row; ?>][date_end]" value="<?php echo $product_special['date_end']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                      <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                      </span></div></td>
                  <td class="text-left"><button type="button" onclick="$('#special-row<?php echo $special_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                </tr>
              </tbody>
              <?php $special_row++; ?>
              <?php } ?>
              <tfoot>
                <tr>
                  <td colspan="5"></td>
                  <td class="text-left"><button type="button" onclick="addSpecial();" data-toggle="tooltip" title="<?php echo $button_add_special; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div><!--tab-special-->
        <?php } ?>    

        <!--tab-image-->
        <?php $image_row = 0; ?>
        <?php if(isset($mp_allowproductcolumn['image'])) { ?>
        <div class="tab-pane" id="tab-image">
          <div class="table-responsive">
            <table id="images" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php echo $entry_image; ?></td>
                  <td class="text-right"><?php echo $entry_sort_order; ?></td>
                  <td></td>
                </tr>
              </thead>
              <?php foreach ($product_images as $product_image) { ?>
              <tbody id="image-row<?php echo $image_row; ?>">

                <tr>
                  <td class="text-left">
                    <input type="file" class="hide" name="product_image[<?php echo $image_row; ?>][image]">
                    <img src="<?php echo $product_image['thumb'] ? $product_image['thumb'] : $placeholder; ?>" data-placeholder="<?php echo $placeholder; ?>" class="img-thumbnail click-file" />
                    <input type="hidden" name="product_image[<?php echo $image_row; ?>][image]" value="<?php echo $product_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>

                  <td class="text-right"><input type="text" name="product_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $product_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                  <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                </tr>         

                
               </tbody>
              <?php $image_row++; ?>
              <?php } ?>
              <tfoot>
                <tr>
                  <td colspan="2"></td>
                  <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_add_image; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>                    
                </tr>
              </tfoot>
            </table>
          </div>
        </div><!--tab-image-->    
        <?php } ?>    

        <?php if(isset($mp_allowproducttabs['custome-field'])) { ?>
        <div id="tab-custom-field" class="tab-pane">
          <div class="row">
            <div class="col-sm-3">
              <ul class="nav nav-pills nav-stacked" id="vtab-option">
                  <?php  $tabCount = 0; $wkcustom_option_row = 0;?>
                    <?php if(!empty($wkPreCustomFields)) { ?>
                      <?php foreach($wkPreCustomFields as $tabs) { ?>
                        <li>
                          <a href="#wktab-option-<?php echo $tabCount; ?>" data-toggle="tab" id="wkoption-<?php echo $tabCount; ?>" field-id = "wkoption-<?php echo $tabs['fieldId'];?>"><i class="fa fa-minus-circle" onclick="$('#wkoption-<?php echo $tabCount; ?>').remove(); $('#wktab-option-<?php echo $tabCount; ?>').remove(); $('#vtab-option li a:first').trigger('click'); return false;"></i><?php echo $tabs["fieldName"]; ?></a>
                        </li>
                      <?php $tabCount++; ?>
                    <?php } ?>
                  <?php } ?>
                  <li id="optionSelector">
                    <select name="wkcustomfield" class="form-control">
                      <?php if(!empty($wkcustomFields)){ ?>
                        <option value=""></option>
                          <?php  foreach($wkcustomFields as $field) { ?>
                            <option value="<?php echo $field['id']; ?>" data-type = "<?php echo $field['fieldType']; ?>" data-name="<?php echo $field['fieldName']; ?>" data-des="<?php echo $field['fieldDescription']; ?>" title="<?php echo $field['fieldDescription']; ?>" data-isRequired = "<?php echo $field['isRequired']; ?>">
                              <?php echo $field['fieldName']; ?>
                            </option>
                          <?php 
                          } 
                        }
                      ?>
                    </select>
                  </li>  
              </ul>
            </div>
            <div class="col-sm-9">
              <div class="tab-content" id="wk_customfieldcontent">
                <?php  $tabCount = 0; $wkcustom_option_row = 0;
                  if(!empty($wkPreCustomFields)) { 
                    foreach($wkPreCustomFields as $tabs) { ?>
                      <div id="wktab-option-<?php echo $tabCount; ?>" class="tab-pane">
                        <div class="alert alert-info">
                          <i class="fa fa-info-circle"></i>
                          <?php  echo $tabs['fieldDes']; ?>
                        </div>
                        <?php if(isset($error) && $error == $tabs['fieldId']) { ?>
                            <div class="alert alert-danger">
                              <i class="fa fa-exclamation-circle"></i>
                              <?php echo $error_warning_mandetory; ?>
                            </div>
                        <?php } ?>
                        <input type="hidden" name="product_custom_field[<?php echo $wkcustom_option_row; ?>][custom_field_name]" value="<?php echo $tabs['fieldName']; ?>">
                        <input type="hidden" name="product_custom_field[<?php echo $wkcustom_option_row; ?>][custom_field_type]" value="<?php echo $tabs['fieldType']; ?>">
                        <input type="hidden" name="product_custom_field[<?php echo $wkcustom_option_row; ?>][custom_field_id]" value="<?php echo $tabs['fieldId']; ?>">
                        <input type="hidden" name="product_custom_field[<?php echo $wkcustom_option_row; ?>][custom_field_des]" value="<?php echo $tabs['fieldDes']; ?>">
                            <?php if($tabs['fieldType'] == 'select') { ?>
                              <div class="form-group <?php if($tabs['isRequired'] == 'yes') echo 'required'; ?>">
                                <label class="col-sm-3 control-label">Select option:</label>
                                <div class="col-sm-9">
                                  <select class="form-control" name="product_custom_field[<?php echo $wkcustom_option_row; ?>][custom_field_value][]" >
                                    <?php  foreach($tabs['preFieldOptions'] as $options) { ?>
                                      <option value="<?php echo $options['optionId']; ?>" <?php if(!empty($tabs['fieldOptions'])) { foreach($tabs['fieldOptions'] as $option) { if($option['optionId'] == $options['optionId']) echo "selected"; } } ?> >
                                        <?php echo $options['optionValue']; ?>
                                      </option>
                                    <?php
                                    }  ?>
                                  </select>
                                </div>
                               </div>
                              <?php 
                              
                              }else if($tabs['fieldType'] == 'checkbox' || $tabs['fieldType'] == 'radio' ) { ?>
                                <div class="form-group  <?php if($tabs['isRequired'] == 'yes') echo 'required'; ?>">
                                <label class="control-label col-sm-3">Select option:</label>
                                <div class="col-sm-9">
                              <?php  foreach($tabs['preFieldOptions'] as $options) { ?>
                                
                                  <div class="radio checkbox">
                                    <label for="<?php echo $wkcustom_option_row.$options['optionId']; ?>">
                                      <input type='<?php echo $tabs['fieldType']; ?>' id="<?php echo $wkcustom_option_row.$options['optionId']; ?>" value="<?php echo $options['optionId']; ?>" name="product_custom_field[<?php echo $wkcustom_option_row; ?>][custom_field_value][]" <?php if(!empty($tabs['fieldOptions'])) { foreach($tabs['fieldOptions'] as $option) { if($option['optionId'] == $options['optionId']) echo "checked"; } } ?> />
                                      <?php echo $options['optionValue']; ?>
                                    </label>
                                  </div>
                               
                              <?php }  ?>
                               </div>
                              </div>
                              <?php }else if($tabs['fieldType'] == 'text') { ?>
                                <div class="form-group <?php if($tabs['isRequired'] == 'yes') echo 'required'; ?>">
                                  <label class="col-sm-3 control-label">Enter Text:</label>
                                  <div class="col-sm-9">
                                    <input class="form-control" type="text" name="product_custom_field[<?php echo $wkcustom_option_row; ?>][custom_field_value][]" value="<?php if(isset($tabs['fieldOptions']['option_id'])) echo $tabs['fieldOptions']['option_id']; ?>" />
                                  </div>
                                </div>
                                <?php
                                }else if($tabs['fieldType'] == 'textarea') { ?>
                                  <div class="form-group <?php if($tabs['isRequired'] == 'yes') echo 'required'; ?>">
                                    <label class="col-sm-3 control-label">Enter Text:</label>
                                    <div class="col-sm-9">
                                      <textarea class="form-control" name="product_custom_field[<?php echo $wkcustom_option_row; ?>][custom_field_value][]" rows="7" >
                                      <?php if(isset($tabs['fieldOptions']['option_id'])) echo $tabs['fieldOptions']['option_id']; ?>
                                    </textarea>
                                    </div>
                                  </div>
                                <?php
                                }else if($tabs['fieldType'] == 'date') { ?>
                                  <div class="form-group <?php if($tabs['isRequired'] == 'yes') echo 'required'; ?>">
                                    <label class="col-sm-3 control-label">Select Date:</label>
                                    <div class="col-sm-6">
                                      <div class="input-group date">
                                        <input type="text" name="product_custom_field[<?php echo $wkcustom_option_row; ?>][custom_field_value][]" value="<?php if(isset($tabs['fieldOptions']['option_id'])) echo $tabs['fieldOptions']['option_id']; ?>" class="form-control">
                                        <span class="input-group-btn">
                                          <button type="button" class="btn btn-default">
                                            <i class="fa fa-calendar"></i>
                                          </button>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                <?php
                                }else if($tabs['fieldType'] == 'time') { ?>
                                  <div class="form-group <?php if($tabs['isRequired'] == 'yes') echo 'required'; ?>">
                                    <label class="col-sm-3 control-label">Enter Text:</label>
                                    <div class="col-sm-6">
                                      <div class="input-group time">
                                         <input class="form-control" type="text" name="product_custom_field[<?php echo $wkcustom_option_row; ?>][custom_field_value][]" value="<?php if(isset($tabs['fieldOptions']['option_id'])) echo $tabs['fieldOptions']['option_id']; ?>" >
                                        <span class="input-group-btn">
                                          <button type="button" class="btn btn-default">
                                            <i class="fa fa-clock-o"></i>
                                          </button>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                  <?php
                                  }else if($tabs['fieldType'] == 'datetime') { ?>
                                    <div class="form-group  <?php if($tabs['isRequired'] == 'yes') echo 'required'; ?>">
                                      <label class="col-sm-3 control-label">Select date-time:</label>
                                      <div class="col-sm-6">
                                        <div class="input-group datetime">
                                          <input type="text" name="product_custom_field[<?php echo $wkcustom_option_row; ?>][custom_field_value][]" value="<?php if(isset($tabs['fieldOptions']['option_id'])) echo $tabs['fieldOptions']['option_id']; ?>" class="form-control">
                                          <span class="input-group-btn">
                                            <button type="button" class="btn btn-default">
                                              <i class="fa fa-clock-o"></i>
                                            </button>
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  <?php
                                  } ?>
                            </div>
                          <?php $tabCount++; $wkcustom_option_row++; 
                        } 
                      } ?>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div><!--tab-content-->
    </form>   
  
</div>  <!--content-->
<?php echo $column_right; ?></div>   <!--row-->
</div>  <!--container-->

<!-- script custom field -->

 <!-- membership codes starts here -->
<script type="text/javascript">
<?php if(isset($wk_seller_group_status) && $wk_seller_group_status) { ?>
  listing_duration = 0;
  <?php if(isset($relist_duration) && $relist_duration) { ?>
    listing_duration = <?php echo $relist_duration; ?>;
  <?php } ?>
  var count = 0;
    function getListingDuration(gld_category_id) {
      $.ajax({
        url: 'index.php?route=account/customerpartner/wk_membership_catalog/getListingDuration',
        data: {category_id: gld_category_id},
        type: 'post',
        methodType: 'json',
        success: function(data) {
          console.log(data);
          $('#alert-danger').remove();
          $('#alert-info').remove();
          html = '';
          if(data) {
            for (var i = 1; i <= data; i++) {
              html += '<option value="'+i+'"';
              if(listing_duration == i) {
                html += ' selected ';
              }
              html += '>'+i+' day(s)</option>';
            };
            $('#input-relist-duration').html(html);
            if(count != 0) {
              $('.breadcrumb').after('<div class="alert alert-info" id="alert-info"><i class="fa fa-info-circle"></i> Listing duration has been refreshed as per category selection, please check it again.<button class="close" data-dismiss="alert" type="button">×</button></div>');
            } else {
              count++;
            }
          } else {
            html += '<option></option>';
            $('#input-relist-duration').html(html);
            $('.breadcrumb').after('<div class="alert alert-danger" id="alert-danger"><i class="fa fa-exclamation-circle"></i> Warning: No more listing duration is available!</div>');
            $('body').animate({
              scrollTop: 0,
            },'slow');
          }
        }
      });
    }
    getListingDuration(0);
<?php } ?>
</script>
 <!-- membership codes ends here -->

<script type="text/javascript">

  $('#vtab-option a:first').tab('show');
    tabCount = '<?php echo $tabCount; ?>';
    wkcustom_option_row = '<?php echo $wkcustom_option_row; ?>';
    $('select[name="wkcustomfield"]').on('change',function(){
      value = $(this).val();
      if(value == ''){
        return;
      }

      if($('body').find('[field-id = wkoption-'+value+']').length){
        return;
      }
    fieldType = $('option:selected', this).attr('data-type');
    fieldName = $('option:selected', this).attr('data-name');
    fieldDes = $('option:selected', this).attr('data-des');
    fieldIsRequired = $('option:selected', this).attr('data-isRequired');
    tab = '<li><a href="#wktab-option-'+tabCount+'" data-toggle="tab" id="wkoption-'+tabCount+'" field-id = "wkoption-'+value+'"><i class="fa fa-minus-circle" onclick="$(\'#wkoption-' + tabCount + '\').remove(); $(\'#wktab-option-' + tabCount + '\').remove(); $(\'#vtab-option a:first\').trigger(\'click\'); return false;" /></i>&nbsp;'+fieldName+'</a></li>';
    $('#optionSelector').before(tab);
    html  = '';
    html += '<input type="hidden" name="product_custom_field['+wkcustom_option_row+'][custom_field_name]" value="'+fieldName+'">';
    html += '<input type="hidden" name="product_custom_field['+wkcustom_option_row+'][custom_field_type]" value="'+fieldType+'">';
    html += '<input type="hidden" name="product_custom_field['+wkcustom_option_row+'][custom_field_id]" value="'+value+'">';
    html += '<input type="hidden" name="product_custom_field['+wkcustom_option_row+'][custom_field_des]" value="'+fieldDes+'">';
    html += '<input type="hidden" name="product_custom_field['+wkcustom_option_row+'][custom_field_is_required]" value="'+fieldIsRequired+'">';
    if(fieldIsRequired == 'yes'){
      required = 'required';
    }else{
      required = '';
    }
    if(fieldType == "textarea"){

      html += '<div class="form-group '+required+' "><label class="col-sm-3 control-label"><?php echo $entry_enter_text; ?></label>';
      html += '<div class="col-sm-9"><textarea class="form-control" id="" value="" name="product_custom_field['+wkcustom_option_row+'][custom_field_value][]" row="7"></textarea></div></div>';
      addtoBody(html);

    }else if(fieldType == "text"){
      
      html += '<div class="form-group '+required+'"><label class="col-sm-3 control-label"><?php echo $entry_enter_text; ?></label>';
      html += '<div class="col-sm-9"><input type="text" class="form-control" name="product_custom_field['+wkcustom_option_row+'][custom_field_value][]" /></div></div>';
      addtoBody(html);

    }else if(fieldType == "time"){
      
      html += '<div class="form-group '+required+'"><label class="col-sm-3 control-label"><?php echo $entry_select_time; ?></label>';
      html += '<div class="col-sm-6"><div class="input-group time"><input type="text" name="product_custom_field['+wkcustom_option_row+'][custom_field_value][]" class="form-control" /><span class="input-group-btn"><button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button</span></div</div></div>';

      addtoBody(html);   

    }else if(fieldType == "datetime"){

      html += '<div class="form-group '+required+'"><label class="col-sm-3 control-label"><?php echo $entry_select_datetime; ?></label>';
      html += '<div class="col-sm-6"><div class="input-group datetime"><input type="text" name="product_custom_field['+wkcustom_option_row+'][custom_field_value][]" class="form-control" /><span class="input-group-btn"><button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button</span></div</div></div>';
      
      addtoBody(html);  

    }else if(fieldType == "date"){

      html += '<div class="form-group '+required+'">';
      html += '<label class="col-sm-3 control-label"><?php echo $entry_select_date; ?></label>';
      html += '<div class="col-sm-6"><div class="input-group date">';
      html += '<input type="text" name="product_custom_field[<?php echo $wkcustom_option_row; ?>][custom_field_value][]" class="form-control">';
      html += '<span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div></div>';

      addtoBody(html); 
      
    }else{
      $.ajax({        
        url:'index.php?route=account/customerpartner/addproduct/getOptions',
        data:'&value='+value,
        dataType:'json',
        type:'post',
        success:function(data){
          innerHtml = '';
          if(fieldType == "select"){
            html += '<div class="form-group '+required+'"><label class="col-sm-3 control-label">Options</label><div class="col-sm-9" >';
          }else{
            html += '<div class="form-group '+required+'"><label class="control-label">Options</label><div>';
          }
          $.each(data, function(key,val){
            if(fieldType == "select"){
              innerHtml += '<option value="' + val.optionId +'">' + val.optionValue + '</option>'
            }else if(fieldType == "checkbox"){
            
              html += '<div class="radio checkbox"><label for="'+ wkcustom_option_row + val.optionId +'"><input type='+fieldType+' id="'+ wkcustom_option_row + val.optionId +'" value="'+val.optionId+'" name="product_custom_field['+wkcustom_option_row+'][custom_field_value][]">'+val.optionValue+'</lable></div>';
             
            }else{
              
              html += '<div class="radio checkbox"><label for="'+ wkcustom_option_row + val.optionId +'"><input type='+fieldType+' id="'+ wkcustom_option_row + val.optionId +'" value="'+val.optionId+'" value="'+val.optionId+'" name="product_custom_field['+wkcustom_option_row+'][custom_field_value][]">'+val.optionValue+'</lable></div>';

            }
          });
          if(fieldType == "select") {
            html += '<select class="form-control" name="product_custom_field['+wkcustom_option_row+'][custom_field_value][]">'+innerHtml+'</select>';
          }
          addtoBody(html);
        }
      })
    }
  });

  function addtoBody(html){
    html = '<div id="wktab-option-'+tabCount+'" class="tab-pane"><div class="alert alert-info"><i class="fa fa-info-circle"></i> ' + fieldDes + '</div>' + html + '</div></div></div>';
    $('#wk_customfieldcontent').append(html);
    $('#wkoption-' + tabCount).trigger('click');
    tabCount++;
    wkcustom_option_row++;

    $('.date').datetimepicker({
      pickTime: false
    });

    $('.time').datetimepicker({
      pickDate: false
    });

    $('.datetime').datetimepicker({
      pickDate: true,
      pickTime: true
    });
  }
  $('.date').datetimepicker({
    pickTime: false
  });

  $('.time').datetimepicker({
    pickDate: false
  });

  $('.datetime').datetimepicker({
    pickDate: true,
    pickTime: true
  });
</script>
<!-- script end here -->

<script type="text/javascript"><!--

// Uploading image for summernote
<?php foreach ($languages as $language) { ?>
  $('#input-description<?php echo $language['language_id']; ?>').summernote({
  height: 300,
  onImageUpload: function(files, editor, $editable) {
  sendFile(files[0],editor,$editable);
  },
  });
<?php } ?>

function sendFile(file,editor,welEditable) {
  data = new FormData();
  data.append("file", file);
  $.ajax({
  url: "index.php?route=account/customerpartner/addproduct/uploadSummernoteImage",
  data: data,
  cache: false,
  contentType: false,
  processData: false,
  type: 'POST',
  success: function(data){
    if (data.image) {
      editor.insertImage(welEditable,data.image);
    }else{
       alert(data.error);
    };
  },
  error: function(jqXHR, textStatus, errorThrown) {
  console.log(textStatus+" "+errorThrown);
  }
  });
}
// Uploading image for summernote


$('.data-date').datetimepicker({
    pickTime: false
});

$('.tab-content').on('click','.click-file',function(){
  $(this).prev().trigger('click');  
})

$(function() {
   $("body").on("change","input[type='file']", function() {
    $.this = this;
       var files = !!this.files ? this.files : [];
       if (!files.length || !window.FileReader) return; /* no file selected, or no FileReader support */
       if (/^image/.test( files[0].type)) { /* only image file */
           var reader = new FileReader(); /* instance of the FileReader */
           reader.readAsDataURL(files[0]); /* read the local file */

           reader.onloadend = function() { /* set image to display only */
               src = this.result;
               $($.this).next().attr('src',src);
           }
       }
   });
});

//--></script> 

<?php if(isset($mp_allowproducttabs['links']) && $mp_allowproducttabs['links']) { ?>
<script type="text/javascript"><!--
$('input[name=\'manufacturer\']').click(function() {
  $(this).autocomplete("search");
});
// Manufacturer
$('input[name=\'manufacturer\']').autocomplete({
  minLength: 0,
  delay: 101,    
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=customerpartner/autocomplete/manufacturer&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) { 
        json.unshift({    
          manufacturer_id: 0,   
          name: '<?php echo $text_none; ?>'   
        }); 
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['manufacturer_id']
          }
        }));
      }
    });
  }, 
  select: function(item) {
    $('input[name=\'manufacturer\']').val(item['label']);
    $('input[name=\'manufacturer_id\']').val(item['value']);
  
    return false;
  },
  focus: function(item) {
      return false;
   }
});


$('input[name=\'category\']').click(function(){
  $(this).autocomplete("search");
});

// Category
$('input[name=\'category\']').autocomplete({
  minLength: 0,
  delay: 101,  
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=customerpartner/autocomplete/category&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
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
  select: function(item) {
  // <!-- membership codes starts here -->
     <?php if($wk_seller_group_status && isset($wk_seller_group_single_category) && $wk_seller_group_single_category) { ?>
       $('input[name=\'category\']').val('');
    $('#product-category' + item['value']).remove();
    
    $('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_category[]" value="' + item['value'] + '" /></div>');  

    $('#product-category div:odd').attr('class', 'odd');
    $('#product-category div:even').attr('class', 'even');
      <?php if($wk_seller_group_status) { ?>
        getListingDuration(item['value']);
      <?php } ?>
    <?php } else { ?>
    $('input[name=\'category\']').val('');
    $('#product-category' + item['value']).remove();
    
    $('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_category[]" value="' + item['value'] + '" /></div>');  

    $('#product-category div:odd').attr('class', 'odd');
    $('#product-category div:even').attr('class', 'even');
    <?php } ?>
     //<!-- membership codes ends here -->
        
    return false;
  },
  focus: function(item) {
      return false;
   }
});
$('#product-category').delegate('.fa-minus-circle', 'click', function() {  
  $(this).parent().remove();  
  $('#product-category div:odd').attr('class', 'odd');
  $('#product-category div:even').attr('class', 'even');  
});


$('input[name=\'filter\']').click(function(){
  $(this).autocomplete("search");
});

// Filter
$('input[name=\'filter\']').autocomplete({
  minLength: 0,
  delay: 101,   
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=customerpartner/autocomplete/filter&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['filter_id']
          }
        }));
      }
    });
  }, 
  select: function(item) {
    $('input[name=\'filter\']').val('');
    $('#product-filter' + item['value']).remove();
    
    $('#product-filter').append('<div id="product-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_filter[]" value="' + item['value'] + '" /></div>');

    $('#product-filter div:odd').attr('class', 'odd');
    $('#product-filter div:even').attr('class', 'even');
        
    return false;
  },
  focus: function(item) {
      return false;
   }
});

$('#product-filter').delegate('.fa-minus-circle', 'click', function() {  
  $(this).parent().remove();  
  $('#product-filter div:odd').attr('class', 'odd');
  $('#product-filter div:even').attr('class', 'even');  
});

$('input[name=\'download\']').click(function(){
  $(this).autocomplete("search");
});

// Downloads
$('input[name=\'download\']').autocomplete({
  minLength: 0,
  delay: 101,    
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=customerpartner/autocomplete/download&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) { 
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['download_id']
          }
        }));
      }
    });
  }, 
  select: function(item) {
    $('input[name=\'download\']').val('');
    $('#product-download' + item['value']).remove();
    
    $('#product-download').append('<div id="product-download' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_download[]" value="' + item['value'] + '" /></div>');

    $('#product-download div:odd').attr('class', 'odd');
    $('#product-download div:even').attr('class', 'even');
        
    return false;
  },
  focus: function(item) {
      return false;
   }
});

$('#product-download').delegate('.fa-minus-circle', 'click', function() {  
  $(this).parent().remove();  
  $('#product-download div:odd').attr('class', 'odd');
  $('#product-download div:even').attr('class', 'even');  
}); 

$('input[name=\'related\']').click(function(){
  $(this).autocomplete("search");
});
// Related
$('input[name=\'related\']').autocomplete({
  minLength: 0,
  delay: 101,  
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=customerpartner/autocomplete/product&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['product_id']
          }
        }));
      }
    });
  }, 
  select: function(item) {
    $('input[name=\'related\']').val('');
    $('#product-related' + item['value']).remove();
    
    $('#product-related').append('<div id="product-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_related[]" value="' + item['value'] + '" /></div>');

    $('#product-related div:odd').attr('class', 'odd');
    $('#product-related div:even').attr('class', 'even');
        
    return false;
  },
  focus: function(item) {
      return false;
   }
});

$('#product-related').delegate('.fa-minus-circle', 'click', function() { 
  $(this).parent().remove();  
  $('#product-related div:odd').attr('class', 'odd');
  $('#product-related div:even').attr('class', 'even'); 
});
//--></script> 
<?php } ?>

<?php if(isset($mp_allowproducttabs['attribute']) && $mp_allowproducttabs['attribute']) { ?>
<script type="text/javascript"><!--

var attribute_row = <?php echo $attribute_row; ?>;

function addAttribute() {
  html  = '<tbody id="attribute-row' + attribute_row + '">';
    html += '  <tr>';
  html += '    <td class="text-left"><input type="text" name="product_attribute[' + attribute_row + '][name]" value="" placeholder="<?php echo $entry_attribute; ?>" class="form-control" /><input type="hidden" name="product_attribute[' + attribute_row + '][attribute_id]" value="" /></td>';
  html += '    <td class="text-left">';
  <?php foreach ($languages as $language) { ?>
  html += '<div class="input-group"><span class="input-group-addon"><img src="thebugmanage/view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span><textarea name="product_attribute[' + attribute_row + '][product_attribute_description][<?php echo $language['language_id']; ?>][text]" rows="5" placeholder="<?php echo $entry_text; ?>" class="form-control"></textarea></div> ';
    <?php } ?>
  html += '    </td>';
  html += '    <td class="text-left"><button type="button" onclick="$(\'#attribute-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '  </tr>';  
    html += '</tbody>';
  
  $('#attribute tfoot').before(html);
  
  attributeautocomplete(attribute_row);
  
  $('input[name=\'product_attribute[' + attribute_row + '][name]\']').click(function(){
      $(this).autocomplete("search");
  });

  attribute_row++;
}

function attributeautocomplete(attribute_row) {
  $('input[name=\'product_attribute[' + attribute_row + '][name]\']').autocomplete({
    minLength: 0,
    delay: 101,  
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=customerpartner/autocomplete/attribute&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) { 
          response($.map(json, function(item) {
            return {
              category: item.attribute_group,
              label: item.name,
              value: item.attribute_id
            }
          }));
        }
      });
    }, 
    select: function(item) {
      $('input[name=\'product_attribute[' + attribute_row + '][name]\']').val(item['label']);
      $('input[name=\'product_attribute[' + attribute_row + '][attribute_id]\']').val(item['value']);
      
      return false;
    },
    focus: function(item) {
          return false;
      }
  });
}

$('#attribute tbody').each(function(index, element) {
  attributeautocomplete(index);
});
 //--></script> 
<?php } ?>

<?php if(isset($mp_allowproducttabs['options']) && $mp_allowproducttabs['options']) { ?>
<script type="text/javascript"><!-- 

var option_row = <?php echo $option_row; ?>;

$('input[name=\'option\']').autocomplete({
  minLength: 0,
  delay: 101,  
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=customerpartner/autocomplete/option&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            category: item.category,
            label: item.name,
            value: item.option_id,
            type: item.type,
            option_value: item.option_value
          }
        }));
      }
    });
  }, 
  select: function(item) {    
    html  = '<div class="tab-pane" id="tab-option' + option_row + '">';
    html += ' <input type="hidden" name="product_option[' + option_row + '][product_option_id]" value="" />';
    html += ' <input type="hidden" name="product_option[' + option_row + '][name]" value="' + item['label'] + '" />';
    html += ' <input type="hidden" name="product_option[' + option_row + '][option_id]" value="' + item['value'] + '" />';
    html += ' <input type="hidden" name="product_option[' + option_row + '][type]" value="' + item['type'] + '" />';

    html += ' <div class="form-group">';
    html += '   <label class="col-sm-3 control-label" for="input-required' + option_row + '"><?php echo $entry_required; ?></label>';
    html += '   <div class="col-sm-9"><select name="product_option[' + option_row + '][required]" id="input-required' + option_row + '" class="form-control">';
    html += '       <option value="1"><?php echo $text_yes; ?></option>';
    html += '       <option value="0"><?php echo $text_no; ?></option>';
    html += '   </select></div>';
    html += ' </div>';

    if (item['type'] == 'text') {
      html += ' <div class="form-group">';
      html += '   <label class="col-sm-3 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
      html += '   <div class="col-sm-9"><input type="text" name="product_option[' + option_row + '][option_value]" value="" placeholder="<?php echo $entry_option_value; ?>" id="input-value' + option_row + '" class="form-control" /></div>';
      html += ' </div>';
    }
    
    if (item['type'] == 'textarea') {
      html += ' <div class="form-group">';
      html += '   <label class="col-sm-3 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
      html += '   <div class="col-sm-9"><textarea name="product_option[' + option_row + '][option_value]" rows="5" placeholder="<?php echo $entry_option_value; ?>" id="input-value' + option_row + '" class="form-control"></textarea></div>';
      html += ' </div>';      
    }
     
    if (item['type'] == 'file') {
      html += ' <div class="form-group" style="display: none;">';
      html += '   <label class="col-sm-3 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
      html += '   <div class="col-sm-9"><input type="text" name="product_option[' + option_row + '][option_value]" value="" placeholder="<?php echo $entry_option_value; ?>" id="input-value' + option_row + '" class="form-control" /></div>';
      html += ' </div>';
    }

    if (item['type'] == 'date') {
      html += ' <div class="form-group">';
      html += '   <label class="col-sm-3 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
      html += '   <div class="col-sm-3"><div class="input-group date"><input type="text" name="product_option[' + option_row + '][option_value]" value="" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
      html += ' </div>';
    }
    
    if (item['type'] == 'time') {
      html += ' <div class="form-group">';
      html += '   <label class="col-sm-3 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
      html += '   <div class="col-sm-9"><div class="input-group time"><input type="text" name="product_option[' + option_row + '][option_value]" value="" placeholder="<?php echo $entry_option_value; ?>" data-date-format="HH:mm" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
      html += ' </div>';
    }
        
    if (item['type'] == 'datetime') {
      html += ' <div class="form-group">';
      html += '   <label class="col-sm-3 control-label" for="input-value' + option_row + '"><?php echo $entry_option_value; ?></label>';
      html += '   <div class="col-sm-9"><div class="input-group datetime"><input type="text" name="product_option[' + option_row + '][option_value]" value="" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
      html += ' </div>';
    }
    
    if (item['type'] == 'select' || item['type'] == 'radio' || item['type'] == 'checkbox' || item['type'] == 'image') {
      html += '<div class="table-responsive">';
      html += '  <table id="option-value' + option_row + '" class="table table-striped table-bordered table-hover">';
      html += '    <thead>'; 
      html += '      <tr>';
      html += '        <td class="text-left"><?php echo $entry_option_value; ?></td>';
      html += '        <td class="text-right"><?php echo $entry_quantity; ?></td>';
      html += '        <td class="text-left"><?php echo $entry_subtract; ?></td>';
      html += '        <td class="text-right"><?php echo $entry_price; ?></td>';
      html += '        <td class="text-right"><?php echo $entry_option_points; ?></td>';
      html += '        <td class="text-right"><?php echo $entry_weight; ?></td>';
      html += '        <td></td>';
      html += '      </tr>';
      html += '    </thead>';
      html += '    <tbody>';
      html += '    </tbody>';
      html += '    <tfoot>';
      html += '      <tr>';
      html += '        <td colspan="6"></td>';
      html += '        <td class="text-left"><button type="button" onclick="addOptionValue(' + option_row + ');" data-toggle="tooltip" title="<?php echo $button_add_option_value; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>';
      html += '      </tr>';
      html += '    </tfoot>';
      html += '  </table>';
      html += '</div>';

        html += '  <select id="option-values' + option_row + '" style="display: none;">';
      
            for (i = 0; i < item['option_value'].length; i++) {
        html += '  <option value="' + item['option_value'][i]['option_value_id'] + '">' + item['option_value'][i]['name'] + '</option>';
            }

            html += '  </select>';  
      html += '</div>';   
    }   
    
    $('#tab-option .tab-content').append(html);
      
    $('#option > li:last-child').before('<li><a href="#tab-option' + option_row + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$(\'a[href=\\\'#tab-option' + option_row + '\\\']\').parent().remove(); $(\'#tab-option' + option_row + '\').remove(); $(\'#option a:first\').tab(\'show\')"></i> ' + item['label'] + '</li>');
    
    $('#option a[href=\'#tab-option' + option_row + '\']').tab('show');
    
    $('.date').datetimepicker({
      pickTime: false
    });
    
    $('.time').datetimepicker({
      pickDate: false
    });
    
    $('.datetime').datetimepicker({
      pickDate: true,
      pickTime: true
    });
        
    option_row++;
    
    return false;
  },
  focus: function(item) {
      return false;
   }
});
//--></script> 
<script type="text/javascript"><!--   
var option_value_row = <?php echo $option_value_row; ?>;
console.log(option_value_row);

function addOptionValue(option_row) { 
  html  = '<tbody id="option-value-row' + option_value_row + '">';
  html += '<tr>';
  html += '  <td class="text-left"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][option_value_id]" class="form-control">';
  html += $('#option-values' + option_row).html();
  html += '  </select><input type="hidden" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][product_option_value_id]" value="" /></td>';
  html += '  <td class="text-right"><input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][quantity]" value="" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>'; 
  html += '  <td class="text-left"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][subtract]" class="form-control">';
  html += '    <option value="1"><?php echo $text_yes; ?></option>';
  html += '    <option value="0"><?php echo $text_no; ?></option>';
  html += '  </select></td>';
  html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price_prefix]" class="form-control">';
  html += '    <option value="+">+</option>';
  html += '    <option value="-">-</option>';
  html += '  </select>';
  html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';
  html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points_prefix]" class="form-control">';
  html += '    <option value="+">+</option>';
  html += '    <option value="-">-</option>';
  html += '  </select>';
  html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points]" value="" placeholder="<?php echo $entry_points; ?>" class="form-control" /></td>';  
  html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight_prefix]" class="form-control">';
  html += '    <option value="+">+</option>';
  html += '    <option value="-">-</option>';
  html += '  </select>';
  html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight]" value="" placeholder="<?php echo $entry_weight; ?>" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#option-value-row' + option_value_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  html +='</tbody>;';
  
  $('#option-value' + option_row + ' tfoot').before(html);

  option_value_row++;
}
//--></script> 
<?php } ?>

<?php if(isset($mp_allowproducttabs['discount']) && $mp_allowproducttabs['discount']) { ?>
<script type="text/javascript"><!--
var discount_row = <?php echo $discount_row; ?>;

function addDiscount() {
  html = '<tbody id="discount-row' + discount_row + '">';
  html  += '<tr>'; 
  html += '  <td class="text-left"><select name="product_discount[' + discount_row + '][customer_group_id]" class="form-control">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo addslashes($customer_group['name']); ?></option>';
    <?php } ?>
    html += '  </select></td>';   
    html += '  <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][quantity]" value="" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>';
    html += '  <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][priority]" value="" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>';
  html += '  <td class="text-right"><input type="text" name="product_discount[' + discount_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';
  html += '  <td class="text-left"><div class="input-group date"><input type="text" name="product_discount[' + discount_row + '][date_start]" value="" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
  html += '  <td class="text-left"><div class="input-group date"><input type="text" name="product_discount[' + discount_row + '][date_end]" value="" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#discount-row' + discount_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  html += '</tbody>';
  
   $('#discount tfoot').before(html);

  $('.date').datetimepicker({
    pickTime: false
  });
  
  discount_row++;
}
//--></script> 
<?php } ?>

<?php if(isset($mp_allowproducttabs['special']) && $mp_allowproducttabs['special']) { ?>
<script type="text/javascript"><!--
var special_row = <?php echo $special_row; ?>;

function addSpecial() {
  html = '<tbody id="special-row' + special_row + '">'
  html  += '<tr>'; 
    html += '  <td class="text-left"><select name="product_special[' + special_row + '][customer_group_id]" class="form-control">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo addslashes($customer_group['name']); ?></option>';
    <?php } ?>
    html += '  </select></td>';   
    html += '  <td class="text-right"><input type="text" name="product_special[' + special_row + '][priority]" value="" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>';
  html += '  <td class="text-right"><input type="text" name="product_special[' + special_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';
    html += '  <td class="text-left"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_start]" value="" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
  html += '  <td class="text-left"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_end]" value="" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#special-row' + special_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  html += '</tbody>';
  
 $('#special tfoot').before(html);

  $('.date').datetimepicker({
    pickTime: false
  });
    
  special_row++;
}
//--></script> 
<?php } ?>

<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
  html  = '<tbody id="image-row' + image_row + '">';
  html += '  <tr>';
  html += '  <td class="text-left"><input type="file" class="hide" name="product_image[' + image_row + '][image]"><img src="<?php echo $placeholder; ?>" class="img-thumbnail click-file" data-placeholder="<?php echo $placeholder; ?>" /><input type="hidden" name="product_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
  html += '  <td class="text-right"><input type="text" name="product_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  html += '</tbody>';

  $('#images tfoot').before(html);
  
  image_row++;
  
}
//--></script> 
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
$('#option a:first').tab('show');
//--></script></div>

<?php }else{ ?>
<?php echo $text_access; ?>
  
</div>  <!--content-->
<?php echo $column_right; ?></div>   <!--row-->
</div>  <!--container-->
<?php } ?>
<?php } ?>
 <!-- membership codes starts here -->
<?php if($wk_seller_group_status && $wk_seller_group_membership_type && $wk_seller_group_membership_type != 'product') {  ?>              
    <div id="myModalanswer" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel"></h3>
              </div>
            <div class="modal-body">
              <span id="alert" class="text-danger"></span>
            <h3 id="wk-open-list"><?php echo $entry_list_header; ?></h3>
              <table class="table table-bordered table-hover" id="details">
                <thead>
                  <tr>
                    <td>
                      <?php echo $entry_name; ?>
                    </td>
                      <td>
                        <?php echo $entry_quantity; ?>
                      </td>
                      <td>
                        <?php echo $entry_price; ?>
                      </td>
                  <tr>
                </thead>
                <tbody>
                  <?php foreach($sellerDetail as $detail){ ?>
                    <tr>
                      <td>
                        <?php echo $detail['name']; ?>
                      </td>
                      <td>
                        <?php echo $detail['quantity']; ?>  
                      </td>
                      <td>
                        <?php echo $detail['price']; ?> 
                      </td>
                    </tr>
                  <?php } ?>        
                </tbody>
            </table>
          </div>
            <div class="modal-footer">
              <button class="btn closebtn" data-dismiss="modal" aria-hidden="true" id="closeButton">Close</button>
            </div>
          </div>
        </div>
      </div>    
  <?php } ?>  
   <!-- membership codes ends here --> 
<?php echo $footer; ?>