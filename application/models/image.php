<?php 
class Image extends Citytour_Model
{
	protected $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = 'ct_images';
	}

	function exists($data)
	{
		$this->db->from($this->table_name);
		
		if (isset($data['id'])) {
			$this->db->where('id',$data['id']);
		}
		
		$query = $this->db->get();
		return ($query->num_rows()==1);
	}

	function save(&$data, $id=false)
	{
		if (!$id && !$this->exists(array('id'=>$id))) {
			if ($this->db->insert($this->table_name,$data)) {
				$data['id'] = $this->db->insert_id();
				return true;
			}
		} else {
			$this->db->where('id',$id);
			return $this->db->update($this->table_name,$data);
		}
		return false;
	}

	function get_all($limit=false,$offset=false)
	{
		$this->db->from($this->table_name);
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		
		return $this->db->get();
	}

	function get_all_by_item($item_id, $limit=false, $offset=false)
	{
		$this->db->from($this->table_name);
		$this->db->where('item_id',$item_id);
		if ($limit) {
			$this->db->limit($limit);
		}
		
		if ($offset) {
			$this->db->offset($offset);
		}
		
		return $this->db->get();
	}

	function get_info($id)
	{
		$query = $this->db->get_where($this->table_name,array('id'=>$id));
		
		if ($query->num_rows()==1) {
			return $query->row();
		} else {
			return $this->get_empty_object($this->table_name);
		}
	}

	function get_multiple_info($ids)
	{
		$this->db->from($this->table_name);
		$this->db->where_in($ids);
		return $this->db->get();
	}

	function count_all()
	{
		$this->db->from($this->table_name);
		return $this->db->count_all_results();
	}

	function count_all_by_item($item_id)
	{
		$this->db->from($this->table_name);
		$this->db->where('item_id',$item_id);
		return $this->db->count_all_results();
	}

	function delete($id)
	{
		$this->db->where('id',$id);
		return $this->db->delete($this->table_name);
 	}
 	
 	function get_all_by_type($parent_id, $type, $limit=false, $offset=false)
 	{
 		$this->db->from($this->table_name);
 		$this->db->where('item_id',$parent_id);
 		$this->db->where('type', $type);
 		
 		if ($limit) {
 			$this->db->limit($limit);
 		}
 		
 		if ($offset) {
 			$this->db->offset($offset);
 		}
 		
 		return $this->db->get();
 	}
 	
 	function delete_file($path)
 	{
 		$this->db->where('path',$path);
 		return $this->db->delete($this->table_name);
 	}

 	function get_info_by_path($path)
 	{
 		$query = $this->db->get_where($this->table_name,array('path'=>$path));
 		
 		if ($query->num_rows()==1) {
 			return $query->row();
 		} else {
 			return $this->get_empty_object($this->table_name);
 		}
 	}
}
?>