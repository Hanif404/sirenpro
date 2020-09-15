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
			$this->deleteData($data['no_ruas']);
			foreach ($data['data'] as $key => $value) {
				$this->db->set('no_ruas', $data['no_ruas']);
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

	public function deleteData($id){
    $this->db->where('no_ruas', $id);
    return $this->db->delete($this->koordinat);
  }
}
