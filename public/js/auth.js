// Basic frontend-only authentication simulation using localStorage

const usersKey = 'larinsUsers';
const currentUserKey = 'larinsCurrentUser';
const logsKey = 'larinsLogs';

function logAction(action) {
    const logs = JSON.parse(localStorage.getItem(logsKey)) || [];
    logs.push({ action, timestamp: Date.now() });
    localStorage.setItem(logsKey, JSON.stringify(logs));
}


// A simple hashing function (DO NOT use in production) – we'll use it for demonstration
function hashPassword(password) {
    // using built-in crypto if available
    if (window.crypto && window.crypto.subtle) {
        const encoder = new TextEncoder();
        return window.crypto.subtle.digest('SHA-256', encoder.encode(password)).then(hashBuffer => {
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
        });
    }
    // fallback: simple hex conversion
    let hash = 0;
    for (let i = 0; i < password.length; i++) {
        hash = Math.imul(31, hash) + password.charCodeAt(i) | 0;
    }
    return Promise.resolve(hash.toString());
}

function saveUsers(users) {
    localStorage.setItem(usersKey, JSON.stringify(users));
}

function loadUsers() {
    return JSON.parse(localStorage.getItem(usersKey)) || [];
}

function register(email, password) {
    return hashPassword(password).then(hash => {
        const users = loadUsers();
        if (users.find(u => u.email === email)) {
            logAction(`register-fail: ${email} already exists`);
            return Promise.reject('User already exists');
        }
        users.push({ email, passwordHash: hash, role: 'admin' });
        saveUsers(users);
        logAction(`registered user: ${email}`);
        return Promise.resolve();
    });
}

function login(email, password) {
    return hashPassword(password).then(hash => {
        const users = loadUsers();
        const user = users.find(u => u.email === email && u.passwordHash === hash);
        if (user) {
            localStorage.setItem(currentUserKey, JSON.stringify(user));
            logAction(`login-success: ${email}`);
            return Promise.resolve(user);
        }
        logAction(`login-fail: ${email}`);
        return Promise.reject('Invalid credentials');
    });
}

function logout() {
    const current = JSON.parse(localStorage.getItem(currentUserKey));
    if (current) {
        logAction(`logout: ${current.email}`);
    }
    localStorage.removeItem(currentUserKey);
}

function getCurrentUser() {
    return JSON.parse(localStorage.getItem(currentUserKey));
}

// on login page
document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const registerLink = document.getElementById('registerLink');
    if (loginForm) {
        loginForm.addEventListener('submit', e => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            login(email, password)
                .then(user => {
                    showToast('Welcome back!');
                    window.location.href = '/admin/dashboard.html';
                })
                .catch(msg => {
                    showToast('Invalid credentials', 4000);
                });
        });
    }

    if (registerLink) {
        registerLink.addEventListener('click', e => {
            e.preventDefault();
            const email = prompt('Enter admin email');
            const password = prompt('Enter password');
            if (email && password) {
                register(email, password)
                    .then(() => showToast('Registered. You can now sign in.'))
                    .catch(err => showToast(err, 4000));
            }
        });
    }
});
