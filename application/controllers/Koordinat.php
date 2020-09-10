<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koordinat extends MY_Controller {

  public function __construct(){
		parent::__construct();
		$this->verifySession();

		$this->load->model('KoordinatModel');
	}

  public function index(){
		$this->wrapper(true,nul,'success get data',200);
  }

  public function setItem(){
    $return = $this->KoordinatModel->saving();
		if(!$return){
				$this->wrapper(false, null ,'failed set',500);
		}
		$this->wrapper(true,null,'success set',200);
  }
}
