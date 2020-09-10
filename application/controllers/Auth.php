<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('PenggunaModel');
	}

	public function index() {

		$this->load->view('login_page');
	}

	public function checkPermission() {
		$return = $this->PenggunaModel->checkPermission();
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success get data',200);
	}

	public function checkSession(){
		$this->verifySession();
	}

	public function getProfile() {
		$return = $this->PenggunaModel->getDetailData($_SESSION['id_user']);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success get data',200);
	}

	public function quit(){
		$this->session->sess_destroy();
		redirect('auth');
	}
}
