<?php

namespace App\Livewire\Partials;

use App\Helpers\CartManagement;
use App\Models\Announcement;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public User $users;

    public $total_count = 0;

    public $announcements = [];

    public $dismissedAnnouncements = [];

    public function mount()
    {
        $this->total_count = count(CartManagement::getCartItemsFromCookie());
        $this->dismissedAnnouncements = json_decode(request()->cookie('dismissed_announcements') ?? '[]', true);
        $this->loadAnnouncements();
    }

    public function loadAnnouncements()
    {
        $this->announcements = Announcement::active()
            ->current()
            ->whereNotIn('id', $this->dismissedAnnouncements)
            ->get()
            ->filter(function ($announcement) {
                return $announcement->isCurrentlyActive();
            })
            ->values()
            ->toArray();
    }

    #[On('update-cart-count')]
    public function updateCartCount($total_count)
    {
        $this->total_count = $total_count;
    }

    public function dismissAnnouncement($id)
    {
        $this->dismissedAnnouncements[] = $id;
        $dismissed = json_encode($this->dismissedAnnouncements);

        \Cookie::queue('dismissed_announcements', $dismissed, 60 * 24 * 30);

        $this->announcements = collect($this->announcements)->reject(fn ($a) => $a['id'] === $id)->values()->toArray();
    }

    public function getTypeStyles($type): array
    {
        return match ($type) {
            'success' => [
                'bg-green-600/10 border-green-600/30 text-green-600',
                'text-green-600',
            ],
            'warning' => [
                'bg-amber-600/10 border-amber-600/30 text-amber-600',
                'text-amber-600',
            ],
            'error' => [
                'bg-red-600/10 border-red-600/30 text-red-600',
                'text-red-600',
            ],
            'info' => [
                'bg-blue-600/10 border-blue-600/30 text-blue-600',
                'text-blue-600',
            ],
            default => [
                'bg-primary/10 border-primary/30 text-primary',
                'text-primary',
            ],
        };
    }

    public function render()
    {
        return view('livewire.partials.navbar')
            ->layout('components.layouts.app', [
                'announcements' => $this->announcements,
                'dismissedAnnouncements' => $this->dismissedAnnouncements,
            ]);
    }
}
