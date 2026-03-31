document.addEventListener('DOMContentLoaded', () => {
    const menuToggle   = document.getElementById('menuToggle');
    const searchToggle = document.getElementById('searchToggle');
    const mobileMenu   = document.getElementById('mobileMenu');
    const mobileSearch = document.getElementById('mobileSearch');

    const menuIcon = document.querySelector('.menu-icon');
    const closeIcon = document.querySelector('.close-icon');

    // Toggle mobile menu
    menuToggle?.addEventListener('click', () => {
        const willOpen = mobileMenu.classList.contains('hidden');

        mobileMenu.classList.toggle('hidden', !willOpen);
        mobileSearch.classList.add('hidden'); // close search if open

        menuIcon.classList.toggle('hidden', willOpen);
        closeIcon.classList.toggle('hidden', !willOpen);
    });

    // Toggle mobile search
    searchToggle?.addEventListener('click', () => {
        const willOpen = mobileSearch.classList.contains('hidden');

        mobileSearch.classList.toggle('hidden', !willOpen);
        mobileMenu.classList.add('hidden'); // close menu if open

        if (!willOpen) {
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        }
    });

    // Close drawers when clicking links
    document.querySelectorAll('.mobile-link, .mobile-auth-link').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            mobileSearch.classList.add('hidden');
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        });
    });

    // Optional: subtle shadow on scroll
    window.addEventListener('scroll', () => {
        document.getElementById('siteHeader').classList.toggle('scrolled', window.scrollY > 10);
    });
});