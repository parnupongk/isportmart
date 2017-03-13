<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $insert; ?>" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-transaction').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
                <label class="control-label" for="input-id"><?php echo $entry_id; ?></label>
                <input type="text" name="filter_id" value="<?php echo $filter_id; ?>" placeholder="<?php echo $entry_id; ?>" id="input-id" class="form-control" />
              </div>

              <div class="form-group">
                <label class="control-label" for="input-message"><?php echo $entry_message; ?></label>
                <input type="text" name="filter_message" value="<?php echo $filter_message; ?>" placeholder="<?php echo $entry_message; ?>" id="input-message" class="form-control" />
              </div>

            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-subject"><?php echo $entry_subject; ?></label>
                <input type="text" name="filter_subject" value="<?php echo $filter_subject; ?>" placeholder="<?php echo $entry_subject; ?>" id="input-subject" class="form-control" />   
              </div>
              <button type="button" onclick="filter();" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>

        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-transaction">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
              <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>

                <td class="text-left">
                  <?php if ($sort == 'id') { ?>
                  <a href="<?php echo $sort_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_id; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_id; ?>"><?php echo $entry_id; ?></a>
                  <?php } ?>                
                </td>
                <td class="text-left">
                  <?php if ($sort == 'name') { ?>
                  <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_name; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_name; ?>"><?php echo $entry_name; ?></a>
                  <?php } ?>               
                </td>

                <td class="text-left">
                  <?php if ($sort == 'subject') { ?>
                  <a href="<?php echo $sort_subject; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_subject; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_subject; ?>"><?php echo $entry_subject; ?></a>
                  <?php } ?>               
                </td>

                <td class="text-left">
                  <?php if ($sort == 'message') { ?>
                  <a href="<?php echo $sort_message; ?>" class="<?php echo strtolower($order); ?>"><?php echo $entry_message; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_message; ?>"><?php echo $entry_message; ?></a>
                  <?php } ?>               
                </td>  

                <td class="text-right"><?php echo $entry_action; ?></td>       
              </tr>
            </thead>

            <tbody>
              <?php if ($mails) { ?>
              <?php foreach ($mails as $result) { ?>
                <tr>             
                  <td style="text-align: center;"><?php if ($result['selected']) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $result['id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $result['id']; ?>" />
                    <?php } ?>
                  </td>              
                  <td class="text-left" ><?php echo $result['id']; ?></td>
                  <td class="text-left"><?php echo  $result['name']; ?></td>
                  <td class="text-left"><?php echo $result['subject']; ?></td>
                  <td class="text-left"><?php echo html_entity_decode($result['message']); ?></td> 
                  <td class="text-right">
                      <a href="<?php echo $result['action']; ?>" data-toggle="tooltip" title="<?php echo $text_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                  </td> 

                </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="6"><?php echo $entry_no_records; ?></td>
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
<script type="text/javascript"><!--

$('#form input').keydown(function(e) {
  if (e.keyCode == 13) {
    filter();
  }
});


function filter() {

  url = 'index.php?route=customerpartner/mails&token=<?php echo $token; ?>';
  
  var filter_name = $('input[name=\'filter_name\']').val();
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }
  
  var filter_id = $('input[name=\'filter_id\']').val();
  
  if (filter_id) {
    url += '&filter_id=' + encodeURIComponent(filter_id);
  }

  var filter_subject = $('input[name=\'filter_subject\']').val();
  
  if (filter_subject) {
    url += '&filter_subject=' + encodeURIComponent(filter_subject);
  }

  var filter_message = $('input[name=\'filter_message\']').val();
  
  if (filter_message) {
    url += '&filter_message=' + encodeURIComponent(filter_message);
  }

  location = url;
}
//--></script> 
<?php echo $footer; ?>
