<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"> <?php echo $breadcrumb['text']; ?> </a> </li>
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
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <p><?php echo $text_balance; ?> <strong>&nbsp;<?php echo $total_trans; ?></strong></p>
      <div class="table-responsive">
 	<table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-center"><?php echo $column_date_modified; ?></td>
              <td class="text-center"><?php echo $column_order_id; ?></td>
              <td class="text-center"><?php echo $column_status; ?></td>
              <td class="text-center"><?php echo $text_action; ?></td>
              <td class="text-center"><?php echo $text_DocDelivery; ?></td>               
            </tr>
          </thead>
          <tbody>
          	   <?php if ($transactions) {  ?>
            <?php foreach ($transactions  as $transaction) { ?>
            <tr>
              <td class="text-center"><?php echo $transaction['date_modified']; ?></td>
              <td class="text-center">
              	 <a href="<?php echo $transaction['showHistory']; ?>" ><?php echo $transaction['order_id']; ?></a>
              </td>
             <?php  if($transaction['order_status_id'] == 3){ ?>
             	<td class="text-center text-success"><?php echo $transaction['status']; ?></td>   	
             <?php  }else if($transaction['order_status_id'] == 22 ||$transaction['order_status_id'] == 23){ ?>
             	<td class="text-center text-warning"><?php echo $transaction['status']; ?></td>   	
             <?php	}else if($transaction['order_status_id'] == 25 ||$transaction['order_status_id'] == 26||$transaction['order_status_id'] == 27){ ?>
             <td class="text-center text-danger"><?php echo $transaction['status']; ?></td>   	
             <?php	}else{ ?>
             <td class="text-center"><?php echo $transaction['status']; ?></td>   	
               <?php	} ?>			
               <td class="text-center">
             <?php if ($transaction['order_status_id'] == '15') {  ?>
                    <a href="<?php echo $transaction['approve']; ?>" data-toggle="tooltip" title="<?php echo $button_approve; ?>" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;<i class="fa fa-long-arrow-right "></i>
             		 <button type="button" class="btn btn-default " disabled><i class="fa fa-truck"></i></button>&nbsp;<i class="fa fa-long-arrow-right "></i>
                    <button type="button" class="btn btn-default " disabled><i class="fa fa-user"></i></button>&nbsp;<i class="fa fa-long-arrow-right "></i>
             		 <button type="button" class="btn btn-default " disabled><i class="fa fa-check-square-o"></i></button>
            
             <?php } else if($transaction['order_status_id'] == '19'){ ?>
             		 <button type="button" class="btn btn-default" disabled><i class="fa fa-thumbs-o-up"></i></button>&nbsp;<i class="fa fa-long-arrow-right "></i>
                    <a href="<?php echo $transaction['updateStatusID']; ?>" data-toggle="tooltip" title="<?php echo $button_order_status_19; ?>" class="btn btn-success"><i class="fa fa-truck"></i></button></a>&nbsp;<i class="fa fa-long-arrow-right "></i>             		 
                    <button type="button" class="btn btn-default " disabled><i class="fa fa-user"></i></button>&nbsp;<i class="fa fa-long-arrow-right "></i>
             		 <button type="button" class="btn btn-default " disabled><i class="fa fa-check-square-o"></i></button>
             <?php }else  if ($transaction['order_status_id'] == '20') {  ?>
              <form id="form <?php echo $transaction['order_id']?>">
              <div class="col-md-8">
               <select  id="input-order-status_form" class="form-control">
                      <?php foreach ($order_statuses as $order_statuse) { ?>
                      <?php if ($order_statuse['order_status_id'] == $transaction['order_status_id']) { ?>
                      <option value="<?php echo $order_statuse['order_status_id']; ?>" selected="selected"><?php echo $order_statuse['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_statuse['order_status_id']; ?>"><?php echo $order_statuse['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>  
                     <button id="btn<?php echo $transaction['order_id']?>"  onclick="myFunction((this.form)" type="button" class="btn btn-success " ><i class="fa fa-user"></i></button>&nbsp;<i class="fa fa-long-arrow-right "></i>
                    <button type="button" class="btn btn-default " disabled><i class="fa fa-check-square-o"></i></button>                                                           
               	 <input type="hidden" id="order_id_form" name="order_id_form" value="<?php echo $transaction['order_id']; ?>">
                    <input type="hidden" id="affiliate_id_form" name="affiliate_id_form" value="<?php echo $transaction['affiliate_id']; ?>">                                  
                    </div>&nbsp;&nbsp;
                  </form>
              <?php }else  if ($transaction['order_status_id'] == '22') {  ?>
              <form id="form <?php echo $transaction['order_id']?>">
                <div class="col-md-8">
               <select name="order_status_id_form" id="input-order-status_form" class="form-control">
                      <?php foreach ($order_statuses as $order_statuse) { ?>
                      <?php if ($order_statuse['order_status_id'] == $transaction['order_status_id']) { ?>
                      <option value="<?php echo $order_statuse['order_status_id']; ?>" selected="selected"><?php echo $order_statuse['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_statuse['order_status_id']; ?>"><?php echo $order_statuse['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>  
                      <button id="btn<?php echo $transaction['order_id']?>"  onclick="myFunction(this.form)" type="button"  class="btn btn-warning " ><i class="fa fa-user"></i></button>&nbsp;<i class="fa fa-long-arrow-right "></i>            		              		  
                    <button type="button" class="btn btn-default " disabled><i class="fa fa-check-square-o"></i></button>                                                           
               	  <input type="hidden" id="order_id_form" name="order_id_form" value="<?php echo $transaction['order_id']; ?>">
                    <input type="hidden" id="affiliate_id_form" name="affiliate_id_form" value="<?php echo $transaction['affiliate_id']; ?>">                                  
                    </div>&nbsp;&nbsp;
                  </form>
              <?php }else  if ($transaction['order_status_id'] == '23') {  ?>
              <form id="form <?php echo $transaction['order_id']?>">
                 <div class="col-md-8">
               <select name="order_status_id_form" id="input-order-status_form" class="form-control">
                      <?php foreach ($order_statuses as $order_statuse) { ?>
                      <?php if ($order_statuse['order_status_id'] == $transaction['order_status_id']) { ?>
                      <option value="<?php echo $order_statuse['order_status_id']; ?>" selected="selected"><?php echo $order_statuse['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_statuse['order_status_id']; ?>"><?php echo $order_statuse['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>  
                     <button id="btn<?php echo $transaction['order_id']?>"  onclick="myFunction(this.form)" type="button"  class="btn btn-warning " ><i class="fa fa-user"></i></button>&nbsp;<i class="fa fa-long-arrow-right "></i>            		              		  
                    <button type="button" class="btn btn-default " disabled><i class="fa fa-check-square-o"></i></button>                                                           
                    <input type="hidden" id="order_id_form" name="order_id_form" value="<?php echo $transaction['order_id']; ?>">
                    <input type="hidden" id="affiliate_id_form" name="affiliate_id_form" value="<?php echo $transaction['affiliate_id']; ?>">                                  
                    </div>&nbsp;&nbsp;
                  </form>
               <?php }else  if ($transaction['order_status_id'] == '25') {  ?>
               <form id="form <?php echo $transaction['order_id']?>">
                  <div class="col-md-8">
               <select name="order_status_id_form" id="input-order-status_form" class="form-control">
                      <?php foreach ($order_statuses as $order_statuse) { ?>
                      <?php if ($order_statuse['order_status_id'] == $transaction['order_status_id']) { ?>
                      <option value="<?php echo $order_statuse['order_status_id']; ?>" selected="selected"><?php echo $order_statuse['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_statuse['order_status_id']; ?>"><?php echo $order_statuse['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>  
                    <button id="btn<?php echo $transaction['order_id']?>"  onclick="myFunction(this.form)" type="button"  class="btn btn-danger " ><i class="fa fa-user"></i></button>&nbsp;<i class="fa fa-long-arrow-right "></i>          		 
             		   <button type="button" class="btn btn-default " disabled><i class="fa fa-check-square-o"></i></button>                                                           
                     <input type="hidden" id="order_id_form" name="order_id_form" value="<?php echo $transaction['order_id']; ?>">
                    <input type="hidden" id="affiliate_id_form" name="affiliate_id_form" value="<?php echo $transaction['affiliate_id']; ?>">                                  
                    </div>&nbsp;&nbsp;
                  </form>
              <?php }else  if ($transaction['order_status_id'] == '26') {  ?>
              <form id="form <?php echo $transaction['order_id']?>">
                    <div class="col-md-8">
               <select name="order_status_id_form" id="input-order-status_form" class="form-control">
                      <?php foreach ($order_statuses as $order_statuse) { ?>
                      <?php if ($order_statuse['order_status_id'] == $transaction['order_status_id']) { ?>
                      <option value="<?php echo $order_statuse['order_status_id']; ?>" selected="selected"><?php echo $order_statuse['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_statuse['order_status_id']; ?>"><?php echo $order_statuse['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>  
                     <button id="btn<?php echo $transaction['order_id']?>"  onclick="myFunction(this.form)" type="button"  class="btn btn-danger " ><i class="fa fa-user"></i></button>&nbsp;<i class="fa fa-long-arrow-right "></i>          		 
             		   <input type="hidden" id="order_id_form" name="order_id_form" value="<?php echo $transaction['order_id']; ?>">
                    <input type="hidden" id="affiliate_id_form" name="affiliate_id_form" value="<?php echo $transaction['affiliate_id']; ?>">                                  
                    </div>&nbsp;&nbsp;
                  </form>
                    <?php }else if($transaction['order_status_id'] == '3' ){ ?>                 
                  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-download" class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-10">
              <div class="input-group">
                <input type="text" name="filename" value="<?php echo $filename; ?>" placeholder="<?php echo $entry_filename; ?>" id="input-filename" class="form-control" />
                 <input type="hidden" name="mask" value="">
                 <input type="hidden" name="order_id_upload" value="<?php echo $transaction['order_id']; ?> ">
                <span class="input-group-btn">
                <button type="button" id="button-upload" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>&nbsp;
                <button type="submit" form="form-download" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-success "><i class="fa fa-save"></i></button>
       		  </span> </div>
              <?php if ($error_filename) { ?>
              <div class="text-danger"><?php echo $error_filename; ?></div>
              <?php } ?>
            </div>
          </div>          
        </form>
        <?php }else if($transaction['order_status_id'] == '27'){ ?>     
                 <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-download" class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-10">
              <div class="input-group">
                <input type="text" name="filename" value="<?php echo $filename; ?>" placeholder="<?php echo $entry_filename; ?>" id="input-filename" class="form-control" />
                 <input type="hidden" name="mask" value="">
                 <input type="hidden" name="order_id_upload" value="<?php echo $transaction['order_id']; ?> ">
                <span class="input-group-btn">
                <button type="button" id="button-upload" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>&nbsp;
                <button type="submit" form="form-download" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-danger "><i class="fa fa-save"></i></button>
       		  </span> </div>
              <?php if ($error_filename) { ?>
              <div class="text-danger"><?php echo $error_filename; ?></div>
              <?php } ?>
            </div>
          </div>          
        </form>
             
             <?php }  ?>
              </td>
             <?php }  ?>
           </tr>
       <?php }  ?>
          <tbody>
        </table>
      </div>
      <div class="text-right"><?php echo $pagination; ?></div>
  <div class="text-right"><?php echo $results; ?></div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
  </div>

  <script type="text/javascript"><!--  	
function myFunction(elem) {
    var affiliate_id = $('#affiliate_id_form').val();
    var order_id    = $('#order_id_form').val();
     var order_status_id = $('select[name="order_status_id_form"]').val();
         alert(elem.id+'---'+order_status_id);
}
/*$('#button-history-order').on('click', function() {
  var affiliate_id = $('#affiliate_id_form').val();
  var order_id    = $('#order_id_form').val();
  var button_history_order    = $('#button-history-order').val();
  
  var order_status_id = $('select[name="order_status_id_form"]').val();
  alert(order_status_id);
	var datastring = {};
							$.ajax({
								type:'POST',
								url:'index.php?route=affiliate/order/approved&affiliate_id='+affiliate_id+'&order_id='+order_id+'&order_status_id='+order_status_id,
								data:datastring,
								waitMsg:'Loading...',
								beforeSend: function() {
								$('#button-history-order').button('loading');			
								},
								complete: function() {
								$('#button-history-order').button('reset');	
								},success:function(data){
									 location.reload();
									// alert(data);
								}
							});				
});*/
$('#button-upload').on('click', function() {
	$('#form-upload').remove();
	
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');
	
	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}
	
	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);		
  var affiliate_id = $('#affiliate_id_form').val();			
			$.ajax({
				url: 'index.php?route=affiliate/order/upload',
				type: 'post',		
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
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
						$('input[name=\'order_id_upload\']').attr('value', json['order_id_upload']);
						
					}
				},			
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script> 
<?php echo $footer; ?>