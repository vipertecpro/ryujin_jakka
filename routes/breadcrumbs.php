<?php

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('dashboard'));
});

/**
 * ***************************************************************************************************************
 * Dashboard Breadcrumbs
 * ***************************************************************************************************************
 * */
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});
/**
 * ***************************************************************************************************************
 * Global Settings Breadcrumbs
 * ***************************************************************************************************************
 * */
Breadcrumbs::for('globalSettings', function (BreadcrumbTrail $trail) {
    $trail->push('Global Settings', route('globalSettings'));
});
/**
 * ***************************************************************************************************************
 * Authorized User Profile Breadcrumbs
 * ***************************************************************************************************************
 * */
Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->push('Profile', route('profile'));
});
/**
 * ***************************************************************************************************************
 * Users Breadcrumbs
 * ***************************************************************************************************************
 * */
Breadcrumbs::for('users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Employees', route('users.index'));
});
Breadcrumbs::for('users.create', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Employees', route('users.index'));
    $trail->push('Add Employee', route('users.create'));
});
Breadcrumbs::for('users.edit', function (BreadcrumbTrail $trail, User $user) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Users', route('users.index'));
    $trail->push('Update Employee', route('users.edit',$user));
});
Breadcrumbs::for('users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Employees', route('users.index'));
    $trail->push('View Details', route('users.show',$user));
});
/**
 * ****************************************************************************************************************
 * Roles Breadcrumbs
 * ***************************************************************************************************************
 * */
Breadcrumbs::for('roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Roles', route('roles.index'));
});
Breadcrumbs::for('roles.create', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Roles', route('roles.index'));
    $trail->push('Add Role', route('roles.create'));
});
Breadcrumbs::for('roles.edit', function (BreadcrumbTrail $trail, Role $role) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Roles', route('roles.index'));
    $trail->push('Update Role', route('roles.edit',$role));
});
Breadcrumbs::for('roles.show', function (BreadcrumbTrail $trail, Role $role) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Roles', route('roles.index'));
    $trail->push('View Details', route('roles.show',$role));
});
/**
 * ****************************************************************************************************************
 * Permissions Breadcrumbs
 * ***************************************************************************************************************
 * */
Breadcrumbs::for('permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Permissions', route('permissions.index'));
});
Breadcrumbs::for('permissions.create', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Permissions', route('permissions.index'));
    $trail->push('Add Role', route('permissions.create'));
});
Breadcrumbs::for('permissions.edit', function (BreadcrumbTrail $trail, Permission $permission) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Permissions', route('permissions.index'));
    $trail->push('Update Permission', route('permissions.edit',$permission));
});
Breadcrumbs::for('permissions.show', function (BreadcrumbTrail $trail, Permission $permission) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Permissions', route('permissions.index'));
    $trail->push('View Details', route('permissions.show',$permission));
});
/**
 * ****************************************************************************************************************
 *  Designations Breadcrumbs
 * ***************************************************************************************************************
 * */
Breadcrumbs::for('designations.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Designations', route('designations.index'));
});
Breadcrumbs::for('designations.create', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Designations', route('designations.index'));
    $trail->push('Add designation', route('designations.create'));
});
Breadcrumbs::for('designations.edit', function (BreadcrumbTrail $trail, Designation $designation) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Designations', route('designations.index'));
    $trail->push('Update designation', route('designations.edit',$designation));
});
Breadcrumbs::for('designations.show', function (BreadcrumbTrail $trail, Designation $designation) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Designations', route('designations.index'));
    $trail->push('View Details', route('designations.show',$designation));
});
/**
 * ****************************************************************************************************************
 *  Departments Breadcrumbs
 * ***************************************************************************************************************
 * */
Breadcrumbs::for('departments.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Departments', route('departments.index'));
});
Breadcrumbs::for('departments.create', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Departments', route('designations.index'));
    $trail->push('Add department', route('designations.create'));
});
Breadcrumbs::for('departments.edit', function (BreadcrumbTrail $trail, Department $department) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Departments', route('departments.index'));
    $trail->push('Update department', route('departments.edit',$department));
});
Breadcrumbs::for('departments.show', function (BreadcrumbTrail $trail, Department $department) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Departments', route('departments.index'));
    $trail->push('View Details', route('departments.show',$department));
});
/**
 * ****************************************************************************************************************
 *  Branches Breadcrumbs
 * ***************************************************************************************************************
 * */
Breadcrumbs::for('branches.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Branches', route('branches.index'));
});
Breadcrumbs::for('branches.create', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Branches', route('branches.index'));
    $trail->push('Add branch', route('branches.create'));
});
Breadcrumbs::for('branches.edit', function (BreadcrumbTrail $trail, Branch $branch) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Branches', route('branches.index'));
    $trail->push('Update branch', route('branches.edit',$branch));
});
Breadcrumbs::for('branches.show', function (BreadcrumbTrail $trail, Branch $branch) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Branches', route('branches.index'));
    $trail->push('View Details', route('branches.show',$branch));
});
/**
 * ****************************************************************************************************************
 *  Employees Breadcrumbs
 * ***************************************************************************************************************
 * */
Breadcrumbs::for('employees.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Employees', route('employees.index'));
});
Breadcrumbs::for('employees.create', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Employees', route('employees.index'));
    $trail->push('Add employee', route('employees.create'));
});
Breadcrumbs::for('employees.edit', function (BreadcrumbTrail $trail, Employee $employee) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Employees', route('employees.index'));
    $trail->push('Update employee', route('employees.edit',$employee));
});
Breadcrumbs::for('employees.show', function (BreadcrumbTrail $trail, Employee $employee) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Employees', route('employees.index'));
    $trail->push('View Details', route('employees.show',$employee));
});

/**
 * ****************************************************************************************************************
 *  Leave Types Breadcrumbs
 * ***************************************************************************************************************
 * */
Breadcrumbs::for('leaveTypes.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Leave Types', route('leaveTypes.index'));
});
Breadcrumbs::for('leaveTypes.create', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Leave Types', route('leaveTypes.index'));
    $trail->push('Add leave type', route('leaveTypes.create'));
});
Breadcrumbs::for('leaveTypes.edit', function (BreadcrumbTrail $trail, LeaveType $leaveType) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Leave Types', route('leaveTypes.index'));
    $trail->push('Update leave type', route('leaveTypes.edit',$leaveType));
});
Breadcrumbs::for('leaveTypes.show', function (BreadcrumbTrail $trail, LeaveType $leaveType) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Leave Types', route('leaveTypes.index'));
    $trail->push('View Details', route('leaveTypes.show',$leaveType));
});
/**
 * ****************************************************************************************************************
 *  Leave Requests Breadcrumbs
 * ***************************************************************************************************************
 * */
Breadcrumbs::for('leaveRequests.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Leave Requests', route('leaveRequests.index'));
});
Breadcrumbs::for('leaveRequests.create', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Leave Requests', route('leaveRequests.index'));
    $trail->push('Add leave request', route('leaveRequests.create'));
});
Breadcrumbs::for('leaveRequests.edit', function (BreadcrumbTrail $trail, LeaveRequest $leaveRequest) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Leave Requests', route('leaveRequests.index'));
    $trail->push('Update leave request', route('leaveRequests.edit',$leaveRequest));
});
Breadcrumbs::for('leaveRequests.show', function (BreadcrumbTrail $trail, LeaveRequest $leaveRequest) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push('Leave Requests', route('leaveRequests.index'));
    $trail->push('View Details', route('leaveRequests.show',$leaveRequest));
});
