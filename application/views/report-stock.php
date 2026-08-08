<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css.php"; ?>
<!-- </copy> -->  
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
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <!-- /.content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
                     <!-- Horizontal Form -->
                     <div class="box box-info ">
                        <div class="box-header with-border">
                           <h3 class="box-title">Please Enter Valid Information</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="report-form" onkeypress="return event.keyCode != 13;">
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                           <div class="box-body">
                            <div class="form-group">
                                 <!-- Store Code -->
                                  <?php if(store_module() && is_admin()) {$this->load->view('store/store_code',array('show_store_select_box'=>true,'store_id'=>get_current_store_id(),'div_length'=>'col-sm-3','show_all'=>'true','form_group_remove' => 'true')); }else{
                                     echo "<input type='hidden' name='store_id' id='store_id' value='".get_current_store_id()."'>";
                                     }?>
                                  <!-- Store Code end -->

                                  <!-- Warehouse Code -->
                                  <?php if(true) {$this->load->view('warehouse/warehouse_code',array('show_warehouse_select_box'=>true,'div_length'=>'col-sm-3','show_all'=>'true','form_group_remove' => 'true','show_all_option'=>true)); }else{
                                     echo "<input type='hidden' name='warehouse_id' id='warehouse_id' value='".get_store_warehouse_id()."'>";
                                     }?>
                                  <!-- Warehouse Code end -->

                                </div>

                              <div class="form-group">
                                 <label for="dptid" class="col-sm-2 control-label"><?= $this->lang->line('department'); ?></label>
                                 <div class="col-sm-3">
                                    <select class="form-control select2" id="dptid" name="dptid" style="width: 100%;">
                                       <option value="">-All-</option>
                                       <?= get_departments_select_list(null, get_current_store_id()); ?>
                                    </select>
                                    <span id="dptid_msg" style="display:none" class="text-danger"></span>
                                 </div>

                                 <label for="category_id" class="col-sm-2 control-label"><?= $this->lang->line('category'); ?></label>
                                 <div class="col-sm-3">
                                    <select class="form-control select2" id="category_id" name="category_id" style="width: 100%;">
                                       <option value="">-All-</option>
                                       <?= get_categories_select_list(null, get_current_store_id()); ?>
                                    </select>
                                    <span id="category_id_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>

                              <div class="form-group">
                                 <label for="scatid" class="col-sm-2 control-label"><?= $this->lang->line('subcategory'); ?></label>
                                 <div class="col-sm-3">
                                    <select class="form-control select2" id="scatid" name="scatid" style="width: 100%;">
                                       <option value="">-All-</option>
                                       <?= get_subcategories_select_list(null, get_current_store_id()); ?>
                                    </select>
                                    <span id="scatid_msg" style="display:none" class="text-danger"></span>
                                 </div>

                                 <label for="brand_id" class="col-sm-2 control-label"><?= $this->lang->line('brand'); ?></label>
                                 <div class="col-sm-3">
                                    <select class="form-control select2" id="brand_id" name="brand_id" style="width: 100%;">
                                       <option value="">-All-</option>
                                       <?= get_brands_select_list(null, get_current_store_id()); ?>
                                    </select>
                                    <span id="brand_id_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                           </div>
                           <!-- /.box-body -->
                           <div class="box-footer">
                              <div class="col-sm-8 col-sm-offset-2 text-center">
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="button" id="view" class=" btn btn-block btn-success" title="Save Data">Show</button>
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

                  <div class="col-md-12">
                     <!-- Custom Tabs -->
                     <div class="nav-tabs-custom">
                       
                        <ul class="nav nav-tabs">
                           <li class="active"><a href="#tab_1" data-toggle="tab"><?= $this->lang->line('item_wise'); ?></a></li>
                           <li><a href="#tab_2" data-toggle="tab"><?= $this->lang->line('brand_wise'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                           <div class="tab-pane active" id="tab_1">
                              <!-- Summary Cards -->
                              <div class="row" id="summary-cards" style="display: none; margin-top: 15px; margin-bottom: 5px;">
                                 <!-- Total Stock Card -->
                                 <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="info-box bg-aqua" style="background-color: #28ACE2 !important; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                       <span class="info-box-icon" style="background: rgba(0,0,0,0.1); border-top-left-radius: 6px; border-bottom-left-radius: 6px;"><i class="fa fa-cubes"></i></span>
                                       <div class="info-box-content" style="padding-top: 15px;">
                                          <span class="info-box-text" style="font-weight: 600; text-transform: uppercase; font-size: 11px;">Total Stock</span>
                                          <span class="info-box-number" id="card-total-stock" style="font-size: 22px; font-weight: 700;">0</span>
                                       </div>
                                    </div>
                                 </div>
                                 
                                 <!-- Total Value Card -->
                                 <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="info-box bg-green" style="background-color: #2fc296 !important; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                       <span class="info-box-icon" style="background: rgba(0,0,0,0.1); border-top-left-radius: 6px; border-bottom-left-radius: 6px;"><i class="fa fa-money"></i></span>
                                       <div class="info-box-content" style="padding-top: 15px;">
                                          <span class="info-box-text" style="font-weight: 600; text-transform: uppercase; font-size: 11px;">Stock Value</span>
                                          <span class="info-box-number" id="card-total-value" style="font-size: 22px; font-weight: 700;">0.00</span>
                                       </div>
                                    </div>
                                 </div>

                                 <!-- Active Filters Card -->
                                 <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="info-box bg-purple" style="background-color: #7952b3 !important; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); color: white;">
                                       <span class="info-box-icon" style="background: rgba(0,0,0,0.1); border-top-left-radius: 6px; border-bottom-left-radius: 6px;"><i class="fa fa-filter"></i></span>
                                       <div class="info-box-content" style="padding-top: 8px;">
                                          <span class="info-box-text" style="font-weight: 600; text-transform: uppercase; font-size: 11px; margin-bottom: 2px;">Active Filters</span>
                                          <div style="font-size: 11px; line-height: 1.3;" id="card-filters">
                                             <div><strong>Wh:</strong> <span id="filt-wh">-</span></div>
                                             <div><strong>Dept:</strong> <span id="filt-dept">-</span></div>
                                             <div><strong>Brand:</strong> <span id="filt-brand">-</span></div>
                                             <div><strong>Cat:</strong> <span id="filt-cat">-</span></div>
                                             <div><strong>Subcat:</strong> <span id="filt-subcat">-</span></div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                            
                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                    <!-- form start -->
                                       <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                                          <?php $this->load->view('components/export_btn',array('tableId' => 'report-data'));?>
                                          <br><br>
                                          <div class="table-responsive">
                                          <table class="table table-hover " id="report-data" >
                                            <thead>
                                            <tr class="bg-blue">
                                              <th style="">#</th>
                                              <?php if(store_module() && is_admin()){ ?>
                                              <th style=""><?= $this->lang->line('store_name'); ?></th>
                                              <?php } ?>
                                              <th style=""><?= $this->lang->line('item_code'); ?></th>
                                              <th style=""><?= $this->lang->line('item_name'); ?></th>
                                              <th style=""><?= $this->lang->line('department'); ?></th>
                                              <th style=""><?= $this->lang->line('brand'); ?></th>
                                              <th style=""><?= $this->lang->line('category'); ?></th>
                                              <th style=""><?= $this->lang->line('subcategory'); ?></th>
                                              <th style=""><?= $this->lang->line('unit_price'); ?></th>
                                              <th style=""><?= $this->lang->line('sales_price'); ?></th>
                                              <th style=""><?= $this->lang->line('opening_stock'); ?></th>
                                              <th style=""><?= $this->lang->line('current_stock'); ?></th>
                                              <th style=""><?= $this->lang->line('value'); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbodyid">
                                            
                                          </tbody>
                                          </table>
                                          </div>
                                       <!-- /.box-body -->
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.tab-pane -->
                          
                           <div class="tab-pane" id="tab_2">
                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                    <!-- form start -->
                                       <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                                          <?php $this->load->view('components/export_btn',array('tableId' => 'brand_wise_stock'));?>
                                          <br><br>
                                          <div class="table-responsive">
                                          <table class="table table-hover " id="brand_wise_stock" >
                                              <thead>
                                              <tr class="bg-blue">
                                                <th style="">#</th>
                                                <?php if(store_module() && is_admin()){ ?>
                                                  <th style=""><?= $this->lang->line('store_name'); ?></th>
                                                  <?php } ?>
                                                <th style=""><?= $this->lang->line('brand_name'); ?></th>
                                                
                                                <th style=""><?= $this->lang->line('current_stock'); ?></th>
                                              </tr>
                                              </thead>
                                              <tbody id="">
                                              
                                              </tbody>
                                            </table>
                                          </div>
                                       <!-- /.box-body -->
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.tab-pane -->
                      
                        </div>
                        <!-- /.tab-content -->
                     </div>
                     <!-- nav-tabs-custom -->
                  </div>
                  <!-- /.col -->
     
      
      </div>
    </section>
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
      <!-- TABLE EXPORT CODE -->
      <?php include"comman/code_js_export.php"; ?>

<script src="<?php echo $theme_link; ?>js/sheetjs.js" type="text/javascript"></script>

<script type="text/javascript">
  var base_url=$("#base_url").val();


</script>
<script type="text/javascript">
  function load_reports(){
   var store_id=$("#store_id").val();
   var brand_id=$("#brand_id").val();
   var category_id=$("#category_id").val();
   var warehouse_id=$("#warehouse_id").val();
   var dptid=$("#dptid").val();
   var scatid=$("#scatid").val();
   $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        $.post(base_url+"reports/get_stock_report",{warehouse_id:warehouse_id,store_id:store_id,brand_id:brand_id,category_id:category_id,dptid:dptid,scatid:scatid},function(result){
            result = $.parseJSON(result);

              $.each( result, function( key, val ) {
                if(key=='item_wise_report'){
                    $("#tbodyid").empty().append(val);
                    
                    var totalStock = $("#tbodyid tr:last td:eq(1)").text() || "0";
                    var totalValue = $("#tbodyid tr:last td:eq(2)").text() || "0.00";
                    
                    if ($("#tbodyid tr:first td").hasClass("text-danger")) {
                       totalStock = "0";
                       totalValue = "0.00";
                    }
                    
                    $("#card-total-stock").text(totalStock);
                    $("#card-total-value").text(totalValue);
                    
                    var whVal = $("#warehouse_id").val();
                    var brandVal = $("#brand_id").val();
                    var catVal = $("#category_id").val();
                    var deptVal = $("#dptid").val();
                    var scatVal = $("#scatid").val();
                    
                    $("#filt-wh").text(whVal ? $("#warehouse_id option:selected").text() : "");
                    $("#filt-brand").text(brandVal ? $("#brand_id option:selected").text() : "");
                    $("#filt-cat").text(catVal ? $("#category_id option:selected").text() : "");
                    $("#filt-dept").text(deptVal ? $("#dptid option:selected").text() : "");
                    $("#filt-subcat").text(scatVal ? $("#scatid option:selected").text() : "");
                    
                    $("#summary-cards").fadeIn();
                }
                if(key=='brand_wise_stock'){
                    $("#brand_wise_stock tbody").empty().append(val);     
                }
              });
              $(".overlay").remove();
            });

    }
</script>
<script>
    $("#view").on("click",function(){
      load_reports();
    });
    $("#store_id,#warehouse_id,#dptid,#category_id,#scatid,#brand_id").on("change",function(){
      load_reports();
    });
</script>
<script type="text/javascript">
        var base_url=$("#base_url").val();
        $("#store_id").on("change",function(){
          var store_id=$(this).val();
          $.post(base_url+"sales/get_customers_select_list",{store_id:store_id},function(result){
              result='<option value="">All</option>'+result;
              $("#customer_id").html('').append(result).select2();

          });
          $.post(base_url+"sales/get_warehouse_select_list",{store_id:store_id},function(result){
              result='<option value="">All</option>'+result;
              $("#warehouse_id").html('').append(result).select2();

              load_brands_list();
              load_category_list();
          });
          $.post(base_url+"sales/get_departments_select_list",{store_id:store_id},function(result){
              result='<option value="">All</option>'+result;
              $("#dptid").html('').append(result).select2();
          });
          $.post(base_url+"sales/get_subcategories_select_list",{store_id:store_id},function(result){
              result='<option value="">All</option>'+result;
              $("#scatid").html('').append(result).select2();
          });
        });


    function load_brands_list(){
     var store_id=$("#store_id").val();
     $.post(base_url+"sales/get_brands_select_list",{store_id:store_id},function(result){
          result='<option value="">All</option>'+result;
          $("#brand_id").html('').append(result).select2();
      });
    }

    function load_category_list(){
     var store_id=$("#store_id").val();
     $.post(base_url+"sales/get_categories_select_list",{store_id:store_id},function(result){
          result='<option value="">All</option>'+result;
          $("#category_id").html('').append(result).select2();
      });
    }

      </script>

<script type="text/javascript">
  function downloadPdf(tableId) {
      $('#' + tableId).tableExport({
          type: 'pdf',
          escape: 'false',
          jspdf: {
              orientation: 'l', // Landscape mode for wider table space and better layout
              format: 'a4',
              unit: 'pt',
              margins: { left: 30, right: 30, top: 120, bottom: 40 },
              autotable: {
                  theme: 'striped',
                  styles: {
                      fontSize: 8,
                      cellPadding: 6,
                      overflow: 'linebreak',
                      halign: 'left',
                      valign: 'middle'
                  },
                  headerStyles: {
                      fillColor: [40, 172, 226], // Matches sidebar #28ACE2
                      textColor: [255, 255, 255],
                      fontStyle: 'bold',
                      fontSize: 9
                  },
                  alternateRowStyles: {
                      fillColor: [248, 249, 250]
                  },
                  margin: { left: 30, right: 30, top: 120, bottom: 40 },
                  beforePageContent: function(data) {
                      // Original tableExport fix for row height
                      if ( data.pageCount === 1 ) {
                        var all = data.table.rows.concat(data.table.headerRow);
                        $.each(all, function () {
                          var row = this;
                          if ( row.height > 0 ) {
                            row.height += (2 - 1.15) / 2 * row.styles.fontSize;
                            data.table.height += (2 - 1.15) / 2 * row.styles.fontSize;
                          }
                        });
                      }

                      var doc = data.settings.tableExport.doc;
                      doc.setFont("helvetica");
                      
                      // Active Filters and Values
                      var whVal = $("#warehouse_id").val();
                      var brandVal = $("#brand_id").val();
                      var catVal = $("#category_id").val();
                      
                      var whText = whVal ? $("#warehouse_id option:selected").text() : "";
                      var brandText = brandVal ? $("#brand_id option:selected").text() : "";
                      var catText = catVal ? $("#category_id option:selected").text() : "";
                      
                      // Draw Banner Background
                      doc.setFillColor(40, 172, 226); // Brand Color #28ACE2
                      doc.rect(30, 20, doc.internal.pageSize.width - 60, 80, 'F');
                      
                      // Left Column Text (Company & Report details)
                      doc.setTextColor(255, 255, 255);
                      
                      // Company Name
                      doc.setFontSize(16);
                      doc.setFontStyle('bold');
                      var companyName = "<?= get_store_name(get_current_store_id()); ?>";
                      doc.text(companyName, 45, 48);
                      
                      // Report Name
                      doc.setFontSize(11);
                      doc.setFontStyle('normal');
                      doc.text("Stock Report", 45, 68);
                      
                      // Generated date
                      doc.setFontSize(8);
                      doc.setFontStyle('italic');
                      var today = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                      doc.text("Generated on: " + today, 45, 85);
                      
                      // Right Column Text (Filters info)
                      var rightX = doc.internal.pageSize.width - 320;
                      var lineY = 42;
                      var lineHeight = 16;
                      
                      doc.setFontSize(9);
                      
                      // Warehouse:
                      doc.setFontStyle('bold');
                      doc.text("Warehouse:", rightX, lineY);
                      doc.setFontStyle('normal');
                      doc.text(whText || "-", rightX + 80, lineY);
                      
                      lineY += lineHeight;
                      
                      // Brands:
                      doc.setFontStyle('bold');
                      doc.text("Brands:", rightX, lineY);
                      doc.setFontStyle('normal');
                      doc.text(brandText || "-", rightX + 80, lineY);
                      
                      lineY += lineHeight;
                      
                      // Category:
                      doc.setFontStyle('bold');
                      doc.text("Category:", rightX, lineY);
                      doc.setFontStyle('normal');
                      doc.text(catText || "-", rightX + 80, lineY);
                  },
                  afterPageContent: function(data) {
                      var doc = data.settings.tableExport.doc;
                      doc.setFontSize(8);
                      doc.setTextColor(150, 150, 150);
                      doc.setFontStyle('normal');
                      doc.text("Page " + data.pageCount, doc.internal.pageSize.width - 60, doc.internal.pageSize.height - 20);
                  }
              }
          }
      });
  }
</script>

<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
    
    
</body>
</html>
