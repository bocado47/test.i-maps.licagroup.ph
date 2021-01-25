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
<?php foreach($info as $value) {

$prdate=$value->plant_release_date;
if($prdate == '0000-00-00')
{
	$prdate='';
}else{
	$prdate=date("m-Y", strtotime($value->plant_release_date));
}
$sr_date=$value->system_release_date;
if($sr_date == '0000-00-00')
{
	$sr_date='';
}else{
	$sr_date=date("m-Y", strtotime($value->system_release_date));
}

?>
<form class="row needs-validation" id="release_form">
	<input type="hidden"  class="form-control" name="csnum" value="<?php echo $csnum; ?>"/>
	<input type="hidden"  class="form-control" name="id" value="<?php echo $value->id; ?>"/>
	<div class="col">
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="pr_date" class="col-sm-12 col-form-label">Plant Released Month:</label>
				<div class="col-sm-12">
					<input type="text" name="pr_date" id="pr_date" class="form-control form-control-1 input-sm montyr" placeholder="Plant Released Month" value="<?php echo $prdate; ?>" />
				</div>
			</div>
			<div class="col-sm-6">
				<label for="ar_date" class="col-sm-12 col-form-label">Actual Released Date:</label>
				<div class="col-sm-12">
					<input type="date" name="ar_date" min='1990-01-01' class="form-control form-control-1 input-sm" readonly/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label for="sr_date" class="col-sm-12 col-form-label">Accounting Sale Period:</label>
				<div class="col-sm-12">
					<input type="text" name="sr_date" id="sr_date" class="form-control form-control-1 input-sm montyr" placeholder="Accounting Sale Period" value="<?php echo $sr_date; ?>" >
				</div>
			</div>
		</div>
	</div>
</form>
<?php } ?>
<script type="text/javascript">
		$(document).ready(function() {
			var bUrl="<?php echo base_url(); ?>";
				$('.montyr').datepicker({
			    	format: "mm-yyyy",
				    viewMode: "months",
				    minViewMode: "months",
				    autoclose: true,
				});
				$('.dates').datepicker({
				format: "dd-mm-yyyy",
				autoclose: true,
			});
		});
</script>
