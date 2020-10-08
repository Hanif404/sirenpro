<?php
class PenangananModel extends CI_Model {
	// var $penanganan = "view_penanganan";
	var $ruas_det = "ruas_jalan_detail";
	var $kategori = "kategori";
	var $penanganan = "pekerjaan_ruas";
	var $penangananHarga = "pekerjaan_harga";
	var $penangananJenis = "pekerjaan_jenis";

	public function __construct()
    {
		parent::__construct();
	}

	private function setData(){
    $this->id = $this->input->post('id');
		$this->jenis_id = $this->input->post('jenis_id');
		$this->harga = $this->input->post('harga');
		$this->volume = $this->input->post('volume');
		$this->hash = $this->input->post('hash');
  }

	public function dataComboKm($filter, $periode, $noruas){
		$this->db->distinct();
		$this->db->select('awal_km as id');
		$this->db->from($this->ruas_det);
		$this->db->where('periode_id', $periode);
		$this->db->where('no_ruas', $noruas);
		if(strlen($filter) > 0){
			$this->db->like('awal_km', $filter);
		}
		$this->db->order_by('awal_km', 'asc');
		$list = $this->db->get();
		if($list->num_rows() > 0){
			$arraylist = $list->result_array();
			return json_encode($arraylist);
		} else {
			return json_encode('');
		}
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

	public function getListDetail($hash){
		$this->db->select('pkj.*, hrg.satuan_id, jns.name');
    $this->db->from($this->penanganan. ' pkj');
		$this->db->join($this->penangananHarga.' hrg', 'pkj.jenis_id = hrg.jenis_id');
		$this->db->join($this->penangananJenis.' jns', 'hrg.jenis_id = jns.id');
		$this->db->where('hash', $hash);
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();
			$hash_data = base64_decode($hash);
			$lshash = explode("~", $hash_data);

			foreach ($arraylist as $ls) {
					$row = array();
    			$row[] = $ls['name'];
    			$row[] = $lshash[5];
					$row[] = $ls['volume'];
    			$row[] = $this->currency_format($ls['harga']).'/'.$this->getMaster("satuan",$ls['satuan_id']);
    			$row[] = $this->currency_format($ls['harga']*$ls['volume']);
    			$row[] = $ls['id'];
					$data[] = $row;
			}

			return $data;
    } else {
      return '';
    }
	}

	private function kondisiPenanganan($value){
		switch ($value) {
			case '1':
				return '1';
				break;
			case '2':
				return '2';
				break;
			case '3':
				return '3';
				break;
			default:
				return '4';
				break;
		}
	}

  private function sumData($noruas, $periode, $awal, $akhir){
		$this->db->select('*');
    $this->db->from($this->ruas_det);
    $this->db->where('no_ruas', $noruas);
    $this->db->where('periode_id', $periode);
    $this->db->where('posisi', "KANAN");
		$this->db->where( "awal_km BETWEEN $awal AND $akhir", NULL, FALSE );
		$this->db->order_by('awal_km', 'asc');
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			$panjang_1 = 0;
			$panjang_2 = 0;
			$panjang_3 = 0;
			$panjang_4 = 0;
			$panjang_5 = 0;
			$panjang_6 = 0;
			$panjang_7 = 0;
			$luas_1 = 0;
			$luas_2 = 0;
			$luas_3 = 0;
			$luas_4 = 0;
			$luas_5 = 0;
			$luas_6 = 0;
			$luas_7 = 0;
			foreach ($arraylist as $ls) {
					if($ls['kategori_id'] == 1){
						$panjang_1 = $panjang_1 + $ls['panjang'];
						$luas_1 = $luas_1 + $ls['luas'];
					}else if($ls['kategori_id'] == 2){
						$panjang_2 = $panjang_2 + $ls['panjang'];
						$luas_2 = $luas_2 + $ls['luas'];
					}else if($ls['kategori_id'] == 3){
						$panjang_3 = $panjang_3 + $ls['panjang'];
						$luas_3 = $luas_3 + $ls['luas'];
					}else if($ls['kategori_id'] == 4){
						$panjang_4 = $panjang_4 + $ls['panjang'];
						$luas_4 = $luas_4 + $ls['luas'];
					}else if($ls['kategori_id'] == 5){
						$panjang_5 = $panjang_5 + $ls['panjang'];
						$luas_5 = $luas_5 + $ls['luas'];
					}else if($ls['kategori_id'] == 6){
						$panjang_6 = $panjang_6 + $ls['panjang'];
						$luas_6 = $luas_6 + $ls['luas'];
					}else if($ls['kategori_id'] == 7){
						$panjang_7 = $panjang_7 + $ls['panjang'];
						$luas_7 = $luas_7 + $ls['luas'];
					}
			}

			$row = array();
			$row['kondisi'] = 1;
			$row['panjang'] = $panjang_1/1000;
			$row['luas'] = $luas_1;
			$data[] = $row;

			$row = array();
			$row['kondisi'] = 2;
			$row['panjang'] = $panjang_2/1000;
			$row['luas'] = $luas_2;
			$data[] = $row;

			$row = array();
			$row['kondisi'] = 3;
			$row['panjang'] = $panjang_3/1000;
			$row['luas'] = $luas_3;
			$data[] = $row;

			$row = array();
			$row['kondisi'] = 4;
			$row['panjang'] = $panjang_4/1000;
			$row['luas'] = $luas_4;
			$data[] = $row;

			$row = array();
			$row['kondisi'] = 5;
			$row['panjang'] = $panjang_5/1000;
			$row['luas'] = $luas_5;
			$data[] = $row;

			$row = array();
			$row['kondisi'] = 6;
			$row['panjang'] = $panjang_6/1000;
			$row['luas'] = $luas_6;
			$data[] = $row;

			$row = array();
			$row['kondisi'] = 7;
			$row['panjang'] = $panjang_7/1000;
			$row['luas'] = $luas_7;
			$data[] = $row;

			return $data;
    } else {
      return '';
    }
	}

	public function getAllData($noruas, $periode, $awal, $akhir){
		$this->db->select('*');
    $this->db->from($this->kategori);
		$this->db->order_by('id', 'asc');
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();
			$sum = $this->sumData($noruas, $periode, $awal, $akhir);

			if($sum != ''){
				foreach ($arraylist as $ls) {
					foreach ($sum as $key => $valsum) {
						if($ls['id'] == $valsum['kondisi']){
							$row = array();
							$penanganan_id = $this->kondisiPenanganan($valsum['kondisi']);
							$row[] = $ls['name'];
							$row[] = $this->getMaster("kategori", $penanganan_id);
							$row[] = $valsum['panjang'];
							$row[] = $valsum['luas'];
							$row[] = base64_encode($noruas."~".$periode."~".$awal."~".$akhir."~".$ls['id']."~".$valsum['panjang']."~".$valsum['luas']);
							$row[] = $penanganan_id;
							$data[] = $row;
						}
					}
				}
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
      $this->db->set('volume', $this->volume);
      $this->db->set('hash', $this->hash);
      $this->db->where('id', $this->id);
      return $this->db->update($this->penanganan);
    }else{
			$this->db->set('jenis_id', $this->jenis_id);
      $this->db->set('harga', $this->harga);
      $this->db->set('volume', $this->volume);
      $this->db->set('hash', $this->hash);
      return $this->db->insert($this->penanganan);
    }
  }

  public function getDetailData($id){
		$this->db->select('pkj.*, hrg.satuan_id, jns.name');
    $this->db->from($this->penanganan.' pkj');
    $this->db->join($this->penangananHarga.' hrg', 'pkj.jenis_id = hrg.jenis_id');
    $this->db->join($this->penangananJenis.' jns', 'hrg.jenis_id = jns.id');
    $this->db->where('pkj.id', $id);
		$list = $this->db->get();
		if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
					$row['jenis_text'] = $ls['name'];
					$row['jenis_id'] = $ls['jenis_id'];
					$row['satuan_text'] = $this->getMaster("satuan",$ls['satuan_id']);
					$row['satuan_id'] = $ls['satuan_id'];
    			$row['harga_text'] = $this->currency_format($ls['harga']) ."/".$row['satuan_text'];
    			$row['harga'] = $ls['harga'];
    			$row['volume'] = $ls['volume'];
    			$row['total'] = $ls['harga']*$ls['volume'];
    			$row['id'] = $ls['id'];
					$data[] = $row;
			}
			return $data;
    }
  }

  public function deleteData($id){
    $this->db->where('id', $id);
    return $this->db->delete($this->penanganan);
  }

	function currency_format($angka){
  	$hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
  	return $hasil_rupiah;
  }
}
