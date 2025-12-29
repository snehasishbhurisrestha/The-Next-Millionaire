@extends('layouts.app')

@section('title', 'Website Settings')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Website Settings</h5>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#general" role="tab">General</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#branding" role="tab">Branding</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#payment" role="tab">Payment</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#contact" role="tab">Contact</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#social" role="tab">Social</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#scripts" role="tab">SEO Tags Manager</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#refbo" role="tab">Referal Bonus</a></li>
            </ul>

            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="tab-content mt-4">

                    {{-- General --}}
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Application Name</label>
                                <input type="text" name="app_name" class="form-control" value="{{ old('app_name', $setting->app_name ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Site Title</label>
                                <input type="text" name="site_title" class="form-control" value="{{ old('site_title', $setting->site_title ?? '') }}">
                            </div>
                            {{-- <div class="col-md-6 mb-3">
                                <label>Coupon Offer Text</label>
                                <input type="text" name="coupon_offer_text" class="form-control" value="{{ old('coupon_offer_text', $setting->coupon_offer_text ?? '') }}">
                            </div> --}}
                            <div class="col-md-12 mb-3">
                                <label>Maintenance Mode</label><br>
                                <label class="form-check form-switch">
                                    <input type="checkbox" name="maintenance_mode" class="form-check-input" {{ !empty($setting->maintenance_mode) ? 'checked' : '' }}>
                                    Enable
                                </label>
                                <input type="text" name="maintenance_mode_text" class="form-control mt-2" placeholder="Maintenance message" value="{{ old('maintenance_mode_text', $setting->maintenance_mode_text ?? '') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Branding --}}
                    <div class="tab-pane fade" id="branding" role="tabpanel">
                        <div class="row">
                            @foreach (['logo' => 'Logo', 'favicon' => 'Favicon'] as $field => $label)
                                <div class="col-md-6 mb-3">
                                    <label>{{ $label }}</label><br>
                                    @php
                                        $mediaUrl = $setting?->getFirstMediaUrl($field);
                                    @endphp
                                    @if($mediaUrl)
                                        <img src="{{ $mediaUrl }}" alt="{{ $label }}" width="100" class="mb-2 rounded border"><br>
                                    @endif
                                    <input type="file" name="{{ $field }}" class="form-control">
                                </div>
                            @endforeach

                        </div>
                    </div>

                    {{-- Payment --}}
                    <div class="tab-pane fade" id="payment" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Razorpay Key</label>
                                <input type="text" name="razorpay_key" class="form-control" value="{{ old('razorpay_key', $setting->razorpay_key ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Razorpay Secret</label>
                                <input type="text" name="razorpay_secret" class="form-control" value="{{ old('razorpay_secret', $setting->razorpay_secret ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Company Name</label>
                                <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $setting->company_name ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Colour Code</label>
                                <input type="text" name="raz_colour_code" class="form-control" value="{{ old('raz_colour_code', $setting->raz_colour_code ?? '') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Contact --}}
                    <div class="tab-pane fade" id="contact" role="tabpanel">
                        <div class="row">
                            @foreach ([
                                'contact_phone_1' => 'Contact Phone 1',
                                'contact_phone_2' => 'Contact Phone 2',
                                'email_1' => 'Email 1',
                                'email_2' => 'Email 2',
                                'address_1' => 'Address 1',
                                'address_2' => 'Address 2'
                            ] as $name => $label)
                                <div class="col-md-6 mb-3">
                                    <label>{{ $label }}</label>
                                    <input type="text" name="{{ $name }}" class="form-control" value="{{ old($name, $setting->$name ?? '') }}">
                                </div>
                            @endforeach
                            <div class="col-md-12 mb-3">
                                <label>Google Map iFrame</label>
                                <textarea name="google_map_iframe" class="form-control" rows="3">{{ old('google_map_iframe', $setting->google_map_iframe ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Social --}}
                    <div class="tab-pane fade" id="social" role="tabpanel">
                        <div class="row">
                            @foreach ([
                                'facebook_link' => 'Facebook Link',
                                'twitter_link' => 'Twitter Link',
                                'youtube_link' => 'YouTube Link',
                                'linkedin_link' => 'LinkedIn Link'
                            ] as $name => $label)
                                <div class="col-md-6 mb-3">
                                    <label>{{ $label }}</label>
                                    <input type="text" name="{{ $name }}" class="form-control" value="{{ old($name, $setting->$name ?? '') }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Scripts --}}
                    <div class="tab-pane fade" id="scripts" role="tabpanel">
                        <div class="mb-3">
                            <label>Header Script</label>
                            <textarea name="header_script" class="form-control" rows="3">{{ old('header_script', $setting->header_script ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Footer Script</label>
                            <textarea name="footer_script" class="form-control" rows="3">{{ old('footer_script', $setting->footer_script ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- Referal Bonus --}}
                    <div class="tab-pane fade" id="refbo" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Referal Bonus Amount</label>
                                <input type="text" name="referal_bonus_amount" class="form-control" value="{{ old('referal_bonus_amount', $setting->referal_bonus_amount ?? '') }}">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">💾 Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
