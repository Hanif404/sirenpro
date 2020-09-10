<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satuan extends MY_Controller {

  public function __construct(){
		parent::__construct();
		$this->verifySession();

		$this->load->model('SatuanModel');
	}

  public function index(){
    $return = $this->SatuanModel->getAllData();
		$this->wrapper(true,$return,'success get data',200);
  }

  public function setItem(){
    $return = $this->SatuanModel->saving();
		if(!$return){
				$this->wrapper(false, null ,'failed set',500);
		}
		$this->wrapper(true,null,'success set',200);
  }

  public function getDetailItem($id){
    $return = $this->SatuanModel->getDetailData($id);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success get data',200);
  }

  public function deleteItem($id){
    $return = $this->SatuanModel->deleteData($id);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success delete data',200);
  }

  public function getCombo(){
    $filter = $this->input->get('q');
    echo $this->SatuanModel->dataCombo($filter);
  }
}
