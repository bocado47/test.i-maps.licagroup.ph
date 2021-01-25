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
        // print_r($datas);
?>
<form class="row needs-validation" id="profil_form">
	<div class="col">
		<div class="form-group row">
			<span data-feather="user" style="width:100%; height: 150px; background-color: #000;	color: white;"></span>
			<input type="hidden" name="invoice_id" value=""/>
			<label for="name" class="col-sm-12 col-form-label" style="font-size: 16px;">Name:</label>
			<div class="col-sm-12" style="text-indent: 50px;">
				<input type="text"  class="form-control" name="name" value="<?php echo $datas->name; ?>" readonly/>
			</div>

		</div>
		<div class="form-group row">
			<label for="email" class="col-sm-12 col-form-label" style="font-size: 16px;">Email:</label>
			<div class="col-sm-12" style="text-indent: 50px;">
				<input type="text"  class="form-control" name="email" value="<?php echo $datas->email; ?>" readonly/>
			</div>
		</div>
	</div>
</form>
 <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace();
    </script>
