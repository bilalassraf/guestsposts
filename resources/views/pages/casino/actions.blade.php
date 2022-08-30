<!-- Edit Modal HTML -->
<a href="#editRequestModal-{{ $request->id }}" class="edit" data-toggle="modal">
    <i class="material-icons fa fa-pencil text-green" data-toggle="tooltip" title="Edit"></i>
</a>
<a href="{{ route('admin.casino.request.approved', $request->id) }}" class="edit">
    <i class="material-icons fa fa-check text-green"></i>
</a>
<a href="{{ route('admin.casino.request.rejected', $request->id) }}">
    <i class="material-icons fa fa-close text-green" title="reject request"></i>
</a>
<a href="#" class="delete" data-toggle="modal" data-target="#deleteGuestModal-{{ $request->id }}"><i class="material-icons fa fa-trash text-green" title="Delete a request"></i></a>
@include('modals.delete-casino-request')
@include('modals.update-casino')
