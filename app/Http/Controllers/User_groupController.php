<?php

namespace App\Http\Controllers;

use App\Models\User_group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class User_groupController extends Controller
{
    public function usersByGroupId($groupId)
    { 
        try {
            $users = User_group::where('group_id', $groupId)
            ->with('user')
            ->get();

            return response()->json([
                'message' => 'Users retrieved',
                'data' => $users,
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