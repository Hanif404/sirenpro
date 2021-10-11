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
		$this->type = $this->input->post('type');
		$this->penanganan_id = $this->input->post('kategori_id');
  }

  public function getAllData($type){ 
	$kg = $type == 1 ? 2 : 3;
		$this->db->select('jn.*, kg.name as jnsName');
    $this->db->from($this->jenisKerja.' jn');
    $this->db->join($this->kategori.' kg', 'jn.penanganan_id = kg.id and kg.jenis = '.$kg);
	$this->db->where('jn.type', $type);
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
      $this->db->set('type', $this->type);
      $this->db->where('id', $this->id);
      return $this->db->update($this->jenisKerja);
    }else{
			$this->db->set('penanganan_id', $this->penanganan_id);
      $this->db->set('name', $this->name);
	  $this->db->set('type', $this->type);
      return $this->db->insert($this->jenisKerja);
    }
  }

  public function getDetailData($id, $type){
	$kg = $type == 1 ? 2 : 3;
	$this->db->select('jn.*, kg.name as penanganan_text');
    $this->db->from($this->jenisKerja.' jn');
    $this->db->join($this->kategori.' kg', 'jn.penanganan_id = kg.id and kg.jenis = '.$kg);
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
		$isNK = false;
		$row = array();
		$this->db->select('id');
		$this->db->from($this->kategori);
		$this->db->where('jenis', 3);
		$this->db->where_in('nilai_kondisi', array(0,1));
		$getKategory = $this->db->get();
		if($getKategory->num_rows() > 0){
			$arraylist = $getKategory->result_array();
			
			foreach ($arraylist as $ls) {
				$row[] = $ls['id'];
			}

			if(in_array($val,$row)){
				$isNK = true;
			}
		}

		$this->db->select('id, name');
		$this->db->from($this->jenisKerja);
		if(strlen($filter) > 0){
			$this->db->like('name', $filter);
		}
		if($isNK){
			$this->db->where_in('penanganan_id', $row);
		}else{
			$this->db->where('penanganan_id', $val);
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
