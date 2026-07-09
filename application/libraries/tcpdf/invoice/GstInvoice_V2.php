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

        $w = 147;
        $h = 25;
        
        $titleHTML = "";
        $titleHTML .= "<b>Customer</b><br/>";
        $titleHTML .= "<b>Mobile</b><br/>";
        $titleHTML .= "<b>Address</b><br/>";
        $titleHTML .= "<b>TRN</b>";
        
        
        
        //$this->setCellMargins(1,1,1,1);
        $this->setCellPaddings(2,1,1,1);
        $this->setFont($this->get_font_name(), '', 9);
        $this->setFillColor(255, 255, 255);

        $this->writeHTMLCell($w, $h, $x ='6', $y='70', $titleHTML, 1, 0, 1, true, 'J', true);
        
        
        $custmer_details = '<b>:</b> <span style="font-size:12px;font-weight:bold;"> '.$customer->customer_name."</span><br/>";

        if($customer->mobile){
        $custmer_details .= '<b>:</b> <span style="font-size:12px;">'.$customer->mobile."</span><br/>"; 
        }else if($customer->phone){
            $custmer_details .= '<b>:</b> <span style="font-size:12px;">'.$customer->phone."</span><br/>"; 
        }else{
            $custmer_details .= "<b>:</b> <br/>";
        }
        
        
        $custmer_details .= '<b>:</b><span style="font-size:12px;"> '.nl2br(substr($customer->address,0,56))."</span><br/>";
        
        $this->writeHTMLCell($w,6,$x = '90', $y = '82', substr($customer->address,56,300),0,0,0, true,'J', true);
        // print_r($customer_details);
        
        $custmer_details .= $customer->id!=2?"<b>:</b><span style='font-size:12px;'> $customer->tax_number </span><br/>": '<b>:</b><br/>';
        
        
        //$this->setCellMargins(1,1,1,1);
        $this->setCellPaddings(2,1,1,1);
        $this->setFont($this->get_font_name(), '', 9);
        $this->setFillColor(255, 255, 255);

        $this->writeHTMLCell($w, $h, $x ='23', $y='70', $custmer_details, [
            'R' => ['width' => 0.1, 'color' => [0,0,0]],
            'T' => ['width' => 0.1, 'color' => [0,0,0]],
            'B' => ['width' => 0.1, 'color' => [0,0,0]],
            ], 0, 0, true, 'J', true);
        
        return $this;
    } 

    public function _get_invoice_details()
    {
    	$sales = $this->sales;//array()
    	//print_r($sales);
    	$customer = $this->customer;
    // 	print_r($customer);
    	
        $w = 52;
        $h = 25;
        
        $payment = $this->CI->db->from('db_salespayments')
                            ->where('sales_id',$sales->id)->order_by('id','desc')
                            ->get()->first_row();
        
        $inv_type = "CREDIT";
        // print_r($payment->payment_type);
        if(!empty($payment)){
            $inv_type = $payment->payment_type;
        }
 
        $titleHTML = "";
        $titleHTML .= '<b>'.$this->CI->lang->line('invoice_no').'</b><br/>';
        
        $titleHTML .= '<b>Invoice Type</b><br/>';
        
        $titleHTML .= '<b>Invoice Date</b><br/>';
        
        $titleHTML .= '<b>'.$this->CI->lang->line('due_date').'</b><br/>';
        $titleHTML .= '<b>Reference</b>';
        

        $this->writeHTMLCell($w, $h, $x ='151', $y='', $titleHTML, [
            'R' => ['width' => 0.1,'color' => [0,0,0]],
            'T' => ['width' => 0.1,'color' => [0,0,0]],
            'B' => ['width' => 0.1,'color' => [0,0,0]],
            ], 1, 1, true, 'J', true);

        $invoice_details = "";
        $invoice_details .= '<b>:</b> <span style="font-size:12px;">'.$sales->sales_code.'</span><br/>';
        $invoice_details .= '<b>:</b> <span style="font-size:12px;">'.$inv_type.'</span><br/>';
        $invoice_details .= '<b>:</b> <span style="font-size:12px;">'.show_date($sales->sales_date).'</span><br/>';
        
        
        if($inv_type == 'CASH'){
			// $sales->due_date = $sales->sales_date;
			$sales->due_date = '';
        }
        
        $invoice_details .= '<b>:</b> <span style="">'.((!empty($sales->due_date)) ? show_date($sales->due_date):'').'</span><br/>';
        $invoice_details .= '<b>:</b> <span style="font-size:12px;">'.$sales->reference_no.'</span>';
        

        $this->writeHTMLCell(28, $h, $x ='173', $y='70', $invoice_details, [
            'R' => ['width' => 0.1,'color' => [0,0,0]],
            'T' => ['width' => 0.1,'color' => [0,0,0]],
            'B' => ['width' => 0.1,'color' => [0,0,0]],
            ], 1, 1, true, 'J', true);
            
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

        $custmer_details = '<span style="color:rgb(65, 59, 212);font-style:italic;">'.$this->CI->lang->line('shipping_address').'</span>';

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
        $invoice_details = '<span style="color:rgb(65, 59, 212);font-style:italic;">'.$this->CI->lang->line("bank_details").'</span><br>';
        $invoice_details .= nl2br($store->bank_details);

        $this->writeHTMLCell($w, $h, $x ='104', $y='', $invoice_details, 1, 1, 1, true, 'J', true);
        return $this;
    }
    
    
    public function _get_invoice_title_name()
    {

        $w = 198;
        $h = 15;
        
        $html = "";
        $html = "<div><span style='font-weight:bold;font-size:50px;'><b>TAX INVOICE</b></span><br/><span>TRN: 100457407300003</span></div>";
        
        $this->setCellMargins(1,1,1,1);
        $this->setCellPaddings(2,1,1,1);
        $this->setFont($this->get_font_name(), '', 15);
        $this->setFillColor(255, 255, 255);

        $this->writeHTMLCell($w, $h, $x ='6', $y='52', $html, 1, 0, 1, true, 'C', true);
        
        return $this;
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
		$this->_set_document_name($this->CI->lang->line("invoice_number"));

		//Sey document number (footer -R)
		$this->_set_document_number($sales->sales_code);

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
			table, td, th {
			    border-collapse: collapse;
			    border: 0.01px solid    #26066c  ;
			    
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
			
		</style>
		<table id="print" >';

		$widthArray = array(
			'sl_no' 		=> '5',
			'description' 	=> '40',
			'unit' 			=> '10',
			'qty' 			=> '10',
			'rate' 	        => '10',
			'dis'           => '5',
			'tax'           => '10',
			'amount' 		=> '10',
		);

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
			        <th colspan="1" class="text-center" style="width: ' . $colW['tax'] . '">Tax(5%)</th>
			        <th colspan="1" class="text-right" style="width: ' . $colW['amount'] . '">' . $this->CI->lang->line("amount") . '</th>
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
			$tbl .= '<td colspan="1" style="text-align:center;width: ' . $colW['sl_no'] . ';font-size:12px;">' . $i++ . '</td>';
			$tbl .= '<td colspan="1" style="width: ' . $colW['description'] . ';font-size:12px;" >';
			$tbl .= $res2->item_name;
			$tbl .= (!empty($res2->description)) ? "<br><i>[" . nl2br($res2->description) . "]</i>" : '';
			$tbl .= '</td>';
			$tbl .= '<td colspan="1" style="width: ' . $colW['unit'] . '">' . $res2->unit_name . '</td>';

			$tbl .= '<td colspan="1" style="text-align:center;width: ' . $colW['qty'] . ';font-size:12px;">' . format_qty($res2->sales_qty) . '</td>';

			$tbl .= '<td colspan="1" class="text-center" style="width: ' . $colW['rate'] . ';font-size:12px;">' . store_number_format($res2->price_per_unit) . '</td>';
			$tbl .= '<td colspan="1" class="text-center" style="width: ' . $colW['dis'] . ';font-size:12px;">' . store_number_format($res2->discount_amt) . '</td>';
			$tbl .= '<td colspan="1" class="text-center" style="width: ' . $colW['tax'] . ';font-size:12px;">' . store_number_format($res2->tax_amt) . '</td>';
			$tbl .= '<td colspan="1" class="text-right" style="width: ' . $colW['amount'] . ';font-size:12px;">' . (store_number_format($res2->total_cost)) . '</td>';

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

		if ($mCount < 25) {
			for ($i = $mCount; $i < 25; $i++) {
				$tbl .= '<tr style="" nobr="true" style="width: 100%;">';
				$tbl .= '<td colspan="1" style="text-align:center;width: ' . $colW['sl_no'] . ';font-size:12px;">' . ($i + 1) . '</td>';
				$tbl .= '<td colspan="1" style="width: ' . $colW['description'] . ';font-size:12px;border:none;border-right: 1px solid #000;" >';
				$tbl .= '</td>';
				$tbl .= '<td colspan="1" style="width: ' . $colW['unit'] . ';border:none;border-right: 1px solid #000;"></td>';
				$tbl .= '<td colspan="1" style="text-align:center;width: ' . $colW['qty'] . ';font-size:12px;border:none;border-right: 1px solid #000;"></td>';
				$tbl .= '<td colspan="1" class="text-center" style="width: ' . $colW['rate'] . ';font-size:12px;border:none;border-right: 1px solid #000;"></td>';
				$tbl .= '<td colspan="1" class="text-center" style="width: ' . $colW['dis'] . ';font-size:12px;border:none;border-right: 1px solid #000;"></td>';
				$tbl .= '<td colspan="1" class="text-center" style="width: ' . $colW['tax'] . ';font-size:12px;border:none;border-right: 1px solid #000;"></td>';
				$tbl .= '<td colspan="1" class="text-right" style="width: ' . $colW['amount'] . ';font-size:12px;border:none;border-right: 1px solid #000;"></td>';

				$tbl .= '</tr>';
			}
		}

		$tbl .= '</tbody>
		    
		</table>
		';

		$tax_perchantage = round(store_number_format(($tot_tax_amt / $tot_total_cost) * 100));


		$tbl .= '<table>';
		$tbl .= '<tbody>';

		$tbl .= '<tr>';

		$tbl .= '<td colspan="3" style="border:none;padding-top:20px; text-align: justify; text-justify: inter-word;">';
		$tbl .= "<b>" . $this->CI->lang->line("termsAndConditions") . ":</b>";
		$tbl .= nl2br(html_entity_decode($sales->invoice_terms));
		$tbl .= '</td>';

		// 		$tbl .= "<td>";
		// 		$tbl .= "<b>Note</b>: " . $sales->sales_note;
		// 		$tbl .= "</td>";

		$tbl .= '<td style="border:none;">';


		$tbl .= '<table>
		            <tbody>';
		//Total Before Tax
		$tbl .= '<tr nobr="true">
		                	<td class="text-left" style="height:18px; width: 60%;">';
		$tbl .= "SubTotal";
		$tbl .= '</td>';
		$tbl .= '<td style="height:22px;;font-size:12px; width: 40%;" class="text-right">';
		$tbl .= store_number_format($sub_total);
		$tbl .= '</td>';
		$tbl .= '</tr>';

		//Tax Total
		$tbl .= '<tr nobr="true">
		                	<td class="text-left" style="height:22px; width: 60%;">';
		$tbl .= "Discount";
		$tbl .= '</td>';
		$tbl .= '<td  class="text-right" style="height:20px; font-size:12px; width: 40%;">';
		$tbl .= store_number_format($tot_discount_amt);
		$tbl .= '</td>';
		$tbl .= '</tr>';

		//Tax Total
		$tbl .= '<tr nobr="true">
		                <td class="text-left" style="height:22px; width: 60%;">';
		$tbl .= "Tax (5%)";
		$tbl .= '</td>';
		$tbl .= '<td class="text-right" style="height:18px; font-size:12px; width: 40%;">';
		$tbl .= store_number_format($tot_tax_amt);
		$tbl .= '</td>';
		$tbl .= '</tr>';

		//Coupon
		if (!empty($coupon_code)) {
			$tbl .= '<tr nobr="true">
			                	<td colspan="4" style="width:' . ($colWidthSize['sl_no'] + $colWidthSize['description'] + $colWidthSize['hsn'] + $colWidthSize['gst_rate'] + $colWidthSize['qty']) . '%">';
			$tbl .= "<b>" . $this->CI->lang->line("couponCode") . "</b>: " . getTruncatedCCNumber($coupon_code);
			$tbl .= '</td>

			                	<td colspan="3" class="text-right" style="width:' . ($colWidthSize['before_tax'] + $colWidthSize['discount']) . '%">';
			$tbl .= $this->CI->lang->line("couponDiscount") . ":";
			$tbl .= ($coupon_type == 'Percentage') ? $coupon_value . '%' : '[Fixed]';
			$tbl .= '</td>

			                	<td colspan="1" class="text-right" style="width:' . ($colWidthSize['amount']) . '%">';
			$tbl .= store_number_format($sales->coupon_amt);
			$tbl .= '</td>';
			$tbl .= '</tr>';
		}

		$tbl .= '<tr nobr="true">
		               	<td class="text-rightx" style="height:22px;width:60%;">';
		$tbl .= "Grand Total";
		$tbl .= '</td>';
		$tbl .= '<td class="text-right" style="height:18px; font-size:12px; width: 40%;">';
		$tbl .= store_number_format($tot_total_cost);
		$tbl .= '</td>';
		$tbl .= '</tr>';
		$tbl .= '</tbody>
		        </table>';

		$tbl .= '</td>';
		$tbl .= '</tr>';
		$tbl .= "<tr>";
		$tbl .= '<td colspan="3"><div style="font-size:12px;"><b>' . $this->CI->lang->line("amount_in_words") . ':</b> ';
		$tbl .= no_to_words($tot_total_cost);
		$tot_expl = explode('.', $tot_total_cost);
		if (!empty($tot_expl[1])) {
			$tbl .= " and " . no_to_words($tot_expl[1]) . " Fills";
		}
		$tbl .= '</div>
		                    </td>';

		$tbl .= '<td style="border-left:none;border-right:none;"><table>';
		// $tbl .= '<tr style="border:none;">';

		//     $tbl .= '<td class="text-left" style="border:none;" style="height:18px; width: 60%;">';
		//     $tbl .= 'Grand Total'; 
		//     $tbl .= '</td>';
		//     $tbl .= '<td class="text-right" style="height:18px;border:none;font-size:12px; width: 40%;">';
		//     $tbl .=store_number_format($tot_total_cost);
		//     $tbl .= '</td>';

		// $tbl .= '</tr>';
		$tbl .= '</table></td>';

		$tbl .= "</tr>";
		$tbl .= '</tbody>';
		$tbl .= '</table>';


		$tbl .= '<table nobr="true">
	            <tbody>
	                <tr nobr="true">
	                    <td colspan="2" style="border-right:none;"><div style="font-size:10px;border-right:none;"><span style="color:rgb(65, 59, 212);font-style:italic;">RECIEVER’S NAME:</span><br><br/>';
		$tbl .= '<hr width="150">';
		$tbl .= '</div>
                		</td>
                		<td colspan="4">';
		$tbl .= nl2br($store->bank_details);
		$tbl .= '
                		</td>
	                    <td colspan="2" style="border-left:none;vertical-align:bottom;text-align:center;min-height:60px;height:60px;"><div style="font-size:10px;"><span style="color:rgb(65, 59, 212);font-style:italic;vertical-align:bottom;"> SIGNATURE:</span><br/><br/> <hr width="120"></div>
	                    		</td>
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
		$this->_set_document_name($this->CI->lang->line("invoice_number"));
		
		//Sey document number (footer -R)
		$this->_set_document_number($sales->sales_code);

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
			table, td, th {
			    border-collapse: collapse;
			    border: 0.01px solid    #26066c  ;
			    
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
			
		</style>
		<table id="print" >';

			$widthArray = array(
				'sl_no' 		=> '5',
				'description' 	=> '40',
				'unit' 			=> '10',
				'qty' 			=> '10',
				'rate' 	        => '10',
				'dis'           => '5',
				'tax'           => '10',
				'amount' 		=> '10',
			);

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
			        <th colspan="1" class="text-center" style="width: '.$colW['tax'].'">Tax(5%)</th>
			        <th colspan="1" class="text-right" style="width: '.$colW['amount'].'">'.$this->CI->lang->line("amount").'</th>
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
				      $tbl .='<td colspan="1" style="text-align:center;width: '.$colW['sl_no'].';font-size:12px;">'.$i++.'</td>';
				      $tbl .='<td colspan="1" style="width: '.$colW['description'].';font-size:12px;" >';
				      $tbl .= $res2->item_name;
				      $tbl .= (!empty($res2->description)) ? "<br><i>[".nl2br($res2->description)."]</i>" : '';
				      $tbl .= '</td>';
				      $tbl .='<td colspan="1" style="width: '.$colW['unit'].'">'.$res2->unit_name.'</td>';
				      
				      $tbl .='<td colspan="1" style="text-align:center;width: '.$colW['qty'].';font-size:12px;">'.format_qty($res2->sales_qty).'</td>';

				      $tbl .='<td colspan="1" class="text-center" style="width: '.$colW['rate'].';font-size:12px;">'.store_number_format($res2->price_per_unit).'</td>';
				      $tbl .='<td colspan="1" class="text-center" style="width: '.$colW['dis'].';font-size:12px;">'.store_number_format($res2->discount_amt).'</td>';
				      $tbl .='<td colspan="1" class="text-center" style="width: '.$colW['tax'].';font-size:12px;">'.store_number_format($res2->tax_amt).'</td>';
				      $tbl .='<td colspan="1" class="text-right" style="width: '.$colW['amount'].';font-size:12px;">'.(store_number_format($res2->total_cost)).'</td>';
				      
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
              
            if($mCount < 25){
            for ($i = $mCount; $i < 25; $i++) {
                 $tbl .='<tr style="" nobr="true" style="width: 100%;">';
				      $tbl .='<td colspan="1" style="text-align:center;width: '.$colW['sl_no'].';font-size:12px;">'.($i+1).'</td>';
				      $tbl .='<td colspan="1" style="width: '.$colW['description'].';font-size:12px;border:none;border-right: 1px solid #000;" >';
				      $tbl .= '</td>';
				      $tbl .='<td colspan="1" style="width: '.$colW['unit'].';border:none;border-right: 1px solid #000;"></td>';
				      $tbl .='<td colspan="1" style="text-align:center;width: '.$colW['qty'].';font-size:12px;border:none;border-right: 1px solid #000;"></td>';
				      $tbl .='<td colspan="1" class="text-center" style="width: '.$colW['rate'].';font-size:12px;border:none;border-right: 1px solid #000;"></td>';
				      $tbl .='<td colspan="1" class="text-center" style="width: '.$colW['dis'].';font-size:12px;border:none;border-right: 1px solid #000;"></td>';
				      $tbl .='<td colspan="1" class="text-center" style="width: '.$colW['tax'].';font-size:12px;border:none;border-right: 1px solid #000;"></td>';
				      $tbl .='<td colspan="1" class="text-right" style="width: '.$colW['amount'].';font-size:12px;border:none;border-right: 1px solid #000;"></td>';
				      
		          $tbl .='</tr>';
            }
                
            }

		    $tbl .='</tbody>
		    
		</table>
		';
		
		$tax_perchantage = round(store_number_format( ($tot_tax_amt / $tot_total_cost) * 100)) ;
		
		
		$tbl .= '<table>';
		$tbl .= '<tbody>';
		
		$tbl .= '<tr>';
		
		$tbl .= '<td colspan="3" style="border:none;padding-top:20px; text-align: justify; text-justify: inter-word;">';
		$tbl .= "<b>" . $this->CI->lang->line("termsAndConditions") . ":</b>";
    	$tbl .=nl2br(html_entity_decode($sales->invoice_terms));
		$tbl .= '</td>';
		
// 		$tbl .= "<td>";
// 		$tbl .= "<b>Note</b>: " . $sales->sales_note;
// 		$tbl .= "</td>";
		
		$tbl .= '<td style="border:none;">';


		$tbl .='<table>
		            <tbody>';
		                //Total Before Tax
		                $tbl .='<tr nobr="true">
		                	<td class="text-left" style="height:18px; width: 60%;">';
		                	$tbl .= "SubTotal";
		                	$tbl .='</td>';
		                	$tbl .='<td style="height:22px;;font-size:12px; width: 40%;" class="text-right">';
		                	$tbl .=store_number_format($sub_total);
		                	$tbl .='</td>';
		                $tbl .='</tr>';

		                //Tax Total
		                $tbl .='<tr nobr="true">
		                	<td class="text-left" style="height:22px; width: 60%;">';
		                	$tbl .= "Discount";
		                	$tbl .='</td>';
		                	$tbl .='<td  class="text-right" style="height:20px; font-size:12px; width: 40%;">';
		                	$tbl .=store_number_format($tot_discount_amt);
		                	$tbl .='</td>';
		                $tbl .='</tr>';

		                //Tax Total
		                $tbl .='<tr nobr="true">
		                <td class="text-left" style="height:22px; width: 60%;">';
		                	$tbl .= "Tax (5%)";
		                	$tbl .='</td>';
		                	$tbl .='<td class="text-right" style="height:18px; font-size:12px; width: 40%;">';
		                	$tbl .= store_number_format($tot_tax_amt);
		                	$tbl .='</td>';
		                $tbl .='</tr>';

		                //Coupon
		                if(!empty($coupon_code)){
			                $tbl .='<tr nobr="true">
			                	<td colspan="4" style="width:'.($colWidthSize['sl_no']+$colWidthSize['description']+$colWidthSize['hsn']+$colWidthSize['gst_rate']+$colWidthSize['qty']).'%">';
			                	$tbl .="<b>".$this->CI->lang->line("couponCode")."</b>: ".getTruncatedCCNumber($coupon_code);
			                	$tbl .='</td>

			                	<td colspan="3" class="text-right" style="width:'.($colWidthSize['before_tax']+$colWidthSize['discount']).'%">';
			                	$tbl .=$this->CI->lang->line("couponDiscount").":";
			                	$tbl .=($coupon_type=='Percentage') ? $coupon_value .'%' : '[Fixed]' ;
			                	$tbl .='</td>

			                	<td colspan="1" class="text-right" style="width:'.($colWidthSize['amount']).'%">';
			                	$tbl .=store_number_format($sales->coupon_amt);
			                	$tbl .='</td>';
			                $tbl .='</tr>';
		            	}

		               $tbl .='<tr nobr="true">
		               	<td class="text-rightx" style="height:22px;width:60%;">';
		               	$tbl .= "Grand Total";
		               	$tbl .='</td>';
		               	$tbl .='<td class="text-right" style="height:18px; font-size:12px; width: 40%;">';
		               	$tbl .=store_number_format($tot_total_cost);
		               	$tbl .='</td>';
		               $tbl .='</tr>';
		            $tbl .='</tbody>
		        </table>';
		        
	$tbl .= '</td>';
	$tbl .= '</tr>';
	$tbl .= "<tr>";
	$tbl .= '<td colspan="3"><div style="font-size:12px;"><b>'.$this->CI->lang->line("amount_in_words").':</b> ';
		                        	$tbl .=no_to_words($tot_total_cost);
                            		$tot_expl = explode('.', $tot_total_cost);
                            		if(!empty($tot_expl[1])){
                            		    $tbl .= " and ". no_to_words($tot_expl[1]). " Fills";
                            		}
		                    		$tbl .='</div>
		                    </td>';
	
	$tbl .= '<td style="border-left:none;border-right:none;"><table>';
	   // $tbl .= '<tr style="border:none;">';
	
	   //     $tbl .= '<td class="text-left" style="border:none;" style="height:18px; width: 60%;">';
	   //     $tbl .= 'Grand Total'; 
	   //     $tbl .= '</td>';
	   //     $tbl .= '<td class="text-right" style="height:18px;border:none;font-size:12px; width: 40%;">';
	   //     $tbl .=store_number_format($tot_total_cost);
	   //     $tbl .= '</td>';
	    
	   // $tbl .= '</tr>';
    $tbl .='</table></td>';
    
	$tbl .= "</tr>";
	$tbl .= '</tbody>';
	$tbl .= '</table>';

		
	$tbl .='<table nobr="true">
	            <tbody>
	                <tr nobr="true">
	                    <td colspan="2" style="border-right:none;"><div style="font-size:10px;border-right:none;"><span style="color:rgb(65, 59, 212);font-style:italic;">RECIEVER’S NAME:</span><br><br/>';
	                            $tbl .= '<hr width="150">';
	                    		$tbl .='</div>
                		</td>
                		<td colspan="4">';
                		$tbl .=nl2br($store->bank_details);
                		$tbl .='
                		</td>
	                    <td colspan="2" style="border-left:none;vertical-align:bottom;text-align:center;min-height:60px;height:60px;"><div style="font-size:10px;"><span style="color:rgb(65, 59, 212);font-style:italic;vertical-align:bottom;"> SIGNATURE:</span><br/><br/> <hr width="120"></div>
	                    		</td>
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