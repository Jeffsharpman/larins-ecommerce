<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Review')]
class ReviewsPage extends Component
{
    public function render()
    {
        return view('livewire.reviews-page')->layout('components.layouts.app');
    }
}
