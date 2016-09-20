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
    	<div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>
      <!--<p><?php echo $text_balance; ?> <strong>&nbsp;<?php echo $total_trans; ?></strong></p>-->
      <div class="table-responsive">
 	<table id="myTable" class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-center"><?php echo $column_date_modified; ?></td>
              <td class="text-center"><?php echo $column_order_id; ?></td>
              <td class="text-center"><?php echo $column_status; ?></td>
              <td class="text-center"><?php echo $text_action; ?></td>            
            </tr>
          </thead>
          <tbody>
          <?php if ($transactions) {  ?>
            <?php foreach ($transactions  as $transaction) { ?>
            <tr onclick="javascript:run(this);">
              <td class="text-center"><?php echo $transaction['date_modified']; ?></td>
              <td class="text-center"><?php echo $transaction['order_id']; ?></td>
              <?php  if($transaction['order_status_id'] == 3){ ?>
             	<td class="text-center text-success"><?php echo $transaction['status']; ?></td>   	
             <?php  }else if($transaction['order_status_id'] == 22 ||$transaction['order_status_id'] == 23){ ?>
             	<td class="text-center text-warning"><?php echo $transaction['status']; ?></td>   	
             <?php	}else if($transaction['order_status_id'] == 25 ||$transaction['order_status_id'] == 26||$transaction['order_status_id'] == 27){ ?>
             <td class="text-center text-danger"><?php echo $transaction['status']; ?></td>   	
             <?php	}else{ ?>
             <td class="text-center"><?php echo $transaction['status']; ?></td>   	
               <?php	} ?>	
               	
             <td class="text-left"> 
             <?php if ($transaction['order_status_id'] == '15' || $transaction['order_status_id'] == '2') {  ?>
             	<a href="<?php echo $transaction['approve']; ?>" data-toggle="tooltip" title="<?php echo $button_approve; ?>" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;<i class="fa fa-long-arrow-right "></i>
             <?php }else{ ?>
             <a href="<?php echo $transaction['invoice']; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></a>
             <!-- bom add 2016/09/02-->
             <a href="<?php echo $transaction['addressPrint']; ?>" target="_blank" data-toggle="tooltip" title="print address" class="btn btn-success"><i class="fa fa-print"></i></a>                
             <a href="<?php echo $transaction['updateBarcodeStock']; ?>" data-toggle="tooltip" title="update barcode stock" class="btn btn-primary"><i class="fa fa-barcode"></i></button></a>
             <a href="<?php echo $transaction['showHistory']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></button></a>             		 

              <?php } ?>
              <?php if($transaction['download_id'] and $transaction['order_status_id'] == '3' || $transaction['order_status_id'] == '27'){?>
               &nbsp;<i class="fa fa-long-arrow-right "></i><a href="<?php echo $transaction['showDownload']; ?>" data-toggle="tooltip" title="<?php echo $button_file; ?>" class="btn btn-default"><i class="fa fa-file-image-o"></i></button></a>             		 
              <?php } ?>
             		</td>
              </tr>
              <?php } ?>
           <?php }  ?>
           
          <tbody>
        </table>
      </div>
      <div class="text-right"><?php echo $pagination; ?></div>
  <div class="text-right"><?php echo $results; ?></div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
  </div>
<script type="text/javascript">
/*function run(){
    document.getElementById('myTable').onclick = function(event){
        event = event || window.event; //for IE8 backward compatibility
        var target = event.target || event.srcElement; //for IE8 backward compatibility
        while (target && target.nodeName != 'TR') {
            target = target.parentElement;
        }
        var cells = target.cells; //cells collection
        //var cells = target.getElementsByTagName('td'); //alternative
        if (!cells.length || target.parentNode.nodeName == 'THEAD') { // if clicked row is within thead
            return;
        }
 }
      
  	var table = document.getElementById("myTable");
if (table != null) {
    for (var i = 0; i < table.rows.length; i++) {
        for (var j = 0; j < table.rows[i].cells.length; j++)
        table.rows[i].cells[j].onclick = function () {
            //tableText(this);
    var text = $(this).text();
    $(this).text('');
    $('<input type="text" />').appendTo($(this)).val(text).select().blur(
      function() {
        var newText = $(this).val();
        $(this).parent().text(newText), find('input:text').remove();
      });  
        };        
    }
}
function tableText(tableCell) {
    alert(tableCell.innerHTML);
	}
}*/
</script>
<?php echo $footer; ?>