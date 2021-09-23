<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jembatan extends MY_Controller {

    public function __construct(){
		parent::__construct();
		$this->verifySession();

		$this->load->model('JembatanModel');
	}

    public function index(){
        $return = $this->JembatanModel->getAllData();
        $this->wrapper(true, $return, 'success get data', 200);
    }

    public function penanganan(){
        $return = $this->JembatanModel->getPenanganan();
        $this->wrapper(true, $return, 'success get data', 200);
    }

    public function penangananDetail(){
        $return = $this->JembatanModel->getPenangananDet();
        $this->wrapper(true, $return, 'success get data', 200);
    }

    public function getPenangananDet($id){
        $return = $this->JembatanModel->getPenangananDetData($id);
        if(!$return){
                $this->wrapper(false, null ,'data not found',404);
        }
        $this->wrapper(true,$return,'success get data',200);
    }
    
    public function penangananDelete($id){
        $return = $this->JembatanModel->delPenangananDet($id);
        if(!$return){
                $this->wrapper(false, null ,'data not found',404);
        }
        $this->wrapper(true,$return,'success delete data',200);
      }

    public function setItem(){
        $return = $this->JembatanModel->saving();
        if(!$return){
            $this->wrapper(false, null ,'failed set',500);
        }
        $this->wrapper(true,null,'success set',200);
    }

    public function setPenanganan(){
        $return = $this->JembatanModel->savingPenanganan();
        if(!$return){
            $this->wrapper(false, null ,'failed set',500);
        }
        $this->wrapper(true,null,'success set',200);
    }

    public function getData($id){
        $return = $this->JembatanModel->findMany($id);
        $this->wrapper(true, $return, 'success get data', 200);
    }

    public function getDataById($id){
        $return = $this->JembatanModel->findOneById($id);
        $this->wrapper(true, $return, 'success get data', 200);
    }
    
    public function getDataByKab($name){
        $return = $this->JembatanModel->findManyKab($name);
        $this->wrapper(true, $return, 'success get data', 200);
    }

    public function getDataPeriode(){
        echo $this->JembatanModel->findManyPeriode();
    }

    public function getDataRuas($periode){
        $filter = $this->input->get('q');
        echo $this->JembatanModel->findManyRuasJalan($periode, $filter);
    }

    public function setImage(){
        //upload file
        $config['upload_path'] =  'assets/image/jembatan/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_filename'] = '255';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = '5000'; //1 MB
        $this->load->library('upload', $config);

        //get data
        $id = $this->input->post('jembatan_id');
        for ($i=1; $i <= 8; $i++) { 
            if($this->upload->do_upload('file_image_'.$i)){
                $data = $this->upload->data();
                $this->JembatanModel->savingImage($id, $i, $data['file_name']);
                $this->wrapper(true,null,'success set',200);
            }
        }
    }

    public function deleteItem($id){
        $return = $this->JembatanModel->deleteData($id);
		if(!$return){
            $this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,$return,'success delete data',200);
    }
}