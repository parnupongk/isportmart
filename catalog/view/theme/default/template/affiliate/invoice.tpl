<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--title><?php //echo $heading_title; ?></title-->
<?php if($data['payment_code'] == 'cod'){?>
<!--title> ใบส่งของ </title-->
<title> ใบรายการสั่งซื้อ </title>
<?php }else{?>
<!--title>ใบส่งของ / ใบเสร็จรับเงิน</title-->
<title> ใบรายการสั่งซื้อ </title>
<?php }?>
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

</head>
<body >
<div class="container">
      
      <?php if($data['payment_code'] == 'cod'){?>
			<!--h1>ใบส่งของ </h1-->
			<h1>ใบรายการสั่งซื้อ </h1>			
			<?php }else{?>
			<!--h1>ใบส่งของ / ใบเสร็จรับเงิน </h1-->
			<h1>ใบรายการสั่งซื้อ </h1>			
			<?php }?>
      <table class="table table-bordered">
        <!--<thead>
          <tr>
            <td class="text-left" colspan="2"><b><?php echo $text_order_detail; ?></b></td>
          </tr>
        </thead>-->
        <tbody>
          <tr>
            <td class="text-left" style="width: 50%;">
           <address>
            <strong><?php echo $store_name; ?></strong><br />
            <strong><?php echo $store_owner; ?></strong><br />
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
            	<b><?php echo $text_order_id; ?></b>&nbsp;&nbsp;<?php echo $order_id; ?><br />             
            	<?php if ($invoice_no) { ?>
              <b><?php //echo $text_invoice_no; ?>เลขที่:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <?php echo $invoice_no; ?><br />
              <?php } ?>            	
              <br />
            	<b><?php echo $text_date_added; ?></b> &nbsp;&nbsp;<?php echo $date_added; ?><br />
              <br />
               
            	<?php if ($payment_method) { ?>
              <b><?php echo $text_payment_method; ?></b>&nbsp;&nbsp; <?php echo $payment_method; ?><br />
              <?php } ?>
              <?php if ($shipping_method) { ?>
              <b><?php echo $text_shipping_method; ?></b> &nbsp;&nbsp;<?php echo $shipping_method; ?>
              <?php } ?></td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td class="text-left" style="width: 50%;"><b><?php //echo $text_payment_address; ?>ออกใบเสร็จในนาม</b></td>
            <?php if ($shipping_address) { ?>
            <td class="text-left"><b><?php echo $text_shipping_address; ?></b></td>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left"><?php echo $payment_address; ?>
            	<br /><b><?php echo $text_telephone; ?></b> <?php echo $cust_telephone; ?></td>
            <?php if ($shipping_address) { ?>
            <td class="text-left"><?php echo $shipping_address; ?>
            		<br /><b><?php echo $text_comment.":"; ?></b> <?php if(empty($cust_comment)){ echo "-";
            		}else{echo $cust_comment; } ?>
            	
            	</td>
            <?php } ?>
          </tr>
        </tbody>
      </table>
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
              <td class="text-right" style="width: 16%;"><b><?php //echo $column_total; ?>จำนวนเงิน(บาท)</b></td>
            
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
              <td colspan="4"></td>
              
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
      <?php if($data['payment_code'] != 'cod'){?>
       <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="text-left" style="width: 50%;">
            	
            	<!--input type='checkbox'>&nbsp;&nbsp;<?php //echo $text_change_invoice; ?><br-->
            	<input type='checkbox'>&nbsp;&nbsp;<?php echo $text_reject_invoice; ?>&nbsp;&nbsp; ระบุสาเหตุ : <br>
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	<input type='text' size=40>
            	<br><br>
            	<input type='checkbox'>&nbsp;&nbsp;<?php echo $text_confirm_invoice; ?><br>
            	&nbsp;<p><br>&nbsp;<p>
            	<?php echo $text_reciever; ?><p>
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เขียนชื่อตัวบรรจง<b>
            <?php //echo '(  ' . $shipping_customer_name . '  )'; ?></b>
            	</td>
            <td class="text-center" style="width: 50%;">
            	ใบเสร็จรับเงินนี้จะสมบูรณ์ต่อเมื่อได้รับเงินเรียบร้อยแล้ว
            	<br><br>
            	<?php echo $text_approve_invoice_name; ?>&nbsp;
            	<?php 
            		//echo $cheque; 
            		echo $store_owner; 
            	?> 
            	<br>
            		<img src="image/isport_sign.png"><br>
            	_________________________________________________<br>
            	<?php echo $text_approve_invoice; ?></td>
           
          </tr>
        </tbody>
      </table>
			<?php }?>
			
</div>
</body>
</html>