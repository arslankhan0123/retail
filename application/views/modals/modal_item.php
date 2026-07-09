<?php $CI =& get_instance(); ?>
<div class="modal fade " id="item-modal" tabindex='-1'>
                <?= form_open('#', array('class' => '', 'id' => 'item-form','enctype'=>'multipart/form-data', 'method'=>'POST')); ?>
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header header-custom">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title text-center"><?= $this->lang->line('new_item'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_item_name"><?= $this->lang->line('item_name'); ?><span class="text-danger">*</span></label>
                                <span id="m_item_name_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control" id="m_item_name" name="m_item_name" placeholder="" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_brand"><?= $this->lang->line('brand'); ?></label>
                                <span id="m_brand_msg" class="text-danger text-right pull-right"></span>
                                <select class="form-control " id="m_brand_id" name="m_brand_id"  style="width: 100%;"  >
                                   <option value="">-Select-</option>
                                    <?= get_brands_select_list();  ?>
                                 </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_category_id"><?= $this->lang->line('category'); ?><span class="text-danger">*</span></label>
                                <span id="m_category_id_msg" class="text-danger text-right pull-right"></span>
                                <select class="form-control " id="m_category_id" name="m_category_id"  style="width: 100%;">
                                   <option value="">-Select-</option>
                                    <?= get_categories_select_list();  ?>
                                 </select>
                              </div>
                            </div>
                          </div>
                          
                          <?php $dept = $this->db->select("*")->FROM('db_department')->get()->result(); ?>
                          <div class="form-group col-md-4">
                            <label for="department" >Department<label class="text-danger">*</label></label>
                            <div class="">
                                <select class="form-control select2" name="dptid" id="dptid" required >
                                  <option value="">Select One</option>
                                  <?php foreach($dept as $value){ ?>
                                  <option <?php echo (($dptid??'') == $value->dptid)?'selected':''?> value="<?php echo $value->dptid; ?>"><?php echo $value->dptName; ?></option>
                                  <?php } ?>
                                </select>
                            </div>
                          </div>
                          <input type="hidden" name="scatid" value="0">
                          
                              
                              <?php $icolors = $this->db->select("*")->FROM('bd_clcategory')->get()->result(); ?>
                              <div class="form-group col-md-4">
                                <label for="subcategory" >Select Colors</label>
                                <div class="">
                                    <select class="form-control" name="clid" id="clid"  >
                                      <option value="">Select One</option>
                                      <?php foreach($icolors as $value){ ?>
                                      <option <?php echo (($clid??'') == $value->clid)?'selected':''?> value="<?php echo $value->clid; ?>"><?php echo $value->clName; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                              </div>
                              <?php $isizes = $this->db->select("*")->FROM('bd_szcategory')->get()->result(); ?>
                              <div class="form-group col-md-4">
                                <label for="subcategory" >Select Size</label>
                                <div class="">
                                    <select class="form-control" name="szid" id="szid"  >
                                      <option value="">Select One</option>
                                      <?php foreach($isizes as $value){ ?>
                                      <option <?php echo (($szid??'') == $value->isid)?'selected':''?> value="<?php echo $value->isid; ?>"><?php echo $value->isName; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                              </div>
                              <?php $iraks = $this->db->select("*")->FROM('db_rack')->get()->result(); ?>
                              <div class="form-group col-md-4">
                                <label for="subcategory" >Select Rack</label>
                                <div class="">
                                    <select class="form-control" name="rkid" id="rkid"  >
                                      <option value="">Select One</option>
                                      <?php foreach($iraks as $value){ ?>
                                      <option <?php echo (($rkid??'') == $value->rkid)?'selected':''?> value="<?php echo $value->rkid; ?>"><?php echo $value->rkName; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                              </div>
                              <?php $ibin = $this->db->select("*")->FROM('bd_bncategory')->get()->result(); ?>
                              <div class="form-group col-md-4">
                                <label for="subcategory" >Select Bin</label>
                                <div class="">
                                    <select class="form-control" name="bnid" id="bnid"  >
                                      <option value="">Select One</option>
                                      <?php foreach($ibin as $value){ ?>
                                      <option <?php echo (($bnid??'') == $value->bnid)?'selected':''?> value="<?php echo $value->bnid; ?>"><?php echo $value->bnName; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                              </div>
                              <?php $isbin = $this->db->select("*")->FROM('bd_sbcategory')->where('bnid',$bnid??'')->get()->result(); ?>
                              <div class="form-group col-md-4">
                                <label for="subcategory" >Select Sub Bin</label>
                                <div class="">
                                    <select class="form-control" name="bsid" id="bsid"  >
                                      <option value="">Select Bin</option>
                                      <?php foreach($isbin as $value){ ?>
                                      <option <?php echo ($bsid == $value->bsid)?'selected':''?> value="<?php echo $value->bsid; ?>"><?php echo $value->bsName; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                              </div>
                          
                          
                          
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_unit_id"><?= $this->lang->line('unit'); ?><span class="text-danger">*</span></label>
                                <span id="m_unit_id_msg" class="text-danger text-right pull-right"></span>
                                <select class="form-control " id="m_unit_id" name="m_unit_id"  style="width: 100%;">
                                    
                                    <?= get_units_select_list();  ?>
                                 </select>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_hsn"><?= $this->lang->line('hsn'); ?></label>
                                <span id="m_hsn_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control maxlength " id="m_hsn" name="m_hsn" placeholder=""  >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_sku"><?= $this->lang->line('sku'); ?></label>
                                <span id="m_sku_msg" class="text-danger text-right pull-right"></span>
                                <input type="text"  class="form-control maxlength " id="m_sku" name="m_sku" placeholder=""  >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_alert_qty"><?= $this->lang->line('alert_qty'); ?></label>
                                <span id="m_alert_qty_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" maxlength="10" class="form-control maxlength no_special_char_no_space " id="m_alert_qty" name="m_alert_qty" placeholder=""  >
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="maximum_qty">Maximum Qty</label>
                                <span id="maximum_qty" class="text-danger text-right pull-right"></span>
                                <input type="text" maxlength="10" class="form-control maxlength no_special_char_no_space " id="maximum_qty" name="maximum_qty" placeholder=""  >
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_alert_qty">Minimum Qty</label>
                                <span id="m_alert_qty_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" maxlength="10" class="form-control maxlength no_special_char_no_space " id="minimum_qty" name="minimum_qty" placeholder=""  >
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="reorder_qty">Reorder Qty</label>
                                <span id="reorder_qty" class="text-danger text-right pull-right"></span>
                                <input type="text" maxlength="10" class="form-control maxlength no_special_char_no_space " id="reorder_qty" name="reorder_qty" placeholder=""  >
                              </div>
                            </div>
                          </div>
                        
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_seller_points"><?= $this->lang->line('seller_points'); ?></label>
                                <span id="m_seller_points_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" maxlength="10" class="form-control maxlength  " id="m_seller_points" name="m_seller_points" placeholder=""  >
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_custom_barcode"><?= $this->lang->line('barcode'); ?><span class="text-danger">*</span></label>
                                <span id="m_custom_barcode_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control maxlength  " id="m_custom_barcode" name="m_custom_barcode" placeholder="" required >
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4 hide">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_item_group"><?= $this->lang->line('item_group'); ?><span class="text-danger">*</span></label>
                                <span id="m_item_group_msg" class="text-danger text-right pull-right"></span>
                                <select class="form-control " id="m_item_group" name="m_item_group"  style="width: 100%;">
                                    <option  value="Single">Single</option>
                                    <option  value="Variants">Variants</option>
                                 </select>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_description"><?= $this->lang->line('description'); ?></label>
                                <span id="m_description_msg" class="text-danger text-right pull-right"></span>
                                <textarea class="form-control" id="m_description" name="m_description" placeholder="" ></textarea>
                              </div>
                            </div>
                          </div>
                          
                        </div>
                        <hr>
                        <div class="row">                          
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_discount_type"><?= $this->lang->line('discount_type'); ?></label>
                                <span id="m_discount_type_msg" class="text-danger text-right pull-right"></span>
                                <select class="form-control " id="m_discount_type" name="m_discount_type"  style="width: 100%;">
                                   <option value='Percentage'>Percentage(%)</option>
                                 <option value='Fixed'>Fixed(<?= $CI->currency() ?>)</option>
                                 </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_discount"><?= $this->lang->line('discount'); ?></label>
                                <span id="m_discount_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control maxlength no_special_char_no_space " id="m_discount" name="m_discount" placeholder=""  >
                              </div>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">                          

                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_price"><?= $this->lang->line('price'); ?><span class="text-danger">*</span></label>
                                <span id="m_price_msg" style="display:none" class="text-danger"></span>
                                <input type="text" class="form-control only_currency" id="m_price" name="m_price" placeholder="Price of Item without Tax">
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_tax_id"><?= $this->lang->line('tax'); ?><span class="text-danger">*</span></label>
                                <span id="m_tax_id_msg" class="text-danger text-right pull-right"></span>
                                <select class="form-control " id="m_tax_id" name="m_tax_id"  style="width: 100%;">
                                    <?= get_tax_select_list();  ?>
                                 </select>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_purchase_price"><?= $this->lang->line('purchase_price'); ?><span class="text-danger">*</span></label>
                                <span id="m_purchase_price_msg" style="display:none" class="text-danger"></span>
                                <input type="text" readonly="" class="form-control only_currency" id="m_purchase_price" name="m_purchase_price">
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_tax_type"><?= $this->lang->line('tax_type'); ?><span class="text-danger">*</span></label>
                                <span id="m_tax_type_msg" class="text-danger text-right pull-right"></span>
                                <select class="form-control " id="m_tax_type" name="m_tax_type"  style="width: 100%;">
                                   <option value="Inclusive">Inclusive</option>
                                    <option value="Exclusive">Exclusive</option>
                                 </select>
                              </div>
                            </div>
                          </div>


                          

                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_profit_margin"><?= $this->lang->line('profit_margin'); ?>(%)<i class="hover-q " data-container="body" data-toggle="popover" data-placement="top" data-content="<?= $this->lang->line('based_on_purchase_price'); ?>" data-html="true" data-trigger="hover" data-original-title="">
                                  <i class="fa fa-info-circle text-maroon text-black hover-q"></i>
                                </i></label>
                                <span id="m_profit_margin_msg" class="text-danger text-right pull-right"></span>
                                <input type="email" class="form-control only_currency" id="m_profit_margin" name="m_profit_margin" placeholder=""  >
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_sales_price"><?= $this->lang->line('sales_price'); ?><span class="text-danger">*</span></label>
                                <span id="m_sales_price_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" maxlength="10" class="form-control maxlength only_currency " id="m_sales_price" name="m_sales_price" placeholder=""  >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_mrp"><?= $this->lang->line('mrp'); ?><i class="hover-q " data-container="body" data-toggle="popover" data-placement="top" data-content="<?= $this->lang->line('mrp_definition'); ?>" data-html="true" data-trigger="hover" data-original-title="">
                                  <i class="fa fa-info-circle text-maroon text-black hover-q"></i>
                                </i></label>
                                <span id="m_mrp_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" maxlength="10" class="form-control maxlength only_currency " id="m_mrp" name="m_mrp" placeholder="Maximum Retail Price"  >
                              </div>
                            </div>
                          </div>

                        
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="item_image"><?= $this->lang->line('select_image'); ?></label>
                                <span id="item_image_msg" style="display:block;" class="text-danger">Max (1000px*1000px),1MB </span>
                                <input type="file" name="item_image" id="item_image">
                              </div>
                            </div>
                          </div>
                          

                        </div>

                        <hr>
                        <div class="row">                          
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="m_warehouse_id"><?= $this->lang->line('warehouse'); ?></label>
                                <span id="warehouse_id_msg" class="text-danger text-right pull-right"></span>
                                <select class="form-control " id="m_warehouse_id" name="m_warehouse_id"  style="width: 100%;">
                                   <?= get_warehouse_select_list();?>
                                 </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="adjustment_qty"><?= $this->lang->line('opening_stock'); ?></label>
                                <span id="adjustment_qty_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control maxlength only_currency " id="adjustment_qty" name="adjustment_qty" placeholder="" value='0'  >
                              </div>
                            </div>
                          </div>
                        </div>

                       
                    </div>
                    <div class="modal-footer">
                      
                      <input type="hidden" name="existing_row_count" value="0">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary add_item">Save</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
               <?= form_close();?>
              </div>
              <!-- /.modal -->