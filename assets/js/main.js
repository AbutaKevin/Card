function initApp() {
    const toggles = document.querySelectorAll('[data-confirm]');
    toggles.forEach(function (element) {
        element.addEventListener('click', function (event) {
            const message = element.getAttribute('data-confirm');
            if (!confirm(message)) {
                event.preventDefault();
            }
        });
    });

    const themeSwitch = document.getElementById('themeSwitch');
    if (themeSwitch) {
        themeSwitch.addEventListener('click', function () {
            document.body.classList.toggle('dark-mode');
        });
    }

    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const layoutWrapper = document.querySelector('.layout-wrapper');
    const sidebarBackdrop = document.querySelector('.sidebar-backdrop');

    function openSidebar() {
        layoutWrapper?.classList.add('sidebar-open');
        document.body.classList.add('sidebar-open');
        if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', 'true');
        // move focus to first nav link for accessibility
        const firstLink = document.querySelector('.sidebar .nav-link');
        if (firstLink) firstLink.focus();
    }

    function closeSidebar() {
        layoutWrapper?.classList.remove('sidebar-open');
        document.body.classList.remove('sidebar-open');
        if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', 'false');
        // return focus to toggle
        if (sidebarToggle) sidebarToggle.focus();
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', openSidebar);
        sidebarToggle.setAttribute('aria-expanded', 'false');
        sidebarToggle.setAttribute('aria-controls', 'sidebar');
    }

    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeSidebar);
    }

    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', closeSidebar);
    }

    document.addEventListener('keyup', function (event) {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initApp);
} else {
    initApp();
}

// Job Card Print Selection Functions
function toggleSelectAll(checkbox) {
    const cardCheckboxes = document.querySelectorAll('.card-checkbox');
    cardCheckboxes.forEach(cb => {
        cb.checked = checkbox.checked;
    });
    updatePrintButton();
}

function updatePrintButton() {
    const printBtn = document.getElementById('printBtn');
    const cardCheckboxes = document.querySelectorAll('.card-checkbox');
    const checkedCount = document.querySelectorAll('.card-checkbox:checked').length;
    
    if (printBtn) {
        if (checkedCount > 0) {
            printBtn.disabled = false;
            printBtn.textContent = `Print Selected (${checkedCount})`;
        } else {
            printBtn.disabled = true;
            printBtn.innerHTML = '<i class="bi bi-printer"></i> Print Selected';
        }
    }
    
    // Update select all checkbox
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.checked = checkedCount === cardCheckboxes.length && checkedCount > 0;
    }
}

function printSelectedCards() {
    const selectedIds = [];
    document.querySelectorAll('.card-checkbox:checked').forEach(checkbox => {
        selectedIds.push(checkbox.value);
    });
    
    if (selectedIds.length === 0) {
        alert('Please select at least one card to print.');
        return;
    }
    
    // Get the base URL from the page
    const baseUrl = document.location.origin + document.location.pathname.split('/jobcards')[0];
    const printUrl = baseUrl + '/jobcards/print?ids=' + selectedIds.join(',');
    
    window.location.href = printUrl;
}
