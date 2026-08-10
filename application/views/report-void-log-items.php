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
      <h1><?= $page_title; ?><small>Invoice <?= html_escape($log->invoice_no); ?></small></h1>
      <ol class="breadcrumb">
        <li><a href="<?= $base_url; ?>reports/void_logs">Void Logs Report</a></li>
        <li class="active">Items</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title">Void Information</h3>
          <div class="box-tools"><a href="<?= $base_url; ?>reports/void_logs" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back</a></div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-3"><strong>Invoice:</strong> <?= html_escape($log->invoice_no); ?></div>
            <div class="col-md-3"><strong>Date & Time:</strong> <?= html_escape(show_date($log->invoice_date).' '.$log->invoice_time); ?></div>
            <div class="col-md-2"><strong>Type:</strong> <?= html_escape($log->invoice_type); ?></div>
            <div class="col-md-2"><strong>Delete:</strong> <?= html_escape($log->delete_type); ?></div>
            <div class="col-md-2"><strong>Salesman:</strong> <?= html_escape($log->salesman_name ?: '—'); ?></div>
          </div>
        </div>
      </div>
      <div class="box box-primary">
        <div class="box-header with-border"><h3 class="box-title">Removed Items</h3></div>
        <div class="box-body">
          <table id="void-items-table" class="table table-bordered table-striped" width="100%">
            <thead class="bg-gray"><tr>
              <th>#</th><th>Barcode</th><th>Item Code</th><th>Item Name</th>
              <th>Qty</th><th>Price</th><th>Discount</th><th>Tax</th><th>Subtotal</th>
            </tr></thead>
            <tbody>
            <?php $qty=0; $subtotal=0; foreach($items as $index=>$item): $qty+=(float)$item->qty; $subtotal+=(float)$item->subtotal; ?>
              <tr>
                <td><?= $index+1; ?></td><td><?= html_escape($item->barcode); ?></td>
                <td><?= html_escape($item->item_code); ?></td><td><?= html_escape($item->item_name); ?></td>
                <td class="text-right"><?= store_number_format($item->qty); ?></td>
                <td class="text-right"><?= store_number_format($item->price); ?></td>
                <td class="text-right"><?= store_number_format($item->disc); ?></td>
                <td class="text-right"><?= store_number_format($item->tax); ?></td>
                <td class="text-right"><?= store_number_format($item->subtotal); ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot class="bg-gray"><tr><th colspan="4" class="text-right">Total</th><th class="text-right"><?= store_number_format($qty); ?></th><th colspan="3"></th><th class="text-right"><?= store_number_format($subtotal); ?></th></tr></tfoot>
          </table>
        </div>
      </div>
    </section>
  </div>
  <?php include "footer.php"; ?>
  <div class="control-sidebar-bg"></div>
</div>
<?php include "comman/code_js.php"; ?>
<script>
$(function(){
  $('#void-items-table').DataTable({paging:false, searching:false, info:false, order:[]});
  $('.report-void-logs-active-li').addClass('active');
});
</script>
</body>
</html>
