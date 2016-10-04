
<?php echo $header; ?>
	<?php 
          	if (strpos($_SERVER['HTTP_HOST'], '203.149.') !== false ) {
          		$vhost = $_SERVER['HTTP_HOST'] . "/ishop";
          	} else {
          		$vhost = $_SERVER['HTTP_HOST'];
          	}	
?>
<style>
#filePreview {
    width: 180px;
    height: 180px;
    background-position: center center;
    background-size: cover;
    -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
    display: inline-block;
}
</style>
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
       <div class="pull-right"> <a href="<?php echo $back; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
    
     <!-- <h1><?php echo $history_title; ?></h1>-->
     <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $history_title; ?></h3>
      </div>
        <p><h5><?php echo $text_order; ?> <strong>&nbsp;<?php  echo $data['showOrder']; ?></strong></h5>
        </p>
     
     <div class="table-responsive">
 	<table class="table table-striped table-bordered table-hover" border = "1">
  <thead>
    <tr>
      <td class="text-left"><?php echo $column_date_added; ?></td>
       <td class="text-left"><?php echo $column_status; ?></td>
      <td class="text-left"><?php echo $column_comment; ?></td>
    </tr>
  </thead>
  <tbody>
    <?php if ($histories) { ?>
    <?php foreach ($histories as $history) { ?>
    <tr>
      <td class="text-left"><?php echo $history['date_added']; ?></td>
      <td class="text-left"><?php echo $history['status']; ?></td>
      <td class="text-left"><?php echo $history['comment']; ?></td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</div>

<div class="row">
  <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
  <div class="col-sm-6 text-right"><?php echo $results; ?></div>
</div>

<!-- bom add update barcode -->
<div class="table-responsive">
        <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left" colspan="6"><b><?php echo $text_order_detail; ?></b></td>
          </tr>
        </thead>
          <thead>
            <tr>
            <td class="text-left" style="width: 5%;"><b>รายการ</b></td>
              <td class="text-left" style="width: 10%;"><b><?php echo $column_model; ?></b></td>
              <td class="text-left"><b><?php echo $column_name; ?></b></td>
              <td class="text-right" style="width: 8%;"><b><?php echo $column_quantity; ?></b></td>
              <td class="text-right" style="width: 16%;"><b><?php echo $column_price; ?></b></td>
              <td class="text-right" style="width: 16%;"><b><?php //echo $column_total; ?>BarCode</b></td>
            
            </tr>
          </thead>
          <tbody>
            <?php 
            	$cnt = 0;
            	foreach ($products as $product) { 
            		$cnt = $cnt + 1;
            ?>
            <tr>
             <td class="text-center"><?php echo $cnt; ?>
              <td class="text-left"><?php echo $product['model']; ?></td>
              <td class="text-left"><?php echo $product['name']; ?>
                <?php foreach ($product['option'] as $option) { ?>
                <br />
                &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                <?php } ?></td>
              <td class="text-right"><?php echo $product['quantity']; ?></td>
              <td class="text-right"><?php echo $product['price']; ?></td>
              <td class="text-right"> 
              <textarea name="barcode" rows="1" id="input-barcode" class="form-control"></textarea>        
                    <div class="input-group btn-block" style="max-width: 200px;"> 
                    <?php echo $product['order_product_id']; ?>   
                    <span class="input-group-btn">                    
                    <button id='button-barcode' type="button" data-toggle="tooltip" title="" class="btn btn-primary" onclick="cart.remove('<?php echo $product['key']; ?>');"><i class="fa fa-barcode"></i></button></span></div>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
<!-- end update barcode -->

<?php if($order_status_id != 3 and $order_status_id != 27 and $order_status_id != 21 and $order_status_id != 24 and $order_status_id != 29){ ?>
<br>
<fieldset>
<legend><?php echo $text_history; ?></legend>
<form class="form-horizontal">
  <div class="form-group">
    <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
    <div class="col-sm-10">               
      <select name="order_status_id" id="input-order-status" class="form-control">
        <?php foreach ($order_statuses as $order_statuses) { ?>
        <?php if ($order_statuses['order_status_id'] == $order_status_id) { ?>
        <option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group">
   <label class="col-sm-2 control-label" for="input-comment"></label>
    <div class="col-sm-10">สำหรับบริการไปรษณีย์ กรุณากรอก <font color="blue">หมายเลขสิ่งของ</font> ที่กล่อง comment ด้านล่าง</div>
  </div>
  <div class="form-group">
   <label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
    <div class="col-sm-10">
      <textarea name="comment" rows="3" id="input-comment" class="form-control"></textarea>
    </div>
  </div>
</form>
<div class="text-right">
<input type="hidden" id="order_id_form" name="order_id_form" value="<?php echo $order_id; ?>">
<input type="hidden" id="affiliate_id_form" name="affiliate_id_form" value="<?php echo $affiliate_id; ?>">                                                   
<button id="button-history" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_history_add; ?></button>
</div>
</fieldset>
<?php }else{ ?>
<br>
<!--<fieldset>
<legend><?php echo $text_upload_head; ?></legend>
 <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-download" class="form-horizontal">
          <div class="form-group">
            <div class="<?php echo $class; ?>">
              <div class="input-group">
                <input type="text" name="filename" value="<?php echo $filename; ?>" placeholder="<?php echo $entry_filename; ?>" id="input-filename" class="form-control" />
                 <input type="hidden" name="mask" value="">
                 <input type="hidden" name="order_id_upload" value="<?php echo $order_id; ?> ">
                 <input type="hidden" name="affiliate_id_form" id="affiliate_id_form" value="<?php echo $affiliate_id; ?>">                                                   
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
</fieldset>-->
<div id="pay">
  <fieldset>
    <legend>แจ้งเอกสารการส่งของ</legend>
       <form  method="post" enctype="multipart/form-data" id="form-download" class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-12">
              <div class="input-group">
               <input type="text" name="filename" size="50" value="<?php echo $filename; ?>" placeholder="<?php echo $entry_filename; ?>" id="filename" class="form-control" />
                 <input type="hidden" id="mask" name="mask" value="">
                 <input type="hidden" id="order_id_upload" name="order_id_upload" value="<?php echo $order_id; ?> ">
                 <input type="hidden" id="affiliate_id_form" name="affiliate_id_form"  value="<?php echo $affiliate_id; ?>">                                                  
                <span class="input-group-btn">
               <button type="button" id="button-upload" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-upload"></i> เลือกรูปภาพ</button>&nbsp;
                <button type="submit" onclick="myFunction()" form="form-download" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-success "><i class="fa fa-save"></i> ยืนยันและอัพโหลดรูปภาพ</button>
            </span> </div>
              <?php if ($error_filename) { ?>
              <div class="text-danger"><?php echo $error_filename; ?></div>
              <?php } ?>
              <img id="filePreview" style="display:none;"><br>
            </div>
          </div>          
        </form>
  <fieldset>
  </div>
 <b><font size='2' color="blue"> <p id="demo"></p></font></b>
<?php } ?>



<?php echo $content_bottom; ?></div>
<?php echo $column_right; ?></div>
<script type="text/javascript">
$('#button-history').on('click', function() {
  var affiliate_id = $('#affiliate_id_form').val();
  var order_id    = $('#order_id_form').val();
  var order_status_id = $('select[name="order_status_id"]').val();
	var datastring = {};
							$.ajax({
								type:'POST',
								url:'index.php?route=affiliate/order/addOrderHistory&affiliate_id='+affiliate_id+'&order_id='+order_id+'&order_status_id='+order_status_id+   '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()),
								data:datastring,
								waitMsg:'Loading...',
								beforeSend: function() {
								$('#button-history').button('loading');			
								},
								complete: function() {
								$('#button-history').button('reset');	
								window.location.assign("http://<?php echo $vhost  ?>/index.php?route=affiliate/order")
         
								},success:function(data){
								  
									// location.reload();
									// alert(data);
								}
							});				
});
/*$('#button-upload').on('click', function() {
$('#form-upload').remove();
$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

$('#form-upload input[name=\'file\']').trigger('click');

if (typeof timer != 'undefined') {
  	clearInterval(timer);
}

timer = setInterval(function() {
	if ($('#form-upload input[name=\'file\']').val() != '') {
		clearInterval(timer);		
		
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
					$('input[name=\'affiliate_id_form\']').attr('value', json['affiliate_id_form']);
					
				}
			},			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}, 500);
});*/
var ref = '';
$(document).on('change','input[name="file"]',function(){
    ref = this;
});

function showImagePreview(input){

 if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#filePreview').attr('src',e.target.result);
        $('#filePreview').show();
    }
    reader.readAsDataURL(input.files[0]);
 }
}

       $("form#form-download").submit(function(event) {
       event.preventDefault();
         var filename = $("#filename").val();
         var mask = $("#mask").val();
         var order_id_upload = $("#order_id_upload").val();
         var affiliate_id_form = $("#affiliate_id_form").val();
         $.ajax({
          type: "POST",
          url: "index.php?route=affiliate/order/add_pay",
          data: "filename=" + filename + "&mask=" + mask+ "&order_id_upload=" + order_id_upload+ "&affiliate_id_form=" + affiliate_id_form,
          success: function(){
            var txt ='ขอบคุณสำหรับหลักฐานการส่งของ';
            $("#pay").hide();
            document.getElementById("demo").innerHTML = txt;
            window.location.assign("http://<?php echo $vhost  ?>/index.php?route=affiliate/order")
          }
          });
        });

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
           ref = '';
        }
              
        if (json['success']) {
          //alert(json['success']);
          showImagePreview(ref);
          $("#imagePreview").css("background-image", "url("+this.result+")");
          $('input[name=\'filename\']').attr('value', json['filename']);
          $('input[name=\'mask\']').attr('value', json['mask']);
          $('input[name=\'order_id_upload\']').attr('value', json['order_id_upload']);
          $('input[name=\'affiliate_id_form\']').attr('value', json['affiliate_id_form']);
          
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
 