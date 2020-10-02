<?php
class RawanModel extends CI_Model {
	var $rawan = "rawan_bencana";

	public function __construct()
    {
		parent::__construct();
	}

	private function setData(){
    $this->id = $this->input->post('id');
		$this->latitude = $this->input->post('latitude');
		$this->longtitude = $this->input->post('longtitude');
		$this->location = $this->input->post('location');
		$this->type = $this->input->post('jns_bencana');
  }

	public function dataBencana($val){
		$this->db->select('*');
    $this->db->from($this->rawan);
    $this->db->where('type', $val);
		return json_encode($this->db->get()->result_array());
	}

  public function getAllData(){
		$this->db->select('*');
    $this->db->from($this->rawan);
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row[] = $this->libBencana($ls['type']);
    			$row[] = $ls['latitude'] .", ". $ls['longtitude'];
    			$row[] = $ls['location'];
    			$row[] = $ls['id'];
					$data[] = $row;
			}

			return $data;
    } else {
      return '';
    }
	}

  public function saving(){
    $this->setData();
    if($this->id != ""){
      $this->db->set('type', $this->type);
      $this->db->set('latitude', $this->latitude);
      $this->db->set('longtitude', $this->longtitude);
      $this->db->set('location', $this->location);
      $this->db->where('id', $this->id);
      return $this->db->update($this->rawan);
    }else{
			$this->db->set('type', $this->type);
      $this->db->set('latitude', $this->latitude);
      $this->db->set('longtitude', $this->longtitude);
      $this->db->set('location', $this->location);
      return $this->db->insert($this->rawan);
    }
  }

  public function getDetailData($id){
    $this->db->select('*');
    $this->db->from($this->rawan);
    $this->db->where('id', $id);
    return $this->db->get()->result();
  }

  public function deleteData($id){
    $this->db->where('id', $id);
    return $this->db->delete($this->rawan);
  }

	private function libBencana($type){
		switch ($type) {
			case '1':
				return "Rawan Longsong";
				break;
			case '2':
				return "Rawan Banjir";
				break;
			case '3':
				return "Rawan Kecelakaan";
				break;
			default:
				return "";
				break;
		}
	}
}
