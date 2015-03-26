<?php 
class Role extends Citytour_model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_name($role_id)
	{
		$query = $this->db->get_where('roles',array('role_id'=>$role_id));
		
		if ($query->num_rows()==1) {
			$row = $query->row();
			return $row->role_desc;
		}
		
		return "Unknown Module";
	}

	function get_all()
	{
		return $this->db->get('roles');
	}
	
	function get_info_by_name($module_name)
	{
		$query = $this->db->get_where('roles',array('role_name'=>$role_name));
		
		if ($query->num_rows()==1) {
			return $query->row();
		} else {
			return $this->get_empty_object('roles');
		}
	}

	function get_allowed_accesses($role_id)
	{
		$query = $this->db->get_where('role_access',array('role_id'=>$role_id));
		$accesses = array();
		foreach ($query->result() as $access) {
			$accesses[] = $access->action_id;
		}
		
		return $accesses;
	}
}
?>