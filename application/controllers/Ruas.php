<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruas extends MY_Controller {

  public function __construct(){
		parent::__construct();
    $this->verifySession();

		$this->load->model('RuasModel');
	}

  public function getData($id){
    echo $this->RuasModel->getOneRecord($id);
  }

  public function getDetail($id){
    echo $this->RuasModel->getOneRecordDetail($id);
  }

  public function getKoordinat($id){
    echo $this->RuasModel->drawKoordinat($id);
  }

  public function getLegenda(){
    echo $this->RuasModel->dataKategori();
  }

  public function getCombo($id){
    $filter = $this->input->get('q');
    echo $this->RuasModel->dataCombo($filter, $id);
  }
}
