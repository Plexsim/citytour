<?php
require_once('permission.php');
class Categories extends Permission
{
	function __construct()
	{
		parent::__construct('categories');
	}
	
	//create
	function add()
	{
		$this->check_access('add');
	
		if ($this->input->server('REQUEST_METHOD')=='POST') {
			$category_data = array(
				'name' => $this->input->post('name'),
				'ordering' => $this->input->post('ordering')
			);
															
			if ($this->category->save($category_data)) {
				$this->session->set_flashdata('success','Category is successfully added.');
			} else {
				$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
			}
			redirect(site_url('categories'));
		}
		
		$content['content'] = $this->load->view('categories/add',array(),true);		
		$this->load->view('template',$content);
	}
	
	//retrieve
	function index()
	{
		$this->session->unset_userdata('searchterm');
	
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('categories/index');
		$pag['total_rows'] = $this->category->count_all();
		
		$data['categories'] = $this->category->get_all($pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		
		$content['content'] = $this->load->view('categories/view',$data,true);		
		$this->load->view('template',$content);
	}
	
	function search()
	{
		$search_term = $this->searchterm_handler($this->input->post('searchterm'));
		
		$pag = $this->config->item('pagination');
		
		$pag['base_url'] = site_url('categories/search');
		$pag['total_rows'] = $this->category->count_all_by(array('searchterm'=>$search_term));
		
		$data['searchterm'] = $search_term;
		$data['categories'] = $this->category->get_all_by(array('searchterm'=>$search_term),$pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		
		$content['content'] = $this->load->view('categories/search',$data,true);		
		$this->load->view('template',$content);
	}
	
	function searchterm_handler($searchterm)
	{
	    if ($searchterm) {
	        $this->session->set_userdata('searchterm', $searchterm);
	        return $searchterm;
	    } elseif ($this->session->userdata('searchterm')) {
	        $searchterm = $this->session->userdata('searchterm');
	        return $searchterm;
	    } else {
	        $searchterm ="";
	        return $searchterm;
	    }
	}
	
	//update
	function edit($category_id=0)
	{
		$this->check_access('edit');
	
		if ($this->input->server('REQUEST_METHOD')=='POST') {
			$category_data = array(
				'name' => $this->input->post('name'),
				'ordering' => $this->input->post('ordering')
			);
			
			if($this->category->save($category_data,$category_id)) {
				$this->session->set_flashdata('success','Category is successfully updated.');
			} else {
				$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
			}
			redirect(site_url('categories'));
		}
		
		$data['category'] = $this->category->get_info($category_id);
		
		$content['content'] = $this->load->view('categories/edit',$data,true);		
		$this->load->view('template',$content);
	}
	
	function publish($category_id = 0)
	{
		$this->check_access('publish');
		
		$category_data = array(
			'is_publish'=> 1
		);
			
		if ($this->category->save($category_data, $category_id)) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
	
	function unpublish($category_id = 0)
	{
		$this->check_access('publish');
		
		$category_data = array(
			'is_publish'=> 0
		);
		
		if ($this->category->save($category_data,$category_id)) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
	
	//delete
	function delete($category_id=0)
	{
		$this->check_access('delete');
		
		if($this->category->delete($category_id)) {
			$this->session->set_flashdata('success','The category is successfully deleted.');
		} else {
			$this->session->set_flashdata('error','Database error occured.Please contact your system administrator.');
		}
		redirect(site_url('categories'));
	}
	
	//delete
	function delete_items($category_id=0)
	{
		$this->check_access('delete');
		
		if ($this->category->delete($category_id)) {
			if ($this->item->delete_by_cat($category_id)) {
				$this->session->set_flashdata('success','The category is successfully deleted.');
			} else {
				$this->session->set_flashdata('error','Database error occured in items.Please contact your system administrator.');
			}
		} else {
			$this->session->set_flashdata('error','Database error occured in categories.Please contact your system administrator.');
		}
		redirect(site_url('categories'));
	}
	
	//is exist
	function exists($category_id=null)
	{
		$name = $_REQUEST['name'];
		
		if (strtolower($this->category->get_info($category_id)->name) == strtolower($name)) {
			echo "true";
		} else if ($this->category->exists(array('name'=>$_REQUEST['name']))) {
			echo "false";
		} else {
			echo "true";
		}
	}
}
?>