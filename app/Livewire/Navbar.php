<?php

namespace App\Livewire;

use Livewire\Component;

class Navbar extends Component
{
    protected $listeners = [
        'refresh' => '$refresh',
        'resetNavbar' => 'resetNavbar',
    ];

    public function resetNavbar() {
        $this->dispatch('refresh');
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
