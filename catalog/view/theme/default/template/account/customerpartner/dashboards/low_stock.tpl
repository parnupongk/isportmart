<style>
/*  #wk_lowstock_title {
      background-color: #F54242;
  }

  #wk_lowstock_title > .tile-heading {
      background-color: #F37575;
  }

  #wk_lowstock_title > .tile-footer {
      background-color: #F37575;
  }*/
</style>

<div class="tile" id="wk_lowstock_title">
  <div class="tile-heading"><?php echo $heading_title; ?></div> 
  <div class="tile-body"><i class="fa fa-thumbs-down"></i>
    <h2 class="pull-right"><?php echo $low_stock_quantity; ?></h2>
  </div>
  <div class="tile-footer"><a href="<?php echo $low_stock_view_more; ?>"><?php echo $text_view; ?></a></div>
</div>
