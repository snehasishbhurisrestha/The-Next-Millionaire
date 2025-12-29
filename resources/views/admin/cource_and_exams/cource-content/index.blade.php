@extends('layouts.app')

@section('title') Course Content @endsection

@section('style')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
@endsection

@section('content')

<div class="section-body">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="header-action">
                <h1 class="page-title">Course Content</h1>
                <ol class="breadcrumb page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cource.index') }}">Course</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Course Content</li>
                </ol>
            </div>
            <ul class="nav nav-tabs page-header-tab">
                <li class="nav-item"><a class="btn btn-info" href="{{ route('cource.index') }}"><i class="fa fa-arrow-left me-2"></i>Back</a></li>
                @can('Course Content Create')
                <li class="nav-item">
                    <a class="btn btn-info" href="{{ route('cource-content.create', request()->segment(2)) }}">
                        <i class="fa fa-plus"></i> Add New
                    </a>
                </li>
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
                                        <th>Sl No.</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Content</th>
                                        <th>Created At</th>
                                        @canany(['Course Content Edit', 'Course Content Delete'])
                                        <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach($contents as $item)
                                    <tr data-id="{{ $item->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $item->title }}</strong></td>

                                        {{-- ✅ Show content type --}}
                                        <td>
                                            @if($item->content_type == 'text')
                                                <span class="badge bg-primary">Text</span>
                                            @elseif($item->content_type == 'video')
                                                <span class="badge bg-success">Video</span>
                                            @elseif($item->content_type == 'pdf')
                                                <span class="badge bg-danger">PDF</span>
                                            @endif
                                        </td>

                                        {{-- ✅ Show content preview depending on type --}}
                                        <td>
                                            @if($item->content_type == 'text')
                                                <span class="font-16">
                                                    {{ \Illuminate\Support\Str::words(strip_tags($item->content), 20, '...') }}
                                                </span>


                                            @elseif($item->content_type == 'video')
                                                {{-- @if($item->getFirstMediaUrl('videos'))
                                                    <video width="250" height="150" controls>
                                                        <source src="{{ $item->getFirstMediaUrl('videos') }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @else
                                                    <span class="text-danger">No video uploaded</span>
                                                @endif --}}

                                                @if($item->video_url)
                                                    {!! $item->video_url !!}
                                                @endif

                                            @elseif($item->content_type == 'pdf')
                                                @if($item->getFirstMediaUrl('pdfs'))
                                                    <a href="{{ $item->getFirstMediaUrl('pdfs') }}" target="_blank" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-file-pdf-o"></i> View PDF
                                                    </a>
                                                @else
                                                    <span class="text-danger">No PDF uploaded</span>
                                                @endif

                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>



                                        <td>{{ format_datetime($item->created_at) }}</td>

                                        @canany(['Course Content Edit','Course Content Delete'])
                                        <td>
                                            @can('Course Content Edit')
                                            <a href="{{ route('cource-content.edit',[$item->id,request()->segment(2)]) }}" class="btn btn-icon btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                            @endcan
                                            @can('Course Content Delete')
                                            <form action="{{ route('cource-content.destroy',$item->id) }}" method="POST" style="display:inline;">
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
            update: function () {
                $('#sortable tr').each(function (index) {
                    $(this).find('td:eq(0)').text(index + 1);
                });

                let order = [];
                $('#sortable tr').each(function (index) {
                    order.push({
                        id: $(this).data('id'),
                        position: index + 1
                    });
                });

                $.ajax({
                    url: "{{ route('cource-content.sort', request()->segment(2)) }}",
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
