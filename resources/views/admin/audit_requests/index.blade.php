@extends('layouts.app')

    @section('title') Audit Enquiry @endsection
    
    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Audit Enquiry</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Audit Enquiry</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}
                    @can('Audit Create')
                    <li class="nav-item"><a class="btn btn-info" href="{{ route('audit.create') }}"><i class="fa fa-plus"></i>Create Audit Enquiry</a></li>
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
                                            <th class="text-wrap">Sl No.</th>
                                            <th class="text-wrap">Shop Details</th>
                                            <th class="text-wrap">Certification Type</th>
                                            <th class="text-wrap">Audit Date</th>
                                            @if(!Auth::user()->hasRole('Auditor'))
                                            <th class="text-wrap">Auditor</th>
                                            @endif
                                            <th class="text-wrap">Shop Address</th>
                                            @if(!Auth::user()->hasRole('Auditor'))
                                            <th class="text-wrap">Created At</th>
                                            @endif
                                            @if(!Auth::user()->hasRole('Auditor'))
                                            <th class="text-wrap">Status</th>
                                            @endif
                                            @canany(['Audit Edit','Audit Delete','Audit Report'])
                                            <th>Action</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($audits as $audit)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
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
                                                <strong>Phone : </strong>{{ $audit->auditor?->phone }}<br>
                                                @if($audit->is_auditor_paid)<span class="badge bg-success">Paid</span> @endif
                                                @can('Audit Delete')
                                                @if(in_array($audit->status, ['Placed', 'Approved', 'Auditor Assigned']))
                                                <a href="{{ route('audit.rollback-assign',$audit->id) }}" onclick="return confirm('Are you sure?')" class="badge rounded-pill bg-danger" data-toggle="tooltip" data-placement="top" title="Deasign Auditor"><i class="fa fa-close mr-1"></i>Deasign</a>
                                                @endif
                                                @endcan
                                                @endif
                                            </td>
                                            @endif
                                            <td>{{ $audit->user?->business?->business_address }}</td>
                                            @if(!Auth::user()->hasRole('Auditor'))
                                            <td>{{ format_datetime($audit->created_at) }}</td>
                                            
                                            <td>
                                                @if(!Auth::user()->hasRole('Auditor'))
                                                <strong>{{ $audit->status }}</strong> <br>
                                                @endif
                                                @can('Audit Edit')
                                                @if(!in_array($audit->status, ['Complete', 'Cancelled']))
                                                <a class="badge rounded-pill bg-success text-white open-dynamic-modal" 
                                                    style="cursor: pointer;" 
                                                    data-id="{{ $audit->id }}" 
                                                    data-status="{{ $audit->status }}"
                                                    data-suditor-id="{{ $audit->auditor_id }}"
                                                    data-payment-amount="{{ $audit->payment_amount }}"
                                                    data-toggle="modal" 
                                                    data-target="#dynamicModal">
                                                    <i class="fa fa-check mr-1"></i>Change Status
                                                </a>
                                                @endif
                                                @endcan
                                                
                                            </td>
                                            @endif
                                            @canany(['Audit Edit','Audit Delete','Audit Report'])
                                            <td>
                                                {{-- <a class="btn btn-success btn-sm open-approve-modal text-white" data-toggle="modal" data-id="{{ $audit->id }}"  data-target="#exampleModalCenter" data-toggle="tooltip" data-placement="top" title="Approve & Assign Auditor"><i class="fa fa-check"></i></a> --}}
                                                {{-- <a href="{{ route('audit.assign-cancel',$audit->id) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Cancel"><i class="fa fa-close"></i></a> --}}
                                                @can('Audit Report')
                                                @if(!in_array($audit->status, ['Placed', 'Approved','Auditor Assigned']))
                                                <a href="{{ route('audit.audit-report',$audit->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Audit Report"><i class="fa fa-upload"></i></a>
                                                @endif
                                                @endcan
                                                @if(Auth::user()->hasRole('Auditor') && in_array($audit->status, ['Placed', 'Approved','Auditor Assigned']))
                                                {{-- <a href="{{ route('audit.audit-report',$audit->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Click Visit Complete to upload report">Visit Complete</a> --}}
                                                <form action="{{ route('audit.update-status') }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="audit_id" value="{{ $audit->id }}">
                                                    <input type="hidden" name="status" value="Visit Complete">
                                                    <button class="btn btn-warning btn-sm" type="submit">Visit Complete</button>
                                                    {{-- <button type="button" class="btn btn-icon btn-sm js-sweetalert" title="Delete" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button> --}}
                                                </form>
                                                @endif

                                                @if(!in_array($audit->status, ['Complete', 'Cancelled']))
                                                @can('Audit Edit')
                                                <a href="{{ route('audit.edit',$audit->id) }}" class="btn btn-icon btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                                @endcan
                                                
                                                @can('Audit Delete')
                                                <form action="{{ route('audit.destroy',$audit->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-icon btn-sm" onclick="return confirm('Are you sure?')" type="submit"><i class="fa fa-trash-o text-danger"></i></button>
                                                    {{-- <button type="button" class="btn btn-icon btn-sm js-sweetalert" title="Delete" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button> --}}
                                                </form>
                                                @endcan
                                                @endif
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
    </div>


    <!-- Single Modal Structure -->
    <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dynamicModalLabel">Change Status of Audit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('audit.update-status') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="audit_id" id="dynamicAuditId">
                        <div class="form-group">
                            <label class="col-form-label">Choose Status <span class="text-danger">*</span></label>
                            <select class="form-control input-height select2" name="status" id="dynamicStatus" required>
                                <option value selected disabled>Select...</option>
                                <option value="Placed">Placed</option>
                                <option value="Approved">Approved</option>
                                <option value="Auditor Assigned">Auditor Assigned</option>
                                <option value="Visit Complete">Visit Complete</option>
                                <option value="Report Uploaded">Report Uploaded</option>
                                {{-- <option value="Complete">Complete</option> --}}
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div id="dynamicAdditionalFields" style="display: none;">
                            <div class="form-group">
                                <label class="col-form-label">Choose Auditor <span class="text-danger">*</span></label>
                                <select class="form-control input-height select2" name="auditor" id="dynamicAuditor">
                                    <option value selected disabled>Select...</option>
                                    {{-- @foreach($auditors as $auditor)
                                    <option value="{{ $auditor->id }}">{{ $auditor->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Payment Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="payment_amount" id="dynamicPaymentAmount" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @endsection

    @section('script')

    <script>
        $(document).ready(function () {
            $('.open-dynamic-modal').on('click', function () {
                // Fetch data from button attributes
                var auditId = $(this).data('id');
                var status = $(this).data('status');
                var data_suditor_id = $(this).data('data-suditor-id');
                var data_payment_amount = $(this).data('data-payment-amount');

                // Set the data in the modal
                $('#dynamicAuditId').val(auditId);
                $('#dynamicStatus').val(status);
                $('#dynamicAuditor').val(data_suditor_id);
                $('#dynamicPaymentAmount').val(data_payment_amount);

                // Show or hide additional fields based on status
                if (status === 'Auditor Assigned') {
                    // $('#dynamicAdditionalFields').show();
                    // $('#dynamicAuditor').attr('required', true);
                    // $('#dynamicPaymentAmount').attr('required', true);
                } else {
                    $('#dynamicAdditionalFields').hide();
                    $('#dynamicAuditor').removeAttr('required');
                    $('#dynamicPaymentAmount').removeAttr('required');
                }

                // Open the modal
                $('#dynamicModal').modal('show');
            });

            $(document).on('change', '#dynamicStatus', function () {
                const selectedStatus = $(this).val(); // Get the selected status
                const dynamicAuditId = $('#dynamicAuditId').val();
                if (selectedStatus === 'Auditor Assigned') {
                    get_specialization_auditors(dynamicAuditId);
                    // If the selected status is "Auditor Assigned", show the hidden section
                    $('#dynamicAuditor').attr('required', true); // Make the auditor dropdown required
                    $('#dynamicPaymentAmount').attr('required', true); // Make the payment amount required
                    $('#dynamicAdditionalFields').show(); // Show the hidden section
                } else {
                    // If the selected status is anything else, hide the hidden section
                    $('#dynamicAuditor').removeAttr('required'); // Remove the required attribute
                    $('#dynamicPaymentAmount').removeAttr('required'); // Remove the required attribute
                    $('#dynamicAdditionalFields').hide(); // Hide the hidden section
                }
            });

            // Dynamically bind modals to buttons
            $(document).on('click', '.open-status-modal', function () {
                const auditId = $(this).data('id'); // Get the audit ID from the button
                const modal = $(`#exampleModal${auditId}`); // Find the corresponding modal
                if (modal.length) {
                    modal.modal('show'); // Show the modal
                } else {
                    console.error('Modal not found for audit ID:', auditId); // Log an error if the modal is not found
                }
            });

            function get_specialization_auditors(audit_id){
                $.ajax({
                    url : "{{ route('audit.get-specialization-auditors') }}",
                    type : "POST",
                    data : { audit_id : audit_id, _token : "{{ csrf_token() }}" },
                    success : function(resp){
                        $('#dynamicAuditor').empty();
                        $('#dynamicAuditor').append('<option value="" selected disabled>Select Auditor</option>');
                        resp.forEach(function (auditor) {
                            $('#dynamicAuditor').append(
                                `<option value="${auditor.id}">${auditor.name}</option>`
                            );
                        });
                    },
                    error : function(resp){
                        console.error('Error fetching auditors:', resp);
                        alert('Failed to load auditors. Please try again.');
                    }
                });
            }
        });

    </script>
    
    @endsection