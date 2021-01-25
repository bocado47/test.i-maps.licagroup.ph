<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

  public function __construct()
  {
      date_default_timezone_set('Asia/Manila');

      parent::__construct();

      $this->load->database();
      $this->load->library('session');
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
        // INVENTORY STATUS
        // $invtry_status=array();
        $checkInvStatus=$this->Dashboard_m->checkInvStatus($po_num);
          if(count($checkInvStatus) > 0)
          {
            if($veh_received != NULL)
            {
              if($nardI != NULL)
              {
                $invtry_status=array('status' => 'Released' );
                $updateStatus1=$this->Main_m->updateIS($po_num,$invtry_status);
              }else{
                $invtry_status=array('status' => 'Received' );
                $updateStatus1=$this->Main_m->updateIS($po_num,$invtry_status);
              }
            }else{
              $invtry_status=array('status' => 'For Pull Out' );
                $updateStatus1=$this->Main_m->updateIS($po_num,$invtry_status);
            }


          }else{
            if($veh_received != NULL)
            {
              if($nardI != NULL)
              {
                $status_data=array(
                  'po_number'=>$po_num,
                  'status'=>'Released'
                );
                  $insertStatus1=$this->Dashboard_m->insertStatus($status_data);
              }else{
                $status_data=array(
                  'po_number'=>$po_num,
                  'status'=>'Received'
                );
                  $insertStatus1=$this->Dashboard_m->insertStatus($status_data);
              }
            }else{
              $status_data=array(
                'po_number'=>$po_num,
                'status'=>'For Pull Out'
              );
                $insertStatus1=$this->Dashboard_m->insertStatus($status_data);
            }


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
        $checkAccStatus=$this->Dashboard_m->checkAccStatus($po_num);
        if(count($checkAccStatus) > 0)
        {
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
                       $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
                   }else{
                     $invtry_acc_status=array('status' => 'Invoiced');
                       $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
                   }
                 }else{
                 $invtry_acc_status=array('status' => 'Allocated' );
                   $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
                }
               }else{
               $invtry_acc_status=array('status' => 'Allocated' );
                 $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
              }

            }else{
                $invtry_acc_status=array('status' => 'Allocated' );
                $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
            }

          }else{
              $invtry_acc_status=array('status' => 'Available' );
                $updateStatus2=$this->Main_m->updateIAS($po_num,$invtry_acc_status);
          }
        }
        }else{
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
                     $status_data=array(
                       'po_number'=>$po_num,
                       'status'=>'Reported'
                     );
                     $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
                   }else{
                     $status_data=array(
                       'po_number'=>$po_num,
                       'status'=>'Invoiced'
                     );
                     $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
                   }
                 }else{
                   $status_data=array(
                     'po_number'=>$po_num,
                     'status'=>'Allocated'
                   );
                   $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
                }
               }else{
                 $status_data=array(
                   'po_number'=>$po_num,
                   'status'=>'Allocated'
                 );
                 $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
              }

            }else{
              $status_data=array(
                'po_number'=>$po_num,
                'status'=>'Allocated'
              );
              $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
            }

          }else{
              $status_data=array(
                'po_number'=>$po_num,
                'status'=>'Available'
              );
              $insertStatus2=$this->Dashboard_m->insertStatusAC($status_data);
          }
        }

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
        $cs_num=$vl2->cs_number;
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
        $cs_num=$vl2->cs_number;
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
        $cs_num=$vl2->cs_number;
        $updateVinNum=$this->Dashboard_m->updateEng($data3,$cs_num);
      }
    }
  }
}
?>
