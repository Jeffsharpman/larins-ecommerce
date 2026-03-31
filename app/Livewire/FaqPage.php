<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Faq')]
class FaqPage extends Component
{
    public function render()
    {
        return view('livewire.faq-page')->layout('components.layouts.app');
    }
}
