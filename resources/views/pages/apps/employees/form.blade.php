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
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-5">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card my-3">
                                <div class="card-header p-2  min-h-100">
                                    <div class="card-title fs-3">
                                        Credentials
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fv-row mb-2">
                                                <label class="required fw-semibold fs-6 mb-2" for="email">Email</label>
                                                <input type="email" id="email" name="email" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter email address" value="{{ @$formData->user->email ?? '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-2">
                                                <label class="fw-semibold fs-6 mb-2" for="password">Password</label>
                                                <input type="password" id="password" name="password" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter password"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card my-3">
                                <div class="card-header p-2  min-h-100">
                                    <div class="card-title fs-3">
                                        General information
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fv-row mb-2">
                                                <label class="required fw-semibold fs-6 mb-2" for="status">Status</label>
                                                <select name="status" id="status" class="form-select form-select-sm mb-3 mb-lg-0" data-control="select2" data-placeholder="Select an status" data-allow-clear="true">
                                                    <option></option>
                                                    <option value="active" {{ @$formData->user->status === 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="in-active" {{ @$formData->user->status === 'in-active' ? 'selected' : '' }}>In-active</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-2">
                                                <label class="required fw-semibold fs-6 mb-2" for="name">Name</label>
                                                <input type="text" id="name" name="name" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter designation name" value="{{ @$formData->user->name ?? '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-2">
                                                <label class="fw-semibold fs-6 mb-2" for="phone">Company Phone Number</label>
                                                <input type="text" id="phone" name="phone" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter company phone number" value="{{ @$formData->user->phone ?? '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-2">
                                                <label class="required fw-semibold fs-6 mb-2" for="designation">Designation</label>
                                                <select name="designation" id="designation" class="form-select form-select-sm mb-3 mb-lg-0" data-control="select2" data-placeholder="Select an designation" data-allow-clear="true">
                                                    <option></option>
                                                    @foreach($designations as $designation)
                                                        <option value="{{ $designation->id }}" {{ @$formData->designation_id === $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-2">
                                                <label class="required fw-semibold fs-6 mb-2" for="department">Department</label>
                                                <select name="department" id="department" class="form-select form-select-sm mb-3 mb-lg-0" data-control="select2" data-placeholder="Select an department" data-allow-clear="true">
                                                    <option></option>
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department->id }}" {{ @$formData->department_id === $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-2">
                                                <label class="required fw-semibold fs-6 mb-2" for="branch">Branch</label>
                                                <select name="branch" id="branch" class="form-select form-select-sm mb-3 mb-lg-0" data-control="select2" data-placeholder="Select an branch" data-allow-clear="true">
                                                    <option></option>
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ @$formData->branch_id === $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-2">
                                                <label class="required fw-semibold fs-6 mb-2" for="employee_code">Employee Code</label>
                                                <input type="text" name="employee_code" class="form-control form-control-sm" id="employee_code" placeholder="Enter employee code"  value="{{ $formData->employee_code ?? '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-2">
                                                <label class="required fw-semibold fs-6 mb-2" for="date_of_joining">Date of joining</label>
                                                <div class="input-group  input-group-sm mb-5">
                                                    <span class="input-group-text " id="dateOfJoining">
                                                        {!! getIcon('calendar', 'fs-2') !!}
                                                    </span>
                                                    <input type="text" class="required form-control form-control-sm" id="date_of_joining" placeholder="Date of joining" aria-label="dateOfJoining" name="date_of_joining" aria-describedby="dateOfJoining" value="{{ $formData->date_of_joining ?? '' }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card my-3">
                                <div class="card-header p-2 min-h-100">
                                    <div class="card-title fs-3">
                                        Personal Information
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fv-row mb-2">
                                                <label class="fw-semibold fs-6 mb-2" for="date_of_birth">Date of birth</label>
                                                <div class="input-group input-group-sm mb-5">
                                                    <span class="input-group-text" id="dateOfBirth">
                                                        {!! getIcon('calendar', 'fs-2') !!}
                                                    </span>
                                                    <input type="text" class="form-control form-control-sm" id="date_of_birth" placeholder="Date of birth" aria-label="dateOfBirth" aria-describedby="dateOfBirth" name="date_of_birth"  value="{{ $formData->date_of_birth ?? '' }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-2">
                                                <label class="fw-semibold fs-6 mb-2" for="pan_number">Pan Number</label>
                                                <input type="text" class="form-control form-control-sm" id="pan_number" name="pan_number" placeholder="Enter pan number"  value="{{ $formData->pan_number ?? '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="fv-row mb-2">
                                                <label class="fw-semibold fs-6 mb-2" for="personal_number">Personal Number</label>
                                                <input type="text" class="form-control form-control-sm" id="personal_number" name="personal_number" placeholder="Enter personal number"  value="{{ $formData->personal_number ?? '' }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="fv-row mb-2">
                                                <label class="fw-semibold fs-6 mb-2" for="current_address">Current Address</label>
                                                <textarea class="form-control form-control-sm" id="current_address" name="current_address" placeholder="Enter current address" rows="5" style="resize: none;">{{ $formData->current_address ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="fv-row mb-2">
                                                <label class="fw-semibold fs-6 mb-2" for="permanent_address">Permanent Address</label>
                                                <textarea class="form-control form-control-sm" id="permanent_address" name="permanent_address" placeholder="Enter permanent address" rows="6" style="resize: none;">{{ $formData->permanent_address ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="card my-3">
                                <div class="card-header p-2 min-h-100">
                                    <div class="card-title fs-3">
                                        Attachments
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fv-row mb-2">
                                                <label class="fw-semibold fs-6 mb-2" for="photo">Photo</label>
                                                <div class="input-group input-group-sm mb-5">
                                                    <input type="file" class="form-control form-control-sm" id="photo" aria-label="photo" aria-describedby="photo" name="attachments[photo]"/>
                                                    @if(@$formData?->attachments()->where('purpose', 'photo')->first() !== null)
                                                        <a href="{{ url($formData->attachments()->where('purpose', 'photo')->first()->file_path) }}" target="_blank" class="input-group-text" id="photo">
                                                            {!! getIcon('eye', 'fs-2 text-warning') !!}
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="separator separator-dashed border-warning my-2"></div>
                                            </div>
                                            <div class="fv-row mb-2">
                                                <label class="fw-semibold fs-6 mb-2" for="aadhaar_card">Aadhaar Card</label>
                                                <div class="input-group input-group-sm mb-5">
                                                    <input type="file" class="form-control form-control-sm" id="aadhaar_card" aria-label="aadhaar_card" aria-describedby="aadhaar_card" name="attachments[aadhaar_card]"/>
                                                    @if(@$formData?->attachments()->where('purpose', 'aadhaar_card')->first() !== null)
                                                        <a href="{{ url($formData->attachments()->where('purpose', 'aadhaar_card')->first()->file_path) }}" target="_blank" class="input-group-text" id="aadhaar_card">
                                                            {!! getIcon('eye', 'fs-2 text-warning') !!}
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="separator separator-dashed border-warning my-2"></div>
                                            </div>
                                            <div class="fv-row mb-2">
                                                <label class="fw-semibold fs-6 mb-2" for="passport">Passport</label>
                                                <div class="input-group input-group-sm mb-5">
                                                    <input type="file" class="form-control form-control-sm" id="passport" aria-label="passport" aria-describedby="passport" name="attachments[passport]"/>
                                                    @if(@$formData?->attachments()->where('purpose', 'passport')->first() !== null)
                                                        <a href="{{ url($formData->attachments()->where('purpose', 'passport')->first()->file_path) }}" target="_blank" class="input-group-text" id="passport">
                                                            {!! getIcon('eye', 'fs-2 text-warning') !!}
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="separator separator-dashed border-warning my-2"></div>
                                            </div>
                                            <div class="fv-row mb-2">
                                                <label class="fw-semibold fs-6 mb-2" for="voter_id">Voter Id</label>
                                                <div class="input-group input-group-sm mb-5">
                                                    <input type="file" class="form-control form-control-sm" id="voter_id" aria-label="voter_id" aria-describedby="voter_id" name="attachments[voter_id]"/>
                                                    @if(@$formData?->attachments()->where('purpose', 'voter_id')->first() !== null)
                                                        <a href="{{ url($formData->attachments()->where('purpose', 'voter_id')->first()->file_path) }}" target="_blank" class="input-group-text" id="voter_id">
                                                            {!! getIcon('eye', 'fs-2 text-warning') !!}
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="separator separator-dashed border-warning my-2"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-rounded table-striped rounded-3 border p-5">
                                                    <thead>
                                                        <tr class="fw-semibold fs-6 text-gray-800 align-items-center justify-content-start align-content-center">
                                                            <th class="d-flex align-center justify-content-start align-content-center align-items-center">
                                                                Qualification Certificates
                                                            </th>
                                                            <th class="w-100px text-center">
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-light-primary fs-6" id="addQualification">
                                                                    Add New
                                                                </a>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="qualificationsList">
                                                    @if(@$formData)
                                                        @foreach(@$formData?->attachments()->where('purpose', 'like', 'qualification_%')->get() as $qualification)
                                                            <tr class="fw-semibold fs-6 text-gray-800 align-items-center justify-content-start align-content-center">
                                                                <td class="d-flex align-center justify-content-start align-content-center align-items-center">
                                                                    <div class="input-group input-group-sm ">
                                                                        <input type="file" class="form-control form-control-sm" id="qualification" aria-label="qualification" aria-describedby="qualification" name="attachments[qualification_{{ $qualification->id }}]"/>
                                                                        <a href="{{ url($qualification->file_path) }}" target="_blank" class="input-group-text" id="qualification">
                                                                            <i class="fa fa-eye text-warning"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <td class="w-100px text-center">
                                                                    <a href="javascript:void(0);" class="btn btn-active-icon-danger btn-text-danger border border-1 border-danger py-1 px-3 removeQualification">
                                                                        <i class="fa fa-trash-alt text-danger"></i>
                                                                    </a>
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
    @push('scripts')
        <script>
            $("#date_of_joining, #date_of_birth").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            });
        </script>
    @endpush
</x-default-layout>
