<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
 <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> 
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="$('form').submit();"><i class="fa fa-trash-o"></i></button>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
           <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-productname"><?php echo $entry_prod; ?></label>
                <input type="text" name="filter_pname" value="<?php echo $filter_pname; ?>" placeholder="<?php echo $entry_prod; ?>" id="input-productname" class="form-control" />
              </div>              
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-starttime"><?php echo $entry_start_time; ?></label>
                <div class="input-group datetime">
                    <input type="text" name="filter_starttime" value="<?php echo $filter_starttime; ?>" placeholder="<?php echo $entry_start_time; ?>" data-format="YYYY-MM-DD HH:mm" id="input-starttime" class="form-control">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>                  </span>
                </div>               
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-endtime"><?php echo $entry_end_time ?></label>
                 <div class="input-group datetime">
                    <input type="text" name="filter_endtime" value="<?php echo $filter_endtime; ?>" placeholder="<?php echo $entry_end_time ?>" data-format="YYYY-MM-DD HH:mm" id="input-endtime" class="form-control">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>                  </span>
                </div>               
              </div>              
            </div>
             <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Filter</button>
          </div>
        </div>     
        <ul class="nav nav-tabs">
         <li class="active"><a href="#tab-currentbidings" data-toggle="tab"><?php echo $entry_cur_bid; ?></a></li>
          <li><a href="#tab-winnerlist" data-toggle="tab"><?php echo $entry_history; ?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-currentbidings">
               <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
              <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td width="1" style="text-align: center;"><input type="checkbox" class="form-control" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'p.name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_prod; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $entry_prod; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'a.start_date') { ?>
                    <a href="<?php echo $sort_starttime; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_start; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_starttime; ?>"><?php echo $entry_start; ?></a>
                    <?php } ?></td>
                     <td class="text-left"><?php if ($sort == 'a.end_date') { ?>
                    <a href="<?php echo $sort_endtime; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_end; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_endtime; ?>"><?php echo $entry_end; ?></a>
                    <?php } ?></td>
                    <td class="text-left"><?php echo $text_total_bid; ?></td>

                    <!-- Automatic bidding -->
                    <?php if (isset($wkproduct_auction_automatic_auction_status) && $wkproduct_auction_automatic_auction_status) {?>
                      <td class="left"><?php echo $text_total_auto_bid; ?></td>
                    <?php }?>
                    <td class="text-center"><?php echo $text_view; ?></td>                
                </tr>
              </thead>
              <tbody>
              <?php if ($bids) { ?>
              <?php foreach ($bids as $bid) { ?>
              <tr>             
                <td class="text-center"><?php if ($bid['selected']) { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $bid['id']; ?>" checked="checked" class="form-control" />
                  <?php } else { ?>
                  <input class="form-control" type="checkbox" name="selected[]" value="<?php echo $bid['id']; ?>" />
                  <?php } ?></td>
                <td class="text-left"><?php echo $bid['product']; ?></td>
                <td class="text-left"><?php echo $bid['auction_start']; ?></td>
                <td class="text-left"><?php echo $bid['auction_end']; ?></td>
                <td class="text-left"><?php echo $bid['totalBid']; ?></td>

                 <!-- Automatic bidding -->
                <?php if (isset($bid['total_auto_bid']) && isset($wkproduct_auction_automatic_auction_status) && $wkproduct_auction_automatic_auction_status) {?>

                    <td class="text-left"><?php echo $bid['total_auto_bid']; ?></td>

                  <?php }elseif(isset($wkproduct_auction_automatic_auction_status) && $wkproduct_auction_automatic_auction_status){?>

                     <td class="text-left"><?php echo "0"; ?></td>

                  <?php } ?>
                <td class="text-center">[ <a class="displayButton" onclick="showlist(this.id)" id="<?php echo $bid['product_id']; ?>" ><?php echo $text_view; ?></a> ]</td>
              </tr>
              <tr>
                <td></td>
                <td colspan="4" style="padding:0">
              <div id="listhead<?php echo $bid['product_id']; ?>" class="wklisthead" style="height:auto;margin-top:2px">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <td class="left" style="background-color:#EFEFEF"><?php echo $text_bidder ?></td>
                    <td class="left" style="background-color:#EFEFEF"><?php echo $entry_start; ?></td>
                    <td class="left" style="background-color:#EFEFEF"><?php echo $entry_end; ?></td>
                    <td class="left" style="background-color:#EFEFEF"><?php echo $text_bid; ?></td>

                    <!-- Automatic bidding -->
                    <?php if (isset($wkproduct_auction_automatic_auction_status) && $wkproduct_auction_automatic_auction_status) {?>
                      <td class="left" style="background-color:#EFEFEF"><?php echo $text_auto_bid; ?></td>
                    <?php }?>
                  </tr>
                </thead>
               <?php if($productBids) {
              foreach($productBids as $productBid){
                if($productBid['product_id'] == $bid['product_id']) { ?>
               <tr id="" class="wklistrow listrow<?php echo $bid['product_id']; ?>">       
                  <td class="left" style="width:25.4%"><?php echo $productBid['customer_name']; ?></td>
                  <td class="left" style="width:29.2%"><?php echo $productBid['start_date']; ?></td>
                  <td class="left" style="width:29.1%"><?php echo $productBid['end_date']; ?></td>
                  <td class="left" style="width:15.8%"><?php echo $productBid['bid']; ?></td>
                  
                  <!-- Automatic bidding -->
                  <?php if (isset($productBid['auto_bid']) && isset($wkproduct_auction_automatic_auction_status) && $wkproduct_auction_automatic_auction_status) {?>

                    <td class="left" style="width:15.8%"><?php echo $productBid['auto_bid']; ?></td>

                  <?php }elseif(isset($wkproduct_auction_automatic_auction_status) && $wkproduct_auction_automatic_auction_status){?>

                     <td class="center" style="width:15.8%"><?php echo "-"; ?></td>

                  <?php } ?>
               </tr>               
               <?php }               
                  } }  ?>
              </table>
            </div>
              </td>
              <td></td>
            </tr>
          <?php }
                 }else { ?>
            <tr>
              <td class="text-center" colspan="6"><?php echo "No records founds"; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div><!--tab1 -->      
      <div class="tab-pane" id="tab-winnerlist">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">          
          <thead>
            <tr>
              <td width="1" class="text-center">
                <input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" />
              </td>
              <td class="text-left"><?php echo $entry_winner ?></td>
              <td class="text-left"><?php echo $entry_prod ?></td>
              <td class="text-left"><?php echo $entry_start; ?></td>
              <td class="text-left"><?php echo $entry_end; ?></td>
              <td class="text-center"><?php echo $text_win_bid; ?></td>
            </tr>
          </thead>
          <tbody>           
            <?php if ($winners) { ?>
            <?php foreach ($winners as $winner) { ?>
            <tr>             
              <td style="text-align: center;"><?php if ($winner['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $winner['id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $winner['id']; ?>" />
                <?php } ?></td>
              <td class="text-left"><?php echo $winner['customer_name']; ?></td>
               <td class="text-left"><?php echo $winner['product_name'] ?></td>
               <td class="text-left"><?php echo $winner['start_date']; ?></td>
               <td class="text-left"><?php echo $winner['end_date']; ?></td>
               <td class="text-center"><?php echo $winner['bid']; ?></td>
               </tr>
               <?php }
               }else { ?>
            <tr>
              <td class="text-center" colspan="6"><?php echo "No records founds"; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div><!-- table responsive-->

      </div>
    </div><!--MainTabContent-->

      </div><!--panel-body-->
    </div><!--panel-default-->
  </div><!--container-fluid-->
</div><!--content-->

<script type="text/javascript">
$('.wklisthead').slideUp();
function showlist(id){
  $('.wklisthead').not('#listhead'+id).slideUp('slow');
  $('#listhead'+id).slideToggle('slow');
  $('.displayButton').not('#'+id).text("show");
  if($('#'+id).text() == "show"){
        $('#'+id).text("hide");
  }else{
        $('#'+id).text("show");
  }
}

$('#button-filter').on('click', function() {
  var url = 'index.php?route=catalog/wkauction_bids&token=<?php echo $token; ?>';

  var filter_pname = $('input[name=\'filter_pname\']').val();

  if (filter_pname) {
    url += '&filter_pname=' + encodeURIComponent(filter_pname);
  }

  var filter_starttime = $('input[name=\'filter_starttime\']').val();

  if (filter_starttime) {
    url += '&filter_starttime=' + encodeURIComponent(filter_starttime);
  }

  var filter_endtime = $('input[name=\'filter_endtime\']').val();

  if (filter_endtime) {
    url += '&filter_endtime=' + encodeURIComponent(filter_endtime);
  }

  location = url;
});

$('.datetime').datetimepicker({
      pickDate: true,
      pickTime: true
    });
</script> 

<?php echo $footer; ?>
