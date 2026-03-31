<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Account')]
class AccountPage extends Component
{
    public function render()
    {
        return view('livewire.account-page')->layout('components.layouts.app');
    }
}
