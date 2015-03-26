<?php
require_once('permission.php');
class Likes extends Permission
{
	function __construct()
	{
		parent::__construct('likes');
	}
	
	function index()
	{
		$this->session->unset_userdata('searchterm');
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('likes/index');
		$pag['total_rows'] = $this->like->count_all();
		$data['likes'] = $this->like->get_all($pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('likes/view',$data,true);		
		$this->load->view('template',$content);
	}
}
?>