<?php
class JembatanModel extends CI_Model {
	var $jembatan = "jembatan";
	var $jembatanImage = "jembatan_images";
	var $jembatanPenanganan = "jembatan_penanganan";
    var $penangananHarga = "pekerjaan_harga";
	var $penangananJenis = "pekerjaan_jenis";
	var $kategori = "kategori";
	var $periode = "view_jembatan_periode";
	var $periodeRuas = "view_jembatan_ruas";
	var $lastJembatan = "view_last_jembatan";
	var $pengelolaJembatan = "view_jembatan_pengelola";
	var $penangananJembatan = "view_jembatan_penanganan";
	var $periodeJembatanYear = "view_jembatan_periode_2";
	var $rekapJembatanYear = "view_jembatan_rekap";
    var $bulan = array (1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );

	public function __construct()
    {
		parent::__construct();
	}

    private function setData(){
        $this->id = $this->input->post('id');
        $this->jenis_id = $this->input->post('jenis_id');
        $this->harga = $this->input->post('harga');
        $this->volume = $this->input->post('volume');
        $this->jembatan_id = $this->input->post('jembatan_id');
      }

    public function getAllData(){
        $this->db->select('jbt.*, kg.name as kg_name');
        $this->db->from($this->jembatan.' jbt');
        $this->db->join($this->kategori.' kg', 'jbt.nk_jbt = kg.nilai_kondisi');
        $list = $this->db->get();
        if($list->num_rows() > 0){
        $arraylist = $list->result_array();
            $data = array();

            foreach ($arraylist as $ls) {
                $row = array();
                $row[] = $ls['no'];
                $row[] = $ls['nama'];
                $row[] = $ls['ruas_jalan'];
                $row[] = $ls['thn'];
                $row[] = $ls['pengelola'];
                $row[] = $ls['tgl_inspeksi'];
                $row[] = $ls['kg_name'];
                $row[] = $ls['id'];
                $data[] = $row;
            }

            return $data;
        } else {
            return '';
        }
	}

    public function getPenanganan(){
        $this->db->select('jbt.*, kg.name as kg_name, kg.jenis as kg_type, kg.id as kg_id');
        $this->db->from($this->jembatan.' jbt');
        $this->db->join($this->kategori.' kg', 'jbt.nk_jbt = kg.nilai_kondisi');
        $this->db->like('jbt.ruas_jalan', $this->input->post('ruas_jalan'));
        $this->db->order_by('jbt.nk_jbt','asc');
        $list = $this->db->get();
        if($list->num_rows() > 0){
            $arraylist = $list->result_array();
            foreach ($arraylist as $ls) {
				$row = array();
    			$row[] = 'NK'.$ls['nk_jbt'];
    			$row[] = $ls['kg_name'];
    			$row[] = $ls['nama'];
    			$row[] = $ls['id'];
    			$row[] = $ls['kg_id'];
                $data[] = $row;
			}

			return $data;
        }else{
            return '';
        }
    }

    public function getPenangananDet(){
        $id = $this->input->post('jembatan_id');

        $this->db->select('pkj.*, hrg.satuan_id, jns.name');
        $this->db->from($this->jembatanPenanganan. ' pkj');
		$this->db->join($this->penangananHarga.' hrg', 'pkj.jenis_id = hrg.jenis_id');
		$this->db->join($this->penangananJenis.' jns', 'hrg.jenis_id = jns.id');
        $this->db->where('pkj.jembatan_id', $id);
        $list = $this->db->get();
        if($list->num_rows() > 0){
            $arraylist = $list->result_array();
            foreach ($arraylist as $ls) {
                $row = array();
                $row[] = $ls['name'];
                $row[] = $ls['volume'];
                $row[] = $this->currency_format($ls['harga']).'/'.$this->getMaster("satuan",$ls['satuan_id']);
                $row[] = $this->currency_format($ls['harga']*$ls['volume']);
                $row[] = $ls['id'];
                $data[] = $row;
            }

			return $data;
        }else{
            return '';
        }
    }

    public function getPenangananDetData($id){
		$this->db->select('pkj.*, hrg.satuan_id, jns.name');
        $this->db->from($this->jembatanPenanganan.' pkj');
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

    public function delPenangananDet($id){
        $this->db->where('id', $id);
        return $this->db->delete($this->jembatanPenanganan);
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

    function currency_format($angka, $rp_text = true){
		if($rp_text){
			$rp = "Rp. ";
		}else{
			$rp = "";
		}
        $hasil_rupiah =  $rp . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

    public function savingPenanganan(){
        $this->setData();
        if($this->id != ""){
            $this->db->set('jenis_id', $this->jenis_id);
            $this->db->set('harga', $this->harga);
            $this->db->set('volume', $this->volume);
            $this->db->where('id', $this->id);
            return $this->db->update($this->jembatanPenanganan);
        }else{
            $this->db->set('jenis_id', $this->jenis_id);
            $this->db->set('harga', $this->harga);
            $this->db->set('volume', $this->volume);
            $this->db->set('jembatan_id', $this->jembatan_id);
            return $this->db->insert($this->jembatanPenanganan);
        }
    }

    public function saving(){
        $json = $this->input->post('body');
        $content = json_decode($json, true);

        foreach ($content as $ls) {
            if($ls['nama'] != ""){
                $query = $this->db->get_where($this->jembatan, array('nama' => $ls['nama'], 'tgl_inspeksi' => $ls['tgl_inspeksi']));
                if($query->num_rows() > 0){
                    $this->db->where('tgl_inspeksi', $ls['tgl_inspeksi']);
                    $this->db->where('nama', $ls['nama']);
                    $this->db->update($this->jembatan, $ls);
                }else{
                    $this->db->insert($this->jembatan,$ls);
                }
            }
        }
        return true;
    }

    public function findOne($id, $type){
        $this->db->select('*');
        $this->db->from($this->jembatanImage);
        $this->db->where('jembatan_id', $id);
        $this->db->where('type', $type);
        $list = $this->db->get();
        if($list->num_rows() > 0){
            $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row['type'] = $ls['type'];
    			$row['name'] = $ls['name'];
    			$row['id'] = $ls['id'];
                $data[] = $row;
			}
			return $data;
        }else{
            return [];
        }
    }

    public function findOneById($id){
        $this->db->select('*');
        $this->db->from($this->jembatan);
        $this->db->where('id', $id);
        $list = $this->db->get();
        if($list->num_rows() > 0){
            $data = $list->result_array();
			return $data;
        }else{
            return [];
        }
    }

    public function findMany($id){
        $this->db->select('*');
        $this->db->from($this->jembatanImage);
        $this->db->where('jembatan_id', $id);
        $list = $this->db->get();
        if($list->num_rows() > 0){
            $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row['type'] = $ls['type'];
    			$row['name'] = 'assets/image/jembatan/'.$ls['name'];
    			$row['id'] = $ls['id'];
                $data[] = $row;
			}
			return $data;
        }else{
            return [];
        }
    }

    public function findManyPeriode(){
        $this->db->select('*');
        $this->db->from($this->periode);
        $list = $this->db->get();
        if($list->num_rows() > 0){
            $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
                $split = explode('-', $ls['periode']);
    			$row['name'] = $this->bulan[ (int)$split[0] ] . ' ' . $split[1];
    			$row['id'] = $ls['periode'];
                $data[] = $row;
			}
			return json_encode($data);
        }else{
            return json_encode('');
        }
    }

    public function findManyRuasJalan($periode, $filter){
        $this->db->select('*');
        $this->db->from($this->periodeRuas);
        $this->db->where('periode', $periode);
        if(strlen($filter) > 0){
			$this->db->like('ruas_jalan', $filter);
		}
        $list = $this->db->get();
        if($list->num_rows() > 0){
            $arraylist = $list->result_array();
			return json_encode($arraylist);
		} else {
			return json_encode('');
		}
    }

    public function findManyPeriode2(){
        $this->db->select('*');
        $this->db->from($this->periodeJembatanYear);
        $list = $this->db->get();
        if($list->num_rows() > 0){
            $arraylist = $list->result_array();
			return json_encode($arraylist);
		} else {
			return json_encode('');
		}
    }

    public function findManyPengelola($periode, $filter){
        $this->db->select('*');
        $this->db->from($this->pengelolaJembatan);
        $this->db->where('periode', $periode);
        if(strlen($filter) > 0){
			$this->db->like('pengelola', $filter);
		}
        $list = $this->db->get();
        if($list->num_rows() > 0){
            $arraylist = $list->result_array();
			return json_encode($arraylist);
		} else {
			return json_encode('');
		}
    }

    public function findManyNkJbt($periode, $pengelola){
        $this->db->select("jbt.*, kg.name, DATE_FORMAT(jbt.tgl_inspeksi,'%m-%Y') as periode ");
        $this->db->from($this->jembatan.' jbt');
        $this->db->join($this->kategori.' kg', 'jbt.nk_jbt = kg.nilai_kondisi');
        $this->db->where("DATE_FORMAT(jbt.tgl_inspeksi,'%Y')", $periode);
        $this->db->where('pengelola', urldecode($pengelola));
        $list = $this->db->get();
        if($list->num_rows() > 0){
            $arraylist = $list->result_array();
			return json_encode($arraylist);
		} else {
			return json_encode([]);
		}
    }

    public function findManyRekapJbt($periode){
        $this->db->select("*");
        $this->db->from($this->rekapJembatanYear);
        $this->db->where("periode", $periode);
        $list = $this->db->get();
        if($list->num_rows() > 0){
            $arraylist = $list->result_array();
			return json_encode($arraylist);
		} else {
			return json_encode([]);
		}
    }

    public function findManyRencanaJbt($periode, $pengelola){
        $this->db->select("*");
        $this->db->from($this->penangananJembatan);
        $this->db->where("periode", $periode);
        $this->db->where('pengelola', urldecode($pengelola));
        $this->db->order_by("nk_jbt", 'asc');
        $list = $this->db->get();
        if($list->num_rows() > 0){
            $arraylist = $list->result_array();
			return json_encode($arraylist);
		} else {
			return json_encode([]);
		}
    }

    public function findManyKab($name){
        $this->db->select('jbt.*, kg.warna');
        $this->db->from($this->jembatan.' jbt');
        $this->db->join($this->kategori.' kg', 'jbt.nk_jbt = kg.nilai_kondisi');
        $this->db->join($this->lastJembatan.' lst', 'jbt.nama = lst.nama AND jbt.tgl_inspeksi = lst.MaxDate');
        $this->db->like('jbt.nama_kota', $name);
        $list = $this->db->get();
        if($list->num_rows() > 0){
            $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row['latitude'] = $ls['latitude'];
    			$row['longtitude'] = $ls['longtitude'];
    			$row['warna'] = $ls['warna'];
    			$row['id'] = $ls['id'];
                $data[] = $row;
			}
			return $data;
        }else{
            return [];
        }
    }

    public function savingImage($id, $type, $filename){
        $data = $this->findOne($id, $type);
        if(count($data) > 0){
            @unlink('assets/image/jembatan/'.$data[0]['name']);

            $this->db->set('name', $filename);
            $this->db->where('id', $data[0]['id']);
            return $this->db->update($this->jembatanImage);
        }else{
            $this->db->set('jembatan_id', $id);
            $this->db->set('name', $filename);
            $this->db->set('type', $type);
            return $this->db->insert($this->jembatanImage);
        }
    }

    public function deleteData($id){
        $images = $this->findMany($id);
        foreach ($images as $key => $value) {
            @unlink($value['name']);
        }

        $this->db->where('id', $id);
        return $this->db->delete($this->jembatan);
    }
}