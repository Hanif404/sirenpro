<?php
class KategoriModel extends CI_Model {
	var $kategori = "kategori";

	public function __construct()
    {
		parent::__construct();
	}

	private function setData(){
    $this->id = $this->input->post('id');
		$this->nama = $this->input->post('name');
		$this->warna = $this->input->post('warna');
		$this->jenis = $this->input->post('jenis');
  }

	public function dataCombo($filter, $type){
		$this->db->select('id, name');
		$this->db->from($this->kategori);
		if(strlen($filter) > 0){
			$this->db->like('nama', $filter);
		}
		$this->db->where('jenis', $type);
		$this->db->order_by('id', 'asc');
		$list = $this->db->get();
		if($list->num_rows() > 0){
			$arraylist = $list->result_array();
			return json_encode($arraylist);
		} else {
			return json_encode('');
		}
	}

  public function getAllData(){
		$this->db->select('*');
    $this->db->from($this->kategori);
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row[] = $ls['name'];
    			$row[] = $ls['warna'];
    			$row[] = $ls['jenis'] == 1 ? "Ruas Jalan" : "Penanganan";
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
      $this->db->set('name', $this->nama);
      $this->db->set('warna', $this->warna);
      $this->db->set('jenis', $this->jenis);
      $this->db->where('id', $this->id);
      return $this->db->update($this->kategori);
    }else{
			$this->db->set('name', $this->nama);
      $this->db->set('warna', $this->warna);
			$this->db->set('jenis', $this->jenis);
      return $this->db->insert($this->kategori);
    }
  }

  public function getDetailData($id){
    $this->db->select('*');
    $this->db->from($this->kategori);
    $this->db->where('id', $id);
    return $this->db->get()->result();
  }

  public function deleteData($id){
    $this->db->where('id', $id);
    return $this->db->delete($this->kategori);
  }
}
