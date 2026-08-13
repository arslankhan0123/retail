<div class="modal fade" id="multiple-payments-modal" tabindex='-1'>
  <input type="hidden" id="direct_payment_type" name="direct_payment_type" value="">
  
  <div class="modal-dialog modal-lg payment-modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-custom">
        <span class="payment-mode-icon" aria-hidden="true">
          <i id="payment_mode_icon" class="fa fa-credit-card"></i>
        </span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 1; font-size: 30px; line-height: 20px;">
          <span aria-hidden="true">&times;</span></button>
        <h4 id="payment_modal_title" class="modal-title text-center" style="font-size: 20px; font-weight: 700;">Payment Processing</h4>
      </div>
      <div class="modal-body">
        
    <div class="row">
      <!-- LEFT HAND -->
      <div class="col-md-8 payment-entry-column">
      <?php 
      if(isset($sales_id) && !empty($sales_id)){
        $sales_rec = get_sales_details($sales_id);
        $coupon_id=$sales_rec->coupon_id;
        $coupon_amt=$sales_rec->coupon_amt;
        $coupon_code = (!empty($coupon_id)) ? get_customer_coupon_details($coupon_id)->code : '';
      }
      else{
        $coupon_code='';
        $coupon_amt=0;
      }

      ?>
        <div class="box box-solid bg-default hide">
          
            <div class="box-body">
              <div class="row">
                 <?php /* ADVANCE SECTION - COMMENTED OUT
                 <div class="col-md-4">
                  <span for="">
                    <label>
                    <?= $this->lang->line('advance'); ?> : <label class="customer_tot_advance">0.00</label>
                  </label>
                  </span>
                  <div class="checkbox">
                    <label id="click_to_uncheck">
                      <input type="checkbox" id="allow_tot_advance" name="allow_tot_advance"> <?= $this->lang->line('adjust_advance_payment'); ?>
                    </label>
                  </div>
                 </div>
                 */ ?>

                 <div class="col-md-8">
                  <span for="">
                    <label>
                    <?= $this->lang->line('discountCouponCode'); ?>
                  </label>
                  </span>
                  <input type="text" class="form-control" id="coupon_code" name="coupon_code" value="<?=$coupon_code?>">
                  <label class="control-label pull-left"><?= $this->lang->line('couponType'); ?>:<span class="coupon_type">---</span></label>
                  <label class="control-label pull-right"><?= $this->lang->line('couponValue'); ?>:<span class="coupon_value">0.00</span></label>
                 </div>

                 <div class="col-md-8 col-md-offset-4 div1 hide">
                   <div class="alert text-left msg_color">
                    <strong id="coupon_code_msg">
                    </strong>
                  </div>
                </div>


              </div>
            </div>
            </div>


        <div>

        <?php 
          $atleast_one_payments = 'true';
          if(isset($sales_id) && $sales_id!='') { //For Save Operation or for new entry

          $q22=$this->db->query("select * from db_salespayments where sales_id='$sales_id'");
       if($q22->num_rows()>0){
        $atleast_one_payments = 'false';
        $i=0;
        foreach ($q22->result() as $res22) {
          $i++;
      ?>    
            <div class="col-md-12  payments_div">
            <div class="box box-solid bg-blue">
              <div class="box-body">
                <div class="row">
           
                  <div class="col-md-6">
                    <div class="">
                    <label for="amount_<?= $i;?>"><?= $this->lang->line('amount'); ?></label>
                      <input type="text" class="form-control text-right payment only_currency" value='<?= store_number_format($res22->payment,0)?>' id="amount_<?= $i;?>" name="amount_<?= $i;?>" placeholder="" onkeyup="calculate_payments()">
                        <span id="amount_<?= $i;?>_msg" style="display:none" class="text-danger"></span>
                  </div>
                 </div>
                  <div class="col-md-6">
                    <div class="">
                      <label for="payment_type_<?= $i;?>"><?= $this->lang->line('payment_type'); ?></label>
                      <select class="form-control" id='payment_type_<?= $i;?>' name="payment_type_<?= $i;?>">
                        <?php
                          $q1=$this->db->query("select * from db_paymenttypes where status=1 and store_id=".get_current_store_id());
                           if($q1->num_rows()>0){
                               foreach($q1->result() as $res1){
                                $selected=($res22->payment_type==$res1->payment_type) ? 'selected' : '';
                               echo "<option $selected value='".$res1->payment_type."'>".$res1->payment_type ."</option>";
                             }
                           }
                           else{
                              echo "No Records Found";
                           }
                          ?>
                      </select>
                      <span id="payment_type_<?= $i;?>_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>
              <div class="clearfix"></div>
          </div>  

          <div class="row">
                  <input type="hidden" id="account_id_<?= $i;?>" name="account_id_<?= $i;?>" value="1">
                  <?php if($i==1){ ?>
                  <div class="col-md-6">
                    <div class="">
                      <label for="payment_discount_input">Discount Amount</label>
                      <input type="text" class="form-control text-right only_currency payment_discount_input" id="payment_discount_input" value="0.00" autocomplete="off">
                      <span class="payment_discount_input_msg text-danger" style="display:none"></span>
                    </div>
                  </div>
                  <?php } ?>
              <div class="clearfix"></div>
          </div>  

          <div class="row hide">
                 <div class="col-md-12">
                    <div class="">
                      <label for="payment_note_<?= $i;?>"><?= $this->lang->line('payment_note'); ?></label>
                      <textarea type="text" class="form-control" id="payment_note_<?= $i;?>" name="payment_note_<?= $i;?>" placeholder="" ><?= $res22->payment_note;?></textarea>
                      <span id="payment_note_<?= $i;?>_msg" style="display:none" class="text-danger"></span>
                    </div>
                 </div>
                  
              <div class="clearfix"></div>
          </div>   
          </div>
          </div>
        </div><!-- col-md-12 -->
        <?php } //foreach() ?>
        <input type="hidden" name="payment_row_count" id='payment_row_count' value="<?= $q22->num_rows();?>">
      <?php } //num_rows if() 
            else{
              $atleast_one_payments ='true';
            }
      ?>
         
    <?php 
     } 
     if($atleast_one_payments=='true'){ ?>
        <input type="hidden" name="payment_row_count" id='payment_row_count' value="1">
        

        <div class="col-md-12  payments_div">

          


          <div class="box box-solid bg-blue">
            <div class="box-body">
              <div class="row">
          

                <div class="col-md-6">
                  <div class="">
                  <label for="amount_1"><?= $this->lang->line('amount'); ?></label>
                    <input type="text" class="form-control text-right payment" id="amount_1" name="amount_1" placeholder="" onkeyup="calculate_payments()">
                      <span id="amount_1_msg" style="display:none" class="text-danger"></span>
                </div>
               </div>
                <div class="col-md-6">
                  <div class="">
                    <label for="payment_type_1"><?= $this->lang->line('payment_type'); ?></label>
                    <select class="form-control" id='payment_type_1' name="payment_type_1">
                      <?php
                        $q1=$this->db->query("select * from db_paymenttypes where status=1 and store_id=".get_current_store_id());
                         if($q1->num_rows()>0){
                             foreach($q1->result() as $res1){
                             echo "<option value='".$res1->payment_type."'>".$res1->payment_type ."</option>";
                           }
                         }
                         else{
                            echo "No Records Found";
                         }
                        ?>
                    </select>
                    <span id="payment_type_1_msg" style="display:none" class="text-danger"></span>
                  </div>
                </div>
            <div class="clearfix"></div>
        </div>  
        <div class="row">
                  <input type="hidden" id="account_id_1" name="account_id_1" value="1">
                  <div class="col-md-6">
                    <div class="">
                      <label for="payment_discount_input">Discount Amount</label>
                      <input type="text" class="form-control text-right only_currency payment_discount_input" id="payment_discount_input" value="0.00" autocomplete="off">
                      <span class="payment_discount_input_msg text-danger" style="display:none"></span>
                    </div>
                  </div>
              <div class="clearfix"></div>
          </div>  
        <div class="row hide">
               <div class="col-md-12">
                  <div class="">
                    <label for="payment_note_1"><?= $this->lang->line('payment_note'); ?></label>
                    <textarea type="text" class="form-control" id="payment_note_1" name="payment_note_1" placeholder="" ></textarea>
                    <span id="payment_note_1_msg" style="display:none" class="text-danger"></span>
                  </div>
               </div>
                
            <div class="clearfix"></div>
        </div>   
        </div>
        </div>
      </div><!-- col-md-12 -->
    <?php } ?>

    </div>
      


      <div class="row">
              <div class="col-md-12">
              <div class="col-md-12">
              <div class="col-md-12">
                <button type="button" class="btn btn-primary btn-block" id="add_payment_row">Add Payment Row</button>
              </div>
              </div>
            </div>
            </div>

            <div class="row hide">
              <div class="col-md-12">
              <div class="col-md-12">
              <div class="col-md-12">
                <div class="">
                    <label for="sales_note"><?= $this->lang->line('note'); ?></label>
                    <textarea type="text" class="form-control" id="sales_note" name="sales_note" placeholder="" ></textarea>
                    <span id="sales_note_msg" style="display:none" class="text-danger"></span>
                  </div>
              </div>
              </div>
            </div>
            </div>
      </div><!-- col-md-9 -->


      <!-- RIGHT HAND -->
      <div class="col-md-4 payment-summary-column">

        
        

        <div class="col-md-12">

          <div class="box box-solid bg-blue">
              <div class="box-body">
                <div class="row payment-items-row">
                  <div class="col-md-12 border-custom-bottom">
                    <span class="col-md-6 text-right text-bold payment-summary-label payment-items-label">Total Items:</span>
                    <span class="col-md-6 text-right text-bold  custom-font-size sales_div_tot_qty">0.00</span>
                  </div>
                </div>

                <div class="row payment-subtotal-row">
                  <div class="col-md-12 border-custom-bottom">
                    <span class="col-md-6 text-right text-bold payment-summary-label">Subtotal:</span>
                    <span class="col-md-6 text-right text-bold  custom-font-size sales_div_tot_amt">0.00</span>
                  </div>
                </div>
                <!--  -->
                <div class="row ">
                  <div class="col-md-12 border-custom-bottom">
                    <span class="col-md-6 text-right text-bold payment-summary-label">Discount(-):</span>
                    <span class="col-md-6 text-right text-bold  custom-font-size sales_div_tot_discount">0.00</span>
                  </div>
                </div>
                <!--  -->
                <div class="row hide">
                  <div class="col-md-12 border-custom-bottom">
                    <span class="col-md-6 text-right text-bold payment-summary-label">Coupon Discount(-):</span>
                    <span class="col-md-6 text-right text-bold  custom-font-size coupon_discount_div_amt">0.00</span>
                    <input type="hidden" name="coupon_discount_amt" id='coupon_discount_amt' value="<?=$coupon_amt?>">
                  </div>
                </div>
                <!--  -->
                <div class="row bg-green">
                  <div class="col-md-12 border-custom-bottom">
                    <span class="col-md-6 text-right text-bold payment-summary-label">Net:</span>
                    <span class="col-md-6 text-right text-bold  custom-font-size sales_div_tot_payble">0.00</span>
                  </div>
                </div>
                <!--  -->
                <div class="row ">
                  <div class="col-md-12 border-custom-bottom">
                    <span class="col-md-6 text-right text-bold payment-summary-label">Paid:</span>
                    <span class="col-md-6 text-right text-bold  custom-font-size sales_div_tot_paid">0.00</span>
                  </div>
                </div>
                <!--  -->
                <!--  -->
                <div class="row payment-balance-row">
                  <div class="col-md-12 border-custom-bottom">
                    <span class="col-md-6 text-right text-bold payment-summary-label">Balance:</span>
                    <span class="col-md-6 text-right text-bold  custom-font-size sales_div_tot_balance">0.00</span>
                  </div>
                </div>
                <!--  -->
                <div class="row payment-change-row">
                  <div class="col-md-12 bg-red">
                    <span class="col-md-6 text-right text-bold payment-summary-label">Change:</span>
                    <span class="col-md-6 text-right text-bold  custom-font-size sales_div_change_return">0.00</span>
                  </div>
                </div>
                <!--  -->
                                      
              </div>
                    <!-- /.box-body -->
                  </div>
        </div>
      </div>
    </div>
        
      </div>
      <div class="modal-footer" style="text-align: center;">
        <button type="button" class="btn btn-default btn-lg hide" data-dismiss="modal">Close</button>
        <button type="button" class="btn bg-maroon btn-lg make_sale btn-lg" onclick="save()" style="border-radius: 20px; width: 140px;"><i class="fa  fa-save "></i> Save</button>
        <button type="button" class="btn btn-success btn-lg make_sale btn-lg" onclick="save(true)" style="border-radius: 20px; width: 140px;"><i class="fa  fa-print "></i> Save & Print</button>

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
