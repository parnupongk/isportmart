<!DOCTYPE HTML>
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
    <div id="content" class="<?php echo $class; ?>">
  <!-- add content-->
    <div class="panel panel-default">

	<div class="panel-heading"> 
	    <table width=100%><tr><td width=90%>
	    		<h3 class="panel-title" align=left><i class="fa fa-bar-chart-o"></i> <?php echo $heading_title; ?></h3>
	    </td><td width=10%>
			<div class="dropdown" align=right>
				<a aria-expanded="" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-calendar"></i> <i class="caret"></i></a>	    	
			      <ul id="range" class="dropdown-menu dropdown-menu-right">
			        <li><a href="day"><?php echo $text_day; ?></a></li>
			        <li><a href="week"><?php echo $text_week; ?></a></li>
			        <li class="active"><a href="month"><?php echo $text_month; ?></a></li>
			        <li><a href="year"><?php echo $text_year; ?></a></li>
			      </ul>	      
		    </div>
		    <input type='hidden' id="affiliate_id" name="affiliate_id" value="<?php echo $affiliate_id; ?> " >
	    </td></tr></table>
	</div>
	  <div class="panel-body">
	    <div id="container" style="min-width: 400px; height: 300px; margin: 0 auto"></div>
	  </div>	 
	  
	</div>
<script type="text/javascript">
	$('#range a').on('click', function(e) {
	e.preventDefault();	
	$(this).parent().parent().find('li').removeClass('active');	
	$(this).parent().addClass('active');
			var options = {
				chart: {
	                renderTo: 'container',
	                plotBackgroundColor: null,
	                plotBorderWidth: null,
	                plotShadow: false
	            },
	            title: {
	                  text: 'Sales Analytics By '+$(this).attr('href'),
	            },
	            tooltip: {
	                formatter: function() {
	                    //return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
	                    return Highcharts.numberFormat(this.percentage, 2) + '%<br />' + '<b>' + '<br />Status: ' + this.point.name + '</b><br />Value: ' + Highcharts.numberFormat(this.y, 2);
	                }
	            },
	            plotOptions: {
	                pie: {
	                    allowPointSelect: true,
	                    cursor: 'pointer',
	                    dataLabels: {
	                        enabled: true,
	                        color: '#000000',
	                        connectorColor: '#000000',
	                        formatter: function() {
	                            //return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
	                             return Highcharts.numberFormat(this.percentage, 2) + '% | Status: ' + this.point.name + '</b> | ' + Highcharts.numberFormat(this.y, 2);
	                        }
	                    }
	                }
	            },
	            series: [{
	                type: 'pie',
	                name: 'Browser share',
	                data: []
	            }]
	        }
	        $.getJSON('data_piechart.php?range='+$(this).attr('href')+'&affiliate_id='+$('input[name=\'affiliate_id\']').val(), function(json) {
				options.series[0].data = json;
	        	chart = new Highcharts.Chart(options);
	        });
	        
	        
	        
      	});   
$('#range .active a').trigger('click');
		</script>
		<script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
</div><!-- add content -->
    <?php echo $column_right; ?></div>
</div>
  </div>
<?php echo $footer; ?>
</html>
