<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategory1_model extends CI_Model {

  var $table = 'db_subcategory1';
  var $column_order = array('scatCode','scatName','scatDetails','status','store_id'); //set column field database for datatable orderable
  var $column_search = array('scatCode','scatName','scatDetails','status','store_id'); //set column field database for datatable searchable 
  var $order = array('  scatid' => 'desc'); // default order 

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
  $query=$this->db->query("select * from db_subcategory1 where upper(scatName)=upper('$scatName') and store_id=$store_id");
  if($query->num_rows()>0)
    {
    return "This Sub Category Name already Exist.";
    }
  else
    {
    $info = array(
      'count_id'    => get_count_id('db_subcategory1'), 
      'dptid'       => $dptid,
      'catid'       => $catid,
      'scatCode'    => get_init_code('category'), 
      'scatName'    => $scatName,
      'scatDetails' => $scatDetails,
      'status'      => 1,
              );
      
    $info['store_id']=(store_module() && is_admin()) ? $store_id : get_current_store_id();  

    $q1 = $this->db->insert('db_subcategory1', $info);
    if($q1)
      {
      $this->session->set_flashdata('success', 'Success!! New Sub Category Added Successfully!');
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
    //Validate This category already exist or not
  $query = $this->db->select("*")
                  ->FROM('db_subcategory1')
                  ->where('scatid',$id)
                  ->get();
  if($query->num_rows()==0)
    {
    show_404();exit;
    }
  else
    {
    $query = $query->row();
    $data['q_id'] = $query->scatid;
    $data['dptid'] = $query->dptid;
    $data['catid'] = $query->catid;
    $data['scatName'] = $query->scatName;
    $data['scatDetails'] = $query->scatDetails;
    $data['store_id'] = $query->store_id;
    return $data;
    }
}

public function update_category()
  {
    //Filtering XSS and html escape from user inputs 
  extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));
    //Validate This category already exist or not
  $store_id=(store_module() && is_admin()) ? $store_id : get_current_store_id();
  $query = $this->db->query("select * from db_subcategory1 where upper(scatName)=upper('$scatName') and scatid<>$q_id and store_id=$store_id");
  if($query->num_rows()>0)
    {
    return "This Sub Category Name already Exist.";
    }
  else
    {
    $info = array(
      'dptid'       => $dptid,
      'catid'       => $catid,
      'scatName'    => $scatName,
      'scatDetails' => $scatDetails,
              );
    $info['store_id']=(store_module() && is_admin()) ? $store_id : get_current_store_id();
    $q1 = $this->db->where('scatid',$q_id)->update('db_subcategory1', $info);
    if($q1)
      {
      $this->session->set_flashdata('success', 'Success!! Sub Category Updated Successfully!');
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
  if(set_status_of_table($id,$status,'db_subcategory1'))
    {
    echo "success";
    }
  else
    {
    echo "failed";
    }
}

public function delete_categories_from_table($id)
  {
  $tot = $this->db->query('SELECT COUNT(*) AS tot,b.scatName FROM db_items a,`db_subcategory1` b WHERE b.scatid=a.`scatid` AND a.scatid IN ('.$id.') GROUP BY a.scatid');
    
  if($tot->num_rows() > 0)
    {
    foreach($tot->result() as $res)
      {
      $scatName[] =$res->scatName;
      }
    $list = implode (",",$scatName);
    echo "Sorry! Can't Delete,<br>Sub Category Name {".$list."} already use in Items!";
    exit();
    }
  else
    {
    $this->db->where("scatid in ($id)");
      //if not admin
    if(!is_admin()){
      $this->db->where("store_id",get_current_store_id());
      }

    $query1 = $this->db->delete("db_subcategory1");
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