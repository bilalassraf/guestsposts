@extends('layouts.default')
@section('title')
    Deleted Website
@endsection
@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="content-wrapper p-5">
        @include('filter')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-green text-white d-flex align-items-center">
                        <h1 class="card-title p-3" style="font-weight:700;font-size:32px !important;">Trashed Requests</h1>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
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
                                @forelse ($trashed as $guest)
                                     <tr>
                                        <td>{{ $guest->id }}</td>
                                        <td>{{ $guest->web_name }}</td>
                                        <td>{{ $guest->email_webmaster }}</td>
                                        <td>{{ $guest->Coordinator }}</td>
                                        <td>{{ Str::limit($guest->web_description, 50, ' (...)') }}</td>
                                        <td>{{ $guest->status }}</td>
                                        <td>
                                            <a href="{{ route('admin.restore.requests', $guest->id) }}"
                                                class="edit"><i class="material-icons fa fa-undo text-green"
                                                    title="Restore Requet"></i></a>
                                            <a href="{{ route('admin.delete.permanently.requests', $guest->id) }}"
                                                class="edit"><i class="material-icons fa fa-trash text-green"
                                                    title="Delete Request permanently"></i></a>
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
