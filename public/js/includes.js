// Simple client-side HTML include helper
// Usage: <div data-include="components/header.html"></div>
function includeHTML() {
    // compute current base path (folder of the page) so relative includes work even
    // if the site is served from a different root (e.g. Live Server open at workspace
    // root while files live in /version2).
    const basePath = window.location.pathname.replace(/[^\/]*$/, '');

    document.querySelectorAll('[data-include]').forEach(el => {
        const url = el.getAttribute('data-include');
        if (!url) return;

        // resolve relative URL against basePath
        const fetchUrl = new URL(url, window.location.origin + basePath).href;

        fetch(fetchUrl)
            .then(resp => {
                if (!resp.ok) throw new Error(`Failed to load ${fetchUrl}`);
                return resp.text();
            })
            .then(html => {
                // create a temporary container to parse the fetched markup
                const tmp = document.createElement('div');
                tmp.innerHTML = html;

                // move any <link rel="stylesheet"> tags to <head> to ensure they load
                tmp.querySelectorAll('link[rel="stylesheet"]').forEach(link => {
                    document.head.appendChild(link);
                });

                // append the remaining nodes to the element
                while (tmp.firstChild) {
                    el.appendChild(tmp.firstChild);
                }

                // execute any scripts that were in the fetched HTML
                el.querySelectorAll('script').forEach(oldScript => {
                    const newScript = document.createElement('script');
                    if (oldScript.src) {
                        newScript.src = oldScript.src;
                        newScript.async = false; // preserve execution order
                    } else {
                        newScript.textContent = oldScript.textContent;
                    }
                    document.body.appendChild(newScript);
                    oldScript.remove();
                });

                // reinitialize icons if page uses lucide/feather
                if (window.lucide) lucide.createIcons();
                if (window.feather) feather.replace();
            })
            .catch(err => console.error(err));
    });
}

document.addEventListener('DOMContentLoaded', includeHTML);
