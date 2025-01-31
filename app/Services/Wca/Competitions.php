<?php

namespace App\Services\Wca;

use App\Models\Competition;
use Illuminate\Support\Facades\Http;

class Competitions
{
    public function list($country = 'DK', $since = '2024-08-08')
    {
        return Http::wca()->get('competitions', ['country_iso2' => $country, 'start' => $since])->json();
    }

    public function getWcif($id)
    {
        return Http::wca()->get("competitions/{$id}/wcif/public")->json();
    }
}
