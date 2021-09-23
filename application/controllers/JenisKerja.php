<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JenisKerja extends MY_Controller {

  public function __construct(){
		parent::__construct();
		$this->verifySession();

		$this->load->model('JenisKerjaModel');
	}

  public function index($type = 1){
    $return = $this->JenisKerjaModel->getAllData($type);
		$this->wrapper(true,$return,'success get data',200);
  }

  public function setItem(){
    $return = $this->JenisKerjaModel->saving();
		if(!$return){
				$this->wrapper(false, null ,'failed set',500);
		}
		$this->wrapper(true,null,'success set',200);
  }

  public function getDetailItem($id, $type = 1){
    $return = $this->JenisKerjaModel->getDetailData($id, $type);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success get data',200);
  }

  public function deleteItem($id){
    $return = $this->JenisKerjaModel->deleteData($id);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success delete data',200);
  }

  public function getCombo($val){
    $filter = $this->input->get('q');
    echo $this->JenisKerjaModel->dataCombo($filter, $val);
  }
}
