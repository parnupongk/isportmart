<?php echo $header; ?>
<?php $class = 'col-sm-12'; ?>
<div class="container">
  <div class="row">
    <div id="content" class="<?php echo $class; ?>">
      <div class="text-center">
        <h3 class="text-info"><?php echo $sell_header; ?></h3>
        <a href="index.php?route=account/register" type="button" class="btn btn-primary btn-lg">
          <?php echo $sell_title; ?>
        </a>
      </div>
      <br/>

      <ul class="nav nav-tabs">
        <?php if($tabs){ ?>
          <?php foreach ($tabs as $key => $value) { ?>
              <li <?php if(!$key){ ?>class="active"<?php } ?>><a href="<?php echo "#tab-".$key; ?>" data-toggle="tab"><?php echo $value['hrefValue']; ?></a></li>
          <?php }?>
        <?php }?>          
      </ul>

      <div class="tab-content">
        <?php foreach ($tabs as $key => $value) { ?>
          <div id="<?php echo "tab-".$key; ?>" class="tab-pane <?php if(!$key){ ?>active<?php } ?>"><?php echo $value['description']; ?></div>
        <?php }?>
      </div>

      <br/>
      <?php if($showpartners) { ?>

        <h3 class="text-info">
          <b><?php echo $text_long_time_seller; ?></b>
        </h3>
        <br/>
        <div class="row">
          <?php foreach ($partners as $partner) { ?>
          <div class="product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="product-thumb">
              
              <div class="text-center">
                <a href="<?php echo $partner['sellerHref']; ?>">
                <?php  if($partner['thumb']) { ?>
                  <img src="<?php echo $partner['thumb']; ?>" alt="<?php echo $partner['name']; ?>" 
                  title="<?php echo $partner['name']; ?>" class="partner-thumb img-circle"/>
                <?php } else { ?>
                  <div class="partner-thumb" style="background-color:<?php echo $partner['backgroundcolor']; ?>"></div>
                <?php } ?>
                </a>

                <h4>
                  <?php echo $text_seller; ?><span data-toggle="tooltip" title="<?php echo $text_seller; ?>"><i class="fa fa-user"></i></span>
                  <a href="<?php echo $partner['sellerHref']; ?>"><?php echo $partner['name']; ?></a>
                </h4>

                <?php if($partner['country']){ ?>
                  <p>
                    <?php echo $text_from; ?><span data-toggle="tooltip" title="<?php echo $text_from; ?>"><i class="fa fa-home"></i></span>                  
                    <b><?php echo $partner['country']; ?></b>
                  </p>
                <?php } ?>

                <p>
                  <?php echo $text_total_products; ?>                 
                  <b><?php echo $partner['total_products']; ?></b>
                </p>
              </div>

            </div>
          </div>
          <?php } ?>
          <?php //for seller list ?>
        </div>
      <?php } ?>

      <?php if($showproducts) {?>
        
        <h3 class="text-info">
          <b><?php echo $text_latest_product; ?></b>
        </h3>
        <br/>

        <div class="row">
          <?php foreach ($latest as $product) { ?>
          <div class="product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="product-thumb seller-thumb" id="<?php echo $product['product_id']; ?>">
              <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
              <div style="position: relative;">
                <div class="caption">
                  <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                  <p><?php echo $product['description']; ?></p>
                  <?php if ($product['rating']) { ?>
                  <div class="rating">
                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <?php if ($product['rating'] < $i) { ?>
                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                    <?php } else { ?>
                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                    <?php } ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                  <?php if ($product['price']) { ?>
                  <p class="price">
                    <?php if (!$product['special']) { ?>
                    <?php echo $product['price']; ?>
                    <?php } else { ?>
                    <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                    <?php } ?>
                    <?php if ($product['tax']) { ?>
                    <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                    <?php } ?>
                  </p>
                  <?php } ?>
                </div>
                <?php if (isset($showpartnerdetails) && $showpartnerdetails) {?>
                <div id="wk_seller_info_container" class="wk_seller_info">
                  <div style="padding: 10px;background-color: #f8f8f8;border-top: 8px solid orange;">
                    <div id="wk_seller_info_profpic">
                      <img src="<?php echo $product['avatar']; ?>" width="100%" height="100%" style="vertical-align:baseline;">
                    </div>
                    <div id="wk_seller_info_box">
                      <h4 style="margin-bottom: 15px;margin-top: 0px;font-size: 13px;"><b><?php echo $text_seller; ?></b></h4>
                      <a href=""><p style="margin:0; line-height: 15px;"><b><?php echo $product['seller_name']; ?></b></p></a>
                      <?php if($product['country']){ ?>
                      <p><?php echo $text_from; ?>
                          <span data-toggle="tooltip" title="<?php echo $text_from; ?>"><i class="fa fa-home"></i></span>
                          <b><?php echo $product['country']; ?></b>
                        </p>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <div class="button-group">
                  <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                  <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                  <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
     <?php } ?>


    </div>
  </div>
</div>


<script>
var seller_display = function (data){
  thisid = data.currentTarget.id; //get id of current selector
  $('#'+ thisid + ' .wk_seller_info').slideDown(); 
  $('#'+ thisid).unbind('mouseenter');
}
var seller_hide = function (data){
  thisid = data.currentTarget.id; //get id of current selector
  $('#'+ thisid + ' .wk_seller_info').slideUp('slow',function(){
    $('.seller-thumb').bind('mouseenter',seller_display);
  }); 
}

$('.seller-thumb').bind({'mouseenter' : seller_display,'mouseleave':seller_hide });

</script>
<?php echo $footer; ?>
