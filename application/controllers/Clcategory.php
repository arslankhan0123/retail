<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clcategory extends MY_Controller {
public function __construct(){
  parent::__construct();
  $this->load_global();
  $this->load->model('Clcategory_model','department');
}

public function add()
  {
  //$this->permission_check('items_category_add');
  $data=$this->data;
  $data['page_title'] = 'Color';
  $this->load->view('colors', $data);
}

public function newcolor()
  {
  $this->form_validation->set_rules('cName', 'cName', 'trim|required');
  //var_dump($test);
  if($this->form_validation->run() == TRUE)
    {
    $result = $this->department->verify_and_save();
    echo $result;
    } 
  else 
    {
    echo "Please Enter Color name.";
    }
}

public function update($id)
  {
  //$this->belong_to('db_category',$id);
  //$this->permission_check('items_category_edit');
  $data = $this->data;
  //var_dump($data); exit();
  //$this->load->model('db_department');
  $result = $this->department->get_details($id,$data);
  //var_dump($result); exit();
  $data = array_merge($data,$result);
  $data['page_title'] = 'Color';
  $this->load->view('colors',$data);
}

public function update_color()
  {
  $this->form_validation->set_rules('cName', 'cName', 'trim|required');
  $this->form_validation->set_rules('q_id', '', 'trim|required');

  if($this->form_validation->run() == TRUE)
    {      
    //$this->load->model('department_model');
    $result = $this->department->update_color();
    echo $result;
    }
  else 
    {
    echo "Please Enter Color name.";
    }
}

public function view()
  {
  //$this->permission_check('items_category_view');
  $data = $this->data;
  $data['page_title'] = 'Color List';
  $this->load->view('color_view', $data);
}

public function ajax_list()
  {
  $list = $this->department->get_datatables();
    
  $data = array();
  $no = $_POST['start'];
  foreach ($list as $category)
    {
    $no++;
    $row = array();
    $row[] = '<input type="checkbox" name="checkbox[]" value='.$category->clid.' class="checkbox column_checkbox" >';
      
    $row[] = $category->clName;
    $row[] = $category->clDetaiils;

    if($category->status == 1)
      { 
      $str = "<span onclick='update_status(".$category->clid.",0)' id='span_".$category->clid."'  class='label label-success' style='cursor:pointer'>Active </span>";
      }
    else
      { 
      $str = "<span onclick='update_status(".$category->clid.",1)' id='span_".$category->clid."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
      }
    $row[] = $str;      
    $str2 = '<div class="btn-group" title="View Account">
        <a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
          <ul role="menu" class="dropdown-menu dropdown-light pull-right">';

            //if($this->permissions('items_category_edit'))
            $str2.='<li><a title="Edit Record ?" href="'.base_url().'Clcategory/update/'.$category->clid.'"><i class="fa fa-fw fa-edit text-blue"></i>Edit</a></li>';

            //if($this->permissions('items_category_delete'))
            $str2.='<li><a style="cursor:pointer" title="Delete Record ?" onclick="delete_color('.$category->clid.')"><i class="fa fa-fw fa-trash text-red"></i>Delete</a></li></ul></div>';      

    $row[] = $str2;
    $data[] = $row;
    }

  $output = array(
    "draw" => $_POST['draw'],
    "recordsTotal" => $this->department->count_all(),
    "recordsFiltered" => $this->department->count_filtered(),
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
    
  //$this->load->model('Department_model');
  $result = $this->department->update_status($id,$status);
  return $result;
}
  
public function delete_color()
  {
  //$this->permission_check_with_msg('items_category_delete');
  $id = $this->input->post('id');
  //$id = 3;
  return $this->department->delete_color_from_table($id);
}

public function multi_delete()
  {
  //$this->permission_check_with_msg('items_category_delete');
  $id = implode (",",$_POST['checkbox']);
  return $this->department->delete_color_from_table($id);
}
  //ITS FROM POP UP MODAL
public function add_color_modal()
  {
  $this->form_validation->set_rules('cName', 'cName', 'trim|required');
  if($this->form_validation->run() == TRUE)
    {
    $result = $this->department->verify_and_save();
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

