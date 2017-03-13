<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-transaction" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>

      <div class="panel-body">

        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $info_mail; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>

        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
          <li><a href="#tab-info" data-toggle="tab"><?php echo $tab_info; ?></a></li>
        </ul>

        <div class="tab-content">    

          <div class="tab-pane active" id="tab-general">
            <form action="<?php echo $save; ?>" method="post" enctype="multipart/form-data" id="form-transaction" class="form-horizontal">

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-name"><span data-toggle="tooltip" title="<?php echo $entry_name_info; ?>"><?php echo $entry_name; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" id="input-name" class="form-control" name="name" value="<?php echo $name; ?>" />
                  <input type="hidden" name="mail_id" value="<?php echo $mail_id; ?>" />
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-subject"><span data-toggle="tooltip" title="<?php echo $entry_subject_info; ?>"><?php echo $entry_subject; ?></span></label>
                <div class="col-sm-10">             
                  <input type="text" id="input-subject" class="form-control" name="subject" value="<?php echo $subject; ?>" />
                </div>
              </div> 

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-message"><span data-toggle="tooltip" title="<?php echo $entry_message_info; ?>"><?php echo $entry_message; ?></span></label>
                <div class="col-sm-10">             
                  <textarea id="input-message" class="form-control" name="message" rows="3"><?php echo $message; ?></textarea>
                </div>
              </div>

            </form>
          </div>

          <div class="tab-pane" id="tab-info">
            <p class="text-info"><?php echo $info_mail_add; ?></p> 
            <table class="table table-bordered table-hover">
              <thead>
              <tr>
                <td><?php echo $entry_for; ?></td>
                <td><?php echo $entry_code; ?></td>                
              </tr>
              </thead>
              <?php foreach($mail_help as $help){?>
                <tr>
                  <td><?php echo ucwords(str_replace('}','',str_replace('{','',str_replace('_', ' ', str_replace('config','Store',$help))))); ?></td>
                  <td><?php echo $help; ?></td>
                </tr>
              <?php } ?>
            </table>

          </div>

        </div>

      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript"><!--
$('#input-message').summernote({height: 300});
</script>