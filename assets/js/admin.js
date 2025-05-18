// Admin JavaScript file

document.addEventListener('DOMContentLoaded', function() {
    // Initialize admin dropdowns
    initAdminDropdowns();
    
    // Initialize admin forms validation
    initFormValidation();
    
    // Initialize admin tables (sortable, etc.)
    initAdminTables();
    
    // Initialize confirm actions (like delete)
    initConfirmActions();
});

/**
 * Initialize admin dropdowns
 */
function initAdminDropdowns() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    // For desktop
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
 * Initialize form validation
 */
function initFormValidation() {
    const forms = document.querySelectorAll('.admin-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Required fields validation
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                    
                    // Add error message if not exists
                    if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('error-message')) {
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'error-message';
                        errorMessage.textContent = 'This field is required';
                        field.parentNode.insertBefore(errorMessage, field.nextSibling);
                    }
                } else {
                    field.classList.remove('error');
                    
                    // Remove error message if exists
                    if (field.nextElementSibling && field.nextElementSibling.classList.contains('error-message')) {
                        field.nextElementSibling.remove();
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                
                // Scroll to first error
                const firstError = form.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });
    });
}

/**
 * Initialize admin tables
 */
function initAdminTables() {
    const tables = document.querySelectorAll('.admin-table');
    
    tables.forEach(table => {
        const headers = table.querySelectorAll('th[data-sort]');
        
        headers.forEach(header => {
            header.addEventListener('click', function() {
                const sortBy = this.getAttribute('data-sort');
                const sortDir = this.getAttribute('data-sort-dir') === 'asc' ? 'desc' : 'asc';
                
                // Update sort direction
                headers.forEach(h => h.removeAttribute('data-sort-dir'));
                this.setAttribute('data-sort-dir', sortDir);
                
                // Add sort parameters to URL and reload
                const url = new URL(window.location.href);
                url.searchParams.set('sort', sortBy);
                url.searchParams.set('dir', sortDir);
                window.location.href = url.toString();
            });
        });
    });
}

/**
 * Initialize confirm actions
 */
function initConfirmActions() {
    // Delete confirmation
    const deleteButtons = document.querySelectorAll('.admin-delete-form');
    
    deleteButtons.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
}

/**
 * Show/hide admin alerts
 */
function toggleAlert(alertId) {
    const alert = document.getElementById(alertId);
    if (alert) {
        alert.classList.toggle('hidden');
    }
}

/**
 * Initialize dynamic form fields
 */
function initDynamicFormFields() {
    // Add row button
    const addButtons = document.querySelectorAll('.admin-form-add-row');
    
    addButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const container = document.getElementById(this.getAttribute('data-container'));
            const template = document.getElementById(this.getAttribute('data-template'));
            
            if (container && template) {
                const newRow = template.content.cloneNode(true);
                container.appendChild(newRow);
                
                // Initialize remove buttons
                initRemoveButtons();
            }
        });
    });
    
    // Initialize existing remove buttons
    initRemoveButtons();
}

/**
 * Initialize remove buttons for dynamic form fields
 */
function initRemoveButtons() {
    const removeButtons = document.querySelectorAll('.admin-form-remove-row');
    
    removeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const row = this.closest('.admin-form-row');
            if (row) {
                row.remove();
            }
        });
    });
}

/**
 * Show preview of uploaded image
 */
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (preview && input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
