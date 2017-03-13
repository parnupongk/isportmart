<div id="slideshow<?php echo $module; ?>" class="owl-carousel wow bounceInDown" style="opacity: 1;">
  <?php foreach ($banners as $banner) { ?>
  <div class="item">
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <?php } ?>
  </div>
  <?php } ?>
</div>
<script type="text/javascript"><!--
$('#slideshow<?php echo $module; ?>').owlCarousel({
	items: 6,
	autoPlay: 7000,
	singleItem: true,
	navigation: true,
	navigationText: ['<i class="fa fa-angle-left fa-5" aria-hidden="true"></i>', '<i class="fa fa-angle-right fa-5" aria-hidden="true"></i>'],
	pagination: true
});
--></script>