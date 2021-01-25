<?php
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$ids=$datas->id;
$type=$datas->type;
?>
<style type="text/css">
   .sorting_asc:before{
    display: none !important;
  }
  .sorting_asc:after{
    display: none !important;
  }
  .label-style{
    width:150px !important;
    line-height: 4;
    font-weight: bold;
  }
  textarea {
  resize: none;
}
.row{
  margin-left: 0px !important;
}
.sls{
  padding: 0px !important;
  color: #fff;
  background-color: #000;
  margin-right: -20;
  margin-left: -20!Important;
  padding-left: 25px !important;
}
.select2-container--default .select2-selection--single {
  display: block;
  width: 100% !important;
  height: calc(2.25rem + 2px);
  padding: 3px;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: .25rem;
  transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.select2-container{
  width: 100% !important;
}
table td{
  text-align: left;
}
.table td{
      padding: 0.45rem !important;
          font-size: 15px;
}
label{
  font-weight: bold;
}
/* .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 35px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px;
} */
input{
  text-align: center;
}
/* .spinner-grow{
  background-color: white;
}
.spinner-grow .test1
{
  -webkit-animation-delay: -1.0s;
  animation-delay:-1.0s
}
.spinner-grow .test2
{
  -webkit-animation-delay: -0.9s;
  animation-delay:-0.9s
}
.spinner-grow .test3
{
  -webkit-animation-delay: -0.8s;
  animation-delay:-0.8s
}
.spinner-grow .test4
{
  -webkit-animation-delay: -0.7s;
  animation-delay:-0.7s
}
.spinner-grow .test5
{
  -webkit-animation-delay: -0.6s;
  animation-delay:-1.0s
} */
.lds-ellipsis {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-ellipsis div {
  position: absolute;
  top: 33px;
  width: 13px;
  height: 13px;
  border-radius: 50%;
  background: #fff;
  animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
.lds-ellipsis div:nth-child(1) {
  left: 8px;
  animation: lds-ellipsis1 0.6s infinite;
  background-color: #000;
}
.lds-ellipsis div:nth-child(2) {
  left: 8px;
  animation: lds-ellipsis2 0.6s infinite;
  background-color: #000;
}
.lds-ellipsis div:nth-child(3) {
  left: 32px;
  animation: lds-ellipsis2 0.6s infinite;
  background-color: #000;
}
.lds-ellipsis div:nth-child(4) {
  left: 56px;
  animation: lds-ellipsis3 0.6s infinite;
  background-color: #000;
}
@keyframes lds-ellipsis1 {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes lds-ellipsis3 {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(0);
  }
}
@keyframes lds-ellipsis2 {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(24px, 0);
  }
}
.active{
  color:#fff !important;
}
#exampleCheck1 {
    -ms-transform: scale(2);
    -moz-transform: scale(2);
    -webkit-transform: scale(2);
    -o-transform: scale(2);
    transform: scale(2);
    padding: 5px;
}
</style>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Search Dashboard</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-1">
                <!-- <span data-feather="calendar"></span>Date -->
            </div>
            <!-- <div class="btn-group mr-2">
              <button class="btn btn-md btn-outline-secondary" id="apo"><span data-feather="shopping-cart"></span> Add Purchase Order</button>
              <button class="btn btn-md btn-outline-secondary" id="import"><span data-feather="download"></span> Batch Import</button>
            </div>
          <a href="../Excel/IMAPS_SAMPLE_DATA.xls"><button class="btn btn-md btn-outline-secondary" id="import"><span data-feather="download"></span>Download Sample File</button></a> -->
       </div>
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3" style="float:left; margin-bottom:20px;">
      <div class="btn-toolbar mb-3 mb-md-0">
        <div class="btn-group mr-2">
           <label for="selectSTatus" class="label-style"> Search by PO#:</label>
           <input type="text" class="form-control" id="Search_PO"/>

         </div>
         <div class="btn-group mr-3">
           <button class="btn btn-primary btn-sm form-control" id="btnSearchpo">Search PO</button>
         </div>
         <div class="btn-group mr-2">
           <label for="selectSTatus" class="label-style"> Search by CS#:</label>
           <input type="text" class="form-control" id="Search_CS"/>

         </div>
         <div class="btn-group mr-3">
           <button class="btn btn-primary btn-sm form-control" id="btnSearchcs">Search CS</button>
         </div>
     </div>
    </div>
</main>
<div class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
  <!-- <div class="alert alert-primary" role="alert">
    This is a primary alert—check it out!
  </div> -->
</div>
<div class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
  <div class="card text-center">
    <div class="card-header">
      <ul class="nav nav-pills card-header-pills">
        <li class="nav-item">
          <a class="nav-link" href="#" id="pobtn" style="display:none; color:#000 !important;">P.O Information</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" id="csbtn" style="display:none; color:#000 !important;">C.S Information</a>
        </li>
        <h4 id="title">Information Box</h4>
      </ul>
    </div>
    <div class="row loading" style="display:none;">
      <div class="col-md-4"></div>
      <div class="col-md-4"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
      <div class="col-md-4"></div>
    </div>
    <div class="card-body" id="po_info" style="display:none;">
      <form id="poeditform" class="needs-validation">
        <input type="hidden" name='poid' id="poid"/>
        <div class="row">
          <div class="col-sm-4"></div>
          <div class="col-sm-8">
            <h5>Accounting Status: <span style="font-weight:normal;" id="accStatus"></span> - Inventory Status: <span style="font-weight:normal;" id="invStatus"></span></h5>
          </div>
        </div>

  				<div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="ponum"> P.O Number: </label>
                  <input type="text" name="po_num" id="ponum" class="form-control" required/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="po_date"> P.O Date: </label>
                  <input type="text"  class="form-control editable_po" name="po_date" id="podate"  placeholder="MM/DD/YYYY"  style="background:white;" required/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="podealer"> P.O Dealer: </label>
                  <input type="text" name="podealer" id="podealer" class="form-control" readonly/>
                  <input type="hidden" name="dealer" id="podealer2" class="form-control" readonly/>
                </div>
              </div>
  			  </div>

          <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="model"> Model: </label>
                  <input type="text" name="pomodel2" id="pomodel2" class="form-control" readonly/>
                  <select class="form-control editable_po" name="model" id="pomodel" style="display:none;">
                    <option value="">Select Model</option>
                  </select>
                  <div class="invalid-feedback">
                    Please provide a Model.
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="model"> Model Type: </label>
                  <input type="text" class="form-control"  name="pomodeltype" id="pomodeltype" required disabled>

                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="color"> Color: </label>
                  <input type="text" name="pomodelcolor2" id="pomodelcolor2" class="form-control" readonly/>
                  <select class="form-control editable_po" name="color" id="pomodelcolor" style="display:none;">
                        <option value="">Select Color</option>
                  </select>
                  <div class="invalid-feedback">
                    Please provide a Model Color.
                  </div>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="model_yr"> Year Model: </label>
                  <select class="form-control editable_po" name="model_yr" id="pomodelyr" required><option value="">Select Year</option></select>
                    <div class="invalid-feedback">
                      Please provide a Year Model.
                    </div>
                </div>
              </div>
    			 </div>

        <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="cost">P.O. AMOUNT: </label>
                <input type="text" name="cost" id="pomodelcost" class="form-control valClick moneyClick editable_po" val="0" required/>
                <div class="invalid-feedback">
                  Please provide a cost minimum of 300,000 and maximum of 5,000,000.
                </div>
              </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                  <label for="csnum">Whole Sale Period: </label>
                  <input type="text" name="whole_sale_period" id="whole_sale_period" class="form-control editable_po" readonly/>
                  </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="remarks">Remarks: </label>
                <textarea  class="form-control editable_po"  name="remarks" id="poremarks"></textarea>
              </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-8"></div>
              <div class="col-sm-2" style="text-align: right; padding:0px !important;">
								<input type="checkbox" name="conf_order" id="exampleCheck1"  class="editable_po" style="width: 50px;" ><b>Confirmed Order</b>
							</div>
              <div class="col-sm-2" style="text-align: right; padding:0px !important;">
								<input type="checkbox" name="testDrive" id="exampleCheck1"  class="editable_po" style="width: 50px;" ><b>Test Drive / Demo Unit</b>
							</div>
				</div>
            <!-- <div class="col-sm-1" style="text-align: right;">
              <input type="checkbox" name="conf_order" id="exampleCheck1" style="width: 25px;" >

            </div>
            <div class="col-sm-3" style="padding-left: 0px !important;">
              <h5 style="line-height: 0.5;">Confirmed Order</h5>
            </div> -->
        <!-- </div> -->
        <div class="row">
          <div class="btn-group col-md-2"></div>
            <div class="btn-group col-md-4"></div>
            <div class="btn-group col-md-2" id="divVehicle">
              <button type="button" class="btn btn-primary" id="addVehicle">Add Vehicle</button>
            </div>
            <div class="btn-group col-md-2">
              <button type="button" class="btn btn-success" id="save" disabled>Save Changes</button>
            </div>
            <div class="btn-group col-md-2">
              <?php if($type == '1'){ ?>
                <button type="button" class="btn btn-danger" id="deletePO">Delete P.O</button>
              <?php } ?>
            </div>
			  </div>
      </form>
    </div>

      <div class="card-body" id="cs_info" style="display:none;">

        <!-- <div class="form-group row"> -->
        <form id="vehicleEditform" class="needs-validation">
          <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="ponum"> C.S Number: </label>
                  <input type="text" name="csnum" id="csnum" class="form-control" required/>
                  <input type="hidden" name="csnum2" id="csnum2" class="form-control"/>
                  <div class="invalid-feedback">
                    Please provide a C.S Number.
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="csnum"> P.O Number: </label>
                  <input type="text" name="ponumcs" id="ponumcs" class="form-control" readonly/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="csnum"> Location: </label>
                  <select class="form-control editable_cs" name="location" id="location" >
                    <option value="">Select Location</option>
                  </select>
                  <div class="invalid-feedback">
                    Please provide a location.
                  </div>
                </div>
              </div>
          </div>

          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="ponum"> Cost: </label>
                <input type="text" name="cost" id="cost" class="form-control money editable_cs" readonly/>
                <div class="invalid-feedback">
                  Please provide a cost minimum of 300,000 and maximum of 5,000,000.
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="csnum"> VRR Number: </label>
                <input type="text" name="vrr_num" id="refnum" class="form-control editable_cs"/>
              </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                  <label for="vrdate"> Vehicle Received Date: </label>
                  <input type="text" name="received_date"  id="vrdate" class="form-control editable_cs" placeholder="MM/DD/YYYY"  style="background:white;" autocomplete="off"/>
                </div>
            </div>
          </div>


          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="ponum"> CSR Date: </label>
                <input type="text" name="csr_date"  id="csrdate" class="form-control editable_cs"  placeholder="MM/DD/YYYY"  style="background:white;"/>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="csnum"> Paid Date: </label>
                <input type="text" name="paid_date"  id="paiddate" class="form-control editable_cs"  placeholder="MM/DD/YYYY"  style="background:white;"/>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="csnum"> Actual Release Date (IMAPS): </label>
                <input type="text" name="ardI"  id="ardI" class="form-control editable_cs"  placeholder="MM/DD/YYYY" />
              </div>
            </div>
          </div>
        <!-- </div> -->

          <div class="form-group row sls">
            <h3> Vehicle Information: </h3>
          </div>

          <!-- <div class="form-group row "> -->
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="ponum"> Model: </label>
                  <input type="hidden" name="model" id="model" class="form-control"  readonly/>
                  <input type="text" name="model1" id="model1" class="form-control"  readonly/>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="ponum"> Model Type: </label>
                    <input type="text" name="modeltype2" id="modeltype2" class="form-control"  readonly>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="csnum"> Model Color: </label>
                  <input type="text" name="color" id="color" class="form-control"  readonly/>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="csnum"> Year Model: </label>
                  <input type="text" name="model_yr" id="model_yr" class="form-control" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="ponum"> VIN Number: </label>
                  <input type="text" name="vin_num" id="vinnum" class="form-control editable_cs" />
                  </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="csnum"> Engine Number: </label>
                  <input type="text" name="eng_num"  id="engnum" class="form-control editable_cs"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="csnum"> Production Number: </label>
                  <input type="text" name="prod_num" id="prodnum" class="form-control editable_cs"/>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="ponum">Allocation Dealer: </label>
                  <!-- <input type="text editable_cs" name="alloc_dealer" id="alloc_dealer" class="form-control" /> -->
                  <select class="form-control editable_cs" name="alloc_dealer" id="alloc_dealer">
                  </select>
                  <div class="invalid-feedback">
                    Please provide a Allocation Dealer.
                  </div>
                  </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="csnum" >Allocation Date: </label>
                  <input type="text" name="alloc_date" id="alloc_date"  placeholder="MM/DD/YYYY" class="form-control editable_cs" autocomplete="off"/>
                  <div class="invalid-feedback">
                    Please provide a Allocation Date.
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="csnum">Subsidy (Outright): </label>
                  <input type="text" name="subsidy_claimed" id="sub_claimed" class="form-control editable_cs" />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="ponum">Subsidy Claiming: </label>
                  <input type="text editable_cs" name="subsidy_claiming" id="sub_claiming" class="form-control editable_cs" />
                  </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="csnum" >Plant Sales Report To: </label>
                  <select class="form-control editable_cs" name="plant_sales_report" id="plant_sales_report">
                  </select>
                  <div class="invalid-feedback">
                    Please provide a Plant Sales Report To.
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="csnum">Plant Sales Month: </label>
                  <input type="text" class="form-control editable_cs montyr" name="plant_sales_month" id="plant_sales_month"  placeholder="MM-YYYY" autocomplete="off"/>
                  <div class="invalid-feedback">
                    Please provide a Plant Sales Month.
                  </div>
                </div>
              </div>
            </div>
          <!-- </div> -->
        </form>
        <div class="form-group row sls">
          <h3> Sales Information: </h3>
        </div>

        <!-- <div class="form-group row "> -->

          <div class="row">
            <table class="table">
              <tr>
                <td class="text-right" style="width:20%;" scope="col"><label>Name:</label></td>
                <td class="text-left" style="width:30%;" scope="col"><span id="Name"></span></td>
                <td class="text-right" style="width:20%;" scope="col"><label>Company Name:</label></td>
                <td class="text-left" style="width:30%;" scope="col"> <span id="com"></span></td>
              </tr>
              <tr>
                <td class="text-right" scope="col"><label>Invoice Number:</label></td>
                <td class="text-left" scope="col"><span id="inv_num"></span></td>
                <td class="text-right" scope="col"><label>Invoice Amount:</label></td>
                <td class="text-left" scope="col"><span id="inv_amt" class="money"></span></td>
              </tr>
              <tr>
                <td class="text-right" scope="col"><label>Invoice Date:</label></td>
                <td class="text-left" scope="col"><span id="inv_date"></span></td>
                <td class="text-right" scope="col"><label>Sales Person:</label></td>
                <td class="text-left" scope="col"><span id="salesperson"></span></td>
              </tr>
              <tr>
                <td class="text-right" scope="col"><label>Pay Mode:</label></td>
                <td class="text-left" scope="col"><span id="pay_mode"></span></td>
                <td class="text-right" scope="col"><label>Bank:</label></td>
                <td class="text-left" scope="col"><span id="bank"></span></td>
              </tr>
              <tr>
                <td class="text-right" scope="col"><label>(Lica) Sales Report To:</label></td>
                <td class="text-left" scope="col"><span id="srt"></span></td>
                <td class="text-right" scope="col"><label>Actual Released Date:</label></td>
                <td class="text-left" scope="col"><span id="ard"></span></td>
              </tr>
            </table>
          </div>

          <div class="row">
            <div class="col-sm-8">
            </div>
            <div class="col-sm-2">
              <button type="button" class="btn btn-success" id="SaveVehicle" disabled>Save Changes</button>
            </div>
            <div class="col-sm-2">
              <?php if($type == '1'){ ?>
                <button type="button" class="btn btn-danger" id="deleteVehicle">Delete C.S</button>
              <?php } ?>
            </div>
          </div>
        <!-- </div> -->

      </div>
  </div>
  <div id="res" style="text-align:center;">
    <!-- <div style="text-align:center; margin-top:20%">
      <div class="spinner-grow test1 text-muted"><h1>I</h1></div>
      <div class="spinner-grow test2 text-primary"><h1>M</h1></div>
      <div class="spinner-grow test3 text-success"><h1>A</h1></div>
      <div class="spinner-grow test4 text-info"><h1>P</h1></div>
      <div class="spinner-grow test5 text-warning"><h1>S</h1></div>
    </div> -->


  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
        var bUrl="<?php echo base_url(); ?>";
        var select=$('select').select2();
        $('#pomodel, #pomodelcolor').select2('destroy');

        if($("#podate").val() == '' || $("#vrdate").val() == '')
        {
          $("#ardI").prop('disabled',true);
        }else{
          $("#ardI").prop('disabled',false);
        }


        //refersh function
        function refresh() {
          var po_num=$("#Search_PO").val();
          var cs_num=$("#Search_CS").val();
          $.ajax({
            url: bUrl+"Dashboard/searchPO?po_num="+po_num+"&cs_num="+cs_num,
            type:"GET",
            dataType:"JSON",
            beforeSend: function() {
                $(".loading").show();
            },
            success:function(data)
            {
                setTimeout(function(){

                  $(".loading").hide();
                  var ponum='';
                  var po='';
                  var model='';
                  var model_yr='';
                  var color='';
                  var dealer='';
                  $("#accStatus").text("No Vehicle");
                  $("#invStatus").text("No Vehicle");
                  $.each(data.status, function(i, value){
                    if(data.status[i].acc_status == 'No Vehicle' && data.status[i].inv_status == 'No Vehicle')
                    {
                      $("#accStatus").text("No Vehicle");
                      $("#invStatus").text("No Vehicle");
                    }else{
                      $("#accStatus").text("");
                      $("#accStatus").text(data.status[i].acc_status);
                      $("#invStatus").text("");
                      $("#invStatus").text(data.status[i].inv_status);
                    }
                  });
                  var acStatus= $("#accStatus").val();
                  if(acStatus == 'reported')
                  {
                    $("#poid").attr('disabled',true);
                    $("#ponum").attr('disabled',true);
                    $("#podate").attr('disabled',true);
                    $("#podealer").attr('disabled',true);
                    $("#podealer2").attr('disabled',true)
                    $("#pomodeltype").attr('disabled',true);
                    $("#pomodelyr").attr('disabled',true);
                    $("#pomodelcolor").attr('disabled',true);
                    $("#pomodelcost").attr('disabled',true);
                    $("#poremarks").attr('disabled',true);
                    $("#csnum").attr('disabled',true);
                    $("#ponumcs").attr('disabled',true);
                    $("#paiddate").attr('disabled',true);
                    $("#cost").attr('disabled',true);
                    $("#refnum").attr('disabled',true);
                    $("#vrdate").attr('disabled',true);
                    $("#csrdate").attr('disabled',true);
                    $("#vinnum").attr('disabled',true)
                    $("#engnum").attr('disabled',true);
                    $("#prodnum").attr('disabled',true);
                    $("#modeltype2").attr('disabled',true);
                    $("#alloc_date").attr('disabled',true);
                    $("#ardI").attr('disabled',true);
                    $("#sub_claimed").attr('disabled',true);
                    $("#sub_claiming").attr('disabled',true);
                    $("#plant_sales_report").attr('disabled',true);
                    $("#plant_sales_month").attr('disabled',true);
                  }
                  if(data.podetails.length > 0)
                  {

                    $("#title").fadeOut();
                    $.each(data.podetails, function( i, value ) {
                      po_num = data.podetails[i].po_num;
                      po = data.podetails[i].dealer;
                      model = data.podetails[i].model;
                      model_yr = data.podetails[i].model_yr;
                      color = data.podetails[i].color;
                      dealer= data.podetails[i].Company;
                      if(data.podetails[i].po_date == '0000-00-00' || data.podetails[i].po_date === null)
                      {
                        po_date=null;
                      }else{
                        po_date= $.datepicker.formatDate('MM dd, yy', new Date(data.podetails[i].po_date));
                        wsp= $.datepicker.formatDate('mm-yy', new Date(data.podetails[i].po_date));
                      }
                      if(data.podetails[i].conf_order == 1)
                      {
                        $("input[name='conf_order']").prop('checked',true);
                        $("#poremarks").attr('required',true);
                      }else{
                        $("input[name='conf_order']").prop('checked',false);
                        $("#poremarks").removeAttr('required');
                      }
                      if(data.podetails[i].testDrive == 1)
                      {
                        $("input[name='testDrive']").prop('checked',true);
                      }else{
                        $("input[name='testDrive']").prop('checked',false);
                      }

                      $("#poid").val(data.podetails[i].ids);
                      $("#ponum").val(data.podetails[i].po_num);
                      $("#podate").val(po_date);
                      $("#podealer").val(data.podetails[i].Company+' '+data.podetails[i].Branch);
                      $("#podealer2").val(data.podetails[i].dealer);
                      $("#pomodeltype").val(data.podetails[i].model_series);
                      $("#pomodelyr").val(data.podetails[i].model_yr);
                      $("#model_yr").val(data.podetails[i].model_yr);
                      $("#pomodelcolor").val(data.podetails[i].color);
                      $("#pomodelcolor2").val(data.podetails[i].color);
                      $("#pomodelcost").val(parseFloat(data.podetails[i].cost).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
                      $("#poremarks").val(data.podetails[i].remarks);
                      $("#whole_sale_period").val(wsp);
                      $("#conf_order").val();
                    });
                    // console.log(data);
                    // $.each(data.status, function(i, value){
                    //   $("#accStatus").text(data.status[i].acc_status);
                    //   $("#invStatus").text(data.status[i].inv_status);
                    // });
                    //model
                    $.ajax({
                        url: bUrl+"Dashboard/Model2?dealer="+dealer,
                            type: "GET",
                            dataType: "JSON",
                            success: function (data) {
                              console.log(data);
                              console.log(po);
                             var tmp='';
                             var series='';
                             tmp+='<option value="">Select Model</option>';
                              $.each(data, function( index, value ) {
                                if(model == value.id)
                                {
                                  tmp +="<option value='"+value.id+"' selected>"+value.Product+"</option>";
                                  $('#model1').val(value.Product);
                                  $('#model').val(value.id);
                                  $('#pomodel2').val(value.Product);
                                }else{
                                  tmp +="<option value='"+value.id+"'>"+value.Product+"</option>";
                                }
                              });
                        $('#pomodel').html(tmp);

                            },
                            error: function() {
                                console.log('error');
                            }
                      });
                    //model

                    // model_yr
                    for (i = new Date().getFullYear()+4; i >= 1990; i--)
                    {
                      if(model_yr == i)
                      {
                        $('#pomodelyr').append($('<option selected />').val(i).html(i));
                      }else{
                        $('#pomodelyr').append($('<option />').val(i).html(i));
                      }

                    }
                    // modelyr

                    // model color
                    $.ajax({
                      url: bUrl+"Dashboard/model_color?model_id="+model,
                          type: "GET",
                          dataType: "JSON",
                          success: function (data) {
                            // console.log(data);
                           var tmps='';
                           tmps+='<option value="" >Select Color</option>';
                           tmps+="<option value='"+color+"' selected>"+color+"</option>";
                           $('#color').val(color);
                            $.each(data, function( index, value ) {
                              if(color == value.color)
                              {
                                // tmps+="<option value='"+value.color+"' selected>"+value.color+"</option>";

                              }else{
                                tmps+="<option value='"+value.color+"'>"+value.color+"</option>";
                              }

                            });
                      $('#pomodelcolor').html(tmps);

                      // $('#Color').prop('disabled',false);
                          },
                          error: function() {
                              console.log('error');
                          }
                    });
                    // model color
                    if(data.csdetails.length > 0)
                    {
                      $('#divVehicle').fadeOut();
                      $('#csbtn').fadeIn();
                      $('#pobtn').fadeIn();
                    }else{
                      $('#divVehicle').fadeIn();
                      $('#csbtn').fadeOut();
                      $('#pobtn').fadeIn();
                    }

                    $("#cs_info").fadeOut();
                    $("#po_info").fadeIn();
                  }

                  if(data.csdetails.length > 0)
                  {
                    var location='';
                    var model2='';
                    var modelyr2='';
                    var color2='';
                    var csnum2='';
                    var alloc_dealer='';
                    var alloc='';

                    $("#Name").text("");
                    $("#comp").text("");
                    $("#inv_num").text("");
                    $("#inv_amt").text("");
                    $("#inv_date").text("");
                    $("#pay_mode").text("");
                    $("#srt").text("");
                    $("#bank").text("");
                    $("#eng").text("");
                    $("#prod").text("");
                    $("#ard").text("");
                    $("#salesperson").text("");


                    // var dealer=$('#podealer').val();
                    // console.log(data.csdetails);
                    $.each(data.csdetails, function( i, value ) {
                      location=data.csdetails[i].location;
                      console.log(location);
                      model2=data.csdetails[i].model;
                      modelyr2=data.csdetails[i].model_yr;
                      color2=data.csdetails[i].color;
                      alloc_dealer=data.csdetails[i].alloc_dealer;
                      psr=data.csdetails[i].plant_sales_report;

                      if(alloc_dealer === undefined)
                      {
                        alloc='';
                      }else if(alloc_dealer === null){
                        alloc='';
                      }else if(alloc_dealer === ''){
                        alloc='';
                      }else{
                        alloc=alloc_dealer;
                      }
                      console.log(alloc);
                      if(data.csdetails[i].paid_date == '0000-00-00' || data.csdetails[i].paid_date === null)
                      {
                        paiddate=null;
                      }else{
                        paiddate= $.datepicker.formatDate('MM dd, yy', new Date(data.csdetails[i].paid_date));
                      }

                      if(data.csdetails[i].veh_received == '0000-00-00' || data.csdetails[i].veh_received === null)
                      {
                        vrdate=null;
                      }else{
                        vrdate= $.datepicker.formatDate('MM dd, yy', new Date(data.csdetails[i].veh_received));
                      }

                      if(data.csdetails[i].csr_received == '0000-00-00' || data.csdetails[i].csr_received === null)
                      {
                        csrdate=null;
                      }else{
                        csrdate= $.datepicker.formatDate('MM dd, yy', new Date(data.csdetails[i].csr_received));
                      }

                      if(data.csdetails[i].alloc_date == '0000-00-00' || data.csdetails[i].alloc_date === null)
                      {
                        alloc_date=null;
                      }else{
                        alloc_date= $.datepicker.formatDate('MM dd, yy', new Date(data.csdetails[i].alloc_date));
                      }

                      if(data.csdetails[i].imaps_actual_release_date == '0000-00-00' || data.csdetails[i].imaps_actual_release_date === null)
                      {
                        ardI=null;
                      }else{
                        ardI= $.datepicker.formatDate('MM dd, yy', new Date(data.csdetails[i].imaps_actual_release_date));
                      }

                      if(data.csdetails[i].plant_sales_month== '0000-00-00' || data.csdetails[i].plant_sales_month === null)
                      {
                        psm=null;
                      }else{
                        psm= $.datepicker.formatDate('mm-yy', new Date(data.csdetails[i].plant_sales_month));
                      }


                      $("#csnum").val(data.csdetails[i].cs_num);
                      $("#csnum2").val(data.csdetails[i].cs_num);
                       csnum2=data.csdetails[i].cs_num;
                      $("#ponumcs").val(po_num);
                      $("#paiddate").val(paiddate);
                      $("#cost").val(parseFloat(data.podetails[i].cost).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
                      $("#ard").text(data.csdetails[i].gp_released_date);
                      $("#srt").text(data.csdetails[i].dealership);
                      $("#refnum").val(data.csdetails[i].vrr_num);
                      // console.log(vrdate);
                      $("#vrdate").val(vrdate);
                      if(vrdate != '')
                      {
                        $("#ardI").prop('disabled',false);
                      }else{
                        $("#ardI").prop('disabled',true);
                      }
                      $("#csrdate").val(csrdate);
                      $("#vinnum").val(data.csdetails[i].vin_num);
                      $("#engnum").val(data.csdetails[i].engine_num);
                      $("#prodnum").val(data.csdetails[i].prod_num);
                      $("#modeltype2").val(data.csdetails[i].model_series);
                      $("#alloc_date").val(alloc_date);
                      $("#ardI").val(ardI);
                      $("#sub_claimed").val(data.csdetails[i].subsidy_claimed);
                      $("#sub_claiming").val(data.csdetails[i].subsidy_claiming);
                      $("#plant_sales_month").val(psm);
                    });
                    // Location
                           console.log(location);
                      $.ajax({
                          url: bUrl+"Dashboard/location",
                              type: "GET",
                              dataType: "JSON",
                              success: function (data) {
                               var tmp='';

                               tmp+='<option value="">Select Location</option>';
                                $.each(data, function( index, value ) {
                                  if(location == value.Company)
                                  {
                                    tmp +="<option value='"+value.Company+"' selected>"+value.Company+"</option>";
                                  }else{
                                    tmp +="<option value='"+value.Company+"'>"+value.Company+"</option>";
                                  }

                                });
                          $('#location').html(tmp);
                              },
                              error: function() {
                                  console.log('error');
                              }
                        });
                    // Location



                    $.each(data.ardetails,function(i, value){

                      var lname=data.ardetails[i].last_name;
                      if(data.ardetails[i].last_name == null)
                      {
                        lname='';
                      }
                      var fname=data.ardetails[i].first_name;
                      if(data.ardetails[i].first_name == null)
                      {
                        fname='';
                      }
                      var mname=data.ardetails[i].middle_name;
                      if(data.ardetails[i].middle_name == null)
                      {
                        mname='';
                      }
                      $("#Name").text(lname+","+fname+" "+mname);
                      $("#com").text(data.ardetails[i].company_name);
                      $("#inv_num").text(data.ardetails[i].invoice_number);
                      $("#inv_amt").text(data.ardetails[i].invoice_amount);
                      $("#pay_mode").text(data.ardetails[i].payment_mode);
                      $("#bank").text(data.ardetails[i].bank);
                      inv_date= $.datepicker.formatDate('MM dd, yy', new Date(data.ardetails[i].invoice_date));
                      $("#inv_date").text(inv_date);
                      if(data.ardetails[i].released_date == '0000-00-00' || data.ardetails[i].released_date === null)
                      {
                        var ard=null;
                      }else{
                        var ard= $.datepicker.formatDate('MM dd, yy', new Date(data.ardetails[i].released_date));
                      }

                      $("#ard").text(ard);
                      // var eng = data.ardetails[i].engine_number;
                      // if(eng != null  && eng.length > 0)
                      // {
                      //   // $("#engnum").val("");
                      //   $("#engnum").val(eng);
                      //   $("#engnum").attr("disabled","disabled");
                      // }
                      // var prod = data.ardetails[i].chasis_number;
                      // if(prod != null  && prod.length > 0)
                      // {
                      //   // $("#prodnum").val("");
                      //   $("#prodnum").val(prod);
                      //   $("#prodnum").attr("disabled","disabled");
                      // }
                      $("#srt").text(data.ardetails[i].dealership);
                    });

                    if(data.ardetails.length > 0)
                    {
                      // console.log(data.gpdetails);
                      $.each(data.gpdetails,function(i, value){
                              var company = data.gpdetails[i].brand;
                              var branch = data.gpdetails[i].branch;
                              var scid = data.gpdetails[i].sc;
                              var sp = data.gpdetails[i].sales_period;
                              var px=window.btoa("0nlyM3@p1");
                              $.ajax({
                                url: 'https://dsar.licagroup.ph/Api/getScID',
                                type: "GET",
                                dataType:"JSON",
                                crossOrigin: false,
                                headers: {
                                  'client-service':'gp-client',
                                  'auth-key':'gp-auth',
                                  'Content-Type':'application/json'
                                },
                                data:"id="+scid+"&px="+px,
                                beforeSend: function () {
                                  // $("#res").html('Loading data...');
                                },
                                success: function (p) {

                                  if(p)
                                  {
                                    var sname=p.Lname+", "+p.Fname+" "+p.Mname;
                                    $("#salesperson").text(sname.toUpperCase());
                                  }else{

                                  }

                                },
                                fail: function(r) {
                                }
                              });
                                if(sp == null)
                                {

                                }else{
                                  var inv_date='';
                                  if(data.gpdetails[i].invoice_date == '0000-00-00' || data.gpdetails[i].invoice_date === null)
                                  {
                                    var inv_date=null;
                                  }else{
                                    var inv_date=$.datepicker.formatDate('MM dd, yy', new Date(data.gpdetails[i].invoice_date));
                                  }
                                  if(inv_date != null &&  inv_date.length > 0)
                                  {
                                    $("#inv_date").text("");
                                    $("#inv_date").text(inv_date);
                                  }else if(inv_date == null)
                                  {
                                    $("#inv_date").text("");
                                  }
                                  var Name=data.gpdetails[i].last_name+","+data.gpdetails[i].first_name+" "+data.gpdetails[i].middle_name;
                                  if(data.gpdetails[i].last_name != null &&  Name.length > 0)
                                  {
                                    Name.replace('null', '');
                                    $("#Name").text("");
                                    $("#Name").text(Name);
                                  }
                                  var comp=data.gpdetails[i].company_name;
                                  if(comp != null && comp.length > 0)
                                  {
                                    $("#comp").text("");
                                    $("#com").text(comp);
                                  }
                                  var inv_num=data.gpdetails[i].invoice_number;
                                  if(inv_num != null && inv_num.length > 0)
                                  {
                                    $("#inv_num").text("");
                                    $("#inv_num").text(inv_num);
                                  }
                                  var inv_amt=data.gpdetails[i].invoice_amount;
                                  if(inv_amt != null &&  inv_amt.length > 0)
                                  {
                                    $("#inv_amt").text("");
                                    $("#inv_amt").text(inv_amt);
                                  }
                                  var inv_date=$.datepicker.formatDate('MM dd, yy', new Date(data.gpdetails[i].invoice_date));
                                  if(inv_date != null &&  inv_date.length > 0)
                                  {
                                    $("#inv_date").text("");
                                    $("#inv_date").text(inv_date);
                                  }
                                  var pay_mode=data.gpdetails[i].payment_mode;
                                  if(pay_mode != null && pay_mode.length > 0)
                                  {
                                    $("#pay_mode").text("");
                                    $("#pay_mode").text(pay_mode);
                                  }
                                  var srt=data.gpdetails[i].dealership;
                                  if(srt != null && srt.length > 0)
                                  {
                                    $("#srt").text("");
                                    $("#srt").text(srt);
                                  }
                                  var bank=data.gpdetails[i].bank;
                                  if(bank != null && bank.length > 0)
                                  {
                                    $("#bank").text("");
                                    $("#bank").text(bank);
                                  }
                                }


                      });
                    }else{

                      $.each(data.gpdetails,function(i, value){
                              var company = data.gpdetails[i].brand;
                              var branch = data.gpdetails[i].branch;
                              var scid = data.gpdetails[i].sc;
                              var sp = data.gpdetails[i].sales_period;
                              var px=window.btoa("0nlyM3@p1");
                              console.log(scid);
                              if(sp != null && sp != '0000-00-00')
                              {
                                $.ajax({
                                  url: 'https://dsar.licagroup.ph/Api/getScID',
                                  type: "GET",
                                  dataType:"JSON",
                                  crossOrigin: false,
                                  headers: {
                                    'client-service':'gp-client',
                                    'auth-key':'gp-auth',
                                    'Content-Type':'application/json'
                                  },
                                  data:"id="+scid+"&px="+px,
                                  beforeSend: function () {
                                    // $("#res").html('Loading data...');
                                  },
                                  success: function (p) {

                                    if(p)
                                    {
                                      var sname=p.Lname+", "+p.Fname+" "+p.Mname;
                                      $("#salesperson").text(sname.toUpperCase());
                                    }else{

                                    }

                                  },
                                  fail: function(r) {
                                  }
                                });
                                  if(sp == null)
                                  {
                                    if(data.gpdetails[i].invoice_date == '0000-00-00' || data.gpdetails[i].invoice_date === null)
                                    {
                                      var inv_date=null;
                                    }else{
                                      var inv_date=$.datepicker.formatDate('MM dd, yy', new Date(data.gpdetails[i].invoice_date));
                                    }

                                    if(inv_date != null &&  inv_date.length > 0)
                                    {
                                      $("#inv_date").text("");
                                      $("#inv_date").text(inv_date);
                                    }else if(inv_date == null)
                                    {
                                      $("#inv_date").text("");
                                    }
                                  }else{
                                    var Name=data.gpdetails[i].last_name+","+data.gpdetails[i].first_name+" "+data.gpdetails[i].middle_name;
                                    if(data.gpdetails[i].last_name != null &&  Name.length > 0)
                                    {
                                      Name.replace('null', '');
                                      $("#Name").text("");
                                      $("#Name").text(Name);
                                    }
                                    var comp=data.gpdetails[i].company_name;
                                    if(comp != null && comp.length > 0)
                                    {
                                      $("#comp").text("");
                                      $("#com").text(comp);
                                    }
                                    var inv_num=data.gpdetails[i].invoice_number;
                                    if(inv_num != null && inv_num.length > 0)
                                    {
                                      $("#inv_num").text("");
                                      $("#inv_num").text(inv_num);
                                    }
                                    var inv_amt=data.gpdetails[i].invoice_amount;
                                    if(inv_amt != null &&  inv_amt.length > 0)
                                    {
                                      $("#inv_amt").text("");
                                      $("#inv_amt").text(inv_amt);
                                    }
                                    var inv_date=$.datepicker.formatDate('MM dd, yy', new Date(data.gpdetails[i].invoice_date));
                                    if(inv_date != null &&  inv_date.length > 0)
                                    {
                                      $("#inv_date").text("");
                                      $("#inv_date").text(inv_date);
                                    }
                                    var pay_mode=data.gpdetails[i].payment_mode;
                                    if(pay_mode != null && pay_mode.length > 0)
                                    {
                                      $("#pay_mode").text("");
                                      $("#pay_mode").text(pay_mode);
                                    }
                                    var srt=data.gpdetails[i].dealership;
                                    if(srt != null && srt.length > 0)
                                    {
                                      $("#srt").text("");
                                      $("#srt").text(srt);
                                    }
                                    var bank=data.gpdetails[i].bank;
                                    if(bank != null && bank.length > 0)
                                    {
                                      $("#bank").text("");
                                      $("#bank").text(bank);
                                    }
                                    // var eng = data.gpdetails[i].engine_number;
                                    // if(eng != null && eng.length > 0)
                                    // {
                                    //   $("#eng").text("");
                                    //   $("#eng").text(eng);
                                    // }
                                    // var prod = data.gpdetails[i].chasis_number;
                                    // if(prod != null && prod.length > 0)
                                    // {
                                    //   $("#prod").text("");
                                    //   $("#prod").text(prod);
                                    // }
                                    // console.log(data.gpdetails[i].released_date);
                                    // var ard = $.datepicker.formatDate('MM dd, yy', new Date(data.gpdetails[i].released_date));
                                    // if(ard != null && ard.length > 0)
                                    // {
                                    //   $("#ard").text("");
                                    //   $("#ard").text(ard);
                                    // }
                                  }
                              }



                      });

                    }
                    //alloc_dealer
                    $.ajax({
                        url: bUrl+"Dashboard/alloc_dealer",
                            type: "GET",
                            dataType: "JSON",
                            success: function (data) {
                             var tmp='';
                               // console.log('gg');
                             tmp+='<option value="">Select Allocation Dealer</option>';
                              $.each(data, function( index, value ) {
                                // console.log(data);

                                // console.log(alloc[1]);
                                // console.log(value);
                                if(alloc == value.Company)
                                {
                                  tmp +="<option value='"+value.Company+"' selected>"+value.Company+"</option>";
                                }else{
                                  tmp +="<option value='"+value.Company+"'>"+value.Company+"</option>";
                                }
                              });
                        $('#alloc_dealer').html(tmp);
                            },
                            error: function() {
                                console.log('aw');
                            }
                      });
                    //alloc_dealer

                    $.ajax({
                        url: bUrl+"Dashboard/alloc_dealer",
                            type: "GET",
                            dataType: "JSON",
                            success: function (data) {
                             var tmp='';
                               // console.log('gg');
                             tmp+='<option value="">Select Plant Sales Report To</option>';
                              $.each(data, function( index, value ) {
                                // console.log(data);

                                // console.log(alloc[1]);
                                // console.log(value);
                                if(psr == value.Company)
                                {
                                  tmp +="<option value='"+value.Company+"' selected>"+value.Company+"</option>";
                                }else{
                                  tmp +="<option value='"+value.Company+"'>"+value.Company+"</option>";
                                }
                              });
                        $('#plant_sales_report').html(tmp);
                            },
                            error: function() {
                                console.log('aw');
                            }
                      });


                  }

              },2000);
            },
            error:function(){
                $(".loading").hide();
                if(po_num.length > 0)
                {
                  $.alert({
                    type:'green',
                    columnClass:"col-sm-6 col-sm-offset-4",
                    title:'Error Message',
                    content:'Your P.O. Number Not Exist',
                  });
                }else if(cs_num.length > 0)
                {
                  $.alert({
                    type:'green',
                    columnClass:"col-sm-6 col-sm-offset-4",
                    title:'Error Message: ',
                    content:'Your C.S. Number Not Exist',
                  });
                }else{
                  $.alert({
                    type:'red',
                    columnClass:"col-sm-6 col-sm-offset-4",
                    title:'Error Message',
                    content:'Invalid Search! Please fill up the search box.',
                  });
                }
            }
        });
        }
        //refersh function

        $('.moneyClick').mask("#,##0.00", {
        reverse: true,
        completed: function (v) {
          var numbers = v.val().replace(/,/g,'');
        }
      });
      $(".valClick").on('blur focusout',function() {
        var v = $(this).val();
        if(v == ""){
          $(this).val('0.00');
        }
      });
      $(".valClick").on('click',function() {
        var v = parseInt($(this).val());
        if(v == 0){
          $(this).val('');
        }
      });

        $('#exampleCheck1').change(function() {
           if(this.checked) {
                $('#poremarks').attr('required',true);
           }else{
                $('#poremarks').removeAttr('required');
           }
       });

        // main function
        $('.montyr').datepicker({
  		    	format: "mm-yyyy",
  			    viewMode: "months",
  			    minViewMode: "months",
  			    autoclose: true
  			});
        $("#btnSearchpo").on('click',function(){
          $("#Search_CS").val("");
          $("#po_info").fadeOut();
          $("#pobtn").addClass( "active" );
          $("#csbtn").removeClass( "active" );
          refresh();
        });
        $('#ponum').on('change',function(){
  	    		var ponum=$(this).val();
  				$.ajax({
  					url: bUrl+"Inventory/check_po_num?ponum="+ponum,
  					type:"GET",
  					dataType:"JSON",
  					success:function(data)
  					{
  						console.log(data);
  						if(data > 0)
  						{
  							 $.alert({
  							 	type:'red',
  	                            columnClass:"col-sm-6 col-sm-offset-4",
  	                            title: '<h3 style="color:red;">Error</h3>',
  	                             content: '<h5 style="color:red;">Invalid Purchase Order number.Your Purchase Order number is already exist, Thank you.</h5>',
  							 });
  							 $('#ponum').val("");

  						}else{
                $("#save").attr('disabled',false);
              }
  					},
  					error:function(){
  						console.log('error');
  					}
  				});
  			});
        $('#csnum').on('change',function(){
	    		var csnum=$(this).val();
					$.ajax({
						url: bUrl+"Inventory/check_cs_num?csnum="+csnum,
						type:"GET",
						dataType:"JSON",
						success:function(data)
						{
							console.log(data);
							if(data > 0)
							{
								 $.alert({
								 	type:'red',
		                            columnClass:"col-sm-6 col-sm-offset-4",
		                            title: '<h3 style="color:red;">Error</h3>',
		                            content: '<h5 style="color:red;">Invalid CS number.Your CS number is already exist, Thank you.</h5>',
								 });
								 $('#csnum').val("");

								 return false;
							}else{
                $("#SaveVehicle").attr('disabled',false);
              }
						},
						error:function(){
							console.log('error');
						}
					});
				});

        $("#btnSearchcs").on('click',function(){
          $("#Search_PO").val("");
          $("#po_info").fadeOut();
          $("#pobtn").addClass( "active" );
          $("#csbtn").removeClass( "active" );
          refresh();
        });

        $("#pobtn").on('click',function(){
           $("#po_info").fadeIn();
           $("#cs_info").fadeOut();
           $("#csbtn").removeClass( "active" );
           $("#pobtn").addClass( "active" );
        });

        $("#csbtn").on('click',function(){
           $("#cs_info").fadeIn();
           $("#po_info").fadeOut();
           $("#pobtn").removeClass( "active" );
           $("#csbtn").addClass( "active" );

        });


        var intVal = function ( i ) {
     return typeof i === 'string' ?
       i.replace(/[\₱,]/g, '')*1 :
     typeof i === 'number' ?
       i : 0;
    };
        $("#save").on('click',function(){
           var ar=$('#poeditform').serialize();
           var pocost=intVal($("#pomodelcost").val());
           if(parseInt(pocost) < parseInt('300000'))
           {
               $("#pomodelcost").val("");
               $('#poeditform').addClass('was-validated');

               return false;
           }
           if(parseInt(pocost) > parseInt('5000000'))
           {
               $("#pomodelcost").val("");
               $('#poeditform').addClass('was-validated');

               return false;
           }

           if($('#poeditform')[0].checkValidity() === false)
           {
               $('#poeditform').addClass('was-validated');

               return false;
           }
           var action="Inventory/editPO";
           $("#po_info").fadeOut();
           $.ajax({
                url:bUrl+action,
                type:"POST",
                data:ar,
              }).done(function(wmsg){
                jQuery.notify({
                  message: 'Submit Successfuly!'
                  },{
                   placement: {
                      from: "bottom",
                      align: "left"
                  },
                    type: 'success'
                  });
                    location.reload();
                    // refresh();
                }).fail(function(){
                  self.setContent('Form Error. Please Try Again Later.');
                });


        });
        $("#deletePO").on('click',function(){
          var val=$("#poid").val();
          var action="Inventory/deletePo?id="+val;
          $.ajax({
                url:bUrl+action,
                type:"POST",
                beforeSend:function(){
                   return confirm("Are you sure you want to delete this PO?");
                },
                success: function (wmsg) {
                  self.close();
                  // console.log(wmsg);
                  if(wmsg > 0)
                  {
                    jQuery.notify({
                        // options
                        message: 'Error Please Submit New Form!'
                    },{
                        // settings
                        placement: {
                          from: "bottom",
                          align: "left"
                        },
                      type: 'Danger'
                    });
                  }else{
                    jQuery.notify({
                      // options
                      message: 'Delete Successfuly!'
                    },{
                      // settings
                      placement: {
                        from: "bottom",
                        align: "left"
                    },
                    type: 'success'
                  });
                 }
                 location.reload();
                 // refresh();
                },
                error: function (xhr) {
                    self.setContent('Form Error. Please Try Again Later.');
                }
          });


        });
        $("#deleteVehicle").on('click',function(){
          var val=$("#csnum").val();
          var ponumd=$("#ponumcs").val();
          var action="Inventory/deleteCS?id="+val+"&ponum="+ponumd;
          $.ajax({
                url:bUrl+action,
                type:"POST",
                beforeSend:function(){
                   return confirm("Are you sure you want to delete this CS?");
                },
                success: function (wmsg) {
                  self.close();
                  // console.log(wmsg);
                  if(wmsg > 0)
                  {
                    jQuery.notify({
                        // options
                        message: 'Error Please Submit New Form!'
                    },{
                        // settings
                        placement: {
                          from: "bottom",
                          align: "left"
                        },
                      type: 'Danger'
                    });
                  }else{
                    jQuery.notify({
                      // options
                      message: 'Delete Successfuly!'
                    },{
                      // settings
                      placement: {
                        from: "bottom",
                        align: "left"
                    },
                    type: 'success'
                  });
                 }
                 location.reload();
                 // refresh();
                },
                error: function (xhr) {
                    self.setContent('Form Error. Please Try Again Later.');
                }
          });
        });
        $("#addVehicle").on('click',function(){
          var ponum=$("#ponum").val();
          $.alert({
                type:'green',
                columnClass:"col-sm-8 col-sm-offset-2",
                title:'Add Vehicle For P.O.',
                content:'url:'+bUrl+'Dashboard/addVehiclePO?po_num='+ponum,
                buttons:
                {
                  confirm:
                  {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function(){
                      var main=this;
                      var ar=$('#vechile_form2').serialize();
                      var action="Inventory/addVehicle2";
                      var currentTime = new Date();
                      if($('#vechile_form2')[0].checkValidity() === false)
                      {
                        $('#vechile_form2').addClass('was-validated');

                        return false;
                      }
                      $.alert({
                        title:"",
                        type:"green",
                        content:function(){
                          var self=this;
                            return $.ajax({
                                url:bUrl+action,
                                type:"POST",
                                data:ar,
                                }).done(function(wmsg){
                                  self.close();
                                  // console.log(wmsg);
                                  if(wmsg > 0)
                                  {
                                      self.close();
                                      jQuery.notify({
                                            message: 'Error Please Submit New Form!'
                                      },{
                                          placement: {
                                            from: "bottom",
                                            align: "left"
                                          },
                                          type: 'Danger'
                                      });
                                  }else{
                                      self.close();
                                      jQuery.notify({
                                        message: 'Submit Successfuly!'
                                      },{
                                          placement: {
                                            from: "bottom",
                                            align: "left"
                                          },
                                          type: 'success'
                                    });
                                    location.reload();
                                    // refresh();
                                  }
                                }).fail(function(){
                                    self.setContent('Form Error. Please Try Again Later.');
                                });
                            }
                          });
                          },
                        },
                        close:
                        {
                            text:'Close',
                            btnClass:'btn-red'
                          }
                        }
              });
        });
        $("#SaveVehicle").on('click',function(){
          var ar=$("#vehicleEditform").serialize();
          var action="Inventory/editCS";
          if($('#vehicleEditform')[0].checkValidity() === false)
          {
              $('#vehicleEditform').addClass('was-validated');

              return false;
          }
          $("#po_info").fadeOut();
          $("#cs_info").fadeOut();
          $("#csbtn").removeClass( "active" );
          $("#pobtn").addClass( "active" );
          $.ajax({
               url:bUrl+action,
               type:"POST",
               data:ar,
             }).done(function(wmsg){
               jQuery.notify({
                 message: 'Submit Successfuly!'
                 },{
                  placement: {
                     from: "bottom",
                     align: "left"
                 },
                   type: 'success'
                 });
               }).fail(function(){
                 self.setContent('Form Error. Please Try Again Later.');
               });
               // setTimeout(function() {  }, 3000);
              location.reload();
              // refresh();
        });

        $(".editable_cs").on('change',function(){
          var plant_sales_month = $("#plant_sales_month").val();
          var plant_sales_report = $("#plant_sales_report").val();
          var alloc_dealer = $("#alloc_date").val();
          var alloc_date = $("#alloc_date").val();

          if(plant_sales_month == '' && plant_sales_report == ''){
            $("#SaveVehicle").removeAttr('disabled');
            $("#plant_sales_report").removeAttr('required');
            $("#plant_sales_month").removeAttr('required');
          }else if(plant_sales_month !='' && plant_sales_report == ''){
            $("#plant_sales_month").attr('required',true);
            $("#plant_sales_report").attr('required',true);
            $("#SaveVehicle").attr('disabled',true);
          }else if(plant_sales_report == '' && plant_sales_month == '0000-00-00'){
            $("#plant_sales_month").attr('required',true);
            $("#plant_sales_report").attr('required',true);
            $("#SaveVehicle").attr('disabled',true);
          }else{
            $("#SaveVehicle").removeAttr('disabled');
            $("#plant_sales_report").removeAttr('required');
            $("#plant_sales_month").removeAttr('required');
          }


          if(alloc_dealer == '' &&  alloc_date ==''){
            $("#alloc_date").removeAttr('required');
            $("#alloc_dealer").removeAttr('required');
            $("#SaveVehicle").removeAttr('disabled');
          }else if(alloc_dealer !='' && alloc_date == ''){
            $("#SaveVehicle").attr('disabled',true);
            $("#alloc_date").attr('required',true);
            $("#alloc_dealer").attr('required',true);
          }else if(alloc_date !='' && alloc_dealer == ''){
            $("#SaveVehicle").attr('disabled',true);
            $("#alloc_date").attr('required',true);
            $("#alloc_dealer").attr('required',true);
          }else{
            $("#alloc_date").removeAttr('required');
            $("#alloc_dealer").removeAttr('required');
            $("#SaveVehicle").removeAttr('disabled');
          }
        });
        $("#alloc_dealer").on('change',function(){
            var alloc_dealer = $(this).val();
            var alloc_date = $("#alloc_date").val();

            if(alloc_dealer == '' &&  alloc_date ==''){
              $("#alloc_date").removeAttr('required');
              $("#alloc_dealer").removeAttr('required');
              $("#SaveVehicle").removeAttr('disabled');
            }else if(alloc_dealer !='' && alloc_date == ''){
              $("#SaveVehicle").attr('disabled',true);
              $("#alloc_date").attr('required',true);
              $("#alloc_dealer").attr('required',true);
            }else if(alloc_date !='' && alloc_dealer == ''){
              $("#SaveVehicle").attr('disabled',true);
              $("#alloc_date").attr('required',true);
              $("#alloc_dealer").attr('required',true);
            }else{
              $("#alloc_date").removeAttr('required');
              $("#alloc_dealer").removeAttr('required');
              $("#SaveVehicle").removeAttr('disabled');
            }
        });
        $("#plant_sales_report").on('change',function(){
          var plant_sales_report = $(this).val();
          var plant_sales_month = $("#plant_sales_month").val();

          if(plant_sales_month == '' && plant_sales_report == ''){
            $("#SaveVehicle").removeAttr('disabled');
            $("#plant_sales_report").removeAttr('required');
            $("#plant_sales_month").removeAttr('required');
          }else if(plant_sales_month !='' && plant_sales_report == ''){
            $("#plant_sales_month").attr('required',true);
            $("#plant_sales_report").attr('required',true);
            $("#SaveVehicle").attr('disabled',true);
          }else if(plant_sales_report !='' && plant_sales_month == '0000-00-00'){
            $("#plant_sales_month").attr('required',true);
            $("#plant_sales_report").attr('required',true);
            $("#SaveVehicle").attr('disabled',true);
          }else if(plant_sales_report !='' && plant_sales_month == ''){
            $("#plant_sales_month").attr('required',true);
            $("#plant_sales_report").attr('required',true);
            $("#SaveVehicle").attr('disabled',true);
          }else{
            $("#SaveVehicle").removeAttr('disabled');
            $("#plant_sales_report").removeAttr('required');
            $("#plant_sales_month").removeAttr('required');
          }
        });
        $("#alloc_date").datepicker({
        }).on("changeDate", function (e) {
            e.preventDefault();
            var alloc_date = $("#alloc_date").val();
            var alloc_dealer = $("#alloc_dealer").val();
            console.log(alloc_date);

            if(alloc_dealer == '' &&  alloc_date ==''){
              $("#alloc_date").removeAttr('required');
              $("#alloc_dealer").removeAttr('required');
              $("#SaveVehicle").removeAttr('disabled');
            }else if(alloc_dealer !='' && alloc_date == ''){
              $("#alloc_dealer").attr('disabled',true);
              $("#alloc_date").attr('required',true);
              $("#alloc_dealer").attr('required',true);
            }else if(alloc_date !='' && alloc_dealer == ''){
              $("#SaveVehicle").attr('disabled',true);
              $("#alloc_date").attr('required',true);
              $("#alloc_dealer").attr('required',true);
            }else{
              $("#alloc_date").removeAttr('required');
              $("#alloc_dealer").removeAttr('required');
              $("#SaveVehicle").removeAttr('disabled');
            }
        });
        $("#alloc_date").on('change',function(){
          var alloc_date = $(this).val();
          var alloc_dealer = $("#alloc_dealer").val();

          if(alloc_dealer == '' &&  alloc_date ==''){
            $("#alloc_date").removeAttr('required');
            $("#alloc_dealer").removeAttr('required');
            $("#SaveVehicle").removeAttr('disabled');
          }else if(alloc_dealer !='' && alloc_date == ''){
            $("#SaveVehicle").attr('disabled',true);
            $("#alloc_date").attr('required',true);
            $("#alloc_dealer").attr('required',true);
          }else if(alloc_date !='' && alloc_dealer == ''){
            $("#SaveVehicle").attr('disabled',true);
            $("#alloc_date").attr('required',true);
            $("#alloc_dealer").attr('required',true);
          }else{
            $("#alloc_date").removeAttr('required');
            $("#alloc_dealer").removeAttr('required');
            $("#SaveVehicle").removeAttr('disabled');
          }
        });
        $("#plant_sales_month").on('change',function(){
          var plant_sales_month = $(this).val();
          console.log(plant_sales_month);
          var plant_sales_report = $("#plant_sales_report").val();

          if(plant_sales_month == '' && plant_sales_report == ''){
            $("#SaveVehicle").removeAttr('disabled');
            $("#plant_sales_report").removeAttr('required');
            $("#plant_sales_month").removeAttr('required');
          }else if(plant_sales_month !='' && plant_sales_report == ''){
            $("#plant_sales_month").attr('required',true);
            $("#plant_sales_report").attr('required',true);
            $("#SaveVehicle").attr('disabled',true);
          }else if(plant_sales_report !='' && plant_sales_month == '0000-00-00'){
            $("#plant_sales_month").attr('required',true);
            $("#plant_sales_report").attr('required',true);
            $("#SaveVehicle").attr('disabled',true);
          }else if(plant_sales_report !='' && plant_sales_month == ''){
            $("#plant_sales_month").attr('required',true);
            $("#plant_sales_report").attr('required',true);
            $("#SaveVehicle").attr('disabled',true);
          }else{
            $("#SaveVehicle").removeAttr('disabled');
            $("#plant_sales_report").removeAttr('required');
            $("#plant_sales_month").removeAttr('required');
          }
        });
        $("#plant_sales_month").datepicker({
        }).on("changeDate", function (e) {
            var plant_sales_month = $(this).val();
            var dateSelected=e.date;
            var plant_sales_report = $("#plant_sales_report").val();

            if(dateSelected == '' && plant_sales_report == ''){
              $("#SaveVehicle").removeAttr('disabled');
              $("#plant_sales_report").removeAttr('required');
              $("#plant_sales_month").removeAttr('required');
            }else if(dateSelected !='' && plant_sales_report == ''){
              $("#plant_sales_month").attr('required',true);
              $("#plant_sales_report").attr('required',true);
              $("#SaveVehicle").attr('disabled',true);
            }else if(plant_sales_report !='' && dateSelected == '0000-00-00'){
              $("#plant_sales_month").attr('required',true);
              $("#plant_sales_report").attr('required',true);
              $("#SaveVehicle").attr('disabled',true);
            }else if(plant_sales_report !='' && dateSelected == ''){
              $("#plant_sales_month").attr('required',true);
              $("#plant_sales_report").attr('required',true);
              $("#SaveVehicle").attr('disabled',true);
            }else{
              $("#SaveVehicle").removeAttr('disabled');
              $("#plant_sales_report").removeAttr('required');
              $("#plant_sales_month").removeAttr('required');
            }
        });
        $(".editable_po").on('change',function(){
          $("#save").removeAttr('disabled');
        });
        $('textarea').on('keyup', function(e) {
          $("#save").removeAttr('disabled');
        });
        // main function

        //input function
        $('#podate').datepicker({
            dateFormat: 'MM dd, yy',
            startDate: '-3d'
        }).on("changeDate", function (e) {
            e.preventDefault();
            var val=$(this).val();
            $('#whole_sale_period').val($.datepicker.formatDate('mm-yy', new Date(val)));
        });
        $('#vrdate').on('keyup',function(){
          var val=$(this).val();
          if($('#podate').val() =='' || val == ''){
              $("#ardI").prop('disabled',true);
          }else{
              $("#ardI").prop('disabled',false);
          }
        });
        $('#vrdate').datepicker({
            dateFormat: 'MM dd, yy',
            startDate: '-3d'
        }).on("changeDate", function (e) {
            e.preventDefault();
            var val=$(this).val();
            if($('#podate').val() =='' || val == ''){
                $("#ardI").prop('disabled',true);
            }else{
                $("#ardI").prop('disabled',false);
            }
        });
        $('#csrdate').datepicker({
            dateFormat: 'MM dd, yy',
            startDate: '-3d'
        });
        $('#paiddate').datepicker({
            dateFormat: 'MM dd, yy',
            startDate: '-3d'
        });
        $('#alloc_date').datepicker({
            dateFormat: 'MM dd, yy',
            startDate: '-3d'
        });
        $('#ardI').datepicker({
            dateFormat: 'MM dd, yy',
            startDate: '-3d'
        });


        $('#podate').on('click',function(){
          $("#save").removeAttr('disabled');
        });
        $('#whole_sale_period').on('click',function(){
          $("#save").removeAttr('disabled');
        });
        $('#vrdate').on('click',function(){
          $("#SaveVehicle").removeAttr('disabled');
        });
        // $('#plant_sales_month').on('click',function(){
        //   $("#SaveVehicle").removeAttr('disabled');
        // });
        $('#csrdate').on('click',function(){
          $("#SaveVehicle").removeAttr('disabled');
        });
        $('#paiddate').on('click',function(){
          $("#SaveVehicle").removeAttr('disabled');
        });
        // $('#alloc_date').on('click',function(){
        //   $("#SaveVehicle").removeAttr('disabled');
        // });
        $('#ardI').on('click',function(){
          $("#SaveVehicle").removeAttr('disabled');
        });
        //input function



        //api function
        function api()
        {
          var res = { };
          res['cs'] = 'E2C098';
          // console.log(res);
          $.ajax({
          	url: 'https://gp.collections.licagroup.biz/api/getcs',
          	type: "POST",
          	dataType:"JSON",
          	headers: {
          		'client-service':'gp-client',
          		'auth-key':'gp-auth',
          		'Content-Type':'application/json'
          	},
          	data:JSON.stringify(res),
          	beforeSend: function () {
          		$("#res").html('Loading data...');
          	},
          	success: function (r) {
          		$("#res").html(JSON.stringify(r));
              // console.log(JSON.stringify(r));
          	}
          }).fail(function(r) {
            console.log('error');
          	$("#res").html(JSON.stringify(r.responseJSON));
            // console.log(JSON.stringify(r.responseJSON));
          });
        }
        //api function
  });
</script>
