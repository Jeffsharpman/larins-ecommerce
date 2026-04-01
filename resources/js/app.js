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

function initTheme() {
    const themeButtons = document.querySelectorAll('#themeToggle, #themeToggleMobile');
    const html = document.documentElement;

    // Apply saved theme or system preference
    const savedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }

    // Update icons based on current theme
    const updateIcons = () => {
        const isDark = html.classList.contains('dark');
        themeButtons.forEach(btn => {
            const sun = btn.querySelector('.sun-icon');
            const moon = btn.querySelector('.moon-icon');
            
            if (sun && moon) {
                if (isDark) {
                    sun.classList.add('hidden');
                    moon.classList.remove('hidden');
                } else {
                    sun.classList.remove('hidden');
                    moon.classList.add('hidden');
                }
            }
        });
    };

    updateIcons();

    // Toggle theme on button click
    themeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            html.classList.toggle('dark');
            const theme = html.classList.contains('dark') ? 'dark' : 'light';
            localStorage.setItem('theme', theme);
            updateIcons();
        });
    });
}

// Initialize theme on first load and on Livewire navigation
initTheme();

document.addEventListener('livewire:navigated', initTheme);