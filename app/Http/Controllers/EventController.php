<?php

namespace App\Http\Controllers;

use App\Models\Event;
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
}
