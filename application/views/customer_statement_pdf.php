<!DOCTYPE html>
<html>

<head>
  <!-- TABLES CSS CODE -->
  <?php include "comman/code_css.php"; ?>
  <!-- </copy> -->
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div id="print">
    <div class="row" id="header">
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
        <table class="table table-bordered table-striped " style="border-width:2px" id="report-data">
          <thead>
            <tr class="">
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
</body>

</html>