<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--title><?php //echo $heading_title; ?></title-->
<?php if($data['payment_code'] == 'cod'){?>
<!--title> ใบส่งของ </title-->
<title>ใบสั่งซื้อ #<?php echo  $order_id;  echo $data['payment_code']; ?> </title>
<?php }else{?>
<!--title>ใบส่งของ / ใบเสร็จรับเงิน</title-->
<title>ใบสั่งซื้อ #<?php echo  $order_id;  echo $data['payment_code']; ?> </title>
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
<style>
@media print { div.page-break { display: block; page-break-before: always;margin-left:2px;  } }

</style>
</head>
<body >
<?php

function get_browser_name($user_agent)
{
    if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge')) return 'Edge';
    elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
    elseif (strpos($user_agent, 'Safari')) return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
    
    return 'Other';
}

// Usage:

//echo get_browser_name($_SERVER['HTTP_USER_AGENT']);

?>

<?php if( get_browser_name($_SERVER['HTTP_USER_AGENT']) == 'Internet Explorer' || get_browser_name($_SERVER['HTTP_USER_AGENT']) == 'Edge' ) { ?>
<div> <h1>Printer not support , please print with chrome Browser</h1> </div>
<?php } else { ?>


  <?php if($data['payment_code'] == 'cod'){?>
<div class="page-break">
   <table class="table table-bordered" style="height:175px;width:280px;">
          <thead>
        <tr>
          <td style="width: 50%;"><b>ผู้ส่ง</b></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width: 50%;"><address>
            <strong><?php echo $store_name; ?></strong><br />
            <strong><?php echo $store_owner; ?></strong><br />
            <?php echo $store_address; ?>
            </address>
            <b><?php echo $text_telephone; ?></b> <?php echo $store_telephone; ?><br />
            <?php if ($store_fax) { ?>
            <b><?php echo $text_fax; ?></b> <?php echo $order['store_fax']; ?><br />
            <?php } ?>
        </tr>
      </tbody>
    </table>
    </div>
<?php }?>
<div class="page-break">

    <table class="table table-bordered" style="height:175px;width:280px;">
          <thead>
        <tr>
          <td style="width: 50%;"><b>ผู้ส่ง</b></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width: 50%;"><address>
            <strong><?php echo $store_name; ?></strong><br />
            <strong><?php echo $store_owner; ?></strong><br />
            <?php echo $store_address; ?>
            </address>
            <b><?php echo $text_telephone; ?></b> <?php echo $store_telephone; ?><br />
            <?php if ($store_fax) { ?>
            <b><?php echo $text_fax; ?></b> <?php echo $order['store_fax']; ?><br />
            <?php } ?>
        </tr>
      </tbody>
    </table>
</div>
<div class="page-break">

    <table class="table table-bordered" style="height:175px;width:280px;">
      <thead>
        <tr>
          <td style="width: 50%;"><b>ผู้รับ</b></td>
          <!--td style="width: 50%;"><b><?php echo $text_ship_to; ?></b></td-->
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><address>
            <?php echo $shipping_address; ?>
            <br /><b><?php echo $text_telephone; ?></b> <?php echo $cust_telephone; ?>
            </address>
            </td>
        </tr>
      </tbody>
    </table>
    </div>

<div class="page-break">

<table class="table table-bordered">
<tr><td colspan='2'>ใบสั่งซื้อ #<?php echo  $order_id; ?> การชำระเงิน <?php echo $data['payment_code']; ?></td></tr>
            <?php 
            	$cnt = 0;
            	foreach ($products as $product) { 
            		$cnt = $cnt + 1;
            ?>
            
            <tr>
              <!-- td class="text-left"><?php echo $product['model']; ?><?php echo $product['name']; ?></td -->
              <td class="text-left">
                <?php foreach ($product['option'] as $option) { ?>
                &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                <?php } ?></td>
              <td class="text-right"><?php echo $product['quantity']; ?></td>
            </tr>
          
            <?php } ?>
              </table>
</div>

<script>
window.print();
</script>

<?php }?>
</body>

</html>