<!-- Edit Modal HTML -->
{{-- <a href="{{ route('admin.show.single.niche', $niche->id) }}"><i class="material-icons fa fa-eye text-green" title="View Request"></i></a> --}}
<a href="#editNicheModal-{{ $niche->id }}" class="edit" data-toggle="modal"><i class="material-icons fa fa-pencil text-green" data-toggle="tooltip" title="Edit"></i></a>
<a href="{{ route('admin.niche.approved', $niche->id) }}" class="edit"><i class="material-icons fa fa-check text-green" title="Aprrove request"></i></a>
<a href="{{ route('admin.niche.rejected', $niche->id) }}" class="edit"><i class="material-icons fa fa-close text-green" title="reject request"></i></a>
<a href="" class="delete" data-toggle="modal" data-target="#deleteNicheModal-{{ $niche->id }}"><i class="material-icons fa fa-trash text-green" title="Delete a request"></i></a>

<!-- Niche Modal -->

@include('modals.update-niche')
@include('modals.delete-niche')