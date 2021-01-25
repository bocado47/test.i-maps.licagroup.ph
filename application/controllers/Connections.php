<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Connections extends CI_Controller {

  public function __construct()
  {
      date_default_timezone_set('Asia/Manila');

      parent::__construct();

      $this->load->database();
      $this->load->model('Api_m');
  } 
  public function models()
  {
    header('Access-Control-Allow-Origin: *');
    $brand=$_GET['brand'];
    if($brand == "MORRIS GARAGES"){
        $brand = "MG";
    }
    $models=$this->Api_m->models($brand);
    echo "processJSONPResponse(".json_encode($models).")";
  }
  public function colormodel()
  {
    header('Access-Control-Allow-Origin: *');
    $model=base64_decode($_GET['model']);
    $models=$this->Api_m->colors($model);
    echo "colorList(".json_encode($models).")";
  }
}
?>
