@extends('layouts.web-app')

@section('title') Certification @endsection

@section('content')
<main>

    <article class="article">
        <section class="topBanner heroSection bsb-hero-5 px-3 bsb-overlay mt-5"
            style="background-image: url('{{ asset('assets/site-assets/img/banner/banner1.jpg') }}');">
            <div class="container">
            <div class="row align-items-center">
                <!-- Left empty column -->
                <div class="col-12 col-md-2"></div>
                <!-- Content column -->
                <div class="col-12 col-md-8 text-start gerw">
                <h2 class="text-center text-start fw-bold mb-4" style="font-size: 50px;">Certification</h2>

                <p class="lead text-white mb-5"> There are three ways to ultimate success: The first way is to be kind.
                    The second way is to be kind. The third way is to be kind.</p>
                </div>
                <div class="col-12 col-md-2"></div>
            </div>
            </div>
        </section>
      
        <section class="fre_cunsultend4 certificate_card">
            <div class="container">
                <div class="row">
                    <h2 class="text-dark text-center fw-bold mb-4" style="font-size: 40px;">Certified for Trust & Quality</h2>
                    <div class="text-design">
                        <div class="d-flex flex-wrap col-lg-12 ">
                            @foreach($certificates as $item)
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{ $item->getFirstMediaUrl('certificate-image') }}" class="card-img-top" alt="{{ $item->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->name }}</h5>
                                        <p class="card-text">{{ $item->description }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- Pagination -->
                        @if ($certificates->hasPages())
                        <nav aria-label="Certificates Pagination">
                            <ul class="pagination justify-content-center">
                                <!-- Previous Button -->
                                @if ($certificates->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $certificates->previousPageUrl() }}" aria-label="Previous">
                                            Previous
                                        </a>
                                    </li>
                                @endif

                                <!-- Page Numbers -->
                                @foreach ($certificates->getUrlRange(1, $certificates->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $certificates->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <!-- Next Button -->
                                @if ($certificates->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $certificates->nextPageUrl() }}" aria-label="Next">
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