/**
 * Admin Panel JavaScript Functionality
 * Handles sidebar toggle, mobile responsiveness, and interactive features
 */

document.addEventListener('DOMContentLoaded', function () {
    // Sidebar toggle functionality
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function (event) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        }
    });

    // Handle window resize
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('show');
        }
    });

    // Add active class to current navigation item
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.sidebar-nav .nav-link');

    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath ||
            (currentPath === '/' && link.getAttribute('href') === '/backend/web/')) {
            link.classList.add('active');
        }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading states to forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function () {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitBtn.disabled = true;

                // Re-enable button after 5 seconds as fallback
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 5000);
            }
        });
    });

    // Add hover effects to dashboard cards
    const dashboardCards = document.querySelectorAll('.dashboard-card');
    dashboardCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-5px)';
        });

        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
        });
    });

    // Notification system
    const notificationBell = document.querySelector('.notifications');
    if (notificationBell) {
        notificationBell.addEventListener('click', function () {
            showNotificationDropdown();
        });
    }

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 300);
            }
        }, 5000);
    });

    // Add keyboard shortcuts
    document.addEventListener('keydown', function (e) {
        // Ctrl/Cmd + K to toggle sidebar
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (sidebar) {
                sidebar.classList.toggle('show');
            }
        }

        // Escape key to close sidebar on mobile
        if (e.key === 'Escape' && window.innerWidth <= 768) {
            if (sidebar) {
                sidebar.classList.remove('show');
            }
        }
    });

    // Initialize tooltips for elements with data-tooltip attribute
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function () {
            showTooltip(this, this.getAttribute('data-tooltip'));
        });

        element.addEventListener('mouseleave', function () {
            hideTooltip();
        });
    });
});

/**
 * Show notification dropdown
 */
function showNotificationDropdown() {
    // Remove existing dropdown
    const existingDropdown = document.querySelector('.notification-dropdown');
    if (existingDropdown) {
        existingDropdown.remove();
        return;
    }

    // Create notification dropdown
    const dropdown = document.createElement('div');
    dropdown.className = 'notification-dropdown';
    dropdown.style.cssText = `
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        min-width: 300px;
        z-index: 1000;
        padding: 1rem;
    `;

    dropdown.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h6 style="margin: 0; color: #2c3e50;">Notifications</h6>
            <button onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; color: #6c757d; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="notification-list">
            <div class="notification-item" style="padding: 0.75rem; border-bottom: 1px solid #f8f9fa; display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 2rem; height: 2rem; background: #667eea; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.875rem;">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: #2c3e50; margin-bottom: 0.25rem;">New user registration</div>
                    <div style="font-size: 0.75rem; color: #6c757d;">2 minutes ago</div>
                </div>
            </div>
            <div class="notification-item" style="padding: 0.75rem; border-bottom: 1px solid #f8f9fa; display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 2rem; height: 2rem; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.875rem;">
                    <i class="fas fa-server"></i>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: #2c3e50; margin-bottom: 0.25rem;">Server backup completed</div>
                    <div style="font-size: 0.75rem; color: #6c757d;">1 hour ago</div>
                </div>
            </div>
            <div class="notification-item" style="padding: 0.75rem; display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 2rem; height: 2rem; background: #ffc107; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.875rem;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: #2c3e50; margin-bottom: 0.25rem;">System maintenance scheduled</div>
                    <div style="font-size: 0.75rem; color: #6c757d;">Tomorrow at 2 AM</div>
                </div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e9ecef;">
            <a href="#" style="color: #667eea; text-decoration: none; font-size: 0.875rem;">View all notifications</a>
        </div>
    `;

    // Position the dropdown
    const notificationBell = document.querySelector('.notifications');
    if (notificationBell) {
        notificationBell.style.position = 'relative';
        notificationBell.appendChild(dropdown);
    }
}

/**
 * Show tooltip
 */
function showTooltip(element, text) {
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = text;
    tooltip.style.cssText = `
        position: absolute;
        background: #2c3e50;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        z-index: 1000;
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s;
    `;

    document.body.appendChild(tooltip);

    // Position tooltip
    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';

    // Show tooltip
    setTimeout(() => {
        tooltip.style.opacity = '1';
    }, 10);

    // Store reference to remove later
    element._tooltip = tooltip;
}

/**
 * Hide tooltip
 */
function hideTooltip() {
    const tooltips = document.querySelectorAll('.tooltip');
    tooltips.forEach(tooltip => {
        tooltip.remove();
    });
}

/**
 * Utility function to show success message
 */
function showSuccess(message) {
    showAlert(message, 'success');
}

/**
 * Utility function to show error message
 */
function showError(message) {
    showAlert(message, 'error');
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} fade-in`;
    alertDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        max-width: 400px;
    `;
    alertDiv.innerHTML = `
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}" 
               style="color: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'};"></i>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(alertDiv);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        alertDiv.style.opacity = '0';
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 300);
    }, 5000);
}
