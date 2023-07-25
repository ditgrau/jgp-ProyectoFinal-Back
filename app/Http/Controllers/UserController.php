<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\User_data;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /* FUNCION PERFIL */

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

    /* FUNCION UPDATE PERFIL */

    public function updateProfile(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string',
                'surname' => 'nullable|string',
            ]);

            $validatorData = Validator::make($request->all(), [
                'birth_date' => 'nullable|date',
                'dni' => 'nullable|string|regex:/^[0-9]{8}[A-Za-z]$/',
                'contact_email' => 'nullable|email',
                'first_phone' => 'nullable|regex:/^\d{9}$/',
                'second_phone' => 'nullable|regex:/^\d{9}$/',
            ]);

            if ($validator->fails() || $validatorData->fails()) {
                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                } else if ($validatorData->fails()) {
                    return response()->json($validatorData->errors(), 400);
                }
            }

            $validUser = $validator->validated();
            $user = auth()->user();
            $currentUser = User::find($user->id)->update($validUser);
            
            $validUserData = $validatorData->validated();
            $currentDataUser = User_data::where('user_id', $user->id)->first();
            $currentDataUser->update($validUserData);

            return response()->json([
                'message' => 'User profile updated',
                'success' => true,
                'user' => $currentUser,
                'profile' => $validUser,
                'newData' => $validUserData
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error updating user profile: ' . $th->getMessage());
            return response()->json([
                'message' => 'Error updating user profile'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAverage() 
    {
        try {
            $user = auth()->user();
            $userId = $user->id;

            $totals = Result::where('user_id', $userId)->pluck('total');
            $positions = Result::where('user_id', $userId)->pluck('ranking');
            
            $average = $totals->avg();
            $ranking = round($positions->avg());
            $updatedUser = User::find($userId)->update(['average' => $average]);

            return response()->json([
                'message' => 'Results retrieved',
                'data' => $totals,
                'average' => $average,
                'ranking' => $ranking,
                'success' => true
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error retrieving results ' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving results'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    
}






// 
// 'average' => 'nullable|float',
// 'role_id' => 'nullable|integer',
// $updatedUser = User::first($userId);
//             $updatedUser->update($validUser);

//             $validDataUser = $validatorData->validated();
//             $updatedDataUser = User_data::where('user_id', $userId)->first();
//             $updatedDataUser->update($validDataUser);

//             if (isset($request->group)) {
//                 $groups = $request->input('group');
//                 $updatedUser->group()->sync($groups);
//             }
