<?php
	class Gp_m extends CI_Model
	{
		public function SearchData($csnum)
		{
			$this->db = $this->load->database('gp',TRUE);
			$this->db->select('*');
			// $this->db->select('collections_gp_db.gp.cs_num');
			$this->db->from('collections_gp_db.gp');
			$this->db->join('collections_wrdp1.wpeq_posts','collections_gp_db.gp.post_id = collections_wrdp1.wpeq_posts.ID','left');
			// $this->db->where('collections_gp_db.gp.sales_period !=',NULL);
			$this->db->where('collections_gp_db.gp.status','1');
			$this->db->group_start();
			$this->db->where('collections_wrdp1.wpeq_posts.post_status','publish');
			$this->db->or_where('collections_wrdp1.wpeq_posts.post_status',NULL);
			$this->db->or_where('collections_wrdp1.wpeq_posts.post_status','');
			$this->db->group_end();
			$this->db->where('collections_gp_db.gp.cs_num',$csnum);

			$query = $this->db->get();
			return $query->result();
		}
		public function get_invoiced()
		{
			$this->db = $this->load->database('gp',TRUE);
			$this->db->select('collections_gp_db.gp.cs_num');
			$this->db->from('collections_gp_db.gp');
			$this->db->join('collections_wrdp1.account_receivable','collections_gp_db.gp.cs_num = collections_wrdp1.account_receivable.cs_num','left');

			$query = $this->db->get();
			return $query->result();
		}
		public function get_invoiced2($cs_num)
		{
			$this->db = $this->load->database('gp',TRUE);
			$this->db->select('collections_gp_db.gp.cs_num');
			$this->db->from('collections_gp_db.gp');
			$this->db->join('collections_wrdp1.account_receivable','collections_gp_db.gp.cs_num = collections_wrdp1.account_receivable.cs_num','left');
			// $this->db->select('cs_num');
			// $this->db->from('gp');
			// $this->db->group_start();
			// $this->db->where('first_name !=',NULL);
			// $this->db->where('last_name !=',NULL);
			// $this->db->group_end();
			//
			// $this->db->where('invoice_date !=',NULL);
			// $this->db->where('invoice_amount !=',NULL);
			// $this->db->where('invoice_number !=',NULL);
			// $this->db->where('bank !=',NULL);
			$this->db->where('collections_gp_db.gp.cs_num',$cs_num);

			$query = $this->db->get();
			return $query->result();
		}
		public function get_details($cs_num)
		{
			$this->db = $this->load->database('gp',TRUE);
			$this->db->select('*');
			// $this->db->select('collections_gp_db.gp.cs_num');
			$this->db->from('collections_gp_db.gp');
			$this->db->join('collections_wrdp1.wpeq_posts','collections_gp_db.gp.post_id = collections_wrdp1.wpeq_posts.ID','left');
			// $this->db->where('collections_gp_db.gp.sales_period !=',NULL);
			$this->db->where('collections_gp_db.gp.status','1');
			$this->db->group_start();
			$this->db->where('collections_wrdp1.wpeq_posts.post_status','publish');
			$this->db->or_where('collections_wrdp1.wpeq_posts.post_status',NULL);
			$this->db->or_where('collections_wrdp1.wpeq_posts.post_status','');
			$this->db->group_end();
			$this->db->where('collections_gp_db.gp.cs_num',$cs_num);

			$query = $this->db->get();
			return $query->num_rows();
		}
		public function get_details_gp($cs_num)
		{
			$this->db = $this->load->database('gp',TRUE);
			$this->db->select('*');
			// $this->db->select('collections_gp_db.gp.cs_num');
			$this->db->from('collections_gp_db.gp');
			$this->db->join('collections_wrdp1.wpeq_posts','collections_gp_db.gp.post_id = collections_wrdp1.wpeq_posts.ID','left');
			// $this->db->where('collections_gp_db.gp.sales_period !=',NULL);
			$this->db->where('collections_gp_db.gp.status','1');
			$this->db->group_start();
			$this->db->where('collections_wrdp1.wpeq_posts.post_status','publish');
			$this->db->or_where('collections_wrdp1.wpeq_posts.post_status',NULL);
			$this->db->or_where('collections_wrdp1.wpeq_posts.post_status','');
			$this->db->group_end();
			$this->db->where('collections_gp_db.gp.cs_num',$cs_num);

			$query = $this->db->get();
			return $query->result();
		}
		public function get_details2($cs_num)
		{
			$this->db = $this->load->database('gp',TRUE);
			$this->db->select('*');
			$this->db->from('collections_wrdp1.account_receivable');
			$this->db->join('collections_wrdp1.wpeq_posts','collections_wrdp1.account_receivable.post_id = collections_wrdp1.wpeq_posts.ID','left');
			$this->db->where('collections_wrdp1.account_receivable.gp_status','1');
			$this->db->group_start();
			$this->db->where('collections_wrdp1.wpeq_posts.post_status','publish');
			$this->db->or_where('collections_wrdp1.wpeq_posts.post_status',NULL);
			$this->db->or_where('collections_wrdp1.wpeq_posts.post_status','');
			$this->db->group_end();
			$this->db->where('collections_wrdp1.account_receivable.cs_num',$cs_num);

			$query = $this->db->get();
			return $query->result();
		}
		public function get_details3($cs_num)
		{
			$this->db = $this->load->database('gp',TRUE);
			$this->db->select('collections_gp_db.gp.invoice_date');
			// $this->db->select('collections_gp_db.gp.cs_num');
			$this->db->from('collections_gp_db.gp');
			$this->db->join('collections_wrdp1.wpeq_posts','collections_gp_db.gp.post_id = collections_wrdp1.wpeq_posts.ID','left');
			// $this->db->where('collections_gp_db.gp.sales_period !=',NULL);
			$this->db->where('collections_gp_db.gp.status','1');
			$this->db->group_start();
			$this->db->where('collections_wrdp1.wpeq_posts.post_status','publish');
			$this->db->or_where('collections_wrdp1.wpeq_posts.post_status',NULL);
			$this->db->or_where('collections_wrdp1.wpeq_posts.post_status','');
			$this->db->group_end();
			$this->db->where('collections_gp_db.gp.cs_num',$cs_num);

			$query = $this->db->get();
			return $query->result();
		}

		public function get_invoiced3($cs_nums)
		{
			$this->db = $this->load->database('gp',TRUE);
			$this->db->select('collections_gp_db.gp.cs_num');
			$this->db->from('collections_gp_db.gp');
			$this->db->join('collections_wrdp1.account_receivable','collections_gp_db.gp.cs_num = collections_wrdp1.account_receivable.cs_num','left');
			$this->db->where('collections_gp_db.gp.cs_num',$cs_nums);

			$query = $this->db->get();
			return $query->result();
		}
		public function testR($csnum)
		{
			  $this->db = $this->load->database('gp',TRUE);
				$this->db->select('collections_wrdp1.account_receivable.cs_num');
				$this->db->from('collections_wrdp1.account_receivable');
				$this->db->where('collections_wrdp1.account_receivable.cs_num',$csnum);

				$query = $this->db->get();
				return $query->result();
		}
		public function getGsm($gsmid)
		{
			$this->db = $this->load->database('gp',TRUE);
			$this->db->select('*');
			$this->db->from('gsm_list');
			$this->db->where('id',$gsmid);

			$query = $this->db->get();
			return $query->result();
		}
		// public function get_invoiced_ar()
		// {
		// 	$this->db = $this->load->database('ar',TRUE);
		// 	$this->db->select('cs_num');
		// 	$this->db->from('account_receivable');
		// 	$this->db->group_start();
		// 	$this->db->where('first_name !=',NULL);
		// 	$this->db->where('last_name !=',NULL);
		// 	$this->db->or_where('company_name !=',NULL);
		// 	$this->db->group_end();
		//
		// 	$this->db->where('invoice_date !=',NULL);
		// 	$this->db->where('invoice_amount !=',NULL);
		// 	$this->db->where('invoice_number !=',NULL);
		// 	$this->db->where('sales_consultant !=',NULL);
		// 	$this->db->where('bank !=',NULL);
		//
		// 	$query = $this->db->get();
		// 	return $query->result();
		// }
  }
?>
