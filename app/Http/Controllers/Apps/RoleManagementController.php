<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\RolesDataTable;
use App\Http\Controllers\Controller;
use App\Imports\RolesImport;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RolesDataTable $dataTable)
    {
        if(Auth::user()->hasPermissionTo('read roles management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Roles',
            'breadcrumbs' => Breadcrumbs::render('roles.index')
        ];
        return $dataTable->render('pages.apps.roles.list',$pageOptions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->hasPermissionTo('create roles management') === false){
            abort(403);
        }
        $checked_permissions = [];
        $permissions_by_group = [];
        foreach (Permission::all() ?? [] as $permission) {
            $ability = Str::after($permission->name, ' ');
            $permissions_by_group[$ability][] = $permission;
        }
        $pageOptions = [
            'title' => 'Create Role',
            'actionUrl' => route('roles.store'),
            'method' => 'POST',
            'breadcrumbs' => Breadcrumbs::render('roles.create'),
            'roles' => Role::all(),
            'permissions_by_group' => $permissions_by_group,
            'checked_permissions' => $checked_permissions,
            'check_all' => false
        ];
        return view('pages.apps.roles.form',$pageOptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasPermissionTo('create roles management') === false){
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $role = new Role();
        $role->name = $request->get('name');
        $role->save();
        $role->syncPermissions($request->get('checked_permissions'));
        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Auth::user()->hasPermissionTo('read roles management') === false){
            abort(403);
        }
        $role = Role::findOrFail($id);
        $pageOptions = [
            'title'       => 'Role Details',
            'breadcrumbs' => Breadcrumbs::render('roles.show',$role),
            'role'      => $role
        ];
        return view('pages.apps.roles.show', $pageOptions);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->hasPermissionTo('edit roles management') === false){
            abort(403);
        }
        $permissions_by_group = [];
        foreach (Permission::all() ?? [] as $permission) {
            $ability = Str::after($permission->name, ' ');
            $permissions_by_group[$ability][] = $permission;
        }
        $role = Role::findOrFail($id);
        $pageOptions = [
            'title' => 'Update Role',
            'actionUrl' => route('roles.update', $id),
            'role' => $role,
            'method' => 'PUT',
            'breadcrumbs' => Breadcrumbs::render('roles.edit',$role),
            'roles' => Role::all(),
            'permissions_by_group' => $permissions_by_group,
            'checked_permissions' => $role->permissions->pluck('name')->toArray(),
            'check_all' => false
        ];
        return view('pages.apps.roles.form', $pageOptions);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if(Auth::user()->hasPermissionTo('edit roles management') === false){
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $role = Role::findOrFail($role->id);
        $role->name = $request->get('name');
        $role->save();
        $role->syncPermissions($request->get('checked_permissions'));
        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        if(Auth::user()->hasPermissionTo('delete roles management') === false){
            return response()->json([
                'message' => 'You do not have permission to delete roles',
                'status' => 'error'
            ], 401);
        }
        try{
            Role::findOrFail($id)->delete();
            return response()->json([
                'message' => 'Role deleted successfully',
                'status' => 'success'
            ]);
        }catch (Exception $exception){
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => 'error'
            ],401);
        }
    }
    /**
     * Import Roles from excel file.
     * */
    public function import(Request $request): JsonResponse{
        if(Auth::user()->hasPermissionTo('import roles management') === false){
            return response()->json([
                'message' => 'You do not have permission to import roles',
                'status' => 'error'
            ], 401);
        }
        try{
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls'
            ]);
            $file = $request->file('file');
            Excel::import(new RolesImport, $file);
            return response()->json([
                'message' => 'Roles imported successfully',
                'status' => 'success'
            ]);
        }catch (Exception $exception){
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => 'error'
            ],401);
        }
    }
    /**
     * Remove all Rolees from storage.
     * */
    public function removeAllData(): JsonResponse
    {
        if(Auth::user()->hasPermissionTo('delete roles management') === false){
            return response()->json([
                'message' => 'You do not have permission to delete roles',
                'status' => 'error'
            ], 401);
        }
        try {
            Role::delete();
            return response()->json([
                'message' => 'All Roles removed successfully',
                'status' => 'success'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => 'error'
            ], 401);
        }
    }
}
