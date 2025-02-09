<?php

namespace App\Services\Wca;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Import the Log facade
use Exception;

class Competitions
{
    public function list($country = 'DK', $since = '2024-01-01', $before = '2025-01-01', $page = 1)
    {
        try {
            $response = Http::wca()->get('competitions', [
                'country_iso2' => $country,
                'start' => $since,
                'end' => $before,
                'per_page' => 100,
                'page' => $page
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                // Log the error and return null or a specific error object
                Log::error('WCA API Error: ' . $response->status() . ' - ' . $response->body(), [
                    'url' => 'competitions',
                    'params' => [
                        'country_iso2' => $country,
                        'start' => $since,
                        'end' => $before,
                        'per_page' => 100,
                        'page' => $page
                    ],
                ]);
                return null; // Or return a specific error object
            }
        } catch (Exception $e) {
            // Log the exception
            Log::error('WCA API Exception: ' . $e->getMessage(), [
                'url' => 'competitions',
                'params' => [
                    'country_iso2' => $country,
                    'since' => $since,
                    'before' => $before,
                    'page' => $page
                ],
                'trace' => $e->getTraceAsString(),
            ]);

            return null; // Or return a specific error object
        }
    }

    public function getWcif($id)
    {
        try {
            $response = Http::wca()->get("competitions/{$id}/wcif/public");

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('WCA API Error: ' . $response->status() . ' - ' . $response->body(), [
                    'url' => "competitions/{$id}/wcif/public",
                ]);
                return null; // Or return a specific error object
            }
        } catch (Exception $e) {
            Log::error('WCA API Exception: ' . $e->getMessage(), [
                'url' => "competitions/{$id}/wcif/public",
                'trace' => $e->getTraceAsString(),
            ]);
            return null; // Or return a specific error object
        }
    }
}
