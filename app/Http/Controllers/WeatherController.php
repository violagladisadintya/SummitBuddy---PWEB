<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    public function index()
    {
        return view('weather.index');
    }

    public function getWeather(Request $request): JsonResponse
    {
        try {
            $location = $request->get('location', 'Semeru');

            $response = Http::get("https://wttr.in/{$location}?format=j1");

            if ($response->successful()) {
                $data = $response->json();

                $currentCondition = $data['current_condition'][0];
                $nearestArea = $data['nearest_area'][0] ?? null;

                return response()->json([
                    'success' => true,
                    'data' => [
                        'location' => $location,
                        'city' => $nearestArea['areaName'][0]['value'] ?? $location,
                        'temperature' => $currentCondition['temp_C'] ?? 'N/A',
                        'description' => $currentCondition['weatherDesc'][0]['value'] ?? 'Tidak tersedia',
                        'humidity' => $currentCondition['humidity'] ?? 'N/A',
                        'wind_speed' => $currentCondition['windspeedKmph'] ?? 'N/A',
                        'icon_url' => 'https:' . ($currentCondition['weatherIconUrl'][0]['value'] ?? ''),
                        'feels_like' => $currentCondition['FeelsLikeC'] ?? $currentCondition['temp_C'],
                        'visibility' => $currentCondition['visibility'] ?? 'N/A',
                        'pressure' => $currentCondition['pressure'] ?? 'N/A',
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data cuaca'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
