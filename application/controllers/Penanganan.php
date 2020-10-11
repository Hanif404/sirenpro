<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penanganan extends MY_Controller {

  public function __construct(){
		parent::__construct();
		$this->verifySession();

		$this->load->model('PenangananModel');
	}

  public function index($noruas, $periode, $awal, $akhir){
    $return = $this->PenangananModel->getAllData($noruas, $periode, $awal, $akhir);
		$this->wrapper(true,$return,'success get data',200);
  }

  public function getDataRekap(){
    $this->verifySession();
    $return = $this->PenangananModel->dataRekap();
    $this->wrapper(true,$return,'success get data',200);
  }

  public function getComboKm($periode, $noruas){
    $filter = $this->input->get('q');
    echo $this->PenangananModel->dataComboKm($filter, $periode, $noruas);
  }

  public function listDetail($hash){
    $return = $this->PenangananModel->getListDetail($hash);
    $this->wrapper(true,$return,'success get data',200);
  }

  public function setItem(){
    $return = $this->PenangananModel->saving();
		if(!$return){
				$this->wrapper(false, null ,'failed set',500);
		}
		$this->wrapper(true,null,'success set',200);
  }

  public function getDetailItem($id){
    $return = $this->PenangananModel->getDetailData($id);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success get data',200);
  }

  public function deleteItem($id){
    $return = $this->PenangananModel->deleteData($id);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success delete data',200);
  }
}
