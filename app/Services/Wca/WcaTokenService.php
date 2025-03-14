<?php

namespace App\Services\Wca;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WcaTokenService
{
    private const CACHE_KEY = 'wca_service_token';
    private const REFRESH_LOCK_KEY = 'wca_token_refresh_lock';

    public function getAccessToken(): ?string
    {
        $cachedToken = Cache::get(self::CACHE_KEY);

        if ($cachedToken) {
            return $cachedToken;
        }

        // Token is missing or expired, refresh it
        return $this->authenticate();
    }

    private function authenticate(): ?string
    {
        try {
            $username = config('services.wca.service_user_username');
            $password = config('services.wca.service_user_password');

            if (!$username || !$password) {
                Log::error('WCA service user credentials not configured.');
                return null;
            }

            $response = Http::asForm()->post('https://www.worldcubeassociation.org/oauth/token', [
                'grant_type' => 'password',
                'username' => $username,
                'password' => $password,
                'scope' => 'public manage_competitions',
                'client_id' => config('services.wca.client_id'),
                'client_secret' => config('services.wca.client_secret'),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $accessToken = $data['access_token'];
                $expiresIn = $data['expires_in'];

                Cache::put(self::CACHE_KEY, $accessToken, $expiresIn);

                return $accessToken;
            } else {
                Log::error('WCA Authentication Failed: ' . $response->status() . ' - ' . $response->body());
                return null;
            }
        } catch (\Exception $e) {
            Log::error('WCA Authentication Exception: ' . $e->getMessage());
            return null;
        }
    }
}
