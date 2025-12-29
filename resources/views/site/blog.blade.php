@extends('layouts.web-app')

@section('title') Blog @endsection

@section('content')

<main>

    <article class="article">
        <section class="topBanner heroSection bsb-hero-5 px-3 bsb-overlay mt-5" style="background-image: url('{{ asset('assets/site-assets/img/photo/world.png') }}');height: 500px;">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left empty column -->
                    <div class="col-12 col-md-2"></div>
                    <!-- Content column -->
                    <div class="col-12 col-md-8 text-start gerw">
                        <h2 class="text-center text-start fw-bold mb-4" style="font-size: 50px;">Blog</h2>
        
                        <p class="lead text-white mb-5"> Inkspiration Awaits: Explore Our Latest Tattoo Stories!</p>
                    </div>
                    <div class="col-12 col-md-2"></div>
                </div>
            </div>
        </section>
  
        <section class="fre_cunsultend4">
            <div class="container">
                <div class="row">
                    <h2 class="text-dark text-center fw-bold mb-4" style="font-size: 40px;">Inkspiration Awaits: Explore Our Latest Tattoo Stories!</h2>
                    <div class="text-design">
                        <div class="d-flex flex-wrap col-lg-12 ">
                            @foreach($blogs as $blog)
                            <div class="col-lg-4">
                                <div class="card" style="width: 18rem;">
                                    <img class="card-img-top" src="{{ $blog->getFirstMediaUrl('blog-image') }}" alt="Card image cap" >
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $blog->title }}</h5>
                                        <p class="card-text">{!! $blog->sort_description !!}</p>
                                        <a href="{{ route('blogs.details',$blog->slug) }}" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- Pagination -->
                        @if ($blogs->hasPages())
                        <nav aria-label="Blog Pagination">
                            <ul class="pagination justify-content-center">
                                <!-- Previous Page Link -->
                                @if ($blogs->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $blogs->previousPageUrl() }}" aria-label="Previous">
                                            Previous
                                        </a>
                                    </li>
                                @endif

                                <!-- Pagination Elements -->
                                @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $blogs->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($blogs->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $blogs->nextPageUrl() }}" aria-label="Next">
                                            Next
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                        @endif

                    </div>
                </div>
            </div>
        </section>
  
    </article>
</main>

@endsection