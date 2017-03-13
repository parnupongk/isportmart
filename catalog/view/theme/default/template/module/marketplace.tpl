<div class="marketplace">
<?php if(isset($chkIsPartner)){ ?>
	<div class="list-group">
		<?php if($chkIsPartner){ ?>
			<?php if(isset($marketplace_account_menu_sequence)) { 
					foreach ($marketplace_account_menu_sequence as $key => $menu_option) { 
						if(isset($marketplace_allowed_account_menu) && $marketplace_allowed_account_menu && in_array($key,$marketplace_allowed_account_menu)) { 
							if($key == 'asktoadmin') { ?>
								<a id="ask-to-admin" class="list-group-item"  data-toggle="modal" data-target="#myModal-seller-mail">
									<?php echo $menu_option; ?>
								</a>
							<?php } else { ?>
								<a href="<?php echo $account_menu_href[$key]; ?>" class="list-group-item">
									<?php echo $menu_option; ?>
								</a>
							<?php } ?>		
						<?php } ?>
					<?php } ?>
			<?php } ?>
		<?php }else{ ?>
			<a href="<?php echo $want_partner; ?>" class="list-group-item"><?php echo $text_becomePartner; ?></a>
		<?php } ?>
	</div>
<?php }elseif(isset($partner)) { ?>
	<?php $addClass = 'col-lg-3 col-md-3 col-sm-6'; ?>
	<div class="row">
      <div class="product-layout product-grid col-xs-12">
        <div class="product-thumb">
          <br/>          
          <div class="text-center">
            <a href="<?php echo $partner['sellerHref']; ?>"><img src="<?php echo $partner['thumb']; ?>" alt="<?php echo $partner['name']; ?>" title="<?php echo $partner['name']; ?>" class="img-circle" style="box-shadow:0px 0px 5px 2px #f1f1f1;"/></a>

            <h4>
              <?php echo $text_seller; ?><span data-toggle="tooltip" title="<?php echo $text_seller; ?>"><i class="fa fa-user"></i></span>
              <a href="<?php echo $partner['sellerHref']; ?>"><?php echo $displayName; ?></a>
            </h4>

            <div class="rating">
	            <p>
	              <?php for ($i = 1; $i <= 5; $i++) { ?>
	              <?php if ($partner['feedback_total'] < $i) { ?>
	              <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
	              <?php } else { ?>
	              <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
	              <?php } ?>
	              <?php } ?>
	          </div>

            <p>
              <?php echo $text_from; ?><span data-toggle="tooltip" title="<?php echo $text_from; ?>"><i class="fa fa-home"></i></span>                  
              <b><?php echo $partner['country']; ?></b>
            </p>

            <p>
              <?php echo $text_total_products; ?>                 
              <b><?php echo $partner['total_products']; ?></b>
            </p>

            <?php if ($contact_mail) { ?>
            
            <?php if($logged){ ?>
            <p>
            	<button class="btn btn-primary" data-toggle="modal" data-target="#myModal-seller-mail"><?php echo $text_ask_seller; ?></button>
        	</p>
        	<?php } else { ?>
            <p>
            	<button class="btn btn-primary" onclick="window.location.href='<?php echo $redirect_user; ?>'"><?php echo $text_ask_seller; ?></button>
        	</p>
        	<?php } ?>
        	<?php } ?>

            <p>
              <?php if(isset($show_seller_product) && !$show_seller_product) { ?> 
              	<a href="<?php echo $collectionHref; ?>"><?php echo $text_latest_product; ?></a>
              <?php } elseif(count($latest) > 2){ ?>
              	<b><?php echo $text_latest_product; ?><i class="fa fa-arrow-down"></i> </b>
              <?php } ?>
            </p>
          </div>

        </div>
      </div>
      <?php if(isset($show_seller_product) && $show_seller_product) { ?>
	      <?php foreach ($latest as $product) { ?>
	      <div class="product-layout product-grid product-seller col-xs-12">
	        <div class="product-thumb seller-thumb" id="<?php echo $product['product_id']; ?>">
	          <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
	          <div>
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
	    <?php } ?>
    </div>
<?php } ?>
</div>
<?php if($contact_mail AND $logged){ ?>
	<div class="modal fade" id="myModal-seller-mail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $text_close; ?></span></button>
	        <h3 class="modal-title"><?php echo $text_ask_question; ?></h3>
	      </div>
	      <form id="seller-mail-form">
		      <div class="modal-body">
		      	<div class="form-group required">
			        <label class="control-label" for="input-subject"><?php echo $text_subject; ?></label>
			        <input type="text" name="subject" id="input-subject" class="form-control" />
			        <?php if(isset($partner)){ ?>
			        	<input type="hidden" name="seller" value="<?php echo $seller_id;?>"/>		        
			        <?php } ?>
			    </div>
				<div class="form-group required">
			        <label class="control-label" for="input-message"><?php echo $text_ask; ?></label>
					<textarea class="form-control" name="message" rows="3" id="input-message"></textarea>
			    </div>
			    <div class="error text-center text-danger"></div>
		      </div>
		  </form>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $text_close; ?></button>
	        <button type="button" class="btn btn-primary" id="send-mail"><?php echo $text_send; ?></button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
<?php } ?>

<style type="text/css">
	.modal-dialog {
		width: 500px;
	}
	.sellerBackground {
		<?php if(isset($sellerProfile['backgroundcolor']) && $sellerProfile['backgroundcolor']) { ?>
			background-color: <?php echo $sellerProfile['backgroundcolor']; ?>;
		<?php } else { ?>
			background-color: #FF4D45;
		<?php } ?>
		height: 200px;
		text-align: center;
	}
	.seller_detail_stripe {
		background-color: rgba(255, 255, 255, 0.1);
		box-shadow: 0 0 1px 1px rgba(255, 255, 255, 0.2);
		height: 30px;
		margin-top: 5px;
		width: 100%;
	}
	.seller_detail_stripe p {
		color: #fff;
	    font-size: 18px;
	    line-height: 30px;
	}
	.seller-dp {
		height: 100px;
		margin-top: 35px;
	}
</style>

	<div class="modal fade" id="myModal-seller-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	<div class="modal-dialog">
	    	<div class="modal-content" style="border-radius:0px">
	      		<div class="modal-body" style="padding-top:0px">
				<?php if(isset($launchModal) && $launchModal) { ?>
			   		<div class="row">
			    		<div class="col-sm-12 sellerBackground" style="">
			    			<div class="seller-dp">
			    				<img src="<?php echo $sellerProfile['avatar']; ?>" alt="<?php echo $sellerProfile['firstname'].' '.$sellerProfile['lastname']; ?>" />
			    			</div>
			    			<div class="seller_detail_stripe" style="">
			    				<p>
			    					<?php echo $text_welcome.$sellerProfile['firstname'].' '.$sellerProfile['lastname']; ?>
			    				</p>
			    			</div>
			    		</div>
			    	</div>
				<?php } ?>
		    		<div class="row">
		      			<div class="col-sm-12">
		      				<?php if(isset($lowStockProducts['products']) && $lowStockProducts['products']) { ?>
			      			<fieldset>
			      				<lagend>
			      					<h3><?php echo $text_low_stock; ?></h3>
			      				</lagend>
				      			<div class="table-responsive">
				      				<table class="table table-bordered table-hover">
					      				<thead>
					      					<tr>
					      						<th><?php echo $text_productname; ?></th>
					      						<th><?php echo $text_model; ?></th>
					      						<th class="text-right"><?php echo $text_quantity; ?></th>
					      					</tr>
					      				</thead>
					      				<tbody>
				      					<?php foreach ($lowStockProducts['products'] as $key => $lowStockProduct) { ?>
				      						<tr>
				      							<td>
				      								<?php echo $lowStockProduct['name']; ?>
				      							</td>
				      							<td>
				      								<?php echo $lowStockProduct['model']; ?>
				      							</td>
				      							<td class="text-right">
				      								<?php echo $lowStockProduct['quantity']; ?>
				      							</td>
				      						</tr>
				      					<?php } ?>
				      					<?php if(isset($totalProductsLowStock) && $totalProductsLowStock > 5) { ?>
					      					<tr>
					      						<td colspan="3">
					      							<a href="<?php echo $moreProductUrl; ?>" class="btn btn-info btn-block">
					      								more
					      							</a>
					      						</td>
					      					</tr>
					      				<?php } ?>
				      					</tbody>
				      				</table>
				      			</div> <!-- table responsive -->
				      		</fieldset> <!-- low stock field set -->
				    		<?php } ?>
			      			<fieldset>
		      					<lagend>
		      						<h3><?php echo $text_most_viewed; ?></h3>
		      					</lagend>
			      				<div class="table-responsive">
			      					<table class="table table-bordered table-hover">
				      					<thead>
					      					<tr>
						      					<th><?php echo $text_productname; ?></th>
						      					<th><?php echo $text_model; ?></th>
						      					<th class="text-right"><?php echo $text_views; ?></th>
					      					</tr>
				      					</thead>
				      					<tbody>
			      						<?php if(isset($mostViewedProducts) && $mostViewedProducts) { ?>
			      							<?php foreach ($mostViewedProducts as $key => $mostViewedProduct) { ?>
			      							<tr>
				      							<td>
				      								<?php echo $mostViewedProduct['name']; ?>
				      							</td>
				      							<td>
				      								<?php echo $mostViewedProduct['model']; ?>
				      							</td>
				      							<td class="text-right">
				      								<?php echo $mostViewedProduct['viewed']; ?>
				      							</td>
				      						</tr>
			      							<?php } ?>
			      						<?php } else { ?>
						      				<tr>
						      					<td class="text-center" colspan="3">
						      						<?php echo $text_more_work; ?>
						      					</td>
						      				</tr>
			      						<?php } ?>
			      						</tbody>
			      					</table>
			      				</div>
			      			</fieldset> <!-- view fieldset -->
		      			</div> <!-- col-sm-12 -->
		    		</div> <!-- row -->
					<div class="row">
						<div class="col-sm-12">
						    <div class="pull-right">
						      	<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
						      		<?php echo $text_close; ?>
						      	</button>
						    </div>
						</div>
					</div> <!-- row -->
	      		</div> <!-- modal-body -->
	    	</div> <!-- modal-content -->
		</div> <!-- modal-dialog -->
	</div> <!-- modal -->

<script>
var launchModal = <?php if($launchModal) echo $launchModal; else echo 0; ?>;
$(document).ready(function() {
	// $('#myModal-seller-info').modal();
	if(launchModal) {
		$('#myModal-seller-info').modal();
	}
});

<?php if(isset($partner)){ ?>
$(document).ready(function(){
	if($('#content').hasClass('col-sm-12')){
		$('.marketplace .row .product-seller').addClass('<?php echo $addClass; ?>');
	}
});
<?php } ?>

<?php if($contact_mail AND $logged){ ?>
$('#send-mail').on('click',function(){
	f = 0;
	$('.alert').remove();
	$('#myModal-seller-mail input[type=\'text\'],#myModal-seller-mail textarea').each(function () {
		if ($(this).val() == '') {
			$(this).parent().addClass('has-error');
			f++;
		}else{
			$(this).parent().removeClass('has-error');
		}
	});

	if (f > 0) {
		$('#myModal-seller-mail .error').text('<?php echo $text_error_mail; ?>').slideDown('slow').delay(2000).slideUp('slow');
	} else {
		$('#send-mail').addClass('disabled');
		$('#myModal-seller-mail').addClass('mail-procss');
		$('.alert-success').remove();
		$('#myModal-seller-mail .modal-body').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $text_success_mail; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>');	

		$.ajax({
			url: '<?php echo $send_mail; ?>',
			data: $('#seller-mail-form').serialize()+'<?php echo $mail_for; ?>',
			type: 'post',
			dataType: 'json',
			complete: function () {
				$('#send-mail').removeClass('disabled');
				$('#myModal-seller-mail input,#myModal-seller-mail textarea').each(function () {
					$(this).val(''); 
					$(this).text(''); 
				});
			}
		});
	}
});
<?php } ?>

</script>
