<?php
class JenisKerjaModel extends CI_Model {
	var $jenisKerja = "pekerjaan_jenis";

	public function __construct()
    {
		parent::__construct();
	}

	private function setData(){
    $this->id = $this->input->post('id');
		$this->name = $this->input->post('name');
		$this->kategori_id = $this->input->post('kategori_id');
  }

	private function getMaster($code, $key){
		$content = file_get_contents(base_url().'assets/master.json');
		$data = json_decode($content, true);
		foreach ($data[$code] as $ls) {
			if($ls['id'] == $key){
				return $ls['name'];
			}
		}
	}

  public function getAllData(){
		$this->db->select('*');
    $this->db->from($this->jenisKerja);
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row[] = $this->getMaster("kategori",$ls['kategori_id']);
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
      $this->db->set('kategori_id', $this->kategori_id);
      $this->db->set('name', $this->name);
      $this->db->where('id', $this->id);
      return $this->db->update($this->jenisKerja);
    }else{
			$this->db->set('kategori_id', $this->kategori_id);
      $this->db->set('name', $this->name);
      return $this->db->insert($this->jenisKerja);
    }
  }

  public function getDetailData($id){
    $this->db->select('*');
    $this->db->from($this->jenisKerja);
    $this->db->where('id', $id);
		$list = $this->db->get();
		if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row['kategori_text'] = $this->getMaster("kategori",$ls['kategori_id']);
    			$row['kategori_id'] = $ls['kategori_id'];
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

	public function dataCombo($filter){
		$this->db->select('id, name');
		$this->db->from($this->jenisKerja);
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
