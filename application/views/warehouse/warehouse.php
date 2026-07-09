<!DOCTYPE html>
<html>
   <head>
      <!-- TABLES CSS CODE -->
      <?php $this->load->view('comman/code_css.php');?>
      <!-- </copy> -->  
   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php $this->load->view('sidebar');?>
         <?php
            if(!isset($warehouse_name)){
              $warehouse_name=$mobile=$email=$country=$state=$city=$area=$contact_person=$mobile_number=$phone_number=$fax=$q_id='';
              $disabled='';
            }else{
              $disabled='disabled="disabled"';
            }
            ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?= $this->lang->line('warehouse'); ?>
                  <small>Enter Valid Information</small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li><a href="<?php echo $base_url; ?>warehouse"><?= $this->lang->line('warehouse_list'); ?></a></li>
                  <li class="active"><?= $this->lang->line('warehouse'); ?></li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- ********** ALERT MESSAGE START******* -->
                  <?php $this->load->view('comman/code_flashdata');?>
                  <!-- ********** ALERT MESSAGE END******* -->
                  <!-- right column -->
                  <div class="col-md-12">
                     <!-- Horizontal Form -->
                     <div class="box box-primary ">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="warehouse-form" onkeypress="return event.keyCode != 13;">
                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                           <div class="box-body">
                              <!-- Store Code -->
                              <?php /*if(store_module() && is_admin()) {$this->load->view('store/store_code',array('show_store_select_box'=>true,'store_id'=>$store_id)); }else{*/
                                 echo "<input type='hidden' name='store_id' id='store_id' value='".get_current_store_id()."'>";
                                 /*}*/ ?>
                              <!-- Store Code end -->
                              <div class="form-group">
                                 <label for="warehouse_name" class="col-sm-2 control-label"><?= $this->lang->line('warehouse_name'); ?><label class="text-danger">*</label></label>
                                 <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm" id="warehouse_name" name="warehouse_name" placeholder="" onkeyup="shift_cursor(event,'mobile')" value="<?php print $warehouse_name; ?>"  autofocus>
                                    <span id="warehouse_name_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label for="mobile" class="col-sm-2 control-label"><?= $this->lang->line('mobile'); ?></label>
                                 <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm no_special_char_no_space"  id="mobile" name="mobile" placeholder="" value="<?= $mobile; ?>" onkeyup="shift_cursor(event,'email')"  >
                                    <span id="mobile_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label for="email" class="col-sm-2 control-label"><?= $this->lang->line('email'); ?></label>
                                 <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm" value="<?= $email; ?>"  id="email" name="email" placeholder="" onkeyup="shift_cursor(event,'pass')"  >
                                    <span id="email_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              
                              
                              <div class="form-group">
                                 <label for="country" class="col-sm-2 control-label"><?= $this->lang->line('country'); ?></label>
                                 <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm" value="<?= $country; ?>"  id="country" name="country" placeholder="" onkeyup="shift_cursor(event,'pass')"  >
                                    <span id="country_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              
                              
                              <div class="form-group">
                                 <label for="state" class="col-sm-2 control-label"><?= $this->lang->line('state'); ?></label>
                                 <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm" value="<?= $state; ?>"  id="state" name="state" placeholder="" onkeyup="shift_cursor(event,'pass')"  >
                                    <span id="state_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              
                              
                              
                              <div class="form-group">
                                 <label for="city" class="col-sm-2 control-label">City</label>
                                 <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm" value="<?= $city; ?>"  id="city" name="city" placeholder="" onkeyup="shift_cursor(event,'pass')"  >
                                    <span id="city_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              
                              <div class="form-group">
                                 <label for="area" class="col-sm-2 control-label">Area</label>
                                 <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm" value="<?= $area; ?>"  id="area" name="area" placeholder="" onkeyup="shift_cursor(event,'pass')"  >
                                    <span id="area_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              
                              
                              <div class="form-group">
                                 <label for="contact_person" class="col-sm-2 control-label">Contact Person</label>
                                 <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm" value="<?= $contact_person; ?>"  id="contact_person" name="contact_person" placeholder="" onkeyup="shift_cursor(event,'pass')"  >
                                    <span id="contact_person_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              
                              <div class="form-group">
                                 <label for="mobile_number" class="col-sm-2 control-label">Mobile Number</label>
                                 <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm" value="<?= $mobile_number; ?>"  id="mobile_number" name="mobile_number" placeholder="" onkeyup="shift_cursor(event,'pass')"  >
                                    <span id="mobile_number_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              
                              
                              <div class="form-group">
                                 <label for="phone_number" class="col-sm-2 control-label">Phone Number</label>
                                 <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm" value="<?= $phone_number; ?>"  id="phone_number" name="phone_number" placeholder="" onkeyup="shift_cursor(event,'pass')"  >
                                    <span id="phone_number_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              
                              <div class="form-group">
                                 <label for="fax" class="col-sm-2 control-label">Fax</label>
                                 <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm" value="<?= $fax; ?>"  id="fax" name="fax" placeholder="" onkeyup="shift_cursor(event,'pass')"  >
                                    <span id="fax_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              
                              
                           </div>
                           <!-- /.box-body -->
                          
                           <div class="box-footer">
                               <div class="col-sm-8 col-sm-offset-2 text-center">
                                  <!-- <div class="col-sm-4"></div> -->
                                  <?php
                                     if($q_id!=""){
                                          $btn_name="Update";
                                          $btn_id="update";
                                        
                                     }
                                               else{
                                                   $btn_name="Save";
                                                   $btn_id="save";
                                               }
                                     
                                               ?>
                                       <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id;?>"/>         
                                  <div class="col-md-3 col-md-offset-3">
                                     <button type="button" id="<?php echo $btn_id;?>" class=" btn btn-block btn-success" title="Save Data"><?php echo $btn_name;?></button>
                                  </div>
                                  <div class="col-sm-3">
                                   <a href="<?=base_url('dashboard');?>">
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
         </div>
         <!-- /.content-wrapper -->
         <?php $this->load->view('footer.php');?>
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      <!-- SOUND CODE -->
      <?php $this->load->view('comman/code_js_sound.php');?>
      <!-- TABLES CODE -->
      <?php $this->load->view('comman/code_js.php');?>
      <script src="<?php echo $theme_link; ?>js/warehouse/warehouse.js"></script>
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
   </body>
</html>
