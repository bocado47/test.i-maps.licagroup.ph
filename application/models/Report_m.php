<?php
	class Report_m extends CI_Model
	{
		public function Brands()
		{
			$this->db->from('invtry_model_table');

			$query = $this->db->get();
			return $query->result();
		}
		public function models($dealer)
		{
			if($dealer == 'MORRIS GARAGES')
			{
				$dealer='MG';
			}
			$this->db->from('product');
			$this->db->where('Company',$dealer);
			$this->db->order_by('product','ASC');

			$query = $this->db->get();
			return $query->result();

		}
		public function models2($nseries)
		{
			$this->db->from('product');
			$this->db->where('model_series',$nseries);
			$this->db->order_by('model_series','ASC');

			$query = $this->db->get();
			return $query->result();

		}
		public function ADIR_m($model,$status)
		{
			$select='invtry_vehicle.cs_num,';
			$select.='invtry_purchase_order.color as color,';
			$select.='invtry_purchase_order.model_yr as year,';
			$select.='invtry_purchase_order.whole_sale_period as date,';
			$select.='invtry_vehicle.veh_received as received_date,';
			$select.='invtry_purchase_order.po_num as po_num,';
			$select.='invtry_vehicle.vin_num as vin_num,';
			$select.='invtry_vehicle.location as location,';
			$select.='invtry_vehicle.vrr_num as vrr_num,';
			$select.='invtry_vehicle.plant_sales_report as grp_plant,';
			$select.='invtry_vehicle.plant_sales_month as plant_sales_month,';
			$select.='invtry_vehicle.imaps_actual_release_date as iard,';
			$select.='invtry_purchase_order.po_date as po_date,';
			$select.='invtry_purchase_order.remarks as remarks,';
			$this->db->select($select);
			$this->db->from('invtry_vehicle');
			$this->db->join('invtry_status','invtry_status.cs_num = invtry_vehicle.cs_num');
      $this->db->join('invtry_purchase_order','invtry_purchase_order.id = invtry_vehicle.purchase_order');
      $this->db->where('invtry_vehicle.model',$model);
      $this->db->where('invtry_status.status',$status);

			$query = $this->db->get();
			return $query->result();
		}
		public function Brands2($id)
		{
			$this->db->select('key as company');
			$this->db->from('invtry_access_table');
			$this->db->where('invtry_admin_id',$id);
			$this->db->where('status','1');
			// $this->db->group_by('Company');

			$query = $this->db->get();
			return $query->result();
		}
		public function fgrp($plant)
		{
			$this->db->select('CONCAT(Company,"-",Branch) as plant');
			$this->db->from('company_branch');
			$this->db->where('id',$plant);

			$query = $this->db->get();
			return $query->result();
		}
		public function ADIR_m2($model,$inv_status,$acc_status)
		{
			$select='invtry_vehicle.cs_num,';
			$select.='invtry_purchase_order.color as color,';
			$select.='invtry_purchase_order.model_yr as year,';
			$select.='invtry_purchase_order.po_date as date,';
			$select.='invtry_vehicle.veh_received as received_date,';
			$select.='invtry_purchase_order.po_num as po_num,';
			$select.='invtry_vehicle.vin_num as vin_num,';
			$select.='invtry_vehicle.location as location,';
			$select.='invtry_vehicle.vrr_num as vrr_num,';
			$select.='invtry_vehicle.plant_sales_report as grp_plant,';
			$select.='invtry_vehicle.plant_sales_month as plant_sales_month,';
			$select.='invtry_vehicle.imaps_actual_release_date as iard,';
			$select.='invtry_purchase_order.po_date as po_date,';
			$select.='invtry_purchase_order.remarks as remarks,';
			$select.='invtry_vehicle.alloc_dealer as alloc_dealer,';
			$select.='invtry_vehicle.alloc_date as alloc_date';

			$this->db->select($select);
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('invtry_status','invtry_status.po_number = invtry_purchase_order.po_num','left');
			$this->db->join('invtry_acc_status','invtry_acc_status.po_number = invtry_purchase_order.po_num','left');
			$this->db->where('invtry_purchase_order.model',$model);
      $this->db->where('invtry_status.status',$inv_status);
      $this->db->where('invtry_acc_status.status',$acc_status);
			$this->db->order_by('invtry_vehicle.color ','ASC');

			$query = $this->db->get();
			return $query->result();
		}
		public function ADIR_m3($model,$acc_status)
		{
			$select='invtry_vehicle.cs_num,';
			$select.='invtry_purchase_order.color as color,';
			$select.='invtry_purchase_order.model_yr as year,';
			$select.='invtry_purchase_order.po_date as date,';
			$select.='invtry_vehicle.veh_received as received_date,';
			$select.='invtry_purchase_order.po_num as po_num,';
			$select.='invtry_vehicle.vin_num as vin_num,';
			$select.='invtry_vehicle.location as location,';
			$select.='invtry_vehicle.vrr_num as vrr_num,';
			$select.='invtry_vehicle.plant_sales_report as grp_plant,';
			$select.='invtry_vehicle.plant_sales_month as plant_sales_month,';
			$select.='invtry_vehicle.imaps_actual_release_date as iard,';
			$select.='invtry_purchase_order.po_date as po_date,';
			$select.='invtry_purchase_order.remarks as remarks,';
			$select.='invtry_vehicle.alloc_dealer as alloc_dealer,';
			$select.='invtry_vehicle.alloc_date as alloc_date';

			$this->db->select($select);
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('invtry_status','invtry_status.po_number = invtry_purchase_order.po_num','left');
			$this->db->join('invtry_acc_status','invtry_acc_status.po_number = invtry_purchase_order.po_num','left');
			$this->db->where('invtry_purchase_order.model',$model);
      $this->db->where('invtry_acc_status.status',$acc_status);
			$this->db->order_by('invtry_vehicle.color ','ASC');

			$query = $this->db->get();
			return $query->result();
		}
		public function ADIR_m4($model,$inv_status)
		{
			$select='invtry_vehicle.cs_num,';
			$select.='invtry_purchase_order.color as color,';
			$select.='invtry_purchase_order.model_yr as year,';
			$select.='invtry_purchase_order.po_date as date,';
			$select.='invtry_vehicle.veh_received as received_date,';
			$select.='invtry_purchase_order.po_num as po_num,';
			$select.='invtry_vehicle.vin_num as vin_num,';
			$select.='invtry_vehicle.location as location,';
			$select.='invtry_vehicle.vrr_num as vrr_num,';
			$select.='invtry_vehicle.plant_sales_report as grp_plant,';
			$select.='invtry_vehicle.plant_sales_month as plant_sales_month,';
			$select.='invtry_vehicle.imaps_actual_release_date as iard,';
			$select.='invtry_purchase_order.po_date as po_date,';
			$select.='invtry_purchase_order.remarks as remarks,';

			$this->db->select($select);
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('invtry_status','invtry_status.po_number = invtry_purchase_order.po_num','left');
			$this->db->join('invtry_acc_status','invtry_acc_status.po_number = invtry_purchase_order.po_num','left');
			$this->db->where('invtry_purchase_order.model',$model);
      $this->db->where('invtry_status.status',$inv_status);
			$this->db->order_by('invtry_vehicle.color ','ASC');

			$query = $this->db->get();
			return $query->result();
		}
		public function ADIR_m5($model)
		{
			$select='invtry_vehicle.cs_num,';
			$select.='invtry_purchase_order.color as color,';
			$select.='invtry_purchase_order.model_yr as year,';
			$select.='invtry_purchase_order.po_date as date,';
			$select.='invtry_vehicle.veh_received as received_date,';
			$select.='invtry_purchase_order.po_num as po_num,';
			$select.='invtry_vehicle.vin_num as vin_num,';
			$select.='invtry_vehicle.location as location,';
			$select.='invtry_vehicle.vrr_num as vrr_num,';
			$select.='invtry_vehicle.plant_sales_report as grp_plant,';
			$select.='invtry_vehicle.plant_sales_month as plant_sales_month,';
			$select.='invtry_vehicle.imaps_actual_release_date as iard,';
			$select.='invtry_purchase_order.po_date as po_date,';
			$select.='invtry_purchase_order.remarks as remarks,';

			$this->db->select($select);
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('invtry_status','invtry_status.po_number = invtry_purchase_order.po_num','left');
			$this->db->join('invtry_acc_status','invtry_acc_status.po_number = invtry_purchase_order.po_num','left');
			$this->db->where('invtry_purchase_order.model',$model);
			$this->db->where('invtry_status.status !=','No Vehicle');
			$this->db->where('invtry_acc_status.status !=','No Vehicle');
			$this->db->order_by('invtry_vehicle.color ','ASC');

			$query = $this->db->get();
			return $query->result();
		}
		public function getV($vid,$countDate)
		{
			$this->db->select('cs_num,veh_received,imaps_actual_release_date');
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('product','product.id = invtry_vehicle.model','left');
			$this->db->group_start();
				$this->db->where('invtry_vehicle.imaps_actual_release_date is NULL', NULL, FALSE);
				$this->db->or_where('invtry_vehicle.imaps_actual_release_date !=','0000-00-00');
				$this->db->where('invtry_vehicle.imaps_actual_release_date >','2020-06-30');
			$this->db->group_end();
			$this->db->where('invtry_vehicle.veh_received is NOT NULL', NULL, FALSE);
			$this->db->where('invtry_vehicle.veh_received !=', '0000-00-00');
			$this->db->where('invtry_vehicle.veh_received <=','2020-06-30');
			$this->db->where('product.id',$vid);
			$this->db->where('invtry_purchase_order.testDrive',0);

			$query = $this->db->get();
			return $query->num_rows();
		}
		public function getVs2($nseries,$countDate)
		{
			$this->db->select('cs_num,veh_received,imaps_actual_release_date');
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('product','product.id = invtry_vehicle.model','left');
			$this->db->group_start();
				$this->db->where('invtry_vehicle.imaps_actual_release_date is NULL', NULL, FALSE);
				$this->db->or_where('invtry_vehicle.imaps_actual_release_date !=','0000-00-00');
				$this->db->where('invtry_vehicle.imaps_actual_release_date >','2020-06-30');
			$this->db->group_end();
			$this->db->where('invtry_vehicle.veh_received is NOT NULL', NULL, FALSE);
			$this->db->where('invtry_vehicle.veh_received !=', '0000-00-00');
			$this->db->where('invtry_vehicle.veh_received <=','2020-06-30');
			$this->db->where('product.model_series',$nseries);
			$this->db->where('invtry_purchase_order.testDrive',0);

			$query = $this->db->get();
			return $query->num_rows();
		}
		public function getV2($vid,$countDate)
		{
			$this->db->select('cs_num,veh_received,imaps_actual_release_date');
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->group_start();
				$this->db->where('invtry_vehicle.imaps_actual_release_date is NULL', NULL, FALSE);
				$this->db->or_where('invtry_vehicle.imaps_actual_release_date !=','0000-00-00');
				$this->db->where('invtry_vehicle.imaps_actual_release_date >','2020-06-30');
			$this->db->group_end();
			$this->db->where('invtry_vehicle.veh_received is NOT NULL', NULL, FALSE);
			$this->db->where('invtry_vehicle.veh_received !=', '0000-00-00');
			$this->db->where('invtry_vehicle.veh_received <=','2020-06-30');
			$this->db->where('invtry_purchase_order.model',$vid);
			$this->db->where('invtry_purchase_order.testDrive',0);

			$query = $this->db->get();
			return $query->result();
		}
		public function getV3($vid)
		{
			$this->db->select('cs_num,veh_received,imaps_actual_release_date,testDrive');
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->where('invtry_vehicle.veh_received is NOT NULL', NULL, FALSE);
			$this->db->where('invtry_vehicle.veh_received !=', '0000-00-00');
			$this->db->where('invtry_vehicle.veh_received <=','2020-06-30');
			$this->db->where('invtry_purchase_order.model',$vid);
			$this->db->where('invtry_purchase_order.testDrive',0);
			$this->db->where('invtry_vehicle.imaps_actual_release_date is NULL', NULL, FALSE);

			$query = $this->db->get();
				return $query->num_rows();
		}
		public function getPM($vid,$firstDate,$lastDate)
		{
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('product','product.id = invtry_vehicle.model','left');
			$this->db->where('invtry_vehicle.veh_received >=',$firstDate);
			$this->db->where('invtry_vehicle.veh_received <=',$lastDate);
			$this->db->where('product.id',$vid);
			$this->db->where('invtry_purchase_order.testDrive',0);
			// $this->db->where('invtry_vehicle.imaps_actual_release_date is NULL', NULL, FALSE);

			$query = $this->db->get();
			return $query->num_rows();
		}
		public function getRM($vid,$firstDate,$lastDate)
		{
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('product','product.id = invtry_vehicle.model','left');
			$this->db->where('invtry_vehicle.imaps_actual_release_date >=',$firstDate);
			$this->db->where('invtry_vehicle.imaps_actual_release_date <=',$lastDate);
			$this->db->where('product.id',$vid);
			$this->db->where('invtry_vehicle.imaps_actual_release_date is NOT NULL', NULL, FALSE);
				$this->db->where('invtry_purchase_order.testDrive',0);

			$query = $this->db->get();
			return $query->num_rows();
		}

		public function getBPM($vid,$beginningDate,$totalDate)
		{
			 $this->db->from('invtry_purchase_order');
	 		 $this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			 	$this->db->join('product','product.id = invtry_vehicle.model','left');
	 		 $this->db->where('invtry_vehicle.veh_received >=',$beginningDate);
	 		 $this->db->where('invtry_vehicle.veh_received <=',$totalDate);

	 		 $this->db->where('product.id',$vid);
			 	$this->db->where('invtry_purchase_order.testDrive',0);

	 		 $query = $this->db->get();
	 		 return $query->num_rows();
		}
		public function getBRM($vid,$beginningDate,$totalDate)
		{
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			 $this->db->join('product','product.id = invtry_vehicle.model','left');
			$this->db->where('invtry_vehicle.imaps_actual_release_date >=',$beginningDate);
			$this->db->where('invtry_vehicle.imaps_actual_release_date <',$totalDate);
			$this->db->where('product.id',$vid);
			$this->db->where('invtry_vehicle.imaps_actual_release_date is NOT NULL', NULL, FALSE);
				$this->db->where('invtry_purchase_order.testDrive',0);

			$query = $this->db->get();
			return $query->num_rows();
		}
		public function getPM2($nseries,$firstDate,$lastDate)
		{
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('product','product.id = invtry_vehicle.model','left');
			$this->db->where('invtry_vehicle.veh_received >=',$firstDate);
			$this->db->where('invtry_vehicle.veh_received <=',$lastDate);
			$this->db->where('product.model_series',$nseries);
			$this->db->where('invtry_purchase_order.testDrive',0);
			// $this->db->where('invtry_vehicle.imaps_actual_release_date is NULL', NULL, FALSE);

			$query = $this->db->get();
			return $query->num_rows();
		}
		public function getRM2($nseries,$firstDate,$lastDate)
		{
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('product','product.id = invtry_vehicle.model','left');
			$this->db->where('invtry_vehicle.imaps_actual_release_date >=',$firstDate);
			$this->db->where('invtry_vehicle.imaps_actual_release_date <=',$lastDate);
			$this->db->where('product.model_series',$nseries);
			$this->db->where('invtry_vehicle.imaps_actual_release_date is NOT NULL', NULL, FALSE);
				$this->db->where('invtry_purchase_order.testDrive',0);

			$query = $this->db->get();
			return $query->num_rows();
		}

		public function getBPM2($nseries,$beginningDate,$totalDate)
		{
			 $this->db->from('invtry_purchase_order');
	 		 $this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			 	$this->db->join('product','product.id = invtry_vehicle.model','left');
	 		 $this->db->where('invtry_vehicle.veh_received >=',$beginningDate);
	 		 $this->db->where('invtry_vehicle.veh_received <',$totalDate);

	 		 $this->db->where('product.model_series',$nseries);
	 		 // $this->db->where('invtry_vehicle.imaps_actual_release_date is NULL', NULL, FALSE);
			 	$this->db->where('invtry_purchase_order.testDrive',0);

	 		 $query = $this->db->get();
	 		 return $query->num_rows();
		}
		public function getBRM2($nseries,$beginningDate,$totalDate)
		{
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			 $this->db->join('product','product.id = invtry_vehicle.model','left');
			$this->db->where('invtry_vehicle.imaps_actual_release_date >=',$beginningDate);
			$this->db->where('invtry_vehicle.imaps_actual_release_date <',$totalDate);
			$this->db->where('product.model_series',$nseries);
			$this->db->where('invtry_vehicle.imaps_actual_release_date is NOT NULL', NULL, FALSE);
				$this->db->where('invtry_purchase_order.testDrive',0);

			$query = $this->db->get();
			return $query->num_rows();
		}
		public function series($dealer)
		{
			if($dealer == 'MORRIS GARAGES')
			{
				$dealer='MG';
			}
			$this->db->select('model_series');
			$this->db->from('product');
			$this->db->where('Company',$dealer);
			$this->db->order_by('model_series','ASC');
			$this->db->group_by('model_series');

			$query = $this->db->get();
			return $query->result();
		}

	}
?>
