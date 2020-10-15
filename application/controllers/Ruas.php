<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruas extends MY_Controller {

  public function __construct(){
		parent::__construct();
		$this->load->model('RuasModel');
	}

  public function import(){
    $this->basicAuth();

    $this->load->model('ImportModel');
    $notifications = json_decode(file_get_contents("php://input"), true);
    if(!is_array($notifications)) {
		    $notifications = json_decode( $notifications );
		}

		if(count($notifications) > 0 ) {
        $this->ImportModel->importData($notifications);
        $this->wrapper(true,null,'success import data',201);
		}
  }

  public function getData($id){
    $this->verifySession();
    echo $this->RuasModel->getOneRecord($id);
  }

  public function getDetail($id){
    $this->verifySession();
    echo $this->RuasModel->getOneRecordDetail($id);
  }

  public function getKoordinat($id){
    $this->verifySession();
    echo $this->RuasModel->drawKoordinat($id);
  }

  public function getCenterKoordinat($id){
    $this->verifySession();
    echo $this->RuasModel->drawCenterKoordinat($id);
  }

  public function getLegenda(){
    $this->verifySession();
    echo $this->RuasModel->dataKategori();
  }

  public function getCombo($id){
    $this->verifySession();
    $filter = $this->input->get('q');
    echo $this->RuasModel->dataCombo($filter, $id);
  }

  public function getComboKsp($region = ""){
    $this->verifySession();
    $filter = $this->input->get('q');
    echo $this->RuasModel->dataComboKsp($filter, $region);
  }

  public function getDataRekap(){
    $this->verifySession();
    echo $this->RuasModel->dataRekap();
  }

  public function getDataRekapTotal(){
    $this->verifySession();
    echo $this->RuasModel->dataRekapTotal();
  }

  public function download(){
      $view = $this->input->post('html');

      $this->load->library('pdf');
      $this->pdf->setPaper('A4', 'landscape');
      $this->pdf->filename = "rekapitulasi.pdf";
      $this->pdf->load_view($view);
  }
}
