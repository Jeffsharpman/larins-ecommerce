<?php

namespace App\Livewire;

use Livewire\Component;

class SkeletonLoader extends Component
{
    public string $type = 'card';

    public int $count = 1;

    public function render()
    {
        return view('components.skeleton-loader');
    }
}
