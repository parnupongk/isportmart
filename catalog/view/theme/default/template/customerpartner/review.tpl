<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
  <div class="review-container">
    <div class="review-container-left-panel">
      <div class="reviewer-name">
        <?php echo $review['author']; ?>
      </div>
      <div class="review-rating">
        <?php for ($i = 1; $i <= $review['rating']; $i++) { ?>
          <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
        <?php } ?>
        <?php for ($j = 1; $j <= 5 - $review['rating']; $j++) { ?>
          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
        <?php } ?>
      </div>
      <div class="review-date">
        <?php echo $review['date_added']; ?>
      </div>
    </div>
    <div class="review-border"></div>
    <div class="review-container-right-panel">
      <div class="reviewed-product-name">
        <?php echo $review['name']; ?>
      </div>
      <div class="review-content">
        <?php echo $review['text']; ?>
      </div>
    </div>
  </div>
<?php } ?>
<div class="text-right"><?php echo $pagination; ?></div>
<?php } else { ?>
<p><?php echo $text_no_reviews; ?></p>
<?php } ?>
