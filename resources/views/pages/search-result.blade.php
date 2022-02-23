@extends('layouts.default')
@section('title')
    User-Info
@endsection
@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="content-wrapper p-5">
        <div class="row">
            <div class="col-12">
                <form method="POST" action="{{ route('admin.deleted.selected') }}" id="delete_form">
                    @csrf
                    <div class="card">
                        <div class="card-header bg-green text-white">
                            <h1 class="card-title p-3" style="font-weight:500;font-size:28px !important;">User Information
                            </h1>
                            <div class="float-right mt-3">
                                <a href="#addUserModal" class="btn btn-primary bg-white p-2 border-0 " data-toggle="modal"
                                    style="font-weight: 600 !important;"><i class="text-green fa fa-plus"
                                        style="font-size: 20px;"></i> <span>Add User</span></a>
                                {{-- <a href="" id="delete-selected" class="btn btn-primary bg-white p-2 border-0 " style="font-weight: 600 !important;"><i class="text-green fa fa-trash" style="font-size: 20px;"> </i> <span>Delete selected</span></a> --}}
                                <input type="submit" value="Delete Selected"
                                    class="btn btn-primary bg-white border-0 text-green fa fa-trash"
                                    style="font-weight: 600 !important; padding:12px;">
                            </div>
                        </div>

                        <!-- /.card-header -->

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col"><input type="checkbox" class="check-all"></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr id="sid{{ $user->id }}">
                                            <td><input type="checkbox" class="check" value="{{ $user->id }}"
                                                    name="ids[]"></td>
                                            <td><a href="{{ route('user.profile', $user->id) }}">{{ $user->name }}</a>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->type }}</td>
                                            <td>
                                                <a href="{{ route('user.profile', $user->id) }}"><i
                                                        class="material-icons fa fa-eye text-green" data-toggle="tooltip"
                                                        title="View" style="font-size:20px;"></i></a>
                                                <a href="#editUserModal-{{ $user->id }}" class="edit"
                                                    data-toggle="modal"><i class="material-icons fa fa-pencil text-green"
                                                        data-toggle="tooltip" title="Edit" style="font-size:20px;"></i></a>
                                                <a href="#deleteUserModal-{{ $user->id }}" class="delete"
                                                    data-toggle="modal"><i class="material-icons fa fa-trash text-green"
                                                        data-toggle="tooltip" title="Delete"
                                                        style="font-size:20px;"></i></a>
                                                <a href="#changePasswordModal-{{ $user->id }}" class="delete"
                                                    data-toggle="modal"><i class="material-icons fa fa-lock text-green"
                                                        title="Change Password" style="font-size:20px;"></i></a>
                                            </td>
                                        </tr>
                                        <!-- Edit Modal -->
                                        @include('modals.update-user')
                                        <!-- Delete Modal -->
                                        @include('modals.delete-user')
                                        <!-- Delete Modal -->
                                        @include('modals.change-password')

                                    @empty
                                        <tr class="text-bold text-green ">
                                            <td>{{ $empty_message }}</td>
                                        </tr>
                                    @endforelse
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
    <script>
        $("#delete-selected").click(function() {
            $("#delete_form").submit();
        });
        
    </script>

@endsection
