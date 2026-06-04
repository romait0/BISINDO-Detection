<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DetectionController extends Controller
{
    public function index()
    {
        return view('detection');
    }

    public function detect(Request $request)
    {
        // Validasi file yang diunggah dari stream canvas javascript
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'No image file stream received'], 400);
        }

        $imageFile = $request->file('image');
        $apiKey = env('ROBOFLOW_API_KEY', 'DzRnqXzja80fBxFOSRju'); 

        try {
            // Konversi file gambar ke format biner untuk payload multipart data
            $imageBinary = file_get_contents($imageFile->getRealPath());

            // 🚀 Menggunakan Endpoint Deteksi Standar Roboflow Object Detection (Sesuai tipe model YOLOv11 Nano kamu)
            // Endpoint ini jauh lebih stabil dan hemat bandwidth dibanding Serverless Workflows JSON
            $response = Http::timeout(15)
                ->withHeaders([
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ])
                ->withBody(base64_encode($imageBinary), 'text/plain')
                ->post("https://detect.roboflow.com/ruangisyarat-vsupz/4?api_key={$apiKey}");

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Roboflow Engine Refused',
                    'message' => $response->body()
                ], $response->status());
            }

            $roboflowData = $response->json();
            
            // Ambil array predictions
            $predictions = $roboflowData['predictions'] ?? [];

            return response()->json([
                'predictions' => $predictions
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Internal Laravel Exception',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}