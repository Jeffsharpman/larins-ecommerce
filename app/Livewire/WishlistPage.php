<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Wishlist')]
class WishlistPage extends Component
{
    public function render()
    {
        return view('livewire.wishlist-page')->layout('components.layouts.app');
    }
}
