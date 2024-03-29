<?php
require_once('permission.php');
class Inquiries extends Permission
{
	function __construct()
	{
		parent::__construct('inquiries');
	}
	
	function index()
	{
		$this->session->unset_userdata('searchterm');
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('inquiries/index');
		$pag['total_rows'] = $this->inquiry->count_all();
		$data['inquiries'] = $this->inquiry->get_all($pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('inquiries/view',$data,true);		
		$this->load->view('template',$content);
	}
	
	function search()
	{
		$search_term = $this->searchterm_handler($this->input->post('searchterm'));
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('inquiries/search');
		$pag['total_rows'] = $this->inquiry->count_all_by(array('searchterm'=>$search_term));
		$data['searchterm'] = $search_term;
		$data['inquiries'] = $this->inquiry->get_all_by(
		array('searchterm'=>$search_term),$pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('inquiries/search',$data,true);		
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
	
	function detail($inquiry_id)
	{
		$data['inquiry'] = $this->inquiry->get_info($inquiry_id);
		$content['content'] = $this->load->view('inquiries/detail',$data,true);		
		$this->load->view('template',$content);
	}

	function delete($inquiry_id=0)
	{
		$this->check_access('delete');
		if ($this->inquiry->delete($inquiry_id)) {
			$this->session->set_flashdata('success','The inquiry is successfully deleted.');
		} else {
			$this->session->set_flashdata('error',
			'Database error occured.Please contact your system administrator.');
		}
		redirect(site_url('inquiries'));
	}
}
?>