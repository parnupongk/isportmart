<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
	<?php 
          	if (strpos($_SERVER['HTTP_HOST'], '203.149.') !== false ) {
          		$vhost = $_SERVER['HTTP_HOST'] . "/ishop";
          	} else {
          		$vhost = $_SERVER['HTTP_HOST'];
          	}	
?>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $heading_title; ?></title>
<base href="<?php echo $base; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="catalog/view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="all" />
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>

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
</head>
<header>
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div id="logo">
                    <h1>iSportMart</a></h1>
                  </div>
      </div>
    </div>
  </div>
</header>
<body >
<div class="container">
<?php //echo $data['order_status_id']; ?>
	<?php if($data['order_status_id']=='1'){ ?>	
      <h1><?php echo $heading_title; ?> # <?php echo $order_id; ?></h1>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td class="text-left" colspan="2"><b><?php echo $text_order_detail; ?></b></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left" style="width: 50%;">
           <address>
            <strong><?php echo $store_name; ?></strong><br />
            <?php echo $store_address; ?>
            </address>
            <b><?php echo $text_telephone; ?></b> <?php echo $store_telephone; ?><br />
            <?php if ($store_fax) { ?>
            <b><?php echo $text_fax; ?></b> <?php echo $store_fax; ?><br />
            <?php } ?>
            <b><?php echo $text_email; ?></b> <?php echo $store_email; ?><br />
            <b><?php echo $text_website; ?></b> <a href="<?php echo $store_url; ?>"><?php echo $store_url; ?></a>
            </td>
            <td class="text-left">
            	<b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?><br />
            	<?php if ($invoice_no) { ?>
              <b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br />
              <?php } ?>
              <b><?php echo $text_order_id; ?></b>&nbsp;<?php echo $order_id; ?><br />              
            	<?php if ($payment_method) { ?>
              <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
              <?php } ?>
              <?php if ($shipping_method) { ?>
              <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
              <?php } ?></td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td class="text-left" style="width: 50%;"><b><?php echo $text_payment_address; ?></b></td>
            <?php if ($shipping_address) { ?>
            <td class="text-left"><b><?php echo $text_shipping_address; ?></b></td>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left"><?php echo $payment_address; ?></td>
            <?php if ($shipping_address) { ?>
            <td class="text-left"><?php echo $shipping_address; ?></td>
            <?php } ?>
          </tr>
        </tbody>
      </table>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left"><b><?php echo $column_name; ?></b></td>
              <td class="text-left"><b><?php echo $column_model; ?></b></td>
              <td class="text-right"><b><?php echo $column_quantity; ?></b></td>
              <td class="text-right"><b><?php echo $column_price; ?></b></td>
              <td class="text-right"><b><?php echo $column_total; ?></b></td>
            
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
              <td class="text-left"><?php echo $product['name']; ?>
                <?php foreach ($product['option'] as $option) { ?>
                <br />
                &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                <?php } ?></td>
              <td class="text-left"><?php echo $product['model']; ?></td>
              <td class="text-right"><?php echo $product['quantity']; ?></td>
              <td class="text-right"><?php echo $product['price']; ?></td>
              <td class="text-right"><?php echo $product['total']; ?></td>
            </tr>
            <?php } ?>
            <?php foreach ($vouchers as $voucher) { ?>
            <tr>
              <td class="text-left"><?php echo $voucher['description']; ?></td>
              <td class="text-left"></td>
              <td class="text-right">1</td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>           
            </tr>
            <?php } ?>
          </tbody>
          <tfoot>
            <?php foreach ($totals as $total) { ?>
            <tr>
              <td colspan="3"></td>
              <td class="text-right"><b><?php echo $total['title']; ?></b></td>
              <td class="text-right"><?php echo $total['text']; ?></td>            
            </tr>
            <?php } ?>
          </tfoot>
        </table>
      </div>
      <?php if ($comment) { ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td class="text-left"><?php echo $text_comment; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left"><?php echo $comment; ?></td>
          </tr>
        </tbody>
      </table>
      <?php } ?>
      <?php }else{ ?>
        <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> History </h3>
      </div>
        <p><h5> Your order Number:  <strong>&nbsp;<?php echo $order_id; ?></strong></h5>
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
	      <!--<td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>-->
	    </tr>
	    <?php } ?>
	  </tbody>
	</table>
	</div>
	<?php } ?>
  <?php if($data['order_status_id']=='1'){ ?>  
  <div id="pay">
  <fieldset>
    <legend>แจ้งการชำระเงิน</legend>
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
                <button type="submit"  form="form-download" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-success "><i class="fa fa-save"></i> ยืนยันและอัพโหลดรูปภาพ</button>
            </span> </div>
              <?php if ($error_filename) { ?>
              <div class="text-danger"><?php echo $error_filename; ?></div>
              <?php } ?>
              <img id="filePreview" style="display:none;"><br>
            หากคุณต้องการรายละเอียด วิธีการชำระเงิน กรุณาคลิก <a target = '_blank' href="<?php echo $vhost ?>/how2pay.html">วิธีการชำระเงิน</a> ของเรา
            </div>
          </div>          
        </form>
  <fieldset>
  </div>
 <!--<b><font size='2' color="blue"> <p id="demo"></p></font></b>-->
  <?php } ?>
</div>
<!--<div class="container">
  <ul class="breadcrumb">
        <li><i class="fa fa-star-o"></i></li>
        <li><a target = '_blank' href="<?php echo $vhost ?>/how2pay.html">ขั้นตอนการชำระเงิน >>>> คลิ๊ก <<<</a></li>
      </ul>
</div>-->
</body>
<footer>
   <div class="container">
<p>iSportMart &copy; 2016 </p>  </div> 
</footer>
</html>
<script type="text/javascript">
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

if( filename != "" && mask != "" )
{
      $.ajax({
          type: "POST",
          url: "index.php?route=affiliate/order/confirm_pay",
          data: "filename=" + filename + "&mask=" + mask+ "&order_id_upload=" + order_id_upload+ "&affiliate_id_form=" + affiliate_id_form,
          success: function(){
           //var txt ='ขอบคุณสำหรับหลักฐานการโอนเงินค่ะ หากมีข้อสงสัยสอบถามที่เบอร์ 02-502-6505';
           // $("#pay").hide();
           // document.getElementById("demo").innerHTML = txt;
           alert("ขอบคุณสำหรับหลักฐานการโอนเงินค่ะ หากมีข้อสงสัยสอบถามที่เบอร์ 02-502-6505");
            location.reload();
          }
          });
          
  }
  else{
    alert("การเพิ่มรูปไม่สำเร็จกรุณาติดต่อที่เบอร์ 02-502-6505");
  }

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
