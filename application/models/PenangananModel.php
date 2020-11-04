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

	public function dataRekap(){
		$periode = $this->input->post('periode');
		$noruas = $this->input->post('noruas');
		$kmAwal = $this->input->post('kmAwal');
		$kmAkhir = $this->input->post('kmAkhir');
		$jns = $this->input->post('jns');

		if($noruas != "" && $kmAwal != "" && $kmAkhir != "" && $jns != ""){
			$isView = 1;
			// rjd.awal_km BETWEEN $kmAwal and $kmAkhir
			$str = "
				SELECT pr.nama as nama_periode, rj.no_ruas, rj.nama_ruas, rj.panjang, rjd.kategori_id, sum(rjd.panjang) as pj_detail, sum(rjd.luas) as luas
				FROM periode pr
				JOIN ruas_jalan rj ON pr.id = rj.periode_id
				join ruas_jalan_detail rjd ON rj.no_ruas = rjd.no_ruas and rj.periode_id = rjd.periode_id
				WHERE rj.no_ruas = $noruas and rj.periode_id = $periode and rjd.posisi = \"KANAN\" AND rjd.awal_km >= $kmAwal AND rjd.akhir_km <= $kmAkhir
				GROUP BY pr.nama, rj.no_ruas, rj.nama_ruas, rj. panjang, rjd.kategori_id
			";
		}else{
			$isView = 2;
			$str = "
				SELECT pr.id, pr.nama, rj.no_ruas, rj.nama_ruas
				FROM periode pr
				JOIN ruas_jalan rj ON pr.id = rj.periode_id
				WHERE rj.periode_id = $periode
			";
		}

		$list = $this->db->query($str);
		if($list->num_rows() > 0){
			$arraylist = $list->result_array();
			$data = array();

			if($isView == 1){
				$sum = $this->sumData($noruas, $periode, $kmAwal, $kmAkhir);
				$data['no_ruas'] = $noruas;
				$data['nama_ruas'] = $arraylist[0]['nama_ruas'];
				$data['nama_periode'] = $arraylist[0]['nama_periode'];
				$data['panjang_km'] = $arraylist[0]['panjang']. " Km";
				$data['penanganan_nama'] = $this->getKgPenanganan($jns);
				$data['penanganan_range'] = "KM ".$kmAwal." s/d KM ".$kmAkhir;

				if($sum != ''){
					foreach ($arraylist as $ls) {
						$penanganan_id = $this->kondisiPenanganan($ls['kategori_id']);
						if($penanganan_id == $jns){
							foreach ($sum as $key => $valsum) {
								if($ls['kategori_id'] == $valsum['kondisi']){
									$data['penanganan_km'] = $valsum['panjang'] ." Km";
									$hash = base64_encode($noruas."~".$periode."~".$kmAwal."~".$kmAkhir."~".$ls['kategori_id']."~".$valsum['panjang']."~".$valsum['luas']);
									$detail = $this->getListDetail($hash, $jns, 1);
									$data['data_detail'] = $detail['data'];
									$data['total'] = $this->currency_format($detail['total']);
								}
							}
						}
					}
				}
			}else if($isView == 2){ // All Penanganan
				$i = 1;
				foreach ($arraylist as $ls) {
					$header = array();
					$header['no'] = $i++;
					$header['nama_ruas'] = $ls['nama_ruas'];

					//loop jenis penanganan
					$kgList = json_decode($this->dataCombo("kategori"), true);
					$detail = array();
					$total_panjang = 0;
					$total_biaya = 0;
					foreach ($kgList as $kgls) {
						$dtdetail = $this->getListDetailByPenanganan($periode, $ls['no_ruas'], $kgls['id']);
						$total_biaya = $total_biaya + $dtdetail['biaya_penanganan_num'];
						$total_panjang = $total_panjang + $dtdetail['panjang_penanganan_num'];
						$detail[] = $dtdetail;
					}

					$header['detail'] = $detail;
					$header['total_panjang'] = number_format($total_panjang,2);
					$header['total_biaya'] = $total_biaya;
					$data[] = $header;
				}
			}
			return $data;
		}else{
			return '';
		}
	}

	private function getListDetailByPenanganan($periode, $noruas, $penanganan_id){
		$total = 0.0;
		$panjang = 0.0;
		$lokasi = "-";
		$id = "";

		$this->db->select('pkj.*, hrg.satuan_id, jns.name, jns.penanganan_id');
    $this->db->from($this->penanganan. ' pkj');
		$this->db->join($this->penangananHarga.' hrg', 'pkj.jenis_id = hrg.jenis_id');
		$this->db->join($this->penangananJenis.' jns', 'hrg.jenis_id = jns.id');
		$this->db->where('jns.penanganan_id', $penanganan_id);
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();
			foreach ($arraylist as $ls) {
				$hash_data = base64_decode($ls['hash']);
				$lshash = explode("~", $hash_data);
				$sum = $this->sumData($noruas, $periode, $lshash[2], $lshash[3]);

				if($sum != ''){
					if($lshash[0] == $noruas && $lshash[1] == $periode){
						$id = $ls['penanganan_id'];
						foreach ($sum as $key => $valsum) {
							$penanganan_id = $this->kondisiPenanganan($valsum['kondisi']);
							if($penanganan_id == $id){
								$panjang = $panjang + $valsum['panjang'];
							}
						}
						$lokasi = "KM ".$lshash[2]." s/d KM ".$lshash[3];
						$biaya = $ls['harga']*$ls['volume'];
						$total = $total + $biaya;
					}
				}
			}

			$data['jenis_penanganan'] = $this->getKgPenanganan($id);
			$data['panjang_penanganan'] = number_format($panjang,2)." Km";
			$data['panjang_penanganan_num'] = number_format($panjang,2);
			$data['lokasi_penanganan'] = $lokasi;
			$data['biaya_penanganan'] = $this->currency_format($total,false);
			$data['biaya_penanganan_num'] = $total;
			return $data;
    }else{
			$data = array();
			$data['jenis_penanganan'] = $this->getKgPenanganan($penanganan_id);
			$data['panjang_penanganan'] = number_format($panjang,2)." Km";
			$data['panjang_penanganan_num'] = number_format($panjang,2);
			$data['lokasi_penanganan'] = $lokasi;
			$data['biaya_penanganan'] = $this->currency_format($total,false);
			$data['biaya_penanganan_num'] = $total;
			return $data;
		}
	}

	public function dataComboKm($filter, $periode, $noruas, $is_pos){
		$this->db->distinct();
		if($is_pos == '1'){
			$this->db->select('akhir_km as id');
		}else{
			$this->db->select('awal_km as id');
		}
		$this->db->from($this->ruas_det);
		$this->db->where('periode_id', $periode);
		$this->db->where('no_ruas', $noruas);
		if($is_pos == '1'){
			if(strlen($filter) > 0){
				$this->db->like('akhir_km', $filter);
			}
			$this->db->order_by('akhir_km', 'desc');
		}else{
			if(strlen($filter) > 0){
				$this->db->like('awal_km', $filter);
			}
			$this->db->order_by('awal_km', 'asc');
		}
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

	public function getListDetail($hash, $jns="", $flag=0){
		$this->db->select('pkj.*, hrg.satuan_id, jns.name');
    $this->db->from($this->penanganan. ' pkj');
		$this->db->join($this->penangananHarga.' hrg', 'pkj.jenis_id = hrg.jenis_id');
		$this->db->join($this->penangananJenis.' jns', 'hrg.jenis_id = jns.id');
		if($jns != ""){
			$this->db->where('jns.penanganan_id', $jns);
		}else{
			$this->db->where('hash', $hash);
		}
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();
			$hash_data_1 = base64_decode($hash);
			$lshash_1 = explode("~", $hash_data_1);
			$total = 0;

			if($flag == 1){
				$i = 1;
				foreach ($arraylist as $ls) {
					$hash_data_2 = base64_decode($ls['hash']);
					$lshash_2 = explode("~", $hash_data_2);

					if($lshash_1[0] == $lshash_2[0] && $lshash_1[1] == $lshash_2[1] && $lshash_1[2] == $lshash_2[2]  && $lshash_1[3] == $lshash_2[3]){
						$row = array();
						$row[] = $i++;
						$row[] = $ls['name'];
						$row[] = $ls['volume'];
						$row[] = $this->getMaster("satuan",$ls['satuan_id']);
						$row[] = $this->currency_format($ls['harga']);
						$row[] = $this->currency_format($ls['harga']*$ls['volume']);
						$row[] = $ls['is_valid'] == 1 ? "Ya" : "Tidak";

						$total = $total + ($ls['harga']*$ls['volume']);
						$data[] = $row;
					}
				}
			}else{
				foreach ($arraylist as $ls) {
						$row = array();
	    			$row[] = $ls['name'];
	    			$row[] = $lshash_1[5];
						$row[] = $ls['volume'];
	    			$row[] = $this->currency_format($ls['harga']).'/'.$this->getMaster("satuan",$ls['satuan_id']);
	    			$row[] = $this->currency_format($ls['harga']*$ls['volume']);
	    			$row[] = $ls['id'];

						$total = $total + ($ls['harga']*$ls['volume']);
						$data[] = $row;
				}
			}

			return array("data"=>$data, "total"=>$total);
    } else {
      return array();
    }
	}

	private function kondisiPenanganan($value){
		switch ($value) {
			case '1':
				return '8';
				break;
			case '2':
				return '9';
				break;
			case '3':
				return '10';
				break;
			default:
				return '11';
				break;
		}
	}

  private function sumData($noruas, $periode, $awal, $akhir){
		$this->db->select('*');
    $this->db->from($this->ruas_det);
    $this->db->where('no_ruas', $noruas);
    $this->db->where('periode_id', $periode);
    $this->db->where('posisi', "KANAN");
		// $this->db->where( "awal_km BETWEEN $awal AND $akhir", NULL, FALSE );
		$this->db->where( "awal_km >= $awal", NULL, FALSE );
		$this->db->where( "akhir_km <= $akhir", NULL, FALSE );
		$this->db->order_by('awal_km', 'asc');
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			$panjang_total = 0;
			$panjang_1 = 0;
			$panjang_2 = 0;
			$panjang_3 = 0;
			$panjang_4 = 0;
			$panjang_5 = 0;
			$panjang_6 = 0;
			$panjang_7 = 0;
			$luas_total = 0;
			$luas_1 = 0;
			$luas_2 = 0;
			$luas_3 = 0;
			$luas_4 = 0;
			$luas_5 = 0;
			$luas_6 = 0;
			$luas_7 = 0;
			foreach ($arraylist as $ls) {
					$panjang_total = $panjang_total + $ls['panjang'];
					$luas_total = $luas_total + $ls['luas'];

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
			$panjang_total = $panjang_total/1000;

			$row = array();
			$row['kondisi'] = 1;
			$row['panjang'] = number_format($luas_1/$luas_total*$panjang_total,2);
			$row['luas'] = $luas_1;
			$data[] = $row;

			$row = array();
			$row['kondisi'] = 2;
			$row['panjang'] = number_format($luas_2/$luas_total*$panjang_total,2);
			$row['luas'] = $luas_2;
			$data[] = $row;

			$row = array();
			$row['kondisi'] = 3;
			$row['panjang'] = number_format($luas_3/$luas_total*$panjang_total,2);
			$row['luas'] = $luas_3;
			$data[] = $row;

			$row = array();
			$row['kondisi'] = 4;
			$row['panjang'] = number_format($luas_4/$luas_total*$panjang_total,2);
			$row['luas'] = $luas_4;
			$data[] = $row;

			$row = array();
			$row['kondisi'] = 5;
			$row['panjang'] = number_format($luas_5/$luas_total*$panjang_total,2);
			$row['luas'] = $luas_5;
			$data[] = $row;

			$row = array();
			$row['kondisi'] = 6;
			$row['panjang'] = number_format($luas_6/$luas_total*$panjang_total,2);
			$row['luas'] = $luas_6;
			$data[] = $row;

			$row = array();
			$row['kondisi'] = 7;
			$row['panjang'] = number_format($luas_7/$luas_total*$panjang_total,2);
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
		$this->db->where('jenis', '1');
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
							$row[] = $this->getKgPenanganan($penanganan_id);
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

	public function getKgPenanganan($id){
		$this->db->select('*');
    $this->db->from($this->kategori);
		$this->db->where('id', $id);
		$this->db->where('jenis', '2');
		$this->db->order_by('id', 'asc');
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			return $arraylist[0]['name'];
		}else{
			return "";
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
    			$row['harga_text'] = $this->currency_format($ls['harga']) ." / ".$row['satuan_text'];
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

	function currency_format($angka, $rp_text = true){
		if($rp_text){
			$rp = "Rp. ";
		}else{
			$rp = "";
		}
  	$hasil_rupiah =  $rp . number_format($angka,0,',','.');
  	return $hasil_rupiah;
  }
}
