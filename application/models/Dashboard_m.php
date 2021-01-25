<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Dashboard_m extends CI_Model
	{
		 function po_Details($po_num)
		 {
			 $this->db->select('*,invtry_purchase_order.id as ids');
			 $this->db->from('invtry_purchase_order');
			 $this->db->join('licagroup_dsar.company_branch','licagroup_dsar.company_branch.id = invtry_purchase_order.dealer ','left');
			 $this->db->join('product','invtry_purchase_order.model = product.id','left');
			  $this->db->where('invtry_purchase_order.po_num',$po_num);

			 $query = $this->db->get();
 			 return $query->result();
		 }
		 function po_Details2($po_id)
		 {
			 $this->db->select('*,invtry_purchase_order.id as ids');
			 $this->db->from('invtry_purchase_order');
			 $this->db->join('company_branch','invtry_purchase_order.dealer = company_branch.id','left');
			 $this->db->join('product','invtry_purchase_order.model = product.id','left');
			  $this->db->where('invtry_purchase_order.id',$po_id);

			 $query = $this->db->get();
 			 return $query->result();
		 }
		 function getpoid($po_num)
		 {
			 $this->db->where('invtry_purchase_order.po_num',$po_num);
			 $this->db->from('invtry_purchase_order');

			 $query = $this->db->get();
 			 return $query->result();
		 }

		 function cs_Details($po_id)
		 {
			 $this->db->where('invtry_vehicle.purchase_order',$po_id);
			 $this->db->from('invtry_vehicle');
			 $this->db->join('product','invtry_vehicle.model = product.id','left');

			 $query = $this->db->get();
			 return $query->result();
		 }
		 function csdetails2($cs_num)
		 {
			 $this->db->where('invtry_vehicle.cs_num',$cs_num);
			 $this->db->from('invtry_vehicle');
			 $this->db->join('product','invtry_vehicle.model = product.id','left');

			 $query = $this->db->get();
			 return $query->result();
		 }
		 function csdetails3($po_num)
		 {
			 $this->db->select('*,invtry_purchase_order.id as ids');
			 $this->db->from('invtry_purchase_order');
			 $this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			 $this->db->join('company_branch','invtry_purchase_order.dealer = company_branch.id','left');
			 $this->db->join('product','invtry_purchase_order.model = product.id','left');
			  $this->db->where('invtry_purchase_order.po_num',$po_num);

			 $query = $this->db->get();
 			 return $query->result();
		 }
		 function location()
		 {
			 $this->db->select('CONCAT(Company,"-",Branch) as "Company"');
			 $this->db->from('company_branch');

			 $query = $this->db->get();
 			 return $query->result();
		 }
		 function insertVehicle($data)
		 {
			 $this->db->insert('invtry_vehicle',$data);
		 }
		 function updatePOs($po_data,$po_id)
		 {
			 $this->db->where('id',$po_id);
			 $this->db->update('invtry_purchase_order',$po_data);
		 }
		 function updateStatus2($updata,$po_id)
		 {
			  $this->db->where('po_id',$po_id);
				$this->db->update('invtry_status',$updata);
		 }
		 function get_gp_cs()
		 {
			 $this->db = $this->load->database('gp',TRUE);
			 $this->db->where('gp.invoice_date',NULL);
			 $this->db->from('gp');

			 $query = $this->db->get();
			return $query->result();
		 }
		 function statusdetails($po_id)
		 {
			 $this->db->select('invtry_acc_status.status as acc_status,invtry_status.status as inv_status');
			 $this->db->from('invtry_acc_status');
			 $this->db->join('invtry_status','invtry_status.po_number = invtry_acc_status.po_number','left');
			 $this->db->join('invtry_purchase_order','invtry_purchase_order.po_num = invtry_acc_status.po_number','left');
			  $this->db->where('invtry_purchase_order.id',$po_id);

			 $query = $this->db->get();
 			 return $query->result();
		 }
		 function insert_wsp($po_num,$datapo)
		 {
			 $this->db->where('po_num',$po_num);
			$this->db->update('invtry_purchase_order',$datapo);
		 }
		 function searchChangeLoc($id)
		 {
			 $this->db->from('changeLocation');
			 $this->db->where('vehicleID',$id);

			$query = $this->db->get();
			return $query->num_rows();
		 }
		 function searchChangeLoc2($id)
		 {
			 $this->db->from('changeLocation');

			$query = $this->db->get();
			return $query->result();
		 }
		 function addToS($data)
		 {
			 $this->db->insert('changeLocation',$data);
		 }
		 function removeToS($id)
		 {
			 $this->db->where('vehicleID',$id);
			 	$this->db->delete('changeLocation');
		 }
		 function updateReceive($data,$csid)
		 {
			 $this->db->where('id',$csid);
		   $this->db->update('invtry_vehicle',$data);
		 }
		 function updateInvStatus($data2,$po_num)
		 {
			 $this->db->where('po_number',$po_num);
		   $this->db->update('invtry_status',$data2);
		 }
		 function infoV($id)
		 {
			 $this->db->where('id',$id);
			 $this->db->from('invtry_vehicle');

			 $query = $this->db->get();
 			 return $query->result();
		 }
		 function Location2()
		 {
			  $this->db->select('CONCAT(Company,"-",Branch) as Location');
			  $this->db->from('company_branch');
				$this->db->where('Company is NOT NULL', NULL, FALSE);
				$this->db->where('Company !=','');

				$query = $this->db->get();
				return $query->result();
		 }
		 function updateInvStatus2($data2,$po_num)
		 {
			 $this->db->where('po_number',$po_num);
			$this->db->update('invtry_acc_status',$data2);
		 }
		 function getPO($cs_num)
		 {
			 $this->db->where('invtry_vehicle.cs_num',$cs_num);
			 $this->db->from('invtry_purchase_order');
			 $this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');

			 $query = $this->db->get();
			 return $query->result();
		 }
		 function updateStatus3($po_num)
		 {
			 	$data=array('invtry_acc_status.status' => 'Invoiced');
				$this->db->where('invtry_acc_status.po_number',$po_num);
				$this->db->where('invtry_acc_status.status','Allocated');
				$this->db->update('invtry_acc_status',$data);
		 }
		 function updateInvoiced($data3,$po_num)
		 {
			 $this->db->where('invtry_purchase_order.po_num',$po_num);
			 $this->db->update('invtry_purchase_order',$data3);
		 }
		 function vehicleInfo($id)
		 {
			 $this->db->where('invtry_vehicle.id',$id);
			 $this->db->from('invtry_vehicle');
			 $this->db->join('product','invtry_vehicle.model = product.id');

			 $query = $this->db->get();
			 return $query->result();
		 }
		 function poInfo($ponum)
		 {
			$this->db->where('po_num',$ponum);
	 		$this->db->select('*,invtry_status.status as Status1,invtry_acc_status.status as Status2,');
	 		$this->db->from('invtry_purchase_order');
	 		$this->db->join('invtry_status','invtry_purchase_order.po_num = invtry_status.po_number');
	 		$this->db->join('invtry_acc_status','invtry_purchase_order.po_num = invtry_acc_status.po_number');
	 		$this->db->join('product','invtry_purchase_order.model = product.id');

 			$query = $this->db->get();
 			return $query->result();

		 }
		 function getDetails()
		 {
			 $this->db->from('invtry_purchase_order');
			 $this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			 $this->db->group_by('invtry_purchase_order.po_num');
			 $query = $this->db->get();
			 return $query->result();

		 }
		 function getDetails2($po_num)
		 {
			 $this->db->from('invtry_purchase_order');
			 $this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			 $this->db->where('invtry_purchase_order.po_num',$po_num);
			 $query = $this->db->get();
			 return $query->result();

		 }
		 function checkAccStatus($po_num)
		 {
			 $this->db->from('invtry_acc_status');
			 $this->db->where('invtry_acc_status.po_number',$po_num);
			 $query = $this->db->get();
			 return $query->result();
		 }
		 function checkInvStatus($po_num)
		 {
			 $this->db->from('invtry_status');
			 $this->db->where('invtry_status.po_number',$po_num);
			 $query = $this->db->get();
			 return $query->result();
		 }
		  public function insertStatus($status_data)
	 		{
	 			$this->db->insert('invtry_status',$status_data);
	 		}
	 		public function insertStatusAC($status_data)
	 		{
	 			$this->db->insert('invtry_acc_status',$status_data);
	 		}


			public function vinCheck()
			{
				$this->db->select('cs_num');
				$this->db->from('invtry_vehicle');
				$this->db->where('vin_num',NULL);
				$this->db->or_where('vin_num','');

				$query = $this->db->get();
				return $query->result();
			}
			public function importCVin($cs)
			{
				$this->db->select('vin_num,cs_number');
				$this->db->from('invtry_import_data');
				$this->db->where('cs_number',$cs);
				$this->db->group_by('cs_number');

				$query = $this->db->get();
				return $query->result();
			}
			public function updateVin($data1,$cs_num)
			{
				$this->db->where('cs_num',$cs_num);
				$this->db->update('invtry_vehicle',$data1);
			}

			public function prodCheck()
			{
				$this->db->select('cs_num');
				$this->db->from('invtry_vehicle');
				$this->db->where('prod_num',NULL);
				$this->db->or_where('prod_num','');

				$query = $this->db->get();
				return $query->result();
			}
			public function importCProd($cs)
			{
				$this->db->select('prod_num,cs_number');
				$this->db->from('invtry_import_data');
				$this->db->where('cs_number',$cs);
					$this->db->group_by('cs_number');

				$query = $this->db->get();
				return $query->result();
			}
			public function updateProd($data2,$cs_num)
			{
				$this->db->where('cs_num',$cs_num);
				$this->db->update('invtry_vehicle',$data2);
			}

			public function engCheck()
			{
				$this->db->select('cs_num');
				$this->db->from('invtry_vehicle');
				$this->db->where('engine_num',NULL);
				$this->db->or_where('engine_num','');

				$query = $this->db->get();
				return $query->result();
			}
			public function importCEng($cs)
			{
				$this->db->select('eng_num,cs_number');
				$this->db->from('invtry_import_data');
				$this->db->where('cs_number',$cs);
				$this->db->group_by('cs_number');

				$query = $this->db->get();
				return $query->result();
			}
			public function updateEng($data3,$cs_num)
			{
				$this->db->where('cs_num',$cs_num);
				$this->db->update('invtry_vehicle',$data3);
			}
			public function insertRequest($data)
			{
				$this->db->insert('invtry_request_table',$data);
				$insert_id = $this->db->insert_id();

   			return  $insert_id;
			}
			public function insertDatatable($data3)
			{
				$this->db->insert('invtry_rt_datatable',$data3);
			}
			public function updateDataTable($rt_id,$date)
			{
				$this->db->set('date_approved',$date);
				$this->db->where('rt_id', $rt_id);
				$this->db->update('invtry_rt_datatable');
			}
			public function product($accessdealer)
			{
	      $this->db->from('product');
				// $this->db->group_start();
				foreach($accessdealer as $val)
				{
					$this->db->or_where('Company',$val->key);
				}
				// $this->db->group_end();
				$this->db->order_by('Company','ASC');

				$query = $this->db->get();
				return $query->result();
			}
			public function productA()
			{
	      $this->db->from('product');
				$this->db->order_by('Company','ASC');

				$query = $this->db->get();
				return $query->result();
			}
			public function brand2($accessdealer)
			{
	      $this->db->from('product');
				// $this->db->group_start();
				foreach($accessdealer as $val)
				{
					if($val->key == 'MORRIS GARAGES')
					{
						$this->db->or_where('Company','MG');
					}else{
						$this->db->or_where('Company',$val->key);
					}

				}
				// $this->db->group_end();
				$this->db->group_by('Company');
				$this->db->order_by('Company','ASC');

				$query = $this->db->get();
				return $query->result();
			}
			public function brand()
			{
	      $this->db->from('product');
				$this->db->group_by('Company');
				$this->db->order_by('Company','ASC');

				$query = $this->db->get();
				return $query->result();
			}
			public function requestDate($id)
			{
				$this->db->from('invtry_request_table');
				$this->db->where('rt_id',$id);

				$query = $this->db->get();
				return $query->result();
			}

			function updateRequest($data,$rt_id)
 		 {
 			 $this->db->where('rt_id',$rt_id);
 			 $this->db->update('invtry_request_table',$data);
 		 }
			function deleteRequest($rt_id)
 		 {
 			 $this->db->where('rt_id',$rt_id);
 			 $this->db->delete('invtry_request_table');
 		 }
		 function requestDataChecked($model_id,$color)
		 {
			 $this->db->from('invtry_request_table');
			 $this->db->where('invtry_request_table.variant',$model_id);
			 $this->db->where('invtry_request_table.color',$color);
			 $this->db->where('invtry_request_table.approved','0');

			 $query = $this->db->get();
			 return $query->num_rows();
		 }
		 function finddata($model_id)
		 {
			$this->db->from('product');
			$this->db->where('product.id',$model_id);

			$query = $this->db->get();
			return $query->result();
		 }
		 function color()
		 {
			 $this->db->from('model_color_tb');
			 $this->db->where('status','1');

	 		$query = $this->db->get();
	 		return $query->result();
		 }
		 function onHandCount($modelid,$color)
		 {
			 $this->db->select('invtry_vehicle.cs_num as cs_num');
			 $this->db->from('invtry_purchase_order');
			 $this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			 $this->db->where('invtry_vehicle.veh_received is NOT NULL', NULL, FALSE);
			 $this->db->where('invtry_vehicle.veh_received !=','0000-00-00');
			 $this->db->group_start();
			 $this->db->where('invtry_vehicle.imaps_actual_release_date', NULL);
			 $this->db->or_where('invtry_vehicle.imaps_actual_release_date','');
			 $this->db->or_where('invtry_vehicle.imaps_actual_release_date','0000-00-00');
			 $this->db->group_end();
			 $this->db->where('invtry_purchase_order.model',$modelid);
			 $this->db->where('invtry_purchase_order.color',$color);

			 $query = $this->db->get();
			 return $query->num_rows();
		 }
		 function intransitCount($modelid,$color)
		 {
			 $this->db->from('invtry_purchase_order');
			 $this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			 $this->db->where('invtry_purchase_order.model',$modelid);
		   $this->db->where('invtry_purchase_order.color',$color);
		   $this->db->group_start();
			 $this->db->where('invtry_vehicle.veh_received is NULL', NULL, FALSE);
 			 $this->db->or_where('invtry_vehicle.veh_received','0000-00-00');
			 $this->db->group_end();

			 $query = $this->db->get();
			 return $query->num_rows();
		 }
		 function intransitCount2($modelid,$color)
		 {
			 $this->db->from('invtry_for_approval_table');
			 $this->db->where('invtry_for_approval_table.variant',$modelid);
			 $this->db->where('invtry_for_approval_table.color',$color);

			 $query = $this->db->get();
			 return $query->result();
		 }
		 function forReleaseCount($modelid,$color)
		 {
			 $this->db->select('invtry_vehicle.cs_num as cs_num');
			 $this->db->from('invtry_purchase_order');
			 $this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			 $this->db->where('invtry_vehicle.veh_received is NOT NULL', NULL, FALSE);
			 $this->db->where('invtry_vehicle.veh_received !=','0000-00-00');
			 $this->db->group_start();
			 $this->db->where('invtry_vehicle.imaps_actual_release_date', NULL);
			 $this->db->or_where('invtry_vehicle.imaps_actual_release_date','');
			 $this->db->or_where('invtry_vehicle.imaps_actual_release_date','0000-00-00');
			 $this->db->group_end();
			 $this->db->where('invtry_purchase_order.model',$modelid);
			 $this->db->where('invtry_purchase_order.color',$color);

			 $query = $this->db->get();
			 return $query->result();
		 }
		 function approvedCount($modelid,$color)
		 {
			 $this->db->select('invtry_for_approval_table.quantity as quantity');
			 $this->db->from('invtry_for_approval_table');
			 $this->db->join('invtry_request_table','invtry_request_table.rt_id = invtry_for_approval_table.rt_id','left');
			 $this->db->where('invtry_request_table.variant',$modelid);
			 $this->db->where('invtry_request_table.color',$color);
			 $this->db->where('invtry_for_approval_table.deleted','0');
			 $this->db->where('invtry_request_table.approved','1');

			 $query = $this->db->get();
			 return $query->result();
		 }
		 function getAve($modelid,$color,$beginningDate,$date)
 		{
 			$this->db->from('invtry_purchase_order');
 			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
 			 $this->db->join('product','product.id = invtry_vehicle.model','left');
 			$this->db->where('invtry_vehicle.imaps_actual_release_date >=',$beginningDate);
 			$this->db->where('invtry_vehicle.imaps_actual_release_date <',$date);
 			$this->db->where('invtry_vehicle.color',$color);
 			$this->db->where('product.id',$modelid);
 			$this->db->where('invtry_vehicle.imaps_actual_release_date is NOT NULL', NULL, FALSE);
 				$this->db->where('invtry_purchase_order.testDrive',0);

 			$query = $this->db->get();
 			return $query->num_rows();
 		}
		function rdata($rt_id)
		{
			$this->db->from('invtry_request_table');
			$this->db->where('invtry_request_table.rt_id',$rt_id);

			$query = $this->db->get();
			return $query->result();
		}
		function rdata2($brand)
		{
			$this->db->from('invtry_request_table');
			$this->db->where('invtry_request_table.brand',$brand);

			$query = $this->db->get();
			return $query->result();
		}
		function approvedtb($data)
		{
			$this->db->insert('invtry_for_approval_table',$data);
		}
		function updatert($rt_id,$data2)
		{
			$this->db->where('invtry_request_table.rt_id',$rt_id);
			$this->db->update('invtry_request_table',$data2);
		}
		function updateAtb($data3,$modelid,$color)
		{
			$this->db->where('invtry_for_approval_table.variant',$modelid);
			$this->db->where('invtry_for_approval_table.color',$color);
			$this->db->update('invtry_for_approval_table',$data3);
		}
		function getFAInfo($fa_id)
		{
			$this->db->select('product.Company as Brand,product.id as Model,invtry_request_table.color as Color,product.Product as Product,invtry_request_table.rt_id as rt_ids,invtry_request_table.cost as cost');
			$this->db->from('invtry_for_approval_table');
			$this->db->join('invtry_request_table','invtry_request_table.rt_id = invtry_for_approval_table.rt_id','left');
			$this->db->join('product','product.id = invtry_request_table.variant','left');
			$this->db->where('invtry_for_approval_table.fa_id',$fa_id);

			$query = $this->db->get();
		  return $query->result();
		}
		function updateQuantity($rt_id)
		{
			$quantity=1;
			$this->db->set('quantity', 'quantity-'. $quantity.'',false);
			$this->db->where('rt_id', $rt_id);
			$this->db->update('invtry_request_table');

		}
		function updateQuantity2($rt_id)
		{
			$quantity=1;
			$this->db->set('quantity', 'quantity-'. $quantity.'',false);
			$this->db->set('approved_intransit', 'approved_intransit-'. $quantity.'',false);
			$this->db->set('total_projected_inventory', 'total_projected_inventory-'. $quantity.'',false);
			$this->db->where('rt_id', $rt_id);
			$this->db->update('invtry_for_approval_table');

		}
		function poM($id)
		{
			$this->db->from('invtry_purchase_order');
			$this->db->where('invtry_purchase_order.id',$id);

			$query = $this->db->get();
			return $query->result();
		}
		function updateTotal($model,$color)
		{
			$quantity=1;
			$this->db->set('approved_intransit', 'approved_intransit+'. $quantity.'',false);
			$this->db->set('quantity', 'quantity+'. $quantity.'',false);
			$this->db->set('total_projected_inventory', 'total_projected_inventory+'. $quantity.'',false);
			$this->db->where('variant', $model);
			$this->db->where('color', $color);
			$this->db->update('invtry_for_approval_table');
		}
		function searchVariant($brand)
		{
			$this->db->from('invtry_request_table');
			$this->db->where('invtry_request_table.brand',$brand);
			$this->db->where('invtry_request_table.approved',0);
			$this->db->where('invtry_request_table.deleted',0);

			$query = $this->db->get();
			return $query->result();
		}
		function searchVariant2($variant,$color)
		{
			$this->db->from('invtry_request_table');
			$this->db->where('invtry_request_table.variant',$variant);
			$this->db->where('invtry_request_table.color',$color);
			$this->db->where('invtry_request_table.approved',0);
			$this->db->where('invtry_request_table.deleted',0);

			$query = $this->db->get();
			return $query->result();
		}
		function modelC($brand)
		{
			$this->db->from('product');
			$this->db->join('model_color_tb','product.id = model_color_tb.model_id','left');
			$this->db->where('product.Company',$brand);

			$query = $this->db->get();
			return $query->result();
		}

		function product2($modelid)
		{
				$this->db->from('product');
				$this->db->where('id',$modelid);

				$query = $this->db->get();
				return $query->result();
		}
		function getMSeries($brand)
		{
			$this->db->from('product');
			$this->db->where('Company',$brand);
			$this->db->group_by('model_series');

			$query = $this->db->get();
			return $query->result();
		}
		function searchModelID($brand,$series)
		{
			$this->db->from('product');
			$this->db->join('invtry_request_table','invtry_request_table.variant = product.id','LEFT JOIN');
			$this->db->where('Company',$brand);
			$this->db->where('model_series',$series);
			$this->db->where('invtry_request_table.approved',0);
			$this->db->where('invtry_request_table.deleted',0);

			$query = $this->db->get();
			return $query->result();
		}
		function getRemarks($rt_id)
		{
			$this->db->from('invtry_request_table');
			$this->db->where('invtry_request_table.rt_id',$rt_id);

			$query = $this->db->get();
			return $query->result();
		}
		function updateRemarks($rt_id,$data)
		{
			$this->db->where('rt_id',$rt_id);
			$this->db->update('invtry_request_table',$data);
		}
	}
?>
