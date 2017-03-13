<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1><br/>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  
  <div class="container-fluid">
    <div class="panel panel-default">
    	<div class="panel-body">
    		
 	  	<a href="http://report.samartbug.com/ishop/isportmart.php" target="_blank">Report : Sale report for Accounting</a>
 	  	<br/><br/> 	  	
	  	<a href="http://report.samartbug.com/ishop/isportmart.php" target="_blank">Report : Product and option in Order </a>  	
      
        <!--div class="table-responsive"-->
		<!--iframe width="100%"  height="500" src="http://report.samartbug.com/ishop/isportmart.php"></iframe--> 
        <!--/div-->
      </div>
    </div>
  </div>
</div>  
  
<?php echo $footer; ?>