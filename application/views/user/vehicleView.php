<style type="text/css">
  td{
    white-space: nowrap;
  }
  .sorting_asc:before{
    display: none !important;
  }
  .sorting_asc:after{
    display: none !important;
  }
  div.dt-buttons {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    vertical-align: middle;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
  }
  .up{
    text-transform: uppercase;
  }
</style>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Vehicle Inventory</h1>
          </div>

          <div class="tab-content">
            <div id="vehicle" class="container tab-pane active"><br>
                <div class="btn-toolbar mb-2 mb-md-0" style="float:right">
                  <div class="btn-group mr-1">
                    <!-- <span data-feather="calendar"></span>Date -->
                  </div>
                  <div class="btn-group mr-2">
                    <button class="btn btn-md btn-outline-secondary" id="apo"><span data-feather="truck"></span> Add Vehicle</button>
                  </div>
                  <div class="btn-group mr-2">
                    <button class="btn btn-md btn-outline-secondary" id="locationButton"><span data-feather="map-pin"></span> Change Location</button>
                  </div>
                  <!-- <div class="btn-group mr-2">
                    <button class="btn btn-md btn-outline-secondary" id="locationButton"><span data-feather="map-pin"></span> Change Location</button>
                  </div> -->
                </div>
                <div class="col-md-3" style="float:left; margin-bottom:20px;">
                  <label for="selectSTatus"> Filter by Status:</label>
                  <select id="selectStatus" class="form-control">
                    <option value=''>Select Status</option>
                    <option value='For Pull Out'>For Pull Out</option>
                    <option value='Available'>Available</option>
                    <option value='Allocated'>Allocated</option>
                    <option value='Invoiced'>Invoiced</option>
                    <option value='Released'>Released</option>
                  </select>
                </div><br><br>
                  <div class="table-responsive">
                    <table class="table table-striped table-sm" id="table">
                      <thead>
                        <tr>
                          <th></th>
                          <th>CS Number</th>
                          <th>P.O. Number</th>
                          <th>Car</th>
                          <th>Dealer</th>
                          <th>Status</th>
                          <th>Options</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
            </div>

        </main>
      </div>
    </div>
<script type="text/javascript">
	$(document).ready(function() {

			var bUrl="<?php echo base_url(); ?>";
            var select=$('select').select2();
			var table=$('#table').DataTable({
                "dom":"Bfrtip",
                "bPrcessing":true,
                "bServerSide":true,
                "sServerMethod": "GET",
                "bInfo": false,
                "sAjaxSource":bUrl+"Inventory/VehicleInvoice",
                "fnServerData":function (sSource,aoData,callback){
                    aoData.push(
                        {"name":"Id","value":1},
                        {"name":"Status","value":$('#selectStatus').val()}
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
                    {"className":"text-center nwp noVis","bSortable":false,"targets":0},
                    {"className":"text-center nwp noVis up","bSortable":false,"targets":1},
                    {"className":"text-center nwp","bSortable":false,"targets":2},
                    {"className":"text-center","bSortable":false,"targets":3},
                    {"className":"text-center","bSortable":false,"targets":4},
                    {"className":"text-center","bSortable":false,"targets":5},
                    {"className":"text-center noVis","bSortable":false,"targets":6}
                ],
                buttons: [
                    {
                        extend: 'colvis',
                        columns: ':not(.noVis)'
                    }
                ],
                "drawCallback":function (settings){
                    $(".Adddealer").on('click',function(){
                       var id=$(this).val();
                       $.alert({
                            type:'red',
                            columnClass:"col-sm-8 col-sm-offset-2",
                            title: 'Change Allocated Dealer',
                            content: 'url:'+bUrl+'Inventory/dealer_form?id='+id,
                            buttons:{
                                save:{
                                    text:'Submit',
                                    btnClass: 'btn-green',
                                    action: function(){
                                        var main=this;
                                        var ar=$('#dealer_form').serialize();
                                        var action="Inventory/dealer_function";
                                        if($('#dealer_form')[0].checkValidity() === false)
                                        {
                                            $('#dealer_form').addClass('was-validated');

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
                                                  message: 'Submit Successfuly!'
                                                },{
                                                  // settings
                                                   placement: {
                                                      from: "bottom",
                                                      align: "left"
                                                  },
                                                  type: 'success'
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
                    $(".received").on('click',function(){
                       var id=$(this).val();
                       $.alert({
                            type:'blue',
                            columnClass:"col-sm-8 col-sm-offset-2",
                            title: 'Received Form',
                            content: 'url:'+bUrl+'Inventory/received_form?id='+id,
                            buttons:{
                                save:{
                                    text:'Submit',
                                    btnClass: 'btn-green',
                                    action: function(){
                                        var main=this;
                                        var ar=$('#receive_form').serialize();
                                        var action="Inventory/receive_function";
                                        if($('#receive_form')[0].checkValidity() === false)
                                        {
                                            $('#receive_form').addClass('was-validated');

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
                                                  message: 'Submit Successfuly!'
                                                },{
                                                  // settings
                                                   placement: {
                                                      from: "bottom",
                                                      align: "left"
                                                  },
                                                  type: 'success'
                                                });
                                                table.draw();
                                                table2.draw();
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
                    $(".releaseds").on('click',function(){
                      var id=$(this).val();
                       $.alert({
                            type:'blue',
                            columnClass:"col-sm-8 col-sm-offset-2",
                            title: 'Release Form',
                             content: 'url:'+bUrl+'Inventory/release_form?id='+id,
                             buttons:{
                                save:{
                                    text:'Submit',
                                    btnClass: 'btn-green',
                                    action: function(){
                                        var main=this;
                                        var ar=$('#release_form').serialize();
                                        var action="Inventory/release_function";
                                        var currentTime = new Date();
                                        if($('#release_form')[0].checkValidity() === false)
                                        {
                                            $('#release_form').addClass('was-validated');

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
                                                  message: 'Submit Successfuly!'
                                                },{
                                                  // settings
                                                   placement: {
                                                      from: "bottom",
                                                      align: "left"
                                                  },
                                                  type: 'success'
                                                });
                                                table.draw();
                                                table2.draw();
                                                console.log(wmsg);
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
                    $(".invoices").on('click',function(){
                      var id=$(this).val();
                       $.alert({
                            type:'blue',
                            columnClass:"col-sm-8 col-sm-offset-2",
                            title: 'Invoice Form',
                            content: 'url:'+bUrl+'Inventory/new_invoice_form?id='+id,
                            buttons:{
                                save:{
                                    text:'Submit',
                                    btnClass: 'btn-green',
                                    action: function(){
                                        var main=this;
                                        var ar=$('#invoice_form').serialize();
                                        var action="Inventory/invoice_function";
                                        var currentTime = new Date();
                                        var paymodes=$('#paymodes').val();
                                        var bank=$('#bank').val();
                                        var fname=$('#first_name').val();
                                        var lname=$('#last_name').val();
                                        var company=$('#company_name').val();
                                        if(fname.length > 0)
                                        {
                                          if(lname.length > 0)
                                          {
                                            $('#company_name').prop('required',false);
                                            $('#first_name').prop('required',true);
                                            $('#last_name').prop('required',true);
                                          }
                                        }else if(company.length > 0){
                                          $('#company_name').prop('required',true);
                                          $('#first_name').prop('required',false);
                                          $('#last_name').prop('required',false);
                                        }else if(fname.length == 0 && lname.length == 0 && company.length == 0)
                                        {
                                          $('#company_name').prop('required',true);
                                          $('#first_name').prop('required',true);
                                          $('#last_name').prop('required',true);
                                        }
                                        // else if(else if(company.length > 0)
                                        // {
                                          // $('#company_name').prop('required',true);
                                          // $('#first_name').prop('required',false);
                                          // $('#last_name').prop('required',false);
                                        // }

                                        // if(paymodes == 'cash')
                                        // {
                                        //   $('#bank').prop('required',false);
                                        // }else{
                                        //   $('#bank').prop('required',true);
                                        // }
                                        if($('#invoice_form')[0].checkValidity() === false)
                                        {
                                            $('#invoice_form').addClass('was-validated');

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
                                                  message: 'Submit Successfuly!'
                                                },{
                                                  // settings
                                                   placement: {
                                                      from: "bottom",
                                                      align: "left"
                                                  },
                                                  type: 'success'
                                                });
                                                table.draw();
                                                table2.draw();
                                                console.log(wmsg);
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
                    $(".alloc").on('click',function(){
                       var id=$(this).val();
                       $.alert({
                            type:'blue',
                            columnClass:"col-sm-8 col-sm-offset-2",
                            title: 'Allocate Form',
                            content: 'url:'+bUrl+'Inventory/allocate_form?id='+id,
                            buttons:{
                                save:{
                                    text:'Submit',
                                    btnClass: 'btn-green',
                                    action: function(){
                                        var main=this;
                                        var ar=$('#allocate_form').serialize();
                                        var action="Inventory/allocate_function";
                                         if($('#allocate_form')[0].checkValidity() === false)
                                        {
                                            $('#allocate_form').addClass('was-validated');

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
                                                  message: 'Submit Successfuly!'
                                                },{
                                                  // settings
                                                   placement: {
                                                      from: "bottom",
                                                      align: "left"
                                                  },
                                                  type: 'success'
                                                });
                                                table.draw();
                                                table2.draw();
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
                    $(".info").on('click',function()
                    {
                       var id=$(this).val();
                       $.alert({
                            type:'blue',
                            columnClass:"col-sm-8 col-sm-offset-2",
                            title: 'Information Form',
                            content: 'url:'+bUrl+'Inventory/new_info_form?id='+id,
                            buttons:{
                                save:{
                                    text:'Submit',
                                    btnClass: 'btn-green',
                                    action: function(){
                                        var main=this;
                                        var ar=$('#info_vechile_form').serialize();
                                        var action="Inventory/new_info_form_function";
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
                                                  message: 'Submit Successfuly!'
                                                },{
                                                  // settings
                                                   placement: {
                                                      from: "bottom",
                                                      align: "left"
                                                  },
                                                  type: 'success'
                                                });
                                                table.draw();
                                                table2.draw();
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
                     $(".deleteveh").on('click',function(){
                       var val=$(this).val();
                       $.alert({
             					type:'red',
             					columnClass:"col-sm-4 col-sm-offset-6",
             					title:'Are you sure you want to delete?',
             					content:'',
             					buttons:
             					{
             						confirm:
             						{
             							text: 'Yes',
                           btnClass: 'btn-green btn-sm',
                           action: function(){
                             var action="Inventory/deleteVehicle?id="+val
                             $.alert({
                               title:"",
                               type:"green",
                               content:function(){
                                 var self=this;
                                   return $.ajax({
                                     url:bUrl+action,
                                     type:"POST",
                                     }).done(function(wmsg){
                                     self.close();
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
                                                                   message: 'Submit Successfuly!'
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
                                     }).fail(function(){
                                         self.setContent('Form Error. Please Try Again Later.');
                                       });
                                     }
                                   });
                           }
                         },
                         close:
             						{
             							text:'No',
             							btnClass:'btn-red btn-sm'
             						}
                       }
                       });
                     });
                }
            });

      $('#selectStatus').change(function(){
        table.draw();
      });
      $('#apo').on('click',function(){
					$.alert({
					type:'green',
					columnClass:"col-sm-8 col-sm-offset-2",
					title:'Add Vehicle For P.O.',
					content:'url:'+bUrl+'Inventory/VehicleForm',
					buttons:
					{
						confirm:
						{
							text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function(){
                                var main=this;
                                var ar=$('#vechile_form').serialize();
                                var action="Inventory/addVehicle";
                                var currentTime = new Date();
                                // var selected_date =new Date(document.getElementById('vvr').value);
                                // var year = currentTime.getFullYear();
                                // var year2 = selected_date.getFullYear();
                                // var year3 = selected_date.getFullYear();

                                // if( year2 < '1990')
                                // {
                                //     $.alert({
                                //       title:"",
                                //       type:"red",
                                //       content:"Please select a valid VVR Date"
                                //     });
                                //     return false;
                                // }
                                // if(year3 > year)
                                // {
                                //     $.alert({
                                //       title:"",
                                //       type:"red",
                                //       content:"Please select a valid VVR Date"
                                //     });
                                //     return false;
                                // }
                                if($('#vechile_form')[0].checkValidity() === false)
                                {
                                    $('#vechile_form').addClass('was-validated');

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
                                                  message: 'Submit Successfuly!'
                                                },{
                                                  // settings
                                                   placement: {
                                                      from: "bottom",
                                                      align: "left"
                                                  },
                                                  type: 'success'
                                                });
                                        table.draw();
                                        table2.draw();
                                        // console.log(wmsg);
                                        }).fail(function(){
                                        self.setContent('Form Error. Please Try Again Later.');
                                        });
                                    }
                                });
                            },
						},
						// next:
						// {
						// 	text:'Submit And Create Invoice',
						// 	btnClass:'btn-success invoice'
						// },
						close:
						{
							text:'Close',
							btnClass:'btn-red'
						}
					}
					});
		  });
      $('#apo2').on('click',function(){
                    $.alert({
                    type:'green',
                    columnClass:"col-sm-8 col-sm-offset-2",
                    title:'Add Vehicle Invoice',
                    content:'url:'+bUrl+'Inventory/new_add_invoice_form',
                    buttons:
                    {
                        confirm:
                        {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function(){
                                var main=this;
                                var ar=$('#invoice_form').serialize();
                                var action="Inventory/new_add_invoice_function";
                                if($('#invoice_form')[0].checkValidity() === false)
                                {
                                    $('#invoice_form').addClass('was-validated');

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
                                                  message: 'Submit Successfuly!'
                                                },{
                                                  // settings
                                                   placement: {
                                                      from: "bottom",
                                                      align: "left"
                                                  },
                                                  type: 'success'
                                                });
                                        table.draw();
                                        table2.draw();
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
      });
       $("#locationButton").on('click',function(){
                        var test=$('.checkbox:checked');

                        var arr = new Array();
                        $.each(test, function( index, cb ) {
                          arr.push(cb.value);
                        });
                        console.log(arr);
                        if(arr.length == 0)
                        {
                           $.alert({
                            type:'red',
                            columnClass:"col-sm-4 col-sm-offset-2",
                            title:'',
                            content:'<h4 style="text-align:center"> Select Vehicle First </h4>',
                          });
                        }else{
                          $.alert({
                          type:'green',
                          columnClass:"col-sm-8 col-sm-offset-2",
                          title:'Change Vehicle',
                          content:'url:'+bUrl+'Inventory/changelocform?id='+arr,
                          buttons:
                            {
                              confirm:
                              {
                                text: 'Submit',
                                              btnClass: 'btn-blue',
                                              action: function(){
                                                  var main=this;
                                                  var ar=$('#change_location_form').serialize();
                                                  var action="Inventory/change_form";
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
                                                                    message: 'Submit Successfuly!'
                                                                  },{
                                                                    // settings
                                                                     placement: {
                                                                        from: "bottom",
                                                                        align: "left"
                                                                    },
                                                                    type: 'success'
                                                                  });
                                                          table.draw();
                                                          table2.draw();
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
                        }

                    });
	});
</script>
