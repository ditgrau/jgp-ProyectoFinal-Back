<?php

namespace App\Http\Controllers;

use App\Models\User_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function profile()
    {
        try {
            $user = auth()->user();
            $userId = $user->id;
            $userData = User_data::where('user_id', $userId)->first();
            // $userGroup = 
            $user->group;

            return response()->json([
                'message' => 'User found',
                'data' => $user,
                'info' => $userData,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error retrieving user ' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving user'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
