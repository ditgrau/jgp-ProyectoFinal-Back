<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class Login extends Controller
{
    public function __invoke(Request $request){
        try {
            $validator = Validator::make($request->all(),[
                'email' => 'required|email',
                'password' => 'required'
            ], [
                'email' => 'Email or password are invalid',
                'password' => 'Email or password are invalid'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $validData = $validator->validated();

            $user = User::where('email', $validData['email'])->first();

            if (!$user) {
                return response()->json([
                    'message' => 'Email or password are invalid'
                ], Response::HTTP_FORBIDDEN);
            }

            if (!Hash::check($validData['password'], $user->password)) {
                return response()->json([
                    'message' => 'Email or password are invalid'
                ], Response::HTTP_FORBIDDEN);
            }

            if($user->confirmed){
                $token = $user->createToken('apiToken')->plainTextToken;
            } else {
                return response()->json([
                    'message' => 'User not confirmed'
                ], Response::HTTP_UNAUTHORIZED);
            }

            return response()->json([
                'data' => $user,
                'token' => $token
            ], Response::HTTP_CREATED);


        } catch (\Throwable $th) {
            Log::error('Error logging user in ' . $th->getMessage());

            return response()->json([
                'message' => 'Error logging user in'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}