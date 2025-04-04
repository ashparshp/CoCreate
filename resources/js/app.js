import './bootstrap';
import Alpine from 'alpinejs';
import axios from 'axios';

window.Alpine = Alpine;
Alpine.start();

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Dark mode initialization
document.addEventListener('DOMContentLoaded', function() {
    initializeDarkMode();
    
    // File preview functionality
    const fileInput = document.getElementById('file');
    if (fileInput) {
        fileInput.addEventListener('change', previewFile);
    }
    
    // Message container auto-scroll
    const messageContainer = document.getElementById('message-container');
    if (messageContainer) {
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }
    
    // Ctrl+Enter to submit forms
    const messageInput = document.getElementById('message-input');
    const messageForm = document.getElementById('message-form');
    if (messageInput && messageForm) {
        messageInput.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'Enter') {
                e.preventDefault();
                messageForm.submit();
            }
        });
    }
    
    // Task filters
    setupTaskFilters();
});

function initializeDarkMode() {
    if (localStorage.getItem('darkMode') === 'true' || 
        (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}

function toggleDarkMode() {
    if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('darkMode', 'false');
    } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('darkMode', 'true');
    }
}

function previewFile() {
    const preview = document.getElementById('file-preview');
    const file = document.getElementById('file').files[0];
    const reader = new FileReader();
    
    reader.onloadend = function() {
        let previewContent = '';
        if (file.type.match('image.*')) {
            previewContent = `<div class="mt-2">
                <p class="text-sm text-secondary-600 dark:text-secondary-400">Preview:</p>
                <img src="${reader.result}" class="h-24 w-auto object-cover rounded border border-secondary-200 dark:border-secondary-700 mt-1" alt="File preview">
            </div>`;
        } else {
            previewContent = `<div class="mt-2">
                <p class="text-sm text-secondary-600 dark:text-secondary-400">Selected file: ${file.name} (${(file.size / 1024).toFixed(2)} KB)</p>
            </div>`;
        }
        preview.innerHTML = previewContent;
    }
    
    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
}

function setupTaskFilters() {
    const statusFilter = document.getElementById('status-filter');
    const priorityFilter = document.getElementById('priority-filter');
    const assignedFilter = document.getElementById('assigned-filter');
    const searchInput = document.getElementById('file-search');
    
    if (statusFilter && priorityFilter && assignedFilter) {
        statusFilter.addEventListener('change', applyFilters);
        priorityFilter.addEventListener('change', applyFilters);
        assignedFilter.addEventListener('change', applyFilters);
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', applyFileFilters);
    }
    
    // Initial filter application
    if (statusFilter && priorityFilter && assignedFilter) {
        applyFilters();
    }
    
    if (searchInput) {
        applyFileFilters();
    }
}

function applyFilters() {
    const statusValue = document.getElementById('status-filter').value;
    const priorityValue = document.getElementById('priority-filter').value;
    const assignedValue = document.getElementById('assigned-filter').value;
    const searchInput = document.getElementById('search');
    const searchValue = searchInput ? searchInput.value.toLowerCase() : '';
    
    // Filter cards in kanban view
    document.querySelectorAll('.task-card').forEach(card => {
        const cardTitle = card.querySelector('a').textContent.toLowerCase();
        const cardDesc = card.querySelector('p') ? card.querySelector('p').textContent.toLowerCase() : '';
        const cardStatus = card.dataset.status;
        const cardPriority = card.dataset.priority;
        const cardAssigned = card.dataset.assigned;
        
        const statusMatch = statusValue === 'all' || cardStatus === statusValue;
        const priorityMatch = priorityValue === 'all' || cardPriority === priorityValue;
        const assignedMatch = assignedValue === 'all' || cardAssigned === assignedValue;
        const searchMatch = searchValue === '' || cardTitle.includes(searchValue) || cardDesc.includes(searchValue);
        
        card.style.display = statusMatch && priorityMatch && assignedMatch && searchMatch ? 'block' : 'none';
    });
    
    // Filter rows in list view
    document.querySelectorAll('.task-row').forEach(row => {
        const rowTitle = row.querySelector('a').textContent.toLowerCase();
        const rowStatus = row.dataset.status;
        const rowPriority = row.dataset.priority;
        const rowAssigned = row.dataset.assigned;
        
        const statusMatch = statusValue === 'all' || rowStatus === statusValue;
        const priorityMatch = priorityValue === 'all' || rowPriority === priorityValue;
        const assignedMatch = assignedValue === 'all' || rowAssigned === assignedValue;
        const searchMatch = searchValue === '' || rowTitle.includes(searchValue);
        
        row.style.display = statusMatch && priorityMatch && assignedMatch && searchMatch ? '' : 'none';
    });
    
    // Show/hide empty state messages in kanban view
    document.querySelectorAll('.task-column').forEach(column => {
        const hasVisibleCards = Array.from(column.querySelectorAll('.task-card')).some(card => card.style.display !== 'none');
        const emptyStateMsg = column.querySelector('.empty-state');
        
        if (emptyStateMsg) {
            emptyStateMsg.style.display = hasVisibleCards ? 'none' : 'block';
        }
    });
}

function applyFileFilters() {
    const searchInput = document.getElementById('file-search');
    const typeFilter = document.getElementById('file-type-filter');
    
    if (!searchInput || !typeFilter) return;
    
    const searchTerm = searchInput.value.toLowerCase();
    const fileType = typeFilter.value;
    
    const fileItems = document.querySelectorAll('.file-item');
    
    fileItems.forEach(item => {
        const filename = item.dataset.filename.toLowerCase();
        const itemType = item.dataset.type;
        
        const matchesSearch = filename.includes(searchTerm);
        const matchesType = fileType === 'all' || itemType === fileType;
        
        item.style.display = matchesSearch && matchesType ? '' : 'none';
    });
    
    // Check if there are any visible items
    const hasVisibleItems = Array.from(fileItems).some(item => item.style.display !== 'none');
    
    // Get the parent table element
    const fileList = document.getElementById('file-list');
    
    // If no visible items and parent exists, add "no results" message
    if (!hasVisibleItems && fileList) {
        // Check if the message already exists
        let noResultsMsg = document.getElementById('no-results-message');
        
        if (!noResultsMsg) {
            noResultsMsg = document.createElement('tr');
            noResultsMsg.id = 'no-results-message';
            noResultsMsg.innerHTML = `
                <td colspan="6" class="py-8 text-center">
                    <p class="text-secondary-500 dark:text-secondary-400">No files match your search.</p>
                </td>
            `;
            fileList.appendChild(noResultsMsg);
        }
    } else {
        // Remove the message if it exists
        const noResultsMsg = document.getElementById('no-results-message');
        if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }
}

// Expose functions to global scope
window.toggleDarkMode = toggleDarkMode;
window.previewFile = previewFile;