<?php

//Find total advance
function get_customer_tot_advance($customer_id){
	$CI =& get_instance();
	$tot_advance = $CI->db->select('coalesce(sum(amount),0) as tot_advance')
							->where('customer_id',$customer_id)
							->get('db_custadvance')->row()->tot_advance;
	//Find used advance in payment
	$advance_adjusted = $CI->db->select('coalesce(sum(advance_adjusted),0) as advance_adjusted')
							->where('customer_id',$customer_id)
							->get('db_salespayments')->row()->advance_adjusted;
	$tot_advance -= $advance_adjusted;
	return $tot_advance;
}

//Set total advance to customer
function set_customer_tot_advance($customer_id){
	$CI =& get_instance();
	$tot_advance = get_customer_tot_advance($customer_id);
	$q1 = $CI->db->set("tot_advance",$tot_advance)
					->where('id',$customer_id)
					->update("db_customers");
	if(!$q1){
		return flase;
	}
	return true;
}
//Find total advance
function get_salesman_tot_advance($salesman_id){
	$CI =& get_instance();
	$tot_advance = $CI->db->select('coalesce(sum(amount),0) as tot_advance')
							->where('salesman_id',$salesman_id)
							->get('db_salesmanadvance')->row()->tot_advance;
	//Find used advance in payment - Not applicable to salesmen
	$advance_adjusted = 0;
	$tot_advance -= $advance_adjusted;
	return $tot_advance;
}

//Set total advance to salesman
function set_salesman_tot_advance($salesman_id){
	$CI =& get_instance();
	$tot_advance = get_salesman_tot_advance($salesman_id);
	$q1 = $CI->db->set('tot_advance',$tot_advance)
					->where('id',$salesman_id)
					->update('db_salesman');
	if(!$q1){
		return false;
	}
	return true;
}
