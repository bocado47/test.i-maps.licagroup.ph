<?php
	class Dsar_m extends CI_Model
	{
		public function cm()
		{
      $this->db = $this->load->database('dsar',TRUE);
      $this->db->from('company_branch');
			$this->db->order_by('Company','ASC');

			$query = $this->db->get();
			return $query->result();
		}
		public function cmd($brand)
		{
      $this->db = $this->load->database('dsar',TRUE);
      $this->db->from('company_branch');
      $this->db->where('company_branch.Company',$brand);
			$this->db->order_by('Company','ASC');

			$query = $this->db->get();
			return $query->result();
		}
		public function cm3($accessdealer)
		{
      $this->db = $this->load->database('dsar',TRUE);
      $this->db->from('company_branch');
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
		public function cmd3($accessdealer,$brand)
		{
      $this->db = $this->load->database('dsar',TRUE);
      $this->db->from('company_branch');
      $this->db->where('company_branch.Company',$brand);
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
		public function cm2($dealer_id)
		{
			$this->db = $this->load->database('dsar',TRUE);
			$this->db->select('CONCAT(Company,"-",Branch) as dealer');
			$this->db->from('company_branch');
			$this->db->where('id',$dealer_id);
			$this->db->order_by('Company','ASC');

			$query = $this->db->get();
			return $query->result();
		}
    public function cm_join($ids)
    {
			$this->db = $this->load->database('dsar',TRUE);
      $this->db->select('*,licagroup_dsar.company_branch.id as id,k0x6k0o6_test_inventory.invtry_access_table.id as access');
			$this->db->where('k0x6k0o6_test_inventory.invtry_access_table.invtry_admin_id',$ids);
			$this->db->where('k0x6k0o6_test_inventory.invtry_access_table.status',1);
			$this->db->from('licagroup_dsar.company_branch');
			$this->db->join('k0x6k0o6_test_inventory.invtry_access_table','company_branch.Company = k0x6k0o6_test_inventory.invtry_access_table.key');
			$this->db->order_by('licagroup_dsar.company_branch.Company','ASC');

			$query = $this->db->get();
			return $query->result();
    }
    public function company_user_access()
    {
      $this->db = $this->load->database('dsar',TRUE);
      $this->db->from('company_branch');
      $this->db->group_by('Company');

      $query = $this->db->get();
      return $query->result();
    }
		public function sc()
		{
			$this->db->from('user');

			$query = $this->db->get();
      return $query->result();
		}
		public function scSearch($scid)
		{
			$this->db = $this->load->database('dsar',TRUE);
			$this->db->from('user');
			$this->db->where('id',$scid);

			$query = $this->db->get();
      return $query->result();
		}
		public function scSearch2($grmid)
		{
			$this->db = $this->load->database('dsar',TRUE);
			$this->db->from('user');
			$this->db->where('id',$grmid);

			$query = $this->db->get();
      return $query->result();
		}
		public function dealerSearch($company,$branch)
		{
			$this->db = $this->load->database('dsar',TRUE);
      $this->db->from('company_branch');
			$this->db->where('Company',$company);
			$this->db->where('Branch',$branch);

			$query = $this->db->get();
			return $query->result();
		}
		public function dealer()
		{
			$this->db = $this->load->database('dsar',TRUE);
			$this->db->select('CONCAT(Company,"-",Branch) as Company');
			$this->db->from('company_branch');
			$this->db->order_by('Company','ASC');

			$query = $this->db->get();
			return $query->result();
		}
		public function dealer2($accessdealer)
		{
			$this->db = $this->load->database('dsar',TRUE);
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
		public function Brands()
		{
			$this->db = $this->load->database('dsar',TRUE);
			$this->db->select('Company');
			$this->db->from('company_branch');
			$this->db->order_by('Company','ASC');
			$this->db->group_by('Company');

			$query = $this->db->get();
			return $query->result();
		}
		public function Brands3($brand)
		{
			$this->db = $this->load->database('dsar',TRUE);
			$this->db->select('Branch');
			$this->db->from('company_branch');
			$this->db->where('Company',$brand);

			$query = $this->db->get();
			return $query->result();
		}
		public function newid($dealer)
		{
			$this->db = $this->load->database('dsar',TRUE);
			$this->db->from('company_branch');
			foreach($dealer as $value)
			{
				$this->db->or_where('Company',$value);
			}

			$query = $this->db->get();
			return $query->result();
		}
		public function Brands2($accessdealer)
		{
			$this->db = $this->load->database('dsar',TRUE);
			$this->db->select('Company');
			$this->db->from('company_branch');
			foreach($accessdealer as $val)
			{
				$this->db->or_where('Company',$val->key);
			}
			$this->db->order_by('Company','ASC');
			$this->db->group_by('Company');

			$query = $this->db->get();
			return $query->result();
		}
  }
?>
