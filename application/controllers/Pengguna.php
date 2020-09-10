<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends MY_Controller {

  public function __construct(){
		parent::__construct();
		$this->verifySession();

		$this->load->model('PenggunaModel');
	}

  public function index(){
    $return = $this->PenggunaModel->getAllData();
		$this->wrapper(true,$return,'success get data',200);
  }

  public function getDetailItem($id){
    $return = $this->PenggunaModel->getDetailData($id);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success get data',200);
  }

  public function deleteItem($id){
    $return = $this->PenggunaModel->deleteData($id);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success delete data',200);
  }

  public function getCombo(){
    $filter = $this->input->get('q');
    echo $this->PenggunaModel->dataCombo($filter);
  }

  public function setItem($type){
		$file_element_name = 'file_image';

		//upload file
    $config['upload_path'] =  'assets/image/upload/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_filename'] = '255';
    $config['encrypt_name'] = TRUE;
    $config['max_size'] = '5000'; //1 MB

		$this->load->library('upload', $config);
		if (!$this->upload->do_upload($file_element_name))
    {
			$pesan = preg_replace('/<[^>]*>/', '', $this->upload->display_errors());
      if($pesan == "You did not select a file to upload."){
        $this->PenggunaModel->saving($this->input->post('file_profile_old'));
        $this->wrapper(true,null,'success set',200);
      }else{
        $this->wrapper(false, $pesan ,'error upload',409);
      }
    } else {
			$data = $this->upload->data();
      if($type == "profile"){
        $this->PenggunaModel->saving($data['file_name']);
      }
      $this->wrapper(true,null,'success set',200);
    }
	}
}
