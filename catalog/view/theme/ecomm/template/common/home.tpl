<?php echo $header; ?>
<div class="container">
  <div><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'full-slide'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?></div>
    
    <?php echo $column_right; ?></div>

    <div><?php echo $content_bottom; ?></div>
</div>
<?php echo $footer; ?>