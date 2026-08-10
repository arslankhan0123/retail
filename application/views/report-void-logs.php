<!DOCTYPE html>
<html>
<head>
  <?php include "comman/code_css.php"; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include "sidebar.php"; ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><?= $page_title; ?><small>All POS void transactions</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?= $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $page_title; ?></li>
      </ol>
    </section>
    <section class="content">
      <div class="row"><div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border"><h3 class="box-title">Void Logs</h3></div>
          <div class="box-body">
            <table id="void-logs-table" class="table table-bordered table-striped" width="100%">
              <thead class="bg-gray"><tr>
                <th>#</th><th>Invoice Date</th><th>Invoice Time</th><th>Invoice No</th>
                <th>Invoice Type</th><th>Delete Type</th><th>Salesman</th><th>User</th>
                <th>Items</th><th>Action</th>
              </tr></thead>
              <tbody>
              <?php foreach($logs as $index=>$log): ?>
                <tr>
                  <td><?= $index+1; ?></td>
                  <td><?= html_escape(show_date($log->invoice_date)); ?></td>
                  <td><?= html_escape($log->invoice_time); ?></td>
                  <td><?= html_escape($log->invoice_no); ?></td>
                  <td><span class="label label-info"><?= html_escape($log->invoice_type); ?></span></td>
                  <td><span class="label <?= $log->delete_type==='Bulk' ? 'label-danger' : 'label-warning'; ?>"><?= html_escape($log->delete_type); ?></span></td>
                  <td><?= html_escape($log->salesman_name ?: '—'); ?></td>
                  <td><?= html_escape($log->username ?: '—'); ?></td>
                  <td><?= (int)$log->item_count; ?></td>
                  <td><a class="btn btn-primary btn-xs" href="<?= $base_url; ?>reports/void_log_items/<?= (int)$log->id; ?>"><i class="fa fa-eye"></i> View</a></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div></div>
    </section>
  </div>
  <?php include "footer.php"; ?>
  <div class="control-sidebar-bg"></div>
</div>
<?php include "comman/code_js.php"; ?>
<script>
$(function(){
  $('#void-logs-table').DataTable({
    order:[], pageLength:25,
    dom:'<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10"B>>>tip',
    buttons:['copy','excel','pdf','print']
  });
  $('.report-void-logs-active-li').addClass('active');
});
</script>
</body>
</html>
