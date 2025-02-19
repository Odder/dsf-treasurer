<?php

namespace App\Livewire;

use App\Models\ContactInfo;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContactInfoDetails extends Component
{
    use AuthorizesRequests;

    public ContactInfo $contactInfo;

    public function mount(ContactInfo $contactInfo)
    {
        $this->authorize('view', $contactInfo);
        $this->contactInfo = $contactInfo;
    }

    public function render()
    {
        return view('livewire.contact-info-details', [
            'associations' => $this->contactInfo->associations()->get(),
        ]);
    }

    public function openEditDialog()
    {
        $this->dispatch('open-dialog', id: 'contactInfoEditDialog');
    }

    #[On('refresh-contact-info')]
    public function refreshContactInfo()
    {
        $this->contactInfo->refresh();
    }
}
