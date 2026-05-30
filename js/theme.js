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

        // Insert into desktop nav
        const navLinks = document.querySelector('.nav-links');
        if (navLinks) {
            navLinks.appendChild(toggle);
        }

        // Also insert into mobile nav if present
        const mobileNav = document.querySelector('.mobile-nav');
        if (mobileNav) {
            const mobileToggle = toggle.cloneNode(true);
            mobileNav.appendChild(mobileToggle);

            // Mobile toggle handler (mirrors desktop)
            mobileToggle.addEventListener('click', function() {
                const isLight = document.body.classList.toggle('light-theme');
                localStorage.setItem('wf-theme', isLight ? 'light' : 'dark');
                toggle.innerHTML = isLight
                    ? '<i class="fas fa-moon"></i>'
                    : '<i class="fas fa-sun"></i>';
                mobileToggle.innerHTML = toggle.innerHTML;
            });
        }

        // Desktop toggle handler
        toggle.addEventListener('click', function() {
            const isLight = document.body.classList.toggle('light-theme');
            localStorage.setItem('wf-theme', isLight ? 'light' : 'dark');
            toggle.innerHTML = isLight
                ? '<i class="fas fa-moon"></i>'
                : '<i class="fas fa-sun"></i>';
            // Sync mobile toggle icon
            const mobileToggles = document.querySelectorAll('.theme-toggle');
            mobileToggles.forEach(function(t) {
                t.innerHTML = toggle.innerHTML;
            });
        });
    });
})();