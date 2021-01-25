<?php

  defined('BASEPATH') OR exit('No direct script access allowed');
  require_once ("Lica.php");

  class Purchase extends Lica {

    public function __construct()
    {
        parent::__construct();
       // error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
       if(!$this->session->userdata('logged_in'))
       {
         die("You don't have access here: <a href='".base_url()."Login'>Login Here! </a>");
       }

      }
    public function purchaseView()
    {
      is_login();

        $empNo = $this->session->userdata('lvIsLogin')['id'];
        $approver = $this->Lica_m->Fapprover($empNo);
        $data['chApp'] = $this->Lica_m->getApprover3($empNo);
        if(count($approver) <= 0){
            $company = $this->session->userdata('lvIsLogin')['Company'];
            $branch = $this->session->userdata('lvIsLogin')['Branch'];
            $dept = $this->session->userdata('lvIsLogin')['Department'];
            $getSecondApprover= $this->Lica_m->getSecondApprover($company,$branch,$dept);
             if(count($getSecondApprover) <= 0)
             {
                $this->session->set_flashdata('cMsgColor', 'danger');
                $this->session->set_flashdata('cMsg', 'Your account does not have an Approver. Please submit a <a href="http://45.64.83.60/osticket/">support ticket.</a>.');
                $data['session_data'] = $this->session->userdata('lvIsLogin');
                $this->load->database();
                $data['approver'] =$this->Lica_m->Fapprover($empNo);
                $data['count']=$this->Lica_m->count();
                $data['Last']=$this->Lica_m->get_last();
                $data['kindList'] = $this->Lica_m->getKind();
                $data['getSecondApprover'] = $this->Lica_m->getSecondApprover($company,$branch,$dept);
                $this->load->view('header');
                $this->load->view('employee/EMP_PURCHASE_REQUEST',$data);
                $this->load->view('footer');
             }else{
                $this->session->set_flashdata('cMsgColor', 'danger');
                $this->session->set_flashdata('cMsg', 'Your account does not have an Approver. Please contact your immediate head to add you as subordinate..2');
                $data['session_data'] = $this->session->userdata('lvIsLogin');
                $this->load->database();
                $data['approver'] =$this->Lica_m->Fapprover($empNo);
                $data['count']=$this->Lica_m->count();
                $data['Last']=$this->Lica_m->get_last();
                $data['kindList'] = $this->Lica_m->getKind();
                $data['getSecondApprover'] = $this->Lica_m->getSecondApprover($company,$branch,$dept);
                $this->load->view('header');
                $this->load->view('employee/EMP_PURCHASE_REQUEST',$data);
                $this->load->view('footer');
             }
        }else{
                $company = $this->session->userdata('lvIsLogin')['Company'];
                $branch = $this->session->userdata('lvIsLogin')['Branch'];
                $dept = $this->session->userdata('lvIsLogin')['Department'];
                $getSecondApprover= $this->Lica_m->getSecondApprover($company,$branch,$dept);
            if(count($getSecondApprover) <= 0)
             {
                $this->session->set_flashdata('cMsgColor', 'danger');
                $this->session->set_flashdata('cMsg', 'Your account lacks an Approver. Please submit a <a href="http://45.64.83.60/osticket/">support ticket.</a>');
                $data['session_data'] = $this->session->userdata('lvIsLogin');
                $this->load->database();
                $data['approver'] =$this->Lica_m->Fapprover($empNo);
                $data['count']=$this->Lica_m->count();
                $data['Last']=$this->Lica_m->get_last();
                $data['kindList'] = $this->Lica_m->getKind();
                $data['getSecondApprover'] = $this->Lica_m->getSecondApprover($company,$branch,$dept);
                $this->load->view('header');
                $this->load->view('employee/EMP_PURCHASE_REQUEST',$data);
                $this->load->view('footer');
             }else{
                $data['session_data'] = $this->session->userdata('lvIsLogin');
                $this->load->database();
                $data['approver'] =$this->Lica_m->Fapprover($empNo);
                $data['count']=$this->Lica_m->count();
                $data['Last']=$this->Lica_m->get_last();
                $data['kindList'] = $this->Lica_m->getKind();
                $data['getSecondApprover'] = $this->Lica_m->getSecondApprover($company,$branch,$dept);
                $this->load->view('header');
                $this->load->view('employee/EMP_PURCHASE_REQUEST',$data);
                $this->load->view('footer');
             }
        }

      }
    public function getItem()
    {
    $item = $this->Lica_m->getItem($_GET['kind']);
    echo json_encode($item);
    }
    public function phReq()
    {

         is_login();
        $empNo = $this->session->userdata('lvIsLogin')['id'];
        $chApp = $this->Lica_m->getApprover3($empNo);
        $data['session_data'] = $this->session->userdata('lvIsLogin');
        $company = $this->session->userdata('lvIsLogin')['Company'];
        $branch = $this->session->userdata('lvIsLogin')['Branch'];
        $dept = $this->session->userdata('lvIsLogin')['Department'];
        $data['vsrv'] = $this->Lica_m->getVServices();

        $query = $this->Lica_m->insert_phreq($_POST);

        if($query){
             $this->email($_POST);
        }else{
          $this->load->view('header');
          $this->load->view('employee/EMP_PURCHASING_REQUEST',$data);
          $this->load->view('footer');
        }
    }
    public function email()
    {
        $datas['session_data'] = $this->session->userdata('lvIsLogin');
        $empNo = $this->session->userdata('lvIsLogin')['id'];
        $Lname=$this->session->userdata('lvIsLogin')['Lname'];
        $Fname=$this->session->userdata('lvIsLogin')['Fname'];
        $Mname=$this->session->userdata('lvIsLogin')['Mname'];
        $chApp = $this->Lica_m->getApprover3($empNo);
        $company = $this->session->userdata('lvIsLogin')['Company'];
        $branch = $this->session->userdata('lvIsLogin')['Branch'];
        $dept = $this->session->userdata('lvIsLogin')['Department'];
        $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
        $contact=$this->Lica_m->getAccountInfo($empNo)[0]->Contact;
        $data['vsrv'] = $this->Lica_m->getVServices();

        $name = ucwords($Lname.', '.$Fname.' '.$Mname);
        $prid=$this->input->post("Pr_ID");
        $kind=$this->input->post('secretkind2');

        $this->load->model('Lica_m');
        $this->Lica_m->updateinfo($_POST);
        $data['info'] =  $this->Lica_m->phrInfo3($prid);
        $data['item'] =  $this->Lica_m->itemInfo3($prid);
        $find=$this->Lica_m->Fapprover($empNo);
        $reasons=$this->input->post("textarea1");
          foreach($find as $e)
          {
            $lol=$e->Approver;
          }

          $approver=$this->Lica_m->Fapprover($empNo);

        foreach($approver as $es)
        {
             $amp=$es->Email;
            $num=$es->Contact;
            $data['fname']=$es->Fname;
            $data['lname']=$es->Lname;
            $data['id']=$es->id;


        // $number1=str_replace("-","",$num);
        // $number2= ltrim($number1, '0');
        // $number3='63'.$number2;
        // $url = 'https://api.infobip.com/sms/1/text/single';
        // $key = base64_encode("licagroup:TAlica03");
        // $data = array(
        //  'from' => 'LicaGroup',
        //  'to' => $number3,
        //  'text' => $name.' has submiited a purchase request #'.$prid.' for you approval',
        // );
        // $options = array(
        //     'http' => array(
        //     'header'  => array(
        //     "Authorization: Basic ".$key,
        //     "Content-type: application/json",
        //     ),
        //     'method'  => 'POST',
        //     'content' => json_encode($data)
        //     )
        // );
        // $context  = stream_context_create($options);
        // $result = file_get_contents($url, false, $context);
        // if($result){
            date_default_timezone_set('Asia/Manila');
            $this->load->library('email');
            $this->email->from('admin@licagroup.biz', 'Lica Management System');
            $this->email->to($amp, 'EMAIL');
            $this->email->subject('Purchase request for approval - '.$kind.' PR#:'.$prid);
            $msg = $this->load->view('email/approveEmail1',$data,TRUE);
            $this->email->set_mailtype("html");
            $this->email->message($msg);
            $send=$this->email->send();
        }
           $this->emailUser($_POST);
    }
    public function emailUser()
    {
        $prid=$this->input->post("Pr_ID");
        $Contact=$this->session->userdata('lvIsLogin')['Contact'];
            is_login();
        $Lname=$this->session->userdata('lvIsLogin')['Lname'];
        $Fname=$this->session->userdata('lvIsLogin')['Fname'];
        $Mname=$this->session->userdata('lvIsLogin')['Mname'];
        $chApp = $this->Lica_m->getApprover3($empNo);
        $datas['session_data'] = $this->session->userdata('lvIsLogin');
        $company = $this->session->userdata('lvIsLogin')['Company'];
        $branch = $this->session->userdata('lvIsLogin')['Branch'];
        $dept = $this->session->userdata('lvIsLogin')['Department'];
        $data['vsrv'] = $this->Lica_m->getVServices();

        $name = ucwords($Lname.', '.$Fname.' '.$Mname);
        $kind=$this->input->post('secretkind2');
        // $this->load->model('purchase_m');
        $this->Lica_m->updateinfo($_POST);
        $empNo=$this->Lica_m->getempno($prid)[0]-> EmployeeNumber;
        $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
        $data['info'] =  $this->Lica_m->phrInfo($_POST);
        $data['item'] =  $this->Lica_m->itemInfo($_POST);
        // $number1=str_replace("-","",$Contact);
        // $number2= ltrim($number1, '0');
        // $number3='63'.$number2;

        // $url = 'https://api.infobip.com/sms/1/text/single';
        // $key = base64_encode("licagroup:TAlica03");
        // $data = array(
        //  'from' => 'LicaGroup',
        //  'to' => $number3,
        //  'text' => 'Your purchase request #'.$prid.' has been submitted for approval.',
        // );
        // $options = array(
        //     'http' => array(
        //     'header'  => array(
        //     "Authorization: Basic ".$key,
        //     "Content-type: application/json",
        //     ),
        //     'method'  => 'POST',
        //     'content' => json_encode($data)
        //     )
        // );
        // $context  = stream_context_create($options);
        // $result = file_get_contents($url, false, $context);
        // if($result){

            date_default_timezone_set('Asia/Manila');
            $this->load->library('email');
            $this->email->from('admin@licagroup.biz', 'Lica Management System');
            $this->email->to($emailadd, 'EMAIL');
            $this->email->subject('Purchase request has been created- PR#:'.$prid);
            $msg = $this->load->view('email/approveEmail2',$_POST,TRUE);
            $this->email->set_mailtype("html");
            $this->email->message($msg);
            $this->email->send();


             header("Location:".base_url()."e/dashboard");
        // }

    }
    public function declineEmail()
    {

        $prid=$this->input->post("Pr_ID");
        $empNo=$this->Lica_m->getempno($prid)[0]->  EmployeeNumber;
        $dates=$this->input->post("Date");
            $kind=$this->input->post("kind");
       $find=$this->Lica_m->Fapprover($empNo);
       $reasons=$this->input->post("textarea1");
          foreach($find as $e)
          {
            $lol=$e->Approver;
          }

          $approver=$this->Lica_m->approverEmail($lol);
           foreach($approver as $es)
          {
            $amp=$es->Email;
            $num=$es->Contact;
          }

            $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
           $data['info'] =  $this->Lica_m->phrInfo3($prid,$dates,$empNo);
           $info =  $this->Lica_m->phrInfo3($prid,$dates,$empNo);
        $data['item'] =  $this->Lica_m->itemInfo3($prid);
        $data['reason']=$this->input->post("textarea1");
        foreach($info as $ei)
        {
            $Status=$ei->Status;
        }
        if($Status ==="Wait for Approval")
        {

                    if($reasons==='')
                {
                 echo  "<script type='text/javascript'>";
                  echo "alert('Please indicate your reason before you DECLINE.');";
                  echo "window.close();";
                  echo "</script>";
                }else{



                      $this->Lica_m->updatestatus($dates,$prid);
                      date_default_timezone_set('Asia/Manila');
                      $this->load->library('email');
                      $this->email->from('admin@licagroup.biz', 'Lica Management System');
                      $this->email->to($emailadd, 'EMAIL');
                      $this->email->subject('Purchase request declined-'.$kind.' PR#:'.$prid);
                      $msg = $this->load->view('email/declineEmail',$data,TRUE);
                      $this->email->set_mailtype("html");
                      $this->email->message($msg);
                      $this->email->send();

                      echo  "<script type='text/javascript'>";
                      echo "alert('You have DECLINED the request');";
                      echo "window.close();";
                      echo "</script>";
                }
        }else if($Status ==="Rejected"){

            echo  "<script type='text/javascript'>";
            echo "alert('Request was already DECLINED.');";
            echo "window.close();";
            echo "</script>";
        }else{
            echo  "<script type='text/javascript'>";
             echo "alert('The request was already APPROVED.');";
            echo "window.close();";
            echo "</script>";
        }

    }
    public function declineEmail2()
    {

        $prid=$this->input->post("Pr_ID");
        $empNo=$this->Lica_m->getempno($prid)[0]->  EmployeeNumber;
        $dates=$this->input->post("Date");
        $kind=$this->input->post("kind");
        $this->load->model('Lica_m');
        // $this->Lica_m->updateinfo($_POST);
        //  $id= $this->purchase_m->view_insert($name);
        // $datas['view']=$id;
        $find=$this->Lica_m->Fapprover($empNo);
        $reasons=$this->input->post("textarea1");
          foreach($find as $e)
          {
            $lol=$e->Approver;
          }

          $approver=$this->Lica_m->approverEmail($lol);
           foreach($approver as $es)
          {
            $amp=$es->Email;
            $num=$es->Contact;
          }

        $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
        $data['info'] =  $this->Lica_m->phrInfo3($prid,$dates,$empNo);
        $info =  $this->Lica_m->phrInfo3($prid,$dates,$empNo);
        $data['item'] =  $this->Lica_m->itemInfo3($prid);
        $data['reason']=$this->input->post("textarea1");
        foreach($info as $ei)
        {
            $Status=$ei->Status;
        }
        if($Status ==="Approve")
        {
            echo  "<script type='text/javascript'>";
             echo "alert('Request was already APPROVED.');";
            echo "window.close();";
            echo "</script>";
        }else if($Status === "Rejected"){

            echo  "<script type='text/javascript'>";
            echo "alert('Request was already DECLINED.');";
            echo "window.close();";
            echo "</script>";
        }else{
              if($reasons==='')
          {
           echo  "<script type='text/javascript'>";
            echo "alert('Please indicate your reason before you DECLINED.');";
            echo "window.close();";
            echo "</script>";
        }else{
                    $this->Lica_m->updatestatus($dates,$prid);
                    date_default_timezone_set('Asia/Manila');
                    $this->load->library('email');
                    $this->email->from('admin@licagroup.biz', 'Lica Management System');
                    $this->email->to($emailadd, 'EMAIL');
                    $this->email->subject('Purchase request declined-'.$kind.' PR#:'.$prid);
                    $msg = $this->load->view('email/declineEmail',$data,TRUE);
                    $this->email->set_mailtype("html");
                    $this->email->message($msg);
                    $this->email->send();

                    echo  "<script type='text/javascript'>";
                    echo "alert('You have DECLINED the request');";
                    echo "window.close();";
                    echo "</script>";
          }
        }

    }

    public function emailApprover2($prid,$dates,$id)
    {

            $empNo=$this->Lica_m->getempno($prid)[0]->  EmployeeNumber;
            $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
            $company=$this->Lica_m->getAccountInfo($empNo)[0]->Company;
            $branch=$this->Lica_m->getAccountInfo($empNo)[0]->Branch;
            $dept=$this->Lica_m->getAccountInfo($empNo)[0]->Department;
            $data['vsrv'] = $this->Lica_m->getVServices();
            $data['info'] =  $this->Lica_m->phrInfo3($prid,$dates,$empNo);
            $data['item'] =  $this->Lica_m->itemInfo3($prid);
            $info =  $this->Lica_m->phrInfo3($prid,$dates,$empNo);
            $find=$this->Lica_m->Fapprover($empNo);
            $appinfo=$this->Lica_m->AppInfo($id);
            foreach($appinfo as $inf)
            {
               $infname=$inf->Fname;
               $inlname=$inf->Lname;
               $contact=$inf->Contact;
              $emailinf=$inf->Email;
              $emailinf2=$inf->Email;
               $fullname=$infname.' '.$inlname.' ('.$contact.') ';
            }
            foreach($info as $if)
            {
               $Status=$if->Status;
            }
            $approver=$this->Lica_m->getSecondApprover($company,$branch,$dept);

            $level=$this->Lica_m->getJobLevel($company,$branch,$dept,$id);


            foreach($level as $lvl)
            {
                $joblevel=$lvl->JobLevel;
            }

            if($Status ==="New")
            {
            echo  "<script type='text/javascript'>";
            echo "alert('You have approved this request An email was sent to confirm what you have approved. Thank you.');";
            echo "window.close();";
            echo "</script>";
            }else if ($Status ==="Rejected"){
            echo  "<script type='text/javascript'>";
            echo "alert('Request was already declined.');";
            echo "window.close();";
            echo "</script>";
            }else if($Status ==="Wait for approval2"){
            echo  "<script type='text/javascript'>";
            echo "alert('The request was already approved.');";
            echo "window.close();";
            echo "</script>";
            }else if($Status ==="Wait for approval"){

            $this->Lica_m->updateinfo3($prid,$dates,$fullname,$emailinf,$id);
            $ifsapprover=$emailinf;
            $data['number']=$this->Lica_m->phrinfo5($ifsapprover);

            if ($joblevel > '9')
            {

                 $this->recipients2($prid,$dates,$fullname,$emailinf,$id);

            }else{

            foreach($approver as $es)
            {
            $amp=$es->Email;
            $num=$es->Contact;
            $data['fname']=$es->Fname;
            $data['lname']=$es->Lname;
            $data['id']=$es->id;

                date_default_timezone_set('Asia/Manila');
                $this->load->library('email');
                $this->email->from('admin@licagroup.biz', 'Lica Management System');
                $this->email->to($emailinf, 'EMAIL');
                // $this->email->cc($emailinf);
                $this->email->subject('Purchase request for final approval-PR#:'.$prid);
                $msg = $this->load->view('email/approveEmail4',$data,TRUE);
                $this->email->set_mailtype("html");
                $this->email->message($msg);
                $this->email->send();

                echo  "<script type='text/javascript'>";
                 echo "alert('You have approved the request.');";
                echo "window.close();";
                echo "</script>";
            }
        }
      }
    }
    public function recipients($prid,$dates,$id)
    {

        $empNo=$this->Lica_m->getempno($prid)[0]->EmployeeNumber;
        $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
        $contact=$this->Lica_m->getAccountInfo($empNo)[0]->Contact;
        $company=$this->Lica_m->getAccountInfo($empNo)[0]->Company;
        $branch=$this->Lica_m->getAccountInfo($empNo)[0]->Branch;
        $data['branch']=$this->Lica_m->getAccountInfo($empNo)[0]->Branch;
        $dept=$this->Lica_m->getAccountInfo($empNo)[0]->Department;
        $data['pinfo']=$this->Lica_m->getAccountInfo($empNo);
        $data['fapprover']=$this->Lica_m->fapprover($empNo);
        $data['sapprover']=$this->Lica_m->getSecondApprover($company,$branch,$dept);
        $infos =  $this->Lica_m->phrInfo4($prid);



        $data['info'] =  $this->Lica_m->phrInfo4($prid);
        $info =  $this->Lica_m->phrInfo3($prid,$dates,$empNo);
        $data['level']=$this->Lica_m->getJobLevel($company,$branch,$dept,$id);
        $data['item'] =  $this->Lica_m->itemInfo3($prid);
        $item =  $this->Lica_m->itemInfo3($prid);
        $item2 =  $this->Lica_m->itemInfo4($prid);
        $appinfo=$this->Lica_m->AppInfo($id);
        $pp='';
        $Status='';
        $emailinf2='';
        $approver=array();

        foreach ($item2 as $itm)
        {
            $pp.=$itm->Item_kind;
        }
        foreach($info as $if)
        {
            $Status.=$if->Status;

        }

        foreach($appinfo as $inf)
        {
            $infname=$inf->Fname;
            $inlname=$inf->Lname;
            $contact=$inf->Contact;
            $emailinf2.=$inf->Email;
            $fullname=$infname.' '.$inlname.' ('.$contact.') ';
        }

        if($pp == 'Company IDs')
        {
            $approver[]=$this->Lica_m->recipients2($empNo);
        }else{
            $approver[]=$this->Lica_m->recipients($empNo);
        }
        // print_r($approver);
        foreach($approver as $es)
        {

                $amp=$es->Email;
                $num=$es->MobileNumber;
                $data['fname']=$es->Fname;
                $data['lname']=$es->Lname;
                $data['id']=$es->id;

                if($Status ==="Approve")
                {
                    echo  "<script type='text/javascript'>";
                    echo "alert('Request was already approved');";
                    echo "window.close();";
                    echo "</script>";
                }
                else if ($Status ==="Rejected"){

                    echo  "<script type='text/javascript'>";
                    echo "alert('Request was already declined.');";
                    echo "window.close();";
                    echo "</script>";
                }else if($Status ==="Wait for approval"){
                    $data['number']=$this->Lica_m->phrInfo6($emailinf2);
                    $this->Lica_m->updateinfo2($prid,$dates,$emailinf2);
                    $list = array($emailadd,$emailinf2);


                    date_default_timezone_set('Asia/Manila');
                    $this->load->library('email');
                    $this->email->from('admin@licagroup.biz', 'Lica Management System');
                    $this->email->to($amp,$emailadd,'EMAIL');
                    // $this->email->cc($ifsSapprover);
                    $this->email->subject('Purchase request PR#:'.$prid.' has been approved');
                    $msg = $this->load->view('email/approveEmail4',$data,TRUE);
                    $this->email->set_mailtype("html");
                    $this->email->message($msg);
                    $this->email->send();
                    // echo $Status;
                    echo  "<script type='text/javascript'>";
                    echo "alert('You have approved this request. An email was sent to confirm what you have approved. Thank you.');";
                    echo "window.close();";
                    echo "</script>";

                    $this->load->library('email');
                    $this->email->from('admin@licagroup.biz', 'Lica Management System');
                    $this->email->to($emailinf2,'EMAIL');
                    // $this->email->cc($ifsSapprover);
                    $this->email->subject('Approved Purchase request PR#:'.$prid);
                    $msg = $this->load->view('email/approveEmail4',$data,TRUE);
                    $this->email->set_mailtype("html");
                    $this->email->message($msg);
                    $this->email->send();
                }else{
                    echo  "<script type='text/javascript'>";
                    echo "alert('Error Please Contact The programmer.');";
                    echo "window.close();";
                    echo "</script>";
                }
        }
    }
    public function recipients2($prid,$dates,$id)
    {

           $empNo=$this->Lica_m->getempno($prid)[0]->EmployeeNumber;
          $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
          $contact=$this->Lica_m->getAccountInfo($empNo)[0]->Contact;
          $company=$this->Lica_m->getAccountInfo($empNo)[0]->Company;
          $branch=$this->Lica_m->getAccountInfo($empNo)[0]->Branch;
          $data['branch']=$this->Lica_m->getAccountInfo($empNo)[0]->Branch;
          $dept=$this->Lica_m->getAccountInfo($empNo)[0]->Department;
          $data['pinfo']=$this->Lica_m->getAccountInfo($empNo);
          $data['fapprover']=$this->Lica_m->fapprover($empNo);
          $data['sapprover']=$this->Lica_m->getSecondApprover($company,$branch,$dept);



          $data['info'] =  $this->Lica_m->phrInfo4($prid);
          $infos =  $this->Lica_m->phrInfo4($prid);
          $info =  $this->Lica_m->phrInfo3($prid,$dates,$empNo);
          $data['level']=$this->Lica_m->getJobLevel($company,$branch,$dept,$id);
          $data['item'] =  $this->Lica_m->itemInfo3($prid);
           $item =  $this->Lica_m->itemInfo3($prid);
            $item2 =  $this->Lica_m->itemInfo4($prid);
            $pp='';
            foreach ($item2 as $itm)
            {
                $pp.=$itm->Item_kind;
            }

            foreach($infos as $ifs)
            {

                $ifsapprover=$ifs->Approver;
                $ifsSapprover=$ifs->Second_approver;
            }
          $appinfo=$this->Lica_m->AppInfo($id);
            foreach($appinfo as $inf)
            {
              $infname=$inf->Fname;
              $inlname=$inf->Lname;
                 $contact=$inf->Contact;
                 $emailinf2=$inf->Email;
              $fullname=$infname.' '.$inlname.' ('.$contact.') ';;

            }
            foreach($info as $if)
            {
                  $Status=$if->Status;

            }

            if($pp == 'Company IDs')
                {
                     $approver=$this->Lica_m->recipients2();
                }else{
                     $approver=$this->Lica_m->recipients();
                }




            if($Status ==="Approve")
            {
            echo  "<script type='text/javascript'>";
            echo "alert('Request was already approved');";
            echo "window.close();";
            echo "</script>";
            }
            else if ($Status ==="Rejected"){

            echo  "<script type='text/javascript'>";
            echo "alert('Request was already declined.');";
            echo "window.close();";
            echo "</script>";
           }else if($Status ==="Wait for approval"){

             $itemxz=array();
            foreach($item as $row)
            {
                $items='Item name: "'.$row->Item_name.'" Item quantity:"'.$row->Item_quantity.$row->Unit.'"<br />';
            }
              echo  "<script type='text/javascript'>";
                echo "alert('".$items."');";
                echo "window.close();";
                echo "</script>";

          }else if($Status ==="New"){

            foreach($approver as $es)
            {
                $amp=$es->Email;
                $num=$es->MobileNumber;
                $data['fname']=$es->Fname;
                $data['lname']=$es->Lname;
                $data['id']=$es->id;

                $this->Lica_m->updateinfo2($prid,$dates,$emailinf2);
                $number1=str_replace("-","",$num);
                $number2= ltrim($number1, '0');
                $number3='63'.$number2;

                $itemsz='';
                foreach($item as $row)
                {

                  $itemsz.=$row->Item_quantity."-".$row->Unit."-".$row->Item_name."\n";

                }
                $str=$itemsz;
                $text="Purchase request PR#".$prid." has been submitted for P.O.\n".$str."";
                $asa=strlen($text);
                if ($asa <= 160) {
                $url = 'https://api.infobip.com/sms/1/text/single';
                $key = base64_encode("licagroup:TAlica03");
                $datas = array(
                 'from' => 'LicaGroup',
                 'to' => $number3,
                 'text' => $text,
                );

            $options = array(
                'http' => array(
                'header'  => array(
                "Authorization: Basic ".$key,
                "Content-type: application/json",
                ),
                'method'  => 'POST',
                'content' => json_encode($datas)
                )
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
             // if($result){
                    $data['number']=$this->Lica_m->phrinfo5($ifsapprover);
                    $data['numbers']=$this->Lica_m->phrInfo6($emailinf2);
                    $list = array($emailadd,$ifsapprover,$ifsSapprover);


                    date_default_timezone_set('Asia/Manila');
                    $this->load->library('email');
                    $this->email->from('admin@licagroup.biz', 'Lica Management System');
                    $this->email->to($amp,$emailadd,'EMAIL');
                    // $this->email->cc($ifsSapprover);
                    $this->email->subject('Purchase request PR#:'.$prid.' has been approved');
                    $msg = $this->load->view('email/approveEmail4',$data,TRUE);
                    $this->email->set_mailtype("html");
                    $this->email->message($msg);
                    $this->email->send();

                     echo  "<script type='text/javascript'>";
                    echo "alert('You have approved this request. An email was sent to confirm what you have approved. Thank you.');";
                    echo "window.close();";
                    echo "</script>";

                    $this->load->library('email');
                    $this->email->from('admin@licagroup.biz', 'Lica Management System');
                    $this->email->to($ifsapprover,'EMAIL');
                    // $this->email->cc($ifsSapprover);
                    $this->email->subject('Approved Purchase request PR#:'.$prid);
                    $msg = $this->load->view('email/approveEmail4',$data,TRUE);
                    $this->email->set_mailtype("html");
                    $this->email->message($msg);
                    $this->email->send();
            // }

        } else {
              $alaw=substr($text, 0, 107) . '...';
              $asos=strlen($alaw);


                    $url = 'https://api.infobip.com/sms/1/text/single';
            $key = base64_encode("licagroup:TAlica03");
            $datas = array(
             'from' => 'LicaGroup',
             'to' => $number3,
             'text' => $alaw,
            );

        $options = array(
            'http' => array(
            'header'  => array(
            "Authorization: Basic ".$key,
            "Content-type: application/json",
            ),
            'method'  => 'POST',
            'content' => json_encode($datas)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);


            if($result){

                $data['number']=$this->Lica_m->phrinfo5($ifsapprover);
                $data['numbers']=$this->Lica_m->phrInfo6($emailinf2);
                $list = array($emailadd,$ifsapprover,$ifsSapprover);

                date_default_timezone_set('Asia/Manila');
                $this->load->library('email');
                $this->email->from('admin@licagroup.biz', 'Lica Management System');
                $this->email->to($amp,$emailadd,'EMAIL');
                // $this->email->cc($ifsSapprover);
                $this->email->subject('Purchase request PR#:'.$prid);
                $msg = $this->load->view('email/approveEmail4',$data,TRUE);
                $this->email->set_mailtype("html");
                $this->email->message($msg);
                $this->email->send();

          $last_word_start = strrpos ( $alaw , ".");
            $last_word_end = strlen($alaw);
                $alawas=substr($text, $last_word_start, $last_word_end);
                // $asos=strlen($alaw);


                $url = 'https://api.infobip.com/sms/1/text/single';
                $key = base64_encode("licagroup:TAlica03");
                $datas = array(
                     'from' => 'LicaGroup',
                     'to' => $number3,
                     'text' => $alawas,
                );
                 $options = array(
                    'http' => array(
                    'header'  => array(
                    "Authorization: Basic ".$key,
                    "Content-type: application/json",
                    ),
                    'method'  => 'POST',
                    'content' => json_encode($datas)
                    )
                );
                $context  = stream_context_create($options);
                $results = file_get_contents($url, false, $context);
                    if($results){
                 echo  "<script type='text/javascript'>";
                echo "alert('You have approved the request.');";
                echo "window.close();";
                echo "</script>";
                    }

                }
            }
        // }
        }
        }
    }
    public function PendingPv()
    {
        is_login();
        $empNo = $this->session->userdata('lvIsLogin')['id'];
        $Lname=$this->session->userdata('lvIsLogin')['Lname'];
        $Fname=$this->session->userdata('lvIsLogin')['Fname'];
        $Mname=$this->session->userdata('lvIsLogin')['Mname'];
        $chApp = $this->Lica_m->getApprover3($empNo);
        if(count($chApp) <= 0){

            $this->session->set_flashdata('cMsgColor', 'danger');
            $this->session->set_flashdata('cMsg', 'Your account does not have an Approver. Please contact your Local hr to update your account.');
            header("Location:".base_url()."e/dashboard");

        }
        $datas['session_data'] = $this->session->userdata('lvIsLogin');
        $company = $this->session->userdata('lvIsLogin')['Company'];
        $branch = $this->session->userdata('lvIsLogin')['Branch'];
        $dept = $this->session->userdata('lvIsLogin')['Department'];
        $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
        $data['vsrv'] = $this->Lica_m->getVServices();

        if ($this->session->userdata('lvIsLogin')) {
            if ($this->session->userdata('lvIsLogin')['AccountStatus'] != 'Disabled') {
                    $data['session_data'] = $this->session->userdata('lvIsLogin');

                    $id = $this->session->userdata('lvIsLogin')['id'];
                    $empNo = $id;
                    $data['empId'] = $empNo;
                    $data['getCountPpr'] = $this->Lica_m->getCountPpr($empNo,$prid);
                    $this->load->view('header');
                    $this->load->view('summary/LICA_PURCHASE_PENDING_REQUEST',$data);
                    $this->load->view('footer');
            }

        }
    }
    public function RejectedPv()
    {
         is_login();
        $empNo = $this->session->userdata('lvIsLogin')['id'];
        $Lname=$this->session->userdata('lvIsLogin')['Lname'];
        $Fname=$this->session->userdata('lvIsLogin')['Fname'];
        $Mname=$this->session->userdata('lvIsLogin')['Mname'];
        $chApp = $this->Lica_m->getApprover3($empNo);
        if(count($chApp) <= 0){

            $this->session->set_flashdata('cMsgColor', 'danger');
            $this->session->set_flashdata('cMsg', 'Your account does not have an Approver. Please contact your Local hr to update your account.');
            header("Location:".base_url()."e/dashboard");

        }
        $datas['session_data'] = $this->session->userdata('lvIsLogin');
        $company = $this->session->userdata('lvIsLogin')['Company'];
        $branch = $this->session->userdata('lvIsLogin')['Branch'];
        $dept = $this->session->userdata('lvIsLogin')['Department'];
        $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
        $data['vsrv'] = $this->Lica_m->getVServices();

        if ($this->session->userdata('lvIsLogin')) {
            if ($this->session->userdata('lvIsLogin')['AccountStatus'] != 'Disabled') {
                    $data['session_data'] = $this->session->userdata('lvIsLogin');
                    $this->load->view('header');
                    $id = $this->session->userdata('lvIsLogin')['id'];
                    $empNo = $id;
                    $data['empId'] = $empNo;
                    $data['getCountPrr'] = $this->Lica_m->getCountPrr($empNo,$prid);
                    //$this->load->view('account/LICA_PUB_NAV');
                    $this->load->view('summary/LICA_PURCHASE_REJECETED_REQUEST',$data);

                    $this->load->view('footer');
            }

            }
        }
    public function ApprovedPv()
    {
         is_login();
        $empNo = $this->session->userdata('lvIsLogin')['id'];
        $Lname=$this->session->userdata('lvIsLogin')['Lname'];
        $Fname=$this->session->userdata('lvIsLogin')['Fname'];
        $Mname=$this->session->userdata('lvIsLogin')['Mname'];
        $chApp = $this->Lica_m->getApprover3($empNo);
        if(count($chApp) <= 0){

            $this->session->set_flashdata('cMsgColor', 'danger');
            $this->session->set_flashdata('cMsg', 'Your account does not have an Approver. Please contact your Local hr to update your account.');
            header("Location:".base_url()."e/dashboard");

        }
        $datas['session_data'] = $this->session->userdata('lvIsLogin');
        $company = $this->session->userdata('lvIsLogin')['Company'];
        $branch = $this->session->userdata('lvIsLogin')['Branch'];
        $dept = $this->session->userdata('lvIsLogin')['Department'];
        $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
        $data['vsrv'] = $this->Lica_m->getVServices();
        if ($this->session->userdata('lvIsLogin')) {
            if ($this->session->userdata('lvIsLogin')['AccountStatus'] != 'Disabled') {
                    $data['session_data'] = $this->session->userdata('lvIsLogin');
                    $this->load->view('header');
                    $id = $this->session->userdata('lvIsLogin')['id'];
                    $empNo = $id;
                    $data['empId'] = $empNo;
                    $data['getCountPar'] = $this->Lica_m->getCountPar($empNo,$prid);
                    //$this->load->view('account/LICA_PUB_NAV');
                    $this->load->view('summary/LICA_PURCHASE_APPROVED_REQUEST',$data);

                    $this->load->view('footer');
            }

      }

   }
    public function resendEmail($empNo,$date,$prid,$id)
    {
        is_login();
        $empNo=$this->Lica_m->getempno($prid)[0]->EmployeeNumber;
        $Lname=$this->session->userdata('lvIsLogin')['Lname'];
        $Fname=$this->session->userdata('lvIsLogin')['Fname'];
        $Mname=$this->session->userdata('lvIsLogin')['Mname'];
        $chApp = $this->Lica_m->getApprover3($empNo);
        if(count($chApp) <= 0){

            $this->session->set_flashdata('cMsgColor', 'danger');
            $this->session->set_flashdata('cMsg', 'Your account does not have an Approver. Please contact your Local hr to update your account.');
            header("Location:".base_url()."e/dashboard");

        }
        $datas['session_data'] = $this->session->userdata('lvIsLogin');
        $company = $this->session->userdata('lvIsLogin')['Company'];
        $branch = $this->session->userdata('lvIsLogin')['Branch'];
        $dept = $this->session->userdata('lvIsLogin')['Department'];
         $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
        $data['vsrv'] = $this->Lica_m->getVServices();

        $name = ucwords($Lname.', '.$Fname.' '.$Mname);
          $kind=$this->input->post('secretkind2');
         $this->load->model('Lica_m');
        $data['info'] =  $this->Lica_m->phrInfo2($empNo,$date,$prid);
        $info=  $this->Lica_m->phrInfo2($empNo,$date,$prid);
        // $this->Lica_m->getPrid($empNo,$date,$prid);

        $data['item'] =  $this->Lica_m->itemInfo2($date,$prid);
     foreach($info as $if)
      {
        $Status=$if->Status;
        $ifsapprover=$if->Approver;
        $ifsSapprover=$if->Second_approver;

      }
        $data['number']=$this->Lica_m->phrinfo5($ifsapprover);
        // print_r($info);
      if ($Status ==="Wait for approval"){

          $approver=$this->Lica_m->Fapprover($empNo);
          $i='0';
          foreach($approver as $es)
          {

             $amp=$es->Email;
             	$data['id']=$es->id;
             date_default_timezone_set('Asia/Manila');
            $this->load->library('email');
            $this->email->from('admin@licagroup.biz', 'Lica Management System');
            $this->email->to($amp, 'EMAIL');
            $this->email->subject('Purchase request resend for approval - PR# '.$prid);
            $msg = $this->load->view('email/approveEmail1',$data,TRUE);
            $this->email->set_mailtype("html");
            $this->email->message($msg);
            $this->email->send();

         }
          echo  "<script type='text/javascript'>";
            echo "alert('Resend purchase request to 1st approver successful');";
            echo "</script>";
      }else if ($Status ==="Wait for approval2"){

          $approvers=$this->Lica_m->getSecondApprover($company,$branch,$dept);
          foreach($approvers as $as)
          {

              $amps=$as->Email;
              	$data['id']=$as->id;
                date_default_timezone_set('Asia/Manila');
                $this->load->library('email');
                $this->email->from('admin@licagroup.biz', 'Lica Management System');
                $this->email->to($amps, 'EMAIL');
                $this->email->subject('Purchase request resend for approval - PR# '.$prid);
                $msg = $this->load->view('email/approveEmail3',$data,TRUE);
                $this->email->set_mailtype("html");
                $this->email->message($msg);
                $this->email->send();


          }
           echo  "<script type='text/javascript'>";
                echo "alert('Resend purchase request to 2nd approver successful');";
                echo "</script>";
      }
        // $this->PendingPV();
       echo "<script>window.location.href = '".base_url()."Purchase/PendingPV';</script>";

    }
    public function deletepending($empNo ,$date ,$prid )
    {
      // echo $empNo;
      // echo $date;

        is_login();
        $empNo = $this->session->userdata('lvIsLogin')['id'];
        $Lname=$this->session->userdata('lvIsLogin')['Lname'];
        $Fname=$this->session->userdata('lvIsLogin')['Fname'];
        $Mname=$this->session->userdata('lvIsLogin')['Mname'];
        $chApp = $this->Lica_m->getApprover3($empNo);
        if(count($chApp) <= 0){

            $this->session->set_flashdata('cMsgColor', 'danger');
            $this->session->set_flashdata('cMsg', 'Your account does not have an Approver. Please contact your Local hr to update your account.');
            header("Location:".base_url()."e/dashboard");

        }
        $datas['session_data'] = $this->session->userdata('lvIsLogin');
        $company = $this->session->userdata('lvIsLogin')['Company'];
        $branch = $this->session->userdata('lvIsLogin')['Branch'];
        $dept = $this->session->userdata('lvIsLogin')['Department'];
         $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
        $data['vsrv'] = $this->Lica_m->getVServices();


        $this->Lica_m->deletePending($prid);



        $this->PendingPV();
    }
    public function viewItem($empNo ,$date ,$prid )
    {
      // echo $empNo;
      // echo $date;

       is_login();
        $empNo = $this->session->userdata('lvIsLogin')['id'];
        $Lname=$this->session->userdata('lvIsLogin')['Lname'];
        $Fname=$this->session->userdata('lvIsLogin')['Fname'];
        $Mname=$this->session->userdata('lvIsLogin')['Mname'];
        $chApp = $this->Lica_m->getApprover3($empNo);
        if(count($chApp) <= 0){

            $this->session->set_flashdata('cMsgColor', 'danger');
            $this->session->set_flashdata('cMsg', 'Your account does not have an Approver. Please contact your Local hr to update your account.');
            header("Location:".base_url()."e/dashboard");

        }
        $datas['session_data'] = $this->session->userdata('lvIsLogin');
        $company = $this->session->userdata('lvIsLogin')['Company'];
        $branch = $this->session->userdata('lvIsLogin')['Branch'];
        $dept = $this->session->userdata('lvIsLogin')['Department'];
        $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
        $data['vsrv'] = $this->Lica_m->getVServices();

        // if ($this->session->userdata('lvIsLogin')) {
        //     if ($this->session->userdata('lvIsLogin')['AccountStatus'] != 'Disabled') {
                    $data['session_data'] = $this->session->userdata('lvIsLogin');

                    $id = $this->session->userdata('lvIsLogin')['id'];
                    $empNo = $id;
                    $data['empId'] = $empNo;
                    $data['getCountall'] = $this->Lica_m->getCountall($empNo,$prid);
                    $this->load->view('header');
                    $this->load->view('summary/LICA_PURCHASE_ITEM_SELECTED',$data);
                    $this->load->view('footer');
        //     }

        // }

        $this->session->set_flashdata('msg', 'Request form removed.');


        // header("Location:".base_url()."e/dashboard");
    }
    public function viewItem2($empNo ,$date ,$prid )
    {
      // echo $empNo;
      // echo $date;

       is_login();
        $empNo = $this->session->userdata('lvIsLogin')['id'];
        $Lname=$this->session->userdata('lvIsLogin')['Lname'];
        $Fname=$this->session->userdata('lvIsLogin')['Fname'];
        $Mname=$this->session->userdata('lvIsLogin')['Mname'];
        $chApp = $this->Lica_m->getApprover3($empNo);
        if(count($chApp) <= 0){

            $this->session->set_flashdata('cMsgColor', 'danger');
            $this->session->set_flashdata('cMsg', 'Your account does not have an Approver. Please contact your Local hr to update your account.');
            header("Location:".base_url()."e/dashboard");

        }
        $datas['session_data'] = $this->session->userdata('lvIsLogin');
        $company = $this->session->userdata('lvIsLogin')['Company'];
        $branch = $this->session->userdata('lvIsLogin')['Branch'];
        $dept = $this->session->userdata('lvIsLogin')['Department'];
        $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
        $data['vsrv'] = $this->Lica_m->getVServices();

        // if ($this->session->userdata('lvIsLogin')) {
        //     if ($this->session->userdata('lvIsLogin')['AccountStatus'] != 'Disabled') {
                    $data['session_data'] = $this->session->userdata('lvIsLogin');

                    $id = $this->session->userdata('lvIsLogin')['id'];
                    $empNo = $id;
                    $data['empId'] = $empNo;
                    $data['getCountall'] = $this->Lica_m->getCountall2($empNo,$prid);
                    $this->load->view('header');
                    $this->load->view('summary/LICA_PURCHASE_ITEM_SELECTED2',$data);
                    $this->load->view('footer');
        //     }

        // }

        $this->session->set_flashdata('msg', 'Request form removed.');


        // header("Location:".base_url()."e/dashboard");
    }
    public function viewItem3($empNo ,$date ,$prid )
    {
      // echo $empNo;
      // echo $date;

       is_login();
        $empNo = $this->session->userdata('lvIsLogin')['id'];
        $Lname=$this->session->userdata('lvIsLogin')['Lname'];
        $Fname=$this->session->userdata('lvIsLogin')['Fname'];
        $Mname=$this->session->userdata('lvIsLogin')['Mname'];
        $chApp = $this->Lica_m->getApprover3($empNo);
        if(count($chApp) <= 0){

            $this->session->set_flashdata('cMsgColor', 'danger');
            $this->session->set_flashdata('cMsg', 'Your account does not have an Approver. Please contact your Local hr to update your account.');
            header("Location:".base_url()."e/dashboard");

        }
        $datas['session_data'] = $this->session->userdata('lvIsLogin');
        $company = $this->session->userdata('lvIsLogin')['Company'];
        $branch = $this->session->userdata('lvIsLogin')['Branch'];
        $dept = $this->session->userdata('lvIsLogin')['Department'];
        $emailadd=$this->Lica_m->getAccountInfo($empNo)[0]->Email;
        $data['vsrv'] = $this->Lica_m->getVServices();

        // if ($this->session->userdata('lvIsLogin')) {
        //     if ($this->session->userdata('lvIsLogin')['AccountStatus'] != 'Disabled') {
                    $data['session_data'] = $this->session->userdata('lvIsLogin');

                    $id = $this->session->userdata('lvIsLogin')['id'];
                    $empNo = $id;
                    $data['empId'] = $empNo;
                    $data['getCountall'] = $this->Lica_m->getCountall3($empNo,$prid);
                    $this->load->view('header');
                    $this->load->view('summary/LICA_PURCHASE_ITEM_SELECTED3',$data);
                    $this->load->view('footer');
        //     }

        // }

        $this->session->set_flashdata('msg', 'Request form removed.');


        // header("Location:".base_url()."e/dashboard");
    }
    public function test()
    {
      $this->load->view('email/approveEmail1');
    }

}
?>
