@extends('layouts.default')
@section('title')
Show Website
@endsection
@section('content')
@include('filter')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="content-wrapper p-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-green text-white">
                    <h1 class="card-title p-3" style="font-weight:500;font-size:28px !important;">Websites</h1>
                    <div class="float-right mt-3">
                        @if (auth()->user()->type == 'Admin')
                            <button class="btn btn-primary bg-white p-2 border-0 selected-spam" type="button" style="font-weight: 600 !important;"><i class="text-green fa fa-plus" style="font-size: 17px;"></i> &nbsp; <span>Mark to Spam</span></button>
                        @endif  
                        {{--<a href="{{ route('admin.add.guest.request') }}" class="btn btn-primary bg-white p-2 border-0 " style="font-weight: 600 !important;"><i class="text-green fa fa-plus" style="font-size: 17px;"></i> &nbsp; <span>Add Website</span></a> --}}
                        @if(auth()->user()->type == 'Admin' || in_array('Approved Data',$user_permissions))
                            <button type="submit" class="btn btn-primary bg-white border-0 approved-selected" style="font-weight: 600 !important; padding:8px;"><i class="text-green fa fa-check" style="font-size: 17px;"></i><span>Approve All</span></button>
                        @endif
                        @if(auth()->user()->type == 'Admin' || in_array('Download Request',$user_permissions))
                            <a href="{{ route('export.excel') }}" class="btn btn-primary bg-white p-2 border-0 " style="font-weight: 600 !important;"><i class="text-green fa fa-download" style="font-size: 17px;"></i> &nbsp; <span>Download</span></a>
                        @endif
                        @if(auth()->user()->type == 'Admin' || in_array('Import Data',$user_permissions))
                            <a href="" class="btn btn-primary bg-white p-2 border-0 " data-toggle="modal" data-target="#importData" style="font-weight: 600 !important;"><i class="text-green fa fa-download" style="font-size: 17px;"></i> &nbsp; <span>Import</span></a>
                        @endif
                        @if(auth()->user()->type == 'Admin' || in_array('Delete Data',$user_permissions))
                            <button type="submit" class="btn btn-primary bg-white border-0 delete-selected" style="font-weight: 600 !important; padding:8px;"><i class="text-green fa fa-trash" style="font-size: 17px;"></i><span>Delete</span></button>
                        @endif
                        @if(auth()->user()->type == 'Admin' || in_array('Advance Filter',$user_permissions))
                            <a href="#advanceFilter" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseExample" class="btn btn-primary bg-white p-2 border-0" style="font-weight: 600 !important;"><i class="text-green fa fa-plus" style="font-size: 17px;"></i> &nbsp; <span>Advance Filter </span></a>
                            <button  onClick="window.location.reload();" class="btn btn-primary bg-white p-2 border-0" style="font-weight: 600 !important;"><i class="text-green fa fa-refresh" style="font-size: 17px;"></i> &nbsp; <span>Reset Filter </span></button>
                        @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-3">
                  <table id="users-table" style="width: 100%;">
                    <thead>
                        <tr>
                            @if(auth()->user()->type == 'Admin' || in_array('Check Box',$user_permissions))
                            <th scope="col">
                                <input type="checkbox" class="check-all" id="check-all" onClick="toggle(this)" style="margin-left: -8px">
                                <label for="check-all">&nbsp;&nbsp; Select All</label>
                            </th>
                            @endif
                            @if(auth()->user()->type == 'Admin' || in_array('Website Name',$user_permissions))
                            <th>Web Name</th>
                            @endif
                            @if (auth()->user()->type == 'Admin' || in_array('coordinator',$user_permissions))
                                <th>Outreach Coordinator</th>
                            @endif
                            @if (auth()->user()->type == 'Admin' || in_array('Price',$user_permissions))
                            <th>Price (Webmaster)</th>
                            @endif
                            @if (auth()->user()->type == 'Admin' || in_array('Categories',$user_permissions))
                            <th>Category</th>
                            @endif
                            @if (auth()->user()->type == 'Admin')
                                <th>Domain Rating</th>
                                <th>Domain Authority</th>
                                <th>Organic Traffic (Ahrefs)</th>
                            @endif
                            @if (auth()->user()->type == 'Admin' || in_array('Status',$user_permissions))
                            <th>Status</th>
                            @endif
                            <th>Updated at</th>
                            @if(auth()->user()->type == 'Admin' || in_array('action',$user_permissions))
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                               <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="myModalLabel"> API CODE </h4>
                                </div>
                                <div class="modal-body" id="getCode" style="overflow-x: scroll;">
                                   //ajax success content here.
                                </div>
                             </div>
                            </div>
                          </div>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modals.add-user')
@include('modals.import-data')
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
@section('scripts')

<script>
    function showModal(id) {
        $('#newPriceModel-'+id).hide('#newPriceModel');
        var price = $('#update_price'+id).val();
        $('#new_price'+id).val(price);
        $('#myModal-'+id).show('#myModal');
    }
    $(document).ready(function() {
        $(".allow-numeric").bind("keypress", function (e) {
            var keyCode = e.which ? e.which : e.keyCode

            if (!(keyCode >= 48 && keyCode <= 57)) {
                $(".error").css("display", "inline");
                return false;
            }else{
                $(".error").css("display", "none");
            }
        });
    });
</script>
<script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script>
<script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('ids[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
var detailUrl = "{{url('details/casino')}}";
$(".range_input").on("input",function(){
    var value = $(this).val();
    var id = $(this).attr('data-id');
    $("#"+id).text(value);
});
var cols =[];
if ('{{ auth()->user()->type }}' == 'Admin') {
    cols = [
        {data: 'check_box', name:'check_box', "orderable":false,"searchable":false},
        {
            "data": "web_name",
            "name": "web_name",
            "render": function(data, type, row) {
                if (row.check_status === 'Good Request') {
                    return '<i class="material-icons fa fa-check-circle text-success" title="Good Request"></i> ' + data;
                } else if (row.check_status === 'Black Hat') {
                    return '<i class="material-icons fas fa-hat-cowboy text-dark" title="Bad Request"></i> ' + data;
                } else {
                    return data;
                }
            }
        },
        {data: 'less_coodinator', name: 'coordinator'},
        {data: 'price', name: 'price'},
        {data: 'less_categories', name: 'categories'},
        {data: 'less_domain_rating', name: 'domain_rating' },
        {data: 'less_domain_authority', name: 'domain_authority' },
        {data: 'less_organic_trafic_ahrefs', name: 'organic_trafic_ahrefs' },
        {data: 'less_status', name: 'status'},
        {data: 'updated_at', name: 'updated_at'},
        {data: 'actions', name: 'actions', "orderable":false,"searchable":false}
    ];
}else{
    cols= [
    @if( in_array('Check Box',$user_permissions))
        {data: 'check_box', name:'check_box', "orderable":false,"searchable":false},
    @endif
    @if( in_array('Website Name',$user_permissions))
        {data: 'web_name', name: 'web_name'},
    @endif
    @if( in_array('Price',$user_permissions))
        {data: 'price', name: 'price'},
    @endif
    @if( in_array('Categories',$user_permissions))
        {data: 'categories', name: 'categories'},
    @endif
    @if( in_array('Status',$user_permissions))
    {   data: 'status', name: 'status'},
    @endif
        {data: 'updated_at', name: 'updated_at'},
    @if( in_array('action',$user_permissions))
    {data: 'actions', name:'action', "orderable":false,"searchable":false},
    @endif
    ];
}
var table = $('#users-table').DataTable({
    serverSide: true,
    order:[[3, 'desc']],
    ajax: "{{ route('get-casino-requests') }}",
    columns:cols,
});
// Add event listener for opening and closing details
$('#users-table tbody').on('click', '.detail', function () {

    var tr = $(this).closest('tr');
    var row = table.row( tr );

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
      var data = row.data();
      var html = "";

      if ('{{ auth()->user()->type }}' == 'Admin') {
        html = '<div class="row" style="width: 100% !important"><div class="col-md-12"><div class="card"><div class="card-body" style="background-color:rgba(36, 41, 57, 0.09);"><div class="row"><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Website Name</h6>'+data.web_name+'</div></div><div class="col-sm-3"><div class="your-details your-details-xs"><h6 class="f-w-600">OutreachCoordinator </h6>'+data.less_coodinator+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Webmaster Price</h6>'+data.less_price+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Status</h6>'+data.status+'</div></div></div><hr> <div class="row"><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Company Price</h6>'+data.less_company_price+'</div></div><div class="col-sm-3"><div class="your-details your-details-xs"><h6 class="f-w-600">Category </h6>'+data.less_categories+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Domain Authority</h6>'+data.less_domain_authority+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Spam Score</h6>'+data.less_span_score+'</div></div></div><hr><div class="row"><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Domain Rating</h6>'+data.less_domain_rating+'</div></div><div class="col-sm-2"><div class="your-details your-details-xs"><h6 class="f-w-600">Organic Traffic  (Ahrefs)</h6>'+data.less_organic_trafic_ahrefs+'</div></div><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Orgainic Traffic (Sem)</h6>'+data.less_organic_trafic_sem+'</div></div><div class="col-sm-2"><div class="your-details your-details-xs"><h6 class="f-w-600">Email (Webmaster)</h6>'+ data.less_email +'</div></div></div><hr><div class="row"><div class="col-sm-6"><div class="your-details your-details-xs"><h6 class="f-w-600">Website Description</h6>'+data.less_web_description+'</div></div><div class="col-sm-6"><div class="your-details your-details-xs"><h6 class="f-w-600">Special Note</h6>'+ data.less_special_note+'</div></div></div> </div></div></div></div>';
        row.child( html  ).show();
        tr.addClass('shown');
        }else{
        $.ajax({
        url: detailUrl+'/'+data.id,
        type:"get",
        success:function(data1){
            row.child( data1 ).show();
            tr.addClass('shown');
        }
      });
      }
    }
});

$('.approved-selected').on('click', function(e) {
    var allVals = [];
    $(".sub_chk:checked").each(function() {
       allVals.push($(this).val());
    });
    if(allVals.length <=0){
       alert("Please select row.");
    }  else {
    var check = confirm("Are you sure you want to approved this row?");
    if(check == true){

        var join_selected_values = allVals.join(",");
        $.ajax({
            url: "{{ route('admin.approved.selected.request') }}",
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: 'ids='+join_selected_values,
            success: function (data) {
                if (data['success']) {
                    $(".sub_chk:checked").each(function() {
                        $(this).parents("tr").remove();
                    });
                    alert(data['success']);
                    table.draw();
                    //location.reload();
                } else if (data['error']) {
                    alert(data['error']);
                } else {
                    alert('Whoops Something went wrong!!');
                }
            },
            error: function (data) {
                alert(data.responseText);
            }
        });
    }
}
});

$('.delete-selected').on('click', function(e) {
    var allVals = [];
    $(".sub_chk:checked").each(function() {
       allVals.push($(this).val());
    });
    if(allVals.length <=0){
       alert("Please select row.");
    }  else {
    var check = confirm("Are you sure you want to delete this row?");
    if(check == true){

        var join_selected_values = allVals.join(",");

        $.ajax({
            url: "{{ route('admin.delete.selected.casino') }}",
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: 'ids='+join_selected_values,
            success: function (data) {
                if (data['success']) {
                    $(".sub_chk:checked").each(function() {
                        $(this).parents("tr").remove();
                    });
                    alert(data['success']);
                    table.draw();
                    //location.reload();
                } else if (data['error']) {
                    alert(data['error']);
                } else {
                    alert('Whoops Something went wrong!!');
                }
            },
            error: function (data) {
                alert(data.responseText);
            }
        });
    }
}
});

$('.selected-spam').on('click', function(e) {
    var allVals = [];
    $(".sub_chk:checked").each(function() {
       allVals.push($(this).val());
    });
    if(allVals.length <=0){
       alert("Please select row.");
    }  else {
    var check = confirm("Are you sure you want to spam this row?");
        if(check == true){

            var join_selected_values = allVals.join(",");

            $.ajax({
                url: "{{ route('admin.casino.request.spam') }}",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: 'ids='+join_selected_values,
                success: function (data) {
                    if (data['success']) {
                        $(".sub_chk:checked").each(function() {
                            $(this).parents("tr").remove();
                        });
                        alert(data['success']);
                        table.draw();
                        //location.reload();
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });
        }
    }
});
</script>
@endsection
