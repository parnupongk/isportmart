<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link href="view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="all" />
</head>
<body style="width:500px,hight:600px;">
<!-- h4><?php echo $text_invoice; ?> #<?php echo $order['order_id']; ?></h4 -->
<div id="footer">
  <?php foreach ($orders as $order) { ?>
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
            <strong><?php echo $order['store_name']; ?></strong><br />
            <strong><?php echo $order['store_owner']; ?></strong><br />
            <?php echo $order['store_address']; ?>
            </address>
            <b><?php echo $text_telephone; ?></b> <?php echo $order['store_telephone']; ?><br />
            <?php if ($order['store_fax']) { ?>
            <b><?php echo $text_fax; ?></b> <?php echo $order['store_fax']; ?><br />
            <?php } ?>
            <!-- b><?php echo $text_email; ?></b> <?php echo $order['store_email']; ?><br /-->
            <!--b><?php echo $text_website; ?></b> <a href="<?php echo $order['store_url']; ?>"><?php echo $order['store_url']; ?></a--></td>
          <!--td style="width: 50%;">
          	<b><?php echo $text_order_id; ?></b> <?php echo $order['order_id']; ?><br />
            <?php if ($order['invoice_no']) { ?>
            <b><?php //echo $text_invoice_no; ?>เลขที่:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> <?php echo $order['invoice_no']; ?><br />
            <?php } ?>
            <br />
            <b><?php echo $text_date_added; ?></b> <?php echo $order['date_added']; ?><br />
            <br />
            <b><?php echo $text_payment_method; ?></b> <?php echo $order['payment_method']; ?><br />
            <?php if ($order['shipping_method']) { ?>
            <b><?php echo $text_shipping_method; ?></b> <?php echo $order['shipping_method']; ?><br />
            <?php } ?></td-->
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td style="width: 50%;"><b><?php echo $text_to; ?></b></td>
          <!--td style="width: 50%;"><b><?php echo $text_ship_to; ?></b></td-->
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><address>
            <?php echo $order['shipping_address']; ?>
            </address></td>
          <!--td><address>
            <?php echo $order['shipping_address']; ?>
            </address></td-->
        </tr>
      </tbody>
    </table>
  </div>
  <?php } ?>
</div>
</body>
</html>