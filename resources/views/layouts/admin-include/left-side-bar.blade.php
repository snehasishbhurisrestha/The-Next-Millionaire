<div id="left-sidebar" class="sidebar">
    <h5 class="brand-name">{{ config('app.name', 'Laravel') }}<a href="javascript:void(0)" class="menu_option float-right"><i class="icon-grid font-16" data-toggle="tooltip" data-placement="left" title="Grid & List Toggle"></i></a></h5>
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu-uni">Admin</a></li>
        {{-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu-admin">Admin</a></li> --}}
    </ul>
    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="menu-uni" role="tabpanel">
            <nav class="sidebar-nav">
                <ul class="metismenu">
                    <li class="active"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
                    
                    @canany(['Permission Show', 'Role Show'])
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-lock"></i><span>Roles Permissions</span>
                        </a>
                        <ul>
                            @can('Role Show')
                            <li><a href="{{ route('roles') }}">Roles</a></li>
                            @endcan
                            @can('Permission Show')
                            <li><a href="{{ route('permission') }}">Permission</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany

                    @can('Settings Show')
                    <li class="active"><a href="{{ route('settings.index') }}"><i class="fa fa-cog"></i><span>Settings</span></a></li>
                    @endcan

                    {{-- @can('Auditor Show')
                    <li><a href="{{ route('auditors.index') }}"><i class="fa fa-black-tie"></i><span>Auditors</span></a></li>
                    @endcan

                    @can('Users Show')
                    <li><a href="{{ route('users.index') }}"><i class="fa fa-users"></i><span>Users</span></a></li>
                    @endcan --}}

                    @canany(['Auditor Show', 'Users Show', 'System User Show'])
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-users"></i><span>Users</span>
                        </a>
                        <ul>
                            {{-- @can('Auditor Show')
                            <li><a href="{{ route('auditors.index') }}">Auditors</a></li>
                            @endcan --}}
                            @can('Users Show')
                            <li><a href="{{ route('users.index') }}">Course Users</a></li>
                            @endcan
                            @can('System User Show')
                            <li><a href="{{ route('system-user.index') }}">System Users</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany

                    {{-- @can('Audit Show')
                    <li><a href="{{ route('audit.index') }}"><i class="fa fa-file"></i><span>Audit Enquiry</span></a></li>
                    @endcan --}}

                    {{-- @canany(['Certification Type Show', 'Business Category Show', 'Checklist Categorie Show'])
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-database"></i><span>Master Data</span>
                        </a>
                        <ul>
                            @can('Business Category Show')
                            <li><a href="{{ route('business-category.index') }}">Business Category</a></li>
                            @endcan
                            @can('Certification Type Show')
                            <li><a href="{{ route('certification-type.index') }}">Certification Type</a></li>
                            @endcan
                            @can('Checklist Categorie Show')
                            <li><a href="{{ route('checklist-categorie.index') }}">Checklist Categories</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany --}}

                    {{-- @canany(['Blog Show', 'Blog Category Show'])
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-align-left"></i><span>Blogs</span>
                        </a>
                        <ul>
                            @can('Blog Category Show')
                            <li><a href="{{ route('blog-category.index') }}">Blog Category</a></li>
                            @endcan
                            @can('Blog Show')
                            <li><a href="{{ route('blog.index') }}">Blog</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany --}}


                    {{-- @canany(['Lead Show'])
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-envelope"></i><span>Contact Us</span>
                        </a>
                        <ul>
                            @can('Lead Show')
                            <li><a href="{{ route('lead.index') }}">All Contact Us</a></li>
                            @endcan
                            @can('Lead Show')
                            <li><a href="{{ route('leads.new-leades') }}">New Contact Us</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany --}}

                    @can('Lead Show')
                    <li><a href="{{ route('lead.index') }}"><i class="fa fa-envelope"></i><span>Contact Us</span></a></li>
                    @endcan

                    @can('Cource Show')
                    <li><a href="{{ route('cource.index') }}"><i class="fa fa-align-left"></i><span>Course</span></a></li>
                    @endcan
                    
                    {{-- @canany(['Cource Show', 'Exams Show'])
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-align-left"></i><span>Cource & Exams</span>
                        </a>
                        <ul>
                            @can('Cource Show')
                            <li><a href="{{ route('cource.index') }}">Cource</a></li>
                            @endcan
                            @can('Exam Show')
                            <li><a href="{{ route('exam.index') }}">Exams</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany --}}

                    {{-- for auditor wallet transaction --}}
                    {{-- @if(Auth::user()->hasRole('Auditor'))
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-money"></i><span>Wallet</span>
                        </a>
                        <ul>
                            <li><a href="{{ route('auditor.wallet.transactions') }}">Transaction</a></li>
                        </ul>
                    </li>
                    @endif --}}

                    @can('Testimonial Show')
                    <li class="active"><a href="{{ route('testimonial.index') }}"><i class="fa fa-comment"></i><span>Testimonial</span></a></li>
                    @endcan

                    @canany(['Enrollments Show','Transactions Show','Withdraw Show'])
                    <li class="{{ request()->is('admin/enrollments*') || request()->is('admin/transactions*') || request()->is('admin/withdraws*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="has-arrow">
                            <i class="fa fa-graduation-cap"></i>
                            <span>Course Management</span>
                        </a>

                        <ul>

                            @can('Enrollments Show')
                            <li class="{{ request()->is('admin/enrollments*') ? 'active' : '' }}">
                                <a href="{{ route('admin.enrollments.index') }}">
                                    <i class="fa fa-check-circle"></i> Enrollments
                                </a>
                            </li>
                            @endcan

                            @can('Transactions Show')
                            <li class="{{ request()->is('admin/transactions*') ? 'active' : '' }}">
                                <a href="{{ route('admin.transactions.index') }}">
                                    <i class="fa fa-credit-card"></i> Transactions
                                </a>
                            </li>
                            @endcan

                            @can('Withdraw Show')
                            <li class="{{ request()->is('admin/withdraws*') ? 'active' : '' }}">
                                <a href="{{ route('admin.withdraw.index') }}">
                                    <i class="fa fa-wallet"></i> Withdraw Requests
                                </a>
                            </li>
                            @endcan

                        </ul>
                    </li>
                    @endcanany


                </ul>
            </nav>
        </div>
    </div>
</div>