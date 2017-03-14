<h3><?php echo $heading_title; ?></h3>

<div id="wk_auctioncarousel<?php echo $module; ?>" class="owl-carousel auctioncarousal">
 <?php if(isset($auction_products) && $auction_products){     
        foreach ($auction_products as $product) {   ?>      
              <div class="item text-center" style="border:1px solid #DDDDDD;margin:5px;">
                  <div class="product-thumb seller-thumb" id="<?php echo $product['product_id']; ?>">
                       <a href="<?php echo $product['href']; ?>" ><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>

                        <div>
                          <div class="caption text-center" style="min-height:20px;">
                            <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                          </div><!--caption-->
                    
                          <table class="table">                  
                          <tr><td><span><?php echo $text_bidnow; ?></span></td><td>:</td><td><span ><?php echo $product['pricebid']; ?></span></td></tr>
                            <!-- tr><td><span><?php echo $text_minbid; ?></span></td><td>:</td><td><span ><?php echo $product['aumin']; ?></span></td></tr -->
                            <!-- tr><td><span><?php echo $text_maxbid; ?></span></td><td>:</td><td><span ><?php echo $product['aumax']; ?></span></td></tr -->
                          </table>                        
                          <br/>
                          <div class="text-center"><a type="button" class="btn btn-primary" data-toggle="tooltip" title="Bid Now" href="<?php echo $product['href']; ?>"><i class="fa fa-hand-o-right"></i><span><?php echo $text_bidnow; ?></span></a></div>   <!--text-center- BUTTON-->   
                           
                          <div class="clear"></div>

                            <div class="button-group">
                              <div class="panel-heading Timer">
              
                                  <div id="countdown_dashboard<?php echo $product['product_id']; ?>"> 
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
                                  }elseif($tim[0] <= date("H") && $tim[1] >= date("i")){
                                    $tim[1] = $tim[1] - date("i");
                                    $tim[0] = 0;
                                  }elseif($tim[0] <= date("H") && $tim[1] <= date("i")){
                                    $tim[1] = $tim[1] + (60 - date("i"));
                                    $tim[1] = 0;
                                  }elseif($tim[0] >= date("H") && $tim[1] <= date("i")){
                                    $tim[0] = ($tim[0] - date("H")) - 1;
                                    $tim[1] = $tim[1] + (60 - date("i"));                                    
                                  }  
                                     
                                ?>    

                                <script type="text/javascript">
                                  start();
                                  function start(){
                                  id = <?php echo $product['product_id']; ?>;
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
                                      'day':    d,
                                      'month':  <?php echo $dat[1]; ?>,
                                      'year':   <?php echo $dat[0]; ?>,
                                      'hour':   h,
                                      'min':    m,
                                      'sec':    0,
                                    }
                                  });
                                  };
                                </script>
                                      <i class="fa fa-clock-o" style="font-size:21px;left:10px;top:9px;"></i>
                            </div><!--button-group-->  
                        </div><!--div-->  
                  </div><!--product-thumb-->
              </div><!--item text-center-->
              
       <?php }
      } ?>                      
    </div><!--owl-carousel-->


<script type="text/javascript"><!--
$(document).ready(function(){
  $('.auctioncarousal .owl-item').css("width", "250px");
}) 

$('#wk_auctioncarousel<?php echo $module; ?>').owlCarousel({
  items: 6,
  autoPlay: 3000,
  navigation: true,
  navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
  pagination: true
});

</script>