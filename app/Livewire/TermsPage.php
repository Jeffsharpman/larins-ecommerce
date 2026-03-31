<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Terms')]
class TermsPage extends Component
{
    public function render()
    {
        return view('livewire.terms-page')->layout('components.layouts.app');
    }
}
