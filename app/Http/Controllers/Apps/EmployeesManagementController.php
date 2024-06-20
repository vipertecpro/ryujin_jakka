<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\EmployeesDataTable;
use App\Http\Controllers\Controller;
use App\Imports\EmployeesImport;
use App\Models\User;
use App\Models\Attachment;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class EmployeesManagementController extends Controller
{
    function saveFile($file, $key, $id) {
        $fileExtension = $file->getClientOriginalExtension();
        $fileName = $key.'_'.time().'_'.rand(0,999).'.'.$fileExtension;
        $fileSize = $file->getSize();
        $fileMimeType = $file->getMimeType();
        $fileOriginalName = $file->getClientOriginalName();
        $fileStorePath = $file->store('attachments');
        Attachment::create([
            'module_id' => $id,
            'uploaded_by' => Auth::id(),
            'module' => 'employees',
            'purpose' => $key,
            'file_original_name' => $fileOriginalName,
            'file_name' => $fileName,
            'file_path' => 'storage/'.$fileStorePath,
            'file_size' => $fileSize,
            'file_extension' => $fileExtension,
            'file_mime_type' => $fileMimeType,
        ]);
        Storage::disk('public')->put($fileStorePath, file_get_contents($file));
    }
    /**
     * Display a listing of the resource.
     */
    public function index(EmployeesDataTable $dataTable)
    {
        if(Auth::user()->hasPermissionTo('read employees management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Employees',
            'breadcrumbs' => Breadcrumbs::render('employees.index')
        ];
        return $dataTable->render('pages.apps.employees.list',$pageOptions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->hasPermissionTo('create employees management') === false){
            abort(403);
        }
        $pageOptions = [
            'title' => 'Create employees',
            'actionUrl' => route('employees.store'),
            'method' => 'POST',
            'breadcrumbs' => Breadcrumbs::render('employees.create'),
            'redirectTo' => route('employees.index'),
            'designations' => Designation::all(),
            'departments' => Department::all(),
            'branches' => Branch::all(),
        ];
        addJavascriptFile('assets/js/custom/configurations/employees/form.js');
        return view('pages.apps.employees.form',$pageOptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->hasPermissionTo('create employees management') === false){
            abort(403);
        }
        try{
            $validator = validator($request->all(),[
                'name'                  => 'required|string|max:255',
                'email'                 => 'required|email',
                'designation'           => 'required|string',
                'department'            => 'required|string',
                'branch'                => 'required|string',
                'employee_code'         => 'required|string',
                'date_of_joining'       => 'required|date',
                'status'                => 'required|string',
                'password'              => 'nullable',
                'phone'                 => 'nullable|string',
                'pan_number'            => 'nullable|string',
                'personal_number'       => 'nullable|string',
                'current_address'       => 'nullable|string',
                'permanent_address'     => 'nullable|string',
                'date_of_birth'         => 'nullable|date',
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->all(),
                    'fields' => $validator->errors()->keys(),
                    'status' => 'error'
                ],401);
            }
            $getUser = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'password' => Hash::make($request->get('password')),
                'status' => $request->get('status'),
            ]);
            $id = Employee::create([
                'user_id'           => $getUser->id,
                'branch_id'         => $request->get('branch'),
                'designation_id'    => $request->get('designation'),
                'department_id'     => $request->get('department'),
                'date_of_birth'     => $request->get('date_of_birth'),
                'date_of_joining'   => $request->get('date_of_joining'),
                'pan_number'        => $request->get('pan_number'),
                'employee_code'     => $request->get('employee_code'),
                'personal_number'   => $request->get('personal_number'),
                'current_address'   => $request->get('current_address'),
                'permanent_address' => $request->get('permanent_address'),
            ]);
            $attachments = $request->file('attachments');
            if($attachments !== null){
                foreach ($attachments as $key => $attachment){
                    if(is_array($attachment)){
                        foreach ($attachment as $key => $file){
                            if($file) {
                                $this->saveFile($file,$key,$id->id);
                            }
                        }
                    } else {
                        if($attachment) {
                            $this->saveFile($attachment,$key,$id->id);
                        }
                    }
                }
            }
            return response()->json([
                'message'    => 'Employees created successfully.',
                'status'     => 'success',
                'redirectTo' => route('employees.index')
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
        if(Auth::user()->hasPermissionTo('read employees management') === false){
            abort(403);
        }
        $employees = Employee::with(['user','branch','designation','department'])->findOrFail($id);
        $pageOptions = [
            'title'         => 'Employees details',
            'breadcrumbs'   => Breadcrumbs::render('employees.show',$employees),
            'formData'      => $employees,
            'designations' => Designation::all(),
            'departments' => Department::all(),
            'branches' => Branch::all(),
        ];
        addJavascriptFile('assets/js/custom/configurations/employees/details.js');
        return view('pages.apps.employees.show', $pageOptions);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->hasPermissionTo('edit employees management') === false){
            abort(403);
        }
        $employees = Employee::with(['attachments'])->where('id',$id)->first();
        $pageOptions = [
            'title' => 'Update employees',
            'actionUrl' => route('employees.update', $id),
            'formData' => $employees,
            'method' => 'PUT',
            'breadcrumbs' => Breadcrumbs::render('employees.edit',$employees),
            'redirectTo' => route('employees.index'),
            'designations' => Designation::all(),
            'departments' => Department::all(),
            'branches' => Branch::all(),
        ];
        addJavascriptFile('assets/js/custom/configurations/employees/form.js');
        return view('pages.apps.employees.form', $pageOptions);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->hasPermissionTo('edit employees management') === false){
            abort(403);
        }
        try{
            $validator = validator($request->all(),[
                'name'                  => 'required|string|max:255',
                'email'                 => 'required|email',
                'password'              => 'nullable',
                'designation'           => 'required|string',
                'department'            => 'required|string',
                'branch'                => 'required|string',
                'employee_code'         => 'required|string',
                'date_of_joining'       => 'required|date',
                'status'                => 'required|string',
                'phone'                 => 'nullable|string',
                'pan_number'            => 'nullable|string',
                'personal_number'       => 'nullable|string',
                'current_address'       => 'nullable|string',
                'permanent_address'     => 'nullable|string',
                'date_of_birth'         => 'nullable|date',
            ]);
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors()->all(),
                    'fields' => $validator->errors()->keys(),
                    'status' => 'error'
                ],401);
            }
            $getUser = User::where('email','=',$request->get('email'))->first();
            if($getUser === null){
                return response()->json([
                    'message' => 'User not found',
                    'status' => 'error'
                ],404);
            }
            if($request->get('password') === null){
                $password = $getUser->password;
            }else{
                $password = bcrypt($request->get('password'));
            }
            $getUser->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'password' => $password,
                'status' => $request->get('status'),
            ]);
            Employee::where('id','=',$id)->update([
                'user_id'           => $getUser->id,
                'branch_id'         => $request->get('branch'),
                'designation_id'    => $request->get('designation'),
                'department_id'     => $request->get('department'),
                'date_of_birth'     => $request->get('date_of_birth'),
                'date_of_joining'   => $request->get('date_of_joining'),
                'pan_number'        => $request->get('pan_number'),
                'employee_code'     => $request->get('employee_code'),
                'personal_number'   => $request->get('personal_number'),
                'current_address'   => $request->get('current_address'),
                'permanent_address' => $request->get('permanent_address'),
            ]);
            $attachments = $request->file('attachments');
            if($attachments !== null){
                foreach ($attachments as $key => $attachment){
                    if(is_array($attachment)){
                        foreach ($attachment as $key => $file){
                            $oldAttachment = Attachment::where('module_id',$id)->where('purpose',$key)->first();
                            if ($file) {
                                if($oldAttachment !== null){
                                    Storage::disk('public')->delete($oldAttachment->file_path);
                                    $oldAttachment->delete();
                                }
                                $this->saveFile($file,$key,$id);
                            }
                        }
                    }else{
                        $oldAttachment = Attachment::where('module_id',$id)->where('purpose',$key)->first();
                        if ($attachment) {
                            if($oldAttachment !== null){
                                Storage::disk('public')->delete($oldAttachment->file_path);
                                $oldAttachment->delete();
                            }
                            $this->saveFile($attachment,$key,$id);
                        }
                    }
                }
            }

            return response()->json([
                'message'    => 'Employees created successfully.',
                'status'     => 'success',
                'redirectTo' => route('employees.index')
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
        if(Auth::user()->hasPermissionTo('delete employees management') === false){
            abort(403);
        }
        try{
            $isExist = Employee::where('id',$id)->first();
            if($isExist === null){
                return response()->json([
                    'message' => 'Employee not found',
                    'status' => 'error'
                ],404);
            }
            $attachments = Attachment::where('module_id',$id)->get();
            foreach ($attachments as $attachment){
                Storage::disk('public')->delete($attachment->file_path);
                $attachment->delete();
            }
            $isExist->user->delete();
            $isExist->delete();
            return response()->json([
                'message'    => 'Employees deleted successfully.',
                'status'     => 'success',
                'redirectTo' => route('employees.index')
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
     * Import employees from excel file.
     * */
    public function import(Request $request): JsonResponse{
        if(Auth::user()->hasPermissionTo('import employees management') === false){
            abort(403);
        }
        try{
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls'
            ]);
            $file = $request->file('file');
            Excel::import(new EmployeesImport, $file);
            return response()->json([
                'message' => 'employees imported successfully.',
                'status' => 'success',
                'redirectTo' => route('employees.index')
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
        if(Auth::user()->hasPermissionTo('delete employees management') === false){
            abort(403);
        }
        try{
            $allEmployees = Employee::all();
            foreach ($allEmployees as $employee){
                $attachments = Attachment::where('module_id',$employee->id)->get();
                foreach ($attachments as $attachment){
                    Storage::disk('public')->delete($attachment->file_path);
                    $attachment->delete();
                }
                $employee->user->delete();
                $employee->delete();
            }
            return response()->json([
                'message'    => 'All employees deleted successfully.',
                'status'     => 'success',
                'redirectTo' => route('employees.index')
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
