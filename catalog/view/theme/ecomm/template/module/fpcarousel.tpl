<div class="box fp_carousel" id="fp_carousel_<?php echo $module; ?>">
  <div class="box-header">
    <div class="row">
      <div class="col-sm-<?php echo ($show_navigation) ? 6 : 12; ?> col-xs-<?php echo ($show_navigation) ? 6 : 12; ?>">
		<?php if($name_as_title){ ?>
        <h3 class="fp_carousel-title"><?php echo $name; ?></h3>
		<?php } else { ?>
        <h3 class="fp_carousel-title"><?php echo $heading_title; ?></h3>
		<?php } ?>
      </div>
	  <?php if($show_navigation) { ?>
      <div class="col-sm-6 text-right">    
        <div class="fp_carousel-controls btn-group text-right" role="group">
          <button type="button" class="btn fp_carousel-left" data-slide="prev">
            <i class="fa fa-chevron-left"></i>
          </button>
          <button type="button" class="btn fp_carousel-right" data-slide="next">
            <i class="fa fa-chevron-right"></i>
          </button>
        </div>
      </div>
	  <?php } ?>
    </div>
  </div>
  <div class="box-content row" id="featured_products_carousel_<?php echo $module; ?>">
      <?php foreach ($products as $product) { ?>
      <div class="item">
		  <div class="product-layout">
			<div class="product-thumb transition">
			  <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
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
</div>

<script>
var fp_carousel_<?php echo $module; ?> = $('#featured_products_carousel_<?php echo $module; ?>');
fp_carousel_<?php echo $module; ?>.owlCarousel({
  items: <?php echo $itemspage; ?>,  
  itemsDesktop: [1199,<?php echo $itemspage; ?>],
  itemsDesktopSmall: [979, <?php echo $itemspage; ?>],
  itemsTablet: [768, <?php echo $itemspage; ?>],
  itemsTabletSmall: [768, <?php echo $itemspage; ?>],
  itemsMobile: [479,1],
  autoPlay: <?php echo ($auto_play)?3000:'false'; ?>,
  pagination: <?php echo ($show_pagination)?'true':'false'; ?>,
  stopOnHover: <?php echo ($pause_on_hover)?'true':'false'; ?>
});
<?php if($show_navigation) { ?> 
// Custom Navigation Events
$("#fp_carousel_<?php echo $module; ?> .fp_carousel-right").click(function(){fp_carousel_<?php echo $module; ?>.trigger('owl.next'); });
$("#fp_carousel_<?php echo $module; ?> .fp_carousel-left").click(function(){ fp_carousel_<?php echo $module; ?>.trigger('owl.prev'); });
<?php } ?>
</script>