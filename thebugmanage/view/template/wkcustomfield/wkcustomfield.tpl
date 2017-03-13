<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		 <div class="container-fluid">
		 	<div class="pull-right">
		 		<a href="<?php echo $insert; ?>" class="btn btn-primary" title="<?php echo $button_insert; ?>" ><i class="fa fa-plus"></i></a>
				<a onclick="$('#fieldListForm').submit();" class="btn btn-danger" title="<?php echo $button_delete; ?>"><i class="fa fa-trash-o"></i></a>
				<a class="btn btn-success" name="filter" id="filterButton" onclick="location='index.php?route=wkcustomfield/wkcustomfield&token=<?php echo $token; ?>'" title="Reset Filter"><i class="fa fa-eraser fa-1"></i></a>
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
			<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $this->session->data['success']; ?>
		      <button type="button" class="close" data-dismiss="alert">&times;</button>
		    </div>
		<?php } ?>
		<?php if(isset($this->session->data['warning']) && $this->session->data['warning'] != '') { ?>
			<div class="warning">
				<?php echo $this->session->data['warning'];
				$this->session->data['warning'] = ''; ?>
			</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i>
					<?php echo $heading_title_list; ?></h3>
			    </div>
			<div class="panel-body">
				<div class="well">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">
									Option Name
								</label>
								<input class="form-control" type="text" name="fieldName" value="<?php if(isset($fieldName)) echo $fieldName; ?>">
							</div>
							<div class="form-group">
								<label class="control-label">
									Field Type
								</label>
								<input class="form-control" type="text" name="fieldType" value="<?php if(isset($fieldType)) echo $fieldType; ?>">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">
									For Seller
								</label>
								<select name="forSeller" class="form-control">
									<option value=""></option>
									<option value="yes" <?php if(isset($forSeller) && $forSeller == 'yes') echo "selected"; ?> >Yes</option>
									<option value="no" <?php if(isset($forSeller) && $forSeller == 'no') echo "selected"; ?> >No</option>
								</select>
							</div>
							<div class="form-group">
								<button type="button" class="btn btn-primary pull-right" id="filterButton" onclick="filter(this)">
									<i class="fa fa-filter"></i>
									Filter
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<form id="fieldListForm" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td class="left" width="2"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);"></td>
									<td class="left"><a class="<?php if(isset($order) && $order == 'cfd.fieldName') echo $sort; ?>" id="cfd.fieldName" onclick="filter(this)">Option Name</a></td>
									<td class="left"><a class="<?php if(isset($order) && $order == 'cf.fieldType') echo $sort; ?>" id="cf.fieldType" onclick="filter(this)">Field Type</a></td>
									<td class="left"><a class="<?php if(isset($order) && $order == 'cf.forSeller') echo $sort; ?>" id="cf.forSeller" onclick="filter(this)">For seller</a></td>
									<td class="center">Action</td>
								</tr>
							</thead>
							<tbody>
								<!-- <tr>
									<td class="left" width="2"></td>
									<td class="left"><input type="text" name="fieldName" value="<?php if(isset($this->request->get['fieldName'])) echo $this->request->get['fieldName']; ?>"></td>
									<td class="left"><input type="text" name="fieldType" value="<?php if(isset($this->request->get['fieldType'])) echo $this->request->get['fieldType']; ?>"></td>
									<td class="left">
										<select name="forSeller">
											<option value=""></option>
											<option value="yes" <?php if(isset($this->request->get['forSeller']) && $this->request->get['forSeller'] == 'yes') echo "selected"; ?> >Yes</option>
											<option value="no" <?php if(isset($this->request->get['forSeller']) && $this->request->get['forSeller'] == 'no') echo "selected"; ?> >No</option>
										</select>
									</td>
									<td class="center">
										<a class="btn btn-primary" name="filter" id="filterButton" onclick="filter(this)"><i class="fa fa-filter fa-1"></i></i> Filter</a>
									</td>
								</tr> -->
								<?php if(!empty($optionList)) {
									foreach ($optionList as $key => $option) { ?>
										<tr>
											<td class="left" width="2"><input type="checkbox" value="<?php echo $option['id']?>" name="selected[]" ></td>
											<td class="left"><?php echo $option['fieldName']; ?></td>
											<td class="left"><?php echo $option['fieldType']; ?></td>
											<td class="left"><?php echo $option['forSeller']; ?></td>
											<td class="center"><a class="btn btn-primary" href="<?php echo $option['edit']; ?>" ><i class="fa fa-pencil"></i></a></td>
										</tr>
									<?php }
								}else{ ?>
										<tr>
											<td></td>
											<td colspan="4"  class="center"><?php echo $noOption; ?></td>
										</tr>
								<?php } ?>
							</tbody>
						</table>
					</form>
				</div>
			</div>
			</div>
		</div>
</div>

<script type="text/javascript">

function filter(data){
	
	url = "index.php?route=wkcustomfield/wkcustomfield&token=<?php echo $token; ?>";
	if(data.id != 'filterButton'){
		order = data.id;
		if($(data).attr('class') == ''){
			sort = 'asc';
		}else if($(data).attr('class') == 'asc'){
			sort = 'desc';
		}else{
			sort = 'asc';
		}
		url += '&order='+order+'&sort='+sort;
	}else{
		order = '<?php if(isset($this->request->get["order"])) echo $this->request->get["order"]; ?>';
		sort = '<?php if(isset($this->request->get["sort"])) echo $this->request->get["sort"]; ?>';
		url += '&order='+order+'&sort='+sort;
	}

	fieldName = $("input[name = 'fieldName']").val();
	if(fieldName){
		url += '&fieldName='+fieldName;
	}
	fieldType = $("input[name = 'fieldType']").val();
	if(fieldType){
		url += '&fieldType='+fieldType;
	}
	forSeller = $("select[name = 'forSeller']").val();
	if(forSeller){
		url += '&forSeller='+forSeller;
	}

	location = url;
}
</script>

<?php echo $footer; ?>