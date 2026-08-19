<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php include "comman/code_css.php";?>
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
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/datepicker/datepicker3.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->

  <?php include "sidebar.php";?>

  <?php
/*Total Points*/
$this->db->where("upper(a.created_by)", strtoupper($this->session->userdata('inv_username')));
$this->db->select("coalesce(sum(seller_points)) as seller_points");
$this->db->join("db_salesitems b", "b.sales_id=a.id", "inner");
$this->db->from("db_sales a");
$this->db->where("a.store_id", get_current_store_id());
$seller_points = $this->db->get()->row()->seller_points;
$seller_points = store_number_format($seller_points);
/*Total Invoices*/
if (!is_admin()) {
	if ($this->session->userdata('role_id') != '2') {
		$this->db->where("upper(created_by)", strtoupper($this->session->userdata('inv_username')));
	}
}
$total_invoice = $this->db->select("COUNT(*) as total")->from("db_sales")->where("store_id", get_current_store_id())->get()->row()->total;
/*Total Invoices Total*/
if (!is_admin()) {
	if ($this->session->userdata('role_id') != '2') {
		$this->db->where("upper(created_by)", strtoupper($this->session->userdata('inv_username')));
	}
}
$sal_total = $this->db->select("COALESCE(sum(grand_total),0) AS tot_sal_grand_total")->from("db_sales")->where("sales_status", 'Final')->where("store_id", get_current_store_id())->get()->row()->tot_sal_grand_total;

/*Total Invoices Return Total*/
if (!is_admin()) {
	if ($this->session->userdata('role_id') != '2') {
		$this->db->where("upper(created_by)", strtoupper($this->session->userdata('inv_username')));
	}
}

$tot_received_amt = $this->db->select("COALESCE(SUM(paid_amount),0) AS paid_amount")->from("db_sales")->where("store_id", get_current_store_id())->get()->row()->paid_amount;

//total sales due
if (!is_admin()) {
	if ($this->session->userdata('role_id') != '2') {
		$this->db->where("upper(created_by)", strtoupper($this->session->userdata('inv_username')));
	}
}
$sales_due_total = $this->db->select("COALESCE(SUM(sales_due),0) AS sales_due")->from("db_customers")->where("store_id", get_current_store_id())->get()->row()->sales_due;

//$sales_due_total = $sal_total - $sal_return_total;

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
       
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
    <?=form_open('#', array('class' => '', 'id' => 'table_form'));?>
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
              <span class="info-box-text" ><?=$total_invoice;?></span>
              <span class="info-box-number"><?=$this->lang->line('total_invoices');?></span>
            </div>
            
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box " >
            <span class="info-box-icon bg-5"><i class="fa fa-dollar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text" ><?=$CI->currency(kmb($sal_total));?></span>
              <span class="info-box-number"><?=$this->lang->line('total_invoices_amount');?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box " >
            <span class="info-box-icon bg-5"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text" ><?=$CI->currency(kmb($tot_received_amt));?></span>
              <span class="info-box-number"><?=$this->lang->line('total_received_amount');?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box " >
            <span class="info-box-icon bg-5"><i class="fa fa-minus-circle"></i></span>

            <div class="info-box-content">
              <span class="info-box-text" ><?=$CI->currency(kmb($sales_due_total));?></span>
              <span class="info-box-number"><?=$this->lang->line('total_sales_due');?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>





      <div class="row">
        
        <div class="col-xs-12 ">
          <div class="box box-primary">
            <div class="box-header with-border">
              <!-- <h3 class="box-title"><?=$page_title;?></h3> -->

              <div class="row">
                <div class="col-md-12">
                <div class="col-md-2 pull-right">
                  <?php if ($CI->permissions('sales_add')) {?>
                  <div class="box-tools">
                <a class="btn btn-block btn-info" href="<?php echo $base_url; ?>sales/add">
                <i class="fa fa-plus"></i> <?=$this->lang->line('new_sales');?></a>
              </div>
                 <?php }?>
                </div>
                </div>
              </div>
              <div class="row">

                <div class="col-md-12">

                <!-- Warehouse Code -->
                <?php if (warehouse_module() && warehouse_count() > 1) {
	echo '<div class="col-md-4">';
	$this->load->view('warehouse/warehouse_code', array('show_warehouse_select_box' => true, 'div_length' => '',
		'label_length' => '', 'show_all' => 'true', 'show_all_option' => true, 'remove_star' => true));
	echo '</div>';
} else {
	echo "<input type='hidden' name='warehouse_id' id='warehouse_id' value='" . get_store_warehouse_id() . "'>";
}?>
                <!-- Warehouse Code end -->

                <div class="col-md-4">
                    <div class="form-group">
                       <label for="search_customer_id"><?=$this->lang->line('customers');?> </label></label>
                       <select class="form-control select2" id="search_customer_id" name="search_customer_id"  style="width: 100%;">
                        <option value="">-All Customers-</option>
                        <?=get_customers_select_list(null,get_current_store_id());?>
                     </select>
                       <span id="search_customer_id_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                       <label for="users"><?=$this->lang->line('users');?> </label></label>
                       <select class="form-control select2" id="users" name="users"  style="width: 100%;">
                        <?php if(is_admin() || is_store_admin()){ ?>
                          <?=get_users_select_list($this->session->userdata("role_id"), get_current_store_id());?>
                        <?php }else{ ?>
                          <option value="<?=html_escape($this->session->userdata('inv_username'));?>"><?=html_escape(ucfirst($this->session->userdata('inv_username')));?></option>
                        <?php } ?>
                     </select>
                       <span id="users_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>

                  <?php $sales_departments = $this->db->select('*')->from('db_department')->get()->result(); ?>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="filter_dptid">Department</label>
                      <select class="form-control select2" id="filter_dptid" style="width:100%;">
                        <option value="">-All Departments-</option>
                        <?php foreach($sales_departments as $department){ ?>
                          <option value="<?= $department->dptid; ?>"><?= $department->dptName; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="filter_category_id">Category</label>
                      <select class="form-control select2" id="filter_category_id" style="width:100%;">
                        <option value="">-All Categories-</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="filter_scatid">Sub Category</label>
                      <select class="form-control select2" id="filter_scatid" style="width:100%;">
                        <option value="">-All Sub Categories-</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="filter_salesman_id">Salesman</label>
                      <select class="form-control select2" id="filter_salesman_id" style="width:100%;">
                        <option value="">-All Salesmen-</option>
                        <?= get_salesmans_select_list(null,get_current_store_id()); ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                       <label for="sales_from_date"><?=$this->lang->line('from_date');?> </label></label>
                       <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                         </div>
                         <input type="text" class="form-control pull-right datepicker"  id="sales_from_date" name="sales_from_date">
                      </div>
                       <span id="sales_from_date_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                       <label for="sales_to_date"><?=$this->lang->line('to_date');?> </label></label>
                       <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                         </div>
                         <input type="text" class="form-control pull-right datepicker"  id="sales_to_date" name="sales_to_date">
                      </div>
                       <span id="sales_to_date_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                       <label for="sales_type"> Type </label></label>
                       <select class="form-control" id="sales_type" name="sales_type"  style="width: 100%;">
                         <option value="all">All</option>
                         <option value="retail">Retail</option>
                         <option value="wholesale">Wholesale</option>
                       </select>
                       <span id="sales_type_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>

                  <!-- <div class="col-md-2">
                    <div class="form-group">
                       <label for="item_id">&nbsp;</label></label>
                       <input type="button" class="btn btn-block btn-info" name="" value="Search">
                       <span id="item_id_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div> -->


                </div>
              </div>

            </div>
            <!-- /.box-header -->
            <div class="box-body ">
              <table id="example2" class="table custom_hover " width="100%">
                <thead class="bg-gray ">
                <tr>
                  <th class="text-center">
                    <input type="checkbox" class="group_check checkbox" >
                  </th>
                  <!-- <th><?=$this->lang->line('store_name');?></th> -->
                  <th><?=$this->lang->line('sales_date');?></th>
                  <th><?=$this->lang->line('due_date');?></th>
                  <th><?=$this->lang->line('sales_code');?></th>
                  <!-- <th><?=$this->lang->line('sales_status');?></th> -->
                  <th><?=$this->lang->line('reference_no');?></th>
                  <th><?=$this->lang->line('customer_name');?></th>
                  <!-- <th>Warehouse</th> -->
                  <th><?=$this->lang->line('total');?></th>
                  <th><?=$this->lang->line('paid_amount');?></th>
                  <th><?=$this->lang->line('payment_status');?></th>
                  <th><?=$this->lang->line('created_by');?></th>
                  <th><?=$this->lang->line('action');?></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                  <tr class="bg-gray" id="overdiv">
                     <!--  <th></th> -->
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
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <?=form_close();?>
  </div>
  <!-- /.content-wrapper -->
  <?php include "footer.php";?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- SOUND CODE -->
<?php include "comman/code_js_sound.php";?>
<!-- TABLES CODE -->
<?php include "comman/code_js.php";?>
<!-- bootstrap datepicker -->
<script src="<?php echo $theme_link; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
  //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
    format: 'dd-mm-yyyy',
     todayHighlight: true
    });
</script>
<script type="text/javascript">
      function load_datatable(){
        //datatables
         var table = $('#example2').DataTable({

          "aLengthMenu": [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],


            /* FOR EXPORT BUTTONS START*/
        dom:'<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10 "B>>>tip',
       /* dom:'<"row"<"col-sm-12"<"pull-left"B><"pull-right">>> <"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr>>>tip',*/
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
              /* FOR EXPORT BUTTONS END */

              "processing": true, //Feature control the processing indicator.
              "serverSide": true, //Feature control DataTables' server-side processing mode.
              "order": [], //Initial no order.
              "responsive": true,
              language: {
                  processing: '<div class="text-primary bg-primary" style="position: relative;z-index:100;overflow: visible;">Processing...</div>'
              },
              // Load data for the table's content from an Ajax source
              "ajax": {
                  "url": "<?php echo site_url('sales/ajax_list') ?>",
                  "type": "POST",
                  "data": {
                      warehouse_id: $("#warehouse_id").val(),
                      sales_from_date: $("#sales_from_date").val(),
                      sales_to_date: $("#sales_to_date").val(),
                      users: $("#users").val(),
                      sales_type: $("#sales_type").val(),
                      customer_id: $("#search_customer_id").val(),
                      dptid: $("#filter_dptid").val(),
                      category_id: $("#filter_category_id").val(),
                      scatid: $("#filter_scatid").val(),
                      salesman_id: $("#filter_salesman_id").val(),
                    },
                  complete: function (data) {
                   $('.column_checkbox').iCheck({
                      checkboxClass: 'icheckbox_square-orange',
                      /*uncheckedClass: 'bg-white',*/
                      radioClass: 'iradio_square-orange',
                      increaseArea: '10%' // optional
                    });
                   call_code();
                    //$(".delete_btn").hide();
                   },

              },

              //Set column definition initialisation properties.
              "columnDefs": [
              {
                  "targets": [ 0,10 ], //first column / numbering column
                  "orderable": false, //set not orderable
              },
              {
                  "targets" :[0],
                  "className": "text-center",
              },

              ],
              /*Start Footer Total*/
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // Remove the formatting to get integer data for summation
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
            /*var due = api
                .column( 8, { page: 'none'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );*/

            //$( api.column( 0 ).footer() ).html('Total');
            $( api.column( 6 ).footer() ).html(to_Fixed(total));
            $( api.column( 7 ).footer() ).html(to_Fixed(paid));
           // $( api.column( 8 ).footer() ).html((due));

        },
              /*End Footer Total*/
          });
          new $.fn.dataTable.FixedHeader( table );
      }
      $(document).ready(function() {
          //datatables
         load_datatable();
      });
      $("#warehouse_id,#sales_from_date,#sales_to_date,#users,#search_customer_id,#sales_type,#filter_scatid,#filter_salesman_id").on("change",function(){
          $('#example2').DataTable().destroy();
          load_datatable();
      });

      $("#filter_dptid").on("change",function(){
        $.post("<?= base_url('items/get_category_data'); ?>",{id:$(this).val()},function(data){
          var options='<option value="">-All Categories-</option>';
          $.each(data,function(_,category){ options+='<option value="'+category.id+'">'+category.category_name+'</option>'; });
          $("#filter_category_id").html(options).val('').trigger('change.select2');
          $("#filter_scatid").html('<option value="">-All Sub Categories-</option>').val('').trigger('change.select2');
          $('#example2').DataTable().destroy();
          load_datatable();
        },'json');
      });

      $("#filter_category_id").on("change",function(){
        $.post("<?= base_url('items/get_sub_category_data'); ?>",{id:$(this).val()},function(data){
          var options='<option value="">-All Sub Categories-</option>';
          $.each(data,function(_,subcategory){ options+='<option value="'+subcategory.scatid+'">'+subcategory.scatName+'</option>'; });
          $("#filter_scatid").html(options).val('').trigger('change.select2');
          $('#example2').DataTable().destroy();
          load_datatable();
        },'json');
      });


      /**************************************************/
       $("#payment_type").on("change",function(){
          show_cheque_details();
        });
        function show_cheque_details(){
            var payment_type = $("#payment_type").val();
            if(payment_type.toUpperCase()=='<?=strtoupper(cheque_name())?>'){
               $(".cheque_div").show();
            }
            else{
               $(".cheque_div").hide();
               $("#cheque_period,#cheque_number").val('');
            }
        }
      /**************************************************/



</script>
<script src="<?php echo $theme_link; ?>js/sales.js"></script>
<script type="text/javascript">
  function print_invoice(id){
  window.open("<?=base_url();?>pos/print_invoice_pos/"+id, "_blank", "scrollbars=1,resizable=1,height=500,width=500");
}
function show_receipt(id){
  window.open("<?=base_url();?>sales/print_show_receipt/"+id, "_blank", "scrollbars=1,resizable=1,height=500,width=500");
}
function share_invoice_whatsapp(id, mobile, sales_code, grand_total, public_pdf_url) {
  var phoneNumber = mobile.replace(/[^0-9]/g, '');
  var inputNumber = prompt("Enter customer WhatsApp number (with country code, e.g., 923001234567):", phoneNumber);
  if (inputNumber === null) {
    return;
  }
  if (inputNumber.trim() === "") {
    alert("Please enter a valid WhatsApp number.");
    return;
  }
  var message = "Dear Customer, here is your invoice " + sales_code + " for " + grand_total + ". You can view or download the PDF invoice here: " + public_pdf_url;
  var waLink = "https://api.whatsapp.com/send?phone=" + inputNumber + "&text=" + encodeURIComponent(message);
  window.open(waLink, '_blank');
}
</script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__, '.php'); ?>-active-li").addClass("active");</script>

</body>
</html>
