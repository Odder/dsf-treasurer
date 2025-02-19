<?php

namespace App\Livewire;

use App\Models\ContactInfo;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContactInfoCreateDialog extends Component
{
    use AuthorizesRequests;

    public string $name = '';
    public string $email = '';
    public string $address = '';
    public string $wca_id = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'address' => 'nullable|string|max:255',
        'wca_id' => 'nullable|string|max:255',
    ];

    public function createContactInfo()
    {
        $this->authorize('create', ContactInfo::class);

        $this->validate();

        ContactInfo::create([
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'wca_id' => $this->wca_id,
        ]);

        $this->reset(['name', 'email', 'address', 'wca_id']);
        $this->dispatch('close-dialog', id: 'contactInfoCreateDialog');
        $this->dispatch('refresh-contact-info-table'); // Refresh the table
    }

    public function render()
    {
        return view('livewire.contact-info-create-dialog');
    }
}
