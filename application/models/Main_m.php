<?php
	class Main_m extends CI_Model
	{
		public function allimportdata()
		{
			$this->db->where('deleted',0);
			$this->db->where('Status !=','Clear');
			$this->db->from('invtry_import_log');

			$query = $this->db->get();
			return $query->result();
		}
		public function info($id)
		{
			$this->db->where('invtry_purchase_order.id',$id);
			$this->db->select('*,invtry_status.status as Status1,invtry_acc_status.status as Status2,');
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_status','invtry_purchase_order.po_num = invtry_status.po_number','left');
			$this->db->join('invtry_acc_status','invtry_purchase_order.po_num = invtry_acc_status.po_number','left');
			$this->db->join('product','invtry_purchase_order.model = product.id','left');
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->result();
		}
		public function deletepo($id)
		{
			$this->db->where('id',$id);
			$this->db->delete('invtry_purchase_order');
		}
		public function findproduct($poid)
		{
			$this->db->where('invtry_purchase_order.po_num',$poid);
			// $this->db->select('*,invtry_status.status as Status,');
			$this->db->from('invtry_purchase_order');
			// $this->db->join('invtry_status','invtry_purchase_order.id = invtry_status.po_id');
			$this->db->join('product','invtry_purchase_order.model = product.id');

			$query = $this->db->get();
			return $query->result();
		}
		public function branch()
		{
			$this->db = $this->load->database('dsar',TRUE);
			$this->db->from('company_branch');
			$this->db->order_by('Company','ASC');

			$query = $this->db->get();
			return $query->result();
		}
		public function podatan($po_num)
		{
			$this->db->from('invtry_purchase_order');
			$this->db->where('po_num',$po_num);

			$query = $this->db->get();
			return $query->result();
		}
		public function getdealers($did)
		{
			$this->db->select('CONCAT(Company," ",Branch) AS "Dealer"');
			$this->db->from('company_branch');
			$this->db->where('id',$did);

			$query = $this->db->get();
			return $query->result();
		}
		public function get_color($model_id)
		{
			$this->db->from('model_color_tb');
			$this->db->where('model_id',$model_id);

			$query = $this->db->get();
			return $query->result();
		}
		public function branch2($ids)
		{
			$this->db->select('*,company_branch.id as id,invtry_access_table.id as access');
			$this->db->where('invtry_access_table.invtry_admin_id',$ids);
			$this->db->where('invtry_access_table.status',1);
			$this->db->from('company_branch');
			$this->db->join('invtry_access_table','company_branch.Company = invtry_access_table.key');
			$this->db->order_by('company_branch.Company','ASC');

			$query = $this->db->get();
			return $query->result();
		}
		public function insertPO($data)
		{
			$this->db->insert('invtry_purchase_order',$data);
			$last_id = $this->db->insert_id();
				return $last_id;
		}
		public function updatePO($data,$poid)
		{
			$this->db->where('id',$poid);
			$this->db->update('invtry_purchase_order',$data);
		}
		public function insertVehicle($data)
		{
			$this->db->insert('invtry_vehicle',$data);
			$last_id = $this->db->insert_id();
    		return $last_id;
		}
		public function purchase_order_num()
		{
			$this->db->where('has_vehicle',0);
			$this->db->from('invtry_purchase_order');

			$query = $this->db->get();
			return $query->result();
		}
		public function checkpurchaseorder($po_id)
		{
			$this->db->where('id',$po_id);
			$this->db->from('invtry_purchase_order');

			$query = $this->db->get();
			return $query->result();
		}
		public function Conf_order($po_id,$dataC)
		{
			$this->db->where('id',$po_id);
			$this->db->update('invtry_purchase_order',$dataC);
		}
		public function checkpurchaseorder2($po_id)
		{
			$this->db->where('purchase_order',$po_id);
			$this->db->from('invtry_vehicle');

			$query = $this->db->get();
			return $query->result();
		}
		public function chkdealer($dealer)
		{
			$this->db->where('invtry_model_table.company',$dealer);
			$this->db->from('invtry_model_table');

			$query = $this->db->get();
			return $query->result();
		}
		public function getInvtryStatus($ponum)
		{
			$this->db->where('invtry_status.po_number',$ponum);
			$this->db->from('invtry_status');

			$query = $this->db->get();
			return $query->result();
		}
		public function models($dealer)
		{
			$this->db->where('licagroup_dsar.company_branch.id',$dealer);
			$this->db->where('k0x6k0o6_test_inventory.product.status','1');
			$this->db->from('licagroup_dsar.company_branch');
			$this->db->join('k0x6k0o6_test_inventory.product','k0x6k0o6_test_inventory.product.Company = licagroup_dsar.company_branch.Company');

			$query = $this->db->get();
			return $query->result();
		}
		public function models3($rdealer)
		{
			$this->db->where('product.Company',$rdealer);
			$this->db->where('product.status','1');
			$this->db->from('product');

			$query = $this->db->get();
			return $query->result();
		}
		public function searchd($dealer)
		{
			$this->db->where('licagroup_dsar.company_branch.id',$dealer);
			$this->db->from('licagroup_dsar.company_branch');

			$query = $this->db->get();
			return $query->result();
		}
		public function models_id($dealer)
		{
			$this->db->where('Company',$dealer);
		  $this->db->where('status','1');
			$this->db->from('product');

			$query = $this->db->get();
			return $query->result();
		}
		public function models2()
		{
			$this->db->where('invtry_model_table.car',1);
			$this->db->from('invtry_model_table');
			$this->db->join('product','invtry_model_table.company = product.Company');

			$query = $this->db->get();
			return $query->result();
		}
		public function infoV($id)
		{
			$this->db->where('id',$id);
			$this->db->from('invtry_vehicle');

			$query = $this->db->get();
			return $query->result();
		}
		public function updateVehicle($data,$vechile_id)
		{
			$this->db->where('id',$vechile_id);
			$this->db->update('invtry_vehicle',$data);
		}
		public function updategrplica($data,$id)
		{
			$this->db->where('vehicle_id',$id);
			$this->db->update('invtry_invoice',$data);
		}
		public function pay_mode()
		{
			$this->db->where('deleted',0);
			$this->db->from('invtry_pay_mode');

			$query = $this->db->get();
			return $query->result();
		}
		public function financier()
		{
			$this->db->where('deleted',0);
			$this->db->from('invtry_financier');

			$query = $this->db->get();
			return $query->result();
		}
		public function insertInvoice($data)
		{
			if($this->db->insert('invtry_invoice',$data))
			{
			    return true;
			}
		}
		public function insertInvoice2($datainv)
		{
			$this->db->insert('invtry_invoice',$datainv);
		}
		public function updateVehicle2($data2,$vechile_id)
		{
			$this->db->where('id',$vechile_id);
			$this->db->update('invtry_vehicle',$data2);
		}
		public function updateVehicle3($data4,$vechile_id)
		{
			$this->db->where('id',$vechile_id);
			$this->db->update('invtry_vehicle',$data4);
		}
		public function checkpo_id($vechile_id)
		{
			$this->db->where('id',$vechile_id);
			$this->db->select('id,purchase_order');
			$this->db->from('invtry_vehicle');

			$query = $this->db->get();
			return $query->result();
		}
		public function updatePO2($data4,$po_number)
		{
			$this->db->where('po_num',$po_number);
			$this->db->update('invtry_purchase_order',$data4);
		}
		public function releasenow($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_vehicle',$data);
		}
		public function getinvoiceid($id)
		{
			$this->db->where('vehicle_id',$id);
			$this->db->from('invtry_invoice');

			$query = $this->db->get();
			return $query->result();
		}
		public function updateINV($data2,$invoiceid)
		{
			$this->db->where('id',$invoiceid);
			$this->db->update('invtry_invoice',$data2);
		}
		public function vehicles()
		{
			$this->db->from('invtry_vehicle');
			$this->db->join('invtry_status','invtry_status.cs_num = invtry_vehicle.cs_num');
			$this->db->where('invtry_status.status','Allocated');
			$this->db->or_where('invtry_status.status','Available');

			$query = $this->db->get();
			return $query->result();
		}
		public function vehicles2()
		{
			// $this->db->where('has_invoice',1);
			$this->db->from('invtry_vehicle');

			$query = $this->db->get();
			return $query->result();
		}

		// public function salesperson()
		// {
		//
		// 	$this->db->where('Position','Sales Consultant');
		// 	$this->db->select('CONCAT(Lname,",",Fname," ",Mname) as Name,id');
		// 	$this->db->from('user');
		//
		// 	$query = $this->db->get();
		// 	return $query->result();
		// }
		public function salesperson3($access)
		{
			$this->db->where('Position','Sales Consultant');
			$this->db->group_start();
			foreach($access as $val)
			{
				$comp=$val->key;
				if($comp == 'MG')
				{
					$comp ='MORRIS GARAGES';
				}else{
					$comp = $comp;
				}
				$this->db->or_where('Company',$comp);
			}
			$this->db->group_end();
			$this->db->select('CONCAT(Lname,",",Fname," ",Mname) as Name,id');
			$this->db->from('user');

			$query = $this->db->get();
			return $query->result();
		}
		public function salesperson2($dealer)
		{
			$this->db->where('Position','Sales Consultant');
			$this->db->group_start();
			$this->db->or_where('Company',$dealer);
			$this->db->group_end();
			$this->db->select('CONCAT(Lname,",",Fname," ",Mname) as Name,id');
			$this->db->from('user');


			$query = $this->db->get();
			return $query->result();
		}
		public function salesperson4($dealer,$location)
		{
			$this->db->where('Position','Sales Consultant');
			$this->db->where('Branch',$location);
			$this->db->group_start();
			$this->db->or_where('Company',$dealer);
			$this->db->group_end();
			$this->db->select('CONCAT(Lname,",",Fname," ",Mname) as Name,id');
			$this->db->from('user');
			$this->db->order_by('id',asc);

			$query = $this->db->get();
			return $query->result();
		}
		public function infoI($id)
		{
			$this->db->where('id',$id);
			$this->db->from('invtry_invoice');

			$query = $this->db->get();
			return $query->result();
		}
		public function updateInvoiceInfo($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_invoice',$data);
		}
		public function cancelU($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_invoice',$data);
		}
		public function getVid($id)
		{
			$this->db->where('id',$id);
			$this->db->from('invtry_invoice');

			$query = $this->db->get();
			return $query->result();
		}
		public function cancelUV($data2,$vid)
		{
			$this->db->where('id',$vid);
			$this->db->update('invtry_vehicle',$data2);
		}
		public function getinfopo($poid)
		{
			$this->db->where('id',$poid);
			$this->db->from('invtry_purchase_order');

			$query = $this->db->get();
			return $query->result();
		}
		public function updateVPO($data2,$po_num)
		{
			$this->db->where('purchase_order',$po_num);
			$this->db->update('invtry_vehicle',$data2);
		}
		public function checkrelease($vid)
		{
			$this->db->where('purchase_order',$vid);
			$this->db->from('invtry_vehicle');

			$query = $this->db->get();
			return $query->result();
		}
		public function updatePOV($data2,$Po_num)
		{
			$this->db->where('id',$Po_num);
			$this->db->update('invtry_purchase_order',$data2);
		}
		public function checkcsnum($csnum)
		{
			$this->db->where('cs_num',$csnum);
			$this->db->where('deleted','0');
			$this->db->from('invtry_vehicle');

			$query = $this->db->get();
			return $query->result();
		}
		public function checkcsnum2($newcsnum)
		{
			$this->db->where('cs_num',$newcsnum);
			$this->db->where('deleted','0');
			$this->db->from('invtry_vehicle');

			$query = $this->db->get();
			return $query->result();
		}
		public function checkinvoicenum($invoicenum)
		{
			$this->db->where('invoice_num',$csnum);
			$this->db->from('invtry_invoice');

			$query = $this->db->get();
			return $query->result();
		}
		public function checkponum($ponum)
		{
			$this->db->where('po_num',$ponum);
			$this->db->where('deleted','0');
			$this->db->from('invtry_purchase_order');

			$query = $this->db->get();
			return $query->result();
		}
		public function poids($poid)
		{
			$this->db->where('id',$poid);
			$this->db->from('invtry_purchase_order');

			$query = $this->db->get();
			return $query->result();
		}
		public function csnum($vid)
		{
			$this->db->where('id',$vid);
			$this->db->select('cs_num');
			$this->db->from('invtry_vehicle');

			$query = $this->db->get();
			return $query->result();
		}
		public function location()
		{
			// $this->db->where('id',$vid);
			// $this->db->select('locat');
			$this->db->select('CONCAT(Company,"-",Branch) as Company,Branch,id');
			$this->db->from('company_branch');

			$query = $this->db->get();
			return $query->result();
		}
		public function location2($accessdealer)
		{
			$this->db->select('CONCAT(Company,"-",Branch) as Company');
			$this->db->from('company_branch');
			foreach($accessdealer as $val)
			{
				$this->db->or_where('Company',$val->key);
			}
			$this->db->order_by('Company','ASC');

			$query = $this->db->get();
			return $query->result();
		}
		public function userCancel($id)
		{
			$this->db->where('id',$id);
			$this->db->select('name');
			$this->db->from('invtry_admin');

			$query = $this->db->get();
			return $query->result();
		}
		public function insertDetails($data)
		{
			$this->db->insert('invtry_ticket',$data);
		}
		public function ChangePassword($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_admin',$data);
		}
		public function infoINV($id)
		{
			$this->db->where('vehicle_id',$id);
			// $this->db->select('locat');
			$this->db->from('invtry_invoice');

			$query = $this->db->get();
			return $query->result();
		}
		public function updateInvoiceNew($datainv,$invoice_id)
		{
			$this->db->where('id',$invoice_id);
			$this->db->update('invtry_invoice',$datainv);
		}
		public function updateVeh($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_vehicle',$data);
		}
		public function assign_cust($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_invoice',$data);
		}
		public function get_veh_inv($id)
		{
			$this->db->where('id',$id);
			$this->db->from('invtry_invoice');

			$query = $this->db->get();
			return $query->result();
		}
		public function update_stats($newdata,$veh_id)
		{

			$this->db->where('id',$veh_id);
			$this->db->update('invtry_vehicle',$newdata);
		}
		public function changeloc($id,$data)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_vehicle',$data);
		}
		public function updatePOs($po_data,$po_id)
		{
			$this->db->where('id',$po_id);
			$this->db->update('invtry_purchase_order',$po_data);
		}
		public function insertStatus($status_data)
		{
			$this->db->insert('invtry_status',$status_data);
		}
		public function insertStatusAC($status_data)
		{
			$this->db->insert('invtry_acc_status',$status_data);
		}
		public function stats($cs,$poid)
		{
			$this->db->where('cs_num',$cs);
			$this->db->where('po_id',$poid);
			$this->db->from('invtry_status');

			$query = $this->db->get();
			return $query->result();
		}
		public function stats2($cs)
		{
			$this->db->where('cs_num',$cs);
			$this->db->from('invtry_status');

			$query = $this->db->get();
			return $query->result();
		}
		public function updateReceive($data,$csnum)
		{
			$this->db->where('cs_num',$csnum);
			$this->db->update('invtry_vehicle',$data);

		}
		public function updateStatus($csnum,$datas)
		{
			$this->db->where('cs_num',$csnum);
			$this->db->update('invtry_status',$datas);
		}
		public function updateIS($po_num,$invtry_status)
		{
			$this->db->where('po_number',$po_num);
			$this->db->update('invtry_status',$invtry_status);
		}
		public function updateIAS($po_num,$invtry_acc_status)
		{
			$this->db->where('po_number',$po_num);
			$this->db->update('invtry_acc_status',$invtry_acc_status);
		}
		// public function updateStatus2($updata,$po_id)
		// {
		// 	$this->db->where('po_id',$po_id);
		// 	$this->db->update('invtry_status',$updata);
		// }
		public function updateStatusNew($datas,$csnum)
		{
			$this->db->where('cs_num',$csnum);
			$this->db->update('invtry_status',$datas);
		}
		public function getvhID($csnum)
		{
			$this->db->where('cs_num',$csnum);
			$this->db->from('invtry_vehicle');

			$query = $this->db->get();
			return $query->result();
		}
		public function updateAllocate($data,$id)
		{
			$this->db->where('vehicle_id',$id);
			$this->db->update('invtry_invoice',$data);
		}
		public function infoInvoice($id)
		{
			$this->db->where('vehicle_id',$id);
			$this->db->from('invtry_invoice');
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->result();
		}
		public function updateInvoice($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_invoice',$data);
		}
		public function getcsnum($vid)
		{
			$this->db->where('id',$vid);
			$this->db->from('invtry_vehicle');

			$query = $this->db->get();
			return $query->result();
		}
		public function dataInfo($id)
		{
			$this->db->where('invtry_vehicle.cs_num',$id);
			$this->db->where('invtry_status.status !=','Released');
			$this->db->from('invtry_vehicle');
			$this->db->join('invtry_invoice','invtry_invoice.vehicle_id = invtry_vehicle.id');
			$this->db->join('invtry_status','invtry_status.cs_num = invtry_vehicle.cs_num');
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->result();
		}
		public function dataInfo1($id)
		{
			$this->db->select('*,invtry_vehicle.model as "model",invtry_vehicle.model_yr as "model_yr",invtry_vehicle.color as "color",invtry_vehicle.cost as "cost"');
			$this->db->where('invtry_vehicle.cs_num',$id);
			$this->db->from('invtry_vehicle');
			$this->db->join('invtry_invoice','invtry_invoice.vehicle_id = invtry_vehicle.id');
			$this->db->join('invtry_status','invtry_status.cs_num = invtry_vehicle.cs_num');
			$this->db->join('invtry_purchase_order','invtry_purchase_order.id = invtry_status.po_id');
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->result();
		}
		public function dataInfo2($id)
		{
			$column='invtry_vehicle.cs_num,';
			$column.='invtry_vehicle.location,';
			$column.='invtry_purchase_order.po_num as purchase_order,';
			$column.='invtry_vehicle.cost,';
			$column.='invtry_vehicle.vrr_num,';
			$column.='invtry_vehicle.veh_received,';
			$column.='invtry_vehicle.csr_received,';
			$column.='invtry_vehicle.paid_date,';
			$column.='invtry_vehicle.model,';
			$column.='invtry_vehicle.model_yr,';
			$column.='invtry_vehicle.color,';
			$column.='invtry_vehicle.vin_num,';
			$column.='invtry_vehicle.engine_num,';
			$column.='invtry_vehicle.prod_num,';
			$column.='invtry_vehicle.remarks,';
			$column.='invtry_invoice.first_name,';
			$column.='invtry_invoice.middle_name,';
			$column.='invtry_invoice.last_name,';
			$column.='invtry_invoice.company,';
			$column.='invtry_invoice.invoice_num,';
			$column.='invtry_invoice.invoice_date,';
			$column.='invtry_invoice.pay_amt,';
			$column.='invtry_invoice.alloc_date,';
			$column.='invtry_vehicle.subsidy,';
			$column.='invtry_invoice.term,';
			$column.='invtry_invoice.bank,';
			$column.='invtry_invoice.grp_lica,';
			$column.='invtry_invoice.grp_plant,';
			$column.='invtry_invoice.plant_release_date,';
			$column.='invtry_invoice.system_release_date,';
			$column.='invtry_invoice.actual_release_date,';
			$column.='invtry_purchase_order.whole_sale_period,';
			$column.='CONCAT(user.Lname,",",user.Fname," ",user.Mname) as salesperson';

			$this->db->select($column);
			$this->db->where('invtry_vehicle.cs_num',$id);
			$this->db->from('invtry_vehicle');
			$this->db->join('invtry_invoice','invtry_invoice.vehicle_id = invtry_vehicle.id');
			$this->db->join('invtry_status','invtry_status.cs_num = invtry_vehicle.cs_num');
			$this->db->join('invtry_purchase_order','invtry_status.po_id = invtry_purchase_order.id');
			$this->db->join('user','user.id = invtry_invoice.salesperson');
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->result();
		}
		public function dataInfo3($id)
		{
			$column='invtry_vehicle.cs_num,';
			$column.='invtry_vehicle.location,';
			$column.='invtry_purchase_order.po_num as purchase_order,';
			$column.='invtry_vehicle.cost,';
			$column.='invtry_vehicle.vrr_num,';
			$column.='invtry_vehicle.veh_received,';
			$column.='invtry_vehicle.csr_received,';
			$column.='invtry_vehicle.paid_date,';
			$column.='invtry_vehicle.model,';
			$column.='invtry_vehicle.model_yr,';
			$column.='invtry_vehicle.color,';
			$column.='invtry_vehicle.vin_num,';
			$column.='invtry_vehicle.engine_num,';
			$column.='invtry_vehicle.prod_num,';
			$column.='invtry_vehicle.remarks,';
			$column.='invtry_invoice.first_name,';
			$column.='invtry_invoice.middle_name,';
			$column.='invtry_invoice.last_name,';
			$column.='invtry_invoice.company,';
			$column.='invtry_invoice.invoice_num,';
			$column.='invtry_invoice.invoice_date,';
			$column.='invtry_invoice.pay_amt,';
			$column.='invtry_invoice.alloc_date,';
			$column.='invtry_vehicle.subsidy,';
			$column.='invtry_invoice.term,';
			$column.='invtry_invoice.bank,';
			$column.='invtry_invoice.grp_lica,';
			$column.='invtry_invoice.grp_plant,';
			$column.='invtry_invoice.plant_release_date,';
			$column.='invtry_invoice.system_release_date,';
			$column.='invtry_invoice.actual_release_date,';
			$column.='invtry_purchase_order.whole_sale_period,';
			$column.='invtry_invoice.salesperson';

			$this->db->select($column);
			$this->db->where('invtry_vehicle.cs_num',$id);
			$this->db->from('invtry_vehicle');
			$this->db->join('invtry_invoice','invtry_invoice.vehicle_id = invtry_vehicle.id');
			$this->db->join('invtry_status','invtry_status.cs_num = invtry_vehicle.cs_num');
			$this->db->join('invtry_purchase_order','invtry_status.po_id = invtry_purchase_order.id');
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->result();
		}
		public function Csalesperson($id)
		{
			$column='invtry_invoice.salesperson';
			$this->db->select($column);
			$this->db->where('invtry_vehicle.cs_num',$id);
			$this->db->from('invtry_vehicle');
			$this->db->join('invtry_invoice','invtry_invoice.vehicle_id = invtry_vehicle.id');
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->result();
		}
		public function updateinfo($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_vehicle',$data);
		}
		public function updateinfo2($datainv,$id)
		{
			$this->db->where('vehicle_id',$id);
			$this->db->update('invtry_invoice',$datainv);
		}
		public function po_datas($firstdate,$lastdate)
		{

			$column='invtry_invoice.first_name,';
			$column.='invtry_invoice.middle_name,';
			$column.='invtry_invoice.last_name,';
			$column.='invtry_vehicle.cs_num,';
			$column.='product.Product,';
			$column.='invtry_vehicle.color,';
			$column.='invtry_vehicle.prod_num,';
			$column.='invtry_vehicle.engine_num,';
			$column.='invtry_vehicle.vin_num,';
			$column.='invtry_vehicle.model_yr,';
			$column.='CONCAT(company_branch.Company," ",company_branch.Branch) as dealer,';
			$column.='invtry_purchase_order.po_num,';
			$column.='invtry_purchase_order.po_date,';
			$column.='invtry_vehicle.paid_date,';
			$column.='invtry_vehicle.posted_date,';
			$column.='invtry_vehicle.subsidy,';
			$column.='invtry_vehicle.cost,';
			$column.='invtry_invoice.term,';
			$column.='invtry_invoice.bank,';
			$column.='invtry_vehicle.vrr_num,';
			$column.='invtry_vehicle.veh_received,';
			$column.='invtry_vehicle.csr_received,';
			$column.='invtry_invoice.alloc_date,';
			$column.='invtry_invoice.salesperson,';
			$column.='invtry_invoice.grp_lica,';
			$column.='invtry_invoice.grp_plant,';
			$column.='invtry_invoice.invoice_date,';
			$column.='invtry_invoice.invoice_num,';
			$column.='invtry_invoice.actual_release_date,';
			$column.="DATE_FORMAT(invtry_invoice.system_release_date,'%m-%Y'),";
			$column.="DATE_FORMAT(invtry_invoice.plant_release_date,'%m-%Y'),";
			$column.='invtry_status.status,';
			$column.='invtry_vehicle.location,';
			$column.='invtry_vehicle.remarks,';
			$column.='invtry_invoice.company,';
			$column.="DATE_FORMAT(invtry_purchase_order.whole_sale_period,'%m-%Y'),";
			$column.='invtry_invoice.pay_amt,';
			// $column.='(SELECT CONTACT(Company,' ',Branch) as dealer from company_branch where id=);

			$this->db->select($column, false);
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('invtry_invoice','invtry_invoice.vehicle_id =invtry_vehicle.id','left');
			$this->db->join('invtry_status','invtry_status.po_id = invtry_purchase_order.id','left');
			$this->db->join('company_branch','company_branch.id = invtry_purchase_order.dealer','left');
			$this->db->join('product','product.id = invtry_vehicle.model','left');
			$this->db->where('invtry_purchase_order.deleted',0);
			$this->db->group_by('invtry_status.id');


			$query = $this->db->get();
			return $query->result();
		}
		public function po_datas2($whdealer,$firstdate,$lastdate)
		{
			$column='invtry_invoice.first_name,';
			$column.='invtry_invoice.middle_name,';
			$column.='invtry_invoice.last_name,';
			$column.='invtry_vehicle.cs_num,';
			$column.='product.Product,';
			$column.='invtry_vehicle.color,';
			$column.='invtry_vehicle.prod_num,';
			$column.='invtry_vehicle.engine_num,';
			$column.='invtry_vehicle.vin_num,';
			$column.='invtry_vehicle.model_yr,';
			$column.='CONCAT(company_branch.Company," ",company_branch.Branch) as dealer,';
			$column.='invtry_purchase_order.po_num,';
			$column.='invtry_purchase_order.po_date,';
			$column.='invtry_vehicle.paid_date,';
			$column.='invtry_vehicle.posted_date,';
			$column.='invtry_vehicle.subsidy,';
			$column.='invtry_vehicle.cost,';
			$column.='invtry_invoice.term,';
			$column.='invtry_invoice.bank,';
			$column.='invtry_vehicle.vrr_num,';
			$column.='invtry_vehicle.veh_received,';
			$column.='invtry_vehicle.csr_received,';
			$column.='invtry_invoice.alloc_date,';
			$column.='invtry_invoice.salesperson,';
			$column.='invtry_invoice.grp_lica,';
			$column.='invtry_invoice.grp_plant,';
			$column.='invtry_invoice.invoice_date,';
			$column.='invtry_invoice.invoice_num,';
			$column.='invtry_invoice.actual_release_date,';
			$column.="DATE_FORMAT(invtry_invoice.system_release_date,'%m-%Y'),";
			$column.="DATE_FORMAT(invtry_invoice.plant_release_date,'%m-%Y'),";
			$column.='invtry_status.status,';
			$column.='invtry_vehicle.location,';
			$column.='invtry_vehicle.remarks,';
			$column.='invtry_invoice.company,';
			$column.="DATE_FORMAT(invtry_purchase_order.whole_sale_period,'%m-%Y'),";
			$column.='invtry_invoice.pay_amt,';
			// $column.='(SELECT CONTACT(Company,' ',Branch) as dealer from company_branch where id=);

			$this->db->select($column, false);
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('invtry_invoice','invtry_invoice.vehicle_id =invtry_vehicle.id','left');
			$this->db->join('invtry_status','invtry_status.po_id = invtry_purchase_order.id','left');
			$this->db->join('company_branch','company_branch.id = invtry_purchase_order.dealer','left');
			$this->db->join('product','product.id = invtry_vehicle.model','left');
			$this->db->where('invtry_purchase_order.deleted',0);
			$this->db->where('invtry_purchase_order.po_date >=',$firstdate);
			$this->db->where('invtry_purchase_order.po_date <=',$lastdate);
			$this->db->group_start();
			foreach($whdealer as $vs)
			{
				$this->db->or_where('invtry_purchase_order.dealer',$vs);
			}
			$this->db->group_end();

			$this->db->group_by('invtry_status.id');


			$query = $this->db->get();
			return $query->result();
		}
		public function po_datas3()
		{

			$column='invtry_invoice.first_name,';
			$column.='invtry_invoice.middle_name,';
			$column.='invtry_invoice.last_name,';
			$column.='invtry_vehicle.cs_num,';
			$column.='product.Product,';
			$column.='invtry_vehicle.color,';
			$column.='invtry_vehicle.prod_num,';
			$column.='invtry_vehicle.engine_num,';
			$column.='invtry_vehicle.vin_num,';
			$column.='invtry_vehicle.model_yr,';
			$column.='CONCAT(company_branch.Company," ",company_branch.Branch) as dealer,';
			$column.='invtry_purchase_order.po_num,';
			$column.='invtry_purchase_order.po_date,';
			$column.='invtry_vehicle.paid_date,';
			$column.='invtry_vehicle.posted_date,';
			$column.='invtry_vehicle.subsidy,';
			$column.='invtry_vehicle.cost,';
			$column.='invtry_invoice.term,';
			$column.='invtry_invoice.bank,';
			$column.='invtry_vehicle.vrr_num,';
			$column.='invtry_vehicle.veh_received,';
			$column.='invtry_vehicle.csr_received,';
			$column.='invtry_invoice.alloc_date,';
			$column.='invtry_invoice.salesperson,';
			$column.='invtry_invoice.grp_lica,';
			$column.='invtry_invoice.grp_plant,';
			$column.='invtry_invoice.invoice_date,';
			$column.='invtry_invoice.invoice_num,';
			$column.='invtry_invoice.actual_release_date,';
			$column.="DATE_FORMAT(invtry_invoice.system_release_date,'%m-%Y'),";
			$column.="DATE_FORMAT(invtry_invoice.plant_release_date,'%m-%Y'),";
			$column.='invtry_status.status,';
			$column.='invtry_vehicle.location,';
			$column.='invtry_vehicle.remarks,';
			$column.='invtry_invoice.company,';
			$column.="DATE_FORMAT(invtry_purchase_order.whole_sale_period,'%m-%Y'),";
			$column.='invtry_invoice.pay_amt,';
			// $column.='(SELECT CONTACT(Company,' ',Branch) as dealer from company_branch where id=);

			$this->db->select($column, false);
			// $this->db->from('invtry_status');
			// $this->db->join('invtry_purchase_order','invtry_purchase_order.id = invtry_status.po_id','left');
			// $this->db->join('invtry_vehicle','invtry_vehicle.cs_num = invtry_status.cs_num','left');
			// $this->db->join('invtry_invoice','invtry_invoice.invoice_num = invtry_status.inv_num','left');
			// $this->db->join('company_branch','invtry_purchase_order.dealer = company_branch.id','left');
			// $this->db->join('product','invtry_vehicle.model = product.id','left');
			// $this->db->where('invtry_purchase_order.deleted',0);
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('invtry_invoice','invtry_invoice.vehicle_id =invtry_vehicle.id','left');
			$this->db->join('invtry_status','invtry_status.po_id = invtry_purchase_order.id','left');
			$this->db->join('company_branch','company_branch.id = invtry_purchase_order.dealer','left');
			$this->db->join('product','product.id = invtry_vehicle.model','left');
			$this->db->where('invtry_purchase_order.deleted',0);
			$this->db->group_by('invtry_status.id');


			$query = $this->db->get();
			return $query->result();
		}
		public function po_datas4($whdealer)
		{
			$column='invtry_invoice.first_name,';
			$column.='invtry_invoice.middle_name,';
			$column.='invtry_invoice.last_name,';
			$column.='invtry_vehicle.cs_num,';
			$column.='product.Product,';
			$column.='invtry_vehicle.color,';
			$column.='invtry_vehicle.prod_num,';
			$column.='invtry_vehicle.engine_num,';
			$column.='invtry_vehicle.vin_num,';
			$column.='invtry_vehicle.model_yr,';
			$column.='CONCAT(company_branch.Company," ",company_branch.Branch) as dealer,';
			$column.='invtry_purchase_order.po_num,';
			$column.='invtry_purchase_order.po_date,';
			$column.='invtry_vehicle.paid_date,';
			$column.='invtry_vehicle.posted_date,';
			$column.='invtry_vehicle.subsidy,';
			$column.='invtry_vehicle.cost,';
			$column.='invtry_invoice.term,';
			$column.='invtry_invoice.bank,';
			$column.='invtry_vehicle.vrr_num,';
			$column.='invtry_vehicle.veh_received,';
			$column.='invtry_vehicle.csr_received,';
			$column.='invtry_invoice.alloc_date,';
			$column.='invtry_invoice.salesperson,';
			$column.='invtry_invoice.grp_lica,';
			$column.='invtry_invoice.grp_plant,';
			$column.='invtry_invoice.invoice_date,';
			$column.='invtry_invoice.invoice_num,';
			$column.='invtry_invoice.actual_release_date,';
			$column.="DATE_FORMAT(invtry_invoice.system_release_date,'%m-%Y'),";
			$column.="DATE_FORMAT(invtry_invoice.plant_release_date,'%m-%Y'),";
			$column.='invtry_status.status,';
			$column.='invtry_vehicle.location,';
			$column.='invtry_vehicle.remarks,';
			$column.='invtry_invoice.company,';
			$column.="DATE_FORMAT(invtry_purchase_order.whole_sale_period,'%m-%Y'),";
			$column.='invtry_invoice.pay_amt,';
			// $column.='(SELECT CONTACT(Company,' ',Branch) as dealer from company_branch where id=);

			$this->db->select($column, false);
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id','left');
			$this->db->join('invtry_invoice','invtry_invoice.vehicle_id =invtry_vehicle.id','left');
			$this->db->join('invtry_status','invtry_status.po_id = invtry_purchase_order.id','left');
			$this->db->join('company_branch','company_branch.id = invtry_purchase_order.dealer','left');
			$this->db->join('product','product.id = invtry_vehicle.model','left');
			$this->db->where('invtry_purchase_order.deleted',0);
			$this->db->group_start();
			foreach($whdealer as $vs)
			{
				$this->db->or_where('invtry_purchase_order.dealer',$vs);
			}
			$this->db->group_end();

			$this->db->group_by('invtry_status.id');


			$query = $this->db->get();
			return $query->result();
		}
		public function bank()
		{
			$this->db->from('bank_list');

			$query = $this->db->get();
			return $query->result();
		}
		public function m_access($id)
		{
			$this->db->where('invtry_admin_id',$id);
			$this->db->where('status',1);
			$this->db->from('invtry_access_table');

			$query = $this->db->get();
			return $query->result();
		}
		public function newid($dealer){
			$this->db->group_start();
			foreach($dealer as $value)
			{
				$this->db->or_where('Company',$value);
			}
			$this->db->group_end();
			$this->db->from('company_branch');

			$query = $this->db->get();
			return $query->result();
		}
		public function newid2($dealer){
			$this->db->or_where('Company',$dealer);

			$this->db->from('company_branch');

			$query = $this->db->get();
			return $query->result();
		}
		public function close($id,$data)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_purchase_order',$data);
		}
		public function open($id,$data)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_purchase_order',$data);
		}
		public function purchase_order_num2()
		{
			// $this->db->where('id !=',$po_id);
			// $this->db->where('has_vehicle',0);
			$this->db->from('invtry_purchase_order');

			$query = $this->db->get();
			return $query->result();
		}
		public function getdealer($csnum)
		{
			$this->db->where('invtry_status.cs_num',$csnum);
			$this->db->from('invtry_status');
			$this->db->join('invtry_purchase_order','invtry_purchase_order.id = invtry_status.po_id');

			$query = $this->db->get();
			return $query->result();
		}
		public function paymodes()
		{
			$this->db->from('paymodes');
			$query = $this->db->get();
			return $query->result();
		}
		public function getdealer5($po_num)
		{
			$this->db->where('invtry_purchase_order.id',$po_num);
			$this->db->from('invtry_purchase_order');
			$this->db->join('company_branch','company_branch.id = invtry_purchase_order.dealer');

			$query = $this->db->get();
			return $query->result();
		}
		public function dealer2($id)
		{
			$this->db->select('CONCAT(company_branch.Company,"-",Branch)  AS Company,company_branch.id,Branch AS branch');
			$this->db->from('company_branch');
			$this->db->join('invtry_access_table','invtry_access_table.key = company_branch.Company');
			$this->db->where('invtry_admin_id',$id);
			$this->db->where('status',1);

			$query = $this->db->get();
			return $query->result();
		}
		// public function dealer2($id)
		// {
		// 	$this->db->select('CONCAT(company_branch.Company,"-",Branch)  AS Company,company_branch.id,Branch AS branch');
		// 	$this->db->from('company_branch');
		// 	$this->db->join('invtry_access_table','invtry_access_table.key = company_branch.Company');
		// 	$this->db->where('invtry_admin_id',$id);
		// 	$this->db->where('status',1);
		//
		// 	$query = $this->db->get();
		// 	return $query->result();
		// }
		// public function dealer()
		// {
			// $this->db->select('CONCAT(invtry_model_table.company,"-",branch)  AS Company,company_branch.id,branch');
			// $this->db->from('invtry_model_table');
			// $this->db->join('company_branch','company_branch.Company = invtry_model_table.company','');
			//
			// $query = $this->db->get();
			// return $query->result();
		// }
		public function dealer()
		{
			// $this->db = $this->load->database('dsar',TRUE);
			$this->db->select('CONCAT(Company,"-",Branch)  AS Company,id,Branch');
			$this->db->from('company_branch');

			$query = $this->db->get();
			return $query->result();
		}
		public function ILog($id)
		{
			$this->db->where('added_by',$id);
			$this->db->from('import_log_table');

			$query = $this->db->get();
			return $query->result();
		}

		public function Searchpo($ponumber)
		{
			$this->db->where('po_num',$ponumber);
			$this->db->where('deleted','0');
			$this->db->from('invtry_purchase_order');

			$query = $this->db->get();
			return $query->result();
		}
		public function Searchcs($csnumber)
		{
			$this->db->where('cs_num',$csnumber);
			$this->db->where('deleted','0');
			$this->db->from('invtry_vehicle');

			$query = $this->db->get();
			return $query->result();
		}
		public function Searchinv($invnumber)
		{
			$this->db->where('invoice_num',$invnumber);
			$this->db->from('invtry_invoice');

			$query = $this->db->get();
			return $query->result();
		}
		public function vudatas($csnum,$vudata)
		{
			$this->db->where('cs_num',$csnum);
			$this->db->update('invtry_vehicle',$vudata);
		}
		public function grp($vids)
		{
			$this->db->select('grp_lica');
			$this->db->where('vehicle_id',$vids);
			$this->db->from('invtry_invoice');

			$query = $this->db->get();
			return $query->result();
		}
		public function ndealer($ids)
		{
			$this->db->select('grp_lica');
			$this->db->where('vehicle_id',$ids);
			$this->db->from('invtry_invoice');

			$query = $this->db->get();
			return $query->result();
		}
		public function gndealer($k)
		{
			$this->db->select('CONCAT(Company," ",Branch) as newdealer');
			$this->db->where('id',$k);
			$this->db->from('company_branch');

			$query = $this->db->get();
			return $query->result();
		}
		public function clrs($data)
		{
			$this->db->where('deleted',0);
			$this->db->update('invtry_import_data',$data);
		}
		public function dv($data1,$csnum)
		{
			$this->db->where('cs_num',$csnum);
		  $this->db->update('invtry_vehicle',$data1);
		}
		public function deleteVehicle($csnum)
		{
			$this->db->where('cs_num',$csnum);
			$this->db->delete('invtry_vehicle');
		}
		public function deleteVehicle2($data2,$ponum)
		{
			$this->db->where('po_number',$ponum);
			$this->db->update('invtry_status',$data2);
		}
		public function deleteVehicle3($data2,$ponum)
		{
			$this->db->where('po_number',$ponum);
			$this->db->update('invtry_acc_status',$data2);
		}
		public function updateVStatus($ponum,$data)
		{
			$this->db->where('po_num',$ponum);
			$this->db->update('invtry_purchase_order',$data);
		}
		public function pu($data2,$poid)
		{
			$this->db->where('po_num',$poid);
		  $this->db->update('invtry_purchase_order',$data2);
		}
		public function dp($id,$data)
		{
			$this->db->where('id',$id);
		  $this->db->update('invtry_purchase_order',$data);
		}
		public function po_numbers()
		{
			$this->db->select('po_num,id');
			$this->db->from('invtry_purchase_order');
			$this->db->where('has_vehicle',1);

			$query = $this->db->get();
			return $query->result();
		}
		public function fcpo($id)
		{
			$this->db->select('po_num');
			$this->db->from('selected_po_fc');
			$this->db->where('po_num',$id);
			$this->db->where('status',1);

			$query = $this->db->get();
			return $query->result();
		}
		public function checkfc()
		{
			$this->db->from('invtry_fc_table');
			$this->db->order_by('fc_id','desc');
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->result();
		}
		public function addFc($data)
		{
			$this->db->insert('invtry_fc_table',$data);
		}
		public function addSelected($data)
		{
			$this->db->insert('selected_po_fc',$data);
			$last_id = $this->db->insert_id();
			return $last_id;
		}
		public function SelectedPO($ponum)
		{
			$this->db->select('*,invtry_purchase_order.date_added as da,invtry_purchase_order.id as pid');
			$this->db->from('invtry_purchase_order');
			$this->db->join('invtry_vehicle','invtry_vehicle.purchase_order = invtry_purchase_order.id');
			$this->db->where('invtry_purchase_order.id',$ponum);

			$query = $this->db->get();
			return $query->result();
		}
		public function updateSelected($data,$val)
		{
			$this->db->where('id',$val);
			$this->db->update('selected_po_fc',$data);
		}
		public function POFCCheck($ponum)
		{
			$this->db->where('po_num',$ponum);
			$this->db->where('status',1);
			$this->db->from('selected_po_fc');

			$query = $this->db->get();
			return $query->result();
		}
		public function updateFC($fc_number,$data)
		{
			$this->db->where('fc_number',$fc_number);
			$this->db->update('invtry_fc_table',$data);
		}
		public function search($ponum)
		{
			$this->db->where('status',1);
			$this->db->where('po_num',$ponum);
			$this->db->from('selected_po_fc');

			$query = $this->db->get();
			return $query->result();
		}
		public function productI($modelid)
		{
			$this->db->where('id',$modelid);
			$this->db->from('product');

			$query = $this->db->get();
			return $query->result();
		}
		public function productS($model)
		{
			$this->db->where('product',$model);
			$this->db->from('product');

			$query = $this->db->get();
			return $query->result();
		}
		public function Iedatalog($id)
	{
		$this->db->where('log_id',$id);
		$this->db->from('invtry_import_log');

		$query = $this->db->get();
		return $query->result();
	}
	public function fpo($po_num)
	{
		$this->db->where('po_num',$po_num);
		$this->db->from('invtry_purchase_order');

		$query = $this->db->get();
		return $query->result();
	}
	public function fcs($cs_num)
	{
		$this->db->where('cs_num',$cs_num);
		$this->db->from('invtry_vehicle');

		$query = $this->db->get();
		return $query->result();
	}
	public function finv($inv_id)
	{
		$this->db->where('invoice_num',$inv_id);
		$this->db->from('invtry_invoice');

		$query = $this->db->get();
		return $query->result();
	}
	public function updatePoIE($po_data_up,$po_id)
	{
		$this->db->where('id',$po_id);
		$this->db->update('invtry_purchase_order',$po_data_up);
	}
	public function updateVIE($v_data_up,$cs_id)
	{
		$this->db->where('id',$cs_id);
		$this->db->update('invtry_vehicle',$v_data_up);
	}
	public function updateINVIE($i_data_up,$inv_id)
	{
		$this->db->where('id',$inv_id);
		$this->db->update('invtry_invoice',$i_data_up);
	}
	public function updateTI($data,$id)
	{
		$this->db->where('log_id',$id);
		$this->db->update('invtry_import_log',$data);
	}
	public function updateStatusIE($id,$updata)
	{
		$this->db->where('log_id',$id);
		$this->db->update('invtry_import_log',$updata);
	}
	public function getmodelN($id)
	{
		$this->db->where('invtry_vehicle.cs_num',$id);
		$this->db->from('invtry_vehicle');
		// $this->db->join('invtry_invoice','invtry_invoice.vehicle_id = invtry_vehicle.id');
		// $this->db->join('invtry_status','invtry_status.cs_num = invtry_vehicle.cs_num');
		// $this->db->join('invtry_purchase_order','invtry_purchase_order.id = invtry_status.po_id');
		$this->db->limit(1);

		$query = $this->db->get();
		return $query->result();
	}
	public function getcolorN($model)
	{
		$this->db->where('model_color_tb.model_id',$model);
		$this->db->from('model_color_tb');

		$query = $this->db->get();
		return $query->result();
	}
	public function brands()
	{
		$this->db->from('company_branch');
		$this->db->group_by('Company');

		$query = $this->db->get();
		return $query->result();

	}
	public function Brands3($brand)
	{
		$this->db->select('Branch');
		$this->db->from('company_branch');
		$this->db->where('Company',$brand);

		$query = $this->db->get();
		return $query->result();
	}
	public function updateCS($data,$csnum)
	{
		$this->db->where('cs_num',$csnum);
		$this->db->update('invtry_vehicle',$data);
	}
	public function modelSearch($model)
	{
		$this->db->from('product');
		$this->db->where('Product',$model);

		$query = $this->db->get();
		return $query->result();
	}
	public function poSearch($po_num)
	{
		$this->db->from('invtry_purchase_order');
		$this->db->where('po_num',$po_num);

		$query = $this->db->get();
		return $query->result();
	}
	public function csSearch($cs_num)
	{
		$this->db->from('invtry_vehicle');
		$this->db->where('cs_num',$cs_num);

		$query = $this->db->get();
		return $query->result();
	}
	public function importD($importdata)
	{
		$this->db->insert('invtry_import_data',$importdata);
	}
	public function insert_po($podata)
	{
		$this->db->insert('invtry_purchase_order',$podata);
		$last_id = $this->db->insert_id();
		return $last_id;
	}
	public function insert_cs($csdata)
	{
		$this->db->insert('invtry_vehicle',$csdata);
	}
	public function invtry_status($Statusdata)
	{
		$this->db->insert('invtry_status',$Statusdata);
	}
	public function invtry_acc_status($accStatusdata)
	{
		$this->db->insert('invtry_acc_status',$accStatusdata);
	}
	public function addLoc($dealer,$data)
	{
		$this->db->where('Company',$dealer);
		$this->db->insert('company_branch',$data);
	}
	public function getallcs()
	{
		$this->db->from('invtry_vehicle');

		$query = $this->db->get();
		return $query->result();
	}
	public function deleteConnectedV($id)
	{
		$this->db->where('purchase_order',$id);
		$this->db->delete('invtry_vehicle');
	}
	public function checkLoc($dealer,$location)
	{
		$this->db->from('company_branch');
		$this->db->where('Company',$dealer);
		$this->db->where('Branch',$location);

		$query = $this->db->get();
		return $query->result();
	}
	public function checkApproved($model_id,$po_model_color)
	{
		$this->db->from('invtry_for_approval_table');
		$this->db->where('approved_intransit >',0);
		$this->db->where('variant',$model_id);
		$this->db->where('color',$po_model_color);

		$query = $this->db->get();
		return $query->num_rows();
	}
		public function updateApproved($model_id,$po_model_color)
		{
			$quantity=1;
			$this->db->set('approved_intransit', 'approved_intransit-'. $quantity.'',false);
			$this->db->set('quantity', 'quantity-'. $quantity.'',false);
			$this->db->set('total_projected_inventory', 'total_projected_inventory-'. $quantity.'',false);
			$this->db->where('variant', $model_id);
			$this->db->where('color', $po_model_color);
			$this->db->update('invtry_for_approval_table');
		}

		public function deletepostatus($ponum)
		{
			$this->db->where('po_number',$ponum);
			$this->db->delete('invtry_status');
		}
		public function deletepostatus2($ponum)
		{
			$this->db->where('po_number',$ponum);
			$this->db->delete('invtry_acc_status');
		}

	}
?>
