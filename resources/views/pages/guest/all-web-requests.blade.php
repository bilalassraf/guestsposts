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
                    <h1 class="card-title p-3" style="font-weight:500;font-size:28px !important;">Websites Requests</h1>
                    <div class="float-right mt-3">

                            <a href="{{ route('admin.add.guest.request') }}" class="btn btn-primary bg-white p-2 border-0 " style="font-weight: 600 !important;"><i class="text-green fa fa-plus" style="font-size: 17px;"></i> &nbsp; <span>Add Website</span></a>
                            @if(auth()->user()->type == 'admin')
                                <a href="{{ route('export.excel') }}" class="btn btn-primary bg-white p-2 border-0 " style="font-weight: 600 !important;"><i class="text-green fa fa-download" style="font-size: 17px;"></i> &nbsp; <span>Download Request</span></a>
                                <a href="" class="btn btn-primary bg-white p-2 border-0 " data-toggle="modal" data-target="#importData" style="font-weight: 600 !important;"><i class="text-green fa fa-download" style="font-size: 17px;"></i> &nbsp; <span>Import Data</span></a>
                                <button type="submit" class="btn btn-primary bg-white border-0 delete-selected" style="font-weight: 600 !important; padding:8px;"><i class="text-green fa fa-trash" style="font-size: 17px;"></i><span> Delete Selected</span></button>
                                <a href="#advanceFilter" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseExample" class="btn btn-primary bg-white p-2 border-0" style="font-weight: 600 !important;"><i class="text-green fa fa-plus" style="font-size: 17px;"></i> &nbsp; <span>Advance Filter </span></a>
                            @endif

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-3">
                  <table id="users-table" style="width: 100%;">
                      <thead>
                        <tr>
                            @if (auth()->user()->type == 'admin')
                                <th scope="col">
                                    <input type="checkbox" class="check-all" id="check-all" onClick="toggle(this)" style="margin-left: -8px">
                                    <label for="check-all">&nbsp;&nbsp; Select All</label>
                                </th>
                            @endif
                            <th>Web Name</th>
                            <th>Category</th>
                            <th>Price (Webmaster)</th>
                            <th>Status</th>
                            <th>Updated at</th>
                            @if(auth()->user()->type == 'admin')
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
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

@section('scripts')
<script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script>
<script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('ids[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

$(".range_input").on("input",function(){
    var value = $(this).val();
    var id = $(this).attr('data-id');
    $("#"+id).text(value);
});
var cols =[];
if ('{{ auth()->user()->type }}' == 'admin') {
    cols = [
 
        {data: 'check_box', name:'check_box', "orderable":false,"searchable":false},
        {data: 'web_name', name: 'web_name'},
        {data: 'categories', name: 'categories'},
        {data: 'price', name: 'price'},
        {data: 'status', name: 'status'},
        {data: 'updated_at', name: 'updated_at'},
        {data: 'actions', name: 'actions', "orderable":false,"searchable":false}
    ];
}else{
    cols= [

    {data: 'web_name', name: 'web_name'},
    {data: 'categories', name: 'categories'},
    {data: 'price', name: 'price'},
    {data: 'status', name: 'status'},
    {data: 'updated_at', name: 'updated_at'},
    ];
}

var table = $('#users-table').DataTable({
    serverSide: true,
    ajax: "{{ route('get-web-requests') }}",
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
      var html = '<div class="row" style="width: 100% !important"><div class="col-md-12"><div class="card"><div class="card-body" style="background-color:rgba(36, 41, 57, 0.09);"><div class="row"><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Website Name</h6>'+data.web_name+'</div></div><div class="col-sm-3"><div class="your-details your-details-xs"><h6 class="f-w-600">OutreachCoordinator </h6>'+data.Coordinator+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Webmaster Price</h6>'+data.price+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Status</h6>'+data.status+'</div></div></div><hr> <div class="row"><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Company Price</h6>'+data.company_price+'</div></div><div class="col-sm-3"><div class="your-details your-details-xs"><h6 class="f-w-600">Category </h6>'+data.categories+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Domain Authority</h6>'+data.domain_authority+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Spam Score</h6>'+data.span_score+'</div></div></div><hr><div class="row"><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Domain Rating</h6>'+data.domain_rating+'</div></div><div class="col-sm-2"><div class="your-details your-details-xs"><h6 class="f-w-600">Organic Traffic  (Ahrefs)</h6>'+data.organic_trafic_ahrefs+'</div></div><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Orgainic Traffic (Sem)</h6>'+data.organic_trafic_sem+'</div></div><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Trust Flow</h6>'+data.trust_flow+'</div></div><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Citation Flow</h6>'+ data.citation_flow +'</div></div><div class="col-sm-2"><div class="your-details your-details-xs"><h6 class="f-w-600">Email (Webmaster)</h6>'+ data.email_webmaster +'</div></div></div><hr><div class="row"><div class="col-sm-6"><div class="your-details your-details-xs"><h6 class="f-w-600">Website Description</h6>'+data.web_description+'</div></div><div class="col-sm-6"><div class="your-details your-details-xs"><h6 class="f-w-600">Special Note</h6>'+ data.special_note+'</div></div></div> </div></div></div></div>';
        row.child( html  ).show();
        tr.addClass('shown');
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
            url: "{{ route('admin.delete.selected.request') }}",
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
