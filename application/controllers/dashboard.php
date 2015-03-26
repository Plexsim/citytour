<?php
require_once('permission.php');
class Dashboard extends Permission
{
	function __construct()
	{
		parent::__construct();
	}	
	
	function index()
	{
		$this->load->view('dashboard');
	}
	
	function profile()
	{
		$user_id = $this->user->get_logged_in_user_info()->user_id;
		$status = "";
		$message = "";
		
		if ($this->input->server('REQUEST_METHOD')=='POST') {
			$user_data = array(
				'user_name' => $this->input->post('user_name')
			);
							
			//If new user password exists,change password
			if ($this->input->post('user_password')!='') {
				$user_data['user_pass'] = md5($this->input->post('user_password'));
			}
			
			if ($this->user->update_profile($user_data,$user_id)) {
				$status = 'success';
				$message = 'User is successfully updated.';
			} else {
				$status = 'error';
				$message = 'Database error occured.Please contact your system administrator.';
			}
		}
		
		$data['user'] = $this->user->get_info($user_id);
		$data['status'] = $status;
		$data['message'] = $message;
		
		$content['content'] = $this->load->view('users/profile',$data,true);		
		$this->load->view('template',$content);
	}
	
	//is exist
	function exists($user_id=null)
	{
		$user_name = $_REQUEST['user_name'];
		
		if (strtolower($this->user->get_info($user_id)->user_name) == strtolower($user_name)) {
			echo "true";
		} else if($this->user->exists(array('user_name'=>$_REQUEST['user_name']))) {
			echo "false";
		} else {
			echo "true";
		}
	}
	
	function backup()
	{
		// Load the DB utility class
		$this->load->dbutil();
		
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup();
		
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download('citytour.zip', $backup);
	}
}
?>