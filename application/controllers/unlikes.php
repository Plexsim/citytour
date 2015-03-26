<?php
require_once('permission.php');
class UnLikes extends Permission
{
	function __construct()
	{
		parent::__construct('likes');
	}
	
	function index()
	{
		$this->session->unset_userdata('searchterm');
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('unlikes/index');
		$pag['total_rows'] = $this->unlike->count_all();
		$data['unlikes'] = $this->unlike->get_all($pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('unlikes/view',$data,true);		
		$this->load->view('template',$content);
	}
}
?>