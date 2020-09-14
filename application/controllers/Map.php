<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends MY_Controller {

  public function __construct(){
		parent::__construct();
		$this->load->model('MapModel');
	}

  public function index($id){
    $data['map'] = $this->MapModel->getData($id);
    $this->load->view('map_page', $data);
  }

  public function setItem(){
    $file_element_name = 'file_map';

		//upload file
    $config['upload_path'] =  'assets/map/';
    $config['allowed_types'] = '*';
    $config['max_filename'] = '255';
    $config['encrypt_name'] = TRUE;
    $config['max_size'] = '5000'; //1 MB

		$this->load->library('upload', $config);
		if (!$this->upload->do_upload($file_element_name))
    {
			$pesan = preg_replace('/<[^>]*>/', '', $this->upload->display_errors());
      $this->wrapper(false, $pesan ,'error upload',409);
    } else {
			$data = $this->upload->data();
      $id = $this->MapModel->saving($data['file_name']);
      $this->wrapper(true,array('id' => $id),'success set',200);
    }
  }

  public function deleteItem($id){
    $return = $this->MapModel->deleteData($id);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,null,'success delete data',200);
  }
}
