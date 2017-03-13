<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2><?php echo $heading_title; ?></h2>
      <?php if ($thumb || $description) { ?>
      <div class="row">
        <?php if ($thumb) { ?>
        <div class="col-sm-2"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" /></div>
        <?php } ?>
        <?php if ($description) { ?>
        <div class="col-sm-10"><?php echo $description; ?></div>
        <?php } ?>
      </div>
      <hr>
      <?php } ?>
      <?php if ($categories) { ?>
      <h3><?php echo $text_refine; ?></h3>
      <?php if (count($categories) <= 5) { ?>
      <div class="row">
        <div class="col-sm-3">
          <ul>
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <?php } else { ?>
      <div class="row">
        <?php foreach (array_chunk($categories, ceil(count($categories) / 4)) as $categories) { ?>
        <div class="col-sm-3">
          <ul>
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
      <?php } ?>
      <?php if ($products) { ?>
		<?php if (empty($agent_id)) { ?>
			<p><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></p>
		<?php } ?>
      <div class="row">
        <div class="col-md-4">
          <div class="btn-group hidden-xs">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
          </div>
        </div>
        <div class="col-md-2 text-right">
          <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
        </div>
        <div class="col-md-3 text-right">
          <select id="input-sort" class="form-control" onchange="location = this.value;">
            <?php foreach ($sorts as $sorts) { ?>
            <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
            <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-1 text-right">
          <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
        </div>
        <div class="col-md-2 text-right">
          <select id="input-limit" class="form-control" onchange="location = this.value;">
            <?php foreach ($limits as $limits) { ?>
            <?php if ($limits['value'] == $limit) { ?>
            <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
      </div>
      <br />
      <div class="row">
        <?php foreach ($products as $product) { ?>
        <div class="product-layout product-list col-xs-12">
          <div class="product-thumb">
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
            <div>
              <div class="caption">
                <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                
     <p><?php echo $product['description']; ?>
                         <?php if($wkget_timezone){ ?>
                              <?php if($auctionProduct) {
        
        foreach($auctionProduct as $auction) {
        if($auction['product_id'] == $product['product_id']){
        $sa=explode(" ",$auction['end_date']);
        $dat=explode("-",$sa[0]);
        $tim=explode(":",$sa[1]);
        
        //if($tim[0] >= date("H") && $tim[1] >= date("i")){
        //$tim[0] = $tim[0] - date("H");
        //$tim[1] = ($tim[1] - date("i"));
        //}else if($tim[0] <= date("H") && $tim[1] >= date("i")){
        //$tim[1] = $tim[1] - date("i");
        //$tim[0] = 0;
        //}else if($tim[0] <= date("H") && $tim[1] <= date("i")){
        //$tim[1] = $tim[1] + (60 - date("i"));
        //$tim[1] = 0;
        //}else if($tim[0] >= date("H") && $tim[1] <= date("i")){
        //$tim[0] = ($tim[0] - date("H")) - 1;
        //$tim[1] = $tim[1] + (60 - date("i"));
        //}
      ?>
      <div id="countdown_dashboard<?php echo $auction['product_id']; ?>" style="width: 100%;margin-top: 20px;">
      <div class="dash weeks_dash">
        <div class="digit">0</div>
        <div class="digit">0</div>
      </div>

      <div class="dash days_dash">
        <div class="digit">0</div>
        <div class="digit">0</div>
      </div>

      <div class="dash hours_dash">
        <div class="digit">0</div>
        <div class="digit">0</div>
      </div>

      <div class="dash minutes_dash">
        <div class="digit">0</div>
        <div class="digit">0</div>
      </div>

      <div class="dash seconds_dash">
        <div class="digit">0</div>
        <div class="digit">0</div>
      </div>

      <div style="color:seagreen"><span>&nbsp&nbsp&nbspW&nbsp&nbsp </span><span>&nbsp&nbsp&nbsp&nbspDay </span><span>&nbsp&nbsp&nbspHour </span><span>&nbsp&nbsp&nbspMin </span><span>&nbsp&nbspSec </span></div>
      
    </div>
    <script>
        id = '<?php echo $auction['product_id']; ?>';
        //D = new Date();
        //y = D.getFullYear();
        //mo = D.getMonth();
        //d = D.getDate();
        //h = D.getHours()
        //m = D.getMinutes();
        //s = D.getSeconds();
        //  d = <?php echo $dat[2]; ?>;
        //if(h+<?php echo $tim[0]; ?> >= 24){
        //  d = d+1;
        //  h = (h+<?php echo $tim[0]; ?> - 24);
        //}else{
        //  h = h+<?php echo $tim[0]; ?>;
       // }
        //if(m+<?php echo $tim[1]; ?> >= 60){
        //  h = h+1;
        //  m = (m+<?php echo $tim[1]; ?> - 60);
        //}else{
        //  m = m+<?php echo $tim[1]; ?>;
        //}
        $('#countdown_dashboard'+id).countDown({
          targetDate: {
            'day':    <?php echo $dat[2]; ?>,
            'month':  <?php echo $dat[1]; ?>,
            'year':   <?php echo $dat[0]; ?>,
            'hour':   <?php echo $tim[0]; ?>,
            'min':    <?php echo $tim[1]; ?>,
            'sec':    <?php echo $tim[2]; ?>,
          }
        });
    </script>
        <?php }
    }
      } ?>
        <?php } ?></p>
                              
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
				<p>ตัวแทนจำหน่าย : <?php echo $product['affiliate']; ?></p>
              </div>
              <div class="button-group">
			  <?php if (!empty($agent_id)) { ?>
                <button type="button" onclick="
				<?php if ($fst_affiliate == 0) { ?>
					cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');
				<?php } else { ?>
				<?php if ($fst_affiliate == $product['affiliate_id']) { ?>
					cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');		
				<?php } else { ?>
					errorCart();			
				<?php } ?>
				<?php } ?>								
				">
				<i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                   
                            <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>"
                       <?php if($auctionProduct) {
        foreach($auctionProduct as $auction) {
        if($auction['product_id'] == $product['product_id']){
           if($wk_cart_option){ echo 'disabled'; } 
                          }
                          } }?>
                            onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
			  <?php } else {?>
                   
                            <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>"
                       <?php if($auctionProduct) {
        foreach($auctionProduct as $auction) {
        if($auction['product_id'] == $product['product_id']){
           if($wk_cart_option){ echo 'disabled'; } 
                          }
                          } }?>
                            onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
			  <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
function errorCart() {
	$('.breadcrumb').after('<div class="alert alert-danger">ไม่สามารถเลือกสินต้าต่างตัวแทนจำหน่ายได้ค่ะ<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
};
//--></script>
   
              <script type="text/javascript"><!--
                  <?php if(isset($wk_cart_option) && $wk_cart_option){ ?>
                    $("#button-cart").attr('disabled',true);
                    <?php } else{ ?>
                    $("#button-cart").removeAttr('disabled');
                  <?php } ?>
              --></script>
               
<?php echo $footer; ?>
