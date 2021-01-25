<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
  {
        date_default_timezone_set('Asia/Manila');
        parent::__construct();
  }
  public function getCSmodel()
  {
    $px = isset($_GET['px']) ? base64_decode($_GET['px']) :'' ;
       if($px != "0nlyM3@p1"){
         die('You have no access here.');
       }
   //echo "<pre>";
   $cs = isset($_POST['c']) ? $_POST['c'] : '';
   // $b = isset($_POST['b']) ? $_POST['b'] : '';
   $sc = $this->Api_m->getCSmodel($cs);
   //print_r($sc);
   echo json_encode($sc)
  }
}
?>
