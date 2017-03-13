<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
		<div class="page-header">
		 	<div class="container-fluid">
		 		<div class="pull-right">
		 			<a id="saveForm" class="btn btn-primary" title="<?php echo $button_save ?>"><i class="fa fa-save"></i></a>
					<a href="<?php echo $back; ?>" class="btn btn-default" title="<?php echo $button_back ?>"><i class="fa fa-reply"></i></a>
		 		</div>
		 		<h1><?php echo $heading_title; ?></h1>
			 	<ul class="breadcrumb">
		        	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		        	<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		        	<?php } ?>
	     	 	</ul>
			</div>
		</div>
	
		<div class="container-fluid">
			<?php if(isset($this->session->data['success']) && $this->session->data['success'] != '') { ?>
			<div class="alert alert-success"><i class="fa fa-info-circle">
			<?php echo $this->session->data['success'];
			$this->session->data['success'] = ''; ?>
			</div>
			<?php } ?>
			<?php if(isset($this->session->data['warning']) && $this->session->data['warning'] != '') { ?>
				<div class="alert alert-warning"><i class="fa fa-info-circle">
				<?php echo $this->session->data['warning'];
				$this->session->data['warning'] = ''; ?>
				</div>
			<?php } ?>
			<div class="panel panel-default">
			    <div class="panel-heading">
			        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $lower_heading_title; ?></h3>
			      </div>
		      	<div class="panel-body">
					<form id="optionform" class="form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
													
										<?php if(isset($fieldId) && $fieldId != '' ) { ?>
											<input type="hidden" name="fieldId" value="<?php echo $fieldId; ?>">
										<?php } ?>
										<?php foreach ($languages as $key => $language) { ?>
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="forseller1">
												<?php echo $text_field_name; ?>
											</label>
											<div class="col-sm-10">
												<div class="input-group">
													<span class="input-group-addon">
														<img src="view/image/flags/<?php echo $language['image']?>">
													</span>
													<input type="text" class="form-control" name="fieldName[<?php echo $language['language_id']?>]" value="<?php if(isset($fieldName)) echo  $fieldName[$language['language_id']]['fieldName']; ?>">
												</div>
											</div>
										</div>
										<?php } ?>
								
										<?php foreach ($languages as $key => $language) { ?>
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="forseller1">
												<?php echo $text_desc; ?>
											</label>
											<div class="col-sm-10">
												<div class="input-group">
													<span class="input-group-addon">
														<img src="view/image/flags/<?php echo $language['image']?>">
													</span>
													<textarea class="form-control" row="5" name="fieldDes[<?php echo $language['language_id']?>]" value="" placeholder="Enter field's Description..."><?php if(isset($fieldDes)) echo  $fieldDes[$language['language_id']]['fieldDes']; ?></textarea>
												</div>
											</div>
										</div>
										<?php } ?>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="forseller1">
														<?php echo $text_is_req; ?>
											</label>
											<div class="col-sm-10">
												<select class="form-control" name="isRequired">
													<option value="yes" <?php if(isset($isRequired) && $isRequired == "yes") echo  "selected"; ?>>Yes</option>
													<option value="no" <?php if(isset($isRequired) && $isRequired == "no") echo  "selected"; ?>>No</option>
												</select>
											</div>
										</div>
										<!-- <input id="required1" type="radio" name="isRequired" value="yes" <?php if(isset($isRequired) && $isRequired == "yes") echo  "checked"; ?>><label for="required1">Yes</label>
										<input id="required2" type="radio" name="isRequired" value="no" <?php if(isset($isRequired) && $isRequired == "no") echo  "checked"; ?> ><label for="required2">No</label> -->
								
									
											<div class="form-group">
												<label class="col-sm-2 control-label" for="forseller1">
													<?php echo $text_for_seller; ?>
												</label>
												<div class="col-sm-10">
													<select class="form-control" name="forSeller">
														<option value="yes" <?php if(isset($forSeller) && $forSeller == "yes") echo  "selected"; ?>>Yes</option>
														<option value="no" <?php if(isset($forSeller) && $forSeller == "no") echo  "selected"; ?>>No</option>
													</select>
												</div>
											</div>
											<!-- <input id="forseller1" type="radio" name="forSeller" value="yes" <?php if(isset($forSeller) && $forSeller == "yes") echo  "checked"; ?> ><label for="forseller1">Yes</label>
											<input id="forseller2" type="radio" name="forSeller" value="no" <?php if(isset($forSeller) && $forSeller == "no") echo  "checked"; ?>><label for="forseller2">No</label> -->
										
							
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="forseller1">
														<?php echo $text_field_type; ?>
											</label>
											<div class="col-sm-10">
												<select class="form-control" name="fieldType" id="selectfieldType">
													<option value=""></option>
													<optgroup label="Choose">
														<option value="select" <?php if(isset($fieldType) && $fieldType == 'select') echo "selected"; ?> >Select</option>
														<option value="radio" <?php if(isset($fieldType) && $fieldType == 'radio') echo "selected"; ?>>Radio</option>
														<option value="checkbox" <?php if(isset($fieldType) && $fieldType == 'checkbox') echo "selected"; ?>>Checkbox</option>
													</optgroup>
													<optgroup label="Input">
														<option value="text" <?php if(isset($fieldType) && $fieldType == 'text') echo "selected"; ?>>Text</option>
														<option value="textarea" <?php if(isset($fieldType) && $fieldType == 'textarea') echo "selected"; ?>>Textarea</option>
													</optgroup>
													<optgroup label="Date">
														<option value="date" <?php if(isset($fieldType) && $fieldType == 'date') echo "selected"; ?>>Date</option>
														<option value="time" <?php if(isset($fieldType) && $fieldType == 'time') echo "selected"; ?>>Time</option>
														<option value="datetime" <?php if(isset($fieldType) && $fieldType == 'datetime') echo "selected"; ?>>Date & time</option>
													</optgroup>
												</select>
											</div>
										</div>
					<table id="optionValues" class="table table-bordered table-hover" >
						<?php $optionRow = 0;
							if(!empty($fieldoptions)) { ?>	
								<thead>
									<tr>
										<td class="left">
											<span style="color:#f00">* </span>
											<?php echo $text_option_value; ?>
										</td>
										<td class="center">
											<?php echo $text_action; ?>
										</td>
									</tr>
								</thead>
								<tr>
									<td class="left"></td>
									<td class="center">
										<a class="btn btn-primary" onclick="addField('<?php if(isset($fieldType) && $fieldType != '') echo $fieldType; ?>');" title="<?php echo $text_add_option; ?>">
											<i class="fa fa-plus"></i>
										</a>
									</td>
								</tr>
								<?php foreach ($fieldoptions as $index => $value) { ?>
										<tr>
											<td class="left">
											<input type="hidden" class="form-control" value="<?php echo $index; ?>" name="optionId[<?php echo $optionRow; ?>]">
											<?php foreach ($languages as $key => $language) { ?>
												<div class="col-sm-10">
													<div class="input-group">
														<span class="input-group-addon">
															<img src="view/image/flags/<?php echo $language["image"]?>">
														</span>
														<input type="text" class="form-control" placeholder="" name="preOptionValue[<?php echo $optionRow; ?>][<?php echo $language["language_id"]; ?>]" value="<?php echo $value[$language['language_id']]['des'];?>">
													</div>
												</div>
											<?php } ?>
											</td>
											<td colspan="" class="center">
												<a class="btn btn-danger" onclick="$(this).parent().parent().remove();" title="<?php echo $text_remove; ?>" >
													<i class="fa fa-minus-circle"></i>
												</a>
											</td>
										</tr>
									<?php
										$optionRow++;
											 } ?>
							<?php } ?>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

$('#saveForm').on('click',function(){
	count = 0;
	$('.alert').remove();
	$('form input[type="text"] ').each(function(){
		if($(this).val() == ''){
			count++;
			if(count == 1){
				html = '<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_insert; ?></div>';
				$('.panel-default').before(html);
			}
			$(this).parent().prev().css('color','#E85453');
			$(this).effect('highlight',500);
		}
	})
	if(count == 0){
		$('#optionform').submit();
	}
});

optionvalue = 0;
flag = 0;
$('#selectfieldType').on('change',function(){
	if(flag == 0){
		Oldcontent = $('#optionValues').html();
	}
	fieldType = $(this).val();
	if(fieldType != 'select' && fieldType != 'checkbox' && fieldType != 'radio'){
		$('#optionValues').hide();
	}else{
		$('#optionValues').show();
		$('#optionValues').html('');
		oldFieldType = '<?php if(isset($fieldType) && $fieldType != '') echo $fieldType; ?>';
		if(fieldType == oldFieldType){
			html = Oldcontent;
		}else{
			html = '<thead><tr><td class="left"><span style="color:#f00">* </span><?php echo $text_option_value; ?></td><td class="center"><?php echo $text_action; ?></td></tr></thead><tr><td class="left"></td><td class="center"><a class="btn btn-primary" onclick="addField(fieldType);" title="<?php echo $text_add_option; ?>"><i class="fa fa-plus"></i></a></td></tr>';
		}
		$(html).appendTo('#optionValues');
		addField(fieldType);
	}
	flag++;
})

function addField(fieldType){
	if(fieldType == 'select' || fieldType == 'checkbox' || fieldType == 'radio') {
			html = '<tr><td class="left">';
		<?php foreach ($languages as $key => $language) { ?>
			html +=  '<div class="col-sm-10"><div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language["image"]?>"></span><input type="text" class="form-control" placeholder="option value '+optionvalue+'" name="optionValue['+optionvalue+'][<?php echo $language["language_id"]?>]"></div></di>';
			<?php } ?>
			html += '</td><td colspan="" class="center"><a class="btn btn-danger" onclick="$(this).parent().parent().remove();" title="<?php echo $text_remove; ?>"><i class="fa fa-minus-circle"></i></a></td></tr>';
			$(html).appendTo('#optionValues');
			optionvalue++;
	}
}

</script>

<?php echo $footer; ?>
