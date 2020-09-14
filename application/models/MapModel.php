<?php
class MapModel extends CI_Model {
	var $map = "map_support";

	public function __construct(){
		parent::__construct();
	}

  public function saving($file){
		$this->db->set('filename', $file);
		$this->db->insert($this->map);
		return $this->db->insert_id();
  }

	public function getData($id){
    $this->db->select('*');
    $this->db->from($this->map);
    $this->db->where('id', $id);
    return $this->db->get()->result_array();
  }

	public function deleteData($id){
		$return = $this->getData($id);
		if($return[0]['filename'] != ""){
			@unlink('assets/map/'.$return[0]['filename']);
		}
		$this->db->where('id', $id);
    return $this->db->delete($this->map);
  }
}
