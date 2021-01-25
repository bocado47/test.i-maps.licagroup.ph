<?php
	class login_m extends CI_Model
	{
		public function loggedin($email,$password)
		{
			$this->db->where('deleted',0);
			$this->db->where('email',$email);
			$this->db->where('password',$password);
			$this->db->from('invtry_admin');

			$query = $this->db->get();
			return $query->result();
		}
	}
?>
