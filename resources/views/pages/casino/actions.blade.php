<!-- Edit Modal HTML -->
<a href="#editRequestModal-{{ $request->id }}" class="edit" data-toggle="modal">
    <i class="material-icons fa fa-pencil text-green" data-toggle="tooltip" title="Edit"></i>
</a>

<a href="javascript:void(0);" onclick="sendAjaxRequest('{{route('admin.casino.request.approved', $request->id)}}', {{ $request->id }});" class="edit">
    <i class="material-icons fa fa-check text-green"></i>
</a>
<a href="javascript:void(0);" onclick="sendAjaxRequest('{{route('admin.casino.request.rejected', $request->id)}}', {{ $request->id }});" class="edit">
    <i class="material-icons fa fa-close text-green" title="reject request"></i>
</a>
{{-- <a href="javascript:void(0);" class="edit" onclick="sendAjaxRequest('{{ route('admin.casino.request.good', $request->id) }}', {{ $request->id }});">    
  <i class="material-icons fa fa-check-circle text-success" title="Good Request"></i>
</a> --}}
<a href="{{ route('admin.single.casino.request.spam', $request->id) }}" class="edit">    
  <i class="material-icons fa fa-user-secret text-danger" title="Spam Request"></i>
</a>
<a href="#" class="delete" data-toggle="modal" data-target="#deleteGuestModal-{{ $request->id }}"><i class="material-icons fa fa-trash text-green" title="Delete a request"></i></a>
@include('modals.delete-casino-request')
@include('modals.update-casino')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
  function sendAjaxRequest(route, nicheId) {
    // Prepare the data to be sent
    var data = {
      casino_id: nicheId
    };
  
    // Send the AJAX request
    $.ajax({
      url: route,
      type: 'get',
      data: JSON.stringify(data),
      contentType: 'application/json',
      success: function(response) {
        if (response.success === 'Approved') {
            toastr.success('Request has been approved');
        } else if (response.info === 'Already Approved') {
            toastr.info('Request is Already Approved');
        }else if (response.success === 'Requests Rejected') {
            toastr.success('Request has been Rejected');
        }else if (response.info === 'Already Rejected') {
            toastr.info('Request is Already Rejected');
        }else if(response.success == 'Good Request'){
            toastr.success('Request has been Good Site');
        }else if(response.info == 'Already Good Request'){
            toastr.success('Request is Already Good Site');
        }else if(response.success == 'Spam Request'){
            toastr.success('Request has been added to Spam Request');
        }else if(response.info == 'Already Spam Request'){
            toastr.info('Already in Spam Request');
        }else {
            // Handle other response scenarios
            console.log(response);
        }
      },
      error: function(xhr, status, error) {
        // Request failed, handle the error
        console.error('Request failed. Status:', status, 'Error:', error);
      }
    });
  }
</script>