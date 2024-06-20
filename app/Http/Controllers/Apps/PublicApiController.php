<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicApiController extends Controller
{
    /**
     * Login user
     *
     * @param Request $request
     * @return JsonResponse
     * */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ],[
                'email.required' => 'Email is required',
                'email.email' => 'Email must be a valid email address',
                'password.required' => 'Password is required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'errors' => $validator->errors()
                ], 400);
            }
            if (!auth()->attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Invalid login credentials',
                ], 401);
            }
            $user = auth()->user();
            $user->tokens()->delete();
            $token = $user->createToken($user->email.'-AuthToken', ['*'], now()->addWeekdays(7))->plainTextToken;
            return response()->json([
                'user'         => $user,
                'access_token' => $token,
            ]);
        }catch (Exception $exception){
            return response()->json([
                'type' => 'exception',
                'errors' => $exception->getMessage()
            ], 400);
        }
    }

    /**
     * Create user
     *
     * @param  Request  $request
     * @return JsonResponse [string] message
     */
    public function register(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email'=>'required|string|unique:users',
                'password'=>'required|string|min:6|max:12',
                'c_password' => 'required|same:password'
            ],[
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.unique' => 'Email already exists',
                'password.required' => 'Password is required',
                'password.min' => 'Password must be at least 6 characters',
                'password.max' => 'Password must be at most 12 characters',
                'c_password.required' => 'Confirm password is required',
                'c_password.same' => 'Password and confirm password must be same',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'errors' => $validator->errors()
                ], 400);
            }
            $user = new User([
                'name'  => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
            ]);
            $user->assignRole('customer');
            if($user->save()){
                $user->tokens()->delete();
                $tokenResult = $user->createToken($user->email.'-AuthToken', ['*'], now()->addWeekdays(7));
                $token = $tokenResult->plainTextToken;
                return response()->json([
                    'message' => 'Customer created successfully',
                    'accessToken'=> $token,
                ],201);
            }
            return response()->json([
                'error' =>  'Provide proper details'
            ], 400);
        }catch (Exception $exception){
            return response()->json([
                'type' => 'exception',
                'errors' => $exception->getMessage()
            ], 400);
        }
    }
    /**
     * Fetch user
     *
     * @param Request $request
     * @return JsonResponse
     * */
    public function fetchUser(Request $request)
    {
        try{
            $user = $request->user();
            return response()->json($user);
        }catch (Exception $exception){
            return response()->json([
                'type' => 'exception',
                'errors' => $exception->getMessage()
            ], 400);
        }
    }
}
