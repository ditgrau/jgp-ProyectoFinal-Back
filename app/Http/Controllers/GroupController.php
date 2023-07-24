<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User_group;
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

    // ALL MIS GRUPOS 

    public function getMyGroups()
    {
        try {
            $user = auth()->user();
            $userId = $user->id;
            $groups = User_group::where('user_id', $userId)
                ->with('group')
                ->get();

            return response()->json([
                'message' => 'Groups retrieved',
                'data' => $groups,
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error retrieving groups ' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving results'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
