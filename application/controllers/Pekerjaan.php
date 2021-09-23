<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerjaan extends MY_Controller {

  public function __construct(){
		parent::__construct();
		$this->verifySession();

		$this->load->model('PekerjaanModel');
	}

  public function index($type = 1){
    	$return = $this->PekerjaanModel->getAllData($type);
		$this->wrapper(true,$return,'success get data',200);
  }

  public function getCombo($code){
    echo $this->PekerjaanModel->dataCombo($code);
  }

  public function setItem(){
    $return = $this->PekerjaanModel->saving();
		if(!$return){
				$this->wrapper(false, null ,'failed set',500);
		}
		$this->wrapper(true,null,'success set',200);
  }

  public function getDetailItem($id, $type = 1){
    $return = $this->PekerjaanModel->getDetailData($id, $type);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success get data',200);
  }

  public function getDetailItemByJenis($id){
    $return = $this->PekerjaanModel->getDataByJenis($id);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success get data',200);
  }

  public function deleteItem($id){
    $return = $this->PekerjaanModel->deleteData($id);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success delete data',200);
  }
}
