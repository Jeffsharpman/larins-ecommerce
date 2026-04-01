<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Shipping Policy')]
class ShippingPage extends Component
{
    public function render()
    {
        return view('livewire.shipping-page')->layout('components.layouts.app');
    }
}
