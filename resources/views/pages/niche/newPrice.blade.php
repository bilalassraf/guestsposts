<a href="#newPriceModel-{{ $request->id }}" class="edit" data-toggle="modal">
@if(auth::user()->type == 'admin' || auth()->user()->type == 'outreach_coordinator' || auth::user()->type == 'moderator')

   {{$request->price}} @if($request->niche_new_price) &nbsp;&nbsp;&nbsp; <i class="material-icons fa fa-arrow-right "></i> &nbsp;&nbsp;&nbsp;{{ $request->niche_new_price}}@endif
@else
{{$request->niche_new_price >0 ? $request->niche_new_price : $request->price}}
@endif
</a>
@include('modals.nicheNewPrice')
