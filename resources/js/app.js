import './bootstrap';
import 'preline';

function initPreline() {
    if (typeof HSStaticMethods !== "undefined") {
        HSStaticMethods.autoInit();
    }
}

function initTheme() {
    const html = document.documentElement;
    const savedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }
    
    updateThemeIcons();
}

function updateThemeIcons() {
    const isDark = document.documentElement.classList.contains('dark');
    
    document.querySelectorAll('.desktop-sun, .mobile-sun, #mobile-sun').forEach(el => {
        el.classList.toggle('hidden', isDark);
    });
    document.querySelectorAll('.desktop-moon, .mobile-moon, #mobile-moon').forEach(el => {
        el.classList.toggle('hidden', !isDark);
    });
}

window.toggleTheme = function() {
    const html = document.documentElement;
    html.classList.toggle('dark');
    const isDark = html.classList.contains('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    updateThemeIcons();
};

document.addEventListener('livewire:init', initPreline);
document.addEventListener('livewire:navigated', initPreline);
document.addEventListener('livewire:updated', initPreline);
document.addEventListener('DOMContentLoaded', () => {
    initPreline();
    initTheme();
});
document.addEventListener('livewire:navigated', initTheme);