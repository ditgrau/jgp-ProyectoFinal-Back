<?php

namespace App\Http\Controllers;

use App\Models\Event_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Event_typeController extends Controller
{
    public function getAllEventTypes()
    {
        try {
            $roles = Event_type::all();
            
            return response()->json([
                'message' => 'Roles retrieved',
                'data' => $roles,
                'success' => true
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error getting roles' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving roles'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
