<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\LeaveTypesDataTable;
use App\Http\Controllers\Controller;
use App\Imports\LeaveTypesImport;
use App\Models\LeaveType;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class LeaveTypeManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LeaveTypesDataTable $dataTable)
    {
        if(Auth::user()->hasPermissionTo('read leave types management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Leave Types',
            'breadcrumbs' => Breadcrumbs::render('leaveTypes.index')
        ];
        return $dataTable->render('pages.apps.leaveTypes.list',$pageOptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasPermissionTo('create leave types management') === false){
            abort(403);
        }
        try{
            $validator = validator($request->all(),[
                'name'        => 'required|string|max:255',
                'total_days'  => 'required|numeric',
                'type'        => 'required|string|max:255',
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->all(),
                    'fields' => $validator->errors()->keys(),
                    'status' => 'error'
                ],401);
            }
            LeaveType::create([
                'name'        => $request->get('name'),
                'total_days'  => $request->get('total_days'),
                'type'        => $request->get('type'),
                'conditions'  => $request->get('conditions'),
            ]);
            return response()->json([
                'message'    => 'Leave type created successfully.',
                'status'     => 'success',
                'redirectTo' => route('leaveTypes.index')
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->hasPermissionTo('create leave types management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Create Leave Type',
            'actionUrl' => route('leaveTypes.store'),
            'method' => 'POST',
            'breadcrumbs' => Breadcrumbs::render('leaveTypes.create'),
            'redirectTo' => route('leaveTypes.index'),
        ];
        addJavascriptFile('assets/js/custom/configurations/leaveTypes/form.js');
        return view('pages.apps.leaveTypes.form',$pageOptions);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Auth::user()->hasPermissionTo('read leave types management') === false){
            abort(403);
        }
        $leaveType = LeaveType::findOrFail($id);
        $pageOptions = [
            'title'         => 'Leave types details',
            'breadcrumbs'   => Breadcrumbs::render('leaveTypes.show',$leaveType),
            'formData'      => $leaveType
        ];
        addJavascriptFile('assets/js/custom/configurations/leaveTypes/details.js');
        return view('pages.apps.leaveTypes.show', $pageOptions);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->hasPermissionTo('edit leave types management') === false){
            abort(403);
        }
        $leaveType = LeaveType::findOrFail($id);
        $pageOptions = [
            'title' => 'Update leave type',
            'actionUrl' => route('leaveTypes.update', $id),
            'formData' => $leaveType,
            'method' => 'PUT',
            'breadcrumbs' => Breadcrumbs::render('leaveTypes.edit',$leaveType),
            'redirectTo' => route('leaveTypes.index'),
        ];
        addJavascriptFile('assets/js/custom/configurations/leaveTypes/form.js');
        return view('pages.apps.leaveTypes.form', $pageOptions);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->hasPermissionTo('edit leave types management') === false){
            abort(403);
        }
        try{
            $validator = validator($request->all(),[
                'name'        => 'required|string|max:255',
                'total_days'  => 'required|numeric',
                'type'        => 'required|string|max:255',
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->all(),
                    'fields' => $validator->errors()->keys(),
                    'status' => 'error'
                ],401);
            }
            LeaveType::where('id',$id)->update([
                'name'                  => $request->get('name'),
                'total_days'            => $request->get('total_days'),
                'type'                  => $request->get('type'),
                'conditions'            => $request->get('conditions'),
            ]);
            return response()->json([
                'message'    => 'Leave type updated successfully.',
                'status'     => 'success',
                'redirectTo' => route('leaveTypes.index')
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
        if(Auth::user()->hasPermissionTo('delete leave types management') === false){
            abort(403);
        }
        try{
            $isExist = LeaveType::where('id',$id)->first();
            if($isExist === null){
                return response()->json([
                    'message' => 'Leave type not found',
                    'status' => 'error'
                ],404);
            }
            $isExist->delete();
            return response()->json([
                'message'    => 'Leave type deleted successfully.',
                'status'     => 'success',
                'redirectTo' => route('leaveTypes.index')
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
     * Import leaves from excel file.
     * */
    public function import(Request $request): JsonResponse{
        if(Auth::user()->hasPermissionTo('import leave types management') === false){
            abort(403);
        }
        try{
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls'
            ]);
            $file = $request->file('file');
            Excel::import(new LeaveTypesImport, $file);
            return response()->json([
                'message' => 'Leave types imported successfully.',
                'status' => 'success',
                'redirectTo' => route('leaveTypes.index')
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
        if(Auth::user()->hasPermissionTo('delete leave types management') === false){
            abort(403);
        }
        try{
            LeaveType::truncate();
            return response()->json([
                'message'    => 'All leave types deleted successfully.',
                'status'     => 'success',
                'redirectTo' => route('leaveTypes.index')
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
