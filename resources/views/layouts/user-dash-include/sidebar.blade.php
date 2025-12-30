<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('user-dashboard') }}">
        <div class="sidebar-brand-text mx-3"><img src="{{ asset('assets/site-assets/images/IMG_64610.png') }}" class="logo-img" alt=""></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-1">

    <!-- Heading -->
    <div class="sidebar-heading">
        Learning
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    @php
    use App\Models\Enrollment;

    $enrollments = Enrollment::with('course.contents')
        ->where('user_id', auth()->id())
        ->get();
    @endphp

    @foreach ($enrollments as $enrollment)
        @php
            $course = $enrollment->course;
            if (!$course) continue; // skip if course missing
            $lessons = $course->contents->sortBy('step_number');
        @endphp

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
                data-target="#collapseCourse{{ $course->id }}"
                aria-expanded="true" aria-controls="collapseCourse{{ $course->id }}">
                <i class="fas fa-fw fa-book"></i>
                <span>{{ $course->title ?? 'Course' }}</span>
            </a>

            <div id="collapseCourse{{ $course->id }}" class="collapse"
                aria-labelledby="headingCourse{{ $course->id }}" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Lessons:</h6>

                    @foreach($lessons as $lesson)
                        <a class="collapse-item {{ isset($currentLesson) && $currentLesson->id == $lesson->id ? 'active' : '' }}"
                        href="{{ route('learning.page', ['course_slug' => $course->slug, 'lesson_id' => $lesson->id]) }}">
                            {{-- Step {{ $lesson->step_number }}: {{ Str::limit($lesson->title, 15) }} --}}
                            LESSON {{ $lesson->step_number }}
                        </a>
                    @endforeach
                </div>
            </div>
        </li>
    @endforeach

    <!-- Divider -->
    <hr class="sidebar-divider my-1">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user-dashboard') }}">
            <i class="fas fa-handshake"></i>
            <span>Affiliate Program</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-1">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('community') }}">
            <i class="fas fa-users"></i>
            <span>Community</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-1">

    <!-- Heading -->
    <div class="sidebar-heading">
        Earning
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.transaction') }}">
            <i class="fas fa-wallet"></i>
            <span>Transaction</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-1">

    <!-- Withdrawals -->
    <li class="nav-item {{ request()->routeIs('user.withdrawals') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.withdrawals') }}">
            <i class="fas fa-hand-holding-usd"></i>
            <span>Withdrawals</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-1">

    <!-- Payment Account -->
    <li class="nav-item {{ request()->routeIs('user.payment.account') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.payment.account') }}">
            <i class="fas fa-credit-card"></i>
            <span>Payment Account</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-1 d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>