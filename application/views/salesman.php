<!DOCTYPE html>
<html>
   <head>
      <!-- TABLES CSS CODE -->
      <?php include"comman/code_css.php"; ?>
      <style type="text/css">
     
      </style>
      <!-- </copy> -->  
   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php include"sidebar.php"; ?>
         <?php
            if(!isset($salesman_name)){
               $salesman_name=$mobile=$email=$description='';
            }
            ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?= $page_title; ?>
                  <small>Enter User Information</small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li><a href="<?php echo $base_url; ?>users/view"><?= $this->lang->line('view_users'); ?></a></li>
                  <li class="active"><?= $page_title; ?></li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- ********** ALERT MESSAGE START******* -->
                  <?php include"comman/code_flashdata.php"; ?>
                  <!-- ********** ALERT MESSAGE END******* -->
                  <!-- right column -->
                  <div class="col-md-12">
                     <!-- Horizontal Form -->
                     <div class="">
                                          <form class="form-horizontal" id="salesman-form" method="post">
                     <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                           <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa  fa-pencil-square text-red"></i> <?= $this->lang->line('add/edit'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                           <div class="tab-pane active" id="tab_1">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                           <div class="box-body">
                              <div class="row">
                                 <div class="col-md-5">
                                    <!-- Store Code -->
                                    <?php 
                                    /*if(store_module() && is_admin()) {$this->load->view('store/store_code',array('show_store_select_box'=>true,'store_id'=>$store_id,'label_length'=>'col-sm-4','div_length'=>'col-sm-8')); }else{*/
                                echo "<input type='hidden' name='store_id' id='store_id' value='".get_current_store_id()."'>";
                              /*}*/
                              ?>
                                    <!-- Store Code end -->
                                 </div>
                              </div>
                              <div class="row">
                                 

                                 <div class="col-md-10">
                                    <div class="form-group">
                                       <label for="salesman_name" class="col-sm-2 control-label"><?= $this->lang->line('salesman_name'); ?><label class="text-danger">*</label></label>
                                       <div class="col-sm-4">
                                          <input type="text" class="form-control" id="salesman_name" name="salesman_name" placeholder=""  value="<?php print $salesman_name; ?>" >
                                          <span id="salesman_name_msg" style="display:none" class="text-danger"></span>
                                       </div>
                                    <!-- </div>
                                    <div class="form-group"> -->
                                       <label for="mobile" class="col-sm-2 control-label"><?= $this->lang->line('mobile'); ?></label>
                                       <div class="col-sm-4">
                                          <input type="text" class="form-control no_special_char_no_space" id="mobile" name="mobile" placeholder="+1234567890" value="<?php print $mobile; ?>"  >
                                          <span id="mobile_msg" style="display:none" class="text-danger"></span>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="email" class="col-sm-2 control-label"><?= $this->lang->line('email'); ?></label>
                                       <div class="col-sm-4">
                                          <input type="text" class="form-control" id="email" name="email" placeholder="" value="<?php print $email; ?>" >
                                          <span id="email_msg" style="display:none" class="text-danger"></span>
                                       </div>
                                     </div>
                                     <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label"><?= $this->lang->line('description'); ?></label>
                                        <div class="col-sm-4">
                                           <textarea type="text" class="form-control" id="description" name="description" placeholder="" ><?php print $description; ?></textarea>
                                           <span id="description_msg" style="display:none" class="text-danger"></span>
                                        </div>
                                     </div>

                                 </div>
                                 <!-- ########### -->
                              </div>
                           </div>
                           </div>
                           <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->

                     </div>
                    <div class="col-sm-8 col-sm-offset-2 text-center">
                           <center>
                            <?php
                                    if($salesman_name!=""){
                                         $btn_name="Update";
                                         $btn_id="update";
                                         ?>
                                 <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id;?>"/>
                                 <?php
                                    }
                                  else{
                                      $btn_name="Save";
                                      $btn_id="save";
                                  }
                        
                                  ?>
                            <div class="col-md-3 col-md-offset-3">
                                 <button type="button" id="<?php echo $btn_id;?>" class=" btn btn-block btn-success" title="Save Data"><?php echo $btn_name;?></button>
                              </div>
                              <div class="col-sm-3">
                                    <a href="<?=base_url('dashboard');?>">
                                    <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                                    </a>
                                 </div>

                                 
                           </center>
                        </div>
                     <!-- /.box -->
                   </form>
                     </div>
                     <!-- /.box -->
                  </div>
                  <!--/.col (right) -->
                </div>


            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
         <?php include"footer.php"; ?>
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      <!-- SOUND CODE -->
      <?php include"comman/code_js_sound.php"; ?>
      <!-- TABLES CODE -->
      <?php include"comman/code_js.php"; ?>
      <script src="<?php echo $theme_link; ?>js/salesman.js"></script>
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
      <script type="text/javascript">
        <?php if(isset($q_id)){ ?>
          $("#store_id").attr('readonly',true);
        <?php }?>
        $("#price_level_type").val('<?= $price_level_type;?>').select2();
      </script>
      <script type="text/javascript">
        function show_attachment(imagepath=''){
          if(imagepath==''){
              toastr["warning"]("No Attachment Availble!");
              failed.currentTime = 0; 
              failed.play();
              return false;
          }
          else{
            window.open(imagepath, "_blank");
          }
        }
        $("#copy_address").on("ifChanged",function(event){
          if(event.target.checked){
           $("#shipping_country").val($("#country").val()).select2();
           $("#shipping_state").val($("#state").val()).select2();
           $("#shipping_postcode").val($("#postcode").val());
           $("#shipping_city").val($("#city").val());
           $("#shipping_address").val($("#address").val());
           $("#shipping_location_link").val($("#location_link").val());
          }
          else{
           $("#shipping_country").val('').select2();
           $("#shipping_state").val('').select2();
           $("#shipping_postcode").val('');
           $("#shipping_city").val('');
           $("#shipping_address").val('');
           $("#shipping_location_link").val('');
          }
        });
      </script>
   </body>
</html>
