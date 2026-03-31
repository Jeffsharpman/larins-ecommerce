// simple log viewer & export
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('logsContainer');
    const exportBtn = document.getElementById('exportLogs');

    function render() {
        const logs = JSON.parse(localStorage.getItem('larinsLogs')) || [];
        container.innerHTML = '';
        logs.forEach(log => {
            const div = document.createElement('div');
            div.className = 'log-entry';
            div.innerHTML = `<span class="time">${new Date(log.timestamp).toLocaleString()}</span> - <span class="action">${escapeHtml(log.action)}</span>`;
            container.appendChild(div);
        });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    exportBtn.addEventListener('click', () => {
        const logs = JSON.parse(localStorage.getItem('larinsLogs')) || [];
        const csv = logs.map(l => `${l.timestamp},"${l.action.replace(/"/g, '""')}"`).join('\n');
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'logs.csv';
        a.click();
        URL.revokeObjectURL(url);
    });

    render();
});