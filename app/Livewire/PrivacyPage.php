<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Privacy Policy')]
class PrivacyPage extends Component
{
    public function render()
    {
        return view('livewire.privacy-page')->layout('components.layouts.app');
    }
}
