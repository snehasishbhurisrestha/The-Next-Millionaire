@extends('layouts.app')

    @section('title') Exam Questions @endsection

    @section('style')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    @endsection

    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Exam Questions</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Course</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Exam Questions</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    <li class="nav-item"><a class="btn btn-info" href="{{ route('exam.index') }}"><i class="fa fa-arrow-left me-2"></i>Back</a></li>
                    @can('Exam Questions Create')
                    <li class="nav-item"><a class="btn btn-info" href="{{ route('exam-questions.create',request()->segment(2)) }}"><i class="fa fa-plus"></i>Add New</a></li>
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
                                <table class="table table-hover table-striped table_custom border-style spacing5">
                                    <thead class="table-light">
                                        <tr>
                                            {{-- <th>#</th> <!-- This is for the drag handle --> --}}
                                            <th>Sl No.</th>
                                            <th>Question</th>
                                            <th>Option A</th>
                                            <th>Option B</th>
                                            <th>Option C</th>
                                            <th>Option D</th>
                                            <th>Correct Answer</th>
                                            <th>Created At</th>
                                            @canany(['Exam Questions Edit','Exam Questions Delete'])
                                            <th>Action</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody id="sortable">
                                        @foreach($contents as $item)
                                        <tr data-id="{{ $item->id }}">
                                            {{-- <td class="drag-handle"><i class="fa fa-arrows-alt"></i></td> <!-- Drag Handle --> --}}
                                            <td class="text-wrap">{{ $loop->iteration }}</td>
                                            <td class="text-wrap"><span class="font-16">{{ $item->question }}</span></td>
                                            <td class="text-wrap"><span class="font-16">{{ $item->option_a }}</span></td>
                                            <td class="text-wrap"><span class="font-16">{{ $item->option_b }}</span></td>
                                            <td class="text-wrap"><span class="font-16">{{ $item->option_c }}</span></td>
                                            <td class="text-wrap"><span class="font-16">{{ $item->option_d }}</span></td>
                                            <td class="text-wrap"><span class="font-16">{{ ucfirst($item->correct_answer) }}</span></td>
                                            <td class="text-wrap">{{ format_datetime($item->created_at) }}</td>
                                            @canany(['Exam Questions Edit','Exam Questions Delete'])
                                            <td>
                                                @can('Exam Questions Edit')
                                                <a href="{{ route('exam-questions.edit',[request()->segment(2),$item->id]) }}" class="btn btn-icon btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                                @endcan
                                                @can('Exam Questions Delete')
                                                <form action="{{ route('exam-questions.destroy',$item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-icon btn-sm" onclick="return confirm('Are you sure?')" type="submit"><i class="fa fa-trash-o text-danger"></i></button>
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
    </div>

    @endsection

    @section('script')
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#sortable").sortable({
                update: function (event, ui) {
                    // Update Sl No. dynamically on the frontend
                    $('#sortable tr').each(function (index) {
                        $(this).find('td:eq(0)').text(index + 1); // Update the 2nd column (Sl No.)
                    });

                    // Prepare data for backend
                    let order = [];
                    $('#sortable tr').each(function (index) {
                        order.push({
                            id: $(this).data('id'),
                            position: index + 1
                        });
                    });

                    // Send AJAX request to save order in DB
                    $.ajax({
                        url: "{{ route('exam-questions.sort', request()->segment(2)) }}",
                        method: 'POST',
                        data: {
                            order: order,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            toastr.success('Order updated successfully!');
                        },
                        error: function () {
                            toastr.error('Something went wrong while updating order.');
                        }
                    });
                }
            });

            $("#sortable").disableSelection();
        });
    </script>


    @endsection