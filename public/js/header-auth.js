// Adjust header auth link based on current user
document.addEventListener('DOMContentLoaded', () => {
    const authLink = document.getElementById('authLink');
    const current = JSON.parse(localStorage.getItem('larinsCurrentUser'));
    if (authLink) {
        if (current) {
            authLink.textContent = 'Logout';
            authLink.href = '#';
            authLink.addEventListener('click', e => {
                e.preventDefault();
                logout();
                window.location.href = '/';
            });
        } else {
            authLink.textContent = 'Login';
            authLink.href = '/admin/login.html';
        }
    }

    // global search redirect
    const searchInputs = document.querySelectorAll('.search-input');
    searchInputs.forEach(input => {
        input.addEventListener('keydown', ev => {
            if (ev.key === 'Enter') {
                ev.preventDefault();
                const q = input.value.trim();
                if (q) window.location.href = `/products.html?search=${encodeURIComponent(q)}`;
            }
        });
    });

    // cart count
    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('larinsCart')) || [];
        const el = document.querySelector('.cart-count');
        if (el) el.textContent = cart.reduce((sum,i)=>sum+i.quantity,0);
    }
    updateCartCount();
    document.addEventListener('cartUpdated', updateCartCount);
});
