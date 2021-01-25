<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UploadAr extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
       // error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

		$this->load->database();
		$this->load->library('excel');
		$this->load->model('Admin_m');
		$this->load->model('Main_m');
		$this->load->model('Dashboard_m');
		$this->load->model('Insurance_m');
		$this->load->library('session');
		ini_set('max_execution_time', 300);
		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		if(!$this->session->userdata('logged_in'))
		{
			die("You don't have access here: <a href='".base_url()."Login'>Login Here! </a>");
		}
    }
    function do_upload()
	{
		$this->load->library('upload');

		$files = $_FILES;
		// print_r($_FILES);
		// die();

			$_FILES['userfile']['name']= $files['userfile']['name'];
			$_FILES['userfile']['type']= $files['userfile']['type'];
			$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'];
			$_FILES['userfile']['error']= $files['userfile']['error'];
			$_FILES['userfile']['size']= $files['userfile']['size'];

			$file = preg_replace('/\s+/', '_',$this->set_upload_options()['upload_path'].$files['userfile']['name']);

			$this->upload->initialize($this->set_upload_options());
			$this->upload->do_upload();
				// echo $file;




				$objPHPExcel = PHPExcel_IOFactory::load($file);

				unlink($file);
				$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
				foreach ( $cell_collection as $cell) {
					$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
					$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
					$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

					if ($row == 1) {
						$header[$row][$column] = $data_value;

					}else{

						$body[$row][$column] = $data_value;

						if(isset($body[$row]["A"]))
						{
							if($column == "A"){
								$s_data[$row]["first_name"] = $data_value;
							}
						}else{
							if(empty($body[$row]["A"])){
								$s_data[$row]["first_name"] = '';
							}
						}

						if(isset($body[$row]["B"]))
						{
							if($column == "B"){
								$s_data[$row]["middle_name"] = $data_value;
							}
						}else{
							if(empty($body[$row]["B"])){
								$s_data[$row]["middle_name"] = '';
							}
						}

						if(isset($body[$row]["C"]))
						{
							if($column == "C"){
								$s_data[$row]["last_name"] = $data_value;
							}
						}else{
							if(empty($body[$row]["C"])){
								$s_data[$row]["last_name"] = '';
							}
						}
						if(isset($body[$row]["D"]))
						{
							if($column == "D"){
								$s_data[$row]["cs_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["D"])){
								$s_data[$row]["cs_num"] = '';
							}
						}

						if(isset($body[$row]["E"]))
						{
							if($column == "E"){
								$s_data[$row]["model"] = $data_value;
							}
						}else{
							if(empty($body[$row]["E"])){
								$s_data[$row]["model"] = '';
							}
						}

						if(isset($body[$row]["F"]))
						{
							if($column == "F"){
								$s_data[$row]["color"] = $data_value;
							}
						}else{
							if(empty($body[$row]["F"])){
								$s_data[$row]["color"] = '';
							}
						}

						if(isset($body[$row]["G"]))
						{
							if($column == "G"){
								$s_data[$row]["prod_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["G"])){
								$s_data[$row]["prod_num"] = '';
							}
						}

						if(isset($body[$row]["H"]))
						{
							if($column == "H"){
								$s_data[$row]["engine_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["H"])){
								$s_data[$row]["engine_num"] = '';
							}
						}

						if(isset($body[$row]["I"]))
						{
							if($column == "I"){
								$s_data[$row]["vin_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["I"])){
								$s_data[$row]["vin_num"] = '';
							}
						}

						if(isset($body[$row]["J"]))
						{
							if($column == "J"){
								$s_data[$row]["model_yr"] = $data_value;
							}
						}else{
							if(empty($body[$row]["J"])){
								$s_data[$row]["model_yr"] = '';
							}
						}

						if(isset($body[$row]["K"]))
						{
							if($column == "K"){
								$s_data[$row]["dealer"] = $data_value;
							}
						}else{
							if(empty($body[$row]["K"])){
								$s_data[$row]["dealer"] = '';
							}
						}

						if(isset($body[$row]["L"]))
						{
							if($column == "L"){
								$s_data[$row]["po_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["L"])){
								$s_data[$row]["po_num"] = '';
							}
						}

						if(isset($body[$row]["M"]))
						{
							if($column == "M"){
								$s_data[$row]["po_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["M"])){
								$s_data[$row]["po_date"] = '';
							}
						}

						if(isset($body[$row]["N"]))
						{
							if($column == "N"){
								$s_data[$row]["paid_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["N"])){
								$s_data[$row]["paid_date"] = '';
							}
						}

						if(isset($body[$row]["O"]))
						{
							if($column == "O"){
								$s_data[$row]["posted_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["O"])){
								$s_data[$row]["posted_date"] = '';
							}
						}

						if(isset($body[$row]["P"]))
						{
							if($column == "P"){
								$s_data[$row]["subsidy"] = $data_value;
							}
						}else{
							if(empty($body[$row]["P"])){
								$s_data[$row]["subsidy"] = '';
							}
						}

						if(isset($body[$row]["Q"]))
						{
							if($column == "Q"){
								$s_data[$row]["cost"] = $data_value;
							}
						}else{
							if(empty($body[$row]["Q"])){
								$s_data[$row]["cost"] = '';
							}
						}

						if(isset($body[$row]["R"]))
						{
							if($column == "R"){
								$s_data[$row]["term"] = $data_value;
							}
						}else{
							if(empty($body[$row]["R"])){
								$s_data[$row]["term"] = '';
							}
						}

						if(isset($body[$row]["S"]))
						{
							if($column == "S"){
								$s_data[$row]["bank"] = $data_value;
							}
						}else{
							if(empty($body[$row]["S"])){
								$s_data[$row]["bank"] = '';
							}
						}

						if(isset($body[$row]["T"]))
						{
							if($column == "T"){
								$s_data[$row]["vrr_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["T"])){
								$s_data[$row]["vrr_num"] = '';
							}
						}

						if(isset($body[$row]["U"]))
						{
							if($column == "U"){
								$s_data[$row]["veh_received"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["U"])){
								$s_data[$row]["veh_received"] = '';
							}
						}

						if(isset($body[$row]["V"]))
						{
							if($column == "V"){
								$s_data[$row]["csr_received"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["V"])){
								$s_data[$row]["csr_received"] = '';
							}
						}

						if(isset($body[$row]["W"]))
						{
							if($column == "W"){
								$s_data[$row]["alloc_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["W"])){
								$s_data[$row]["alloc_date"] = '';
							}
						}

						if(isset($body[$row]["X"]))
						{
							if($column == "X"){
								$s_data[$row]["sales_person"] = $data_value;
							}
						}else{
							if(empty($body[$row]["X"])){
								$s_data[$row]["sales_person"] = '';
							}
						}

						if(isset($body[$row]["Y"]))
						{
							if($column == "Y"){
								$s_data[$row]["grp_lica"] = $data_value;
							}
						}else{
							if(empty($body[$row]["Y"])){
								$s_data[$row]["grp_lica"] = '';
							}
						}

						if(isset($body[$row]["Z"]))
						{
							if($column == "Z"){
								$s_data[$row]["grp_plant"] = $data_value;
							}
						}else{
							if(empty($body[$row]["Z"])){
								$s_data[$row]["grp_plant"] = '';
							}
						}

						if(isset($body[$row]["AA"]))
						{
							if($column == "AA"){
								$s_data[$row]["invoice_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["AA"])){
								$s_data[$row]["invoice_date"] = '';
							}
						}

						if(isset($body[$row]["AB"]))
						{
							if($column == "AB"){
								$s_data[$row]["invoice_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["AB"])){
								$s_data[$row]["invoice_num"] = '';
							}
						}

						if(isset($body[$row]["AC"]))
						{
							if($column == "AC"){
								$s_data[$row]["actual_release_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["AC"])){
								$s_data[$row]["actual_release_date"] = '';
							}
						}

						if(isset($body[$row]["AD"]))
						{
							if($column == "AD"){
								$s_data[$row]["system_release_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["AD"])){
								$s_data[$row]["system_release_date"] = '';
							}
						}

						if(isset($body[$row]["AE"]))
						{
							if($column == "AE"){
								$s_data[$row]["plant_release_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["AE"])){
								$s_data[$row]["plant_release_date"] = '';
							}
						}

						if(isset($body[$row]["AF"]))
						{
							if($column == "AF"){
								$s_data[$row]["status"] = $data_value;
							}
						}else{
							if(empty($body[$row]["AF"])){
								$s_data[$row]["status"] = '';
							}
						}

						if(isset($body[$row]["AG"]))
						{
							if($column == "AG"){
								$s_data[$row]["location"] = $data_value;
							}
						}else{
							if(empty($body[$row]["AG"])){
								$s_data[$row]["location"] = '';
							}
						}

						if(isset($body[$row]["AH"]))
						{
							if($column == "AH"){
								$s_data[$row]["remarks"] = $data_value;
							}
						}else{
							if(empty($body[$row]["AH"])){
								$s_data[$row]["remarks"] = '';
							}
						}
						if(isset($body[$row]["AI"]))
						{
							if($column == "AI"){
								$s_data[$row]["company"] = $data_value;
							}
						}else{
							if(empty($body[$row]["AI"])){
								$s_data[$row]["company"] = '';
							}
						}
						if(isset($body[$row]["AJ"]))
						{
							if($column == "AJ"){
								$s_data[$row]["whole_sale_period"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["AJ"])){
								$s_data[$row]["whole_sale_period"] = '';
							}
						}
						if(isset($body[$row]["AK"]))
						{
							if($column == "AK"){
								$s_data[$row]["inv_amt"] = $data_value;
							}
						}else{
							if(empty($body[$row]["AK"])){
								$s_data[$row]["inv_amt"] = '';
							}
						}
					}

					}

				$error_count=0;
				$count_recorded=0;
				$update_count=0;
				// echo '<pre>';print_r($s_data); die();
				foreach ($s_data as $value) {
					$dealer=$value['dealer'];
					$grplica=$value['grp_lica'];
					$grpPlant=$value['grp_plant'];
					if(strlen($dealer) > 0){
						$newdealer=explode(" ",$dealer);
						$count=count($newdealer);
						if($count == 3)
						{
							$brand=$newdealer[0];
							$branch=$newdealer[1].' '.$newdealer[2];
						}else{
							$brand=$newdealer[0];
							$branch=$newdealer[1];
						}
							if(strlen($grplica) > 0){
								$newlica=explode(" ",$grplica);
								$Lcount=count($newlica);
								if($Lcount == 3)
								{
									$Lbrand=$newlica[0];
									$Lbranch=$newlica[1].' '.$newlica[2];
								}else{
									$Lbrand=$newlica[0];
									$Lbranch=$newlica[1];
								}
							}
							if(strlen($grpPlant) > 0){
								$newplant=explode(" ",$grpPlant);
								$Pcount=count($newplant);
								if($Pcount == 3)
								{
									$Pbrand=$newplant[0];
									$Pbranch=$newplant[1].' '.$newplant[2];
								}else{
									$Pbrand=$newplant[0];
									$Pbranch	=$newplant[1];
								}
							}

						$ponum=$value['po_num'];
						$csnum=$value['cs_num'];
						$model=$value['model'];

						$invoice_num=$value['invoice_num'];
						if($ponum == '')
						{
							echo 'po error';
							die();
						}
						$findealer=$this->Admin_m->find_dealer($brand,$branch);
						$countf=count($findealer);
						if($countf < 1)
						{
							$company_data=array(
								'Company'=>$brand,
								'Branch'=>$branch,
							);
							$this->Admin_m->add_new_dealer($company_data);
						}

						$findmodel=$this->Admin_m->find_model($model,$brand);
						$countS=count($findmodel);
						if($countS < 1)
						{
							$product_data=array(
								'Company'=>$brand,
								'Product'=>$model
							);
							$this->Admin_m->add_new_model($product_data);
						}

						$searchdealer=$this->Admin_m->searchd($brand,$branch);
						$LDealer='';
						if(strlen($grplica) > 0){
							$searchlica=$this->Admin_m->Lsearchd($Lbrand,$Lbranch);
							// print_r();
							$lid=$searchlica[0]->id;
							$LDealer=$lid;
						}
						$PDealer='';
						if(strlen($grpPlant) > 0){
							$searchplant=$this->Admin_m->Psearchd($Pbrand,$Pbranch);
							// print_r($searchplant);
							$Pid=$searchplant[0]->id;
							$PDealer=$Pid;
						}
						$did=$searchdealer[0]->id;
						$dealer=$did;
						// echo $did;
						// 	die();
						// print_r($did);




						$checkPO=$this->Admin_m->check_po_id($ponum);
						$checkCSnum=$this->Admin_m->check_cs_num($csnum);
						$checkInvoice=$this->Admin_m->check_inv_num($invoice_num);
						$countPO=count($checkPO);
						$countCS=count($checkCSnum);
						$countINV=count($checkInvoice);

						// $session_data = $this->session->userdata('logged_in');
						// $datas=$session_data[0];
						$id=$_GET['ids'];
						$type=$_GET['type'];
						// $access=$this->Main_m->m_access($id);
						// print_r($access);

						if($type == 1){
							if($countPO > 0)
							{
								if($countCS > 0)
								{
									if($countINV > 0)
									{
											$error_count++;
											$error_data=array(
												'csnum' => $csnum,
												'ponum' => $ponum,
												'invoice_num' => $invoice_num,
												'added_by'=>$id
											);
											$this->Admin_m->error_log_data($error_data);
								 }else{
											echo $ponum;
											$error_count++;
											$error_data=array(
												'csnum' => $csnum,
												'ponum' => $ponum,
												'invoice_num' => $invoice_num,
												'added_by'=>$id
											);
											$this->Admin_m->error_log_data($error_data);
									}
									}else{
									$error_count++;
									$error_data=array(
										'csnum' => $csnum,
										'ponum' => $ponum,
										'invoice_num' => $invoice_num,
										'added_by'=>$id
									);
									$this->Admin_m->error_log_data($error_data);
								}

							}else{
								if($countCS > 0)
								{
									if($countINV > 0)
									{
										$error_count++;
										$error_data=array(
											'csnum' => $csnum,
											'ponum' => $ponum,
											'invoice_num' => $invoice_num,
											'added_by'=>$id
										);
										$this->Admin_m->error_log_data($error_data);
									}else{
										$error_count++;
										$error_data=array(
											'csnum' => $csnum,
											'ponum' => $ponum,
											'invoice_num' => $invoice_num,
											'added_by'=>$id
										);
										$this->Admin_m->error_log_data($error_data);
									}
								}else{
									$pr_dateget=$value['plant_release_date'];
													if($pr_dateget == '')
													{
															$pr_date="0000-00-00";
													}else{
															$pr_dateArray= explode('-', $pr_dateget);
															$pr_date = new DateTime();
															$pr_date->setDate($pr_dateArray[1], $pr_dateArray[0], 01);
															$pr_date=$pr_date->format('Y-m-d');
													}


													$sr_dateget=$value['system_release_date'];
													if($sr_dateget == '')
													{
															$sr_date="0000-00-00";
													}else{
															$sr_dateArray= explode('-', $sr_dateget);
															$sr_date = new DateTime();
															$sr_date->setDate($sr_dateArray[1], $sr_dateArray[0], 01);
															$sr_date=$sr_date->format('Y-m-d');
													}

										$po_array=array(
											'po_num'=>$ponum,
											'po_date'=>$value['po_date'],
											'dealer'=>$dealer,
											'added_by'=>$_GET['id'],
											'whole_sale_period'=>$value['whole_sale_period'],
											'has_vehicle'=>1,
											'deleted'=>0
										);
										$last_id=$this->Admin_m->insert_po($po_array);
										$v_array=array(
											'cs_num'=>$value['cs_num'],
											'model'=>$value['model'],
											'model_yr'=>$value['model_yr'],
											'location'=>$value['location'],
											'purchase_order'=>$last_id,
											'vrr_num'=>$value['vrr_num'],
											'color'=>$value['color'],
											'prod_num'=>$value['prod_num'],
											'vin_num'=>$value['vin_num'],
											'paid_date'=>$value['paid_date'],
											'posted_date'=>$value['posted_date'],
											'subsidy'=>$value['subsidy'],
											'veh_received'=>$value['veh_received'],
											'csr_received'=>$value['csr_received'],
											'engine_num'=>$value['engine_num'],
											'cost'=>$value['cost'],
											'remarks'=>$value['remarks'],
											'added_by'=>$_GET['id'],
											'deleted'=>0
										);
										$last_id2=$this->Admin_m->insert_vehicle($v_array);
										$inv_array=array(
											'vehicle_id'=>$last_id2,
											'pay_amt' => $value['cost'],
											'first_name' => $value['first_name'],
											'middle_name' => $value['middle_name'],
											'last_name' => $value['last_name'],
											'alloc_date' => $value['alloc_date'],
											'salesperson' => $value['sales_person'],
											'invoice_date' => $value['invoice_date'],
											'invoice_num' => $value['invoice_num'],
											'company' => $value['company'],
											'term' => $value['term'],
											'bank' => $value['bank'],
											'grp_lica' => $LDealer,
											'grp_plant' => $PDealer,
											'actual_release_date' => $value['actual_release_date'],
											'plant_release_date' => $pr_dateget,
											'system_release_date' => $sr_dateget,
											'remarks' => $value['remarks'],
											'added_by'=>$_GET['id']
										);
										$this->Admin_m->insert_invoice($inv_array);
										$status='';
										if(!$value['veh_received'])
										{
											$status='For Pull Out';
										}else if((!$value['alloc_date']) AND (!$value['invoice_num']) AND (!$value['actual_release_date']))
										{
											$status='Available';
										}else if((!$value['invoice_num']) AND (!$value['actual_release_date']))
										{
											$status='Allocated';
										}else if(!$value['actual_release_date'])
										{
											$status='Invoiced';
										}else{
											$status='Released';
										}

										// echo $last_id.$value['cs_num'].$value['invoice_num'].$status;
										$updata=array(
													'po_id'=>$last_id,
													'cs_num' =>$value['cs_num'],
													'inv_num' =>$value['invoice_num'],
													'status' => $status
												);

												$test=$this->Admin_m->insertStatus($updata);
												print_r($test);
										$count_recorded++;

								}
							}
						}else{
							$access=$this->Main_m->m_access($id);
							foreach ($access as $acc) {
								$dealers=$acc->key;

								if($dealers == $brand)
								{
									if($countPO > 0)
									{
												$error_count++;
												$error_data=array(
													'csnum' => $csnum,
													'ponum' => $ponum,
													'invoice_num' => $invoice_num,
													'added_by'=>$id
												);
												$this->Admin_m->error_log_data($error_data);
									}else{
										if($countCS > 0)
										{
											$error_count++;
											$error_data=array(
												'csnum' => $csnum,
												'ponum' => $ponum,
												'invoice_num' => $invoice_num,
												'added_by'=>$id
											);
											$this->Admin_m->error_log_data($error_data);
										}else{
											$pr_dateget=$value['plant_release_date'];
															if($pr_dateget == '')
															{
																	$pr_date="0000-00-00";
															}else{
																	$pr_dateArray= explode('-', $pr_dateget);
																	$pr_date = new DateTime();
																	$pr_date->setDate($pr_dateArray[1], $pr_dateArray[0], 01);
																	$pr_date=$pr_date->format('Y-m-d');
															}


															$sr_dateget=$value['system_release_date'];
															if($sr_dateget == '')
															{
																	$sr_date="0000-00-00";
															}else{
																	$sr_dateArray= explode('-', $sr_dateget);
																	$sr_date = new DateTime();
																	$sr_date->setDate($sr_dateArray[1], $sr_dateArray[0], 01);
																	$sr_date=$sr_date->format('Y-m-d');
															}

												$po_array=array(
													'po_num'=>$ponum,
													'po_date'=>$value['po_date'],
													'dealer'=>$dealer,
													'whole_sale_period'=>$value['whole_sale_period'],
													'added_by'=>$_GET['id'],
													'has_vehicle'=>1,
													'deleted'=>0
												);
												$last_id=$this->Admin_m->insert_po($po_array);
												$v_array=array(
													'cs_num'=>$value['cs_num'],
													'model'=>$value['model'],
													'model_yr'=>$value['model_yr'],
													'location'=>$value['location'],
													'purchase_order'=>$last_id,
													'vrr_num'=>$value['vrr_num'],
													'color'=>$value['color'],
													'prod_num'=>$value['prod_num'],
													'vin_num'=>$value['vin_num'],
													'paid_date'=>$value['paid_date'],
													'posted_date'=>$value['posted_date'],
													'subsidy'=>$value['subsidy'],
													'veh_received'=>$value['veh_received'],
													'csr_received'=>$value['csr_received'],
													'engine_num'=>$value['engine_num'],
													'cost'=>$value['cost'],
													'remarks'=>$value['remarks'],
													'added_by'=>$_GET['id'],
													'deleted'=>0
												);
												$last_id2=$this->Admin_m->insert_vehicle($v_array);
												$inv_array=array(
													'vehicle_id'=>$last_id2,
													'pay_amt' => $value['cost'],
													'first_name' => $value['first_name'],
													'middle_name' => $value['middle_name'],
													'last_name' => $value['last_name'],
													'alloc_date' => $value['alloc_date'],
													'salesperson' => $value['sales_person'],
													'invoice_date' => $value['invoice_date'],
													'invoice_num' => $value['invoice_num'],
													'company' => $value['company'],
													'term' => $value['term'],
													'bank' => $value['bank'],
													'grp_lica' => $LDealer,
													'grp_plant' => $PDealer,
													'actual_release_date' => $value['actual_release_date'],
													'plant_release_date' => $pr_dateget,
													'system_release_date' => $sr_dateget,
													'remarks' => $value['remarks'],
													'added_by'=>$_GET['id']
												);
												$this->Admin_m->insert_invoice($inv_array);
												$status='';
												if(!$value['veh_received'])
												{
													$status='For Pull Out';
												}else if((!$value['alloc_date']) AND (!$value['invoice_num']) AND (!$value['actual_release_date']))
												{
													$status='Available';
												}else if((!$value['invoice_num']) AND (!$value['actual_release_date']))
												{
													$status='Allocated';
												}else if(!$value['actual_release_date'])
												{
													$status='Invoiced';
												}else{
													$status='Released';
												}
												$updata=array(
															'po_id'=>$last_id,
															'cs_num' =>$value['cs_num'],
															'inv_num' =>$value['invoice_num'],
															'status' => $status
														);

														$test=$this->Admin_m->insertStatus($updata);
														print_r($test);
												$count_recorded++;

										}
									}
								}else{
									$error_count++;
										$error_data=array(
											'csnum' => $csnum,
											'ponum' => $ponum,
											'invoice_num' => $invoice_num
										);
										$this->Admin_m->error_log_data($error_data);
								}
							}
						}
					}else{
						$error_count++;

					}
				}
				echo "Total Count Import Successful = ".$count_recorded;
				echo "<br/>Total Count Import Update Record = ".$update_count;
				echo "<br/>Total Count Import Unsuccessful = ".$error_count;

	}

	private function set_upload_options()
	{
		//upload an image options
		$config = array();
		$config['upload_path'] = './Excel/';
		$config['allowed_types'] = '*';
		$config['max_size']      = '0';
		$config['overwrite']     = FALSE;

		return $config;
	}
	private function set_mail_options()
	{
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "mail.licagroup.biz";
		$config['smtp_port'] = "25";
		$config['smtp_user'] = "dsar@licagroup.biz";
		$config['smtp_pass'] = "code015";
		$config['mailtype'] = "html";

		return $config;
	}

	public function ma()
	{
		$user_info = $this->session->userdata('colisLoggin');
		$uc = $this->login_model->getUserAccess($user_info['id']);
		echo "<pre>";
		print_r($uc);
	}
	public function escape($str)
	{
		if (is_array($str))
		{
			$str = array_map(array(&$this, 'escape'), $str);
			return $str;
		}
		elseif (is_string($str) OR (is_object($str) && method_exists($str, '__toString')))
		{
			return "'".$this->escape_str($str)."'";
		}
		elseif (is_bool($str))
		{
			return ($str === FALSE) ? 0 : 1;
		}
		elseif ($str === NULL)
		{
			return 'NULL';
		}

		return $str;
	}
	public function escape_str($str)
	{
		if (is_array($str))
		{
			foreach ($str as $key => $val)
			{
				$str[$key] = $this->escape_str($val, $like);
			}

			return $str;
		}

		$str = $this->_escape_str($str);


		return $str;
	}

	protected function _escape_str($str)
	{
		return str_replace("'", "''", remove_invisible_characters($str));
	}

	function _insert_on_duplicate_update_batch($table, $keys, $values)
	{
		foreach($keys as $num => $key) {
			$update_fields[] = $key .'='. $values[$num];
		}
		return "INSERT INTO ".$table." (".implode(', ', $keys).") VALUES (".implode(', ', $values).") ON DUPLICATE KEY UPDATE ".implode(', ', $update_fields);
		//return "INSERT INTO ".$table." (".$keys.") VALUES (".implode(', ', $values).") ON DUPLICATE KEY UPDATE ".implode(', ', $update_fields);
	}

	function UpDebtors()
	{
		ini_set('memory_limit', '-1');
		$file = "./UploadArFiles/Invoices.xls";

		$objPHPExcel = PHPExcel_IOFactory::load($file);

		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		//extract to a PHP readable array format

		foreach ( $cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

			if ($row == 1) {
				$header[$row][$column] = $data_value;
			}
			else {
				$tbody[$row][$column] = trim($data_value);
				// if($column == "G"){
				// 	$column = "Name";
				// 	$today = date('Y-m-d');
				// 	$body[$row]["Date_Added"] = $today;
				// 	$body[$row][$column] = trim($data_value);
				// }

				if(isset($tbody[$row]['G'])){
					if($column == "G"){
						$column = "Name";
						$today = date('Y-m-d');
						$body[$row]["Date_Added"] = $today;
						$body[$row][$column] = trim($data_value);
					}
				}
				else{
					$today = date('Y-m-d');
					$body[$row]["Date_Added"] = $today;
					$body[$row]['Name'] = '';
				}

				if(isset($tbody[$row]['M'])){
					if($column == "M"){
						$body[$row]['Credit_Terms'] = trim($data_value);
					}
				}
				else{
					$body[$row]['Credit_Terms'] = 0;
				}
				if(isset($tbody[$row]['F'])){
					if($column == "F"){
						$body[$row]['Classification'] = trim($data_value);
					}
				}
				else{
					$body[$row]['Classification'] = 0;
				}

			}
		}
		//echo "<pre>";
		//print_r($header);
		$allDebtor = array_unique($body, SORT_REGULAR);
		// print_r($allDebtor);
		//  die();
		if(count($allDebtor) > 0){
			$dLen = $this->debtor_m->addDebtorFromExcel($allDebtor);
		}
		else{
			$dLen = 0;
		}

		header("Location:".base_url()."uploadar/ce");
	}

	function Ce()
	{
		ini_set('memory_limit', '-1');

		$file = "./UploadArFiles/Invoices.xls";

		$objPHPExcel = PHPExcel_IOFactory::load($file);

		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		//extract to a PHP readable array format
		$dList = $this->debtor_m->getDebtor();
		$statusList = $this->invoice_m->getStatus();
		echo "<pre>";
		// print_r($dList);
		// die();
		foreach ( $cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

			if ($row == 1) {
				$header[$row][$column] = $data_value;
			}
			else {
				$tbody[$row][$column] = trim($data_value);
				if($column == "G"){
					//$column = "Debtor";
					//$body[$row][$column] = trim($data_value);
					foreach ($dList as $key) {
						if(strcmp(trim($data_value), $key->Name) === 0)	{
							$body[$row]['debtor_id'] = $key->id;
							$hasDebtor = true;
							$today = date('Y-m-d H:i:s');
							$body[$row]["Date_Added"] = $today;
							$body[$row]['Company'] = trim($tbody[$row]['B']);
							$body[$row]['Branch'] = trim($tbody[$row]['C']);
						}
					}

				}
				if(isset($hasDebtor)){
					if($column == "B"){
						$column = "Company";

						//$body[$row][$column] = trim($data_value);
					}
					if($column == "C"){
						$column = "Branch";

						//$body[$row][$column] = trim($data_value);
					}

					if(isset($tbody[$row]['H'])){
						if($column == "H"){
							$body[$row]['Debtor_Branch'] = trim($data_value);
						}
					}
					else{
						$body[$row]['Debtor_Branch'] = '';
					}

					if(isset($tbody[$row]['I'])){
						if($column == "I"){
							$body[$row]['Bank_Name'] = trim($data_value);
						}
					}
					else{
						$body[$row]['Bank_Name'] = '';
					}

					if(isset($tbody[$row]['J'])){
						if($column == "J"){
							$body[$row]['Invoice_Date'] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
						}
					}
					else{
						$body[$row]['Invoice_Date'] = '';
					}

					if(isset($tbody[$row]['P'])){
						if($column == "P"){
							$body[$row]['Invoice_No'] = trim($data_value);
						}
					}
					else{
						$body[$row]['Invoice_No'] = 'No Invoice';
					}
					if(isset($tbody[$row]['Q'])){
						if($column == "Q"){
							$body[$row]['Manual_Invoice_No'] = trim($data_value);
						}
					}
					else{
						$body[$row]['Manual_Invoice_No'] = '';
					}

					if(isset($tbody[$row]['R'])){
						if($column == "R"){
							$body[$row]['Invoice_Amt'] = trim($data_value);
						}
					}
					else{
						$body[$row]['Invoice_Amt'] = '0';
					}


					if(isset($tbody[$row]['T'])){
						if($column == "T"){
							foreach ($statusList as $key) {
								if(strcmp(trim($data_value), $key->Status) === 0){
									$body[$row]['Status'] = $key->id;
								}
							}
						}
					}
					else{
						$body[$row]['Status'] = '';
					}

					if(isset($tbody[$row]['BJ'])){
						if($column == "BJ"){
							$body[$row]['Assured_Name'] = $body[$row]['Remarks'] = preg_replace('/[^A-Za-z0-9\-]/', ' ', $data_value);
						}
					}
					else{
						$body[$row]['Assured_Name'] = '';
					}

					if(isset($tbody[$row]['U'])){
						if($column == "U"){
							$column = "Collectible";
							if(strlen(trim($data_value)) > 0){
								if(trim($data_value) == "COLLECTIBLE"){
									$body[$row][$column] = 1;
								}
								else{
									$body[$row][$column] = 0;
								}
							}
							else{
								$body[$row]['Collectible'] = 0;
							}
						}
					}
					else{
						$body[$row]['Collectible'] = 0;
					}

					if(isset($tbody[$row]['V'])){
						if($column == "V"){
							$body[$row]['Tags'] = trim($data_value);
						}
					}
					else{
						$body[$row]['Tags'] = '';
					}

					if(isset($tbody[$row]['AD'])){
						if($column == "AD"){
							//$body[$row]['Remarks'] =  $data_value;
							$body[$row]['Remarks'] =  preg_replace('/\\\\/', '_',$data_value);

						}
					}
					else{
						$body[$row]['Remarks'] = '';
					}

					if(isset($tbody[$row]['BF'])){
						if($column == "BF"){
							$body[$row]['Claim_No'] = trim($data_value);
						}
					}
					else{
						$body[$row]['Claim_No'] = '';
					}

					if(isset($tbody[$row]['BG'])){
						if($column == "BG"){
							$body[$row]['Policy_No'] = trim($data_value);
						}
					}
					else{
						$body[$row]['Policy_No'] = '';
					}

					if(isset($tbody[$row]['BD'])){
						if($column == "BD"){
							$body[$row]['LOA'] = trim($data_value);
						}
					}
					else{
						$body[$row]['LOA'] = '';
					}

					if(isset($tbody[$row]['BD'])){
						if($column == "BD"){
							$body[$row]['PO'] = trim($data_value);
						}
					}
					else{
						$body[$row]['PO'] = '';
					}

					if(isset($tbody[$row]['BC'])){
						if($column == "BC"){
							$body[$row]['JO_RO'] = trim($data_value);
						}
					}
					else{
						$body[$row]['JO_RO'] = '';
					}

					if(isset($tbody[$row]['BB'])){
						if($column == "BB"){
							$body[$row]['Plate_No'] = trim($data_value);
						}
					}
					else{
						$body[$row]['Plate_No'] = '';
					}

					if(isset($tbody[$row]['BI'])){
						if($column == "BI"){
							$body[$row]['Adjuster'] = trim($data_value);
						}
					}
					else{
						$body[$row]['Adjuster'] = '';
					}

					if(isset($tbody[$row]['AE'])){
						if($column == "AE"){
							$body[$row]['Counter_Date'] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
						}
					}
					else{
						$body[$row]['Counter_Date'] = '';
					}

					if(isset($tbody[$row]['AJ'])){
						if($column == "AJ"){
							$body[$row]['Due_Date'] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
						}
					}
					else{
						$body[$row]['Due_Date'] = '';
					}

					if(isset($tbody[$row]['BH'])){
						if($column == "BH"){
							$body[$row]['Date_of_Loss'] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
						}
					}
					else{
						$body[$row]['Date_of_Loss'] = '';
					}

					if(isset($tbody[$row]['AO'])){
						if($column == "AO"){
							$body[$row]['Expected_Collection_Date'] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
						}
					}
					else{
						$body[$row]['Expected_Collection_Date'] = '';
					}

					if(isset($tbody[$row]['AR'])){
						if($column == "AR"){
							$body[$row]['OR_No'] = trim($data_value);
						}
					}
					else{
						$body[$row]['OR_No'] = '';
					}

					if(isset($tbody[$row]['AS'])){
						if($column == "AS"){
							$body[$row]['Check_Amt'] = trim($data_value);
						}
					}
					else{
						$body[$row]['Check_Amt'] = '';
					}

					if(isset($tbody[$row]['AT'])){
						if($column == "AT"){
							$body[$row]['EWT'] = trim($data_value);
						}
					}
					else{
						$body[$row]['EWT'] = '';
					}

					if(isset($tbody[$row]['AU'])){
						if($column == "AU"){
							$body[$row]['Form_2307'] = trim($data_value);
						}
					}
					else{
						$body[$row]['Form_2307'] = '';
					}
				}


			}
		}

		// print_r($header);

		// $today = date('Y-m-d H:i:s');
		// $actlogs = array(
		// 	"debtor_id" => $debtId,
		// 	"contact_person_id" => $contactID,
		// 	"invoice_id" => $invId,
		// 	"user_id" => $user_id,
		// 	"Date" => $today,
		// 	"Action" => $logs
		// 	);


		foreach ($body as $key => $value) {
			$keys = array_keys($value);
		}

		// print_r($body);
		// die();
		$iLen = 0;
		foreach($body as $num => $key) {
			$upf = array();
			$rmk = '';
			$dID = '';
			foreach ($keys as $k) {
				$upf[] = $k .'='. $this->escape($key[$k]);
				if($k == "Remarks"){
					$rmk =$key[$k];
				}
				if($k == "debtor_id"){
					$dID = $key[$k];
				}

			}

			//$str = "INSERT INTO Test (".implode(', ', $keys).") VALUES (".implode(', ', $key).") ON DUPLICATE KEY UPDATE ".implode(', ', $upf);
			//echo $str, EOL;
			$last_id_inv = $this->invoice_m->addInvoiceFromExcel($key,$upf);
			$today = date('Y-m-d H:i:s');
			$actlogs = array(
				"debtor_id" => $dID,
				"contact_person_id" => null,
				"invoice_id" => $last_id_inv,
				"user_id" => 999,
				"Date" => $today,
				"Action" => $rmk
			);
			$this->invoice_m->addInvoiceLogs($actlogs);
			//print_r($actlogs);
			//$iLens = $this->invoice_m->addInvoiceFromExcel($key,$upf);
			// if($iLens > 0){
			// 	$iLen++;
			// }

			//echo $this->invoice_m->addInvoiceFromExcel($key,$upf), EOL;
		}
		echo "Upload complete.";
		if($iLen === -1){
			$this->session->set_flashdata('msgColor', 'danger');
			$this->session->set_flashdata('msg', 'Wrong file or already added.');
		}
		else if($iLen === 0){
			$this->session->set_flashdata('msgColor', 'danger');
			$this->session->set_flashdata('msg', 'Wrong file or already added.');
		}else{
			$this->session->set_flashdata('msgColor', 'success');
    		$this->session->set_flashdata('msg', '<b>'.$dLen.' </b> Debtor and <b>'.$iLen.'</b> Invoices has been added successfully.');
		}

	}
	function do_upload2()
	{
		$this->load->library('upload');

		$files = $_FILES;
		// print_r($_FILES);
		// die();

		$_FILES['userfile']['name']= $files['userfile']['name'];
		$_FILES['userfile']['type']= $files['userfile']['type'];
		$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'];
		$_FILES['userfile']['error']= $files['userfile']['error'];
		$_FILES['userfile']['size']= $files['userfile']['size'];

		$file = preg_replace('/\s+/', '_',$this->set_upload_options()['upload_path'].$files['userfile']['name']);

		$this->upload->initialize($this->set_upload_options());
		$this->upload->do_upload();
			// echo $file;




			$objPHPExcel = PHPExcel_IOFactory::load($file);

			unlink($file);
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			foreach ( $cell_collection as $cell) {
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

				if ($row == 1) {
					$header[$row][$column] = $data_value;

				}else{

					$body[$row][$column] = $data_value;

					if(isset($body[$row]["A"]))
					{
						if($column == "A"){
							$s_data[$row]["first_name"] = $data_value;
						}
					}else{
						if(empty($body[$row]["A"])){
							$s_data[$row]["first_name"] = '';
						}
					}

					if(isset($body[$row]["B"]))
					{
						if($column == "B"){
							$s_data[$row]["middle_name"] = $data_value;
						}
					}else{
						if(empty($body[$row]["B"])){
							$s_data[$row]["middle_name"] = '';
						}
					}

					if(isset($body[$row]["C"]))
					{
						if($column == "C"){
							$s_data[$row]["last_name"] = $data_value;
						}
					}else{
						if(empty($body[$row]["C"])){
							$s_data[$row]["last_name"] = '';
						}
					}
					if(isset($body[$row]["D"]))
					{
						if($column == "D"){
							$s_data[$row]["cs_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["D"])){
							$s_data[$row]["cs_num"] = '';
						}
					}

					if(isset($body[$row]["E"]))
					{
						if($column == "E"){
							$s_data[$row]["model"] = $data_value;
						}
					}else{
						if(empty($body[$row]["E"])){
							$s_data[$row]["model"] = '';
						}
					}

					if(isset($body[$row]["F"]))
					{
						if($column == "F"){
							$s_data[$row]["color"] = $data_value;
						}
					}else{
						if(empty($body[$row]["F"])){
							$s_data[$row]["color"] = '';
						}
					}

					if(isset($body[$row]["G"]))
					{
						if($column == "G"){
							$s_data[$row]["prod_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["G"])){
							$s_data[$row]["prod_num"] = '';
						}
					}

					if(isset($body[$row]["H"]))
					{
						if($column == "H"){
							$s_data[$row]["engine_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["H"])){
							$s_data[$row]["engine_num"] = '';
						}
					}

					if(isset($body[$row]["I"]))
					{
						if($column == "I"){
							$s_data[$row]["vin_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["I"])){
							$s_data[$row]["vin_num"] = '';
						}
					}

					if(isset($body[$row]["J"]))
					{
						if($column == "J"){
							$s_data[$row]["model_yr"] = $data_value;
						}
					}else{
						if(empty($body[$row]["J"])){
							$s_data[$row]["model_yr"] = '';
						}
					}

					if(isset($body[$row]["K"]))
					{
						if($column == "K"){
							$s_data[$row]["dealer"] = $data_value;
						}
					}else{
						if(empty($body[$row]["K"])){
							$s_data[$row]["dealer"] = '';
						}
					}

					if(isset($body[$row]["L"]))
					{
						if($column == "L"){
							$s_data[$row]["po_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["L"])){
							$s_data[$row]["po_num"] = '';
						}
					}

					if(isset($body[$row]["M"]))
					{
						if($column == "M"){
							if(empty($data_value)){
								$s_data[$row]["po_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["po_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["M"])){
							$s_data[$row]["po_date"] = '';
						}
					}

					if(isset($body[$row]["N"]))
					{
						if($column == "N"){
							if(empty($data_value)){
								$s_data[$row]["paid_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["paid_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["N"])){
							$s_data[$row]["paid_date"] = '';
						}
					}

					if(isset($body[$row]["O"]))
					{
						if($column == "O"){
							if(empty($data_value)){
								$s_data[$row]["posted_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["posted_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["O"])){
							$s_data[$row]["posted_date"] = '';
						}
					}

					if(isset($body[$row]["P"]))
					{
						if($column == "P"){
							$s_data[$row]["subsidy"] = $data_value;
						}
					}else{
						if(empty($body[$row]["P"])){
							$s_data[$row]["subsidy"] = '';
						}
					}

					if(isset($body[$row]["Q"]))
					{
						if($column == "Q"){
							$s_data[$row]["cost"] = $data_value;
						}
					}else{
						if(empty($body[$row]["Q"])){
							$s_data[$row]["cost"] = '';
						}
					}

					if(isset($body[$row]["R"]))
					{
						if($column == "R"){
							$s_data[$row]["term"] = $data_value;
						}
					}else{
						if(empty($body[$row]["R"])){
							$s_data[$row]["term"] = '';
						}
					}

					if(isset($body[$row]["S"]))
					{
						if($column == "S"){
							$s_data[$row]["bank"] = $data_value;
						}
					}else{
						if(empty($body[$row]["S"])){
							$s_data[$row]["bank"] = '';
						}
					}

					if(isset($body[$row]["T"]))
					{
						if($column == "T"){
							$s_data[$row]["vrr_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["T"])){
							$s_data[$row]["vrr_num"] = '';
						}
					}

					if(isset($body[$row]["U"]))
					{
						if($column == "U"){
							if(empty($data_value)){
								$s_data[$row]["veh_received"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
								$s_data[$row]["veh_received"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["U"])){
							$s_data[$row]["veh_received"] = '';
						}
					}

					if(isset($body[$row]["V"]))
					{
						if($column == "V"){
							if(empty($data_value)){
								$s_data[$row]["csr_received"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["csr_received"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["V"])){
							$s_data[$row]["csr_received"] = '';
						}
					}

					if(isset($body[$row]["W"]))
					{
						if($column == "W"){
							if(empty($data_value)){
								$s_data[$row]["alloc_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["alloc_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["W"])){
							$s_data[$row]["alloc_date"] = '';
						}
					}

					if(isset($body[$row]["X"]))
					{
						if($column == "X"){
							$s_data[$row]["sales_person"] = $data_value;
						}
					}else{
						if(empty($body[$row]["X"])){
							$s_data[$row]["sales_person"] = '';
						}
					}

					if(isset($body[$row]["Y"]))
					{
						if($column == "Y"){
							$s_data[$row]["grp_lica"] = $data_value;
						}
					}else{
						if(empty($body[$row]["Y"])){
							$s_data[$row]["grp_lica"] = '';
						}
					}

					if(isset($body[$row]["Z"]))
					{
						if($column == "Z"){
							$s_data[$row]["grp_plant"] = $data_value;
						}
					}else{
						if(empty($body[$row]["Z"])){
							$s_data[$row]["grp_plant"] = '';
						}
					}

					if(isset($body[$row]["AA"]))
					{
						if($column == "AA"){
							if(empty($data_value)){
								$s_data[$row]["invoice_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["invoice_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["AA"])){
							$s_data[$row]["invoice_date"] = '';
						}
					}

					if(isset($body[$row]["AB"]))
					{
						if($column == "AB"){
							$s_data[$row]["invoice_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["AB"])){
							$s_data[$row]["invoice_num"] = '';
						}
					}

					if(isset($body[$row]["AC"]))
					{
						if($column == "AC"){
							if(empty($data_value)){
								$s_data[$row]["actual_release_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["actual_release_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["AC"])){
							$s_data[$row]["actual_release_date"] = '';
						}
					}

					if(isset($body[$row]["AD"]))
					{
						if($column == "AD"){
							if(empty($data_value)){
								$s_data[$row]["system_release_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["system_release_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["AD"])){
							$s_data[$row]["system_release_date"] = '';
						}
					}

					if(isset($body[$row]["AE"]))
					{
						if($column == "AE"){
							if(empty($data_value)){
								$s_data[$row]["plant_release_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["plant_release_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["AE"])){
							$s_data[$row]["plant_release_date"] = '';
						}
					}

					if(isset($body[$row]["AF"]))
					{
						if($column == "AF"){
							$s_data[$row]["status"] = $data_value;
						}
					}else{
						if(empty($body[$row]["AF"])){
							$s_data[$row]["status"] = '';
						}
					}

					if(isset($body[$row]["AG"]))
					{
						if($column == "AG"){
							$s_data[$row]["location"] = $data_value;
						}
					}else{
						if(empty($body[$row]["AG"])){
							$s_data[$row]["location"] = '';
						}
					}

					if(isset($body[$row]["AH"]))
					{
						if($column == "AH"){
							$s_data[$row]["remarks"] = $data_value;
						}
					}else{
						if(empty($body[$row]["AH"])){
							$s_data[$row]["remarks"] = '';
						}
					}
					if(isset($body[$row]["AI"]))
					{
						if($column == "AI"){
							$s_data[$row]["company"] = $data_value;
						}
					}else{
						if(empty($body[$row]["AI"])){
							$s_data[$row]["company"] = '';
						}
					}
					if(isset($body[$row]["AJ"]))
					{
						if($column == "AJ"){
							if(empty($data_value)){
								$s_data[$row]["whole_sale_period"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["whole_sale_period"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["AJ"])){
							$s_data[$row]["whole_sale_period"] = '';
						}
					}
					if(isset($body[$row]["AK"]))
					{
						if($column == "AK"){
							$s_data[$row]["inv_amt"] = $data_value;
						}
					}else{
						if(empty($body[$row]["AK"])){
							$s_data[$row]["inv_amt"] = '';
						}
					}
				}

				}

			$error_count=0;
			$count_recorded=0;
			$update_count=0;

			foreach ($s_data as $value) {
				$dealer=$value['dealer'];
				$grplica=$value['grp_lica'];
				$grpPlant=$value['grp_plant'];

				if(strlen($dealer) > 0){
					$newdealer=explode(" ",$dealer);
					$count=count($newdealer);

						if($count == 3){
								$brand=$newdealer[0];
								$branch=$newdealer[1].' '.$newdealer[2];
						}else{
								$brand=$newdealer[0];
								$branch=$newdealer[1];
						}

						if(strlen($grplica) > 0){
							$newlica=explode(" ",$grplica);
							$Lcount=count($newlica);
							if($Lcount == 3)
							{
								$Lbrand=$newlica[0];
								$Lbranch=$newlica[1].' '.$newlica[2];
							}else{
								$Lbrand=$newlica[0];
								$Lbranch=$newlica[1];
							}
						}

						if(strlen($grpPlant) > 0){
							$newplant=explode(" ",$grpPlant);
							$Pcount=count($newplant);
							if($Pcount == 3)
							{
								$Pbrand=$newplant[0];
								$Pbranch=$newplant[1].' '.$newplant[2];
							}else{
								$Pbrand=$newplant[0];
								$Pbranch	=$newplant[1];
							}
						}

					$ponum=$value['po_num'];
					$csnum=$value['cs_num'];
					$model=$value['model'];
					$color=$value['color'];

					$searchmodel=$this->Main_m->productS($model);
					$model_id='';
					foreach($searchmodel as $vls)
					{
						$model_id=$vls->id;
					}

					$invoice_num=$value['invoice_num'];
					if($ponum == '')
					{
						echo 'po error';
						die();
					}

					$findealer=$this->Admin_m->find_dealer($brand,$branch);
					$countf=count($findealer);
					if($countf < 1)
					{
						$company_data=array(
							'Company'=>$brand,
							'Branch'=>$branch,
						);
						$this->Admin_m->add_new_dealer($company_data);
					}



					$searchdealer=$this->Admin_m->searchd($brand,$branch);
					$LDealer='';
					if(strlen($grplica) > 0){
						$searchlica=$this->Admin_m->Lsearchd($Lbrand,$Lbranch);
						// print_r();
						$lid='';
						foreach($searchlica as $vls)
						{
							$lid=$vls->id;
						}

						$LDealer=$lid;
					}

					$PDealer='';
					if(strlen($grpPlant) > 0){
						$searchplant=$this->Admin_m->Psearchd($Pbrand,$Pbranch);
						$Pid='';
						foreach($searchplant as $vl)
						{
							$Pid=$vl->id;
						}

						$PDealer=$Pid;
					}
					$did=$searchdealer[0]->id;
					$dealer=$did;

					$countPO=0;
					$countCS=0;


					if(strlen($ponum) > 0)
					{
						$checkPO=$this->Admin_m->check_po_id($ponum);
						$countPO=count($checkPO);
					}else{
						$countPO=0;
					}

					if(strlen($csnum) > 0)
					{
						$checkCSnum=$this->Admin_m->check_cs_num($csnum);
						$countCS=count($checkCSnum);
						$findmodel=$this->Admin_m->find_model($model,$brand);
						$countS=count($findmodel);
						if($countS < 1)
						{
							$error_count++;
							$error_array['Status']=$model.'model not recorded';
							$this->Admin_m->add_error($error_array);
						}else{
							foreach($findmodel as $vls)
							{
								$model_ids=$vls->id;
								$color=$color;
								$search_model_color=$this->Admin_m->searchColor($model_ids,$color);
								if(count($searchmodel) < 1)
								{
									$datas=array('model_id' => $model_ids,'color'=>$value['color']);
									$this->Admin_m->add_model_color($datas);
								}
							}
						}
					}else{
						$countCS=0;
					}

					$checkInvoice=$this->Admin_m->check_inv_num($invoice_num);
					$countINV=count($checkInvoice);

					$id=$_GET['ids'];
					$type=$_GET['type'];

					if($type == 1){

						// DATE ChECKER
							$pr_dateget=$value['plant_release_date'];
							if($pr_dateget == '')
							{
									$pr_date=NULL;
							}else{
									$pr_dateArray= explode('-', $pr_dateget);
									// $pr_date = new DateTime();
									// $pr_date->setDate($pr_dateArray[0],01,$pr_dateArray[1]);
									// $pr_date->setDate(01,$pr_dateArray[0],'20'.$pr_dateArray[1]);
									// $pr_date=date("d-m-Y", strtotime($pr_dateget));
									$pr_date=$value['plant_release_date'];
									// print_r($pr_date);
									// die();
							}


							$sr_dateget=$value['system_release_date'];
							if($sr_dateget == '')
							{
									$sr_date=NULL;
							}else{
									$sr_dateArray= explode('-', $sr_dateget);
									// $sr_date = new DateTime();
									// $sr_date->setDate(01,$sr_dateArray[0],'20'.$sr_dateArray[1]);
									$sr_date=$value['system_release_date'];
							}
							$ar_dateget=$value['actual_release_date'];
							if($ar_dateget == '')
							{
									$ar_date=NULL;
							}else{
									$ar_dateArray= explode('-', $ar_dateget);
									// $ar_date = new DateTime();
									// $ar_date->setDate(01,$ar_dateArray[0],'20'.$ar_dateArray[1]);
									$ar_date=$value['actual_release_date'];
							}
							$po_dateget=$value['po_date'];
							if($po_dateget == '')
							{
									$po_date=NULL;
							}else{
									$po_dateArray= explode('-', $po_dateget);
									// $po_date = new DateTime();
									// $po_date->setDate(01,$po_dateArray[0],'20'.$po_dateArray[1]);
									$po_date=$value['po_date'];
							}
							$paid_dateget=$value['paid_date'];
							if($paid_dateget == '')
							{
									$paid_date=NULL;
							}else{
									$paid_dateArray= explode('-', $paid_date);
									// $po_date = new DateTime();
									// $po_date->setDate(01,$po_dateArray[0],'20'.$po_dateArray[1]);
									$paid_date=$value['paid_date'];
							}
							$posted_dateget=$value['posted_date'];
							if($posted_dateget == '')
							{
									$posted_date=NULL;
							}else{
									$posted_dateArray= explode('-', $posted_dateget);
									// $posted_date = new DateTime();
									// $posted_date->setDate(01,$posted_dateArray[0],'20'.$posted_dateArray[1]);
									$posted_date=$value['posted_date'];
							}
							$veh_receivedget=$value['veh_received'];
							if($veh_receivedget == '')
							{
									$veh_received=NULL;
							}else{
									$veh_receivedArray= explode('-', $veh_receivedget);
									// $veh_received = new DateTime();
									// $veh_received->setDate(01,$veh_receivedArray[0],'20'.$veh_receivedArray[1]);
									$veh_received=$value['veh_received'];
							}
							$csr_receivedget=$value['csr_received'];
							if($csr_receivedget == '')
							{
									$csr_received=NULL;
							}else{
									$csr_receivedArray= explode('-', $csr_receivedget);
									// $csr_received = new DateTime();
									// $csr_received->setDate(01,$csr_receivedArray[0],'20'.$csr_receivedArray[1]);
									$csr_received=$value['csr_received'];
							}
							$alloc_dateget=$value['alloc_date'];
							if($alloc_dateget == '')
							{
									$alloc_date=NULL;
							}else{
									$alloc_dateArray= explode('-', $alloc_dateget);
									// $alloc_date = new DateTime();
									// $alloc_date->setDate(01,$alloc_dateArray[0],'20'.$alloc_dateArray[1]);
									$alloc_date=$value['alloc_date'];
							}
							$invoice_dateget=$value['invoice_date'];
							if($invoice_dateget == '')
							{
									$invoice_date=NULL;
							}else{
									$invoice_dateArray= explode('-', $invoice_dateget);
									// $invoice_date = new DateTime();
									// $invoice_date->setDate(01,$invoice_dateArray[0],'20'.$invoice_dateArray[1]);
									$invoice_date=$value['invoice_date'];
							}
						// DATE ChECKER END
						$error_array=array(
							'po_num'=>$ponum,
							'po_date'=>$po_date,
							'dealer'=>$dealer,
							'whole_sale_period'=>$value['whole_sale_period'],
							'has_vehicle'=>1,
							'cs_num'=>$value['cs_num'],
							'model'=>$model_id,
							'model_yr'=>$value['model_yr'],
							'location'=>$value['location'],
							'purchase_order'=>$ponum,
							'vrr_num'=>$value['vrr_num'],
							'color'=>$value['color'],
							'prod_num'=>$value['prod_num'],
							'vin_num'=>$value['vin_num'],
							'paid_date'=>$paid_date,
							'posted_date'=>$posted_date,
							'subsidy'=>$value['subsidy'],
							'veh_received'=>$veh_received,
							'csr_received'=>$csr_received,
							'engine_num'=>$value['engine_num'],
							'cost'=>$value['cost'],
							'pay_amt'=>$value['inv_amt'],
							'vehicle_id'=>$value['cs_num'],
							'first_name' => $value['first_name'],
							'middle_name' => $value['middle_name'],
							'last_name' => $value['last_name'],
							'alloc_date' => $alloc_date,
							'salesperson' => $value['sales_person'],
							'invoice_date' => $invoice_date,
							'invoice_num' => $value['invoice_num'],
							'company' => $value['company'],
							'term' => $value['term'],
							'bank' => $value['bank'],
							'grp_lica' => $LDealer,
							'grp_plant' => $PDealer,
							'actual_release_date' => $ar_dateget,
							'plant_release_date' => $pr_dateget,
							'system_release_date' => $sr_dateget,
							'remarks' => $value['remarks'],
							'added_by'=>$_GET['id']
						);



						if($countPO > 0){

							if($countCS > 0)
							{
									$error_array['Status']='Has same p.o and c,s number';
									$this->Admin_m->add_error($error_array);
									$error_count++;
							}else{
								$error_array['Status']='Has same p.o number';
								$this->Admin_m->add_error($error_array);
								$error_count++;
							}

						}else{

							if($countCS > 0)
							{
									$error_array['Status']='Has same c,s number';
									$this->Admin_m->add_error($error_array);
									$error_count++;
							}else{

									$error_array['Status']='Clear';

												if(strlen($csnum) > 0){
													$po_array=array(
														'po_num'=>strtoupper($ponum),
														'po_date'=>$po_date,
														'dealer'=>$dealer,
														'model'=>$model_id,
														'model_yr'=>$value['model_yr'],
														'color'=>strtoupper($value['color']),
														'cost'=>$value['cost'],
														'added_by'=>$_GET['id'],
														'whole_sale_period'=>$value['whole_sale_period'],
														'has_vehicle'=>1,
														'conf_order'=>0,
														'deleted'=>0
													);

													$last_id=$this->Admin_m->insert_po($po_array);
													$v_array=array(
														'cs_num'=>strtoupper($value['cs_num']),
														'model'=>$model_id,
														'model_yr'=>$value['model_yr'],
														'location'=>strtoupper($value['location']),
														'purchase_order'=>$last_id,
														'vrr_num'=>strtoupper($value['vrr_num']),
														'color'=>strtoupper($value['color']),
														'prod_num'=>strtoupper($value['prod_num']),
														'vin_num'=>strtoupper($value['vin_num']),
														'paid_date'=>$paid_date,
														'posted_date'=>$posted_date,
														'subsidy'=>strtoupper($value['subsidy']),
														'veh_received'=>$veh_received,
														'csr_received'=>$csr_received,
														'engine_num'=>strtoupper($value['engine_num']),
														'cost'=>$value['cost'],
														'remarks'=>strtoupper($value['remarks']),
														'added_by'=>$_GET['id'],
														'deleted'=>0
													);
													$last_id2=$this->Admin_m->insert_vehicle($v_array);
													$inv_array=array(
														'vehicle_id'=>$last_id2,
														'first_name' => strtoupper($value['first_name']),
														'middle_name' => strtoupper($value['middle_name']),
														'last_name' => strtoupper($value['last_name']),
														'alloc_date' => $alloc_date,
														'salesperson' => strtoupper($value['sales_person']),
														'invoice_date' =>$invoice_date,
														'invoice_num' => strtoupper($value['invoice_num']),
														'pay_amt'=>$value['inv_amt'],
														'company' => strtoupper($value['company']),
														'term' => strtoupper($value['term']),
														'bank' => strtoupper($value['bank']),
														'grp_lica' => strtoupper($LDealer),
														'grp_plant' => strtoupper($PDealer),
														'actual_release_date' => $ar_date,
														'plant_release_date' => $pr_dateget,
														'system_release_date' => $sr_dateget,
														'remarks' => strtoupper($value['remarks']),
														'added_by'=>$_GET['id']
													);
													$this->Admin_m->insert_invoice($inv_array);
													$status='';
													if(!$value['veh_received'])
													{
														$status='For Pull Out';
													}else if((!$value['alloc_date']) AND (!$value['invoice_num']) AND (!$value['actual_release_date']))
													{
														$status='Available';
													}else if((!$value['invoice_num']) AND (!$value['actual_release_date']))
													{
														$status='Allocated';
													}else if(!$value['actual_release_date'])
													{
														$status='Invoiced';
													}else{
														$status='Released';
													}
													$updata=array(
																'po_id'=>$last_id,
																'cs_num' =>strtoupper($value['cs_num']),
																'inv_num' =>strtoupper($value['invoice_num']),
																'status' => $status
															);

															$test=$this->Admin_m->insertStatus($updata);
														$this->Admin_m->add_error($error_array);
													$count_recorded++;
												}else{
													$po_array=array(
														'po_num'=>strtoupper($ponum),
														'po_date'=>$po_date,
														'dealer'=>$dealer,
														'model'=>$model_id,
														'model_yr'=>$value['model_yr'],
														'color'=>strtoupper($value['color']),
														'cost'=>$value['cost'],
														'added_by'=>$_GET['id'],
														'whole_sale_period'=>$value['whole_sale_period'],
														'has_vehicle'=>0,
														'conf_order'=>0,
														'deleted'=>0
													);
													$last_id=$this->Admin_m->insert_po($po_array);
													$status='No Vehicle';
													$updata=array(
																'po_id'=>$last_id,
																'cs_num' =>strtoupper($value['cs_num']),
																'inv_num' =>strtoupper($value['invoice_num']),
																'status' => $status
															);

															$test=$this->Admin_m->insertStatus($updata);
														$this->Admin_m->add_error($error_array);
													$count_recorded++;
												}
							}
						}
					}else{
						// DATE ChECKER
							$pr_dateget=$value['plant_release_date'];
							if($pr_dateget == '')
							{
									$pr_date=NULL;
							}else{
									$pr_dateArray= explode('-', $pr_dateget);
									// $pr_date = new DateTime();
									// $pr_date->setDate($pr_dateArray[0],01,$pr_dateArray[1]);
									// $pr_date->setDate(01,$pr_dateArray[0],'20'.$pr_dateArray[1]);
									// $pr_date=date("d-m-Y", strtotime($pr_dateget));
									$pr_date=$value['plant_release_date'];
									// print_r($pr_date);
									// die();
							}


							$sr_dateget=$value['system_release_date'];
							if($sr_dateget == '')
							{
									$sr_date=NULL;
							}else{
									$sr_dateArray= explode('-', $sr_dateget);
									// $sr_date = new DateTime();
									// $sr_date->setDate(01,$sr_dateArray[0],'20'.$sr_dateArray[1]);
									$sr_date=$value['system_release_date'];
							}
							$ar_dateget=$value['actual_release_date'];
							if($ar_dateget == '')
							{
									$ar_date=NULL;
							}else{
									$ar_dateArray= explode('-', $ar_dateget);
									// $ar_date = new DateTime();
									// $ar_date->setDate(01,$ar_dateArray[0],'20'.$ar_dateArray[1]);
									$ar_date=$value['actual_release_date'];
							}
							$po_dateget=$value['po_date'];
							if($po_dateget == '')
							{
									$po_date=NULL;
							}else{
									$po_dateArray= explode('-', $po_dateget);
									// $po_date = new DateTime();
									// $po_date->setDate(01,$po_dateArray[0],'20'.$po_dateArray[1]);
									$po_date=$value['po_date'];
							}
							$paid_dateget=$value['paid_date'];
							if($paid_dateget == '')
							{
									$paid_date=NULL;
							}else{
									$paid_dateeArray= explode('-', $paid_dateget);
									// $paid_date = new DateTime();
									// $paid_date->setDate(01,$paid_dateeArray[0],'20'.$paid_dateeArray[1]);
									$paid_date=$value['paid_date'];
							}
							$posted_dateget=$value['posted_date'];
							if($posted_dateget == '')
							{
									$posted_date=NULL;
							}else{
									$posted_dateArray= explode('-', $posted_dateget);
									// $posted_date = new DateTime();
									// $posted_date->setDate(01,$posted_dateArray[0],'20'.$posted_dateArray[1]);
									$posted_date=$value['posted_date'];
							}
							$veh_receivedget=$value['veh_received'];
							if($veh_receivedget == '')
							{
									$veh_received=NULL;
							}else{
									$veh_receivedArray= explode('-', $veh_receivedget);
									// $veh_received = new DateTime();
									// $veh_received->setDate(01,$veh_receivedArray[0],'20'.$veh_receivedArray[1]);
									$veh_received=$value['veh_received'];
							}
							$csr_receivedget=$value['csr_received'];
							if($csr_receivedget == '')
							{
									$csr_received=NULL;
							}else{
									$csr_receivedArray= explode('-', $csr_receivedget);
									// $csr_received = new DateTime();
									// $csr_received->setDate(01,$csr_receivedArray[0],'20'.$csr_receivedArray[1]);
									$csr_received=$value['csr_received'];
							}
							$alloc_dateget=$value['alloc_date'];
							if($alloc_dateget == '')
							{
									$alloc_date=NULL;
							}else{
									$alloc_dateArray= explode('-', $alloc_dateget);
									// $alloc_date = new DateTime();
									// $alloc_date->setDate(01,$alloc_dateArray[0],'20'.$alloc_dateArray[1]);
									$alloc_date=$value['alloc_date'];
							}
							$invoice_dateget=$value['invoice_date'];
							if($invoice_dateget == '')
							{
									$invoice_date=NULL;
							}else{
									$invoice_dateArray= explode('-', $invoice_dateget);
									// $invoice_date = new DateTime();
									// $invoice_date->setDate(01,$invoice_dateArray[0],'20'.$invoice_dateArray[1]);
									$invoice_date=$value['invoice_date'];
							}
						// DATE ChECKER END
						$error_array=array(
							'po_num'=>$ponum,
							'po_date'=>$po_date,
							'dealer'=>$dealer,
							'whole_sale_period'=>$value['whole_sale_period'],
							'has_vehicle'=>1,
							'cs_num'=>$value['cs_num'],
							'model'=>$model_id,
							'model_yr'=>$value['model_yr'],
							'location'=>$value['location'],
							'purchase_order'=>$ponum,
							'vrr_num'=>$value['vrr_num'],
							'color'=>$value['color'],
							'prod_num'=>$value['prod_num'],
							'vin_num'=>$value['vin_num'],
							'paid_date'=>$paid_date,
							'posted_date'=>$posted_date,
							'subsidy'=>$value['subsidy'],
							'veh_received'=>$veh_received,
							'csr_received'=>$csr_received,
							'engine_num'=>$value['engine_num'],
							'cost'=>$value['cost'],
							'pay_amt'=>$value['inv_amt'],
							'vehicle_id'=>$value['cs_num'],
							'first_name' => $value['first_name'],
							'middle_name' => $value['middle_name'],
							'last_name' => $value['last_name'],
							'alloc_date' => $alloc_date,
							'salesperson' => $value['sales_person'],
							'invoice_date' => $invoice_date,
							'invoice_num' => $value['invoice_num'],
							'company' => $value['company'],
							'term' => $value['term'],
							'bank' => $value['bank'],
							'grp_lica' => $LDealer,
							'grp_plant' => $PDealer,
							'actual_release_date' => $ar_dateget,
							'plant_release_date' => $pr_dateget,
							'system_release_date' => $sr_dateget,
							'remarks' => $value['remarks'],
							'added_by'=>$_GET['id']
						);
						$access=$this->Main_m->m_access($id);
						foreach ($access as $acc) {
							$dealers=$acc->key;

							if($dealers == $brand)
							{
								if($countPO > 0){
									if($countCS > 0)
									{

											$error_array['Status']='Has same p.o and c,s number';
											$this->Admin_m->add_error($error_array);
											$error_count++;
									}else{
										$error_array['Status']='Has same p.o number';
										$this->Admin_m->add_error($error_array);
										$error_count++;
									}
								}else{
									if($countCS > 0)
									{

											$error_array['Status']='Has same c,s number';
											$this->Admin_m->add_error($error_array);
											$error_count++;
									}else{
											$error_array['Status']='Clear';
													if(strlen($csnum) > 0){
														$po_array=array(
															'po_num'=>strtoupper($ponum),
															'po_date'=>$po_date,
															'dealer'=>$dealer,
															'model'=>$model_id,
															'model_yr'=>$value['model_yr'],
															'color'=>strtoupper($value['color']),
															'cost'=>$value['cost'],
															'added_by'=>$_GET['id'],
															'whole_sale_period'=>$value['whole_sale_period'],
															'has_vehicle'=>1,
															'conf_order'=>0,
															'deleted'=>0
														);

														$last_id=$this->Admin_m->insert_po($po_array);
														$v_array=array(
															'cs_num'=>strtoupper($value['cs_num']),
															'model'=>$model_id,
															'model_yr'=>$value['model_yr'],
															'location'=>strtoupper($value['location']),
															'purchase_order'=>$last_id,
															'vrr_num'=>strtoupper($value['vrr_num']),
															'color'=>strtoupper($value['color']),
															'prod_num'=>strtoupper($value['prod_num']),
															'vin_num'=>strtoupper($value['vin_num']),
															'paid_date'=>$paid_date,
															'posted_date'=>$posted_date,
															'subsidy'=>strtoupper($value['subsidy']),
															'veh_received'=>$veh_received,
															'csr_received'=>$csr_received,
															'engine_num'=>strtoupper($value['engine_num']),
															'cost'=>$value['cost'],
															'remarks'=>strtoupper($value['remarks']),
															'added_by'=>$_GET['id'],
															'deleted'=>0
														);
														$last_id2=$this->Admin_m->insert_vehicle($v_array);
														$inv_array=array(
															'vehicle_id'=>$last_id2,
															'first_name' => strtoupper($value['first_name']),
															'middle_name' => strtoupper($value['middle_name']),
															'last_name' => strtoupper($value['last_name']),
															'alloc_date' => $alloc_date,
															'salesperson' => strtoupper($value['sales_person']),
															'invoice_date' =>$invoice_date,
															'invoice_num' => strtoupper($value['invoice_num']),
															'pay_amt'=>$value['inv_amt'],
															'company' => strtoupper($value['company']),
															'term' => strtoupper($value['term']),
															'bank' => strtoupper($value['bank']),
															'grp_lica' => strtoupper($LDealer),
															'grp_plant' => strtoupper($PDealer),
															'actual_release_date' => $ar_date,
															'plant_release_date' => $pr_dateget,
															'system_release_date' => $sr_dateget,
															'remarks' => strtoupper($value['remarks']),
															'added_by'=>$_GET['id']
														);
														$this->Admin_m->insert_invoice($inv_array);
														$status='';
														if(!$value['veh_received'])
														{
															$status='For Pull Out';
														}else if((!$value['alloc_date']) AND (!$value['invoice_num']) AND (!$value['actual_release_date']))
														{
															$status='Available';
														}else if((!$value['invoice_num']) AND (!$value['actual_release_date']))
														{
															$status='Allocated';
														}else if(!$value['actual_release_date'])
														{
															$status='Invoiced';
														}else{
															$status='Released';
														}
														$updata=array(
																	'po_id'=>$last_id,
																	'cs_num' =>strtoupper($value['cs_num']),
																	'inv_num' =>strtoupper($value['invoice_num']),
																	'status' => $status
																);

																$test=$this->Admin_m->insertStatus($updata);
															$this->Admin_m->add_error($error_array);
														$count_recorded++;
													}else{
														$po_array=array(
															'po_num'=>strtoupper($ponum),
															'po_date'=>$value['po_date'],
															'dealer'=>$dealer,
															'model'=>$model_id,
															'model_yr'=>$value['model_yr'],
															'color'=>strtoupper($value['color']),
															'cost'=>$value['cost'],
															'added_by'=>$_GET['id'],
															'whole_sale_period'=>$value['whole_sale_period'],
															'has_vehicle'=>0,
															'conf_order'=>0,
															'deleted'=>0
														);
														$last_id=$this->Admin_m->insert_po($po_array);
														$status='No Vehicle';
														$updata=array(
																	'po_id'=>$last_id,
																	'cs_num' =>strtoupper($value['cs_num']),
																	'inv_num' =>strtoupper($value['invoice_num']),
																	'status' => $status
																);

																$test=$this->Admin_m->insertStatus($updata);
															$this->Admin_m->add_error($error_array);
														$count_recorded++;
													}
									}
								}
							}else{
								$error_count++;
								$error_array['Status']='Dealer / Brand not recorded';
								$error_count++;
								$this->Admin_m->add_error($error_array);
							}

						}
					}
				}else{
					// $error_count++;

				}
			}
			echo "Total Count Import Successful = ".$count_recorded;
			echo "<br/>Total Count Import Unsuccessful = ".$error_count;

}

	function do_upload3()
	{
		$this->load->library('upload');

		$files = $_FILES;
		// print_r($_FILES);
		// die();

			$_FILES['userfile']['name']= $files['userfile']['name'];
			$_FILES['userfile']['type']= $files['userfile']['type'];
			$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'];
			$_FILES['userfile']['error']= $files['userfile']['error'];
			$_FILES['userfile']['size']= $files['userfile']['size'];

			$file = preg_replace('/\s+/', '_',$this->set_upload_options()['upload_path'].$files['userfile']['name']);

			$this->upload->initialize($this->set_upload_options());
			$this->upload->do_upload();

			$objPHPExcel = PHPExcel_IOFactory::load($file);

			unlink($file);
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			foreach ( $cell_collection as $cell) {
					$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
					$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
					$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

					if ($row == 1) {
						$header[$row][$column] = $data_value;

					}else{

						$body[$row][$column] = $data_value;

						if(isset($body[$row]["A"]))
						{
							if($column == "A"){
								$s_data[$row]["first_name"] = $data_value;
							}
						}else{
							if(empty($body[$row]["A"])){
								$s_data[$row]["first_name"] = '';
							}
						}

						if(isset($body[$row]["B"]))
						{
							if($column == "B"){
								$s_data[$row]["middle_name"] = $data_value;
							}
						}else{
							if(empty($body[$row]["B"])){
								$s_data[$row]["middle_name"] = '';
							}
						}

						if(isset($body[$row]["C"]))
						{
							if($column == "C"){
								$s_data[$row]["last_name"] = $data_value;
							}
						}else{
							if(empty($body[$row]["C"])){
								$s_data[$row]["last_name"] = '';
							}
						}
						if(isset($body[$row]["D"]))
						{
							if($column == "D"){
								$s_data[$row]["cs_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["D"])){
								$s_data[$row]["cs_num"] = '';
							}
						}

						if(isset($body[$row]["E"]))
						{
							if($column == "E"){
								$s_data[$row]["model"] = $data_value;
							}
						}else{
							if(empty($body[$row]["E"])){
								$s_data[$row]["model"] = '';
							}
						}

						if(isset($body[$row]["F"]))
						{
							if($column == "F"){
								$s_data[$row]["color"] = $data_value;
							}
						}else{
							if(empty($body[$row]["F"])){
								$s_data[$row]["color"] = '';
							}
						}

						if(isset($body[$row]["G"]))
						{
							if($column == "G"){
								$s_data[$row]["prod_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["G"])){
								$s_data[$row]["prod_num"] = '';
							}
						}

						if(isset($body[$row]["H"]))
						{
							if($column == "H"){
								$s_data[$row]["engine_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["H"])){
								$s_data[$row]["engine_num"] = '';
							}
						}

						if(isset($body[$row]["I"]))
						{
							if($column == "I"){
								$s_data[$row]["vin_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["I"])){
								$s_data[$row]["vin_num"] = '';
							}
						}

						if(isset($body[$row]["J"]))
						{
							if($column == "J"){
								$s_data[$row]["model_yr"] = $data_value;
							}
						}else{
							if(empty($body[$row]["J"])){
								$s_data[$row]["model_yr"] = '';
							}
						}

						if(isset($body[$row]["K"]))
						{
							if($column == "K"){
								$s_data[$row]["dealer"] = $data_value;
							}
						}else{
							if(empty($body[$row]["K"])){
								$s_data[$row]["dealer"] = '';
							}
						}

						if(isset($body[$row]["L"]))
						{
							if($column == "L"){
								$s_data[$row]["po_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["L"])){
								$s_data[$row]["po_num"] = '';
							}
						}

						if(isset($body[$row]["M"]))
						{
							if($column == "M"){
								$s_data[$row]["po_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["M"])){
								$s_data[$row]["po_date"] = '';
							}
						}

						if(isset($body[$row]["N"]))
						{
							if($column == "N"){
								$s_data[$row]["paid_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["N"])){
								$s_data[$row]["paid_date"] = '';
							}
						}

						if(isset($body[$row]["O"]))
						{
							if($column == "O"){
								$s_data[$row]["posted_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["O"])){
								$s_data[$row]["posted_date"] = '';
							}
						}

						if(isset($body[$row]["P"]))
						{
							if($column == "P"){
								$s_data[$row]["subsidy"] = $data_value;
							}
						}else{
							if(empty($body[$row]["P"])){
								$s_data[$row]["subsidy"] = '';
							}
						}

						if(isset($body[$row]["Q"]))
						{
							if($column == "Q"){
								$s_data[$row]["cost"] = $data_value;
							}
						}else{
							if(empty($body[$row]["Q"])){
								$s_data[$row]["cost"] = '';
							}
						}

						if(isset($body[$row]["R"]))
						{
							if($column == "R"){
								$s_data[$row]["term"] = $data_value;
							}
						}else{
							if(empty($body[$row]["R"])){
								$s_data[$row]["term"] = '';
							}
						}

						if(isset($body[$row]["S"]))
						{
							if($column == "S"){
								$s_data[$row]["bank"] = $data_value;
							}
						}else{
							if(empty($body[$row]["S"])){
								$s_data[$row]["bank"] = '';
							}
						}

						if(isset($body[$row]["T"]))
						{
							if($column == "T"){
								$s_data[$row]["vrr_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["T"])){
								$s_data[$row]["vrr_num"] = '';
							}
						}

						if(isset($body[$row]["U"]))
						{
							if($column == "U"){
								$s_data[$row]["veh_received"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["U"])){
								$s_data[$row]["veh_received"] = '';
							}
						}

						if(isset($body[$row]["V"]))
						{
							if($column == "V"){
								$s_data[$row]["csr_received"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["V"])){
								$s_data[$row]["csr_received"] = '';
							}
						}

						if(isset($body[$row]["W"]))
						{
							if($column == "W"){
								$s_data[$row]["alloc_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["W"])){
								$s_data[$row]["alloc_date"] = '';
							}
						}

						if(isset($body[$row]["X"]))
						{
							if($column == "X"){
								$s_data[$row]["sales_person"] = $data_value;
							}
						}else{
							if(empty($body[$row]["X"])){
								$s_data[$row]["sales_person"] = '';
							}
						}

						if(isset($body[$row]["Y"]))
						{
							if($column == "Y"){
								$s_data[$row]["grp_lica"] = $data_value;
							}
						}else{
							if(empty($body[$row]["Y"])){
								$s_data[$row]["grp_lica"] = '';
							}
						}

						if(isset($body[$row]["Z"]))
						{
							if($column == "Z"){
								$s_data[$row]["grp_plant"] = $data_value;
							}
						}else{
							if(empty($body[$row]["Z"])){
								$s_data[$row]["grp_plant"] = '';
							}
						}

						if(isset($body[$row]["AA"]))
						{
							if($column == "AA"){
								$s_data[$row]["invoice_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["AA"])){
								$s_data[$row]["invoice_date"] = '';
							}
						}

						if(isset($body[$row]["AB"]))
						{
							if($column == "AB"){
								$s_data[$row]["invoice_num"] = $data_value;
							}
						}else{
							if(empty($body[$row]["AB"])){
								$s_data[$row]["invoice_num"] = '';
							}
						}

						if(isset($body[$row]["AC"]))
						{
							if($column == "AC"){
								$s_data[$row]["actual_release_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["AC"])){
								$s_data[$row]["actual_release_date"] = '';
							}
						}

						if(isset($body[$row]["AD"]))
						{
							if($column == "AD"){
								$s_data[$row]["system_release_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["AD"])){
								$s_data[$row]["system_release_date"] = '';
							}
						}

						if(isset($body[$row]["AE"]))
						{
							if($column == "AE"){
								$s_data[$row]["plant_release_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["AE"])){
								$s_data[$row]["plant_release_date"] = '';
							}
						}

						if(isset($body[$row]["AF"]))
						{
							if($column == "AF"){
								$s_data[$row]["status"] = $data_value;
							}
						}else{
							if(empty($body[$row]["AF"])){
								$s_data[$row]["status"] = '';
							}
						}

						if(isset($body[$row]["AG"]))
						{
							if($column == "AG"){
								$s_data[$row]["location"] = $data_value;
							}
						}else{
							if(empty($body[$row]["AG"])){
								$s_data[$row]["location"] = '';
							}
						}

						if(isset($body[$row]["AH"]))
						{
							if($column == "AH"){
								$s_data[$row]["remarks"] = $data_value;
							}
						}else{
							if(empty($body[$row]["AH"])){
								$s_data[$row]["remarks"] = '';
							}
						}
						if(isset($body[$row]["AI"]))
						{
							if($column == "AI"){
								$s_data[$row]["company"] = $data_value;
							}
						}else{
							if(empty($body[$row]["AI"])){
								$s_data[$row]["company"] = '';
							}
						}
						if(isset($body[$row]["AJ"]))
						{
							if($column == "AJ"){
								$s_data[$row]["whole_sale_period"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($data_value));
							}
						}else{
							if(empty($body[$row]["AJ"])){
								$s_data[$row]["whole_sale_period"] = '';
							}
						}
					}

				}

				$same=0;
				$notsame=0;
				$count=0;
			// foreach ($s_data as $value) {
			// 	$ponum=$value['po_num'];
			// 	$csnum=$value['cs_num'];
			// 	if($ponum != '')
			// 	{
			// 		foreach($s_data as $vls)
			// 		{
			// 			if($ponum == $vls['po_num'] and $csnum== $vls['cs_num'])
			// 			{
			// 				$same++;
			// 			}else{
			// 				$notsame++;
			// 			}
			// 				$count++;
			// 		}
			// 	}
			//
			// 	// $ponum=$value['po_num'];
			// 	// $csnum=$value['cs_num'];
			// 	// foreach($s_data as $vls)
			// 	// {
			// 	// 	if($ponum == $vls['po_num'] and $csnum== $vls['cs_num'])
			// 	// 	{
			// 	// 		$same++;
			// 	// 	}else{
			// 	// 		$notsame++;
			// 	// 	}
			// 	// }
			// }
			 // return array_unique(array_diff_assoc($s_data,array_unique($s_data)));
			// $newarray=array_diff_assoc($s_data, array_unique($s_data));
			echo '<pre>';
			// print_r(array_unique($s_data, SORT_REGULAR));
			$unique=array();

			foreach($s_data as $value)
			{
				$unique[$value['po_num']]=$value;
			}
			$data['uniquepo']=array_values($unique);
			print_r($data);
			// echo $same;
	}
	function do_upload4()
	{
		$this->load->library('upload');

		$files = $_FILES;
		// print_r($_FILES);
		// die();

		$_FILES['userfile']['name']= $files['userfile']['name'];
		$_FILES['userfile']['type']= $files['userfile']['type'];
		$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'];
		$_FILES['userfile']['error']= $files['userfile']['error'];
		$_FILES['userfile']['size']= $files['userfile']['size'];

		$file = preg_replace('/\s+/', '_',$this->set_upload_options()['upload_path'].$files['userfile']['name']);

		$this->upload->initialize($this->set_upload_options());
		$this->upload->do_upload();
			// echo $file;




			$objPHPExcel = PHPExcel_IOFactory::load($file);

			unlink($file);
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			foreach ( $cell_collection as $cell) {
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

				if ($row == 1) {
					$header[$row][$column] = $data_value;

				}else{

					$body[$row][$column] = $data_value;

					if(isset($body[$row]["A"]))
					{
						if($column == "A"){
							$s_data[$row]["first_name"] = $data_value;
						}
					}else{
						if(empty($body[$row]["A"])){
							$s_data[$row]["first_name"] = '';
						}
					}

					if(isset($body[$row]["B"]))
					{
						if($column == "B"){
							$s_data[$row]["middle_name"] = $data_value;
						}
					}else{
						if(empty($body[$row]["B"])){
							$s_data[$row]["middle_name"] = '';
						}
					}

					if(isset($body[$row]["C"]))
					{
						if($column == "C"){
							$s_data[$row]["last_name"] = $data_value;
						}
					}else{
						if(empty($body[$row]["C"])){
							$s_data[$row]["last_name"] = '';
						}
					}
					if(isset($body[$row]["D"]))
					{
						if($column == "D"){
							$s_data[$row]["cs_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["D"])){
							$s_data[$row]["cs_num"] = '';
						}
					}

					if(isset($body[$row]["E"]))
					{
						if($column == "E"){
							$s_data[$row]["model"] = $data_value;
						}
					}else{
						if(empty($body[$row]["E"])){
							$s_data[$row]["model"] = '';
						}
					}

					if(isset($body[$row]["F"]))
					{
						if($column == "F"){
							$s_data[$row]["color"] = $data_value;
						}
					}else{
						if(empty($body[$row]["F"])){
							$s_data[$row]["color"] = '';
						}
					}

					if(isset($body[$row]["G"]))
					{
						if($column == "G"){
							$s_data[$row]["prod_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["G"])){
							$s_data[$row]["prod_num"] = '';
						}
					}

					if(isset($body[$row]["H"]))
					{
						if($column == "H"){
							$s_data[$row]["engine_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["H"])){
							$s_data[$row]["engine_num"] = '';
						}
					}

					if(isset($body[$row]["I"]))
					{
						if($column == "I"){
							$s_data[$row]["vin_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["I"])){
							$s_data[$row]["vin_num"] = '';
						}
					}

					if(isset($body[$row]["J"]))
					{
						if($column == "J"){
							$s_data[$row]["model_yr"] = $data_value;
						}
					}else{
						if(empty($body[$row]["J"])){
							$s_data[$row]["model_yr"] = '';
						}
					}

					if(isset($body[$row]["K"]))
					{
						if($column == "K"){
							$s_data[$row]["dealer"] = $data_value;
						}
					}else{
						if(empty($body[$row]["K"])){
							$s_data[$row]["dealer"] = '';
						}
					}

					if(isset($body[$row]["L"]))
					{
						if($column == "L"){
							$s_data[$row]["po_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["L"])){
							$s_data[$row]["po_num"] = '';
						}
					}

					if(isset($body[$row]["M"]))
					{
						if($column == "M"){
							if(empty($data_value)){
								$s_data[$row]["po_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["po_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["M"])){
							$s_data[$row]["po_date"] = '';
						}
					}

					if(isset($body[$row]["N"]))
					{
						if($column == "N"){
							if(empty($data_value)){
								$s_data[$row]["paid_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["paid_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["N"])){
							$s_data[$row]["paid_date"] = '';
						}
					}

					if(isset($body[$row]["O"]))
					{
						if($column == "O"){
							if(empty($data_value)){
								$s_data[$row]["posted_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["posted_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["O"])){
							$s_data[$row]["posted_date"] = '';
						}
					}

					if(isset($body[$row]["P"]))
					{
						if($column == "P"){
							$s_data[$row]["subsidy"] = $data_value;
						}
					}else{
						if(empty($body[$row]["P"])){
							$s_data[$row]["subsidy"] = '';
						}
					}

					if(isset($body[$row]["Q"]))
					{
						if($column == "Q"){
							$s_data[$row]["cost"] = $data_value;
						}
					}else{
						if(empty($body[$row]["Q"])){
							$s_data[$row]["cost"] = '';
						}
					}

					if(isset($body[$row]["R"]))
					{
						if($column == "R"){
							$s_data[$row]["term"] = $data_value;
						}
					}else{
						if(empty($body[$row]["R"])){
							$s_data[$row]["term"] = '';
						}
					}

					if(isset($body[$row]["S"]))
					{
						if($column == "S"){
							$s_data[$row]["bank"] = $data_value;
						}
					}else{
						if(empty($body[$row]["S"])){
							$s_data[$row]["bank"] = '';
						}
					}

					if(isset($body[$row]["T"]))
					{
						if($column == "T"){
							$s_data[$row]["vrr_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["T"])){
							$s_data[$row]["vrr_num"] = '';
						}
					}

					if(isset($body[$row]["U"]))
					{
						if($column == "U"){
							if(empty($data_value)){
								$s_data[$row]["veh_received"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
								$s_data[$row]["veh_received"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["U"])){
							$s_data[$row]["veh_received"] = '';
						}
					}

					if(isset($body[$row]["V"]))
					{
						if($column == "V"){
							if(empty($data_value)){
								$s_data[$row]["csr_received"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["csr_received"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["V"])){
							$s_data[$row]["csr_received"] = '';
						}
					}

					if(isset($body[$row]["W"]))
					{
						if($column == "W"){
							if(empty($data_value)){
								$s_data[$row]["alloc_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["alloc_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["W"])){
							$s_data[$row]["alloc_date"] = '';
						}
					}

					if(isset($body[$row]["X"]))
					{
						if($column == "X"){
							$s_data[$row]["sales_person"] = $data_value;
						}
					}else{
						if(empty($body[$row]["X"])){
							$s_data[$row]["sales_person"] = '';
						}
					}

					if(isset($body[$row]["Y"]))
					{
						if($column == "Y"){
							$s_data[$row]["grp_lica"] = $data_value;
						}
					}else{
						if(empty($body[$row]["Y"])){
							$s_data[$row]["grp_lica"] = '';
						}
					}

					if(isset($body[$row]["Z"]))
					{
						if($column == "Z"){
							$s_data[$row]["grp_plant"] = $data_value;
						}
					}else{
						if(empty($body[$row]["Z"])){
							$s_data[$row]["grp_plant"] = '';
						}
					}

					if(isset($body[$row]["AA"]))
					{
						if($column == "AA"){
							if(empty($data_value)){
								$s_data[$row]["invoice_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["invoice_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["AA"])){
							$s_data[$row]["invoice_date"] = '';
						}
					}

					if(isset($body[$row]["AB"]))
					{
						if($column == "AB"){
							$s_data[$row]["invoice_num"] = $data_value;
						}
					}else{
						if(empty($body[$row]["AB"])){
							$s_data[$row]["invoice_num"] = '';
						}
					}

					if(isset($body[$row]["AC"]))
					{
						if($column == "AC"){
							if(empty($data_value)){
								$s_data[$row]["actual_release_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["actual_release_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["AC"])){
							$s_data[$row]["actual_release_date"] = '';
						}
					}

					if(isset($body[$row]["AD"]))
					{
						if($column == "AD"){
							if(empty($data_value)){
								$s_data[$row]["system_release_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["system_release_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["AD"])){
							$s_data[$row]["system_release_date"] = '';
						}
					}

					if(isset($body[$row]["AE"]))
					{
						if($column == "AE"){
							if(empty($data_value)){
								$s_data[$row]["plant_release_date"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["plant_release_date"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["AE"])){
							$s_data[$row]["plant_release_date"] = '';
						}
					}

					if(isset($body[$row]["AF"]))
					{
						if($column == "AF"){
							$s_data[$row]["status"] = $data_value;
						}
					}else{
						if(empty($body[$row]["AF"])){
							$s_data[$row]["status"] = '';
						}
					}

					if(isset($body[$row]["AG"]))
					{
						if($column == "AG"){
							$s_data[$row]["location"] = $data_value;
						}
					}else{
						if(empty($body[$row]["AG"])){
							$s_data[$row]["location"] = '';
						}
					}

					if(isset($body[$row]["AH"]))
					{
						if($column == "AH"){
							$s_data[$row]["remarks"] = $data_value;
						}
					}else{
						if(empty($body[$row]["AH"])){
							$s_data[$row]["remarks"] = '';
						}
					}
					if(isset($body[$row]["AI"]))
					{
						if($column == "AI"){
							$s_data[$row]["company"] = $data_value;
						}
					}else{
						if(empty($body[$row]["AI"])){
							$s_data[$row]["company"] = '';
						}
					}
					if(isset($body[$row]["AJ"]))
					{
						if($column == "AJ"){
							if(empty($data_value)){
								$s_data[$row]["whole_sale_period"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["whole_sale_period"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["AJ"])){
							$s_data[$row]["whole_sale_period"] = '';
						}
					}
					if(isset($body[$row]["AK"]))
					{
						if($column == "AK"){
							$s_data[$row]["inv_amt"] = $data_value;
						}
					}else{
						if(empty($body[$row]["AK"])){
							$s_data[$row]["inv_amt"] = '';
						}
					}
				}

				}
	}

	function do_upload5()
	{
		$this->load->library('upload');

		$files = $_FILES;
		// print_r($_FILES);
		// die();

		$_FILES['userfile']['name']= $files['userfile']['name'];
		$_FILES['userfile']['type']= $files['userfile']['type'];
		$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'];
		$_FILES['userfile']['error']= $files['userfile']['error'];
		$_FILES['userfile']['size']= $files['userfile']['size'];

		$file = preg_replace('/\s+/', '_',$this->set_upload_options()['upload_path'].$files['userfile']['name']);

		$this->upload->initialize($this->set_upload_options());
		$this->upload->do_upload();
			// echo $file;




			$objPHPExcel = PHPExcel_IOFactory::load($file);

			unlink($file);
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			foreach ( $cell_collection as $cell) {
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

				if ($row == 1) {
					$header[$row][$column] = $data_value;

				}else{

					$body[$row][$column] = $data_value;

					if(isset($body[$row]["A"]))
					{
						if($column == "A"){
							$s_data[$row]["P.O NUMBER"] = $data_value;
						}
					}else{
						if(empty($body[$row]["A"])){
							$s_data[$row]["P.O NUMBER"] = '';
						}
					}

					if(isset($body[$row]["B"]))
					{
						if($column == "B"){
							if(empty($data_value)){
								$s_data[$row]["P.O DATE"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["P.O DATE"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["B"])){
							$s_data[$row]["P.O DATE"] = '';
						}
					}

					if(isset($body[$row]["C"]))
					{
						if($column == "C"){
							$s_data[$row]["P.O DEALER"] = $data_value;
						}
					}else{
						if(empty($body[$row]["C"])){
							$s_data[$row]["P.O DEALER"] = '';
						}
					}
					if(isset($body[$row]["D"]))
					{
						if($column == "D"){
							$s_data[$row]["P.O MODEL"] = $data_value;
						}
					}else{
						if(empty($body[$row]["D"])){
							$s_data[$row]["P.O MODEL"] = '';
						}
					}

					if(isset($body[$row]["E"]))
					{
						if($column == "E"){
							$s_data[$row]["P.O MODEL COLOR"] = $data_value;
						}
					}else{
						if(empty($body[$row]["E"])){
							$s_data[$row]["P.O MODEL COLOR"] = '';
						}
					}

					if(isset($body[$row]["F"]))
					{
						if($column == "F"){
							$s_data[$row]["P.O MODEL COST"] = $data_value;
						}
					}else{
						if(empty($body[$row]["F"])){
							$s_data[$row]["P.O MODEL COST"] = '';
						}
					}

					if(isset($body[$row]["G"]))
					{
						if($column == "G"){
							$s_data[$row]["C.S NUMBER"] = $data_value;
						}
					}else{
						if(empty($body[$row]["G"])){
							$s_data[$row]["C.S NUMBER"] = '';
						}
					}

					if(isset($body[$row]["H"]))
					{
						if($column == "H"){
							$s_data[$row]["MODEL YEAR"] = $data_value;
						}
					}else{
						if(empty($body[$row]["H"])){
							$s_data[$row]["MODEL YEAR"] = '';
						}
					}

					if(isset($body[$row]["I"]))
					{
						if($column == "I"){
							$s_data[$row]["PRODUCTION NUMBER"] = $data_value;
						}
					}else{
						if(empty($body[$row]["I"])){
							$s_data[$row]["PRODUCTION NUMBER"] = '';
						}
					}

					if(isset($body[$row]["J"]))
					{
						if($column == "J"){
							$s_data[$row]["VIN NUMBER"] = $data_value;
						}
					}else{
						if(empty($body[$row]["J"])){
							$s_data[$row]["VIN NUMBER"] = '';
						}
					}

					if(isset($body[$row]["K"]))
					{
						if($column == "K"){
							$s_data[$row]["ENGINE NUMBER"] = $data_value;
						}
					}else{
						if(empty($body[$row]["K"])){
							$s_data[$row]["ENGINE NUMBER"] = '';
						}
					}

					if(isset($body[$row]["L"]))
					{
						if($column == "L"){
							$s_data[$row]["SUBSIDY CLAIMING"] = $data_value;
						}
					}else{
						if(empty($body[$row]["L"])){
							$s_data[$row]["SUBSIDY CLAIMING"] = '';
						}
					}
					if(isset($body[$row]["M"]))
					{
						if($column == "M"){
							$s_data[$row]["LOCATION"] = $data_value;
						}
					}else{
						if(empty($body[$row]["M"])){
							$s_data[$row]["LOCATION"] = '';
						}
					}
					if(isset($body[$row]["N"]))
					{
						if($column == "N"){
							if(empty($data_value)){
								$s_data[$row]["RECEIVED DATE"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
							$s_data[$row]["RECEIVED DATE"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["N"])){
							$s_data[$row]["RECEIVED DATE"] = '';
						}
					}
				}

			}

			$error_count=0;
			$count_recorded=0;
			$update_count=0;
			$user_id=$_GET['ids'];
			// echo '<pre>';
			// print_r($s_data);
			$cs_chk=array();
			foreach($s_data as $vl)
			{
				$cs_chk[]=$vl['C.S NUMBER'];
			}

			// foreach ($cs_chk as $key ) {
			// 	 print_r($key);
			// }
			// die();
			foreach ($s_data as $value) {
				$model=strtoupper(trim($value['P.O MODEL']));
				$po_num=str_replace(' ','',$value['P.O NUMBER']);
				$cs_num=str_replace(' ','',$value['C.S NUMBER']);
				$exDealer=strtoupper(trim($value['P.O DEALER']));
				$po_date=$value['P.O DATE'];
				$po_model_color=$value['P.O MODEL COLOR'];
				$po_model_cost=$value['P.O MODEL COST'];
				$po_model_year=$value['MODEL YEAR'];
				$prod_number=$value['PRODUCTION NUMBER'];
				$vin_number=$value['VIN NUMBER'];
				$engine_number=$value['ENGINE NUMBER'];
				$sub_claim=$value['SUBSIDY CLAIMING'];
				$location=$value['LOCATION'];
				$receive_date=$value['RECEIVED DATE'];
				$model_search=$this->Main_m->modelSearch($model);
				$po_search=$this->Main_m->poSearch($po_num);
				$cs_search=$this->Main_m->csSearch($cs_num);
				$model_id='';
				foreach($model_search as $vl)
				{
					$model_id=$vl->id;
				}
				$checkApproved=$this->Main_m->checkApproved($model_id,$po_model_color);
				if($checkApproved > 0)
				{
					if(strlen($exDealer) > 0)
					{
						$dealer=explode(" ",$exDealer);
						if(count($dealer) == 3)
						{
							if($dealer[0].' '.$dealer[1] == 'MORRIS GARAGES' OR $dealer[0].' '.$dealer[1] == 'KING LONG' OR $dealer[0].' '.$dealer[1] == 'MINI COOPER')
							{
								$company = $dealer[0].' '.$dealer[1];
								if($dealer[2] == 'BF')
								{
									$branch = 'BF PARAÑAQUE';
								}else{
									$branch = $dealer[2];
								}
							}else{
								$company=$dealer[0];
								$branch=$dealer[1].' '.$dealer[2];
							}
						}else if(count($dealer) == 4){
							if($dealer[0].' '.$dealer[1] == 'MORRIS GARAGES' OR $dealer[0].' '.$dealer[1] == 'KING LONG' OR $dealer[0].' '.$dealer[1] == 'MINI COOPER')
							{
								$company = $dealer[0].' '.$dealer[1];
								if($dealer[2] == 'BF')
								{
									$branch = 'BF PARAÑAQUE';
								}else{
									$branch = $dealer[2].' '.$dealer[3];
								}
							}else{
								$company=$dealer[0];
								$branch=$dealer[1].' '.$dealer[2];
							}
						}else{
							$company=$dealer[0];
							$branch=$dealer[1];
						}


						$dealersearch=$this->Dsar_m->dealerSearch($company,$branch);
						$dealerid='';
						foreach($dealersearch as $lv)
						{
							$dealerid=$lv->id;
						}
						if(count($dealersearch) > 0)
						{
							if(count($model_search) > 0)
							{
								if(count($po_search) < 1)
								{
									if(strlen($cs_num) > 1)
									{
										if(count($cs_search) == 0)
										{

											$podata=array(
												'po_num'=>$po_num,
												'po_date'=>$po_date,
												'dealer'=>$dealerid,
												'model'=>$model_id,
												'model_yr'=>$po_model_year,
												'color'=>strtoupper(trim($po_model_color)),
												'cost'=>$po_model_cost,
												'added_by'=>$user_id,
												'has_vehicle'=>1,
												'conf_order'=>1,
												'deleted'=>0
											);
											$insertpo=$this->Main_m->insert_po($podata);
												$loc=explode("-",$location);
												$floc='';
												if(count($loc) > 0)
												{
													$dealer=$loc[0];
													if(count($loc) == 1)
													{
														$location='';
													}else{
														$location=$loc[1];
													}

													$checkLoc=$this->Main_m->checkLoc($dealer,$location);
													if(count($checkLoc) > 0)
													{
														$floc=$dealer.'-'.$location;
													}else{
														$data=array('Company' => $dealer,'Branch' => $location);
														$addLoc=$this->Main_m->addLoc($dealer,$data);
														$floc=$dealer.'-'.$location;
													}
												}
												$last_id=$insertpo;

												$csdata=array(
													'cs_num'=>$cs_num,
													'purchase_order'=>$last_id,
													'model'=>$model_id,
													'model_yr'=>$po_model_year,
													'color'=>strtoupper(trim($po_model_color)),
													'cost'=>$po_model_cost,
													'prod_num'=>strtoupper(trim($prod_number)),
													'vin_num'=>strtoupper(trim($vin_number)),
													'engine_num'=>strtoupper(trim($engine_number)),
													'subsidy_claiming'=>$sub_claim,
													'location'=>$floc,
													'veh_received'=>$receive_date,
													'deleted'=>0
												);
												$insertcs=$this->Main_m->insert_cs($csdata);
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

														$gpdata=$this->Gp_m->get_details($cs_num);
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
												$status="Insert Successful";
												$count_recorded++;
												$updateApproved=$this->Main_m->updateApproved($model_id,$po_model_color);
										}else{

											$podata=array(
												'po_num'=>$po_num,
												'po_date'=>$po_date,
												'dealer'=>$dealerid,
												'model'=>$model_id,
												'color'=>strtoupper(trim($po_model_color)),
												'cost'=>$po_model_cost,
												'added_by'=>$user_id,
												'has_vehicle'=>0,
												'conf_order'=>1,
												'deleted'=>0
											);
											$insertpo=$this->Main_m->insert_po($podata);
											$status="C.S Number is Double";
											$error_count++;
											$updateApproved=$this->Main_m->updateApproved($model_id,$po_model_color);
										}

									}else{

										$podata=array(
											'po_num'=>$po_num,
											'po_date'=>$po_date,
											'dealer'=>$dealerid,
											'model'=>$model_id,
											'color'=>strtoupper(trim($po_model_color)),
											'cost'=>$po_model_cost,
											'added_by'=>$user_id,
											'has_vehicle'=>0,
											'conf_order'=>1,
											'deleted'=>0
										);
										$insertpo=$this->Main_m->insert_po($podata);
										$status="Insert Successful";
										$count_recorded++;
										$updateApproved=$this->Main_m->updateApproved($model_id,$po_model_color);
									}
								}else{
									$status="P.O. Number is Exist";
									$error_count++;
								}
							}else{
								$status="No Model Record";
								$error_count++;
							}
						}else{
							$status="No Dealer Record";
							$error_count++;
						}
					}

				}else{
					$status="No Model Approved Record";
					$error_count++;
				}


				$importdata=array(
					'po_number'=>$po_num,
					'po_date'=>$po_date,
					'po_dealer'=>strtoupper(trim($exDealer)),
					'po_model'=>strtoupper(trim($model)),
					'po_model_color'=>strtoupper(trim($po_model_color)),
					'po_model_cost'=>$po_model_cost,
					'cs_number'=>$cs_num,
					'model_yr'=>$po_model_year,
					'prod_num'=>strtoupper(trim($prod_number)),
					'vin_num'=>strtoupper(trim($vin_number)),
					'eng_num'=>strtoupper(trim($engine_number)),
					'subsidy_claiming'=>$sub_claim,
					'import_log_status'=>$status,
				);
				$this->Main_m->importD($importdata);
			}
			echo "Total Count Import Successful = ".$count_recorded;
			echo "<br/>Total Count Import Unsuccessful = ".$error_count;
	}
	function douploadinsurance()
	{
		$this->load->library('upload');

		$files = $_FILES;
		// print_r($_FILES);
		// die();

		$_FILES['userfile']['name']= $files['userfile']['name'];
		$_FILES['userfile']['type']= $files['userfile']['type'];
		$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'];
		$_FILES['userfile']['error']= $files['userfile']['error'];
		$_FILES['userfile']['size']= $files['userfile']['size'];

		$file = preg_replace('/\s+/', '_',$this->set_upload_options()['upload_path'].$files['userfile']['name']);

		$this->upload->initialize($this->set_upload_options());
		$this->upload->do_upload();
			// echo $file;




			$objPHPExcel = PHPExcel_IOFactory::load($file);

			unlink($file);
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			foreach ( $cell_collection as $cell) {
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

				if ($row == 1) {
					$header[$row][$column] = $data_value;

				}else{

					$body[$row][$column] = $data_value;

					if(isset($body[$row]["A"]))
					{
						if($column == "A"){
							$s_data[$row]["policyNumber"] = $data_value;
						}
					}else{
						if(empty($body[$row]["A"])){
							$s_data[$row]["policyNumber"] = '';
						}
					}

					if(isset($body[$row]["B"]))
					{
						if($column == "B"){
							if(empty($data_value)){
								$s_data[$row]["fSalesPeriod"] = NULL;
							}else{
								$date=str_replace(' ','',$data_value);
								$s_data[$row]["fSalesPeriod"] = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($date));
							}
						}
					}else{
						if(empty($body[$row]["B"])){
							$s_data[$row]["fSalesPeriod"] = '';
						}
					}
				}

			}
			// echo '<pre>';
			// print_r($s_data);
			foreach($s_data as $value)
			{
				$policynumber=$value["policyNumber"];
				$fsalesperiod=$value["fSalesPeriod"];

				$update=$this->Insurance_m->updates($policynumber,$fsalesperiod);
			}

	}
}
?>
