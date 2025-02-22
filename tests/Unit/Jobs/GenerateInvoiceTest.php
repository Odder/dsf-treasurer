<?php

namespace Tests\Unit\Jobs;

use App\Jobs\GenerateInvoice;
use App\Models\Competition;
use App\Models\RegionalAssociation;
use App\Services\Wca\Wcif;
use App\Services\Wca\Facades\Wcif as WcifFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\DiscordAlerts\Facades\DiscordAlert;
use Tests\TestCase;

class GenerateInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_correctly_calculates_non_paying_participants_based_on_wca_id_and_role(): void
    {
        /* Setup */
        RegionalAssociation::factory()->create(['wcif_identifier' => 'Test Association']);
        $competition = Competition::factory()->create(['name' => 'Test Competition']);
        $wcifData = [
            'persons' => [
                [
                    'name' => 'Organizer with WCA ID (exempt)',
                    'wcaId' => '2008ANDE02',
                    'roles' => ['organizer'],
                    'countryIso2' => 'DK',
                    'registration' => 'Registered',
                ],
                [
                    'name' => 'Delegate with WCA ID (exempt)',
                    'wcaId' => '2012GOOD02',
                    'roles' => ['delegate'],
                    'countryIso2' => 'DK',
                    'registration' => 'Registered',
                ],
                [
                    'name' => 'Organizer without WCA ID (exempt)',
                    'wcaId' => null,
                    'roles' => ['organizer'],
                    'countryIso2' => 'DK',
                    'registration' => 'Registered',
                ],
                [
                    'name' => 'Delegate without WCA ID (exempt)',
                    'wcaId' => '',
                    'roles' => ['delegate'],
                    'countryIso2' => 'DK',
                    'registration' => 'Registered',
                ],
                [
                    'name' => 'Competitor with WCA ID (should pay)',
                    'wcaId' => '2017ASMU01',
                    'roles' => [],
                    'countryIso2' => 'DK',
                    'registration' => 'Registered',
                ],
                [
                    'name' => 'Competitor without WCA ID (should pay)',
                    'wcaId' => null,
                    'roles' => [],
                    'countryIso2' => 'DK',
                    'registration' => 'Registered',
                ],
            ],
            'extensions' => [
                [
                    'id' => 'dsfAssociationInfo',
                    'specUrl' => 'https://tools.danskspeedcubingforening.dk/foreninger',
                    'data' => [
                        'billingAssociation' => 'Test Association',
                        'organisingAssociation' => 'Test Association',
                    ],
                ],
            ],
        ];

        WcifFacade::shouldReceive('fromId')
            ->andReturn(new Wcif($wcifData));
        DiscordAlert::shouldReceive('message')
            ->twice()
            ->andReturn(true);

        /* Logic */
        $job = new GenerateInvoice($competition);
        $job->handle();

        /* Assertions */
        $this->assertDatabaseHas('invoices', [
            'competition_id' => $competition->id,
            'participants' => 6,
            'non_paying_participants' => 4,
            'amount' => 25 * (6 - 4),
        ]);

        $invoice = $competition->invoices()->first();
        $this->assertDatabaseCount('invoice_lines', 2);
        $this->assertDatabaseHas('invoice_lines', [
            'invoice_id' => $invoice->id,
            'description' => 'Deltagere fritaget for kontigent',
            'quantity' => 4,
            'unit_price' => -25,
            'total_price' => -100,
        ]);
    }
}
