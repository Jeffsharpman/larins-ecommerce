<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Contact')]
class ContactPage extends Component
{
    public function render()
    {
        return view('livewire.contact-page')->layout('components.layouts.app');
    }
}
