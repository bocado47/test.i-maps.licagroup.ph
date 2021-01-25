<?php
$session_data = $this->session->userdata('logged_in');
$datas=$session_data[0];
$ids=$datas->id;
$type=$datas->type;
?>
 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Models Table</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-1">
                <a href="<?php echo base_url();?>Admin/download_mc" target="_self"><button class="btn btn-md btn-outline-secondary"><span data-feather="download"></span> Export Models </button></a>
              </div>
              <div class="btn-group mr-2">
                <button class="btn btn-md btn-outline-secondary" id="import"><span data-feather="upload"></span> Import Model</button>
              </div>
              <div class="btn-group mr-2">
                <button class="btn btn-md btn-outline-secondary" id="apo"><span data-feather="user-plus"></span> Add Model</button>
              </div>
                <a href="../Excel/IMAPS_SAMPLE_MODEL_DATA.xls"><button class="btn btn-md btn-outline-secondary" id="import"><span data-feather="download"></span>Download Sample File</button></a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-sm" id="table">
              <thead>
                <tr>
                  <th>Brand</th>
                  <th>Model</th>
                  <th>Series</th>
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
      var table=$('#table').DataTable({
                "bPrcessing":true,
                "bServerSide":true,
                "sServerMethod": "GET",
                "sAjaxSource":bUrl+"Admin/ModelsRecord",
                "fnServerData":function (sSource,aoData,callback){
                    aoData.push(
                        {"name":"Id","value":1}
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
                    {"className":"text-center","bSortable":false,"targets":2},
                    {"className":"text-center","bSortable":false,"targets":3},
                ],
                "drawCallback":function (settings){
                  $(".btnview").on('click',function(){
                     var id=$(this).val();
                     $.alert({
                        type:'blue',
                        columnClass:"col-sm-6 col-sm-offset-4",
                        title: 'Model View And Edit',
                        content: 'url:'+bUrl+'Admin/modeleditform?id='+id,
                        buttons:{
                          save:{
                              text:'Update',
                              btnClass: 'btn-green',
                              action:function()
                              {
                                var main=this;
                                var ar=$('#model_form_e').serialize();
                                console.log(ar);
                                var action="Admin/updatemodel";
                                if($('#model_form_e')[0].checkValidity() === false)
                                {
                                    $('#model_form_e').addClass('was-validated');

                                    return false;
                                }
                                $.alert({
                                    title:"Form",
                                    type:"green",
                                    content:function(){
                                      this.close();
                                      $.alert({
                                         type:'red',
                                         columnClass:"col-sm-6 col-sm-offset-4",
                                         title: 'Are you sure want to continue?',
                                         buttons:{
                                           save:{
                                             text:'Yes',
                                             btnClass: 'btn-green',
                                             action:function()
                                             {

                                               var self=this;
                                               // self.close();
                                               return $.ajax({
                                               url:bUrl+action,
                                               type:"POST",
                                               data:ar,
                                               }).done(function(wmsg){
                                                 $.alert({
                                                    type:'green',
                                                    columnClass:"col-sm-4 col-sm-offset-4",
                                                    title: 'Submit Successfuly!',
                                                    content:'',
                                                  });
                                                  table.draw();
                                               // console.log(wmsg);
                                             }).fail(function(data){
                                               self.setContent('Form Error. Please Try Again Later.');
                                               });
                                             }
                                           },
                                           close:{
                                             text:'No',
                                             btnClass: 'btn-red',
                                           }
                                         }
                                         });

                                    }
                                });

                              }
                          },
                          close:{
                          }
                        }
                        // content:id,
                     });
                  });
                   $(".btndelete").on('click',function(){
                    var id=$(this).val();
                    var action="Admin/delete_product?id="+id;

                    $.ajax({
                      url:bUrl+action,
                      type:"POST",
                      dataType:"JSON",
                      success:function(data)
                      {
                        // console.log(data);
                        $.alert({
                           type:'red',
                           columnClass:"col-sm-4 col-sm-offset-4",
                           title: 'Delete Successfuly!',
                           content:'',
                         });
                        table.draw();
                      },
                      error:function(){
                        console.log('error');
                      }
                    });
                  });
                  $(".btnactivate").on('click',function(){
                    var id=$(this).val();
                    var action="Admin/product_activate?id="+id;
                    $.ajax({
                      url:bUrl+action,
                      type:"POST",
                      dataType:"JSON",
                      success:function(data)
                      {
                        $.alert({
                        type:'green',
                        columnClass:"col-sm-4 col-sm-offset-2",
                        title:'Activate Succesfuly',
                        content: ''
                        });
                        table.draw();
                      },
                      error:function(){
                        console.log('error');
                      }
                    });
                  });
                  $(".btndeactivate").on('click',function(){
                    var id=$(this).val();
                    var action="Admin/product_deactivate?id="+id;
                    $.ajax({
                      url:bUrl+action,
                      type:"POST",
                      dataType:"JSON",
                      success:function(data)
                      {
                        $.alert({
                        type:'red',
                        columnClass:"col-sm-4 col-sm-offset-2",
                        title:'De-Activate Succesfuly',
                        content: ''
                        });
                        table.draw();
                      },
                      error:function(){
                        console.log('error');
                      }
                    });
                  });
                },
      });
      $('#apo').on('click',function(){
          $.alert({
          type:'green',
          columnClass:"col-sm-8 col-sm-offset-2",
          title:'Add New Model',
          content:'url:'+bUrl+'Admin/model_form',
          buttons:
          {
            confirm:
            {
              text: 'Submit',
              btnClass: 'btn-blue',
                action: function(){
                var main=this;
                var ar=$('#model_form').serialize();
                var action="Admin/model_form_add";
                if($('#model_form')[0].checkValidity() === false)
                {
                    $('#model_form').addClass('was-validated');
                    return false;
                }
                $.alert({
                  title:"Form",
                  type:"green",
                  content:function(){
                      var self=this;
                      return $.ajax({
                      url:bUrl+action,
                      type:"POST",
                      data:ar,
                      }).done(function(wmsg){
                      self.setTitle(wmsg);
                      self.setContentAppend('</br>');
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
      $('#import').on('click',function(){
        var id="<?php echo $ids; ?>";
        console.log(id);
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
                  var action="Uploadar/do_upload2";
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
                      url: bUrl+'Admin/do_upload3?id='+id+'&ids='+ids+'&type='+type,
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
   });
</script>
