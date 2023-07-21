<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class Register extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'surname' => 'required|string',
                'birth_date' => 'required|date',
                'dni' => 'required|string|regex:/^[0-9]{8}[A-Za-z]$/',
                'group' => 'required',
                'contact_email' => 'required|email',
                'first_phone' => 'required|regex:/^\d{9}$/',
                'second_phone' => 'required|regex:/^\d{9}$/',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $validData = $validator->validated();

            // creacion de nuevos registros en las tablas
            
            $newUser = User::create([
                'name' => $validData['name'],
                'role_id' => 3,
                'email' => $validData['email'],
                'password' => bcrypt($validData['password']),
                'average'=> null,
                'confirmed' => false
            ]);

            $newUser_data = User_data::create([
                'user_id' => $newUser->id, 
                'surname'=> $validData['surname'],
                'contact_email'=> $validData['contact_email'],
                'first_phone'=> $validData['first_phone'],
                'second_phone'=> $validData['second_phone'],
                'birth_date'=> $validData['birth_date'],
                'dni'=> $validData['dni'],
            ]);

            $newUser->group()->attach($validData['group']);

            $token = $newUser->createToken('apiToken')->plainTextToken;

            return response()->json([
                'message' => 'User registered',
                'success' => true,
                'user' => $newUser,
                'data' => $newUser_data,
                'token' => $token,
            ], Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            Log::error('Error registering user ' . $th->getMessage());

            return response()->json([
                'message' => 'Error registering user'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
