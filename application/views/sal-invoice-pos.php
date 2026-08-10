<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>POS Tax Invoice</title>
  <style>
    *{box-sizing:border-box}
    html,body{margin:0;padding:0;background:#fff;color:#000}
    body{font-family:Arial,Helvetica,sans-serif;font-size:10px;line-height:1.22}
    .receipt{width:80mm;max-width:80mm;margin:0 auto;padding:4mm 5mm 5mm}
    .center{text-align:center}.right{text-align:right}.bold{font-weight:700}
    .store-logo{display:block;max-width:34mm;max-height:20mm;width:auto;height:auto;margin:0 auto 2px}
    .store-name{font-size:11px;font-weight:700;text-transform:uppercase}
    .rule{border:0;border-top:1px dashed #000;margin:5px 0}
    .solid-rule{border:0;border-top:1px solid #000;margin:5px 0}
    .invoice-meta{width:100%;border-collapse:collapse;font-size:9px}
    .invoice-meta td{padding:0;white-space:nowrap}
    .barcode{display:block;width:43mm;max-height:11mm;margin:3px auto 0;object-fit:fill}
    .invoice-number{font-weight:700;margin-top:1px}
    .items{width:100%;border-collapse:collapse;table-layout:fixed}
    .items th{font-size:9px;text-align:left;border-top:1px dashed #000;border-bottom:1px dashed #000;padding:3px 1px}
    .items td{vertical-align:top;padding:2px 1px}
    .items .sl{width:7%}.items .description{width:47%}.items .qty{width:12%;text-align:center}
    .items .price,.items .amount{width:17%;text-align:right}
    .item-barcode{display:block;font-size:8px;margin-top:1px}
    .summary,.details{width:100%;border-collapse:collapse}
    .summary td{padding:1px 0}.summary .label{width:23%}.summary .value{width:27%;text-align:right;padding-right:5px}
    .net-amount{text-align:center;font-size:18px;font-weight:700;padding:7px 0 4px}
    .details td{width:50%;vertical-align:top;padding:0 3px 0 0}
    .section-title{font-size:12px;font-weight:700;margin-bottom:3px}
    .detail-row{display:grid;grid-template-columns:20mm minmax(0,1fr);align-items:baseline;font-size:8px;line-height:1.35;white-space:nowrap}
    .detail-row span,.detail-row b{display:block;white-space:nowrap}
    .policy-title{font-size:11px;font-weight:700;margin:12px 0 7px}
    .policy{font-size:8px;white-space:pre-line}
    .thank-you{font-size:9px;font-weight:700;margin:10px 0 5px}
    .receipt-marks{display:flex;align-items:center;justify-content:center;gap:3mm;margin-top:7px}
    .receipt-marks img{display:block;width:auto;height:auto;object-fit:contain}
    .qr{max-width:18mm;max-height:18mm}
    .paid-logo{max-width:25mm;max-height:20mm}
    .print-button{display:block;width:55mm;margin:12px auto 0;padding:5px;border:0;background:#00a65a;color:#fff;cursor:pointer}
    @media print{
      @page{size:80mm auto;margin:0}
      html,body,.receipt{width:80mm;max-width:80mm}
      .receipt{margin:0;padding:3mm 4mm}
      .no-print{display:none!important}
    }
  </style>
</head>
<body onload="window.print();">
<?php
$sale = $this->db
  ->select('s.*, c.customer_name')
  ->from('db_sales s')
  ->join('db_customers c','c.id=s.customer_id','left')
  ->where('s.id',(int)$sales_id)->get()->row();
$store = $this->db->where('id',$sale->store_id)->get('db_store')->row();
$items = $this->db
  ->select('si.*, i.item_name, i.item_code, i.custom_barcode, t.tax')
  ->from('db_salesitems si')
  ->join('db_items i','i.id=si.item_id','left')
  ->join('db_tax t','t.id=si.tax_id','left')
  ->where('si.sales_id',(int)$sales_id)->order_by('si.id','ASC')->get()->result();
$payments = $this->db->where('sales_id',(int)$sales_id)->order_by('id','ASC')->get('db_salespayments')->result();

$store_logo = !empty($store->store_logo) ? $store->store_logo : store_demo_logo();
$invoice_date = show_date($sale->sales_date);
$invoice_time = show_time($sale->created_time);
$item_subtotal = 0; $item_discount = 0; $tax_total = 0;
foreach($items as $item){
  $item_subtotal += (float)$item->price_per_unit * (float)$item->sales_qty;
  $item_discount += (float)$item->discount_amt;
  $tax_total += (float)$item->tax_amt;
}
$total_discount = $item_discount + (float)$sale->tot_discount_to_all_amt + (float)$sale->coupon_amt;
$change_return = (float)get_change_return_amount($sales_id);
$net_before_rounding = (float)$sale->grand_total - (float)$sale->round_off;
$taxable_amount = max(0,$net_before_rounding-$tax_total);
$tax_rates = array();
foreach($items as $item){
  $rate = (float)$item->tax;
  if($rate>0) $tax_rates[(string)$rate] = $rate;
}
$tax_rate_text = count($tax_rates)===1 ? rtrim(rtrim(number_format(reset($tax_rates),2,'.',''),'0'),'.').'%' : (count($tax_rates)>1 ? 'Multiple' : '0%');
$payment_names = array();
foreach($payments as $payment){ if(!in_array($payment->payment_type,$payment_names,true)) $payment_names[]=$payment->payment_type; }
$payment_text = $payment_names ? implode(', ',$payment_names) : '-';
$received_amount = 0;
foreach($payments as $payment) $received_amount += (float)$payment->payment;
$received_amount += $change_return;
$policy = !empty(trim($sale->invoice_terms)) ? html_entity_decode($sale->invoice_terms) : '';
$footer = !empty(trim($store->sales_invoice_footer_text)) ? html_entity_decode($store->sales_invoice_footer_text) : 'THANK YOU FOR YOUR BUSINESS!';
?>
<main class="receipt">
  <header class="center">
    <?php if(!empty($store_logo)): ?><img class="store-logo" src="<?= base_url($store_logo); ?>" alt="Logo"><?php endif; ?>
    <div class="store-name"><?= html_escape($store->store_name); ?></div>
    <?php if(!empty($store->address)): ?><div><?= html_escape($store->address); ?></div><?php endif; ?>
    <?php if(!empty($store->city)): ?><div><?= html_escape($store->city.(!empty($store->postcode) ? ', '.$store->postcode : '')); ?></div><?php endif; ?>
    <?php if(!empty($store->mobile) || !empty($store->phone)): ?>
      <div>Mobile: <?= html_escape(implode(', ',array_filter(array($store->mobile,$store->phone)))); ?></div>
    <?php endif; ?>
    <?php if(!empty($store->vat_no)): ?><div class="bold">TRN : <?= html_escape($store->vat_no); ?></div><?php endif; ?>
  </header>

  <hr class="rule">
  <table class="invoice-meta">
    <tr>
      <td>Date : <?= html_escape($invoice_date); ?></td>
      <td class="center bold">TAX INVOICE</td>
      <td class="right">Time : <?= html_escape($invoice_time); ?></td>
    </tr>
  </table>
  <img class="barcode" src="<?= base_url('barcode/index/'.rawurlencode($sale->sales_code)); ?>" alt="<?= html_escape($sale->sales_code); ?>">
  <div class="invoice-number center"><?= html_escape($sale->sales_code); ?></div>
  <hr class="rule">

  <table class="items">
    <thead><tr><th class="sl">SL</th><th class="description">Description</th><th class="qty">Qty</th><th class="price">Price</th><th class="amount">Amount</th></tr></thead>
    <tbody>
    <?php foreach($items as $index=>$item): ?>
      <tr>
        <td class="sl"><?= $index+1; ?></td>
        <td class="description"><?= html_escape($item->item_name); ?>
          <?php if(!empty($item->custom_barcode) || !empty($item->item_code)): ?>
            <span class="item-barcode"><?= html_escape($item->custom_barcode ?: $item->item_code); ?></span>
          <?php endif; ?>
        </td>
        <td class="qty"><?= format_qty($item->sales_qty); ?></td>
        <td class="price"><?= store_number_format($item->price_per_unit); ?></td>
        <td class="amount"><?= store_number_format($item->total_cost); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

  <hr class="rule">
  <table class="summary">
    <tr>
      <td class="label">Subtotal</td><td class="value"><?= store_number_format($item_subtotal); ?></td>
      <td class="label">Discount</td><td class="value"><?= store_number_format($total_discount); ?></td>
    </tr>
    <tr>
      <td class="label">Net Total</td><td class="value"><?= store_number_format($net_before_rounding); ?></td>
      <td class="label">Rounding</td><td class="value"><?= store_number_format($sale->round_off); ?></td>
    </tr>
  </table>
  <div class="net-amount">NET AMOUNT : <?= store_total_format($sale->grand_total); ?></div>
  <hr class="solid-rule">

  <table class="details">
    <tr>
      <td>
        <div class="section-title">Tender Details</div>
        <div class="detail-row"><span>Payment Type</span><b>: <?= html_escape($payment_text); ?></b></div>
        <div class="detail-row"><span>Received Amount</span><b>: <?= store_number_format($received_amount); ?></b></div>
        <div class="detail-row"><span>Balance Amount</span><b>: <?= store_number_format($change_return); ?></b></div>
      </td>
      <td>
        <div class="section-title">VAT Details</div>
        <div class="detail-row"><span>Taxable Amount</span><b>: <?= store_number_format($taxable_amount); ?></b></div>
        <div class="detail-row"><span>VAT Rate(s)</span><b>: <?= html_escape($tax_rate_text); ?></b></div>
        <div class="detail-row"><span>VAT Amount</span><b>: <?= store_number_format($tax_total); ?></b></div>
      </td>
    </tr>
  </table>
  <hr class="rule">

  <?php if($policy!==''): ?>
    <div class="policy-title">RETURN &amp; EXCHANGE POLICY</div>
    <div class="policy"><?= nl2br(html_escape($policy)); ?></div>
    <hr class="rule">
  <?php endif; ?>

  <div class="thank-you center"><?= nl2br(html_escape($footer)); ?></div>
  <div class="receipt-marks">
    <div><?php if(!empty($store->qr_image)): ?><img class="qr" src="<?= base_url($store->qr_image); ?>" alt="QR Code"><?php endif; ?></div>
    <div><img class="paid-logo" src="<?= base_url('uploads/paid2.png'); ?>" alt="Paid"></div>
  </div>

  <button type="button" class="print-button no-print" onclick="window.print()">Print</button>
  <?php if(isset($_GET['redirect'])): ?><div class="center no-print"><a href="<?= base_url($_GET['redirect']); ?>">Back</a></div><?php endif; ?>
</main>
</body>
</html>
