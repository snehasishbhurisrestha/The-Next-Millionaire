@extends('layouts.app')

    @section('title') Auditors @endsection
    
    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Auditors</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Auditors</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}
                    @can('Auditor Create')
                    <li class="nav-item"><a class="btn btn-info" href="{{ route('auditors.create') }}"><i class="fa fa-plus"></i>Add Auditor</a></li>
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
                                            <th></th>
                                            <th>Specialization</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Registred Date</th>
                                            <th></th>
                                            @canany(['Auditor Edit','Auditor Delete'])
                                            <th>Action</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($auditors as $auditor)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="w60">
                                                <img class="avatar" src="{{ $auditor->getFirstMediaUrl('auditors-image') }}" alt="">
                                            </td>
                                            <td><span class="font-16">{{ $auditor->name }} ( {{ $auditor->user_id }} )</span></td>
                                            <td>
                                                @foreach($auditor->specialization as $specialization)
                                                    {{ $specialization->name }}<br>
                                                @endforeach
                                            </td>
                                            <td>{{ $auditor->email }}</td>
                                            <td>{{ $auditor->phone }}</td>
                                            <td>{{ $auditor->address }}</td>
                                            <td>{{ format_datetime($auditor->created_at) }}</td>
                                            <td>{!! check_visibility($auditor->status) !!}</td>
                                            <td>
                                                <a href="{{ route('auditors.show',$auditor->id) }}" class="btn btn-icon btn-sm" title="View"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('auditor.id-card',$auditor->id) }}" class="btn btn-info btn-sm" title="View">Id Card</a>
                                                @can('Auditor Edit')
                                                <a href="{{ route('auditors.edit',$auditor->id) }}" class="btn btn-icon btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                                @endcan
                                                @can('Auditor Delete')
                                                <form action="{{ route('auditors.destroy',$auditor->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-icon btn-sm" onclick="return confirm('Are you sure?')" type="submit"><i class="fa fa-trash-o text-danger"></i></button>
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