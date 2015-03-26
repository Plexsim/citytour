<?php

require_once('permission.php');
class Favourites extends Permission
{
	function __construct()
	{
		parent::__construct('favourites');
	}
	
	function index()
	{
		$this->session->unset_userdata('searchterm');
		$pag = $this->config->item('pagination');
		$pag['base_url'] = site_url('favourites/index');
		$pag['total_rows'] = $this->favourite->count_all();
		$data['favourites'] = $this->favourite->get_all($pag['per_page'],$this->uri->segment(3));
		$data['pag'] = $pag;
		$content['content'] = $this->load->view('favourites/view',$data,true);		
		$this->load->view('template',$content);
	}
}

?>