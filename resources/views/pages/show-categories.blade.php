@extends('layouts.default')
@section('title')
    Show Category
@endsection
@section('content')
    <div class="content-wrapper p-4">
        @include('filter')
        <div class="card-header bg-green text-white">
            <h1 class="card-title p-3" style="font-weight:500;font-size:28px !important;">Categories</h1>
            <div class="float-right mt-3">
                <a href="#addCategory" class="btn btn-primary bg-white p-2 border-0 " data-toggle="modal"
                    style="font-weight: 600 !important;"><i class="text-green fa fa-plus" style="font-size: 20px;"></i>
                    <span>Add Category</span></a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordernone">
                    <thead>
                        <tr>
                            <th>#id</th>
                            <th> Category Name</th>
                            <th>Added at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->category }}</td>
                                <td>{{ $category->created_at->format('d-y-m') }}</td>
                                <td>
                                    <a href="" class="edit" data-toggle="modal"
                                        data-target="#editCategory-{{ $category->id }}"><i
                                            class="material-icons fa fa-edit text-green" data-toggle="tooltip"
                                            title="Edit"></i></a>
                                    <a href="" class="delete" data-toggle="modal"
                                        data-target="#deletCategory-{{ $category->id }}"><i
                                            class="material-icons fa fa-trash text-green" data-toggle="tooltip"
                                            title="Delete"></i></a>
                                </td>
                            </tr>
                            @include('modals.category')
                            @include('modals.edit-category')
                            @include('modals.remove-category')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('modals.add-user')
@endsection
