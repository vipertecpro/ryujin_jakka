<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        if(Auth::user()->hasPermissionTo('read users management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Employees List',
            'breadcrumbs' => Breadcrumbs::render('users.index')
        ];
        return $dataTable->render('pages.apps.users.list',$pageOptions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->hasPermissionTo('create users management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Create Employee',
            'actionUrl' => route('users.store'),
            'method' => 'POST',
            'breadcrumbs' => Breadcrumbs::render('users.create'),
            'roles' => Role::all()
        ];
        return view('pages.apps.users.form',$pageOptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasPermissionTo('create users management') === false){
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255',
            'password' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'date_of_joining' => 'required',
            'date_of_birth' => 'required',
            'pan_number' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);
        $user = new User();
        $user->avatar = $request->avatar;
        $user->name = $request->name;
        $user->employee_number = $request->employee_number;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->designation = $request->designation;
        $user->date_of_joining = $request->date_of_joining;
        $user->date_of_birth = $request->date_of_birth;
        $user->pan_number = $request->pan_number;
        $user->status = $request->status;
        $user->save();
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Auth::user()->hasPermissionTo('read users management') === false){
            abort(403);
        }
        $user = User::findOrFail($id);
        $pageOptions = [
            'title'       => 'Employee Details',
            'breadcrumbs' => Breadcrumbs::render('users.show',$user),
            'user'      => $user
        ];
        return view('pages.apps.users.show', $pageOptions);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->hasPermissionTo('edit users management') === false){
            abort(403);
        }
        $user = User::findOrFail($id);
        $pageOptions = [
            'title' => 'Update Employee',
            'actionUrl' => route('users.update', $id),
            'user' => $user,
            'method' => 'PATCH',
            'breadcrumbs' => Breadcrumbs::render('users.edit',$user),
            'roles' => Role::all(),
            'userRoles' => $user->roles()->pluck('name')->toArray(),
        ];
        return view('pages.apps.users.form', $pageOptions);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if(Auth::user()->hasPermissionTo('edit users management') === false){
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255',
            'designation' => 'required|string|max:255',
            'date_of_joining' => 'required',
            'date_of_birth' => 'required',
            'pan_number' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);
        $password = $request->get('password')? bcrypt($request->get('password')) : $user->password;
        $user->avatar = $request->get('avatar');
        $user->name = $request->get('name');
        $user->employee_number = $request->get('employee_number');
        $user->email = $request->get('email');
        $user->password = $password;
        $user->designation = $request->get('designation');
        $user->date_of_joining = $request->get('date_of_joining');
        $user->date_of_birth = $request->get('date_of_birth');
        $user->pan_number = $request->get('pan_number');
        $user->status = $request->get('status');
        $user->update();
        $user->syncRoles($request->get('role_id'));
        return redirect()->route('users.edit',$user)->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        if(Auth::user()->hasPermissionTo('delete users management') === false){
            return response()->json([
                'message' => 'You do not have permission to delete users',
                'status' => 'error'
            ], 401);
        }
        try{
            User::findOrFail($id)->delete();
            return response()->json([
                'message' => 'User deleted successfully',
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
     * Import users from excel file.
     * */
    public function import(Request $request): JsonResponse{
        if(Auth::user()->hasPermissionTo('import users management') === false){
            return response()->json([
                'message' => 'You do not have permission to import users',
                'status' => 'error'
            ], 401);
        }
        try{
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls'
            ]);
            $file = $request->file('file');
            Excel::import(new UsersImport, $file);
            return response()->json([
                'message' => 'Users imported successfully',
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
     * Remove all useres from storage.
     * */
    public function removeAllData(): JsonResponse
    {
        try {
            if(Auth::user()->hasPermissionTo('delete users management') === false){
                return response()->json([
                    'message' => 'You do not have permission to delete users',
                    'status' => 'error'
                ], 401);
            }
            User::where('id','!=',Auth::user()->id)->delete();
            return response()->json([
                'message' => 'All users removed successfully',
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
