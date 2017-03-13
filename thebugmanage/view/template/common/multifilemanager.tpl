<script src="view/javascript/jquery/fileupload/js/vendor/jquery.ui.widget.js"></script>
<script src="view/javascript/jquery/fileupload/js/jquery.iframe-transport.js"></script>
<script src="view/javascript/jquery/fileupload/js/jquery.fileupload.js"></script>
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title"><?php echo $heading_title; ?></h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-sm-5">
          <a href="<?php echo $parent; ?>" data-toggle="tooltip" title="<?php echo $button_parent; ?>" id="button-parent" class="btn btn-default"><i class="fa fa-level-up"></i></a> 
          <a href="<?php echo $refresh; ?>" data-toggle="tooltip" title="<?php echo $button_refresh; ?>" id="button-refresh" class="btn btn-default"><i class="fa fa-refresh"></i></a>
          <!--
          <button type="button" data-toggle="tooltip" title="<?php echo $button_upload; ?>" id="button-upload" class="btn btn-primary"><i class="fa fa-upload"></i></button>
          -->
          <input type="hidden" name="upload_directory" value="<?php echo $directory; ?>" id="upload_directory">
          <button type="button" data-toggle="tooltip" title="<?php echo $button_upload; ?>" id="button-upload-multi" class="btn btn-primary"><i class="fa fa-upload"></i></button>
          <button type="button" data-toggle="tooltip" title="<?php echo $button_folder; ?>" id="button-folder" class="btn btn-default"><i class="fa fa-folder"></i></button>
          <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" id="button-delete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
          <button type="button" data-toggle="tooltip" title="Add" id="btn_mutil_img_add" class="btn btn-primary"><i class="fa fa-save"></i></button>
        </div>
        <div class="col-sm-7">
          <div class="input-group">
            <input type="text" name="search" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_search; ?>" class="form-control">
            <span class="input-group-btn">
            <button type="button" data-toggle="tooltip" title="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </span></div>
        </div>
      </div>
      <div class="row" style="padding-top: 10px;">
	    <div id="progress" style="padding-left: 15px; color: green;"></div>
	  </div>
	  <div class="row" style="padding-top: 10px; padding-left: 15px;" id="rad_mutil_img_select_div">
      	<input type="checkbox" onclick="$('input[name*=\'path\']').prop('checked', this.checked);"> Select All </input>
	  </div>
      <hr />
      <?php foreach (array_chunk($images, 4) as $image) { ?>
      <div class="row">
        <?php foreach ($image as $image) { ?>
        <div class="col-sm-3 text-center">
          <?php if ($image['type'] == 'directory') { ?>
          <div class="text-center"><a href="<?php echo $image['href']; ?>" class="directory" style="vertical-align: middle;"><i class="fa fa-folder fa-5x"></i></a></div>
          <label>
            <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
            <?php echo $image['name']; ?></label>
          <?php } ?>
          <?php if ($image['type'] == 'image') { ?>
          <a href="<?php echo $image['href']; ?>" class="thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" /></a>
          <label>
            <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
            <?php echo $image['name']; ?></label>
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <br />
      <?php } ?>
    </div>
    <div class="modal-footer"><?php echo $pagination; ?></div>
  </div>
</div>
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImageHtml(obj) {
	html  = '<tr id="image-row' + image_row + '">';
	html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="' + $(obj).find('img').attr('src') + '" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="product_image[' + image_row + '][image]" value="' + $(obj).parent().find('input').attr('value') + '" id="input-image' + image_row + '" /></td>';
	html += '  <td class="text-right"><input type="text" name="product_image[' + image_row + '][sort_order]" value="0" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';
	
	$('#images tbody').append(html);
	
	image_row++;
	
	$('#modal-image').modal('hide');
}

function addMultiImageHtml() {
	var img_count = 0;
	var checkboxs = $('input[name^=\'path\']:checked');
	$.each(checkboxs, function(i, checkObj){
	  	var class_name = $(checkObj).parent().parent().find('a').attr('class');
	  	if (class_name == 'thumbnail') {
	  		var img_path = $(checkObj).val();
	  		var img_url = $(checkObj).parent().parent().find('a img').attr('src');
	  		addUnitImageHtml(img_path, img_url);
	  		img_count++;
	  	}
	});
	if (img_count > 0) {
		$('#modal-image').modal('hide');
	} else {
		alert('Please select image.');
	}
}

function addUnitImageHtml(imagePath, imageUrl) {
	html  = '<tr id="image-row' + image_row + '">';
	html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="' + imageUrl + '" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="product_image[' + image_row + '][image]" value="' + imagePath + '" id="input-image' + image_row + '" /></td>';
	html += '  <td class="text-right"><input type="text" name="product_image[' + image_row + '][sort_order]" value="0" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';
	
	$('#images tbody').append(html);
	
	image_row++;
}

$('#btn_mutil_img_add').on('click', function(e) {
	e.preventDefault();

	addMultiImageHtml();
});

$('a.thumbnail').on('click', function(e) {
	e.preventDefault();

	addImageHtml(this);
});

$('a.directory').on('click', function(e) {
	e.preventDefault();
	
	var multi_href = $(this).attr('href') + '&image_row=' + image_row;
	$(this).attr('href', multi_href);
	
	$('#modal-image').load($(this).attr('href'));
});

$('.pagination a').on('click', function(e) {
	e.preventDefault();
	
	var multi_href = $(this).attr('href') + '&image_row=' + image_row;
	$(this).attr('href', multi_href);
	
	$('#modal-image').load($(this).attr('href'));
});

$('#button-parent').on('click', function(e) {
	e.preventDefault();
	
	var multi_href = $(this).attr('href') + '&image_row=' + image_row;
	$(this).attr('href', multi_href);
	
	$('#modal-image').load($(this).attr('href'));
});

$('#button-refresh').on('click', function(e) {
	e.preventDefault();
	
	var multi_href = $(this).attr('href') + '&image_row=' + image_row;
	$(this).attr('href', multi_href);
	
	$('#modal-image').load($(this).attr('href'));
});

$('#button-search').on('click', function() {
	var url = 'index.php?route=common/multifilemanager&token=<?php echo $token; ?>&directory=<?php echo $directory; ?>' + '&image_row=' + image_row;
	
	var filter_name = $('input[name=\'search\']').val();
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
							
	<?php if ($thumb) { ?>
	url += '&thumb=' + '<?php echo $thumb; ?>';
	<?php } ?>
	
	<?php if ($target) { ?>
	url += '&target=' + '<?php echo $target; ?>';
	<?php } ?>
			
	$('#modal-image').load(url);
});
//--></script> 
<!--
<script type="text/javascript">
$('#button-upload').on('click', function() {
	$('#form-upload').remove();
	
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');
	
	$('#form-upload input[name=\'file\']').on('change', function() {
		$.ajax({
			url: 'index.php?route=common/multifilemanager/upload&token=<?php echo $token; ?>&directory=<?php echo $directory; ?>',
			type: 'post',		
			dataType: 'json',
			data: new FormData($(this).parent()[0]),
			cache: false,
			contentType: false,
			processData: false,		
			beforeSend: function() {
				$('#button-upload i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
				$('#button-upload').prop('disabled', true);
			},
			complete: function() {
				$('#button-upload i').replaceWith('<i class="fa fa-upload"></i>');
				$('#button-upload').prop('disabled', false);
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				}
				
				if (json['success']) {
					alert(json['success']);
					
					$('#button-refresh').trigger('click');
				}
			},			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
});
</script>
-->
<script type="text/javascript"><!--
$('#button-upload-multi').on('click', function() {
	$('#fileupload').remove();
	var upload_dir = $('#upload_directory').val();
	$('body').prepend('<input id="fileupload" type="file" name="files[]" style="display: none;" data-url="index.php?route=common/multifilemanager/multiupload&token=<?php echo $token; ?>&directory=' + upload_dir + '" multiple>');
	$('#fileupload').fileupload({
	    dataType: 'json',
	    done: function (e, data) {
	    	$('#button-refresh').trigger('click');
	    },
	    progressall: function (e, data) {
	        var progress = parseInt(data.loaded / data.total * 100, 10);
	        $('#progress').html(progress + '%');
	    }
	});
	$('#fileupload').trigger('click');
});

$('#button-folder').popover({
	html: true,
	placement: 'bottom',
	trigger: 'click',
	title: '<?php echo $entry_folder; ?>',
	content: function() {
		html  = '<div class="input-group">';
		html += '  <input type="text" name="folder" value="" placeholder="<?php echo $entry_folder; ?>" class="form-control">';
		html += '  <span class="input-group-btn"><button type="button" title="<?php echo $button_folder; ?>" id="button-create" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></span>';
		html += '</div>';
		
		return html;	
	}
});

$('#button-folder').on('shown.bs.popover', function() {
	$('#button-create').on('click', function() {
		$.ajax({
			url: 'index.php?route=common/multifilemanager/folder&token=<?php echo $token; ?>&directory=<?php echo $directory; ?>',
			type: 'post',		
			dataType: 'json',
			data: 'folder=' + encodeURIComponent($('input[name=\'folder\']').val()),
			beforeSend: function() {
				$('#button-create i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
				$('#button-create').prop('disabled', true);
			},
			complete: function() {
				$('#button-create i').replaceWith('<i class="fa fa-plus-circle"></i>');
				$('#button-create').prop('disabled', false);
			},
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				}
				
				if (json['success']) {
					alert(json['success']);
										
					$('#button-refresh').trigger('click');
				}
			},			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});	
});

$('#modal-image #button-delete').on('click', function(e) {
	if (confirm('<?php echo $text_confirm; ?>')) {
		$.ajax({
			url: 'index.php?route=common/multifilemanager/delete&token=<?php echo $token; ?>',
			type: 'post',		
			dataType: 'json',
			data: $('input[name^=\'path\']:checked'),
			beforeSend: function() {
				$('#button-delete i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
				$('#button-delete').prop('disabled', true);
			},	
			complete: function() {
				$('#button-delete i').replaceWith('<i class="fa fa-trash-o"></i>');
				$('#button-delete').prop('disabled', false);
			},		
			success: function(json) {
				if (json['error']) {
					alert(json['error']);
				}
				
				if (json['success']) {
					alert(json['success']);
					
					$('#button-refresh').trigger('click');
				}
			},			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});
//--></script>