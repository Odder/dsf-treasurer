<?php

namespace App\Services\Wca;

use App\Models\RegionalAssociation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class Wcif
{
    public $raw;

    public function __construct($raw)
    {
        $this->raw = $raw;
    }

    public static function fromId($id)
    {
        try {
            $response = Http::wca()->get("competitions/{$id}/wcif/public");

            if ($response->successful()) {
                return new static($response->json());
            } else {
                Log::error('WCA API Error: ' . $response->status() . ' - ' . $response->body(), [
                    'url' => "competitions/{$id}/wcif/public",
                ]);
                return null; // Or throw an exception
            }
        } catch (Exception $e) {
            Log::error('WCA API Exception: ' . $e->getMessage(), [
                'url' => "competitions/{$id}/wcif/public",
                'trace' => $e->getTraceAsString(),
            ]);
            return null; // Or throw an exception
        }
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

    public function getRegionalAssociation()
    {
        if (!$this->raw) {
            return null;
        }
        $extensions = collect($this->raw['extensions']);
        try {
            $associationExtension = $extensions->firstWhere('id', 'dsfAssociationInfo');
            return $associationExtension['data']['billingAssociation'];
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function getBillingAssociation()
    {
        if (!$this->raw) {
            return null;
        }
        $extensions = collect($this->raw['extensions']);
        try {
            $associationExtension = $extensions->firstWhere('id', 'dsfAssociationInfo');
            return $associationExtension['data']['billingAssociation'];
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function getOrganisingAssociation()
    {
        if (!$this->raw) {
            return null;
        }
        $extensions = collect($this->raw['extensions']);
        try {
            $associationExtension = $extensions->firstWhere('id', 'dsfAssociationInfo');
            return $associationExtension['data']['organisingAssociation'];
        }
        catch (\Exception $e) {
            return null;
        }
    }

    public function addRegionalAssociation(RegionalAssociation $billingAssociation, ?RegionalAssociation $organisingAssociation = null)
    {
        $extension = [
            'id' => 'dsfAssociationInfo',
            'specUrl' => 'https://tools.danskspeedcubingforening.dk/foreninger',
            'data' => [
                'billingAssociation' => $billingAssociation->wcif_identifier,
                'organisingAssociation' => $organisingAssociation ? $organisingAssociation->wcif_identifier : $billingAssociation->wcif_identifier,
            ],
        ];

        // $extensions
        $extensions = collect($this->raw['extensions']);
        $index = $extensions->search(
            fn ($extension) => $extension['id'] === 'dsfAssociationInfo'
        );

        if ($index === false) {
            $extensions->push($extension);
        }
        else {
            $extensions->put($index, $extension);
        }

        try {
            $response = Http::wca()
                ->withHeaders([
                    'Authorization' => 'bearer '.config('app.wca_api_key'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->patch("competitions/{$this->raw['id']}/wcif", ['extensions' => $extensions]);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('WCA API Error: ' . $response->status() . ' - ' . $response->body(), [
                    'url' => "competitions/{$this->raw['id']}/wcif",
                    'method' => 'PATCH',
                    'headers' => [
                        'Authorization' => 'bearer '.config('app.wca_api_key'),
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                    'body' => ['extensions' => $extensions],
                ]);
                return null;
            }
        } catch (Exception $e) {
            Log::error('WCA API Exception: ' . $e->getMessage(), [
                'url' => "competitions/{$this->raw['id']}/wcif",
                'method' => 'PATCH',
                'headers' => [
                    'Authorization' => 'bearer '.config('app.wca_api_key'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'body' => ['extensions' => $extensions],
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }
}
