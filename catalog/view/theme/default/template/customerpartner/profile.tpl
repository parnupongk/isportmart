<?php echo $header; ?>
<style type="text/css">
  .banner-container {
   <?php if($partner['companybanner']) { ?>
      background:url("<?php echo $partner['companybanner']; ?>") no-repeat scroll center center / 100% 325px rgba(0, 0, 0, 0);
    <?php } else if($partner["backgroundcolor"]) { ?>
      background-color:<?php echo $partner["backgroundcolor"]; ?>;
      background-image: linear-gradient(to top, #fff, <?php echo $partner["backgroundcolor"]; ?>);
      background-image: -webkit-gradient(linear, left bottom, left top, from(#FFFFFF), to(<?php echo $partner["backgroundcolor"]; ?>));
      background-image: -webkit-linear-gradient(top, <?php echo $partner["backgroundcolor"]; ?>,#FFFFFF);
      background-image:    -moz-linear-gradient(top, <?php echo $partner["backgroundcolor"]; ?>,#FFFFFF);
      background-image:      -o-linear-gradient(top, <?php echo $partner["backgroundcolor"]; ?>,#FFFFFF);
      background-image:         linear-gradient(to bottom, <?php echo $partner["backgroundcolor"]; ?>,#FFFFFF);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=<?php echo $partner["backgroundcolor"]; ?>, endColorstr=#FFFFFFFF);
      -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=<?php echo $partner["backgroundcolor"]; ?>, endColorstr=#FFFFFFFF)";
    <?php } else { ?>
      background: #FFF;
    <?php } ?>
    /*background-repeat: no-repeat;
    background-position: center;
    background-size: cover;*/
    text-align: center;
    /*top: 5%;*/
    width: 100%;
    height: 415px;
    padding-top: 50px;
  }
  .af {

  }
  a{
    cursor: pointer;
  }
</style>
<!-- <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/MP/profile.css"> -->
<?php $class = 'col-sm-12'; ?>
<div class="container">
  <div class="row">
    <div id="content" class="<?php echo $class; ?>">
      <div class="banner-container">
        <div class="banner-stripe">
          <div class="company-logo">
            <?php if(isset($partner['companylogo']) && $partner['companylogo']) { ?>
              <img src="<?php echo $partner['companylogo']; ?>" alt="<?php echo $partner['companyname']; ?>" class="">
            <?php } else { ?>
              <div class="block-for-image">
                
              </div>
            <?php } ?>
          </div>
          <div class="seller-location">
            <h4 class="">
            <?php echo $text_from; ?><span data-toggle="tooltip" title="<?php echo $text_from; ?>"><i class="fa fa-home"></i></span>                  
              <b><?php echo $partner['country']; ?></b>
            </h4>
          </div>
          <div class="seller-rating">
            <?php for ($i = 1; $i <= 5; $i++) { ?>
              <?php if (round($feedback_total) < $i) { ?>
            <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
              <?php } else { ?>
            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
              <?php } ?>
            <?php } ?>
          </div>
        </div> <!-- banner stripe -->
        <div class="seller-details-stripe-lower">
          <div class="detail-container-inner">
            <div class="profile-pic">
              <div class="img-div">
                <?php if(isset($partner['avatar']) && $partner['avatar']) { ?>
                  <img src="<?php echo $partner['avatar']; ?>" alt="<?php echo $partner['firstname']; ?>">
                <?php } else { ?>
                  <div class="no-image-div">
                    
                  </div>
                <?php } ?>
              </div>
            </div> <!-- profile-pic -->
            <div class="details">
              <div class="upper-detail">
                <h4>
                  <?php echo $partner['firstname']." ".$partner['lastname']; ?>
                </h4>
              </div>
              <div class="lower-detail">
                <h4>
                  AVERAGE RATING
                </h4>
                <!-- <br/> -->
                <?php for ($i = 1; $i <= round($feedback_total); $i++) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                <?php } ?>
                <?php for ($j = 1; $j <= 5 - round($feedback_total); $j++) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                <?php } ?>
              </div>
            </div> <!-- details -->
            <div class="contact-seller">
              <div class="upper-contact-seller">
                <?php if ($telephone || $customer_id == $seller_id) { ?>
                  <div class="seller-mobile">
                    <i class="fa fa-phone"></i>
                    <?php echo $partner['telephone']; ?>
                  </div>                  
                <?php } ?>
                <?php if ($email || $customer_id == $seller_id) { ?>
                  <div class="seller-email">
                    <i class="fa fa-envelope-o"></i>
                    <?php echo $partner['email']; ?>
                  </div>
                <?php } ?>
              </div>
              <?php if ($marketplace_customercontactseller) {?>
              <div class="lower-contact-seller">
                <div class="cennect-text">
                  Connect us with: 
                </div>
                <div class="connect-icons">
                  <span>
                    <?php if(isset($partner['facebookid']) && $partner['facebookid']) { ?>
                      <a href="http://facebook.com/<?php echo $partner['facebookid'] ?>">
                        <i class="fa fa-facebook-square"></i>
                      </a>
                    <?php } ?>
                  </span>
                  <span>
                    <?php if(isset($partner['twitterid']) && $partner['twitterid']) { ?>
                      <a href="http://twitter.com/<?php echo $partner['twitterid'] ?>">
                        <i class="fa fa-twitter"></i>
                      </a>
                    <?php } ?>
                  </span>
                  <span>
                    <?php if($logged) { ?>
                      <a data-target="#myModal-seller-mail" data-toggle="modal">
                        <i class="fa fa-envelope-o"></i>
                      </a>
                    <?php } else { ?>
                      <a href="<?php echo $login; ?>" data-toggle="tooltip" data-original-title="<?php echo $text_login_contact; ?>">
                        <i class="fa fa-envelope"></i>
                      </a>
                    <?php } ?>
                  </span>
                </div> <!-- connect-icons -->
              </div> <!-- lower-contact-seller -->
            <?php } ?>
            </div> <!-- contact-seller -->
          </div> <!-- detail-container-inner -->
        </div> <!-- seller-details-stripe-lower -->
      </div> <!-- bannner-container -->
      <div class="col-sm-3 left-panel">
        <ul class="mp-list-group" id="main-tab">
          <li class="mp-list-group-item mp-active">
            <a data-tab="#tab-profile">
              <i class="fa fa-user"></i>
              <?php echo $text_profile; ?>
            </a>
          </li>
          <?php if(isset($public_seller_profile) && in_array('store',$public_seller_profile)) { ?>
          <li class="mp-list-group-item">
            <a data-tab="#tab-store">
              <i class="fa fa-clipboard"></i>
              <?php echo $text_store; ?>
            </a>
          </li>   
          <?php } ?>
          <?php if(isset($public_seller_profile) && in_array('collection',$public_seller_profile)) { ?>
          <li class="mp-list-group-item">
            <a data-tab="#tab-collection">
              <i class="fa fa-cubes"></i>
              <?php echo $text_collection.' ('.($collection_total ? $collection_total : '0').')'; ?>
            </a>
          </li>
          <?php } ?>
          <?php if(isset($public_seller_profile) && in_array('review',$public_seller_profile)) { ?>
          <li class="mp-list-group-item">
            <a data-tab="#tab-reviews">
              <i class="fa fa-comment-o"></i>
              <?php echo $text_reviews.' ('.($feedback_total ? round($feedback_total,1) : '0').')'; ?>
            </a>
          </li>
          <?php } ?>
          <?php if(isset($public_seller_profile) && in_array('productReview',$public_seller_profile)) { ?>
          <li class="mp-list-group-item">
            <a data-tab="#tab-product-reviews">
              <i class="fa fa-comments-o"></i>
              <?php echo $text_product_reviews.' ('.($product_feedback_total ? $product_feedback_total : '0').')'; ?>
            </a>
          </li>
          <?php } ?>
          <?php if(isset($public_seller_profile) && in_array('location',$public_seller_profile)) { ?>
          <li class="mp-list-group-item">
            <a data-tab="#tab-location">
              <i class="fa fa-globe"></i>
              <?php echo $text_location; ?>
            </a>
          </li>
          <?php } ?>
        </ul>
      </div> <!-- left-panel -->
      <div class="col-sm-9 right-panel">
        <div id="tab-profile" class="mp-tab-content mp-tab-active">
          <?php echo html_entity_decode($partner['shortprofile']); ?>
        </div> <!-- tab-profile -->
        <div id="tab-store" class="mp-tab-content">
          <?php echo html_entity_decode($partner['companydescription']); ?>
        </div> <!-- tab-store -->
        <div id="tab-reviews" class="mp-tab-content">
        <?php if ($customer_id != $seller_id) {?>
          <div>
            <?php if($logged) { ?>
              <?php if ($give_review) {?>
                <button type="button" data-toggle="modal" class="btn btn-warning btn-block" data-target="#myModal-seller-review">
                <?php echo $text_write_review; ?>
              <?php } ?>
              </button>
            <?php } else { ?>
              <a href="<?php echo $login; ?>" class="btn btn-warning btn-block" data-toggle="tooltip" data-original-title="<?php echo $text_login_review; ?>">
                <?php echo $text_write_review; ?>
              </a>
            <?php } ?>
          </div>
        <?php } ?>
          <div id="prev-reviews">
            
          </div>
        </div> <!-- tab-reviews -->
        <div id="tab-product-reviews" class="mp-tab-content"></div> <!-- tab-product-reviews -->
        <div id="tab-collection" class="mp-tab-content"></div> <!-- tab-collection -->
        <div id="tab-location" class="mp-tab-content"></div> <!-- tab-collection -->
        <div id="dummy-collection"></div>
      </div> <!-- right-panel -->
    </div> <!-- content -->
  </div> <!-- row -->
</div> <!-- container -->

<?php if($logged){ ?>
<div class="modal fade" id="myModal-seller-mail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $text_close; ?></span></button>
        <h3 class="modal-title"><?php echo $text_ask_seller; ?></h3>
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

  <div class="modal fade" id="myModal-seller-review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo $text_close; ?></span></button>
        <h3 class="modal-title"><?php echo $text_write_review; ?></h3>
      </div>
      <div class="modal-body" id="review-modal">
        <form class="form-horizontal">
          <div class="form-group required">
            <div class="col-sm-12">
              <label class="control-label" for="input-name"><?php echo $text_nickname; ?></label>
              <input type="text" name="name" value="" id="input-name" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <div class="col-sm-12">
              <label class="control-label" for="input-review"><?php echo $text_review; ?></label>
              <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
              <div class="help-block"><?php echo $text_note; ?></div>
            </div>
          </div>
          <div class="form-group required">
            <div class="col-sm-12">
              <label class="control-label"><?php echo $text_price; ?></label>
              &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
              <input type="radio" name="price_rating" value="1" />
              &nbsp;
              <input type="radio" name="price_rating" value="2" />
              &nbsp;
              <input type="radio" name="price_rating" value="3" />
              &nbsp;
              <input type="radio" name="price_rating" value="4" />
              &nbsp;
              <input type="radio" name="price_rating" value="5" />
              &nbsp;<?php echo $entry_good; ?>
            </div>
          </div>
          <div class="form-group required">
            <div class="col-sm-12">
              <label class="control-label"><?php echo $text_value; ?></label>
              &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
              <input type="radio" name="value_rating" value="1" />
              &nbsp;
              <input type="radio" name="value_rating" value="2" />
              &nbsp;
              <input type="radio" name="value_rating" value="3" />
              &nbsp;
              <input type="radio" name="value_rating" value="4" />
              &nbsp;
              <input type="radio" name="value_rating" value="5" />
              &nbsp;<?php echo $entry_good; ?>
            </div>
          </div>
          <div class="form-group required">
            <div class="col-sm-12">
              <label class="control-label"><?php echo $text_quality; ?></label>
              &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
              <input type="radio" name="quality_rating" value="1" />
              &nbsp;
              <input type="radio" name="quality_rating" value="2" />
              &nbsp;
              <input type="radio" name="quality_rating" value="3" />
              &nbsp;
              <input type="radio" name="quality_rating" value="4" />
              &nbsp;
              <input type="radio" name="quality_rating" value="5" />
              &nbsp;<?php echo $entry_good; ?>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $text_close; ?></button>
        <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $text_send; ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">

collectionUrl = '<?php echo $collection; ?>';

function loadCollection(showMenu){
  $.ajax({
    url : collectionUrl,
    dataType: 'html',
    success: function(response) {
      categoryMenu = $(response).find('#column-left').html();
      $('#category-menu').remove();
      $('.left-panel').append(categoryMenu);
      $('#tab-collection').html($(response).find('#mp-products').html());
      if(showMenu) {
        $('#category-menu').show();
      }
      if (localStorage.getItem('display') == 'list') {
        $('#list-view').trigger('click');
      } else {
        $('#grid-view').trigger('click');
      }
    }
  })
}

(function($) {
  $('#main-tab li').on('click', function() {
    tab = $(this).children('a').data('tab');
    $('.mp-list-group li').removeClass('mp-active');
    $(this).addClass('mp-active');
    $('.mp-tab-content').removeClass('mp-tab-active');
    $(tab).addClass('mp-tab-active');
    if(tab == '#tab-collection') {
      $('#category-menu').show();
    } else {
      $('#category-menu').hide();
    }
  });

  $.ajax({
      url : '<?php echo $feedback; ?>',
      dataType: 'html',
      success: function(response) {
        $('#prev-reviews').html(response);
      }
    });

  $.ajax({
    url : '<?php echo $product_feedback; ?>',
    dataType: 'html',
    success: function(response) {
      $('#tab-product-reviews').html(response);
    }
  });

  loadCollection(false);

})(jQuery)

$('body').on('click', '#category-menu li', function() {
  collectionUrl = $(this).children('a').data('collection-url');
  $('#category-menu li').removeClass('mp-active');
  $(this).addClass('mp-active');
  loadCollection(true);
})

<?php if($showCollection) { ?>
  $('a[data-tab="#tab-collection"]').trigger('click');
<?php } ?>

<?php if($logged){ ?>
$('#send-mail').on('click',function(){
  f = 0;
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

<script type="text/javascript">

localocation = false;
$('#main-tab li').on('click',function(){
  if(!localocation){
    $.ajax({
      url: '<?php echo $loadLocation; ?>',
      dataType: 'html',
      success: function(response) {
        $('#tab-location').html(response);
      }
    });
    localocation = true;
  }
})

/**
 * [To store feedback]
 * @return {none} [It will not return anything just reflect the form if unsuccessful and empty the form if successful]
 */
$('#button-review').on('click', function() {
  console.log($('textarea[name=\'text\']').val());
  $.ajax({
    url: '<?php echo $writeFeedback; ?>',
    type: 'post',
    dataType: 'json',
    data: {
      name : $('input[name=\'name\']').val(),
      text : $('textarea[name=\'text\']').val(),
      value_rating : $('input[name=\'value_rating\']:checked').val() ? $('input[name=\'value_rating\']:checked').val() : '',
      quality_rating : $('input[name=\'quality_rating\']:checked').val() ? $('input[name=\'quality_rating\']:checked').val() : '',
      price_rating : $('input[name=\'price_rating\']:checked').val() ? $('input[name=\'price_rating\']:checked').val() : '',
    },
    beforeSend: function() {
      $('#button-feedback').button('loading');
    },
    complete: function() {
      $('#button-feedback').button('reset');
    },
    success: function(json) {
      $('.alert-success, .alert-danger').remove();
      
      if (json['error']) {
        $('#review-modal').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button class="close" type="button" data-dismiss="alert" >&times;</button></div>');
      }
      if (json['success']) {
        $('.alert-success').remove();
        $('#review-modal').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
        $('input[name=\'name\']').val('');
        $('textarea[name=\'text\']').val('');
        $('input[name=\'price_rating\']:checked').prop('checked', false);
        $('input[name=\'quality_rating\']:checked').prop('checked', false);
        $('input[name=\'value_rating\']:checked').prop('checked', false);
      }
    }
  });
});

</script>

<script>
// Product List
$('body').on('click', '#list-view', function() {
  $('#content .product-layout > .clearfix').remove();

  $('#content .product-layout').attr('class', 'product-layout product-list col-xs-12');

  localStorage.setItem('display', 'list');
});

// Product Grid
$('body').on('click', '#grid-view', function() {
  $('#content .product-layout > .clearfix').remove();

  // What a shame bootstrap does not take into account dynamically loaded columns
  cols = $('#column-right, #column-left').length;

  if (cols == 2) {
    $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');

    $('#content .product-layout:nth-child(2)').after('<div class="clearfix visible-md visible-sm"></div>');
  } else if (cols == 1) {
    $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');

    $('#content .product-layout:nth-child(3)').after('<div class="clearfix visible-lg"></div>');
  } else {
    $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-4 col-md-3 col-sm-6 col-xs-12');

    $('#content .product-layout:nth-child(3)').after('<div class="clearfix"></div>');
  }

   localStorage.setItem('display', 'grid');
});

if (localStorage.getItem('display') == 'list') {
  $('#list-view').trigger('click');
} else {
  $('#grid-view').trigger('click');
}

$('body').on('change', '#seller-collection select',function() {
  collectionUrl = this.value; 
  loadCollection(true);
  // $('a[href=\'#tab-collection\']').append(' <i class="fa fa-spinner fa-spin remove-me"></i>');
  // $('#tab-collection').load(thisvalue,function(){
  //     $('.remove-me').remove();
  //   });
});

$('body').on('click','#seller-collection a',function(e){
  if(!$(this).hasClass('default-work'))
    e.preventDefault();
  else
    return;
  
  thisvalue = this.href;
  $('a[data-tab=\'#tab-collection\']').append(' <i class="fa fa-spinner fa-spin remove-me"></i>');   
  $('#tab-collection').load(thisvalue,function(){
      $('.remove-me').remove();
    });
});
</script>
<?php echo $footer; ?>
