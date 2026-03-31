// account.js - Account management functionality
let userProfile = JSON.parse(localStorage.getItem('larinsUserProfile')) || {
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    dateOfBirth: ''
};

let userAddresses = JSON.parse(localStorage.getItem('larinsUserAddresses')) || [];

function saveProfile() {
    localStorage.setItem('larinsUserProfile', JSON.stringify(userProfile));
}

function saveAddresses() {
    localStorage.setItem('larinsUserAddresses', JSON.stringify(userAddresses));
}

// Tab switching functionality
function initTabs() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.dataset.tab;

            // Update tab buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'text-primary', 'border-primary');
                btn.classList.add('text-muted-foreground', 'border-transparent');
            });
            button.classList.add('active', 'text-primary', 'border-primary');
            button.classList.remove('text-muted-foreground', 'border-transparent');

            // Update tab content
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById(`${targetTab}-tab`).classList.remove('hidden');
        });
    });
}

// Profile management
function initProfile() {
    const form = document.getElementById('profileForm');

    // Load existing profile data
    document.getElementById('firstName').value = userProfile.firstName || '';
    document.getElementById('lastName').value = userProfile.lastName || '';
    document.getElementById('email').value = userProfile.email || '';
    document.getElementById('phone').value = userProfile.phone || '';
    document.getElementById('dateOfBirth').value = userProfile.dateOfBirth || '';

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        userProfile = {
            firstName: document.getElementById('firstName').value,
            lastName: document.getElementById('lastName').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            dateOfBirth: document.getElementById('dateOfBirth').value
        };

        saveProfile();
        showToast('Profile updated successfully!');
    });
}

// Address management
function initAddresses() {
    renderAddresses();

    // Add address button
    document.getElementById('addAddressBtn').addEventListener('click', () => {
        openAddressModal();
    });

    // Modal controls
    document.getElementById('closeModal').addEventListener('click', closeAddressModal);
    document.getElementById('cancelAddress').addEventListener('click', closeAddressModal);

    // Address form
    document.getElementById('addressForm').addEventListener('submit', (e) => {
        e.preventDefault();
        saveAddress();
    });
}

function renderAddresses() {
    const container = document.getElementById('addressesContainer');
    if (userAddresses.length === 0) {
        container.innerHTML = `
            <div class="col-span-full text-center py-12">
                <i data-lucide="map-pin" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">No addresses yet</h3>
                <p class="text-muted-foreground">Add your first address to make checkout faster</p>
            </div>
        `;
        return;
    }

    container.innerHTML = userAddresses.map((address, index) => `
        <div class="bg-card p-6 rounded-xl shadow-soft border relative">
            ${address.isDefault ? '<div class="absolute top-4 right-4 w-3 h-3 bg-primary rounded-full"></div>' : ''}
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                        <i data-lucide="map-pin" class="w-5 h-5 text-primary"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold capitalize">${address.type}</h3>
                        <p class="text-sm text-muted-foreground">${address.name}</p>
                    </div>
                </div>
                ${address.isDefault ? '<span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full">Default</span>' : ''}
            </div>

            <div class="text-sm text-muted-foreground mb-4">
                <p>${address.streetAddress}</p>
                ${address.apartment ? `<p>${address.apartment}</p>` : ''}
                <p>${address.city}, ${address.state} ${address.zipCode}</p>
                <p>${address.country}</p>
                <p class="mt-2">${address.phone}</p>
            </div>

            <div class="flex gap-2">
                <button onclick="editAddress(${index})" class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-secondary text-secondary-foreground rounded-lg hover:bg-secondary/80 transition-colors text-sm font-medium">
                    <i data-lucide="edit" class="w-4 h-4"></i>
                    Edit
                </button>
                ${!address.isDefault ? `<button onclick="setDefaultAddress(${index})" class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-colors text-sm font-medium">
                    <i data-lucide="star" class="w-4 h-4"></i>
                    Set Default
                </button>` : ''}
                <button onclick="deleteAddress(${index})" class="inline-flex items-center justify-center gap-2 px-3 py-2 bg-destructive text-destructive-foreground rounded-lg hover:bg-destructive/90 transition-colors text-sm font-medium">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    `).join('');

    // Re-render icons
    lucide.createIcons();
}

function openAddressModal(addressIndex = null) {
    const modal = document.getElementById('addressModal');
    const form = document.getElementById('addressForm');
    const title = document.getElementById('modalTitle');

    if (addressIndex !== null) {
        // Edit mode
        const address = userAddresses[addressIndex];
        title.textContent = 'Edit Address';
        document.getElementById('addressType').value = address.type;
        document.getElementById('addressName').value = address.name;
        document.getElementById('addressPhone').value = address.phone;
        document.getElementById('streetAddress').value = address.streetAddress;
        document.getElementById('apartment').value = address.apartment || '';
        document.getElementById('city').value = address.city;
        document.getElementById('state').value = address.state;
        document.getElementById('zipCode').value = address.zipCode;
        document.getElementById('country').value = address.country;
        document.getElementById('isDefault').checked = address.isDefault || false;

        form.dataset.editIndex = addressIndex;
    } else {
        // Add mode
        title.textContent = 'Add New Address';
        form.reset();
        delete form.dataset.editIndex;
    }

    modal.classList.remove('hidden');
}

function closeAddressModal() {
    document.getElementById('addressModal').classList.add('hidden');
}

function saveAddress() {
    const formData = {
        type: document.getElementById('addressType').value,
        name: document.getElementById('addressName').value,
        phone: document.getElementById('addressPhone').value,
        streetAddress: document.getElementById('streetAddress').value,
        apartment: document.getElementById('apartment').value,
        city: document.getElementById('city').value,
        state: document.getElementById('state').value,
        zipCode: document.getElementById('zipCode').value,
        country: document.getElementById('country').value,
        isDefault: document.getElementById('isDefault').checked
    };

    const editIndex = document.getElementById('addressForm').dataset.editIndex;

    if (editIndex !== undefined) {
        // Update existing address
        userAddresses[editIndex] = formData;
    } else {
        // Add new address
        userAddresses.push(formData);
    }

    // If this is set as default, remove default from others
    if (formData.isDefault) {
        userAddresses.forEach((addr, index) => {
            if (index !== parseInt(editIndex) && addr !== formData) {
                addr.isDefault = false;
            }
        });
    }

    saveAddresses();
    renderAddresses();
    closeAddressModal();
    showToast(editIndex !== undefined ? 'Address updated successfully!' : 'Address added successfully!');
}

// Global functions for address actions
window.editAddress = function(index) {
    openAddressModal(index);
};

window.setDefaultAddress = function(index) {
    userAddresses.forEach((addr, i) => {
        addr.isDefault = i === index;
    });
    saveAddresses();
    renderAddresses();
    showToast('Default address updated!');
};

window.deleteAddress = function(index) {
    if (confirm('Are you sure you want to delete this address?')) {
        userAddresses.splice(index, 1);
        saveAddresses();
        renderAddresses();
        showToast('Address deleted successfully!');
    }
};

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    initTabs();
    initProfile();
    initAddresses();

    // Update account summary
    const orders = JSON.parse(localStorage.getItem('larinsOrders')) || [];
    const wishlist = JSON.parse(localStorage.getItem('larinsWishlist')) || [];

    document.getElementById('totalOrders').textContent = orders.length;
    document.getElementById('wishlistCount').textContent = wishlist.length;
    document.getElementById('memberSince').textContent = 'Jan 2024'; // You can make this dynamic
});