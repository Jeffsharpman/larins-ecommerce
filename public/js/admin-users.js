// load users and allow export/delete
document.addEventListener('DOMContentLoaded', () => {
    const usersBody = document.getElementById('usersBody');
    const exportBtn = document.getElementById('exportUsers');

    function render() {
        const users = JSON.parse(localStorage.getItem('larinsUsers')) || [];
        usersBody.innerHTML = '';
        users.forEach((u, idx) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${escapeHtml(u.email)}</td><td>${escapeHtml(u.role)}</td><td><button class="btn btn-outline btn-sm delete" data-index="${idx}">Delete</button></td>`;
            usersBody.appendChild(tr);
        });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    usersBody.addEventListener('click', e => {
        if (e.target.matches('.delete')) {
            const idx = parseInt(e.target.dataset.index, 10);
            let users = JSON.parse(localStorage.getItem('larinsUsers')) || [];
            users.splice(idx, 1);
            localStorage.setItem('larinsUsers', JSON.stringify(users));
            render();
        }
    });

    exportBtn.addEventListener('click', () => {
        const users = JSON.parse(localStorage.getItem('larinsUsers')) || [];
        const csv = users.map(u => `${u.email},${u.role}`).join('\n');
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'users.csv';
        a.click();
        URL.revokeObjectURL(url);
    });

    render();
});