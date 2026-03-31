<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Error')]
class ErrorPage extends Component
{
    public function render()
    {
        return view('livewire.error-page')->layout('components.layouts.app');
    }
}
