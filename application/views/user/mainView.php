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
</style>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Purchase Order</h1>
            <div class="btn-toolbar mb-3 mb-md-0">
              <div class="btn-group mr-3">
                <!-- <button class="btn btn-md btn-outline-secondary" id="apo"><span data-feather="shopping-cart"></span> Add Purchase Order</button> -->
                <button class="btn btn-md btn-outline-secondary" id="import"><span data-feather="download"></span> Batch Import</button>
                  <?php if($ids == 1){ ?>
                <button class="btn btn-md btn-outline-secondary" id="testimport"><span data-feather="download"></span> test Import</button>
                <?php } ?>

              </div>
              <div class="btn-group mr-2">
                <?php if($ids == 1){ ?>
               <button class="btn btn-md btn-outline-secondary" id="uaStatus"><span data-feather="loader"></span>Update all Status</button>
               <?php } ?>
              </div>
              <a href="../Excel/IMAPS_SAMPLE_DATA.xls"><button class="btn btn-md btn-outline-secondary" id="import"><span data-feather="download"></span>Download Sample File</button></a>
            </div>
          </div>
          <div class="col-md-3" style="float:left; margin-bottom:20px;">
            <label for="selectSTatus"> Filter by CS#:</label>
            <select id="selectStatus" class="form-control">
              <option value=''>Select Filter</option>
              <option value='po'>No CS Number</option>
              <option value='pocs'>With CS Number</option>
            </select>
          </div><br><br>
          <div class="table-responsive">
            <table class="table table-striped table-sm" id="table">
              <thead>
                <tr>
                  <th>P.O. Number</th>
                  <th>P.O. Date</th>
                  <th>P.O. Dealer</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>

<script type="text/javascript">
	$(document).ready(function() {

			var bUrl="<?php echo base_url(); ?>";
            var select=$('select').select2();
  			var table=$('#table').DataTable({
                  "bPrcessing":true,
                  "bServerSide":true,
                  "sServerMethod": "GET",
                  "bInfo": false,
                  "processing": true,
                  "sAjaxSource":bUrl+"Inventory/POData",
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
                      {"className":"text-center nwp","bSortable":false,"targets":0},
                      {"className":"text-center nwp","bSortable":false,"targets":1},
                      {"className":"text-center","bSortable":false,"targets":2},
                      {"className":"text-center","bSortable":true,"targets":3}
                  ],
                  "drawCallback":function (settings){
                      $(".btnview").on('click',function(){
                          var id=$(this).val();
                          var name=$(this).attr('username');
                          $.alert({
                              type:'blue',
                              columnClass:"col-sm-8 col-sm-offset-2",
                              title: 'Purchase Order View Form',
                              content: 'url:'+bUrl+'Inventory/POinfo?id='+id,
                              buttons:{
                                  save:{
                                      text:'Save',
                                      btnClass: 'btn-green',
                                      action: function(){
                                          var main=this;
                                          var ar=$('#poeditform').serialize();
                                          var action="Inventory/editPO";
                                          var currentTime = new Date();
                                          var val=$("#po_date2").val();
                                          var selected_date =new Date(val);
                                          var year = currentTime.getFullYear();
                                          var year2 = selected_date.getFullYear();
                                          var year3 = selected_date.getFullYear();

                                          if( year2 < '1990')
                                          {
                                              $.alert({
                                                title:"",
                                                type:"red",
                                                content:"Please select a valid P.O. Date"
                                              });
                                              return false;
                                          }
                                          if(year3 > year)
                                          {
                                              $.alert({
                                                title:"",
                                                type:"red",
                                                content:"Please select a valid P.O. Date"
                                              });
                                              return false;
                                          }
                                          if($('#poeditform')[0].checkValidity() === false)
                                          {
                                              $('#poeditform').addClass('was-validated');

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
                                                  // console.log(wmsg);
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
                      $(".btnview1").on('click',function(){
                          var id=$(this).val();
                          var name=$(this).attr('username');
                          $.alert({
                              type:'blue',
                              columnClass:"col-sm-8 col-sm-offset-2",
                              title: 'Purchase Order View Form',
                              content: 'url:'+bUrl+'Inventory/POinfo1?id='+id,
                              buttons:{
                                  close:{
                                      text:'Close',
                                      btnClass: 'btn-red'
                                  },
                              }
                          });
                      });
                      $(".closePO").on('click',function(){
                         var id=$(this).val();
                          $.ajax({
                            url: bUrl+"Inventory/close?id="+id,
                                type: "GET",
                                dataType: "JSON",
                                success: function (data) {
                                  table.draw();
                                },
                                error: function() {
                                    console.log('error');
                                }
                          });
                      });
                      $(".openPO").on('click',function(){
                        var id=$(this).val();
                          $.ajax({
                            url: bUrl+"Inventory/open?id="+id,
                                type: "GET",
                                dataType: "JSON",
                                success: function (data) {
                                  table.draw();
                                },
                                error: function() {
                                    console.log('error');
                                }
                          });
                      });
                      $(".btnnadd").on('click',function(){
                          var id=$(this).val();
                          console.log(id);
                            $.alert({
                                  type:'green',
                                  columnClass:"col-sm-8 col-sm-offset-2",
                                      title:'Add Vehicle For P.O.',
                                      content:'url:'+bUrl+'Inventory/POVehicleForm?po_num='+id,
                                      class:'btnSubmit',
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
                                                                // self.close();
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
                      $(".deletePo").on('click',function(){
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
                              var action="Inventory/deletePo?id="+val
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
            var intVal = function ( i ) {
         return typeof i === 'string' ?
           i.replace(/[\₱,]/g, '')*1 :
         typeof i === 'number' ?
           i : 0;
        };
      $('#apo').on('click',function(){
					$.alert({
					type:'green',
					columnClass:"col-sm-8 col-sm-offset-2",
					title:'Add Purchase Order',
					content:'url:'+bUrl+'Inventory/POForm',
					buttons:
					{
						confirm:
						{
							text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function(){
                                var main=this;
                                var ar=$('#poform').serialize();
                                var action="Inventory/addPO";
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
                                        $.alert({
                                                  type:'green',
                                                  columnClass:"col-sm-8 col-sm-offset-2",
                                                  title:'Add Vehicle For P.O.',
                                                  content:'url:'+bUrl+'Inventory/POVehicleForm?po_num='+PO_ID,
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
      $("#testimport").on('click',function(){
        $.alert({
          type:'green',
          columnClass:"col-sm-6 col-sm-offset-4",
          title:'Import Excel Record',
          content:'url:'+bUrl+'Inventory/IForm',
          buttons:
        {
          confirm:
          {
            text: 'Submit',
            btnClass: 'btn-blue one',
              action: function(){
                var main=this;
                var ar=$('#importform').serialize();
                var action="Uploadar/douploadinsurance";
                var file = $("#userFile")[0].files;
                console.log(file);
                var reader = new FileReader();
                var fData = new FormData();
                fData.append('userfile', file[0]);
                 $.ajax({
                    url: bUrl+'Uploadar/douploadinsurance',
                    type: 'POST',
                    data : fData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    xhr: function() {
                      var myXhr = $.ajaxSettings.xhr();
                      if (myXhr.upload) {
                                // For handling the progress of the upload
                                myXhr.upload.addEventListener('progress', function(e) {
                                  if (e.lengthComputable) {
                                    var p = (e.loaded  / e.total) * 100;
                                    $("#loadingBar").css("width",Math.round(p)+"%");
                                    $('#loadingBar').html('Uploading '+Math.round(p)+'% Complete Please Wait..');

                                  }
                                } , false);
                        }
                        return myXhr;
                    },
                    beforeSend: function (argument) {
                          $('.progress').css('display','flex');
                          $('#loadingBar').html('Loading...');
                          $('.one').attr('disabled',true);
                          $('.close').attr('disabled',true);
                    },
                 }).done(function(msg){
                  jQuery.notify({
                        message: msg
                         },{
                        placement: {
                          from: "bottom",
                          align: "left"
                        },
                        type: 'success'
                     });
                     main.close();
                    table.draw();

                 }).fail(function () {
                                    $.alert({
                                        theme:"bootstrap",
                                        title: 'Status',
                                        content: 'Connection failed!',
                                        type: 'red',
                                        columnClass: 'col-sm-6 col-sm-offset-3',
                                        buttons: {
                                            ok: {
                                                text: 'OK',
                                                btnClass: 'btn-red soloBtn',
                                                keys: ['enter'],
                                                action: function () {
                                                    main.close();
                                                    table.draw();
                                                }
                                            }
                                        }
                                    });
                   });
                  return false;
               },
          },
          close:
          {
            text:'Close',
            btnClass:'btn-red close'
          }
        }
        });
      });
      $('#import').on('click',function(){
        var id="<?php echo $ids; ?>";
          $.alert({
            type:'green',
            columnClass:"col-sm-6 col-sm-offset-4",
            title:'Import Excel Record',
            content:'url:'+bUrl+'Inventory/IForm',
            buttons:
          {
            confirm:
            {
              text: 'Submit',
              btnClass: 'btn-blue one',
                action: function(){
                  var main=this;
                  var ar=$('#importform').serialize();
                  var action="Uploadar/do_upload5";
                      if($('#importform')[0].checkValidity() === false)
                      {
                        $('#importform').addClass('was-validated');
                          return false;
                      }
                  var file = $("#userFile")[0].files;
                  console.log(file);
                  var reader = new FileReader();
                  var fData = new FormData();
                  var ids="<?php echo $ids; ?>";
                  var type="<?php echo $type; ?>";
                  fData.append('userfile', file[0]);
                   $.ajax({
                      url: bUrl+'Uploadar/do_upload5?id='+id+'&ids='+ids+'&type='+type,
                      type: 'POST',
                      data : fData,
                      cache: false,
                      contentType: false,
                      processData: false,
                      xhr: function() {
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) {
                                  // For handling the progress of the upload
                                  myXhr.upload.addEventListener('progress', function(e) {
                                    if (e.lengthComputable) {
                                      var p = (e.loaded  / e.total) * 100;
                                      $("#loadingBar").css("width",Math.round(p)+"%");
                                      $('#loadingBar').html('Uploading '+Math.round(p)+'% Complete Please Wait..');

                                    }
                                  } , false);
                          }
                          return myXhr;
                      },
                      beforeSend: function (argument) {
                            $('.progress').css('display','flex');
                            $('#loadingBar').html('Loading...');
                            $('.one').attr('disabled',true);
                            $('.close').attr('disabled',true);
                      },
                   }).done(function(msg){
                    jQuery.notify({
                          message: msg
                           },{
                          placement: {
                            from: "bottom",
                            align: "left"
                          },
                          type: 'success'
                       });
                       main.close();
                      table.draw();

                   }).fail(function () {
                                      $.alert({
                                          theme:"bootstrap",
                                          title: 'Status',
                                          content: 'Connection failed!',
                                          type: 'red',
                                          columnClass: 'col-sm-6 col-sm-offset-3',
                                          buttons: {
                                              ok: {
                                                  text: 'OK',
                                                  btnClass: 'btn-red soloBtn',
                                                  keys: ['enter'],
                                                  action: function () {
                                                      main.close();
                                                      table.draw();
                                                  }
                                              }
                                          }
                                      });
                     });
                    return false;
                 },
            },
            close:
            {
              text:'Close',
              btnClass:'btn-red close'
            }
          }
          });
      });

      $('#uaStatus').on('click',function(){
        $.ajax({
					url: bUrl+"Dashboard/updateAllStatus",
					type:"GET",
					dataType:"JSON",
					success:function(data)
					{
						if(data == 'success')
						{
							 $.alert({
							 	type:'green',
	              columnClass:"col-sm-4 col-sm-offset-6",
	              title: '<h2 style="color:red;"></h2>',
	              content: '<h5 style="color:Green;">All Status Updated, Thank you.</h5>',
							 });
						}
					},
					error:function(){
						console.log('error');
					}
				});
      });
	});

</script>
