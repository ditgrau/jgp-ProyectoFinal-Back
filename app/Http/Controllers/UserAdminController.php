<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserAdminController extends Controller
{
    public function getAllUsers()
    {
        try {
            $users = User::select('id', 'role_id', 'name', 'surname', 'email')
                ->with('role')->with('group')
                ->get();
            // dd($users->toSql());

            return response()->json([
                'message' => 'Users retrieved',
                'data' => $users,
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting users' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving users'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUsersAverage()
    {
        try {
            $usersAverage = User::select('name', 'surname', 'average')->get();

            return response()->json([
                'message' => 'Users retrieved',
                'data' => $usersAverage,
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting users' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving users'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserById($id)
    {
        try {
            $user = User::with('user_data')->with('role:name')->with('group')->with('event')
                ->find($id);
            return response()->json([
                'success' => true,
                'message' => 'Users retrieved by id',
                'data' => $user
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting user' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving user',
            ]);
        }
    }

    public function getUserUnconfirmed($confirmed)
    {
        try {
            $user = User::where('confirmed', $confirmed)->with('group')
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'Users retrieved',
                'data' => $user
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting user' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving user',
            ]);
        }
    }

    public function updateConfirmation(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'confirmed' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $validConfirmation = $validator->validated();

            $user = User::find($id);
            $user->update($validConfirmation);

            return response()->json([
                'success' => true,
                'message' => 'User updated',
                'data' => $user
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error updating user' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error updating user',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserByName($name)
    {
        try {
            $user = User::where('name', 'like', '%' . $name . '%')->get();

            return response()->json([
                'success' => true,
                'message' => 'Users retrieved by name',
                'data' => $user
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting user' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving user',
            ]);
        }
    }
}
