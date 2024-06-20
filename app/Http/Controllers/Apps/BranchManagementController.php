<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\BranchDataTable;
use App\Http\Controllers\Controller;
use App\Imports\BranchesImport;
use App\Models\Branch;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BranchManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BranchDataTable $dataTable)
    {
        if(Auth::user()->hasPermissionTo('read branch management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Branches',
            'breadcrumbs' => Breadcrumbs::render('branches.index')
        ];
        return $dataTable->render('pages.apps.branches.list',$pageOptions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->hasPermissionTo('create branch management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Create Branch',
            'actionUrl' => route('branches.store'),
            'method' => 'POST',
            'breadcrumbs' => Breadcrumbs::render('branches.create'),
            'redirectTo' => route('branches.index'),
        ];
        addJavascriptFile('assets/js/custom/configurations/branches/form.js');
        return view('pages.apps.branches.form',$pageOptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasPermissionTo('create branch management') === false){
            abort(403);
        }
        try{
            $validator = validator($request->all(),[
                'name'        => 'required|string|max:255',
                'country'     => 'required|string|max:255',
                'email'       => 'required|email',
                'code'        => 'required|string|max:255',
                'state'       => 'required|string|max:255',
                'phone'       => 'required|string|max:255',
                'address'     => 'required|string|max:255',
                'postal_code' => 'required|string|max:255',
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->all(),
                    'fields' => $validator->errors()->keys(),
                    'status' => 'error'
                ],401);
            }
            Branch::create([
                'name'      => $request->get('name'),
                'country'   => $request->get('country'),
                'email'   => $request->get('email'),
                'code'   => $request->get('code'),
                'state'   => $request->get('state'),
                'phone'   => $request->get('phone'),
                'address'   => $request->get('address'),
                'postal_code'   => $request->get('postal_code'),
            ]);
            return response()->json([
                'message'    => 'Branch created successfully.',
                'status'     => 'success',
                'redirectTo' => route('branches.index')
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
        if(Auth::user()->hasPermissionTo('read branch management') === false){
            abort(403);
        }
        $Branch = Branch::findOrFail($id);
        $pageOptions = [
            'title'         => 'Branch details',
            'breadcrumbs'   => Breadcrumbs::render('branches.show',$Branch),
            'formData'      => $Branch
        ];
        addJavascriptFile('assets/js/custom/configurations/branches/details.js');
        return view('pages.apps.branches.show', $pageOptions);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->hasPermissionTo('edit branch management') === false){
            abort(403);
        }
        $branch = Branch::findOrFail($id);
        $pageOptions = [
            'title' => 'Update Branch',
            'actionUrl' => route('branches.update', $id),
            'formData' => $branch,
            'method' => 'PUT',
            'breadcrumbs' => Breadcrumbs::render('branches.edit',$branch),
            'redirectTo' => route('branches.index'),
        ];
        addJavascriptFile('assets/js/custom/configurations/branches/form.js');
        return view('pages.apps.branches.form', $pageOptions);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->hasPermissionTo('edit branch management') === false){
            abort(403);
        }
        try{
            $validator = validator($request->all(),[
                'name'        => 'required|string|max:255',
                'country'     => 'required|string|max:255',
                'email'       => 'required|email',
                'code'        => 'required|string|max:255',
                'state'       => 'required|string|max:255',
                'phone'       => 'required|string|max:255',
                'address'     => 'required|string|max:255',
                'postal_code' => 'required|string|max:255',
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->all(),
                    'fields' => $validator->errors()->keys(),
                    'status' => 'error'
                ],401);
            }
            Branch::where('id',$id)->update([
                'name'      => $request->get('name'),
                'country'   => $request->get('country'),
                'email'   => $request->get('email'),
                'code'   => $request->get('code'),
                'state'   => $request->get('state'),
                'phone'   => $request->get('phone'),
                'address'   => $request->get('address'),
                'postal_code'   => $request->get('postal_code'),
            ]);
            return response()->json([
                'message'    => 'Branch updated successfully.',
                'status'     => 'success',
                'redirectTo' => route('branches.index')
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
        if(Auth::user()->hasPermissionTo('delete branch management') === false){
            abort(403);
        }
        try{
            $isExist = Branch::where('id',$id)->first();
            if($isExist === null){
                return response()->json([
                    'message' => 'Branch not found',
                    'status' => 'error'
                ],404);
            }
            $isExist->delete();
            return response()->json([
                'message'    => 'Branch deleted successfully.',
                'status'     => 'success',
                'redirectTo' => route('branches.index')
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
     * Import branch from excel file.
     * */
    public function import(Request $request): JsonResponse{
        if(Auth::user()->hasPermissionTo('import branch management') === false){
            abort(403);
        }
        try{
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls'
            ]);
            $file = $request->file('file');
            Excel::import(new BranchesImport, $file);
            return response()->json([
                'message' => 'branch imported successfully.',
                'status' => 'success',
                'redirectTo' => route('branches.index')
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
        if(Auth::user()->hasPermissionTo('delete branch management') === false){
            abort(403);
        }
        try{
            Branch::truncate();
            return response()->json([
                'message'    => 'All branch deleted successfully.',
                'status'     => 'success',
                'redirectTo' => route('branches.index')
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
