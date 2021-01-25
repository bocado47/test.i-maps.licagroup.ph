<?php
$CI =& get_instance();
$CI->load->model('Dsar_m');

$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$ids=$datas->id;
$type=$datas->type;
$accessdealer=$this->Admin_m->getaccess($ids);

if($type == 2)
{
	if(count($accessdealer) >= 1)
	{
		$dealer=$CI->Dsar_m->dealer2($accessdealer);
	}else{
		$dealer=$CI->Dsar_m->dealer();
	}
}else{
	$dealer=$CI->Dsar_m->dealer();
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
<form class="row needs-validation" id="allocation_form">
  <input type="hidden" name="csid" value="<?php echo $id; ?>"/>
  <input type="hidden" name="po_num" value="<?php echo $po_num; ?>"/>
  	<div class="col">
  		<div class="form-group row">
  			<div class="col-sm-12">
  				<label for="alloc_dealer" class="col-sm-12 col-form-label">Allocation Dealer:</label>
  				<div class="col-sm-12">
            <select class="form-control" name="alloc_dealer" id="alloc_dealer" required>
                <option value="">Select Dealer</options>
                  <?php foreach($dealer as $vl){ ?>
                          <option value="<?php echo $vl->Company; ?>"><?php echo $vl->Company;  ?></option>
                  <?php } ?>
            </select>
  					<div class="invalid-feedback">
  						Please provide a Allocation Dealer.
  					</div>
  				</div>
  			</div>
  		</div>
      <div class="form-group row">
  			<div class="col-sm-12">
  				<label for="alloc_date" class="col-sm-12 col-form-label">Allocation Date:</label>
  				<div class="col-sm-12">
            <input type="date" class="form-control" name="alloc_date" id="alloc_date" required/>
  					<div class="invalid-feedback">
  						Please provide a Allocation Date.
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
</form>
<script type="text/javascript">
  $(document).ready(function() {
    $('#alloc_dealer').select2({
      placeholder: "Select Location",
      width: "100%"
    });
  });
</script>
