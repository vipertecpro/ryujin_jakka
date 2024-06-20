<x-default-layout  :title="$title">
    @section('title')
        {{ $title }}
    @endsection
    @section('breadcrumbs')
        {!! $breadcrumbs !!}
    @endsection
    <form id="kt_form" class="form" method="POST" action="{{ $actionUrl }}" enctype="multipart/form-data">
        @csrf
        @method($method)
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column gap-5">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control  form-control-sm mb-3 mb-lg-0" placeholder="Enter name of the branch" value="{{ @$formData->name }}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="code">Code</label>
                                <input type="text" id="code" name="code" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter name of the code" value="{{ @$formData->code }}"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="country">Country</label>
                                <input type="text" id="country" name="country" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter name of the country" value="{{ @$formData->country }}"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="state" >State</label>
                                <input type="text" id="state" name="state" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter state" value="{{ @$formData->state }}"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="postal_code" >Postal Code</label>
                                <input type="text" id="postal_code" name="postal_code" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter postal code" value="{{ @$formData->postal_code }}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="email">Email</label>
                                <input type="text" id="email" name="email" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter email address" value="{{ @$formData->email }}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="phone" >Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter phone" value="{{ @$formData->phone }}"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="address" >Address</label>
                                <textarea type="text" id="address" name="address" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter address">{{ @$formData->address }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer p-5">
                <div class="text-end">
                    <a href="{{ $redirectTo }}" class="btn btn-secondary me-3 btn-sm" aria-label="Close">Cancel</a>
                    <button type="button" class="btn btn-primary btn-sm" data-kt-branches-modal-action="submit" id="kt_form_submit">
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
