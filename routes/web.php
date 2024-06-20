<?php

use App\Http\Controllers\Apps\GlobalSettingController;
use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Apps\BranchManagementController;
use App\Http\Controllers\Apps\DepartmentsManagementController;
use App\Http\Controllers\Apps\DesignationsManagementController;
use App\Http\Controllers\Apps\EmployeesManagementController;
use App\Http\Controllers\Apps\LeaveRequestsManagementController;
use App\Http\Controllers\Apps\LeaveTypeManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profileUpdate', [DashboardController::class, 'profileUpdate'])->name('profileUpdate');
    /**
     * *************************************************************************************************************
     * Configuration
     * **************************************************************************************************************
     * */
    Route::get('/globalSettings', [GlobalSettingController::class, 'globalSettings'])->name('globalSettings');
    Route::post('/globalSettingsUpdate', [GlobalSettingController::class, 'globalSettingsUpdate'])->name('globalSettingsUpdate');

    Route::post('/permissions/import', [PermissionManagementController::class, 'import'])->name('permissions.import');
    Route::delete('/permissions/removeAllData', [PermissionManagementController::class, 'removeAllData'])->name('permissions.removeAll');
    Route::resource('/permissions', PermissionManagementController::class);

    Route::post('/roles/import', [RoleManagementController::class, 'import'])->name('roles.import');
    Route::delete('/roles/removeAllData', [RoleManagementController::class, 'removeAllData'])->name('roles.removeAll');
    Route::resource('/roles', RoleManagementController::class);

    Route::post('/branches/import', [BranchManagementController::class, 'import'])->name('branches.import');
    Route::delete('/branches/removeAllData', [BranchManagementController::class, 'removeAllData'])->name('branches.removeAll');
    Route::resource('/branches', BranchManagementController::class);

    Route::post('/departments/import', [DepartmentsManagementController::class, 'import'])->name('departments.import');
    Route::delete('/departments/removeAllData', [DepartmentsManagementController::class, 'removeAllData'])->name('departments.removeAll');
    Route::resource('/departments', DepartmentsManagementController::class);

    Route::post('/designations/import', [DesignationsManagementController::class, 'import'])->name('designations.import');
    Route::delete('/designations/removeAllData', [DesignationsManagementController::class, 'removeAllData'])->name('designations.removeAll');
    Route::resource('/designations', DesignationsManagementController::class);

    Route::post('/leaveTypes/import', [LeaveTypeManagementController::class, 'import'])->name('leaveTypes.import');
    Route::delete('/leaveTypes/removeAllData', [LeaveTypeManagementController::class, 'removeAllData'])->name('leaveTypes.removeAll');
    Route::resource('/leaveTypes', LeaveTypeManagementController::class);
    /**
     * *************************************************************************************************************
     * Modules
     * *************************************************************************************************************
     * */
    Route::post('/employees/import', [EmployeesManagementController::class, 'import'])->name('employees.import');
    Route::delete('/employees/removeAllData', [EmployeesManagementController::class, 'removeAllData'])->name('employees.removeAll');
    Route::resource('/employees', EmployeesManagementController::class);

    Route::post('/leaveRequests/approve', [LeaveRequestsManagementController::class, 'approveLeaveRequest'])->name('leaveRequests.approveLeaveRequest');
    Route::post('/leaveRequests/reject', [LeaveRequestsManagementController::class, 'rejectLeaveRequest'])->name('leaveRequests.rejectLeaveRequest');
    Route::get('/leaveRequests/cancel/{leave_request_id}', [LeaveRequestsManagementController::class, 'cancelLeaveRequest'])->name('leaveRequests.cancelLeaveRequest');
    Route::delete('/leaveRequests/removeAllData', [LeaveRequestsManagementController::class, 'removeAllData'])->name('leaveRequests.removeAll');
    Route::resource('/leaveRequests', LeaveRequestsManagementController::class);

});
Route::get('/error', function () {
    abort(500);
});
Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);
require __DIR__ . '/auth.php';
