<!DOCTYPE html>
<html>

<head>
<!-- TABLES CSS CODE -->
<?php $this->load->view('comman/code_css.php');?>
<style type="text/css">
   table.table-bordered > thead > tr > th {
   text-align: center;
   }
   .table > tbody > tr > td, 
   .table > tbody > tr > th, 
   .table > tfoot > tr > td, 
   .table > tfoot > tr > th, 
   .table > thead > tr > td, 
   .table > thead > tr > th 
   {
   padding-left: 2px;
   padding-right: 2px;  
   }
</style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  
<div class="wrapper">
 
 <?php $this->load->view('sidebar');?>
 <?php
    $CI =& get_instance();
    if(!isset($damaged_id)){
      $damaged_date  = $warehouse_id =
      $reference_no  =
      $damaged_note=$store_id='';
      $damaged_date=show_date(date("d-m-Y"));
    }
    else{
      $q2 = $this->db->query("select * from db_damaged where id=$damaged_id");
      $warehouse_id=$q2->row()->warehouse_id;
      $damaged_date=show_date($q2->row()->damaged_date);
      $reference_no=$q2->row()->reference_no;
      $damaged_note=$q2->row()->damaged_note;
      $store_id=$q2->row()->store_id;

      $items_count = $this->db->query("select count(*) as items_count from db_damageditems where damaged_id=$damaged_id")->row()->items_count;
    }
    ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- **********************MODALS***************** -->
    <?php $this->load->view('modals/modal_stock_adjustment_item');?>
    <?php $this->load->view('modals/modal_item');?>
    <?php $this->load->view('modals/modal_item_or_service');?>
    <!-- **********************MODALS END***************** -->
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
         <h1>
            <?=$page_title;?>
            <small>Add/Update Damaged Stock</small>
         </h1>
         <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $base_url; ?>damaged">Damaged List</a></li>
            <li><a href="<?php echo $base_url; ?>damaged/add">New Damaged Stock</a></li>
            <li class="active"><?=$page_title;?></li>
         </ol>
      </section>

    <!-- Main content -->
     <section class="content">
               <div class="row">
                  <!-- right column -->
                  <div class="col-md-12">
                     <div class="box box-primary " >
                        <!-- form start -->
                        <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'damaged-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
                           <input type="hidden" id="base_url" value="<?php echo $base_url; ?>">
                           <input type="hidden" value='1' id="hidden_rowcount" name="hidden_rowcount">
                           <input type="hidden" value='0' id="hidden_update_rowid" name="hidden_update_rowid">

                           <div class="box-body">
                              <!-- Store Code -->
                              <input type='hidden' name='store_id' id='store_id' value='<?=get_current_store_id();?>'>
                              <!-- Warehouse Code -->
                              <?php 
                               if(warehouse_module() && warehouse_count()>1) {
                                 $this->load->view('warehouse/warehouse_code',array('show_warehouse_select_box'=>true,'warehouse_id'=>$warehouse_id,'div_length'=>'col-sm-3','show_select_option'=>false)); 
                               }else{
                                 echo "<input type='hidden' name='warehouse_id' id='warehouse_id' value='".get_store_warehouse_id()."'>";
                               }
                              ?>

                              <div class="form-group">
                                 <label for="damaged_date" class="col-sm-2 control-label">Date <label class="text-danger">*</label></label>
                                 <div class="col-sm-3">
                                    <div class="input-group date">
                                       <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                       </div>
                                       <input type="text" class="form-control pull-right datepicker" id="damaged_date" name="damaged_date" readonly value="<?= $damaged_date;?>">
                                    </div>
                                    <span id="damaged_date_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              
                                 <label for="reference_no" class="col-sm-2 control-label">Reference No</label>
                                 <div class="col-sm-3">
                                    <input type="text" value="<?php echo $reference_no; ?>" class="form-control" id="reference_no" name="reference_no" placeholder="" >
                                    <span id="reference_no_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="row">
                              <div class="col-md-12">
                                  <div class="box-header">
                                    <div class="col-md-8 col-md-offset-2 d-flex justify-content" >
                                     <div class="input-group">
                                            <span class="input-group-addon" title="Select Items"><i class="fa fa-barcode"></i></span>
                                             <input type="text" class="form-control" placeholder="Item name/Barcode/Itemcode" autofocus id="item_search">
                                             <span class="input-group-addon pointer text-green show_item_service" title="Click to Add New Item or Service"><i class="fa fa-plus"></i></span>
                                          </div>
                                    </div>
                                  </div>
                                  <div class="box-body">
                                    <div class="table-responsive" style="width: 100%">
                                    <table class="table table-hover table-bordered" style="width:100%" id="damaged_table">
                                         <thead class="custom_thead">
                                            <tr class="bg-primary">
                                               <th rowspan='2' style="width:15%">Item Name</th>
                                               <th rowspan='2' style="width:15%;min-width: 180px;">Quantity</th>
                                               <th rowspan='2' style="width:7.5%">Action</th>
                                            </tr>
                                         </thead>
                                         <tbody>
                                         </tbody>
                                      </table>
                                  </div>
                                  </div>
                              </div>
                              
                              <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                          <label for="" class="col-sm-4 control-label">Total Quantities</label>    
                                          <div class="col-sm-4">
                                             <label class="control-label total_quantity text-success" style="font-size: 15pt;">0</label>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 
                                <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                          <label for="damaged_note" class="col-sm-4 control-label">Note</label>    
                                          <div class="col-sm-8">
                                             <textarea class="form-control text-left" id='damaged_note' name="damaged_note"><?=$damaged_note;?></textarea>
                                             <span id="damaged_note_msg" style="display:none" class="text-danger"></span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="box-footer col-sm-12">
                              <center>
                                <?php
                                if(isset($damaged_id)){
                                  $btn_id='update';
                                  $btn_name="Update";
                                  echo '<input type="hidden" name="damaged_id" id="damaged_id" value="'.$damaged_id.'"/>';
                                }
                                else{
                                  $btn_id='save';
                                  $btn_name="Save";
                                }
                                ?>
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="button" id="<?php echo $btn_id;?>" class="btn btn-block btn-success payments_modal" title="Save Data"><?php echo $btn_name;?></button>
                                 </div>
                                 <div class="col-sm-3"><a href="<?= base_url()?>dashboard">
                                    <button type="button" class="btn btn-block btn-warning" title="Go Dashboard">Close</button>
                                  </a>
                                </div>
                              </center>
                           </div>

                        <?= form_close(); ?>
                     </div>
                  </div>
               </div>
             </section>
  </div>
  
 <?php $this->load->view('footer');?>
<!-- SOUND CODE -->
<?php $this->load->view('comman/code_js_sound');?>
<!-- GENERAL CODE -->
<?php $this->load->view('comman/code_js');?>
 
 <script src="<?php echo $theme_link; ?>js/modals.js"></script>
 <script src="<?php echo $theme_link; ?>js/modals/modal_item.js"></script>
 <div class="control-sidebar-bg"></div>
</div>

<script src="<?php echo $theme_link; ?>js/damaged/damaged.js"></script>  

<script>
        var base_url=$("#base_url").val();
        
        $("#warehouse_id").on("change",function(){
          $("#damaged_table > tbody").empty();
          final_total();
        });

         $(".close_btn").on("click",function(){
           if(confirm('Are you sure you want to navigate away from this page?')){
               window.location='<?php echo $base_url; ?>dashboard';
             }
         });
         
         $(".select2").select2();
         $('.datepicker').datepicker({
             autoclose: true,
             format: 'dd-mm-yyyy',
             todayHighlight: true
         });
         
         function final_total(){
           var rowcount=$("#hidden_rowcount").val();
           var total_quantity=0;
          
           for(i=1;i<=rowcount;i++){
             if(document.getElementById("td_data_"+i+"_3")){
                if($("#td_data_"+i+"_3").val()!=null && $("#td_data_"+i+"_3").val()!=''){ 
                     total_quantity +=parseFloat($("#td_data_"+i+"_3").val());
                }
             }
           }
           $(".total_quantity").html(format_qty(total_quantity));
         }
           
         function removerow(id){
             $("#row_"+id).remove();
             final_total();
             failed.currentTime = 0;
             failed.play();
         }
                
         function show_purchase_item_modal(row_id){
           $('#purchase_item').modal('toggle');
           var item_name = $("#td_data_"+row_id+"_1").html();
           var description = $("#description_"+row_id).val();
           $("#popup_item_name").html(item_name);
           $("#popup_description").val(description);
           $("#popup_row_id").val(row_id);
         }

         function set_info(){
           var row_id = $("#popup_row_id").val();
           var description = $("#popup_description").val();
           $("#description_"+row_id).val(description);
           final_total();
           $('#purchase_item').modal('toggle');
         }
</script>
<!-- UPDATE OPERATIONS -->
<script type="text/javascript">
   <?php if(isset($damaged_id)){ ?> 
       $(document).ready(function(){
          $("#store_id").attr('readonly',true);
          var base_url='<?= base_url();?>';
          var damaged_id='<?= $damaged_id;?>';
          $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
          $.post(base_url+"damaged/return_damaged_list/"+damaged_id,{},function(result){
            $('#damaged_table tbody').append(result);
            $("#hidden_rowcount").val(parseInt(<?=$items_count;?>)+1);
            success.currentTime = 0;
            success.play();
            $(".overlay").remove();
            final_total();
        }); 
       });
   <?php }?>
</script>
<!-- Make sidebar menu highlighter -->
<script>$(".damaged_list-active-li").addClass("active");</script>
</body>
</html>
