<?php
$CI =& get_instance();
$CI->load->model('Admin_m');
$access=$CI->Dsar_m->company_user_access();
$ids=$id;
$dealer=$CI->Admin_m->branch2($ids);
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
<form class="row needs-validation" id="user_access_form">
	<div class="col">
		<!-- <div class="form-group row" id="admin">
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
		</div -->
		<!-- <?php print_r($id); ?> -->
		<div class="form-group row">
			<label  class="col-sm-12 col-form-label">Company Access:</label>
			<?php foreach($access as $value){ ?>
			<div class="col-sm-4 text-center" style="padding-top: 10px; text-align: left !important;">
				<label for=""></label>

				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input rlsd" name= "access[]" id="<?php echo $value->Company; ?>" value="<?php echo $value->Company; ?>"
					<?php foreach($useraccessdata as $acs) {
					 if($acs->key == $value->Company){
					 ?>
					 checked
					<?php }else{ ?>
						
					<?php
						}
					}
					?>
					>
					<label  class="custom-control-label" for="<?php echo $value->Company; ?>" style="font-size: 18px;"><?php if($value->Company =='MG'){ echo 'MORRIS GARAGES'; }else{ echo $value->Company; } ?></label>
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
			if(value == 1)
			{
				$("#admin").css('display', 'flex');
				$(".Caccess").removeAttr('disabled');
			}else{
				$("#admin").hide();
				$(".Caccess").attr('disabled','disabled');
			}
		});
	});
</script>
