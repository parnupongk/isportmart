<?php echo $header; ?>
<?php echo $baner; ?>
<div id="home_content" class="container">
	<div class="row">
		<div class="col-sm-4">
			<div class="padded">
				<?php echo $baner_1; ?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="padded">
				<?php echo $baner_2; ?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="padded">
				<?php echo $baner_3; ?>
			</div>
		</div>
	</div>
	<div class="row"><?php echo $content_top; ?></div>
	<div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div class="<?php echo $class; ?>"><?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php 
	echo $footer; 
?>