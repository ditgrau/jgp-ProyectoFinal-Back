<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use App\Models\Result;
use App\Models\User_data;
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
            $user = User::with('user_data')->with('role')->with('group')->with('event')->with('result')
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

    public function updateUserRole(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'role_id' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $validData = $validator->validated();

            $user = User::find($id);
            $user->update($validData);

            return response()->json([
                'message' => 'User profile updated',
                'success' => true,
                'user' => $user,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error updating user profile: ' . $th->getMessage());
            return response()->json([
                'message' => 'Error updating user profile'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateUserGroup(Request $request, $id)
{
    try {
        $validator = Validator::make($request->all(), [
            'group' => 'nullable|array',
            'group.*' => 'integer|exists:group,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $validData = $validator->validated();

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->group()->sync($validData['group']);

        return response()->json([
            'message' => 'User groups updated',
            'success' => true,
            'user' => $user,
        ], Response::HTTP_OK);

    } catch (\Throwable $th) {
        Log::error('Error updating user groups: ' . $th->getMessage());
        return response()->json([
            'message' => 'Error updating user groups'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}


    public function deleteUserById($id)
    {
        try {
            $user = User::with('user_data')->with('group')->with('event')->with('result')->find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'Usuario no encontrado'
                ], Response::HTTP_NOT_FOUND);
            }
            if ($user->result) {
                foreach ($user->result as $result) {
                    $result->delete();
                }
            }
            if ($user->event) {
                foreach ($user->event as $event) {
                    $user->event()->detach($event->id);
                }
            }
            if ($user->group) {
                foreach ($user->group as $group) {
                    $user->group()->detach($group->id);
                }
            }
            if ($user->user_data) {
                $user->user_data->delete();
            }
            $user->delete();

            return response()->json([
                'message' => 'Usuario eliminado'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error al eliminar usuario: ' . $th->getMessage());

            return response()->json([
                'message' => 'Error al eliminar usuario'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
