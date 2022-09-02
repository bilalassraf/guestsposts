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
            <form method="POST" action="{{ route('admin.delete.selected.request') }}" id="delete_form">
                @csrf
                <div class="card">
                    <!-- <div class="card-header bg-green text-white d-flex align-items-center">
                        <h1 class="card-title p-3" style="font-weight:700;font-size:32px !important;">Websites Requests</h1>
                      </div> -->
                    <div class="card-header bg-green text-white">
                        <h1 class="card-title p-3" style="font-weight:500;font-size:28px !important;">Websites Requests
                        </h1>
                        <div class="float-right mt-3">
                            <a href="{{ route('admin.add.guest.request') }}"
                                class="btn btn-primary bg-white p-2 border-0 " style="font-weight: 600 !important;"><i
                                    class="text-green fa fa-plus" style="font-size: 17px;"></i> &nbsp; <span>Add
                                    Website</span></a>
                            <a href="{{ route('export.excel') }}" class="btn btn-primary bg-white p-2 border-0 "
                                style="font-weight: 600 !important;"><i class="text-green fa fa-download"
                                    style="font-size: 17px;"></i> &nbsp; <span>Download Request</span></a>
                            <button type="submit" class="btn btn-primary bg-white border-0 "
                                style="font-weight: 600 !important; padding:8px;"><i class="text-green fa fa-trash"
                                    style="font-size: 17px;"></i><span> Delete Selected</span></button>
                            <a href="#advanceFilter" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseExample" class="btn btn-primary bg-white p-2 border-0" style="font-weight: 600 !important;"><i class="text-green fa fa-plus" style="font-size: 17px;"></i> &nbsp; <span>Advance Filter </span></a>        
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap" id="example" >
                            <thead>
                                <tr>
                                    <th scope="col"><input type="checkbox" class="check-all"></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Coordinator</th>
                                    <th>Web Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guest_requests as $request)
                                <tr data-widget="expandable-table" aria-expanded="false">
                                    <td><input type="checkbox" class="check" value="{{ $request->id }}" name="ids[]"><i
                                            class="expandable-table-caret fas fa-caret-right fa-fw"></i></td>
                                    <td>{{ $request->web_name }}</td>
                                    <td>{{ $request->email_webmaster }}</td>
                                    <td>{{ $request->coodinator->name ?? "N/A"}}</td>
                                    <td>{{ Str::limit($request->web_description, 50, ' (...)') }}</td>
                                    <td>
                                        <a href="#editRequestModal-{{ $request->id }}" class="edit"
                                            data-toggle="modal"><i class="material-icons fa fa-pencil text-green"
                                                data-toggle="tooltip" title="Edit"></i></a>
                                        <a href="{{ route('admin.guest.request.approved', $request->id) }}"
                                            class="edit"><i class="material-icons fa fa-check text-green"
                                                title="Aprrove request"></i></a>
                                        <a href="{{ route('admin.guest.request.rejected', $request->id) }}"
                                            class="edit"><i class="material-icons fa fa-close text-green"
                                                title="reject request"></i></a>
                                        <a href="" class="delete" data-toggle="modal"
                                            data-target="#deleteGuestModal-{{ $request->id }}"><i
                                                class="material-icons fa fa-trash text-green"
                                                title="Delete a request"></i></a>
                                    </td>
                                </tr>
                                <tr class="expandable-body">
                                    <td colspan="12" style="width:100% !important;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-body" style="background-color:rgba(36, 41, 57, 0.09);">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="your-details">
                                                                        <h6 class="f-w-600">Website Name</h6>
                                                                        {{ $request->web_name }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="your-details your-details-xs">
                                                                        <h6 class="f-w-600">Outreach
                                                                            Coordinator </h6>
                                                                        {{ $request->coodinator->name ?? "N/A" }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="your-details">
                                                                        <h6 class="f-w-600">Webmaster Price
                                                                        </h6>
                                                                        {{ $request->price }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="your-details">
                                                                        <h6 class="f-w-600">Status</h6>
                                                                        {{ $request->status }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="your-details">
                                                                        <h6 class="f-w-600">Company Price</h6>
                                                                        {{ $request->company_price }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="your-details your-details-xs">
                                                                        <h6 class="f-w-600">Category </h6>
                                                                        @foreach ($request->categories as $category)
                                                                        {{ $category->category}},
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="your-details">
                                                                        <h6 class="f-w-600">Domain Authority
                                                                        </h6>
                                                                        {{ $request->domain_authority }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="your-details">
                                                                        <h6 class="f-w-600">Spam Score</h6>
                                                                        {{ $request->span_score }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-sm-2">
                                                                    <div class="your-details">
                                                                        <h6 class="f-w-600">Domain Rating</h6>
                                                                        {{ $request->domain_rating }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <div class="your-details your-details-xs">
                                                                        <h6 class="f-w-600">Organic Traffic  (Ahrefs)</h6>
                                                                        {{ $request->organic_trafic_ahrefs }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <div class="your-details">
                                                                        <h6 class="f-w-600">Orgainic Traffic (Sem)
                                                                        </h6>
                                                                        {{ $request->organic_trafic_sem }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <div class="your-details">
                                                                        <h6 class="f-w-600">Trust Flow</h6>
                                                                        {{ $request->trust_flow }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <div class="your-details">
                                                                        <h6 class="f-w-600">Citation Flow</h6>
                                                                        {{ $request->citation_flow }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <div class="your-details your-details-xs">
                                                                        <h6 class="f-w-600">Email (Webmaster)</h6>
                                                                        {{ $request->organic_trafic_ahrefs }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="your-details your-details-xs">
                                                                        <h6 class="f-w-600">Website Description</h6>
                                                                        {{ $request->web_description }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="your-details your-details-xs">
                                                                        <h6 class="f-w-600">Special Note</h6>
                                                                        {{ $request->special_note }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </td>
                                </tr>
                                @include('modals.update-request')
                                <!-- Delete Niche Modal -->
                                @include('modals.delete-guest-request')
                                @endforeach
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
<style type="text/css">
    label {
        margin: 10px;
    }

    a.paginate_button.current {
        background: #242939 !important;
        color: white !important;
    }

    div#example_info {
        padding-left: 10px;
    }

    .card.sroling {
        width: 239%;
    }
</style>
