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
      <?php
      if(!isset($category_name)){
        $category_code=$category_name=$scatName=$scatDetails=$description=$store_id="";
        }
      ?>
         <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
            <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1><?=$page_title;?><small>Add/Update Sub Category</small></h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $base_url; ?>Subcategory/view">Sub Category List</a></li>
            <li class="active"><?=$page_title;?></li>
          </ol>
        </section>
            <!-- Main content -->
        <section class="content">
          <div class="row">
                  <!-- right column -->
            <div class="col-md-12">
                     <!-- Horizontal Form -->
              <div class="box box-primary ">
                <div class="box-header with-border">
                  <h3 class="box-title">Please Enter Valid Data</h3>
                </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                <form class="form-horizontal" id="category-form" onkeypress="return event.keyCode != 13;">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                  <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                  <div class="box-body">
                              <!-- Store Code -->
                    <?php /*if(store_module() && is_admin()) {$this->load->view('store/store_code',array('show_store_select_box'=>true,'store_id'=>$store_id)); }else{*/
                    echo "<input type='hidden' name='store_id' id='store_id' value='".get_current_store_id()."'>";
                      /*}*/ ?>
                              <!-- Store Code end -->
                    <?php $dept = $this->db->select("*")->FROM('db_category')->get()->result(); ?>
                    <div class="form-group">
                      <label for="department" class="col-sm-2 control-label">Category<label class="text-danger">*</label></label>
                      <div class="col-sm-4">
                        <select class="form-control" name="dptid" id="dptid" required >
                          <option value="">Select One</option>
                          <?php foreach($dept as $value){ ?>
                          <option <?php echo ($dptid??'' == $value->id)?'selected':''?> value="<?php echo $value->id; ?>"><?php echo $value->category_name; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="catid" class="col-sm-2 control-label">Sub Category<label class="text-danger">*</label></label>
                      <div class="col-sm-4">
                        <select class="form-control" name="catid" id="catid" required >
                          <option value="">Select One</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="scatName" class="col-sm-2 control-label">Name<label class="text-danger">*</label></label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control input-sm" id="scatName" name="scatName" placeholder="" onkeyup="shift_cursor(event,'description')" value="<?php print $scatName??''; ?>" autofocus >
                        <span id="category_msg" style="display:none" class="text-danger"></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="description" class="col-sm-2 control-label"><?= $this->lang->line('description'); ?></label>
                      <div class="col-sm-4">
                        <textarea type="text" class="form-control" id="scatDetails" name="scatDetails" placeholder=""><?php print $scatDetails??''; ?></textarea>
                        <span id="description_msg" style="display:none" class="text-danger"></span>
                      </div>
                    </div>
                  </div>
                           <!-- /.box-footer -->
                    <div class="box-footer">
                      <div class="col-sm-8 col-sm-offset-2 text-center">
                                 <!-- <div class="col-sm-4"></div> -->
                        <?php
                        if(isset($q_id)){
                          $btn_name="Update";
                          $btn_id="update";
                        ?>
                        <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id;?>"/>
                        <?php
                          }
                        else{
                          $btn_name="Save";
                          $btn_id="save";
                        } ?>
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
  <script src="<?php echo $theme_link; ?>js/subcategory1.js"></script>
  <script type="text/javascript">
    <?php if(isset($q_id)){ ?>
      $("#store_id").attr('readonly',true);
    <?php }?>
  </script>
      <!-- Make sidebar menu hughlighter/selector -->
  <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>

      <script type="text/javascript" >
        $(document).ready(function(){
          $('#dptid').change(function(){
            var url = "<?php echo base_url(); ?>Subcategory1/get_category_data";
            var id = $('#dptid').val();
            //alert(id);alert(id2);
            $.ajax({
              method: "POST",
              url     : url,
              dataType: 'json',
              data    : {'id':id},
              success:function(data){ 
              //alert(data);
              var HTML = 'Select One';
              for (var key in data) 
                {
                HTML +='<option value="'+data[key]['id']+'">'+data[key]['category_name']+'</option>';
                  }
              $("#catid").html(HTML);
                },
              error:function(data){
              alert('error');
              }
            });
          });
        });
      </script>
  </body>
</html>
