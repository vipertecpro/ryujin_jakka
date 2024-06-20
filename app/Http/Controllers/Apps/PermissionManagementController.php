<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\PermissionsDataTable;
use App\Http\Controllers\Controller;
use App\Imports\PermissionsImport;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;

class PermissionManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PermissionsDataTable $dataTable)
    {
        if(Auth::user()->hasPermissionTo('read permissions management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Permissions',
            'breadcrumbs' => Breadcrumbs::render('permissions.index')
        ];
        return $dataTable->render('pages.apps.permissions.list',$pageOptions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->hasPermissionTo('create permissions management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Create Permission',
            'actionUrl' => route('permissions.store'),
            'method' => 'POST',
            'breadcrumbs' => Breadcrumbs::render('permissions.create'),
            'Permissions' => Permission::all()
        ];
        return view('pages.apps.permissions.form',$pageOptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasPermissionTo('create permissions management') === false){
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->save();
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Auth::user()->hasPermissionTo('read permissions management') === false){
            abort(403);
        }
        $permission = Permission::findOrFail($id);
        $pageOptions = [
            'title'       => 'Permission Details',
            'breadcrumbs' => Breadcrumbs::render('permissions.show',$permission),
            'permission'      => $permission
        ];
        return view('pages.apps.permissions.show', $pageOptions);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->hasPermissionTo('edit permissions management') === false){
            abort(403);
        }
        $permission = Permission::findOrFail($id);
        $pageOptions = [
            'title' => 'Update Permission',
            'actionUrl' => route('permissions.update', $id),
            'permission' => $permission,
            'method' => 'PUT',
            'breadcrumbs' => Breadcrumbs::render('permissions.edit',$permission),
            'permissions' => Permission::all(),
        ];
        return view('pages.apps.permissions.form', $pageOptions);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        if(Auth::user()->hasPermissionTo('edit permissions management') === false){
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $permission = Permission::findOrFail($permission->id);
        $permission->name = $request->get('name');
        $permission->save();
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        if(Auth::user()->hasPermissionTo('delete permissions management') === false){
            return response()->json([
                'message' => 'You do not have permission to delete permissions',
                'status' => 'error'
            ], 401);
        }
        try{
            Permission::findOrFail($id)->delete();
            return response()->json([
                'message' => 'Permission deleted successfully',
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
     * Import Permissions from excel file.
     * */
    public function import(Request $request): JsonResponse{
        if(Auth::user()->hasPermissionTo('import permissions management') === false){
            return response()->json([
                'message' => 'You do not have permission to import permissions',
                'status' => 'error'
            ], 401);
        }
        try{
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls'
            ]);
            $file = $request->file('file');
            Excel::import(new PermissionsImport, $file);
            return response()->json([
                'message' => 'Permissions imported successfully',
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
     * Remove all Permissions from storage.
     * */
    public function removeAllData(): JsonResponse
    {
        if(Auth::user()->hasPermissionTo('delete permissions management') === false){
            return response()->json([
                'message' => 'You do not have permission to delete roles',
                'status' => 'error'
            ], 401);
        }
        try {
            Permission::delete();
            return response()->json([
                'message' => 'All Permissions removed successfully',
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
