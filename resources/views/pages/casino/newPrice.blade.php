<a href="#newPriceModel-{{ $request->id }}" class="edit" data-toggle="modal">
@if(auth::user()->type == 'Admin' || auth::user()->type == 'Outreach Coordinator' || auth::user()->type == 'Moderator')

   {{$request->less_price}} @if($request->new_price) &nbsp;&nbsp;&nbsp; <i class="material-icons fa fa-arrow-right "></i> &nbsp;&nbsp;&nbsp;{{ $request->new_price}}@endif
@else
{{$request->new_price >0 ? $request->new_price : $request->price}}
@endif
</a>
@include('modals.casinoNewPrice')


