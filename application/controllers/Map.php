<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends MY_Controller {

  public function __construct(){
		parent::__construct();
		$this->load->model('MapModel');
	}

  public function index($id){
    $data['map'] = $this->MapModel->getData($id);
    $this->load->view('map_page', $data);
  }

  public function setItem(){
    $notifications = json_decode(file_get_contents("php://input"), true);
    if(!is_array($notifications)) {
		    $notifications = json_decode( $notifications );
		}

		if(count($notifications) > 0 ) {
      $this->load->helper('path');
      $file_path = 'assets/map/';

      $image = base64_decode($notifications['file_map']);
      // decoding base64 string value
      $image_name = md5(uniqid(rand(), true));// image name generating with random number with 32 characters
      $filename = $image_name . '.' . 'geojson';
      //rename file name with random number
      $path = set_realpath($file_path);
      //image uploading folder path
      file_put_contents($path . $filename, $image);

      // insert file
      $id = $this->MapModel->saving($filename);
      $this->wrapper(true,array('id' => $id),'success set',200);
		}
  }

  public function deleteItem($id){
    $return = $this->MapModel->deleteData($id);
		if(!$return){
				$this->wrapper(false, null ,'data not found',404);
		}
		$this->wrapper(true,null,'success delete data',200);
  }
}
