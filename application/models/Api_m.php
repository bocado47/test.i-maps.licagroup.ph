<?php
	class Api_m extends CI_Model
	{
		public function models($brand)
		{
					$this->db->where('Company',$brand);
					$this->db->from('product');
					$this->db->order_by('product','ASC');

          $query = $this->db->get();
  		    return $query->result();
		}
		public function colors($model)
		{
					$this->db->where('product.Product',$model);
					$this->db->from('product');
					$this->db->join('model_color_tb','model_color_tb.model_id = product.id','left');
					$this->db->order_by('model_color_tb.color','ASC');


		      $query = $this->db->get();
		  		return $query->result();
		}
		// public function getCSmodel($cs)
		// {
		// 		$this->db->select('invtry_vehicle.cs_num','invtry_vehicle.model')
		// 		$this->db->from('invtry_vehicle');
		// 		$this->db->join('product','product.id = invtry_vehicle.model','left');
		// 		$this->db->join('model_color_tb','model_color_tb.model_id = product.id','left');
		//
		// 		$query = $this->db->get();
		// 		return $query->result();
		// }
  }
?>
