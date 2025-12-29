@extends('layouts.app')

    @section('title') Contact Us @endsection
    
    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Contact Us</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}
                    {{-- @can('Lead Create')
                    <li class="nav-item"><a class="btn btn-warning" href="{{ route('leads.lead-import') }}"><i class="fa fa-upload"></i>Import Lead</a></li>
                    <li class="nav-item"><a class="btn btn-info" href="{{ route('lead.create') }}"><i class="fa fa-plus"></i>Add New</a></li>
                    @endcan --}}
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
                                            {{-- <th>Business Name</th>
                                            <th>Business category</th> --}}
                                            <th>Email</th>
                                            {{-- <th>Gender</th> --}}
                                            {{-- <th>Phone</th>
                                            <th>Business Address</th> --}}
                                            <th>Message</th>
                                            {{-- <th>Status</th> --}}
                                            {{-- <th>Next Followup Date</th> --}}
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><span class="font-16">{{ $item->first_name .' '.$item->last_name }}</span></td>
                                            {{-- <td>{{ $item->business_name }}</td>
                                            <td>{{ $item->category?->name }}</td> --}}
                                            <td>{{ $item->email }}</td>
                                            {{-- <td>{{ ucfirst($item->gender) }}</td> --}}
                                            {{-- <td>{{ $item->phone }}</td> --}}
                                            {{-- <td>{{ $item->business_address }}</td> --}}
                                            <td>{{ $item->message }}</td>
                                            {{-- <td>{{ ucfirst($item->status) }}</td> --}}
                                            {{-- <td>{{ $item->latestFollowUp?->next_follow_up_date ? format_date($item->latestFollowUp?->next_follow_up_date) : '' }}</td> --}}
                                            <td>{{ format_datetime($item->created_at) }}</td>
                                            <td>
                                                {{-- <a href="{{ route('lead.show',$item->id) }}" class="btn btn-icon btn-sm" title="View"><i class="fa fa-eye"></i></a>
                                                @can('Lead Edit')
                                                <a href="{{ route('lead.edit',$item->id) }}" class="btn btn-icon btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                                @endcan --}}
                                                @can('Lead Delete')
                                                <form action="{{ route('lead.destroy',$item->id) }}" method="POST" style="display:inline;">
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