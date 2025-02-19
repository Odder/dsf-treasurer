<?php

namespace App\Livewire;

use App\Models\ContactInfo;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ContactInfoTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public int $perPage = 10;

    public function render()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (!Auth::user()->isDSFBoardMember()) {
            abort(403, 'Unauthorized.');
        }

        return view('livewire.contact-info-table', [
            'contacts' => ContactInfo::orderBy('name')->paginate($this->perPage),
        ]);
    }

    public function openCreateDialog()
    {
        $this->dispatch('open-dialog', id: 'contactInfoCreateDialog');
    }

    #[On('refresh-contact-info-table')]
    public function refreshContactInfoTable()
    {
        $this->resetPage();
    }
}
