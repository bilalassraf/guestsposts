@extends('layouts.default')
@section('title')
    Spam Website
@endsection
@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="content-wrapper p-5">
        @include('filter')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-green text-white">
                        <h1 class="card-title p-3" style="font-weight:700;font-size:32px !important;">Spam Requests</h1>
                        <div class="text-right mt-3">
                            
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    @if(auth()->user()->type == 'Admin')
                                        <th scope="col">
                                            <input type="checkbox" class="check-all" id="check-all" onClick="toggle(this)">
                                            Select All
                                        </th>
                                    @endif
                                    <th>#id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Description</th>
                                    <th>Pending Requests</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $guest)
                                     <tr>
                                        @if(auth()->user()->type == 'Admin')
                                            <td>
                                                <input type="checkbox" name="check_box" class="sub_chk" value="{{ $guest->id }}">
                                            </td>
                                        @endif 
                                        <td>{{ $guest->id }}</td>
                                        <td><i class="material-icons fa fa-user-secret text-danger" title="Bad Request"></i> {{ $guest->web_name }}</td>
                                        <td>{{ $guest->email_webmaster }}</td>
                                        <td>{{ $guest->coodinator->type ?? "" }}</td>
                                        <td>{{ Str::limit($guest->web_description, 50, ' (...)') }}</td>
                                        <td>{{ $guest->status }}</td>
                                        <td>
                                            <a href="#"
                                                onclick="sendAjaxRequest('{{route('admin.casino.request.unspam', $guest->id)}}', {{ $guest->id }});"
                                                class="edit"><i class="material-icons fa fa-undo text-green"
                                                    title="Restore Spam Requet"></i></a>
                                            <a href="{{ route('admin.delete.permanently.casino', $guest->id) }}"
                                                class="edit"><i class="material-icons fa fa-trash text-green"
                                                    title="Delete Request permanently"></i>
                                            </a>
                                        </td>
                                    </tr>
                                     </tbody>
                                @empty
                                    <td><p class="text-bold">{{$empty_message}}</p></td>
                                @endforelse

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@section('scripts')    

<script language="JavaScript">

  function sendAjaxRequest(route, nicheId) {
    // Prepare the data to be sent
    var data = {
      niche_id: nicheId
    };
  
    // Send the AJAX request
    $.ajax({
      url: route,
      type: 'get',
      data: JSON.stringify(data),
      contentType: 'application/json',
      success: function(response) {
        if (response.success === 'Un-Spam Request') {
            toastr.success('Request has been Un-spam');
        }else {
            console.log(response);
        }
      },
      error: function(xhr, status, error) {
        console.error('Request failed. Status:', status, 'Error:', error);
      }
    });
  }

    function toggle(source) {
        checkboxes = document.getElementsByName('check_box');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
    }

    
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
</script>

@endsection