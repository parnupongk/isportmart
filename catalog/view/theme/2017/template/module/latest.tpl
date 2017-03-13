<h3><?php echo $heading_title; ?></h3>
<div class="mod_carusel">
<div id="mod_latest" class="row owl-carousel owl-theme" >
  <?php foreach ($products as $product) { ?>
  <div class="item-product-scroll col-xs-12">
    <div class="product-thumb transition">
      <div class="image transition">
		<a role="button" data-toggle="modal" id="product_link-<?php echo $product['product_id']; ?>" href="#product_<?php echo $product['product_id']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
		<div class="image_panel">
			<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#product_<?php echo $product['product_id']; ?>">
				<i class="fa  fa-search"></i>
			</button>
		</div>
	  </div>
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

  <?php } ?>
</div>
</div>
<?php foreach ($products as $product) { ?>
	<div id="product_<?php echo $product['product_id']; ?>" class="modal">
        <div class="modal-dialog mod-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo $product['name']; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="col-sm-6">
						<div class="padded">
							<?php if ($product['thumb'] || $images) { ?>
								<ul class="thumbnails">
								
									<?php if ($product['thumb']) { ?>
										<li><a class="thumbnail" href="<?php echo $product['image']; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
									<?php } ?>
									
									<?php if ($images) { ?>
										<?php foreach ($images as $image) { ?>
											<?php if($image['id'] == $product['product_id']){?>
												<li class="image-additional"><a class="thumbnail" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"> <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
											<?php } ?>
										<?php } ?>
									<?php } ?>
									
								</ul>
							<?php } ?>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="padded">
							<?php if ($product['price']) { ?>
								<p class="modal-price">
									<?php if (!$product['special']) { ?>
										<span class="price-normal"><?php echo $product['price']; ?></span>
									<?php } else { ?>
										<span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
									<?php } ?>
									<?php if ($product['tax']) { ?>
										<span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
									<?php } ?>
								</p>
							<?php } ?>
							<div class="rating">
								<?php for ($i = 1; $i <= 5; $i++) { ?>
									<?php if ($product['rating'] < $i) { ?>
										<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
									<?php } else { ?>
										<span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
									<?php } ?>
								<?php } ?>
							</div>	
							<hr/>
							<p><?php echo $product['full_description']; ?></p>		
						</div>
					</div>
					<div class="row padded"></div>
                </div>
                <div class="modal-footer">
					<div class="button-group">
						<button class="btn btn-primary btn-lg" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
						<button class="btn btn-primary btn-lg" type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
						<button class="btn btn-primary btn-lg" type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
					</div>
				</div>
            </div>
        </div>
    </div>
<?php } ?>	
	
<script type="text/javascript">
$('#mod_latest').owlCarousel({
	items: 4,
	navigation: true,
	navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
	pagination: false
});


</script> 
