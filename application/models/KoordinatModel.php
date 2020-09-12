<?php
class KoordinatModel extends CI_Model {
	var $koordinat = "ruas_jalan_koordinat";

	public function __construct()
    {
		parent::__construct();
	}

  public function saving(){
		$data = json_decode($this->input->post('body'), true);
		
		if(count($data)>0){
			foreach ($data as $key => $value) {
				$this->deleteData($value["hash"], $value["lat_data"]);

				$this->db->set('hash_data', $value["hash"]);
	      $this->db->set('latitude', $value["lat_data"]);
	      $this->db->set('longtitude', $value["long_data"]);
	    	$this->db->insert($this->koordinat);
			}
			return true;
		}else{
			return false;
		}
  }

	public function deleteData($id, $lat){
    $this->db->where('hash_data', $id);
    $this->db->where('latitude', $lat);
    return $this->db->delete($this->koordinat);
  }
}
