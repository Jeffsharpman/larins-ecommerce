<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Error')]
class ErrorPage extends Component
{
    public function render()
    {
        return view('livewire.error-page')->layout('components.layouts.app');
    }
}
