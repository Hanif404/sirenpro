<?php
class PekerjaanModel extends CI_Model {
	var $pekerjaan = "pekerjaan_harga";
	var $master = "master_data";

	public function __construct()
    {
		parent::__construct();
	}

	private function setData(){
    $this->id = $this->input->post('id');
		$this->jenis_id = $this->input->post('jenis_id');
		$this->harga = $this->input->post('harga');
		$this->satuan_id = $this->input->post('satuan_id');
		$this->kategori_id = $this->input->post('kategori_id');
  }

	public function dataCombo($code){
		$content = file_get_contents(base_url().'assets/master.json');
		$data = json_decode($content, true);
		return json_encode($data[$code]);
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
    $this->db->from($this->pekerjaan);
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row[] = $this->getMaster("kategori", $ls['kategori_id']);
    			$row[] = $ls['jenis_id'];
    			$row[] = $this->getMaster("satuan", $ls['satuan_id']);
    			$row[] = $ls['harga'];
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
      $this->db->set('jenis_id', $this->jenis_id);
      $this->db->set('harga', $this->harga);
      $this->db->set('satuan_id', $this->satuan_id);
      $this->db->set('kategori_id', $this->kategori_id);
      $this->db->where('id', $this->id);
      return $this->db->update($this->pekerjaan);
    }else{
			$this->db->set('jenis_id', $this->jenis_id);
			$this->db->set('harga', $this->harga);
			$this->db->set('satuan_id', $this->satuan_id);
			$this->db->set('kategori_id', $this->kategori_id);
      return $this->db->insert($this->pekerjaan);
    }
  }

  public function getDetailData($id){
    $this->db->select('*');
    $this->db->from($this->pekerjaan);
    $this->db->where('id', $id);
    return $this->db->get()->result();
  }

  public function deleteData($id){
    $this->db->where('id', $id);
    return $this->db->delete($this->pekerjaan);
  }
}
