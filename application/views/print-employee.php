<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $page_title; ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo $theme_link; ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $theme_link; ?>dist/css/AdminLTE.min.css">

  <style type="text/css">
    body {
      background-color: #fff;
      font-size: 13px;
      color: #000;
      font-family: 'sans-serif', 'Arial';
    }
    .print-container {
      padding: 15px;
      max-width: 900px;
      margin: 0 auto;
    }
    .profile-img {
      width: 140px;
      height: 140px;
      object-fit: cover;
      border: 1px solid #ddd;
      margin-bottom: 10px;
    }
    .table-details {
      margin-bottom: 20px;
    }
    .table-details th {
      background-color: #f5f5f5 !important;
      font-weight: bold;
      width: 35%;
      border: 1px solid #ddd !important;
      padding: 6px 10px !important;
    }
    .table-details td {
      border: 1px solid #ddd !important;
      padding: 6px 10px !important;
    }
    .header-logo {
      max-height: 85px;
      width: auto;
    }
    .header-section {
      margin-bottom: 10px;
      padding-bottom: 10px;
    }
    .divider {
      border-bottom: 2px solid #000;
      margin-top: 5px;
      margin-bottom: 15px;
    }
    .title-banner {
      border: 1px solid #000;
      padding: 8px;
      text-align: center;
      background-color: #fcfcfc;
      margin-bottom: 20px;
    }
    .title-banner h3 {
      margin: 0;
      font-weight: bold;
      font-size: 18px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .section-title {
      font-size: 15px;
      font-weight: bold;
      color: #000;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px;
      margin-top: 25px;
      margin-bottom: 12px;
      text-transform: uppercase;
    }
    @media print {
      .no-print {
        display: none;
      }
      body {
        margin: 0;
        padding: 0;
      }
      .print-container {
        padding: 0;
        max-width: 100%;
      }
    }
  </style>
</head>
<body onload="window.print();">
<div class="print-container">
  
  <?php
    $store_rec = get_store_details();
    $store_logo = (!empty($store_rec->store_logo)) ? $store_rec->store_logo : store_demo_logo();
  ?>

  <!-- Header Section -->
  <div class="row header-section">
    <div class="col-xs-3">
      <img src="<?php echo base_url($store_logo); ?>" class="header-logo" alt="Logo">
    </div>
    <div class="col-xs-6 text-center">
      <h3 style="margin: 0 0 5px 0; font-weight: bold; text-transform: uppercase; font-size: 20px;"><?php echo $store_rec->store_name; ?></h3>
      <p style="margin: 0; font-size: 13px;">
        <strong>Email:</strong> <?php echo !empty($store_rec->email) ? $store_rec->email : ''; ?><br>
        <?php echo !empty($store_rec->address) ? $store_rec->address : ''; ?><br>
        <strong>Mob:</strong> <?php echo !empty($store_rec->mobile) ? $store_rec->mobile : ''; ?><?php echo !empty($store_rec->phone) ? ', ' . $store_rec->phone : ''; ?>
      </p>
    </div>
    <div class="col-xs-3 text-right no-print">
      <button class="btn btn-default btn-sm" onclick="window.print();"><i class="fa fa-print"></i> Print / Save PDF</button>
    </div>
  </div>

  <div class="divider"></div>

  <!-- Title Banner -->
  <div class="title-banner">
    <h3>Employee Profile Card</h3>
  </div>

  <!-- Profile & Basic Info -->
  <div class="row">
    <div class="col-xs-3 text-center">
      <?php 
        $img_src = !empty($employee_image) ? base_url($employee_image) : base_url('theme/images/avatar.png');
      ?>
      <img src="<?php echo $img_src; ?>" class="img-thumbnail profile-img" alt="Employee Photo">
      <h4 style="margin: 5px 0; font-weight: bold;"><?php echo $employee_name; ?></h4>
      <span class="text-muted"><strong>ID:</strong> <?php echo $employee_id; ?></span><br>
      <span class="label <?php echo ($status == 1) ? 'label-success' : 'label-danger'; ?>" style="font-size: 11px; display: inline-block; margin-top: 5px;">
        <?php echo ($status == 1) ? 'Active' : 'Inactive'; ?>
      </span>
    </div>
    
    <div class="col-xs-9">
      <div class="section-title" style="margin-top: 0;">Employee Details</div>
      <table class="table table-bordered table-details">
        <tr>
          <th>Employee ID</th>
          <td><?php echo $employee_id; ?></td>
        </tr>
        <tr>
          <th>Employee Name</th>
          <td><?php echo $employee_name; ?></td>
        </tr>
        <tr>
          <th>Phone / Mobile</th>
          <td><?php echo !empty($phone) ? $phone : '-'; ?></td>
        </tr>
        <tr>
          <th>Email Address</th>
          <td><?php echo !empty($email) ? $email : '-'; ?></td>
        </tr>
        <tr>
          <th>Joining Date</th>
          <td><?php echo $joining_date; ?></td>
        </tr>
        <tr>
          <th>Date of Birth</th>
          <td><?php echo !empty($dob) ? $dob : '-'; ?></td>
        </tr>
        <tr>
          <th>Gender</th>
          <td><?php echo !empty($gender) ? $gender : '-'; ?></td>
        </tr>
        <tr>
          <th>Marital Status</th>
          <td><?php echo !empty($marital_status) ? $marital_status : '-'; ?></td>
        </tr>
        <tr>
          <th>Blood Group</th>
          <td><?php echo !empty($blood_group) ? $blood_group : '-'; ?></td>
        </tr>
        <tr>
          <th>Country</th>
          <td><?php echo !empty($country) ? $country : '-'; ?></td>
        </tr>
        <tr>
          <th>Basic Salary</th>
          <td><?php echo store_number_format($basic_salary); ?></td>
        </tr>
        <tr>
          <th>Gross Salary</th>
          <td><?php echo store_number_format($gross_salary); ?></td>
        </tr>
      </table>
    </div>
  </div>

  <!-- Identification Information -->
  <div class="row">
    <div class="col-xs-12">
      <div class="section-title">Identification Documents</div>
      <table class="table table-bordered table-striped" style="border: 1px solid #ddd;">
        <thead>
          <tr style="background-color: #f5f5f5;">
            <th style="width: 33%; border: 1px solid #ddd; padding: 8px;">Document Type</th>
            <th style="width: 33%; border: 1px solid #ddd; padding: 8px;">Document Number</th>
            <th style="width: 34%; border: 1px solid #ddd; padding: 8px;">Expiry Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="border: 1px solid #ddd; padding: 8px;"><strong>Iqama</strong></td>
            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $iqama_no; ?></td>
            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo !empty($iqama_expiry) ? $iqama_expiry : '-'; ?></td>
          </tr>
          <tr>
            <td style="border: 1px solid #ddd; padding: 8px;"><strong>Passport</strong></td>
            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo !empty($passport_no) ? $passport_no : '-'; ?></td>
            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo !empty($passport_expiry) ? $passport_expiry : '-'; ?></td>
          </tr>
          <tr>
            <td style="border: 1px solid #ddd; padding: 8px;"><strong>Driving License</strong></td>
            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo !empty($driving_license_no) ? $driving_license_no : '-'; ?></td>
            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo !empty($driving_license_expiry) ? $driving_license_expiry : '-'; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Uploaded Files -->
  <div class="row">
    <div class="col-xs-12">
      <div class="section-title">Employee Documents</div>
      <?php if (!empty($documents)) { ?>
        <table class="table table-bordered table-striped" style="border: 1px solid #ddd;">
          <thead>
            <tr style="background-color: #f5f5f5;">
              <th style="border: 1px solid #ddd; padding: 8px;">Document Title</th>
              <th style="border: 1px solid #ddd; padding: 8px;">Expiry Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($documents as $doc) { ?>
              <tr>
                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $doc->document_name; ?></td>
                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo !empty($doc->expiry_date) ? show_date($doc->expiry_date) : '-'; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } else { ?>
        <p class="text-muted">No documents uploaded.</p>
      <?php } ?>
    </div>
  </div>

</div>
</body>
</html>
