<?php echo $header; ?>
<div class="container"> 
  	<div class="row">
	    <?php $class = 'col-sm-12'; ?>
	    
    <div id="content" class="<?php echo $class; ?>">
		<div class="panel panel-primary">
			<div class="panel-heading" style="font-size:18px;font-weight:bold;"><?php echo $heading_title; ?></div>
			<div class="panel-body" >
				<ul class="nav nav-tabs">
			    	<li class="active"><a href="#tab-current-auction" data-toggle="tab"><?php echo $text_currentAuct; ?></a></li>
			        <li><a href="#tab-recent-winners" data-toggle="tab"><?php echo $text_recentWinner; ?></a></li>
			    </ul>
			    <div class="tab-content">
        		<div class="tab-pane active" id="tab-current-auction"> 
        			<!-- for category list-->
				<column id="column-left" class="col-sm-3 hidden-xs">
				<div class="list-group">
					
						<a class="list-group-item active" value="" onclick="filter(this.value);"><?php echo $text_allProduct; ?></a>
						<?php if($categories){ ?>
						<? foreach($categories as $category) {?>
							<a class="list-group-item" value="<?php echo $category['category_id']?>" onclick="filter(this);"><?php echo $category['name']; ?></a>
						<?php } ?>
					<?php } ?>

				</div>
				</column>        			
			<div class="row col-sm-9">          
				<?php if($allauctions){	   
				$i = 0;	
				foreach ($allauctions as $product) {   ?>		   
			    <div class="product-layout product-grid col-lg-4 col-md-8 col-sm-8 col-xs-12">
			        <div class="product-thumb seller-thumb" id="<?php echo $product['product_id']; ?>">
			            <div class="image"><a href="<?php echo $product['href']; ?>" ><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
			            </div><!--image-->
	              	<div>
		                <div class="caption text-center" style="min-height:20px;">
		                  <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>                  
		                </div><!--caption-->
		                <div class="details_info" style="display:none;">
		                    <table class="table">
						      <tr><td><span><?php echo $text_sTime; ?></span></td><td>:</td><td><span ><?php echo $product['austart']; ?></span></td></tr>
						      <tr><td><span><?php echo $text_eTime; ?></span></td><td>:</td><td><span><?php echo $product['auend']; ?></span></td></tr>
						      <tr><td><span><?php echo $text_minBid; ?></span></td><td>:</td><td><span ><?php echo $product['aumin']; ?></span></td></tr>
						      <tr><td><span><?php echo $text_maxBid; ?></span></td><td>:</td><td><span ><?php echo $product['aumax']; ?></span></td></tr>
						  	</table>			                  
		                 	<br/>
		                <div class="text-center">
		                    <a type="button" class="btn btn-primary" data-toggle="tooltip" title="Bid Now" href="<?php echo $product['href']; ?>"><i class="fa fa-hand-o-right"></i><span><?php echo $text_bidNow; ?></span></a>
		           		</div>   <!--text-center- BUTTON-->   
		                </div>  <!--details_info-->             
			            <div class="clear"></div>

			        <div class="button-group">
		                <div class="panel-heading Timer">
				   		<div id="countdown_dashboard<?php echo $i; ?>">
						    <div class="dash weeks_dash">
							    <div class="digit">0</div>
							    <div class="digit">0</div>
						    </div>

						    <div class="dash days_dash">
							    <div class="digit">0</div>
							    <div class="digit">0</div>
						    </div>

						    <div class="dash hours_dash">
							    <div class="digit">0</div>
							    <div class="digit">0</div>
						    </div>

						    <div class="dash minutes_dash">
							    <div class="digit">0</div>
							    <div class="digit">0</div>
						    </div>

						    <div class="dash seconds_dash">
							    <div class="digit">0</div>
							    <div class="digit">0</div>
						    </div>
					    </div><!--countdown_dashboard--> 
				      	</div><!--panel-heading Timer-->  
				      	<?php 
				$sa=explode(" ",$product['auend']);
			 	$dat=explode("-",$sa[0]);
   				$tim=explode(":",$sa[1]);    						 				
   				if($tim[0] >= date("H") && $tim[1] >= date("i")){
				  $tim[0] = $tim[0] - date("H");
				  $tim[1] = $tim[1] - date("i");
				}else if($tim[0] <= date("H") && $tim[1] >= date("i")){
				  $tim[1] = $tim[1] - date("i");
				  $tim[0] = 0;
				}else if($tim[0] <= date("H") && $tim[1] <= date("i")){
				  $tim[1] = $tim[1] + (60 - date("i"));
				  $tim[1] = 0;
				}else if($tim[0] >= date("H") && $tim[1] <= date("i")){
				  $tim[0] = ($tim[0] - date("H")) - 1;
				  $tim[1] = $tim[1] + (60 - date("i"));
				}				
				?>
			
			<script type="text/javascript">
				start();
				function start(){
				id = <?php echo $i; ?>;
				D = new Date();
				y = D.getFullYear();
				mo = D.getMonth();
				d = D.getDate();
				h = D.getHours()
				m = D.getMinutes();
				s = D.getSeconds();	
				d = <?php echo $dat[2]; ?>;	

				if(h+<?php echo $tim[0]; ?> >= 24){
				  d = d+1;
				  h = (h+<?php echo $tim[0]; ?> - 24);
				}else{
				  h = h+<?php echo $tim[0]; ?>;
				}
				if(m+<?php echo $tim[1]; ?> >= 60){
				  h = h+1;
				  m = (m+<?php echo $tim[1]; ?> - 60);
				}else{
				  m = m+<?php echo $tim[1]; ?>;
				}

				$('#countdown_dashboard'+id).countDown({
					targetDate: {
						'day': 		d,
						'month': 	<?php echo $dat[1]; ?>,
						'year': 	<?php echo $dat[0]; ?>,
						'hour': 	h,
						'min': 		m,
						'sec': 		0,
					}
				});
				};
			</script>
						<i class="fa fa-clock-o" style="font-size:21px;left:10px;top:9px;"></i>
			        </div><!--button-group-->  
			    </div><!--div-->  
			</div><!--product-thumb-->
			</div><!--product-layout-->
			<?php  $i++;  }
			}else{ ?>
				<div id="noproduct"><?php echo $entry_empty; ?></div>
			<?php }	 ?>
			</div><!--row-->
			<div class="row">
				<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
		        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
		      </div>
		</div><!--tab-current-auction-->
		<div class="tab-pane " id="tab-recent-winners"> 

			<?php if($recentWinners){				
			foreach($recentWinners as $winner){ ?>
				<div class="winnercontainer">
					<div class="winningBid">
						<span><?php echo $text_winnerBid; ?><?php echo $winner['winningBid']; ?></span>
					</div>
					<div class="winningProductImage">
						<img src="<?php echo $winner['productImage']; ?>" title="<?php echo $winner['productName']; ?>" />
					</div>
					<div class="winnerName">
					    <span><?php echo $text_winnerName; ?><?php echo $winner['winnerName']; ?></span>
					</div>
				</div>
			<?php } } ?>

		</div><!--tab-recent-winners-->
	</div><!--tab-content-->
</div><!--panel-body-->		 	
</div><!--panel-primary-->
	</div><!--content-->
	</div><!--row-->
</div><!--container-->

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery("ul#mpauctionul").quickPagination({pageSize:"12"});
});
</script>

<div class="pagination"><?php echo $pagination; ?> </div>
<script type="text/javascript">
function addTobid(saas) { 
	this.document.location.href = saas;
}				
function filter(data){
	var val = $(data).attr('value');
	url = 'index.php?route=catalog/wkallauctions';
    if(val){
    	url += '&category='+val;
    }
    url += '<?php if(isset($this->request->get['page'])) echo "&page=".$this->request->get['page']; ?>';
    location = url;
}
var details_display = function (data){
  thisid = data.currentTarget.id; //get id of current selector

  $('#'+ thisid + ' .details_info').slideDown(); 
  $('#'+ thisid).unbind('mouseenter');
}
var details_hide = function (data){
  thisid = data.currentTarget.id; //get id of current selector
  $('#'+ thisid + ' .details_info').slideUp('slow',function(){
    $('.seller-thumb').bind('mouseenter',details_display);
  }); 
}
$('.seller-thumb').bind({'mouseenter' : details_display,'mouseleave':details_hide });

</script>

<?php echo $footer; ?>