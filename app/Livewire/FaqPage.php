<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Faq')]
class FaqPage extends Component
{
    public function render()
    {
        return view('livewire.faq-page')->layout('components.layouts.app');
    }
}
