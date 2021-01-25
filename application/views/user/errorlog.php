<style>
#table td{
  white-space: nowrap;
}
</style>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Import Error Log Table</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-1">
                <!-- <span data-feather="calendar"></span>Date -->
              </div>
              <div class="btn-group mr-2">
                <button class="btn btn-danger btn-md btn-outline-secondary" id="clear" style="color:#fff; margin-right:5px;"><span data-feather="x-circle"></span> Clear Logs</button>
                <button class="btn btn-danger btn-md btn-outline-secondary" id="updateall" style="color:#fff;"><span data-feather="x-circle"></span> Update All Logs</button>

              </div>
            </div>
          </div>
          <div class="col-md-3" style="float:left; margin-bottom:20px;">
            <label for="selectSTatus"> Filter by Status:</label>
            <select id="selectStatus" class="form-control">
              <option value=''>Select Status</option>
              <option value='Clear'>Clear</option>
              <option value='notclear'>Not Clear</option>
            </select>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-sm" id="table">
              <thead>
                <tr>
                  <th>P.O Number</th>
                  <th>Date</th>
                  <th>Reason</th>
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
      // var table=$('#table').DataTable();

      var table=$('#table').DataTable({
                "bPrcessing":true,
                "bServerSide":true,
                "sServerMethod": "GET",
                "bInfo": false,
                "sAjaxSource":bUrl+"Inventory/IELogdata",
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
                    {"className":"text-center nwp","bSortable":true,"targets":1},
                    {"className":"text-center","bSortable":false,"targets":2}
                ],
                "drawCallback":function (settings){
                  $(".ur").on('click',function(){
                       var id = $(this).val();
                       $.alert({
                           type:'red',
                           columnClass:"col-sm-5 col-sm-offset-3",
                           title: 'Are you sure you want to continue?',
                           content: '',
                           buttons:{
                               save:{
                                   text:'Yes',
                                   btnClass: 'btn-green',
                                   action: function(){
                                     $.ajax({
                                           url: bUrl+"Inventory/UpdatedataIE?id="+id,
                                           type: "POST",
                                           dataType:"JSON",
                                           success: function (data) {
                                             table.draw();
                                             $.alert({
                                               title:"",
                                               type:"Green",
                                               content:"<h4>Data Updated</h4>"
                                             });
                                           },
                                           error: function(e) {
                                               console.log(e);
                                           }
                                     });
                                   },
                               },
                               close:{
                                   text:'No',
                                   btnClass: 'btn-red'
                               },
                           }
                       });

                  });
                  $(".ig").on('click',function(){
                      var id = $(this).val();
                      $.ajax({
                            url: bUrl+"Inventory/UpdateInvalid?id="+id,
                            type: "POST",
                            dataType:"JSON",
                            success: function (data) {
                              table.draw();
                              $.alert({
                                title:"",
                                type:"Green",
                                content:"<h4>Data Updated</h4>"
                              });
                            },
                            error: function(e) {
                                console.log(e);
                            }
                      });
                  });
                }
      });
      $('#selectStatus').change(function(){
        table.draw();
      });
      $("#clear").on('click',function(){
        $.ajax({
              url: bUrl+"Inventory/clear",
              type: "POST",
              dataType:"JSON",
              success: function (data) {
                table.draw();
                $.alert({
                  title:"",
                  type:"Green",
                  content:"<h4>Data Cleared</h4>"
                });
              },
              error: function(e) {
                  console.log(e);
              }
        });

      });
      $("#updateall").on('click',function(){
        $.alert({
          type:'green',
          columnClass:"col-sm-6 col-sm-offset-4",
          title:'Update all record',
          content:'url:'+bUrl+'Inventory/lform',
          buttons:
        {
          confirm:
          {
            text: 'Update All',
            btnClass: 'btn-blue one',
              action: function(){
                var main=this;
                var ar=$('#importform').serialize();
                $.ajax({
                    url: bUrl+"Inventory/updateall",
                    type: "POST",
                    dataType:"JSON",
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


        // $.ajax({
        //       url: bUrl+"Inventory/updateall",
        //       type: "POST",
        //       dataType:"JSON",
        //       beforeSend: function() {
        //           // setting a timeout
        //           var a=$.alert({
        //             title:"",
        //             type:"Green",
        //             content:'url:'+bUrl+'Inventory/IForm',
        //             // content:"<h4>Please Wait... Updating....</h4>"
        //           });
        //       },
        //       success: function (data) {
        //         a.close();
        //         table.draw();
        //         $.alert({
        //           title:"",
        //           type:"Green",
        //           content:"<h4>Data Updated</h4>"
        //         });
        //       },
        //       error: function(e) {
        //           console.log(e);
        //       }
        // });

      });
	});
</script>
