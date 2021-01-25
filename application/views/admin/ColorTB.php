<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
 <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
   <h1 class="h2">Model Color Table</h1>
   <div class="btn-toolbar mb-2 mb-md-0">
     <div class="btn-group mr-1">
       <!-- <span data-feather="calendar"></span>Date -->
     </div>
     <div class="btn-group mr-2">
       <button class="btn btn-md btn-outline-secondary" id="apo"><span data-feather="user-plus"></span>Add Model Color</button>
     </div>
   </div>
 </div>
 <div class="table-responsive">
   <table class="table table-striped table-sm" id="table">
     <thead>
       <tr>
         <th>Brand</th>
         <th>Model</th>
         <th>Color</th>
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
// var table=$('#table').DataTable();
// ModelCRecord
var table=$('#table').DataTable({
       "bPrcessing":true,
       "bServerSide":true,
       "sServerMethod": "GET",
       "sAjaxSource":bUrl+"Admin/ModelCRecord",
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
           {"className":"text-center nwp","bSortable":true,"targets":2},
           {"className":"text-center nwp","bSortable":true,"targets":3}
       ],
       "drawCallback":function (settings){
         $(".btnedit").on('click',function(){
            var id=$(this).val();
            $.alert({
               type:'blue',
               columnClass:"col-sm-6 col-sm-offset-4",
               title: 'Model Color View And Edit',
               content: 'url:'+bUrl+'Admin/coloreditform?id='+id,
               buttons:{
                 save:{
                     text:'Update',
                     btnClass: 'btn-green',
                     action:function()
                     {
                       var main=this;
                       var ar=$('#color_form_e').serialize();
                       console.log(ar);
                       var action="Admin/updatecolor";
                       if($('#color_form_e')[0].checkValidity() === false)
                       {
                           $('#color_form_e').addClass('was-validated');

                           return false;
                       }
                       $.alert({
                           title:"Form",
                           type:"green",
                           content:function(){
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
                                      return $.ajax({
                                      url:bUrl+action,
                                      type:"POST",
                                      data:ar,
                                      }).done(function(wmsg){
                                      self.setContent('<font color="green"><center>Submit Successfuly!</center></font>');
                                      self.setContentAppend('</br>');
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
           var action="Admin/delete_color?id="+id;

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
       }
});
$('#apo').on('click',function(){
 $.alert({
 type:'green',
 columnClass:"col-sm-8 col-sm-offset-2",
 title:'Add Model Color',
 content:'url:'+bUrl+'Admin/form_m_color',
 buttons:
   {
     confirm:
     {
       text: 'Submit',
                     btnClass: 'btn-blue',
                     action: function(){
                         var main=this;
                         var ar=$('#model_c_form').serialize();
                         var action="Admin/add_model_color";
                         if($('#model_c_form')[0].checkValidity() === false)
                         {
                             $('#model_c_form').addClass('was-validated');

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
});
</script>
