<?php echo $header; ?>
<style>
.csv-warning{
  display: none;
}
</style>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-shipping" data-toggle="tooltip" title="<?php echo $button_next; ?>" class="btn btn-primary"><i class="fa fa-share"></i></button>
        <a href="<?php echo $back; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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

        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $entry_info; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-shipping" class="form-horizontal">

        	<div class="form-group required">
	            <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $entry_csv; ?>"><?php echo $entry_csv; ?></span></label>
	            <div class="col-sm-9">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-primary" onclick="$('input[name=\'up_file\']').trigger('click');"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                  </span> 
                  <input type="text" id="input-csv-name" class="form-control" disabled/>
                </div>
		        	  <input type="file" name="up_file" class="form-control" style="display:none;"> 
  		        	<div class="hide csv-warning">
    		        		<?php echo $entry_error_csv; ?>
    				    </div>        
            	</div>
          	</div>

          	<div class="form-group required">
	            <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $entry_separator; ?>"><?php echo $entry_separator; ?></span></label>
	            <div class="col-sm-9">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-primary separator"><i class="fa fa-keyboard-o"></i> <?php echo $entry_sep_manually; ?></button>
                  </span> 
                  <div>
      		        	<select name="separator" id="separator" class="form-control">
                  		<option value=";">Semicolon ; </option>
                  		<option value="	">Tab</option>
                  		<option value=",">Comma ,</option>
                  		<option value=":">Colon : </option>
                  		<option value="|">Vertical bar</option>
                    </select> 
                  </div>
                </div>           
            	</div>
          	</div>     
	    </form>
      </div>
    </div>
  </div>
</div>

<script>
jQuery('input[name=up_file]').change(function(){
  csv_val = jQuery(this).val().split('.').pop();  
    $('#input-csv-name').val(jQuery(this).val().replace(/C:\\fakepath\\/i, ''));
    if(csv_val!='csv'){
      jQuery('.csv-warning').addClass('text-danger').removeClass('hide');            
    }else{
      jQuery('.csv-warning').addClass('hide').removeClass('text-danger');            
    } 
});

jQuery('input[name=up_file]').change(function(){
	csv_val = jQuery(this).val().split('.').pop();		
  if(csv_val!='csv'){
    jQuery(this).parents('.required').addClass('has-error');
    jQuery('.view_red').slideDown();	    	    
  }else{
    jQuery('.view_red').slideUp();
  }	
});

nextHtml = false;
prevHtml = $("<input type='text' class=\"form-control\"/>").attr({ name: 'separator' });

jQuery('.separator').click(function(){	
  catchDiv = $(this).parent().next();
  nextHtml = catchDiv.html();
  catchDiv.html(prevHtml);
  prevHtml = nextHtml;
})

</script>

<?php echo $footer; ?>