<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<style type="text/css">
  @media screen and (max-width: 786px) {
    #productImage {
      width: 100%;
    } 
    #preview-image-container {
      width: 100%;
    }
  }
</style>
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $insert; ?>" id="insert" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-product').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>

      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-seller"><?php echo $column_partner_name; ?></label>
                <div class='input-group'>
                    <input type="text" name="filter_seller" value="<?php echo $filter_seller; ?>" placeholder="<?php echo $column_partner_name; ?>" id="input-seller" class="form-control" />                                      
                    <span class="input-group-addon"><span class="fa fa-angle-double-down"></span>
                    </span>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label" for="input-price"><?php echo $column_price; ?></label>
                <input type="text" name="filter_price" value="<?php echo $filter_price; ?>" placeholder="<?php echo $column_price; ?>" id="input-price" class="form-control" />
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $column_name; ?></label>
                <div class='input-group'>
                    <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $column_name; ?>" id="input-name" class="form-control" />                    
                    <span class="input-group-addon"><span class="fa fa-angle-double-down"></span>
                    </span>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label" for="input-model"><?php echo $column_model; ?></label>
                <div class='input-group'>
                    <input type="text" name="filter_model" value="<?php echo $filter_model; ?>" placeholder="<?php echo $column_model; ?>" id="input-model" class="form-control" />                                   
                    <span class="input-group-addon"><span class="fa fa-angle-double-down"></span>
                    </span>
                </div>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-quantity"><?php echo $column_quantity; ?></label>
                <input type='text' name="filter_quantity" value="<?php echo $filter_quantity; ?>" placeholder="<?php echo $column_quantity; ?>" id="input-quantity" class="form-control" />
              </div>

              <div class="form-group">
                <label class="control-label" for="input-quantity"><?php echo $column_status; ?></label>

                <select name="filter_status" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_status) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>

              <button type="button" onclick="filter();" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>

          </div>
        </div>

        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-product">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
    			        <td class="text-left"><?php if ($sort == 'c.customer_id') { ?>
                    <a href="<?php echo $sort_seller_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_partner_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_seller_name; ?>"><?php echo $column_partner_name; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php echo $column_image; ?></td>
                  <td class="text-left"><?php if ($sort == 'pd.name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'p.model') { ?>
                    <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'p.price') { ?>
                    <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_price; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_price; ?>"><?php echo $column_price; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($sort == 'p.quantity') { ?>
                    <a href="<?php echo $sort_quantity; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_quantity; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_quantity; ?>"><?php echo $column_quantity; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php if ($sort == 'p.product_id') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($products) { ?>
                <?php foreach ($products as $product) { ?>
                <tr>
                  <td style="text-align: center;"><?php if ($product['selected']) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
                    <?php } ?></td>
    			        <td class="text-left">
                    <?php if($partners){ ?>
                      <div class="form-group">
                        <div class="input-group"> 
                          <span class="input-group-addon" style="width: auto;" data-toggle="tooltip" title="<?php echo $text_seller_info; ?>"><span class="fa fa-user"></span></span>
                          <select class="form-control partner_change">
                            <option></option>
                          <?php foreach($partners as $partner){ ?>
                            <?php if($product['customer_id']==$partner['customer_id']){ ?>
                              <option value="<?php echo $partner['customer_id'] ;?>" selected ><?php echo $partner['name'] ;?></option>
                            <?php }else{ ?>
                              <option value="<?php echo $partner['customer_id'] ;?>" ><?php echo $partner['name'] ;?></option>
                            <?php } ?>
                          <?php } ?>
                          </select>
                        </div>
                      </div>
                    <?php } ?>
                  </td>
                  <td class="text-center"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
                  <td class="text-left"><?php echo $product['name']; ?></td>
                  <td class="text-left"><?php echo $product['model']; ?></td>
                  <td class="text-left"><?php if ($product['special']) { ?>
                    <span style="text-decoration: line-through;"><?php echo $product['price']; ?></span><br/>
                    <span class="text-danger"><?php echo $product['special']; ?></span>
                    <?php } else { ?>
                    <?php echo $product['price']; ?>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($product['quantity'] <= 0) { ?>
                    <span class="label label-warning"><?php echo $product['quantity']; ?></span>
                    <?php } elseif ($product['quantity'] <= 5) { ?>
                    <span class="label label-danger"><?php echo $product['quantity']; ?></span>
                    <?php } else { ?>
                    <span class="label label-success"><?php echo $product['quantity']; ?></span>
                    <?php } ?></td>
                  <td class="text-center">
                    <a data-toggle="tooltip" title="<?php echo $text_approve; ?>" class="btn btn-success cp-pro-status" <?php echo $product['status'] ? "disabled" : ""; ?> cp-pro-id="<?php echo $product['product_id']?>"><i class="fa fa-thumbs-o-up"></i></a>
                  </td>
                  <td class="text-center">
                  	<button type="button" data-toggle="tooltip" title="Product preview" class="btn btn-warning previewButton" data-product-id="<?php echo $product['product_id']; ?>" data-product-status="<?php echo $product['status']; ?>">
                    	<i class="fa fa-eye"></i>
                    </button>
                    <?php	foreach ($product['action'] as $action) { ?>
                      <a href="<?php echo $action['href']; ?>" data-toggle="tooltip" title="<?php echo $action['text']; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                    <?php } ?>
                  </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="9"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
        </table>
        </div>
      </form>       
         
    <div class="row">
      <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
      <div class="col-sm-6 text-right"><?php echo $results; ?></div>
    </div>
  </div>
</div>

<div id="productPreviewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    		<h4><?php echo "Product Preview" ?></h4>
    	</div>
    	<div class="modal-body">
      	<div class="row">
          <div class="col-sm-6">
            <div class="img-thumbnail" id="preview-image-container">
              <img id="productImage" src="" >
            </div>
          </div>
          <div class="col-sm-6">
            <ul class="list-group">
              <li class="list-group-item" id="productName"></li>
              <li class="list-group-item" id="productModel"></li>
              <li class="list-group-item" id="ProductPrice"></li>
              <li class="list-group-item" id="productQuantity"></li>
              <li class="list-group-item" id="productAvailability"></li>
            </ul>
          </div>
        </div>
      </div>
    	<div class="modal-footer">
    		<div class="pull-right">
    			<button type="button" id="modalButton" class="btn btn-success cp-pro-status" cp-pro-id="">
    				<i class="fa fa-thumbs-o-up"></i>
    			</button>
    			<button class="btn btn-default" type="button" data-dismiss="modal">
    				<?php echo "close"; ?>
    			</button>
    		</div>
    	</div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$('.previewButton').on('click', function() {
		var caller = $(this);
    product_id = $(this).data('product-id');
		product_status = $(this).data('product-status');
		$('#modalButton').attr({'cp-pro-id': product_id});
		if(product_status) {
			$('#modalButton').attr('disabled', true);
		} else {
			$('#modalButton').removeAttr('disabled');
		}
    
		$.ajax({
			url : 'index.php?route=customerpartner/product/getProduct&token=<?php echo $token; ?>',
      data: {product_id : product_id},
      method: 'post',
			dataType: 'json',
      beforeSend : function() {
        caller.attr('disabled',true).children('i').removeClass('fa-eye').addClass('fa-spinner fa-spin');
      },
			success: function(product) {
        if(product.image) {
          $('#productImage').attr({'src':product.image, 'alt':product.name});
        } else {
          $('#productImage').attr({'src':'../image/no_image.png', 'alt':product.name});
        }
        $('#productName').text('<?php echo $column_name." : "; ?>'+product.product_name);
        $('#productModel').text('<?php echo $column_model." : "; ?>'+product.model);
        $('#ProductPrice').text('<?php echo $column_price." : "; ?>'+product.price);
        // $('#Productspecial').text('<?php echo $column_price." : "; ?>'+product.price);
        $('#productQuantity').text('<?php echo $column_quantity." : "; ?>'+product.quantity);
        if(product.quantity < 1) {
          $('#productAvailability').show();
          $('#productAvailability').text('<?php echo $column_availability." : "; ?>'+product.stock_status_name);
        } else {
          $('#productAvailability').hide();
        }
        caller.removeAttr('disabled').children('i').removeClass('fa-spinner fa-spin').addClass('fa-eye');
				$('#productPreviewModal').modal();
			},
		});
	});
</script>

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=customerpartner/product&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').val();
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

  var filter_seller = $('input[name=\'filter_seller\']').val();
  
  if (filter_seller) {
    url += '&filter_seller=' + encodeURIComponent(filter_seller);
  }
	
	var filter_model = $('input[name=\'filter_model\']').val();
	
	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}
	
	var filter_price = $('input[name=\'filter_price\']').val();
	
	if (filter_price) {
		url += '&filter_price=' + encodeURIComponent(filter_price);
	}
	
	var filter_quantity = $('input[name=\'filter_quantity\']').val();
	
	if (filter_quantity) {
		url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
	}
	
	var filter_status = $('select[name=\'filter_status\']').val();
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=customerpartner/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(item) {
		$('input[name=\'filter_name\']').val(item.label);
						
		return false;
	},
	focus: function(item) {
      	return false;
   	}
});

$('input[name=\'filter_model\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=customerpartner/product/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.model,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(item) {
		$('input[name=\'filter_model\']').val(item.label);
						
		return false;
	},
	focus: function(item) {
      	return false;
   	}
});

$('input[name=\'filter_seller\']').autocomplete({
  delay: 0,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=customerpartner/partner/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) { 
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.id
          }
        }));
      }
    });
  }, 
  select: function(item) {
    $('input[name=\'filter_seller\']').val(item.label);
            
    return false;
  },
  focus: function(item) {
      return false;
  }
});

//change product seller after change seller
$('.partner_change').on('change',function(){
  thisthis = this;
  $('.alert').remove();
  spanHtml = $(this).prev().html();
  $(this).prev().html('<i class="fa fa-spinner fa-spin"></i>');

  $.ajax({
    url: 'index.php?route=customerpartner/partner/updateProductSeller&token=<?php echo $token; ?>',
    data: 'product_id=' +  encodeURIComponent($(this).parents('td').prev('td').children('input').val()) + '&partner_id=' + encodeURIComponent(this.value),
    dataType: 'json',
    success: function(json) { 
      html = '';
      if(json['success']){
        html = '<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'];
        html +=   '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        html += '</div>';
      }else if(json['error']){
        html = '<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + json['success'];
        html +=   '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        html += '</div>';
      }
      $('.panel').before(html);
      $(thisthis).prev().html(spanHtml);

    }
  });
});

//--></script>
<script><!--//
(function($wk_jq) {
	$wk_jq('.cp-pro-status').on('click', function(){
		if(confirm("<?php echo $text_confirm_approve; ?>")){
  		url = '<?php echo $approve; ?>&product_id='+$wk_jq(this).attr('cp-pro-id');
      $wk_jq('#insert').attr('href',url).trigger('click');
      location = url;
		}
	});	
})(jQuery);
//--></script>
<?php echo $footer; ?>