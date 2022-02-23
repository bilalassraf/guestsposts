@extends('layouts.default')
@section('title')
    Deleted Niche
@endsection
@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="content-wrapper p-5">
        @include('filter')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-green text-white d-flex align-items-center">
                        <h1 class="card-title p-3" style="font-weight:700;font-size:32px !important;">Trashed Niches</h1>
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
                                @foreach ($trashed as $niche)
                                    <tr>
                                        <td>{{ $niche->id }}</td>
                                        <td>{{ $niche->web_name }}</td>
                                        <td>{{ $niche->email_webmaster }}</td>
                                        <td>{{ $niche->Coordinator }}</td>
                                        <td>{{ Str::limit($niche->web_description, 50, ' (...)') }}</td>
                                        <td>{{ $niche->status }}</td>
                                        <td>
                                            <a href="{{ route('admin.restore.niche', $niche->id) }}"
                                                class="edit"><i class="material-icons fa fa-undo text-green"
                                                    title="Restore Requet"></i></a>
                                            <a href="{{ route('admin.delete.permanently.niche', $niche->id) }}"
                                                class="edit"><i class="material-icons fa fa-trash text-green"
                                                    title="Delete Request permanently"></i></a>
                                        </td>
                                    </tr>
                                    <!-- Delete Niche Modal -->
                                    @include('modals.delete-niche')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection
