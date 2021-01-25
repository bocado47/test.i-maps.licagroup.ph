<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

  public function __construct()
  {
      date_default_timezone_set('Asia/Manila');

      parent::__construct();

      $this->load->database();
      $this->load->library('session');
      if(!$this->session->userdata('logged_in'))
      {
        die("You don't have access here: <a href='".base_url()."Login'>Login Here! </a>");
      }
  }
  public function index()
  {
          $session_data = $this->session->userdata('logged_in');
          $this->load->view('v2/partial/header');
          $this->load->view('v2/Sdashboard');
          $this->load->view('v2/partial/footer');
  }
  public function SearchDashboard()
  {

    $session_data = $this->session->userdata('logged_in');
    $this->load->view('v2/partial/header');
    $this->load->view('v2/Sdashboard');
    $this->load->view('v2/partial/footer');
  }

  public function searchPO()
  {
    $session_data = $this->session->userdata('logged_in');

    $po_num=$_GET['po_num'];
    $cs_num=$_GET['cs_num'];

    if(strlen($po_num) > 0)
    {
      $podetails=$this->Dashboard_m->getpoid($po_num);
      $po_id='';
      foreach($podetails as $val)
      {
        $po_id=$val->id;
      }
      $getcs=$this->Dashboard_m->csdetails3($po_num);
      $cs_num='';
      foreach($getcs as $vl)
      {
        $cs_num=$vl->cs_num;
      }
        $data['csdetails']=$this->Dashboard_m->cs_Details($po_id);
        $data['gpdetails']=$this->Gp_m->get_details_gp($cs_num);
        $data['ardetails']=$this->Gp_m->get_details2($cs_num);
        $data['podetails']=$this->Dashboard_m->po_Details($po_num);
        $data['status']=$this->Dashboard_m->statusdetails($po_id);

        echo json_encode($data);


    }else if(strlen($cs_num) > 0)
    {
      $csdetails=$this->Dashboard_m->csdetails2($cs_num);

      $po_id='';
      foreach($csdetails as $val)
      {
        $po_id=$val->purchase_order;
      }
      //
      // $updategp=$this->Gp_m->get_details($cs_num);
      // foreach($updategp as $value)
      // {
      //   $cs_num=$value->cs_num;
      //   $getPoNum=$this->Dashboard_m->getPO($cs_num);
      //   foreach($getPoNum as $val)
      //   {
      //     $po_num = $val->po_num;
      //     $updateStatus=$this->Dashboard_m->updateStatus3($po_num);
      //   }
      // }

      $data['csdetails']=$this->Dashboard_m->csdetails2($cs_num);
      $data['gpdetails']=$this->Gp_m->get_details_gp($cs_num);
      $data['ardetails']=$this->Gp_m->get_details2($cs_num);
      $data['podetails']=$this->Dashboard_m->po_Details2($po_id);
      $data['status']=$this->Dashboard_m->statusdetails($po_id);

      echo json_encode($data);
    }

  }
  public function addVehiclePO()
  {
    $session_data = $this->session->userdata('logged_in');
    $po_num=$_GET['po_num'];
    $data['podetails']=$this->Dashboard_m->po_Details($po_num);
    $data['location']=$this->Dashboard_m->location();
    $this->load->view('v2/Forms/po_add_vehicle',$data);
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

        $po_id=$this->input->post('poid');

        $check=$this->Main_m->checkpurchaseorder2($po_id);
        $countcheck=count($check);

        $whole_sale_period=$this->input->post('whole_sale_period');
        $datapo=array('whole_sale_period' => $whole_sale_period);
        $insert_wsp=$this->Dashboard_m->insert_wsp($po_num,$datapo);

        if($countcheck > 0)
        {
            echo json_encode($countcheck);
        }else{
            $data=array(
                'cs_num' => strtoupper($csnum),
                'model' => $this->input->post('model2'),
                'model_yr' => $this->input->post('model_yr2'),
                'location' => $loc,
                'purchase_order' => $po_id,
                'vrr_num' => $this->input->post('vvr_num'),
                'color' => $this->input->post('color2'),
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

            $model=$this->input->post('model2');
            $model_yr=$this->input->post('model_yr2');

            $veh_received=$this->input->post('received_date');


            $getDetails=$this->Dashboard_m->getDetails2($po_num);
            foreach($getDetails as $value)
            {
              $po_num=$value->po_num;
              $veh=$value->has_vehicle;
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
              if($veh == 1)
              {
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

              }else{
                  $status_data=array(
                    'po_number'=>$po_num,
                    'status'=>'No Vehicle'
                  );
                  $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
                  $insertStatus1=$this->Dashboard_m->insertStatus($status_data);
              }

            }
            // ACCOUNT STATUS


        }
  }
  public function location()
  {
    $session_data = $this->session->userdata('logged_in');
    $datas=$session_data[0];
    $id=$datas->id;
    $type=$datas->type;

    $accessdealer=$this->Main_m->m_access($id);

    if($type == 1){
      $data=$this->Main_m->location();
      echo json_encode($data);
    }else{
      $data=$this->Main_m->location2($accessdealer);
      echo json_encode($data);
    }

  }
  public function location2()
  {
    $brand=$_GET['brand'];
    $data=$this->Main_m->Brands3($brand);
    echo json_encode($data);
  }
  public function Clocation()
  {
      $this->load->view('v2/partial/header');
      $this->load->view('v2/ChangeLocation');
      $this->load->view('v2/partial/footer');
  }
  public function POCS_loc()
  {
    $aColumns = array(
        'C.S. Number',
        'P.O. Number',
        'Location',
        'Options',
    );

    // DB table to use    }
    $this->db->order_by('invtry_vehicle.Location','DESC');
    $sTable = 'invtry_vehicle';;

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
             $this->db->or_like("invtry_vehicle.location", $this->db->escape_like_str($sSearch),'both');
            $this->db->group_end();
        }
    }

    // Select Data
    //Customize select
    $cSelect = "SQL_CALC_FOUND_ROWS ";
    $cSelect .="invtry_vehicle.id as 'ids',";
    $cSelect .="invtry_vehicle.cs_num as'C.S. Number',";
    $cSelect .="invtry_vehicle.location as 'Location',";
    $cSelect .="invtry_purchase_order.po_num as 'P.O. Number',";

    $this->db->select($cSelect, false);
    $this->db->join('invtry_purchase_order','invtry_purchase_order.id = invtry_vehicle.purchase_order','left');
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
            if($col == 'Options'){
              $id=$aRow['ids'];
              $scl=$this->Dashboard_m->searchChangeLoc($id);
              if($scl == 0)
              {
                $aRow[$col] ='<button type="button" class="btn btn-sm btn-primary add" value="'.$id.'">Add To Selection</button>';
              }else{
                $aRow[$col] ='<button type="button" class="btn btn-sm btn-danger remove" value="'.$id.'">remove To Selection</button>';
              }

            }
            $row[] = $aRow[$col];
        }

        $output['aaData'][] = $row;
    }
    echo json_encode($output);
  }
  public function addToSelection()
  {
    $id=$_GET['id'];
    $data=array('vehicleID' => $id);
    $this->Dashboard_m->addToS($data);
    echo json_encode($data);
  }
  public function removeToSelection()
  {
    $id=$_GET['id'];
    $this->Dashboard_m->removeToS($id);
    echo json_encode($id);
  }
  public function for_pull_out_D()
  {
    $this->load->view('v2/partial/header');
    $this->load->view('v2/Status_F/for_pull_out_D');
    $this->load->view('v2/partial/footer');
  }
  public function receive_D()
  {
    $this->load->view('v2/partial/header');
    $this->load->view('v2/Status_F/received_D');
    $this->load->view('v2/partial/footer');
  }
  public function available_D()
  {
    $this->load->view('v2/partial/header');
    $this->load->view('v2/Status_F/available_D');
    $this->load->view('v2/partial/footer');
  }
  public function allocated_D()
  {
    $data=$this->Gp_m->get_invoiced();
    // echo '<pre>';
    // print_r($data);
    // die();
    foreach($data as $value)
    {
      $cs_num=$value->cs_num;
      $getPoNum=$this->Dashboard_m->getPO($cs_num);
      foreach($getPoNum as $val)
      {
        $po_num = $val->po_num;
        $updateStatus=$this->Dashboard_m->updateStatus3($po_num);
      }
    }

    $this->load->view('v2/partial/header');
    $this->load->view('v2/Status_F/allocated_D');
    $this->load->view('v2/partial/footer');
  }
  public function released_D()
  {
    $this->load->view('v2/partial/header');
    $this->load->view('v2/Status_F/released_D');
    $this->load->view('v2/partial/footer');
  }
  public function invoiced_D()
  {
    $data=$this->Gp_m->get_invoiced();
    foreach($data as $value)
    {
      $cs_num=$value->cs_num;
      $getPoNum=$this->Dashboard_m->getPO($cs_num);
      foreach($getPoNum as $val)
      {
        $po_num = $val->po_num;
        $updateStatus=$this->Dashboard_m->updateStatus3($po_num);
      }
    }

    $this->load->view('v2/partial/header');
    $this->load->view('v2/Status_F/invoiced_D');
    $this->load->view('v2/partial/footer');
  }
  public function reported_D()
  {
    $this->load->view('v2/partial/header');
    $this->load->view('v2/Status_F/reported_D');
    $this->load->view('v2/partial/footer');
  }
  public function alloc_dealer()
  {
    $session_data = $this->session->userdata('logged_in');
    $datas=$session_data[0];
    $ids=$datas->id;
    $type=$datas->type;
    // $access=$this->Main_m->m_access($id);
    $accessdealer=$this->Admin_m->getaccess($ids);
    $dealer="";
    if($type == 2)
    {
      if(count($accessdealer) >= 1)
    	{
    		$dealer=$this->Dsar_m->dealer2($accessdealer);
    		// $location=$CI->main_m->location2($accessdealer);
    	}else{
    		$dealer=$this->Dsar_m->dealer();
    	}
    }else{
      $dealer=$this->Dsar_m->dealer();
    }

    echo json_encode($dealer);
  }
  public function received_form()
  {
    $data['id']=$_GET['id'];
    $data['po_num']=$_GET['po_num'];
    $this->load->view('v2/Forms/receive_form',$data);
  }
  public function receive_function()
  {
    $date=$_POST['received_date'];
    $po_num=$_POST['po_num'];
    $csid=$_POST['csid'];
    $data=array(
        'veh_received'=>$date,
    );
    $data2=array(
      'status' => 'Received',
    );
    //
    $update=$this->Dashboard_m->updateReceive($data,$csid);
    $updateStatus=$this->Dashboard_m->updateInvStatus($data2,$po_num);
    //
    echo json_encode($po_num);
  }
  public function change_location()
  {
    $data['id']=$_GET['id'];
    $id=$_GET['id'];
    $data['info']=$this->Dashboard_m->infoV($id);
    $this->load->view('v2/Forms/change_loc_form',$data);
  }
  public function change_location_function()
  {
    $location=$_POST['location'];
    $csid=$_POST['csid'];
    $data=array(
        'location'=>$location,
    );
    //
    $update=$this->Dashboard_m->updateReceive($data,$csid);
    //
    echo json_encode($csid);
  }
  public function release()
  {
    $id=$_GET['id'];
    $csnum=$_GET['cs_num'];
    $data['po_num']=$_GET['po_num'];
    $data['gp']=$this->Gp_m->SearchData($csnum);
    $data['id']=$id;
    $data['cs_num']=$csnum;
    $this->load->view('v2/Forms/release_form',$data);
  }
  public function release_function()
  {
    $po_num=$_POST['po_num'];
    $csid=$_POST['csid'];
    $imaps_release=$_POST['imaps_release'];
    $gp_release=$_POST['gp_release'];
    $data=array(
        'gp_actual_release_date'=>$gp_release,
        'imaps_actual_release_date'=>$imaps_release,
    );

    $update=$this->Dashboard_m->updateReceive($data,$csid);
    $data2=array(
      'status' => 'Released',
    );
    $updateStatus=$this->Dashboard_m->updateInvStatus($data2,$po_num);
    echo json_encode($csid);
  }
  public function allocate()
  {
    $data['id']=$_GET['id'];
    $data['po_num']=$_GET['po_num'];
    $this->load->view('v2/Forms/allocate_form',$data);
  }
  public function allocate_function()
  {
    $po_num=$_POST['po_num'];
    $csid=$_POST['csid'];
    $alloc_dealer=$_POST['alloc_dealer'];
    $alloc_date=$_POST['alloc_date'];
    $data=array(
        'alloc_dealer'=>$alloc_dealer,
        'alloc_date'=>$alloc_date,
    );

    $update=$this->Dashboard_m->updateReceive($data,$csid);
    $data2=array(
      'status' => 'Allocated',
    );
    $updateStatus=$this->Dashboard_m->updateInvStatus2($data2,$po_num);
    echo json_encode($csid);
  }
  public function changeAlloc()
  {
    $data['id']=$_GET['id'];
    $id=$_GET['id'];
    $data['info']=$this->Dashboard_m->infoV($id);
    $this->load->view('v2/Forms/change_alloc_form',$data);
  }
  public function change_alloc_function()
  {
    $csid=$_POST['csid'];
    $alloc_dealer=$_POST['alloc_dealer'];
    $alloc_date=$_POST['alloc_date'];
    $data=array(
        'alloc_dealer'=>$alloc_dealer,
        'alloc_date'=>$alloc_date,
    );

    //
    $update=$this->Dashboard_m->updateReceive($data,$csid);
    //
    echo json_encode($csid);
  }
  public function report_form()
  {
    $data['id']=$_GET['id'];
    $data['po_num']=$_GET['po_num'];
    $cs_num=$_GET['cs_num'];
    $data['gp']=$this->Gp_m->get_details($cs_num);
    // echo '<pre>';
    // print_r($data);
    $this->load->view('v2/Forms/report_form',$data);
  }
  public function report_function()
  {
    $po_num=$_POST['po_num'];
    $csid=$_POST['csid'];
    $plant_sales_report=$_POST['plant_sales_report'];
    $plant_sales_month=$_POST['plant_sales_month'];
    $test=explode("-",$plant_sales_month);
    $psm=date($test[1].'-'.$test[0].'-1');
    $whole_sale_period=$_POST['whole_sale_period'];
    $data=array(
        'plant_sales_report'=>$plant_sales_report,
        'plant_sales_month'=>$psm,
    );
    $data2=array(
      'status' => 'Reported',
    );
    $data3=array(
      'whole_sale_period' => 'whole_sale_period',
    );
    //
    $update=$this->Dashboard_m->updateReceive($data,$csid);
    $updateStatus=$this->Dashboard_m->updateInvStatus2($data2,$po_num);
    $update2=$this->Dashboard_m->updateInvoiced($data3,$po_num);

    echo json_encode($po_num);
  }
  public function view_details()
  {
    $id=$_GET['id'];
    $csnum=$_GET['cs_num'];
    $ponum=$_GET['po_num'];
    $data['gp']=$this->Gp_m->SearchData($csnum);
    $data['vehicle']=$this->Dashboard_m->vehicleInfo($id);
    $data['po']=$this->Dashboard_m->poInfo($ponum);

    $this->load->view('v2/Forms/view_form',$data);
  }
  public function test()
  {
    echo '<pre>';
    $getcs=$this->Main_m->getallcs();
    $count=0;
    foreach($getcs as $value)
    {
      $csnum=$value->cs_num;
      $ar=$this->Gp_m->testR($csnum);
      foreach($ar as $vl)
      {
        $count++;
      }
    }

    echo $count;
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
  public function model_color()
  {
    $model_id=$_GET['model_id'];

    $color=$this->Main_m->get_color($model_id);
    echo json_encode($color);
  }
  public function updateAllStatus()
  {
    $getDetails=$this->Dashboard_m->getDetails();
    foreach($getDetails as $value)
    {
      $po_num=$value->po_num;
      $veh=$value->has_vehicle;
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
      if($veh == 1)
      {
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

      }else{
          $status_data=array(
            'po_number'=>$po_num,
            'status'=>'No Vehicle'
          );
          $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
          $insertStatus1=$this->Dashboard_m->insertStatus($status_data);
      }

    }

    echo json_encode('success');
  }
  public function updateTest()
  {
    $vinNumCheck=$this->Dashboard_m->vinCheck();
    foreach($vinNumCheck as $val1)
    {
      $cs=$val1->cs_num;
      $importCheckvin=$this->Dashboard_m->importCVin($cs);
      foreach($importCheckvin as $vl2)
      {
        $data1=array(
          'vin_num'=>$vl2->vin_num,
        );
        $cs_num=$vl2->vin_num;
        $updateVinNum=$this->Dashboard_m->updateVin($data1,$cs_num);
      }
    }

    $prodNumCheck=$this->Dashboard_m->prodCheck();
    foreach($prodNumCheck as $val1)
    {
      $cs=$val1->cs_num;
      $importCheckProd=$this->Dashboard_m->importCProd($cs);
      foreach($importCheckProd as $vl2)
      {
        $data2=array(
          'prod_num'=>$vl2->prod_num,
        );
        $cs_num=$vl2->vin_num;
        $updateVinNum=$this->Dashboard_m->updateProd($data2,$cs_num);
      }
    }

    $engNumCheck=$this->Dashboard_m->engCheck();
    foreach($engNumCheck as $val1)
    {
      $cs=$val1->cs_num;
      $importCheckEng=$this->Dashboard_m->importCEng($cs);
      foreach($importCheckEng as $vl2)
      {
        $data3=array(
          'engine_num'=>$vl2->eng_num,
        );
        $cs_num=$vl2->vin_num;
        $updateVinNum=$this->Dashboard_m->updateEng($data3,$cs_num);
      }
    }
  }
  public function requestDashboard()
  {

    $session_data = $this->session->userdata('logged_in');
    $this->load->view('v2/partial/header');
    $this->load->view('v2/RDashboard');
    $this->load->view('v2/partial/footer');
  }
  public function RData()
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
    }

    $aColumns = array(
            'Variant',
            'Color',
            'Quantity',
            'Cost',
            'Justification',
            'Options'
        );

        if($type == 1){

        }else{
          $this->db->group_start();
          foreach($access as $value) {
            if($value->key == 'MORRIS GARAGES')
            {
              $this->db->or_where('invtry_request_table.brand','MG');
            }else{
              $this->db->or_where('invtry_request_table.brand',$value->key);
            }

          }
          $this->db->group_end();

        }
        if(isset($_GET['brand'])){
          if(strlen($_GET['brand']) > 0)
          {
              $this->db->where('invtry_request_table.brand',$_GET['brand']);
          }
        }
        $this->db->where('deleted',0);
        $this->db->where('approved',0);
        $sTable = 'invtry_request_table';

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
                  // $this->db->like("invtry_request_table.variant", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("product.Product", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_request_table.color", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_request_table.justification", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_request_table.quantity", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="invtry_request_table.rt_id,";
        $cSelect .="invtry_request_table.brand,";
        $cSelect .="product.Product as 'Variant',";
        $cSelect .="invtry_request_table.color as 'Color',";
        $cSelect .="invtry_request_table.quantity as 'Quantity',";
        $cSelect .="invtry_request_table.justification as 'Justification',";
        $cSelect .="invtry_request_table.cost as 'Cost',";

        $this->db->select($cSelect, false);
        $this->db->join('product','product.id = invtry_request_table.variant','left');
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
              if($col == 'Options'){
                  $aRow[$col]= '<button class="btn btn-warning btn-sm editR" id="editR" value="'.$aRow['rt_id'].'"> Edit </button> <button class="btn btn-danger  btn-sm cancelR" id="cancelR" value="'.$aRow['rt_id'].'">  Cancel </button>';
                }
                if($col == 'Cost'){
                  $aRow[$col]=number_format((float)$aRow['Cost'],2,'.',',');
                }
                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);

  }
  public function request_form()
  {
      $this->load->view('v2/Forms/request_form');
  }
  public function request_view_form()
  {
    $id=$_GET['rt_id'];
    $data['request_data']=$this->Dashboard_m->requestDate($id);

    $this->load->view('v2/Forms/request_view_form',$data);
  }
  public function saveRequest()
  {
    $data=array();
    $data2=array();
    $count=0;
    $counts=0;
    foreach($_POST['variant'] as $k => $v){
        $model_id=$v;
        $color=$_POST['color'][$k];
        $rows = 'Variant:'.$v.', Color:'.$_POST['color'][$k];
        $checkedData=$this->Dashboard_m->requestDataChecked($model_id,$color);
        if($checkedData > 0)
        {
          $count++;
          $data2[]=array(
            'variant'=>$v,
            'color'=>$_POST['color'][$k]
          );
        }else{
          $counts++;
          $oldcost=$_POST['cost'][$k];
          $cost=str_replace( ',', '', $oldcost);
          $data=array(
            'brand'=>$_POST['Brand'],
            'variant' =>$v,
            'color' => $_POST['color'][$k],
            'quantity' => $_POST['quantity'][$k],
            'cost' => $cost,
            'justification' => $_POST['justification'][$k]
          );

        }
        if($counts > 0)
        {
            $insert_id=$this->Dashboard_m->insertRequest($data);

            $data3=array(
              'rt_id'=>$insert_id,
              'variant' =>$_POST['variant'][$k],
              'color' => $_POST['color'][$k],
              'quantity' => $_POST['quantity'][$k],
              'remarks' => $_POST['justification'][$k],
              'cost' => $cost
            );
            $this->Dashboard_m->insertDatatable($data3);
        }
    }


    echo "Total Count Added Successful = ".$counts;
    echo "<br/>Total Count Added UnSuccessful = ".$count;
    echo "<br/> Added Unsuccessful:";
    foreach($data2 as $vals)
    {
      $model_id=$vals['variant'];
      $variantData=$this->Dashboard_m->finddata($model_id);
      foreach($variantData as $d)
      {
        echo "<br/> =".$d->Product.'-'.$vals['color'];
      }

    }

  }
  public function requestUpdate()
  {
    $rt_id=$_POST['requestid'];
    $oldcost=$_POST['cost'];
    $cost=str_replace(',', '', $oldcost);
    $data=array(
      'cost' => $cost,
      'quantity' => $_POST['quantity'],
      'justification' => $_POST['justification']
    );

    $insert=$this->Dashboard_m->updateRequest($data,$rt_id);
  }
  public function requestCancel()
  {
    $rt_id=$_GET['rt_id'];


    $insert=$this->Dashboard_m->deleteRequest($rt_id);
  }
  public function checkRequestModel()
  {
    $model_id=$_GET['model_id'];
    $color=$_GET['color'];

    $checkedData=$this->Dashboard_m->requestDataChecked($model_id,$color);
    echo json_encode($checkedData);
  }
  public function forApprovalDashboard()
  {

    $session_data = $this->session->userdata('logged_in');
    $this->load->view('v2/partial/header');
    $this->load->view('v2/FADashaboard');
    $this->load->view('v2/partial/footer');
  }
  public function FAData()
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

    // if($type == 1){
    // }else{
    // $getdealerid=$this->Dsar_m->newid($dealer);
    // print_r($getdealerid);
    // die();
    // }

      $aColumns = array(
              'Variant',
              'Color',
              'Quantity',
              'Approved/Intransit',
              'OnHand',
              'For Release',
              'Total Projected Inventory',
              'Ave. Sales',
              'MOS',
              'Justification',
              'Options'
          );

        // if(isset($_GET['brand'])){
        //   if(strlen($_GET['brand']) > 0)
        //   {
              $this->db->where('invtry_request_table.brand',$_GET['brand']);
          // }
        // }
        $this->db->where('deleted',0);
        $this->db->where('approved',0);
        $sTable = 'invtry_request_table';

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

                $this->db->group_start();
                $this->db->or_like("product.Product", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_request_table.color", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_request_table.justification", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_request_table.quantity", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="invtry_request_table.rt_id,";
        $cSelect .="invtry_request_table.brand,";
        $cSelect .="invtry_request_table.variant as'modelid',";
        $cSelect .="product.Product as 'Variant',";
        $cSelect .="invtry_request_table.color as 'Color',";
        $cSelect .="invtry_request_table.quantity as 'Quantity',";
        $cSelect .="invtry_request_table.justification as 'Justification',";

        $this->db->select($cSelect, false);
        $this->db->join('product','product.id = invtry_request_table.variant','left');
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
              if($col == 'Approved/Intransit'){
                $modelid=$aRow['modelid'];
                $color=$aRow['Color'];
                $Sintransit=$this->Dashboard_m->intransitCount($modelid,$color);
                $intransit=$Sintransit;



                $rt_id=$aRow['rt_id'];
                $app=$this->Dashboard_m->approvedCount($modelid,$color);
                $approved=0;
                foreach($app as $value)
                {
                  $approved=$value->quantity;
                }
                $aRow[$col]= $approved + $intransit;
              }
              if($col == 'OnHand'){
                $modelid=$aRow['modelid'];
                $color=$aRow['Color'];
                $onHand=$this->Dashboard_m->onHandCount($modelid,$color);
                $aRow[$col]= $onHand;
              }
              if($col == 'For Release'){
                $modelid=$aRow['modelid'];
                $color=$aRow['Color'];
                $fr=$this->Dashboard_m->forReleaseCount($modelid,$color);
                $forRelease2=0;
                // $cs_num='';
                foreach ($fr as $value) {
                  $cs_num=$value->cs_num;
                  // print_r($value->cs_num);
                  $gpdetails=$this->Gp_m->get_details3($cs_num);
                  //
                  $forRelease=0;
                  foreach ($gpdetails as $value) {

                    if($value->invoice_date == '0000-00-00' OR $value->invoice_date === null)
                    {
                    }else{
                    $forRelease++;

                    }
                  }
                  // print_r($forRelease);
                  $forRelease2=$forRelease2+$forRelease;
                }
                $aRow[$col]= $forRelease2;
              }
              if($col == 'Total Projected Inventory'){
                $modelid=$aRow['modelid'];
                $color=$aRow['Color'];
                $rt_id=$aRow['rt_id'];

                $Sintransit=$this->Dashboard_m->intransitCount($modelid,$color);
                $intransit=$Sintransit;

                $app=$this->Dashboard_m->approvedCount($modelid,$color);
                $approved=0;
                foreach($app as $value)
                {
                  $approved=$value->quantity;
                }
                $onHand=$this->Dashboard_m->onHandCount($modelid,$color);
                $fr=$this->Dashboard_m->forReleaseCount($modelid,$color);
                $forRelease2=0;
                // $cs_num='';
                foreach ($fr as $value) {
                  $cs_num=$value->cs_num;
                  // print_r($value->cs_num);
                  $gpdetails=$this->Gp_m->get_details3($cs_num);
                  //
                  $forRelease=0;
                  foreach ($gpdetails as $value) {

                    if($value->invoice_date == '0000-00-00' OR $value->invoice_date === null)
                    {
                    }else{
                    $forRelease++;

                    }
                  }
                  // print_r($forRelease);
                  $forRelease2=$forRelease2+$forRelease;
                }
                $aRow[$col]= $aRow['Quantity'] + $approved + $onHand + $intransit - $forRelease2;
              }
              if($col == 'Ave. Sales'){
                $modelid=$aRow['modelid'];
                $color=$aRow['Color'];

                $date=date('Y-m-d');
                $date2 = explode("-", $date);
                $month = $date2[0];
                $year = $date2[1];

                $average='';
                if($month == '1' and $year > '2020')
    						{
    							$lsmonth = array('11','12','01');
                  $beginningDate=date($year.'-'.$lsmonth.'-01');
                  $average=$this->Dashboard_m->getAve($modelid,$color,$beginningDate,$date);
                }
                else if($month == '2' and $year > '2020')
    						{
    							$lsmonth = array('12','01','02');
                  $beginningDate=date($year.'-'.$lsmonth.'-01');
                  $average=$this->Dashboard_m->getAve($modelid,$color,$beginningDate,$date);
                }else{
                  $lsmonth = $month - 2;
                  $beginningDate=date($year.'-'.$lsmonth.'-01');
                  $average=$this->Dashboard_m->getAve($modelid,$color,$beginningDate,$date);
                }

                if($average > 0)
                {
                    $aRow[$col]= $average / 3;
                }else{
                    $aRow[$col]= 0;
                }

              }
            if($col == 'MOS'){
                $modelid=$aRow['modelid'];
                $color=$aRow['Color'];
                $rt_id=$aRow['rt_id'];

                $Sintransit=$this->Dashboard_m->intransitCount2($modelid,$color);
                $intransit=0;
                foreach($Sintransit as $vl)
                {
                  $intransit=$vl->intransit;
                }
                $app=$this->Dashboard_m->approvedCount($modelid,$color);
                $approved=0;
                foreach($app as $value)
                {
                  $approved+=$value->quantity;
                }
                $onHand=$this->Dashboard_m->onHandCount($modelid,$color);
                $fr=$this->Dashboard_m->forReleaseCount($modelid,$color);
                $forRelease2=0;
                foreach ($fr as $value) {
                  $cs_num=$value->cs_num;
                  $gpdetails=$this->Gp_m->get_details3($cs_num);
                  //
                  $forRelease=0;
                  foreach ($gpdetails as $value) {

                    if($value->invoice_date == '0000-00-00' OR $value->invoice_date === null)
                    {
                    }else{
                    $forRelease++;

                    }
                  }
                  // print_r($forRelease);
                  $forRelease2=$forRelease2+$forRelease;
                }

                $tpi= $aRow['Quantity'] + $approved + $onHand + $intransit - $forRelease2;
                $date=date('Y-m-d');
                $date2 = explode("-", $date);
                $month = $date2[0];
                $year = $date2[1];

                $average='';
                if($month == '1' and $year > '2020')
    						{
    							$lsmonth = array('11','12','01');
                  $beginningDate=date($year.'-'.$lsmonth.'-01');
                  $average=$this->Dashboard_m->getAve($modelid,$color,$beginningDate,$date);
                }
                else if($month == '2' and $year > '2020')
    						{
    							$lsmonth = array('12','01','02');
                  $beginningDate=date($year.'-'.$lsmonth.'-01');
                  $average=$this->Dashboard_m->getAve($modelid,$color,$beginningDate,$date);
                }else{
                  $lsmonth = $month - 2;
                  $beginningDate=date($year.'-'.$lsmonth.'-01');
                  $average=$this->Dashboard_m->getAve($modelid,$color,$beginningDate,$date);
                }
                if($average > 0)
                {
                    $average= number_format($average / 3,2);
                }else{
                   $average= 0;
                }

                if($tpi > 0 AND $average > 0){
                  $aRow[$col]= number_format($tpi / $average,2);
                }else{
                  $aRow[$col]='0';
                }
              }
              if($col == 'Options'){
                  if($type == 3 OR $type == 2)
                  {
                    $aRow[$col]= '';
                  }else if($type == 4 OR $type == 1 ){
                    $aRow[$col]= '<button class="btn btn-sm btn-success approved" id="approved" value="'.$aRow['rt_id'].'">Approve </button>';
                  }

                }
                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
  }
  public function approved()
  {
    $rt_id=$_GET['rt_id'];
    $date=date('Y-m-d');
    $this->Dashboard_m->updateDataTable($rt_id,$date);
    $requestData=$this->Dashboard_m->rdata($rt_id);
    foreach($requestData as $value)
    {
      $modelid=$value->variant;
      $color=$value->color;
      $quantity=$value->quantity;
      $rt_id=$rt_id;

      $intransit=$this->Dashboard_m->intransitCount($modelid,$color);
      $app=$this->Dashboard_m->approvedCount($modelid,$color);
      $approved=0;
      foreach($app as $value)
      {
        $approved+=$value->quantity;
      }
      if($approved > 0)
      {
        $approved_intransit= $approved + $intransit + $quantity;
      }else{
        $approved_intransit= $quantity + $intransit;
      }


      $on_hand=$this->Dashboard_m->onHandCount($modelid,$color);

      $fr=$this->Dashboard_m->forReleaseCount($modelid,$color);
      $forRelease2=0;
      // $cs_num='';
      foreach ($fr as $value) {
        $cs_num=$value->cs_num;
        // print_r($value->cs_num);
        $gpdetails=$this->Gp_m->get_details3($cs_num);
        //
        $forRelease=0;
        foreach ($gpdetails as $value) {

          if($value->invoice_date == '0000-00-00' OR $value->invoice_date === null)
          {
          }else{
          $forRelease++;

          }
        }
        // print_r($forRelease);
        $forRelease2=$forRelease2+$forRelease;
      }

      $total_projected_inventory= $value->quantity + $approved + $on_hand + $intransit - $forRelease2;

      $date=date('Y-m-d');
      $date2 = explode("-", $date);
      $month = $date2[0];
      $year = $date2[1];

      $average='';
      $ave_sales=0;
      if($month == '1' and $year > '2020')
      {
        $lsmonth = array('11','12','01');
        $beginningDate=date($year.'-'.$lsmonth.'-01');
        $average=$this->Dashboard_m->getAve($modelid,$color,$beginningDate,$date);
      }
      else if($month == '2' and $year > '2020')
      {
        $lsmonth = array('12','01','02');
        $beginningDate=date($year.'-'.$lsmonth.'-01');
        $average=$this->Dashboard_m->getAve($modelid,$color,$beginningDate,$date);
      }else{
        $lsmonth = $month - 2;
        $beginningDate=date($year.'-'.$lsmonth.'-01');
        $average=$this->Dashboard_m->getAve($modelid,$color,$beginningDate,$date);
      }

      if($average > 0)
      {
          $ave_sales = $average / 3;
      }else{
          $ave_sales = 0;
      }
      $mos=0;
      if($total_projected_inventory > 0 AND $ave_sales > 0){
        $mos= $total_projected_inventory / $ave_sales;
      }else{
        $mos='0';
      }
      $data=array(
        'rt_id'=>$rt_id,
        'variant'=>$modelid,
        'color'=>$color,
        'quantity'=>$quantity,
        'approved_intransit' => $approved_intransit,
        'on_hand'=>$on_hand,
        'for_release'=>$forRelease2,
        'total_projected_inventory'=>$total_projected_inventory,
        'ave_sales'=>$ave_sales,
        'mos'=>$mos
      );
      $data2=array(
        'approved' => 1
      );
      if($approved > 0)
      {
        $data3=array(
          'quantity'=>$quantity + $approved,
          'approved_intransit' => $approved_intransit,
          'on_hand'=>$on_hand,
          'for_release'=>$forRelease2,
          'total_projected_inventory'=>$total_projected_inventory,
          'ave_sales'=>$ave_sales,
          'mos'=>$mos
        );
        $update_approved=$this->Dashboard_m->updateAtb($data3,$modelid,$color);
      }else{
        $insert_approved=$this->Dashboard_m->approvedtb($data);
      }

      $updatert=$this->Dashboard_m->updatert($rt_id,$data2);
      echo json_encode($data);
    }
  }
  public function approvedAll()
  {
    $brand=$_GET['brand'];
    $requestData=$this->Dashboard_m->rdata2($brand);
    // print_r($requestData);
    // die();
    foreach($requestData as $value)
    {
      $modelid=$value->variant;
      $color=$value->color;
      $quantity=$value->quantity;
      $rt_id=$value->rt_id;

      $intransit=$this->Dashboard_m->intransitCount($modelid,$color);
      $app=$this->Dashboard_m->approvedCount($modelid,$color);
      $approved=0;
      foreach($app as $value)
      {
        $approved+=$value->quantity;
      }
      if($approved > 0)
      {
        $approved_intransit= $approved + $intransit + $quantity;
      }else{
        $approved_intransit= $quantity + $intransit;
      }


      $on_hand=$this->Dashboard_m->onHandCount($modelid,$color);

      $fr=$this->Dashboard_m->forReleaseCount($modelid,$color);
      $forRelease2=0;
      // $cs_num='';
      foreach ($fr as $value) {
        $cs_num=$value->cs_num;
        // print_r($value->cs_num);
        $gpdetails=$this->Gp_m->get_details3($cs_num);
        //
        $forRelease=0;
        foreach ($gpdetails as $value) {

          if($value->invoice_date == '0000-00-00' OR $value->invoice_date === null)
          {
          }else{
          $forRelease++;

          }
        }
        // print_r($forRelease);
        $forRelease2=$forRelease2+$forRelease;
      }

      $total_projected_inventory= $quantity + $approved + $on_hand + $intransit - $forRelease2;

      $date=date('Y-m-d');
      $date2 = explode("-", $date);
      $month = $date2[0];
      $year = $date2[1];

      $average='';
      $ave_sales=0;
      if($month == '1' and $year > '2020')
      {
        $lsmonth = array('11','12','01');
        $beginningDate=date($year.'-'.$lsmonth.'-01');
        $average=$this->Dashboard_m->getAve($modelid,$color,$beginningDate,$date);
      }
      else if($month == '2' and $year > '2020')
      {
        $lsmonth = array('12','01','02');
        $beginningDate=date($year.'-'.$lsmonth.'-01');
        $average=$this->Dashboard_m->getAve($modelid,$color,$beginningDate,$date);
      }else{
        $lsmonth = $month - 2;
        $beginningDate=date($year.'-'.$lsmonth.'-01');
        $average=$this->Dashboard_m->getAve($modelid,$color,$beginningDate,$date);
      }

      if($average > 0)
      {
          $ave_sales = $average / 3;
      }else{
          $ave_sales = 0;
      }
      $mos=0;
      if($total_projected_inventory > 0 AND $ave_sales > 0){
        $mos= $total_projected_inventory / $ave_sales;
      }else{
        $mos='0';
      }
      $data=array(
        'rt_id'=>$rt_id,
        'variant'=>$modelid,
        'color'=>$color,
        'quantity'=>$quantity,
        'approved_intransit' => $approved_intransit,
        'on_hand'=>$on_hand,
        'for_release'=>$forRelease2,
        'total_projected_inventory'=>$total_projected_inventory,
        'ave_sales'=>$ave_sales,
        'mos'=>$mos
      );
      $data2=array(
        'approved' => 1
      );
      $updatert=$this->Dashboard_m->updatert($rt_id,$data2);
      echo $rt_id;
      if($approved > 0)
      {
        $data3=array(
          'quantity'=>$quantity + $approved,
          'approved_intransit' => $approved_intransit,
          'on_hand'=>$on_hand,
          'for_release'=>$forRelease2,
          'total_projected_inventory'=>$total_projected_inventory,
          'ave_sales'=>$ave_sales,
          'mos'=>$mos
        );
        $update_approved=$this->Dashboard_m->updateAtb($data3,$modelid,$color);
      }else{
        $insert_approved=$this->Dashboard_m->approvedtb($data);
      }


    }
    echo json_encode($data);
  }
  public function approvedDashboard()
  {

    $session_data = $this->session->userdata('logged_in');
    $this->load->view('v2/partial/header');
    $this->load->view('v2/ADashboard');
    $this->load->view('v2/partial/footer');
  }
  public function AData()
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
            'Variant',
            'Color',
            'Approved For Po',
            'Options'
        );

        if($type == 1){

        }else{
          $this->db->group_start();
          foreach($access as $value) {
            if($value->key == 'MORRIS GARAGES')
            {
              $this->db->or_where('invtry_request_table.brand','MG');
            }else{
              $this->db->or_where('invtry_request_table.brand',$value->key);
            }

          }
          $this->db->group_end();

        }
        if(isset($_GET['brand'])){
          if(strlen($_GET['brand']) > 0)
          {
              $this->db->where('invtry_request_table.brand',$_GET['brand']);
          }
        }
        $this->db->where('invtry_request_table.deleted',0);
        $this->db->where('invtry_request_table.approved',1);
        $this->db->where('invtry_for_approval_table.quantity >',0);
        $sTable = 'invtry_for_approval_table';

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
                  // $this->db->like("invtry_request_table.variant", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("product.Product", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_request_table.color", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_request_table.quantity", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="product.Product as 'Variant',";
        $cSelect .="invtry_for_approval_table.fa_id,";
        $cSelect .="invtry_for_approval_table.color as 'Color',";
        $cSelect .="invtry_request_table.rt_id as 'rt_id',";
        $cSelect .="invtry_for_approval_table.quantity as 'Approved For Po',";

        $this->db->select($cSelect, false);
        $this->db->join('invtry_request_table','invtry_request_table.rt_id = invtry_for_approval_table.rt_id','left');
        $this->db->join('product','product.id = invtry_request_table.variant','left');
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
              if($col == 'Options'){
                  $aRow[$col]= '<button class="btn btn-sm btn-success cretepo" type="button" value="'.$aRow['fa_id'].'">Create PO</button>';
                  $aRow[$col].= ' <button class="btn btn-sm btn-primary viewRemarks" type="button" value="'.$aRow['rt_id'].'">View Remarks</button>';
                }
                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
  }
  public function poform()
  {
    $fa_id=$_GET['fa_id'];
    $data['getInfo']=$this->Dashboard_m->getFAInfo($fa_id);

    $this->load->view('v2/Forms/poform',$data);
  }
  public function addpo()
  {
    $session_data = $this->session->userdata('logged_in');
    $datas=$session_data[0];
    $oldpo=$this->input->post('po_num');
    $rt_id=$this->input->post('rt_id');
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
    $this->Dashboard_m->updateQuantity($rt_id);
    $this->Dashboard_m->updateQuantity2($rt_id);
  }
  public function vehicleForm()
  {
    $po_num=$_GET['po_num'];
    $data['podata']=$this->Main_m->podatan($po_num);
    $this->load->view('v2/Forms/vehicle_form',$data);
  }
  public function addNewVehicle()
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
              // echo $po_num.'<br>';
              // echo $veh_received.'<br>';
              // print_r($invtry_status);
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
          echo $po_num.'<br>';
          echo $veh_received.'<br>';
          print_r($invtry_acc_status);
              $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
        }
        echo json_encode($countcheck);
    }
  }
  public function inventory_d()
  {
    $this->load->view('v2/partial/header');
    $this->load->view('v2/Status_F/inventory_D');
    $this->load->view('v2/partial/footer');
  }
  public function inventory_data()
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

    // if($type == 1){
    // }else{
    // $getdealerid=$this->Dsar_m->newid($dealer);
    // print_r($getdealerid);
    // die();
    // }

      $aColumns = array(
              'Variant',
              'Color',
              'Quantity',
              'Approved/Intransit',
              'OnHand',
              'For Release',
              'Total Projected Inventory',
              'Ave. Sales',
              'MOS',
              'Justification',
              'Options'
          );

        // if(isset($_GET['brand'])){
        //   if(strlen($_GET['brand']) > 0)
        //   {
              $this->db->where('invtry_request_table.brand',$_GET['brand']);
          // }
        // }
        $this->db->where('deleted',0);
        $this->db->where('approved',0);
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

                $this->db->group_start();
                $this->db->or_like("product.Product", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_request_table.color", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_request_table.justification", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_request_table.quantity", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";

        $this->db->select($cSelect, false);
        $this->db->join('invtry_purchase_order','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
        $this->db->join('invtry_status','invtry_purchase_order.po_num = invtry_status.po_number','left');
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

                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
  }
  public function viewRemarksForm()
  {
    $rt_id=$_GET['rt_id'];
    $data['getRemarks']=$this->Dashboard_m->getRemarks($rt_id);

    $this->load->view('v2/Forms/viewRemarks',$data);
  }
  public function remarksUpdate()
  {
    $rt_id=$_POST['rt_id'];
    $data=array(
      'justification' => $_POST['justification']
    );
    $updateRemarks=$this->Dashboard_m->updateRemarks($rt_id,$data);
  }
}
?>
