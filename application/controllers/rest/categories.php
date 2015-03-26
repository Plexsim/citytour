<?php 
require_once(APPPATH.'/libraries/REST_Controller.php');

class Categories extends REST_Controller
{
	function get_get()
	{
		$data = null;
		
		$id = $this->get('id');

		if ($id) {
			$cat = $this->category->get_info($id);
			$cat->items = $this->get_items($cat->id);
			$data = $cat;
		} else {
			$cats = $this->category->get_only_publish()->result();
			foreach ($cats as $cat) {
				$cat->items = $this->get_items($cat->id);
			}
			$data = $cats;
		}
		
		$this->response($data);
	}
	
	function get_items($cat_id)
	{
		$all = $this->get('item');
		$count = $this->get('count');
		$from = $this->get('from');
		$keyword = "";
		if ($this->get('keyword')) {
			$keyword = $this->get('keyword');
		}
					
		if (!$all) {
			$items = $this->item->get_all_by_cat($cat_id, $keyword, 3)->result();
		} else {
			if ($count && $from) {
				$items = $this->item->get_all_by_cat($cat_id, $keyword, $count, $from)->result();
			} else if ($count) {
				$items = $this->item->get_all_by_cat($cat_id, $keyword, $count)->result();
			} else {
				$items = $this->item->get_all_by_cat($cat_id, $keyword)->result();
			}
		}
		
		$i = 0;
		foreach ($items as $item) {
			$items[$i]->images = $this->image->get_all_by_item($item->id)->result();
			$items[$i]->like_count = $this->like->count_all($item->id);
			$items[$i]->unlike_count = $this->unlike->count_all($item->id);
			$items[$i]->review_count = $this->review->count_all($item->id);
			$items[$i]->inquiries_count = $this->inquiry->count_all($item->id);
			$items[$i]->touches_count = $this->touch->count_all($item->id);
			
			$reviews = array();
			$j = 0;
			foreach ($this->review->get_all_by_item_id($item->id)->result() as $review) {
				$reviews[$j] = $review;
				$reviews[$j]->added = $this->ago($reviews[$j]->added);
				$appuser = $this->appuser->get_info($review->appuser_id);
				$reviews[$j]->appuser_name = $appuser->username;
				$reviews[$j++]->profile_photo = $appuser->profile_photo;
			}
			
			$items[$i++]->reviews = $reviews;
		}
		
		return $items;
	}
	
	function ago($time)
	{
		$time = mysql_to_unix($time);
		$now = mysql_to_unix($this->category->get_now());
		
	   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	   $lengths = array("60","60","24","7","4.35","12","10");
	
	   $difference     = $now - $time;
	   $tense         = "ago";
	
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