// Main JavaScript file for the public site

document.addEventListener('DOMContentLoaded', function() {
    // Initialize dropdown menus
    initDropdowns();
    
    // Initialize search functionality
    initSearch();
    
    // Initialize filter functionality
    initFilters();
});

/**
 * Initialize dropdown menus
 */
function initDropdowns() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    // For desktop - already handled by CSS :hover, but adding for completeness
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.closest('.dropdown');
            parent.classList.toggle('active');
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        const dropdowns = document.querySelectorAll('.dropdown.active');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    });
}

/**
 * Initialize search functionality
 */
function initSearch() {
    const searchForm = document.querySelector('.search-form');
    if (!searchForm) return;
    
    searchForm.addEventListener('submit', function(e) {
        const searchInput = this.querySelector('.search-input');
        if (!searchInput.value.trim()) {
            e.preventDefault();
            searchInput.focus();
        }
    });
}

/**
 * Initialize filter functionality
 */
function initFilters() {
    const filterForm = document.querySelector('.filter-form');
    if (!filterForm) return;
    
    // Toggle filters visibility on mobile
    const filterToggle = document.querySelector('.filter-toggle');
    if (filterToggle) {
        filterToggle.addEventListener('click', function(e) {
            e.preventDefault();
            filterForm.classList.toggle('active');
            this.textContent = filterForm.classList.contains('active') ? 'Hide Filters' : 'Show Filters';
        });
    }
    
    // Reset filters button
    const resetButton = document.querySelector('.filter-reset');
    if (resetButton) {
        resetButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Reset all inputs
            filterForm.querySelectorAll('input[type="text"], input[type="number"]').forEach(input => {
                input.value = '';
            });
            
            // Reset all selects
            filterForm.querySelectorAll('select').forEach(select => {
                select.selectedIndex = 0;
            });
            
            // Reset all checkboxes
            filterForm.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Submit the form
            filterForm.submit();
        });
    }
}

/**
 * Show/hide elements by ID
 */
function toggleElement(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        if (element.style.display === 'none' || getComputedStyle(element).display === 'none') {
            element.style.display = 'block';
        } else {
            element.style.display = 'none';
        }
    }
}

/**
 * Handle detail tabs
 */
function openTab(evt, tabName) {
    // Hide all tab content
    const tabContent = document.querySelectorAll('.tab-content');
    for (let i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = 'none';
    }
    
    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    for (let i = 0; i < tabButtons.length; i++) {
        tabButtons[i].className = tabButtons[i].className.replace(' active', '');
    }
    
    // Show the current tab and add an "active" class to the button
    document.getElementById(tabName).style.display = 'block';
    evt.currentTarget.className += ' active';
}
