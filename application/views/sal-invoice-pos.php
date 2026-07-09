<!DOCTYPE html>
<html>

<head>
    <title>Default Invoice Format</title>
    <!-- TABLES CSS CODE -->
    <?php include"comman/code_css.php"; ?>
    <style type="text/css">
    body {
        font-family: arial;
        font-size: 9px;
        font-weight: normal;
        padding-top: 15px;
    }

    hr {
        margin-top: 3px;
        margin-bottom: 3px;
        border: none;
        border-top: 1px solid #000;
        color: #000;
        background-color: #000;
        height: 1px;
    }

    /* QR code size */
    .qr-box img {
        width: 150px;
        height: auto;
    }

    @media print {

        .qr-box img {
            width: 130px;
        }


        @page {
            margin: 0;
        }

        html,
        body {
            width: 80mm;
            padding: 5mm 3mm;
            box-sizing: border-box;
        }

        .no-print {
            display: none !important;
        }
    }
    </style>
</head>

<body onload="window.print();">
    <!--  -->
    <?php
	$CI =& get_instance();
	
    
  	$q3=$this->db->query("SELECT b.coupon_id,b.coupon_amt, b.created_by, b.customer_previous_due,b.customer_total_due,b.store_id,a.customer_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,a.delete_bit,b.invoice_terms,
                           a.opening_balance,a.country_id,a.state_id,
                           a.postcode,a.address,b.sales_date,b.created_time,b.reference_no,
                           b.sales_code,b.sales_note,a.sales_due,
                           coalesce(b.grand_total,0) as grand_total,
                           coalesce(b.subtotal,0) as subtotal,
                           coalesce(b.paid_amount,0) as paid_amount,
                           coalesce(b.other_charges_input,0) as other_charges_input,
                           other_charges_tax_id,
                           coalesce(b.other_charges_amt,0) as other_charges_amt,
                           discount_to_all_input,
                           b.discount_to_all_type,
                           coalesce(b.tot_discount_to_all_amt,0) as tot_discount_to_all_amt,
                           coalesce(b.round_off,0) as round_off,
                           b.payment_status

                           FROM db_customers a,
                           db_sales b 
                           WHERE 
                           a.`id`=b.`customer_id` AND 
                           b.`id`='$sales_id' 
                           ");
                        
    
    $res3=$q3->row();
    $customer_name=$res3->customer_name;
    $customer_mobile=$res3->mobile;
    $customer_phone=$res3->phone;
    $customer_email=$res3->email;
    $customer_country=$res3->country_id;
    $customer_state=$res3->state_id;
    $customer_address=$res3->address;
    $customer_postcode=$res3->postcode;
    $customer_gst_no=$res3->gstin;
    $customer_tax_number=$res3->tax_number;
    $customer_opening_balance=$res3->opening_balance;
    $sales_date=show_date($res3->sales_date);
    $reference_no=$res3->reference_no;
    $created_time=show_time($res3->created_time);
    $sales_code=$res3->sales_code;
    $sales_note=$res3->sales_note;
    $customer_delete_bit=$res3->delete_bit;
   // $invoice_terms=nl2br($res3->invoice_terms);

    $previous_due=$res3->sales_due-($res3->grand_total-$res3->paid_amount);//$res3->customer_previous_due;
    $previous_due = ($previous_due>0) ? $previous_due : 0;
    $total_due=$res3->sales_due;//$res3->customer_total_due;

    $coupon_id=$res3->coupon_id;
    $coupon_amt=$res3->coupon_amt;

    $coupon_code = '';
    $coupon_type = '';
    $coupon_value=0;
    if(!empty($coupon_id)){
    	$coupon_details =get_customer_coupon_details($coupon_id);
    	$coupon_code =$coupon_details->code;
    	$coupon_value =$coupon_details->value;
    	$coupon_type =$coupon_details->type;
    } 

    
    $subtotal=$res3->subtotal;
    $grand_total=$res3->grand_total;
    $other_charges_input=$res3->other_charges_input;
    $other_charges_tax_id=$res3->other_charges_tax_id;
    $other_charges_amt=$res3->other_charges_amt;
    $paid_amount=$res3->paid_amount;
    $discount_to_all_input=$res3->discount_to_all_input;
    $discount_to_all_type=$res3->discount_to_all_type;
    //$discount_to_all_type = ($discount_to_all_type=='in_percentage') ? '%' : 'Fixed';
    $tot_discount_to_all_amt=$res3->tot_discount_to_all_amt;
    $round_off=$res3->round_off;
    $payment_status=$res3->payment_status;
    
    if($discount_to_all_input>0){
    	$str="($discount_to_all_input%)";
    }else{
    	$str="(Fixed)";
    }


    if(!empty($customer_state)){
      $q6 = $this->db->query("select state from db_states where id='$customer_state'");
      if($q6->num_rows()>0){
      	$customer_state = $q6->row()->state;
      }
    }

    $overall_discounted = $tot_discount_to_all_amt + $coupon_amt;

    $q1=$this->db->query("select * from db_store where id=".$res3->store_id." ");
    $res1=$q1->row();
    $store_name		=$res1->store_name;
    $company_mobile		=$res1->mobile;
    $company_phone		=$res1->phone;
    $company_email		=$res1->email;
    $company_country	=$res1->country;
    $company_state		=$res1->state;
    $company_city		=$res1->city;
    $company_address	=$res1->address;
    $company_postcode	=$res1->postcode;
    $company_gst_no		=$res1->gst_no;//Goods and Service Tax Number (issued by govt.)
    $company_vat_number		=$res1->vat_no;//Goods and Service Tax Number (issued by govt.)
    $store_logo=(!empty($res1->store_logo)) ? $res1->store_logo : store_demo_logo();
    $store_website		=$res1->store_website;
    $mrp_column		=$res1->mrp_column;
    $previous_balance_bit	=$res1->previous_balance_bit;
    $pos_invoice_format_id	=$res1->pos_invoice_format_id;
    $t_and_c_status_pos	=$res1->t_and_c_status_pos;


    ?>
    <table width="95%" align="center">
        <tr>
            <td align="center" width="100%">
                <span>

                    <!-- Dynamic header from DB - disabled, replaced with static AL KASIR info below

                    <strong>TAX INVOICE</strong><br>
                    <strong><?= $store_name; ?></strong><br>
                    <?php echo (!empty(trim($company_address))) ? $this->lang->line('company_address')."".$company_address."<br>" : '';?>
                    <?php echo (!empty(trim($company_gst_no)) && gst_number()) ? $this->lang->line('gst_number').": ".$company_gst_no."<br>" : '';?>
                    <?php if(!empty(trim($company_mobile)))
		            		{
		            			echo 'Mob. No.'.": ".$company_mobile;
		            			if(!empty($company_phone)){
		            				echo ",".$company_phone;
		            			}
		            			echo "<br>";
		            		}
		            ?>
                    <?php echo (!empty(trim($company_vat_number)) && vat_number()) ? $this->lang->line('vat_number').": ".$company_vat_number."<br>" : '';?>

                    -->

                    <!-- Dynamic Header -->
                    <?php 
                        $dynamic_store_name = strtoupper($store_name);
                        $dynamic_store_name = str_replace('&AMP;', '&amp;', $dynamic_store_name);
                        $dynamic_address = $company_address;
                        if (!empty($company_city)) {
                            $dynamic_address .= ', ' . $company_city;
                        }
                        $dynamic_phones = [];
                        if(!empty($company_mobile)) $dynamic_phones[] = $company_mobile;
                        if(!empty($company_phone)) $dynamic_phones[] = $company_phone;
                        $dynamic_phone_str = implode(", ", $dynamic_phones);
                    ?>
                    <strong style="font-size: 22px;"><?= $dynamic_store_name ?></strong><br>
                    <?php if(!empty($company_email)): ?>
                        <strong style="font-size: 11px;">Email: <?= $company_email ?></strong><br>
                    <?php endif; ?>
                    <span style="font-weight: normal;"><?= $dynamic_address ?></span><br>
                    <span style="font-weight: normal;">Mob.: <?= $dynamic_phone_str ?></span><br>
                    <span style="font-weight: normal;">TRN: <?= $company_vat_number ?></span><br>
                    <hr>
                    <strong style="display: inline-block; margin-bottom: 6px;">TAX INVOICE</strong>

                </span>
            </td>
        </tr>
        <!-- empty spacer row disabled to minimize gap above bill details
        <tr>
            <td align="center">

            </td>
        </tr>
        -->

        <tr>
            <td style="padding-top:0;padding-bottom:0;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <!-- Original bill info layout - disabled, replaced with screenshot layout below
                    <tr>
                        <td>Bill No.&nbsp; &nbsp; &nbsp;:<?= $sales_code; ?>
                        </td>
                        <td>Counter # &nbsp; : 1</td>
                    </tr>
                    <tr>
                        <td>Bill Date&nbsp;&nbsp;:&nbsp;<?=$sales_date ?></td>
                        <td>Bill Time&nbsp; &nbsp;:<?=$created_time ?></td>
                    </tr>
                    <tr>
                        <td><?= $this->lang->line('name'); ?> &nbsp; &nbsp; &nbsp; &nbsp; :
                            <?= $customer_name; ?></td>
                        <td><?= $this->lang->line('seller'); ?> &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; :
                            <?= ucfirst($res3->created_by) ?>
                        </td>
                    </tr>
                    -->

                    <!-- New bill info layout matching screenshot -->
                    <tr>
                        <td>Bill No.&nbsp;:&nbsp;<strong><?= $sales_code; ?></strong></td>
                        <td align="right">Bill Date&nbsp;:&nbsp;<strong><?= $sales_date ?> <?= $created_time ?></strong></td>
                    </tr>
                    <tr>
                        <td>Payment&nbsp;:&nbsp;<strong>Cash</strong></td>
                        <td align="right">Customer&nbsp;:&nbsp;<strong><?= $customer_name; ?></strong></td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                        <!-- Original header (lang-based) - disabled, replaced with screenshot labels below
                        <tr style="border-top-style: dashed;border-bottom-style: dashed;border-width: 0.1px;">
                            <th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;">#</th>
                            <th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;">
                                <?= $this->lang->line('description'); ?></th>

                            <th style="font-size: 11px; text-align: center;padding-left: 2px; padding-right: 2px;">
                                <?= $this->lang->line('quantity'); ?></th>
                            <?php if($mrp_column){ ?>
                            <th style="font-size: 11px; text-align: right;padding-left: 2px; padding-right: 2px;">
                                <?= $this->lang->line('mrp'); ?></th>
                            <?php  } ?>
                            <th style="font-size: 11px; text-align: right;padding-left: 2px; padding-right: 2px;">
                                <?= $this->lang->line('rate'); ?></th>
                            <th style="font-size: 11px; text-align: right;padding-left: 2px; padding-right: 2px;">
                                <?= $this->lang->line('total'); ?></th>
                        </tr>
                        -->

                        <!-- Screenshot header labels: #, Item, Qty, Rate, Amt -->
                        <tr style="border-top-style: dashed;border-bottom-style: dashed;border-width: 0.1px;">
                            <th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;">#</th>
                            <th style="font-size: 11px; text-align: left;padding-left: 2px; padding-right: 2px;">Item</th>
                            <th style="font-size: 11px; text-align: center;padding-left: 2px; padding-right: 2px;">Qty</th>
                            <?php if($mrp_column){ ?>
                            <th style="font-size: 11px; text-align: right;padding-left: 2px; padding-right: 2px;">MRP</th>
                            <?php  } ?>
                            <th style="font-size: 11px; text-align: right;padding-left: 2px; padding-right: 2px;">Rate</th>
                            <th style="font-size: 11px; text-align: right;padding-left: 2px; padding-right: 2px;">Amt</th>
                        </tr>
                    </thead>
                    <tbody style="border-bottom-style: dashed;border-width: 0.1px;">
                        <?php
			              $i=0;
			              $tot_qty=0;
			              $subtotal=0;
			              $tax_amt=0;
			              $q2=$this->db->query("select b.mrp, b.item_name,a.sales_qty,a.unit_total_cost,a.price_per_unit,a.tax_amt,c.tax,a.total_cost,a.discount_amt from db_salesitems a,db_items b,db_tax c where c.id=a.tax_id and b.id=a.item_id and a.sales_id='$sales_id'");
			              foreach ($q2->result() as $res2) {
			                  echo "<tr>";  
			                  echo "<td style='padding-left: 2px; padding-right: 2px;' valign='top'>".++$i."</td>";
			                  echo "<td style='padding-left: 2px; padding-right: 2px;'>".$res2->item_name."</td>";
			                  
			                  echo "<td style='text-align: center;padding-left: 2px; padding-right: 2px;'>".format_qty($res2->sales_qty)."</td>";
			                  if($mrp_column){
			                  	echo "<td style='text-align: right;padding-left: 2px; padding-right: 2px;'>".store_number_format($res2->mrp)."</td>";
			                  }
			                  echo "<td style='text-align: right;padding-left: 2px; padding-right: 2px;'>".store_number_format($res2->unit_total_cost)."</td>";
			                  echo "<td style='text-align: right;padding-left: 2px; padding-right: 2px;' >".store_number_format($res2->total_cost)."</td>";
			                  echo "</tr>";  
			                  //$tot_qty+=$res2->sales_qty;
			                  $subtotal+=($res2->total_cost);
			                  $tax_amt+=$res2->tax_amt;
			                  $overall_discounted+=$res2->discount_amt;
			              }
			              $before_tax = $subtotal-$tax_amt;



			              ?>

                    </tbody>
                    <tfoot>
                        <!-- Original totals layout - disabled, replaced with screenshot 2x2 grid + big Net Total below

                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>"
                                align="right"><?= $this->lang->line('before_tax'); ?></td>
                            <td style=" padding-left: 2px; padding-right: 2px;" align="right">
                                <?= store_number_format($before_tax);?></td>
                        </tr>

                        <?php if(get_store_details()->pos_invoice_format_id == 1){ ?>
                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>"
                                align="right"><?= $this->lang->line('tax_amount'); ?></td>
                            <td style=" padding-left: 2px; padding-right: 2px;" align="right">
                                <?= store_number_format($tax_amt);?></td>
                        </tr>
                        <?php } ?>

                        <?php if(!empty($coupon_code)) {?>
                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>"
                                align="right"><?= $this->lang->line('couponDiscount'); ?></td>
                            <td style=" padding-left: 2px; padding-right: 2px;" align="right">
                                <?= store_number_format($coupon_amt); ?></td>
                        </tr>
                        <?php } ?>

                        <?php if(!empty($tot_discount_to_all_amt) && $tot_discount_to_all_amt!=0) {?>
                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>"
                                align="right"><?= $this->lang->line('discount'); ?></td>
                            <td style=" padding-left: 2px; padding-right: 2px;" align="right">
                                <?= store_number_format($tot_discount_to_all_amt); ?></td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>"
                                align="right"><?= $this->lang->line('total'); ?></td>
                            <td style=" padding-left: 2px; padding-right: 2px;" align="right">
                                <?= store_number_format($grand_total); ?></td>
                        </tr>
                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>"
                                align="right"><?= $this->lang->line('tot_discounted_amt'); ?></td>
                            <td style=" padding-left: 2px; padding-right: 2px;" align="right">
                                <?= store_number_format($overall_discounted); ?></td>
                        </tr>

                        <?php if(change_return_status()) {
                            $change_return_amount = get_change_return_amount($sales_id); ?>
                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>"
                                align="right"><?= $this->lang->line('paid_amount'); ?></td>
                            <td style=" padding-left: 2px; padding-right: 2px;" align="right">
                                <?= store_number_format($paid_amount+$change_return_amount); ?></td>
                        </tr>
                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>"
                                align="right"><?= $this->lang->line('refund'); ?></td>
                            <td style=" padding-left: 2px; padding-right: 2px;" align="right">
                                <?= store_number_format($change_return_amount); ?></td>
                        </tr>
                        <?php } else { ?>
                        <tr>
                            <td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>"
                                align="right"><?= $this->lang->line('paid_amount'); ?></td>
                            <td style=" padding-left: 2px; padding-right: 2px;" align="right">
                                <?= store_number_format($paid_amount); ?></td>
                        </tr>
                        <?php } ?>

                        -->

                        <!-- Screenshot totals layout: 2x2 grid (Taxable | Sub Total) (Total VAT | Discount) + big Net Total -->
                        <tr>
                            <td colspan="<?=$mrp_column+5?>" style="padding-top: 4px;">
                                <table width="100%" style="border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 2px;">Sub Total&nbsp;:&nbsp;<strong><?= store_number_format($subtotal); ?></strong></td>
                                        <td style="padding: 2px;" align="right">Discount&nbsp;:&nbsp;<strong><?= store_number_format($overall_discounted); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 2px;">Taxable&nbsp;:&nbsp;<strong><?= store_number_format($before_tax); ?></strong></td>
                                        <td style="padding: 2px;" align="right">Total VAT&nbsp;:&nbsp;<strong><?= store_number_format($tax_amt); ?></strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="<?=$mrp_column+5?>" align="center" style="padding-top: 6px; padding-bottom: 4px;">
                                <span style="font-size: 22px; font-weight: bold;">Net Total&nbsp;:&nbsp;<?= store_number_format($grand_total); ?></span>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="<?=$mrp_column+5?>"><hr></td>
                        </tr>

                        <?php if($previous_balance_bit==1) {?>

                        <?php } ?>
                        <?php if(!empty($coupon_code)) {?>
                        <tr>
                            <td colspan="<?=$mrp_column+5?>" align="left">
                                <b><?= $this->lang->line('couponCode'); ?>:</b>
                                <i><?=getTruncatedCCNumber($coupon_code);?></i>
                            </td>
                        </tr>
                        <?php }?>
                        <?php
						if($t_and_c_status_pos){ ?>
                        <tr>
                            <td colspan="<?=$mrp_column+5?>" align="left">
                                &nbsp;
                            </td>
                        </tr>

                        <?php }
					 ?>

                        <tr>
                            <td colspan="<?=$mrp_column+5?>" align="center" style="padding:0;">
                                <?php
								/* Dynamic WhatsApp QR code generation - disabled, replaced with static QR image below

									// Build the WhatsApp message with the bill details
								$wa_message  = "Request for Customer Support *Al Kasir*".PHP_EOL.PHP_EOL;
								// monospace block (```) so the columns line up
								$wa_message .= "```".PHP_EOL;
								$wa_message .= str_pad("Bill Number", 11)." : ".$sales_code.PHP_EOL;
								$wa_message .= str_pad("Date & Time", 11)." : ".$sales_date." ".$created_time.PHP_EOL;
								$wa_message .= str_pad("Bill Amount", 11)." : ".store_number_format($grand_total).PHP_EOL;
								$wa_message .= str_pad("Tax Amount", 11)." : ".store_number_format($tax_amt).PHP_EOL;
								$wa_message .= "```".PHP_EOL.PHP_EOL;
								$wa_message .= "Thank you!";

								// WhatsApp click-to-chat link
								$whatsapp_link = "https://api.whatsapp.com/send?phone=971556173300&text=".rawurlencode($wa_message);

								// qr_image() base64-decodes its input, so encode it (URL-safe)
								$qr_data = str_replace('=', '-', str_replace('/', '_', base64_encode($whatsapp_link)));

									echo $CI->print_qr($qr_data);
								*/
						?>
                                <!-- Static QR code image --><div class="qr-box" style="display:inline-block;vertical-align:middle;line-height:0 !important;font-size:0;"><img src="<?= base_url('uploads/store/whatsapp_qr.jpeg'); ?>" alt="QR Code"></div>

                            </td>
                        </tr>

                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
    <div style="text-align:center; margin-top:20px; font-weight:bold; font-size: 16px;">
        Thank You!<br>
        Visit Again!
    </div>
    <center>
        <div class="row no-print">
            <div class="col-md-12">
                <div class="col-md-2 col-md-offset-5 col-xs-4 col-xs-offset-4 form-group">
                    <button type="button" id="" class="btn btn-block btn-success btn-xs" onclick="window.print();"
                        title="Print">Print</button>
                    <?php if(isset($_GET['redirect'])){ ?>
                    <a href="<?= base_url().$_GET['redirect'];?>"><button type="button"
                            class="btn btn-block btn-danger btn-xs" title="Back">Back</button></a>
                    <?php } ?>
                </div>
            </div>
        </div>

    </center>
</body>

</html>