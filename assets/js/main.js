/**
 * FitTrack Pro - Main JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle
    initMobileSidebar();
    
    // Auto-hide alerts after 5 seconds
    initAutoHideAlerts();
});

/**
 * Initialize mobile sidebar toggle
 */
function initMobileSidebar() {
    // Check if we're on mobile
    const isMobile = window.innerWidth <= 768;
    
    if (isMobile) {
        // Create toggle button if it doesn't exist
        let toggleBtn = document.querySelector('.sidebar-toggle');
        if (!toggleBtn) {
            toggleBtn = document.createElement('button');
            toggleBtn.className = 'sidebar-toggle icon-btn';
            toggleBtn.innerHTML = '<span class="material-symbols-outlined">menu</span>';
            toggleBtn.style.position = 'fixed';
            toggleBtn.style.top = '12px';
            toggleBtn.style.left = '12px';
            toggleBtn.style.zIndex = '101';
            
            document.body.appendChild(toggleBtn);
            
            toggleBtn.addEventListener('click', function() {
                const sidebar = document.querySelector('.sidebar');
                sidebar.classList.toggle('open');
            });
        }
    }
}

/**
 * Initialize auto-hide for alerts
 */
function initAutoHideAlerts() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            
            setTimeout(function() {
                alert.remove();
            }, 500);
        }, 5000);
    });
}

/**
 * Handle window resize
 */
window.addEventListener('resize', function() {
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.sidebar-toggle');
    
    if (window.innerWidth > 768) {
        // Desktop - remove mobile classes and toggle button
        if (sidebar) {
            sidebar.classList.remove('open');
        }
        if (toggleBtn) {
            toggleBtn.remove();
        }
    } else {
        // Mobile - recreate toggle button if needed
        initMobileSidebar();
    }
});
