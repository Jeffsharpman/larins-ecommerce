<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Review')]
class ReviewsPage extends Component
{
    public function render()
    {
        return view('livewire.reviews-page')->layout('components.layouts.app');
    }
}
