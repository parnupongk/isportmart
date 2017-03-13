<?php if ($feedbacks) { ?>
	<?php foreach ($feedbacks as $feedback) { ?>

	<div class="review-container">
		<div class="review-detail-container">
		    <div class="review-container-left-panel">
		      <div class="reviewer-name">
		        <?php echo $feedback['nickname']; ?>
		      </div>
		      <div class="review-date">
		        <?php echo $feedback['createdate']; ?>
		      </div>
		    </div>
	    	<div class="review-border"></div>
		    <div class="review-container-right-panel">
		      <div class="review-content">
		        <?php echo $feedback['review']; ?>
		      </div>
		    </div>
		</div>
	    <div class="review-seller-rating">
	    	<div class="rating-price actual-seller-rating">
	    		<div class="text-container">
	    			<?php echo $text_price; ?>
	    		</div>
	    		<div class="rating-container">
		    		<?php for ($i = 1; $i <= $feedback['feedprice']; $i++) { ?>
		          		<span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
			        <?php } ?>
			        <?php for ($j = 1; $j <= 5 - $feedback['feedprice']; $j++) { ?>
			          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
			        <?php } ?>
			    </div>
	    	</div>
	    	<div class="rating-value actual-seller-rating">
	    		<div class="text-container">
	    			<?php echo $text_value; ?>
	    		</div>
	    		<div class="rating-container">
		    		<?php for ($i = 1; $i <= $feedback['feedvalue']; $i++) { ?>
		          		<span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
			        <?php } ?>
			        <?php for ($j = 1; $j <= 5 - $feedback['feedvalue']; $j++) { ?>
			          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
			        <?php } ?>
			    </div>
	    	</div>
	    	<div class="rating-quality actual-seller-rating">
	    		<div class="text-container">
	    			<?php echo $text_quality; ?>
	    		</div>
	    		<div class="rating-container">
		    		<?php for ($i = 1; $i <= $feedback['feedquality']; $i++) { ?>
		          		<span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
			        <?php } ?>
			        <?php for ($j = 1; $j <= 5 - $feedback['feedquality']; $j++) { ?>
			          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
			        <?php } ?>
			    </div>
	    	</div>
	    </div>
  	</div>
	<?php } ?>
	<div class="text-right"><?php echo $results; ?></div>

<?php } else { ?>
	<div class="mp-no-location-found text-danger"><?php echo $text_no_feedbacks; ?></div>
<?php } ?>	