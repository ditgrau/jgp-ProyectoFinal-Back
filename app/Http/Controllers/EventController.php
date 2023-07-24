<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User_event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    public function getAllEvents() 
    {
        try {
            $events = Event::all();
            
            return response()->json([
                'message' => 'Events retrieved',
                'data' => $events,
                'success' => true
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error retrieving events ' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving events'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEventsByType($typeId) 
    {
        try {
            $events = Event::where('event_type_id', $typeId)->get();
            
            return response()->json([
                'message' => 'Events retrieved',
                'data' => $events,
                'success' => true
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error retrieving events ' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving events'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getMyEvents() 
    {
        try {
            $user = auth()->user();
            $userId = $user->id;
            $events = User_event::where('user_id', $userId)
            ->with('event')
            ->get();

            return response()->json([
                'message' => 'Events retrieved',
                'data' => $events,
                'success' => true,
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error retrieving events ' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving events'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // public function myEventsByType($typeId) 
    // {
    //     try {
    //         $user = auth()->user();
    //         $events = User_event::where('user_id', $user->id)
    //         ->with('event')->where('event_type_id', $typeId)
    //         ->get();
            
    //         return response()->json([
    //             'message' => 'Events retrieved',
    //             'data' => $events,
    //             'success' => true
    //         ], Response::HTTP_OK);

    //     } catch (\Throwable $th) {
    //         Log::error('Error retrieving events ' . $th->getMessage());

    //         return response()->json([
    //             'message' => 'Error retrieving events'
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }
    
    // TENGO QUE BUSCAR EN LA TABLA INTERMEDIA




    //crear evento
    // $request->validate([
    //     'name' => 'required|string',
    //     'start_date' => 'required|date|after:today', 
    //     'end_date' => 'nullable|date|after:start_date',
    //     'location' => 'required|string',
    //     'comment' => 'nullable|string',
    //     'pdf_path' => 'nullable|string',
    // ]);
}
