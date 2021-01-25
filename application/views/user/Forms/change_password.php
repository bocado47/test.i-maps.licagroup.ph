<?php
$CI =& get_instance();
$CI->load->model('main_m');

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
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
?>
<form class="row needs-validation" id="changepass_form">
	<div class="col">
		<div class="form-group row">
			<input type="hidden" name="id" value="<?php echo $datas->id; ?>"/>
		<!-- 	<input type="text" name="password"  id="old" value="<?php echo $datas->password; ?>"/>
			<label for="oldpass" class="col-sm-12 col-form-label" id="oldpass" style="font-size: 16px;">Old Password:</label>
			<div class="col-sm-12" style="text-indent: 50px;">
				<input type="text"  class="form-control" name="oldpass"/>
			</div> -->
			
		</div>
		<div class="form-group row">
			<label for="newpass" class="col-sm-12 col-form-label" style="font-size: 16px;">New Password:</label>
			<div class="col-sm-12" style="text-indent: 50px;">
				<input type="password"  class="form-control" name="newpass" required/>
				<div class="invalid-feedback">
				    Please provide your new password.
				</div>
			</div>
		</div>
	</div>
</form>