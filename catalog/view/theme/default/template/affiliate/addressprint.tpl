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
<div id="footer">

  <div style="page-break-after: always;">
   
    <table class="table table-bordered">
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
    <table class="table table-bordered" style="margin-bottom:-20px;">
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
            </address></td>
          <!--td><address>
            <?php echo $order['shipping_address']; ?>
            </address></td-->
        </tr>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>