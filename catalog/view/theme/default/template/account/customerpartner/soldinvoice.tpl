<?php if($chkIsPartner AND !$errorPage){ ?>
<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
  <meta charset="UTF-8" />
  <title><?php echo $heading_title; ?></title>
  <base href="<?php echo $base; ?>" />
  <!--<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
  <script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> -->
  <link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" /> 
  <link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
  <link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
</head>
<body>
<div class="container">

  <div style="page-break-after: always;">
    <h1>
      <?php echo $heading_title?><?php echo $text_order; ?> # <?php echo $order_id;?> 
      <div class="pull-right">
        <button type="button" class="btn btn-primary" data-toggle="tooltip" title="<?php echo $text_print_invoice; ?>" onclick="printinvoice();"><i class="fa fa-print"></i></button> 
      </div>
    </h1>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td colspan="2"><?php echo $text_order_info; ?></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width: 50%;"><div>
            <strong><?php echo $order['store_name']; ?></strong><br />
            <?php echo $order['store_address']; ?>
            </div>
            <b><?php echo $text_telephone; ?></b> 
            <?php echo $order['store_telephone']; ?>
            <br />

            <?php if ($order['store_fax']) { ?>
              <b><?php echo $text_fax; ?></b> <?php echo $order['store_fax']; ?><br />
            <?php } ?>
            <b><?php echo $text_email; ?></b> <?php echo $order['store_email']; ?><br />
            <b><?php echo $text_website; ?></b> <a href="<?php echo $order['store_url']; ?>"><?php echo $order['store_url']; ?></a></td>

          <td style="width: 50%;">
            <b><?php echo $text_order_date; ?></b> <?php echo $order['date_added']; ?><br />
            <?php if ($invoice_no) { ?>
            <b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br />
            <?php } ?>
            <b><?php echo $text_order_id; ?></b> <?php echo $order_id; ?><br />
            <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
            <?php if ($shipping_method) { ?>
              <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?><br />
            <?php } ?></td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td style="width: 50%;"><b><?php echo $text_billing_address; ?></b></td>
          <td style="width: 50%;"><b><?php echo $text_shipping_address; ?></b></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><address>
            <?php echo $payment_address; ?>
            <br/><?php echo $email; ?>
            </address></td>
          <td><address>
            <?php echo $shipping_address; ?>
            </address></td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td><b><?php echo $text_product; ?></b></td>
          <td><b><?php echo $entry_model; ?></b></td>
          <td class="text-right"><b><?php echo $text_qty; ?></b></td>
          <td class="text-right"><b><?php echo $text_price; ?></b></td>
          <td class="text-right"><b><?php echo $text_total_row; ?></b></td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product) { ?>
        <tr>
          <td><?php echo $product['name']; ?>
            <?php foreach ($product['option'] as $option) { ?>
            <br />
            &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
            <?php } ?>
          </td>
          <td><?php echo $product['model']; ?></td>
          <td class="text-right"><?php echo $product['quantity']; ?></td>
          <td class="text-right"><?php echo $product['price']; ?></td>
          <td class="text-right"><?php echo $product['total']; ?></td>
        </tr>
        <?php } ?>
        <?php foreach ($totals as $total) { ?>
        <tr>
          <td class="text-right" colspan="4"><b><?php echo $total['title']; ?></b></td>
          <td class="text-right"><?php echo $total['text']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php if (isset($comment)) { ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td><b><?php echo $column_comment; ?></b></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $order['comment']; ?></td>
        </tr>
      </tbody>
    </table>
    <?php } ?>
  </div>

</div>
</body>
</html>
<script>
function printinvoice(){
  window.print();
}
</script>
<?php } ?>
