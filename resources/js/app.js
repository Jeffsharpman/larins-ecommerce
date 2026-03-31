import './bootstrap';
import 'preline';

function initPreline() {
    if (typeof HSStaticMethods !== "undefined") {
        HSStaticMethods.autoInit();
    }
}

document.addEventListener('livewire:init', initPreline);
document.addEventListener('livewire:navigated', initPreline);
document.addEventListener('livewire:updated', initPreline);
document.addEventListener('DOMContentLoaded', initPreline);

document.addEventListener('livewire:navigated', () => {
    const themeButtons = document.querySelectorAll('#themeToggle, #themeToggleMobile');
    const html = document.documentElement;

    // 1. RE-APPLY THEME FROM STORAGE (The Missing Piece)
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }

    // 2. Initial Icon State Sync
    const updateIcons = () => {
        const isDark = html.classList.contains('dark');
        themeButtons.forEach(btn => {
            const sun = btn.querySelector('.sun-icon');
            const moon = btn.querySelector('.moon-icon');
            
            if (isDark) {
                sun?.classList.add('hidden');
                moon?.classList.remove('hidden');
            } else {
                sun?.classList.remove('hidden');
                moon?.classList.add('hidden');
            }
        });
    };

    // 3. Click Logic
    themeButtons.forEach(btn => {
        // Use { once: true } or clear previous listeners to avoid clones if needed, 
        // but Livewire usually handles this cleanup on navigated.
        btn.addEventListener('click', () => {
            html.classList.toggle('dark');
            const theme = html.classList.contains('dark') ? 'dark' : 'light';
            localStorage.setItem('theme', theme);
            updateIcons();
        });
    });

    // Run once on every navigation
    updateIcons();
});