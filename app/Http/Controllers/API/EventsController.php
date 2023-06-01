<?php

namespace App\Http\Controllers\API;

use App\Models\Events;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;

class EventsController extends Controller
{
    public function getAllEvents(){
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return $this->sendError([], "user not found", 403);
            }
        } catch (JWTException $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }

        $events = Events::select('id', 'title', 'start')->get();
        return response()->json($events);
    }

    public function saveEvent(Request $request){
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return $this->sendError([], "user not found", 403);
            }
        } catch (JWTException $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }

        $event = new Events();
        $event->title = $request->title;
        $event->start = $request->start;
        $event->save();

        // traemos odos los eventos
        $events = Events::select('id', 'title', 'start')->get();

        return response()->json($events);
    }

    // delete evento
    public function deleteEvent(Request $request){
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return $this->sendError([], "user not found", 403);
            }
        } catch (JWTException $e) {
            return $this->sendError([], $e->getMessage(), 500);
        }

        Events::where('id', $request->id)->delete();

        return response()->json([
            'message' => 'Evento eliminado con exito'
        ]);
    }

}
