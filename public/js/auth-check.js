// include at top of admin pages to verify authentication
document.addEventListener('DOMContentLoaded', () => {
    const current = JSON.parse(localStorage.getItem('larinsCurrentUser'));
    if (!current || current.role !== 'admin') {
        window.location.href = '/admin/login.html';
        return;
    }
    // session expiration (15 minutes)
    const tsKey = 'larinsSessionTS';
    const now = Date.now();
    const last = Number(localStorage.getItem(tsKey)) || now;
    if (now - last > 15 * 60 * 1000) {
        alert('Session expired');
        logout();
        window.location.href = '/admin/login.html';
        return;
    }
    localStorage.setItem(tsKey, now);
    // refresh ts on any click/keypress
    ['click','keydown','mousemove','scroll'].forEach(evt => {
        document.addEventListener(evt, () => {
            localStorage.setItem(tsKey, Date.now());
        });
    });
});