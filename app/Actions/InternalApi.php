<?php

namespace App\Actions;

use App\Models\WCustomer;
use App\Models\WModeOfPayment;
use App\Models\WTreatment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InternalApi
{
    public function getChildTreatments(Request $request): JsonResponse
    {
       try{
            $treatment = WTreatment::with(['children'])->whereHas('children')->where('id','=', $request->get('treatment_parent_id'))->first();
            if($treatment === null){
                return response()->json([
                    'status' => 'error',
                    'message' => 'No child treatments found'
                ],404);
            }
            return response()->json([
                'status' => 'success',
                'data' => $treatment->children
            ]);
       }catch (Exception $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ],401);
       }
    }
    public function getAllModesOfPayment(Request $request): JsonResponse
    {
        try{
            $modesOfPayment = WModeOfPayment::all();
            if($modesOfPayment === null){
                return response()->json([
                    'status' => 'error',
                    'message' => 'No modes of payment found'
                ],404);
            }
            return response()->json([
                'status' => 'success',
                'data' => $modesOfPayment
            ]);
        }catch (Exception $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ],401);
        }
    }
    public function getCustomerDetails(Request $request): JsonResponse
    {
        try{
            $customer = WCustomer::with(['branch','user'])->where('id',$request->get('customer_id'))->first();
            if($customer === null){
                return response()->json([
                    'status' => 'error',
                    'message' => 'No customer found'
                ],404);
            }
            return response()->json([
                'status' => 'success',
                'data' => $customer
            ]);
        }catch (Exception $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ],401);
        }
    }
}
