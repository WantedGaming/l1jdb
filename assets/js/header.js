/**
 * header.js
 * JavaScript for header navigation functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize header functionality
    initMobileMenu();
    initDropdowns();
    initSearch();
    initUserProfile();
});

/**
 * Mobile Menu Functionality
 */
function initMobileMenu() {
    const mobileButton = document.querySelector('.mobile-menu-button');
    const mobileNav = document.querySelector('.nav-mobile');
    
    if (!mobileButton || !mobileNav) return;
    
    // Toggle mobile menu
    mobileButton.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleMobileMenu();
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!mobileNav.contains(event.target) && !mobileButton.contains(event.target)) {
            closeMobileMenu();
        }
    });
    
    // Handle mobile dropdown toggles
    const mobileDropdownLinks = mobileNav.querySelectorAll('.nav-link.has-dropdown');
    mobileDropdownLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            toggleMobileDropdown(this);
        });
    });
}

function toggleMobileMenu() {
    const mobileNav = document.querySelector('.nav-mobile');
    const mobileButton = document.querySelector('.mobile-menu-button');
    
    if (mobileNav.classList.contains('active')) {
        closeMobileMenu();
    } else {
        openMobileMenu();
    }
}

function openMobileMenu() {
    const mobileNav = document.querySelector('.nav-mobile');
    const mobileButton = document.querySelector('.mobile-menu-button');
    
    mobileNav.classList.add('active');
    mobileButton.innerHTML = '<i class="fas fa-times"></i>';
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closeMobileMenu() {
    const mobileNav = document.querySelector('.nav-mobile');
    const mobileButton = document.querySelector('.mobile-menu-button');
    
    mobileNav.classList.remove('active');
    mobileButton.innerHTML = '<i class="fas fa-bars"></i>';
    document.body.style.overflow = ''; // Restore scrolling
    
    // Close all mobile dropdowns
    const openDropdowns = mobileNav.querySelectorAll('.dropdown-menu');
    openDropdowns.forEach(function(dropdown) {
        dropdown.style.display = 'none';
    });
}

function toggleMobileDropdown(link) {
    const dropdown = link.nextElementSibling;
    const arrow = link.querySelector('.dropdown-arrow');
    
    if (!dropdown) return;
    
    const isOpen = dropdown.style.display === 'block';
    
    // Close all other mobile dropdowns
    const allDropdowns = document.querySelectorAll('.nav-mobile .dropdown-menu');
    const allArrows = document.querySelectorAll('.nav-mobile .dropdown-arrow');
    
    allDropdowns.forEach(function(menu) {
        menu.style.display = 'none';
    });
    
    allArrows.forEach(function(arr) {
        arr.style.transform = 'rotate(0deg)';
    });
    
    // Toggle current dropdown
    if (!isOpen) {
        dropdown.style.display = 'block';
        if (arrow) arrow.style.transform = 'rotate(180deg)';
    }
}

/**
 * Desktop Dropdown Functionality
 */
function initDropdowns() {
    const dropdownItems = document.querySelectorAll('.nav:not(.nav-mobile) .nav-item');
    
    dropdownItems.forEach(function(item) {
        const dropdown = item.querySelector('.dropdown-menu');
        
        if (!dropdown) return;
        
        let hoverTimeout;
        
        // Show dropdown on hover
        item.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimeout);
            showDropdown(dropdown);
        });
        
        // Hide dropdown on leave with delay
        item.addEventListener('mouseleave', function() {
            hoverTimeout = setTimeout(function() {
                hideDropdown(dropdown);
            }, 300); // 300ms delay
        });
        
        // Keep dropdown open when hovering over it
        dropdown.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimeout);
        });
        
        dropdown.addEventListener('mouseleave', function() {
            hoverTimeout = setTimeout(function() {
                hideDropdown(dropdown);
            }, 300);
        });
    });
}

function showDropdown(dropdown) {
    dropdown.style.opacity = '1';
    dropdown.style.visibility = 'visible';
    dropdown.style.transform = 'translateY(0)';
}

function hideDropdown(dropdown) {
    dropdown.style.opacity = '0';
    dropdown.style.visibility = 'hidden';
    dropdown.style.transform = 'translateY(-10px)';
}

/**
 * Search Functionality
 */
function initSearch() {
    const searchForm = document.querySelector('.header-search-form');
    const searchInput = document.querySelector('.header-search-input');
    
    if (!searchForm || !searchInput) return;
    
    // Auto-focus search on Ctrl+K or Cmd+K
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
        }
        
        // Close search suggestions on Escape
        if (e.key === 'Escape' && document.activeElement === searchInput) {
            searchInput.blur();
        }
    });
    
    // Add search suggestions (placeholder for future implementation)
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        if (query.length >= 2) {
            // TODO: Implement search suggestions
            // showSearchSuggestions(query);
        } else {
            // hideSearchSuggestions();
        }
    });
}

/**
 * User Profile Dropdown
 */
function initUserProfile() {
    const userProfile = document.querySelector('.user-profile');
    
    if (!userProfile) return;
    
    userProfile.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleUserDropdown();
    });
    
    // Close user dropdown when clicking outside
    document.addEventListener('click', function() {
        closeUserDropdown();
    });
}

function toggleUserDropdown() {
    // TODO: Implement user profile dropdown
    // This would show options like Profile, Settings, Logout
    console.log('User dropdown clicked');
}

function closeUserDropdown() {
    // TODO: Close user dropdown
}

/**
 * Utility Functions
 */

// Debounce function for search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = function() {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Smooth scroll to element
function smoothScrollTo(element) {
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Handle responsive behavior
function handleResize() {
    const isMobile = window.innerWidth <= 768;
    
    if (!isMobile) {
        closeMobileMenu();
    }
}

// Listen for window resize
window.addEventListener('resize', debounce(handleResize, 250));

// Export functions for global access
window.toggleMobileMenu = toggleMobileMenu;
window.closeMobileMenu = closeMobileMenu;