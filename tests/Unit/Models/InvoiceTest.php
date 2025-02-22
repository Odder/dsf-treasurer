<?php

namespace Tests\Unit\Models;

use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_stamps_an_invoice()
    {
        $invoice = Invoice::factory()->create();

        $this->assertNull($invoice->due_at);
        $this->assertNull($invoice->sent_at);
        $this->assertNull($invoice->invoice_number);

        $invoice->stamp();
        $invoice = $invoice->fresh();

        $this->assertNotNull($invoice->due_at);
        $this->assertNotNull($invoice->sent_at);
        $this->assertNotNull($invoice->invoice_number);
    }

    /** @test */
    public function it_sets_due_at_30_days_in_future()
    {
        $invoice = Invoice::factory()->create();
        $expectedDueAt = now()->addDays(30);

        $this->assertNull($invoice->due_at);

        $invoice->stamp();
        $invoice = $invoice->fresh();

        $this->assertEqualsWithDelta(
            $expectedDueAt->timestamp,
            $invoice->due_at->timestamp,
            86400 // 1 day
        );
    }
}
