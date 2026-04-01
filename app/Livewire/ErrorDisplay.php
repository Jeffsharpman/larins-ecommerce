<?php

namespace App\Livewire;

use Livewire\Component;

class ErrorDisplay extends Component
{
    public ?string $title = null;

    public ?string $message = null;

    public ?string $icon = 'alert-circle';

    public function mount(?string $title = null, ?string $message = null, ?string $icon = 'alert-circle')
    {
        $this->title = $title ?? 'Something went wrong';
        $this->message = $message ?? 'An error occurred while loading this content. Please try again.';
        $this->icon = $icon;
    }

    public function render()
    {
        return view('livewire.error-display');
    }
}
