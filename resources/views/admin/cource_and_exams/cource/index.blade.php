@extends('layouts.app')

    @section('title') Course @endsection
    
    @section('content')

    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-action">
                    <h1 class="page-title">Course</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    {{-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Student-all" id="list-tab">List</a></li> --}}
                    @can('Course Create')
                    <li class="nav-item"><a class="btn btn-info" href="{{ route('cource.create') }}"><i class="fa fa-plus"></i>Add New</a></li>
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
                                            <th>Slug</th>
                                            <th>Video</th>
                                            <th>Price</th>
                                            <th>Created At</th>
                                            <th></th>
                                            @canany(['Course Edit','Course Delete'])
                                            <th>Action</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($courses as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><span class="font-16">{{ $item->title }}</span></td>
                                            <td>{{ $item->slug }}</td>
                                            <td>
                                                {{-- @if($item->hasMedia('course-video'))
                                                    <video width="120" controls>
                                                        <source src="{{ $item->getFirstMediaUrl('course-video') }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @else
                                                    <span>No video</span>
                                                @endif --}}
{{-- 
                                                @if($item->video_url)
                                                    @php
                                                        $videoId = '';

                                                        // Match normal YouTube links (watch?v=)
                                                        if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $item->video_url, $matches)) {
                                                            $videoId = $matches[1];
                                                        }
                                                        // Match youtu.be links
                                                        elseif (preg_match('/youtu\.be\/([^?]+)/', $item->video_url, $matches)) {
                                                            $videoId = $matches[1];
                                                        }
                                                        // Match YouTube Shorts links
                                                        elseif (preg_match('/youtube\.com\/shorts\/([^?]+)/', $item->video_url, $matches)) {
                                                            $videoId = $matches[1];
                                                        }
                                                    @endphp

                                                    @if($videoId)
                                                        <iframe height="100"
                                                                src="https://www.youtube.com/embed/{{ $videoId }}"
                                                                frameborder="0"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen>
                                                        </iframe>
                                                    @endif
                                                @endif --}}

                                                @if($item->video_url)
                                                    {!! $item->video_url !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->offer_price)
                                                    <del class="mx-3">{{ $item->price }}</del>
                                                    {{ $item->offer_price }}
                                                @else
                                                    {{ $item->price }}
                                                @endif
                                            </td>
                                            <td>{{ format_datetime($item->created_at) }}</td>
                                            <td>{!! check_visibility($item->is_visible) !!}</td>
                                            @canany(['Course Edit','Course Delete'])
                                            <td>
                                                <a href="{{ route('cource-content.index',$item->id) }}" class="btn btn-info btn-sm">Course Content</a>
                                                @can('Course Edit')
                                                <a href="{{ route('cource.edit',$item->id) }}" class="btn btn-icon btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                                @endcan
                                                @can('Course Delete')
                                                <form action="{{ route('cource.destroy',$item->id) }}" method="POST" style="display:inline;">
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
    </div>

    @endsection