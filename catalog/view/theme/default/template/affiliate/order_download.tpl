<?php 
          	if (strpos($_SERVER['HTTP_HOST'], '203.149.') !== false ) {
          		$vhost = $_SERVER['HTTP_HOST'] . "/ishop";
          	} else {
          		$vhost = $_SERVER['HTTP_HOST'];
          	}	
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8" />
<title></title>
<link href="http://<?php echo $vhost ?> /catalog/view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="http://<?php echo $vhost ?>/catalog/view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="http://<?php echo $vhost ?>/catalog/view/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="http://<?php echo $vhost ?>/catalog/view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link type="text/css" href="http://<?php echo $vhost; ?>/catalog/view/stylesheet/stylesheet.css" rel="stylesheet" media="all" />
</head>
<body>
<div class="container">
  <?php foreach ($file_down as $file_download) { ?>
  <div style="page-break-after: always;">
<?php  
    echo "<img src=http://" .$vhost . "/system/download/".$file_download['name']."><br>Date added:" . $file_download['name'].$file_download['date_added'] . "<br>"; 
  ?>
  <?php } ?>
<a href="<?php echo $back; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
</div>
</body>
</html>