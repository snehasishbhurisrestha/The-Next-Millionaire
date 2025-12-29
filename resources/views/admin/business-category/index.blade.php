@extends('layouts.app')

    @section('title') Business Category @endsection
    
    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Business Category</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Business Category</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}
                    @can('Business Category Create')
                    <li class="nav-item"><a class="btn btn-info" href="{{ route('business-category.create') }}"><i class="fa fa-plus"></i>Add New</a></li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>

    <div class="section-body mt-4">
        <div class="container-fluid">
            <div class="tab-content">
                <div class="tab-pane active" id="Student-all">
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Created At</th>
                                            <th></th>
                                            @canany(['Business Category Edit','Business Category Delete'])
                                            <th>Action</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><span class="font-16">{{ $item->name }}</span></td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ format_datetime($item->created_at) }}</td>
                                            <td>{!! check_visibility($item->is_visible) !!}</td>
                                            <td>
                                                @can('Business Category Edit')
                                                <a href="{{ route('business-category.edit',$item->id) }}" class="btn btn-icon btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                                @endcan
                                                @can('Business Category Delete')
                                                <form action="{{ route('business-category.destroy',$item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-icon btn-sm" onclick="return confirm('Are you sure?')" type="submit"><i class="fa fa-trash-o text-danger"></i></button>
                                                    {{-- <button type="button" class="btn btn-icon btn-sm js-sweetalert" title="Delete" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button> --}}
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection