<?php
$CI =& get_instance();
$CI->load->model('Dsar_m');

$dealer=$CI->Dsar_m->cm();
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
<form class="row needs-validation" id="change_alloc_form">
  <?php foreach($info as $value){ ?>
  <input type="hidden" name="csid" value="<?php echo $id; ?>"/>
  	<div class="col">
  		<div class="form-group row">
  			<div class="col-sm-12">
  				<label for="alloc_dealer" class="col-sm-12 col-form-label">Allocation Dealer:</label>
  				<div class="col-sm-12">
            <select class="form-control" name="alloc_dealer" id="alloc_dealer" required>
                <option value="">Select Dealer</options>
                  <?php foreach($dealer as $vl){
                        if($value->alloc_dealer == $vl->Company.'-'.$vl->Branch){ ?>
                          <option value="<?php echo $vl->Company.'-'.$vl->Branch; ?>" selected><?php echo $vl->Company.'-'.$vl->Branch;  ?></option>
                          <?php }else{ ?>
                            <option value="<?php echo $vl->Company.'-'.$vl->Branch; ?>"><?php echo $vl->Company.'-'.$vl->Branch;  ?></option>
                          <?php } ?>
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
            <input type="date" class="form-control" name="alloc_date" id="alloc_date" value="<?php echo $value->alloc_date; ?>"/>
  					<div class="invalid-feedback">
  						Please provide a Allocation Date.
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  <?php } ?>
</form>
<script type="text/javascript">
  $(document).ready(function() {
    $('#alloc_dealer').select2({
      placeholder: "Select Location",
      width: "100%"
    });
  });
</script>
