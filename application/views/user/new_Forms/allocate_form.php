<?php
$CI =& get_instance();
$CI->load->model('main_m');
// $color=$CI->main_m->color_cat();
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$ids=$datas->id;
$type=$datas->type;
if($type == 1)
{
	$dealer=$CI->main_m->branch();
}else{
	$dealer=$CI->main_m->branch2($ids);
}
$location=$CI->main_m->location();

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
<form class="row needs-validation" id="allocate_form">
<input type="hidden" name="csnum" value="<?php echo $id; ?>"/>
	<div class="col">
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="alloc_date" class="col-sm-12 col-form-label">Allocation Date:</label>
				<div class="col-sm-12">
					<input type="date" name="alloc_date" min='1990-01-01' id="alloc_date" class="form-control" required/>
					 <div class="invalid-feedback">
					 	Please provide a Allocation Date.
					 </div>
				</div>
			</div>
			<div class="col-sm-12">
				<label for="alloc_date" class="col-sm-12 col-form-label">Allocation Dealer:</label>
				<div class="col-sm-12">
					<select class="form-control" name="dealer" id="dealer" required>
						<option value="">Select Dealer</option>
						<?php foreach($dealer as $dlr){ ?>
							<option value="<?php echo $dlr->id; ?>"> <?php echo $dlr->Company.' '.$dlr->Branch; ?> </option>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
						Please select a dealer.
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
