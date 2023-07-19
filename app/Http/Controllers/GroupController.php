<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends Controller
{
    public function getAllGroups() 
    {
        try {
            $groups = Group::all();
            
            return response()->json([
                'message' => 'Groups retrieved',
                'data' => $groups,
                'success' => true
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error getting groups' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving groups'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
