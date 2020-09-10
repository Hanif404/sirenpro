<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->verifySession();
	}

	public function index()
	{
		$this->load->view('main_page');
	}
}
