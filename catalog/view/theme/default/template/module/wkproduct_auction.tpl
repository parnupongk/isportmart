<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" />
<?php 
 if($timeout==0){
      foreach($my_bids as $ibid){
       
       if($ibid['user_id']==$current_user && $ibid['winner']==1)
      { 
   if($endDate['end_date'] == $ibid['end_date']) {
      $wuser=$current_user;
         }
      }
    }
      if($wuser!=0){ ?>
          <div class="wkauction">
            <div id="aumain" class="" style="border-radius:10px"><?php echo $entry_winner; ?></div>
          </div>
          <?php 
      }
   }
   else{  
   $tbids=count($my_bids);
   if($auction_id){
    $sa=explode(" ",$end);
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
<style type="text/css">
.table_border{
  padding: 3px !important;
  border-top: none !important;
}
</style>
 <div id="msg"></div>
  
  <?php if(isset($bidmsg) && $bidmsg) { ?>
    <div class="alert alert-success text-center">
      <button class="close" data-dismiss="alert">&times;</button>
      <?php echo $bidmsg; ?>
    </div>
  <?php } ?>
<div class="wkauction">
<div class="panel panel-primary">

    <div class="modal fade" id="myModal-seller-mail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title"><b><?php echo $text_list_bids; ?></b></h3>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
            <table class="table table-bordered" style="margin:0;">         
              <?php if($bids){ ?>
              <thead>
                <tr><th class="text-left"><?php echo $text_name; ?></th><th class="text-left"><?php echo $text_bids; ?></th></tr>
              </thead>
              <tbody>
                <?php foreach($bids as $bid) { ?>
                <tr><td class="text-left"><?php echo $bid['name'];?></td><td class="text-left"><?php echo $bid['bid'];?></td></tr>
              <?php   }
              }else{  ?>
                  <tr><td colspan="2" class="text-center"><?php echo $text_nobids; ?></td></tr>
              <?php }?>
              </tbody>
            </table>
          </div><!--table-responsive-->
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Automatic auction -->
    <div class="modal fade" id="myModal-auto-bid" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="modal-title"><b><?php echo $text_list_bids; ?></b></h3>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
            <table class="table table-bordered" style="margin:0;">         
              <?php if(isset($auto_bids) && $auto_bids){ ?>
              <thead>
                <tr><th class="text-left"><?php echo $text_name; ?></th><th class="text-left"><?php echo $text_bids; ?></th></tr>
              </thead>
              <tbody>
                <?php foreach($auto_bids as $bid) { ?>
                <tr><td class="text-left"><?php echo $bid['name'];?></td><td class="text-left"><?php echo $bid['bid'];?></td></tr>
              <?php   }
              }else{  ?>
                  <tr><td colspan="2" class="text-center"><?php echo $text_nobids; ?></td></tr>
              <?php }?>
              </tbody>
            </table>
          </div><!--table-responsive-->
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

  <!-- Default panel contents -->
  <div class="panel-heading text-center"><?php echo $entry_auction; ?></div>
  <div class="panel-body">
    <div class="subheadcont">
  <div id="countdown_dashboard">
      <div class="dash weeks_dash">
        <div class="digit">0</div><div class="digit">0</div>
      </div>

      <div class="dash days_dash">
        <div class="digit">0</div><div class="digit">0</div>
      </div>

      <div class="dash hours_dash">
        <div class="digit">0</div><div class="digit">0</div>
      </div>

      <div class="dash minutes_dash">
        <div class="digit">0</div><div class="digit">0</div>
      </div>

      <div class="dash seconds_dash">
        <div class="digit">0</div><div class="digit">0</div>
      </div>

    </div>
    <i class="glyphicon glyphicon-time"></i>
        <div class="detailbutton">
          
          <div class="quantity_msg"><?php echo $text_quantity.$quant_limit?></div>
          <span class="btn btn-primary bid_details"><?php echo $text_biddetails; ?></span>&nbsp;
          <span class="btn btn-primary" data-toggle="modal" data-target="#myModal-seller-mail"><?php echo $text_bidlist; ?></span>
          
          <!-- Automatic auction -->
          <?php if ($wkproduct_auction_automatic_auction_status && $wkproduct_auction_automatic_bidders_detail_status) {?>
            <span class="btn btn-primary" data-toggle="modal" data-target="#myModal-auto-bid"><?php echo $text_auto_bidlist; ?></span>
          <?php } ?>
        </div>
        <div id="rangearea">   
          <div class="table-responsive">
              <table class="table">        
                <tr><td class="table_border"><?php echo $entry_bids; ?></td><td class="table_border"><?php echo $totalBids;?></td></tr>
                <?php if ($wkproduct_auction_automatic_auction_status) {?>
                <tr><td class="table_border"><?php echo $entry_total_bids; ?></td><td class="table_border"><?php echo $totalautoBids;?></td></tr>
                <?php } ?>
                <tr><td class="table_border"><?php echo $entry_min_price; ?></td><td class="table_border"><?php echo $min;?> </td></tr>
                <!--tr><td class="table_border"><?php echo $entry_max_price; ?></td><td class="table_border"><?php echo $max;?> </td></tr -->
                <tr><td class="table_border"><?php echo $entry_start_time; ?></td><td class="table_border"><?php echo substr($start,11,19);?> </td></tr>
                <tr><td class="table_border"><?php echo $entry_close_time; ?></td><td class="table_border"><?php echo substr($end,11,19);?></td></tr>
            </table>
          </div>
        </div> 
        <?php if ($wkproduct_auction_automatic_auction_status) {?>
        <div class="checkbox">
        <label>
          <input type="checkbox" class="automaticbid" name="automaticbid" value="1" ><p><b><?php echo $automatic_bid;?>
        </b></p></label>
        </div>
        <?php }?>
        <div id="tarea">
          <input type="text" id="bidamount" name="bidmount" class="form-control"/>
          <input type="button" id="bidbutton" class="btn btn-primary" value="<?php echo $text_bidnow; ?>" class="form-control"/>
        </div>
     
  </div>   
    <div class="subbids">
      <!-- <div id="cross"><img id="cimg" src="catalog/view/theme/default/image/crossButton.png"></div> -->
      <div class="bidme"></div>
    </div>
 
  </div>
</div>
</div><!--wkauction-->
</script>
<script type="text/javascript">
$('.bid_details').click(function(){
    $('#rangearea').slideToggle('slow');
});

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
        $('#countdown_dashboard').countDown({
          targetDate: {
            'day':    d,
            'month':  <?php echo $dat[1]; ?>,
            'year':   <?php echo $dat[0]; ?>,
            'hour':   h,
            'min':    m,
            'sec':    0,
          }
        });

$('#bidbutton').on('click',function(){
  var bid_amount= $('#bidamount').val();
  var value=<?php echo $currency_value; ?>;
  var amount=bid_amount/value;  
  var user=<?php echo $current_user;?>;
  var end_date='<?php echo $end;?>';
  var start_date='<?php echo $start;?>';
  var auction=<?php echo $auction_id;?>;
  var product_id=<?php echo $product_id;?>;

//automatic auction 
var automaticbid = $('input[name=\'automaticbid\']').prop('checked');

  if(!amount){

         $("#msg").html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $entry_bids_error; ?></div>');
         $("#msg").fadeIn('slow');
         $("#bidamount").attr('value','');
         setInterval(function(){$("#msg").fadeOut('slow')}, 10000);
  }
  else if(!$.isNumeric(amount)){    
        $("#msg").html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $entry_ammount_error; ?></div>');         
         $("#msg").fadeIn('slow');
         $("#bidamount").attr('value','');
          setInterval(function(){$("#msg").fadeOut('slow')}, 10000);
    }
  else if(user==0){
        $("#msg").html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $entry_login_error; ?></div>');
         $("#msg").fadeIn('slow');
         $("#bidamount").attr('value','');
         setInterval(function(){$("#msg").fadeOut('slow')}, 10000);
  }else{  
    $.ajax({
          type: 'post',
          url: 'index.php?route=module/wkproduct_auction/wkauctionbids',
          data: 'product_id='+product_id+'&amount='+amount+'&user='+user+'&auction='+auction+'&start_date='+start_date+'&end_date='+end_date+'&automaticbid='+automaticbid,
          dataType: 'json',
          success: function(json) {
                if(json['success']) {
                 
                    if(json['success']=='done'){
                      location.reload();
                     }
                     else if(json['success']=='not'){
                       $("#msg").html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $entry_ammount_less_error; ?></div>');
                       $("#msg").fadeIn('slow');
                       $("#bidamount").attr('value','');
                       setInterval(function(){$("#msg").fadeOut('slow')}, 10000);

                       }
                       //Automatic auction
                     else if(json['success']=='nochange'){
                       $("#msg").html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $entry_cannot_change_auto_bid;?></div>');
                       $("#msg").fadeIn('slow');
                       $("#bidamount").attr('value','');
                       setInterval(function(){$("#msg").fadeOut('slow')}, 10000);

                       }
                       //Automatic auction
                     else if(json['success']=='not_min_auction'){
                       $("#msg").html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $entry_ammount_morethan_normalbid;?></div>');
                       $("#msg").fadeIn('slow');
                       $("#bidamount").attr('value','');
                       setInterval(function(){$("#msg").fadeOut('slow')}, 10000);
                       
                    }else if(json['success']=='not done'){
                       $("#msg").html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $entry_ammount_range_error; ?></div>');
                       $("#msg").fadeIn('slow');
                       $("#bidamount").attr('value','');
                       setInterval(function(){$("#msg").fadeOut('slow')}, 10000);
                    }
                }else{
                    $(".bidme").html('<div class="bids"><?php echo $entry_no_bids; ?></div>');
                }
          }
      });
   
    }
  
});
</script>
<?php } }?>