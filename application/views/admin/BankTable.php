<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
 <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
   <h1 class="h2">Bank Table</h1>
   <div class="btn-toolbar mb-2 mb-md-0">
     <div class="btn-group mr-1">
       <!-- <span data-feather="calendar"></span>Date -->
     </div>
     <div class="btn-group mr-2">
       <button class="btn btn-md btn-outline-secondary" id="apo"><span data-feather="user-plus"></span> Add Bank</button>
     </div>
   </div>
 </div>
 <div class="table-responsive">
   <table class="table table-striped table-sm" id="table">
     <thead>
       <tr>
         <th>Bank Code</th>
         <th>Bank Description</th>
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
var table=$('#table').DataTable({
       "bPrcessing":true,
       "bServerSide":true,
       "sServerMethod": "GET",
       "sAjaxSource":bUrl+"Admin/BankRecord",
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
           {"className":"text-center nwp","bSortable":true,"targets":1}
       ],
       "drawCallback":function (settings){
         $(".btnedit").on('click',function(){
            var id=$(this).val();
            $.alert({
               type:'blue',
               columnClass:"col-sm-6 col-sm-offset-4",
               title: 'Bank View And Edit',
               content: 'url:'+bUrl+'Admin/bank_form2?id='+id,
               buttons:{
                 save:{
                     text:'Update',
                     btnClass: 'btn-green',
                     action:function()
                     {
                       var main=this;
                       var ar=$('#bank_form2').serialize();
                       console.log(ar);
                       var action="Admin/bankeditform";
                       if($('#bank_form2')[0].checkValidity() === false)
                       {
                           $('#bank_form2').addClass('was-validated');

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
                               self.setContent('<font color="green"><center>Update Successfuly!</center></font>');
                               self.setContentAppend('</br>');
                               table.draw();
                               // console.log(wmsg);
                               }).fail(function(){
                               self.setContent('Form Error. Please Try Again Later.');
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
           var action="Admin/delete_bank?id="+id;

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
 title:'Add Bank',
 content:'url:'+bUrl+'Admin/bank_form',
 buttons:
 {
   confirm:
   {
     text: 'Submit',
                   btnClass: 'btn-blue',
                   action: function(){
                       var main=this;
                       var ar=$('#bank_form').serialize();
                       var action="Admin/bankaddform";
                       if($('#bank_form')[0].checkValidity() === false)
                       {
                           $('#bank_form').addClass('was-validated');

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
                               self.setContent('<font color="green"><center>Submit Successfuly!</center></font>');
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
   // next:
   // {
   //  text:'Submit And Create Invoice',
   //  btnClass:'btn-success invoice'
   // },
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
