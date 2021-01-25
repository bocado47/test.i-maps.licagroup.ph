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
  .select2-container--default .select2-selection--single {
      height: calc(2.25rem + 2px) !important;
      width: auto !important;
      text-align: left;
      padding-left: 3px;
      font-size: 15px;
      padding-top: 3px;
  }
</style>
<?php
foreach($podetails as $value)
{
  $dealer=$value->dealer;
  $model=$value->model;
  $model_yr=$value->model_yr;
  $color=$value->color;
  $po_num=$value->po_num;
  $cost=$value->cost;
  $poid=$value->ids;
}
?>

<form class="row needs-validation" id="vechile_form2">
	<div class="col">
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="cs_num" class="col-sm-12 col-form-label">CS Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="cs_num" id="cs_num" pattern="[a-zA-Z0-9\s]+" required/>
					<div class="invalid-feedback">
						Please provide a C.S Number.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="color" class="col-sm-12 col-form-label">Location:</label>
				<div class="col-sm-12">
          <select class="form-control" name="location" id="location" >
						<option value="">Select Location</option>
						<?php foreach ($location as $value) { ?>
							<option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
						Please provide a location.
					</div>
				</div>
			</div>
		</div>
		<br/>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="purchase_order" class="col-sm-12 col-form-label">Purchase Order Number:</label>
				<div class="col-sm-12">
					<input type="text" value="<?php echo $po_num; ?>" class="form-control" name="po_num" readonly/>
					<input type="hidden" value="<?php echo $po_num.','.$dealer.','.$poid; ?>" class="form-control" name="purchase_order" readonly/>
					<div class="invalid-feedback">
						Please provide a Purchase Order Number.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="cost" class="col-sm-12 col-form-label">Cost:</label>
				<div class="col-sm-12">
					<input type="text"  min="0"  class="form-control money"  value="<?php echo number_format((float)$cost,2,'.',''); ?>" name="cost" id="cost" readonly/>
					<div class="invalid-feedback">
						Please provide a Cost.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="vvr_num" class="col-sm-12 col-form-label">Reference number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control s" name="vvr_num" pattern="[a-zA-Z0-9\s]+"/>
					<div class="invalid-feedback">
						Please provide a Vehicle Receipt Report.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="received_date" class="col-sm-12 col-form-label">Vehicle Received Date:</label>
				<div class="col-sm-12">
					<input type="date"  class="form-control s" name="received_date" min='1990-01-01'/>
					<div class="invalid-feedback">
						Please provide a  Valid Vehicle Received Date
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="csr_date" class="col-sm-12 col-form-label">CSR Received Date:</label>
				<div class="col-sm-12">
					<input type="date"  class="form-control" name="csr_date" min='1990-01-01'/>
					<div class="invalid-feedback">
						Please provide a  CSR Received Date
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="paid_date" class="col-sm-12 col-form-label">Paid Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="paid_date" min='1990-01-01' />
					<div class="invalid-feedback">
						Please provide a Valid Paid Date:.
					</div>
				</div>
			</div>
		</div>
		<br/>
		<h4>Vehicle Information :</h4>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="model" class="col-sm-12 col-form-label">Model:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="model3" id="model3"  readonly/>
					<select class="form-control" name="model" id="model2" style="display:none;">
						<option value="">Select Model</option>
					</select>
					<div class="invalid-feedback">
						Please provide a Model.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="model_yr" class="col-sm-12 col-form-label">Year Model:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="model_yr3" id="model_yr3"  readonly/>
					<select class="form-control" name="model_yr" id="model_yr2" style="display:none;"><option value="">Select Year</option></select>
					<div class="invalid-feedback">
						Please provide a Year Model.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="color" class="col-sm-12 col-form-label">Color:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="color3" id="color3"  readonly/>
					<select class="form-control" name="color" id="color2" style="display:none;">
						<option value="">Select Color</option>
					</select>
					<!-- <input type="text"  class="form-control" name="color" pattern="[a-zA-Z0-9\s]+" required/> -->
					<div class="invalid-feedback">
						Please provide a Color.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="vin_num" class="col-sm-12 col-form-label">VIN Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="vin_num" pattern="[a-zA-Z0-9\s]+" />
					<div class="invalid-feedback">
						Please provide a VIN Number.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="eng_num" class="col-sm-12 col-form-label">Engine Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="eng_num" pattern="[a-zA-Z0-9\s]+" />
					<div class="invalid-feedback">
						Please provide a ENG Number.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="prod_num" class="col-sm-12 col-form-label">Prod Number:</label>
				<div class="col-sm-12">
					<input type="text"  class="form-control" name="prod_num" pattern="[a-zA-Z0-9\s]+" />
					<div class="invalid-feedback">
						Please provide a Prod Number.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="eng_num" class="col-sm-12 col-form-label">Subsidy Claiming:</label>
				<div class="col-sm-12">
					<input type="text" min="0"  class="form-control money" name="subsidy_claiming"/>
					<div class="invalid-feedback">
						Please provide a Subsidy Claiming.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="prod_num" class="col-sm-12 col-form-label">Subsidy Claimed:</label>
				<div class="col-sm-12">
					<input type="text" min="0"  class="form-control money" name="subsidy_claimed" />
					<div class="invalid-feedback">
						Please provide a Subsidy Claimed.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="eng_num" class="col-sm-12 col-form-label">Allocation Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control" name="alloc_date" pattern="[a-zA-Z0-9\s]+" />
					<div class="invalid-feedback">
						Please provide a Allocation Date.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="prod_num" class="col-sm-12 col-form-label">Allocation Dealer:</label>
				<div class="col-sm-12">
					<select class="form-control" name="alloc_dealer" id="alloc_dealer" >
						<option value="">Select Allocation Dealer</option>
						<?php foreach ($location as $value) { ?>
							<option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
						Please provide a Dealer.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="prod_num" class="col-sm-12 col-form-label">Plant Sales Report:</label>
				<div class="col-sm-12">
					<select class="form-control" name="plant_sales_report" id="plant_sales_report" >
						<option value="">Select Plant Sales Report</option>
						<?php foreach ($location as $value) { ?>
							<option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
						<?php } ?>
					</select>
					<div class="invalid-feedback">
						Please provide a Plant Sales Report.
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<label for="eng_num" class="col-sm-12 col-form-label">Plant Sales Month:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control form-control-1 input-sm montyr" name="plant_sales_month" id="psm"  />
					<div class="invalid-feedback">
						Please provide a Plant Sales Month.
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="eng_num" class="col-sm-12 col-form-label">Whole Sale Period:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control form-control-1 input-sm montyr" name="whole_sale_period" id="wsp" />
					<div class="invalid-feedback">
						Please provide a Whole Sale Period.
					</div>
				</div>
			</div>
		</div>
		<br/>
		<h4>Other Details :</h4>
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="remarks" class="col-sm-12 col-form-label">Remarks:</label>
				<div class="col-sm-12">
					<textarea class="form-control" name="remarks"></textarea>
				</div>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
$(document).ready(function() {
			var bUrl="<?php echo base_url(); ?>";
			var dealer="<?php echo $dealer; ?>";
			var model="<?php echo $model; ?>";
			var model_yr="<?php echo $model_yr; ?>";
			var color="<?php echo $color; ?>";
      var select=	$('#plant_sales_report, #alloc_dealer, #location').select2();
			console.log(model);
      $('.money').mask("#,##0.00", {reverse: true});
      // model
        $.ajax({
            url: bUrl+"Inventory/Model?dealer="+dealer,
                type: "GET",
                dataType: "JSON",
                success: function (data) {

                 var tmp='';
                 tmp+='<option >Select Model</option>';
                  $.each(data, function( index, value ) {
                    if(model == value.id)
                    {
											console.log(model);
                      tmp +="<option value='"+value.id+"' selected>"+value.Product+"</option>";
											  $('#model3').val(value.Product);
                    }else{
                      tmp +="<option value='"+value.id+"'>"+value.Product+"</option>";
                    }

                  });
            $('#model2').html(tmp);
                },
                error: function() {
                    console.log('error');
                }
          });
      // model
      // model_yr
        for (i = new Date().getFullYear()+4; i >= 1990; i--)
        {
        if(model_yr == i)
        {
          $('#model_yr2').append($('<option selected />').val(i).html(i));
					$('#model_yr3').val(i);
        }else{
          $('#model_yr2').append($('<option />').val(i).html(i));
        }

      }
      // modelyr

      // model color
        $.ajax({
        url: bUrl+"Inventory/model_color?model_id="+model,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
              console.log(data);
             var tmps='';
             tmps+='<option value="" >Select Color</option>';
              $.each(data, function( index, value ) {
                if(color == value.color)
                {
                  tmps+="<option value='"+value.color+"' selected>"+value.color+"</option>";
									  $('#color3').val(value.color);
                }else{
                  tmps+="<option value='"+value.color+"'>"+value.color+"</option>";
                }

              });
        $('#color2').html(tmps);
        // $('#Color').prop('disabled',false);
            },
            error: function() {
                console.log('error');
            }
      });
      // model color
});
</script>
