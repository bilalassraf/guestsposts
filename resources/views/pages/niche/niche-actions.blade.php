<!-- Edit Modal HTML -->
{{-- <a href="{{ route('admin.show.single.niche', $niche->id) }}"><i class="material-icons fa fa-eye text-green" title="View Request"></i></a> --}}
<a href="#editNicheModal-{{ $niche->id }}" class="edit" data-toggle="modal"><i class="material-icons fa fa-pencil text-green" data-toggle="tooltip" title="Edit"></i></a>
<a href="javascript:void(0);" class="edit" onclick="sendAjaxRequest('{{ route('admin.niche.approved', $niche->id) }}', {{ $niche->id }});">
    <i class="material-icons fa fa-check text-green" title="Approve request"></i>
</a>
<a href="javascript:void(0);" class="edit" onclick="sendAjaxRequest('{{ route('admin.niche.rejected', $niche->id) }}', {{ $niche->id }});">    
    <i class="material-icons fa fa-close text-green" title="Reject request"></i>
</a>
<a href="javascript:void(0);" class="edit" onclick="sendAjaxRequest('{{ route('admin.niche.good', $niche->id) }}', {{ $niche->id }});">    
    <i class="material-icons fa fa-check-circle text-success" title="Good Request"></i>
</a>
<a href="javascript:void(0);" class="edit" onclick="sendAjaxRequest('{{ route('admin.niche.spam', $niche->id) }}', {{ $niche->id }});">    
    <i class="material-icons fa fa-user-secret text-waring" title="Spam Request"></i>
</a>
<a href="" class="delete" data-toggle="modal" data-target="#deleteNicheModal-{{ $niche->id }}"><i class="material-icons fa fa-trash text-green" title="Delete a request"></i></a>

<!-- Niche Modal -->

@include('modals.update-niche')
@include('modals.delete-niche')
  
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
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
        if (response.success === 'Approved') {
            toastr.success('Request has been approved');
        } else if (response.info === 'Already Approved') {
            toastr.info('Request is Already Approved');
        }else if (response.success === 'Rejected') {
            toastr.success('Request has been Rejected');
        }else if (response.info === 'Already Rejected') {
            toastr.info('Request is Already Rejected');
        }else if(response.success == 'Good Request'){
            toastr.success('Niche added to Good Request');
        }else if(response.info == 'Already Good Request'){
            toastr.success('Niche Already in Good Request');
        }else if(response.success == 'Spam Request'){
            toastr.success('Niche added to Spam Request');
        }else if(response.info == 'Already Spam Request'){
            toastr.info('Niche Already in Spam Request');
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
  