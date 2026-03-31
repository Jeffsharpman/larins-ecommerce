<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Wishlist')]
class WishlistPage extends Component
{
    public function render()
    {
        return view('livewire.wishlist-page')->layout('components.layouts.app');
    }
}
