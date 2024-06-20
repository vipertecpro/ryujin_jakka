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
                        <div class="col-md-4">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter name" value="{{ @$formData->name }}"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="total_days">Total Days</label>
                                <input type="text" id="total_days" name="total_days" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter total days" value="{{ @$formData->total_days }}"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="type">Type</label>
                                <select id="type" name="type" class="form-select form-select-sm mb-3 mb-lg-0">
                                    <option value="">Select Type</option>
                                    <option value="annual" {{ @$formData->type == 'annual' ? 'selected' : '' }}>Annual</option>
                                    <option value="monthly" {{ @$formData->type == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="single" {{ @$formData->type == 'single' ? 'selected' : '' }}>Single</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="fv-row mb-2">
                                <label class="required fw-semibold fs-6 mb-2" for="conditions">Conditions</label>
                                <table class="table table-bordered table-hover" id="kt_conditionTable">
                                    <thead>
                                        <tr>
                                            <th class="w-200px">Condition Type</th>
                                            <th class="w-600px">Condition Description</th>
                                            <th class="w-10px">
                                                <button type="button" class="btn btn-sm btn-primary" id="addCondition">
                                                    <i class="fa fa-plus-circle z-0"></i>
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(@$formData->conditions)
                                            @foreach(@$formData->conditions['conditionType'] as $key => $conditionType)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="conditions[conditionType][]" class="form-control form-control-sm" value="{{ $conditionType }}" placeholder="Enter condition type"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="conditions[conditionDescriptions][]" class="form-control form-control-sm" value="{{ @$formData->conditions['conditionDescriptions'][$key] }}" placeholder="Enter condition description"/>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger removeCondition">
                                                            <i class="fa fa-minus-circle z-0 removeCondition"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
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
