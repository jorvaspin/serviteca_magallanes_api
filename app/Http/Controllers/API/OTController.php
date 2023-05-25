<?php

namespace App\Http\Controllers\API;

use App\Models\OrdenTrabajoModel;
use App\Models\TrabajosOTModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;

class OTController extends Controller
{

    public function sendResponse($data)
    {
        $response = [
            'data' => $data
        ];

        return response()->json($response);
    }

    public function getOrdenTrabajos()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return $this->sendError([], "user not found", 403);
            }
        } catch (JWTException $e) {
            return response()->json('ola');
        }

        $ordenTrabajo = OrdenTrabajoModel::orderByDesc('created_at')->get();
        return response()->json($ordenTrabajo);
    }

    public function getOrderId()
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
        return response()->json($ordenTrabajo->uuid);
    }

    public function getOrdenTrabajosHoy()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return $this->sendError([], "user not found", 403);
            }
        } catch (JWTException $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
        $ordenTrabajo = OrdenTrabajoModel::whereDate('created_at', Carbon::today())->orderByDesc('created_at')->limit(10)->get();
        return response()->json($ordenTrabajo);
    }

    public function createWorkOrder(Request $request){
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return $this->sendError([], "user not found", 403);
            }
        } catch (JWTException $e) {
            return $this->sendError([], $e->getMessage(), 500);
    }


        $total_a_pagar = 0;
        foreach ($request->data['trabajos'] as $trabajo) {
            $total_a_pagar += $trabajo['costo'];
        }

        $ordenTrabajo = OrdenTrabajoModel::get()->last();

        $workOrder = OrdenTrabajoModel::create([
            'uuid'            => $ordenTrabajo->uuid + 1,
            'patente'         => $request->data['patente'],
            'marca'           => $request->data['marca'],
            'modelo'          => $request->data['modelo'],
            'kilometraje'     => $request->data['kilometraje'],
            'nombre_cliente'  => $request->data['nombre_cliente'],
            'mecanico'        => $request->data['mecanico'],
            'forma_pago'      => $request->data['forma_pago'],
            'total_a_pagar'   => $total_a_pagar
        ]);

        $lastID = $workOrder->id;

        foreach($request->data['trabajos'] as $trabajo){
            TrabajosOTModel::create([
                'ot_id'             => $lastID,
                'nombre_trabajo'    => $trabajo['trabajo'],
                'precio'            => $trabajo['costo']
            ]);
        }

        return response()->json([
            'message' => 'Orden de trabajo creada con exito'
        ]);
    }
}
