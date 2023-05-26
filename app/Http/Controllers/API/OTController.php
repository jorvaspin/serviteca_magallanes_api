<?php

namespace App\Http\Controllers\API;

use App\Models\WorkOrder;
use App\Models\WorkOrderTask;
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

    public function getWorkOrders()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return $this->sendError([], "user not found", 403);
            }
        } catch (JWTException $e) {
            return response()->json('ola');
        }

        $workOrder = WorkOrder::orderByDesc('created_at')->get();
        return response()->json($workOrder);
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

        $workOrderId = WorkOrder::get()->last();
        return response()->json($workOrderId->uuid);
    }

    public function getWorksToday()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return $this->sendError([], "user not found", 403);
            }
        } catch (JWTException $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }
        $worksToday = WorkOrder::whereDate('created_at', Carbon::today())->orderByDesc('created_at')->limit(10)->get();
        return response()->json($worksToday);
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


        $totalPay = 0;
        foreach ($request->data['trabajos'] as $trabajo) {
            $totalPay += $trabajo['costo'];
        }

        $lastWorkOrder = WorkOrder::get()->last();

        $workOrder = WorkOrder::create([
            'uuid'            => $lastWorkOrder->uuid + 1,
            'patente'         => $request->data['patente'],
            'marca'           => $request->data['marca'],
            'modelo'          => $request->data['modelo'],
            'kilometraje'     => $request->data['kilometraje'],
            'nombre_cliente'  => $request->data['nombre_cliente'],
            'mecanico'        => $request->data['mecanico'],
            'forma_pago'      => $request->data['forma_pago'],
            'total_a_pagar'   => $totalPay
        ]);

        $lastID = $workOrder->id;

        foreach($request->data['trabajos'] as $trabajo){
            WorkOrderTask::create([
                'ot_id'      => $lastID,
                'trabajo'    => $trabajo['trabajo'],
                'costo'      => $trabajo['costo']
            ]);
        }

        return response()->json([
            'message' => 'Orden de trabajo creada con exito'
        ]);
    }

    public function getLastWeekData(){
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return $this->sendError([], "user not found", 403);
            }
        } catch (JWTException $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }

        $date_array = array();
        $total_array = array();
        $date_count = array();

        $i = 0;
        while ($i < 7) {
            $today = Carbon::today();
            array_push( $date_array, $today->subDays($i)->format('Y-m-d') );
            $i++;
        }

        if(! empty( $date_array ) ){
            foreach($date_array as $date){
                array_push( $total_array, WorkOrder::whereDate('created_at', $date)->sum('total_a_pagar') );
                // $date_count = WorkOrder::where( 'created_at', '>', $date )->sum('total_a_pagar');
            }
        }

        return response()->json([
            'date_array' => $date_array,
            'total_array' => $total_array
        ]);
    }
}
