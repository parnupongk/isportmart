<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-commission" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>

      <div class="panel-body">

        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $info_category_select; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>

        <form action="<?php echo $save; ?>" method="post" enctype="multipart/form-data" id="form-commission" class="form-horizontal">
          <input type="hidden" name="id" value="<?php echo $id; ?>" />

          <div class="form-group">
            <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_category; ?>"><?php echo $entry_category; ?></span></label>

            <div class="col-sm-10">
              <select name="category_id" class="form-control">
                <?php foreach($category as $value){ ?>               
                  <?php if(is_array($commission_add) AND in_array('category',$commission_add) ){ ?> 
                    <?php if($value['parent_id']==0){ ?>
                      <?php if($category_id == $value['category_id']){ ?>                      
                        <option value="<?php echo $value['category_id']; ?>" selected ><?php echo $value['name']; ?></option>    
                      <?php }else{ ?>
                          <?php if(in_array($value['category_id'],$added_category)){ ?>
                            <option value="<?php echo $value['category_id']; ?>" disabled class="disabled"><?php echo $value['name']; ?></option>  
                          <?php }else{ ?>
                            <option value="<?php echo $value['category_id']; ?>"><?php echo $value['name']; ?></option>
                          <?php } ?>
                      <?php } ?>
                    <?php } ?>
                  <?php } 
                  if(is_array($commission_add) AND in_array('category_child',$commission_add) ){ ?>
                    <?php if($value['parent_id']!=0){ ?>
                      <?php if($category_id == $value['category_id']){ ?>  
                        <option value="<?php echo $value['category_id']; ?>" selected ><?php echo $value['name']; ?></option>
                      <?php }else{ ?>
                        <?php if(in_array($value['category_id'],$added_category)){ ?>
                          <option value="<?php echo $value['category_id']; ?>" disabled class="disabled"><?php echo $value['name']; ?></option>  
                        <?php }else{ ?>
                          <option value="<?php echo $value['category_id']; ?>"><?php echo $value['name']; ?></option>
                        <?php } ?>                                         
                      <?php } ?>
                    <?php } ?>
                  <?php } ?>
                <?php } ?>
              </select>             
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_commission_info; ?>"><?php echo $entry_commission; ?></span></label>
            <div class="col-sm-10">
              <div class="input-group">                
                <input type="text" class="form-control" name="fixed" value="<?php echo $fixed ? $fixed : 0 ; ?>" />
                <span class="input-group-addon"> <b><?php echo $entry_fixed ?></b> </span>
              </div>
              &nbsp; &nbsp; +  &nbsp; &nbsp; 
              <div class="input-group">
                <input type="text" class="form-control" name="percentage" value="<?php echo $percentage ? $percentage : 0 ; ?>" />
                <span class="input-group-addon"> <b>%</b> </span>
              </div>
            </div>
          </div>  

      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>