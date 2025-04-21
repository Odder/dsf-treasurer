<?php

namespace App\Observers;

use App\Models\Receipt;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class ReceiptObserver
{
    /**
     * Handle the Receipt "created" event.
     */
    public function created(Receipt $receipt): void
    {
        DiscordAlert::message("🧾 New receipt uploaded by **{$receipt->user->name}**! Amount: {$receipt->amount}. Description: {$receipt->description}. See details: " . route('receipts.manage'));
    }

    /**
     * Handle the Receipt "updated" event.
     */
    public function updated(Receipt $receipt): void
    {
        //
    }

    /**
     * Handle the Receipt "deleted" event.
     */
    public function deleted(Receipt $receipt): void
    {
        //
    }

    /**
     * Handle the Receipt "restored" event.
     */
    public function restored(Receipt $receipt): void
    {
        //
    }

    /**
     * Handle the Receipt "force deleted" event.
     */
    public function forceDeleted(Receipt $receipt): void
    {
        //
    }
}
