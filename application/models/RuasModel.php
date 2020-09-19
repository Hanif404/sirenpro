<?php
class RuasModel extends CI_Model {
	var $periode = "periode";
	var $ruas = "ruas_jalan";
	var $ruas_detail = "ruas_jalan_detail";
	var $ruas_koordinat = "ruas_jalan_koordinat";
	var $kategori = "kategori";
	var $view_sum = "view_sum_kategori";

	public function __construct()
    {
		parent::__construct();
	}

	private function setData(){
    $this->id = $this->input->post('id');
		$this->kode = $this->input->post('kode');
		$this->nama = $this->input->post('nama');
		$this->urutan = $this->input->post('urutan');
		$this->posisi = $this->input->post('posisi');
		$this->awal_km = $this->input->post('awal_km');
		$this->akhir_km = $this->input->post('akhir_km');
  }

  public function drawKoordinat($id){
		$this->db->select('rd.*, kg.name, kg.warna');
		$this->db->from($this->ruas_detail.' rd');
		$this->db->join($this->kategori.' kg', 'rd.kategori_id=kg.id');
		$this->db->where('no_ruas', $id);
		$list = $this->db->get();
		if($list->num_rows() > 0){
			$arraylist = $list->result_array();
      $data = array();

      foreach ($arraylist as $ls) {
        $koordinat = $this->listKoordinat($ls['hash_data']);

        if(count($koordinat) > 0){
          $feature = new stdClass();
          $properties = new stdClass();
          $geometry = new stdClass();

          $properties->color = $ls['warna'];
          $geometry->type = "LineString";
          $geometry->coordinates = $koordinat;

          $feature->type = "Feature";
          $feature->properties = $properties;
          $feature->geometry = $geometry;

          $data[]=$feature;
        }
      }

			return json_encode($data);
		} else {
			return json_encode([]);
		}
	}

  private function listKoordinat($value){
    $this->db->select('*');
    $this->db->from($this->ruas_koordinat);
    $this->db->where('hash_data', $value);
    $list = $this->db->get();
    if($list->num_rows() > 0){
			$arraylist = $list->result_array();
      $data = array();

      foreach ($arraylist as $ls) {
        $row = array();

        $row[0] = $ls['longtitude'];
        $row[1] = $ls['latitude'];

        $data[]=$row;
      }

      return $data;
    }else{
      return array();
    }
  }

  public function saving(){
    $this->setData();
    if($this->id != ""){
      $this->db->set('kode', $this->kode);
      $this->db->set('nama', $this->nama);
      $this->db->set('urutan', $this->urutan);
      $this->db->set('posisi', $this->posisi);
      $this->db->set('awal_km', $this->awal_km);
      $this->db->set('akhir_km', $this->akhir_km);
      $this->db->where('id', $this->id);
      $this->db->update($this->ruas);
    }else{
      $this->db->set('kode', $this->kode);
      $this->db->set('nama', $this->nama);
      $this->db->set('urutan', $this->urutan);
      $this->db->set('posisi', $this->posisi);
      $this->db->set('awal_km', $this->awal_km);
      $this->db->set('akhir_km', $this->akhir_km);
      $this->db->insert($this->ruas);
    }
  }

  public function getOneRecord($id){
    $this->db->select('*');
    $this->db->from($this->ruas);
    $this->db->where('no_ruas', $id);
    $list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result();
      return json_encode($arraylist);
    } else {
      return json_encode('');
    }
  }

	public function getOneRecordDetail($id){
    $this->db->select('*, kg.name');
    $this->db->from($this->ruas_detail.' rd');
    $this->db->join($this->kategori.' kg', 'rd.kategori_id=kg.id');
    $this->db->order_by('awal_km', 'asc');
    $this->db->where('no_ruas', $id);
    $list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row[] = $ls['panjang'];
    			$row[] = $ls['lebar'];
    			$row[] = $ls['luas'];
    			$row[] = $ls['awal_km'];
					$row[] = $ls['akhir_km'];
					$row[] = $ls['posisi'];
					$row[] = $ls['name'];
					$row[] = $ls['petugas_survey'];
					$row[] = $ls['tgl_survey'];

 					$arrKoordinat = $this->listKoordinat($ls['hash_data']);
					$lastArr = end($arrKoordinat);
					$row[] = json_encode(array('latitude'=>$lastArr[1], 'longtitude'=>$lastArr[0]));

				$data[] = $row;
			}

			return json_encode(['data'=>$data]);
    } else {
      return json_encode(['data'=>'']);
    }
  }

  public function deleteRecord($id){
    $this->db->where('id', $id);
    $this->db->delete($this->ruas);
  }

	public function dataCombo($filter, $id){
		$this->db->select('no_ruas as id, CONCAT(no_ruas, " :: ", nama_ruas) as nama');
		$this->db->from($this->ruas);
		$this->db->where('periode_id', $id);
		if(strlen($filter) > 0){
			$this->db->like('CONCAT(no_ruas, " :: ", nama_ruas)', $filter);
		}
		$this->db->order_by('no_ruas', 'asc');
		$list = $this->db->get();
		if($list->num_rows() > 0){
			$arraylist = $list->result_array();
			return json_encode($arraylist);
		} else {
			return json_encode('');
		}
	}

	public function dataComboKsp($filter, $region){
		$this->db->select('unit_kerja as id, unit_kerja as nama');
		$this->db->from($this->ruas);
		$this->db->group_by("unit_kerja");
		if(strlen($filter) > 0){
			$this->db->like('unit_kerja', $filter);
		}
		if(strlen($region) > 0){
			$this->db->where('lower(nama_kota)', $region);
		}
		$this->db->order_by('unit_kerja', 'asc');
		$list = $this->db->get();
		if($list->num_rows() > 0){
			$arraylist = $list->result_array();
			return json_encode($arraylist);
		} else {
			return json_encode('');
		}
	}

	public function dataKategori(){
    $this->db->select('*');
    $this->db->from($this->kategori);
		$this->db->order_by('id', 'asc');
    return json_encode($this->db->get()->result());
	}

	public function dataRekap(){
		$periode = $this->input->post('periode');
		$daerah = $this->input->post('daerah');
		$ksp = $this->input->post('ksp');

		$this->db->select('rj.nama_ruas, rj.nama_kota, rj.panjang, vsk.*');
    $this->db->from($this->ruas.' rj');
    $this->db->join($this->view_sum.' vsk', 'rj.no_ruas = vsk.no_ruas and rj.periode_id = vsk.periode_id');
		if($daerah != ""){
			$this->db->where('lower(nama_kota)', $daerah);
		}
		if($ksp != ""){
			$this->db->where('unit_kerja', $ksp);
		}
		if($periode != ""){
			$this->db->where('rj.periode_id', $periode);
		}
		return json_encode($this->db->get()->result_array());
	}
	public function dataRekapTotal(){
		$periode = $this->input->post('periode');

		$this->db->select('rj.nama_kota, sum(vsk.total_km_all) as total_all, sum(vsk.total_km_1) as total_1,sum(vsk.total_km_2) as total_2,sum(vsk.total_km_3) as total_3,sum(vsk.total_km_4) as total_4,sum(vsk.total_km_5) as total_5,sum(vsk.total_km_6) as total_6,sum(vsk.total_km_7) as total_7');
    $this->db->from($this->ruas.' rj');
    $this->db->join($this->view_sum.' vsk', 'rj.no_ruas = vsk.no_ruas and rj.periode_id = vsk.periode_id');
		if($periode != ""){
			$this->db->where('rj.periode_id', $periode);
		}
		$this->db->group_by('rj.nama_kota');
		return json_encode($this->db->get()->result_array());
	}
}
