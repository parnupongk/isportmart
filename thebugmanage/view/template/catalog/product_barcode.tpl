

<?php foreach ($product_barcodes as $product) { ?>
    <img src="https://isportmart.com/barcode/barcode.php?text=<?php echo $product['b_barcode'];  ?>-<?php echo $product['b_id'];  ?>" width="200px" style="padding-left:50px;">
<?php } ?>

