// Theme toggle — shared across all pages
(function() {
    // Apply saved theme immediately on load (prevents flash)
    const saved = localStorage.getItem('wf-theme');
    if (saved === 'light') {
        document.documentElement.classList.add('preload-light');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Remove preload class
        document.documentElement.classList.remove('preload-light');

        // Apply saved theme
        const savedTheme = localStorage.getItem('wf-theme') || 'dark';
        if (savedTheme === 'light') {
            document.body.classList.add('light-theme');
        }

        // Create toggle button
        const toggle = document.createElement('button');
        toggle.className = 'theme-toggle';
        toggle.title = 'Toggle light/dark mode';
        toggle.innerHTML = savedTheme === 'light' 
            ? '<i class="fas fa-moon"></i>' 
            : '<i class="fas fa-sun"></i>';

        // Insert into nav after the last nav link
        const navLinks = document.querySelector('.nav-links');
        if (navLinks) {
            navLinks.appendChild(toggle);
        }

        // Toggle handler
        toggle.addEventListener('click', function() {
            const isLight = document.body.classList.toggle('light-theme');
            localStorage.setItem('wf-theme', isLight ? 'light' : 'dark');
            toggle.innerHTML = isLight 
                ? '<i class="fas fa-moon"></i>' 
                : '<i class="fas fa-sun"></i>';
        });
    });
})();
