<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Terms')]
class TermsPage extends Component
{
    public function render()
    {
        return view('livewire.terms-page')->layout('components.layouts.app');
    }
}
