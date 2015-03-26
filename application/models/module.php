<?php
class Module extends Citytour_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_name($module_id)
	{
		$query = $this->db->get_where('modules',array('module_id'=>$module_id));
		
		if ($query->num_rows()==1) {
			$row = $query->row();
			return $row->module_name;
		}
		
		return "Unknown Module";
	}

	function get_all()
	{
		return $this->db->get('modules');
	}
	
	function get_info_by_name($module_name)
	{
		$query = $this->db->get_where('modules',array('module_name'=>$module_name));
		
		if ($query->num_rows()==1) {
			return $query->row();
		} else {
			return $this->get_empty_object('modules');
		}
	}

	function get_allowed_modules($user_id)
	{
		$this->db->from('modules');
		$this->db->join('permissions','permissions.module_id=modules.module_id');
		$this->db->where('permissions.user_id',$user_id);
		$this->db->order_by('modules.ordering');
		return $this->db->get();
	}
}
?>
