<?php
$CI =& get_instance();
$CI->load->model('main_m');
$brands=$CI->Main_m->Brands();
// $location=$CI->Dsar_m->location();

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
<form class="row needs-validation" id="change_location_form">
	<div class="col">
		<div class="form-group row">
			<label for="Brand" class="col-sm-6 col-form-label">Brand:</label>
			<label for="Location" class="col-sm-6 col-form-label">Location:</label>
			<div class="col-sm-6">
				<!-- <input type="text"  class="form-control" name="Brand" value="" required/> -->
				<select class="form-control" name="Brand" id="Brand" required>
					<option value="">Select Brand</option>
					<?php foreach($brands as $value){ ?>
						<option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
					<?php } ?>
				</select>
				<div class="invalid-feedback">
				        Please provide a Brand.
				</div>
			</div>
			<div class="col-sm-6">
				<select class="form-control" name="Location" id="location" required>
					<option value="">Select Location</option>
				</select>
				<div class="invalid-feedback">
				        Please provide a Location.
				</div>
			</div>
		</div>
	</div>
</form>
<script>
	$(document).ready(function(){
			$('select').select2();
		    	$('#location').select2({
	      width: "100%"
	    });
			$("#Brand").on('change',function(){
				var val=$(this).val();
				console.log(val);
				$.ajax({
					url: bUrl+"Dashboard/location2?brand="+val,
							type: "GET",
							dataType: "JSON",
							success: function (data) {
							 var tmp='';
							 tmp+='<option value="">Select Location</option>';

								$.each(data, function( index, value ) {
										tmp +="<option value='"+value.Branch+"'>"+value.Branch+"</option>";
								});
								$('#location').html(tmp);
							},
							error: function() {
									console.log('error');
							}
				});
			});
	});
</script>
