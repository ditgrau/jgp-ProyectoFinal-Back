<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Event_type;
use App\Models\User_event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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

            $three = $events->take(3);

            return response()->json([
                'message' => 'Events retrieved',
                'data' => $events,
                'three' => $three,
                'success' => true,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error retrieving events ' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving events'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function newEvent(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'event_type_id' => 'required|integer',
                'name' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
                'location' => 'required|string',
                'comment' => 'required|string',
                'pdf_path' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $validData = $validator->validated();

            $newEvent = Event::create([
                'event_type_id' => $validData['event_type_id'],
                'name' => $validData['name'],
                'start_date' => $validData['start_date'],
                'end_date' => $validData['end_date'],
                'location' => $validData['location'],
                'comment' => $validData['comment'],
                'pdf_path' => $validData['pdf_path'],
            ]);
            return response()->json([
                'message' => 'Event created',
                'success' => true,
                'event' => $newEvent,
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Error registering user ' . $th->getMessage());

            return response()->json([
                'message' => 'Error registering user'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function addUserToEvent(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'integer|exists:user,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $userIds = $validator->validated()['user_ids'] ?? [];

        try {
            $event = Event::find($id);
            if (!$event) {
                return response()->json(['error' => 'El evento no existe'], 404);
            }

            $event->users()->attach($userIds);

            return response()->json(['message' => 'Usuarios agregados al evento'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar usuarios'], 500);
        }
    }
    public function myEventById($id)
    {
        try {
            $user = auth()->user();
            $userId = $user->id;
            $result = User_event::where('event_id', $id)
                ->where('user_id', $userId)
                ->with('event')
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Result retrieved by id',
                'data' => $result
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting result' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving result',
            ]);
        }
    }

    public function getEventById($id)
    {
        try {
            $result = Event::where('id', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Result retrieved by id',
                'data' => $result
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting result' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving result',
            ]);
        }
    }

// Obtener mis eventos por tipo - User (sin implementar, para un futuro, pero funciona)
    public function myEventsByType($typeId)

    {
        try {
            $user = auth()->user();
            $events = $user->event;

            $eventType = Event_type::where('id', $typeId)->first();
            $filteredEvents = $events->filter(function ($event) use ($eventType) {
                return $event->event_type_id === $eventType->id;
            });

            return response()->json([
                'success' => true,
                'message' => 'Result retrieved by id',
                'data' => $filteredEvents
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error getting result' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving result',
            ]);
        }
    }
}
