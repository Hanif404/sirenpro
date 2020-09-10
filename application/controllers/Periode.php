<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Periode extends MY_Controller {

  public function __construct(){
		parent::__construct();
		$this->verifySession();

		$this->load->model('PeriodeModel');
	}

  public function getCombo(){
    $filter = $this->input->get('q');
    echo $this->PeriodeModel->dataCombo($filter);
  }
}
