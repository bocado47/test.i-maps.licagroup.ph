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
<?php foreach($info as $value){ ?> 
<form class="row needs-validation" id="release_form">
	<div class="col">
		<div class="form-group row">
		<div class="col-sm-6">
			<label for="release_date" class="col-sm-12 col-form-label">CS Number:</label>
			<div class="col-sm-12">
				<input type="hidden" class="form-control" name="vid"  id="vid"  value="<?php echo $id;?>" readonly/>
				<input type="text" class="form-control" name="csnum"  id="csnum"  value="<?php echo $value->cs_num;?>" readonly/>
			</div>
		</div>
		<div class="col-sm-6">
				<label for="pr_date" class="col-sm-12 col-form-label">Plant Released Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control release" name="pr_date" />
				</div>
			</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-6">
				<label for="sr_date" class="col-sm-12 col-form-label">System Released Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control release" name="sr_date" />
				</div>
		</div>
			<div class="col-sm-6">
				<label for="ar_date" class="col-sm-12 col-form-label">Actual Released Date:</label>
				<div class="col-sm-12">
					<input type="date" class="form-control release" name="ar_date" />
				</div>
			</div>
	</div>
	</div>
</form>

<?php }?> 