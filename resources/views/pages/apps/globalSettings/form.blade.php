<x-default-layout :title="$title">
    @section('title')
        {{ $title }}
    @endsection
    @section('breadcrumbs')
        {!! $breadcrumbs !!}
    @endsection
    <form id="kt_modal_globalSettings_form" class="form" method="POST" action="{{ $actionUrl }}" enctype="multipart/form-data">
        @csrf
        @method($method)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#generalSettings">General</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="generalSettings" role="tabpanel">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="fv-row fv-plugins-icon-container mb-2">
                                        <label class="col-form-label required" for="site_title">Title of the site</label>
                                        <input type="text" name="key[TEXT][site_title]"
                                               class="form-control form-control-sm"
                                               placeholder="Enter site title"
                                               id="site_title"
                                               value="{{ getGlobalSetting('site_title') }}">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <label class="col-form-label" for="favicon">Favicon</label>
                                    <div class="input-group">
                                        <input type="file" name="key[FILE][favicon]" id="favicon" class="form-control form-control-sm">
                                        @if(getGlobalSetting('favicon'))
                                            <a href="{{ getGlobalSetting('favicon') }}" target="_blank" class="btn btn-sm btn-secondary" type="button">View</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <label class="col-form-label" for="logo">Logo</label>
                                    <div class="input-group">
                                        <input type="file" name="key[FILE][logo]" id="logo" class="form-control form-control-sm">
                                        @if(getGlobalSetting('logo'))
                                            <a href="{{ getGlobalSetting('logo') }}" target="_blank" class="btn btn-sm btn-secondary" type="button">View</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <label class="col-form-label" for="login_banner">Login Banner</label>
                                    <div class="input-group">
                                        <input type="file" name="key[FILE][login_banner]" id="login_banner" class="form-control form-control-sm">
                                        @if(getGlobalSetting('login_banner'))
                                            <a href="{{ getGlobalSetting('login_banner') }}" target="_blank" class="btn btn-sm btn-secondary" type="button">View</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <label class="col-form-label" for="gst">GST (%)</label>
                                    <div class="input-group">
                                        <input type="text" name="key[TEXT][gst]" id="gst" class="form-control form-control-sm" value="{{ getGlobalSetting('gst') }}" placeholder="Enter the gst">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <label class="col-form-label" for="gst">CGST (%)</label>
                                    <div class="input-group">
                                        <input type="text" name="key[TEXT][cgst]" id="gst" class="form-control form-control-sm" value="{{ getGlobalSetting('cgst') }}" placeholder="Enter the cgst">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer p-5">
                <div class="text-end">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary me-3 btn-sm" aria-label="Close">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm" data-kt-rolees-modal-action="submit">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">
                            Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-default-layout>
