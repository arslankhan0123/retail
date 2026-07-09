<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {

  var $table = 'db_department';
  var $column_order = array('dptCode','dptName','dptDetails','status','store_id'); //set column field database for datatable orderable
  var $column_search = array('dptCode','dptName','dptDetails','status','store_id'); //set column field database for datatable searchable 
  var $order = array('dptid' => 'desc'); // default order 

private function _get_datatables_query()
  {
  $this->db->from($this->table);
    //if not admin
    //if(!is_admin()){
  $this->db->where("store_id",get_current_store_id());
    //}
  $i = 0;
  
  foreach($this->column_search as $item) // loop column 
    {
    if($_POST['search']['value']) // if datatable send POST for search
      {
      if($i===0) // first loop
        {
        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
        $this->db->like($item, $_POST['search']['value']);
        }
      else
        {
        $this->db->or_like($item, $_POST['search']['value']);
        }

      if(count($this->column_search) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
    $i++;
    }
    
  if(isset($_POST['order'])) // here order processing
    {
    $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } 
  else if(isset($this->order))
    {
    $order = $this->order;
    $this->db->order_by(key($order), $order[key($order)]);
    }
}

function get_datatables()
  {
  $this->_get_datatables_query();
  if($_POST['length'] != -1)
  $this->db->limit($_POST['length'], $_POST['start']);
  $query = $this->db->get();
  return $query->result();
}

function count_filtered()
  {
  $this->_get_datatables_query();
  $query = $this->db->get();
  return $query->num_rows();
}

public function count_all()
  {
  $this->db->where("store_id",get_current_store_id());
  $this->db->from($this->table);
  return $this->db->count_all_results();
}

public function verify_and_save()
  {
    //Filtering XSS and html escape from user inputs 
  extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));
    //Validate This category already exist or not
  $store_id=(store_module() && is_admin()) ? $store_id : get_current_store_id();
  $query=$this->db->query("select * from db_department where upper(dptName)=upper('$dptName') and store_id=$store_id");
  if($query->num_rows()>0)
    {
    return "This Department Name already Exist.";
    }
  else
    {
    $info = array(
      'count_id'   => get_count_id('db_department'), 
      'dptCode'    => get_init_code('category'), 
      'dptName'    => $dptName,
      'dptDetails' => $dptDetails,
      'status'     => 1,
              );
      
    $info['store_id']=(store_module() && is_admin()) ? $store_id : get_current_store_id();  

    $q1 = $this->db->insert('db_department', $info);
    if($q1)
      {
      $this->session->set_flashdata('success', 'Success!! New Category Added Successfully!');
      return "success";
      }
    else
      {
      return "failed";
      }
    }
}
  //Get category_details
public function get_details($id,$data)
  {
  //var_dump($id); exit();
    //Validate This category already exist or not
  $query = $this->db->query("select * from db_department where upper(dptid)=upper('$id')");
  //var_dump($query); exit();
  if($query->num_rows()==0)
    {
    show_404();exit;
    }
  else
    {
    $query = $query->row();
    $data['q_id'] = $query->dptid;
    $data['dptName'] = $query->dptName;
    $data['dptDetails'] = $query->dptDetails;
    $data['store_id'] = $query->store_id;
    return $data;
    }
}

public function update_department()
  {
    //Filtering XSS and html escape from user inputs 
  extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));
    //Validate This category already exist or not
  $store_id=(store_module() && is_admin()) ? $store_id : get_current_store_id();
  $query = $this->db->query("select * from db_department where upper(dptName)=upper('$dptName') and dptid<>$q_id and store_id=$store_id");
  if($query->num_rows()>0)
    {
    return "This Department Name already Exist.";
    }
  else
    {
    $info = array(
      'dptName'    => $dptName,
      'dptDetails' => $dptDetails,
              );
    $info['store_id']=(store_module() && is_admin()) ? $store_id : get_current_store_id();
    $q1 = $this->db->where('dptid',$q_id)->update('db_department', $info);
    if($q1)
      {
      $this->session->set_flashdata('success', 'Success!! Department Updated Successfully!');
      return "success";
      }
    else
      {
      return "failed";
      }
    }
}

public function update_status($id,$status)
  {
  if(set_status_of_table($id,$status,'db_category'))
    {
    echo "success";
    }
  else
    {
    echo "failed";
    }
}

public function delete_department_from_table($id)
  {
  //var_dump($id);
  $tot = $this->db->select('*')
                ->from('db_items')
                ->where('dptid',$id)
                ->get();
  //var_dump($tot->num_rows()); exit();
  if($tot->num_rows() > 0)
    {
    // foreach($tot->result() as $res)
    //   {
      $dptName =$tot->dptName;
      //}
    $list = implode (",",$dptName);
    echo "Sorry! Can't Delete,<br>Department Name {".$dptName."} already use in Items!";
    exit();
    }
  else
    {
    $this->db->where("dptid in ($id)");
      //if not admin
    if(!is_admin()){
      $this->db->where("store_id",get_current_store_id());
      }

    $query1 = $this->db->delete("db_department");
    if($query1)
      {
      echo "success";
      }
    else
      {
      echo "failed";
      } 
    }
}


}