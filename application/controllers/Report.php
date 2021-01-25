<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function __construct()
    {
        date_default_timezone_set('Asia/Manila');

        parent::__construct();
				if(!$this->session->userdata('logged_in'))
        {
          die("You don't have access here: <a href='".base_url()."Login'>Login Here! </a>");
        }
    }
    public function Dashboard()
    {
				$this->load->view('v2/partial/header');
        $this->load->view('user/Reports/dashboard');
        $this->load->view('v2/partial/footer');
    }
    public function VDIR()
    {
    	$dealer=$_GET['dealer'];
			$status=$_GET['status'];
    	$model=$this->Report_m->models($dealer);
    	$array=array();
    	foreach($model as $val)
    	{
    		$model=$val->id;
    		$model_name=$val->Product;
    		$info=$this->Report_m->ADIR_m($model,$status);

    		$vehicle_array=array();
				// echo'<pre>';
				// print_r($dealer);
				// die();
    		foreach($info as $value)
    		{
					$plant=$value->grp_plant;

					$fgrplant=$this->Report_m->fgrp($plant);
					$grp_plant='';
					foreach($fgrplant as $new)
					{
						$grp_plant=$new->plant;
					}

    			$vehicle_array[]=array(
    				'cs_num'=>$value->cs_num,
    				'color'=>$value->color,
    				'dlr' =>$value->year,
    				'mth_d_f_o'=>$value->date,
    				'received'=>$value->received_date,
    				'po_num'=>$value->po_num,
    				'vin'=>$value->vin_num,
    				'loc'=>$value->location,
    				'vrr_no'=>$value->vrr_num,
    				'psr'=>$grp_plant,
    				'psd'=>$psd,
    				'aging'=>$aging,
    				'Remarks'=>$value->remarks,
    			);

    		}
    		if(count($vehicle_array) > 0)
    		{
    			$model2=str_replace($dealer, '',$model_name);
    			$array[]=array(
	    			'Model'=>$model2,
	    			'Info' =>$vehicle_array
    			);
    		}
    	}
    	$data['report']=$array;
    	$data['dealer']=$dealer;
			$data['status']=$status;
			// print_r($data);
    	// $this->load->view('partial/header');
    	$this->load->view('user/Reports/form/vdir',$data);
    	// $this->load->view('partial/footer');
    }
		public function download2()
		{

			$dealer=$_GET['dealer'];
			$inv_status=$_GET['inv_status'];
			$acc_status=$_GET['acc_status'];
    	$model=$this->Report_m->models($dealer);
    	$array=array();
			$countss=0;
			foreach($model as $val)
    	{
    		$model=$val->id;
    		$model_name=$val->Product;
				// $info=$this->Report_m->ADIR_m5($model);
					$vehicle_array=array();
				if($acc_status == 'All' AND $inv_status == 'All')
				{

						$info=$this->Report_m->ADIR_m5($model);

						foreach($info as $value)
		    		{
							$countss++;
							$psd='';
							if($value->plant_sales_month == NULL OR $value->plant_sales_month == '0000-00-00' OR $value->plant_sales_month =='')
							{

							}else{
								$psdorig=strtotime($value->plant_sales_month);
								$psd=date('Y-m', $psdorig);
							}


							$iard=$value->iard;
							$podate=$value->po_date;
							$aging=0;
							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}
							$vehicle_array[]=array(
		    				'cs_num'=>$value->cs_num,
		    				'color'=>$value->color,
		    				'dlr' =>$value->year,
		    				'mth_d_f_o'=>$value->date,
		    				'received'=>$value->received_date,
		    				'po_num'=>$value->po_num,
		    				'vin'=>$value->vin_num,
		    				'loc'=>$value->location,
		    				'psr'=>$value->grp_plant,
		    				'psd'=>$psd,
		    				'aging'=>$aging,
		    				'Remarks'=>$value->remarks,
		    			);

		    		}
				}else if($acc_status == 'All')
				{
						$info=$this->Report_m->ADIR_m4($model,$inv_status);
						foreach($info as $value)
		    		{
							$countss++;
							$psd='';
							if($value->plant_sales_month == NULL OR $value->plant_sales_month == '0000-00-00' OR $value->plant_sales_month =='')
							{

							}else{
								$psdorig=strtotime($value->plant_sales_month);
								$psd=date('Y-m', $psdorig);
							}


							$iard=$value->iard;
							$podate=$value->po_date;
							$aging=0;
							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}
							$vehicle_array[]=array(
		    				'cs_num'=>$value->cs_num,
		    				'color'=>$value->color,
		    				'dlr' =>$value->year,
		    				'mth_d_f_o'=>$value->date,
		    				'received'=>$value->received_date,
		    				'po_num'=>$value->po_num,
		    				'vin'=>$value->vin_num,
		    				'loc'=>$value->location,
		    				'psr'=>$value->grp_plant,
		    				'psd'=>$psd,
		    				'aging'=>$aging,
		    				'Remarks'=>$value->remarks,
		    			);

		    		}

				}else if($inv_status == 'All'){
					$info=$this->Report_m->ADIR_m3($model,$acc_status);
					foreach($info as $value)
					{
						$countss++;
						$psd='';
						if($value->plant_sales_month == NULL OR $value->plant_sales_month == '0000-00-00' OR $value->plant_sales_month =='')
						{

						}else{
							$psdorig=strtotime($value->plant_sales_month);
							$psd=date('Y-m', $psdorig);
						}


						$iard=$value->iard;
						$podate=$value->po_date;
						$alloc_date=$value->alloc_date;
						$aging=0;
						$allocatedAge=0;
						$invoicedAge=0;

						$csnum=$value->cs_num;
						$gpdata=$this->Gp_m->SearchData($csnum);
						$invNumber='';
						$accName='';
						$agent='';
						$manager='';
						$group='';
						$invDate='';
						$paymentMode='';

						foreach($gpdata as $value0)
						{
							$invNumber=$value0->invoice_number;
							$invDate=$value0->invoice_date;
							$paymentMode=$value0->payment_mode;
							$accName=strtoupper($value0->first_name).' '.strtoupper($value0->middle_name).' '.strtoupper($value0->last_name);
							if(strlen(str_replace(' ', '', $accName)) < 1 OR $accName == '')
							{
								$accName=$value0->company_name;
							}
							$scid=$value0->sc;
							$grmid=$value0->grm;
							$gsmid=$value0->gsm;
							$searchsc=$this->Dsar_m->scSearch($scid);
							if(count($searchsc) > 0)
							{
								$agent=strtoupper($searchsc[0]->Fname).' '.strtoupper($searchsc[0]->Mname).' '.strtoupper($searchsc[0]->Lname);
							}


							$searchgrm=$this->Dsar_m->scSearch2($grmid);
							if(count($searchgrm) > 0)
							{
								$manager=strtoupper($searchgrm[0]->Fname).' '.strtoupper($searchgrm[0]->Mname).' '.strtoupper($searchgrm[0]->Lname);
							}

							$searchgsm=$this->Gp_m->getGsm($gsmid);
							if(count($searchgsm) > 0)
							{
								$group=strtoupper($searchgsm[0]->first_name).' '.strtoupper($searchgsm[0]->last_name);
							}
						}

						if($acc_status == 'Available')
						{
							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}
						}else if($acc_status == 'Allocated'){

							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}

							if($alloc_date == '1970-01-01' OR $alloc_date == '0000-00-00')
							{
								$allocatedAge=0;
							}else{
								$now = time();
								$your_date = strtotime($alloc_date);
								$datediff2 = $now - $your_date;

								$allocatedAge=round($datediff2 / (60 * 60 * 24));
							}
						}else if($acc_status == 'Invoiced' || $acc_status == 'Reported'){
							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}
							if($alloc_date == '1970-01-01' OR $alloc_date == '0000-00-00')
							{
								$allocatedAge=0;
							}else{
								$now = time();
								$your_date = strtotime($alloc_date);
								$datediff2 = $now - $your_date;

								$allocatedAge=round($datediff2 / (60 * 60 * 24));
							}

							if($invDate == '1970-01-01' OR $invDate == '0000-00-00')
							{
								$invoicedAge=0;
							}else{
								$now = time();
								$your_date = strtotime($invDate);
								$datediff3 = $now - $your_date;

								$invoicedAge=round($datediff3 / (60 * 60 * 24));
							}
						}

						$vehicle_array[]=array(
							'cs_num'=>$value->cs_num,
							'color'=>$value->color,
							'dlr' =>$value->year,
							'mth_d_f_o'=>$value->date,
							'received'=>$value->received_date,
							'po_num'=>$value->po_num,
							'vin'=>$value->vin_num,
							'loc'=>$value->location,
							'psr'=>$value->grp_plant,
							'psd'=>$psd,
							'aging'=>$aging,
							'Remarks'=>$value->remarks,
							'alloc_dealer'=>$value->alloc_dealer,
							'alloc_date'=>$value->alloc_date,
							'invNumber'=>$invNumber,
							'accName'=>$accName,
							'agent'=>$agent,
							'manager'=>$manager,
							'group'=>$group,
							'invDate'=>$invDate,
							'paymentMode'=>$paymentMode,
							'invoicedAge'=>$invoicedAge,
							'allocatedAge'=>$allocatedAge

						);

					}
				}else{
					$info=$this->Report_m->ADIR_m2($model,$inv_status,$acc_status);
					foreach($info as $value)
					{
						$psd='';
						$countss++;
						if($value->plant_sales_month == NULL OR $value->plant_sales_month == '0000-00-00' OR $value->plant_sales_month =='')
						{

						}else{
							$psdorig=strtotime($value->plant_sales_month);
							$psd=date('Y-m', $psdorig);
						}


						$iard=$value->iard;
						$podate=$value->po_date;
						$alloc_date=$value->alloc_date;
						$aging=0;
						$allocatedAge=0;
						$invoicedAge=0;

						$csnum=$value->cs_num;
						$gpdata=$this->Gp_m->SearchData($csnum);
						$invNumber='';
						$accName='';
						$agent='';
						$manager='';
						$group='';
						$invDate='';
						$paymentMode='';

						foreach($gpdata as $value0)
						{
							$invNumber=$value0->invoice_number;
							$invDate=$value0->invoice_date;
							$paymentMode=$value0->payment_mode;
							$accName=strtoupper($value0->first_name).' '.strtoupper($value0->middle_name).' '.strtoupper($value0->last_name);
							if(strlen(str_replace(' ', '', $accName)) < 1 OR $accName == '')
							{
								$accName=$value0->company_name;
							}
							$scid=$value0->sc;
							$grmid=$value0->grm;
							$gsmid=$value0->gsm;
							$searchsc=$this->Dsar_m->scSearch($scid);
							if(count($searchsc) > 0)
							{
								$agent=strtoupper($searchsc[0]->Fname).' '.strtoupper($searchsc[0]->Mname).' '.strtoupper($searchsc[0]->Lname);
							}


							$searchgrm=$this->Dsar_m->scSearch2($grmid);
							if(count($searchgrm) > 0)
							{
								$manager=strtoupper($searchgrm[0]->Fname).' '.strtoupper($searchgrm[0]->Mname).' '.strtoupper($searchgrm[0]->Lname);
							}

							$searchgsm=$this->Gp_m->getGsm($gsmid);
							if(count($searchgsm) > 0)
							{
								$group=strtoupper($searchgsm[0]->first_name).' '.strtoupper($searchgsm[0]->last_name);
							}
						}

						if($acc_status == 'Available')
						{
							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}
						}else if($acc_status == 'Allocated'){

							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}

							if($alloc_date == '1970-01-01' OR $alloc_date == '0000-00-00')
							{
								$allocatedAge=0;
							}else{
								$now = time();
								$your_date = strtotime($alloc_date);
								$datediff2 = $now - $your_date;

								$allocatedAge=round($datediff2 / (60 * 60 * 24));
							}
						}else if($acc_status == 'Invoiced' || $acc_status == 'Reported'){
							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}
							if($alloc_date == '1970-01-01' OR $alloc_date == '0000-00-00')
							{
								$allocatedAge=0;
							}else{
								$now = time();
								$your_date = strtotime($alloc_date);
								$datediff2 = $now - $your_date;

								$allocatedAge=round($datediff2 / (60 * 60 * 24));
							}

							if($invDate == '1970-01-01' OR $invDate == '0000-00-00')
							{
								$invoicedAge=0;
							}else{
								$now = time();
								$your_date = strtotime($invDate);
								$datediff3 = $now - $your_date;

								$invoicedAge=round($datediff3 / (60 * 60 * 24));
							}
						}

						$vehicle_array[]=array(
							'cs_num'=>$value->cs_num,
							'color'=>$value->color,
							'dlr' =>$value->year,
							'mth_d_f_o'=>$value->date,
							'received'=>$value->received_date,
							'po_num'=>$value->po_num,
							'vin'=>$value->vin_num,
							'loc'=>$value->location,
							'psr'=>$value->grp_plant,
							'psd'=>$psd,
							'aging'=>$aging,
							'Remarks'=>$value->remarks,
							'alloc_dealer'=>$value->alloc_dealer,
							'alloc_date'=>$value->alloc_date,
							'invNumber'=>$invNumber,
							'accName'=>$accName,
							'agent'=>$agent,
							'manager'=>$manager,
							'group'=>$group,
							'invDate'=>$invDate,
							'paymentMode'=>$paymentMode,
							'invoicedAge'=>$invoicedAge,
							'allocatedAge'=>$allocatedAge

						);

					}
				}



				// echo'<pre>';
				// print_r($info);
				// die();

    		if(count($vehicle_array) > 0)
    		{
    			$model2=str_replace($dealer,' ',$model_name);
    			$array[]=array(
	    			'Model'=>$model2,
	    			'Info' =>$vehicle_array,
						'Inv_stats'=>$inv_status,
						'Acc_stats'=>$acc_status
    			);
    		}
			}

			$report=$array;
			if($acc_status == 'Available' OR $acc_status == 'All'){
				$thead=array(
					'CS NUM',
					'COLOR',
					'YEAR',
					'PO DATE',
					'RECEIVED DATE',
					'PO NUM',
					'VIN NUM',
					'LOCATION',
					'PLANT SALE REPORTED',
					'PLANT SALE MONTH',
					'AGING',
					'REMARKS',
				);
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Daily Inventory Report');

				$row = 1;
				$col = 0;
				$j = 'F';
				$new=ucfirst(strtolower('Total Units:')).' '.$countss;
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$new);
				$this->excel->getActiveSheet()->mergeCells('A'.$row.':L'.$row);
				$row++;
				foreach($report as $value) {
					$count=0;
					$mod=ucfirst(strtolower($dealer)).' '.$value['Model'];
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$mod);
					$this->excel->getActiveSheet()->mergeCells('A'.$row.':L'.$row);
					$styleArray2 = array(
						'font'  => array(
								'bold'  => true,
								'size'  => 15,
								'color' => array('rgb' => 'ffffff'),
						),
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '0,0,0')
						),
						// 'startcolor' => array('rgb' => '255,255,255'),
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					)
					);
					$this->excel->getActiveSheet()->getStyle('A'.$row.':L'.$row)->applyFromArray($styleArray2);
					$row++;
					// $col++;
					foreach($thead as $vl)
					{
						// $ncol=0;
						$styleArray3 = array(
							'font'  => array(
									'bold'  => true,
									'size'  => 12,
							),
							'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						)
						);
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$vl);
						$this->excel->getActiveSheet()->getStyle('A'.$row.':L'.$row)->applyFromArray($styleArray3);
						$col++;
					}
					$col=0;
					// $this->excel->getActiveSheet()->mergeCells('A'.$row.':F'.$row);
					$row++;
					foreach($value['Info'] as $val)
					{
							$count++;
							if($val['mth_d_f_o'] == '0000-00-00' OR $val['mth_d_f_o'] == '1970-01-01')
							{
								$podate=0;
							}else{
								$podate=$val['mth_d_f_o'];
							}
							if($val['received'] == '0000-00-00' OR $val['received'] == '1970-01-01')
							{
								$receivedDate=0;
							}else{
								$receivedDate=$val['received'];
							}
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$row,$val['cs_num']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$row,$val['color']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$row,$val['dlr']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3,$row,$podate);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4,$row,$receivedDate);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5,$row,$val['po_num']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6,$row,$val['vin']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(7,$row,$val['loc']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(8,$row,$val['psr']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(9,$row,$val['psd']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(10,$row,$val['aging']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(11,$row,$val['Remarks']);
							$row++;
					}
					$col=0;
					$mod2=ucfirst(strtolower($dealer)).' '.$value['Model'];
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$mod2);
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(11,$row,$count);
					$this->excel->getActiveSheet()->mergeCells('A'.$row.':K'.$row);
					$style = array(
					'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
							)
					);
					$styleArray = array(
						'font'  => array(
								'bold'  => true,
								'size'  => 12,
						),
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					)
					);
					$this->excel->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray($styleArray);
					$row++;
					//
					//
					// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					// print("\n");
					// foreach($thead as $vl)
					// {
					// 	echo $vl."\t";
					// }
					// print("\n");
				}
				$filename='daily_inventory_report.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache

				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
				// echo '<pre>';
				// print_r($data);
			}else if($acc_status == 'Allocated') {
				$thead=array(
					'ALLOCATION DATE',
					'ALLOCATION DEALER',
					'CS NUM',
					'COLOR',
					'YEAR',
					'AGING',
					'ALLOCATED AGE',
					'PLANT SALE REPORTED',
					'PLANT SALE MONTH',
					'REMARKS',
				);
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Daily Inventory Report');

				$row = 1;
				$col = 0;
				$j = 'F';
				$new=ucfirst(strtolower('Total Units:')).' '.$countss;
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$new);
				$this->excel->getActiveSheet()->mergeCells('A'.$row.':J'.$row);
				$row++;
				foreach($report as $value) {
					$count=0;
					$mod=ucfirst(strtolower($dealer)).' '.$value['Model'];
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$mod);
					$this->excel->getActiveSheet()->mergeCells('A'.$row.':J'.$row);
					$styleArray2 = array(
						'font'  => array(
								'bold'  => true,
								'size'  => 15,
								'color' => array('rgb' => 'ffffff'),
						),
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '0,0,0')
						),
						// 'startcolor' => array('rgb' => '255,255,255'),
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					)
					);
					$this->excel->getActiveSheet()->getStyle('A'.$row.':J'.$row)->applyFromArray($styleArray2);
					$row++;
					// $col++;
					foreach($thead as $vl)
					{
						// $ncol=0;
						$styleArray3 = array(
							'font'  => array(
									'bold'  => true,
									'size'  => 12,
							),
							'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						)
						);
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$vl);
						$this->excel->getActiveSheet()->getStyle('A'.$row.':I'.$row)->applyFromArray($styleArray3);
						$col++;
					}
					$col=0;
					// $this->excel->getActiveSheet()->mergeCells('A'.$row.':F'.$row);
					$row++;
					foreach($value['Info'] as $val)
					{
							$count++;
							if($val['mth_d_f_o'] == '0000-00-00' OR $val['mth_d_f_o'] == '1970-01-01')
							{
								$podate=0;
							}else{
								$podate=$val['mth_d_f_o'];
							}
							if($val['received'] == '0000-00-00' OR $val['received'] == '1970-01-01')
							{
								$receivedDate=0;
							}else{
								$receivedDate=$val['received'];
							}
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$row,$val['alloc_date']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$row,$val['alloc_dealer']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$row,$val['cs_num']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3,$row,$val['color']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4,$row,$val['dlr']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5,$row,$val['aging']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6,$row,$val['allocatedAge']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(7,$row,$val['psr']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(8,$row,$val['psd']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(9,$row,$val['Remarks']);
							$row++;
					}
					$col=0;
					$mod2=ucfirst(strtolower($dealer)).' '.$value['Model'];
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$mod2);
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(9,$row,$count);
					$this->excel->getActiveSheet()->mergeCells('A'.$row.':J'.$row);
					$style = array(
					'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
							)
					);
					$styleArray = array(
						'font'  => array(
								'bold'  => true,
								'size'  => 12,
						),
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					)
					);
					$this->excel->getActiveSheet()->getStyle('A'.$row.':J'.$row)->applyFromArray($styleArray);
					$row++;
					//
					//
					// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					// print("\n");
					// foreach($thead as $vl)
					// {
					// 	echo $vl."\t";
					// }
					// print("\n");
				}
				$filename='daily_inventory_report.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache

				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');

			}else if($acc_status == 'Invoiced' || $acc_status == 'Reported') {
				$thead=array(
					'ALLOCATION DATE',
					'ALLOCATION DEALER',
					'ACCOUNT NAME',
					'CS NUM',
					'COLOR',
					'YEAR',
					'AGING',
					'ALLOCATED AGE',
					'INVOICED AGE',
					'INVOICE NUMBER',
					'INVOICE DATE',
					'PAYMENT MODE',
					'AGENT',
					'MANAGER',
					'GROUP',
					'PLANT SALE REPORTED',
					'PLANT SALE MONTH',
					'REMARKS',
				);
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Daily Inventory Report');

				$row = 1;
				$col = 0;
				$j = 'F';
				$new=ucfirst(strtolower('Total Units:')).' '.$countss;
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$new);
				$this->excel->getActiveSheet()->mergeCells('A'.$row.':R'.$row);
				$row++;
				foreach($report as $value) {
					$count=0;
					$mod=ucfirst(strtolower($dealer)).' '.$value['Model'];
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$mod);
					$this->excel->getActiveSheet()->mergeCells('A'.$row.':R'.$row);
					$styleArray2 = array(
						'font'  => array(
								'bold'  => true,
								'size'  => 15,
								'color' => array('rgb' => 'ffffff'),
						),
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => '0,0,0')
						),
						// 'startcolor' => array('rgb' => '255,255,255'),
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					)
					);
					$this->excel->getActiveSheet()->getStyle('A'.$row.':R'.$row)->applyFromArray($styleArray2);
					$row++;
					// $col++;
					foreach($thead as $vl)
					{
						// $ncol=0;
						$styleArray3 = array(
							'font'  => array(
									'bold'  => true,
									'size'  => 12,
							),
							'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						)
						);
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$vl);
						$this->excel->getActiveSheet()->getStyle('A'.$row.':R'.$row)->applyFromArray($styleArray3);
						$col++;
					}
					$col=0;
					// $this->excel->getActiveSheet()->mergeCells('A'.$row.':F'.$row);
					$row++;
					foreach($value['Info'] as $val)
					{
							$count++;
							if($val['mth_d_f_o'] == '0000-00-00' OR $val['mth_d_f_o'] == '1970-01-01')
							{
								$podate=0;
							}else{
								$podate=$val['mth_d_f_o'];
							}
							if($val['received'] == '0000-00-00' OR $val['received'] == '1970-01-01')
							{
								$receivedDate=0;
							}else{
								$receivedDate=$val['received'];
							}
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$row,$val['alloc_date']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$row,$val['alloc_dealer']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$row,$val['accName']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3,$row,$val['cs_num']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4,$row,$val['color']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5,$row,$val['dlr']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6,$row,$val['aging']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(7,$row,$val['allocatedAge']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(8,$row,$val['invoicedAge']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(9,$row,$val['invNumber']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(10,$row,$val['invDate']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(11,$row,strtoupper(str_replace('_',' ',$val['paymentMode'])));
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(12,$row,$val['agent']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(13,$row,$val['manager']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(14,$row,$val['group']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(15,$row,$val['psr']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(16,$row,$val['psd']);
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow(17,$row,$val['Remarks']);
							$row++;
					}
					$col=0;
					$mod2=ucfirst(strtolower($dealer)).' '.$value['Model'];
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$mod2);
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow(18,$row,$count);
					$this->excel->getActiveSheet()->mergeCells('A'.$row.':R'.$row);
					$style = array(
					'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
							)
					);
					$styleArray = array(
						'font'  => array(
								'bold'  => true,
								'size'  => 12,
						),
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					)
					);
					$this->excel->getActiveSheet()->getStyle('A'.$row.':R'.$row)->applyFromArray($styleArray);
					$row++;
					//
					//
					// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					// print("\n");
					// foreach($thead as $vl)
					// {
					// 	echo $vl."\t";
					// }
					// print("\n");
				}
				$filename='daily_inventory_report.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache

				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
				// echo '<pre>';
				// print_r($data);
			}




		}

		public function reportIS()
		{
			$dealer=$_GET['dealer'];
			$status=$_GET['status'];
			$model=$this->Report_m->models($dealer);
			$array=array();
			foreach($model as $val)
			{
				$model=$val->id;
    		$model_name=$val->Product;
    		$info=$this->Report_m->ADIR_m($model,$status);
			}
		}
		public function VDIR2()
		{
			$dealer=$_GET['dealer'];
			$inv_status=$_GET['inv_status'];
			$acc_status=$_GET['acc_status'];
			$model=$this->Report_m->models($dealer);
			$array=array();
			$counts=0;
			foreach($model as $val)
    	{
    		$model=$val->id;
    		$model_name=$val->Product;
				$vehicle_array=array();
				if($acc_status == 'All' AND $inv_status == 'All')
				{

						$info=$this->Report_m->ADIR_m5($model,$dealer);
						foreach($info as $value)
		    		{
							$counts++;
							$psd='';
							if($value->plant_sales_month == NULL OR $value->plant_sales_month == '0000-00-00' OR $value->plant_sales_month =='')
							{

							}else{
								$psdorig=strtotime($value->plant_sales_month);
								$psd=date('Y-m', $psdorig);
							}


							$iard=$value->iard;
							$podate=$value->po_date;
							$aging=0;
							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}

							$wsp_date=$value->date;
			        if($wsp_date == '0000-00-00' OR $wsp_date == '1970-01-01')
			        {
			          $wsp_date='';
			        }else{
			          $wsp_date=$value->date;
			        }

							$receivedDate=$value->received_date;
							if($receivedDate == '0000-00-00' OR $receivedDate == '1970-01-01')
							{
								$receivedDate='';
							}else{
								$receivedDate=$value->received_date;
							}
		    			$vehicle_array[]=array(
		    				'cs_num'=>$value->cs_num,
		    				'color'=>$value->color,
		    				'dlr' =>$value->year,
		    				'mth_d_f_o'=>$wsp_date,
		    				'received'=>$receivedDate,
		    				'po_num'=>$value->po_num,
		    				'vin'=>$value->vin_num,
		    				'loc'=>$value->location,
		    				'psr'=>$value->grp_plant,
								'psd'=>$psd,
		    				'aging'=>$aging,
		    				'Remarks'=>$value->remarks,
		    			);
		    		}
				}else if($acc_status == 'All')
				{
						$info=$this->Report_m->ADIR_m4($model,$inv_status);
						foreach($info as $value)
		    		{
							$counts++;
							$psd='';
							if($value->plant_sales_month == NULL OR $value->plant_sales_month == '0000-00-00' OR $value->plant_sales_month =='')
							{

							}else{
								$psdorig=strtotime($value->plant_sales_month);
								$psd=date('Y-m', $psdorig);
							}


							$iard=$value->iard;
							$podate=$value->po_date;
							$aging=0;
							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}
							$wsp_date=$value->date;
							if($wsp_date == '0000-00-00' OR $wsp_date == '1970-01-01')
							{
								$wsp_date='';
							}else{
								$wsp_date=$value->date;
							}

							$receivedDate=$value->received_date;
							if($receivedDate == '0000-00-00' OR $receivedDate == '1970-01-01')
							{
								$receivedDate='';
							}else{
								$receivedDate=$value->received_date;
							}
							$vehicle_array[]=array(
								'cs_num'=>$value->cs_num,
								'color'=>$value->color,
								'dlr' =>$value->year,
								'mth_d_f_o'=>$wsp_date,
								'received'=>$receivedDate,
								'po_num'=>$value->po_num,
								'vin'=>$value->vin_num,
								'loc'=>$value->location,
								'psr'=>$value->grp_plant,
								'psd'=>$psd,
								'aging'=>$aging,
								'Remarks'=>$value->remarks,
							);

		    		}
						// print_r($inv_status);
				}else if($inv_status == 'All'){
					$info=$this->Report_m->ADIR_m3($model,$acc_status);
					foreach($info as $value)
					{
						$counts++;
						$psd='';
						if($value->plant_sales_month == NULL OR $value->plant_sales_month == '0000-00-00' OR $value->plant_sales_month =='')
						{

						}else{
							$psdorig=strtotime($value->plant_sales_month);
							$psd=date('Y-m', $psdorig);
						}


						$iard=$value->iard;
						$podate=$value->po_date;
						$alloc_date=$value->alloc_date;
						$aging=0;
						$allocatedAge=0;
						$invoicedAge=0;

						$csnum=$value->cs_num;
						$gpdata=$this->Gp_m->SearchData($csnum);
						$invNumber='';
						$accName='';
						$agent='';
						$manager='';
						$group='';
						$invDate='';
						$paymentMode='';

						foreach($gpdata as $value0)
						{
							$invNumber=$value0->invoice_number;
							$invDate=$value0->invoice_date;
							$paymentMode=$value0->payment_mode;
							$accName=strtoupper($value0->first_name).' '.strtoupper($value0->middle_name).' '.strtoupper($value0->last_name);
							if(strlen(str_replace(' ', '', $accName)) < 1 OR $accName == '')
							{
								$accName=$value0->company_name;
							}
							$scid=$value0->sc;
							$grmid=$value0->grm;
							$gsmid=$value0->gsm;
							$searchsc=$this->Dsar_m->scSearch($scid);
							if(count($searchsc) > 0)
							{
								$agent=strtoupper($searchsc[0]->Fname).' '.strtoupper($searchsc[0]->Mname).' '.strtoupper($searchsc[0]->Lname);
							}


							$searchgrm=$this->Dsar_m->scSearch2($grmid);
							if(count($searchgrm) > 0)
							{
								$manager=strtoupper($searchgrm[0]->Fname).' '.strtoupper($searchgrm[0]->Mname).' '.strtoupper($searchgrm[0]->Lname);
							}

							$searchgsm=$this->Gp_m->getGsm($gsmid);
							if(count($searchgsm) > 0)
							{
								$group=strtoupper($searchgsm[0]->first_name).' '.strtoupper($searchgsm[0]->last_name);
							}
						}

						if($acc_status == 'Available')
						{
							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}
						}else if($acc_status == 'Allocated'){

							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}

							if($alloc_date == '1970-01-01' OR $alloc_date == '0000-00-00')
							{
								$allocatedAge=0;
							}else{
								$now = time();
								$your_date = strtotime($alloc_date);
								$datediff2 = $now - $your_date;

								$allocatedAge=round($datediff2 / (60 * 60 * 24));
							}
						}else if($acc_status == 'Invoiced' || $acc_status == 'Reported'){
							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}
							if($alloc_date == '1970-01-01' OR $alloc_date == '0000-00-00')
							{
								$allocatedAge=0;
							}else{
								$now = time();
								$your_date = strtotime($alloc_date);
								$datediff2 = $now - $your_date;

								$allocatedAge=round($datediff2 / (60 * 60 * 24));
							}

							if($invDate == '1970-01-01' OR $invDate == '0000-00-00')
							{
								$invoicedAge=0;
							}else{
								$now = time();
								$your_date = strtotime($invDate);
								$datediff3 = $now - $your_date;

								$invoicedAge=round($datediff3 / (60 * 60 * 24));
							}
						}
						$wsp_date=$value->date;
						if($wsp_date == '0000-00-00' OR $wsp_date == '1970-01-01')
						{
							$wsp_date='';
						}else{
							$wsp_date=$value->date;
						}

						$receivedDate=$value->received_date;
						if($receivedDate == '0000-00-00' OR $receivedDate == '1970-01-01')
						{
							$receivedDate='';
						}else{
							$receivedDate=$value->received_date;
						}

						$vehicle_array[]=array(
							'cs_num'=>$value->cs_num,
							'color'=>$value->color,
							'dlr' =>$value->year,
							'mth_d_f_o'=>$wsp_date,
							'received'=>$receivedDate,
							'po_num'=>$value->po_num,
							'vin'=>$value->vin_num,
							'loc'=>$value->location,
							'psr'=>$value->grp_plant,
							'psd'=>$psd,
							'aging'=>$aging,
							'Remarks'=>$value->remarks,
							'alloc_dealer'=>$value->alloc_dealer,
							'alloc_date'=>$value->alloc_date,
							'invNumber'=>$invNumber,
							'accName'=>$accName,
							'agent'=>$agent,
							'manager'=>$manager,
							'group'=>$group,
							'invDate'=>$invDate,
							'paymentMode'=>$paymentMode,
							'invoicedAge'=>$invoicedAge,
							'allocatedAge'=>$allocatedAge

						);

					}
				}else{
					$info=$this->Report_m->ADIR_m2($model,$inv_status,$acc_status);
					foreach($info as $value)
					{
						$counts++;
						$psd='';
						if($value->plant_sales_month == NULL OR $value->plant_sales_month == '0000-00-00' OR $value->plant_sales_month =='')
						{

						}else{
							$psdorig=strtotime($value->plant_sales_month);
							$psd=date('Y-m', $psdorig);
						}


						$iard=$value->iard;
						$podate=$value->po_date;
						$alloc_date=$value->alloc_date;
						$aging=0;
						$allocatedAge=0;
						$invoicedAge=0;

						$csnum=$value->cs_num;
						$gpdata=$this->Gp_m->SearchData($csnum);
						$invNumber='';
						$accName='';
						$agent='';
						$manager='';
						$group='';
						$invDate='';
						$paymentMode='';

						foreach($gpdata as $value0)
						{
							$invNumber=$value0->invoice_number;
							$invDate=$value0->invoice_date;
							$paymentMode=$value0->payment_mode;
							$accName=strtoupper($value0->first_name).' '.strtoupper($value0->middle_name).' '.strtoupper($value0->last_name);
							if(strlen(str_replace(' ', '', $accName)) < 1 OR $accName == '')
							{
								$accName=$value0->company_name;
							}
							$scid=$value0->sc;
							$grmid=$value0->grm;
							$gsmid=$value0->gsm;
							$searchsc=$this->Dsar_m->scSearch($scid);
							if(count($searchsc) > 0)
							{
								$agent=strtoupper($searchsc[0]->Fname).' '.strtoupper($searchsc[0]->Mname).' '.strtoupper($searchsc[0]->Lname);
							}


							$searchgrm=$this->Dsar_m->scSearch2($grmid);
							if(count($searchgrm) > 0)
							{
								$manager=strtoupper($searchgrm[0]->Fname).' '.strtoupper($searchgrm[0]->Mname).' '.strtoupper($searchgrm[0]->Lname);
							}

							$searchgsm=$this->Gp_m->getGsm($gsmid);
							if(count($searchgsm) > 0)
							{
								$group=strtoupper($searchgsm[0]->first_name).' '.strtoupper($searchgsm[0]->last_name);
							}
						}

						if($acc_status == 'Available')
						{
							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}
						}else if($acc_status == 'Allocated'){

							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}

							if($alloc_date == '1970-01-01' OR $alloc_date == '0000-00-00')
							{
								$allocatedAge=0;
							}else{
								$now = time();
								$your_date = strtotime($alloc_date);
								$datediff2 = $now - $your_date;

								$allocatedAge=round($datediff2 / (60 * 60 * 24));
							}
						}else if($acc_status == 'Invoiced' || $acc_status == 'Reported'){
							if($iard == NULL OR $iard == "")
							{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
									$now = time(); // or your date as well
									$your_date = strtotime($podate);
									$datediff = $now - $your_date;

									$aging=round($datediff / (60 * 60 * 24));
								}
							}else{
								if($podate == '1970-01-01' OR $podate == '0000-00-00')
								{
									$aging=0;
								}else{
								$now = strtotime($iard);
								$your_date = strtotime($podate);
								$datediff = $now - $your_date;

								$aging=round($datediff / (60 * 60 * 24));
								}
							}
							if($alloc_date == '1970-01-01' OR $alloc_date == '0000-00-00')
							{
								$allocatedAge=0;
							}else{
								$now = time();
								$your_date = strtotime($alloc_date);
								$datediff2 = $now - $your_date;

								$allocatedAge=round($datediff2 / (60 * 60 * 24));
							}

							if($invDate == '1970-01-01' OR $invDate == '0000-00-00')
							{
								$invoicedAge=0;
							}else{
								$now = time();
								$your_date = strtotime($invDate);
								$datediff3 = $now - $your_date;

								$invoicedAge=round($datediff3 / (60 * 60 * 24));
							}
						}

						$wsp_date=$value->date;
						if($wsp_date == '0000-00-00' OR $wsp_date == '1970-01-01')
						{
							$wsp_date='';
						}else{
							$wsp_date=$value->date;
						}

						$receivedDate=$value->received_date;
						if($receivedDate == '0000-00-00' OR $receivedDate == '1970-01-01')
						{
							$receivedDate='';
						}else{
							$receivedDate=$value->received_date;
						}

						$vehicle_array[]=array(
							'cs_num'=>$value->cs_num,
							'color'=>$value->color,
							'dlr' =>$value->year,
							'mth_d_f_o'=>$wsp_date,
							'received'=>$receivedDate,
							'po_num'=>$value->po_num,
							'vin'=>$value->vin_num,
							'loc'=>$value->location,
							'psr'=>$value->grp_plant,
							'psd'=>$psd,
							'aging'=>$aging,
							'Remarks'=>$value->remarks,
							'alloc_dealer'=>$value->alloc_dealer,
							'alloc_date'=>$value->alloc_date,
							'invNumber'=>$invNumber,
							'accName'=>$accName,
							'agent'=>$agent,
							'manager'=>$manager,
							'group'=>$group,
							'invDate'=>$invDate,
							'paymentMode'=>$paymentMode,
							'invoicedAge'=>$invoicedAge,
							'allocatedAge'=>$allocatedAge

						);

					}
				}



				// die();

    		if(count($vehicle_array) > 0)
    		{
    			$model2=str_replace($dealer,' ',$model_name);
    			$array[]=array(
	    			'Model'=>$model2,
	    			'Info' =>$vehicle_array,
						'Inv_stats'=>$inv_status,
						'Acc_stats'=>$acc_status,
    			);
    		}
			}
			$data['report']=$array;
			$data['dealer']=$dealer;
			$data['inv_status']=$inv_status;
			$data['acc_status']=$acc_status;
			$data['counts']=$counts;

			$this->load->view('user/Reports/form/vdir',$data);

		}

		public function PRCR(){
			$dealer=$_GET['dealer'];
			$date=$_GET['startDate'];
			$series=$this->Report_m->series($dealer);
			$newreport=array();
			foreach($series as $vl)
			{
				$report=array();
				$date2 = explode("-", $date);
				$month = $date2[0];
				$year = $date2[1];
				$totalBC=0;

				$nseries=$vl->model_series;
				$countDate=date('2020-06-30');

				$beginningCount=$this->Report_m->getV($nseries,$countDate);

				$model=$this->Report_m->models2($nseries);
				foreach($model as $val)
				{

					$vid=$val->id;
					$countDate=date('2020-06-30');
					$beginningCount=$this->Report_m->getV($vid,$countDate);
					// print_r($beginningCount):
					$releasedJuly=$this->Report_m->getV3($vid);

					$lsmonth = $month - 2;
					$beginningDate=date('2020-07-01');
					$totalDate=date($year.'-'.$lsmonth.'-01');

					if($month == '7' AND $year =='2020')
					{

						$lsmonth = $month;
						$beginningDate=date('2020-07-01');
						$totalDate=date('2020-'.$lsmonth.'-01');

						$getBPM=$this->Report_m->getBPM($vid,$beginningDate,$totalDate);
						$getBRM=$this->Report_m->getBRM($vid,$beginningDate,$totalDate);

						$totalCurrent= $beginningCount + $getBPM - $getBRM;
						$total=abs($totalCurrent);
						$array=array();
						for( $i= $month ; $i >= $lsmonth ; $lsmonth++ )
						{
								$firstDate=date('y-'.$lsmonth.'-01');
								$lastDate=date('y-'.$lsmonth.'-t');

								$getPM=$this->Report_m->getPM($vid,$firstDate,$lastDate);
								$getRM=$this->Report_m->getRM($vid,$firstDate,$lastDate);

								$total=$total + $getPM - $getRM;
								$array[]=array(
									'Month' => date($lsmonth.'-y'),
									'Purchase'=>$getPM,
									'Release'=>$getRM,
									'Total'=> $total
								);
						}
					}else if($month == '8' AND $year =='2020'){
						$lsmonth = $month - 1;
						$beginningDate=date('2020-07-01');
						$totalDate=date('2020-'.$lsmonth.'-01');

						$getBPM=$this->Report_m->getBPM($vid,$beginningDate,$totalDate);
						$getBRM=$this->Report_m->getBRM($vid,$beginningDate,$totalDate);

						$totalCurrent= $beginningCount + $getBPM - $getBRM;
						$total=abs($totalCurrent);
						$array=array();
						for( $i= $month ; $i >= $lsmonth ; $lsmonth++ )
						{
								$firstDate=date('y-'.$lsmonth.'-01');
								$lastDate=date('y-'.$lsmonth.'-t');

								$getPM=$this->Report_m->getPM($vid,$firstDate,$lastDate);
								$getRM=$this->Report_m->getRM($vid,$firstDate,$lastDate);

								$total=$total + $getPM - $getRM;
								$array[]=array(
									'Month' => date($lsmonth.'-y'),
									'Purchase'=>$getPM,
									'Release'=>$getRM,
									'Total'=> $total
								);
						}
					}else{
						if($month == '1' and $year > '2020')
						{
							$lsmonth = array('11','12','01');
							$beginningDate=date('2020-07-01');
							$totalDate=date($year.'-'.$month.'-01');

							$getBPM=$this->Report_m->getBPM($vid,$beginningDate,$totalDate);
							$getBRM=$this->Report_m->getBRM($vid,$beginningDate,$totalDate);

							$totalCurrent= $beginningCount + $getBPM - $getBRM;

							$total=abs($totalCurrent);
							$array=array();
							foreach($lsmonth as $value)
							{
								if($value != '01' AND $year > date('Y'))
								{
									$year=$year-1;
								}else if($value == '01' AND $year == date('Y')){
									$year=$year+1;
								}
								$firstDate=date($year.'-'.$value.'-01');
								$lastDate=date($year.'-'.$value.'-t');
								// echo $firstDate.'<br/>';
								$getPM=$this->Report_m->getPM($vid,$firstDate,$lastDate);
								$getRM=$this->Report_m->getRM($vid,$firstDate,$lastDate);

								$total=$total + $getPM - $getRM;
								$array[]=array(
									'Month' => date($value.'-'.$year),
									'Purchase'=>$getPM,
									'Release'=>$getRM,
									'Total'=> $total
								);
							}
						}else if($month == '2' and $year > '2020')
						{
							$lsmonth = array('12','01','02');
							$beginningDate=date('2020-07-01');
							$totalDate=date($year.'-'.$month.'-01');

							$getBPM=$this->Report_m->getBPM($vid,$beginningDate,$totalDate);
							$getBRM=$this->Report_m->getBRM($vid,$beginningDate,$totalDate);

							$totalCurrent= $beginningCount + $getBPM - $getBRM;
							$total=abs($totalCurrent);
							$array=array();
							foreach($lsmonth as $value)
							{
								if($value != '01')
								{
									$year-1;
								}
								$firstDate=date($year.'-'.$value.'-01');
								$lastDate=date($year.'-'.$value.'-t');

								$getPM=$this->Report_m->getPM($vid,$firstDate,$lastDate);
								$getRM=$this->Report_m->getRM($vid,$firstDate,$lastDate);

								$total=$total + $getPM - $getRM;
								$array[]=array(
									'Month' => date($value.'-'.$year),
									'Purchase'=>$getPM,
									'Release'=>$getRM,
									'Total'=> $total
								);
							}
						}else{
							$lsmonth = $month - 2;
							$beginningDate=date('2020-07-01');
							$totalDate=date($year.'-'.$lsmonth.'-01');

							// echo '<pre>';
							$getBPM=$this->Report_m->getBPM($vid,$beginningDate,$totalDate);
							$getBRM=$this->Report_m->getBRM($vid,$beginningDate,$totalDate);

							$totalCurrent= $beginningCount + $getBPM - $getBRM;
							$total=abs($totalCurrent);
							$array=array();
							for( $i= $month ; $i >= $lsmonth ; $lsmonth++ )
							{
									$firstDate=date($year.'-'.$lsmonth.'-01');
									$lastDate=date($year.'-'.$lsmonth.'-t');

									$getPM=$this->Report_m->getPM($vid,$firstDate,$lastDate);
									$getRM=$this->Report_m->getRM($vid,$firstDate,$lastDate);

									$total=$total + $getPM - $getRM;
									$array[]=array(
										'Month' => date($lsmonth.'-'.$year),
										'Purchase'=>$getPM,
										'Release'=>$getRM,
										'Total'=> $total
									);
							}
						}
					}
					$report[]=array(
						'id'=>$vid,
						'model'=>$val->Product,
						'BeginCount'=> abs($totalCurrent),
						'Counts' => $array,
						'Dealer' => $dealer,
					);
				}


				$countDate=date('2020-06-30');
				$beginningCount=$this->Report_m->getVs2($nseries,$countDate);
				$releasedJuly=$this->Report_m->getV3($vid);
				if($month == '7' AND $year =='2020')
				{

					$lsmonth = $month;
					$beginningDate=date('2020-07-01');
					$totalDate=date('2020-'.$lsmonth.'-01');

					$getBPM=$this->Report_m->getBPM2($nseries,$beginningDate,$totalDate);
					$getBRM=$this->Report_m->getBRM2($nseries,$beginningDate,$totalDate);

					$totalCurrent= $beginningCount + $getBPM - $getBRM;
					$total=$totalCurrent;
					$array2=array();
					for( $i= $month ; $i >= $lsmonth ; $lsmonth++ )
					{
							$firstDate=date('y-'.$lsmonth.'-01');
							$lastDate=date('y-'.$lsmonth.'-t');

							$getPM=$this->Report_m->getPM2($nseries,$firstDate,$lastDate);
							$getRM=$this->Report_m->getRM2($nseries,$firstDate,$lastDate);

							$total=$total + $getPM - $getRM;
							$array2[]=array(
								'Month' => date($lsmonth.'-y'),
								'Purchase'=>$getPM,
								'Release'=>$getRM,
								'Total'=> $total
							);
					}
				}else if($month == '8' AND $year =='2020'){
					$lsmonth = $month - 1;
					$beginningDate=date('2020-07-01');
					$totalDate=date('2020-'.$lsmonth.'-01');

					$getBPM=$this->Report_m->getBPM2($nseries,$beginningDate,$totalDate);
					$getBRM=$this->Report_m->getBRM2($nseries,$beginningDate,$totalDate);

					$totalCurrent= $beginningCount + $getBPM - $getBRM;
					$total=$totalCurrent;
					$array2=array();
					for( $i= $month ; $i >= $lsmonth ; $lsmonth++ )
					{
							$firstDate=date('y-'.$lsmonth.'-01');
							$lastDate=date('y-'.$lsmonth.'-t');

							$getPM=$this->Report_m->getPM2($nseries,$firstDate,$lastDate);
							$getRM=$this->Report_m->getRM2($nseries,$firstDate,$lastDate);

							$total=$total + $getPM - $getRM;
							$array2[]=array(
								'Month' => date($lsmonth.'-y'),
								'Purchase'=>$getPM,
								'Release'=>$getRM,
								'Total'=> $total
							);
					}
				}else{
					if($month == '1' and $year > '2020')
					{
						$lsmonth = array('11','12','01');
						$beginningDate=date('2020-07-01');
						$totalDate=date($year.'-'.$month.'-01');

						$getBPM=$this->Report_m->getBPM2($nseries,$beginningDate,$totalDate);
						$getBRM=$this->Report_m->getBRM2($nseries,$beginningDate,$totalDate);

						$totalCurrent= $beginningCount + $getBPM - $getBRM;
						$total=$totalCurrent;
						$array2=array();
						foreach($lsmonth as $value)
						{
							if($value != '01' AND $year > date('Y'))
							{
								$year=$year-1;
							}else if($value == '01' AND $year == date('Y')){
								$year=$year+1;
							}
							$firstDate=date($year.'-'.$value.'-01');
							$lastDate=date($year.'-'.$value.'-t');
							// echo $firstDate.'<br/>';
							$getPM=$this->Report_m->getPM2($nseries,$firstDate,$lastDate);
							$getRM=$this->Report_m->getRM2($nseries,$firstDate,$lastDate);

							$total=$total + $getPM - $getRM;
							$array2[]=array(
								'Month' => date($value.'-'.$year),
								'Purchase'=>$getPM,
								'Release'=>$getRM,
								'Total'=> $total
							);
						}
					}else if($month == '2' and $year > '2020')
					{
						$lsmonth = array('12','01','02');
						$beginningDate=date('2020-07-01');
						$totalDate=date($year.'-'.$month.'-01');

						$getBPM=$this->Report_m->getBPM2($nseries,$beginningDate,$totalDate);
						$getBRM=$this->Report_m->getBRM2($nseries,$beginningDate,$totalDate);

						$totalCurrent= $beginningCount + $getBPM - $getBRM;
						$total=$totalCurrent;
						$array2=array();
						foreach($lsmonth as $value)
						{
							if($value != '01')
							{
								$year-1;
							}
							$firstDate=date($year.'-'.$value.'-01');
							$lastDate=date($year.'-'.$value.'-t');

							$getPM=$this->Report_m->getPM2($nseries,$firstDate,$lastDate);
							$getRM=$this->Report_m->getRM2($nseries,$firstDate,$lastDate);

							$total=$total + $getPM - $getRM;
							$array2[]=array(
								'Month' => date($value.'-'.$year),
								'Purchase'=>$getPM,
								'Release'=>$getRM,
								'Total'=> $total
							);
						}
					}else{
						$lsmonth = $month - 2;
						$beginningDate=date('2020-07-01');
						$totalDate=date($year.'-'.$lsmonth.'-01');

						$getBPM=$this->Report_m->getBPM2($nseries,$beginningDate,$totalDate);
						$getBRM=$this->Report_m->getBRM2($nseries,$beginningDate,$totalDate);

						$totalCurrent= $beginningCount + $getBPM - $getBRM;
						$total=$totalCurrent;
						$array2=array();
						for( $i= $month ; $i >= $lsmonth ; $lsmonth++ )
						{
								$firstDate=date($year.'-'.$lsmonth.'-01');
								$lastDate=date($year.'-'.$lsmonth.'-t');

								$getPM=$this->Report_m->getPM2($nseries,$firstDate,$lastDate);
								$getRM=$this->Report_m->getRM2($nseries,$firstDate,$lastDate);

								$total=$total + $getPM - $getRM;
								$array2[]=array(
									'Month' => date($lsmonth.'-'.$year),
									'Purchase'=>$getPM,
									'Release'=>$getRM,
									'Total'=> $total
								);
						}
					}
				}
				$newreport[]=array(
					'Series'=>$nseries,
					'report'=>$report,
					'BeginCount'=> abs($totalCurrent),
					'Counts' => $array2,
				);
			}
			// print_r($newreport);
			// die();
				$data['newreport']=$newreport;
			if($year > '2020'){
				$this->load->view('user/Reports/form/vdir3',$data);
			}else if($year == '2020'){
				if($month > '06')
				{
					$this->load->view('user/Reports/form/vdir3',$data);
				}else{
						echo "<h1> No Record Found </h1>";
				}
			}else{
					echo "<h1> No Record Found </h1>";
			}





		}

		public function PRCR2()
		{
			echo '<pre>';
			$dealer=$_GET['dealer'];
			$date=$_GET['startDate'];
			$series=$this->Report_m->series($dealer);
			$newreport=array();
			foreach($series as $vl)
			{
				$report=array();
				$date2 = explode("-", $date);
				$month = $date2[0];
				$year = $date2[1];
				$totalBC=0;

				$nseries=$vl->model_series;
				$countDate=date('2020-06-30');

				$beginningCount=$this->Report_m->getV($nseries,$countDate);

				$model=$this->Report_m->models2($nseries);
				foreach($model as $val)
				{

					$vid=$val->id;
					$countDate=date('2020-06-30');
					$beginningCount=$this->Report_m->getV($vid,$countDate);
					// print_r($beginningCount):
					$releasedJuly=$this->Report_m->getV3($vid);

					$lsmonth = $month - 2;
					$beginningDate=date('2020-07-01');
					$totalDate=date($year.'-'.$lsmonth.'-01');

					if($month == '7' AND $year =='2020')
					{

						$lsmonth = $month;
						$beginningDate=date('2020-07-01');
						$totalDate=date('2020-'.$lsmonth.'-01');

						$getBPM=$this->Report_m->getBPM($vid,$beginningDate,$totalDate);
						$getBRM=$this->Report_m->getBRM($vid,$beginningDate,$totalDate);

						$totalCurrent= $beginningCount + $getBPM - $getBRM;
						$total=abs($totalCurrent);
						$array=array();
						for( $i= $month ; $i >= $lsmonth ; $lsmonth++ )
						{
								$firstDate=date('y-'.$lsmonth.'-01');
								$lastDate=date('y-'.$lsmonth.'-t');

								$getPM=$this->Report_m->getPM($vid,$firstDate,$lastDate);
								$getRM=$this->Report_m->getRM($vid,$firstDate,$lastDate);

								$total=$total + $getPM - $getRM;
								$array[]=array(
									'Month' => date($lsmonth.'-y'),
									'Purchase'=>$getPM,
									'Release'=>$getRM,
									'Total'=> $total
								);
						}
					}else if($month == '8' AND $year =='2020'){
						$lsmonth = $month - 1;
						$beginningDate=date('2020-07-01');
						$totalDate=date('2020-'.$lsmonth.'-01');

						$getBPM=$this->Report_m->getBPM($vid,$beginningDate,$totalDate);
						$getBRM=$this->Report_m->getBRM($vid,$beginningDate,$totalDate);

						$totalCurrent= $beginningCount + $getBPM - $getBRM;
						$total=abs($totalCurrent);
						$array=array();
						for( $i= $month ; $i >= $lsmonth ; $lsmonth++ )
						{
								$firstDate=date('y-'.$lsmonth.'-01');
								$lastDate=date('y-'.$lsmonth.'-t');

								$getPM=$this->Report_m->getPM($vid,$firstDate,$lastDate);
								$getRM=$this->Report_m->getRM($vid,$firstDate,$lastDate);

								$total=$total + $getPM - $getRM;
								$array[]=array(
									'Month' => date($lsmonth.'-y'),
									'Purchase'=>$getPM,
									'Release'=>$getRM,
									'Total'=> $total
								);
						}
					}else{
						if($month == '1' and $year > '2020')
						{
							$lsmonth = array('11','12','01');
							$beginningDate=date('2020-07-01');
							$totalDate=date($year.'-'.$month.'-01');

							$getBPM=$this->Report_m->getBPM($vid,$beginningDate,$totalDate);
							$getBRM=$this->Report_m->getBRM($vid,$beginningDate,$totalDate);

							$totalCurrent= $beginningCount + $getBPM - $getBRM;
							$total=abs($totalCurrent);
							$array=array();
							foreach($lsmonth as $value)
							{
								if($value != '01' AND $year > date('Y'))
								{
									$year=$year-1;
								}else if($value == '01' AND $year == date('Y')){
									$year=$year+1;
								}
								$firstDate=date($year.'-'.$value.'-01');
								$lastDate=date($year.'-'.$value.'-t');
								// echo $firstDate.'<br/>';
								$getPM=$this->Report_m->getPM($vid,$firstDate,$lastDate);
								$getRM=$this->Report_m->getRM($vid,$firstDate,$lastDate);

								$total=$total + $getPM - $getRM;
								$array[]=array(
									'Month' => date($value.'-'.$year),
									'Purchase'=>$getPM,
									'Release'=>$getRM,
									'Total'=> $total
								);
							}
						}else if($month == '2' and $year > '2020')
						{
							$lsmonth = array('12','01','02');
							$beginningDate=date('2020-07-01');
							$totalDate=date($year.'-'.$month.'-01');

							$getBPM=$this->Report_m->getBPM($vid,$beginningDate,$totalDate);
							$getBRM=$this->Report_m->getBRM($vid,$beginningDate,$totalDate);

							$totalCurrent= $beginningCount + $getBPM - $getBRM;
							$total=abs($totalCurrent);
							$array=array();
							foreach($lsmonth as $value)
							{
								if($value != '01')
								{
									$year-1;
								}
								$firstDate=date($year.'-'.$value.'-01');
								$lastDate=date($year.'-'.$value.'-t');

								$getPM=$this->Report_m->getPM($vid,$firstDate,$lastDate);
								$getRM=$this->Report_m->getRM($vid,$firstDate,$lastDate);

								$total=$total + $getPM - $getRM;
								$array[]=array(
									'Month' => date($value.'-'.$year),
									'Purchase'=>$getPM,
									'Release'=>$getRM,
									'Total'=> $total
								);
							}
						}else{
							$lsmonth = $month - 2;
							$beginningDate=date('2020-07-01');
							$totalDate=date($year.'-'.$lsmonth.'-01');

							$getBPM=$this->Report_m->getBPM($vid,$beginningDate,$totalDate);
							$getBRM=$this->Report_m->getBRM($vid,$beginningDate,$totalDate);

							$totalCurrent= $beginningCount + $getBPM - $getBRM;
							$total=abs($totalCurrent);
							$array=array();
							for( $i= $month ; $i >= $lsmonth ; $lsmonth++ )
							{
									$firstDate=date($year.'-'.$lsmonth.'-01');
									$lastDate=date($year.'-'.$lsmonth.'-t');

									$getPM=$this->Report_m->getPM($vid,$firstDate,$lastDate);
									$getRM=$this->Report_m->getRM($vid,$firstDate,$lastDate);

									$total=$total + $getPM - $getRM;
									$array[]=array(
										'Month' => date($lsmonth.'-'.$year),
										'Purchase'=>$getPM,
										'Release'=>$getRM,
										'Total'=> $total
									);
							}
						}
					}
					$report[]=array(
						'id'=>$vid,
						'model'=>$val->Product,
						'BeginCount'=> abs($totalCurrent),
						'Counts' => $array,
						'Dealer' => $dealer,
					);
				}


				$countDate=date('2020-06-30');
				$beginningCount=$this->Report_m->getVs2($nseries,$countDate);
				$releasedJuly=$this->Report_m->getV3($vid);
				if($month == '7' AND $year =='2020')
				{

					$lsmonth = $month;
					$beginningDate=date('2020-07-01');
					$totalDate=date('2020-'.$lsmonth.'-01');

					$getBPM=$this->Report_m->getBPM2($nseries,$beginningDate,$totalDate);
					$getBRM=$this->Report_m->getBRM2($nseries,$beginningDate,$totalDate);

					$totalCurrent= $beginningCount + $getBPM - $getBRM;
					$total=$totalCurrent;
					$array=array();
					for( $i= $month ; $i >= $lsmonth ; $lsmonth++ )
					{
							$firstDate=date('y-'.$lsmonth.'-01');
							$lastDate=date('y-'.$lsmonth.'-t');

							$getPM=$this->Report_m->getPM2($nseries,$firstDate,$lastDate);
							$getRM=$this->Report_m->getRM2($nseries,$firstDate,$lastDate);

							$total=$total + $getPM - $getRM;
							$array[]=array(
								'Month' => date($lsmonth.'-y'),
								'Purchase'=>$getPM,
								'Release'=>$getRM,
								'Total'=> $total
							);
					}
				}else if($month == '8' AND $year =='2020'){
					$lsmonth = $month - 1;
					$beginningDate=date('2020-07-01');
					$totalDate=date('2020-'.$lsmonth.'-01');

					$getBPM=$this->Report_m->getBPM2($nseries,$beginningDate,$totalDate);
					$getBRM=$this->Report_m->getBRM2($nseries,$beginningDate,$totalDate);

					$totalCurrent= $beginningCount + $getBPM - $getBRM;
					$total=$totalCurrent;
					$array=array();
					for( $i= $month ; $i >= $lsmonth ; $lsmonth++ )
					{
							$firstDate=date('y-'.$lsmonth.'-01');
							$lastDate=date('y-'.$lsmonth.'-t');

							$getPM=$this->Report_m->getPM2($nseries,$firstDate,$lastDate);
							$getRM=$this->Report_m->getRM2($nseries,$firstDate,$lastDate);

							$total=$total + $getPM - $getRM;
							$array[]=array(
								'Month' => date($lsmonth.'-y'),
								'Purchase'=>$getPM,
								'Release'=>$getRM,
								'Total'=> $total
							);
					}
				}else{
					if($month == '1' and $year > '2020')
					{
						$lsmonth = array('11','12','01');
						$beginningDate=date('2020-07-01');
						$totalDate=date($year.'-'.$month.'-01');

						$getBPM=$this->Report_m->getBPM2($nseries,$beginningDate,$totalDate);
						$getBRM=$this->Report_m->getBRM2($nseries,$beginningDate,$totalDate);

						$totalCurrent= $beginningCount + $getBPM - $getBRM;
						$total=$totalCurrent;
						$array=array();
						foreach($lsmonth as $value)
						{
							if($value != '01' AND $year > date('Y'))
							{
								$year=$year-1;
							}else if($value == '01' AND $year == date('Y')){
								$year=$year+1;
							}
							$firstDate=date($year.'-'.$value.'-01');
							$lastDate=date($year.'-'.$value.'-t');
							// echo $firstDate.'<br/>';
							$getPM=$this->Report_m->getPM2($nseries,$firstDate,$lastDate);
							$getRM=$this->Report_m->getRM2($nseries,$firstDate,$lastDate);

							$total=$total + $getPM - $getRM;
							$array[]=array(
								'Month' => date($value.'-'.$year),
								'Purchase'=>$getPM,
								'Release'=>$getRM,
								'Total'=> $total
							);
						}
					}else if($month == '2' and $year > '2020')
					{
						$lsmonth = array('12','01','02');
						$beginningDate=date('2020-07-01');
						$totalDate=date($year.'-'.$month.'-01');

						$getBPM=$this->Report_m->getBPM2($nseries,$beginningDate,$totalDate);
						$getBRM=$this->Report_m->getBRM2($nseries,$beginningDate,$totalDate);

						$totalCurrent= $beginningCount + $getBPM - $getBRM;
						$total=$totalCurrent;
						$array=array();
						foreach($lsmonth as $value)
						{
							if($value != '01')
							{
								$year-1;
							}
							$firstDate=date($year.'-'.$value.'-01');
							$lastDate=date($year.'-'.$value.'-t');

							$getPM=$this->Report_m->getPM2($nseries,$firstDate,$lastDate);
							$getRM=$this->Report_m->getRM2($nseries,$firstDate,$lastDate);

							$total=$total + $getPM - $getRM;
							$array[]=array(
								'Month' => date($value.'-'.$year),
								'Purchase'=>$getPM,
								'Release'=>$getRM,
								'Total'=> $total
							);
						}
					}else{
						$lsmonth = $month - 2;
						$beginningDate=date('2020-07-01');
						$totalDate=date($year.'-'.$lsmonth.'-01');

						$getBPM=$this->Report_m->getBPM2($nseries,$beginningDate,$totalDate);
						$getBRM=$this->Report_m->getBRM2($nseries,$beginningDate,$totalDate);

						$totalCurrent= $beginningCount + $getBPM - $getBRM;
						$total=$totalCurrent;
						$array=array();
						for( $i= $month ; $i >= $lsmonth ; $lsmonth++ )
						{
								$firstDate=date($year.'-'.$lsmonth.'-01');
								$lastDate=date($year.'-'.$lsmonth.'-t');

								$getPM=$this->Report_m->getPM2($nseries,$firstDate,$lastDate);
								$getRM=$this->Report_m->getRM2($nseries,$firstDate,$lastDate);

								$total=$total + $getPM - $getRM;
								$array[]=array(
									'Month' => date($lsmonth.'-'.$year),
									'Purchase'=>$getPM,
									'Release'=>$getRM,
									'Total'=> $total
								);
						}
					}
				}
				$newreport[]=array(
					'Series'=>$nseries,
					'report'=>$report,
					'BeginCount'=> abs($totalCurrent),
					'Counts' => $array2,
				);
			}
			// print_r($newreport);
			// die();
				$data['newreport']=$newreport;
			if($year > '2020'){
				$this->load->view('user/Reports/form/vdir3',$data);
			}else if($year == '2020'){
				if($month > '06')
				{
					$this->load->view('user/Reports/form/vdir3',$data);
				}else{
						echo "<h1> No Record Found </h1>";
				}
			}else{
					echo "<h1> No Record Found </h1>";
			}




		}
		public function VDIR_D()
		{
			$this->load->view('v2/partial/header');
			$this->load->view('user/Reports/vdir_d');
			$this->load->view('v2/partial/footer');
		}
		public function faD()
		{
					$brand=$_GET['brand'];
					$searchVariant=$this->Dashboard_m->searchVariant($brand);
					$rdata=array();
					$POT=0;
					$AT=0;
					$OHT=0;
					$FRT=0;
					$EIT=0;
					$COSTT=0;
					$TCOSTT=0;
					foreach($searchVariant as $value)
					{
						$modelid=$value->variant;
						$color=$value->color;
						$cost=number_format((float)$value->cost,2,'.','');
						if($value->cost == '')
						{
							$cost=0;
						}


							$product=$this->Dashboard_m->product2($modelid);
							$intransit=$this->Dashboard_m->intransitCount($modelid,$color);
							$app=$this->Dashboard_m->approvedCount($modelid,$color);
							$onHand=$this->Dashboard_m->onHandCount($modelid,$color);
							$fr=$this->Dashboard_m->forReleaseCount($modelid,$color);

							$approved=0;
							foreach($app as $apv)
							{
								$approved=$apv->quantity;
							}
							$approvedI = $approved + $intransit;

							$forRelease2=0;
							// $cs_num='';
							foreach ($fr as $frvl) {
								$cs_num=$frvl->cs_num;
								// print_r($value->cs_num);
								$gpdetails=$this->Gp_m->get_details3($cs_num);
								//
								$forRelease=0;
								foreach ($gpdetails as $gvl) {

									if($gvl->invoice_date == '0000-00-00' OR $gvl->invoice_date === null)
									{
									}else{
									$forRelease++;

									}
								}
								$forRelease2=$forRelease2+$forRelease;
							}
							$model='';
							foreach($product as $vls)
							{
								$model=$vls->Product;
							}
							$end=$value->quantity + $approved + $onHand + $intransit - $forRelease2;
							$tcost=$cost * $value->quantity;
							$POT=$POT + $value->quantity;
							$AT=$AT + $approvedI;
							$OHT=$OHT + $onHand;
							$FRT=$FRT + $forRelease2;
							$EIT=$EIT + $end;
							$COSTT=$COSTT + $cost;
							$TCOSTT= $TCOSTT + $tcost;

							$rdata[]=array(
								'model'=>$model,
								'color'=>$color,
								'PO'=>$value->quantity,
								'approved'=>$approvedI,
								'onhand'=>$onHand,
								'forrealease'=>$forRelease2,
								'remarks'=>$value->justification,
								'end'=>$end,
								'cost'=>$cost,
								'totalcost'=>number_format((float)$tcost,2,'.','')
							);

					}

					$getmodelseries=$this->Dashboard_m->getMSeries($brand);
					$seriesCount=array();
					$SQTotal=0;
					$SOHTotal=0;
					$SFRTotal=0;
					$SEITotal=0;
					$SCTotal=0;
					$SATotal=0;
					foreach($getmodelseries as $vseries)
					{
						$series=$vseries->model_series;
						$searchVariant2=$this->Dashboard_m->searchModelID($brand,$series);
						$quantity=0;
						$approvedIS=0;
						$onhand=0;
						$forelease=0;
						$endInv=0;
						$finalcost=0;

						foreach($searchVariant2 as $svVL)
						{
							// echo '<pre>';
							// print_r($searchVariant2);
							$modelid=$svVL->variant;
							$color=$svVL->color;

							$cost=number_format((float)$svVL->cost,2,'.','');
							if($value->cost == '')
							{
								$cost=0;
							}

							// $quantity=$quantity + $value->quantity;
								$product=$this->Dashboard_m->product2($modelid);
								$intransit=$this->Dashboard_m->intransitCount($modelid,$color);
								$app=$this->Dashboard_m->approvedCount($modelid,$color);
								$onHand=$this->Dashboard_m->onHandCount($modelid,$color);
								$fr=$this->Dashboard_m->forReleaseCount($modelid,$color);


								$approved=0;
								foreach($app as $apv)
								{
									$approved=$apv->quantity;
								}
								$approvedS = $approved + $intransit;

								$forRelease2=0;
								// $cs_num='';
								foreach ($fr as $frvl) {
									$cs_num=$frvl->cs_num;
									// print_r($value->cs_num);
									$gpdetails=$this->Gp_m->get_details3($cs_num);
									//
									$forRelease=0;
									foreach ($gpdetails as $gvl) {

										if($gvl->invoice_date == '0000-00-00' OR $gvl->invoice_date === null)
										{
										}else{
										$forRelease++;

										}
									}
									$forRelease2=$forRelease2+$forRelease;
								}
								$model='';
								foreach($product as $vls)
								{
									$model=$vls->Product;
								}
								$end=$svVL->quantity + $approved + $onHand + $intransit - $forRelease2;
								$approvedIS= $approvedIS + $approvedS;
								$quantity=$quantity + $svVL->quantity;
								$onhand=$onhand + $onHand;
								$forelease=$forelease + $forRelease2;
								$endInv=$endInv + $end;
								$tcost=$cost * $svVL->quantity;
								$finalcost=$finalcost + $tcost;

						}
						if($quantity == 0)
						{

						}else{
							$seriesCount[]=array(
								'model_series' => $series,
								'approved'=>$approvedIS,
								'quantity' =>$quantity,
								'onhand' =>$onhand,
								'forelease' =>$forelease,
								'endInv' =>$endInv,
								'totalcost'=>$finalcost
							);
						}


						$SQTotal=$SQTotal + $quantity;
						$SATotal=$SATotal + $approvedIS;
						$SOHTotal=$SOHTotal + $onhand;
						$SFRTotal=$SFRTotal + $forelease;
						$SEITotal=$SEITotal + $endInv;
						$SCTotal=$SCTotal + $finalcost;

					}

					// die();

					$data['data']=$rdata;
					$data['POT']=$POT;
					$data['AT']=$AT;
					$data['OHT']=$OHT;
					$data['FRT']=$FRT;
					$data['EIT']=$EIT;
					$data['COSTT']=$COSTT;
					$data['TCOSTT']=$TCOSTT;

					$data['series']=$seriesCount;
					$data['SQTotal']=$SQTotal;
					$data['SATotal']=$SATotal;
					$data['OHTotal']=$SOHTotal;
					$data['SFRTotal']=$SFRTotal;
					$data['SEITotal']=$SEITotal;
					$data['SCTotal']=$SCTotal;
					$data['Brand']= $brand;



					$this->load->view('v2/Forms/printForm',$data);
		}
		public function faD2()
		{
					$brand=$_GET['brand'];
					$models=$this->Dashboard_m->modelC($brand);
					$rdata=array();
					$POT=0;
					$AT=0;
					$OHT=0;
					$FRT=0;
					$EIT=0;
					$COSTT=0;
					$TCOSTT=0;
					foreach($models as $vs)
					{
						$variant=$vs->model_id;
						$modelname=$vs->Product;
						$color=$vs->color;
						$searchVariant=$this->Dashboard_m->searchVariant2($variant,$color);


						// echo '<pre>';
						// print_r($searchVariant);
						// die();
						foreach($searchVariant as $value)
						{
							$modelid=$value->variant;
							$quantity=$value->quantity;
							$color=$value->color;
							$cost=number_format((float)$value->cost,2,'.','');
							if($value->cost == '')
							{
								$cost=0;
							}


								$product=$this->Dashboard_m->product2($modelid);
								$intransit=$this->Dashboard_m->intransitCount($modelid,$color);
								$app=$this->Dashboard_m->approvedCount($modelid,$color);
								$onHand=$this->Dashboard_m->onHandCount($modelid,$color);
								$fr=$this->Dashboard_m->forReleaseCount($modelid,$color);

								$approved=0;
								foreach($app as $apv)
								{
									$approved=$apv->quantity;
								}
								$approvedI = $approved + $intransit;

								$forRelease2=0;
								// $cs_num='';
								foreach ($fr as $frvl) {
									$cs_num=$frvl->cs_num;
									// print_r($value->cs_num);
									$gpdetails=$this->Gp_m->get_details3($cs_num);
									//
									$forRelease=0;
									foreach ($gpdetails as $gvl) {

										if($gvl->invoice_date == '0000-00-00' OR $gvl->invoice_date === null)
										{
										}else{
										$forRelease++;

										}
									}
									$forRelease2=$forRelease2+$forRelease;
								}
								$model='';
								foreach($product as $vls)
								{
									$model=$vls->Product;
								}
								$end=$value->quantity + $approved + $onHand + $intransit - $forRelease2;
								$tcost=$cost * $value->quantity;
								$POT=$POT + $value->quantity;
								$AT=$AT + $approvedI;
								$OHT=$OHT + $onHand;
								$FRT=$FRT + $forRelease2;
								$EIT=$EIT + $end;
								$COSTT=$COSTT + $cost;
								$TCOSTT= $TCOSTT + $tcost;
						}
						if(count($searchVariant) < 1)
						{
							$rdata[]=array(
								'model'=>$modelname,
								'color'=>$color,
								'PO'=>0,
								'approved'=>0,
								'onhand'=>0,
								'forrealease'=>0,
								'remarks'=>'',
								'end'=>0,
								'cost'=>0,
								'totalcost'=>number_format((float)0,2,'.','')
							);
						}else{
							$rdata[]=array(
								'model'=>$modelname,
								'color'=>$color,
								'PO'=>$quantity,
								'approved'=>$approvedI,
								'onhand'=>$onHand,
								'forrealease'=>$forRelease2,
								'remarks'=>$value->justification,
								'end'=>$end,
								'cost'=>$cost,
								'totalcost'=>number_format((float)$tcost,2,'.','')
							);
						}

					}



					$getmodelseries=$this->Dashboard_m->getMSeries($brand);
					$seriesCount=array();
					$SQTotal=0;
					$SOHTotal=0;
					$SFRTotal=0;
					$SEITotal=0;
					$SCTotal=0;
					$SATotal=0;
					foreach($getmodelseries as $vseries)
					{
						$series=$vseries->model_series;
						$searchVariant2=$this->Dashboard_m->searchModelID($brand,$series);
						$quantity=0;
						$approvedIS=0;
						$onhand=0;
						$forelease=0;
						$endInv=0;
						$finalcost=0;

						foreach($searchVariant2 as $svVL)
						{
							// echo '<pre>';
							// print_r($searchVariant2);
							$modelid=$svVL->variant;
							$color=$svVL->color;

							$cost=number_format((float)$svVL->cost,2,'.','');
							if($value->cost == '')
							{
								$cost=0;
							}

							// $quantity=$quantity + $value->quantity;
								$product=$this->Dashboard_m->product2($modelid);
								$intransit=$this->Dashboard_m->intransitCount($modelid,$color);
								$app=$this->Dashboard_m->approvedCount($modelid,$color);
								$onHand=$this->Dashboard_m->onHandCount($modelid,$color);
								$fr=$this->Dashboard_m->forReleaseCount($modelid,$color);


								$approved=0;
								foreach($app as $apv)
								{
									$approved=$apv->quantity;
								}
								$approvedS = $approved + $intransit;

								$forRelease2=0;
								// $cs_num='';
								foreach ($fr as $frvl) {
									$cs_num=$frvl->cs_num;
									// print_r($value->cs_num);
									$gpdetails=$this->Gp_m->get_details3($cs_num);
									//
									$forRelease=0;
									foreach ($gpdetails as $gvl) {

										if($gvl->invoice_date == '0000-00-00' OR $gvl->invoice_date === null)
										{
										}else{
										$forRelease++;

										}
									}
									$forRelease2=$forRelease2+$forRelease;
								}
								$model='';
								foreach($product as $vls)
								{
									$model=$vls->Product;
								}
								$end=$svVL->quantity + $approved + $onHand + $intransit - $forRelease2;
								$approvedIS= $approvedIS + $approvedS;
								$quantity=$quantity + $svVL->quantity;
								$onhand=$onhand + $onHand;
								$forelease=$forelease + $forRelease2;
								$endInv=$endInv + $end;
								$tcost=$cost * $svVL->quantity;
								$finalcost=$finalcost + $tcost;

						}
						// if($quantity == 0)
						// {
						//
						// }else{
							$seriesCount[]=array(
								'model_series' => $series,
								'approved'=>$approvedIS,
								'quantity' =>$quantity,
								'onhand' =>$onhand,
								'forelease' =>$forelease,
								'endInv' =>$endInv,
								'totalcost'=>$finalcost
							);
						// }


						$SQTotal=$SQTotal + $quantity;
						$SATotal=$SATotal + $approvedIS;
						$SOHTotal=$SOHTotal + $onhand;
						$SFRTotal=$SFRTotal + $forelease;
						$SEITotal=$SEITotal + $endInv;
						$SCTotal=$SCTotal + $finalcost;

					}

					// die();

					$data['data']=$rdata;
					$data['POT']=$POT;
					$data['AT']=$AT;
					$data['OHT']=$OHT;
					$data['FRT']=$FRT;
					$data['EIT']=$EIT;
					$data['COSTT']=$COSTT;
					$data['TCOSTT']=$TCOSTT;

					$data['series']=$seriesCount;
					$data['SQTotal']=$SQTotal;
					$data['SATotal']=$SATotal;
					$data['OHTotal']=$SOHTotal;
					$data['SFRTotal']=$SFRTotal;
					$data['SEITotal']=$SEITotal;
					$data['SCTotal']=$SCTotal;
					$data['Brand']= $brand;



					$this->load->view('v2/Forms/printForm',$data);
		}
}
?>
