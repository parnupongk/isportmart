<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a class="btn btn-danger" href="<?php echo $remove_url; ?>" data-toggle="tooltip" data-original-title="<?php echo $button_reset_filter; ?>">
					<i class="fa fa-eraser"></i>
				</a>
				<!-- <span class="label bg-primary"><?php echo $grand_total_paid; ?></span>
				<span class="label bg-primary"><?php echo $grand_total_admin; ?></span>
				<span class="label bg-primary"><?php echo $grand_total_rem; ?></span> -->
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
		<div class="panel panel-default">
			<div class="panel-heading">
        		<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
			</div>
			<div class="panel-body">
				<div class="well">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label"><?php echo $text_seller_name; ?></label>
								<input type="text" class="form-control" placeholder="<?php echo $text_seller_name ?>" name="filter_seller_name" value="<?php echo $seller_name; ?>" />
							</div>
							<div class="form-group">
								<label class="control-label"><?php echo $text_seller_amount; ?></label>
								<div class="input-group">
									<span class="input-group-addon">
										<?php echo $text_from; ?>
									</span>
									<input type="text" class="form-control" placeholder="<?php echo $text_from; ?>" name="filter_seller_amount_from" value="<?php echo $seller_amount_from; ?>" />
									<span class="input-group-addon">
										<?php echo $text_to; ?>
									</span>
									<input type="text" class="form-control" placeholder="<?php echo $text_to ?>" name="filter_seller_amount_to" value="<?php echo $seller_amount_to; ?>" />
								</div>
							</div>
							
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label"><?php echo $text_commission; ?></label>
								<div class="input-group">
									<span class="input-group-addon">
										<?php echo $text_from; ?>
									</span>
									<input type="text" class="form-control" placeholder="<?php echo $text_from; ?>" name="filter_commission_from" value="<?php echo $commission_from; ?>" />
									<span class="input-group-addon">
										<?php echo $text_to; ?>
									</span>
									<input type="text" class="form-control" placeholder="<?php echo $text_to ?>" name="filter_commission_to" value="<?php echo $commission_to; ?>" />
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label"><?php echo $text_admin_amount; ?></label>
								<div class="input-group">
									<span class="input-group-addon">
										<?php echo $text_from; ?>
									</span>
									<input type="text" class="form-control" placeholder="<?php echo $text_from; ?>" name="filter_admin_amount_from" value="<?php echo $admin_amount_from; ?>" />
									<span class="input-group-addon">
										<?php echo $text_to; ?>
									</span>
									<input type="text" class="form-control" placeholder="<?php echo $text_to ?>" name="filter_admin_amount_to" value="<?php echo $admin_amount_to; ?>" />
								</div>
							</div>
							<!-- <div class="form-group">
								<label class="control-label">
									<?php echo $text_paid_to_seller; ?>
								</label>
								<div class="input-group">
									<span class="input-group-addon">
										<?php echo $text_from; ?>
									</span>
									<input type="text" class="form-control" placeholder="<?php echo $text_from; ?>" name="filter_paid_to_seller_from" value="<?php echo $paid_to_seller_from; ?>" />
									<span class="input-group-addon">
										<?php echo $text_to; ?>
									</span>
									<input type="text" class="form-control" placeholder="<?php echo $text_to ?>" name="filter_paid_to_seller_to" value="<?php echo $paid_to_seller_to; ?>" />
								</div>
							</div> -->
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label"><?php echo $text_total_amount; ?></label>
								<div class="input-group">
									<span class="input-group-addon">
										<?php echo $text_from; ?>
									</span>
									<input type="text" class="form-control" placeholder="<?php echo $text_from; ?>" name="filter_total_amount_from" value="<?php echo $total_amount_from; ?>" />
									<span class="input-group-addon">
										<?php echo $text_to; ?>
									</span>
									<input type="text" class="form-control" placeholder="<?php echo $text_to ?>" name="filter_total_amount_to" value="<?php echo $total_amount_to; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">
									<?php echo $text_date_added; ?>
								</label>
								<div class="input-group datetime">
									<span class="input-group-addon ">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" class="form-control datetimefrom" placeholder="<?php echo $text_from; ?>" name="filter_date_added_from" value="<?php echo $date_added_from; ?>" />
									<span class="input-group-addon ">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" class="form-control datetimeto" placeholder="<?php echo $text_to; ?>" name="filter_date_added_to" value="<?php echo $date_added_to; ?>" />
								</div>
							</div>
							<!-- <div class="form-group">
								<label class="control-label">
									<?php echo $text_seller_name; ?>
								</label>
								<input type="text" class="form-control" placeholder="<?php echo $text_commission ?>" />
							</div> -->
							<button class="btn btn-primary pull-right" type="button" onclick="Filter()">
								<i class="fa fa-filter"></i>
								<?php echo $button_filter; ?>
							</button>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-left">
									<a href="<?php echo $seller_name_url; ?>" class="<?php if(isset($order) && $order == 'c.firstname') echo $sort; ?> ">
										<?php echo $text_seller_name; ?>
									</a>
								</th>
								<th class="text-left">
									<a href="<?php echo $seller_commission_url; ?>" class="<?php if(isset($order) && $order == 'cp2c.commission') echo $sort; ?> ">
										<?php echo $text_commission; ?>
									</a>
								</th>
								<th class="text-left">
									<a href="<?php echo $total_url; ?>" class="<?php if(isset($order) && $order == 'total') echo $sort; ?> ">
										<?php echo $text_total_amount; ?>
									</a>
								</th>
								<th class="text-left">
									<a href="<?php echo $customer_url; ?>" class="<?php if(isset($order) && $order == 'customer') echo $sort; ?> ">
										<?php echo $text_seller_amount; ?>
									</a>
								</th>
								<th class="text-left">
									<a href="<?php echo $admin_url; ?>" class="<?php if(isset($order) && $order == 'admin') echo $sort; ?> ">
										<?php echo $text_admin_amount; ?>
									</a>
								</th>
								<th class="text-left">
									<!-- <a > -->
										<?php echo $text_paid_to_seller; ?>
									<!-- </a> -->
								</th>
								<th class="text-left">
									<!-- <a > -->
										<?php echo $text_rem_amount; ?>
									<!-- </a> -->
								</th>
								<th class="text-center">
									<?php echo $text_action; ?>
								</th>
							</tr>
						</thead>
						<?php if($income_details) { 
							foreach ($income_details as $key => $income_detail) { ?>
							<tr>
								<td class="text-left">
									<a href="<?php echo $income_detail['dashborad_url']; ?>" target="_blank" data-toggle="tooltip" data-original-title="<?php echo $income_detail['firstname'].$text_dashboard; ?>" >
										<?php echo  $income_detail['seller_name']; ?>
									</a>
								</td>
								<td class="text-left">
									<?php echo $income_detail['commission']; ?>
								</td>
								<td class="text-left">
									<?php echo $income_detail['total']; ?>
								</td>
								<td class="text-left">
									<?php echo $income_detail['seller_total']; ?>
								</td>
								<td class="text-left">
									<?php echo $income_detail['admin_total']; ?>
								</td>
								<td class="text-left">
									<?php echo $income_detail['paid_total']; ?>
								</td>
								<td class="text-left">
									<?php echo $income_detail['amount_to_pay']; ?>
								</td>
								<td class="text-center">
									<a href="<?php echo $income_detail['pay_link']; ?>" class="btn btn-primary" <?php if($income_detail['button_status']) echo "disabled"; ?> >
										<?php echo $income_detail['pay']; ?>
									</a>
								</td>
							</tr>
						<?php } ?>
							<tr>
								<td class="text-center" colspan="2">
									<b><?php echo $text_grand_total; ?></b>
								</td>
								<td>
									<?php echo $grand_total; ?>
								</td>
								<td>
									<?php echo $grand_total_seller; ?>
								</td>
								<td>
									<?php echo $grand_total_admin; ?>
								</td>
								<td>
									<?php echo $grand_total_paid; ?>
								</td>
								<td>
									<?php echo $grand_total_rem; ?>
								</td>
							</tr>
						<?php } else { ?>
						<tr>
							<td colspan="8" class="text-center"><?php echo $no_records; ?></td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<div class="row">
					<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
					<div class="col-sm-6 text-right"><?php echo $results; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$('.datetimefrom').datetimepicker({
		pickDate: true,
		pickTime: true,
		format: 'YYYY-MM-DD HH:MM:SS'
	});
	$('.datetimeto').datetimepicker({
		pickDate: true,
		pickTime: true,
		format: 'YYYY-MM-DD HH:MM:SS'
	});
	
	function Filter(){
		url = "index.php?route=customerpartner/income&token=<?php echo $token; ?>";
		seller_name = $('input[name="filter_seller_name"]').val();
		if(seller_name) {
			url += '&seller_name='+seller_name;
		}
		commission_from = $('input[name="filter_commission_from"]').val();
		if(commission_from) {
			url += '&commission_from='+commission_from;
		}
		commission_to = $('input[name="filter_commission_to"]').val();
		if(commission_to) {
			url += '&commission_to='+commission_to;
		}
		total_amount_from = $('input[name="filter_total_amount_from"]').val();
		if(total_amount_from) {
			url += '&total_amount_from='+total_amount_from;
		}
		total_amount_to = $('input[name="filter_total_amount_to"]').val();
		if(total_amount_to) {
			url += '&total_amount_to='+total_amount_to;
		}
		seller_amount_from = $('input[name="filter_seller_amount_from"]').val();
		if(seller_amount_from) {
			url += '&seller_amount_from='+seller_amount_from;
		}
		seller_amount_to = $('input[name="filter_seller_amount_to"]').val();
		if(seller_amount_to) {
			url += '&seller_amount_to='+seller_amount_to;
		}
		admin_amount_from = $('input[name="filter_admin_amount_from"]').val();
		if(admin_amount_from) {
			url += '&admin_amount_from='+admin_amount_from;
		}
		admin_amount_to = $('input[name="filter_admin_amount_to"]').val();
		if(admin_amount_to) {
			url += '&admin_amount_to='+admin_amount_to;
		}
		paid_to_seller_from = $('input[name="filter_paid_to_seller_from"]').val();
		if(paid_to_seller_from) {
			url += '&paid_to_seller_from='+paid_to_seller_from;
		}
		paid_to_seller_to = $('input[name="filter_paid_to_seller_to"]').val();
		if(paid_to_seller_to) {
			url += '&paid_to_seller_to='+paid_to_seller_to;
		}
		// rem_amount_from = $('input[name="filter_rem_amount_from"]').val();
		// if(rem_amount_from) {
		// 	url += '&rem_amount_from='+rem_amount_from;
		// }
		// rem_amount_to = $('input[name="filter_rem_amount_to"]').val();
		// if(rem_amount_to) {
		// 	url += '&rem_amount_to='+rem_amount_to;
		// }
		date_added_from = $('input[name="filter_date_added_from"]').val();
		if(date_added_from) {
			url += '&date_added_from='+date_added_from;
		}
		date_added_to = $('input[name="filter_date_added_to"]').val();
		if(date_added_to) {
			url += '&date_added_to='+date_added_to;
		}

		location = url;
	}

	$('input[name=\'filter_seller_name\']').autocomplete({
	  delay: 0,
	  source: function(request, response) {
	    $.ajax({
	      url: 'index.php?route=customerpartner/partner/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request)+'&filter_view=' +  jQuery('#view_all').val(),
	      dataType: 'json',
	      success: function(json) {   
	        response($.map(json, function(item) {
	          return {
	            label: item.name,
	            value: item.id
	          }
	        }));
	      }
	    });
	  },
	  'select': function(item) {
	    $('input[name=\'filter_seller_name\']').val(item['label']);
	  }

	});
</script>

<?php echo $footer; ?>