<?php
require_once(APPPATH.'/libraries/REST_Controller.php');

class Items extends REST_Controller
{
	function get_get()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
	
		$item = $this->item->get_info($item_id);
		$item->images = $this->image->get_all_by_item($item_id)->result();
		$item->like_count = $this->like->count_all($item_id);
		$item->unlike_count = $this->unlike->count_all($item_id);
		$item->review_count = $this->review->count_all($item_id);
		$item->inquiries_count = $this->inquiry->count_all($item_id);
		$item->touches_count = $this->touch->count_all($item_id);
		
		$reviews = array();
		$j = 0;
		foreach ($this->review->get_all_by_item_id($item_id)->result() as $review) {
			$reviews[$j] = $review;
			$reviews[$j]->added = $this->ago($reviews[$j]->added);
			$appuser = $this->appuser->get_info($review->appuser_id);
			$reviews[$j]->appuser_name = $appuser->username;
			$reviews[$j++]->profile_photo = $appuser->profile_photo;
		}
		
		$item->reviews = $reviews;
		
		$this->response($item);
	}
	
	function reviews_count_get()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
	
		$count = $this->like->count_all($item_id);
			
		$this->response(array('count' => $count));
	}
	
	function inquiries_count_get()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
	
		$count = $this->inquiry->count_all($item_id);
			
		$this->response(array('count' => $count));
	}

	function likes_count_get()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}	
	
		$count = $this->like->count_all($item_id);
			
		$this->response(array('count' => $count));
	}
	
	function touches_count_get()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
	
		$count = $this->touch->count_all($item_id);
			
		$this->response(array('count' => $count));
	}
	
	function review_post()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
		
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('appuser_id',$data)) {
			$this->response(array('error' => array('message' => 'require_appuser_id')));
		}
			
		if (!array_key_exists('review',$data)) {
			$this->response(array('error' => array('message' => 'require_review')));
		}
		
		$data = array(
			'item_id' => $item_id,
			'appuser_id' => $data['appuser_id'],
			'review' => $data['review']
		);
		
		$this->review->save($data);
		$count = $this->review->count_all($item_id);
		$this->response(array(
			'success'=>'Review is saved successfully!',
			'total'	=>$count
		));
	}
	
	function inquiry_post()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
		
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('name', $data)) {
			$this->response(array('error' => array('message' => 'require_name')));
		}
			
		if (!array_key_exists('email', $data)) {
			$this->response(array('error' => array('message' => 'require_email')));
		}
		
		if (!array_key_exists('message', $data)) {
			$this->response(array('error' => array('message' => 'require_message')));
		}
		
		$data = array(
			'item_id' => $item_id,
			'name' => $data['name'],
			'email' => $data['email'],
			'message' => $data['message']
		);
		
		$this->inquiry->save($data);
		$this->response(array('success'=>'Inquiry is saved successfully!'));
	}
	
	function like_post()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
		
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('appuser_id', $data)) {
			$this->response(array('error' => array('message' => 'require_appuser_id')));
		}
		
		if ($this->like->exists(array('appuser_id' => $data['appuser_id'], 'item_id' => $item_id))) {
			$this->response(array('error' => array('message' => 'appuser_like_exist')));
		}
		
		$data = array(
			'item_id' => $item_id,
			'appuser_id' => $data['appuser_id']
		);
		
		$this->like->save($data);
		$count = $this->like->count_all($item_id);
		$this->response(array(
			'success'=>'Like is saved successfully!',
			'total'	=>$count)
		);
	}
	
	function unlike_post()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
		
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('appuser_id', $data)) {
			$this->response(array('error' => array('message' => 'require_appuser_id')));
		}
		
		if ($this->unlike->exists(array('appuser_id' => $data['appuser_id'], 'item_id' => $item_id))) {
			$this->response(array('error' => array('message' => 'appuser_like_exist')));
		}
		
		$data = array(
			'item_id' => $item_id,
			'appuser_id' => $data['appuser_id']
		);
		
		$this->unlike->save($data);
		$count = $this->unlike->count_all($item_id);
		$this->response(array(
			'success'=>'Unlike is saved successfully!',
			'total'	=>$count)
		);
	}

	function is_like_post()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
		
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('appuser_id', $data)) {
			$this->response(array('error' => array('message' => 'require_appuser_id')));
		}
		$count = $this->like->count_all($item_id);		
		if ($this->like->exists(array(
			'item_id' => $item_id,
			'appuser_id' => $data['appuser_id']))) {
			$this->response(array('status'=> 'yes','total'	=>$count));
		} else {
			$this->response(array('status'=> 'no','total'	=>$count));
		}
		
	}
	
	function is_unlike_post()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
		
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('appuser_id', $data)) {
			$this->response(array('error' => array('message' => 'require_appuser_id')));
		}
		$count = $this->unlike->count_all($item_id);			
		if ($this->unlike->exists(array(
			'item_id' => $item_id,
			'appuser_id' => $data['appuser_id']))) {
			$this->response(array('status'=> 'yes','total'	=>$count));
		} else {
			$this->response(array('status'=> 'no','total'	=>$count));
		}
		
	}
	
	function favourite_post()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
		
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('appuser_id', $data)) {
			$this->response(array('error' => array('message' => 'require_appuser_id')));
		}
		
		if ($this->favourite->exists(array('appuser_id' => $data['appuser_id'], 'item_id' => $item_id))) {
			$this->response(array('error' => array('message' => 'appuser_favourite_exist')));
		}
		
		$data = array(
			'item_id' => $item_id,
			'appuser_id' => $data['appuser_id']
		);
		
		$this->favourite->save($data);
		$count = $this->favourite->count_all($item_id);
		$this->response(array(
			'success'=>'Favourite is saved successfully!',
			'total'	=>$count)
		);
	}
	
	function is_favourite_post()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
		
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('appuser_id', $data)) {
			$this->response(array('error' => array('message' => 'require_appuser_id')));
		}
				
		if ($this->favourite->exists(array(
			'item_id' => $item_id,
			'appuser_id' => $data['appuser_id']))) {
			$this->response(array('status'=> 'yes'));
		} else {
			$this->response(array('status'=> 'no'));
		}
		
	}
	
	function user_favourites_get()
	{
		$user_id = $this->get('user_id');
		if (!$user_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
	
		$favourites = $this->favourite->get_by_user_id($user_id)->result();
		
		$data = array();
		foreach ($favourites as $favourite) {
			$this->get_favourite_detail($favourite);
			$data[] = $favourite;
		}
		$this->response($data);
	}
	
	function get_favourite_detail(&$favourite)
	{
		$item_id = $favourite->item_id;
		$item = $this->item->get_info($item_id);
		$item->cat_name = $this->category->get_cat_name_by_id($item->cat_id);
		$item->images = $this->image->get_all_by_item($item_id)->result();
		$item->like_count = $this->like->count_all($item_id);
		$item->unlike_count = $this->unlike->count_all($item_id);
		$item->review_count = $this->review->count_all($item_id);
		$item->inquiries_count = $this->inquiry->count_all($item_id);
		$item->touches_count = $this->touch->count_all($item_id);
		
		
		$reviews = array();
		$j = 0;
		foreach ($this->review->get_all_by_item_id($item_id)->result() as $review) {
			$reviews[$j] = $review;
			$reviews[$j]->added = $this->ago($reviews[$j]->added);
			$appuser = $this->appuser->get_info($review->appuser_id);
			$reviews[$j]->appuser_name = $appuser->username;
			$reviews[$j++]->profile_photo = $appuser->profile_photo;
		}
		
		$item->reviews = $reviews;
		$favourite->item = $item;
	}
	
	function popular_items_get()
	{
		$popularItems = $this->item->get_popular_items()->result();
		
		
		$data = array();
		foreach ($popularItems as $popular) {
			$this->get_popular_detail($popular);
			$data[] = $popular;
		}
		$this->response($data);
		
	}
	
	function get_popular_detail(&$popular)
	{
		$item_id = $popular->item_id;
		$item = $this->item->get_info($item_id);
		$item->cat_name = $this->category->get_cat_name_by_id($item->cat_id);
		$item->images = $this->image->get_all_by_item($item_id)->result();
		$item->like_count = $this->like->count_all($item_id);
		$item->unlike_count = $this->unlike->count_all($item_id);
		$item->review_count = $this->review->count_all($item_id);
		$item->inquiries_count = $this->inquiry->count_all($item_id);
		$item->touches_count = $this->touch->count_all($item_id);
		$item->popular_count = $popular->cnt;
		
		
		$reviews = array();
		$j = 0;
		foreach ($this->review->get_all_by_item_id($item_id)->result() as $review) {
			$reviews[$j] = $review;
			$reviews[$j]->added = $this->ago($reviews[$j]->added);
			$appuser = $this->appuser->get_info($review->appuser_id);
			$reviews[$j]->appuser_name = $appuser->username;
			$reviews[$j++]->profile_photo = $appuser->profile_photo;
		}
		
		$item->reviews = $reviews;
		$popular->item = $item;
	}
	
	function touch_post()
	{
		$item_id = $this->get('id');
		if (!$item_id) {
			$this->response(array('error' => array('message' => 'require_id')));
		}
		
		$data = $this->post();
		
		if ($data == null) {
			$this->response(array('error' => array('message' => 'invalid_json')));
		}
		
		if (!array_key_exists('appuser_id',$data)) {
			$this->response(array('error' => array('message' => 'require_appuser_id')));
		}
		
		$data = array(
			'item_id' => $item_id,
			'appuser_id' => $data['appuser_id']
		);
		
		$this->touch->save($data);
		$count = $this->touch->count_all($item_id);
		$this->response(array(
			'success'=>'Touch is saved successfully!',
			'total'	=>$count)
		);
	}
	
	function ago($time)
	{
		$time = mysql_to_unix($time);
		$now = mysql_to_unix($this->category->get_now());
		
	   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	   $lengths = array("60","60","24","7","4.35","12","10");
	
	   $difference = $now - $time;
	  	$tense = "ago";
	
	   for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
	       $difference /= $lengths[$j];
	   }
	
	   $difference = round($difference);
	
	   if ($difference != 1) {
	       $periods[$j].= "s";
	   }
	
	   if ($difference==0) {
	   		return "Just Now";
	   } else {
	   		return "$difference $periods[$j] ago";
	   }
	}
}
?>