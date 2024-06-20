<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\DepartmentsDataTable;
use App\Http\Controllers\Controller;
use App\Imports\DepartmentsImport;
use App\Models\Department;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentsManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DepartmentsDataTable $dataTable)
    {
        if(Auth::user()->hasPermissionTo('read department management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Departments',
            'breadcrumbs' => Breadcrumbs::render('departments.index')
        ];
        return $dataTable->render('pages.apps.departments.list',$pageOptions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->hasPermissionTo('create department management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Create department',
            'actionUrl' => route('departments.store'),
            'method' => 'POST',
            'breadcrumbs' => Breadcrumbs::render('departments.create'),
            'redirectTo' => route('departments.index')
        ];
        addJavascriptFile('assets/js/custom/configurations/departments/form.js');
        return view('pages.apps.departments.form',$pageOptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasPermissionTo('create department management') === false){
            abort(403);
        }
        try{
            $validator = validator($request->all(),[
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string',
                'status'      => 'required'
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->all(),
                    'fields' => $validator->errors()->keys(),
                    'status' => 'error'
                ],401);
            }
            Department::create([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'status' => $request->get('status')
            ]);
            return response()->json([
                'message'    => 'department created successfully.',
                'status'     => 'success',
                'redirectTo' => route('departments.index')
            ]);
        }catch (Exception $exception){
            Log::info('---------------------------------------------------------------------------------------');
            Log::info('****************************************');
            Log::info('CLASS : '.__CLASS__);
            Log::info('METHOD : '.__METHOD__);
            Log::info('FUNCTION : '.__FUNCTION__);
            Log::info('DIRECTORY : '.__DIR__);
            Log::info('****************************************');
            Log::info('EXCEPTION',[
                'status' => 'error',
                'curlUrl' => '',
                'message' => $exception->getMessage(),
                'content' => '',
                'header' => '',
                'code'    => $exception->getCode(),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'trace'   => $exception->getTrace(),
            ]);
            Log::info('---------------------------------------------------------------------------------------');
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => 'exception'
            ],401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Auth::user()->hasPermissionTo('read department management') === false){
            abort(403);
        }
        $department = Department::findOrFail($id);
        $pageOptions = [
            'title'         => 'department details',
            'breadcrumbs'   => Breadcrumbs::render('departments.show',$department),
            'formData'      => $department
        ];
        addJavascriptFile('assets/js/custom/configurations/departments/details.js');
        return view('pages.apps.departments.show', $pageOptions);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->hasPermissionTo('edit department management') === false){
            abort(403);
        }
        $department = Department::findOrFail($id);
        $pageOptions = [
            'title' => 'Update department',
            'actionUrl' => route('departments.update', $id),
            'formData' => $department,
            'method' => 'PUT',
            'breadcrumbs' => Breadcrumbs::render('departments.edit',$department),
            'redirectTo' => route('departments.index')
        ];
        addJavascriptFile('assets/js/custom/configurations/departments/form.js');
        return view('pages.apps.departments.form', $pageOptions);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->hasPermissionTo('edit department management') === false){
            abort(403);
        }
        try{
            $validator = validator($request->all(),[
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string',
                'status'      => 'required'
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->all(),
                    'fields' => $validator->errors()->keys(),
                    'status' => 'error'
                ],401);
            }
            Department::where('id',$id)->update([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'status' => $request->get('status')
            ]);
            return response()->json([
                'message'    => 'Department updated successfully.',
                'status'     => 'success',
                'redirectTo' => route('departments.index')
            ]);
        }catch (Exception $exception){
            Log::info('---------------------------------------------------------------------------------------');
            Log::info('****************************************');
            Log::info('CLASS : '.__CLASS__);
            Log::info('METHOD : '.__METHOD__);
            Log::info('FUNCTION : '.__FUNCTION__);
            Log::info('DIRECTORY : '.__DIR__);
            Log::info('****************************************');
            Log::info('EXCEPTION',[
                'status' => 'error',
                'curlUrl' => '',
                'message' => $exception->getMessage(),
                'content' => '',
                'header' => '',
                'code'    => $exception->getCode(),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'trace'   => $exception->getTrace(),
            ]);
            Log::info('---------------------------------------------------------------------------------------');
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => 'exception'
            ],401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        if(Auth::user()->hasPermissionTo('delete department management') === false){
            abort(403);
        }
        try{
            $isExist = Department::where('id',$id)->first();
            if($isExist === null){
                return response()->json([
                    'message' => 'department not found',
                    'status' => 'error'
                ],404);
            }
            $isExist->delete();
            return response()->json([
                'message'    => 'Department deleted successfully.',
                'status'     => 'success',
                'redirectTo' => route('departments.index')
            ]);
        }catch (Exception $exception){
            Log::info('---------------------------------------------------------------------------------------');
            Log::info('****************************************');
            Log::info('CLASS : '.__CLASS__);
            Log::info('METHOD : '.__METHOD__);
            Log::info('FUNCTION : '.__FUNCTION__);
            Log::info('DIRECTORY : '.__DIR__);
            Log::info('****************************************');
            Log::info('EXCEPTION',[
                'status' => 'error',
                'curlUrl' => '',
                'message' => $exception->getMessage(),
                'content' => '',
                'header' => '',
                'code'    => $exception->getCode(),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'trace'   => $exception->getTrace(),
            ]);
            Log::info('---------------------------------------------------------------------------------------');
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => 'exception'
            ],401);
        }
    }
    /**
     * Import Departments from excel file.
     * */
    public function import(Request $request): JsonResponse{
        if(Auth::user()->hasPermissionTo('import department management') === false){
            abort(403);
        }
        try{
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls'
            ]);
            $file = $request->file('file');
            Excel::import(new DepartmentsImport, $file);
            return response()->json([
                'message' => 'Departments imported successfully.',
                'status' => 'success',
                'redirectTo' => route('departments.index')
            ]);
        }catch (Exception $exception){
            Log::info('---------------------------------------------------------------------------------------');
            Log::info('****************************************');
            Log::info('CLASS : '.__CLASS__);
            Log::info('METHOD : '.__METHOD__);
            Log::info('FUNCTION : '.__FUNCTION__);
            Log::info('DIRECTORY : '.__DIR__);
            Log::info('****************************************');
            Log::info('EXCEPTION',[
                'status' => 'error',
                'curlUrl' => '',
                'message' => $exception->getMessage(),
                'content' => '',
                'header' => '',
                'code'    => $exception->getCode(),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'trace'   => $exception->getTrace(),
            ]);
            Log::info('---------------------------------------------------------------------------------------');
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => 'exception'
            ],401);
        }
    }
    /**
     * Remove all modes of payment from storage.
     * */
    public function removeAllData(): JsonResponse
    {
        if(Auth::user()->hasPermissionTo('delete department management') === false){
            abort(403);
        }
        try{
            Department::truncate();
            return response()->json([
                'message'    => 'All department deleted successfully.',
                'status'     => 'success',
                'redirectTo' => route('departments.index')
            ]);
        }catch (Exception $exception){
            Log::info('---------------------------------------------------------------------------------------');
            Log::info('****************************************');
            Log::info('CLASS : '.__CLASS__);
            Log::info('METHOD : '.__METHOD__);
            Log::info('FUNCTION : '.__FUNCTION__);
            Log::info('DIRECTORY : '.__DIR__);
            Log::info('****************************************');
            Log::info('EXCEPTION',[
                'status' => 'error',
                'curlUrl' => '',
                'message' => $exception->getMessage(),
                'content' => '',
                'header' => '',
                'code'    => $exception->getCode(),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'trace'   => $exception->getTrace(),
            ]);
            Log::info('---------------------------------------------------------------------------------------');
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => 'exception'
            ],401);
        }
    }
}
