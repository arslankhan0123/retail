<!DOCTYPE html>
<html>
   <head>
      <!-- TABLES CSS CODE -->
      <?php include"comman/code_css.php"; ?>
      <style>
         .profile-user-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
         }
         .detail-label {
            font-weight: bold;
            color: #555;
         }
         .detail-value {
            color: #000;
         }
      </style>
   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php include"sidebar.php"; ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?=$page_title;?>
                  <small>Employee Profile Details</small>
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
                  <div class="col-md-12">
                     <div class="box box-info">
                        <div class="box-body">
                           <div class="row">
                              <div class="col-md-3 text-center">
                                 <?php 
                                    $img_src = !empty($employee_image) ? base_url($employee_image) : base_url('theme/images/avatar.png');
                                 ?>
                                 <img class="profile-user-img img-responsive img-circle img-thumbnail" src="<?php echo $img_src; ?>" alt="User profile picture">
                                 <h3 class="profile-username text-center"><?php echo $employee_name; ?></h3>
                                 <p class="text-muted text-center"><?php echo $employee_id; ?></p>
                                 <span class="label <?php echo ($status == 1) ? 'label-success' : 'label-danger'; ?>">
                                    <?php echo ($status == 1) ? 'Active' : 'Inactive'; ?>
                                 </span>
                              </div>
                              <div class="col-md-9">
                                 <h4 class="box-title text-primary">Basic Information</h4>
                                 <hr style="margin-top: 5px; margin-bottom: 15px;">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <table class="table table-striped table-bordered">
                                          <tr>
                                             <td class="detail-label" style="width: 40%;">Employee ID</td>
                                             <td class="detail-value"><?php echo $employee_id; ?></td>
                                          </tr>
                                          <tr>
                                             <td class="detail-label">Employee Name</td>
                                             <td class="detail-value"><?php echo $employee_name; ?></td>
                                          </tr>
                                          <tr>
                                             <td class="detail-label">Phone</td>
                                             <td class="detail-value"><?php echo !empty($phone) ? $phone : '-'; ?></td>
                                          </tr>
                                          <tr>
                                             <td class="detail-label">Email</td>
                                             <td class="detail-value"><?php echo !empty($email) ? $email : '-'; ?></td>
                                          </tr>
                                          <tr>
                                             <td class="detail-label">Joining Date</td>
                                             <td class="detail-value"><?php echo $joining_date; ?></td>
                                          </tr>
                                          <tr>
                                             <td class="detail-label">DOB</td>
                                             <td class="detail-value"><?php echo !empty($dob) ? $dob : '-'; ?></td>
                                          </tr>
                                       </table>
                                    </div>
                                    <div class="col-md-6">
                                       <table class="table table-striped table-bordered">
                                          <tr>
                                             <td class="detail-label" style="width: 40%;">Marital Status</td>
                                             <td class="detail-value"><?php echo !empty($marital_status) ? $marital_status : '-'; ?></td>
                                          </tr>
                                          <tr>
                                             <td class="detail-label">Blood Group</td>
                                             <td class="detail-value"><?php echo !empty($blood_group) ? $blood_group : '-'; ?></td>
                                          </tr>
                                          <tr>
                                             <td class="detail-label">Gender</td>
                                             <td class="detail-value"><?php echo !empty($gender) ? $gender : '-'; ?></td>
                                          </tr>
                                          <tr>
                                             <td class="detail-label">Country</td>
                                             <td class="detail-value"><?php echo !empty($country) ? $country : '-'; ?></td>
                                          </tr>
                                          <tr>
                                             <td class="detail-label">Basic Salary</td>
                                             <td class="detail-value"><?php echo store_number_format($basic_salary); ?></td>
                                          </tr>
                                          <tr>
                                             <td class="detail-label">Gross Salary</td>
                                             <td class="detail-value"><?php echo store_number_format($gross_salary); ?></td>
                                          </tr>
                                       </table>
                                    </div>
                                 </div>

                                 <br>
                                 <h4 class="box-title text-primary">Identification Information</h4>
                                 <hr style="margin-top: 5px; margin-bottom: 15px;">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="well well-sm">
                                          <strong>Iqama Number:</strong>
                                          <p><?php echo $iqama_no; ?></p>
                                          <strong>Expiry Date:</strong>
                                          <p><?php echo !empty($iqama_expiry) ? $iqama_expiry : '-'; ?></p>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="well well-sm">
                                          <strong>Passport Number:</strong>
                                          <p><?php echo !empty($passport_no) ? $passport_no : '-'; ?></p>
                                          <strong>Expiry Date:</strong>
                                          <p><?php echo !empty($passport_expiry) ? $passport_expiry : '-'; ?></p>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="well well-sm">
                                          <strong>Driving License Number:</strong>
                                          <p><?php echo !empty($driving_license_no) ? $driving_license_no : '-'; ?></p>
                                          <strong>Expiry Date:</strong>
                                          <p><?php echo !empty($driving_license_expiry) ? $driving_license_expiry : '-'; ?></p>
                                       </div>
                                    </div>
                                 </div>

                                 <br>
                                 <h4 class="box-title text-primary">Attached Documents</h4>
                                 <hr style="margin-top: 5px; margin-bottom: 15px;">
                                 <?php if (!empty($documents)) { ?>
                                    <table class="table table-bordered table-striped">
                                       <thead>
                                          <tr class="bg-gray">
                                             <th>Document Title</th>
                                             <th>Expiry Date</th>
                                             <th>Download File</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php foreach ($documents as $doc) { ?>
                                             <tr>
                                                <td><?php echo $doc->document_name; ?></td>
                                                <td><?php echo !empty($doc->expiry_date) ? show_date($doc->expiry_date) : '-'; ?></td>
                                                <td>
                                                   <a href="<?php echo base_url($doc->file_path); ?>" target="_blank" class="btn btn-xs btn-primary">
                                                      <i class="fa fa-download"></i> View File
                                                   </a>
                                                </td>
                                             </tr>
                                          <?php } ?>
                                       </tbody>
                                    </table>
                                 <?php } else { ?>
                                    <p class="text-muted">No documents uploaded for this employee.</p>
                                 <?php } ?>

                              </div>
                           </div>
                        </div>
                        <div class="box-footer text-center">
                           <a href="<?php echo base_url('employees'); ?>" class="btn btn-warning">Close / Go Back</a>
                           <?php if($CI->permissions('employees_edit')) { ?>
                              <a href="<?php echo base_url('employees/update/' . $q_id); ?>" class="btn btn-info">Edit Employee Profile</a>
                           <?php } ?>
                        </div>
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
      <script>$(".employees-list-active-li").addClass("active");</script>
   </body>
</html>
