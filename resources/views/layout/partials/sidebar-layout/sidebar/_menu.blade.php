<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
	<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
		<div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
			<a href="{{ route('dashboard') }}" class="menu-item menu-accordion {{ request()->routeIs('dashboard') ? 'here show' : '' }}">
				<span class="menu-link">
					<span class="menu-icon">{!! getIcon('element-11', 'fs-2') !!}</span>
					<span class="menu-title">Dashboard</span>
				</span>
			</a>
			<div class="menu-item pt-5">
				<div class="menu-content">
					<span class="menu-heading fw-bold text-uppercase fs-7">Modules</span>
				</div>
			</div>
            @if(Auth::user()->hasAnyPermission([
               'create employees management',
               'read employees management',
               'edit employees management',
               'delete employees management',
               'import employees management',
               'export employees management',
           ]))
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('employees.*') ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('people', 'fs-2') !!}</span>
                        <span class="menu-title">Employees</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        @if(Auth::user()->hasAllPermissions([
                           'read employees management',
                       ]))
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('employees.index') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">List</span>
                                </a>
                            </div>
                        @endif
                        @if(Auth::user()->hasAllPermissions([
                             'create employees management',
                         ]))
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('employees.create') ? 'active' : '' }}" href="{{ route('employees.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Add New</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            @if(Auth::user()->hasAnyPermission([
               'read leave requests management',
            ]))
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('leaveRequests.*') ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('calendar-add', 'fs-2') !!}</span>
                        <span class="menu-title">Leave Requests</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        @if(Auth::user()->hasAllPermissions([
                           'read leave requests management',
                       ]))
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('leaveRequests.index') ? 'active' : '' }}" href="{{ route('leaveRequests.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">List</span>
                                </a>
                            </div>
                        @endif
                        @if(Auth::user()->hasAllPermissions([
                             'create leave requests management',
                         ]))
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('leaveRequests.create') ? 'active' : '' }}" href="{{ route('leaveRequests.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Add New</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <div class="menu-item pt-5">
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">Configurations</span>
                </div>
            </div>
            @if(Auth::user()->hasAnyPermission([
               'read leave types management',
            ]))
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('leaveTypes.*') ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('calendar-2', 'fs-2') !!}</span>
                        <span class="menu-title">Leave Types</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        @if(Auth::user()->hasAllPermissions([
                           'read leave types management',
                       ]))
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('leaveTypes.index') ? 'active' : '' }}" href="{{ route('leaveTypes.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">List</span>
                                </a>
                            </div>
                        @endif
                        @if(Auth::user()->hasAllPermissions([
                             'create leave types management',
                         ]))
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('leaveTypes.create') ? 'active' : '' }}" href="{{ route('leaveTypes.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Add New</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            @if(Auth::user()->hasAnyPermission([
               'read designation management',
           ]))
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('designations.*') ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('element-2', 'fs-2') !!}</span>
                        <span class="menu-title">Designations</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        @if(Auth::user()->hasAllPermissions([
                           'read designation management',
                       ]))
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('designations.index') ? 'active' : '' }}" href="{{ route('designations.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">List</span>
                                </a>
                            </div>
                        @endif
                        @if(Auth::user()->hasAllPermissions([
                             'create designation management',
                         ]))
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('designations.create') ? 'active' : '' }}" href="{{ route('designations.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Add New</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            @if(Auth::user()->hasAnyPermission([
               'read department management',
           ]))
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('departments.*') ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('element-plus', 'fs-2') !!}</span>
                        <span class="menu-title">Departments</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        @if(Auth::user()->hasAllPermissions([
                           'read department management',
                       ]))
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('departments.index') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">List</span>
                                </a>
                            </div>
                        @endif
                        @if(Auth::user()->hasAllPermissions([
                             'create department management',
                         ]))
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('departments.create') ? 'active' : '' }}" href="{{ route('departments.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Add New</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            @if(Auth::user()->hasAnyPermission([
              'read branch management',
            ]))
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('branches.*') ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('data', 'fs-2') !!}</span>
                        <span class="menu-title">Branches</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        @if(Auth::user()->hasAllPermissions([
                           'read branch management',
                       ]))
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('branches.index') ? 'active' : '' }}" href="{{ route('branches.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">List</span>
                                </a>
                            </div>
                        @endif
                        @if(Auth::user()->hasAllPermissions([
                             'create branch management',
                         ]))
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('branches.create') ? 'active' : '' }}" href="{{ route('branches.create') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Add New</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('roles.*') ? 'here show' : '' }}">
				<span class="menu-link">
					<span class="menu-icon">{!! getIcon('shield-tick', 'fs-2') !!}</span>
					<span class="menu-title">Roles</span>
					<span class="menu-arrow"></span>
				</span>
                <div class="menu-sub menu-sub-accordion">
                    @if(Auth::user()->hasAllPermissions([
                       'read roles management',
                    ]))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('roles.index') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">List</span>
                            </a>
                        </div>
                    @endif
                    @if(Auth::user()->hasAllPermissions([
                          'create roles management',
                    ]))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('roles.create') ? 'active' : '' }}" href="{{ route('roles.create') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Add New</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('permissions.*') ? 'here show' : '' }}">
				<span class="menu-link">
					<span class="menu-icon">{!! getIcon('shield', 'fs-2') !!}</span>
					<span class="menu-title">Permissions</span>
					<span class="menu-arrow"></span>
				</span>
                <div class="menu-sub menu-sub-accordion">
                    @if(Auth::user()->hasAllPermissions([
                      'read permissions management',
                   ]))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('permissions.index') ? 'active' : '' }}" href="{{ route('permissions.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">List</span>
                            </a>
                        </div>
                    @endif
                    @if(Auth::user()->hasAllPermissions([
                         'create permissions management',
                    ]))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('permissions.create') ? 'active' : '' }}" href="{{ route('permissions.create') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Add New</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
		</div>
	</div>
    @include('layout.partials.sidebar-layout.sidebar._footer')
</div>
