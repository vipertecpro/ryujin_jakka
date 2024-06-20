<x-default-layout  :title="$title">
    @section('title')
        {{ $title }}
    @endsection
    @section('breadcrumbs')
        {!! $breadcrumbs !!}
    @endsection
    <form id="kt_modal_add_role_form" class="form" method="POST" action="{{ $actionUrl }}" enctype="multipart/form-data">
        @csrf
        @method($method)
        <input type="hidden" name="role_id" value="{{ @$role_id }}"/>
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column gap-5">
                    <div class="row">
                        <div class="fv-row mb-10">
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">Role name</span>
                            </label>
                            <input class="form-control form-control-solid" placeholder="Enter a role name" name="name" value="{{ @$role->name }}"/>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="fv-row">
                            <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <tbody class="text-gray-600 fw-semibold">
                                    <tr>
                                        <td class="text-gray-800">Administrator Access
                                            <span class="ms-1" data-bs-toggle="tooltip" title="Allows a full access to the system">
                                                {!! getIcon('information-5','text-gray-500 fs-6') !!}
                                            </span>
                                        </td>
                                        <td>
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox" id="kt_roles_select_all" />
                                                <span class="form-check-label" for="kt_roles_select_all">Select all</span>
                                            </label>
                                        </td>
                                    </tr>
                                    @foreach($permissions_by_group as $group => $permissions)
                                        <tr>
                                            <td class="text-gray-800">{{ ucwords($group) }}</td>
                                            @foreach($permissions as $permission)
                                                <td>
                                                    <div class="d-flex">
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                            <input class="form-check-input" type="checkbox" name="checked_permissions[]" value="{{ $permission->name }}" {{ in_array($permission->name, $checked_permissions) === true ? 'checked' : '' }}/>
                                                            <span class="form-check-label">{{ ucwords(Str::before($permission->name, ' ')) }}</span>
                                                        </label>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer p-5">
                <div class="text-end">
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary me-3 btn-sm" aria-label="Close">Cancel</a>
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
    @push('scripts')
        <script>
            // on click on check all
            $('#kt_roles_select_all').on('change', function() {
                if ($(this).is(':checked')) {
                    $('input[type="checkbox"]').prop('checked', true);
                } else {
                    $('input[type="checkbox"]').prop('checked', false);
                }
            });
        </script>
    @endpush
</x-default-layout>
