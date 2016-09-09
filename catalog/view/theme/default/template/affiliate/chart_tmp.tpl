<?php echo $header;   ?>
<div class="container">
	  

 <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>


<div class="container-fluid">
<div class="row">
<div class="<?php echo $class; ?>">
<div class="panel panel-default">

	<div class="panel-heading">
	  	
	    <!--div class="pull-left"-->	    
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
	    </td></tr></table>
	    
	  </div>
	  <div class="panel-body">
	    <div id="chart-sale" style="width: 100%; height: 260px;"></div>
	  </div>	 
	  
	</div>

<script type="text/javascript" src="thebugmanage/view/javascript/jquery/flot/jquery.flot.js"></script> 
<script type="text/javascript" src="thebugmanage/view/javascript/jquery/flot/jquery.flot.resize.min.js"></script>
<script type="text/javascript"><!--
$('#range a').on('click', function(e) {
	e.preventDefault();
	
	$(this).parent().parent().find('li').removeClass('active');
	
	$(this).parent().addClass('active');
	
	$.ajax({
		type: 'get',
		url: 'index.php?route=affiliate/chart/chart&range=' + $(this).attr('href'),
		dataType: 'json',
		success: function(json) {
                        if (typeof json['order'] == 'undefined') { return false; }
			var option = {	
				shadowSize: 0,
				colors: ['#9FD5F1', '#1065D2'],
				bars: { 
					show: true,
					fill: true,
					lineWidth: 1
				},
				grid: {
					backgroundColor: '#FFFFFF',
					hoverable: true
				},
				points: {
					show: false
				},
				xaxis: {
					show: true,
            		ticks: json['xaxis']
				}
			}
			
			$.plot('#chart-sale', [json['order'], json['customer']], option);	
					
			$('#chart-sale').bind('plothover', function(event, pos, item) {
				$('.tooltip').remove();
			  
				if (item) {
					$('<div id="tooltip" class="tooltip top in"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + item.datapoint[1].toFixed(2) + '</div></div>').prependTo('body');
					
					$('#tooltip').css({
						position: 'absolute',
						left: item.pageX - ($('#tooltip').outerWidth() / 2),
						top: item.pageY - $('#tooltip').outerHeight(),
						pointer: 'cusror'
					}).fadeIn('slow');	
					
					$('#chart-sale').css('cursor', 'pointer');		
			  	} else {
					$('#chart-sale').css('cursor', 'auto');
				}
			});
		},
        error: function(xhr, ajaxOptions, thrownError) {
           alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});

$('#range .active a').trigger('click');
//--></script>

</div>
</div>
</div>
</div>

<?php echo $footer; ?>
