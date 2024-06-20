<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\LeaveRequestsDataTable;
use App\Http\Controllers\Controller;
use App\Imports\LeaveRequestsImport;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class LeaveRequestsManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LeaveRequestsDataTable $dataTable)
    {
        if(Auth::user()->hasPermissionTo('read leave requests management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Leave Requests',
            'breadcrumbs' => Breadcrumbs::render('leaveRequests.index'),
        ];
        return $dataTable->render('pages.apps.leaveRequests.list',$pageOptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasPermissionTo('create leave requests management') === false){
            abort(403);
        }
        try{
            $validator = validator($request->all(),[
                'w_employee_id'     => 'required',
                'leave_type_id'     => 'required',
                'start_date'        => 'required|date',
                'end_date'          => 'required|date',
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->all(),
                    'fields' => $validator->errors()->keys(),
                    'status' => 'error'
                ],401);
            }
            LeaveRequest::create([
                'w_employee_id'     => $request->get('w_employee_id'),
                'leave_type_id'     => $request->get('leave_type_id'),
                'start_date'        => Carbon::parse($request->get('start_date'))->format('Y-m-d'),
                'end_date'          => Carbon::parse($request->get('end_date'))->format('Y-m-d'),
                'status'            => 'pending',
            ]);
            return response()->json([
                'message'    => 'Leave type created successfully.',
                'status'     => 'success',
                'redirectTo' => route('leaveRequests.index')
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
        if(Auth::user()->hasPermissionTo('create leave requests management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Create Leave Request',
            'actionUrl' => route('leaveRequests.store'),
            'method' => 'POST',
            'breadcrumbs' => Breadcrumbs::render('leaveRequests.create'),
            'redirectTo' => route('leaveRequests.index'),
            'leaveTypes' => LeaveType::all(),
        ];
        addJavascriptFile('assets/js/custom/configurations/leaveRequests/form.js');
        return view('pages.apps.leaveRequests.form',$pageOptions);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Auth::user()->hasPermissionTo('read leave requests management') === false){
            abort(403);
        }
        $leaveRequest = LeaveRequest::with(['employee','leaveType','approvedBy','rejectedBy'])->findOrFail($id);
        $pageOptions = [
            'title'         => 'Leave request details',
            'breadcrumbs'   => Breadcrumbs::render('leaveRequests.show',$leaveRequest),
            'formData'      => $leaveRequest
        ];
        addJavascriptFile('assets/js/custom/configurations/leaveRequests/details.js');
        return view('pages.apps.leaveRequests.show', $pageOptions);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->hasPermissionTo('edit leave requests management') === false){
            abort(403);
        }
        $leaveRequest = LeaveRequest::findOrFail($id);
        $pageOptions = [
            'title' => 'Update treatment',
            'actionUrl' => route('leaveRequests.update', $id),
            'formData' => $leaveRequest,
            'method' => 'PUT',
            'breadcrumbs' => Breadcrumbs::render('leaveRequests.edit',$leaveRequest),
            'redirectTo' => route('leaveRequests.index'),
            'leaveTypes' => LeaveType::all(),
        ];
        addJavascriptFile('assets/js/custom/configurations/leaveRequests/form.js');
        return view('pages.apps.leaveRequests.form', $pageOptions);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        if(Auth::user()->hasPermissionTo('delete leave requests management') === false){
            abort(403);
        }
        try{
            $isExist = LeaveRequest::where('id',$id)->first();
            if($isExist === null){
                return response()->json([
                    'message' => 'Leave request not found',
                    'status' => 'error'
                ],404);
            }
            $isExist->delete();
            return response()->json([
                'message'    => 'Leave request has been deleted successfully.',
                'status'     => 'success',
                'redirectTo' => route('leaveRequests.index')
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
        if(Auth::user()->hasPermissionTo('import leave requests management') === false){
            abort(403);
        }
        try{
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls'
            ]);
            $file = $request->file('file');
            Excel::import(new leaveRequestsImport, $file);
            return response()->json([
                'message' => 'Leave requests has been imported successfully.',
                'status' => 'success',
                'redirectTo' => route('leaveRequests.index')
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
        if(Auth::user()->hasPermissionTo('delete leave requests management') === false){
            abort(403);
        }
        try{
            LeaveRequest::truncate();
            return response()->json([
                'message'    => 'All leaves requests deleted successfully.',
                'status'     => 'success',
                'redirectTo' => route('leaveRequests.index')
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
     * Approve leave request.
     * */
    public function approveLeaveRequest(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'leave_request_id' => 'required|numeric'
            ]);
            $leaveRequest = LeaveRequest::findOrFail($request->get('leave_request_id'));
            $leaveRequest->update([
                'status' => 'approved',
                'approved_by' => $request->get('approved_by'),
                'approved_remarks' => $request->get('approved_remarks'),
                'approved_at' => Carbon::now()
            ]);
            return response()->json([
                'message' => 'Leave request has been approved successfully.',
                'status' => 'success',
                'redirectTo' => route('leaveRequests.index')
            ]);
        } catch (Exception $exception) {
            Log::info('---------------------------------------------------------------------------------------');
            Log::info('****************************************');
            Log::info('CLASS : '.__CLASS__);
            Log::info('METHOD : '.__METHOD__);
            Log::info('FUNCTION : '.__FUNCTION__);
            Log::info('DIRECTORY : '.__DIR__);
            Log::info('****************************************');
            Log::info('EXCEPTION', [
                'status' => 'error',
                'curlUrl' => '',
                'message' => $exception->getMessage(),
                'content' => '',
                'header' => '',
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTrace(),
            ]);
            Log::info('---------------------------------------------------------------------------------------');
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => 'exception'
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->hasPermissionTo('edit leave requests management') === false){
            abort(403);
        }
        try{
            $validator = validator($request->all(),[
                'w_employee_id'     => 'required|numeric',
                'leave_type_id'     => 'required|numeric',
                'start_date'        => 'required|date',
                'end_date'          => 'required|date',
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->all(),
                    'fields' => $validator->errors()->keys(),
                    'status' => 'error'
                ],401);
            }
            LeaveRequest::where('id',$id)->update([
                'w_employee_id'     => $request->get('w_employee_id'),
                'leave_type_id'     => $request->get('leave_type_id'),
                'start_date'        => Carbon::parse($request->get('start_date'))->format('Y-m-d'),
                'end_date'          => Carbon::parse($request->get('end_date'))->format('Y-m-d'),
            ]);
            return response()->json([
                'message'    => 'Leave request has been updated successfully.',
                'status'     => 'success',
                'redirectTo' => route('leaveRequests.index')
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
     * Reject leave request.
     * */
    public function rejectLeaveRequest(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'leave_request_id' => 'required|numeric'
            ]);
            $leaveRequest = LeaveRequest::findOrFail($request->get('leave_request_id'));
            $leaveRequest->update([
                'status' => 'rejected',
                'rejected_by' => $request->get('rejected_by'),
                'rejected_reason' => $request->get('rejected_reason'),
                'rejected_at' => Carbon::now()
            ]);
            return response()->json([
                'message' => 'Leave request has been rejected successfully.',
                'status' => 'success',
                'redirectTo' => route('leaveRequests.index')
            ]);
        } catch (Exception $exception) {
            Log::info('---------------------------------------------------------------------------------------');
            Log::info('****************************************');
            Log::info('CLASS : '.__CLASS__);
            Log::info('METHOD : '.__METHOD__);
            Log::info('FUNCTION : '.__FUNCTION__);
            Log::info('DIRECTORY : '.__DIR__);
            Log::info('****************************************');
            Log::info('EXCEPTION', [
                'status' => 'error',
                'curlUrl' => '',
                'message' => $exception->getMessage(),
                'content' => '',
                'header' => '',
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTrace(),
            ]);
            Log::info('---------------------------------------------------------------------------------------');
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => 'exception'
            ], 401);
        }
    }
    /**
     * Cancel leave request.
     * */
    public function cancelLeaveRequest($leave_request_id): RedirectResponse
    {
        try {
            $leaveRequest = LeaveRequest::findOrFail($leave_request_id);
            $leaveRequest->update([
                'status' => 'cancelled'
            ]);
            return redirect()->route('leaveRequests.index');
        } catch (Exception $exception) {
            Log::info('---------------------------------------------------------------------------------------');
            Log::info('****************************************');
            Log::info('CLASS : '.__CLASS__);
            Log::info('METHOD : '.__METHOD__);
            Log::info('FUNCTION : '.__FUNCTION__);
            Log::info('DIRECTORY : '.__DIR__);
            Log::info('****************************************');
            Log::info('EXCEPTION', [
                'status' => 'error',
                'curlUrl' => '',
                'message' => $exception->getMessage(),
                'content' => '',
                'header' => '',
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTrace(),
            ]);
            Log::info('---------------------------------------------------------------------------------------');
            return redirect()->route('leaveRequests.index');
        }
    }

}
