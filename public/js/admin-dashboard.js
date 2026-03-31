// Dashboard logic: show counts and admin name

document.addEventListener('DOMContentLoaded', () => {
    const userCountEl = document.getElementById('userCount');
    const logCountEl = document.getElementById('logCount');
    const adminNameEl = document.getElementById('adminName');

    const users = JSON.parse(localStorage.getItem('larinsUsers')) || [];
    const logs = JSON.parse(localStorage.getItem('larinsLogs')) || [];
    const current = JSON.parse(localStorage.getItem('larinsCurrentUser'));

    userCountEl.textContent = users.length;
    logCountEl.textContent = logs.length;
    adminNameEl.textContent = current ? current.email : 'Guest';
}

// refresh counts every 10 seconds
setInterval(render, 10000);

render();
});