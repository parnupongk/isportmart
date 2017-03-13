<style>
    .wk_order_status_box{
        background-color: #dedddb;
        padding: 10px;
        margin: 5px 0;
    }

    .wk_order_status_label{
        display: inline-block;
        width: 70%;
        color: black;
    }

    .wk_status_count{
      display: inline-block;
    }

    .wk_status_ray{
        background-color: white;
        height: 10px;
    }
</style>
		                    
		                
<div class="tile" style="background-color: white;">
    <div class="tile-body" style="background-color: white;padding: 0;">
        <div id="wk_order_status_container" style="line-height: 5px;">
          <div class="wk_order_status_box">
            <div class="wk_order_status_label">
              <p><a href="<?php echo $processing_order_link; ?>" style="color: black;"><?php echo $text_order_processing; ?></a></p>
              <div class="wk_status_ray">
                <div style="width: <?php echo $totalProcessingPercent; ?>;background-color: #00c9ff;height: 100%;"></div>
              </div>
            </div>
            <div class="wk_status_count" style="color: black;"><?php echo $totalProcessing; ?>/<?php echo $totalSellerOrder; ?></div>
          </div>

          <div class="wk_order_status_box">
            <div class="wk_order_status_label">
              <p><a href="<?php echo $complete_order_link; ?>" style="color: black;"><?php echo $text_order_complete; ?></a></p>
              <div class="wk_status_ray">
                <div style="width: <?php echo $totalCompletePercent; ?>;background-color: #1db114;height: 100%;"></div>
              </div>
            </div>
            <div class="wk_status_count" style="color: black;"><?php echo $totalComplete; ?>/<?php echo $totalSellerOrder; ?></div>
          </div>

          <div class="wk_order_status_box">
            <div class="wk_order_status_label">
              <p><a href="<?php echo $cancel_order_link; ?>" style="color: black;"><?php echo $text_order_cancel; ?></a></p>
              <div class="wk_status_ray">
                <div style="width: <?php echo $totalCanceledPercent; ?>;background-color: orangered;height: 100%;"></div>
              </div>
            </div>
            <div class="wk_status_count" style="color: black;"><?php echo $totalCancel; ?>/<?php echo $totalSellerOrder; ?></div>
          </div>
        </div>
    </div>
   <div class="tile-footer" style="background-color: white"></div>
</div>