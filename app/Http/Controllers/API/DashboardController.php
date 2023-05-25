<?php

namespace App\Http\Controllers\API;

use App\Models\WorkOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function sendResponse($data)
    {
        $response = [
            'data' => $data
        ];

        return response()->json($response);
    }

    public function getDataAdmin($data)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return $this->sendError([], "user not found", 403);
            }
        } catch (JWTException $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }

        switch ($data) {
            case 'week':
                $workOrders = WorkOrder::whereDate('created_at','<=', Carbon::now())
                ->whereDate('created_at','>=', Carbon::now()->subWeek())
                ->get();

                return response()->json([
                    'workOrders' => $workOrders
                ]);
                break;
            case 'month':
                $workOrders = WorkOrder::whereDate('created_at','<=', Carbon::now())
                ->whereDate('created_at','>=', Carbon::now()->subMonth())
                ->get();
                return response()->json([
                    'workOrders' => $workOrders
                ]);
                break;
            case 'year':
                $workOrders = WorkOrder::whereDate('created_at','<=', Carbon::now())
                ->whereDate('created_at','>=', Carbon::now()->subYear())
                ->get();
                return response()->json([
                    'workOrders' => $workOrders
                ]);
                break;

            default:
                $workOrders = WorkOrder::whereDate('created_at','<=', Carbon::now())
                ->whereDate('created_at','>=', Carbon::now()->subWeek())
                ->get();
                return response()->json([
                    'workOrders' => $workOrders
                ]);
                break;
        }
    }

    public function getLastWorksCompleted()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return $this->sendError([], "user not found", 403);
            }
        } catch (JWTException $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
        $lastWorksCompleted = WorkOrder::get()->last();
        return response()->json($lastWorksCompleted);
    }

}
