document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('settingsForm');
    const siteNameInput = document.getElementById('siteName');
    const maintenanceInput = document.getElementById('maintenanceMode');

    const settingsKey = 'larinsSettings';

    function load() {
        const s = JSON.parse(localStorage.getItem(settingsKey)) || {};
        siteNameInput.value = s.siteName || '';
        maintenanceInput.checked = s.maintenanceMode || false;
    }
    function save(e) {
        e.preventDefault();
        const s = {
            siteName: siteNameInput.value.trim(),
            maintenanceMode: maintenanceInput.checked
        };
        localStorage.setItem(settingsKey, JSON.stringify(s));
        alert('Settings saved');
    }
    form.addEventListener('submit', save);
    load();

    document.getElementById('backupData').addEventListener('click', () => {
        const data = {};
        Object.keys(localStorage).forEach(key => {
            if (key.startsWith('larins')) {
                data[key] = localStorage.getItem(key);
            }
        });
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'larins-backup.json';
        a.click();
        URL.revokeObjectURL(url);
    });
});