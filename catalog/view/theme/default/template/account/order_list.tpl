<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
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
      <?php if ($orders) { ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-right"><?php echo $column_order_id; ?></td>
              <td class="text-left"><?php echo $column_status; ?></td>
              <td class="text-left"><?php echo $column_date_added; ?></td>
              <td class="text-right"><?php echo $column_product; ?></td>
              <td class="text-left"><?php echo $column_customer; ?></td>
              <td class="text-right"><?php echo $column_total; ?></td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $order) { ?>
            <tr>
              <td class="text-right">#<?php echo $order['order_id']; ?></td>
              <td class="text-left"><?php echo $order['status']; ?></td>
              <td class="text-left"><?php echo $order['date_added']; ?></td>
              <td class="text-right"><?php echo $order['products']; ?></td>
              <td class="text-left"><?php echo $order['name']; ?></td>
              <td class="text-right"><?php echo $order['total']; ?></td>
			  <td class="text-right">
			   <!--<a href="<?php echo $order['href_conf']; ?>" data-toggle="tooltip" title="Update Status" class="btn btn-primary"><i class="fa fa-edit"></i></a>-->
		<?php if (($order['laststatus'] == '1')||($order['laststatus'] == '10')||($order['laststatus'] == '28')) { ?>
			  <a href="<?php echo $order['href_conf']; ?>" data-toggle="tooltip" title="<?php echo $btn_confirm; ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
		<?php } ?>
				<a href="<?php echo $order['href_comp']; ?>" data-toggle="tooltip" title="<?php echo $btn_complaint; ?>#<?php echo $order['order_id']; ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
				
              <a href="<?php echo $order['href']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
			  </td>
            </tr>
			<?php } ?>
          </tbody>
        </table>
      </div>
	  
	<script type="text/javascript">  
	function popup(url,name,windowWidth,windowHeight){      
		myleft=(screen.width)?(screen.width-windowWidth)/2:100;   
		mytop=(screen.height)?(screen.height-windowHeight)/2:100;     
		properties = "width="+windowWidth+",height="+windowHeight;  
		properties +=",scrollbars=yes, top="+mytop+",left="+myleft;     
		window.open(url,name,properties);  
	}  
	</script> 

      <div class="text-right"><?php echo $pagination; ?></div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>