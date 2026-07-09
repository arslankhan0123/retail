<!DOCTYPE html>
<html>

<head>
  <!-- TABLES CSS CODE -->
  <?php include "comman/code_css.php"; ?>
  <!-- </copy> -->
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <?php include "sidebar.php"; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><?= $page_title; ?><small></small></h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active"><?= $page_title; ?></li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <!-- right column -->
          <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary ">
              <div class="box-header with-border">
                <h3 class="box-title">Please Enter Valid Information</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <!-- <form class="form-horizontal" id="report-form" onkeypress="return event.keyCode != 13;"> -->
              <form class="form-horizontal" action="<?php echo base_url() ?>reports/customer_statements" method="get">
                <div class="box-body">
                  <div class="form-group">
                    <label for="customer_id" class="col-sm-2 control-label"><?= $this->lang->line('customer_name'); ?></label>
                    <div class="col-sm-3">
                      <select class="form-control select2 " id="customer_id" name="customer_id" required>
                        <option value="">Select Customer</option>
                        <?= get_customers_select_list($custid ?? null, get_current_store_id()); ?>
                      </select>
                      <span id="customer_id_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="from_date" class="col-sm-2 control-label"><?= $this->lang->line('from_date'); ?></label>
                    <div class="col-sm-3">
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right datepicker" id="from_date" name="from_date" value="<?php echo $psdate ?? show_date(date('d-m-Y')); ?>" required>
                      </div>
                      <span id="Sales_date_msg" style="display:none" class="text-danger"></span>
                    </div>
                    <label for="to_date" class="col-sm-2 control-label"><?= $this->lang->line('to_date'); ?></label>
                    <div class="col-sm-3">
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right datepicker" id="to_date" name="to_date" value="<?php echo $pedate ?? show_date(date('d-m-Y')) ?>" required>
                      </div>
                      <span id="Sales_date_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <div class="col-sm-8 col-sm-offset-2 text-center">
                    <div class="col-md-3 col-md-offset-3">
                      <button type="submit" id="v2iew" class="btn btn-block btn-success" name="search" title="Save Data">Show</button>
                    </div>
                    <div class="col-sm-3">
                      <a href="<?= base_url('dashboard'); ?>">
                        <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                      </a>
                    </div>
                  </div>
                </div>
                <!-- /.box-footer -->
              </form>
            </div>
            <!-- /.box -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
      <section class="content">
        <div class="row">
          <!-- right column -->
          <div class="col-md-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Records Table</h3>
                <?php $this->load->view('components/export_btn', array('tableId' => 'report-data')); ?>
                <a href="javascript:void(0)" onclick="printDiv('print')" class="btn btn-primary " style="float: right; "><i class="fa fa-print"></i> Print</a>
              </div>
              <!-- /.box-header -->
              <!-- <div class="box-body table-responsive no-padding">
                <table class="table table-bordered table-hover " id="report-data">
                  <thead>
                    <tr>
                      <td><?= $this->lang->line('name'); ?></td>
                      <td colspan="9" id="customer_name">
                      </td>
                    </tr>
                    <tr>
                      <td><?= $this->lang->line('mobile'); ?></td>
                      <td colspan="9" id="customer_mobile">
                      </td>
                    </tr>
                    <tr>
                      <td><?= $this->lang->line('address'); ?></td>
                      <td colspan="9" id="customer_address">
                      </td>
                    </tr>
                    <tr>
                      <td><?= $this->lang->line('previous_due'); ?></td>
                      <td colspan="9" id="previous_due">
                      </td>
                    </tr>
                    <tr class="bg-blue">
                      <th style="">#</th>

                      <th style=""><?= $this->lang->line('date'); ?></th>
                      <th style=""><?= $this->lang->line('invoice_no'); ?></th>
                      <th style=""><?= $this->lang->line('referenced_bill_no'); ?></th>
                      <th style=""><?= $this->lang->line('description'); ?></th>
                      <th style=""><?= $this->lang->line('qty'); ?></th>
                      <th style=""><?= $this->lang->line('bill_amount'); ?>(<?= $CI->currency(); ?>)</th>
                      <th style=""><?= $this->lang->line('receive'); ?>(<?= $CI->currency(); ?>)</th>

                      <th style=""><?= $this->lang->line('total'); ?>(<?= $CI->currency(); ?>)</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyid">
                  </tbody>
                </table>
              </div> -->
              <!-- /.box-body -->
              <?php if (isset($_GET['search'])) { ?>
                <div id="print">
                  <div class="row" id="header" style="display: none;">
                    <div class="col-sm-12 col-md-12 col-12" style="text-align: center;">
                      <div class="col-sm-12 col-md-12 col-12">
                        <h3><b><?php echo $company->store_name; ?></b></h3>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        <b><?php echo $company->address . ', ' . $company->city . ', ' . $company->state; ?></b>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        <b>Mobile&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->mobile; ?></b>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        <b>Email&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->email; ?></b>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        <b>TRN&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $company->vat_no; ?></b>
                      </div>
                    </div>
                    <div class="col-sm-8 col-md-8 col-xs-8">
                      <div class="col-sm-12 col-md-12 col-12">
                        <b>Customer&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $customer->customer_name; ?></b>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        <b>Mobile&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $customer->mobile; ?></b>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        <b>Address&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $customer->address; ?></b>
                      </div>
                    </div>
                    <div class="col-sm-4 col-md-4 col-xs-4">
                      <div class="col-sm-12 col-md-12 col-12">
                        <b>Start Date&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo date('d-m-Y', strtotime($sdate)); ?></b>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        <b>End Date&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo date('d-m-Y', strtotime($edate)); ?></b>
                      </div>
                      <div class="col-sm-12 col-md-12 col-12">
                        <b>Print Date&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo date('d-m-Y'); ?></b>
                      </div>
                    </div>
                  </div>

                  <div class="box-body">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                      <table class="table table-bordered table-striped " id="report-data">
                        <thead>
                          <tr class="bg-blue">
                            <th class="hidden">#</th>
                            <th data-orderable="false">Doc No.</th>
                            <th data-orderable="false">Doc Date</th>
                            <th data-orderable="false">Doc Type</th>
                            <th data-orderable="false">Debit</th>
                            <th data-orderable="false">Credit</th>
                            <th data-orderable="false">Balance</th>
                          </tr>
                        </thead>
                        <tbody id="tbodyid">
                          <?php if ($sale != null) { ?>
                            <?php
                            $i = 0;
                            $tsa = 0;
                            $tsp = 0;
                            $tsd = 0;
                            foreach ($sale as $value) {
                              $i++;

                              $saprod = $this->db->select("SUM(grand_total) as total,SUM(paid_amount) as ptotal")
                                ->FROM('db_sales')
                                ->where('customer_id', $customer->id)
                                ->where('count_id <=', $value->count_id)
                                //->where('sales_date <=',$value->sales_date)
                                //->where_not_in('return_bit',1)
                                ->where("grand_total > paid_amount")
                                ->get()
                                ->row();
                              //var_dump($saprod); exit();
                              if ($saprod) {
                                $satp = ($saprod->total - $saprod->ptotal);
                              } else {
                                $satp = 0;
                              }

                              $sap1rod = $this->db->select("SUM(grand_total) as total,SUM(paid_amount) as ptotal")
                                ->FROM('db_sales')
                                ->where('customer_id', $customer->id)
                                ->where('sales_date >=', $sdate)
                                ->where('sales_date <=', $value->sales_date)
                                ->where('return_bit', 1)
                                ->where("grand_total > paid_amount")
                                ->get()
                                ->row();
                              //var_dump($saprod); exit();
                              if ($sap1rod) {
                                $sa2tp = ($sap1rod->total * 2);
                              } else {
                                $sa2tp = 0;
                              }
                              if ($payment) {
                                $puprod = $this->db->select("SUM(payment) as total")
                                  ->FROM('db_cobpayments')
                                  ->join('sales', 'sales.said = sales_payment.said', 'left')
                                  ->where('customer_id', $customer->id)
                                  ->where('payment_date <=', $value->sales_date)
                                  ->get()
                                  ->row();
                                if ($puprod) {
                                  $ptp = $puprod->total;
                                } else {
                                  $ptp = 0;
                                }
                              } else {
                                $ptp = 0;
                              }
                              if ($voucher) {
                                $cvpay = $this->db->select("SUM(payment) as total")
                                  ->FROM('db_customer_payments')
                                  ->where('customer_id', $customer->id)
                                  ->where('payment_date <=', $value->sales_date)
                                  ->get()
                                  ->row();
                                if ($cvpay) {
                                  $tcp = $cvpay->total;
                                } else {
                                  $tcp = 0;
                                }
                              } else {
                                $tcp = 0;
                              }
                            ?>
                              <tr class="gradeX">
                                <td class="hidden"><?php echo date('Ymd', strtotime($value->sales_date)); ?></td>
                                <td><?php echo $value->sales_code; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($value->sales_date)); ?></td>
                                <td><?php if ($value->return_bit == 1) {
                                      echo 'Return';
                                    } else {
                                      echo 'Invoice';
                                    } ?></td>
                                <td><?php if ($value->return_bit == 0) {
                                      echo number_format($value->grand_total, 2);
                                      $tsa += $value->grand_total;
                                    } else {
                                      echo '0.00';
                                      $tsa += 0;
                                    } ?></td>
                                <td><?php if ($value->return_bit == 1) {
                                      echo number_format($value->grand_total, 2);
                                      $tsp += $value->grand_total;
                                    } else {
                                      echo number_format($value->paid_amount, 2);
                                      $tsp += $value->paid_amount;
                                    } ?></td>
                                <td><?php echo number_format(($satp - $sa2tp), 2); ?></td>
                              </tr>
                            <?php } ?>
                          <?php } else { ?>
                            <?php $tsa = 0;
                            $tsp = 0;
                            $tsd = 0;
                            $i = 0; ?>
                          <?php } ?>

                          <?php if ($payment != null) { ?>

                            <?php
                            $j = $i;
                            $tcva = 0;
                            foreach ($payment as $value) {
                              $j++;
                              if ($sale) {
                                $saprod = $this->db->select("SUM(grand_total) as total,SUM(paid_amount) as ptotal")
                                  ->FROM('db_sales')
                                  ->where('customer_id', $customer->id)
                                  ->where('sales_date <=', $value->payment_date)
                                  ->get()
                                  ->row();
                                if ($saprod) {
                                  $satp = ($saprod->total - $saprod->ptotal);
                                } else {
                                  $satp = 0;
                                }
                              } else {
                                $satp = 0;
                              }

                              $puprod = $this->db->select("SUM(payment) as total")
                                ->FROM('db_cobpayments')
                                ->join('sales', 'sales.said = sales_payment.said', 'left')
                                ->where('customer_id', $customer->id)
                                ->where('payment_date <=', $value->payment_date)
                                ->get()
                                ->row();
                              if (isset($puprod)) {
                                $ptp = $puprod->total;
                              } else {
                                $ptp = 0;
                              }
                              if ($voucher) {
                                $cvpay = $this->db->select("SUM(payment) as total")
                                  ->FROM('db_customer_payments')
                                  ->where('customer_id', $customer->id)
                                  ->where('payment_date <=', $value->payment_date)
                                  ->get()
                                  ->row();
                                if ($cvpay) {
                                  $tcp = $cvpay->total;
                                } else {
                                  $tcp = 0;
                                }
                              } else {
                                $tcp = 0;
                              }
                            ?>
                              <tr class="gradeX">
                                <td class="hidden"><?php echo date('Ymd', strtotime($value->payment_date)); ?></td>
                                <td><?php echo $value->id; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($value->payment_date)); ?></td>
                                <td><?php echo 'Money Receipt'; ?></td>
                                <td></td>
                                <td><?php echo number_format($value->payment, 2);
                                    $tcva += $value->payment; ?></td>
                                <td><?php echo number_format(($satp - ($ptp + $tcp)), 2); ?></td>
                              </tr>
                            <?php } ?>
                          <?php } else { ?>
                            <?php $tcva = 0;
                            $j = $i or $j = 0; ?>
                          <?php } ?>

                          <?php if ($voucher != null) { ?>

                            <?php
                            $k = $j;
                            $tva = 0;
                            foreach ($voucher as $value) {
                              $k++;
                              if ($sale) {
                                $saprod = $this->db->select("SUM(grand_total) as total,SUM(paid_amount) as ptotal")
                                  ->FROM('db_sales')
                                  ->where('customer_id', $customer->id)
                                  ->where('sales_date <=', $value->payment_date)
                                  ->get()
                                  ->row();
                                if ($saprod) {
                                  $satp = ($saprod->total - $saprod->ptotal);
                                } else {
                                  $satp = 0;
                                }
                              } else {
                                $satp = 0;
                              }
                              if ($payment) {
                                $puprod = $this->db->select("SUM(payment) as total")
                                  ->FROM('db_cobpayments')
                                  ->join('sales', 'sales.said = sales_payment.said', 'left')
                                  ->where('customer_id', $customer->id)
                                  ->where('payment_date <=', $value->payment_date)
                                  ->get()
                                  ->row();
                                if ($puprod) {
                                  $ptp = $puprod->total;
                                } else {
                                  $ptp = 0;
                                }
                              } else {
                                $ptp = 0;
                              }

                              $cvpay = $this->db->select("SUM(payment) as total")
                                ->FROM('db_customer_payments')
                                ->where('customer_id', $customer->id)
                                ->where('payment_date <=', $value->payment_date)
                                ->get()
                                ->row();
                              if ($cvpay) {
                                $tcp = $cvpay->total;
                              } else {
                                $tcp = 0;
                              }
                            ?>
                              <tr class="gradeX">
                                <td class="hidden"><?php echo date('Ymd', strtotime($value->payment_date)); ?></td>
                                <td><?php echo $value->id; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($value->payment_date)); ?></td>
                                <td><?php echo 'Money Receipt'; ?></td>
                                <td></td>
                                <td><?php echo number_format($value->payment, 2);
                                    $tva += $value->payment; ?></td>
                                <td><?php echo number_format(($satp - ($ptp + $tcp)), 2); ?></td>
                              </tr>
                            <?php } ?>
                          <?php } else { ?>
                            <?php $tva = 0; ?>
                          <?php } ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td class="hidden"></td>
                            <td colspan="3" align="right"><b>Grand Total</b></td>
                            <td><b><?php echo number_format($tsa, 2); ?></b></td>
                            <td><b><?php echo number_format($tsp + $tcva + $tva, 2); ?></b></td>
                            <td><b><?php echo number_format(($tsa - ($tsp + $tcva + $tva)), 2); ?></b></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              <?php } ?>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>
      </section>
    </div>
    <!-- /.content-wrapper -->
    <?php include "footer.php"; ?>
    <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <!-- SOUND CODE -->
  <?php include "comman/code_js_sound.php"; ?>
  <!-- TABLES CODE -->
  <?php include "comman/code_js.php"; ?>
  <!-- TABLE EXPORT CODE -->
  <?php include "comman/code_js_export.php"; ?>
  <script src="<?php echo $theme_link; ?>js/sheetjs.js" type="text/javascript"></script>

  <script type="text/javascript">
    $(function() {
      $("#custdata").DataTable({
        "order": [
          [0, "asc"]
        ],
        "paging": false,
        'aTargets': '_all'
      });
    });
  </script>

  <script type="text/javascript">
    function printDiv(divName) {
      $('#header').show();
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
      location.reload();
    }
  </script>

  <!-- Make sidebar menu hughlighter/selector -->
  <script>
    $(".<?php echo basename(__FILE__, '.php'); ?>-active-li").addClass("active");
  </script>
</body>

</html>