<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\DesignationsDataTable;
use App\Http\Controllers\Controller;
use App\Imports\DesignationsImport;
use App\Models\Designation;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class DesignationsManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DesignationsDataTable $dataTable)
    {
        if(Auth::user()->hasPermissionTo('read designation management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Designations',
            'breadcrumbs' => Breadcrumbs::render('designations.index')
        ];
        return $dataTable->render('pages.apps.designations.list',$pageOptions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->hasPermissionTo('create designation management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Create designation',
            'actionUrl' => route('designations.store'),
            'method' => 'POST',
            'breadcrumbs' => Breadcrumbs::render('designations.create'),
            'redirectTo' => route('designations.index')
        ];
        addJavascriptFile('assets/js/custom/configurations/designations/form.js');
        return view('pages.apps.designations.form',$pageOptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasPermissionTo('create designation management') === false){
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
            Designation::create([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'status' => $request->get('status')
            ]);
            return response()->json([
                'message'    => 'Designation created successfully.',
                'status'     => 'success',
                'redirectTo' => route('designations.index')
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
        if(Auth::user()->hasPermissionTo('read designation management') === false){
            abort(403);
        }
        $WDesignation = Designation::findOrFail($id);
        $pageOptions = [
            'title'         => 'Designation details',
            'breadcrumbs'   => Breadcrumbs::render('designations.show',$WDesignation),
            'formData'      => $WDesignation
        ];
        addJavascriptFile('assets/js/custom/configurations/designations/details.js');
        return view('pages.apps.designations.show', $pageOptions);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->hasPermissionTo('edit designation management') === false){
            abort(403);
        }
        $WDesignation = Designation::findOrFail($id);
        $pageOptions = [
            'title' => 'Update designation',
            'actionUrl' => route('designations.update', $id),
            'formData' => $WDesignation,
            'method' => 'PUT',
            'breadcrumbs' => Breadcrumbs::render('designations.edit',$WDesignation),
            'redirectTo' => route('designations.index')
        ];
        addJavascriptFile('assets/js/custom/configurations/designations/form.js');
        return view('pages.apps.designations.form', $pageOptions);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->hasPermissionTo('edit designation management') === false){
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
            Designation::where('id',$id)->update([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'status' => $request->get('status')
            ]);
            return response()->json([
                'message'    => 'Designation updated successfully.',
                'status'     => 'success',
                'redirectTo' => route('designations.index')
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
        if(Auth::user()->hasPermissionTo('delete designation management') === false){
            abort(403);
        }
        try{
            $isExist = Designation::where('id',$id)->first();
            if($isExist === null){
                return response()->json([
                    'message' => 'Designation not found',
                    'status' => 'error'
                ],404);
            }
            $isExist->delete();
            return response()->json([
                'message'    => 'Designation deleted successfully.',
                'status'     => 'success',
                'redirectTo' => route('designations.index')
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
     * Import designations from excel file.
     * */
    public function import(Request $request): JsonResponse{
        if(Auth::user()->hasPermissionTo('import designation management') === false){
            abort(403);
        }
        try{
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls'
            ]);
            $file = $request->file('file');
            Excel::import(new DesignationsImport, $file);
            return response()->json([
                'message' => 'Designations imported successfully.',
                'status' => 'success',
                'redirectTo' => route('designations.index')
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
        if(Auth::user()->hasPermissionTo('delete designation management') === false){
            abort(403);
        }
        try{
            Designation::truncate();
            return response()->json([
                'message'    => 'All designation deleted successfully.',
                'status'     => 'success',
                'redirectTo' => route('designations.index')
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
