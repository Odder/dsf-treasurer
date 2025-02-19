<?php

namespace App\Livewire;

use App\Models\ContactInfo;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContactInfoEditDialog extends Component
{
    use AuthorizesRequests;

    public ContactInfo $contactInfo;

    public string $name;
    public string $email;
    public string $address;
    public string $wca_id;

    public function mount(ContactInfo $contactInfo)
    {
        $this->authorize('update', $contactInfo);

        $this->contactInfo = $contactInfo;
        $this->name = $contactInfo->name;
        $this->email = $contactInfo->email;
        $this->address = $contactInfo->address;
        $this->wca_id = $contactInfo->wca_id;
    }

    public function updateContactInfo()
    {
        $this->authorize('update', $this->contactInfo);

        $this->contactInfo->update([
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'wca_id' => $this->wca_id,
        ]);

        $this->dispatch('close-dialog', id: 'contactInfoEditDialog');
        $this->dispatch('refresh-contact-info'); // Dispatch event to refresh the details page
    }

    public function render()
    {
        return view('livewire.contact-info-edit-dialog');
    }
}
