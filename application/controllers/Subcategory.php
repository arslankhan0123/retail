<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategory extends MY_Controller {
public function __construct(){
  parent::__construct();
  $this->load_global();
  $this->load->model('Subcategory_model','category');
}

public function add()
  {
  //$this->permission_check('items_category_add');
  $data=$this->data;
  $data['page_title'] = 'Sub Category';
  $this->load->view('subcategory', $data);
}

public function get_category_data()
  {
  $section = $this->db->select("*")->FROM('db_category');
  
  if($_POST['id'] == "" || $_POST['id'] == 3){
      
  }else{
      $section = $section->where('dptid',$_POST['id']);
  }
  
  $section = $section->get()->result();
  $someJSON = json_encode($section);
  echo $someJSON;
}

public function newcategory()
  {
  $this->form_validation->set_rules('dptid', 'dptid', 'trim|required');
  $this->form_validation->set_rules('catid', 'catid', 'trim|required');
  $this->form_validation->set_rules('scatName', 'scatName', 'trim|required');
  if($this->form_validation->run() == TRUE)
    {
    $result = $this->category->verify_and_save();
    echo $result;
    } 
  else 
    {
    echo "Please Enter Category name.";
    }
}

public function update($id)
  {
  //$this->belong_to('db_category',$id);
  //$this->permission_check('items_category_edit');
  $data = $this->data;

  $result = $this->category->get_details($id,$data);
  $data = array_merge($data,$result);
  $data['page_title'] = $this->lang->line('category');
  $this->load->view('subcategory',$data);
}

public function update_category()
  {
  $this->form_validation->set_rules('dptid', 'dptid', 'trim|required');
  $this->form_validation->set_rules('catid', 'catid', 'trim|required');
  $this->form_validation->set_rules('scatName', 'scatName', 'trim|required');
  $this->form_validation->set_rules('q_id', '', 'trim|required');

  if($this->form_validation->run() == TRUE)
    {
    $result = $this->category->update_category();
    echo $result;
    }
  else 
    {
    echo "Please Enter Category name.";
    }
}

public function view()
  {
  //$this->permission_check('items_category_view');
  $data = $this->data;
  $data['page_title'] = $this->lang->line('categories_list');
  $this->load->view('subcategory_list', $data);
}

public function ajax_list()
  {
  $list = $this->category->get_datatables();
    //var_dump($list); exit();
  $data = array();
  $no = $_POST['start'];
  foreach ($list as $category)
    {
    $dept = $this->db->select("dptName")->FROM('db_department')->where('dptid',$category->dptid)->get()->row();
    if($dept)
      {
      $dptName = $dept->dptName;
      }
    else
      {
      $dptName = '';
      }
    $cat = $this->db->select("category_name")->FROM('db_category')->where('id',$category->catid)->get()->row();
    if($cat)
      {
      $catName = $cat->category_name;
      }
    else
      {
      $catName = '';
      }
    $no++;
    $row = array();
    $row[] = '<input type="checkbox" name="checkbox[]" value='.$category->scatid.' class="checkbox column_checkbox" >';
      
    $row[] = $dptName;
    $row[] = $catName;
    $row[] = $category->scatName;
    $row[] = $category->scatDetails;

    if($category->status == 1)
      { 
      $str = "<span onclick='update_status(".$category->scatid.",0)' id='span_".$category->scatid."'  class='label label-success' style='cursor:pointer'>Active </span>";
      }
    else
      { 
      $str = "<span onclick='update_status(".$category->scatid.",1)' id='span_".$category->scatid."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
      }
    $row[] = $str;      
    $str2 = '<div class="btn-group" title="View Account">
        <a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
          <ul role="menu" class="dropdown-menu dropdown-light pull-right">';

            if($this->permissions('items_category_edit'))
            $str2.='<li><a title="Edit Record ?" href="'.base_url().'Subcategory/update/'.$category->scatid.'"><i class="fa fa-fw fa-edit text-blue"></i>Edit</a></li>';

            if($this->permissions('items_category_delete'))
            $str2.='<li><a style="cursor:pointer" title="Delete Record ?" onclick="delete_category('.$category->scatid.')"><i class="fa fa-fw fa-trash text-red"></i>Delete</a></li></ul></div>';      

    $row[] = $str2;
    $data[] = $row;
    }
    //var_dump($data); exit();
  $output = array(
    "draw" => $_POST['draw'],
    "recordsTotal" => $this->category->count_all(),
    "recordsFiltered" => $this->category->count_filtered(),
    "data" => $data,
        );
    //output to json format
  echo json_encode($output);
}

public function update_status()
  {
  //$this->permission_check_with_msg('items_category_edit');
  $id = $this->input->post('id');
  $status = $this->input->post('status');
    
  //$this->load->model('category_model');
  $result = $this->category->update_status($id,$status);
  return $result;
}
  
public function delete_category()
  {
  //$this->permission_check_with_msg('items_category_delete');
  $id = $this->input->post('q_id');
  return $this->category->delete_categories_from_table($id);
}

public function multi_delete()
  {
  //$this->permission_check_with_msg('items_category_delete');
  $id = implode (",",$_POST['checkbox']);
  return $this->category->delete_categories_from_table($id);
}
  //ITS FROM POP UP MODAL
public function add_category_modal()
  {
  $this->form_validation->set_rules('category', 'Category Name', 'trim|required');
  if($this->form_validation->run() == TRUE)
    {
    $result = $this->category->verify_and_save();
      //fetch latest item details
    $res = array();
    $query = $this->db->select("id,category_name")
                    ->where('store_id',get_current_store_id())
                    ->from('db_category')
                    ->order_by('id','desc')
                    ->limit(1)->get();
    $res['id'] = $query->row()->id;
    $res['category'] = $query->row()->category_name;
    $res['result'] = $result;
      
    echo json_encode($res);
    } 
  else 
    {
    echo "Please Fill Compulsory(* marked) Fields.";
    }
}
  //END

}

