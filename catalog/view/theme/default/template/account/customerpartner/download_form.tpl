<?php echo $header; ?>
<?php if($chkIsPartner){ ?>

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
    <?php if ($error_warning) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $error_warning; ?></div>
    <?php } ?>

    <div id="content" class="<?php echo $class; ?>"> <?php echo $content_top; ?>
      <h1>
        <?php echo $heading_title; ?>        
        <div class="pull-right">
          <a onclick="$('#form-insert').submit();" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></a>
          <a href="<?php echo $cancel; ?>" data-toggle="tooltip" class="btn btn-default"  title="<?php echo $button_cancel; ?>"><i class="fa fa-reply"></i></a>
        </div>
      </h1>
      <fieldset>
      <legend><i class="fa fa-list"></i> <?php echo $text_downloadableInsert; ?></legend>
      <?php if(!isset($access_error) && $isMember) { ?>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-insert" class="form-horizontal">
          
          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <?php foreach ($languages as $language) { ?>
              <div class="input-group"> <span class="input-group-addon"><img src="thebugmanage/view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                <input type="text" name="download_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($download_description[$language['language_id']]) ? $download_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
              </div>
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
              <?php } ?>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-filename"><span data-toggle="tooltip" title="<?php echo $help_fileDetails; ?>"><?php echo $entry_filename; ?></span></label>
            <div class="col-sm-10">
              <div class="input-group">
                <input type="text" name="filename" value="<?php echo $filename; ?>" placeholder="<?php echo $entry_filename; ?>" id="input-filename" class="form-control" />
                <span class="input-group-btn">
                <button type="button" id="button-upload" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                </span> </div>
              <?php if ($error_filename) { ?>
              <div class="text-danger"><?php echo $error_filename; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-mask"><span data-toggle="tooltip" title="<?php echo $help_mask; ?>"><?php echo $entry_mask; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="mask" value="<?php echo $mask; ?>" placeholder="<?php echo $entry_mask; ?>" id="input-mask" class="form-control" />
              <?php if ($error_mask) { ?>
              <div class="text-danger"><?php echo $error_mask; ?></div>
              <?php } ?>
            </div>
          </div>         
      </form>
    </fieldset>
  </div>
<?php echo $column_right; ?></div>
</div>
<script type="text/javascript">

$('#button-upload').on('click',function(){
  $('#form-upload').remove();
  $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
  $('#form-upload input[name=\'file\']').trigger('click');

  $('#form-upload input[name=\'file\']').on('change', function() {
    $.ajax({
      url: 'index.php?route=account/customerpartner/download/upload',
      type: 'post',   
      dataType: 'json',
      data: new FormData($(this).parent()[0]),
      cache: false,
      contentType: false,
      processData: false,   
      beforeSend: function() {
        $('#button-upload').button('loading');
      },
      complete: function() {
        $('#button-upload').button('reset');
      },  
      success: function(json) {

        if (json['error']) {
          alert(json['error']);
        }
              
        if (json['success']) {
          alert(json['success']);
          
          $('input[name=\'filename\']').attr('value', json['filename']);
          $('input[name=\'mask\']').attr('value', json['mask']);
        }
      },      
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  });

})//function
</script> 
<?php }else{  echo $text_access;   ?>
  </div>
  <?php echo $column_right; ?></div>
</div>
<?php } ?>
<?php } ?>
<?php echo $footer; ?>