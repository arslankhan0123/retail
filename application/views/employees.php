<!DOCTYPE html>
<html>
   <head>
      <!-- TABLES CSS CODE -->
      <?php include"comman/code_css.php"; ?>
   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php include"sidebar.php"; ?>
         <?php
            if(!isset($employee_name)){
               $employee_id=$employee_name=$phone=$email=$joining_date=$dob=$marital_status=$blood_group=$gender=$country=$basic_salary=$gross_salary=$employee_image=$iqama_no=$iqama_expiry=$passport_no=$passport_expiry=$driving_license_no=$driving_license_expiry=$status=$store_id='';
               $basic_salary=0;
               $gross_salary=0;
               $documents=array();
            }
            ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?=$page_title;?>
                  <small>Add/Update Employee</small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li><a href="<?php echo $base_url; ?>employees">Employee List</a></li>
                  <li class="active"><?=$page_title;?></li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- ********** ALERT MESSAGE START******* -->
                  <?php include"comman/code_flashdata.php"; ?>
                  <!-- ********** ALERT MESSAGE END******* -->
                  
                  <div class="col-md-12">
                     <div class="box box-info ">
                        <!-- form start -->
                        <?= form_open_multipart('#', array('class' => 'form-horizontal', 'id' => 'employees-form', 'method'=>'POST', 'accept-charset'=>'UTF-8', 'novalidate'=>'novalidate' ));?>
                        <input type="hidden" id="base_url" value="<?php echo $base_url; ?>">
                        <div class="box-body">
                           
                           <!-- Store Code -->
                           <input type='hidden' name='store_id' id='store_id' value='<?= get_current_store_id(); ?>'>
                           
                           <h4 class="box-title text-primary">Basic Information</h4>
                           <hr>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="employee_id" class="col-sm-4 control-label">Employee ID<label class="text-danger">*</label></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="e.g. M11" value="<?php print $employee_id; ?>" autofocus>
                                       <span id="employee_id_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="employee_name" class="col-sm-4 control-label">Employee Name<label class="text-danger">*</label></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" id="employee_name" name="employee_name" placeholder="" value="<?php print $employee_name; ?>">
                                       <span id="employee_name_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="phone" class="col-sm-4 control-label">Phone</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" id="phone" name="phone" placeholder="" value="<?php print $phone; ?>">
                                       <span id="phone_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="email" class="col-sm-4 control-label">Email</label>
                                    <div class="col-sm-8">
                                       <input type="email" class="form-control" id="email" name="email" placeholder="" value="<?php print $email; ?>">
                                       <span id="email_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="joining_date" class="col-sm-4 control-label">Joining Date<label class="text-danger">*</label></label>
                                    <div class="col-sm-8">
                                       <div class="input-group date">
                                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                          <input type="text" class="form-control datepicker" id="joining_date" name="joining_date" placeholder="dd-mm-yyyy" readonly value="<?php print $joining_date; ?>">
                                       </div>
                                       <span id="joining_date_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="dob" class="col-sm-4 control-label">DOB</label>
                                    <div class="col-sm-8">
                                       <div class="input-group date">
                                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                          <input type="text" class="form-control datepicker" id="dob" name="dob" placeholder="dd-mm-yyyy" readonly value="<?php print $dob; ?>">
                                       </div>
                                       <span id="dob_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="status" class="col-sm-4 control-label">Status</label>
                                    <div class="col-sm-8">
                                       <select class="form-control select2" id="status" name="status" style="width:100%;">
                                          <option value="1" <?php echo ($status == '1' || $status == '') ? 'selected' : ''; ?>>Active</option>
                                          <option value="0" <?php echo ($status == '0') ? 'selected' : ''; ?>>Inactive</option>
                                       </select>
                                       <span id="status_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="marital_status" class="col-sm-4 control-label">Marital Status</label>
                                    <div class="col-sm-8">
                                       <select class="form-control select2" id="marital_status" name="marital_status" style="width:100%;">
                                          <option value="">-Select-</option>
                                          <option value="Single" <?php echo ($marital_status == 'Single') ? 'selected' : ''; ?>>Single</option>
                                          <option value="Married" <?php echo ($marital_status == 'Married') ? 'selected' : ''; ?>>Married</option>
                                          <option value="Divorced" <?php echo ($marital_status == 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
                                          <option value="Widowed" <?php echo ($marital_status == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
                                       </select>
                                       <span id="marital_status_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="blood_group" class="col-sm-4 control-label">Blood Group</label>
                                    <div class="col-sm-8">
                                       <select class="form-control select2" id="blood_group" name="blood_group" style="width:100%;">
                                          <option value="">-Select-</option>
                                          <?php
                                             $bg_list = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');
                                             foreach ($bg_list as $bg) {
                                                $selected = ($blood_group == $bg) ? 'selected' : '';
                                                echo "<option value='$bg' $selected>$bg</option>";
                                             }
                                          ?>
                                       </select>
                                       <span id="blood_group_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="gender" class="col-sm-4 control-label">Gender</label>
                                    <div class="col-sm-8">
                                       <select class="form-control select2" id="gender" name="gender" style="width:100%;">
                                          <option value="">-Select-</option>
                                          <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                                          <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                                          <option value="Other" <?php echo ($gender == 'Other') ? 'selected' : ''; ?>>Other</option>
                                       </select>
                                       <span id="gender_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="country" class="col-sm-4 control-label">Country</label>
                                    <div class="col-sm-8">
                                       <select class="form-control select2" id="country" name="country" style="width:100%;">
                                          <option value="">-Select-</option>
                                          <?php
                                             $q_country = $this->db->select('*')->where('status',1)->get('db_country');
                                             foreach ($q_country->result() as $res_c) {
                                                $selected = ($country == $res_c->country) ? 'selected' : '';
                                                echo "<option value='".$res_c->country."' $selected>".$res_c->country."</option>";
                                             }
                                          ?>
                                       </select>
                                       <span id="country_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="basic_salary" class="col-sm-4 control-label">Basic Salary<label class="text-danger">*</label></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control only_currency" id="basic_salary" name="basic_salary" placeholder="" value="<?php print store_number_format($basic_salary,0); ?>">
                                       <span id="basic_salary_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="gross_salary" class="col-sm-4 control-label">Gross Salary</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control only_currency" id="gross_salary" name="gross_salary" placeholder="" value="<?php print store_number_format($gross_salary,0); ?>">
                                       <span id="gross_salary_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="employee_image" class="col-sm-4 control-label">Employee Image (Max 2MB)</label>
                                    <div class="col-sm-8">
                                       <input type="file" class="form-control" id="employee_image" name="employee_image" accept=".png,.jpg,.jpeg">
                                       <span id="employee_image_msg" style="display:none" class="text-danger"></span>
                                       <?php if(!empty($employee_image)) { ?>
                                          <br><img src="<?php echo base_url($employee_image); ?>" width="80px" height="80px" class="img-thumbnail">
                                       <?php } ?>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <br>
                           <h4 class="box-title text-primary">Identification</h4>
                           <hr>
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <div class="col-sm-12">
                                       <label for="iqama_no">Iqama no<label class="text-danger">*</label></label>
                                       <input type="text" class="form-control" id="iqama_no" name="iqama_no" placeholder="" value="<?php print $iqama_no; ?>">
                                       <span id="iqama_no_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <div class="col-sm-12">
                                       <label for="iqama_expiry">Expiry Date</label>
                                       <div class="input-group date">
                                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                          <input type="text" class="form-control datepicker" id="iqama_expiry" name="iqama_expiry" placeholder="dd-mm-yyyy" readonly value="<?php print $iqama_expiry; ?>">
                                       </div>
                                       <span id="iqama_expiry_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <div class="col-sm-12">
                                       <label for="passport_no">Passport no</label>
                                       <input type="text" class="form-control" id="passport_no" name="passport_no" placeholder="" value="<?php print $passport_no; ?>">
                                       <span id="passport_no_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <div class="col-sm-12">
                                       <label for="passport_expiry">Expiry Date</label>
                                       <div class="input-group date">
                                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                          <input type="text" class="form-control datepicker" id="passport_expiry" name="passport_expiry" placeholder="dd-mm-yyyy" readonly value="<?php print $passport_expiry; ?>">
                                       </div>
                                       <span id="passport_expiry_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <div class="col-sm-12">
                                       <label for="driving_license_no">Driving License no</label>
                                       <input type="text" class="form-control" id="driving_license_no" name="driving_license_no" placeholder="" value="<?php print $driving_license_no; ?>">
                                       <span id="driving_license_no_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <div class="col-sm-12">
                                       <label for="driving_license_expiry">Expiry date</label>
                                       <div class="input-group date">
                                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                          <input type="text" class="form-control datepicker" id="driving_license_expiry" name="driving_license_expiry" placeholder="dd-mm-yyyy" readonly value="<?php print $driving_license_expiry; ?>">
                                       </div>
                                       <span id="driving_license_expiry_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <br>
                           <h4 class="box-title text-primary">Documents</h4>
                           <hr>
                           <?php if (!empty($documents)) { ?>
                              <div class="row">
                                 <div class="col-md-12">
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr class="bg-gray">
                                             <th>Document Title</th>
                                             <th>File (PDF/Image)</th>
                                             <th>Expiry Date</th>
                                             <th class="text-center">Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php foreach ($documents as $doc) { ?>
                                             <tr id="existing_doc_<?php echo $doc->id; ?>">
                                                <td><?php echo $doc->document_name; ?></td>
                                                <td><a href="<?php echo base_url($doc->file_path); ?>" target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-download"></i> View Document</a></td>
                                                <td><?php echo !empty($doc->expiry_date) ? show_date($doc->expiry_date) : '-'; ?></td>
                                                <td class="text-center">
                                                   <button type="button" onclick="delete_existing_doc(<?php echo $doc->id; ?>)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                                </td>
                                             </tr>
                                          <?php } ?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           <?php } ?>

                           <div class="row">
                              <div class="col-md-12">
                                 <table class="table table-bordered" id="documents_table">
                                    <thead>
                                       <tr class="bg-gray">
                                          <th style="width: 40%;">Documents</th>
                                          <th style="width: 40%;">File (PDF), Max Size 2MB</th>
                                          <th style="width: 15%;">Expiry Date</th>
                                          <th style="width: 5%;" class="text-center">
                                             <button type="button" class="btn btn-primary add_doc_row"><i class="fa fa-plus"></i></button>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr id="doc_row_0">
                                          <td>
                                             <input type="text" name="doc_name[]" class="form-control" placeholder="Document Title / Name">
                                          </td>
                                          <td>
                                             <input type="file" name="doc_file[]" class="form-control" accept=".pdf,.png,.jpg,.jpeg">
                                          </td>
                                          <td>
                                             <input type="text" name="doc_expiry[]" class="form-control datepicker" placeholder="dd-mm-yyyy" readonly>
                                          </td>
                                          <td class="text-center">
                                             <button type="button" class="btn btn-danger remove_doc_row" data-row-id="0"><i class="fa fa-minus"></i></button>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                           <div class="col-sm-8 col-sm-offset-2 text-center">
                              <?php
                                 if(isset($q_id)){
                                    $btn_name="Update";
                                    $btn_id="update";
                                    echo '<input type="hidden" name="q_id" id="q_id" value="'.$q_id.'"/>';
                                 } else {
                                    $btn_name="Save";
                                    $btn_id="save";
                                 }
                              ?>
                              <div class="col-md-3 col-md-offset-3">
                                 <button type="button" id="<?php echo $btn_id;?>" class="btn btn-block btn-success" title="Save Data"><?php echo $btn_name;?></button>
                              </div>
                              <div class="col-sm-3">
                                 <a href="<?=base_url('employees');?>">
                                    <button type="button" class="btn btn-block btn-warning" title="Go to List">Close</button>
                                 </a>
                              </div>
                           </div>
                        </div>
                        <!-- /.box-footer -->
                        <?= form_close(); ?>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <!-- /.content-wrapper -->
         <?php include"footer.php"; ?>
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- SOUND CODE -->
      <?php include"comman/code_js_sound.php"; ?>
      <!-- TABLES CODE -->
      <?php include"comman/code_js.php"; ?>
      <script src="<?php echo $theme_link; ?>js/employees.js"></script>
      <script type="text/javascript">
         $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            todayHighlight: true
         });
         $(".select2").select2();
      </script>
      <script>$(".employees-list-active-li").addClass("active");</script>
   </body>
</html>
