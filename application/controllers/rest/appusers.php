<?php 
require_once(APPPATH.'/libraries/REST_Controller.php');

class Appusers extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('email',array(
       	'mailtype'  => 'html',
        	'newline'   => '\r\n'
		));
	}
	
	function login_post()
	{
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
			
		if (!array_key_exists('email', $data)) {
			$this->response(array('error' => array('message' => 'require_email')));
		}
		
		if (!array_key_exists('password', $data)) {
			$this->response(array('error' => array('message' => 'require_password')));
		}
		
		if ($user = $this->appuser->login($data['email'],$data['password'])) {
			$this->response($user);
		} else {
			$this->response(array('error' => array('message' => 'incorrect_login')));
		}
	}
	
	function reset_get()
	{
		$email = $this->get('email');
		if (!$email) {
			$this->response(array('error' => array('message' => 'require_email')));
		}
		
		$appuser = $this->appuser->get_info_by_email($email);
		if ($appuser->id == "") {
			$this->response(array('error' => array('message' => 'no_email_exist')));
		}
		
		$code = md5(time().'teamps');
		
		$data = array(
			'user_id'=>$appuser->id,
			'code'=> $code
		);
		
		if ($this->code->save($data,$appuser->id)) {
			$sender_email = $this->config->item('sender_email');
			$sender_name = $this->config->item('sender_name');
			$to = $appuser->email;
		   $subject = 'Password Reset';
			$html = "<p>Hi,".$appuser->username."</p>".
						"<p>Please click the following link to reset your password<br/>".
						"<a href='".site_url('reset/'.$code)."'>Reset Password</a></p>".
						"<p>Best Regards,<br/>".$sender_name."</p>";
						
			$this->email->from($sender_email,$sender_name);
			$this->email->to($to); 
			$this->email->subject($subject);
			$this->email->message($html);	
			$this->email->send();
			
			$this->response(array('success'=>'Password reset email already sent!'));
		} else {
			$this->response(array('error' => array('message' => 'db_error')));
		}
	}
	
	function add_post()
	{
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('username', $data)) {
			$this->response(array('error' => array('message' => 'require_username')));
		}
			
		if (!array_key_exists('email', $data)) {
			$this->response(array('error' => array('message' => 'require_email')));
		}
		
		if (!array_key_exists('password', $data)) {
			$this->response(array('error' => array('message' => 'require_password')));
		}
		
		$user_data = array(
			'username' => $data['username'],
			'password' => md5($data['password']),
			'email' => $data['email']
		);
		
		if ($this->appuser->exists($user_data)) {
			$this->response(array('error' => array('message' => 'email_exist')));
		} else {
			$this->appuser->save($user_data);
			$this->response(array('user_id'=>$user_data['id']));
		}
	}
	
	function update_put()
	{
		$id = $this->get('id');
		if (!$id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
		
		$data = $this->put();
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		$user_data = $data;
		$user_data['id'] = $id;
		if (array_key_exists('password',$data)) {
			$user_data['password'] = md5($data['password']);
		}
		
		if (array_key_exists('email',$data)) {
			if (strtolower($this->appuser->get_info($id)->email) != strtolower($user_data['email'])) {
				$cond = array('email'=>strtolower($user_data['email']));
				
				if ($this->appuser->exists($cond)) {
					$this->response(array('error' => array('message' => 'email_exist')));
				}
			}
		}
		
		$this->appuser->save($user_data,$id);
		$this->response(array('success'=>'User is successfully updated!'));
	}
}
?>