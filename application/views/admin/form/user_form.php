<?php
$CI =& get_instance();
$access=$CI->Dsar_m->company_user_access();
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
	#admin
	{
		display:none;
	}
</style>
<form class="row needs-validation" id="user_form">
	<div class="col">
		<div class="form-group row">
			<label for="name" class="col-sm-12 col-form-label">Name:</label>
			<div class="col-sm-12">
				<input type="text"  class="form-control" name="name" required/>
				<div class="invalid-feedback">
				        Please provide a Name.
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label for="email" class="col-sm-12 col-form-label">Email:</label>
			<div class="col-sm-12">
				<input type="email"  class="form-control" name="email" required/>
				<div class="invalid-feedback">
				        Please provide a Email.
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label for="password" class="col-sm-6 col-form-label">Password:</label>
			<label for="type" class="col-sm-6 col-form-label">Type:</label>
			<div class="col-sm-6">
				<input type="password"  class="form-control" name="password" required/>
				<div class="invalid-feedback">
				        Please provide a Password.
				</div>
			</div>
			<div class="col-sm-6">
				<select class="form-control" name="type" id="type" required>
					<option value="">Select Type</option>
					<option value="1">Admin</option>
					<option value="2">Sales</option>
					<option value="3">OPS</option>
					<option value="4">Finance</option>
				</select>
				<div class="invalid-feedback">
				        Please provide a Type.
				</div>
			</div>
		</div>
	<!-- 	<div class="form-group row" id="admin">
			<label  class="col-sm-12 col-form-label">Config Access:</label>
				<div class="col-sm-3 text-center" style="padding-top: 10px; text-align: left !important;">
					<label for=""></label>

					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input Caccess" name="Caccess[]" id="user" value="user" disabled>
						<label  class="custom-control-label" for="user" style="font-size: 18px;">User Access</label>
					</div>
				</div>
				<div class="col-sm-3 text-center" style="padding-top: 10px; text-align: left !important;">
					<label for=""></label>

					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input Caccess" name="Caccess[]" id="financier" value="financier" disabled>
						<label  class="custom-control-label" for="financier" style="font-size: 18px;">Financier Access</label>
					</div>
				</div>
				<div class="col-sm-3 text-center" style="padding-top: 10px; text-align: left !important;">
					<label for=""></label>

					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input Caccess" name="Caccess[]" id="paymentmode" value="paymentmode" disabled>
						<label  class="custom-control-label" for="paymentmode" style="font-size: 18px;">Payment Mode Access</label>
					</div>
				</div>
				<div class="col-sm-3 text-center" style="padding-top: 10px; text-align: left !important;">
					<label for=""></label>

					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input Caccess" name="Caccess[]" id="location" value="location" disabled>
						<label  class="custom-control-label" for="location" style="font-size: 18px;">Location Table Access</label>
					</div>
				</div>
		</div> -->
		<div class="form-group row" id="admin">
			<label  class="col-sm-12 col-form-label">Company Access:</label>
			<?php foreach($access as $value){ ?>
			<div class="col-sm-4 text-center" style="padding-top: 10px; text-align: left !important;">
				<label for=""></label>

				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input rlsd" name="access[]" id="<?php echo $value->Company; ?>" value="<?php echo $value->Company; ?>">
					<label  class="custom-control-label" for="<?php echo $value->Company; ?>" style="font-size: 18px;"><?php echo $value->Company; ?></label>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function() {
		$("#type").on('change',function(){
			var value=$(this).val();
			if(value == 2)
			{
				$("#admin").css('display', 'flex');
				$(".Caccess").removeAttr('disabled');
			}else{
				$(".rlsd").attr('disabled','disabled');
				$("#admin").hide();
				$(".Caccess").attr('disabled','disabled');
			}
		});
	});
</script>
