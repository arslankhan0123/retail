<div class="modal fade" id="customer-modal" tabindex="-1">
  <?= form_open('#', array('id' => 'customer-form')); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header header-custom">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title text-center"><?= $this->lang->line('add_customer'); ?></h4>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label for="customer_name"><?= $this->lang->line('customer_name'); ?>*</label>
            <label id="customer_name_msg" class="text-danger text-right pull-right"></label>
            <input type="text" class="form-control" id="customer_name" name="customer_name">
          </div>

          <div class="form-group">
            <label for="mobile"><?= $this->lang->line('mobile'); ?></label>
            <label id="mobile_msg" class="text-danger text-right pull-right"></label>
            <input type="tel" class="form-control no_special_char_no_space" id="mobile" name="mobile" placeholder="+1234567890">
          </div>

          <div class="form-group">
            <label for="email"><?= $this->lang->line('email'); ?></label>
            <label id="email_msg" class="text-danger text-right pull-right"></label>
            <input type="email" class="form-control" id="email" name="email">
          </div>

          <input type="hidden" name="phone" value="">
          <input type="hidden" name="country" value="">
          <input type="hidden" name="state" value="">
          <input type="hidden" name="city" value="">
          <input type="hidden" name="postcode" value="">
          <input type="hidden" name="address" value="">
          <input type="hidden" name="opening_balance" value="0">
          <input type="hidden" name="tax_number" value="">
          <input type="hidden" name="location_link" value="">
          <input type="hidden" name="credit_limit" value="-1">
          <?php if (gst_number()) { ?>
            <input type="hidden" name="gstin" value="">
          <?php } ?>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_customer">Save</button>
        </div>
      </div>
    </div>
  <?= form_close(); ?>
</div>
