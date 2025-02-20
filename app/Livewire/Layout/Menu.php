<?php

namespace App\Livewire\Layout;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Menu extends Component
{
    public $contact;
    public $user;

    public function mount()
    {
        if (Auth::check()) {
            $this->user = Auth::user();
            $this->contact = $this->user->contact;
        }
    }

    public function render()
    {
        return view('livewire.layout.menu');
    }
}
