<?php

namespace App\Services\Wca;

use App\Models\RegionalAssociation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class WcifService
{
    public function fromId(string $id, bool $public = true): ?Wcif
    {
        try {
            if ($public)  {
                $response = Http::wca()->get("competitions/{$id}/wcif/public");
            } else {
                $response = Http::wca()
                    ->withHeaders([
                        'Authorization' => 'bearer '.config('app.wca_api_key')
                    ])->get("competitions/{$id}/wcif");
            }

            if ($response->successful()) {
                return new Wcif($response->json());
            } else {
                Log::error('WCA API Error: ' . $response->status() . ' - ' . $response->body(), [
                    'url' => "competitions/{$id}/wcif/public",
                ]);
                return null;
            }
        } catch (Exception $e) {
            Log::error('WCA API Exception: ' . $e->getMessage(), [
                'url' => "competitions/{$id}/wcif/public",
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }
}
