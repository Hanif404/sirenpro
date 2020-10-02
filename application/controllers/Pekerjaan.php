<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerjaan extends MY_Controller {

  public function __construct(){
		parent::__construct();
		$this->verifySession();

		$this->load->model('PekerjaanModel');
	}

  public function index(){
    $return = $this->PekerjaanModel->getAllData();
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

  public function getDetailItem($id){
    $return = $this->PekerjaanModel->getDetailData($id);
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
