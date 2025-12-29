@extends('layouts.app')

    @section('title') Leades @endsection
    
    @section('style')
    <style>
        .inq-container{
            width:100%;
        }
        .inq-row{
            width:100%;
            display:flex;
            flex-wrap:wrap;
        }
        .inq-item{
            width:50%;
            display: flex;
            align-items: center;
        }
        .inq-label{
            color:#000000;
            font-size: 14px;
            width:35%;
            /* font-weight: bolder; */
        }
        .inq-label::after{
        content: ':';
        }
        .inq-value{
            font-size: 14px;
            width:65%;
            padding-left: 10px;
        }
        .form-actions {
            padding: 0!important;
        }
    </style>
    @endsection

    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Leades</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Leades</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}
                    <li class="nav-item"><a class="btn btn-info" href="{{ route('lead.index') }}"><i class="fa fa-arrow-left me-2"></i>Back</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="section-body mt-4">
        <div class="container-fluid">
            <div class="tab-content">
                <div class="tab-pane active" id="Student-all">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Business User Details</h3>
                            <div class="card-options">
                                <a href="#" class="card-options-collapse" data-toggle="card-collapse">
                                    <i class="fe fe-chevron-up"></i>
                                </a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove">
                                    <i class="fe fe-x"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body" style="padding-left: 69px;">
                            <div id="select_all_frm" name="select_all_frm">
                                <div id="inq-wrapper">
                                    <div class="inq-container">
                                        <div class="inq-row">
                                            <div class="inq-item">
                                                <p class="inq-label">Name</p>
                                                <p class="inq-value">{{ $item->first_name .' '. $item->last_name }}</p>
                                            </div>
                                            <div class="inq-item">
                                                <p class="inq-label">Business Name</p>
                                                <p class="inq-value">{{ $item->business_name }}</p>
                                            </div>
                                            <div class="inq-item">
                                                <p class="inq-label">Email</p>
                                                <p class="inq-value">{{ $item->email }}</p>
                                            </div>
                                            <div class="inq-item">
                                                <p class="inq-label">Business category</p>
                                                <p class="inq-value">{{ $item->category?->name }}</p>
                                            </div>
                                            <div class="inq-item">
                                                <p class="inq-label">Mobile No</p>
                                                <p class="inq-value">{{ $item->phone }}</p>
                                            </div>
                                            <div class="inq-item">
                                                <p class="inq-label">Business Address</p>
                                                <p class="inq-value">{{ $item->business_address }}</p>
                                            </div>
                                            <div class="inq-item">
                                                <p class="inq-label">Alternate No</p>
                                                <p class="inq-value">{{ $item->opt_mobile_no }}</p>
                                            </div>
                                            <div class="inq-item">
                                                <p class="inq-label">Contact Person</p>
                                                <p class="inq-value">{{ $item->contact_person }}</p>
                                            </div>
                                            
                                            <div class="inq-item">
                                                <p class="inq-label">Gender</p>
                                                <p class="inq-value">{{ ucfirst($item->gender) }}</p>
                                            </div>
                                            <div class="inq-item">
                                                <p class="inq-label">Status</p>
                                                <p class="inq-value">{{ ucfirst($item->status) }}</p>
                                            </div>
                                            <div class="inq-item">
                                                <p class="inq-label">Message</p>
                                                <p class="inq-value">{{ $item->message }}</p>
                                            </div>
                                            <div class="inq-item">
                                                <p class="inq-label">Next Follow Up Date</p>
                                                <p class="inq-value">{{ $item->latestFollowUp?->next_follow_up_date ? format_date($item->latestFollowUp?->next_follow_up_date) : '' }}</p>
                                            </div>
                                        </div>
                                    </div>
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
            <div class="tab-content">
                <div class="tab-pane active" id="Student-all">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Follow Up History</h3>
                            <div class="card-options">
                                <a href="#" class="card-options-collapse" data-toggle="card-collapse">
                                    <i class="fe fe-chevron-up"></i>
                                </a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove">
                                    <i class="fe fe-x"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body" style="padding-left: 69px;">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Remark</th>
                                            <th>Remark By</th>
                                            <th>Followuped At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($followups as $followup)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $followup->remarks }}</td>
                                            <td>{{ $followup->remarkedBy?->name }}</td>
                                            <td>{{ format_datetime($followup->created_at) }}</td>
                                        </tr>
                                        @endforeach
                                        @can('Lead Followup')
                                        <tr>
                                            <td colspan="4" class="text text-center">
                                                <a href="javascript:void(0);" class="btn btn-outline-success" data-toggle="modal" data-target="#dynamicModal" aria-expanded="false">
                                                <i class="fa fa-plus me-2"></i> Add Followup Status
                                                </a>
                                            </td>
                                        </tr>
                                        @endcan
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Followup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('leads.add-followup-status') }}" method="post" class="custom-validation" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="inquiry_id" value="<?= $item->id; ?>" id="inquiry_id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label" for="rmark">Remark / Message</label>
                        <textarea class="form-control" id="rmark" name="remarks" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inqstatus">Inquiry Status</label>
                        <select class="form-control" name="status" id="inqstatus" required>
                            <option selected value="">Choose...</option>
                            <option value="in progress">In Progress</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="not interested">Not Interested</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid state.
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="form-label" for="nctfollow">Next Followup Date</label>
                        <div>
                            <input class="form-control" type="date" name="next_followup_date" value="" id="nctfollow">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="mdi mdi-check-bold"></i> Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="mdi mdi-cancel"></i> Cancel</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    @endsection