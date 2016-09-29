
<div id="content">

        <?php foreach ($products as $product) { ?>
          <div class="col-md-1">
            <img src="https://isportmart.com/barcode/barcode.php?text=<?php echo $product['b_barcode'];  ?>-<?php echo $product['b_id'];  ?>"> ?/>
          </div>
        <?php } ?>


  </div>