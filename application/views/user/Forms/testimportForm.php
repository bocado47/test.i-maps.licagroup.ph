<style type="text/css">
	red{
		color: red;
	}
</style>
<p style="text-align: right;">(Save your file as <red><b>.xls</b></red> before upload it)</p>

<form id="importform" enctype="multipart/form-data">
	 <!-- div class="input-default-wrapper mt-3">

	  <span class="input-group-text mb-3" id="input1">Upload</span>

	  <input type="file" id="file-with-current" class="input-default-js" name="userfile"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">

	  <label class="label-for-default-js rounded-right mb-3" for="file-with-current"><span class="span-choose-file">Choose
	      file</span>

	    <div class="float-right span-browse">Browse</div>

	  </label>

	</div> -->
	<div class="progress" style="display: none;">
		<div id="loadingBar"  class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
		Uploading 0%
		</div>
	</div>
	<div class="input-group input-file" name="Fichier1">
			<span class="input-group-btn">
        		<button class="btn btn-default btn-choose" type="button" style="border-radius:0px !important;">Choose</button>
    		</span>
    		<input type="text" class="form-control" placeholder='Click here to choose file...' name="userfile" id="userFile" accept=".xls" required/>
    		<span class="input-group-btn">
       			 <button class="btn btn-warning btn-reset" type="button" style="border-radius:0px !important;">Remove</button>
    		</span>
				<p style="color:red;font-size:10px;">*Record with same P.O Number and C.S Number  will put on Import Error Log.<br/>
				*Record without same P.O Number but same C.S will record as invalid record.</p>
	</div>
</form>
<Script>
	$(document).ready(function(){
		function bs_input_file() {
	$(".input-file").before(
		function() {
			if ( ! $(this).prev().hasClass('input-ghost') ) {
				var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0' name='userfile' id='userFile' accept='application/vnd.ms-excel' >");
				element.attr("name",$(this).attr("name"));
				element.change(function(){
					element.next(element).find('input').val((element.val()).split('\\').pop());
				});
				$(this).find("button.btn-choose").click(function(){
					element.click();
				});
				$(this).find("button.btn-reset").click(function(){
					element.val(null);
					$(this).parents(".input-file").find('input').val('');
				});
				$(this).find('input').css("cursor","pointer");
				$(this).find('input').mousedown(function() {
					$(this).parents('.input-file').prev().click();
					return false;
				});
				return element;
			}
		}
	);
}
$(function() {
	bs_input_file();
});
	});
</Script>
