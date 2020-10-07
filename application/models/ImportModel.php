<?php
class ImportModel extends CI_Model {
	var $periode = "periode";
	var $ruas = "ruas_jalan";
	var $ruas_detail = "ruas_jalan_detail";
	var $kategori = "kategori";

	public function __construct()
    {
		parent::__construct();
	}

	public function importData($data){
		$kg = $this->dataKategori();
		$pr = $this->dataPeriode($data['periode']);

		if(count($pr) > 0){
			$idPeriode = $pr[0]['id'];
		}else{
			// TODO insert new periode
			$idPeriode = $this->insertPeriode($data['periode']);
		}

		foreach ($data['ruas'] as $key => $value) {
			$rj = $this->dataRuas($value['no'], $idPeriode);
			if(count($rj) > 0){
				// TODO update ruas
	      $this->db->set('nama_ruas', $value['nama']);
	      $this->db->set('nama_kota', $value['kota']);
	      $this->db->set('asal_km', $value['asal_km']);
	      $this->db->set('panjang', $value['panjang']);
	      $this->db->set('lebar', $value['lebar']);
	      $this->db->set('awal_km', $value['awal_km']);
	      $this->db->set('akhir_km', $value['akhir_km']);
	      $this->db->set('jns_permukaan', $value['jns_permukaan']);
	      // $this->db->set('periode_id', $idPeriode);
	      $this->db->set('lat_awal', $value['lat_awal']);
	      $this->db->set('long_awal', $value['long_awal']);
	      $this->db->set('lat_akhir', $value['lat_akhir']);
	      $this->db->set('long_akhir', $value['long_akhir']);
	      $this->db->set('unit_kerja', $value['unit_kerja']);
	      $this->db->where('periode_id', $idPeriode);
	      $this->db->where('no_ruas', $value['no']);
	      $this->db->update($this->ruas);
			} else {
				// TODO insert ruas
				$this->db->set('no_ruas', $value['no']);
				$this->db->set('nama_ruas', $value['nama']);
	      $this->db->set('nama_kota', $value['kota']);
	      $this->db->set('asal_km', $value['asal_km']);
	      $this->db->set('panjang', $value['panjang']);
	      $this->db->set('lebar', $value['lebar']);
	      $this->db->set('awal_km', $value['awal_km']);
	      $this->db->set('akhir_km', $value['akhir_km']);
	      $this->db->set('jns_permukaan', $value['jns_permukaan']);
	      $this->db->set('periode_id', $idPeriode);
	      $this->db->set('lat_awal', $value['lat_awal']);
	      $this->db->set('long_awal', $value['long_awal']);
	      $this->db->set('lat_akhir', $value['lat_akhir']);
	      $this->db->set('long_akhir', $value['long_akhir']);
				$this->db->set('unit_kerja', $value['unit_kerja']);
	      $this->db->insert($this->ruas);
			}

			//TODO detail ruas jalan
			foreach ($value['detail'] as $key => $detRuas) {
				$rjd = $this->dataRuasDetail($value['no'], $idPeriode, number_format($detRuas['awal_km'], 3, '.', ''), strtoupper($detRuas['posisi']));
				// echo $this->db->last_query();exit;

				$hash = md5($value['no'].number_format($detRuas['awal_km'], 3, '.', '').strtoupper($detRuas['posisi']));
				$hash_center = md5($value['no'].number_format($detRuas['awal_km'], 3, '.', '')));
				$idKategori = 0;

				foreach ($kg as $key => $kgData) {
					if(strtoupper($kgData['name']) == strtoupper($detRuas['kategori'])){
						$idKategori = $kgData['id'];
					}
				}
				if(count($rjd) > 0){
					// TODO update detail ruas jalan
					$this->db->set('no_seksi', $detRuas['no_seksi']);
		      // $this->db->set('awal_km', $detRuas['awal_km']);
		      $this->db->set('akhir_km', $detRuas['akhir_km']);
		      // $this->db->set('posisi', strtoupper($detRuas['posisi']));
		      $this->db->set('panjang', $detRuas['panjang']);
		      $this->db->set('lebar', $detRuas['lebar']);
		      $this->db->set('luas', $detRuas['luas']);
		      $this->db->set('kategori_id', $idKategori);
		      $this->db->set('ikp', $detRuas['ikp']);
		      $this->db->set('petugas_survey', $detRuas['nm_survey']);
		      $this->db->set('tgl_survey', $detRuas['tgl_survey']);
		      $this->db->set('nm_ikp',  strtoupper($detRuas['nm_ikp']));
		      $this->db->set('hash_data', $hash);
		      $this->db->set('hash_center', $hash_center);

					$this->db->where('periode_id', $idPeriode);
					$this->db->where('awal_km = '.$detRuas['awal_km'], null, false);
					$this->db->where('UPPER(posisi) = "'.strtoupper($detRuas['posisi']).'"', null, false);
		      $this->db->where('no_ruas', $value['no']);
		      $this->db->update($this->ruas_detail);
				} else {
					// TODO insert detail ruas jalan
					$this->db->set('no_ruas', $value['no']);
					$this->db->set('no_seksi', $detRuas['no_seksi']);
					$this->db->set('awal_km', $detRuas['awal_km']);
					$this->db->set('akhir_km', $detRuas['akhir_km']);
					$this->db->set('posisi', strtoupper($detRuas['posisi']));
					$this->db->set('panjang', $detRuas['panjang']);
					$this->db->set('lebar', $detRuas['lebar']);
					$this->db->set('luas', $detRuas['luas']);
					$this->db->set('kategori_id', $idKategori);
					$this->db->set('periode_id', $idPeriode);
					$this->db->set('ikp', $detRuas['ikp']);
					$this->db->set('petugas_survey', $detRuas['nm_survey']);
					$this->db->set('tgl_survey', $detRuas['tgl_survey']);
					$this->db->set('hash_data', $hash);
					$this->db->set('hash_center', $hash_center);
					$this->db->set('nm_ikp', strtoupper($detRuas['nm_ikp']));
					$this->db->insert($this->ruas_detail);
				}
			}
		}
	}

	// Begin Ruas Jalan ======================
	private function dataRuasDetail($no, $periode, $km, $pos){
		$this->db->select('*');
		$this->db->from($this->ruas_detail);
		$this->db->where('no_ruas', $no);
		$this->db->where('periode_id', $periode);
		$this->db->where('awal_km = '.$km, null, false);
		$this->db->where('UPPER(posisi) = "'.$pos.'"', null, false);
		return $this->db->get()->result_array();
	}

	private function dataRuas($no, $id){
		$this->db->select('*');
		$this->db->from($this->ruas);
		$this->db->where('no_ruas', $no);
		$this->db->where('periode_id', $id);
		return $this->db->get()->result_array();
	}
	// End Ruas Jalan ======================

	// Begin Periode ======================
	private function insertPeriode($nama){
		$this->db->set('nama', strtoupper($nama));
		$this->db->insert($this->periode);
		return $this->db->insert_id();
	}

	private function dataPeriode($nama){
    $this->db->select('*');
    $this->db->from($this->periode);
		$this->db->where('UPPER(nama) = "'.strtoupper($nama).'"', null, false);
    return $this->db->get()->result_array();
	}
	// End Periode ======================

	private function dataKategori(){
    $this->db->select('*');
    $this->db->from($this->kategori);
    return $this->db->get()->result_array();
	}
}
