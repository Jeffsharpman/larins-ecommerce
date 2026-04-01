<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Account')]
class AccountPage extends Component
{
    public $activeTab = 'profile';

    public $user;

    public $first_name;

    public $last_name;

    public $phone;

    public $birthday;

    public $addresses = [];

    public $orders = [];

    public $wishlistItems = [];

    public $totalOrders = 0;

    public $totalWishlist = 0;

    public $isLoading = true;

    public $error = null;

    public function mount()
    {
        $this->loadUserData();
    }

    public function loadUserData()
    {
        $this->isLoading = true;
        $this->error = null;

        try {
            $this->user = Auth::user();

            if (! $this->user) {
                $this->error = 'Please log in to view your account';
                $this->isLoading = false;

                return;
            }

            $nameParts = explode(' ', $this->user->name, 2);
            $this->first_name = $nameParts[0] ?? '';
            $this->last_name = $nameParts[1] ?? '';
            $this->phone = '';
            $this->birthday = '';

            $this->addresses = Address::whereHas('order', function ($query) {
                $query->where('user_id', $this->user->id);
            })->orderBy('created_at', 'desc')->get()->unique(fn ($a) => $a->street_address.$a->city.$a->state)->values()->toArray();

            $this->orders = Order::where('user_id', $this->user->id)
                ->with(['items.product', 'items.product.category', 'items.product.brand'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            $this->totalOrders = Order::where('user_id', $this->user->id)->count();

            $wishlist = json_decode(request()->cookie('wishlist') ?? '[]', true);
            $this->wishlistItems = $wishlist;
            $this->totalWishlist = count($wishlist);
        } catch (\Exception $e) {
            $this->error = 'Unable to load account data. Please try again.';
            Log::error('Account page error: '.$e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function updateProfile()
    {
        $this->validate([
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255',
            'phone' => 'nullable|min:10|max:20',
        ]);

        $this->user->update([
            'name' => trim($this->first_name.' '.$this->last_name),
        ]);

        session()->flash('success', 'Profile updated successfully');

        $this->dispatch('swal:alert',
            icon: 'success',
            title: 'Profile Updated',
            html: '<p class="text-[9px] font-medium uppercase tracking-widest">Your credentials have been saved</p>',
            position: 'bottom-end',
            timer: 3000,
            toast: true,
        );
    }

    public function render()
    {
        return view('livewire.account-page', [
            'user' => $this->user,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'birthday' => $this->birthday,
            'addresses' => $this->addresses,
            'orders' => $this->orders,
            'wishlistItems' => $this->wishlistItems,
            'totalOrders' => $this->totalOrders,
            'totalWishlist' => $this->totalWishlist,
            'isLoading' => $this->isLoading,
            'error' => $this->error,
        ])->layout('components.layouts.app');
    }
}
