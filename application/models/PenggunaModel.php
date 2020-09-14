<?php
class PenggunaModel extends CI_Model {
	var $pengguna = "pengguna";

	public function __construct()
    {
		parent::__construct();
	}

	private function setData(){
    $this->id = $this->input->post('id');
		$this->nama = $this->input->post('nama');
		$this->email = $this->input->post('email');
		$this->nip = $this->input->post('nip');
		$this->is_admin = $this->input->post('is_admin');
		$this->is_active = $this->input->post('is_active');
		$this->file_old = $this->input->post('file_profile_old');
		$this->password = md5($this->input->post('password'));
  }

	public function getAllData(){
		$this->db->select('*');
    $this->db->from($this->pengguna);
		$this->db->where('is_admin', 0);
		$list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();

			foreach ($arraylist as $ls) {
				$row = array();
    			$row[] = $ls['nip'];
    			$row[] = $ls['nama'];
    			$row[] = $ls['email'];
					if($ls['is_active'] == 1){
						$row[] = 'Ya';
					}else{
						$row[] = 'Tidak';
					}
    			$row[] = $ls['id'];
					$data[] = $row;
			}

			return $data;
    } else {
      return '';
    }
	}

  public function saving($filename){
    $this->setData();
    if($this->id != ""){
			if($this->file_old != $filename){
					@unlink('assets/image/upload/'.$this->file_old);
			}
      $this->db->set('nama', $this->nama);
      $this->db->set('nip', $this->nip);
      $this->db->set('email', $this->email);
      $this->db->set('is_active', $this->is_active);
			if($this->password != ""){
				$this->db->set('password', $this->password);
			}else{
				$this->db->set('password', $this->input->post('password_old'));
			}
      $this->db->set('photo', $filename);
      $this->db->where('id', $this->id);
      return $this->db->update($this->pengguna);
    }else{
			$this->db->set('nama', $this->nama);
			$this->db->set('nip', $this->nip);
      $this->db->set('email', $this->email);
      $this->db->set('is_active', $this->is_active);
      $this->db->set('password', $this->password);
			$this->db->set('photo', $filename);
      return $this->db->insert($this->pengguna);
    }
  }

  public function getDetailData($id){
    $this->db->select('*');
    $this->db->from($this->pengguna);
    $this->db->where('id', $id);
    return $this->db->get()->result();
  }

  public function deleteData($id){
		$return = json_decode(json_encode($this->getDetailData($id)), true);
		if($return[0]['photo'] != ""){
			@unlink('assets/image/upload/'.$return[0]['photo']);
		}
    $this->db->where('id', $id);
    return $this->db->delete($this->pengguna);
  }

	public function checkPermission(){
		$username = $this->input->post('username');
    $password = $this->input->post('password');

    $this->db->select('id, is_admin');
    $this->db->from($this->pengguna);
    $this->db->where('email', $username);
    $this->db->where('is_active', 1);
    $this->db->where('password', md5($password));
    $list = $this->db->get();
    if($list->num_rows() > 0){
      $arraylist = $list->result_array();
			$data = array();
			foreach ($arraylist as $ls) {
        $data['id_user'] = $ls['id'];
        $data['is_admin'] = $ls['is_admin'];
				$data['is_login'] = TRUE;
				$this->session->set_userdata($data);
			}
      return TRUE;
    }else{
      return FALSE;
    }
	}
}
