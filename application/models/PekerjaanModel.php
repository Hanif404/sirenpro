<?php
class PekerjaanModel extends CI_Model {
	var $pekerjaan = "pekerjaan_harga";
	var $jenisKerja = "pekerjaan_jenis";
	var $kategori = "kategori";

	public function __construct()
    {
		parent::__construct();
	}

	private function setData(){
    $this->id = $this->input->post('id_pekerjaan');
		$this->jenis_id = $this->input->post('jenis_id');
		$this->harga = $this->input->post('harga');
		$this->satuan_id = $this->input->post('satuan_id');
  }

	public function getDataByJenis($id){
		$this->db->select('*');
    $this->db->from($this->pekerjaan);
    $this->db->where('jenis_id', $id);
		$list = $this->db->get();
		if($list->num_rows() > 0){
      $arraylist = $list->result_array();

			$data = array();
			$data['satuan_text'] = $this->getMaster("satuan",$arraylist[0]['satuan_id']);
			$data['satuan_id'] = $arraylist[0]['satuan_id'];
			$data['harga'] = $arraylist[0]['harga'];
			$data['harga_text'] = $this->currency_format($arraylist[0]['harga']) ." / ".$this->getMaster("satuan",$arraylist[0]['satuan_id']);
			return $data;
    }
	}

	function currency_format($angka){
  	$hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
  	return $hasil_rupiah;
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
		$this->db->select('pkj.*, jpk.name, jpk.penanganan_id, kg.name as penanganan_text');
    $this->db->from($this->pekerjaan.' pkj');
    $this->db->join($this->jenisKerja.' jpk', 'pkj.jenis_id = jpk.id');
		$this->db->join($this->kategori.' kg', 'jpk.penanganan_id = kg.id and kg.jenis = 2');
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row[] = $ls['penanganan_text'];
    			$row[] = $ls['name'];
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
      $this->db->where('id', $this->id);
      return $this->db->update($this->pekerjaan);
    }else{
			$this->db->set('jenis_id', $this->jenis_id);
			$this->db->set('harga', $this->harga);
			$this->db->set('satuan_id', $this->satuan_id);
      return $this->db->insert($this->pekerjaan);
    }
  }

  public function getDetailData($id){
		$this->db->select('pkj.*, jpk.name, jpk.penanganan_id, kg.name as penanganan_text');
    $this->db->from($this->pekerjaan.' pkj');
    $this->db->join($this->jenisKerja.' jpk', 'pkj.jenis_id = jpk.id');
		$this->db->join($this->kategori.' kg', 'jpk.penanganan_id = kg.id and kg.jenis = 2');
    $this->db->where('pkj.id', $id);
		$list = $this->db->get();
		if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
					$row['satuan_text'] = $this->getMaster("satuan",$ls['satuan_id']);
					$row['satuan_id'] = $ls['satuan_id'];
    			$row['penanganan_text'] = $ls['penanganan_text'];
    			$row['penanganan_id'] = $ls['penanganan_id'];
					$row['jenis_text'] = $ls['name'];
					$row['jenis_id'] = $ls['jenis_id'];
    			$row['harga'] = $ls['harga'];
    			$row['id'] = $ls['id'];
					$data[] = $row;
			}
			return $data;
    }
  }

  public function deleteData($id){
    $this->db->where('id', $id);
    return $this->db->delete($this->pekerjaan);
  }
}
