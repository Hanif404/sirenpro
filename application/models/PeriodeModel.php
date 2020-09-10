<?php
class PeriodeModel extends CI_Model {
	var $periode = "periode";

	public function __construct()
    {
		parent::__construct();
	}

	private function setData(){
    $this->id = $this->input->post('id');
		$this->nama = $this->input->post('nama');
  }

  public function saving(){
    $this->setData();
    if($this->id != ""){
      $this->db->set('nama', $this->nama);
      $this->db->where('id', $this->id);
      $this->db->update($this->periode);
    }else{
      $this->db->set('nama', $this->nama);
      $this->db->insert($this->periode);
    }
  }

  public function getOneRecord($id){
    $this->db->select('*');
    $this->db->from($this->periode);
    $this->db->where('id', $id);
    $list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
      $data = array();

      foreach ($arraylist as $ls) {
        $row = array();

        $row['nama'] = $ls['nama'];
        $row['id'] = $ls['id'];
        $data[] = $row;
      }

      return json_encode($data);
    } else {
      return json_encode('');
    }
  }

  public function deleteRecord($id){
    $this->db->where('id', $id);
    $this->db->delete($this->periode);
  }

	public function dataCombo($filter){
		$this->db->select('id, nama');
		$this->db->from($this->periode);
		if(strlen($filter) > 0){
			$this->db->like('nama', $filter);
		}
		$this->db->order_by('id', 'asc');
		$list = $this->db->get();
		if($list->num_rows() > 0){
			$arraylist = $list->result_array();
			return json_encode($arraylist);
		} else {
			return json_encode('');
		}
	}
}
