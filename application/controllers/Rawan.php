<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rawan extends MY_Controller {

  public function __construct(){
		parent::__construct();
		$this->verifySession();

		$this->load->model('RawanModel');
	}

  public function index(){
    $return = $this->RawanModel->getAllData();
		$this->wrapper(true,$return,'success get data',200);
  }

  public function getLongsor(){
    $this->verifySession();
    echo $this->RawanModel->dataBencana(1);
  }

  public function getBanjir(){
    $this->verifySession();
    echo $this->RawanModel->dataBencana(2);
  }

  public function getKecelakaan(){
    $this->verifySession();
    echo $this->RawanModel->dataBencana(3);
  }

  public function setItem(){
    $return = $this->RawanModel->saving();
		if(!$return){
				$this->wrapper(false, null ,'failed set',500);
		}
		$this->wrapper(true,null,'success set',200);
  }

  public function getDetailItem($id){
    $return = $this->RawanModel->getDetailData($id);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success get data',200);
  }

  public function deleteItem($id){
    $return = $this->RawanModel->deleteData($id);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success delete data',200);
  }
}
