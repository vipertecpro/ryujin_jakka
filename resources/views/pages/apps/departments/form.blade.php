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
                                <input type="text" id="name" name="name" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter department name" value="{{ @$formData->name }}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="status">Status</label>
                                <select name="status" id="status" class="form-select form-select-sm mb-3 mb-lg-0" data-control="select2" data-placeholder="Select an status">
                                    <option></option>
                                    <option value="active" {{ @$formData->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="in-active" {{ @$formData->status === 'in-active' ? 'selected' : '' }}>In-active</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="fv-row mb-2">
                                <label class="fw-semibold fs-6 mb-2" for="description">Description</label>
                                <textarea type="text" id="description" name="description" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter description">{{ @$formData->description }}</textarea>
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
