<?php

namespace Tests\Unit\Jobs;

use App\Jobs\GenerateInvoice;
use App\Jobs\StampInvoices;
use App\Models\Competition;
use App\Models\Invoice;
use App\Models\RegionalAssociation;
use App\Services\Wca\Wcif;
use App\Services\Wca\Facades\Wcif as WcifFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Spatie\DiscordAlerts\Facades\DiscordAlert;
use Tests\TestCase;

class StampInvoicesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_picks_up_and_stamp_old_invoices(): void
    {
        /* Setup */
        $date = now()->subDays(30);
        $competition = Competition::factory()->create(['end_date' => $date]);
        $invoice = Invoice::factory()->create(['competition_id' => $competition->id, 'invoice_number' => null]);
        DiscordAlert::shouldReceive('message')
            ->andReturn(true);

        // Act
        $job = new StampInvoices();
        $job->handle();
        $invoice = $invoice->fresh();

        // Assert
        $this->assertNotNull($invoice->invoice_number);
        $this->assertNotNull($invoice->sent_at);
        $this->assertNotNull($invoice->due_at);
        $this->assertEquals('unpaid', $invoice->status);
    }
}
