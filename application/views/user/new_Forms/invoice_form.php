<?php
$CI =& get_instance();
$CI->load->model('main_m');
$PO_num=$CI->main_m->purchase_order_num();
$location=$CI->main_m->location();
$bank=$CI->main_m->bank();
$paymodes=$CI->main_m->paymodes();
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$id=$datas->id;
$type=$datas->type;
$access=$this->Main_m->m_access($id);
$dealer=$CI->main_m->dealer();

if($type == 1)
{
	$sales=$CI->main_m->salesperson();
	$dealer=$CI->main_m->dealer();
}else{
	$sales=$CI->main_m->salesperson3($access);
	$dealer=$CI->main_m->dealer2($id);
}
// print_r($sales)
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
<?php foreach($info as $value) {
	if($value->plant_release_date == '0000-00-00')
	{
		$pr='';
	}else{
		$pr=$value->plant_release_date;
	}

	if($value->system_release_date == '0000-00-00')
	{
		$sr='';
	}else{
		$sr=$value->system_release_date;
	}
?>
<form class="row needs-validation" id="invoice_form">
	<input type="hidden"  class="form-control" name="csnum" value="<?php echo $csnum; ?>"/>
	<input type="hidden"  class="form-control" name="id" value="<?php echo $value->id; ?>"/>
	<div class="col">
		<div class="form-group row">
			<div class="col-sm-4">
				<label for="last_name" class="col-sm-12 col-form-label">Last Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="last_name" id="last_name" value="<?php echo $value->last_name; ?>" required/>
					 <div class="invalid-feedback">
					 	Please provide a Last Name.
					 </div>
				</div>
			</div>
			<div class="col-sm-4">
				<label for="first_name" class="col-sm-12 col-form-label">First Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="first_name" id="first_name" value="<?php echo $value->first_name; ?>" required/>
					<div class="invalid-feedback">
					 	Please provide a First Name
					 </div>
				</div>
			</div>
			<div class="col-sm-4">
				<label for="middle_name" class="col-sm-12 col-form-label">Middle Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="middle_name" id="middle_name" value="<?php echo $value->middle_name; ?>" />
					<div class="invalid-feedback">
					 	Please provide a Middle Name.
					 </div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="company_name" class="col-sm-12 col-form-label">Company Name:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="company_name" id="company_name" value="<?php echo $value->company; ?>" required/>
					<div class="invalid-feedback">
					 	Please provide a Company Name.
					 </div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="inv_num" class="col-sm-12 col-form-label">Invoice Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="inv_num" pattern="^[a-zA-Z0-9]+$" value="<?php echo $value->invoice_num; ?>" required/>
					<div class="invalid-feedback">
					 	Please provide a Invoice Number.
					 </div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="inv_amt" class="col-sm-12 col-form-label">Invoice Amount:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control money" name="inv_amt" id="inv_amt" value="<?php echo $value->pay_amt; ?>" required/>
					<div class="invalid-feedback">
					 	Please provide a Invoice Amount.
					 </div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="inv_date" class="col-sm-12 col-form-label">Invoice Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="inv_date" min='1990-01-01' value="<?php echo $value->invoice_date; ?>" required/>
					<div class="invalid-feedback">
					 	Please provide a Invoice Date.
					 </div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="alloc_date" class="col-sm-12 col-form-label">Allocation Date:</label>
				<div class="col-sm-12">
					<input type="date" min='1990-01-01' class="form-control" name="alloc_date" value="<?php echo $value->alloc_date; ?>" required/>
					<div class="invalid-feedback">
					 	Please provide a Allocation Date.
					 </div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="salesperson" class="col-sm-12 col-form-label">Salesperson:</label>
				<div class="col-sm-12">
					<select name="salesperson" class="form-control" >
						<option value="">Select Sales Person</option>
						<?php foreach ($sales as $vls) { ?>
							<option value="<?php echo $vls->Name; ?>"><?php echo $vls->Name; ?></option>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
					 	Please provide a Sale Person.
					 </div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="term" class="col-sm-12 col-form-label">Pay Modes:</label>
				<div class="col-sm-12">
					<select name="term" id="paymodes" class="form-control" required>
						<option value="">Select Pay Mode</option>
						<?php foreach($paymodes as $dlr) {
							if($dlr->name == $value->term){ ?>
							<option value="<?php echo $dlr->name; ?>" selected><?php echo $dlr->name; ?></option>
							<?php }else{ ?>
							<option value="<?php echo $dlr->name; ?>"><?php echo $dlr->name; ?></option>
							<?php } ?>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
					 	Please provide a Payment Mode.
					 </div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="paid_date" class="col-sm-12 col-form-label">Paid Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="paid_date" min='1990-01-01'/>
					<div class="invalid-feedback">
						Please provide a Valid Paid Date:.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="bank" class="col-sm-12 col-form-label">Bank:</label>
				<div class="col-sm-12">
					<select name="bank"  id="bank" class="form-control" disabled="disabled" required>
						<option value="">Select Bank</option>
						<?php foreach($bank as $dlr) {
								if($dlr->bank_code == $value->bank){ ?>
								<option value="<?php echo $dlr->bank_code; ?>" selected><?php echo $dlr->Description; ?></option>
								<?php }else{ ?>
								<option value="<?php echo $dlr->bank_code; ?>"><?php echo $dlr->Description; ?></option>
								<?php } ?>
							<?php } ?>
					</select>
					<div class="invalid-feedback">
					 	Please provide a Bank.
					 </div>
				</div>
			</div>
			<div class="col-sm-6"></div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="grp_lica" class="col-sm-12 col-form-label">(Lica) Sale Report To:</label>
				<div class="col-sm-12">
					<select name="grp_lica" class="form-control" required>
						<option value="">Select Group lica</option>
						<?php foreach ($dealer as $val) {
							 if($val->id == $value->grp_lica){
							?>
							<option value="<?php echo $val->id; ?>" selected><?php echo $val->Company; ?></option>
						<?php }else{ ?>
							<option value="<?php echo $val->id; ?>"><?php echo $val->Company; ?></option>
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
					<select name="grp_plant" class="form-control">
						<option value="">Select Group Plant</option>
						<?php foreach ($dealer as $value) { ?>
							<option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
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
					 <input type="text" name="pr_date" id="pr_date" class="form-control form-control-1 input-sm montyr" placeholder="Plant Released Month " value="<?php echo $pr; ?>">
				</div>
			</div>
			<div class="col-sm-6">
				<label for="ar_date" class="col-sm-12 col-form-label">Actual Released Date:</label>
				<div class="col-sm-12">
					<input type="date"  min='1990-01-01' name="ar_date" class="form-control form-control-1 input-sm" />
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="sr_date" class="col-sm-12 col-form-label">Accounting Sale Period:</label>
				<div class="col-sm-12">
					<input type="text" name="sr_date" id="sr_date" class="form-control form-control-1 input-sm montyr" placeholder="Accounting Sale Period" value="<?php echo $sr; ?>">
				</div>
			</div>

		</div>

	</div>
</form>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {

			$('.money').mask("#,###.##", {reverse: true});
			var bUrl="<?php echo base_url(); ?>";
			$('.montyr').datepicker({
			    	format: "mm-yyyy",
				    viewMode: "months",
				    minViewMode: "months",
				    autoclose: true,
				});
				$('.dates').datepicker({
					format: "dd-mm-yyyy",
					autoclose: true,
				});
				$('select').select2();
	    	$('#location').select2({
    	placeholder: "Select Location",
      width: "100%"
    });
		$("#paymodes").on('change',function(){
				var paymode=$(this).val();

				if(paymode == 'company po' || paymode == 'cash')
				{
					$('#bank').attr('disabled','disabled');
					// $('#bankrow').hide();
				}else{
					$('#bank').attr('disabled',false);
					// $('#bankrow').show();
				}
		});
	});
</script>
