<?php
$CI =& get_instance();
$CI->load->model('main_m');
// $color=$CI->main_m->color_cat();
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$ids=$datas->id;
$type=$datas->type;
$color=$CI->Dashboard_m->color();
	if($type == 1)
	{
		$brand=$CI->Dashboard_m->brand();
	}else{
		$accessdealer=$CI->Admin_m->getaccess($ids);
		if(count($accessdealer) >= 1)
		{
			$brand=$CI->Dashboard_m->brand2($accessdealer);
		}else{
			$brand=$CI->Dashboard_m->brand();
		}

	}

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
      <h1 class="h2">Approved Dashboard</h1>
  </div>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-1">
            <!-- <span data-feather="calendar"></span>Date -->
        </div>
        <div class="btn-group mr-3">
          <select id="brand" name="brand" class="form-control">
            <option value="">All Brand </option>
            <?php foreach($brand as $value){ ?>
                <option value="<?php echo $value->Company; ?>"><?php echo $value->Company; ?></option>
            <?php }?>
          </select>
        </div>
        <div class="btn-group mr-2">

          <button class="btn btn-md btn-outline-secondary" id="scan"><span data-feather="search"></span> Scan</button>
        </div>
     </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm" id="table">
      <thead>
        <th>Variant</th>
        <th>Color</th>
        <th>Approved For Po</th>
        <th>Options</th>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</main>
<script type="text/javascript">
  $(document).ready(function() {
    	var bUrl="<?php echo base_url(); ?>";
      var select=$("select").select2();
      var intVal = function ( i ) {
         return typeof i === 'string' ?
           i.replace(/[\₱,]/g, '')*1 :
         typeof i === 'number' ?
           i : 0;
        };

      var table=$('#table').DataTable({
                "bPrcessing":true,
                "bServerSide":true,
                "sServerMethod": "GET",
                "bInfo": false,
                "processing": true,
                "sAjaxSource":bUrl+"Dashboard/AData",
                "fnServerData":function (sSource,aoData,callback){
                  aoData.push(
                      {"name":"Id","value":1},
                      {"name":"brand","value":$('#brand').val()}
                  );
                    $.ajax({
                        'url':sSource,
                        'data':aoData,
                        'type':'GET',
                        'success':callback,
                        'dataType':'json',
                        'cache':true
                    });
                },
                "lengthMenu":[[10,25,50,-1],[10,25,50,"ALL"]],
                "columnDefs":[
                    {"className":"text-center nwp","bSortable":true,"targets":0},
                    {"className":"text-center nwp","bSortable":true,"targets":1},
                    {"className":"text-center","bSortable":false,"targets":2},
                    {"className":"text-center","bSortable":false,"targets":3}
                ],
                "drawCallback":function (settings){
                  $(".cretepo").on("click",function(){
                        var fa_id=$(this).val();

                        $.alert({
                            type:'blue',
                            columnClass:"col-sm-10 col-sm-offset-2",
                            title: 'Create PO',
                            content: 'url:'+bUrl+'Dashboard/poform?fa_id='+fa_id,
                            buttons:{
                              confirm:
                              {
                                text: 'Submit',
                                              btnClass: 'btn-blue',
                                              action: function(){
                                                  var main=this;
                                                  var ar=$('#poform').serialize();
                                                  var action="Dashboard/addpo";
                                                  var currentTime = new Date();
                                                   var val=$("#po_date").val();
                                                   var PO_ID=$("#po_num").val();
                                                  var selected_date =new Date(val);
                                                  var year = currentTime.getFullYear();
                                                  var year2 = selected_date.getFullYear();
                                                  var year3 = selected_date.getFullYear();
                                                  var cost=intVal($("#cost").val());
                                                  if(parseInt(cost) < parseInt('300000'))
                                                  {
                                                      $("#cost").val("");
                                                      $('#poform').addClass('was-validated');

                                                      return false;
                                                  }
                                                  if(parseInt(cost) > parseInt('5000000'))
                                                  {
                                                      $("#cost").val("");
                                                      $('#poform').addClass('was-validated');

                                                      return false;
                                                  }
                                                  if( year2 < '1990')
                                                  {
                                                      $.alert({
                                                        title:"",
                                                        type:"red",
                                                        content:"Please select a valid P.O. Date"
                                                      });
                                                      return false;
                                                  }

                                                  if($('#poform')[0].checkValidity() === false)
                                                  {
                                                      $('#poform').addClass('was-validated');

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
                                                                    jQuery.notify({
                                                                      // options
                                                                      message: 'PO Added Successfuly!'
                                                                    },{
                                                                      // settings
                                                                       placement: {
                                                                          from: "bottom",
                                                                          align: "left"
                                                                      },
                                                                      type: 'success'
                                                                    });
                                                           $.alert({
                                                                     type:'green',
                                                                     columnClass:"col-sm-8 col-sm-offset-2",
                                                                     title:'Add Vehicle For P.O.',
                                                                     content:'url:'+bUrl+'Dashboard/vehicleForm?po_num='+PO_ID,
                                                                     buttons:
                                                                     {
                                                                       confirm:
                                                                       {
                                                                         text: 'Submit',
                                                                         btnClass: 'btn-blue',
                                                                         action: function(){
                                                                         var main=this;
                                                                         var ar=$('#vechile_form2').serialize();
                                                                         var action="Dashboard/addNewVehicle";
                                                                         var currentTime = new Date();
                                                                         var val1=$('#psm').val().split('-');
                                                                         var newval1=val1[1]+'-'+val1[0]+'-01';
                                                                         var val2=$('#wsp').val().split('-');
                                                                         var newval2=val2[1]+'-'+val2[0]+'-01';
                                                                         if(newval1 < '1990-01-01')
                                                                         {
                                                                           $.alert({
                                                                             type:'red',
                                                                             columnClass:"col-sm-6 col-sm-offset-4",
                                                                             title: '<h3 style="color:red;">Error</h3>',
                                                                             content: '<h5 style="color:red;">Please provide a Valid Plant Released Month, Thank you.</h5>',
                                                                            });
                                                                           $('#psm').val("");
                                                                           return false;
                                                                         }
                                                                         if(newval2 < '1990-01-01')
                                                                         {

                                                                           $.alert({
                                                                             type:'red',
                                                                             columnClass:"col-sm-6 col-sm-offset-4",
                                                                             title: '<h3 style="color:red;">Error</h3>',
                                                                             content: '<h5 style="color:red;">Please provide a Valid Whole Sale Period, Thank you.</h5>',
                                                                            });
                                                                           $('#wsp').val("");

                                                                           return false;
                                                                         }
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
                                                                                                     console.log(wmsg);
                                                                                                     if(wmsg > 0)
                                                                                                     {

                                                                                                     self.close();
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
                                                                                                             table.draw();
                                                                                                     }else{
                                                                                                     self.close();
                                                                                                             jQuery.notify({
                                                                                                               // options
                                                                                                               message: 'Add Vehicle Successfuly!'
                                                                                                             },{
                                                                                                               // settings
                                                                                                                placement: {
                                                                                                                   from: "bottom",
                                                                                                                   align: "left"
                                                                                                               },
                                                                                                               type: 'success'
                                                                                                             });
                                                                                                     table.draw();
                                                                                                   }
                                                                                                   // console.log(wmsg);
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
                                                            table.draw();
                                                          }).fail(function(){
                                                          self.setContent('Form Error. Please Try Again Later.');
                                                          });
                                                }
                                              });
                                            },
                                },
                                close:{
                                    text:'Close',
                                    btnClass: 'btn-red'
                                },
                            }
                          });
                  });
									$(".viewRemarks").on("click",function(){
											  var rt_id=$(this).val();
												$.alert({
                            type:'blue',
                            columnClass:"col-sm-7 col-sm-offset-5",
                            title: 'View Remarks/ Justification',
                            content: 'url:'+bUrl+'Dashboard/viewRemarksForm?rt_id='+rt_id,
														buttons:{
	                              // save:{
	                              //     text:'Save',
	                              //     btnClass: 'btn-green',
	                              //     action: function(){
	                              //         var main=this;
	                              //         var ar=$('#remarksEdit').serialize();
	                              //         var action="Dashboard/remarksUpdate";
	                              //         if($('#remarksEdit')[0].checkValidity() === false)
	                              //         {
	                              //             $('#remarksEdit').addClass('was-validated');
																//
	                              //             return false;
	                              //         }
	                              //         $.alert({
	                              //             title:"",
	                              //             type:"green",
	                              //             content:function(){
	                              //                 var self=this;
	                              //                 return $.ajax({
	                              //                 url:bUrl+action,
	                              //                 type:"POST",
	                              //                 data:ar,
	                              //                 }).done(function(wmsg){
	                              //                   self.close();
	                              //                 jQuery.notify({
	                              //                   // options
	                              //                   message: 'Submit Successfuly!'
	                              //                 },{
	                              //                   // settings
	                              //                    placement: {
	                              //                       from: "bottom",
	                              //                       align: "left"
	                              //                   },
	                              //                   type: 'success'
	                              //                 });
	                              //                 table.draw();
	                              //                 // console.log(wmsg);
	                              //                 }).fail(function(){
	                              //                 self.setContent('Form Error. Please Try Again Later.');
	                              //                 });
	                              //             }
	                              //         });
	                              //     },
	                              // },
	                              close:{
	                                  text:'Close',
	                                  btnClass: 'btn-red'
	                              },
	                          }
													});
									});
                }
      });

      $('#scan').on('click',function(){
        table.draw();
      });
  });
</script>
