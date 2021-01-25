<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
  {
        date_default_timezone_set('Asia/Manila');
        parent::__construct();
				if(!$this->session->userdata('logged_in'))
	      {
	        die("You don't have access here: <a href='".base_url()."Login'>Login Here! </a>");
	      }
  }
    // USER TABLE
	public function user_table()
	{
		$this->load->view('v2/partial/header');
		$this->load->view('admin/UserTable');
		$this->load->view('v2/partial/footer');
	}
	public function user_record()
	{
		$aColumns = array(
            'Name',
            'Email',
            'Type',
            'Status',
            'Options'
        );

        // DB table to use
        // $this->db->where('deleted','0');
        $sTable = 'invtry_admin';

        $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            // $this->db->limit(10,20);
        }

        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }

        if(isset($sSearch) && !empty($sSearch))
        {
            $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
            for($i=0; $i<count($aColumns); $i++)
            {
                // Individual column filtering
            }

            if(isset($bSearchable) && $bSearchable == 'true')
            {
                //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("invtry_admin.name", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("invtry_admin.email", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="invtry_admin.id,";
        $cSelect .="invtry_admin.name as 'Name',";
        $cSelect .="invtry_admin.email as 'Email',";
        $cSelect .="invtry_admin.type as 'Type', ";
        $cSelect .="invtry_admin.deleted as 'Active', ";

        $this->db->select($cSelect, false);
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach($aColumns as $col)
            {
            	if($col == 'Type')
            	{
            		if($aRow['Type'] == '1')
            		{
            			$aRow[$col]='Admin';
            		}else if($aRow['Type'] == '2')
            		{
            			$aRow[$col]='Sales Person';
            		}
								else if($aRow['Type'] == '3')
            		{
            			$aRow[$col]='OPS';
            		}
								else if($aRow['Type'] == '4')
            		{
            			$aRow[$col]='Finance';
            		}
            	}
            	if($col == 'Status')
            	{
            		if($aRow['Active'] == '0')
            		{
            			$aRow[$col]='<h5 style="color:green;">Active</h5>';
            		}else if($aRow['Active'] == '1')
            		{
            			$aRow[$col]='<h5 style="color:red;">Inactive</h5>';
            		}
            	}
                if($col == 'Options'){
                    $aRow[$col] = '';

                    if($aRow['Active'] == 1)
                    {
                        $aRow[$col] .= "<button class='btn btn-sm btn-success btnactivate' value='".$aRow['id']."'>Activate</button> ";
                    }else{
                        if($aRow['Type'] == 'Admin')
                        {
                            $aRow[$col] .= "<button class='btn btn-sm btn-success btnview' value='".$aRow['id']."'>Edit</button> ";
                        }else if($aRow['Type'] == 'Sales Person'){
                            $aRow[$col] .= "<button class='btn btn-sm btn-success btnview' value='".$aRow['id']."'>Edit</button> ";
                            $aRow[$col] .= "<button class='btn btn-sm btn-primary btnaccess' value='".$aRow['id']."'>View Access</button>";
                            $aRow[$col] .= " <button class='btn btn-sm btn-danger btndelete' value='".$aRow['id']."'>Delete</button>";
                        }else if($aRow['Type'] == 'OPS'){
                            $aRow[$col] .= "<button class='btn btn-sm btn-success btnview' value='".$aRow['id']."'>Edit</button> ";
                            $aRow[$col] .= "<button class='btn btn-sm btn-primary btnaccess' value='".$aRow['id']."'>View Access</button>";
                            $aRow[$col] .= " <button class='btn btn-sm btn-danger btndelete' value='".$aRow['id']."'>Delete</button>";
                        }else if($aRow['Type'] == 'Finance'){
                            $aRow[$col] .= "<button class='btn btn-sm btn-success btnview' value='".$aRow['id']."'>Edit</button> ";
                            $aRow[$col] .= "<button class='btn btn-sm btn-primary btnaccess' value='".$aRow['id']."'>View Access</button>";
                            $aRow[$col] .= " <button class='btn btn-sm btn-danger btndelete' value='".$aRow['id']."'>Delete</button>";
                        }
                    }
                }

                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
	}
	public function user_form()
	{
		$this->load->view('admin/form/user_form');
	}
    public function useraddform()
    {
        $name=$this->input->post('name');
        $email=$this->input->post('email');
        $password=md5($this->input->post('password'));
        $type=$this->input->post('type');
        $Caccess=$this->input->post('Caccess');
        $access=$this->input->post('access');
        $comaccess=$this->Dsar_m->company_user_access();
				  // echo '<pre>';
					// print_r($comaccess);
					// die();
        $data=array(
            'name' => $name,
            'password' => $password,
            'email' => $email,
            'type' => $type
        );
        $input_id=$this->Admin_m->insertUser($data);

        // echo $input_id;
        // if($type == '1')
        // {
        //     foreach($Caccess as $val)
        //     {
        //         $dataAccess=array(
        //             'invtry_admin_id'=>$input_id,
        //             'key'=>$val
        //         );
        //         $this->Admin_m->dataAcs($dataAccess);
        //     }
        // }
        foreach($comaccess as $val)
        {
            $dataAccess2=array(
                'invtry_admin_id'=>$input_id,
                'key'=>$val->Company
            );
            $this->Admin_m->dataAcs2($dataAccess2);
        }

        foreach($access as $val)
        {
            $dataAccess3=array(
                'status' => 1
            );
            $invtry_admin_id=$input_id;
            $company=$val;
            $this->Admin_m->updateAcs($dataAccess3,$invtry_admin_id,$company);
        }

        echo json_encode($data);
    }
    public function user_profile()
    {
        $id=$_GET['id'];
        $data['id']=$id;
        $data['userprofile']=$this->Admin_m->userprofile($id);
        $this->load->view('admin/form/user_edit_form',$data);
    }
    public function userupdateform()
    {
        $data=array(
            'name'=>$this->input->post('name'),
            'email'=>$this->input->post('email'),
            'type'=>$this->input->post('type'),
        );
        $id=$_GET['id'];
        $this->Admin_m->update_user($data,$id);
        echo json_encode($data);
    }
    public function user_access()
    {
        $id=$_GET['id'];
        $data['id']=$id;
        $data['useraccessdata']=$this->Admin_m->useraccessdata($id);
        $this->load->view('admin/form/user_edit_access',$data);
    }
    public function user_access_update()
    {
        $val=$this->input->post('access');
        $id=$_GET['id'];
        $access=$this->Admin_m->access();
        $check=array();

        foreach ($val as $key => $value) {
					if($value=='MORRIS GARAGES')
					{
						$value='MG';
					}
            $string_array =$value;
            $data1=array(
                'Status'=>'1'
            );

            $this->Admin_m->MakeAccess($string_array,$data1,$id);
        }
        $newval=$this->Admin_m->NewAccess($id);
        $data2=array(
                'Status'=>'0'
            );
        $test=$this->Admin_m->RemoveAccess($val,$data2,$id);
    }
    public function user_delete()
    {
        $id=$_GET['id'];
        $data=array(
            'deleted' => 1
        );
        $this->Admin_m->deleteUser($id,$data);
        echo json_encode($data);
    }
    public function user_activate()
    {
        $id=$_GET['id'];
        $data=array(
            'deleted' => 0
        );
        $this->Admin_m->deleteUser($id,$data);
        echo json_encode($data);
    }
	// USER TABLE END
    //Financier Table
    public function FinancierTable()
    {
        $this->load->view('v2/partial/header');
        $this->load->view('admin/FinancierTable');
        $this->load->view('v2/partial/footer');
    }
    public function FinancierRecord()
    {
        $aColumns = array(
            'Name',
            'Date Added',
            'Status',
            'Options'
        );

        // DB table to use
        // $this->db->where('deleted','0');
        $sTable = 'invtry_financier';

        $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            // $this->db->limit(10,20);
        }

        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }

        if(isset($sSearch) && !empty($sSearch))
        {
            $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
            for($i=0; $i<count($aColumns); $i++)
            {
                // Individual column filtering
            }

            if(isset($bSearchable) && $bSearchable == 'true')
            {
                //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("invtry_financier.fin_name", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="invtry_financier.id,";
        $cSelect .="invtry_financier.fin_name as 'Name',";
        $cSelect .="invtry_financier.dated_added as 'Date Added',";
        $cSelect .="invtry_financier.deleted as 'Active', ";

        $this->db->select($cSelect, false);
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach($aColumns as $col)
            {
                if($col == 'Name')
                {
                    $aRow[$col]=ucfirst($aRow['Name']);
                }
                if($col == 'Status')
                {
                    if($aRow['Active'] == '0')
                    {
                        $aRow[$col]='<h5 style="color:green;">Active</h5>';
                    }else if($aRow['Active'] == '1')
                    {
                        $aRow[$col]='<h5 style="color:red;">Inactive</h5>';
                    }
                }
                if($col == 'Options'){
                    $aRow[$col] = '';
                    $aRow[$col] .= "<button class='btn btn-md btn-success btnview' value='".$aRow['id']."'>Edit</button>";
                    if($aRow['Active'] == '0')
                    {
                        $aRow[$col] .= " <button class='btn btn-md btn-danger btndelete' value='".$aRow['id']."'>Delete</button>";
                    }else if($aRow['Active'] == '1')
                    {
                     $aRow[$col] .= " <button class='btn btn-md btn-success btnactivate' value='".$aRow['id']."'>Activate</button>";
                    }
                }

                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }
    public function financier_form()
    {
        $this->load->view('admin/form/financier_form');
    }
    public function financieraddform()
    {
        $name=$this->input->post('name');

        $data=array(
            'fin_name' => $name,
        );
        $this->Admin_m->insertFinancier($data);
    }
    public function updateFinancierForm()
    {
        $data['id']=$_GET['id'];
        $id=$_GET['id'];
        $data['name']=$this->Admin_m->FinInfo($id);
        $this->load->view('admin/form/update_financier_form',$data);
    }
    public function updateFinancier()
    {
        $id=$this->input->post('id');
        $data=array(
            'fin_name'=>$this->input->post('name')
        );
        $this->Admin_m->updateFin($id,$data);
    }
    public function financier_activate()
    {
        $id=$_GET['id'];
        $data=array(
            'deleted' => 0
        );
        $this->Admin_m->deleteFin($id,$data);
        echo json_encode($data);
    }
    public function financier_delete()
    {
        $id=$_GET['id'];
        $data=array(
            'deleted' => 1
        );
        $this->Admin_m->deleteFin($id,$data);
        echo json_encode($data);
    }
    // Financier Table End
    // Payment Mode Table
    public function PModeTable()
    {
        $this->load->view('v2/partial/header');
        $this->load->view('admin/PModeTable');
        $this->load->view('v2/partial/footer');
    }
    public function PModeRecord()
    {
        $aColumns = array(
            'Name',
            'Status',
            'Options'
        );

        // DB table to use
        // $this->db->where('deleted','0');
        $sTable = 'invtry_pay_mode';

        $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            // $this->db->limit(10,20);
        }

        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }

        if(isset($sSearch) && !empty($sSearch))
        {
            $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
            for($i=0; $i<count($aColumns); $i++)
            {
                // Individual column filtering
            }

            if(isset($bSearchable) && $bSearchable == 'true')
            {
                //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("invtry_pay_mode.pay_mode", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="invtry_pay_mode.id,";
        $cSelect .="invtry_pay_mode.pay_mode as 'Name',";
        $cSelect .="invtry_pay_mode.deleted as 'Active', ";

        $this->db->select($cSelect, false);
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach($aColumns as $col)
            {
                if($col == 'Name')
                {
                    $aRow[$col]=ucfirst($aRow['Name']);
                }
                if($col == 'Status')
                {
                    if($aRow['Active'] == '0')
                    {
                        $aRow[$col]='<h5 style="color:green;">Active</h5>';
                    }else if($aRow['Active'] == '1')
                    {
                        $aRow[$col]='<h5 style="color:red;">"Inactive"</h5>';
                    }
                }
                if($col == 'Options'){
                    $aRow[$col] = '';
                    $aRow[$col] .= "<button class='btn btn-md btn-success btnview' value='".$aRow['id']."'>Edit</button> ";
                    if($aRow['Active'] == '1')
                    {
                        $aRow[$col] .= "<button class='btn btn-md btn-success btnactivate' value='".$aRow['id']."'>Activate</button>";
                    }else if($aRow['Active'] == '0')
                    {
                        $aRow[$col] .= "<button class='btn btn-md btn-danger btndelete' value='".$aRow['id']."'>Deactivate</button>";
                    }
                }

                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }
    public function PModeform()
    {
        $this->load->view('admin/form/PMode_form');
    }
    public function pmodeaddform()
    {
       $name=$this->input->post('name');

        $data=array(
            'pay_mode' => $name,
        );
        $this->Admin_m->insertPaymode($data);
    }
    public function updatepmodeForm()
    {
        $data['id']=$_GET['id'];
        $id=$_GET['id'];
        $data['name']=$this->Admin_m->pmodeinfo($id);
        $this->load->view('admin/form/update_pmode_form',$data);
    }
    public function updatepmode()
    {
        $id=$this->input->post('id');
        $data=array(
            'pay_mode'=>$this->input->post('name')
        );
        $this->Admin_m->updatePmode($id,$data);
    }
    public function pmode_activate()
    {
        $id=$_GET['id'];
        $data=array(
            'deleted' => 0
        );
        $this->Admin_m->deletePmode($id,$data);
        echo json_encode($data);
    }
    public function pmode_delete()
    {
        $id=$_GET['id'];
        $data=array(
            'deleted' => 1
        );
        $this->Admin_m->deletePmode($id,$data);
        echo json_encode($data);
    }
    // Payment Mode Table End
    // Location Table
     public function LocationTable()
    {
        $this->load->view('v2/partial/header');
        $this->load->view('admin/LocationTable');
        $this->load->view('v2/partial/footer');
    }
    public function LocationRecord()
    {
        $aColumns = array(
            'Dealer',
            'Location',
            'Options'
        );

        // DB table to use
        // $this->db->where('deleted','0');
				$this->db->order_by('Company','ASC');
        $sTable = 'company_branch';

        $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            // $this->db->limit(10,20);
        }

        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }

        if(isset($sSearch) && !empty($sSearch))
        {
            $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
            for($i=0; $i<count($aColumns); $i++)
            {
                // Individual column filtering
            }

            if(isset($bSearchable) && $bSearchable == 'true')
            {
                //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("company_branch.Company", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("company_branch.Branch", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="company_branch.id,";
        $cSelect .="company_branch.Company as 'Dealer',";
        $cSelect .=",company_branch.Branch as 'Location',";

        $this->db->select($cSelect, false);
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach($aColumns as $col)
            {
                if($col == 'Options'){
                    $aRow[$col] = '';
                    $aRow[$col] .= "<button class='btn btn-sm btn-success btnview' value='".$aRow['id']."'>Edit</button> ";
                    $aRow[$col] .= "<button class='btn btn-sm btn-danger btndelete' value='".$aRow['id']."'>Delete</button> ";

                }

                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }
    public function Locationform()
    {
        $this->load->view('admin/form/Location_form');
    }
    public function Locationaddform()
    {
       $Brand=$this->input->post('Brand');
       $Location=$this->input->post('Location');
       $session_data = $this->session->userdata('logged_in');
       $datas=$session_data[0];
        $data=array(
            'Company' => $Brand,
            'Branch' => $Location
        );
        $this->Admin_m->insertLocation($data);
    }
     public function updateLocationForm()
    {
        $data['id']=$_GET['id'];
        $id=$_GET['id'];
        $data['location']=$this->Admin_m->Locationinfo($id);
        $this->load->view('admin/form/update_location_form',$data);
    }
    public function updateLocation()
    {
        $id=$this->input->post('id');
        $session_data = $this->session->userdata('logged_in');
				$Brand=$this->input->post('Brand');
				$Location=$this->input->post('Location');
	      $datas=$session_data[0];
				$data=array(
						 'Company' => $Brand,
						 'Branch' => $Location
				 );
        $this->Admin_m->updateLoc($id,$data);
    }
    public function Location_activate()
    {
        $id=$_GET['id'];
        $data=array(
            'deleted' => 0
        );
        $this->Admin_m->deleteLocation($id,$data);
        echo json_encode($data);
    }
    public function Location_delete()
    {
        $id=$_GET['id'];
        $this->Admin_m->deleteLocation($id);
        echo json_encode($id);
    }
    public function ModelsTable()
    {
        $this->load->view('v2/partial/header');
        $this->load->view('admin/ModelsTable');
        $this->load->view('v2/partial/footer');
    }
    public function ModelsRecord()
    {
			$session_data = $this->session->userdata('logged_in');
			$datas=$session_data[0];
			$id=$datas->id;
			$type=$datas->type;

			$access=$this->Main_m->m_access($id);



        $aColumns = array(
            'Brand',
            'Model',
            'Series',
            'Options'
        );

				if($type == 1){
				}else{
					$this->db->group_start();
					foreach($access as $value) {
						$dealer=$value->key;
						$this->db->or_where('product.Company',$dealer);
					}
					$this->db->group_end();
				}
				$this->db->where('product !=','');
        $this->db->order_by('status','ASC');
        $sTable = 'product';
        $this->db->order_by('Company');
        $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            // $this->db->limit(10,20);
        }

        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
        if(isset($sSearch) && !empty($sSearch))
        {
            $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
            for($i=0; $i<count($aColumns); $i++)
            {
                // Individual column filtering
            }

            if(isset($bSearchable) && $bSearchable == 'true')
            {
                //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("product.product", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("product.company", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("product.model_series", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="product.id,";
        $cSelect .="product.Company as 'Brand',";
        $cSelect .="product.Product as 'Model',";
        $cSelect .="product.model_series as 'Series',";
        $cSelect .="product.status,";

        $this->db->select($cSelect, false);
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach($aColumns as $col)
            {
                if($col == 'Options'){
                    $aRow[$col] = '';
                    $aRow[$col] .= "<button class='btn btn-sm btn-primary btnview' value='".$aRow['id']."'> Edit </button> ";
                    if($aRow['status'] == '1')
                    {
												$aRow[$col] .= "<button class='btn btn-sm btn-danger btndeactivate' value='".$aRow['id']."'>De-Activate</button> ";
                    }else
                    {
                     		$aRow[$col] .= "<button class='btn btn-sm btn-success btnactivate' value='".$aRow['id']."'>Activate</button> ";
                    }
                }

                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }
		public function product_activate()
		{
				$id=$_GET['id'];
				$data=array(
						'status' => '1'
				);
				$this->Admin_m->updatemodels($data,$id);
				echo json_encode($data);
		}
		public function product_deactivate()
		{
				$id=$_GET['id'];
				$data=array(
						'status' => '0'
				);
				$this->Admin_m->updatemodels($data,$id);
				echo json_encode($data);
		}
		public function delete_product()
		{
			$model_id=$_GET['id'];
			$data=array('status'=>'0');
			$updateproduct=$this->Admin_m->productd($data,$model_id);
			$updatecolor=$this->Admin_m->colord($data,$model_id);
			echo json_encode($model_id);

		}
    public function model_form()
    {
        $this->load->view('admin/form/model_form');
    }
    public function model_form_add()
    {
        $brand=trim($this->input->post('brand'));
        $model=trim(preg_replace('/[\s]+/mu', ' ', $this->input->post('model')));
        $model_series=trim($this->input->post('model_series'));
        $data=array(
            'Company' => $brand,
            'Product'=>$model,
            'model_series'=>$model_series,
						'Price' =>0,
						'status'=>1
        );
				$searchModel=$this->Admin_m->searchmodel2($model);
				if(count($searchModel) > 0)
				{
					echo '<h3><font color="red"><center>Model Is Existing!</center></font></h3>';
				}else{
					$this->Admin_m->insertmodels($data);
					echo '<h3><font color="green"><center>Added Successfuly!</center></font></h3>';
				}

    }
		public function modeleditform()
		{
			$model_id=$_GET['id'];
			$data['model']=$this->Admin_m->viewmodel($model_id);
			$this->load->view('admin/form/model_view',$data);
		}
		public function updatemodel()
		{
			$id=$this->input->post('id');
			$data=array(
				'Company'=> $this->input->post('brand'),
				'Product' => $this->input->post('model'),
				'model_series' => $this->input->post('model_series')
			);
			$this->Admin_m->updatemodels($data,$id);
			// echo json_encode($data);
		}
		public function coloreditform()
		{
			$color_id=$_GET['id'];
			$data['model']=$this->Admin_m->viewcolor($color_id);
			$this->load->view('admin/form/color_view',$data);
		}
		public function updatecolor()
		{
			$id=$this->input->post('id');
			$model_id=$this->input->post('model');
			$last_color=$this->input->post('last_color');
			$data=array(
				'Color'=> $this->input->post('color'),
			);
			$data2=array(
				'color'=> $this->input->post('color'),
			);
			$this->Admin_m->updateclr($data2,$id);
			$this->Admin_m->updateOtherColor($data,$model_id,$last_color);
			echo json_encode($data);
		}
    // Models Table End
    // Bank Table
    public function BankTable()
    {
        $this->load->view('v2/partial/header');
        $this->load->view('admin/BankTable');
        $this->load->view('v2/partial/footer');
    }
    public function BankRecord()
    {
         $aColumns = array(
            'Bank Code',
            'Bank Description',
            'Options'
        );

        // DB table to use
        // $this->db->where('deleted','0');
        $sTable = 'bank_list';
        // $this->db->order_by('id');
        $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            // $this->db->limit(10,20);
        }

        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }

        if(isset($sSearch) && !empty($sSearch))
        {
            $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
            for($i=0; $i<count($aColumns); $i++)
            {
                // Individual column filtering
            }

            if(isset($bSearchable) && $bSearchable == 'true')
            {
                //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("bank_list.bank_names", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="bank_list.id,";
        $cSelect .="bank_list.bank_code as 'Bank Code',";
        $cSelect .="bank_list.Description as 'Bank Description',";

        $this->db->select($cSelect, false);
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach($aColumns as $col)
            {
                if($col == 'Options'){
                    $aRow[$col] = '';
                    $aRow[$col] .= "<button class='btn btn-sm btn-success btnedit' value='".$aRow['id']."'>Edit</button> ";
                    $aRow[$col] .= "<button class='btn btn-sm btn-danger btndelete' value='".$aRow['id']."'>Delete</button> ";
                    // if($aRow['Status'] == '<h5 style="color:green;">Active</h5>')
                    // {
                    //     $aRow[$col] .= "<button class='btn btn-md btn-danger btndelete' value='".$aRow['id']."'>Delete</button> ";
                    // }else if($aRow['Status'] == '<h5 style="color:red;">Inactive</h5>')
                    // {
                    //     $aRow[$col] .= "<button class='btn btn-md btn-success btnactivate' value='".$aRow['id']."'>activate</button> ";
                    // }
                }

                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }
    public function bank_form()
    {
        $this->load->view('admin/form/bank_form');
    }
    public function bankaddform()
    {
        $bank=$this->input->post('bank_code');
        $Description=$this->input->post('Description');
        $data=array(
            'bank_code' => $bank,
            'Description' => $Description,
        );
        $this->Admin_m->insertbank($data);
    }
		public function bank_form2()
		{
			$id=$_GET['id'];
			$data['id']=$_GET['id'];
			$data['bank']=$this->Admin_m->bankid($id);
			$this->load->view('admin/form/bank_edit_form',$data);
		}
		public function bankeditform()
		{
			$id=$_POST['id'];
			$bank=$this->input->post('bank_code');
			$Description=$this->input->post('Description');
			$data=array(
					'bank_code' => $bank,
					'Description' => $Description,
			);
			$this->Admin_m->editbank($data,$id);
			echo json_encode($id);
		}
		public function delete_bank()
		{
			$id=$_GET['id'];
			$data['bank']=$this->Admin_m->deletebank($id);
			echo json_encode($id);
		}
		// Bank Table End
		// model color table
		public function ColorTable()
		{
			$this->load->view('v2/partial/header');
			$this->load->view('admin/ColorTB');
			$this->load->view('v2/partial/footer');
		}
		public function ModelCRecord()
    {	$session_data = $this->session->userdata('logged_in');
			$datas=$session_data[0];
			$id=$datas->id;
			$type=$datas->type;

			$access=$this->Main_m->m_access($id);

         $aColumns = array(
            'Brand',
            'Model',
            'Color',
            'Options'
        );
				if($type == 1){
				}else{
					$this->db->group_start();
					foreach($access as $value) {
						$dealer=$value->key;
						$this->db->or_where('product.Company',$dealer);
					}
					$this->db->group_end();
				}

        // DB table to use
        // $this->db->where('deleted','0');
				$this->db->where('model_color_tb.status','1');
        $sTable = 'model_color_tb';
        // $this->db->order_by('id');
        $iDisplayStart = intval($this->input->get_post('iDisplayStart', true));
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            // $this->db->limit(10,20);
        }

        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }

        if(isset($sSearch) && !empty($sSearch))
        {
            $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
            for($i=0; $i<count($aColumns); $i++)
            {
                // Individual column filtering
            }

            if(isset($bSearchable) && $bSearchable == 'true')
            {
                //$this->db->like("CONCAT(prospect_details.Fname,' ',prospect_details.Lname)", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_start();
                $this->db->or_like("model_color_tb.color", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("product.Company", $this->db->escape_like_str($sSearch),'both');
                $this->db->or_like("product.Product", $this->db->escape_like_str($sSearch),'both');
                $this->db->group_end();
            }
        }

        // Select Data
        //Customize select
        $cSelect = "SQL_CALC_FOUND_ROWS ";
        $cSelect .="model_color_tb.id,";
        $cSelect .="model_color_tb.color as 'Color',";
        $cSelect .="model_color_tb.model_id,";
        $cSelect .="product.Company as 'Brand',";
        $cSelect .="product.Product as 'Model',";

        $this->db->select($cSelect, false);
				$this->db->join('product','product.id = model_color_tb.model_id');
        $rResult = $this->db->get($sTable);

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all($sTable);

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach($aColumns as $col)
            {
                if($col == 'Options'){
                    $aRow[$col] = '';
                    $aRow[$col] .= "<button class='btn btn-sm btn-success btnedit' value='".$aRow['id']."'>Edit</button> ";
                    $aRow[$col] .= "<button class='btn btn-sm btn-danger btndelete' value='".$aRow['id']."'>Delete</button> ";
                    // if($aRow['Status'] == '<h5 style="color:green;">Active</h5>')
                    // {
                    //     $aRow[$col] .= "<button class='btn btn-md btn-danger btndelete' value='".$aRow['id']."'>Delete</button> ";
                    // }else if($aRow['Status'] == '<h5 style="color:red;">Inactive</h5>')
                    // {
                    //     $aRow[$col] .= "<button class='btn btn-md btn-success btnactivate' value='".$aRow['id']."'>activate</button> ";
                    // }
                }

                $row[] = $aRow[$col];
            }

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }
		public function form_m_color()
		{
			$this->load->view('admin/form/form_m_c');
		}
		public function delete_color()
		{
			$id=$_GET['id'];
			$deleteColor=$this->Admin_m->colordel($id);
			echo json_encode($id);
		}
		public function v_models()
		{
			$brand=$_GET['brand'];

			$models=$this->Admin_m->product_v($brand);
			echo json_encode($models);
		}
		public function add_model_color()
		{
			$model_id=trim($_POST['model']);
			$color=trim(preg_replace('/[\s]+/mu', ' ', $_POST['color']));
			$data=array(
				'model_id' => $model_id,
				'color' => $color,
					'status' => '1'
			);
			$searchModelColor=$this->Admin_m->searchModelColor($model_id,$color);
			if(count($searchModelColor) > 0)
			{
				echo '<h3><font color="red"><center>Color Is Existing For This Model!</center></font></h3>';
			}else{
				$this->Admin_m->insert_m_c($data);
				echo '<h3><font color="green"><center>Added Successfuly!</center></font></h3>';
			}
		}
		// model color table end
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
		public function do_upload3()
		{
			$this->load->library('upload');

			$files = $_FILES;

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
								$s_data[$row]["BRAND NAME"] = $data_value;
							}
						}else{
							if(empty($body[$row]["A"])){
								$s_data[$row]["BRAND NAME"] = '';
							}
						}
						if(isset($body[$row]["B"]))
						{
							if($column == "B"){
								$s_data[$row]["MODEL NAME"] = $data_value;
							}
						}else{
							if(empty($body[$row]["B"])){
								$s_data[$row]["MODEL NAME"] = '';
							}
						}
						if(isset($body[$row]["C"]))
						{
							if($column == "C"){
								$s_data[$row]["MODEL SERIES"] = $data_value;
							}
						}else{
							if(empty($body[$row]["C"])){
								$s_data[$row]["MODEL SERIES"] = '';
							}
						}

						if(isset($body[$row]["D"]))
						{
							if($column == "D"){
								$s_data[$row]["COLOR DESCRIPTION"] = $data_value;
							}
						}else{
							if(empty($body[$row]["D"])){
								$s_data[$row]["COLOR DESCRIPTION"] = '';
							}
						}

						if(isset($body[$row]["E"]))
						{
							if($column == "E"){
								$s_data[$row]["COLOR NAME"] = $data_value;
							}
						}else{
							if(empty($body[$row]["E"])){
								$s_data[$row]["COLOR NAME"] = '';
							}
						}
					}
				}

				$error_count=0;
				$count_recorded=0;
				$update_count=0;


			foreach ($s_data as $value) {
				$brand=$value['BRAND NAME'];
				$model=trim(preg_replace('/[\s]+/mu', ' ',$value['MODEL NAME']));
				$model_series=$value['MODEL SERIES'];
				$colorD=trim(preg_replace('/[\s]+/mu', ' ',$value['COLOR DESCRIPTION']));
				$colorN=trim(preg_replace('/[\s]+/mu', ' ',$value['COLOR NAME']));

				$findMOdel=$this->Admin_m->findM($brand,$model);
				$countRecord=count($findMOdel);

				if(strlen($model_series) < 1)
				{
					$array=explode(' ',$model);
					$newmodel_series='';
					if(count($array) >= 3)
					{
							if(is_numeric($array[1][0]))
							{
								$newmodel_series=$array[0];
							}else if(is_numeric($array[2][0])){
								$newmodel_series=$array[0].' '.$array[1];
							}else{
								$newmodel_series=$model;
							}
					}else if(count($array) == 2)
					{
							if(is_numeric($array[1][0]))
							{
								$newmodel_series=$array[0];
							}else{
								$newmodel_series=$array[0].' '.$array[1];
							}
					}else if(count($array) < 2)
					{
								$newmodel_series=$array[0];
					}

				}else{
					$newmodel_series=$model_series;
				}


				// echo $newmodel_series;
				// die();
				if($countRecord < 1)
				{

					// $id='';
					// foreach($findModel as $value)
					// {
					// 	$id.=$value['id'];
					// }
					// $findColor=$this->Admin_m->findC($id,$colorD);
					// $countC=count($findColor);
					// if($countC > 0)
					// {
						$data=array('Company'=>$brand,'Product'=>trim($model),'model_series'=>$newmodel_series,'Price'=>0,'status'=>1);
						$last_id=$this->Admin_m->insertM($data);
						$data2=array('model_id'=>$last_id,'color'=>$colorD,'base_color'=>$colorN);
						$inserColor=$this->Admin_m->inserC($data2);

					// }
				}else{
					$id='';
					foreach($findMOdel as $value)
					{
						$id.=$value->id;
					}
					$findColor=$this->Admin_m->findC($id,$colorD);
					$countC=count($findColor);
					if($countC < 1)
					{
						$data2=array('model_id'=>$id,'color'=>$colorD,'base_color'=>$colorN,'status'=>1);
						$inserColor=$this->Admin_m->inserC($data2);
					}
				}
			}
			echo "Insert Successful";

		}
		public function dsar_cb()
		{
			$cb=$this->Dsar_m->company_branch();
			echo '<pre>';
			print_r($cb);
		}
		public function download_mc()
		{
			ini_set('memory_limit', '2048M');
			$model_c=$this->Admin_m->models();
			// $array=array();
			// foreach($model_c as $val)
			// {
			// 	$array[]=array(
			// 		'Brand'=>$val->Company,
			// 		'Model' =>$val->Product,
			// 		'Series' =>$val->model_series,
			// 		'Color' =>$val->color,
			// 		'Base_Color' =>$val->base_color,
			// 	);
			// }
			// $report=$array;

			 $object = new PHPExcel();

			 $object->setActiveSheetIndex(0);

			 $table_columns = array("BRAND", "MODEL", "SERIES", "COLOR", "BASE_COLOR");

			 $column = 0;

			 foreach($table_columns as $field)
			 {
				$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
				$column++;
			 }

			 // $employee_data = $this->excel_export_model->fetch_data();

			 $excel_row = 2;

			 foreach($model_c as $row)
			 {
				$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->Company);
				$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->Product);
				$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->model_series);
				$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->color);
				$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->base_color);
				$excel_row++;
			 }

			 $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
			 header('Content-Type: application/vnd.ms-excel');
			 header('Content-Disposition: attachment;filename="Model Data.xls"');
			 $object_writer->save('php://output');


		}
}
?>
