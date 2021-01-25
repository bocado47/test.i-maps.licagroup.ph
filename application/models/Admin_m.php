<?php
	class Admin_m extends CI_Model
	{
		public function bankid($id)
		{
			$this->db->where('id',$id);
			$this->db->from('bank_list');

			$query = $this->db->get();
			return $query->result();
		}
		public function editbank($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('bank_list',$data);
		}
		public function access()
		{
			$this->db->from('invtry_model_table');

			$query = $this->db->get();
			return $query->result();
		}
		public function getaccess($ids)
		{
			$this->db->select('key');
			$this->db->from('invtry_access_table');
			$this->db->where('invtry_admin_id',$ids);
			$this->db->where('status',1);

			$query = $this->db->get();
			return $query->result();
		}
		public function access2()
		{
			$this->db->select('Company');
			$this->db->from('product');
			$this->db->group_by('Company');

			$query = $this->db->get();
			return $query->result();
		}
		public function insertUser($data)
		{
			$this->db->insert('invtry_admin',$data);
			$last_id = $this->db->insert_id();
    		return $last_id;
		}
		public function dataAcs($dataAccess)
		{
			$this->db->insert('invtry_access_table',$dataAccess);
		}
		public function dataAcs2($dataAccess2)
		{
			$this->db->insert('invtry_access_table',$dataAccess2);
		}
		public function userprofile($id)
		{
			$this->db->where('id',$id);
			$this->db->from('invtry_admin');

			$query = $this->db->get();
			return $query->result();
		}
		public function update_user($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_admin',$data);
		}
		public function useraccessdata($id)
		{
			$this->db->where('invtry_admin_id',$id);
			$this->db->where('status',1);
			$this->db->from('invtry_access_table');

			$query = $this->db->get();
			return $query->result();
		}
		public function branch2($ids)
		{
			$this->db->where('invtry_access_table.invtry_admin_id',$ids);
			$this->db->from('invtry_model_table');
			$this->db->join('invtry_access_table','invtry_model_table.company = invtry_access_table.key');

			$query = $this->db->get();
			return $query->result();
		}
		public function check_inv_num($invoice_num)
		{
			$this->db->where('invoice_num',$invoice_num);
			$this->db->from('invtry_invoice');

			$query = $this->db->get();
			return $query->result();
		}
		public function check_po_id($ponum)
		{
			$this->db->where('po_num',$ponum);
			$this->db->where('deleted',0);
			$this->db->from('invtry_purchase_order');

			$query = $this->db->get();
			return $query->result();
		}
		public function check_cs_num($csnum)
		{
			$this->db->where('invtry_vehicle.cs_num',$csnum);
			$this->db->where('invtry_purchase_order.deleted',0);
			$this->db->from('invtry_vehicle');
			$this->db->join('invtry_purchase_order','invtry_purchase_order.id = invtry_vehicle.purchase_order','left');

			$query = $this->db->get();
			return $query->result();
		}
		public function insert_po($po_array)
		{
			$this->db->insert('invtry_purchase_order',$po_array);
			$last_id = $this->db->insert_id();
    		return $last_id;
		}
		public function insert_vehicle($v_array)
		{
			$this->db->insert('invtry_vehicle',$v_array);
			$last_id = $this->db->insert_id();
    		return $last_id;
		}
		public function update_po($po_data_update,$ponum)
		{
			$this->db->where('po_num',$ponum);
			$this->db->update('invtry_purchase_order',$po_data_update);
		}
		public function update_vehicle($vehicle_data,$csnum)
		{
			$this->db->where('cs_num',$csnum);
			$this->db->update('invtry_vehicle',$vehicle_data);
		}
		public function add_new_model($product_data)
		{
			$this->db->insert('product',$product_data);
		}
		public function updateAcs($dataAccess3,$invtry_admin_id,$company)
		{
			$this->db->where('invtry_admin_id',$invtry_admin_id);
			$this->db->where('key',$company);
			$this->db->update('invtry_access_table',$dataAccess3);
		}
		public function MakeAccess($string_array,$data1,$id)
		{
			$this->db->where('invtry_admin_id',$id);
			$this->db->where('key',$string_array);
			$this->db->update('invtry_access_table',$data1);
		}
		public function NewAccess($id)
		{
			$this->db->where('invtry_admin_id',$id);
			$this->db->where('key',1);
			$this->db->from('invtry_access_table');

			$query = $this->db->get();
			return $query->result();
		}
		public function RemoveAccess($val,$data2,$id)
		{
			foreach($val as $key => $val)
	        {
	            $this->db->where('key !=',$val);
	        }
			$this->db->where('invtry_admin_id',$id);
			$this->db->update('invtry_access_table',$data2);
		}
		public function insertFinancier($data)
		{
			$this->db->insert('invtry_financier',$data);
		}
		public function deleteUser($id,$data)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_admin',$data);
		}
		public function updateFin($id,$data)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_financier',$data);
		}
		public function FinInfo($id)
		{
			$this->db->where('id',$id);
			$this->db->select('fin_name');
			$this->db->from('invtry_financier');

			$query = $this->db->get();
			return $query->result();
		}
		public function deleteFin($id,$data)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_financier',$data);
		}
		public function insertPaymode($data)
		{
			$this->db->insert('invtry_pay_mode',$data);
		}
		public function pmodeinfo($id)
		{
			$this->db->where('id',$id);
			$this->db->select('pay_mode');
			$this->db->from('invtry_pay_mode');

			$query = $this->db->get();
			return $query->result();
		}
		public function updatePmode($id,$data)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_pay_mode',$data);

		}
		public function deletePmode($id,$data)
		{
			$this->db->where('id',$id);
			$this->db->update('invtry_pay_mode',$data);
		}
		public function insertLocation($data)
		{
			$this->db->insert('company_branch',$data);
		}
		public function updateLoc($id,$data)
		{
			$this->db->where('id',$id);
			$this->db->update('company_branch',$data);

		}
		public function Locationinfo($id)
		{
			$this->db->where('id',$id);
			$this->db->from('company_branch');

			$query = $this->db->get();
			return $query->result();
		}
		public function deleteLocation($id)
		{
			$this->db->where('id',$id);
			$this->db->delete('company_branch');
		}
		public function find_dealer($brand,$branch)
		{
		    $this->db->where('Company',$brand);
		    $this->db->where('Branch',$branch);
		    $this->db->from('company_branch');

			$query = $this->db->get();
			return $query->result();
		}
		public function add_new_dealer($company_data)
		{
			$this->db->insert('company_branch',$company_data);
		}
		public function find_model($model,$brand)
		{
			$this->db->where('Company',$brand);
			$this->db->where('Product',$model);
			$this->db->from('product');

			$query = $this->db->get();
			return $query->result();
		}
		public function insertmodels($data)
		{
			$this->db->insert('product',$data);
		}
		public function brands()
		{
			$this->db->select('Company');
			$this->db->from('product');
			$this->db->where('Company !=','');
			$this->db->group_by('Company');

			$query = $this->db->get();
			return $query->result();
		}
		public function insert_invoice($inv_array)
		{
			$this->db->insert('invtry_invoice',$inv_array);
		}
		public function error_log_data($error_data)
		{
			$this->db->insert('import_log_table',$error_data);
		}
		public function insertbank($data)
		{
			$this->db->insert('bank_list',$data);
		}
		public function insertStatus($updata)
		{
			$this->db->insert('invtry_status',$updata);
		}
		public function searchd($brand,$branch)
		{
			$this->db->select('id');
			$this->db->from('company_branch');
			$this->db->where('Company',$brand);
			$this->db->where('Branch',$branch);
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->result();
		}
		public function Lsearchd($Lbrand,$Lbranch)
		{
			$this->db->select('id');
			$this->db->from('company_branch');
			$this->db->where('Company',$Lbrand);
			$this->db->where('Branch',$Lbranch);
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->result();
		}
		public function Psearchd($Pbrand,$Pbranch)
		{
			$this->db->select('id');
			$this->db->from('company_branch');
			$this->db->where('Company',$Pbrand);
			$this->db->where('Branch',$Pbranch);
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->result();
		}
		public function product_v($brand)
		{
			$this->db->from('product');
			$this->db->where('Company',$brand);

			$query = $this->db->get();
			return $query->result();

		}
		public function insert_m_c($data)
		{
			$this->db->insert('model_color_tb',$data);
		}
		public function add_error($error_array)
		{
			$this->db->insert('invtry_import_log',$error_array);
		}
		public function searchmodel($model)
		{
			$this->db->where('Product',$model);
			$this->db->from('product');
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->result();
		}
		public function searchmodel2($model)
		{
			$this->db->where('Product',$model);
			$this->db->from('product');

			$query = $this->db->get();
			return $query->result();
		}
		public function searchModelColor($model_id,$color)
		{
			$this->db->where('model_id',$model_id);
			$this->db->where('color',$color);
			$this->db->from('model_color_tb');

			$query = $this->db->get();
			return $query->result();
		}
		public function chckcolor($mid,$color)
		{
			$this->db->where('model_id',$mid);
			$this->db->where('color',$color);
			$this->db->from('model_color_tb');

			$query = $this->db->get();
			return $query->result();
		}
		public function new_color($color_data)
		{
			$this->db->insert('model_color_tb',$color_data);
		}
		public function viewmodel($model_id)
		{
			$this->db->where('id',$model_id);
			$this->db->from('product');

			$query = $this->db->get();
			return $query->result();
		}
		public function updatemodels($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('product',$data);
		}
		public function viewcolor($color_id)
		{
			$this->db->where('id',$color_id);
			$this->db->from('model_color_tb');

			$query = $this->db->get();
			return $query->result();
		}
		public function updateOtherColor($data,$model_id,$last_color)
		{
			$this->db->where('model',$model_id);
			$this->db->where('color',$last_color);
			$this->db->update('invtry_vehicle',$data);
		}
		public function updateclr($data2,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('model_color_tb',$data2);
		}
		public function searchColor($model_ids,$color)
		{
			$this->db->where('model_id',$model_ids);
			$this->db->where('color',$color);
			$this->db->from('model_color_tb');

			$query = $this->db->get();
			return $query->result();
		}
		public function add_model_color($datas)
		{
			$this->db->insert('model_color_tb',$datas);
		}
		public function findM($brand,$model)
		{
			$this->db->where('Company',$brand);
			$this->db->where('Product',$model);

			$this->db->from('product');

			$query = $this->db->get();
			return $query->result();
		}
		public function findC($id,$colorD)
		{
			$this->db->where('model_id',$id);
			$this->db->where('color',$colorD);

			$this->db->from('model_color_tb');

			$query = $this->db->get();
			return $query->result();
		}
		public function insertM($data)
		{
			$this->db->insert('product',$data);
			$last_id = $this->db->insert_id();
    	return $last_id;
		}
		public function inserC($data2)
		{
			$this->db->insert('model_color_tb',$data2);
		}
		public function productd($data,$model_id)
		{
			$this->db->where('id',$model_id);
			$this->db->delete('product');
		}
		public function productd2($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('product',$data);
		}
		public function colord($data,$model_id)
		{
			$this->db->where('model_id',$model_id);
			$this->db->delete('model_color_tb');
		}
		public function colordel($id)
		{
			$this->db->where('id',$id);
			$this->db->delete('model_color_tb');
		}
		public function deletebank($id)
		{
			$this->db->where('id',$id);
			$this->db->delete('bank_list');
		}
		public function models()
		{
			$this->db->from('product');
			$this->db->join('model_color_tb','product.id = model_color_tb.model_id','left');
			$this->db->where('product.status','1');
			$this->db->where('model_color_tb.status','1');

			$query = $this->db->get();
			return $query->result();
		}

	}
?>
