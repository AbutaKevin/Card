document.addEventListener('DOMContentLoaded', function () {
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
});

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
