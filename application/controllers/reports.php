<?php 
require_once('permission.php');
class Reports extends Permission
{
	function __construct()
	{
		parent::__construct('reports');
	}
	
	function index()
	{
		redirect('reports/analytic');
	}
	
	function analytic()
	{
		$cat_id = 0;
		$cat_name = "";
		if ($this->input->post('cat_id')) {
			$cat_id = $this->input->post('cat_id');
		}
		
		$data['cat_id'] = $cat_id;
		$items = $this->item->get_all_by_cat($cat_id)->result();
		$item_arr = array();
		foreach ($items as $item) {
			$item_arr[$item->name] = $this->touch->count_all($item->id);
		}
		
		$graph_arr = array();
		foreach ($item_arr as $name=>$count) {
			$graph_arr[] = "['".$name."',".$count."]";
		}
		
		arsort($item_arr);
		$pie_arr = array();
		$i = 0;
		foreach ($item_arr as $name=>$count) {
			if(($i++) < 5){
				$pie_arr[] = "['".$name."',".$count."]";
			}
		}
		
		$data['count'] = count($items);
		$data['cat_name'] = $this->category->get_cat_name_by_id($cat_id) . " Category";
		$data['graph_items'] = "[['Items','Touches'],".implode(',',$graph_arr)."]";
		$data['pie_items'] = "[['Items','Touches'],".implode(',',$pie_arr)."]";
		$content['content'] = $this->load->view('reports/analytic',$data,true);		
		$this->load->view('template',$content);
	}
}
?>