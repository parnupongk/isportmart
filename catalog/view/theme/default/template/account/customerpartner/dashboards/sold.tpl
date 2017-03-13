
<style>
  #wk_sold_title {
      background-color: #1CA740;;
  }

  #wk_sold_title > .tile-heading {
      background-color: #3BC55F;
  }

  #wk_sold_title > .tile-footer {
      background-color: #3BC55F;
  }
</style>

<div class="tile" id="wk_sold_title">
  <div class="tile-heading"><?php echo $heading_title; ?> 
      <!-- <span class="pull-right">
      <?php if ($percentage > 0) { ?>
      <i class="fa fa-caret-up"></i>
      <?php } elseif ($percentage < 0) { ?>
      <i class="fa fa-caret-down"></i>
      <?php } ?>
      <?php echo $percentage; ?>%</span> -->
  </div>
  <div class="tile-body"><i class="fa fa-cart-plus"></i>
    <h2 class="pull-right">10</h2>
  </div>
  <div class="tile-footer"><a href="<?php echo $order; ?>"><?php echo $text_view; ?></a></div>
</div>
