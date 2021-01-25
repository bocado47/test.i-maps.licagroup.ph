<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

    public function __construct()
    {
        date_default_timezone_set('Asia/Manila');

        parent::__construct();
        if(!$this->session->userdata('logged_in'))
        {
          die("You don't have access here: <a href='".base_url()."Login'>Login Here! </a>");
        }

    }
    public function profile()
    {
        $this->load->view('user/Forms/profile');
    }
    public function changepas()
    {
        $this->load->view('user/Forms/change_password');
    }
    public function change()
    {
        $id=$this->input->post('id');
        $data=array(
            'password'=>MD5($this->input->post('newpass'))
        );
        $this->Main_m->ChangePassword($data,$id);

        echo json_encode($data);
    }
    public function index()
    {
         if($this->session->userdata('logged_in'))
            {
                $this->load->view('v2/partial/header');
                $this->load->view('user/mainView');
                $this->load->view('v2/partial/footer');
           }else{

            $this->load->view('LoginView');
           }
    }
    // PO FORM
    public function Purchase()
    {
        if($this->session->userdata('logged_in'))
            {
        $this->load->view('v2/partial/header');
        $this->load->view('user/mainView');
        $this->load->view('v2/partial/footer');
         }else{

            $this->load->view('LoginView');
           }
    }
    public function POForm()
    {
        $this->load->view('user/Forms/purchase_order_form');
    }
    public function POData()
    {
        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];
        $id=$datas->id;
        $type=$datas->type;

        $access=$this->Main_m->m_access($id);
        $dealer=array();
        foreach($access as $value) {
          $dealer[]=$value->key;
        }

        if($type == 1){
        }else{
        $getdealerid=$this->Dsar_m->newid($dealer);
        // print_r($getdealerid);
        // die();
        }

        $aColumns = array(
            // 'CheckBox',
            'P.O. Number',
            'P.O. Date',
            'P.O. Dealer',
            'Options'
        );

        // DB table to use
        if(isset($_GET['Status'])){
          if(strlen($_GET['Status']) > 0)
          {
            if($_GET['Status'] =='po')
            {
              $this->db->where('invtry_purchase_order.has_vehicle','0');
            }
            else if($_GET['Status'] =='pocs'){
              $this->db->where('invtry_purchase_order.has_vehicle','1');
            }
          }
        }

        $this->db->where('deleted','0');

        if($type == 1){

        }else{
          $this->db->group_start();
          foreach($getdealerid as $val)
          {

            $this->db->or_where('invtry_purchase_order.dealer =',$val->id);
          }
          $this->db->group_end();

        }
        $this->db->order_by('date_added','DESC');

        $sTable = 'invtry_purchase_order';

        $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            // $this->db->limit(10,20);
        }

        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                if($bSortable == 'true')
                {

                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }

        if(isset($sSearch) && !empty($sSearch))
        {
            $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
            for($i=0; $i<count($aColumns); $i++)
            {
                // Individual column filtering
            }

            if(isset($bSearchable) && $bSearchable == 'true')
            {
                //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("invtry_purchase_order.po_num", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_purchase_order.po_date", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="invtry_purchase_order.id,";
        $cSelect .="invtry_purchase_order.po_num as 'P.O. Number',";
        $cSelect .="invtry_purchase_order.po_num,";
        $cSelect .="invtry_purchase_order.po_date as 'P.O. Date',";
        $cSelect .="invtry_purchase_order.dealer,";
        $cSelect .="invtry_purchase_order.has_vehicle,";

        $this->db->select($cSelect, false);
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach($aColumns as $col)
            {
                if($col == 'P.O. Dealer')
                {
                  $aRow[$col] = '';
                  $dsardb=$this->load->database('dsar',TRUE);
                  $dsardb->where('company_branch.id',$aRow['dealer']);
                  $dsardb->from('company_branch');

                  $query = $dsardb->get();
            			$result = $query->result();

                  foreach($result as $value)
                  {
                    $aRow[$col]= $value->Company.' '.$value->Branch;
                  }
                }
                if($col == 'Options'){
                    $aRow[$col] = '';
                    if($aRow['has_vehicle'] == 1)
                    {
                        $dsardb=$this->load->database('dsar',TRUE);
                        $dsardb->where('company_branch.id',$aRow['dealer']);
                        $dsardb->from('company_branch');
                        $query = $dsardb->get();
                  			$result = $query->result();
                        foreach($result as $value)
                        {
                          $podealer= $value->Company.' '.$value->Branch;
                        }
                        $dl=explode(' ',trim($podealer));
                        if($dl[0] == 'MORRIS')
                        {
                          $dealer='MORRIS GARAGES';
                        }else if($dl[0] == 'KING'){
                          $dealer='KING LONG';
                        }else if($dl[0] == 'MINI'){
                          $dealer='MINI COOPER';
                        }else{
                          $dealer=$dl[0];
                        }

                        $checkdealer=$this->Main_m->chkdealer($dealer);


                        $ponum=$aRow['po_num'];
                        $getStatus=$this->Main_m->getInvtryStatus($ponum);
                        $status='';
                        foreach($getStatus as $value)
                        {
                          $status=$value->status;
                        }
                            foreach ($checkdealer as $val) {
                                $code=$val->car;

                                if($code == 1)
                                {
                                    if($status == 'Released')
                                    {
                                        $aRow[$col] .= "<button class='btn btn-sm btn-primary btnview1' value='".$aRow['id']."'>View</button>";
                                        $aRow[$col] .= " <button class='btn btn-sm btn-danger deletePo' value='".$aRow['id']."'>Delete</button>";
                                    }else{
                                      $aRow[$col] .= "<button class='btn btn-sm btn-primary btnview1' value='".$aRow['id']."'>View</button>";
                                      if($type == 1){
                                        $aRow[$col] .= " <button class='btn btn-sm btn-danger deletePo' value='".$aRow['id']."'>Delete</button>";
                                      }else{
                                      }

                                    }
                                }else if($code == 0){
                                    if($aRow['vid'] == 0)
                                    {
                                        $aRow[$col] .= "<button class='btn btn-sm btn-danger closePO' value='".$aRow['id']."'>Close</button>";
                                        if($status == 'Released')
                                        {

                                        }else{
                                          $aRow[$col] .= " <button class='btn btn-sm btn-danger deletePo' value='".$aRow['id']."'>Delete</button>";
                                        }
                                    }else if($aRow['vid'] == 1)
                                    {
                                        $aRow[$col] .= "<button class='btn btn-sm btn-success openPO' value='".$aRow['id']."'>Open</button>";
                                        if($status == 'Released')
                                        {

                                        }else{
                                          if($type == 1){
                                            $aRow[$col] .= " <button class='btn btn-sm btn-danger deletePo' value='".$aRow['id']."'>Delete</button>";
                                          }else{
                                          }
                                        }
                                    }
                                }else{
                                  $aRow[$col] .= "<button class='btn btn-sm btn-primary btnview1' value='".$aRow['id']."'>View</button>";
                                  if($type == 1){
                                    $aRow[$col] .= " <button class='btn btn-sm btn-danger deletePo' value='".$aRow['id']."'>Delete</button>";
                                  }else{
                                  }
                                }
                            }
                    }else{
                        if($type == 1){
                         $aRow[$col] .= "<button class='btn btn-sm btn-primary btnview' value='".$aRow['id']."'>View / Edit</button> <button class='btn btn-sm btn-success btnnadd' value='".$aRow['P.O. Number']."'>Add Vehicle</button> <button class='btn btn-sm btn-danger deletePo' value='".$aRow['id']."'>Delete</button>";
                       }else{
                         $aRow[$col] .= "<button class='btn btn-sm btn-primary btnview' value='".$aRow['id']."'>View / Edit</button> <button class='btn btn-sm btn-success btnnadd' value='".$aRow['P.O. Number']."'>Add Vehicle</button>";
                       }
                    }

                }

                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;

        }
        echo json_encode($output);
    }
    public function deletePo()
    {
      $id=$_GET['id'];

      $searchpo=$this->Dashboard_m->poM($id);
      foreach($searchpo as $value)
      {
        $ponum=$value->po_num;
        $model=$value->model;
        $color=$value->color;

        $updateTotal=$this->Dashboard_m->updateTotal($model,$color);
      }
      $this->Main_m->deletepo($id);
      $this->Main_m->deletepostatus($ponum);
      $this->Main_m->deletepostatus2($ponum);
      $this->Main_m->deleteConnectedV($id);
    }
    public function deleteCS()
    {
      $csnum=$_GET['id'];
      $ponum=$_GET['ponum'];
      $data2=array("status"=>'No Vehicle');
      $this->Main_m->deleteVehicle($csnum);
      $this->Main_m->deleteVehicle2($data2,$ponum);
      $this->Main_m->deleteVehicle3($data2,$ponum);
      $data=array("has_vehicle"=>'0');
      $this->Main_m->updateVStatus($ponum,$data);
    }
    public function POinfo()
    {
        $id=$_GET['id'];
        $data['id']=$id;
        $data['info']=$this->Main_m->info($id);
        $cm=$this->Main_m->info($id);
        $dealer_id='';
        foreach($cm as $vl)
        {
          $dealer_id=$vl->dealer;
        }
        $data['info2']=$this->Dsar_m->cm2($dealer_id);
        // print_r($data);
        $this->load->view('user/Forms/purchase_order_view',$data);
    }
    public function POinfo1()
    {
        $id=$_GET['id'];
        $data['id']=$id;
        $data['info']=$this->Main_m->info($id);
        // print_r($data);
        $this->load->view('user/Forms/purchase_order_view1',$data);
    }
    public function addPO()
    {
        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];
        $oldpo=$this->input->post('po_num');
        $newpo = str_replace(' ', '', $oldpo);
        $wsp=$this->input->post('whole_sale_period');
        if(strlen($wsp) > 0)
        {
          $wspArray= explode('-', $wsp);
          $date = new DateTime();
          $date->setDate($wspArray[1], $wspArray[0], 01);
          $newwsp=$date->format('Y-m-d');
        }
        $conf_order=$this->input->post('conf_order');
        $confvalue=0;
        if(strlen($conf_order) > 0)
        {
          $confvalue=1;
        }else{
          $confvalue=0;
        }
        $po_date=date('Y-m-d',strtotime($this->input->post('po_date')));
        $oldcost=$this->input->post('cost');
        $cost=str_replace( ',', '', $oldcost);
        $data=array(
            'po_num' => strtoupper($newpo),
            'po_date' => $po_date,
            'dealer' => $this->input->post('dealer'),
            'model' => $this->input->post('model'),
            'model_yr' => $this->input->post('model_yr'),
            'color' => $this->input->post('color'),
            'cost' => $cost,
            'conf_order' =>$confvalue,
            'whole_sale_period' => $newwsp,
            'remarks' => $this->input->post('remarks'),
            'added_by' => $datas->id,
            'deleted' => 0
        );
        // print_r($data);
        $lastid=$this->Main_m->insertPO($data);
        $status='No Vehicle';

        $status_data=array(
          'po_number'=>strtoupper($newpo),
          'status'=>$status
        );
        $this->Main_m->insertStatus($status_data);
        $this->Main_m->insertStatusAC($status_data);
    }
    public function editPO()
    {
        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];
        $poid=$this->input->post('poid');
        $dealerpost=$this->input->post('dealer');
        $po_num=$this->input->post('po_num');

        $getinfopo=$this->Main_m->getinfopo($poid);
        $dealer='';
        foreach($getinfopo as $value)
        {
            $dealer.=$value->dealer;

        }
        if($dealer == $dealerpost)
        {
            $data2=array('model'=>NULL,'model_yr'=>NULL);
            $updateVehicle=$this->Main_m->updateVPO($data2,$po_num);
        }
        $oldcost=$this->input->post('cost');
        $cost=str_replace(',', '', $oldcost);
        $podate=$this->input->post('po_date');
        if($podate != '')
        {
          $npodate=date("Y-m-d", strtotime($podate));
        }else{
          $npodate=NULL;
        }
        $wsp=$this->input->post('whole_sale_period');
        if(strlen($wsp) > 0)
        {
          $wspArray= explode('-', $wsp);
          $date = new DateTime();
          $date->setDate($wspArray[1], $wspArray[0], 01);
          $newwsp=$date->format('Y-m-d');
        }else
        {
          $newwsp=NULL;
        }
        $conf_order=$this->input->post('conf_order');
        $confvalue=0;
        if(strlen($conf_order) > 0)
        {
          $confvalue=1;
        }else{
          $confvalue=0;
        }
        $testDrive=$this->input->post('testDrive');
        $testDriveValue=0;
        if(strlen($testDrive) > 0)
        {
          $testDriveValue=1;
        }else{
          $testDriveValue=0;
        }

        $data=array(
            'po_num' => $this->input->post('po_num'),
            'po_date' => $npodate,
            'dealer' => $this->input->post('dealer'),
            'dealer' => $this->input->post('dealer'),
            'model' => $this->input->post('model'),
            'model_yr' => $this->input->post('model_yr'),
            'color' => $this->input->post('color'),
            'cost' => $cost,
            'conf_order' => $confvalue,
            'testDrive' => $testDriveValue,
            'remarks' => $this->input->post('remarks'),
            'whole_sale_period' => $newwsp,
            'added_by' => $datas->id,
            'deleted' => 0
        );

        $this->Main_m->updatePO($data,$poid);

        $getDetails=$this->Dashboard_m->getDetails2($po_num);
        foreach($getDetails as $value)
        {
            $po_num=$value->po_num;
            $ardI=$value->imaps_actual_release_date;
            if($ardI != ''){
              $nardI=date("Y-m-d", strtotime($ardI));
            }else{
              $nardI= NULL;
            }
            $veh_received=$value->veh_received;

            if($veh_received != '0000-00-00' AND $veh_received != ''){
                $veh_received=date("Y-m-d", strtotime($veh_received));
            }else{
              $veh_received= NULL;
            }

            // INVENTORY STATUS
            $invtry_status=array();
              if($veh_received != NULL)
              {
                if($nardI != NULL)
                {
                  $invtry_status=array('status' => 'Released' );
                }else{
                  $invtry_status=array('status' => 'Received' );
                }
              }else{
                $invtry_status=array('status' => 'For Pull Out' );
              }

            // INVENTORY STATUS

            // ACCOUNT STATUS
            $cs_num=$value->cs_num;
            if($cs_num == '')
            {
              $cs_num=NULL;
            }

            $model=$value->model;
            if($model == '')
            {
              $model=NULL;
            }

            $model_yr=$value->model_yr;
            if($model_yr == '')
            {
              $model_yr=NULL;
            }

            $alloc_date=$value->alloc_date;
            if($alloc_date != '0000-00-00' AND $alloc_date != ''){
                $alloc_date=date("Y-m-d", strtotime($alloc_date));
            }else{
              $alloc_date= NULL;
            }

            $plant_sales_month=$value->plant_sales_month;
            if(strlen($plant_sales_month) > 0)
            {
              $psmArray= explode('-', $plant_sales_month);
              $date = new DateTime();
              $date->setDate($psmArray[1], $psmArray[0], 01);
              $plant_sales_month=$date->format('Y-m-d');
            }else
            {
              $plant_sales_month=NULL;
            }

            $alloc_dealer=$value->alloc_dealer;
            if($alloc_dealer == '')
            {
              $alloc_dealer=NULL;
            }

            $plant_sales_report=$value->plant_sales_report;
            if($plant_sales_report == '')
            {
              $plant_sales_report=NULL;
            }

            $gpdata=$this->Gp_m->get_details2($cs_num);
            $invtry_acc_status=array();
            if($cs_num != NULL AND $model != NULL AND $model_yr != NULL)
            {
              if($alloc_date != NULL AND $alloc_dealer != NULL)
              {
                if(count($gpdata) > 0 ){
                  foreach($gpdata as $val)
                  {
                    $invoice_date=$val->invoice_date;
                    if($invoice_date != '0000-00-00' AND $invoice_date != ''){
                        $invoice_date=date("Y-m-d", strtotime($invoice_date));
                    }else{
                      $invoice_date= NULL;
                    }
                    $post_status=$val->post_status;
                    if($post_status == '')
                    {
                      $post_status=NULL;
                    }
                  }
                 if($post_status != 'trash'){
                   if($invoice_date != NULL)
                   {
                     if($plant_sales_report != NULL  AND $plant_sales_month != NULL )
                     {
                       $invtry_acc_status=array('status' => 'Reported' );
                       $checkAccStatus=$this->Dashboard_m->checkAccStatus($po_num);

                       if(count($checkAccStatus) > 0)
                       {
                         $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
                       }else{
                         $status_data=array(
                           'po_number'=>$po_num,
                           'status'=>$invtry_acc_status['status']
                         );
                         $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
                       }
                     }else{
                       $invtry_acc_status=array('status' => 'Invoiced');
                       $checkAccStatus=$this->Dashboard_m->checkAccStatus($po_num);

                       if(count($checkAccStatus) > 0)
                       {
                         $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
                       }else{
                         $status_data=array(
                           'po_number'=>$po_num,
                           'status'=>$invtry_acc_status['status']
                         );
                         $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
                       }
                     }
                   }else if($invoice_date != NULL)
                   {
                     if($plant_sales_report != NULL  AND $plant_sales_month != NULL  )
                     {
                       $invtry_acc_status=array('status' => 'Reported' );
                       $checkAccStatus=$this->Dashboard_m->checkAccStatus($po_num);

                       if(count($checkAccStatus) > 0)
                       {
                         $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
                       }else{
                         $status_data=array(
                           'po_number'=>$po_num,
                           'status'=>$invtry_acc_status['status']
                         );
                         $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
                       }
                     }else{
                       $invtry_acc_status=array('status' => 'Invoiced');
                       $checkAccStatus=$this->Dashboard_m->checkAccStatus($po_num);

                       if(count($checkAccStatus) > 0)
                       {
                         $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
                       }else{
                         $status_data=array(
                           'po_number'=>$po_num,
                           'status'=>$invtry_acc_status['status']
                         );
                         $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
                       }
                     }
                   }else{
                   $invtry_acc_status=array('status' => 'Allocated' );
                   $checkAccStatus=$this->Dashboard_m->checkAccStatus($po_num);

                   if(count($checkAccStatus) > 0)
                   {
                     $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
                   }else{
                     $status_data=array(
                       'po_number'=>$po_num,
                       'status'=>$invtry_acc_status['status']
                     );
                     $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
                   }
                  }
                 }else{
                 $invtry_acc_status=array('status' => 'Allocated' );
                 $checkAccStatus=$this->Dashboard_m->checkAccStatus($po_num);

                 if(count($checkAccStatus) > 0)
                 {
                   $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
                 }else{
                   $status_data=array(
                     'po_number'=>$po_num,
                     'status'=>$invtry_acc_status['status']
                   );
                   $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
                 }
                }

              }else{
                  $invtry_acc_status=array('status' => 'Allocated' );
                  $checkAccStatus=$this->Dashboard_m->checkAccStatus($po_num);

                  if(count($checkAccStatus) > 0)
                  {
                    $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
                  }else{
                    $status_data=array(
                      'po_number'=>$po_num,
                      'status'=>$invtry_acc_status['status']
                    );
                    $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
                  }
              }

            }else{
                $invtry_acc_status=array('status' => 'Available' );
                $checkAccStatus=$this->Dashboard_m->checkAccStatus($po_num);

                if(count($checkAccStatus) > 0)
                {
                  $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
                }else{
                  $status_data=array(
                    'po_number'=>$po_num,
                    'status'=>$invtry_acc_status['status']
                  );
                  $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
                }
            }
          }
            // ACCOUNT STATUS

                $checkInvStatus=$this->Dashboard_m->checkInvStatus($po_num);
            if(count($checkInvStatus) > 0)
            {
              $updateStatus1=$this->Main_m->updateIS($po_num,$invtry_status);
            }else{
              $status_data=array(
                'po_number'=>$po_num,
                'status'=>$invtry_status['status']
              );
              $insertStatus1=$this->Dashboard_m->insertStatus($status_data);
            }
        }
        echo json_encode($data);
    }
    public function check_po_num()
    {
        $newponum=$_GET['ponum'];
        $ponum=strtolower($newponum);
        $check=$this->Main_m->checkponum($ponum);
        $countcheck=count($check);
        echo json_encode($countcheck);
    }
    public function addVehicle2()
    {
        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];

        $PO=$this->input->post('purchase_order');
        $po_num=$this->input->post('po_num');
        $data3= explode(",",$PO);

        $loc=$this->input->post('location');
        $cust_name=$this->input->post('cust_name');
        $inv_num=$this->input->post('inv_date');

        $oldcost=$this->input->post('cost');
        $cost=str_replace( ',', '', $oldcost);

        $oldamt=$this->input->post('inv_amt');
        $inv_amt=str_replace(',','',$oldamt);

        $oldcsnum=$this->input->post('cs_num');
        $csnum = str_replace(' ', '', $oldcsnum);
        $newcsnum=$csnum;

        $po_id=strtolower($data3[2]);

        $check=$this->Main_m->checkpurchaseorder2($po_id);
        $countcheck=count($check);

        $check2=$this->Main_m->checkcsnum2($newcsnum);
        $countcheckcs=count($check2);

        $whole_sale_period=$this->input->post('whole_sale_period');
        $datapo=array('whole_sale_period' => $whole_sale_period);
        $insert_wsp=$this->Dashboard_m->insert_wsp($po_num,$datapo);

        if($countcheck > 0)
        {
            echo json_encode($countcheck);
        }else if($countcheckcs > 0){
            echo json_encode($countcheckcs);
        }else{
            $data=array(
                'cs_num' => strtoupper($csnum),
                'model' => $this->input->post('model'),
                'model_yr' => $this->input->post('model_yr'),
                'location' => $loc,
                'purchase_order' => $po_id,
                'vrr_num' => $this->input->post('vvr_num'),
                'color' => $this->input->post('color'),
                'vin_num' => $this->input->post('vin_num'),
                'engine_num' => $this->input->post('eng_num'),
                'cost' => $cost,
                'remarks' => $this->input->post('remarks'),
                'veh_received'=>$this->input->post('received_date'),
                'csr_received'=>$this->input->post('csr_date'),
                'subsidy_claiming'=>$this->input->post('subsidy_claiming'),
                'subsidy_claimed'=>$this->input->post('subsidy_claimed'),
                'alloc_date'=>$this->input->post('alloc_date'),
                'alloc_dealer'=>$this->input->post('alloc_dealer'),
                'plant_sales_report'=>$this->input->post('plant_sales_report'),
                'plant_sales_month'=>$this->input->post('plant_sales_month'),
                'prod_num' => $this->input->post('prod_num'),
                'paid_date'=>$this->input->post('paid_date'),
                'added_by' => $datas->id,
                'deleted' => 0
            );

            $cs_id=$this->Main_m->insertVehicle($data);
            $check=$this->Main_m->checkpurchaseorder($po_id);

            $po_data=array('has_vehicle'=> 1);
            $this->Main_m->updatePOs($po_data,$po_id);

            $getDetails=$this->Dashboard_m->getDetails2($po_num);
            foreach($getDetails as $value)
            {
                $po_num=$value->po_num;
                $ardI=$value->imaps_actual_release_date;
                if($ardI != ''){
                  $nardI=date("Y-m-d", strtotime($ardI));
                }else{
                  $nardI= NULL;
                }
                $veh_received=$value->veh_received;

                if($veh_received != '0000-00-00' AND $veh_received != ''){
                    $veh_received=date("Y-m-d", strtotime($veh_received));
                }else{
                  $veh_received= NULL;
                }

                // INVENTORY STATUS
                $invtry_status=array();
                  if($veh_received != NULL)
                  {
                    if($nardI != NULL)
                    {
                      $invtry_status=array('status' => 'Released' );
                    }else{
                      $invtry_status=array('status' => 'Received' );
                    }
                  }else{
                    $invtry_status=array('status' => 'For Pull Out' );
                  }
                  $updateStatus1=$this->Main_m->updateIS($po_num,$invtry_status);
                // INVENTORY STATUS

                // ACCOUNT STATUS
                $cs_num=$value->cs_num;
                if($cs_num == '')
                {
                  $cs_num=NULL;
                }

                $model=$value->model;
                if($model == '')
                {
                  $model=NULL;
                }

                $model_yr=$value->model_yr;
                if($model_yr == '')
                {
                  $model_yr=NULL;
                }

                $alloc_date=$value->alloc_date;
                if($alloc_date != '0000-00-00' AND $alloc_date != ''){
                    $alloc_date=date("Y-m-d", strtotime($alloc_date));
                }else{
                  $alloc_date= NULL;
                }

                $plant_sales_month=$value->plant_sales_month;
                if(strlen($plant_sales_month) > 0)
                {
                  $psmArray= explode('-', $plant_sales_month);
                  $date = new DateTime();
                  $date->setDate($psmArray[1], $psmArray[0], 01);
                  $plant_sales_month=$date->format('Y-m-d');
                }else
                {
                  $plant_sales_month=NULL;
                }

                $alloc_dealer=$value->alloc_dealer;
                if($alloc_dealer == '')
                {
                  $alloc_dealer=NULL;
                }

                $plant_sales_report=$value->plant_sales_report;
                if($plant_sales_report == '')
                {
                  $plant_sales_report=NULL;
                }

                $gpdata=$this->Gp_m->get_details2($cs_num);
                $invtry_acc_status=array();
                if($cs_num != NULL AND $model != NULL AND $model_yr != NULL)
                {
                  if($alloc_date != NULL AND $alloc_dealer != NULL)
                  {
                    if(count($gpdata) > 0 ){
                      foreach($gpdata as $val)
                      {
                        $invoice_date=$val->invoice_date;
                        if($invoice_date != '0000-00-00' AND $invoice_date != ''){
                            $invoice_date=date("Y-m-d", strtotime($invoice_date));
                        }else{
                          $invoice_date= NULL;
                        }
                        $post_status=$val->post_status;
                        if($post_status == '')
                        {
                          $post_status=NULL;
                        }
                      }
                     if($post_status != 'trash'){
                       if($invoice_date != NULL)
                       {
                         if($plant_sales_report != NULL  AND $plant_sales_month != NULL )
                         {
                           $invtry_acc_status=array('status' => 'Reported' );
                         }else{
                           $invtry_acc_status=array('status' => 'Invoiced');
                         }
                       }else if($invoice_date != NULL)
                       {
                         if($plant_sales_report != NULL  AND $plant_sales_month != NULL  )
                         {
                           $invtry_acc_status=array('status' => 'Reported' );
                         }else{
                           $invtry_acc_status=array('status' => 'Invoiced');
                         }
                       }else{
                       $invtry_acc_status=array('status' => 'Allocated' );
                      }
                     }else{
                     $invtry_acc_status=array('status' => 'Allocated' );
                    }

                  }else{
                      $invtry_acc_status=array('status' => 'Allocated' );
                  }

                }else{
                    $invtry_acc_status=array('status' => 'Available' );
                }
              }
                // ACCOUNT STATUS
                // $checkAccStatus=$this->Dashboard_m->checkAccStatus($po_num);
                // $checkInvStatus=$this->Dashboard_m->checkInvStatus($po_num);
                // if(count($checkAccStatus) > 0)
                // {
                  $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
                // }else{
                //   $status_data=array(
                //     'po_number'=>$po_num,
                //     'status'=>$invtry_acc_status['status']
                //   );
                //   $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
                // }
                //
                // if(count($checkInvStatus) > 0)
                // {

                // }else{
                //   $status_data=array(
                //     'po_number'=>$po_num,
                //     'status'=>$invtry_status['status']
                //   );
                //   $insertStatus1=$this->Dashboard_m->insertStatus($status_data);
                // }
            }
            echo json_encode($countcheck);
        }
    }
    // PO FORM END
    // VEHICLE FORM
    public function Vehicle()
    {
        if($this->session->userdata('logged_in'))
            {
        $this->load->view('v2/partial/header');
        $this->load->view('user/vehicleView');
        $this->load->view('v2/partial/footer');
      }else{
         $this->load->view('LoginView');
        }
    }
    public function VehicleForm()
    {
        $this->load->view('user/Forms/vehicle_form');
    }
    public function POVehicleForm()
    {
        $po_num=$_GET['po_num'];
        $data['podata']=$this->Main_m->podatan($po_num);
        $this->load->view('user/Forms/purchase_vehicle_form',$data);
    }
    public function VehicleInvoice()
    {
        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];
        $id=$datas->id;
        $type=$datas->type;
        $access=$this->Main_m->m_access($id);
        $dealer=array();
        foreach($access as $value) {
          $dealer[]=$value->key;
        }
        if($type == 1){
        }else{
        $getdealerid=$this->Main_m->newid($dealer);
        }

        $aColumns = array(
            'CheckBox',
            'CS Number',
            'P.O Number',
            'Car',
            'Dealer',
            'Status',
            'Options'
        );

        // DB table to use

        $this->db->order_by('invtry_vehicle.date_added','DESC');
        $this->db->where('invtry_vehicle.deleted','0');
        $this->db->where('invtry_purchase_order.deleted',0);
        $this->db->where('invtry_status.status !=','Released');
        if($type == 1){

        }else{
          $this->db->group_start();
          foreach($getdealerid as $val)
          {
            // print_r($value->id);
            // die();
            $this->db->or_where('invtry_purchase_order.dealer =',$val->id);
          }
          $this->db->group_end();

        }
        if(isset($_GET['Status'])){
          if(strlen($_GET['Status']) > 0)
          {
            if($_GET['Status'] =='Available')
            {
              $this->db->where('invtry_status.status','Available');
            }
            else if($_GET['Status'] =='For Pull Out'){
              $this->db->where('invtry_status.status','For Pull Out');
            }
            else if($_GET['Status'] =='Released'){
              $this->db->where('invtry_status.status','Released');
            }
            else if($_GET['Status'] =='Invoiced'){
              $this->db->where('invtry_status.status','Invoiced');
            }
            else if($_GET['Status'] =='Allocated'){
              $this->db->where('invtry_status.status','Allocated');
            }
          }
        }

        $sTable = 'invtry_vehicle';

        $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            // $this->db->limit(10,20);
        }

        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                if($bSortable == 'true')
                {

                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }

        if(isset($sSearch) && !empty($sSearch))
        {
            $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
            for($i=0; $i<count($aColumns); $i++)
            {
                // Individual column filtering
            }

            if(isset($bSearchable) && $bSearchable == 'true')
            {
                //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("invtry_purchase_order.po_num", $this->db->escape_like_str($sSearch),'both');
                 $this->db->or_like("CONCAT(product.Product,' ',invtry_vehicle.model_yr)", $this->db->escape_like_str($sSearch),'both');
                 $this->db->or_like("invtry_vehicle.cs_num", $this->db->escape_like_str($sSearch),'both');
                 $this->db->or_like("invtry_status.status", $this->db->escape_like_str($sSearch),'both');
                 $this->db->or_like("CONCAT(company_branch.Company,' ',company_branch.Branch)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="invtry_vehicle.id as 'CheckBox',";
        $cSelect .="invtry_vehicle.id as 'ids',";
        $cSelect .="invtry_vehicle.cs_num as'CS Number',";
        $cSelect .="invtry_vehicle.model as 'Model',";
        $cSelect .="invtry_vehicle.model_yr as 'ModelYR',";
        $cSelect .="invtry_vehicle.purchase_order as 'P.O Number',";
        $cSelect .="invtry_vehicle.model,";
        $cSelect .="invtry_vehicle.location as 'Location',";
        $cSelect .="invtry_vehicle.vrr_num,";
        $cSelect .="invtry_vehicle.vrr_date,";
        $cSelect .="invtry_vehicle.color,";
        $cSelect .="invtry_vehicle.vin_num,";
        $cSelect .="invtry_vehicle.cost as 'Cost',";
        $cSelect .="invtry_vehicle.remarks,";
        $cSelect .="invtry_vehicle.veh_received as'received',";
        $cSelect .="invtry_vehicle.date_added,";
        $cSelect .="invtry_vehicle.added_by,";
        $cSelect .="invtry_vehicle.has_invoice,";
        $cSelect .="invtry_vehicle.is_release,";
        $cSelect .="invtry_vehicle.deleted,";
        $cSelect .="invtry_purchase_order.po_num as 'P.O Number',";
        $cSelect .="CONCAT(product.Product,' ',invtry_vehicle.model_yr) as 'Car',";
        $cSelect .="CONCAT(company_branch.Company,' ',company_branch.Branch) as 'Dealer',";
        // $cSelect .="invtry_purchase_order.dealer as 'Dealer',";
        $cSelect .="invtry_status.status,";

        $this->db->select($cSelect, false);
        $this->db->join('invtry_status','invtry_status.cs_num = invtry_vehicle.cs_num','left');
        $this->db->join('invtry_purchase_order','invtry_purchase_order.id = invtry_vehicle.purchase_order','left');
        $this->db->join('product','product.id = invtry_vehicle.model','left');
        $this->db->join('invtry_invoice','invtry_invoice.vehicle_id = invtry_vehicle.id','left');
        $this->db->join('company_branch','company_branch.id = invtry_invoice.grp_lica','left');
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');

        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach($rResult->result_array() as $aRow)
        {
            $row = array();
            $id=$aRow['CheckBox'];
            foreach($aColumns as $col)
            {
                if($col == 'CheckBox')
                {

                  $aRow[$col] = "<input type='checkbox' name='check[]' class='checkbox' value='".$id."'/>";
                }

                $ids=$aRow['ids'];
                $newdealer=$this->Main_m->ndealer($ids);
                $did='';
                foreach($newdealer as $vls)
                {
                  $did=$vls->grp_lica;
                }

                if($col == 'Status'){
                    $aRow[$col] = '';
                    $cs=$aRow['CS Number'];
                    $poid=$aRow['P.O Number'];
                    // echo $cs.$poid;
                     $stats=$aRow['status'];
                        if($stats == 'Available')
                        {
                            $aRow[$col]='<z style="color:Green;">'.$stats.'</z>';
                        }
                        else if($stats == 'Allocated')
                        {
                            $aRow[$col]='<z style="color:Violet;">'.$stats.'</z>';
                        }
                        else if($stats == 'Invoiced')
                        {
                            $aRow[$col]='<z style="color:orange;">'.$stats.'</z>';
                        }
                        else if($stats == 'Released')
                        {
                            $aRow[$col]='<z style="color:red;">'.$stats.'</z>';
                        }
                        else if($stats == 'For Pull Out')
                        {
                            $aRow[$col]=$stats;
                        }
                 }

                if($col == 'Options'){
                    $aRow[$col] = '';
                    $cs=$aRow['CS Number'];
                    $poid=$aRow['P.O Number'];
                    // echo $cs.$poid;
                     $stats=$aRow['status'];
                        if($stats == 'Available')
                        {
                            $aRow[$col]='<button class="btn btn-sm btn-primary info" value="'.$cs.'">View Details</button> <button class="btn btn-sm btn-success alloc" value="'.$cs.'">Allocate</button> <button class="btn btn-danger btn-sm deleteveh" value="'.$cs.','.$poid.'">Delete</button>';
                        }
                        else if($stats == 'Allocated')
                        {
                            $vids=$aRow['ids'];
                            $id=$this->Main_m->grp($vids);
                            $aRow[$col]='<button class="btn btn-sm btn-primary info" value="'.$cs.'">View Details</button>  <button class="btn btn-sm btn-danger Adddealer" value="'.$id[0]->grp_lica.','.$vids.'">Change Alloc Dealer</button> <button class="btn btn-danger btn-sm deleteveh" value="'.$cs.','.$poid.'">Delete</button>';
                        }
                        else if($stats == 'Invoiced')
                        {
                            $aRow[$col]='<button class="btn btn-sm btn-primary info" value="'.$cs.'">View Details</button> <button class="btn btn-sm btn-success releaseds" value="'.$cs.'">Release</button> <button class="btn btn-danger btn-sm deleteveh" value="'.$cs.','.$poid.'">Delete</button>';
                        }
                        else if($stats == 'Released')
                        {
                            $aRow[$col]='';
                        }
                        else if($stats == 'For Pull Out')
                        {
                            $aRow[$col]='<button class="btn btn-sm btn-primary info" value="'.$cs.'">View Details</button> <button class="btn btn-sm btn-primary received" value="'.$cs.'">Received</button> <button class="btn btn-danger btn-sm deleteveh" value="'.$cs.','.$poid.'">Delete</button>';
                        }

                }
                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }
    public function model_color()
    {
      $model_id=$_GET['model_id'];

      $color=$this->Main_m->get_color($model_id);
      echo json_encode($color);
    }
    public function deleteVehicle()
    {
      $id=$_GET['id'];
      $ar=explode(",",$id);
      $csnum=$ar[0];
      $poid=$ar[1];

      $data1=array('deleted'=>1);
      $data2=array('has_vehicle'=>0);

      $this->Main_m->dv($data1,$csnum);
      $this->Main_m->pu($data2,$poid);
      $this->Main_m->deleteVehicle($csnum);
    }
    public function addVehicle()
    {
        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];
        $PO=$this->input->post('purchase_order');
        $data3= explode(",",$PO);
        $loc=$this->input->post('location');
        $cust_name=$this->input->post('cust_name');
        $inv_num=$this->input->post('inv_date');
        $oldcost=$this->input->post('cost');
        $cost=str_replace( ',', '', $oldcost);
        $oldamt=$this->input->post('inv_amt');
        $inv_amt=str_replace(',','',$oldamt);
        $oldcsnum=$this->input->post('cs_num');
        $csnum = str_replace(' ', '', $oldcsnum);

        $data=array(
            'cs_num' => strtolower($csnum),
            'model' => $this->input->post('model'),
            'model_yr' => $this->input->post('model_yr'),
            'location' => $loc,
            'purchase_order' => $data3[2],
            'vrr_num' => $this->input->post('vvr_num'),
            'color' => $this->input->post('color'),
            'vin_num' => $this->input->post('vin_num'),
            'engine_num' => $this->input->post('eng_num'),
            'cost' => $cost,
            'remarks' => $this->input->post('remarks'),
            'veh_received'=>$this->input->post('received_date'),
            'csr_received'=>$this->input->post('csr_date'),
            'subsidy'=>$this->input->post('subsidy'),
            'prod_num' => $this->input->post('prod_num'),
            'paid_date'=>$this->input->post('paid_date'),
            'added_by' => $datas->id,
            'deleted' => 0
        );
        $last_id=$this->Main_m->insertVehicle($data);

        $pr_dateget=$this->input->post('pr_date');

        if($pr_dateget == '')
        {
            $pr_date="0000-00-00";
        }else{
            $pr_dateArray= explode('-', $pr_dateget);
            $pr_date = new DateTime();
            $pr_date->setDate($pr_dateArray[1], $pr_dateArray[0], 01);
            $pr_date=$pr_date->format('Y-m-d');
        }


        $sr_dateget=$this->input->post('sr_date');

        if($sr_dateget == '')
        {
            $sr_date="0000-00-00";
        }else{
            $sr_dateArray= explode('-', $sr_dateget);
            $sr_date = new DateTime();
            $sr_date->setDate($sr_dateArray[1], $sr_dateArray[0], 01);
            $sr_date=$sr_date->format('Y-m-d');
        }

        $datainv=array(
                'vehicle_id'=>$last_id,
                'first_name' => $this->input->post('first_name'),
                'middle_name' => $this->input->post('middle_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company_name'),
                'invoice_num' => $this->input->post('inv_num'),
                'alloc_date'=>$_POST['alloc_date'],
                'salesperson'=>$_POST['salesperson'],
                'term' => $_POST['term'],
                'bank' => $_POST['bank'],
                'grp_lica' => $_POST['grp_lica'],
                'grp_plant' => $_POST['grp_bank'],
                'pay_amt'=>$inv_amt,
                'invoice_date' => $this->input->post('inv_date'),
                'plant_release_date' => $pr_date,
                'system_release_date' => $sr_date,
                'actual_release_date' => $this->input->post('ar_date')
        );

        $this->Main_m->insertInvoice2($datainv);

        $po_id=$data3[2];
        $check=$this->Main_m->checkpurchaseorder($po_id);
        $po_data=array(
                        'has_vehicle'=> 1,
                    );

         $this->Main_m->updatePOs($po_data,$po_id);

        $status='';
        if(empty($_POST['received_date']) or $_POST['received_date']=='')
        {
            $status='For Pull Out';
        }else if(empty($_POST['alloc_date']) or $_POST['alloc_date'] =='0000-00-00'
            AND empty($_POST['inv_num']) or $_POST['inv_num'] == ''
            AND $_POST['actual_release_date'] == '0000-00-00')
        {
            $status='Available';
        }else if(empty($_POST['inv_num']) or $_POST['inv_num'] == ''
            AND $_POST['actual_release_date'] == '0000-00-00')
        {
            $status='Allocated';
        }else if(!$_POST['actual_release_date'])
        {
            $status='Invoiced';
        }else{
            $status='Released';
        }

        $updata=array(
          'cs_num' =>$csnum,
          'inv_num' =>$inv_num,
          'status' => $status
        );

        $this->Main_m->updateStatus2($updata,$po_id);

        echo json_encode($data);
    }

    public function Model()
    {
        $dealer=$_GET['dealer'];
        $Search=$this->Main_m->searchd($dealer);
        foreach($Search as $vl)
        {
           $rdealer=$vl->Company;
           if($rdealer == 'MORRIS GARAGES')
           {
               $rdealer='MG';
               $models=$this->Main_m->models3($rdealer);
               echo json_encode($models);
           }else{
               $models=$this->Main_m->models3($rdealer);
               echo json_encode($models);
           }
        }
    }
    public function Model2()
    {
      $dealer=$_GET['dealer'];
      // // if($dealer == 'CARMAX')
      // // {
      // //     $models=$this->Main_m->models2();
      // //      echo json_encode($models);
      // // }else{
          $models=$this->Main_m->models_id($dealer);
          echo json_encode($models);
      // }
    }
    public function VechileInfo()
    {
        $id=$_GET['id'];
        $data['id']=$id;
        $data['info']=$this->Main_m->infoV($id);
        $data['infoInvoice']=$this->Main_m->infoINV($id);
        $this->load->view('user/Forms/vehicle_form_view',$data);
    }
    public function VechileInfo2()
    {
        $id=$_GET['id'];
        $data['id']=$id;
        $data['info']=$this->Main_m->infoV($id);
        $data['infoInvoice']=$this->Main_m->infoINV($id);
        $this->load->view('user/Forms/vehicle_form_view2',$data);
    }
    public function editVehicle()
    {
        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];
        $loc=$this->input->post('location');
        $PO=$this->input->post('purchase_order');
        $data3= explode(",",$PO);
        $oldcost=$this->input->post('cost');
        $cost=str_replace( ',', '', $oldcost);

        $data=array(
           'cs_num' => $this->input->post('cs_num'),
            'model' => $this->input->post('model'),
            'model_yr' => $this->input->post('model_yr'),
            'location' => $loc,
            'purchase_order' => $data3[2],
            'vrr_num' => $this->input->post('vvr_num'),
            'vrr_date' => $this->input->post('vvr_date'),
            'color' => $this->input->post('color'),
            'vin_num' => $this->input->post('vin_num'),
            'engine_num' => $this->input->post('eng_num'),
            'cost' => $cost,
            'remarks' => $this->input->post('remarks'),
            'veh_received'=>$this->input->post('received_date'),
            'csr_received'=>$this->input->post('csr_date'),
            'subsidy'=>$this->input->post('subsidy'),
            'prod_num' => $this->input->post('prod_num'),
            'paid_date'=>$this->input->post('paid_date'),
            'added_by' => $datas->id,
            'deleted' => 0
        );
        $vechile_id=$this->input->post('vechile_id');
        $invoice_id=$this->input->post('invoice_id');

        $this->Main_m->updateVehicle($data,$vechile_id);

        $datainv=array(
            'cust_name' => $this->input->post('cust_name'),
            'invoice_date' => $this->input->post('inv_date'),
            'plant_release_date' => $this->input->post('pr_date'),
            'system_release_date' => $this->input->post('sr_date'),
            'actual_release_date' => $this->input->post('ar_date')
        );
        $this->Main_m->updateInvoiceNew($datainv,$invoice_id);

        echo json_encode($data);
    }
    public function check_cs_num()
    {
        $newcsnum=$_GET['csnum'];
        $csnum=strtolower($newcsnum);
        $check=$this->Main_m->checkcsnum($csnum);
        $countcheck=count($check);
        echo json_encode($countcheck);
    }
    // VEHICLE FORM END
    // Invoice
    public function InvoiceForm()
    {
        $id=$_GET['id'];
        $data['id']=$id;
        $data['info']=$this->Main_m->infoV($id);
        $this->load->view('user/Forms/invoice_form',$data);
    }
    public function InvoiceForm2()
    {
         $this->load->view('user/Forms/invoice_form2');
    }
    public function SaveInvoice()
    {
        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];
        $rlsd=$this->input->post('release');

        $released=NULL;
        $has_invoice=1;
        $is_release=0;
        $vechile_id=$this->input->post('vehicle_id');

        if($rlsd)
        {
            $released=$datas->id;
            $is_release=1;
        }

        $data=array(
            'invoice_num' => $this->input->post('invoice_num'),
            'invoice_date' => $this->input->post('invoice_date'),
            'vehicle_id' => $vechile_id,
            'cust_name' => $this->input->post('cust_name'),
            'term' => $this->input->post('term'),
            'bank' => $this->input->post('bank'),
            'grp_lica' => $this->input->post('grp_lica'),
            'grp_plant' => $this->input->post('grp_plant'),
            'pay_mode' => $this->input->post('pay_mode'),
            'financier' => $this->input->post('financier'),
            'fin_branch' => $this->input->post('fin_branch'),
            'pay_amt' => $this->input->post('pay_amt'),
            'salesperson' => $this->input->post('salesperson'),
            'remarks' => $this->input->post('remarks'),
            'release_date' => $this->input->post('release_date'),
            'release_by' => $released,
            'added_by' => $datas->id
        );
        $data2=array(
            'is_release' => $is_release
        );
        $data4=array(
              'has_invoice' => $has_invoice,
        );
        $insert=$this->Main_m->insertInvoice($data);
        if($insert == true)
        {
            $this->Main_m->updateVehicle2($data2,$vechile_id);
            $this->Main_m->updateVehicle3($data4,$vechile_id);

            $Vehicle=$this->Main_m->checkpo_id($vechile_id);
            $po_number='';
            foreach($Vehicle as $value)
            {
                $po_number.=$value->purchase_order;
            }
            $this->Main_m->updatePO2($data4,$po_number);
            echo json_encode($data);
        }

    }
    public function ReleaseForm()
    {
        $id=$_GET['id'];
        $data['id']=$id;
        $data['info']=$this->Main_m->infoV($id);
        $this->load->view('user/Forms/release_form',$data);
    }
    public function releasenow()
    {
        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];
        $id=$this->input->post('vid');
        $data=array(
            'is_release'=>1
        );
        $this->Main_m->releasenow($data,$id);
        $invoice=$this->Main_m->getinvoiceid($id);
        $invoiceid='';
        foreach($invoice as $inv)
        {
            $invoiceid.=$inv->id;
        }
        $data2=array(
            'release_date'=>$this->input->post('release_date'),
            'plant_release_date'=>$this->input->post('pr_date'),
            'system_release_date'=>$this->input->post('sr_date'),
            'actual_release_date'=>$this->input->post('ar_date'),
            'release_by'=>$datas->id
        );
        $this->Main_m->updateINV($data2,$invoiceid);
        echo json_encode($data);
    }
    public function Invoice()
    {
        $aColumns = array(
            'CS Number',
            'Invoice Number',
            'Customer Name',
            'Amount Of Payment',
            'Options'
        );

        // DB table to use
        $this->db->order_by('invtry_invoice.id','DESC');
        $this->db->where('invtry_invoice.invoice_num !=','');
        $this->db->group_start();
        $this->db->where('invtry_status.status','Allocated');
        $this->db->or_where('invtry_status.status','Available');
        $this->db->or_where('invtry_status.status','Invoiced');
        $this->db->group_end();
        $sTable = 'invtry_invoice';

        $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            // $this->db->limit(10,20);
        }

        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }

        if(isset($sSearch) && !empty($sSearch))
        {
            $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
            for($i=0; $i<count($aColumns); $i++)
            {
                // Individual column filtering
            }

            if(isset($bSearchable) && $bSearchable == 'true')
            {
                //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("invtry_invoice.invoice_num", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_invoice.invoice_date", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_invoice.pay_amt", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("CONCAT(invtry_invoice.first_name,invtry_invoice.middle_name,invtry_invoice.last_name )", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="invtry_invoice.id,";
        $cSelect .="invtry_invoice.invoice_num as'Invoice Number',";
        $cSelect .="invtry_invoice.invoice_date as 'Invoice Date',";
        $cSelect .="invtry_invoice.vehicle_id as 'vhid',";
        $cSelect .="invtry_invoice.first_name as 'FName',";
        $cSelect .="invtry_invoice.middle_name as 'MName',";
        $cSelect .="invtry_invoice.last_name as 'LName',";
        $cSelect .="invtry_invoice.pay_amt as 'Amount Of Payment',";
        $cSelect .="invtry_invoice.alloc_date,";
        $cSelect .="invtry_invoice.actual_release_date,";
        $cSelect .="invtry_invoice.vehicle_id,";
        $cSelect .="invtry_invoice.cancelled_by,";
        $cSelect .="invtry_invoice.cancel_date,";
        $cSelect .="invtry_status.status,";
        $cSelect .="invtry_status.cs_num,";

        $this->db->select($cSelect, false);
        $this->db->join('invtry_vehicle','invtry_vehicle.id = invtry_invoice.vehicle_id');
        $this->db->join('invtry_status','invtry_status.cs_num = invtry_vehicle.cs_num');
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach($aColumns as $col)
            {
                if($col == 'CS Number')
                {

                    $vid=$aRow['vehicle_id'];
                    $getCSNum=$this->Main_m->csnum($vid);
                    $gg='';
                    foreach ($getCSNum as $value) {
                       $gg.=$value->cs_num;
                    }
                     $aRow[$col]=$gg;

                }
                if($col == 'Customer Name')
                {
                    $aRow[$col]=$aRow['LName'].','.$aRow['FName'].' '.$aRow['MName'];
                }

                if($col == 'Amount Of Payment')
                {
                    $aRow[$col] = number_format($aRow['Amount Of Payment']);
                }
                if($col == 'Options'){
                    $aRow[$col] = '';
                    $vid=$aRow['vhid'];
                    $getcsnum=$this->Main_m->getcsnum($vid);
                    $cs='';
                    foreach($getcsnum as $value)
                    {
                        $cs=$value->cs_num;
                    }
                    $stats=$this->Main_m->stats2($cs);
                    // print_r($cs);
                    // die();
                    foreach($stats as $val)
                    {
                        $stats=$val->status;
                        if($stats == 'Available')
                        {
                            $aRow[$col]='<button class="btn btn-primary invoice" value="'.$cs.'">Invoice</button>';
                        }
                        else if($stats == 'Allocated')
                        {
                            $aRow[$col]='<button class="btn btn-primary invoice" value="'.$cs.'">Invoice</button>';
                        }
                        else if($stats == 'Invoiced')
                        {
                            $aRow[$col]='<button class="btn btn-success released" value="'.$cs.'">Release</button>';
                        }
                        else if($stats == 'Released')
                        {
                            $aRow[$col]='';
                        }
                        else
                        {
                            $aRow[$col]='<button class="btn btn-primary received" value="'.$cs.'">Received</button>';
                        }

                    }
                }

                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }
    public function addInvoice()
    {
        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];
        $rlsd=$this->input->post('release');
        $date=$this->input->post('pr_date');

        $released=NULL;
        $has_invoice=1;
        $is_release=0;
        $vechile_id=$this->input->post('vehicle_id');

        if($rlsd)
        {
            $released=$datas->id;
            $is_release=1;
        }
        $oldcost=$this->input->post('pay_amt');
        $cost=str_replace( ',', '', $oldcost);

        $data=array(
            'invoice_num' => $this->input->post('invoice_num'),
            'invoice_date' => $this->input->post('invoice_date'),
            'vehicle_id' => $vechile_id,
            'cust_name' => $this->input->post('cust_name'),
            'pay_mode' => $this->input->post('pay_mode'),
            'financier' => $this->input->post('financier'),
            'term' => $this->input->post('term'),
            'bank' => $this->input->post('bank'),
            'grp_lica' => $this->input->post('grp_lica'),
            'grp_plant' => $this->input->post('grp_plant'),
            'fin_branch' => $this->input->post('fin_branch'),
            'pay_amt' => $cost,
            'salesperson' => $this->input->post('salesperson'),
            'remarks' => $this->input->post('remarks'),
            'release_date' => $this->input->post('release_date'),
            'plant_release_date'=>$this->input->post('pr_date'),
            'system_release_date'=>$this->input->post('sr_date'),
            'actual_release_date'=>$this->input->post('ar_date'),
            'release_by' => $released,
            'added_by' => $datas->id
        );
        $new=$this->Main_m->get_veh_inv($id);
        $veh_id=$vechile_id;
        if($date == '0000-00-00' OR $date=='')
        {
            $newdata=array('has_invoice'=>'1');
        }else{
            $newdata=array('has_invoice'=>'1','is_release' => '1');
        }

        $this->Main_m->update_stats($newdata,$veh_id);
    }
    public function InvoiceInfo()
    {
        $id=$_GET['id'];
        $data['id']=$id;
        $data['info']=$this->Main_m->infoI($id);
        $this->load->view('user/Forms/invoice_form_view',$data);
    }
    public function InvoiceInfo2()
    {
        $id=$_GET['id'];
        $data['id']=$id;
        $data['info']=$this->Main_m->infoI($id);
        $this->load->view('user/Forms/invoice_form_view2',$data);
    }
    public function invoice_form_update()
    {
        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];
        $vechile_id=$this->input->post('vehicle_id');


        $oldcost=$this->input->post('pay_amt');
        $cost=str_replace( ',', '', $oldcost);
        $data=array(
            'invoice_num' => $this->input->post('invoice_num'),
            'invoice_date' => $this->input->post('invoice_date'),
            'vehicle_id' => $vechile_id,
            'cust_name' => $this->input->post('cust_name'),
            'pay_mode' => $this->input->post('pay_mode'),
            'financier' => $this->input->post('financier'),
            'fin_branch' => $this->input->post('fin_branch'),
            'term' => $this->input->post('term'),
            'bank' => $this->input->post('bank'),
            'grp_lica' => $this->input->post('grp_lica'),
            'grp_plant' => $this->input->post('grp_plant'),
            'pay_amt' => $cost,
            'salesperson' => $this->input->post('salesperson'),
             'plant_release_date'=>$this->input->post('pr_date'),
            'system_release_date'=>$this->input->post('sr_date'),
            'actual_release_date'=>$this->input->post('ar_date'),
            'remarks' => $this->input->post('remarks'),
        );
        $id=$this->input->post('id');

        $this->Main_m->updateInvoiceInfo($data,$id);
    }
    public function CancelForm()
    {
        $data['id']=$_GET['id'];
        $this->load->view('user/Forms/cancel_form',$data);
    }
    public function invoice_form_cancel()
    {
        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];
        $date=date('m-d-Y');
        $data=array(
            'cancel_reason'=>$this->input->post('cancel_reason'),
            'cancelled_by' => $datas->id
        );
        $id=$this->input->post('invoice_id');
        // echo $id;
        $this->Main_m->cancelU($data,$id);

        $getid=$this->Main_m->getVid($id);
        foreach($getid as $val)
        {
            $vid=$val->vehicle_id;

        }
         // echo $vid;
            $data2=array(
                'has_invoice' => 2,
            );
            // print_r($data2);
            $d=$this->Main_m->cancelUV($data2,$vid);

            echo json_encode($data);

    }
    public function check_invoice_num()
    {
        $invoicenum=$_GET['invoicenum'];
        $check=$this->Main_m->checkinvoicenum($invoicenum);
        $countcheck=count($check);
        echo json_encode($countcheck);
    }
    // Invoice End
    // Help
    public function help()
    {
        if($this->session->userdata('logged_in'))
        {
            $this->load->view('v2/partial/header');
            $this->load->view('user/helpView');
            $this->load->view('v2/partial/footer');
        }else{
            $this->load->view('LoginView');
        }
    }
    public function HelpForm()
    {
        $name=$this->input->post('name');
        $email=$this->input->post('email');
        $contactnumber=$this->input->post('contact');
        $subject=$this->input->post('subject');
        $message=$this->input->post('message');
        $data=array(
            'name'=>$name,
            'email'=>$email,
            'contact_number'=>$contactnumber,
            'subject' =>$subject,
            'message' =>$message
        );
        $this->Main_m->insertDetails($data);

        $this->load->library('email');

        $emailAdd = "bocadojomari18@gmail.com";
        $emailSubject = $subject;
        $emailMsg = $message;

        $config['protocol'] = "smtp";
        $config['smtp_host'] = "mail.licagroup.biz";
        $config['smtp_port'] = "25";
        $config['smtp_user'] = "leavemanagement@licagroup.biz";
        $config['smtp_pass'] = "code015";
        $config['mailtype'] = "html";

        $this->email->initialize($config);
        $this->email->from($email, 'Lica Group Vehicle Invetory Ticket');
        $this->email->to($emailAdd);
        $this->email->subject('Lica Group Vehicle Invetory Ticket :'.$emailSubject);


        $this->email->message($emailMsg);
        $this->email->send();

        $this->index();
    }
    // Help End
    // Import
    public function IForm()
    {
        $this->load->view('user/Forms/ImportForm');
    }
    public function TIForm()
    {
        $this->load->view('user/Forms/testimportForm');
    }
    public function lform()
    {
      $this->load->view('user/Forms/loadingform');
    }
    // Import End
    // For Pull Out
    public function pull_out()
    {

        if($this->session->userdata('logged_in'))
        {
            $this->load->view('v2/partial/header');
            $this->load->view('user/pulloutView');
            $this->load->view('v2/partial/footer');
        }else{
            $this->load->view('LoginView');
        }
    }
    public function pulloutrecord()
    {
      $session_data = $this->session->userdata('logged_in');
      $datas=$session_data[0];
      $id=$datas->id;
      $type=$datas->type;

      $access=$this->Main_m->m_access($id);
      $dealer=array();
      foreach($access as $value) {
        $dealer[]=$value->key;
      }

      if($type == 1){
      }else{
      $getdealerid=$this->Dsar_m->newid($dealer);
      // print_r($getdealerid);
      // die();
      }
      $aColumns = array(
              'C.S. Number',
              'P.O. Number',
              'Accounting Status',
              'Inventory Status',
              'Options'
          );

          // DB table to use
          // $this->db->where('invtry_vehicle.veh_received !=',NULL);
          $this->db->where('invtry_status.status','For Pull Out');
          if($type == 1){

          }else{
            $this->db->group_start();
            foreach($getdealerid as $val)
            {

              $this->db->or_where('invtry_purchase_order.dealer =',$val->id);
            }
            $this->db->group_end();

          }
          $sTable = 'invtry_vehicle';

          $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
          $iDisplayLength = $this->input->get_post('iDisplayLength', true);
          $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
          $iSortingCols = $this->input->get_post('iSortingCols', true);
          $sSearch = $this->input->get_post('sSearch', true);
          $sEcho = $this->input->get_post('sEcho', true);

          // Paging
          if(isset($iDisplayStart) && $iDisplayLength != '-1')
          {
              $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
              // $this->db->limit(10,20);
          }

          // Ordering
          if(isset($iSortCol_0))
          {
              for($i=0; $i<intval($iSortingCols); $i++)
              {
                  $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                  $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                  $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                  if($bSortable == 'true')
                  {
                      $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                  }
              }
          }

          if(isset($sSearch) && !empty($sSearch))
          {
              $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
              for($i=0; $i<count($aColumns); $i++)
              {
                  // Individual column filtering
              }

              if(isset($bSearchable) && $bSearchable == 'true')
              {
                  //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                  $this->db->group_start();
                  $this->db->or_like("invtry_purchase_order.po_num", $this->db->escape_like_str($sSearch),'both');
                  $this->db->or_like("invtry_vehicle.cs_num", $this->db->escape_like_str($sSearch),'both');
                  $this->db->group_end();
              }
          }

          // Select Data
          //Customize select
          $cSelect = "SQL_CALC_FOUND_ROWS ";
          $cSelect .="invtry_vehicle.id,";
          $cSelect .="invtry_vehicle.cs_num as 'C.S. Number',";
          $cSelect .="invtry_purchase_order.po_num as 'P.O. Number',";
          $cSelect .="invtry_acc_status.status as 'Accounting Status',";
          $cSelect .="invtry_acc_status.status as 'acstats',";
          $cSelect .="invtry_status.status as 'Inventory Status',";
          $cSelect .="invtry_status.status as 'invStatus',";

          $this->db->select($cSelect, false);
          $this->db->join('invtry_purchase_order','invtry_purchase_order.id=invtry_vehicle.purchase_order','left');
          $this->db->join('invtry_acc_status','invtry_purchase_order.po_num = invtry_acc_status.po_number ','left');
          $this->db->join('invtry_status','invtry_purchase_order.po_num=invtry_status.po_number','left');
          $rResult = $this->db->get($sTable);

          // Data set length after filtering
          $this->db->select('FOUND_ROWS() AS found_rows');
          $iFilteredTotal = $this->db->get()->row()->found_rows;

          // Total data set length
          $iTotal = $this->db->count_all($sTable);

          // Output
          $output = array(
              'sEcho' => intval($sEcho),
              'iTotalRecords' => $iTotal,
              'iTotalDisplayRecords' => $iFilteredTotal,
              'aaData' => array()
          );

          foreach($rResult->result_array() as $aRow)
          {
              $row = array();

              foreach($aColumns as $col)
              {
                if($col == 'Accounting Status')
                {
                    $aRow[$col]='<span style="color:green;">'.$aRow[$col].'</span>';
                }
                if($col == 'Inventory Status')
                {
                    $aRow[$col]='<span style="color:blue;">'.$aRow[$col].'</span>';
                }
                if($col == 'Options'){
                      $aRow[$col] = '';
                      if($aRow['acstats'] == 'Available'){
                        $aRow[$col] .= "<button class='btn btn-sm btn-primary allocate' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Allocate</button> ";
                      }else if($aRow['acstats'] == 'Invoiced'){
                        $aRow[$col] .= "<button class='btn btn-sm btn-primary report' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Report</button> ";
                      }
                        $aRow[$col] .= "<button class='btn btn-sm btn-success receive' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Receive</button> ";
                        $aRow[$col] .= "<button class='btn btn-sm btn-danger cl' value='".$aRow['id']."'>Change Location</button> ";
                  }

                  $row[] = $aRow[$col];
              }

              $output['aaData'][] = $row;
          }
          echo json_encode($output);
    }

    // For Pull Out End
    public function receiveRecord()
    {
      $session_data = $this->session->userdata('logged_in');
      $datas=$session_data[0];
      $id=$datas->id;
      $type=$datas->type;

      $access=$this->Main_m->m_access($id);
      $dealer=array();
      foreach($access as $value) {
        $dealer[]=$value->key;
      }

      if($type == 1){
      }else{
      $getdealerid=$this->Dsar_m->newid($dealer);
      // print_r($getdealerid);
      // die();
      }

      $aColumns = array(
              'C.S. Number',
              'P.O. Number',
              'Accounting Status',
              'Inventory Status',
              'Options'
          );

          // DB table to use
          $this->db->where('invtry_vehicle.veh_received !=',NULL);
          $this->db->where('invtry_status.status','Received');
          if($type == 1){

          }else{
            $this->db->group_start();
            foreach($getdealerid as $val)
            {

              $this->db->or_where('invtry_purchase_order.dealer =',$val->id);
            }
            $this->db->group_end();

          }
          $sTable = 'invtry_vehicle';

          $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
          $iDisplayLength = $this->input->get_post('iDisplayLength', true);
          $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
          $iSortingCols = $this->input->get_post('iSortingCols', true);
          $sSearch = $this->input->get_post('sSearch', true);
          $sEcho = $this->input->get_post('sEcho', true);

          // Paging
          if(isset($iDisplayStart) && $iDisplayLength != '-1')
          {
              $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
              // $this->db->limit(10,20);
          }

          // Ordering
          if(isset($iSortCol_0))
          {
              for($i=0; $i<intval($iSortingCols); $i++)
              {
                  $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                  $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                  $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                  if($bSortable == 'true')
                  {
                      $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                  }
              }
          }

          if(isset($sSearch) && !empty($sSearch))
          {
              $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
              for($i=0; $i<count($aColumns); $i++)
              {
                  // Individual column filtering
              }

              if(isset($bSearchable) && $bSearchable == 'true')
              {
                  //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                  $this->db->group_start();
                  $this->db->or_like("invtry_purchase_order.po_num", $this->db->escape_like_str($sSearch),'both');
                  $this->db->or_like("invtry_vehicle.cs_num", $this->db->escape_like_str($sSearch),'both');
                  $this->db->group_end();
              }
          }

          // Select Data
          //Customize select
          $cSelect = "SQL_CALC_FOUND_ROWS ";
          $cSelect .="invtry_vehicle.id,";
          $cSelect .="invtry_vehicle.cs_num as 'C.S. Number',";
          $cSelect .="invtry_purchase_order.po_num as 'P.O. Number',";
          $cSelect .="invtry_acc_status.status as 'Accounting Status',";
          $cSelect .="invtry_acc_status.status as 'acstats',";
          $cSelect .="invtry_status.status as 'Inventory Status',";
          $cSelect .="invtry_status.status as 'invStatus',";

          $this->db->select($cSelect, false);
          $this->db->join('invtry_purchase_order','invtry_purchase_order.id=invtry_vehicle.purchase_order','left');
          $this->db->join('invtry_acc_status','invtry_acc_status.po_number=invtry_purchase_order.po_num','left');
          $this->db->join('invtry_status','invtry_status.po_number=invtry_purchase_order.po_num','left');
          $rResult = $this->db->get($sTable);

          // Data set length after filtering
          $this->db->select('FOUND_ROWS() AS found_rows');
          $iFilteredTotal = $this->db->get()->row()->found_rows;

          // Total data set length
          $iTotal = $this->db->count_all($sTable);

          // Output
          $output = array(
              'sEcho' => intval($sEcho),
              'iTotalRecords' => $iTotal,
              'iTotalDisplayRecords' => $iFilteredTotal,
              'aaData' => array()
          );

          foreach($rResult->result_array() as $aRow)
          {
              $row = array();

              foreach($aColumns as $col)
              {
                if($col == 'Accounting Status')
                {
                    $aRow[$col]='<span style="color:green;">'.$aRow[$col].'</span>';
                }
                if($col == 'Inventory Status')
                {
                    $aRow[$col]='<span style="color:blue;">'.$aRow[$col].'</span>';
                }
                if($col == 'Options'){
                      $aRow[$col] = '';
                          if($aRow['acstats'] == 'Available'){
                            $aRow[$col] .= "<button class='btn btn-sm btn-primary allocate' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Allocate</button> ";
                          }else if($aRow['acstats'] == 'Invoiced'){
                            $aRow[$col] .= "<button class='btn btn-sm btn-primary report' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Report</button> ";
                          }
                            $aRow[$col] .= "<button class='btn btn-sm btn-success release' value='".$aRow['id'].','.$aRow['C.S. Number'].','.$aRow['P.O. Number']."'>Release</button> ";
                          // }
                          $aRow[$col] .= "<button class='btn btn-sm btn-danger cl' value='".$aRow['id']."'>Change Location</button> ";
                  }

                  $row[] = $aRow[$col];
              }

              $output['aaData'][] = $row;
          }
          echo json_encode($output);
    }
    // Available
    public function available()
    {
            $this->load->view('v2/partial/header');
            $this->load->view('v2/Status_F/available_D');
            $this->load->view('v2/partial/footer');
    }
    public function availableRecord()
    {
      $session_data = $this->session->userdata('logged_in');
      $datas=$session_data[0];
      $id=$datas->id;
      $type=$datas->type;

      $access=$this->Main_m->m_access($id);
      $dealer=array();
      foreach($access as $value) {
        $dealer[]=$value->key;
      }

      if($type == 1){
      }else{
      $getdealerid=$this->Dsar_m->newid($dealer);
      // print_r($getdealerid);
      // die();
      }
      $aColumns = array(
              'C.S. Number',
              'P.O. Number',
              'Accounting Status',
              'Inventory Status',
              'Options'
          );

          // DB table to use
          // $this->db->where('invtry_vehicle.veh_received !=',NULL);
          $this->db->where('invtry_acc_status.status','Available');
          if($type == 1){

          }else{
            $this->db->group_start();
            foreach($getdealerid as $val)
            {

              $this->db->or_where('invtry_purchase_order.dealer =',$val->id);
            }
            $this->db->group_end();

          }
          $sTable = 'invtry_vehicle';

          $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
          $iDisplayLength = $this->input->get_post('iDisplayLength', true);
          $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
          $iSortingCols = $this->input->get_post('iSortingCols', true);
          $sSearch = $this->input->get_post('sSearch', true);
          $sEcho = $this->input->get_post('sEcho', true);

          // Paging
          if(isset($iDisplayStart) && $iDisplayLength != '-1')
          {
              $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
              // $this->db->limit(10,20);
          }

          // Ordering
          if(isset($iSortCol_0))
          {
              for($i=0; $i<intval($iSortingCols); $i++)
              {
                  $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                  $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                  $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                  if($bSortable == 'true')
                  {
                      $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                  }
              }
          }

          if(isset($sSearch) && !empty($sSearch))
          {
              $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
              for($i=0; $i<count($aColumns); $i++)
              {
                  // Individual column filtering
              }

              if(isset($bSearchable) && $bSearchable == 'true')
              {
                  //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                  $this->db->group_start();
                  $this->db->or_like("invtry_purchase_order.po_num", $this->db->escape_like_str($sSearch),'both');
                  $this->db->or_like("invtry_vehicle.cs_num", $this->db->escape_like_str($sSearch),'both');
                  $this->db->group_end();
              }
          }

          // Select Data
          //Customize select
          $cSelect = "SQL_CALC_FOUND_ROWS ";
          $cSelect .="invtry_vehicle.id,";
          $cSelect .="invtry_vehicle.cs_num as 'C.S. Number',";
          $cSelect .="invtry_purchase_order.po_num as 'P.O. Number',";
          $cSelect .="invtry_acc_status.status as 'Accounting Status',";
          $cSelect .="invtry_status.status as 'Inventory Status',";
          $cSelect .="invtry_status.status as 'invStatus',";

          $this->db->select($cSelect, false);
          $this->db->join('invtry_purchase_order','invtry_purchase_order.id=invtry_vehicle.purchase_order','left');
          $this->db->join('invtry_acc_status','invtry_acc_status.po_number=invtry_purchase_order.po_num','left');
          $this->db->join('invtry_status','invtry_status.po_number=invtry_purchase_order.po_num','left');
          $rResult = $this->db->get($sTable);

          // Data set length after filtering
          $this->db->select('FOUND_ROWS() AS found_rows');
          $iFilteredTotal = $this->db->get()->row()->found_rows;

          // Total data set length
          $iTotal = $this->db->count_all($sTable);

          // Output
          $output = array(
              'sEcho' => intval($sEcho),
              'iTotalRecords' => $iTotal,
              'iTotalDisplayRecords' => $iFilteredTotal,
              'aaData' => array()
          );

          foreach($rResult->result_array() as $aRow)
          {
              $row = array();

              foreach($aColumns as $col)
              {
                if($col == 'Accounting Status')
                {
                    $aRow[$col]='<span style="color:green;">'.$aRow[$col].'</span>';
                }
                if($col == 'Inventory Status')
                {
                    $aRow[$col]='<span style="color:blue;">'.$aRow[$col].'</span>';
                }
                if($col == 'Options'){
                      $aRow[$col] = '';
                          $aRow[$col] .= "<button class='btn btn-sm btn-primary allocate' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Allocate</button> ";
                          if($aRow['invStatus'] == 'For Pull Out'){
                            $aRow[$col] .= "<button class='btn btn-sm btn-success receive' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Receive</button> ";
                          }else if($aRow['invStatus'] == 'Received'){
                            $aRow[$col] .= "<button class='btn btn-sm btn-success release' value='".$aRow['id'].','.$aRow['C.S. Number'].','.$aRow['P.O. Number']."'>Release</button> ";
                          }
                          $aRow[$col] .= "<button class='btn btn-sm btn-danger cl' value='".$aRow['id']."'>Change Location</button> ";
                  }

                  $row[] = $aRow[$col];
              }

              $output['aaData'][] = $row;
          }
          echo json_encode($output);
    }
    // Available End
    // Allocated``
    public function allocated()
    {
         if($this->session->userdata('logged_in'))
        {
            $this->load->view('v2/partial/header');
            $this->load->view('user/allocatedView');
            $this->load->view('v2/partial/footer');
        }else{
            $this->load->view('LoginView');
        }
    }
    public function allocatedRecord()
    {
      // $get_gp_cs=$this->Dashboard_m->get_gp_cs();

      $session_data = $this->session->userdata('logged_in');
      $datas=$session_data[0];
      $id=$datas->id;
      $type=$datas->type;

      $access=$this->Main_m->m_access($id);
      $dealer=array();
      foreach($access as $value) {
        $dealer[]=$value->key;
      }

      if($type == 1){
      }else{
      $getdealerid=$this->Dsar_m->newid($dealer);
      // print_r($getdealerid);
      // die();
      }
        $aColumns = array(
                'C.S. Number',
                'P.O. Number',
                'Accounting Status',
                'Inventory Status',
                'Options'
            );


          $this->db->where('invtry_acc_status.status','Allocated');
          if($type == 1){

          }else{
            $this->db->group_start();
            foreach($getdealerid as $val)
            {

              $this->db->or_where('invtry_purchase_order.dealer =',$val->id);
            }
            $this->db->group_end();

          }
          $sTable = 'invtry_vehicle';

          $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
          $iDisplayLength = $this->input->get_post('iDisplayLength', true);
          $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
          $iSortingCols = $this->input->get_post('iSortingCols', true);
          $sSearch = $this->input->get_post('sSearch', true);
          $sEcho = $this->input->get_post('sEcho', true);

          // Paging
          if(isset($iDisplayStart) && $iDisplayLength != '-1')
          {
              $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
              // $this->db->limit(10,20);
          }

          // Ordering
          if(isset($iSortCol_0))
          {
              for($i=0; $i<intval($iSortingCols); $i++)
              {
                  $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                  $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                  $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                  if($bSortable == 'true')
                  {
                      $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                  }
              }
          }

          if(isset($sSearch) && !empty($sSearch))
          {
              $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
              for($i=0; $i<count($aColumns); $i++)
              {
                  // Individual column filtering
              }

              if(isset($bSearchable) && $bSearchable == 'true')
              {
                  //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                  $this->db->group_start();
                  $this->db->or_like("invtry_purchase_order.po_num", $this->db->escape_like_str($sSearch),'both');
                  $this->db->or_like("invtry_vehicle.cs_num", $this->db->escape_like_str($sSearch),'both');
                  $this->db->group_end();
              }
          }

          // Select Data
          //Customize select
          $cSelect = "SQL_CALC_FOUND_ROWS ";
          $cSelect .="invtry_vehicle.id,";
          $cSelect .="invtry_vehicle.cs_num as 'C.S. Number',";
          $cSelect .="invtry_vehicle.cs_num,";
          $cSelect .="invtry_purchase_order.po_num as 'P.O. Number',";
          $cSelect .="invtry_acc_status.status as 'Accounting Status',";
          $cSelect .="invtry_status.status as 'Inventory Status',";
          $cSelect .="invtry_status.status as 'invStatus',";

          $this->db->select($cSelect, false);
          $this->db->join('invtry_purchase_order','invtry_purchase_order.id = invtry_vehicle.purchase_order','left');
          $this->db->join('invtry_acc_status','invtry_purchase_order.po_num = invtry_acc_status.po_number','left');
          $this->db->join('invtry_status','invtry_purchase_order.po_num = invtry_status.po_number','left');
          // $this->db->join('collecti_gp_db.gp','collecti_gp_db.gp.cs_num = invtry_vehicle.cs_num','left');
          $rResult = $this->db->get($sTable);

          // Data set length after filtering
          $this->db->select('FOUND_ROWS() AS found_rows');
          $iFilteredTotal = $this->db->get()->row()->found_rows;

          // Total data set length
          $iTotal = $this->db->count_all($sTable);

          // Output
          $output = array(
              'sEcho' => intval($sEcho),
              'iTotalRecords' => $iTotal,
              'iTotalDisplayRecords' => $iFilteredTotal,
              'aaData' => array()
          );

          foreach($rResult->result_array() as $aRow)
          {
              $row = array();

              foreach($aColumns as $col)
              {
                if($col == 'Accounting Status')
                {
                      $aRow[$col]='<span style="color:green;">'.$aRow[$col].'</span>';
                }
                if($col == 'Inventory Status')
                {
                      $aRow[$col]='<span style="color:blue;">'.$aRow[$col].'</span>';
                }
                if($col == 'Options'){
                      $aRow[$col] = '';
                      $aRow[$col] .= "<button class='btn btn-sm btn-primary changeAlloc' value='".$aRow['id']."'>Change Allocation Dealer</button> ";
                      if($aRow['invStatus'] == 'For Pull Out'){
                        $aRow[$col] .= "<button class='btn btn-sm btn-success receive' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Receive</button> ";
                      }else if($aRow['invStatus'] == 'Received'){
                        $aRow[$col] .= "<button class='btn btn-sm btn-success release' value='".$aRow['id'].','.$aRow['C.S. Number'].','.$aRow['P.O. Number']."'>Release</button> ";
                      }
                      $aRow[$col] .= "<button class='btn btn-sm btn-danger cl' value='".$aRow['id']."'>Change Location</button> ";
                  }

                  $row[] = $aRow[$col];
              }

              $output['aaData'][] = $row;
          }
          echo json_encode($output);
    }
    public function allocform()
    {
        $data['id']=$_GET['id'];
        $this->load->view('user/Forms/custform',$data);
    }
    public function alloc_cust_form()
    {
        $id=$this->input->post('invoice_id');
        $data=array(
            'cust_name'=>$this->input->post('cust_name'),
            'alloc_date'=>$this->input->post('alloc_date'),
        );
        $this->Main_m->assign_cust($data,$id);
        $getveh=$this->Main_m->getVid($id);
        foreach ($getveh as $value) {
            $vid=$value->vehicle_id;
            $data2=array(
                'has_invoice'=> 0
            );
           $this->Main_m->cancelUV($data2,$vid);
        }
        echo json_encode($data);
    }
    // Allocated End
    // Invoiced
    public function invoiced()
    {
         if($this->session->userdata('logged_in'))
        {
            $this->load->view('v2/partial/header');
            $this->load->view('user/invoicedView');
            $this->load->view('v2/partial/footer');
        }else{
            $this->load->view('LoginView');
        }
    }
    public function invoicedRecord()
    {
      $session_data = $this->session->userdata('logged_in');
      $datas=$session_data[0];
      $id=$datas->id;
      $type=$datas->type;

      $access=$this->Main_m->m_access($id);
      $dealer=array();
      foreach($access as $value) {
        $dealer[]=$value->key;
      }

      if($type == 1){
      }else{
      $getdealerid=$this->Dsar_m->newid($dealer);
      // print_r($getdealerid);
      // die();
      }

      $aColumns = array(
              'C.S. Number',
              'P.O. Number',
              'Accounting Status',
              'Inventory Status',
              'Options'
          );


        $this->db->where('invtry_acc_status.status','Invoiced');
        if($type == 1){

        }else{
          $this->db->group_start();
          foreach($getdealerid as $val)
          {

            $this->db->or_where('invtry_purchase_order.dealer =',$val->id);
          }
          $this->db->group_end();

        }
        $sTable = 'invtry_vehicle';

        $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            // $this->db->limit(10,20);
        }

        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }

        if(isset($sSearch) && !empty($sSearch))
        {
            $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
            for($i=0; $i<count($aColumns); $i++)
            {
                // Individual column filtering
            }

            if(isset($bSearchable) && $bSearchable == 'true')
            {
                //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("invtry_purchase_order.po_num", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_vehicle.cs_num", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="invtry_vehicle.id,";
        $cSelect .="invtry_vehicle.cs_num as 'C.S. Number',";
        $cSelect .="invtry_vehicle.cs_num,";
        $cSelect .="invtry_purchase_order.po_num as 'P.O. Number',";
        $cSelect .="invtry_acc_status.status as 'Accounting Status',";
        $cSelect .="invtry_status.status as 'Inventory Status',";
        $cSelect .="invtry_status.status as 'invStatus',";

        $this->db->select($cSelect, false);
        $this->db->join('invtry_purchase_order','invtry_purchase_order.id = invtry_vehicle.purchase_order','left');
        $this->db->join('invtry_acc_status','invtry_purchase_order.po_num = invtry_acc_status.po_number','left');
        $this->db->join('invtry_status','invtry_purchase_order.po_num = invtry_status.po_number','left');
        // $this->db->join('collecti_gp_db.gp','collecti_gp_db.gp.cs_num = invtry_vehicle.cs_num','left');
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach($aColumns as $col)
            {
              if($col == 'Accounting Status')
              {
                    $aRow[$col]='<span style="color:green;">'.$aRow[$col].'</span>';
              }
              if($col == 'Inventory Status')
              {
                    $aRow[$col]='<span style="color:blue;">'.$aRow[$col].'</span>';
              }
              if($col == 'Options'){
                    $aRow[$col] = '';
                    $aRow[$col] .= "<button class='btn btn-sm btn-primary report' value='".$aRow['id'].','.$aRow['P.O. Number'].','.$aRow['C.S. Number']."'>Report</button> ";
                    if($aRow['invStatus'] == 'For Pull Out'){
                      $aRow[$col] .= "<button class='btn btn-sm btn-success receive' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Receive</button> ";
                    }else if($aRow['invStatus'] == 'Received'){
                      $aRow[$col] .= "<button class='btn btn-sm btn-success release' value='".$aRow['id'].','.$aRow['C.S. Number'].','.$aRow['P.O. Number']."'>Release</button> ";
                    }
                    $aRow[$col] .= "<button class='btn btn-sm btn-danger cl' value='".$aRow['id']."'>Change Location</button> ";
            }

                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }
    public function invoicedForm()
    {
        $data['id']=$_GET['id'];
        $this->load->view('user/Forms/invoicedNewFrom',$data);
    }
    public function save_new_invoice_form()
    {
        $id=$this->input->post('invoice_id');
        $date=$this->input->post('pr_date');
        $oldcost=$this->input->post('pay_amt');
        $cost=str_replace( ',', '', $oldcost);
        $datas=$session_data[0];
        if($date == '0000-00-00' OR $date=='')
        {
            $data=array(
            'invoice_num'=>$this->input->post('invoice_num'),
            'invoice_date'=>$this->input->post('invoice_date'),
            'term' => $this->input->post('term'),
            'bank' => $this->input->post('bank'),
            'grp_lica' => $this->input->post('grp_lica'),
            'grp_plant' => $this->input->post('grp_plant'),
            'pay_mode' => $this->input->post('pay_mode'),
            'financier' => $this->input->post('financier'),
            'fin_branch' => $this->input->post('fin_branch'),
            'pay_amt' => $cost,
            'salesperson' => $this->input->post('salesperson'),
            'release_date' => $this->input->post('ar_date'),
            'remarks'=>$this->input->post('remarks'),
            'plant_release_date'=>$this->input->post('pr_date'),
            'system_release_date'=>$this->input->post('sr_date'),
            'actual_release_date'=>$this->input->post('ar_date'),
            'release_by'=> $datas->id,
            'added_by' => $datas->id
        );
        }else{
            $data=array(
            'invoice_num'=>$this->input->post('invoice_num'),
            'invoice_date'=>$this->input->post('invoice_date'),
            'term' => $this->input->post('term'),
            'bank' => $this->input->post('bank'),
            'grp_lica' => $this->input->post('grp_lica'),
            'grp_plant' => $this->input->post('grp_plant'),
            'pay_mode' => $this->input->post('pay_mode'),
            'financier' => $this->input->post('financier'),
            'fin_branch' => $this->input->post('fin_branch'),
            'pay_amt' => $cost,
            'salesperson' => $this->input->post('salesperson'),
            'release_date' => $this->input->post('ar_date'),
            'remarks'=>$this->input->post('remarks'),
            'plant_release_date'=>$this->input->post('pr_date'),
            'system_release_date'=>$this->input->post('sr_date'),
            'actual_release_date'=>$this->input->post('ar_date'),
            'added_by' => $datas->id
        );
        }

        $this->Main_m->assign_cust($data,$id);
        $new=$this->Main_m->get_veh_inv($id);
        $veh_id="";
        foreach ($new as  $value) {
            $veh_id=$value->vehicle_id;
        }
        if($date == '0000-00-00' OR $date=='')
        {
            $newdata=array('has_invoice'=>'1');
        }else{
            $newdata=array('has_invoice'=>'1','is_release' => '1');
        }

        $this->Main_m->update_stats($newdata,$veh_id);
        echo json_encode($data);
    }
    // Invoiced End
    // Released
    public function released()
    {
         if($this->session->userdata('logged_in'))
        {
            $this->load->view('v2/partial/header');
            $this->load->view('user/releasedView');
            $this->load->view('v2/partial/footer');
        }else{
            $this->load->view('LoginView');
        }
    }
    public function releasedrecord()
    {
      $session_data = $this->session->userdata('logged_in');
      $datas=$session_data[0];
      $id=$datas->id;
      $type=$datas->type;

      $access=$this->Main_m->m_access($id);
      $dealer=array();
      foreach($access as $value) {
        $dealer[]=$value->key;
      }

      if($type == 1){
      }else{
      $getdealerid=$this->Dsar_m->newid($dealer);
      // print_r($getdealerid);
      // die();
      }
      $aColumns = array(
              'C.S. Number',
              'P.O. Number',
              'Accounting Status',
              'Inventory Status',
              'Options'
          );

          // DB table to use
          $this->db->where('invtry_vehicle.veh_received !=',NULL);
          $this->db->where('invtry_status.status','Released');
          if($type == 1){

          }else{
            $this->db->group_start();
            foreach($getdealerid as $val)
            {

              $this->db->or_where('invtry_purchase_order.dealer =',$val->id);
            }
            $this->db->group_end();

          }
          $sTable = 'invtry_vehicle';

          $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
          $iDisplayLength = $this->input->get_post('iDisplayLength', true);
          $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
          $iSortingCols = $this->input->get_post('iSortingCols', true);
          $sSearch = $this->input->get_post('sSearch', true);
          $sEcho = $this->input->get_post('sEcho', true);

          // Paging
          if(isset($iDisplayStart) && $iDisplayLength != '-1')
          {
              $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
              // $this->db->limit(10,20);
          }

          // Ordering
          if(isset($iSortCol_0))
          {
              for($i=0; $i<intval($iSortingCols); $i++)
              {
                  $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                  $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                  $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                  if($bSortable == 'true')
                  {
                      $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                  }
              }
          }

          if(isset($sSearch) && !empty($sSearch))
          {
              $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
              for($i=0; $i<count($aColumns); $i++)
              {
                  // Individual column filtering
              }

              if(isset($bSearchable) && $bSearchable == 'true')
              {
                  //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                  $this->db->group_start();
                  $this->db->or_like("invtry_purchase_order.po_num", $this->db->escape_like_str($sSearch),'both');
                  $this->db->or_like("invtry_vehicle.cs_num", $this->db->escape_like_str($sSearch),'both');
                  $this->db->group_end();
              }
          }

          // Select Data
          //Customize select
          $cSelect = "SQL_CALC_FOUND_ROWS ";
          $cSelect .="invtry_vehicle.id,";
          $cSelect .="invtry_vehicle.cs_num as 'C.S. Number',";
          $cSelect .="invtry_purchase_order.po_num as 'P.O. Number',";
          $cSelect .="invtry_acc_status.status as 'Accounting Status',";
          $cSelect .="invtry_acc_status.status as 'acstats',";
          $cSelect .="invtry_status.status as 'Inventory Status',";
          $cSelect .="invtry_status.status as 'invStatus',";

          $this->db->select($cSelect, false);
          $this->db->join('invtry_purchase_order','invtry_purchase_order.id=invtry_vehicle.purchase_order','left');
          $this->db->join('invtry_acc_status','invtry_acc_status.po_number=invtry_purchase_order.po_num','left');
          $this->db->join('invtry_status','invtry_status.po_number=invtry_purchase_order.po_num','left');
          $rResult = $this->db->get($sTable);

          // Data set length after filtering
          $this->db->select('FOUND_ROWS() AS found_rows');
          $iFilteredTotal = $this->db->get()->row()->found_rows;

          // Total data set length
          $iTotal = $this->db->count_all($sTable);

          // Output
          $output = array(
              'sEcho' => intval($sEcho),
              'iTotalRecords' => $iTotal,
              'iTotalDisplayRecords' => $iFilteredTotal,
              'aaData' => array()
          );

          foreach($rResult->result_array() as $aRow)
          {
              $row = array();

              foreach($aColumns as $col)
              {
                if($col == 'Accounting Status')
                {
                    $aRow[$col]='<span style="color:green;">'.$aRow[$col].'</span>';
                }
                if($col == 'Inventory Status')
                {
                    $aRow[$col]='<span style="color:blue;">'.$aRow[$col].'</span>';
                }
                if($col == 'Options'){
                      $aRow[$col] = '';
                      if($aRow['acstats'] == 'Available'){
                        $aRow[$col] .= "<button class='btn btn-sm btn-primary allocate' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Allocate</button> ";
                      }else if($aRow['acstats'] == 'Invoiced'){
                        $aRow[$col] .= "<button class='btn btn-sm btn-primary report' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Report</button> ";
                      }
                          // $aRow[$col] .= "<button class='btn btn-sm btn-primary allocate' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Allocate</button> ";
                          // if($aRow['invStatus'] == 'For Pull Out'){
                            // $aRow[$col] .= "<button class='btn btn-sm btn-success receive' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Receive</button> ";
                          // }else if($aRow['invStatus'] == 'Received'){
                            // $aRow[$col] .= "<button class='btn btn-sm btn-success release' value='".$aRow['id'].','.$aRow['C.S. Number'].','.$aRow['P.O. Number']."'>Release</button> ";
                          // }
                          $aRow[$col] .= "<button class='btn btn-sm btn-danger cl' value='".$aRow['id']."'>Change Location</button> ";
                  }

                  $row[] = $aRow[$col];
              }

              $output['aaData'][] = $row;
          }
          echo json_encode($output);
    }
    // Released End
    // change location
    public function changelocform()
    {
        $this->load->view('user/Forms/change_loc');
    }
    public function change_form()
    {
        $brand=$this->input->post("Brand");
        $location=$this->input->post("Location");
        $vls=$brand."-".$location;
        $data=array(
            'location' => $vls
        );
        $scl=$this->Dashboard_m->searchChangeLoc2($id);

        foreach ($scl as $value){
            $id=$value->vehicleID;
            $this->Main_m->changeloc($id,$data);
            $this->Dashboard_m->removeToS($id);
        }
        echo json_encode($data);
    }
    // change location

    public function received_form()
    {
        $data['id']=$_GET['id'];
        // $csnum=$_GET['id'];
        // $getid=$this->Main_m->getvhID($csnum);
        $id=$_GET['id'];
        // $data['csnum']=$csnum;
        $data['info']=$this->Main_m->infoV($id);
        $this->load->view('user/new_Forms/receive_form',$data);
    }
    public function dealer_form()
    {
        $id=$_GET['id'];
        $arr=explode(",",$id);
        $data['id']=$arr[1];
        $data['did']=$arr[0];
        // $csnum=$_GET['id'];
        // $getid=$this->Main_m->getvhID($csnum);
        // $id='';
        // foreach($getid as $value)
        // {
        //     $id=$value->id;
        // }
        // // $data['csnum']=$csnum;
        // $data['info']=$this->Main_m->infoV($id);
        $this->load->view('user/new_Forms/adddealer',$data);
    }
    public function dealer_function()
    {
      $id=$_POST['csnum'];
      // $getid=$this->Main_m->getvhID($csnum);
      // $id='';
      // foreach($getid as $value)
      // {
      //     $id=$value->id;
      // }
      $data=array(
          'grp_lica'=>$_POST['dealer']
      );

      $update=$this->Main_m->updategrplica($data,$id);
        print_r($update);
      echo json_encode($update);
    }
    public function receive_function()
    {
        $csnum=$_POST['csnum'];
        $date=$_POST['received_date'];
        $data=array(
            'veh_received'=>$date,
            'vrr_num' => $this->input->post('vvr_num'),
            'csr_received'=>$this->input->post('csr_date'),
        );

        $update=$this->Main_m->updateReceive($data,$csnum);

        echo json_encode($csnum);
    }

    public function allocate_form()
    {
        $data['id']=$_GET['id'];
        $this->load->view('user/new_Forms/allocate_form',$data);
    }
    public function allocate_function()
    {
        $csnum=$_POST['csnum'];
        $date=$_POST['alloc_date'];
        $dealer=$_POST['dealer'];
        $data=array(
            'alloc_date'=>$date,
            'grp_lica'=>$dealer
        );
        $getid=$this->Main_m->getvhID($csnum);
        $id='';
        foreach($getid as $value)
        {
            $id=$value->id;
        }
        $update=$this->Main_m->updateAllocate($data,$id);

        $status='Allocated';
        $datas=array(
            'status' => $status
        );

        $this->Main_m->updateStatus($csnum,$datas);

        echo json_encode($id);
    }
    public function new_invoice_form()
    {
        $csnum=$_GET['id'];
        $getid=$this->Main_m->getvhID($csnum);
        $id='';
        foreach($getid as $value)
        {
            $id=$value->id;
        }
        $data['csnum']=$csnum;
        $data['info']=$this->Main_m->infoInvoice($id);

        $this->load->view('user/new_Forms/invoice_form',$data);
    }
    public function invoice_function()
    {
        $csnum=$_POST['csnum'];
        $id=$_POST['id'];
        $pr_dateget=$this->input->post('pr_date');

        if($pr_dateget == '')
        {
            $pr_date="0000-00-00";
        }else{
            $pr_dateArray= explode('-', $pr_dateget);
            $pr_date = new DateTime();
            $pr_date->setDate($pr_dateArray[1], $pr_dateArray[0], 01);
            $pr_date=$pr_date->format('Y-m-d');
        }

        // echo $pr_date;
        $sr_dateget=$this->input->post('sr_date');

        if($sr_dateget == '')
        {
            $sr_date="0000-00-00";
        }else{
            $sr_dateArray= explode('-', $sr_dateget);
            $sr_date = new DateTime();
            $sr_date->setDate($sr_dateArray[1], $sr_dateArray[0], 01);
            $sr_date=$sr_date->format('Y-m-d');
        }
        // echo $sr_dateget;
        $oldamt=$this->input->post('inv_amt');
        $inv_amt=str_replace(',','',$oldamt);
        $data=array(
            'last_name' => $_POST['last_name'],
            'first_name' => $_POST['first_name'],
            'middle_name' => $_POST['middle_name'],
            'company' => $_POST['company_name'],
            'invoice_num'=> $_POST['inv_num'],
            'pay_amt' => $inv_amt,
            'invoice_date' => $_POST['inv_date'],
            'alloc_date'=> $_POST['alloc_date'],
            'salesperson' => $_POST['salesperson'],
            'term' => $_POST['term'],
            'bank' => $_POST['bank'],
            'grp_lica' => $_POST['grp_lica'],
            'grp_plant' => $_POST['grp_plant'],
            'plant_release_date' => $pr_date,
            'actual_release_date' => $_POST['ar_date'],
            'system_release_date' => $sr_date
        );
        $update=$this->Main_m->updateInvoice($data,$id);

        $status='';
         if($_POST['ar_date'] == '0000-00-00' || empty($_POST['ar_date']))
        {
            $status='Invoiced';
        }else{
            $status='Released';
        }
        $vudata=array(
          'paid_date' => $_POST['paid_date']
        );
        $this->Main_m->vudatas($csnum,$vudata);
        $datas=array(
          'inv_num'=>$_POST['inv_num'],
          'status' => $status
        );

        $this->Main_m->updateStatus($csnum,$datas);
        echo json_encode($id);
    }
    public function release_form()
    {
        $csnum=$_GET['id'];
        $getid=$this->Main_m->getvhID($csnum);
        $id='';
        foreach($getid as $value)
        {
            $id=$value->id;
        }
        $data['csnum']=$csnum;
        $data['info']=$this->Main_m->infoInvoice($id);

        $this->load->view('user/new_Forms/release_form',$data);
    }
    public function release_function()
    {
        $csnum=$_POST['csnum'];
        $id=$_POST['id'];
         $pr_dateget=$this->input->post('pr_date');

        if($pr_dateget == '')
        {
            $pr_date="0000-00-00";
        }else{
            $pr_dateArray= explode('-', $pr_dateget);
            $pr_date = new DateTime();
            $pr_date->setDate($pr_dateArray[1], $pr_dateArray[0], 01);
            $pr_date=$pr_date->format('Y-m-d');
        }

        // echo $pr_date;
        $sr_dateget=$this->input->post('sr_date');

        if($sr_dateget == '')
        {
            $sr_date="0000-00-00";
        }else{
            $sr_dateArray= explode('-', $sr_dateget);
            $sr_date = new DateTime();
            $sr_date->setDate($sr_dateArray[1], $sr_dateArray[0], 01);
            $sr_date=$sr_date->format('Y-m-d');
        }
        $data=array(
            'plant_release_date' => $pr_date,
            'actual_release_date' => $_POST['ar_date'],
            'system_release_date' => $sr_date
        );
        $update=$this->Main_m->updateInvoice($data,$id);

        $status='';
        if($_POST['actual_release_date'] == '0000-00-00')
        {
            $status='Invoiced';
        }else{
            $status='Released';
        }
        $datas=array(
          'status' => $status
        );

        $this->Main_m->updateStatus($csnum,$datas);
        echo json_encode($csnum);
    }
    public function new_add_invoice_form()
    {
        $this->load->view('user/new_Forms/add_invoice_form');
    }
    public function new_add_invoice_function()
    {
        $ids=$_POST['vehicle_id'];
        $id=$ids[0];
        $csnum=$ids[1];
        $oldamt=$_POST['inv_amt'];
        $inv_amt=str_replace(',','',$oldamt);

        $pr_dateget=$this->input->post('pr_date');
        if($pr_dateget == '')
        {
            $pr_date="0000-00-00";
        }else{
            $pr_dateArray= explode('-', $pr_dateget);
            $pr_date = new DateTime();
            $pr_date->setDate($pr_dateArray[1], $pr_dateArray[0], 01);
            $pr_date=$pr_date->format('Y-m-d');
        }


        $sr_dateget=$this->input->post('sr_date');
        if($sr_dateget == '')
        {
            $sr_date="0000-00-00";
        }else{
            $sr_dateArray= explode('-', $sr_dateget);
            $sr_date = new DateTime();
            $sr_date->setDate($sr_dateArray[1], $sr_dateArray[0], 01);
            $sr_date=$sr_date->format('Y-m-d');
        }

        $data=array(
            'last_name' => $_POST['last_name'],
            'first_name' => $_POST['first_name'],
            'middle_name' => $_POST['middle_name'],
            'company' => $_POST['company_name'],
            'invoice_num'=> $_POST['inv_num'],
            'pay_amt' => $inv_amt,
            'invoice_date' => $_POST['inv_date'],
            'salesperson' => $_POST['salesperson'],
            'term' => $_POST['term'],
            'bank' => $_POST['bank'],
            'grp_lica' => $_POST['grp_lica'],
            'grp_plant' => $_POST['grp_plant'],
            'plant_release_date' => $pr_date,
            'actual_release_date' => $_POST['ar_date'],
            'system_release_date' => $sr_date
        );
        $update=$this->Main_m->updateInvoice($data,$id);

        $status='';
        if(empty($_POST['alloc_date']) AND empty($_POST['inv_num']) AND empty($_POST['actual_release_date']))
        {
            $status='Available';
        }else if(empty($_POST['inv_num']) AND empty($_POST['actual_release_date']))
        {
            $status='Allocated';
        }else if(!$_POST['actual_release_date'])
        {
            $status='Invoiced';
        }else{
            $status='Released';
        }
        $datas=array(
          'inv_num'=>$_POST['inv_num'],
          'status' => $status
        );

        $this->Main_m->updateStatus($csnum,$datas);
        echo json_encode($id);
    }
    public function new_info_form()
    {
        $id=$_GET['id'];
        $data['info']=$this->Main_m->dataInfo1($id);
        $getmodel=$this->Main_m->getmodelN($id);
        $model='';
        foreach($getmodel as $value)
        {
          $model=$value->model;
        }
        $data['color']=$this->Main_m->getcolorN($model);
        // print_r($data);
        // die();
        $this->load->view('user/new_Forms/new_info_form',$data);
    }
    public function new_info_form_function()
    {
        $id=$_POST['veh_id'];
        $csnum=$this->input->post('cs_num');
        $PO=$this->input->post('purchase_order');
        $data3= explode(",",$PO);
        $loc=$this->input->post('location');
        $inv_num=$this->input->post('inv_date');
        $oldcost=$this->input->post('cost');
        $cost=str_replace( ',', '', $oldcost);
         $oldamt=$this->input->post('inv_amt');
        $inv_amt=str_replace(',','',$oldamt);

        $data=array(
            'model' => $this->input->post('model'),
            'model_yr' => $this->input->post('model_yr'),
            'location' => $loc,
            'purchase_order' => $data3[2],
            'vrr_num' => $this->input->post('vvr_num'),
            'color' => $this->input->post('color'),
            'vin_num' => $this->input->post('vin_num'),
            'engine_num' => $this->input->post('eng_num'),
            'cost' => $cost,
            'remarks' => $this->input->post('remarks'),
            'veh_received'=>$this->input->post('received_date'),
            'csr_received'=>$this->input->post('csr_date'),
            'subsidy'=>$this->input->post('subsidy'),
            'prod_num' => $this->input->post('prod_num'),
            'paid_date'=>$this->input->post('paid_date')
        );
        $this->Main_m->updateinfo($data,$id);

        $pr_dateget=$this->input->post('pr_date');
        $pr_dateArray= explode('-', $pr_dateget);
        $pr_date = new DateTime();
        $pr_date->setDate($pr_dateArray[1], $pr_dateArray[0], 01);
        $pr_date=$pr_date->format('Y-m-d');

        $sr_dateget=$this->input->post('sr_date');
        $sr_dateArray= explode('-', $sr_dateget);
        $sr_date = new DateTime();
        $sr_date->setDate($sr_dateArray[1], $sr_dateArray[0], 01);
        $sr_date=$sr_date->format('Y-m-d');

            $datainv=array(
                'first_name' => $this->input->post('first_name'),
                'middle_name' => $this->input->post('middle_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'invoice_num' => $this->input->post('inv_num'),
                'pay_amt'=>$inv_amt,
                'alloc_date' => $this->input->post('alloc_date'),
                'salesperson' => $this->input->post('salesperson'),
                'invoice_date' => $this->input->post('inv_date'),
                'term' => $this->input->post('term'),
                'grp_lica' => $this->input->post('grp_lica'),
                'grp_plant' => $this->input->post('grp_plant'),
                'plant_release_date' => $pr_date,
                'system_release_date' => $sr_date,
                'actual_release_date' => $this->input->post('ar_date')
            );
        $this->Main_m->updateinfo2($datainv,$id);

        $status='';
        if(empty($_POST['received_date']) AND empty($_POST['alloc_date']) AND empty($_POST['inv_num']) AND empty($_POST['ar_date']))
        {
            $status='For Pull Out';
        }else if(empty($_POST['alloc_date']) AND empty($_POST['inv_num']) AND empty($_POST['ar_date']))
        {
            $status='Available';
        }else if(empty($_POST['inv_num']) AND empty($_POST['ar_date']))
        {
            $status='Allocated';
        }else if(empty($_POST['ar_date']))
        {
            $status='Invoiced';
        }else{
            $status='Released';
        }
        $datas=array(
          'status' => $status
        );

        $this->Main_m->updateStatusNew($datas,$csnum);
        echo json_encode($data);
    }

    public function new_info_form2()
    {
        $id=$_GET['id'];

        $checksalesperson=$this->Main_m->Csalesperson($id);
        foreach ($checksalesperson as $value) {
            if (preg_match('/\d/', $value->salesperson))
            {
                $data['info']=$this->Main_m->dataInfo2($id);
            }else{
                $data['info']=$this->Main_m->dataInfo3($id);
            }
        }

        $this->load->view('user/new_Forms/new_info_form2',$data);
    }
    public function downloaddb()
    {
      if($this->session->userdata('logged_in'))
        {
            $this->load->view('v2/partial/header');
            $this->load->view('user/download/downloaddb');
            $this->load->view('v2/partial/footer');
        }else{
            $this->load->view('LoginView');
        }
    }
    public function download()
    {
        // Header info settings

        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];
        $monthly=date($_POST['Month']);
        $last=date('t',strtotime($monthly));
        $ex=explode("-",$monthly);
        $firstdate='01-'.$ex[0].'-'.$ex[1];
        $lastdate=$last.'-'.$ex[0].'-'.$ex[1];
        $firstdate=date('Y-m-d', strtotime($firstdate));
        $lastdate=date('Y-m-d', strtotime($lastdate));
        // echo $firstdate.' '.$lastdate;
        // die();
        // $result = json_decode($data, true);
        $id=$datas->id;
        $type=$datas->type;
        $access=$this->Main_m->m_access($id);
        $date=date('Y-m-d');
        $xls_filename="IMAPS_".$date.".xls";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$xls_filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        /***** Start of Formatting for Excel *****/
        // echo '<pre>';
        // Define separator (defines columns in excel &amp; tabs in word)
        $sep = "\t"; // tabbed character

        // Start of printing column names as names of MySQL fields
        $result=array(
            'FIRSTNAME',
            'MIDDLENAME',
            'LASTNAME',
            'CS',
            'MODEL',
            'COLOR',
            'PROD #',
            'ENGINE #',
            'CHASSIS #',
            'YEAR MODEL',
            'ORD DEALER',
            'PO #',
            'PO DATE',
            'PAID DATE',
            'POSTED DATE',
            'SUBSIDY',
            'COST',
            'TERM',
            'BANK',
            'VRR_NO',
            'VEH_RECEIVED',
            'CSR RECEIVED',
            'ALLOC_DATE',
            'SALES PERSON',
            'GROUP LICA',
            'GROUP PLANT',
            'INV_DATE',
            'INV_NO',
            'REL_D ACTUAL',
            'REL_D LICA',
            'REL_D PLANT',
            'STATUS',
            'LOCATION',
            'REMARKS',
            'COMPANY',
            'WHOLE SALE PERIOD',
            'INV AMT',
        );
        for ($i = 0; $i < count($result); $i++) {
            echo $result[$i]. "\t";
        }

        print("\n");

          if($type == 1){
             $data=$this->Main_m->po_datas($firstdate,$lastdate);
          }else{
            $whdealer=array();
            foreach ($access as $acc) {
                $dealer=$acc->key;
                $getdealerid=$this->Main_m->newid2($dealer);
                foreach($getdealerid as $vals)
                {
                  $whdealer[]=$vals->id;
                }
              }
              // echo "<pre>";
              // print_r($whdealer);
               $data=$this->Main_m->po_datas2($whdealer,$firstdate,$lastdate);
          }

          // print_r($data);
          // die();


        foreach($data as $key => $value)
        {
          // echo "<pre>";
          // print_r($value);
          // die();
            if($type == 1){
                foreach($value as  $nkey => $k)
                {
                  if($nkey =='po_num')
                  {
                    $poid=$k;
                    echo $poid."\t";
                  }else if($nkey == 'grp_lica')
                  {
                    $getdealer=$this->Main_m->gndealer($k);
                    $newdealer='';
                    foreach ($getdealer as $value) {
                      $newdealer=$value->newdealer;
                    }
                    echo $newdealer."\t";
                    // die();
                  }else if($nkey == 'grp_plant'){
                    $newdealer='';
                  $getdealer=$this->Main_m->gndealer($k);
                  foreach ($getdealer as $value) {
                    $newdealer=$value->newdealer;
                  }
                  echo $newdealer."\t";
                }else if($nkey =='Product'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $product=$vl->Product;
                    }
                    echo $product."\t";
                  }else{
                    echo $k."\t";
                  }
                }else if($nkey =='color'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $color=$vl->color;
                    }
                    echo $color."\t";
                  }else{
                    echo $k."\t";
                  }
                }else if($nkey =='model_yr'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $model_yr=$vl->model_yr;
                    }
                    echo $model_yr."\t";
                  }else{
                    echo $k."\t";
                  }
                }else if($nkey =='cost'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $cost=$vl->cost;
                    }
                    echo $cost."\t";
                  }else{
                    echo $k."\t";
                  }
                }else{
                    echo $k."\t";
                  }
                }
                print("\n");
            }else{

              foreach($value as  $nkey => $k)
              {
                // echo "<pre>";
                // print_r($nkey);
                if($nkey =='po_num')
                {
                  $poid=$k;
                  echo $poid."\t";
                }else if($nkey == 'grp_lica')
                {
                  $newdealer='';
                  $getdealer=$this->Main_m->gndealer($k);
                  foreach ($getdealer as $value) {
                    $newdealer=$value->newdealer;
                  }
                  echo $newdealer."\t";
                }else if($nkey == 'grp_plant')
                {
                    $newdealer='';
                  $getdealer=$this->Main_m->gndealer($k);
                  foreach ($getdealer as $value) {
                    $newdealer=$value->newdealer;
                  }
                  echo $newdealer."\t";
                }else if($nkey =='Product'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $product=$vl->Product;
                    }
                    echo $product."\t";
                  }else{
                    echo $k."\t";
                  }
                }else if($nkey =='color'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $color=$vl->color;
                    }
                    echo $color."\t";
                  }else{
                    echo $k."\t";
                  }
                }else if($nkey =='model_yr'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $model_yr=$vl->model_yr;
                    }
                    echo $model_yr."\t";
                  }else{
                    echo $k."\t";
                  }
                }else if($nkey =='cost'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $cost=$vl->cost;
                    }
                    echo $cost."\t";
                  }else{
                    echo $k."\t";
                  }
                }else{
                  echo $k."\t";
                }
                // die();
              }
              print("\n");
            }
             // die();
        }
        // End of printing column names

        // Start while loop to get data
        //

        // foreach ($data as $value) {
        //     $schema_insert = "";
        // }
        // while($row = $result)
        // {
        //     $schema_insert = "";
        //     for($j=0; $j < count($result); $j++)
        //     {
        //           if(!isset($row[$j])) {
        //             $schema_insert .= "NULL".$sep;
        //           }
        //           elseif ($row[$j] != "") {
        //             $schema_insert .= "$row[$j]".$sep;
        //           }
        //           else {
        //             $schema_insert .= "".$sep;
        //           }
        //     }
        //         $schema_insert = str_replace($sep."$", "", $schema_insert);
        //         $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        //         $schema_insert .= "\t";
        //         print(trim($schema_insert));
        //         print "\n";
        //     // $this->load->view('v2/partial/header');
        //     // $this->load->view('user/mainView');
        //     // $this->load->view('v2/partial/footer');
        // }
        // $this->downloaddb();
    }
    public function download2()
    {
      header("Content-Type: text/html; charset=UTF-8");
      $session_data = $this->session->userdata('logged_in');
      $datas=$session_data[0];
      // $monthly=date($_POST['Month']);
      // $last=date('t',strtotime($monthly));
      // $ex=explode("-",$monthly);
      // $firstdate='01-'.$ex[0].'-'.$ex[1];
      // $lastdate=$last.'-'.$ex[0].'-'.$ex[1];
      // $firstdate=date('Y-m-d', strtotime($firstdate));
      // $lastdate=date('Y-m-d', strtotime($lastdate));
      // echo $firstdate.' '.$lastdate;
      // die();
      // $result = json_decode($data, true);
      $id=$datas->id;
      $type=$datas->type;
      $access=$this->Main_m->m_access($id);
      $date=date('Y-m-d');
      $xls_filename="IMAPS_".$date.".xls";
      header("Content-Type: application/xls");
      header("Content-Disposition: attachment; filename=$xls_filename");
      header("Pragma: no-cache");
      header("Expires: 0");
      /***** Start of Formatting for Excel *****/
      // echo '<pre>';
      // Define separator (defines columns in excel &amp; tabs in word)
      $sep = "\t"; // tabbed character

      // Start of printing column names as names of MySQL fields
      $result=array(
          'FIRSTNAME',
          'MIDDLENAME',
          'LASTNAME',
          'CS',
          'MODEL',
          'COLOR',
          'PROD #',
          'ENGINE #',
          'CHASSIS #',
          'YEAR MODEL',
          'ORD DEALER',
          'PO #',
          'PO DATE',
          'PAID DATE',
          'POSTED DATE',
          'SUBSIDY',
          'COST',
          'TERM',
          'BANK',
          'VRR_NO',
          'VEH_RECEIVED',
          'CSR RECEIVED',
          'ALLOC_DATE',
          'SALES PERSON',
          'GROUP LICA',
          'GROUP PLANT',
          'INV_DATE',
          'INV_NO',
          'REL_D ACTUAL',
          'REL_D LICA',
          'REL_D PLANT',
          'STATUS',
          'LOCATION',
          'REMARKS',
          'COMPANY',
          'WHOLE SALE PERIOD',
          'INV AMT',
      );
      for ($i = 0; $i < count($result); $i++) {
          echo $result[$i]. "\t";
      }

      print("\n");

        if($type == 1){
           $data=$this->Main_m->po_datas3();
        }else{
          $whdealer=array();
          foreach ($access as $acc) {
              $dealer=$acc->key;
              $getdealerid=$this->Main_m->newid2($dealer);
              foreach($getdealerid as $vals)
              {
                $whdealer[]=$vals->id;
              }
            }
            //
            // print_r($whdealer);
             $data=$this->Main_m->po_datas4($whdealer);
        }

        // print_r($data);
        // die();


        foreach($data as $key => $value)
        {
          $cs=$value->cs_num;
          $poid=$value->po_num;
          // die();
            if($type == 1){
                foreach($value as  $nkey => $k)
                {
                  // $poid=$k->po_num;
                 if($nkey == 'grp_lica')
                  {
                    $getdealer=$this->Main_m->gndealer($k);
                    $newdealer='';
                    foreach ($getdealer as $value) {
                      $newdealer=$value->newdealer;
                    }
                    echo $newdealer."\t";
                    // die();
                  }else if($nkey == 'grp_plant'){
                    $newdealer='';
                  $getdealer=$this->Main_m->gndealer($k);
                  foreach ($getdealer as $value) {
                    $newdealer=$value->newdealer;
                  }
                  echo $newdealer."\t";
                }else if($nkey =='Product'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $product=$vl->Product;
                    }
                    echo $product."\t";
                  }else{
                    echo $k."\t";
                  }
                }else if($nkey =='color'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $color=$vl->color;
                    }
                    echo $color."\t";
                  }else{
                    echo $k."\t";
                  }
                }else if($nkey =='model_yr'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $model_yr=$vl->model_yr;
                    }
                    echo $model_yr."\t";
                  }else{
                    echo $k."\t";
                  }
                }else if($nkey =='cost'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $cost=$vl->cost;
                    }
                    echo $cost."\t";
                  }else{
                    echo $k."\t";
                  }
                }else{
                    echo $k."\t";
                  }
                }
                print("\n");
            }else{

              foreach($value as  $nkey => $k)
              {
                // echo "<pre>";
                // print_r($nkey);
                if($nkey =='po_num')
                {
                  $poid=$k;
                  echo $poid."\t";
                }else if($nkey == 'grp_lica')
                {
                  $newdealer='';
                  $getdealer=$this->Main_m->gndealer($k);
                  foreach ($getdealer as $value) {
                    $newdealer=$value->newdealer;
                  }
                  echo $newdealer."\t";
                }else if($nkey == 'grp_plant')
                {
                    $newdealer='';
                  $getdealer=$this->Main_m->gndealer($k);
                  foreach ($getdealer as $value) {
                    $newdealer=$value->newdealer;
                  }
                  echo $newdealer."\t";
                }else if($nkey =='Product'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $product=$vl->Product;
                    }
                    echo $product."\t";
                  }else{
                    echo $k."\t";
                  }
                }else if($nkey =='color'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $color=$vl->color;
                    }
                    echo $color."\t";
                  }else{
                    echo $k."\t";
                  }
                }else if($nkey =='model_yr'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $model_yr=$vl->model_yr;
                    }
                    echo $model_yr."\t";
                  }else{
                    echo $k."\t";
                  }
                }else if($nkey =='cost'){
                  if(strlen($k) < 1)
                  {
                    $findproduct=$this->Main_m->findproduct($poid);
                    $product='';
                    foreach($findproduct as $vl)
                    {
                      $cost=$vl->cost;
                    }
                    echo $cost."\t";
                  }else{
                    echo $k."\t";
                  }
                }else{
                  echo $k."\t";
                }
                // die();
              }
              print("\n");
            }
             // die();
        }
    }
    public function salesperson()
    {
        $dealer=$_GET['dealer'];
        // if($dealer == 'CARMAX')
        // {
        //     $models=$this->Main_m->models2();
        //      echo json_encode($models);
        // }else{
        //     $models=$this->Main_m->models($dealer);
        //     echo json_encode($models);
        // }
        $salesperson=$this->Main_m->salesperson2($dealer);
        echo json_encode($salesperson);
    }
    public function salesperson4()
    {
      $dealer=$_GET['dealer'];
      $location=$_GET['location'];

      $px=base64_encode("0nlyM3@p1");
      $postData = 'px='.$px.'&c='.$dealer.'&b='.$location;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://dsar.licagroup.biz/api/getsc");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Accept: application/json',
                    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                    'Content-Type: application/json'
                )
            );

            $server_output = curl_exec($ch);
            curl_close ($ch);
      // print_r($server_output);

      // $salesperson=$this->Main_m->salesperson4($dealer,$location);
      $res=json_decode($server_output);
      echo json_encode($res);
    }
    public function salesperson5()
    {
      $po_num=$_GET['po_num'];
      $gedealer=$this->Main_m->getdealer5($po_num);
      $dealer='';
      foreach($gedealer as $val)
      {
        $dealer=$val->Company;
      }
      $location='';

      $px=base64_encode("0nlyM3@p1");
      $postData = 'px='.$px.'&c='.$dealer.'&b='.$location;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://dsar.licagroup.biz/api/getsc");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Accept: application/json',
                    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                    'Content-Type: application/json'
                )
            );

            $server_output = curl_exec($ch);
            curl_close ($ch);
      // print_r($server_output);

      // $salesperson=$this->Main_m->salesperson4($dealer,$location);
      $res=json_decode($server_output);

      echo json_encode($res);
    }
    public function check_po()
    {
        $po_num=$_GET['po_num'];

        $check=$this->Main_m->checkpurchaseorder($po_num);
        foreach($check as $value)
        {
            $vch=$value->has_vehicle;

            if($vch == 0)
            {
                echo 'available';
            }else if($vch==1){
                $dealer=$value->dealer;
                $checkdealer=$this->Main_m->chkdealer($dealer);
                foreach ($checkdealer as $val) {
                    $code=$val->car;
                    if($code == 1)
                    {
                        echo 'car';
                    }else if($code == 0)
                    {
                        echo 'motor';
                    }
                }

            }
        }
    }
    public function close()
    {
        $id=$_GET['id'];
        $data=array(

            'has_vehicle' => 1,
        );
        $this->Main_m->close($id,$data);
        echo json_encode($id);
    }
    public function open()
    {
        $id=$_GET['id'];
        $data=array(
            'has_vehicle' => 0,
        );
        $this->Main_m->open($id,$data);
        echo json_encode($id);
    }
    public function test()
    {
      $px=base64_encode("0nlyM3@p1");
      $postData = 'px='.$px.'&c=NISSAN&b=BATANGAS';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://dsar.licagroup.biz/api/getsc");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Accept: application/json',
                    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                    'Content-Type: application/json'
                )
            );

            $server_output = curl_exec($ch);
            curl_close ($ch);
      print_r($server_output);
    }
    public function IELog()
    {
      $this->load->view('v2/partial/header');
      $this->load->view('user/errorlog');
      $this->load->view('v2/partial/footer');
    }
    public function IELogdata()
    {
      $aColumns = array(
         'P.O Number',
         'Date',
         'Reason'
     );

     // DB table to use
     $this->db->where('deleted',0);
     $this->db->order_by('invtry_import_data.created_at','desc');
     $sTable = 'invtry_import_data';
     // $this->db->order_by('id');
     if(isset($_GET['Status'])){
       if(strlen($_GET['Status']) > 0)
       {

         if($_GET['Status'] =='notclear')
         {
           $this->db->where('invtry_import_data.import_log_Status !=','Insert Successful');
         }else{
           $this->db->where('invtry_import_data.import_log_Status','Insert Successful');
         }
       }
     }
     $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
     $iDisplayLength = $this->input->get_post('iDisplayLength', true);
     $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
     $iSortingCols = $this->input->get_post('iSortingCols', true);
     $sSearch = $this->input->get_post('sSearch', true);
     $sEcho = $this->input->get_post('sEcho', true);

     // Paging
     if(isset($iDisplayStart) && $iDisplayLength != '-1')
     {
         $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
         // $this->db->limit(10,20);
     }

     // Ordering
     if(isset($iSortCol_0))
     {
         for($i=0; $i<intval($iSortingCols); $i++)
         {
             $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
             $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
             $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

             if($bSortable == 'true')
             {
                 $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
             }
         }
     }

     if(isset($sSearch) && !empty($sSearch))
     {
         $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
         for($i=0; $i<count($aColumns); $i++)
         {
             // Individual column filtering
         }

         if(isset($bSearchable) && $bSearchable == 'true')
         {
             //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
             $this->db->group_start();
             $this->db->or_like("invtry_import_data.import_log_Status", $this->db->escape_like_str($sSearch),'both');
             $this->db->or_like("invtry_import_data.po_number", $this->db->escape_like_str($sSearch),'both');
             // $this->db->or_like("import_log_table.csnum", $this->db->escape_like_str($sSearch),'both');
             // $this->db->or_like("import_log_table.invoice_num", $this->db->escape_like_str($sSearch),'both');
             // $this->db->or_like("Status", $this->db->escape_like_str($sSearch),'both');
             $this->db->group_end();
         }
     }

     // Select Data
     //Customize select
     $cSelect = "SQL_CALC_FOUND_ROWS ";
     $cSelect .="invtry_import_data.import_id,";
     $cSelect .="invtry_import_data.po_number as 'P.O Number',";
     $cSelect .="invtry_import_data.created_at as 'Date',";
     $cSelect .="invtry_import_data.import_log_status as 'Reason'";

     $this->db->select($cSelect, false);
     $rResult = $this->db->get($sTable);

     // Data set length after filtering
     $this->db->select('FOUND_ROWS() AS found_rows');
     $iFilteredTotal = $this->db->get()->row()->found_rows;

     // Total data set length
     $iTotal = $this->db->count_all($sTable);

     // Output
     $output = array(
         'sEcho' => intval($sEcho),
         'iTotalRecords' => $iTotal,
         'iTotalDisplayRecords' => $iFilteredTotal,
         'aaData' => array()
     );
     foreach($rResult->result_array() as $aRow)
     {
         $row = array();

         foreach($aColumns as $col)
         {
           // if($col == 'Options'){
           //      $aRow[$col] = '';
           //      if($aRow['Status'] == 'Clear')
           //    {
           //
           //    }else if($aRow['Status'] == 'Invalid')
           //    {
           //
           //    }else if($aRow['Status'] == 'Has same p.o and c,s number')
           //    {
           //      $aRow[$col].="<button class='btn btn-success btn-sm ur' value='".$aRow['log_id']."' >Update</button> ";
           //      $aRow[$col].=" <button class='btn btn-danger btn-sm ig' value='".$aRow['log_id']."' >Ignore</button>";
           //    }else if($aRow['Status'] == 'Has same p.o number')
           //    {
           //      $aRow[$col].="<button class='btn btn-success btn-sm ur' value='".$aRow['log_id']."' >Update</button> ";
           //      $aRow[$col].=" <button class='btn btn-danger btn-sm ig' value='".$aRow['log_id']."' >Ignore</button>";
           //    }else{
           //      $aRow[$col].=" <button class='btn btn-danger btn-sm ig' value='".$aRow['log_id']."' >Ignore</button>";
           //    }
           // }
             $row[] = $aRow[$col];
         }

         $output['aaData'][] = $row;
     }
     echo json_encode($output);

    }
    public function clear()
    {
      $data=array(
        'deleted' => 1
      );
      $clr=$this->Main_m->clrs($data);

      echo json_encode($clr);
    }
    public function updateall()
    {
      $alldata=$this->Main_m->allimportdata();

      foreach($alldata as $value)
      {
        $po_num=$value->po_num;
        $cs_num=$value->vehicle_id;
        $inv_num=$value->invoice_num;
        $po_id='';
        $cs_id='';
        $inv_id='';
        $findpo=$this->Main_m->fpo($po_num);
        foreach($findpo as $vl)
        {
          $po_id=$vl->id;
        }
        $findcs=$this->Main_m->fcs($cs_num);
        foreach($findcs as $vl)
        {
          $cs_id=$vl->id;
        }
        $findinv=$this->Main_m->finv($inv_num);
        foreach($findinv as $vl)
        {
          $inv_id=$vl->id;
        }
        $po_data_up=array(
          'po_date' => $value->po_date,
          'dealer' => $value->dealer,
          'whole_sale_period' => $value->whole_sale_period,
          'has_vehicle' => $value->has_vehicle,
        );
        $v_data_up=array(
          'cs_num'=>$value->cs_num,
          'model'=>$value->model,
          'model_yr'=>$value->model_yr,
          'location'=>$value->location,
          'purchase_order'=>$po_id,
          'vrr_num'=>$value->vrr_num,
          'color'=>$value->color,
          'prod_num'=>$value->prod_num,
          'vin_num'=>$value->vin_num,
          'paid_date'=>$value->paid_date,
          'posted_date'=>$value->posted_date,
          'subsidy'=>$value->subsidy,
          'veh_received'=>$value->veh_received,
          'csr_received'=>$value->csr_received,
          'engine_num'=>$value->engine_num,
          'cost'=>$value->cost,
          'remarks'=>$value->remarks,
        );
        $i_data_up=array(
          'vehicle_id'=> $cs_id,
          'pay_amt' => $value->cost,
          'first_name' => $value->first_name,
          'middle_name' => $value->middle_name,
          'last_name' => $value->last_name,
          'alloc_date' => $value->alloc_date,
          'salesperson' => $value->salesperson,
          'invoice_date' => $value->invoice_date,
          'invoice_num' => $value->invoice_num,
          'company' => $value->company,
          'term' => $value->term,
          'bank' => $value->bank,
          'grp_lica' => $value->grp_lica,
          'grp_plant' => $value->grp_plant,
          'actual_release_date' => $value->actual_release_date,
          'plant_release_date' => $value->plant_release_date,
          'system_release_date' => $value->system_release_date,
        );
        $this->Main_m->updatePoIE($po_data_up,$po_id);
        $this->Main_m->updateVIE($v_data_up,$cs_id);
        $this->Main_m->updateINVIE($i_data_up,$inv_id);
        $id=$value->log_id;
        $updata=array('Status'=>'Clear');
        $this->Main_m->updateStatusIE($id,$updata);
      }
      echo json_encode('Update Successful');
          // $color=$value->Status;
    }
    public function closedpo()
    {
      if($this->session->userdata('logged_in'))
          {
      $this->load->view('v2/partial/header');
      $this->load->view('user/closedpoview');
      $this->load->view('v2/partial/footer');
       }else{

          $this->load->view('LoginView');
         }
    }
    public function closedrecord()
    {
        $session_data = $this->session->userdata('logged_in');
        $datas=$session_data[0];
        $id=$datas->id;
        $type=$datas->type;
        $access=$this->Main_m->m_access($id);
        $dealer=array();
        foreach($access as $value) {
          $dealer[]=$value->key;
        }

        if($type == 1){
        }else{
        $getdealerid=$this->Main_m->newid($dealer);
        }

         $aColumns = array(
            'CS Number',
            'P.O Number',
            'Car',
            'Dealer',
            'Status',
            'Options'
        );

        // DB table to use
        if($type == 1){

        }else{
          $this->db->group_start();
          foreach($getdealerid as $val)
          {
            // print_r($value->id);
            // die();
            $this->db->or_where('invtry_purchase_order.dealer =',$val->id);
          }
          $this->db->group_end();

        }
        $this->db->order_by('date_added','DESC');
        $this->db->where('invtry_vehicle.deleted','0');
        $this->db->where('invtry_status.status','Released');
        $this->db->group_start();
        $this->db->or_where('invtry_invoice.plant_release_date !=','0000-00-00');
        $this->db->or_where('invtry_invoice.system_release_date !=','0000-00-00');
        $this->db->or_where('invtry_invoice.actual_release_date !=','0000-00-00');
        $this->db->group_end();
        // $this->db->where('invtry_invoice.system_release_date IS NOT NULL', NULL, TRUE);
        // $this->db->where('invtry_invoice.actual_release_date IS NOT NULL', NULL, TRUE);
        // $this->db->where('invtry_status.status','Released');
        $sTable = 'invtry_vehicle';

        $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            // $this->db->limit(10,20);
        }

        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }

        if(isset($sSearch) && !empty($sSearch))
        {
            $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
            for($i=0; $i<count($aColumns); $i++)
            {
                // Individual column filtering
            }

            if(isset($bSearchable) && $bSearchable == 'true')
            {
                //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("invtry_purchase_order.po_num", $this->db->escape_like_str($sSearch),'both');
                 $this->db->or_like("CONCAT(product.Product,' ',invtry_vehicle.model_yr)", $this->db->escape_like_str($sSearch),'both');
                 $this->db->or_like("invtry_vehicle.cs_num", $this->db->escape_like_str($sSearch),'both');
                 $this->db->or_like("invtry_status.status", $this->db->escape_like_str($sSearch),'both');
                 $this->db->or_like("CONCAT(company_branch.Company,' ',company_branch.Branch)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="invtry_vehicle.id as 'CheckBox',";
        $cSelect .="invtry_vehicle.id as 'ids',";
        $cSelect .="invtry_vehicle.cs_num as'CS Number',";
        $cSelect .="invtry_vehicle.model as 'Model',";
        $cSelect .="invtry_vehicle.model_yr as 'ModelYR',";
        $cSelect .="invtry_vehicle.purchase_order as 'P.O Number',";
        $cSelect .="invtry_vehicle.model,";
        $cSelect .="invtry_vehicle.location as 'Location',";
        $cSelect .="invtry_vehicle.vrr_num,";
        $cSelect .="invtry_vehicle.vrr_date,";
        $cSelect .="invtry_vehicle.color,";
        $cSelect .="invtry_vehicle.vin_num,";
        $cSelect .="invtry_vehicle.cost as 'Cost',";
        $cSelect .="invtry_vehicle.remarks,";
        $cSelect .="invtry_vehicle.veh_received as'received',";
        $cSelect .="invtry_vehicle.date_added,";
        $cSelect .="invtry_vehicle.added_by,";
        $cSelect .="invtry_vehicle.has_invoice,";
        $cSelect .="invtry_vehicle.is_release,";
        $cSelect .="invtry_vehicle.deleted,";
        $cSelect .="invtry_purchase_order.po_num as 'P.O Number',";
        $cSelect .="CONCAT(product.Product,' ',invtry_vehicle.model_yr) as 'Car',";
        $cSelect .="CONCAT(company_branch.Company,' ',company_branch.Branch) as 'Dealer',";
        // $cSelect .="invtry_purchase_order.dealer as 'Dealer',";
        $cSelect .="invtry_status.status,";

        $this->db->select($cSelect, false);
        $this->db->join('invtry_status','invtry_status.cs_num = invtry_vehicle.cs_num','left');
        $this->db->join('invtry_purchase_order','invtry_purchase_order.id = invtry_vehicle.purchase_order','left');
        $this->db->join('product','product.id = invtry_vehicle.model','left');
        $this->db->join('company_branch','company_branch.id = invtry_purchase_order.dealer','left');
        $this->db->join('invtry_invoice','invtry_invoice.vehicle_id = invtry_vehicle.id','left');
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach($aColumns as $col)
            {
              $ids=$aRow['ids'];
              $newdealer=$this->Main_m->ndealer($ids);
              $did=$newdealer[0]->grp_lica;
                 if($col == 'Status'){
                    $aRow[$col] = '';
                    $cs=$aRow['CS Number'];
                    $poid=$aRow['P.O Number'];
                    // echo $cs.$poid;
                     $stats=$aRow['status'];
                        if($stats == 'Available')
                        {
                            $aRow[$col]='<z style="color:Green;">'.$stats.'</z>';
                        }
                        else if($stats == 'Allocated')
                        {
                            $aRow[$col]='<z style="color:Violet;">'.$stats.'</z>';
                        }
                        else if($stats == 'Invoiced')
                        {
                            $aRow[$col]='<z style="color:orange;">'.$stats.'</z>';
                        }
                        else if($stats == 'Released')
                        {
                            $aRow[$col]='<z style="color:red;">'.$stats.'</z>';
                        }
                        else
                        {
                            $aRow[$col]=$stats;
                        }


                      }
                if($col == 'Options'){
                     $aRow[$col] = '';
                    $cs=$aRow['CS Number'];
                    $poid=$aRow['P.O Number'];
                    // echo $cs.$poid;
                     $stats=$aRow['status'];
                        if($stats == 'Available')
                        {
                            $aRow[$col]='<button class="btn btn-sm btn-primary alloc" value="'.$cs.'">Allocate</button> <button class="btn btn-sm btn-primary invoice" value="'.$cs.'">Invoice</button> ';
                        }
                        else if($stats == 'Allocated')
                        {
                            $aRow[$col]='<button class="btn btn-sm btn-primary invoice" value="'.$cs.'">Invoice</button> <button class="btn btn-sm btn-success released" value="'.$cs.'">Release</button>';
                        }
                        else if($stats == 'Invoiced')
                        {
                            $aRow[$col]='<button class="btn btn-sm btn-success released" value="'.$cs.'">Release</button>';
                        }
                        else if($stats == 'Released')
                        {
                            $aRow[$col]='<button class="btn btn-sm btn-primary info" value="'.$cs.'">View Details</button>';
                        }
                        else
                        {
                            $aRow[$col]='<button class="btn btn-sm btn-primary received" value="'.$cs.'">Received</button>';
                        }


                }

                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }
    public function Tdashboard()
    {
      if($this->session->userdata('logged_in'))
          {
      $this->load->view('v2/partial/header');
      $this->load->view('treasury/tdashboard');
      $this->load->view('v2/partial/footer');
       }else{

          $this->load->view('LoginView');
         }
    }
    public function tdata()
      {
        // $session_data = $this->session->userdata('logged_in');
        // $datas=$session_data[0];
        // $id=$datas->id;
        // $type=$datas->type;
        //
        // $access=$this->Main_m->m_access($id);
        // $dealer=array();
        // foreach($access as $value) {
        //   $dealer[]=$value->key;
        // }
        //
        // if($type == 1){
        // }else{
        // $getdealerid=$this->Main_m->newid($dealer);
        // }

        $aColumns = array(
            'P.O. #',
            'Model',
            'Color',
            'P.O. Date',
            'Cost',
            'Bank',
            'FC #',
        );

        // DB table to use

        $this->db->where('invtry_purchase_order.deleted','0');
        $this->db->where('invtry_status.Status !=','For Pull Out');
        $this->db->order_by('selected_po_fc.fc_number','DESC');
        // if($type == 1){
        //
        // }else{
        //   $this->db->group_start();
        //   foreach($getdealerid as $val)
        //   {
        //     // print_r($value->id);
        //     // die();
        //     $this->db->or_where('invtry_purchase_order.dealer =',$val->id);
        //   }
        //   $this->db->group_end();
        //
        // }
        $sTable = 'invtry_purchase_order';

        $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            // $this->db->limit(10,20);
        }

        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                if($bSortable == 'true')
                {

                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }

        if(isset($sSearch) && !empty($sSearch))
        {
            $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
            for($i=0; $i<count($aColumns); $i++)
            {
                // Individual column filtering
            }

            if(isset($bSearchable) && $bSearchable == 'true')
            {
                //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("invtry_purchase_order.po_num", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_purchase_order.po_date", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_purchase_order.model", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_purchase_order.cost", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_purchase_order.color", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("selected_po_fc.bank", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("selected_po_fc.fc_number", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="invtry_purchase_order.id,";
        $cSelect .="invtry_purchase_order.po_num as 'P.O. #',";
        $cSelect .="invtry_purchase_order.po_date as 'P.O. Date',";
        $cSelect .="invtry_vehicle.model as 'Model',";
        $cSelect .="invtry_vehicle.color as 'Color',";
        $cSelect .="invtry_vehicle.cost as 'Cost',";
        $cSelect .="selected_po_fc.bank as 'Bank',";
        $cSelect .="selected_po_fc.fc_number as 'FC #',";
        $cSelect .="invtry_status.Status as 'Status'";

        $this->db->select($cSelect, false);
        $this->db->join('invtry_status','invtry_status.po_id = invtry_purchase_order.id');
        $this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id');
        $this->db->join('invtry_invoice','invtry_invoice.vehicle_id = invtry_vehicle.id');
        $this->db->join('selected_po_fc','selected_po_fc.po_num = invtry_purchase_order.id','left');
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach($aColumns as $col)
            {
              if($col =='FC #')
              {
                if(strlen($aRow[$col]) > 0)
                {
                  $fcno=intval($aRow['FC #'])+10000;
                  $fcno=$fcno+"";
                  $fc=substr($fcno,1);
                  $aRow[$col]='FC'.$fc;
                }
              }
                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
      }
      public function UpdatedataIE()
     {
        $id=$_GET['id'];
        $iedata=$this->Main_m->Iedatalog($id);

        foreach($iedata as $value)
        {
          $po_num=$value->po_num;
          $cs_num=$value->vehicle_id;
          $inv_num=$value->invoice_num;
          $po_id='';
          $cs_id='';
          $inv_id='';
          $findpo=$this->Main_m->fpo($po_num);
          foreach($findpo as $vl)
          {
            $po_id=$vl->id;
          }
          $findcs=$this->Main_m->fcs($cs_num);
          foreach($findcs as $vl)
          {
            $cs_id=$vl->id;
          }
          $findinv=$this->Main_m->finv($inv_num);
          foreach($findinv as $vl)
          {
            $inv_id=$vl->id;
          }
          $po_data_up=array(
            'po_date' => $value->po_date,
            'dealer' => $value->dealer,
            'whole_sale_period' => $value->whole_sale_period,
            'has_vehicle' => $value->has_vehicle,
          );
          $v_data_up=array(
            'cs_num'=>$value->cs_num,
            'model'=>$value->model,
            'model_yr'=>$value->model_yr,
            'location'=>$value->location,
            'purchase_order'=>$po_id,
            'vrr_num'=>$value->vrr_num,
            'color'=>$value->color,
            'prod_num'=>$value->prod_num,
            'vin_num'=>$value->vin_num,
            'paid_date'=>$value->paid_date,
            'posted_date'=>$value->posted_date,
            'subsidy'=>$value->subsidy,
            'veh_received'=>$value->veh_received,
            'csr_received'=>$value->csr_received,
            'engine_num'=>$value->engine_num,
            'cost'=>$value->cost,
            'remarks'=>$value->remarks,
          );
          $i_data_up=array(
            'vehicle_id'=> $cs_id,
            'pay_amt' => $value->cost,
            'first_name' => $value->first_name,
            'middle_name' => $value->middle_name,
            'last_name' => $value->last_name,
            'alloc_date' => $value->alloc_date,
            'salesperson' => $value->salesperson,
            'invoice_date' => $value->invoice_date,
            'invoice_num' => $value->invoice_num,
            'company' => $value->company,
            'term' => $value->term,
            'bank' => $value->bank,
            'grp_lica' => $value->grp_lica,
            'grp_plant' => $value->grp_plant,
            'actual_release_date' => $value->actual_release_date,
            'plant_release_date' => $value->plant_release_date,
            'system_release_date' => $value->system_release_date,
          );
          $this->Main_m->updatePoIE($po_data_up,$po_id);
          $this->Main_m->updateVIE($v_data_up,$cs_id);
          $this->Main_m->updateINVIE($i_data_up,$inv_id);
        }
        $updata=array('Status'=>'Clear');
        $this->Main_m->updateStatusIE($id,$updata);
        echo json_encode($id);
     }
  public function UpdateInvalid()
  {
    $id=$_GET['id'];
    $data=array(
      'Status' => 'Invalid',
    );
    $test=$this->Main_m->updateTI($data,$id);
    echo json_encode($test);
  }
  public function newfc()
  {
    $fcCheck=$this->Main_m->checkfc();
    $count=count($fcCheck);
    $newfcnumber=0;
    if(count($fcCheck) > 0 )
    {
      foreach($fcCheck as $value)
      {
        $fcnumber=$value->fc_number;
        $fcnumber++;
        $newfcnumber=$fcnumber;
        $data=array(
          'fc_number' => $fcnumber
        );
        $this->Main_m->addFc($data);
      }
    }else{
      $fcnumber=1;
      $newfcnumber=$fcnumber;
      $data=array(
        'fc_number' => $fcnumber
      );
      $this->Main_m->addFc($data);
    }
    $newnumber='FC000'.$newfcnumber;
    echo json_encode($newnumber);
  }
  public function addFCForm()
  {
    $data['fcnumber']=$_GET['fcnumber'];
    $data['bank']=$this->Main_m->bank();
    // $data['po_record']=$this->Main_m->po_numbers();
    // $data['fcpo']=$this->Main_m->fcpo();
    $this->load->view('treasury/Forms/addFC',$data);
  }
  public function po_nums()
  {
    $po_record=$this->Main_m->po_numbers();

    $record=array();
    foreach($po_record as $value)
    {
      $id=$value->id;
      $fcpo=$this->Main_m->fcpo($id);
      if(count($fcpo) > 0)
      {

      }else{
         $record[]=array('id'=>$value->id,'po_num'=>$value->po_num);
      }
      // if(count($fcpo) > 0)
      // {
      //   foreach($fcpo as $val)
      //   {
      //     if($value->id == $val->po_num)
      //     {
      //
      //     }else{
      //       $record[]=array('id'=>$value->id,'po_num'=>$value->po_num);
      //     }
      //   }
      // }else{
      //   $record[]=array('id'=>$value->id,'po_num'=>$value->po_num);
      // }
    }
    echo json_encode($record);
  }
  public function addfc()
  {
    $fcnumber=$_POST['fc_number'];
    $fcbank=$_POST['bank'];
    $ponum=$_POST['ponum'];
    $POCheck=$this->Main_m->POFCCheck($ponum);
    $cnt=count($POCheck);
    if($cnt > 0 )
    {
      echo json_encode('error');
    }else{
      $fcnumbers=str_replace("FC000","",$fcnumber);
      $data=array(
        'po_num' => $ponum,
        'fc_number' => $fcnumbers,
        'bank' =>  $fcbank,
        'status'=>1,
      );
      $last_id=$this->Main_m->addSelected($data);
      $FCSelect=$this->Main_m->SelectedPO($ponum);

      $newdata=array('fcnumber'=>$fcnumber,'FCSelect'=> $FCSelect,'FCID'=>$last_id,'Check'=>$cnt);
      echo json_encode($newdata);
    }

  }
  public function removepo()
  {
    $vals=$_GET['id'];
    $ar=explode(",",$vals);
    $val=$ar[0];
    $cost=$ar[1];
    $data=array('status'=>0);
    $this->Main_m->updateSelected($data,$val);

    echo json_encode($cost);
  }
  public function getfc()
  {
    echo json_encode($_GET['nfc']);
  }
  public function submitFC()
  {
    $fcno=$this->input->post('fc_numbers');
    $fc_number=str_replace("FC000","",$fcno);
    $total=$this->input->post('total');
    $data=array('total'=>$total);
    $this->Main_m->updateFC($fc_number,$data);
    echo json_encode($total);
  }
  public function reportedRecord()
  {
    $session_data = $this->session->userdata('logged_in');
    $datas=$session_data[0];
    $id=$datas->id;
    $type=$datas->type;

    $access=$this->Main_m->m_access($id);
    $dealer=array();
    foreach($access as $value) {
      $dealer[]=$value->key;
    }

    if($type == 1){
    }else{
    $getdealerid=$this->Dsar_m->newid($dealer);
    // print_r($getdealerid);
    // die();
    }
    $aColumns = array(
            'C.S. Number',
            'P.O. Number',
            'Accounting Status',
            'Inventory Status',
            'Options'
        );


      $this->db->where('invtry_acc_status.status','Reported');
      if($type == 1){

      }else{
        $this->db->group_start();
        foreach($getdealerid as $val)
        {

          $this->db->or_where('invtry_purchase_order.dealer =',$val->id);
        }
        $this->db->group_end();

      }
      $sTable = 'invtry_vehicle';

      $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
      $iDisplayLength = $this->input->get_post('iDisplayLength', true);
      $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
      $iSortingCols = $this->input->get_post('iSortingCols', true);
      $sSearch = $this->input->get_post('sSearch', true);
      $sEcho = $this->input->get_post('sEcho', true);

      // Paging
      if(isset($iDisplayStart) && $iDisplayLength != '-1')
      {
          $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
          // $this->db->limit(10,20);
      }

      // Ordering
      if(isset($iSortCol_0))
      {
          for($i=0; $i<intval($iSortingCols); $i++)
          {
              $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
              $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
              $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

              if($bSortable == 'true')
              {
                  $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
              }
          }
      }

      if(isset($sSearch) && !empty($sSearch))
      {
          $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
          for($i=0; $i<count($aColumns); $i++)
          {
              // Individual column filtering
          }

          if(isset($bSearchable) && $bSearchable == 'true')
          {
              //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
              $this->db->group_start();
              $this->db->or_like("invtry_purchase_order.po_num", $this->db->escape_like_str($sSearch),'both');
              $this->db->or_like("invtry_vehicle.cs_num", $this->db->escape_like_str($sSearch),'both');
              $this->db->group_end();
          }
      }

      // Select Data
      //Customize select
      $cSelect = "SQL_CALC_FOUND_ROWS ";
      $cSelect .="invtry_vehicle.id,";
      $cSelect .="invtry_vehicle.cs_num as 'C.S. Number',";
      $cSelect .="invtry_vehicle.cs_num,";
      $cSelect .="invtry_purchase_order.po_num as 'P.O. Number',";
      $cSelect .="invtry_acc_status.status as 'Accounting Status',";
      $cSelect .="invtry_status.status as 'Inventory Status',";
      $cSelect .="invtry_status.status as 'invStatus',";

      $this->db->select($cSelect, false);
      $this->db->join('invtry_purchase_order','invtry_purchase_order.id = invtry_vehicle.purchase_order','left');
      $this->db->join('invtry_acc_status','invtry_purchase_order.po_num = invtry_acc_status.po_number','left');
      $this->db->join('invtry_status','invtry_purchase_order.po_num = invtry_status.po_number','left');
      // $this->db->join('collecti_gp_db.gp','collecti_gp_db.gp.cs_num = invtry_vehicle.cs_num','left');
      $rResult = $this->db->get($sTable);

      // Data set length after filtering
      $this->db->select('FOUND_ROWS() AS found_rows');
      $iFilteredTotal = $this->db->get()->row()->found_rows;

      // Total data set length
      $iTotal = $this->db->count_all($sTable);

      // Output
      $output = array(
          'sEcho' => intval($sEcho),
          'iTotalRecords' => $iTotal,
          'iTotalDisplayRecords' => $iFilteredTotal,
          'aaData' => array()
      );

      foreach($rResult->result_array() as $aRow)
      {
          $row = array();

          foreach($aColumns as $col)
          {
            if($col == 'Accounting Status')
            {
                  $aRow[$col]='<span style="color:green;">'.$aRow[$col].'</span>';
            }
            if($col == 'Inventory Status')
            {
                  $aRow[$col]='<span style="color:blue;">'.$aRow[$col].'</span>';
            }
            if($col == 'Options'){
                  $aRow[$col] = '';
                  $aRow[$col] .= "<button class='btn btn-sm btn-primary view' value='".$aRow['id'].','.$aRow['C.S. Number'].','.$aRow['P.O. Number']."'>View</button> ";
                  if($aRow['invStatus'] == 'For Pull Out'){
                    $aRow[$col] .= "<button class='btn btn-sm btn-success receive' value='".$aRow['id'].','.$aRow['P.O. Number']."'>Receive</button> ";
                  }else if($aRow['invStatus'] == 'Received'){
                    $aRow[$col] .= "<button class='btn btn-sm btn-success release' value='".$aRow['id'].','.$aRow['C.S. Number'].','.$aRow['P.O. Number']."'>Release</button> ";
                  }
                  $aRow[$col] .= "<button class='btn btn-sm btn-danger cl' value='".$aRow['id']."'>Change Location</button> ";
              }

              $row[] = $aRow[$col];
          }

          $output['aaData'][] = $row;
      }
      echo json_encode($output);
  }
  public function editCS()
  {
    $session_data = $this->session->userdata('logged_in');
    $datas=$session_data[0];

    $loc=$this->input->post('location');

    $oldcost=$this->input->post('cost');
    $cost=str_replace( ',', '', $oldcost);

    $oldamt=$this->input->post('inv_amt');
    $inv_amt=str_replace(',','',$oldamt);

    $oldcsnum=$this->input->post('csnum');
    $oldcsnum = str_replace(' ', '', $oldcsnum);
    $newcsnum=$oldcsnum;
    $csnum=$this->input->post('csnum2');

    $received_date=$this->input->post('received_date');
    if($received_date != ''){
      $nreceived_date=date("Y-m-d", strtotime($received_date));
    }else{
      $nreceived_date= NULL;
    }


    $alloc_date=$this->input->post('alloc_date');
    if($alloc_date != ''){
      $nalloc_date=date("Y-m-d", strtotime($alloc_date));
    }else{
      $nalloc_date= NULL;
    }


    $paid_date=$this->input->post('paid_date');
    if($paid_date != ''){
      $npaid_date=date("Y-m-d", strtotime($paid_date));
    }else{
      $npaid_date= NULL;
    }


    $csr_date=$this->input->post('csr_date');
    if($csr_date != ''){
      $ncsr_date=date("Y-m-d", strtotime($csr_date));
    }else{
      $ncsr_date= NULL;
    }


    $ardI=$this->input->post('ardI');
    if($ardI != ''){
      $nardI=date("Y-m-d", strtotime($ardI));
    }else{
      $nardI= NULL;
    }

    $psm=$this->input->post('plant_sales_month');
    if(strlen($psm) > 0)
    {
      $psmArray= explode('-', $psm);
      $date = new DateTime();
      $date->setDate($psmArray[1], $psmArray[0], 01);
      $newpsm=$date->format('Y-m-d');
    }else
    {
      $newpsm=NULL;
    }

        $data=array(
            'cs_num' => $newcsnum,
            'model' => $this->input->post('model'),
            'model_yr' => $this->input->post('model_yr'),
            'location' => $loc,
            'vrr_num' => $this->input->post('vrr_num'),
            'color' => $this->input->post('color'),
            'vin_num' => $this->input->post('vin_num'),
            'engine_num' => $this->input->post('eng_num'),
            'prod_num' => $this->input->post('prod_num'),
            'cost' => $cost,
            'remarks' => $this->input->post('remarks'),
            'veh_received'=>$nreceived_date,
            'csr_received'=>$ncsr_date,
            'subsidy_claiming'=>$this->input->post('subsidy_claiming'),
            'subsidy_claimed'=>$this->input->post('subsidy_claimed'),
            'alloc_date'=>$nalloc_date,
            'alloc_dealer'=>$this->input->post('alloc_dealer'),
            'plant_sales_report'=>$this->input->post('plant_sales_report'),
            'plant_sales_month'=>$newpsm,
            'paid_date'=>$npaid_date,
            'imaps_actual_release_date'=>$nardI,
            'added_by' => $datas->id,
            'deleted' => 0
        );

        $cs_id=$this->Main_m->updateCS($data,$csnum);
        $po_num=str_replace(' ', '', $this->input->post('ponumcs'));

        $getDetails=$this->Dashboard_m->getDetails2($po_num);
        foreach($getDetails as $value)
        {
            $po_num=$value->po_num;
            $ardI=$value->imaps_actual_release_date;
            if($ardI != ''){
              $nardI=date("Y-m-d", strtotime($ardI));
            }else{
              $nardI= NULL;
            }
            $veh_received=$value->veh_received;

            if($veh_received != '0000-00-00' AND $veh_received != ''){
                $veh_received=date("Y-m-d", strtotime($veh_received));
            }else{
              $veh_received= NULL;
            }

            // INVENTORY STATUS
            $invtry_status=array();
              if($veh_received != NULL)
              {
                if($nardI != NULL)
                {
                  $invtry_status=array('status' => 'Released' );
                }else{
                  $invtry_status=array('status' => 'Received' );
                }
              }else{
                $invtry_status=array('status' => 'For Pull Out' );
              }

            // INVENTORY STATUS

            // ACCOUNT STATUS
            $cs_num=$value->cs_num;
            if($cs_num == '')
            {
              $cs_num=NULL;
            }

            $model=$value->model;
            if($model == '')
            {
              $model=NULL;
            }

            $model_yr=$value->model_yr;
            if($model_yr == '')
            {
              $model_yr=NULL;
            }

            $alloc_date=$value->alloc_date;
            if($alloc_date != '0000-00-00' AND $alloc_date != ''){
                $alloc_date=date("Y-m-d", strtotime($alloc_date));
            }else{
              $alloc_date= NULL;
            }

            $plant_sales_month=$value->plant_sales_month;
            if(strlen($plant_sales_month) > 0)
            {
              $psmArray= explode('-', $plant_sales_month);
              $date = new DateTime();
              $date->setDate($psmArray[1], $psmArray[0], 01);
              $plant_sales_month=$date->format('Y-m-d');
            }else
            {
              $plant_sales_month=NULL;
            }

            $alloc_dealer=$value->alloc_dealer;
            if($alloc_dealer == '')
            {
              $alloc_dealer=NULL;
            }

            $plant_sales_report=$value->plant_sales_report;
            if($plant_sales_report == '')
            {
              $plant_sales_report=NULL;
            }

            $gpdata=$this->Gp_m->get_details2($cs_num);
            $invtry_acc_status=array();
            if($cs_num != NULL AND $model != NULL AND $model_yr != NULL)
            {
              if($alloc_date != NULL AND $alloc_dealer != NULL)
              {
                if(count($gpdata) > 0 ){
                  foreach($gpdata as $val)
                  {
                    $invoice_date=$val->invoice_date;
                    if($invoice_date != '0000-00-00' AND $invoice_date != ''){
                        $invoice_date=date("Y-m-d", strtotime($invoice_date));
                    }else{
                      $invoice_date= NULL;
                    }

                    $post_status=$val->post_status;
                    if($post_status == '')
                    {
                      $post_status=NULL;
                    }
                  }

                 if($post_status != 'trash'){

                   if($invoice_date != NULL)
                   {
                     if($plant_sales_report != NULL  AND $plant_sales_month != NULL )
                     {
                       $invtry_acc_status=array('status' => 'Reported' );
                     }else{
                       $invtry_acc_status=array('status' => 'Invoiced');
                     }
                   }else{
                   $invtry_acc_status=array('status' => 'Allocated' );
                  }
                 }else{
                 $invtry_acc_status=array('status' => 'Allocated' );
                }

              }else{
                  $invtry_acc_status=array('status' => 'Allocated' );
              }

            }else{
                $invtry_acc_status=array('status' => 'Available' );
            }
          }
            // ACCOUNT STATUS
            $checkAccStatus=$this->Dashboard_m->checkAccStatus($po_num);
            $checkInvStatus=$this->Dashboard_m->checkInvStatus($po_num);
            if(count($checkAccStatus) > 0)
            {
              $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
            }else{
              $status_data=array(
                'po_number'=>$po_num,
                'status'=>$invtry_acc_status['status']
              );
              $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
            }

            if(count($checkInvStatus) > 0)
            {
              $updateStatus1=$this->Main_m->updateIS($po_num,$invtry_status);
            }else{
              $status_data=array(
                'po_number'=>$po_num,
                'status'=>$invtry_status['status']
              );
              $insertStatus1=$this->Dashboard_m->insertStatus($status_data);
            }
        }
        echo json_encode($cs_num);

  }
}
