<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Account')]
class AccountPage extends Component
{
    use WithPagination;

    public $activeTab = 'profile';

    public $user;

    public $first_name;

    public $last_name;

    public $phone;

    public $birthday;

    public $addresses = [];

    /** @var Collection<int, Product> */
    public $wishlistProducts;

    public $totalOrders = 0;

    public $totalWishlist = 0;

    public $isLoading = true;

    public $error = null;

    public $showAddressModal = false;

    public $editingAddress = null;

    public $showDeleteModal = false;

    public $addressToDelete = null;

    public $addressTitle = '';

    public $addressStreet = '';

    public $addressCity = '';

    public $addressState = '';

    public $addressZip = '';

    public $addressPhone = '';

    protected function rules(): array
    {
        return [
            'addressTitle' => 'required|in:home,work_place,other',
            'addressStreet' => 'min:5',
            'addressCity' => 'min:2',
            'addressState' => 'min:2',
            'addressZip' => 'nullable|min:5',
            'addressPhone' => 'nullable|min:10',
        ];
    }

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

            $this->user = $this->user->fresh();

            $this->first_name = $this->user->nameParts()['first'];
            $this->last_name = $this->user->nameParts()['last'];
            $this->phone = $this->user->phone ?? '';
            $this->birthday = '';

            $this->addresses = $this->user->addresses()->orderBy('created_at', 'desc')->get()->toArray();

            $this->totalOrders = Order::where('user_id', $this->user->id)->count();

            $this->wishlistProducts = CartManagement::getWishlistProducts();
            $this->totalWishlist = $this->wishlistProducts->count();
        } catch (\Exception $e) {
            $this->error = 'Unable to load account data. Please try again.';
            Log::error('Account page error: '.$e->getMessage().' - Trace: '.$e->getTraceAsString());
        } finally {
            $this->isLoading = false;
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        if ($tab === 'orders') {
            $this->loadOrders();
        }
        if ($tab === 'wishlist') {
            $this->wishlistProducts = CartManagement::getWishlistProducts();
            $this->totalWishlist = $this->wishlistProducts->count();
        }
    }

    private function loadOrders() {}

    public function getOrdersProperty()
    {
        if (! $this->user) {
            return collect();
        }

        return Order::where('user_id', $this->user->id)
            ->with(['items.product', 'items.product.category', 'items.product.brand'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function updateProfile()
    {
        $this->validate([
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'nullable|min:2|max:255',
            'phone' => 'nullable|min:10|max:20',
        ]);

        $fullName = trim($this->first_name.' '.$this->last_name);

        $this->user->update([
            'name' => $fullName ?: $this->user->name,
            'phone' => $this->phone,
        ]);

        $this->dispatch('swal:alert',
            icon: 'success',
            title: 'Profile Updated',
            html: '<p class="text-[9px] font-medium uppercase tracking-widest">Your credentials have been saved</p>',
            position: 'bottom-end',
            timer: 3000,
            toast: true,
        );
    }

    public function openAddressModal(?Address $address = null)
    {
        $this->editingAddress = $address;
        if ($address) {
            $this->addressTitle = $address->title;
            $this->addressStreet = $address->street_address;
            $this->addressCity = $address->city;
            $this->addressState = $address->state;
            $this->addressZip = $address->zip_code ?? '';
            $this->addressPhone = $address->phone ?? '';
        } else {
            $this->resetAddressFields();
        }
        $this->showAddressModal = true;
    }

    public function closeAddressModal()
    {
        $this->showAddressModal = false;
        $this->editingAddress = null;
        $this->resetAddressFields();
    }

    private function resetAddressFields()
    {
        $this->addressTitle = '';
        $this->addressStreet = '';
        $this->addressCity = '';
        $this->addressState = '';
        $this->addressZip = '';
        $this->addressPhone = '';
    }

    public function saveAddress()
    {
        $this->validate();

        try {
            if ($this->editingAddress) {
                $this->editingAddress->update([
                    'title' => $this->addressTitle,
                    'street_address' => $this->addressStreet,
                    'city' => $this->addressCity,
                    'state' => $this->addressState,
                    'zip_code' => $this->addressZip,
                    'phone' => $this->addressPhone,
                ]);
                $message = 'Address updated successfully';
            } else {
                Address::create([
                    'user_id' => $this->user->id,
                    'title' => $this->addressTitle,
                    'street_address' => $this->addressStreet,
                    'city' => $this->addressCity,
                    'state' => $this->addressState,
                    'zip_code' => $this->addressZip,
                    'phone' => $this->addressPhone,
                    'is_active' => $this->user->addresses()->count() === 0,
                ]);
                $message = 'Address added successfully';
            }

            $this->addresses = $this->user->addresses()->orderBy('created_at', 'desc')->get()->toArray();
            $this->closeAddressModal();

            $this->dispatch('swal:alert',
                icon: 'success',
                title: 'Address Saved',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest">'.$message.'</p>',
                position: 'bottom-end',
                timer: 3000,
                toast: true,
            );
        } catch (\Exception $e) {
            $this->dispatch('swal:alert',
                icon: 'error',
                title: 'Error',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest">Unable to save address</p>',
                position: 'bottom-end',
                timer: 3000,
                toast: true,
            );
        }
    }

    public function confirmDeleteAddress(Address $address)
    {
        $this->addressToDelete = $address;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->addressToDelete = null;
    }

    public function deleteAddress()
    {
        if (! $this->addressToDelete) {
            return;
        }

        try {
            $wasActive = $this->addressToDelete->is_active;
            $this->addressToDelete->delete();
            $this->addresses = $this->user->addresses()->orderBy('created_at', 'desc')->get()->toArray();

            if ($wasActive && $this->user->addresses()->exists()) {
                $this->user->addresses()->first()->setAsActive();
                $this->addresses = $this->user->addresses()->orderBy('created_at', 'desc')->get()->toArray();
            }

            $this->dispatch('swal:alert',
                icon: 'success',
                title: 'Address Deleted',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest">Address has been removed</p>',
                position: 'bottom-end',
                timer: 3000,
                toast: true,
            );
        } catch (\Exception $e) {
            $this->dispatch('swal:alert',
                icon: 'error',
                title: 'Error',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest">Unable to delete address</p>',
                position: 'bottom-end',
                timer: 3000,
                toast: true,
            );
        } finally {
            $this->closeDeleteModal();
        }
    }

    public function removeFromWishlist(Product $product)
    {
        CartManagement::removeFromWishlist($product->id);
        $this->wishlistProducts = CartManagement::getWishlistProducts();
        $this->totalWishlist = $this->wishlistProducts->count();

        $this->dispatch('wishlistUpdated');

        $this->dispatch('swal:alert',
            icon: 'success',
            title: 'Removed',
            html: '<p class="text-[9px] font-medium uppercase tracking-widest">Removed from favorites</p>',
            position: 'bottom-end',
            timer: 3000,
            toast: true,
        );
    }

    public function addToCart($productId)
    {
        $count = CartManagement::addItemToCart($productId);
        $this->dispatch('cartUpdated', count: $count);
        $this->dispatch('update-cart-count', total_count: $count)->to(Navbar::class);
        $this->dispatchBrowserEvent('cart-count-updated', ['count' => $count]);

        $this->dispatch('swal:alert',
            icon: 'success',
            title: 'Added to Cart',
            html: '<p class="text-[9px] font-medium uppercase tracking-widest">Item added to your archive</p>',
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
            'wishlistProducts' => $this->wishlistProducts,
            'totalOrders' => $this->totalOrders,
            'totalWishlist' => $this->totalWishlist,
            'isLoading' => $this->isLoading,
            'error' => $this->error,
            'showAddressModal' => $this->showAddressModal,
            'editingAddress' => $this->editingAddress,
            'showDeleteModal' => $this->showDeleteModal,
            'orders' => $this->orders,
        ])->layout('components.layouts.app');
    }
}
