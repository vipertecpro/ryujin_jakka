@php use Illuminate\Support\Facades\Auth; @endphp
<x-default-layout :title="$title">
    @section('title')
        {{ $title }}
    @endsection
    @section('breadcrumbs')
        {!! $breadcrumbs !!}
    @endsection
    <form id="kt_form" class="form" method="POST" action="{{ $actionUrl }}" enctype="multipart/form-data">
        @csrf
        @method($method)
        <input type="hidden" name="w_employee_id" value="{{ @$formData->w_employee_id ?? Auth::id() }}" />
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column gap-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="leaveTypes">Leave Type</label>
                                <select id="leaveTypes" name="leave_type_id" class="form-select form-select-sm mb-3 mb-lg-0">
                                    <option value="">Select Type</option>
                                    @foreach($leaveTypes as $leaveType)
                                        <option value="{{ $leaveType->id }}" @if($leaveType->id === @$formData->leave_type_id) selected @endif>{{ $leaveType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="startDate">Start Date</label>
                                <input type="text" class="form-control form-control-sm" id="startDate" name="start_date" value="{{ @$formData->start_date?->format('d-m-Y') }}" placeholder="Select date"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="endDate">End Date</label>
                                <input type="text" class="form-control form-control-sm" id="endDate" name="end_date" value="{{ @$formData->end_date?->format('d-m-Y') }}" placeholder="Select date"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer p-5">
                <div class="text-end">
                    <a href="{{ $redirectTo }}" class="btn btn-secondary me-3 btn-sm" aria-label="Close">Cancel</a>
                    <button type="button" class="btn btn-primary btn-sm" data-kt-branches-modal-action="submit"
                            id="kt_form_submit">
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
    @push('scripts')
        <script>
            $('#startDate').flatpickr({
                dateFormat: "d-m-Y",
                minDate: "today",
            });
            $('#endDate').flatpickr({
                dateFormat: "d-m-Y",
                minDate: "today",
            });
        </script>
    @endpush
</x-default-layout>
