@extends('layouts.app')

    @section('title') Inspection Category @endsection
    
    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Inspection Category</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('checklist-categorie.index') }}">Inspection Category</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Inspection Category</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}

                    <li class="nav-item"><a class="btn btn-info" href="{{ route('checklist-categorie.index') }}"><i class="fa fa-arrow-left me-2"></i>Back</a></li>
                </ul>
            </div>
        </div>
    </div>

    
    <div class="section-body mt-4">
        <div class="container-fluid">
            <form action="{{ route('checklist-categorie.update',$item->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Basic Information</h3>
                            <div class="card-options ">
                                {{-- <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Name <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ $item->name }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Max Score <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" placeholder="Enter Max Score" name="max_score" value="{{ $item->max_score }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Save & Publish</h3>
                            <div class="card-options ">
                                {{-- <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row clearfix">
                                <div class="col-sm-12 mb-3">
                                    <label class="form-label mb-3 d-flex">Visibility</label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline1" name="is_visible" class="form-check-input" value="1" {{ check_uncheck($item->is_visible,1) }}>
                                        <label class="form-check-label" for="customRadioInline1">Show</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline2" name="is_visible" class="form-check-input" value="0" {{ check_uncheck($item->is_visible,0) }}>
                                        <label class="form-check-label" for="customRadioInline2">Hide</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Criteria Questions</h3>
                        <div class="card-options ">
                            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                            <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <a class="btn btn-info open-dynamic-modal text-white open-dynamic-modal-edit" 
                                style="cursor: pointer;" 
                                data-toggle="modal" 
                                data-target="#dynamicModal">
                                <i class="fa fa-plus"></i> Add Criteria</a>
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Name</th>
                                        <th>Max Score</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        @canany(['Inspection Category Edit','Inspection Category Delete'])
                                        <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inspection_items as $inspection_item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><span class="font-16">{{ $inspection_item->name }}</span></td>
                                        <td>{{ $inspection_item->point }}</td>
                                        <td>{!! check_visibility($inspection_item->is_visible) !!}</td>
                                        <td>{{ format_datetime($inspection_item->created_at) }}</td>
                                        @canany(['Inspection Category Edit','Inspection Category Delete'])
                                        <td>
                                            @can('Inspection Category Edit')
                                            <a class="btn btn-icon btn-sm open-dynamic-modal-edit" 
                                                style="cursor: pointer;" 
                                                data-id="{{ $inspection_item->id }}"
                                                data-visible="{{ $inspection_item->is_visible }}"
                                                data-name="{{ $inspection_item->name }}"
                                                data-point="{{ $inspection_item->point }}"
                                                data-action="{{ route('checklist-item.update', ':id') }}"
                                                data-toggle="modal" 
                                                data-target="#dynamicModal" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('Inspection Category Delete')
                                            <form action="{{ route('checklist-item.destroy',$inspection_item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-icon btn-sm" onclick="return confirm('Are you sure?')" type="submit"><i class="fa fa-trash-o text-danger"></i></button>
                                                {{-- <button type="button" class="btn btn-icon btn-sm js-sweetalert" title="Delete" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button> --}}
                                            </form>
                                            @endcan
                                        </td>
                                        @endcanany
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
    

    {{-- <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dynamicModalLabel">Add New Criteria Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('checklist-item.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" value="{{ $item->id }}" name="inspection_category_id">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="criteriaName">Name <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" placeholder="Enter name" id="criteriaName" name="name" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="criteriaPoint">Max Score <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="number" class="form-control" placeholder="Enter Max Score" id="criteriaPoint" name="point" value="" required>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label mb-3 d-flex">Visibility</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="is_visible1" name="is_visible" class="form-check-input" value="1" {{ check_uncheck($item->is_visible,1) }}>
                                <label class="form-check-label" for="is_visible1">Show</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="is_visible2" name="is_visible" class="form-check-input" value="0" {{ check_uncheck($item->is_visible,0) }}>
                                <label class="form-check-label" for="is_visible2">Hide</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Publish</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dynamicModalLabel">Add New Criteria Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="dynamicForm" action="{{ route('checklist-item.store') }}" method="post">
                    @csrf
                    <div id="methodInput"></div> <!-- Placeholder for the PUT method -->
                    <div class="modal-body">
                        <!-- Hidden Input for Category ID -->
                        <input type="hidden" value="{{ $item->id }}" name="inspection_category_id">
                        <!-- Hidden Input for Inspection Item ID -->
                        <input type="hidden" id="inspectionItemId" name="inspection_item_id" value="">
    
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="criteriaName">Name <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" placeholder="Enter name" id="criteriaName" name="name" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="criteriaPoint">Max Score <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="number" class="form-control" placeholder="Enter Max Score" id="criteriaPoint" name="point" value="" required>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label mb-3 d-flex">Visibility</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="is_visible1" name="is_visible" class="form-check-input" value="1">
                                <label class="form-check-label" for="is_visible1">Show</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="is_visible2" name="is_visible" class="form-check-input" value="0">
                                <label class="form-check-label" for="is_visible2">Hide</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Publish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    @endsection

    @section('script')
    <script> 
        $(document).ready(function () {
            $('.open-dynamic-modal-edit').on('click', function () {
                // Fetch data from button attributes
                var id = $(this).data('id');
                var visible = $(this).data('visible');
                var point = $(this).data('point');
                var name = $(this).data('name');
                
                if (id && visible !== undefined && point && name) {
                    const actionUrl = $(this).data('action').replace(':id', id);
                    // Set modal title to 'Edit' if all data is available
                    $('#dynamicModalLabel').text('Edit Criteria Question');

                    // Populate modal fields with existing data
                    $('#inspectionItemId').val(id); // Set the hidden inspection_item ID
                    $('#criteriaName').val(name);  // Set the name field
                    $('#criteriaPoint').val(point); // Set the point field
                    $(`input[name="is_visible"][value="${visible}"]`).prop('checked', true); // Set visibility

                    // Add the PUT method for editing
                    $('#methodInput').html('@method("PUT")');

                    // Set the form action dynamically for editing
                    $('#dynamicForm').attr('action', actionUrl);
                } else {
                    // If not all data is available, change modal title to 'Add' and clear fields
                    $('#dynamicModalLabel').text('Add New Criteria Question');

                    // Clear the form inputs for adding a new item
                    $('#inspectionItemId').val('');
                    $('#criteriaName').val('');
                    $('#criteriaPoint').val('');
                    $('input[name="is_visible"]').prop('checked', false);

                    // Remove the PUT method for adding
                    $('#methodInput').html('');

                    // Set the form action dynamically for adding
                    $('#dynamicForm').attr('action', `{{ route('checklist-item.store') }}`);
                }

                // Open the modal (modal will already be triggered via data-target, but ensures smooth behavior)
                $('#dynamicModal').modal('show');
            });
        });

    </script>
    @endsection