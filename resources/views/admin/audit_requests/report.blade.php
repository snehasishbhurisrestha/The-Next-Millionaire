@extends('layouts.app')

    @section('title') Audit Report @endsection
    
    @section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin-assets/plugins/dropify/css/dropify.min.css') }}">
    <style>
        .category-section {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .category-section h2 {
            color: #007bff;
            margin-bottom: 20px;
        }

        .question {
            margin-bottom: 15px;
        }

        .rating input {
            margin-right: 10px;
        }

        .rating label {
            font-weight: normal;
            font-size: 1.1rem;
        }

        .comment textarea {
            width: 100%;
            resize: none;
        }

        .btn-submit {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1.1rem;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
    @endsection

    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Audit Report</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('audit.index') }}">Audit Enquiry</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Audit Report</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}

                    <li class="nav-item"><a class="btn btn-info" href="{{ route('audit.index') }}"><i class="fa fa-arrow-left me-2"></i>Back</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="section-body mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Audit Details</h3>
                            <div class="card-options">
                                <a href="#" class="card-options-collapse" data-toggle="card-collapse">
                                    <i class="fe fe-chevron-up"></i>
                                </a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove">
                                    <i class="fe fe-x"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-wrap">Shop Details</th>
                                                <th class="text-wrap">Certification Type</th>
                                                <th class="text-wrap">Audit Date</th>
                                                @if(!Auth::user()->hasRole('Auditor'))
                                                <th class="text-wrap">Auditor</th>
                                                @endif
                                                <th class="text-wrap">Shop Address</th>
                                                @if(!Auth::user()->hasRole('Auditor'))
                                                <th class="text-wrap">Created At</th>
                                                <th class="text-wrap">Status</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <strong>Owner Name : </strong> {{ $audit->user?->name }}<br>
                                                    <strong>Phone : </strong> {{ $audit->user?->phone }}<br>
                                                    <strong>Business Name : </strong> {{ $audit->user?->business?->business_name }}<br>
                                                    <strong>Business Category : </strong> {{ $audit->user?->business?->category->name }}<br>
                                                </td>
                                                <td>{{ $audit->certificationType?->name }}</td>
                                                <td>
                                                    {{ format_date($audit->audit_date) }}
                                                </td>
                                                @if(!Auth::user()->hasRole('Auditor'))
                                                <td>
                                                    @if(!empty($audit->auditor?->name))
                                                    <strong>Name : </strong>{{ $audit->auditor?->name }}<br>
                                                    <strong>ID : </strong>{{ $audit->auditor?->user_id }}<br>
                                                    <strong>Phone : </strong>{{ $audit->auditor?->phone }}
                                                    @endif
                                                </td>
                                                @endif
                                                <td>{{ $audit->user->business->business_address }}</td>
                                                @if(!Auth::user()->hasRole('Auditor'))
                                                <td>{{ format_datetime($audit->created_at) }}</td>
                                                <td>
                                                    <strong>{{ $audit->status }}</strong>
                                                </td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="section-body mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Track Audit</h3>
                            <div class="card-options ">
                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($audit_stacks as $audit_stack)
                            <div class="timeline_item">
                                <div class="tl_avatar" style="background-color: #10a8b4;border-radius: 50%;height: 20px;width: 20px;left: -10px;"></div>
                                <span>
                                    <a href="javascript:void(0);">{{ $audit_stack->description }}</a>
                                    <small class="float-right text-right">{{ format_datetime($audit_stack->created_at) }}</small>
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Visit Report</h3>
                            <div class="card-options ">
                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-wrap">Description</th>
                                        <th class="text-wrap">Files</th>
                                        <th class="text-wrap">Uploaded By</th>
                                        <th class="text-wrap">Uploaded At</th>
                                        <th class="text-wrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($audit_reports as $audit_report)
                                    <tr>
                                        <td>{!! $audit_report->description !!}</td>
                                        <td>
                                            @if($audit_report->getMedia('audit-report-file')->isNotEmpty())
                                                <ul>
                                                    @foreach($audit_report->getMedia('audit-report-file') as $file)
                                                        <li>
                                                            <a href="{{ $file->getUrl() }}" target="_blank">{{ $file->file_name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                No files uploaded.
                                            @endif
                                        </td>
                                        <td>{{ $audit_report->user?->name }}</td>
                                        <td>{{ format_datetime($audit_report->created_at) }}</td>
                                        <td>
                                            @if($audit_report->is_draft)
                                            <button class="btn btn-icon btn-sm btn-edit" data-id="{{ $audit_report->id }}" data-description="{{ $audit_report->description }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form action="{{ route('audit.delete-audit-report',$audit_report->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-icon btn-sm" onclick="return confirm('Are you sure?')" type="submit"><i class="fa fa-trash-o text-danger"></i></button>
                                            </form>
                                            @endif
                                            @if(Auth::user()->hasRole('Super Admin') && $audit_report->is_approved == 0)
                                            <a href="{{ route('audit.approved-audit-report',$audit_report->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Approve"><i class="fa fa-check"></i></a>
                                            <button class="btn btn-icon btn-sm btn-edit" data-id="{{ $audit_report->id }}" data-description="{{ $audit_report->description }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            @endif
                                            @if($audit_report->is_approved == 1)
                                            <span class="btn btn-success brn-sm">Approved</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if(count($audit_reports) <= 0)
                            <div class="mt-3">
                                <button id="toggleUploadPart" class="btn btn-success">Add</button>
                            </div>
                            @endif
                            <div class="upload-part mt-3" id="uploadPart" style="display: none;">
                                <form action="{{ route('audit.upload-audit-report',$audit->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <textarea rows="2" class="form-control no-resize summernote" name="description" placeholder="Enter here for tweet..." required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Upload File</label>
                                    <div class="">
                                        <input type="file" class="dropify" name="file[]" multiple>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 mb-3">
                                    <label class="form-label mb-3 d-flex">Status</label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline1" name="is_draft" class="form-check-input" value="1" checked>
                                        <label class="form-check-label" for="customRadioInline1">Is Draft</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline2" name="is_draft" class="form-check-input" value="0">
                                        <label class="form-check-label" for="customRadioInline2">Final Submit</label>
                                    </div>
                                    <span class="text-danger">( After Final submit you cannot modify any data )</span>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <!-- Edit Form -->
                            <div class="edit-part mt-3" id="editPart" style="display: none;">
                                <form id="editForm" action="" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" id="editId">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control no-resize summernote" name="description" id="editDescription" placeholder="Edit description..." required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Existing Files</label>
                                        <ul id="existingFiles"></ul>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Upload File</label>
                                        <div>
                                            <input type="file" class="dropify" name="file[]" multiple>
                                        </div>
                                    </div>
                                    @if(!Auth::user()->hasRole('Super Admin'))
                                    <div class="col-sm-12 mb-3">
                                        <label class="form-label mb-3 d-flex">Status</label>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="editcustomRadioInline1" name="is_draft" class="form-check-input" value="1" checked>
                                            <label class="form-check-label" for="editcustomRadioInline1">Is Draft</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="editcustomRadioInline2" name="is_draft" class="form-check-input" value="0">
                                            <label class="form-check-label" for="editcustomRadioInline2">Final Submit</label>
                                        </div>
                                        <span class="text-danger">( After Final submit you cannot modify any data )</span>
                                    </div>
                                    @endif
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <button type="button" id="cancelEdit" class="btn btn-outline-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div> --}}

                            <form action="{{ route('audit.upload-audit-report', $audit->id) }}" method="POST">
                                @csrf
                                @foreach ($inspectionCategories as $index => $category)
                                    <div class="category-section">
                                        <h2>{{ $category['category']['name'] }}</h2>
                            
                                        @foreach ($category['items'] as $itemIndex => $item)
                                            <div class="question">
                                                <p><strong>{{ $itemIndex + 1 }}. {{ $item['name'] }}</strong></p>
                            
                                                <div class="rating">
                                                    @foreach ([0 => '✅ Compliant', 1 => '⚠ Partially Compliant', 2 => '❌ Non-Compliant'] as $value => $label)
                                                        <label>
                                                            <input type="radio" 
                                                                name="rating[{{ $category['category']['id'] }}][{{ $item['id'] }}]" 
                                                                value="{{ $value }}"
                                                                @if(isset($auditScores[$item['id']]) && $auditScores[$item['id']]->score == $value) checked @endif 
                                                                required> 
                                                            {{ $label }}
                                                        </label>
                                                    @endforeach
                                                </div>
                            
                                                <div class="comment mt-3">
                                                    <label for="comment_{{ $item['id'] }}">Comment:</label>
                                                    <textarea name="comment[{{ $category['category']['id'] }}][{{ $item['id'] }}]" 
                                                              id="comment_{{ $item['id'] }}" rows="3" 
                                                              class="form-control">
                                                        {{ isset($auditScores[$item['id']]) ? $auditScores[$item['id']]->notes : '' }}
                                                    </textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                                @if(empty($auditScores))
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                                @endif
                                @if(Auth::user()->hasRole('Super Admin'))
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                                @endif
                            </form>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    

    @endsection

    @section('script')
    <script src="{{ asset('assets/admin-assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/page-assets/js/form/dropify.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#toggleUploadPart').click(function () {
                const uploadPart = $('#uploadPart');
                if (uploadPart.is(':visible')) {
                    uploadPart.hide();
                    $(this).text('Add').removeClass('btn-danger').addClass('btn-success');
                } else {
                    uploadPart.show();
                    $(this).text('Remove').removeClass('btn-success').addClass('btn-danger');
                }
            });
        });

        $(document).ready(function () {
            // Show the edit form when Edit button is clicked
            $('.btn-edit').on('click', function () {
                const id = $(this).data('id');

                // Fetch data using AJAX
                $.ajax({
                    url: "{{ route('audit.audit-report-edit', '__id__') }}".replace('__id__', id),
                    method: 'GET',
                    success: function (response) {
                        // Populate the form fields
                        $('#editForm').attr('action', "{{ route('audit.update-upload-audit-report', '__id__') }}".replace('__id__', id)); // Set form action
                        $('#editId').val(response.id);
                        // $('#editDescription').val(response.description);
                        $('#editDescription').summernote('code', response.description);

                        if (response.is_draft === 1) {
                            $('#editcustomRadioInline1').prop('checked', true); // Set "Is Draft" as checked
                            $('#editcustomRadioInline2').prop('checked', false);
                        } else {
                            $('#editcustomRadioInline1').prop('checked', false); 
                            $('#editcustomRadioInline2').prop('checked', true); // Set "Final Submit" as checked
                        }
                        // Populate existing files
                        let filesList = '';
                        response.files.forEach(file => {
                            filesList += `
                                <li>
                                    <a href="${file.url}" target="_blank">${file.name}</a>
                                    <button type="button" class="btn btn-sm btn-danger delete-file" data-report-id="${response.id}" data-file-id="${file.id}">Delete</button>
                                </li>`;
                        });
                        $('#existingFiles').html(filesList);

                        // Show the edit form
                        $('#editPart').show();
                    },
                    error: function () {
                        alert('Failed to fetch report details.');
                    }
                });
            });

            // Delete file functionality
            $(document).on('click', '.delete-file', function () {
                const fileId = $(this).data('file-id');
                const id = $(this).data('report-id');

                if (confirm('Are you sure you want to delete this file?')) {
                    $.ajax({
                        url: "{{ route('audit.delete-audit-file', ['id' => '__id__', 'fileId' => '__fileId__']) }}".replace('__id__', id).replace('__fileId__', fileId),
                        method: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
                        },
                        success: function () {
                            // alert('File deleted successfully.');
                            showToast('success', 'Success', 'File deleted successfully');
                            // Find the file item in the list and remove it
                            $('.delete-file[data-file-id="' + fileId + '"]').closest('li').remove();
                        },
                        error: function () {
                            alert('Failed to delete the file.');
                        }
                    });
                }
            });

            // Hide the edit form when Cancel button is clicked
            $('#cancelEdit').on('click', function () {
                $('#editPart').hide();
            });
        });


    </script>
    <script>
        document.getElementById('inspectionForm').addEventListener('submit', function (e) {
            let firstEmptyField = null;
            
            // Loop through all required inputs (radio buttons) to check if they are filled
            document.querySelectorAll('input[required]').forEach(function (input) {
                if (!input.checked) {
                    if (!firstEmptyField) {
                        firstEmptyField = input;
                    }
                }
            });
    
            // If any required field is empty, focus on it and prevent form submission
            if (firstEmptyField) {
                e.preventDefault();
                firstEmptyField.focus();
            }
        });
    </script>
    @endsection