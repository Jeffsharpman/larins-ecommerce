<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Account')]
class AccountPage extends Component
{
    public function render()
    {
        return view('livewire.account-page')->layout('components.layouts.app');
    }
}
