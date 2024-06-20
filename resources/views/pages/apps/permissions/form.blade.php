<x-default-layout :title="$title">
    @section('title')
        {{ $title }}
    @endsection
    @section('breadcrumbs')
        {!! $breadcrumbs !!}
    @endsection
    <form id="kt_modal_add_permission_form" class="form" method="POST" action="{{ $actionUrl }}" enctype="multipart/form-data">
        @csrf
        @method($method)
        <input type="hidden" name="permission_id" value="{{ @$permission_id }}"/>
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column gap-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control  form-control-sm mb-3 mb-lg-0" placeholder="Enter name of the permission" value="{{ @$permission->name }}"/>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-footer p-5">
                <div class="text-end">
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary me-3 btn-sm" aria-label="Close">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm" data-kt-permissiones-modal-action="submit">
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
