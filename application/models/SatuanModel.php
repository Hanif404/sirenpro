<?php
class SatuanModel extends CI_Model {
	var $satuan_pekerjaan = "satuan_pekerjaan";

	public function __construct()
    {
		parent::__construct();
	}

	private function setData(){
    $this->id = $this->input->post('id_pekerjaan');
		$this->nama = $this->input->post('jenis_pekerjaan');
		$this->harga = $this->input->post('harga_pekerjaan');
		$this->satuan = $this->input->post('satuan_pekerjaan');
  }

  public function getAllData(){
		$this->db->select('*');
    $this->db->from($this->satuan_pekerjaan);
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row[] = $ls['nama'];
    			$row[] = $ls['harga'];
    			$row[] = $ls['satuan'];
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
      $this->db->set('nama', $this->nama);
      $this->db->set('harga', $this->harga);
      $this->db->set('satuan', $this->satuan);
      $this->db->where('id', $this->id);
      return $this->db->update($this->satuan_pekerjaan);
    }else{
			$this->db->set('nama', $this->nama);
      $this->db->set('harga', $this->harga);
      $this->db->set('satuan', $this->satuan);
      return $this->db->insert($this->satuan_pekerjaan);
    }
  }

  public function getDetailData($id){
    $this->db->select('*');
    $this->db->from($this->satuan_pekerjaan);
    $this->db->where('id', $id);
    return $this->db->get()->result();
  }

  public function deleteData($id){
    $this->db->where('id', $id);
    return $this->db->delete($this->satuan_pekerjaan);
  }
}
