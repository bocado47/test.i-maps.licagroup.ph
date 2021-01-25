<?php
$CI =& get_instance();
$CI->load->model('Lica_m');
$getKind=$CI->Lica_m->getKind();

?>
<style type="text/css">
  th,td{
    text-align: center;
  }
  .dataTables_wrapper .dataTables_paginate .paginate_button
  {
    padding:0px !important;
  }
    .sorting, .sorting_asc, .sorting_desc {
        background : none;
    }
    .right{
    float: right;
    margin: 3px;
  }
  .blackwhite{
    background-color:#C0C0C0 !important;
    color:#000 !important;

  }
  .pointer {cursor: pointer;}
</style>
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Purchase Request</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
          </div>

          <!-- Content Row -->


          <!-- Content Row -->
          <form id="form1" >
             <div class="card" style="height: 100%;">
              <div class="form-group card-body">
              <?php foreach($pr_request as $val){ ?>
                <input type="hidden" name="prid" value="<?php echo $val->Pr_ID; ?>" readonly="readonly">
                <div class="form-row">
                  <div class="col">
                      <label for="txtName" class="control-label col-md-12" style="text-align:left;">Name:</label>
                      <div class="col-md-12" >
                        <input type="text" class="form-control" name="txtName" value="<?php echo $val->Requestor_name; ?>" readonly/>
                      </div>
                  </div>
                  <?php if($val->Status == 'New'){ ?>
                  <div class="col">
                       <label class="control-label col-md-12" style="text-align:left;">Terms:</label>
                       <div class="col-md-12" >
                          <input type="text" class="form-control" name="txtterms" value="" />
                       </div>
                  </div>
                  <div class="col">
                       <label class="control-label col-md-12" style="text-align:left;">Supplier Name:</label>
                       <div class="col-md-12" >
                          <input type="text" class="form-control txtsupplier" name="txtsupplier" id="txtsupplier" value=""/>
                       </div>
                  </div>
                  <div class="col">
                       <label class="control-label col-md-12" style="text-align:left;">Attention To:</label>
                       <div class="col-md-12" >
                          <input type="text" class="form-control txtattention" name="txtattention"  value="" required/>
                       </div>
                  </div>
                  <?php }else{ ?>
                    <div class="col">
                         <label class="control-label col-md-12" style="text-align:left;">Terms:</label>
                         <div class="col-md-12" >
                            <input type="text" class="form-control" name="txtterms" value="<?php echo $val->terms; ?>"/>
                         </div>
                    </div>
                    <div class="col">
                         <label class="control-label col-md-12" style="text-align:left;">Supplier Name:</label>
                         <div class="col-md-12" >
                            <input type="text" class="form-control txtsupplier" name="txtsupplier" id="txtsupplier" value="<?php echo $val->supplier_name; ?>" />
                         </div>
                    </div>
                    <div class="col">
                         <label class="control-label col-md-12" style="text-align:left;">Attention To:</label>
                         <div class="col-md-12" >
                            <input type="text" class="form-control txtattention" name="txtattention"  value="<?php echo $val->attention_to; ?>" />
                         </div>
                    </div>
                  <?php } ?>
                </div>
                <br/>
                <div class="form-row">
                  <div class="col col-md-12">
                    <label class="control-label col-sm-2">Purpose:</label>
                        <div class="col-sm-6">
                          <textarea class="form-control" name='txtpurpose' style="resize: none;" readonly="readonly"><?php echo $val->Pr_Purpose; ?></textarea>
                        </div>
                  </div>
                </div>
              <?php } ?>
              </div>
                  <!--      -->
                <div id="Type">
                  <table id="myTable" class="display table table-sm" data-stripe-classes='[]' style="width:100%">
                        <thead>
                            <tr>
                                <th class="Unclick">Kind</th>
                                <th class="Unclick">Item</th>
                                <th class="Unclick">Order Qty</th>
                                <th class="Unclick">Unit</th>
                                <th class="Unclick">Remaining Qty</th>
                                <th class="Unclick">Remarks</th>
                                <th class="Unclick">Unit Price</th>
                                <th class="Unclick">Amount</th>
                                <th class="Unclick" width="5px;">Option</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="7" class="Unclick" style="text-align:right !important;">Total:</th>
                                <th colspan="2" class="Unclick"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="form-group">
                  <div class="col-md-12">

                  </div>
                  <div class="col-md-12">
                      <a href="<?php echo base_url(); ?>" class="btn btn-danger btn-md right" id="close">Close</a>
                      <?php foreach($pr_request as $val){ ?>
                        <?php if($val->Status == 'New'){ ?>
                          <button type="button" class="btn btn-success btn-md right" value="<?php echo $val->Pr_ID; ?>" id="Approve">Submit</button>
                        <?php }else{ ?>
                            <button type="button" class="btn btn-success btn-md right" value="<?php echo $val->Pr_ID; ?>" id="Edit">Submit</button>
                        <?php } ?>
                      <?php } ?>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
<script type="text/javascript">
  $(document).ready( function () {
      var bUrl="<?php echo base_url(); ?>";
      var id="<?php echo $Pr_ID; ?>";
    //   var availableTags = [
    //   "ActionScript",
    //   "AppleScript",
    //   "Asp",
    //   "BASIC",
    //   "C",
    //   "C++",
    //   "Clojure",
    //   "COBOL",
    //   "ColdFusion",
    //   "Erlang",
    //   "Fortran",
    //   "Groovy",
    //   "Haskell",
    //   "Java",
    //   "JavaScript",
    //   "Lisp",
    //   "Perl",
    //   "PHP",
    //   "Python",
    //   "Ruby",
    //   "Scala",
    //   "Scheme"
    // ];
    // $( ".items" ).autocomplete({
    //   source: availableTags
    // });
      var table=$('#myTable').DataTable({
          "rowReorder": {
              selector: 'td:nth-child(2)'
          },
          "responsive": true,
          "bPrcessing":true,
                "bServerSide":true,
                "bPaginate": false,
                "bInfo" : false,
                "bSortable":false,
                "bFilter": false,
                "searching": false,
                "sServerMethod": "GET",
                "sAjaxSource":bUrl+"Purchaser/item_data?id="+id,
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
                  {"className":"text-center kinds pointer","title":"Double Click To Edit","bSortable":false,"targets":0},
                  {"className":"item text-center pointer","bSortable":false,"targets":1},
                  {"className":"ord_qty text-center pointer","bSortable":false,"targets":2},
                  {"className":"unit text-center pointer","bSortable":false,"targets":3},
                  {"className":"text-center blackwhite","bSortable":false,"targets":4},
                  {"className":"text-center blackwhite","bSortable":false,"targets":5},
                  {"className":"price text-center pointer","bSortable":false,"targets":6},
                  {"className":"text-center blackwhite","bSortable":false,"targets":7},
                  {"className":"text-center","bSortable":false,"targets":8}
                ],
                "drawCallback":function (settings){
                  $(".Unclick").removeClass("ord_qty price blackwhite kinds item unit");
                  $(".ord_qty, .price, .unit, .kinds, .item").on('dblclick',function(e){
                    e.preventDefault();
                    var cl = $(this).attr('class');
                    var id = $(this).parent().attr('class');
                    var val = $(this).html();
                    var main = $(this);
                    var valkind= $(this).parent().find('.kinds').html();
                    // console.log(valkind);
                    tdClick(cl,main,id,val,valkind);
                  });
                  $(".removed").on('click',function(event){
                    event.preventDefault();
                      var id=$(this).val();
                      console.log(id);
                        $.ajax({
                        type:"POST",
                        url:bUrl+"Purchaser/removes",
                        data:"id="+id,
                        beforeSend: function (){
                          $(this).html('loading..');
                        },
                        success: function(){
                          $.alert({
                            type:'red',
                            columnClass:"col-sm-4 col-sm-offset-2",
                            title: '',
                            content: 'Remove Item Success. Thank You.',
                          });
                          table.draw();
                          // location.reload();
                        }
                      });
                  });
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column( 7 )
                        .data()
                        .reduce( function (a, b) {
                            var b=b.substring(1);
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Total over this page
                    pageTotal = api
                        .column( 7, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                     var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display;
                    $( api.column( 7 ).footer() ).html(
                        "<input type='text' class='text-center total' value='₱ "+numFormat(total)+"' name='total' style='    border: 0px !important;' readonly/>"
                    );
            }

    });
    $("#Approve").on('click', function (){
      var ar=$('#form1').serialize();
      var action="Purchaser/purchaseInfoSave";
      var id=$(this).val();
      var total=$('.total').val();

      if ( ! table.data().any() ) {
        $.alert({
          type:'red',
          columnClass:"col-sm-4 col-sm-offset-2",
          title: '',
          content: 'Sorry your table is empty',
        });
        return false;
      }else if($('.txtsupplier').val() == ''){
        $.alert({
          type:'red',
          columnClass:"col-sm-4 col-sm-offset-2",
          title: '',
          content: 'Sorry your Supplier is Empty',
        });
        return false;
      }else if($('.txtattention').val() == ''){
        $.alert({
          type:'red',
          columnClass:"col-sm-4 col-sm-offset-2",
          title: '',
          content: 'Sorry your Atteontion to is Empty',
        });
        return false;
      }else if(total == '₱ 0.00'){
        $.alert({
          type:'red',
          columnClass:"col-sm-4 col-sm-offset-2",
          title: '',
          content: 'Sorry your Total is 0',
        });
        return false;
      }else{
        $.ajax({
                url:bUrl+action,
                type:"POST",
                data:ar,
                success: function(){
                  table.draw();
                  window.open(bUrl+'p/prints?id='+id);
                  window.location.href = bUrl;
                }
            });
      }

    });
    $("#Edit").on('click', function (){
      var ar=$('#form1').serialize();
      var action="Purchaser/purchaseInfoEdit";
      var id=$(this).val();
      if ( ! table.data().any() ) {
        $.alert({
          type:'red',
          columnClass:"col-sm-4 col-sm-offset-2",
          title: '',
          content: 'Sorry your table is empty',
        });
      }else{
        $.ajax({
                url:bUrl+action,
                type:"POST",
                data:ar,
                success: function(){
                  table.draw();
                  window.open(bUrl+'p/prints?id='+id);
                  window.location.href = bUrl;
                }
            });
      }

    });
    function tdClick(cl,main,id,val,valkind)
    {
      cl=cl.split(' ')[1];
        // console.log(cl);

      var txtbox=main;
      var currentVal=main.html();
      var dropdown='<?php echo json_encode($getKind); ?>';
      var record=[];

      if(cl == 'unit')
      {
        var input="<input type='text' class='text-center form-control-xs txtTargetClicked'>";
      }else if(cl == 'kinds'){
        var input="<select id='kinds' class='form-control-xs txtTargetClicked' name='kinds'></select>";
      }else if(cl == 'item'){
        // var input="<select id='items' class='form-control-xs txtTargetClicked' name='items'></select>";
        //   $('#items').select2();
        var input="<input type='text' class='text-center form-control-xs txtTargetClicked items' id='items' autocomplete='on'>";

         $.getJSON(bUrl+"Purchase/getItem?kind="+valkind,function (data) {

            $.each(data, function(index, c) {
                record.push(c.ITEM);
               });

         });
          console.log(record);

      }else{
        var input="<input type='number' class='text-center form-control-xs txtTargetClicked'>";
      }

      txtbox.html(input);
      $( ".items" ).autocomplete({
              source: function(request, response) {
             var results = $.ui.autocomplete.filter(record, request.term);

             response(results.slice(0, 10));
         }
       });

      $(".txtTargetClicked").focus();
      $.each(JSON.parse(dropdown), function(key, value) {
        // console.log(value['Kind']);
           $('#kinds')
               .append($("<option></option>")
                          .attr("value",value['Kind'])
                          .text(value['Kind']));
      });
     // var ccards = "";
      // $.getJSON(bUrl+"Purchase/getItem?kind="+valkind,function (data) {
      //
      //   if (data.length > 0) {
      //     ccards += "<option></option>";
      //     $.each(data, function(index, c) {
      //       ccards += "<option value='"+c.ITEM+"'>"+c.ITEM+"</option>";
      //     });
      //     $('#items').html(ccards);
      //
      // 	 }else{
      // 	        $('#items').html();
      // 	}
      //   });
      if(cl == 'kinds' || cl == 'items')
      {
        // console.log(val);
        if(val == '')
        {
          $(".txtTargetClicked").val('');
        }else{
          $(".txtTargetClicked").val(val);
        }
      }else{
        if(val == 0)
        {
          $(".txtTargetClicked").val('');
        }else{
          $(".txtTargetClicked").val(val);
        }
      }
        $(".txtTargetClicked").on('blue focusout',function () {
          var newVal= $(this).val();
          if(newVal.length > 0)
          {
            if(val != newVal)
            {
              $.ajax({
                type:"POST",
                url:bUrl+"Purchaser/Update",
                data:"id="+id+"&v="+newVal+"&cl="+cl,
                beforeSend: function (){
                  txtbox.html('updating..');
                },
                success: function(){
                  table.draw();
                  console.log('Done');
                }
              });
            }
            else{
              console.log('SAME VALUE');
              txtbox.html(val);
            }
          }
          else{
            txtbox.html(currentVal);
          }
        });
    }
});


</script>
