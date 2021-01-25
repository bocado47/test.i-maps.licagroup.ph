<?php
	class Insurance_m extends CI_Model
	{
		public function updates($policynumber,$fsalesperiod)
		{
      $this->db = $this->load->database('testinsurance',TRUE);
      $this->db->set('fSalesPeriod2',$fsalesperiod);
      $this->db->where('policyNumber',$policynumber);
      $this->db->update('policiesTable');
		}
  }
?>
