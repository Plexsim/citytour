<?php 
require APPPATH.'/libraries/REST_Controller.php';

class Images extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('uploader');
	}
	
	function upload_post()
	{
		$user_id = $this->get('userId');
		if (!$user_id) {
			$this->response(array('error' => array('message' => 'require_user_id')));
		}
		
		$file_type = $this->get('fileType');
		if (!$file_type) {
			$this->response(array('error' => array('message' => 'require_filetype')));
		}
		
		$upload_data = $this->uploader->upload($_FILES,$user_id,$file_type);
		
		$images = array();
		foreach ($upload_data as $upload) {
			$images[] = array(
								'filename'=>$upload['file_name'],
								'width'=>$upload['image_width'],
								'height'=>$upload['image_height']
							);
			
			$photo = "";
			if ($file_type == 'profile') {
				$photo = array('profile_photo' => $upload['file_name']);
			} else { 
				$photo = array('background_photo' => $upload['file_name']);
			}
				
			$this->appuser->save($photo,$user_id);
		}
		
		if (!isset($upload_data['error'])) {
			$this->response(array(
				'success'=>'successfully uploaded!',
				'images' => $images
			));
		} else {
			$this->response(array('error' => array('message' => 'error_in_uploading')));
		}
	}
}
?>