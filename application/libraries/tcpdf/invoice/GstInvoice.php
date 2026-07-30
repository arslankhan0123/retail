<?php

include('MyPDF.php');

class GstInvoice extends MyPDF{
	//public $CI=null;

	public $sales_id =null;

	public $store =array();

	protected $customer =array();

	protected $sales =array();
	
	protected $sales_payment = [];

	public $customer_state_name = null;


	public function __construct(array $param=array())
	{
		$this->sales_id = $param['sales_id'];
		parent::__construct();

		$this->sales_id = $param['sales_id'];

		//$this->CI =& get_instance();

		$this->store = get_store_details();//Declared in MyPDF Pa

		$this->sales = get_sales_details($this->sales_id);

		$this->customer = get_customer_details($this->sales->customer_id);

	}
	public function _get_customer_details()
    {   
        $sales = $this->sales;
    	$customer = $this->customer;//array()
    	
    // 	print_r($customer);
        // print_r($sales);

    	$store = $this->store;//array()
    	
    // 	print_r($store);
    	
    	//Customer Records
	    $state = (!empty($customer->state_id)) ? get_state_details($customer->state_id) : '';
	    $this->customer_state_name = (!empty($state)) ? $state->state : $store->state;

        $pageWidth = $this->getPageWidth();
        $printableWidth = $pageWidth - 12;
        $ratio_cust = ($pageWidth < 160) ? 0.55 : 0.65;
        $w = $printableWidth * $ratio_cust;
        $h = 30;
        
        $salesman_name = '';
        if (!empty($sales->salesman_id)) {
            $salesman_query = $this->CI->db->query("select salesman_name from db_salesman where id=" . $sales->salesman_id);
            if ($salesman_query->num_rows() > 0) {
                $salesman_name = $salesman_query->row()->salesman_name;
            }
        }
        
        $customer_phone = !empty($customer->mobile) ? $customer->mobile : $customer->phone;
        $customer_trn = ($customer->id != 2) ? $customer->tax_number : '';
        $customer_details = '<table border="0" cellpadding="0" cellspacing="0" style="width:100%;">';
        $customer_details .= '<tr><td style="width:24%;"><b>Customer</b></td><td style="width:3%;"><b>:</b></td><td style="width:73%; font-weight:bold;">'.$customer->customer_name.'</td></tr>';
        $customer_details .= '<tr><td style="width:24%;"><b>Mobile</b></td><td style="width:3%;"><b>:</b></td><td style="width:73%;">'.$customer_phone.'</td></tr>';
        $customer_details .= '<tr><td style="width:24%;"><b>Address</b></td><td style="width:3%;"><b>:</b></td><td style="width:73%;">'.nl2br($customer->address).'</td></tr>';
        $customer_details .= '<tr><td style="width:24%;"><b>TRN</b></td><td style="width:3%;"><b>:</b></td><td style="width:73%;">'.$customer_trn.'</td></tr>';
        $customer_details .= '<tr><td style="width:24%;"><b>Salesman</b></td><td style="width:3%;"><b>:</b></td><td style="width:73%;">'.$salesman_name.'</td></tr>';
        $customer_details .= '</table>';

        $this->setCellPaddings(2,1,1,1);
        $this->setFont($this->get_font_name(), '', 11);
        $this->setFillColor(255, 255, 255);

        $this->writeHTMLCell($w, $h, $x ='6', $y='57', $customer_details, 1, 0, 1, true, 'L', true);
        
        return $this;
    } 

    public function _get_invoice_details()
    {
    	$sales = $this->sales;//array()
    	//print_r($sales);
    	$customer = $this->customer;
    // 	print_r($customer);
    	
        $pageWidth = $this->getPageWidth();
        $printableWidth = $pageWidth - 12;
        $ratio_cust = ($pageWidth < 160) ? 0.55 : 0.65;
        $ratio_inv = 1 - $ratio_cust;
        $w_customer = $printableWidth * $ratio_cust;
        $w_invoice = $printableWidth * $ratio_inv;
        $w = $w_invoice;
        $h = 30;
        
        $payments = $this->CI->db->select('payment_type')
                            ->from('db_salespayments')
                            ->where('sales_id', $sales->id)
                            ->order_by('id', 'asc')
                            ->get();

        $payment_types = array();
        $payment_type_keys = array();
        foreach($payments->result() as $payment){
            $payment_type = trim($payment->payment_type);
            $payment_type_key = strtoupper($payment_type);
            if($payment_type !== '' && !in_array($payment_type_key, $payment_type_keys, true)){
                $payment_types[] = $payment_type;
                $payment_type_keys[] = $payment_type_key;
            }
        }

        $inv_type = !empty($payment_types) ? implode(', ', $payment_types) : 'CREDIT';
        $primary_inv_type = !empty($payment_types) ? strtoupper($payment_types[0]) : 'CREDIT';

        if($primary_inv_type == 'CASH'){
			// $sales->due_date = $sales->sales_date;
			$sales->due_date = '';
			}
			if ($primary_inv_type == 'CREDIT') {
				if(!$sales->due_date){
				$sales->due_date = $sales->sales_date;
				}
			
		}

        $due_date = !empty($sales->due_date) ? show_date($sales->due_date) : '';
        $invoice_details = '<table border="0" cellpadding="0" cellspacing="0" style="width:100%;">';
        $invoice_details .= '<tr><td style="width:38%;"><b>'.$this->CI->lang->line('invoice_no').'</b></td><td style="width:4%;"><b>:</b></td><td style="width:58%;">'.$sales->sales_code.'</td></tr>';
        $invoice_details .= '<tr><td style="width:38%;"><b>Payment Types</b></td><td style="width:4%;"><b>:</b></td><td style="width:58%;">'.html_escape($inv_type).'</td></tr>';
        $invoice_details .= '<tr><td style="width:38%;"><b>Invoice Date</b></td><td style="width:4%;"><b>:</b></td><td style="width:58%;">'.show_date($sales->sales_date).'</td></tr>';
        $invoice_details .= '<tr><td style="width:38%;"><b>'.$this->CI->lang->line('due_date').'</b></td><td style="width:4%;"><b>:</b></td><td style="width:58%;">'.$due_date.'</td></tr>';
        $invoice_details .= '<tr><td style="width:38%;"><b>Reference</b></td><td style="width:4%;"><b>:</b></td><td style="width:58%;">'.$sales->reference_no.'</td></tr>';
        $invoice_details .= '</table>';

        $this->setCellPaddings(2,1,1,1);
        $this->setFont($this->get_font_name(), '', 11);
        $this->setFillColor(255, 255, 255);
        $this->writeHTMLCell($w, $h, $x = 6 + $w_customer, $y='57', $invoice_details, 1, 1, 1, true, 'L', true);
            
        return $this;
    }

    public function _get_shipping_address()
    {
        return null;
        $w = 100;
        $h = 40;

        $customer = $this->customer;//array()
        //Customer Shipping Address Records
	    $country='';
	    $state='';
	    $city='';
	    $address='';
	    $postcode='';
	    if(!empty($customer->shippingaddress_id)){
	        $Q2 = $this->CI->db->select("c.country,s.state,a.city,a.postcode,a.address")
	                        ->where("a.id",$customer->shippingaddress_id)
	                        ->from("db_shippingaddress a")
	                        ->join("db_country c","c.id = a.country_id",'left')
	                        ->join("db_states s","s.id = a.state_id",'left')
	                        ->get();                    
	        if($Q2->num_rows()>0){
	          $country=$Q2->row()->country;
	          $address=$Q2->row()->address;
	          $state=$Q2->row()->state;
	          $city=$Q2->row()->city;
	          $postcode=$Q2->row()->postcode;
	        }
	      }

        $custmer_details = '<span style="color:rgb(0, 0, 128);font-style:italic;">'.$this->CI->lang->line('shipping_address').'</span>';

        $custmer_details .= "<br><b>".$this->CI->lang->line('mobile')." :</b> ".$customer->mobile;
        $custmer_details .= "<br><b>".$this->CI->lang->line('name')." :</b> ".$customer->customer_name;
        $custmer_details .= "<br><b>".$this->CI->lang->line('address')." :</b> ".$address;
        $custmer_details .= "<br><b>".$this->CI->lang->line('postcode')." :</b> ".$postcode;
        $custmer_details .= "<br><b>".$this->CI->lang->line('city')." :</b> ".$city;
        $custmer_details .= "<br><b>".$this->CI->lang->line('state')." :</b> ".$state;

        $this->writeHTMLCell($w, $h, $x ='6', $y='90', $custmer_details, 1, 0, 1, true, 'J', true);
        return $this;
    }

    public function _get_bank_details()
    {
        return null;
    	$store = $this->store;
        $w = 100;
        $h = 25;
        $invoice_details = "";
        $invoice_details = '<span style="color:rgb(0, 0, 128);font-style:italic;">'.$this->CI->lang->line("bank_details").'</span><br>';
        $invoice_details .= nl2br($store->bank_details);

        $this->writeHTMLCell($w, $h, $x ='104', $y='', $invoice_details, 1, 1, 1, true, 'J', true);
        return $this;
    }
    
    
    public function _get_invoice_title_name()
    {

        $pageWidth = $this->getPageWidth();
        $w = $pageWidth - 12;
        $h = 15;
        
        $title_fs = ($pageWidth < 160) ? '30px' : '50px';

        $html = "<div><span style='font-weight:bold;font-size:".$title_fs.";'><b>TAX INVOICE</b></span><br/><span>TRN: " . $this->store->vat_no . "</span></div>";
        
        $this->setCellMargins(1,1,1,1);
        $this->setCellPaddings(2,1,1,1);
        $this->setFont($this->get_font_name(), '', 15);
        $this->setFillColor(255, 255, 255);

        $this->writeHTMLCell($w, $h, $x ='6', $y='40', $html, 1, 0, 1, true, 'C', true);
        
        return $this;
    }

    // Keep the print timestamp at the bottom; pagination is shown in the title box.
    public function Footer()
    {
        $this->setY(-8);
        $this->setFont($this->get_font_name(), 'I', 8);
        
        // Printed on (Left side)
        $this->Cell(0, 10, $this->_document_name.' : '.$this->_document_number, 0, false, 'L', 0, '', 0, false, 'T', 'M');
        
        // Page number (Right side)
        $this->setX($this->lMargin);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

   
	public function show_pdf()
	{
		$this->_main_body();
	}

	public function print()
	{
		$sales 		= $this->sales; //array()
		$store 		= $this->store; //array()
		$customer 	= $this->customer; //array()



		$this->_invoice_name = "Tax Invoice";

		$this->page_title = "Tax Invoice";

		//Don't change this
		$this->_invoice_format = 'GST';

		//$this->_QRCODE = $sales->sales_code;

		// set font
		$this->setFont($this->get_font_name(), 'B', 20);

		// add a page
		$this->AddPage();


		//invoice title
		$this->_get_invoice_title_name();

		// Cusomer Details
		$this->_get_customer_details();

		// Cusomer Details
		$this->_get_invoice_details();

		// Shipping Details
		$this->_get_shipping_address();

		// Bank Details
		$this->_get_bank_details();

		//Set document name (footer -R)
		$this->_set_document_name('Printed on');

		//Sey document number (footer -R)
		$this->_set_document_number(date('d-m-Y h:i:s a'));

		//Search Coupon Details
		$coupon_code = $coupon_type = '';
		$coupon_value = 0;
		if (!empty($sales->coupon_id)) {
			$coupon_details = get_customer_coupon_details($sales->coupon_id);
			$coupon_code = $coupon_details->code;
			$coupon_value = $coupon_details->value;
			$coupon_type = $coupon_details->type;
		}
		$this->setFont($this->get_font_name(), '', 8);

		// set cell padding
		$this->setCellPaddings(1, 1, 1, 1);

		// set cell margins
		//$this->setCellMargins(1, 1, 1, 1);

		// set color for background
		$this->setFillColor(255, 255, 255);

		$this->Ln(0);



		$this->setFont($this->get_font_name(), '', 8);


		$tbl = '
		<style type="text/css">
			table {
			    border-collapse: collapse;
			}
			#print, .totals-table, .signatures-table {
			    border: 0.5px solid #000000;
			}
			th {
			    border: 0.5px solid #000000;
			}
			.totals-table td {
			    border: 0.5px solid #000000;
			}
			table + table, table + table tr:first-child th, table + table tr:first-child td {
			    border-top: 0;
			}
			.text-right{
				text-align: right;
			}
			.text-center{
				text-align: center;
			}
			.text-bold{
				font-weight: bold;
			}
			.bg-light-blue{
				background-color: #e4eaff;
			}
			
			#print tbody td {
				border-top: none;
				border-bottom: none;
			}
		</style>
		<table id="print" >';

		$pageWidth = $this->getPageWidth();
		if ($pageWidth < 160) {
			$widthArray = array(
				'sl_no' 		=> '4',
				'description' 	=> '45',
				'unit' 			=> '5',
				'qty' 			=> '5',
				'rate' 	        => '10',
				'dis'           => '8',
				'tax'           => '12',
				'amount' 		=> '11',
			);
		} else {
			$widthArray = array(
				'sl_no' 		=> '4',
				'description' 	=> '48',
				'unit' 			=> '5',
				'qty' 			=> '6',
				'rate' 	        => '9',
				'dis'           => '8',
				'tax'           => '10',
				'amount' 		=> '10',
			);
		}

		//Sum the value
		$sumOfWidth = 0;
		$colW = array();

		foreach ($widthArray as $key => $val) {

			//Update value
			$colWidthSize[$key] = $val;

			//New Array => Reasssign % symbol
			$colW[$key] = $val . '%';

			//Sum of value
			$sumOfWidth += $val;
		}



		$tbl .= '<thead>
		        <tr class="bg-light-blue text-bold" style="width: 100%;">
			        <th colspan="1" style="text-align:center;width: ' . $colW['sl_no'] . '">#</th>
			        <th colspan="1" class="text-center" style="width: ' . $colW['description'] . '" >' . $this->CI->lang->line("description") . '</th>
			        <th colspan="1" class="text-center" style="width: ' . $colW['unit'] . '">Unit</th>
			        <th colspan="1" style="text-align:center;width: ' . $colW['qty'] . '">' . $this->CI->lang->line("qty") . '</th>
			        <th colspan="1" class="text-center" style="width: ' . $colW['rate'] . '">Rate</th>
					 <th colspan="1" class="text-center" style="width: ' . $colW['dis'] . '">Dis </th>
			        <th colspan="1" class="text-center" style="width: ' . $colW['tax'] . '"><nobr>Tax(5%)&nbsp;(<img src="'.base_url('uploads/logo-black.png').'" width="8" height="8" align="top">)</nobr></th>
			        <th colspan="1" class="text-right" style="width: ' . $colW['amount'] . '"><nobr>' . $this->CI->lang->line("amount") . '&nbsp;(<img src="'.base_url('uploads/logo-black.png').'" width="8" height="8" align="top">)</nobr></th>
		        </tr>
		    </thead>
		    <tbody>';

		$i = 1;
		$tot_qty = 0;
		$tot_sales_price = 0;
		$tot_tax_amt = 0;
		$tot_discount_amt = 0;
		$tot_unit_total_cost = 0;
		$tot_total_cost = 0;
		$tot_before_tax = 0;

		$tot_price_per_unit = 0;
		$sum_of_tot_price = 0;
		$sub_total = 0;



		$this->CI->db->select(" a.description,c.item_name,c.item_code, a.sales_qty,a.tax_type,
                                  a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
                                  a.discount_input,a.discount_amt, a.unit_total_cost,
                                  a.total_cost, d.unit_name,c.sku,c.hsn
                              ");
		$this->CI->db->where("a.sales_id", $this->sales_id);
		$this->CI->db->from("db_salesitems a");
		$this->CI->db->join("db_tax b", "b.id=a.tax_id", "left");
		$this->CI->db->join("db_items c", "c.id=a.item_id", "left");
		$this->CI->db->join("db_units d", "d.id = c.unit_id", "left");

		$q2 = $this->CI->db->get();

		//   print_r(count($q2));
		//   print_r($q2->result());

		foreach ($q2->result() as $res2) {
			// print_r($res2);
			$discount = (empty($res2->discount_input) || $res2->discount_input == 0) ? store_number_format(0) : store_number_format($res2->discount_input) . "%";
			$discount_amt = (empty($res2->discount_amt) || $res2->discount_input == 0) ? '0' : $res2->discount_amt . "";
			$before_tax = $res2->price_per_unit; // * $res2->sales_qty;
			$tot_cost_before_tax = $res2->total_cost; //$before_tax * $res2->sales_qty;

			$tax_type = ($res2->tax_type == 'Exclusive') ? 'Exc.' : 'Inc.';
			$tbl .= '<tr style="" nobr="true" style="width: 100%;">';
			$tbl .= '<td colspan="1" style="text-align:center;width: ' . $colW['sl_no'] . ';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;">' . $i++ . '</td>';
			$tbl .= '<td colspan="1" style="width: ' . $colW['description'] . ';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;" >';
			$tbl .= '<nobr>' . $res2->item_name . '</nobr>';
			$tbl .= (!empty($res2->description)) ? "<br><i>[" . nl2br($res2->description) . "]</i>" : '';
			$tbl .= '</td>';
			$tbl .= '<td colspan="1" style="width: ' . $colW['unit'] . ';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;">' . $res2->unit_name . '</td>';

			$tbl .= '<td colspan="1" style="text-align:center;width: ' . $colW['qty'] . ';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;">' . format_qty($res2->sales_qty) . '</td>';

			$tbl .= '<td colspan="1" class="text-center" style="width: ' . $colW['rate'] . ';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;"><nobr>' . store_number_format($res2->price_per_unit) . '</nobr></td>';
			$tbl .= '<td colspan="1" class="text-center" style="width: ' . $colW['dis'] . ';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;"><nobr>' . store_number_format($res2->discount_amt) . '</nobr></td>';
			$tbl .= '<td colspan="1" class="text-center" style="width: ' . $colW['tax'] . ';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;">' . store_number_format($res2->tax_amt) . '</td>';
			$tbl .= '<td colspan="1" class="text-right" style="width: ' . $colW['amount'] . ';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;">' . (store_number_format($res2->total_cost)) . '</td>';

			$tbl .= '</tr>';

			$tot_qty += $res2->sales_qty;
			$tot_sales_price += $res2->price_per_unit;
			$tot_tax_amt += $res2->tax_amt;
			$tot_discount_amt += $res2->discount_amt;
			$tot_unit_total_cost += $res2->unit_total_cost;
			$tot_before_tax += $before_tax;
			$tot_total_cost += $tot_cost_before_tax;
			$sub_total += $res2->price_per_unit * $res2->sales_qty;
		}

		$mCount = count($q2->result());

		// Use one tall spacer row so only column lines appear in the blank area.
		if ($mCount < 25) {
			$blank_lines = str_repeat('<br/>', 25 - $mCount);
			$tbl .= '<tr nobr="true">';
			$tbl .= '<td style="width: ' . $colW['sl_no'] . ';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">' . $blank_lines . '</td>';
			$tbl .= '<td style="width: ' . $colW['description'] . ';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
			$tbl .= '<td style="width: ' . $colW['unit'] . ';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
			$tbl .= '<td style="width: ' . $colW['qty'] . ';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
			$tbl .= '<td style="width: ' . $colW['rate'] . ';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
			$tbl .= '<td style="width: ' . $colW['dis'] . ';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
			$tbl .= '<td style="width: ' . $colW['tax'] . ';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
			$tbl .= '<td style="width: ' . $colW['amount'] . ';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
			$tbl .= '</tr>';
		}

		$tbl .= '</tbody>
		    
		</table>
		';

		$tax_perchantage = round(store_number_format(($tot_tax_amt / $tot_total_cost) * 100));
		// POS stores the complete discount (item + invoice discount) in
		// tot_discount_to_all_amt, so adding item discounts again duplicates them.
		$invoice_discount_amt = (isset($sales->pos) && (int) $sales->pos === 1)
			? (float) $sales->tot_discount_to_all_amt
			: $tot_discount_amt + (isset($sales->tot_discount_to_all_amt) ? (float) $sales->tot_discount_to_all_amt : 0);
		$invoice_net_total = (float) $sales->grand_total;
		$change_return_amount = (float) get_change_return_amount($sales->id);


		$tbl .= '<div style="font-size:20px;line-height:20px;">&nbsp;</div>';
		$tbl .= '<table class="totals-table">';
		$tbl .= '<tbody>';

		$tbl .= '<tr>';

		$col_left = ($pageWidth < 160) ? 60 : 72;
		$col_right = 100 - $col_left;
		$col_r_left = $col_right * 0.6;
		$col_r_right = $col_right * 0.4;

		$tbl .= '<tr>';
		// Bank Details spans the subtotal, discount, VAT and optional change rows.
		$bank_details_rows = ($change_return_amount > 0) ? 4 : 3;
		$tbl .= '<td rowspan="'.$bank_details_rows.'" colspan="3" style="border:none;border-bottom:none;padding-top:20px;width:'.$col_left.'%;">';
		if(!empty($store->bank_details)){
			$tbl .= '<span style="font-size:12px;color:rgb(0, 0, 128);font-style:italic;font-weight:bold;">Bank Details:</span><br/>';
			$tbl .= '<span style="text-align:justify;font-size:11px;line-height:1.2;">' . nl2br($store->bank_details) . '</span>';
		}
		$tbl .= '</td>';

		// Row 1 Totals: SubTotal
		$tbl .= '<td class="text-left" style="height:22px; width: '.$col_r_left.'%; font-size:15px; border-bottom:0.5px solid #000000; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">SubTotal</td>';
		$tbl .= '<td style="height:22px; font-size:15px; width: '.$col_r_right.'%; border-bottom:0.5px solid #000000; border-left:0.5px solid #000000; border-right:0.5px solid #000000;" class="text-right">';
		$tbl .= store_number_format($sub_total);
		$tbl .= '</td>';
		$tbl .= '</tr>';

		// Row 2 Totals: Discount
		$tbl .= '<tr>';
		$tbl .= '<td class="text-left" style="height:22px; width: '.$col_r_left.'%; font-size:15px; border-bottom:0.5px solid #000000; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">Discount</td>';
		$tbl .= '<td class="text-right" style="height:22px; font-size:15px; width: '.$col_r_right.'%; border-bottom:0.5px solid #000000; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">';
		$tbl .= store_number_format($invoice_discount_amt);
		$tbl .= '</td>';
		$tbl .= '</tr>';

		// Row 3 Totals: VAT
		$tbl .= '<tr>';
		$tbl .= '<td class="text-left" style="height:22px; width: '.$col_r_left.'%; font-size:15px; border-bottom:none; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">VAT (5%)</td>';
		$tbl .= '<td class="text-right" style="height:22px; font-size:15px; width: '.$col_r_right.'%; border-bottom:none; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">';
		$tbl .= store_number_format($tot_tax_amt);
		$tbl .= '</td>';
		$tbl .= '</tr>';

		if($change_return_amount > 0){
			$tbl .= '<tr>';
			$tbl .= '<td class="text-left" style="height:22px; width: '.$col_r_left.'%; font-size:15px; border-bottom:none; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">Change</td>';
			$tbl .= '<td class="text-right" style="height:22px; font-size:15px; width: '.$col_r_right.'%; border-bottom:none; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">';
			$tbl .= store_number_format($change_return_amount);
			$tbl .= '</td>';
			$tbl .= '</tr>';
		}

		// Final row: Amount in Words + Net Total
		$tbl .= '<tr>';
		$tbl .= '<td colspan="3" style="width:'.$col_left.'%;border-top:none;"><div style="font-size:12px;"><b>' . $this->CI->lang->line("amount_in_words") . ':</b> ';
		$tbl .= no_to_words($invoice_net_total);
		$tot_expl = explode('.', store_number_format($invoice_net_total));
		if (!empty($tot_expl[1])) {
			$tbl .= " and " . no_to_words($tot_expl[1]) . " Fills";
		}
		$tbl .= '</div>';
		$tbl .= '</td>';

		$tbl .= '<td class="text-left text-bold" style="width: '.$col_r_left.'%; height:24px; font-size:15px; border-top:none; border-bottom:0.5px solid #000000; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">Net Total</td>';
		$tbl .= '<td class="text-right text-bold" style="width: '.$col_r_right.'%; height:24px; font-size:15px; border-top:none; border-bottom:0.5px solid #000000; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">' . store_number_format($invoice_net_total) . '</td>';
		$tbl .= '</tr>';

		$tbl .= '</tbody>';
		$tbl .= '</table>';


		$tbl .= '<table cellpadding="8" class="signatures-table" nobr="true" style="width:100%;">
	            <tbody>';
	    
        $show_paid_img = false;
	    if(!empty($store->qr_image)){
	        $payment_query = $this->CI->db->from('db_salespayments')->where('sales_id', $sales->id)->order_by('id','desc')->get();
	        if ($payment_query->num_rows() > 0) {
	            $payment_row = $payment_query->first_row();
	            if (!empty($payment_row) && strtoupper($payment_row->payment_type) == 'CASH') {
	                $show_paid_img = true;
	            }
	        }
	    }
	    $signature_box_width = $show_paid_img ? '25%' : '33.3333%';
	    
	    $tbl .='<tr nobr="true">';
	    // Box 1: Receiver's Sign
	    $tbl .= '<td style="border:1px solid #333; text-align:center; font-weight:bold; font-size:11px; width:'.$signature_box_width.'; vertical-align:bottom;"><br><br><br><br><br>Receiver\'s Sign<br>___________________</td>';
	    
        // Box 2: Paid
        if ($show_paid_img) {
            $tbl .= '<td class="text-center" style="border:1px solid #333; width:'.$signature_box_width.'; vertical-align:middle;"><br><img src="'.base_url('uploads/paid.png').'" width="80" height="80"></td>';
        }

        // Box 3: QR Code
        if(!empty($store->qr_image)) {
            $tbl .= '<td class="text-center" style="border:1px solid #333; width:'.$signature_box_width.'; vertical-align:middle;"><br><img src="'.base_url($store->qr_image).'" width="80" height="80"></td>';
        } else {
            $tbl .= '<td style="border:1px solid #333; width:'.$signature_box_width.';"></td>';
        }

        // Box 4: Prepared By
        $tbl .= '<td style="border:1px solid #333; text-align:center; font-weight:bold; font-size:11px; width:'.$signature_box_width.'; vertical-align:bottom;"><br><br><br><br><br>Prepared By<br>___________________</td>';
        $tbl .= '</tr>';
	    
	    $tbl .='</tbody>
	        </table>';

	    $tbl .='<br/><br/>
	        <table border="0" nobr="true" style="border:none; width:100%;">
	            <tbody>
	                <tr nobr="true">
	                    <td style="border:none; text-align:center; font-weight:bold; font-size:11px;"><br/><br/>Return and Exchange Policy</td>
	                </tr>
	                <tr nobr="true">
	                    <td style="border:none; text-align:center; font-size:10px;">For Exchange/return of goods, the invoice is required and the goods should be in good condition.</td>
	                </tr>
	            </tbody>
	        </table>';
		return $this->writeHTML($tbl, true, false, true, true, 'j');
		//$this->IncludeJS("print(true);");
		//return $this->Output('invoice_100.pdf', 'I');
			//return $tbl;
	}

	public function _main_body()
	{	
		$sales 		= $this->sales;//array()
		$store 		= $this->store;//array()
		$customer 	= $this->customer;//array()
			
	

		$this->_invoice_name = "Tax Invoice";

		$this->page_title = "Tax Invoice";

		//Don't change this
		$this->_invoice_format = 'GST';

		//$this->_QRCODE = $sales->sales_code;

		// set font
		$this->setFont($this->get_font_name(), 'B', 20);

		// add a page
		$this->AddPage();
		
		
		//invoice title
		$this->_get_invoice_title_name();
		
		// Cusomer Details
		$this->_get_customer_details(); 

		// Cusomer Details
		$this->_get_invoice_details();

		// Shipping Details
		$this->_get_shipping_address(); 

		// Bank Details
		$this->_get_bank_details();
	
		//Set document name (footer -R)
		$this->_set_document_name('Printed on');
		
		//Sey document number (footer -R)
		$this->_set_document_number(date('d-m-Y h:i:s a'));

		//Search Coupon Details
		$coupon_code = $coupon_type = '';
	    $coupon_value=0;
	    if(!empty($sales->coupon_id)){
	      $coupon_details =get_customer_coupon_details($sales->coupon_id);
	      $coupon_code =$coupon_details->code;
	      $coupon_value =$coupon_details->value;
	      $coupon_type =$coupon_details->type;
	    } 
		$this->setFont($this->get_font_name(), '', 8);

		// set cell padding
		$this->setCellPaddings(1, 1, 1, 1);

		// set cell margins
		//$this->setCellMargins(1, 1, 1, 1);

		// set color for background
		$this->setFillColor(255, 255, 255);

		$this->Ln(0);

		

		$this->setFont($this->get_font_name(), '', 8);
		
		
		$tbl = '
		<style type="text/css">
			table {
			    border-collapse: collapse;
			}
			#print, .totals-table, .signatures-table {
			    border: 0.5px solid #000000;
			}
			th {
			    border: 0.5px solid #000000;
			}
			.totals-table td {
			    border: 0.5px solid #000000;
			}
			table + table, table + table tr:first-child th, table + table tr:first-child td {
			    border-top: 0;
			}
			.text-right{
				text-align: right;
			}
			.text-center{
				text-align: center;
			}
			.text-bold{
				font-weight: bold;
			}
			.bg-light-blue{
				background-color: #e4eaff;
			}
			#print tbody td {
				border-top: none;
				border-bottom: none;
			}
		</style>
		<table id="print" >';

		$pageWidth = $this->getPageWidth();
		if ($pageWidth < 160) {
			$widthArray = array(
				'sl_no' 		=> '4',
				'description' 	=> '45',
				'unit' 			=> '5',
				'qty' 			=> '5',
				'rate' 	        => '10',
				'dis'           => '8',
				'tax'           => '12',
				'amount' 		=> '11',
			);
		} else {
			$widthArray = array(
				'sl_no' 		=> '4',
				'description' 	=> '48',
				'unit' 			=> '5',
				'qty' 			=> '6',
				'rate' 	        => '9',
				'dis'           => '8',
				'tax'           => '10',
				'amount' 		=> '10',
			);
		}

			//Sum the value
			$sumOfWidth = 0;
			$colW =array();
			
			foreach($widthArray as $key => $val){
				
				//Update value
				$colWidthSize[$key] = $val;

				//New Array => Reasssign % symbol
				$colW[$key] = $val.'%';

				//Sum of value
				$sumOfWidth+=$val;
			}

			
			
		    $tbl .='<thead>
		        <tr class="bg-light-blue text-bold" style="width: 100%;">
			        <th colspan="1" style="text-align:center;width: '.$colW['sl_no'].'">#</th>
			        <th colspan="1" class="text-center" style="width: '.$colW['description'].'" >'.$this->CI->lang->line("description").'</th>
			        <th colspan="1" class="text-center" style="width: '.$colW['unit'].'">Unit</th>
			        <th colspan="1" style="text-align:center;width: '.$colW['qty'].'">'.$this->CI->lang->line("qty").'</th>
			        <th colspan="1" class="text-center" style="width: '.$colW['rate'].'">Rate</th>
					 <th colspan="1" class="text-center" style="width: '.$colW['dis'].'">Dis </th>
			        <th colspan="1" class="text-center" style="width: '.$colW['tax'].'"><nobr>Tax(5%)&nbsp;(<img src="'.base_url('uploads/logo-black.png').'" width="8" height="8" align="top">)</nobr></th>
			        <th colspan="1" class="text-right" style="width: '.$colW['amount'].'"><nobr>'.$this->CI->lang->line("amount").'&nbsp;(<img src="'.base_url('uploads/logo-black.png').'" width="8" height="8" align="top">)</nobr></th>
		        </tr>
		    </thead>
		    <tbody>';
		        
		      $i=1;
              $tot_qty=0;
              $tot_sales_price=0;
              $tot_tax_amt=0;
              $tot_discount_amt=0;
              $tot_unit_total_cost=0;
              $tot_total_cost=0;
              $tot_before_tax=0;
              
              $tot_price_per_unit=0;
              $sum_of_tot_price=0;
              $sub_total = 0;

          

              $this->CI->db->select(" a.description,c.item_name,c.item_code, a.sales_qty,a.tax_type,
                                  a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
                                  a.discount_input,a.discount_amt, a.unit_total_cost,
                                  a.total_cost, d.unit_name,c.sku,c.hsn
                              ");
              $this->CI->db->where("a.sales_id",$this->sales_id);
              $this->CI->db->from("db_salesitems a");
              $this->CI->db->join("db_tax b","b.id=a.tax_id","left");
              $this->CI->db->join("db_items c","c.id=a.item_id","left");
              $this->CI->db->join("db_units d","d.id = c.unit_id","left");

              $q2=$this->CI->db->get();
              
            //   print_r(count($q2));
            //   print_r($q2->result());

		        foreach ($q2->result() as $res2) {
		          // print_r($res2);
                  $discount = (empty($res2->discount_input)||$res2->discount_input==0)? store_number_format(0):store_number_format($res2->discount_input)."%";
                  $discount_amt = (empty($res2->discount_amt)||$res2->discount_input==0)? '0':$res2->discount_amt."";
                  $before_tax=$res2->price_per_unit;// * $res2->sales_qty;
                  $tot_cost_before_tax=$res2->total_cost;//$before_tax * $res2->sales_qty;

                 $tax_type = ($res2->tax_type=='Exclusive') ? 'Exc.' : 'Inc.';
                  $tbl .='<tr style="" nobr="true" style="width: 100%;">';
				      $tbl .='<td colspan="1" style="text-align:center;width: '.$colW['sl_no'].';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;">'.$i++.'</td>';
				      $tbl .= '<td colspan="1" style="width: '.$colW['description'].';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;" >';
				      $tbl .= '<nobr>' . $res2->item_name . '</nobr>';
				      $tbl .= (!empty($res2->description)) ? "<br><i>[".nl2br($res2->description)."]</i>" : '';
				      $tbl .= '</td>';
				      $tbl .='<td colspan="1" style="width: '.$colW['unit'].';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;">'.$res2->unit_name.'</td>';
				      
				      $tbl .='<td colspan="1" style="text-align:center;width: '.$colW['qty'].';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;">'.format_qty($res2->sales_qty).'</td>';

				      $tbl .='<td colspan="1" class="text-center" style="width: '.$colW['rate'].';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;"><nobr>'.store_number_format($res2->price_per_unit).'</nobr></td>';
				      $tbl .='<td colspan="1" class="text-center" style="width: '.$colW['dis'].';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;"><nobr>'.store_number_format($res2->discount_amt).'</nobr></td>';
				      $tbl .='<td colspan="1" class="text-center" style="width: '.$colW['tax'].';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;">'.store_number_format($res2->tax_amt).'</td>';
				      $tbl .='<td colspan="1" class="text-right" style="width: '.$colW['amount'].';font-size:12px;border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:none;">'.(store_number_format($res2->total_cost)).'</td>';
				      
		          $tbl .='</tr>';

                  $tot_qty +=$res2->sales_qty;
                  $tot_sales_price +=$res2->price_per_unit;
                  $tot_tax_amt +=$res2->tax_amt;
                  $tot_discount_amt +=$res2->discount_amt;
                  $tot_unit_total_cost +=$res2->unit_total_cost;
                  $tot_before_tax +=$before_tax;
                  $tot_total_cost +=$tot_cost_before_tax;
                  $sub_total += $res2->price_per_unit * $res2->sales_qty;
              }
              
              $mCount = count($q2->result());
              
            // Use one tall spacer row so only column lines appear in the blank area.
            if($mCount < 25){
				$blank_lines = str_repeat('<br/>', 25 - $mCount);
				$tbl .='<tr nobr="true">';
				$tbl .='<td style="width: '.$colW['sl_no'].';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">'.$blank_lines.'</td>';
				$tbl .='<td style="width: '.$colW['description'].';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
				$tbl .='<td style="width: '.$colW['unit'].';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
				$tbl .='<td style="width: '.$colW['qty'].';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
				$tbl .='<td style="width: '.$colW['rate'].';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
				$tbl .='<td style="width: '.$colW['dis'].';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
				$tbl .='<td style="width: '.$colW['tax'].';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
				$tbl .='<td style="width: '.$colW['amount'].';border-left:0.5px solid #000000;border-right:0.5px solid #000000;border-top:none;border-bottom:0.5px solid #000000;">&nbsp;</td>';
				$tbl .='</tr>';
            }

		    $tbl .='</tbody>
		    
		</table>
		';
		
		$tax_perchantage = round(store_number_format( ($tot_tax_amt / $tot_total_cost) * 100)) ;
		// POS stores the complete discount (item + invoice discount) in
		// tot_discount_to_all_amt, so adding item discounts again duplicates them.
		$invoice_discount_amt = (isset($sales->pos) && (int) $sales->pos === 1)
			? (float) $sales->tot_discount_to_all_amt
			: $tot_discount_amt + (isset($sales->tot_discount_to_all_amt) ? (float) $sales->tot_discount_to_all_amt : 0);
		$invoice_net_total = (float) $sales->grand_total;
		$change_return_amount = (float) get_change_return_amount($sales->id);
		
		
		$tbl .= '<div style="font-size:20px;line-height:20px;">&nbsp;</div>';
		$tbl .= '<table class="totals-table">';
		$tbl .= '<tbody>';
		
		$col_left = ($pageWidth < 160) ? 60 : 72;
		$col_right = 100 - $col_left;
		$col_r_left = $col_right * 0.6;
		$col_r_right = $col_right * 0.4;

		$tbl .= '<tr>';
		// Bank Details spans the subtotal, discount, VAT and optional change rows.
		$bank_details_rows = ($change_return_amount > 0) ? 4 : 3;
		$tbl .= '<td rowspan="'.$bank_details_rows.'" colspan="3" style="border:none;border-bottom:none;padding-top:20px;width:'.$col_left.'%;">';
		if(!empty($store->bank_details)){
			$tbl .= '<span style="font-size:12px;color:rgb(0, 0, 128);font-style:italic;font-weight:bold;">Bank Details:</span><br/>';
			$tbl .= '<span style="text-align:justify;font-size:11px;line-height:1.2;">' . nl2br($store->bank_details) . '</span>';
		}
		$tbl .= '</td>';

		// Row 1 Totals: SubTotal
		$tbl .= '<td class="text-left" style="height:22px; width: '.$col_r_left.'%; font-size:13px; border-bottom:0.5px solid #000000; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">SubTotal</td>';
		$tbl .= '<td style="height:22px; font-size:13px; width: '.$col_r_right.'%; border-bottom:0.5px solid #000000; border-left:0.5px solid #000000; border-right:0.5px solid #000000;" class="text-right">';
		$tbl .= store_number_format($sub_total);
		$tbl .= '</td>';
		$tbl .= '</tr>';

		// Row 2 Totals: Discount
		$tbl .= '<tr>';
		$tbl .= '<td class="text-left" style="height:22px; width: '.$col_r_left.'%; font-size:13px; border-bottom:0.5px solid #000000; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">Discount</td>';
		$tbl .= '<td class="text-right" style="height:22px; font-size:13px; width: '.$col_r_right.'%; border-bottom:0.5px solid #000000; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">';
		$tbl .= store_number_format($invoice_discount_amt);
		$tbl .= '</td>';
		$tbl .= '</tr>';

		// Row 3 Totals: VAT
		$tbl .= '<tr>';
		$tbl .= '<td class="text-left" style="height:22px; width: '.$col_r_left.'%; font-size:13px; border-bottom:none; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">VAT (5%)</td>';
		$tbl .= '<td class="text-right" style="height:22px; font-size:13px; width: '.$col_r_right.'%; border-bottom:none; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">';
		$tbl .= store_number_format($tot_tax_amt);
		$tbl .= '</td>';
		$tbl .= '</tr>';

		if($change_return_amount > 0){
			$tbl .= '<tr>';
			$tbl .= '<td class="text-left" style="height:22px; width: '.$col_r_left.'%; font-size:13px; border-bottom:none; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">Change</td>';
			$tbl .= '<td class="text-right" style="height:22px; font-size:13px; width: '.$col_r_right.'%; border-bottom:none; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">';
			$tbl .= store_number_format($change_return_amount);
			$tbl .= '</td>';
			$tbl .= '</tr>';
		}

		// Final row: Amount in Words + Net Total
		$tbl .= '<tr>';
		$tbl .= '<td colspan="3" style="width:'.$col_left.'%;border-top:none;"><div style="font-size:12px;"><b>'.$this->CI->lang->line("amount_in_words").':</b> ';
		$tbl .=no_to_words($invoice_net_total);
		$tot_expl = explode('.', store_number_format($invoice_net_total));
		if(!empty($tot_expl[1])){
			$tbl .= " and ". no_to_words($tot_expl[1]). " Fills";
		}
		$tbl .='</div>';
		$tbl .= '</td>';

		$tbl .= '<td class="text-left text-bold" style="width: '.$col_r_left.'%; height:24px; font-size:15px; border-top:none; border-bottom:0.5px solid #000000; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">Net Total</td>';
		$tbl .= '<td class="text-right text-bold" style="width: '.$col_r_right.'%; height:24px; font-size:15px; border-top:none; border-bottom:0.5px solid #000000; border-left:0.5px solid #000000; border-right:0.5px solid #000000;">' . store_number_format($invoice_net_total) . '</td>';
		$tbl .= '</tr>';

	$tbl .= '</tbody>';
	$tbl .= '</table>';

		
	$tbl .='<table cellpadding="8" class="signatures-table" nobr="true" style="width:100%;">
	            <tbody>';
	            
	    $show_paid_img = false;
	    if(!empty($store->qr_image)){
	        $payment_query = $this->CI->db->from('db_salespayments')->where('sales_id', $sales->id)->order_by('id','desc')->get();
	        if ($payment_query->num_rows() > 0) {
	            $payment_row = $payment_query->first_row();
	            if (!empty($payment_row) && strtoupper($payment_row->payment_type) == 'CASH') {
	                $show_paid_img = true;
	            }
	        }
	    }
	    $signature_box_width = $show_paid_img ? '25%' : '33.3333%';
	    
	    $tbl .='<tr nobr="true">';
	    // Box 1: Receiver's Sign
	    $tbl .= '<td style="border:1px solid #333; text-align:center; font-weight:bold; font-size:11px; width:'.$signature_box_width.'; vertical-align:bottom;"><br><br><br><br><br>Receiver\'s Sign<br>___________________</td>';
	    
        // Box 2: Paid
        if ($show_paid_img) {
            $tbl .= '<td class="text-center" style="border:1px solid #333; width:'.$signature_box_width.'; vertical-align:middle;"><br><img src="'.base_url('uploads/paid.png').'" width="80" height="80"></td>';
        }

        // Box 3: QR Code
        if(!empty($store->qr_image)) {
            $tbl .= '<td class="text-center" style="border:1px solid #333; width:'.$signature_box_width.'; vertical-align:middle;"><br><img src="'.base_url($store->qr_image).'" width="80" height="80"></td>';
        } else {
            $tbl .= '<td style="border:1px solid #333; width:'.$signature_box_width.';"></td>';
        }

        // Box 4: Prepared By
        $tbl .= '<td style="border:1px solid #333; text-align:center; font-weight:bold; font-size:11px; width:'.$signature_box_width.'; vertical-align:bottom;"><br><br><br><br><br>Prepared By<br>___________________</td>';
        $tbl .= '</tr>';
	    
	    $tbl .='</tbody>
	        </table>';

	    $tbl .='<br/><br/>
	        <table border="0" nobr="true" style="border:none; width:100%;">
	            <tbody>
	                <tr nobr="true">
	                    <td style="border:none; text-align:center; font-weight:bold; font-size:11px;"><br/><br/>Return and Exchange Policy</td>
	                </tr>
	                <tr nobr="true">
	                    <td style="border:none; text-align:center; font-size:10px;">For Exchange/return of goods, the invoice is required and the goods should be in good condition.</td>
	                </tr>
	            </tbody>
	        </table>';
		// above tr
	// 	<tr style="display:none;" nobr="true">
	// 	<td colspan="18" class="text-center">';
	// 			$tbl .=nl2br($store->sales_invoice_footer_text);
	// 			$tbl .='
	// 	</td>
	// </tr>
	// <tr style="display:none;" nobr="true">
	// 	<td colspan="18" class="text-center">';
	// 			$tbl .=nl2br($store->sales_invoice_footer_text);
	// 			$tbl .='
	// 	</td>
	// </tr>

	
// 		print_r($store);
// 		exit;

		    //    echo $tbl;exit;
		$this->writeHTMLCell('', '', $x ='', $y='', $tbl, 0, 1, 1, true, 'J', true);
		$this->IncludeJS("print(true);");
		$this->Output('invoice_100.pdf', 'I');
	}

}
