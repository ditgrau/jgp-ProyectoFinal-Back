<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
}


