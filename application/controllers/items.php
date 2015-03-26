<?php
require_once('permission.php');
class Items extends Permission
{
	function __construct()
	{
		parent::__construct('items');
		$this->load->library('uploader');
	}
	
	//create
	function add()
	{
		$this->check_access('add');
		
		$action = "save";
		unset($_POST['save']);
		if ($this->input->post('gallery')) {
			$action = "gallery";
			unset($_POST['gallery']);
		}
		
		if ($this->input->server('REQUEST_METHOD')=='POST') {
			$item_data = $this->input->post();
			
			if ($this->item->save($item_data)) {			
				$this->session->set_flashdata('success','Item is successfully added.');
			} else {
				$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
			}
			
			if ($action == "gallery") {
				redirect(site_url('items/gallery/'.$item_data['id']));
			} else {
				redirect(site_url('items'));
			}
		}
		
		$content['content'] = $this->load->view('items/add',array(),true);
		$this->load->view('template',$content);
	}
	
	//retrieve
	function index()
	{
		$this->session->unset_userdata('searchterm');
		$this->session->unset_userdata('cat_id');
	
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('items/index');
		$pag['total_rows'] = $this->item->count_all();
		
		$data['items'] = $this->item->get_all($pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		
		$content['content'] = $this->load->view('items/view',$data,true);		
		$this->load->view('template',$content);
	}
	
	function search()
	{
		$search_term = $this->searchterm_handler(array(
																	"searchterm"=>$this->input->post('searchterm'),
																	"cat_id"=>$this->input->post('cat_id')
																));
		$data = $search_term;
		
		$pag = $this->config->item('pagination');
		
		$pag['base_url'] = site_url('items/search');
		$pag['total_rows'] = $this->item->count_all_by($search_term);
		
		$data['items'] = $this->item->get_all_by($search_term,$pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		
		$content['content'] = $this->load->view('items/search',$data,true);		
		$this->load->view('template',$content);
	}
	
	function searchterm_handler($searchterms = array())
	{
		$data = array();
		
		if ($this->input->server('REQUEST_METHOD')=='POST') {
			foreach ($searchterms as $name=>$term) {
				if ($term && trim($term) != " ") {
					$this->session->set_userdata($name,$term);
					$data[$name] = $term;
				} else {
					$this->session->unset_userdata($term);
					$data[$name] = "";
				}
			}
		} else {
			foreach ($searchterms as $name=>$term) {
				if ($this->session->userdata($name)) {
					$data[$name] = $this->session->userdata($name);
				} else { 
					$data[$name] = "";
				}
			}
		}
		return $data;
	}
	
	//update
	function edit($item_id=0)
	{
		$this->check_access('edit');
		
		if ($this->input->server('REQUEST_METHOD')=='POST') {
			if ($this->input->post('isOnHomePage')!= 1) {
				$_POST['isOnHomePage'] = 0;
			}
			
			if ($this->item->save($this->input->post(),$item_id)) {
				$this->session->set_flashdata('success','item is successfully updated.');
			} else {
				$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
			}
			redirect(site_url('items'));
		}
		
		$data['item'] = $this->item->get_info($item_id);
		
		$content['content'] = $this->load->view('items/edit',$data,true);		
		$this->load->view('template',$content);
	}
	
	//gallery
	function gallery($id)
	{
			session_start();
			$_SESSION['parent_id'] = $id;
			$_SESSION['type'] = 'item';
	    	$content['content'] = $this->load->view('items/gallery', array('id' => $id), true);
	    	$this->load->view('template',$content);
	}
	
	function upload($item_id=0)
	{
		$this->check_access('edit');
		
		$upload_data = $this->uploader->upload($_FILES);
		
		if (!isset($upload_data['error'])) {
			foreach ($upload_data as $upload) {
				$image = array(
								'item_id'=>$item_id,
								'path' => $upload['file_name'],
								'width'=>$upload['image_width'],
								'height'=>$upload['image_height']
							);
				$this->image->save($image);
			}
		} else {
			$data['error'] = $upload_data['error'];
		}
		
		$data['item'] = $this->item->get_info($item_id);
		
		$content['content'] = $this->load->view('items/edit',$data,true);		
		$this->load->view('template',$content);
	}
	
	function publish($id = 0)
	{
		$this->check_access('publish');
		
		$item_data = array(
			'is_publish'=> 1
		);
			
		if ($this->item->save($item_data,$id)) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
	
	function unpublish($id = 0)
	{
		$this->check_access('publish');
		
		$item_data = array(
			'is_publish'=> 0
		);
			
		if ($this->item->save($item_data,$id)) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
	
	//For Show/Hide from Home Page Category
	function showOnHome($id = 0)
	{
		$this->check_access('edit');
		
		$item_data = array(
			'isOnHomePage'=> 1
		);
			
		if ($this->item->save($item_data,$id)) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
	
	function hideOnHome($id = 0)
	{
		$this->check_access('edit');
		
		$item_data = array(
			'isOnHomePage'=> 0
		);
			
		if ($this->item->save($item_data,$id)) {
			echo 'true';
		} else {
			echo 'false';
		}
	}

	//delete
	function delete($item_id=0)
	{
		$this->check_access('delete');
		
		$images = $this->image->get_all_by_type($item_id, 'item');
		foreach ($images->result() as $image) {
			$this->image->delete($image->id);
			unlink('./uploads/'.$image->path);
		}
		
		if ($this->item->delete($item_id)) {
			$this->session->set_flashdata('success','The item is successfully deleted.');
		} else {
			$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
		}
		redirect(site_url('items'));
	}

	//delete image
	function delete_image($item_id,$image_id,$image_name)
	{
		$this->check_access('edit');
		
		if ($this->image->delete($image_id)) {
			unlink('./uploads/'.$image_name);
			$this->session->set_flashdata('success','The image is successfully deleted.');
		} else {
			$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
		}
		redirect(site_url('items/edit/'.$item_id));
	}
	
	//is exist
	function exists($item_id=null)
	{
		$name = $_REQUEST['name'];
		
		if (strtolower($this->item->get_info($item_id)->name) == strtolower($name)) {
			echo "true";
		} else if($this->item->exists(array('name'=>$_REQUEST['name']))) {
			echo "false";
		} else {
			echo "true";
		}
	}
}
?>