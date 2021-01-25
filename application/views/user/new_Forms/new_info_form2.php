<?php
$CI =& get_instance();
$CI->load->model('main_m');
$PO_num=$CI->main_m->purchase_order_num();
$location=$CI->main_m->location();
$sales=$CI->main_m->salesperson();
$bank=$CI->main_m->bank();
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$ids=$datas->id;
$type=$datas->type;
if($type == 1)
{
	$dlrs=$CI->main_m->branch();
}else{
	$dlrs=$CI->main_m->branch2($ids);
}
?>

<style type="text/css">
	.jconfirm-content{
		overflow: hidden !important;
	}
	.jconfirm{
		z-index:1000;
	}
	textarea{
		resize: none;
	}
	.select2-container--default .select2-selection--single
	{
		height: calc(2.25rem + 2px) !important;
	}
</style>
<?php
$model='';
$dealer='';
$po_num='';
$year='';
foreach($info as $value){

$model=$value->model;
$year=$value->model_yr;
$locations=$value->location;
$newloc = explode('^', $locations);

$prdate=$value->plant_release_date;
if($prdate == '0000-00-00')
{
	$prdate='';
}else{
	$prdate=date("m-Y", strtotime($value->plant_release_date));
}
$sr_date=$value->system_release_date;
if($sr_date == '0000-00-00')
{
	$sr_date='';
}else{
	$sr_date=date("m-Y", strtotime($value->system_release_date));
}
$w_date=$value->whole_sale_period;
if($w_date == '0000-00-00')
{
	$w_date='';
}else{
	$w_date=date("m-Y", strtotime($value->whole_sale_period));
}
?>
<form class="row needs-validation" id="info_vechile_form">
	<div class="col">
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="cs_num" class="col-sm-12 col-form-label">CS Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="cs_num" id="cs_num" value="<?php echo $value->cs_num; ?>" readonly/>
					<div class="invalid-feedback">
						Please provide a C.S Number.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="color" class="col-sm-12 col-form-label">location:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="location" id="location" value="<?php echo $value->location; ?>" readonly/>
				</div>
			</div>
		</div>
		<br/>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="purchase_order" class="col-sm-12 col-form-label">Purchase Order Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="purchase_order" id="purchase_order" value="<?php echo $value->purchase_order; ?>" readonly/>
					<div class="invalid-feedback">
						Please provide a Purchase Order Number.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="cost" class="col-sm-12 col-form-label">Cost:</label>
				<div class="col-sm-12">
					<input type="text"  min="0"  class="form-control money" name="cost" id="cost" value="<?php echo number_format((float)$value->cost,2,'.',''); ?>" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="vvr_num" class="col-sm-12 col-form-label">Reference Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="vvr_num" value="<?php echo $value->vrr_num; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="received_date" class="col-sm-12 col-form-label">Vehicle Received Date:</label>
				<div class="col-sm-12">
					<input type="date"  class="form-control" name="received_date" value="<?php echo $value->veh_received; ?>" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="csr_date" class="col-sm-12 col-form-label">CSR Received Date:</label>
				<div class="col-sm-12">
					<input type="date"  class="form-control" name="csr_date" value="<?php echo $value->csr_received; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="paid_date" class="col-sm-12 col-form-label">Paid Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="paid_date" value="<?php echo $value->paid_date; ?>" readonly/>
				</div>
			</div>
		</div>
		<br/>
		<h4>Vehicle Details :</h4>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="model" class="col-sm-12 col-form-label">Model:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="model" id="model" value="<?php echo $value->model; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="model_yr" class="col-sm-12 col-form-label">Year Model:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="model_yr" id="model_yr" value="<?php echo $value->model_yr; ?>" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="color" class="col-sm-12 col-form-label">Color:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="color" value="<?php echo $value->color; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="vin_num" class="col-sm-12 col-form-label">VIN Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="vin_num" value="<?php echo $value->vin_num; ?>" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="eng_num" class="col-sm-12 col-form-label">Engine Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="eng_num" value="<?php echo $value->engine_num; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="prod_num" class="col-sm-12 col-form-label">Prod Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="prod_num" value="<?php echo $value->prod_num; ?>" readonly/>
				</div>
			</div>
		</div>
		<br/>
		<h4>Sales Info :</h4>
		<div class="form-group row">
			<div class="col-sm-4">
				<label for="last_name" class="col-sm-12 col-form-label">Last Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="last_name" value="<?php echo $value->last_name; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-4">
				<label for="first_name" class="col-sm-12 col-form-label">First Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="first_name" value="<?php echo $value->first_name; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-4">
				<label for="middle_name" class="col-sm-12 col-form-label">Middle Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="middle_name" value="<?php echo $value->middle_name; ?>" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="company_name" class="col-sm-12 col-form-label">Company Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="company_name" value="<?php echo $value->company; ?>" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="inv_num" class="col-sm-12 col-form-label">Invoice Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="inv_num" value="<?php echo $value->invoice_num; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="inv_amt" class="col-sm-12 col-form-label">Invoice Amount:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control money" name="inv_amt" value="<?php echo number_format((float)$value->pay_amt,2,'.',''); ?>" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="inv_date" class="col-sm-12 col-form-label">Invoice Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="inv_date" value="<?php echo $value->invoice_date; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="alloc_date" class="col-sm-12 col-form-label">Allocation Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="alloc_date" value="<?php echo $value->alloc_date; ?>" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="subsidy" class="col-sm-12 col-form-label">Subsidy:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="subsidy" value="<?php echo $value->subsidy; ?>" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="salesperson" class="col-sm-12 col-form-label">Salesperson:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="salesperson" id="salesperson" value="<?php echo ucfirst($value->salesperson); ?>" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="term" class="col-sm-12 col-form-label">Term:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="term" value="<?php echo $value->term; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="bank" class="col-sm-12 col-form-label">Bank:</label>
				<div class="col-sm-12">
					<?php foreach($bank as $dlr) {
							if($dlr->bank_code == $value->bank){ ?>
								<input type="text" class="form-control" name="bank" value="<?php echo $value->Description; ?>" readonly/>
							<?php }else{ ?>
							<input type="text" class="form-control" name="bank" value="<?php echo $value->bank; ?>" readonly/>
							<?php } ?>
						<?php } ?>


				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="grp_lica" class="col-sm-12 col-form-label">(Lica) Sale Report To:</label>
				<div class="col-sm-12">
					<select name="grp_lica" class="form-control" required>
						<option value="">Select Group lica</option>
						<?php foreach ($dlrs as $val) {
							 if($val->id == $value->grp_lica){
							?>
							<option value="<?php echo $val->id; ?>" selected><?php echo $val->Company.' '.$val->Branch; ?></option>
						<?php }else{ ?>
							<option value="<?php echo $val->id; ?>"><?php echo $val->Company.' '.$val->Branch; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
					 	Please provide a Group Lica Dealer.
					 </div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="grp_plant" class="col-sm-12 col-form-label">(Plant) Sale Report To:</label>
				<div class="col-sm-12">
					<select name="grp_plant" class="form-control" required>
						<option value="">Select Group Plant</option>
						<?php foreach ($dlrs as $val) {
							 if($val->id == $value->grp_plant){
							?>
							<option value="<?php echo $val->id; ?>" selected><?php echo $val->Company.' '.$val->Branch; ?></option>
						<?php }else{ ?>
							<option value="<?php echo $val->id; ?>"><?php echo $val->Company.' '.$val->Branch; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
					 	Please provide a Group Plant Dealer.
					 </div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="pr_date" class="col-sm-12 col-form-label">Plant Released Month:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="pr_date" value="<?php echo $prdate; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="ar_date" class="col-sm-12 col-form-label">Actual Released Date:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="ar_date" value="<?php echo $value->actual_release_date; ?>" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="sr_date" class="col-sm-12 col-form-label">Accounting Sale Period:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="sr_date" value="<?php echo $sr_date; ?>" readonly/>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="posted_date" class="col-sm-12 col-form-label">Whole Sale Period:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="posted_date" value="<?php echo $w_date; ?>" readonly/>
				</div>
			</div>
		</div>
		<br/>
		<h4>Other Details :</h4>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="remarks" class="col-sm-12 col-form-label">Remarks:</label>
				<div class="col-sm-12">
					<textarea class="form-control" name="remarks"><?php echo $value->remarks; ?></textarea>
				</div>
			</div>
		</div>
	</div>
</form>
<?php } ?>
