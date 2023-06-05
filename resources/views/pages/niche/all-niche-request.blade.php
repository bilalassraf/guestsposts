@extends('layouts.default')
@section('title')
Show Niche
@endsection
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="content-wrapper p-5">
    @include('filter')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('admin.delete.selected.niches') }}" id="delete_form">
                @csrf
                <div class="card">
                    <div class="card-header bg-green text-white">
                        <h1 class="card-title p-3" style="font-weight:500;font-size:28px !important;">Niches
                        </h1>
                        <div class="float-right mt-3">
                            <a href="{{ route('admin.add.niche') }}" class="btn btn-primary bg-white p-2 border-0 " style="font-weight: 600 !important;"><i class="text-green fa fa-plus" style="font-size: 17px;"></i> &nbsp; <span>Add Niche</span></a>
                            <button type="submit" class="btn btn-primary bg-white border-0 " style="font-weight: 600 !important; padding:8px;"><i class="text-green fa fa-trash" style="font-size: 17px;"></i><span> Delete Selected</span></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-3">
                        <table class="table" id="users-table" style="width: 100%;">
                            <thead>
                                <tr>
                                    @if (auth()->user()->type == 'Admin' || in_array('Check Box',$user_permissions))
                                        <th scope="col">
                                            <input type="checkbox" class="check-all" id="check-all" onClick="toggle(this)" style="margin-left: -8px">
                                            <label for="check-all">&nbsp;&nbsp; Select All</label>
                                        </th>
                                    @endif
                                    @if (auth()->user()->type == 'Admin' || in_array('Website Name',$user_permissions))
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
                                    @if(auth()->user()->type == 'Admin' || in_array('niche_actions',$user_permissions))
                                        <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
            </form>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
</div>
@include('modals.add-user')
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

var detailUrl = "{{url('get/niche/details')}}";
var cols =[];
if ('{{ auth()->user()->type }}' == 'Admin') {
    cols = [

        {data: 'check_box', name:'check_box', "orderable":false,"searchable":false},
        {data: 'less_web_name', name: 'web_name'},
        {data: 'less_coodinator', name: 'coordinator'},
        {data: 'less_price', name: 'price'},
        {data: 'less_categories', name: 'categories'},
        {data: 'less_domain_rating', name: 'domain_rating' },
        {data: 'less_domain_authority', name: 'domain_authority' },
        {data: 'less_organic_trafic_ahrefs', name: 'organic_trafic_ahrefs' },
        {data: 'check_client_status', name: 'status'},
        {data: 'updated_at', name: 'updated_at'},
        {data: 'niche_actions', name: 'niche_actions', "orderable":false,"searchable":false}
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
        {data: 'check_client_status', name: 'status'},
    @endif
        {data: 'updated_at', name: 'updated_at'},
    @if( in_array('niche_actions',$user_permissions))
        {data: 'niche_actions', name: 'niche_actions', "orderable":false,"searchable":false}
    @endif
    ];
}
var table = $('#users-table').DataTable({
    serverSide: true,
    order:[[3, 'desc']],
    ajax: "{{ route('get-niche-requests') }}",
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
         html = '<div class="row" style="width: 100% !important"><div class="col-md-12"><div class="card"><div class="card-body" style="background-color:rgba(36, 41, 57, 0.09);"><div class="row"><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Website Name</h6>'+data.less_web_name+'</div></div><div class="col-sm-3"><div class="your-details your-details-xs"><h6 class="f-w-600">OutreachCoordinator </h6>'+data.less_coodinator+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Webmaster Price</h6>'+data.less_price+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Status</h6>'+data.status+'</div></div></div><hr> <div class="row"><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Company Price</h6>'+data.company_price+'</div></div><div class="col-sm-3"><div class="your-details your-details-xs"><h6 class="f-w-600">Category </h6>'+data.less_categories+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Domain Authority</h6>'+data.less_domain_authority+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Spam Score</h6>'+data.less_span_score+'</div></div></div><hr><div class="row"><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Domain Rating</h6>'+data.less_domain_rating+'</div></div><div class="col-sm-2"><div class="your-details your-details-xs"><h6 class="f-w-600">Organic Traffic  (Ahrefs)</h6>'+data.less_organic_trafic_ahrefs+'</div></div><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Orgainic Traffic (Sem)</h6>'+data.less_organic_trafic_sem+'</div></div><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Trust Flow</h6>'+data.less_trust_flow+'</div></div><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Citation Flow</h6>'+ data.less_citation_flow +'</div></div><div class="col-sm-2"><div class="your-details your-details-xs"><h6 class="f-w-600">Email (Webmaster)</h6>'+ data.less_email +'</div></div></div><hr><div class="row"><div class="col-sm-6"><div class="your-details your-details-xs"><h6 class="f-w-600">Website Description</h6>'+data.less_web_description+'</div></div><div class="col-sm-6"><div class="your-details your-details-xs"><h6 class="f-w-600">Special Note</h6>'+ data.less_special_note+'</div></div></div> </div></div></div></div>';
         row.child( html ).show();
        tr.addClass('shown');
        }else{
        $.ajax({
        url: detailUrl+'/'+data.id,
        type:"get",
        success:function(data1){
            console.log('hhihi');
            row.child( data1 ).show();
            tr.addClass('shown');
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
