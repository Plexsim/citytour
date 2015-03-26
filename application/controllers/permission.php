<?php
/**
 * @author fokhwar
 */
class Permission extends CI_Controller
{
	function __construct($module_name = null)
	{
		parent::__construct();
		//If user has no permission,kick off.
		if (!$this->user->is_logged_in()) {
			redirect(site_url('login'));
		}
		
		//If user has no permission  for this module,kick off.
		if (!$this->user->has_permission($module_name, $this->user->get_logged_in_user_info()->user_id)) {
			redirect(site_url('login'));
		}
		
		//load global data
		$logged_in_user_info = $this->user->get_logged_in_user_info();
		$data['allowed_modules'] = $this->module->get_allowed_modules($logged_in_user_info->user_id);
		$data['allowed_accesses'] = $this->role->get_allowed_accesses($logged_in_user_info->role_id);
		$data['user_info'] = $logged_in_user_info;
		$this->load->vars($data);
	}

	function check_access($action_id = null)
	{
		//If user has no permission,kick off.
		if (!$this->user->is_logged_in()) {
			redirect(site_url('login'));
		}
		
		//If user has no permission  for this module,kick off.
		if (!$this->user->has_access($action_id, $this->user->get_logged_in_user_info()->role_id)) {
			redirect(site_url('dashboard'));
		}
		
		return true;
	}
}
?>