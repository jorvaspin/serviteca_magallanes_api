<?php

namespace App\Http\Controllers\API;

use App\Models\OrdenTrabajoModel;
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
                $ordenTrabajo = OrdenTrabajoModel::whereDate('created_at','<=', Carbon::now())
                ->whereDate('created_at','>=', Carbon::now()->subWeek())
                ->get();

                return response()->json([
                    'ordenTrabajo' => $ordenTrabajo,
                    'ganancias' => 1000,
                    'trabajosRealizados' => 100
                ]);
                break;
            case 'month':
                $ordenTrabajo = OrdenTrabajoModel::whereDate('created_at','<=', Carbon::now())
                ->whereDate('created_at','>=', Carbon::now()->subMonth())
                ->get();
                return response()->json([
                    'ordenTrabajo' => $ordenTrabajo,
                    'ganancias' => 1000,
                    'trabajosRealizados' => 100
                ]);
                break;
            case 'year':
                $ordenTrabajo = OrdenTrabajoModel::whereDate('created_at','<=', Carbon::now())
                ->whereDate('created_at','>=', Carbon::now()->subYear())
                ->get();
                return response()->json([
                    'ordenTrabajo' => $ordenTrabajo,
                    'ganancias' => 1000,
                    'trabajosRealizados' => 100
                ]);
                break;

            default:
                $ordenTrabajo = OrdenTrabajoModel::whereDate('created_at','<=', Carbon::now())
                ->whereDate('created_at','>=', Carbon::now()->subWeek())
                ->get();
                return response()->json([
                    'ordenTrabajo' => $ordenTrabajo,
                    'ganancias' => 1000,
                    'trabajosRealizados' => 100
                ]);
                break;
        }
    }

    public function getLastTrabajosRealizados()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return $this->sendError([], "user not found", 403);
            }
        } catch (JWTException $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
        $ordenTrabajo = OrdenTrabajoModel::get()->last();
        return response()->json($ordenTrabajo);
    }

}
