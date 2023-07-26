<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ResultController extends Controller
{

    // ALL LOS RESULTADOS PARA ADMIN

    public function getAllResults() 
    {
        try {
            $results = Result::all();
            
            return response()->json([
                'message' => 'Results retrieved',
                'data' => $results,
                'success' => true
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error retrieving results ' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving results'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // ALL MIS RESULTADOS 

    public function getMyResults() 
    {
        try {
            $user = auth()->user();
            $userId = $user->id;

            $results = Result::where('user_id', $userId)->get();
            
            $idResults = Result::where('user_id', $userId)->pluck('id');
 
            return response()->json([
                'message' => 'Results retrieved',
                'data' => $results,
                'idResults' => $idResults,
                'success' => true
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error retrieving results ' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving results'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    
    public function myLastResults() 
    {
        try {
            $user = auth()->user();
            $userId = $user->id;

            $results = Result::where('user_id', $userId)
            ->orderBy('total', 'desc')
            ->take(3)
            ->get();
            
            return response()->json([
                'message' => 'Results retrieved',
                'data' => $results,
                'success' => true
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            Log::error('Error retrieving results ' . $th->getMessage());

            return response()->json([
                'message' => 'Error retrieving results'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    
    public function getResultById($id)
    {
        try {
            $result = Result::with('user')->find($id);
            return response()->json([
                'success' => true,
                'message' => 'Result retrieved by id',
                'data' => $result
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting result' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving result',
            ]);
        }
    }

    
    public function addResult(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'difficulty' => 'nullable|numeric',
                'artistic' => 'nullable|numeric',
                'execution' => 'nullable|numeric',
                'total' => 'required|numeric',
                'ranking' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $validData = $validator->validated();

            $user = auth()->user();
            $userId = $user->id;

            $newResult = Result::create([
                'user_id' => $userId,
                'name' => $validData['name'],
                'difficulty' => $validData['difficulty'],
                'artistic' => $validData['artistic'],
                'execution' => $validData['execution'],
                'total' => $validData['total'],
                'ranking' => $validData['ranking']
            ]);

            return response()->json([
                'message' => 'Result created',
                'success' => true,
                'result' => $newResult,
            ], Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            Log::error('Error creating new result ' . $th->getMessage());

            return response()->json([
                'message' => 'Error adding result'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}


