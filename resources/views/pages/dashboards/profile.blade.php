<x-default-layout :title="$title" >

    @section('title')
        {{ $title }}
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

        <form id="kt_modal_add_user_form" class="form" method="POST" action="{{ $actionUrl }}" enctype="multipart/form-data">
            @csrf
            @method($method)
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column gap-5">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="fv-row mb-2">
                                    <label class="required fw-semibold fs-6 mb-2" for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control  form-control-sm mb-3 mb-lg-0" placeholder="Enter name of the user" value="{{ @$user->name }}"/>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-2">
                                    <label class="required fw-semibold fs-6 mb-2" for="employee_number">Employee Number</label>
                                    <input type="text" id="employee_number" name="employee_number" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter employee number" value="{{ @$user->employee_number }}"/>
                                    @error('employee_number')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-2">
                                    <label class="required fw-semibold fs-6 mb-2" for="status" >Status</label>
                                    <select type="text" id="status" name="status" class="form-select form-select-sm mb-3 mb-lg-0" placeholder="Enter status" >
                                        <option value="">Select status</option>
                                        <option value="active" {{ @$user->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ @$user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-2">
                                    <label class="required fw-semibold fs-6 mb-2" for="email">Email</label>
                                    <input type="text" id="email" name="email" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter email" value="{{ @$user->email }}"/>
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-2">
                                    <label class="fw-semibold fs-6 mb-2" for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter password" autocomplete="new-password"/>
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-2">
                                    <label class="required fw-semibold fs-6 mb-2" for="state">Designation</label>
                                    <input type="text" id="designation" name="designation" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter designation" value="{{ @$user->designation }}"/>
                                    @error('designation')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-2">
                                    <label class="required fw-semibold fs-6 mb-2" for="date_of_joining" >Date of joining</label>
                                    <input type="text" id="date_of_joining" name="date_of_joining" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter date of joining" value="{{ @$user->date_of_joining }}"/>
                                    @error('date_of_joining')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row">
                                    <label class="required fw-semibold fs-6 mb-2" for="date_of_birth" >Date of birth</label>
                                    <input type="text" id="date_of_birth" name="date_of_birth" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter date of birth" value="{{ @$user->date_of_birth }}"/>
                                    @error('date_of_birth')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row">
                                    <label class="required fw-semibold fs-6 mb-2" for="pan_number" >Pan Number</label>
                                    <input type="text" id="pan_number" name="pan_number" class="form-control form-control-sm mb-3 mb-lg-0" placeholder="Enter pan number" value="{{ @$user->pan_number }}"/>
                                    @error('pan_number')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-5">
                    <div class="text-end">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary me-3 btn-sm" aria-label="Close">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm" data-kt-useres-modal-action="submit">
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
                $("#date_of_joining").flatpickr({
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                });
                $("#date_of_birth").flatpickr({
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                });
            </script>
        @endpush
</x-default-layout>
