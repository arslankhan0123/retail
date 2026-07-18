<!DOCTYPE html>
<html>
   <head>
      <!-- TABLES CSS CODE -->
      <?php include"comman/code_css.php"; ?>
      <style>
  @media(max-width: 480px){
  .small-box h3 {
    font-size: 23px;
    font-weight: bold;
    margin: 0 0 10px 0;
    white-space: nowrap;
    padding: 0;
}
}
.sectionmenu {
    display: block;
    min-height: 110px;
    background: #fff;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 5px;
    margin-bottom: 35px;
}
.sectionmenu .info-box-icon {
    border-top-left-radius: 2px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 2px;
    display: block;
    float: right;
    height: 80px;
    margin-right: 20px;
    margin-top: 13px;
    margin-left: 10px;
    padding: 8px;
    border-radius: 60px;
    background-color: rgb(0 0 0 / 31%);
    color: white;
    width: 80px;
    text-align: center;
    font-size: 40px;
    line-height: 68px;
}
.sectionmenu .info-box-content {
    padding: 24px 10px;
    margin-left: 27px;
}
.info-box-number {
    display: block;
    font-weight: bold;
    font-size: 14px;
}
</style>
      <link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/datepicker/datepicker3.css">
   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php include"sidebar.php"; ?>
         <?php 
            /*Total Invoices*/
            if (!is_admin()) {
              if ($this->session->userdata('role_id') != '2') {
                $this->db->where("upper(created_by)", strtoupper($this->session->userdata('inv_username')));
              }
            }
            $total_invoice = $this->db->select("COUNT(*) as total")->from("db_orders")->where("store_id", get_current_store_id())->get()->row()->total;
            /*Total Invoices Total*/
            if (!is_admin()) {
              if ($this->session->userdata('role_id') != '2') {
                $this->db->where("upper(created_by)", strtoupper($this->session->userdata('inv_username')));
              }
            }
            $pur_total = $this->db->select("COALESCE(sum(grand_total),0) AS tot_pur_grand_total")->from("db_orders")->where("order_status", 'Received')->where("store_id", get_current_store_id())->get()->row()->tot_pur_grand_total;
            
            // Total Paid
            if (!is_admin()) {
              if ($this->session->userdata('role_id') != '2') {
                $this->db->where("upper(created_by)", strtoupper($this->session->userdata('inv_username')));
              }
            }
            $tot_paid_amt=$this->db->select("COALESCE(SUM(paid_amount),0) AS paid_amount")->from("db_orders")->where("store_id",get_current_store_id())->get()->row()->paid_amount;
            $order_due_total = $pur_total - $tot_paid_amt;
            ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?=$page_title;?>
                  <small>View/Search Order</small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li class="active"><?=$page_title;?></li>
               </ol>
            </section>
            <div class="pay_now_modal">
            </div>
            <div class="view_payments_modal">
            </div>
            <!-- Main content -->
            <?= form_open('#', array('class' => '', 'id' => 'table_form')); ?>
            <input type="hidden" id='base_url' value="<?=$base_url;?>">
            <section class="content">
               <!-- Small boxes (Stat box) -->
               <div class="row">
                <!-- ********** ALERT MESSAGE START******* -->
                <?php include "comman/code_flashdata.php";?>
                <!-- ********** ALERT MESSAGE END******* -->
               </div>
               <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="info-box " >
                    <span class="info-box-icon bg-5"><i class="ion ion-bag"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text"><?=$total_invoice;?></span>
                      <span class="info-box-number">Total Invoices</span>
                    </div>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="info-box " >
                    <span class="info-box-icon bg-5"><i class="fa fa-dollar"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text"><?=$CI->currency(kmb($pur_total));?></span>
                      <span class="info-box-number">Total Invoices Amount</span>
                    </div>
                  </div>
                </div>
                <!-- /.col -->
                <div class="clearfix visible-sm-block"></div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="info-box " >
                    <span class="info-box-icon bg-5"><i class="fa fa-money"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text"><?=$CI->currency(kmb($tot_paid_amt));?></span>
                      <span class="info-box-number">Total Paid Amount</span>
                    </div>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="info-box " >
                    <span class="info-box-icon bg-5"><i class="fa fa-minus-circle"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text"><?=$CI->currency(kmb($order_due_total));?></span>
                      <span class="info-box-number">Total Order Due</span>
                    </div>
                  </div>
                </div>
              </div>
               <!-- /.row -->
               <div class="row">
                  <div class="col-xs-12">
                     <div class="box box-primary">
                        <div class="box-header with-border">
                          <div class="col-xs-8 input-group">
                              <?php 
                               if(warehouse_module() && warehouse_count()>1) {$this->load->view('warehouse/warehouse_code',array('show_warehouse_select_box_2'=>true,'show_all_option'=>true)); }else{
                                echo "<input type='hidden' name='warehouse_id' id='warehouse_id' value='".get_store_warehouse_id()."'>";
                                echo '<h3 class="box-title">'.$page_title.'</h3>';
                               }
                              ?>
                            </div>
                           <?php if($CI->permissions('order_add')) { ?>
                           <div class="box-tools">
                              <a class="btn btn-block btn-info" href="<?php echo $base_url; ?>orders/add">
                              <i class="fa fa-plus"></i> New Order</a>
                           </div>
                           <?php } ?>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                           <table id="example2" class="table table-bordered custom_hover" width="100%">
                              <thead class="bg-gray ">
                                 <tr>
                                    <th class="text-center">
                                       <input type="checkbox" class="group_check checkbox" >
                                    </th>
                                    <th>Order Date</th>
                                    <th>Order Code</th>
                                    <th>Order Status</th>
                                    <th><?= $this->lang->line('reference_no'); ?></th>
                                    <th><?= $this->lang->line('supplier_name'); ?></th>
                                    <th><?= $this->lang->line('total'); ?></th>
                                    <th><?= $this->lang->line('paid_amount'); ?></th>
                                    <th><?= $this->lang->line('payment_status'); ?></th>
                                    <th><?= $this->lang->line('created_by'); ?></th>
                                    <th><?= $this->lang->line('action'); ?></th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                <tr class="bg-gray">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align:right">Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <?= form_close();?>
         </div>
         <!-- /.content-wrapper -->
         <?php include"footer.php"; ?>
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- SOUND CODE -->
      <?php include"comman/code_js_sound.php"; ?>
      <!-- TABLES CODE -->
      <?php include"comman/code_js.php"; ?>
      <!-- bootstrap datepicker -->
      <script src="<?php echo $theme_link; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
      <script type="text/javascript">
           $('.datepicker').datepicker({
             autoclose: true,
             format: 'dd-mm-yyyy',
             todayHighlight: true
           });
      </script>
      <script type="text/javascript">
       function load_datatable(){
        var table = $('#example2').DataTable({ 
            "aLengthMenu": [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
            dom:'<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10 "B>>>tip',
            buttons: {
                 buttons: [
                     {
                         className: 'btn bg-red color-palette btn-flat hidden delete_btn pull-left',
                         text: 'Delete',
                         action: function ( e, dt, node, config ) {
                             multi_delete();
                         }
                     },
                     { extend: 'copy', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
                     { extend: 'excel', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
                     { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
                     { extend: 'print', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
                     { extend: 'csv', className: 'btn bg-teal color-palette btn-flat',footer: true, exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
                     { extend: 'colvis', className: 'btn bg-teal color-palette btn-flat',footer: true, text:'Columns' },  
                     ]
                 },
                 "processing": true,
                 "serverSide": true,
                 "order": [],
                 "responsive": true,
                 language: {
                     processing: '<div class="text-primary bg-primary" style="position: relative;z-index:100;overflow: visible;">Processing...</div>'
                 },
                 "ajax": {
                     "url": "<?php echo site_url('orders/ajax_list')?>",
                     "type": "POST",
                     "data": {
                      warehouse_id: $("#warehouse_id").val()
                     },
                     complete: function (data) {
                      $('.column_checkbox').iCheck({
                         checkboxClass: 'icheckbox_square-orange',
                         radioClass: 'iradio_square-orange',
                         increaseArea: '10%'
                       });
                      call_code();
                      },
                 },
                 "columnDefs": [
                 { 
                     "targets": [ 0,10 ],
                     "orderable": false,
                 },
                 {
                     "targets" :[0],
                     "className": "text-center",
                 },
                 ],
                  "footerCallback": function ( row, data, start, end, display ) {
                      var api = this.api(), data;
                      var intVal = function ( i ) {
                          return typeof i === 'string' ?
                              i.replace(/[\$,]/g, '')*1 :
                              typeof i === 'number' ?
                                  i : 0;
                      };
                      var total = api
                          .column( 6, { page: 'none'} )
                          .data()
                          .reduce( function (a, b) {
                              return intVal(a) + intVal(b);
                          }, 0 );
                      var paid = api
                          .column( 7, { page: 'none'} )
                          .data()
                          .reduce( function (a, b) {
                              return intVal(a) + intVal(b);
                          }, 0 );
                      $( api.column( 6 ).footer() ).html(to_Fixed(total));
                      $( api.column( 7 ).footer() ).html(to_Fixed(paid));
                  },
              });
              new $.fn.dataTable.FixedHeader( table );
        }
       $(document).ready(function() {
          load_datatable();
       });
       $("#warehouse_id").on("change",function(){
           $('#example2').DataTable().destroy();
           load_datatable();
       });
      </script>
      <script src="<?php echo $theme_link; ?>js/orders.js"></script>
      <script>$(".orders-list-active-li").addClass("active");</script>
   </body>
</html>
