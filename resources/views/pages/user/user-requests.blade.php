@extends('layouts.default')
@section('user')
<div class="content-wrapper p-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="width: 100% !important;">
            <div class="card-header bg-green border-0">
                <h1 class="card-title ">Users Information</h1>
                <div class="float-right mt-3">
                    {{-- <a href="{{ route('addWeb') }}" class="btn btn-primary bg-white p-2 border-0 " style="font-weight: 600 !important;"><i class="text-green fa fa-plus" style="font-size: 17px;"></i> &nbsp; <span>Add Website</span></a> --}}
                </div>
            </div>
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
                          @if (auth()->user()->type == 'Admin' || in_array('Coordinator',$user_permissions))
                              <th>Outreach Coordinator</th>
                          @endif
                          @if (auth()->user()->type == 'Admin' || in_array('Price',$user_permissions))
                          <th>Price (Webmaster)</th>
                          @endif
                          @if (auth()->user()->type == 'Admin' || in_array('Categories',$user_permissions))
                          <th>Category</th>
                          @endif
                          @if (auth()->user()->type == 'Admin' || in_array('price',$user_permissions))
                              <th>Domain Rating</th>
                              <th>Organic Traffic (Ahrefs)</th>
                          @endif
                          @if (auth()->user()->type == 'Admin' || in_array('Status',$user_permissions))
                          <th>Status</th>
                          @endif
                          <th>Updated at</th>
                          @if(auth()->user()->type == 'Admin' || in_array('updated at',$user_permissions))
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
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

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
var detailUrl = "{{url('get/details')}}";
$(".range_input").on("input",function(){
    var value = $(this).val();
    var id = $(this).attr('data-id');
    $("#"+id).text(value);
});
var cols =[];
if ('{{ auth()->user()->type }}' == 'Admin') {
    cols = [
        {data: 'check_box', name:'check_box', "orderable":false,"searchable":false},
        {data: 'web_name', name: 'web_name'},
        {data: 'Coordinator', name: 'Coordinator'},
        {data: 'price', name: 'price'},
        {data: 'categories', name: 'categories'},
        {data: 'domain_rating', name: 'domain_rating' },
        {data: 'organic_trafic_ahrefs', name: 'organic_trafic_ahrefs' },
        {data: 'status', name: 'status'},
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
      var html = "";

      if ('{{ auth()->user()->type }}' == 'Admin') {
         html = '<div class="row" style="width: 100% !important"><div class="col-md-12"><div class="card"><div class="card-body" style="background-color:rgba(36, 41, 57, 0.09);"><div class="row"><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Website Name</h6>'+data.web_name+'</div></div><div class="col-sm-3"><div class="your-details your-details-xs"><h6 class="f-w-600">OutreachCoordinator </h6>'+data.Coordinator+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Webmaster Price</h6>'+data.price+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Status</h6>'+data.status+'</div></div></div><hr> <div class="row"><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Company Price</h6>'+data.company_price+'</div></div><div class="col-sm-3"><div class="your-details your-details-xs"><h6 class="f-w-600">Category </h6>'+data.categories+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Domain Authority</h6>'+data.domain_authority+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Spam Score</h6>'+data.span_score+'</div></div></div><hr><div class="row"><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Domain Rating</h6>'+data.domain_rating+'</div></div><div class="col-sm-2"><div class="your-details your-details-xs"><h6 class="f-w-600">Organic Traffic  (Ahrefs)</h6>'+data.organic_trafic_ahrefs+'</div></div><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Orgainic Traffic (Sem)</h6>'+data.organic_trafic_sem+'</div></div><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Trust Flow</h6>'+data.trust_flow+'</div></div><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Citation Flow</h6>'+ data.citation_flow +'</div></div><div class="col-sm-2"><div class="your-details your-details-xs"><h6 class="f-w-600">Email (Webmaster)</h6>'+ data.email_webmaster +'</div></div></div><hr><div class="row"><div class="col-sm-6"><div class="your-details your-details-xs"><h6 class="f-w-600">Website Description</h6>'+data.web_description+'</div></div><div class="col-sm-6"><div class="your-details your-details-xs"><h6 class="f-w-600">Special Note</h6>'+ data.special_note+'</div></div></div> </div></div></div></div>';
         row.child( html  ).show();
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
      var html = '<div class="row" style="width: 100% !important"><div class="col-md-12"><div class="card"><div class="card-body" style="background-color:rgba(36, 41, 57, 0.09);"><div class="row"><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Website Name</h6>'+data.web_name+'</div></div><div class="col-sm-3"><div class="your-details your-details-xs"><h6 class="f-w-600">OutreachCoordinator </h6>'+data.Coordinator+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Webmaster Price</h6>'+data.price+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Status</h6>'+data.status+'</div></div></div><hr> <div class="row"><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Company Price</h6>'+data.company_price+'</div></div><div class="col-sm-3"><div class="your-details your-details-xs"><h6 class="f-w-600">Category </h6>'+data.category+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Domain Authority</h6>'+data.domain_authority+'</div></div><div class="col-sm-3"><div class="your-details"><h6 class="f-w-600">Spam Score</h6>'+data.span_score+'</div></div></div><hr><div class="row"><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Domain Rating</h6>'+data.domain_rating+'</div></div><div class="col-sm-2"><div class="your-details your-details-xs"><h6 class="f-w-600">Organic Traffic  (Ahrefs)</h6>'+data.organic_trafic_ahrefs+'</div></div><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Orgainic Traffic (Sem)</h6>'+data.organic_trafic_sem+'</div></div><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Trust Flow</h6>'+data.trust_flow+'</div></div><div class="col-sm-2"><div class="your-details"><h6 class="f-w-600">Citation Flow</h6>'+ data.citation_flow +'</div></div><div class="col-sm-2"><div class="your-details your-details-xs"><h6 class="f-w-600">Email (Webmaster)</h6>'+ data.email_webmaster +'</div></div></div><hr><div class="row"><div class="col-sm-6"><div class="your-details your-details-xs"><h6 class="f-w-600">Website Description</h6>'+data.web_description+'</div></div><div class="col-sm-6"><div class="your-details your-details-xs"><h6 class="f-w-600">Special Note</h6>'+ data.special_note+'</div></div></div> </div></div></div></div>';
        row.child( html  ).show();
        tr.addClass('shown');
    }
});
</script>
@endsection
