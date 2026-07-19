<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php $this->load->view('comman/code_css.php');?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php $this->load->view('sidebar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Damaged Stock Invoice
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>damaged">Damaged List</a></li>
        <li><a href="<?php echo $base_url; ?>damaged/add">New Damaged Stock</a></li>
        <li class="active">Invoice</li>
      </ol>
    </section>
    <div class="row">
      <div class="col-md-12">
      <!-- ********** ALERT MESSAGE START******* -->
      <?php $this->load->view('comman/code_flashdata');?>
      <!-- ********** ALERT MESSAGE END******* -->
      </div>
    </div>
    <?php
    $CI =& get_instance();
    
    $q3=$this->db->query("SELECT b.store_id,b.damaged_date,b.created_time,b.reference_no,
                           b.damaged_note
                           FROM 
                           db_damaged b 
                           WHERE 
                           b.`id`='$damaged_id' AND b.store_id=".get_current_store_id());
                        
    $res3=$q3->row();
    if($res3->store_id!=get_current_store_id()){
      $CI->show_access_denied_page();exit();
    }
    
    $damaged_date=$res3->damaged_date;
    $created_time=$res3->created_time;
    $reference_no=$res3->reference_no;
    $damaged_note=$res3->damaged_note;

    $q1=$this->db->query("select * from db_store where id=".$res3->store_id." ");
    $res1=$q1->row();
    $store_name=$res1->store_name;
    $company_mobile=$res1->mobile;
    $company_phone=$res1->phone;
    $company_email=$res1->email;
    $company_country=$res1->country;
    $company_state=$res1->state;
    $company_city=$res1->city;
    $company_address=$res1->address;
    $company_gst_no=$res1->gst_no;
    $company_vat_no=$res1->vat_no;
    $company_pan_no=$res1->pan_no;
    ?>

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="printableArea">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> <?= $page_title; ?>
            <small class="pull-right">Date: <?php echo show_date($damaged_date)." ".$created_time; ?></small>
          </h2>
        </div>
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <address>
            <strong><?php echo $store_name; ?></strong><br>
            <?php echo $company_address; ?>,
            <?= $this->lang->line('city'); ?>:<?php echo $company_city; ?><br>
            <?= $this->lang->line('phone'); ?>: <?php echo $company_phone; ?>,
            <?= $this->lang->line('mobile'); ?>: <?php echo $company_mobile; ?><br>
            <?php echo (!empty(trim($company_email))) ? $this->lang->line('email').": ".$company_email."<br>" : '';?>
            <?php echo (!empty(trim($company_gst_no)) && gst_number()) ? $this->lang->line('gst_number').": ".$company_gst_no."<br>" : '';?>
            <?php echo (!empty(trim($company_vat_no)) && vat_number()) ? $this->lang->line('vat_number').": ".$company_vat_no."<br>" : '';?>
            <?php echo (!empty(trim($company_pan_no)) && pan_number()) ? $this->lang->line('pan_number').": ".$company_pan_no."<br>" : '';?>
          </address>
        </div>
        
        <div class="col-sm-4 invoice-col">
          <b>Reference No: <?php echo $reference_no; ?></b><br>
        </div>
      </div>

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table records_table table-bordered">
            <thead class="bg-gray-active">
            <tr>
              <th>#</th>
              <th>Item Name</th>
              <th>Quantity</th>
            </tr>
            </thead>
            <tbody>
              <?php
              $i=0;
              $tot_qty=0;
              
              $q2=$this->db->query("SELECT a.description,c.item_name, a.damaged_qty
                                  FROM 
                                  db_damageditems AS a,db_items AS c 
                                  WHERE 
                                  c.id=a.item_id AND a.damaged_id='$damaged_id'");
              foreach ($q2->result() as $res2) {
                  echo "<tr>";  
                  echo "<td>".++$i."</td>";
                  echo "<td>";
                    echo $res2->item_name;
                    echo (!empty($res2->description)) ? "<br><i>[".nl2br($res2->description)."]</i>" : '';
                  echo "</td>";
                  echo "<td>".format_qty($res2->damaged_qty)."</td>";
                  echo "</tr>";  
                  $tot_qty +=$res2->damaged_qty;
              }
              ?>
            </tbody>
            <tfoot class="text-right text-bold bg-gray">
              <tr>
                <td colspan="2" class="text-center">Total</td>
                <td class="text-left"><?=format_qty($tot_qty);?></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    
      <div class="row">
       <div class="col-md-6">
          <div class="row">
              <div class="col-md-12">
                 <div class="form-group">
                    <label for="damaged_note" class="col-sm-4 control-label" style="font-size: 17px;">Note</label>    
                    <div class="col-sm-8">
                       <label class="control-label" style="font-size: 17px;">: <?=$damaged_note;?></label>
                    </div>
                 </div>
              </div>
           </div> 
        </div>
      </div>

    </div>
      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <?php if($CI->permissions('damaged_edit')) { ?>
          <a href="<?php echo $base_url; ?>damaged/update/<?php echo $damaged_id ?>" class="btn btn-success">
            <i class="fa fa-edit"></i> Edit
          </a>
          <?php } ?>
        </div>
      </div>

    </section>
    <div class="clearfix"></div>
  </div>
  <?php $this->load->view('footer');?>

  <div class="control-sidebar-bg"></div>
</div>

<!-- SOUND CODE -->
<?php $this->load->view('comman/code_js_sound');?>
<!-- TABLES CODE -->
<?php $this->load->view('comman/code_js');?>

<script>$(".damaged_list-active-li").addClass("active");</script>
</body>
</html>
