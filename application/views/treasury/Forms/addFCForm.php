<?php
$CI =& get_instance();
$CI->load->model('main_m');
$color=$CI->main_m->color_cat();
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
	input {
  display: block;
  width: 150px;
}
tr th{
  text-align:center;
}
</style>
    <form class="row" class="needs-validation" id="poform">
			<div class="col">
				<div class="form-group row">
            <div class="col-sm-4">
              <label for="bank" class="col-sm-12 col-form-label">Bank:</label>
              <div class="col-sm-12">
                 <select name="bank" class="form-control"></select>
                  <div class="invalid-feedback">
                    Please provide a Bank.
                  </div>
              </div>
            </div>
            <div class="col-sm-8"></div>
            <div class="col-sm-4">
              <label for="date" class="col-sm-12 col-form-label">Date:</label>
              <div class="col-sm-12">
                 <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly/>
              </div>
            </div>
            <div class="col-sm-5">
              <label for="ponum" class="col-sm-12 col-form-label">Choose P.O.:</label>
              <div class="col-sm-12">
                 <select name="ponum" class="form-control"></select>
                  <div class="invalid-feedback">
                    Please provide a P.O numebr.
                  </div>
              </div>
            </div>
            <div class="col-sm-3">
              <button class="btn btn-primary btnaddpo" style="margin-top:30px;">Add</button>
            </div>
			  </div>
        <div class="form-group row">
          <div class="col-sm-12">
            <h4 style="text-align:left;"> Selected P.O.s:</h4>
            <table class="table table-striped table-sm" id="table" width="100%">
                  <thead>
                    <tr>
                      <th>P.O.#</th>
                      <th>Model</th>
                      <th>Color</th>
                      <th>P.O. Date</th>
                      <th>Cost</th>
                    </tr>
                  </thead>
            </table>
          </div>
        </div>
     </div>
	</form>
<script type="text/javascript">
	$(document).ready(function() {

	});
</script>
