<?php
class JenisKerjaModel extends CI_Model {
	var $jenisKerja = "pekerjaan_jenis";
	var $kategori = "kategori";

	public function __construct()
    {
		parent::__construct();
	}

	private function setData(){
    $this->id = $this->input->post('id');
		$this->name = $this->input->post('name');
		$this->penanganan_id = $this->input->post('kategori_id');
  }

  public function getAllData(){
		$this->db->select('jn.*, kg.name as jnsName');
    $this->db->from($this->jenisKerja.' jn');
    $this->db->join($this->kategori.' kg', 'jn.penanganan_id = kg.id and kg.jenis = 2');
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row[] = $ls['jnsName'];
    			$row[] = $ls['name'];
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
      $this->db->set('penanganan_id', $this->penanganan_id);
      $this->db->set('name', $this->name);
      $this->db->where('id', $this->id);
      return $this->db->update($this->jenisKerja);
    }else{
			$this->db->set('penanganan_id', $this->penanganan_id);
      $this->db->set('name', $this->name);
      return $this->db->insert($this->jenisKerja);
    }
  }

  public function getDetailData($id){
		$this->db->select('jn.*, kg.name as penanganan_text');
    $this->db->from($this->jenisKerja.' jn');
    $this->db->join($this->kategori.' kg', 'jn.penanganan_id = kg.id and kg.jenis = 2');
    $this->db->where('jn.id', $id);
		$list = $this->db->get();
		if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row['penanganan_text'] = $ls['penanganan_text'];
    			$row['penanganan_id'] = $ls['penanganan_id'];
    			$row['name'] = $ls['name'];
    			$row['id'] = $ls['id'];
					$data[] = $row;
			}
			return $data;
    }
  }

  public function deleteData($id){
    $this->db->where('id', $id);
    return $this->db->delete($this->jenisKerja);
  }

	public function dataCombo($filter, $val){
		$this->db->select('id, name');
		$this->db->from($this->jenisKerja);
		$this->db->where('penanganan_id', $val);
		if(strlen($filter) > 0){
			$this->db->like('name', $filter);
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
