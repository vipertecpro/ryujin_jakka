<a href="#" class="btn btn-icon btn-icon-primary p-0 h-100" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
    <i class="ki-duotone ki-dots-circle-vertical fs-1">
        <span class="path1"></span>
        <span class="path2"></span>
        <span class="path3"></span>
        <span class="path4"></span>
    </i>
</a>
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
    @if(Auth::user()->hasPermissionTo('read leave types management') === true)
        <div class="menu-item px-3">
            <a href="{{ route('leaveTypes.show', $row) }}" class="menu-link px-3">
                View
            </a>
        </div>
    @endif
    @if(Auth::user()->hasPermissionTo('edit leave types management') === true)
        <div class="menu-item px-3">
            <a href="{{ route('leaveTypes.edit',$row) }}" class="menu-link px-3" data-kt-branch-id="{{ $row->id }}">
                Edit
            </a>
        </div>
    @endif
    @if(Auth::user()->hasPermissionTo('delete leave types management') === true)
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3" data-kt-branch-id="{{ $row->id }}" data-kt-remove-url="{{ route('leaveTypes.destroy',$row) }}" data-kt-action="delete_row">
                Delete
            </a>
        </div>
    @endif
</div>
