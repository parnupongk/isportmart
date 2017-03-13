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
	   <div id="container" style="min-width: 450px; height: 300px; margin: 0 auto"></div>
	  </div>	 
	  
	</div>
	<script type="text/javascript" src="highchart/jquery.min.js"></script>
<script type="text/javascript">
	$('#range a').on('click', function(e) {
	e.preventDefault();	
	$(this).parent().parent().find('li').removeClass('active');	
	$(this).parent().addClass('active');
			var options = {
	            chart: {
	                renderTo: 'container',
	                type: 'column',
	                marginRight: 130,
	                marginBottom: 25
	            },
	            title: {
	                text: 'Sales Analytics By '+$(this).attr('href'),
	                x: -20 //center
	            },
	            subtitle: {
	                text: '',
	                x: -20
	            },
	            xAxis: {
	                categories: []
	            },
	            yAxis: {
	                title: {
	                    text: 'Requests'
	                },
	                plotLines: [{
	                    value: 0,
	                    width: 1,
	                    color: '#808080'
	                }]
	            },
	            tooltip: {
	                formatter: function() {
	                        return '<b>'+ this.series.name +'</b><br/>'+
	                        this.x +': '+ this.y;
	                }
	            },
	            legend: {
	            	itemStyle: {
                 		font: '8pt Trebuchet MS, Verdana, sans-serif'
              		},
	                layout: 'vertical',
	                align: 'right',
	                verticalAlign: 'top',
	                x: 20,
	                y: 150,
	                borderWidth: 0
	            },
	            series: []
	          //   series: [{name:"Cancel", data:[0, 2, 1, 1, 0, 2, 0, 2, 3, 0, 0]}, {name:"During Delivery", data:[0, 2, 1, 3, 5, 6, 0, 31, 32, 5, 3]}, {name:"Deliver to Customer", data:[2, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0]}, {name:"Deliver cancel", data:[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]}, {name:"Claim Refund", data:[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]}, {name:"Completed ", data:[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]}]
	        }
	        $.getJSON('data_columnchart.php?range='+$(this).attr('href')+'&affiliate_id='+$('input[name=\'affiliate_id\']').val(), function(json) {
				//options.series[0].data = json;
	        	//chart = new Highcharts.Chart(options);
	        	options.xAxis.categories = json[0]['data'];
	        	options.series[0] = json[1];
	        	options.series[1] = json[2];
	        	options.series[2] = json[3];
	        	options.series[3] = json[4];
	        	options.series[4] = json[5];
	        	options.series[5] = json[6];
	        	options.series[6] = json[7];
	        	options.series[7] = json[8];
	        	//alert( json.toSource());
		        chart = new Highcharts.Chart(options);
	        });
	        
	        
	        
      	});   
$('#range .active a').trigger('click');
		</script>
		<script src="highchart/highcharts.js"></script>
        <script src="highchart/exporting.js"></script>
</div><!-- add content -->
    <?php echo $column_right; ?></div>
</div>
  </div>
<?php echo $footer; ?>
</html>
