<?php

namespace App\Services\Wca;

use Illuminate\Support\Facades\Http;

class Wcif
{
    public $raw;

    public function __construct($raw)
    {
        $this->raw = $raw;
    }

    public static function fromId($id)
    {
        return new static(Http::wca()->get("competitions/{$id}/wcif/public")->json());
    }

    public function getCompetitors()
    {
        return collect($this->raw['persons'])->map(function ($person) {
            return collect([
                'name' => $person['name'],
                'wcaId' => $person['wcaId'],
                'roles' => $person['roles'],
                'country' => $person['countryIso2'],
                'registration' => $person['registration'],
            ]);
        });
    }
}
