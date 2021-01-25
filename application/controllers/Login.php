<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
    {
        date_default_timezone_set('Asia/Manila');

        parent::__construct();

    	$this->load->database();
		$this->load->model('login_m');
		$this->load->model('Main_m');
		$this->load->library('session');
		// if (!$this->session->userdata('user_data')) {
	 //        return redirect('Login');
	 //    }
    }
	public function index()
	{
		// phpinfo();
		$this->load->view('LoginView');
	}
	public function logged_in()
	{
		$email=$this->input->post('email');
		$pass=$this->input->post('password');
		$password=MD5($pass);

		$loggedin=$this->login_m->loggedin($email,$password);

		$data=array();
		$id='';
		foreach($loggedin as $value)
		{
			$id=$value->id;
			$type=$value->type;
			$data=array(
			'Name' => $value->name,
			'Type' => $value->type,

			);
		}

		$checkaccess=$this->Main_m->m_access($id);
		$this->session->set_userdata('logged_in', $loggedin);

		  if(count($this->session->userdata('logged_in')) > 0)
            {
            	echo json_encode($data);

      }else if(count($checkaccess < 1)){
					echo json_encode('error');
			}else{
          echo json_encode('error');

      }
			die();
	}
	public function Logout()
	{
		session_destroy();
		$this->load->view('LoginView');
	}
}
