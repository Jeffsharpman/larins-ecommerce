<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cancel')]
class CancelPage extends Component
{
    public $order_id;

    public function mount($order_id = null)
    {
        $this->order_id = $order_id;
    }

    public function render()
    {
        return view('livewire.cancel-page')->layout('components.layouts.app');
    }
}
