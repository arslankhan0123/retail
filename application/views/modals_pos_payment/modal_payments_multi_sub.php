<?php 
$rowcount = $this->input->post('payment_row_count') +1;
?>
<div class="col-md-12 payments_div payments_div_<?=$rowcount?>">
          <div class="box box-solid bg-gray">
            <div class="box-header">
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" onclick="remove_row('<?=$rowcount?>')"><i class="fa fa-times fa-2x"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
         
                <div class="col-md-12">
                  <div class="">
                  <label for="amount_<?= $rowcount;?>"><?= $this->lang->line('amount'); ?></label>
                    <input type="text" class="form-control text-right paid_amt only_currency" id="amount_<?= $rowcount;?>" name="amount_<?= $rowcount;?>" placeholder="" onkeyup="calculate_payments()" >
                      <span id="amount_<?= $rowcount;?>_msg" style="display:none" class="text-danger"></span>
                </div>
               </div>
                <input type="hidden" id="payment_type_<?= $rowcount;?>" name="payment_type_<?= $rowcount;?>" value="Cash">
            <div class="clearfix"></div>
        </div>  
        <div class="row">
                  <div class="col-md-6">
                    <div class="">
                      <label for="account_id_<?= $rowcount;?>"><?= $this->lang->line('account'); ?></label>
                      <input type="text" class="form-control" value="Current Assets" readonly>
                      <input type="hidden" id="account_id_<?= $rowcount;?>" name="account_id_<?= $rowcount;?>" value="<?= get_current_assets_account_id(); ?>">
                      <span id="account_id_<?= $rowcount;?>_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>
              <div class="clearfix"></div>
          </div> 
        </div>
        </div>
      </div><!-- col-md-12 -->
