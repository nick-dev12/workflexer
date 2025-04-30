// Sidebar toggle
document.addEventListener('DOMContentLoaded', function () {
    // Sidebar toggle functionality
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    const header = document.querySelector('.header');
    const mainContent = document.querySelector('.main-content');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            header.classList.toggle('expanded');
            mainContent.classList.toggle('expanded');

            // Store sidebar state in localStorage
            if (sidebar.classList.contains('collapsed')) {
                localStorage.setItem('sidebarState', 'collapsed');
            } else {
                localStorage.setItem('sidebarState', 'expanded');
            }
        });

        // Check saved state on load
        const savedState = localStorage.getItem('sidebarState');
        if (savedState === 'collapsed') {
            sidebar.classList.add('collapsed');
            header.classList.add('expanded');
            mainContent.classList.add('expanded');
        }
    }

    // Modal functionality
    const modalTriggers = document.querySelectorAll('[data-modal-target]');
    const modalCloseButtons = document.querySelectorAll('.modal-close, .btn-cancel');

    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', () => {
            const modal = document.getElementById(trigger.dataset.modalTarget);
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    modalCloseButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modal = button.closest('.modal-overlay');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Close modal when clicking outside
    document.addEventListener('click', (e) => {
        const modals = document.querySelectorAll('.modal-overlay.active');
        modals.forEach(modal => {
            if (e.target === modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Data table search functionality
    const tableSearchInputs = document.querySelectorAll('.table-search-input');

    tableSearchInputs.forEach(input => {
        input.addEventListener('keyup', function () {
            const searchTerm = this.value.toLowerCase();
            const tableId = this.dataset.tableTarget;
            const table = document.getElementById(tableId);

            if (table) {
                const rows = table.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        });
    });

    // Data table sorting
    const sortableColumns = document.querySelectorAll('.sortable');

    sortableColumns.forEach(column => {
        column.addEventListener('click', function () {
            const tableId = this.closest('table').id;
            const table = document.getElementById(tableId);
            const columnIndex = Array.from(column.parentNode.children).indexOf(column);
            const sortDirection = this.classList.contains('asc') ? 'desc' : 'asc';

            // Remove sorting classes from all columns
            const allSortable = table.querySelectorAll('.sortable');
            allSortable.forEach(col => {
                col.classList.remove('asc', 'desc');
            });

            // Add new sort direction
            this.classList.add(sortDirection);

            // Sort the table
            sortTable(table, columnIndex, sortDirection);
        });
    });

    function sortTable(table, columnIndex, direction) {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        // Sort rows
        rows.sort((a, b) => {
            const aValue = a.children[columnIndex].textContent.trim();
            const bValue = b.children[columnIndex].textContent.trim();

            if (direction === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        });

        // Remove existing rows
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }

        // Add sorted rows
        rows.forEach(row => {
            tbody.appendChild(row);
        });
    }

    // Pagination functionality
    const paginationTables = document.querySelectorAll('[data-pagination]');

    paginationTables.forEach(table => {
        const rowsPerPage = parseInt(table.dataset.pagination) || 10;
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const paginationContainer = document.querySelector(`[data-pagination-for="${table.id}"]`);

        if (paginationContainer) {
            const paginationInfo = paginationContainer.querySelector('.pagination-info');
            const paginationControls = paginationContainer.querySelector('.pagination-controls');
            const totalRows = rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);

            // Create pagination buttons
            paginationControls.innerHTML = '';

            // Prev button
            const prevButton = document.createElement('button');
            prevButton.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevButton.disabled = true;
            paginationControls.appendChild(prevButton);

            // Page buttons
            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                if (i === 1) pageButton.classList.add('active');
                pageButton.dataset.page = i;
                paginationControls.appendChild(pageButton);
            }

            // Next button
            const nextButton = document.createElement('button');
            nextButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
            if (totalPages <= 1) nextButton.disabled = true;
            paginationControls.appendChild(nextButton);

            // Show initial page
            showPage(1);

            // Update pagination info
            if (paginationInfo) {
                updatePaginationInfo(1);
            }

            // Page button click handlers
            paginationControls.addEventListener('click', function (e) {
                if (e.target.tagName === 'BUTTON' || e.target.parentNode.tagName === 'BUTTON') {
                    const button = e.target.tagName === 'BUTTON' ? e.target : e.target.parentNode;

                    // Previous button
                    if (button === prevButton) {
                        const activePage = paginationControls.querySelector('.active');
                        const currentPage = parseInt(activePage.dataset.page);
                        if (currentPage > 1) {
                            showPage(currentPage - 1);
                        }
                    }
                    // Next button
                    else if (button === nextButton) {
                        const activePage = paginationControls.querySelector('.active');
                        const currentPage = parseInt(activePage.dataset.page);
                        if (currentPage < totalPages) {
                            showPage(currentPage + 1);
                        }
                    }
                    // Page number button
                    else if (button.dataset.page) {
                        showPage(parseInt(button.dataset.page));
                    }
                }
            });

            function showPage(pageNumber) {
                // Update active button
                const buttons = paginationControls.querySelectorAll('button[data-page]');
                buttons.forEach(btn => {
                    btn.classList.remove('active');
                    if (parseInt(btn.dataset.page) === pageNumber) {
                        btn.classList.add('active');
                    }
                });

                // Enable/disable prev/next buttons
                prevButton.disabled = pageNumber === 1;
                nextButton.disabled = pageNumber === totalPages;

                // Show/hide rows
                const startIndex = (pageNumber - 1) * rowsPerPage;
                const endIndex = startIndex + rowsPerPage;

                rows.forEach((row, index) => {
                    if (index >= startIndex && index < endIndex) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Update pagination info
                if (paginationInfo) {
                    updatePaginationInfo(pageNumber);
                }
            }

            function updatePaginationInfo(pageNumber) {
                const startIndex = (pageNumber - 1) * rowsPerPage + 1;
                const endIndex = Math.min(startIndex + rowsPerPage - 1, totalRows);
                paginationInfo.textContent = `Affichage de ${startIndex}-${endIndex} sur ${totalRows} entrées`;
            }
        }
    });

    // Alert auto-dismiss
    const alerts = document.querySelectorAll('.alert[data-auto-dismiss]');

    alerts.forEach(alert => {
        const dismissTime = parseInt(alert.dataset.autoDismiss) || 5000;
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, dismissTime);
    });

    // Confirm delete action
    const deleteButtons = document.querySelectorAll('[data-confirm-delete]');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            const message = this.dataset.confirmDelete || 'Êtes-vous sûr de vouloir supprimer cet élément ?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // Menu active link based on current page
    const currentPath = window.location.pathname;
    const menuLinks = document.querySelectorAll('.menu-link');

    menuLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (currentPath.includes(href) && href !== '#') {
            link.classList.add('active');
        }
    });
});

// Export table to CSV
function exportTableToCSV(tableId, filename = 'export.csv') {
    const table = document.getElementById(tableId);
    if (!table) return;

    const rows = table.querySelectorAll('tr');
    const csv = [];

    for (let i = 0; i < rows.length; i++) {
        const row = [], cols = rows[i].querySelectorAll('td, th');

        for (let j = 0; j < cols.length; j++) {
            // Get text content and clean it
            let text = cols[j].textContent.trim();
            // Replace any double quotes with two double quotes
            text = text.replace(/"/g, '""');
            // Wrap with double quotes to handle commas within text
            row.push('"' + text + '"');
        }

        csv.push(row.join(','));
    }

    // Download CSV file
    const csvContent = 'data:text/csv;charset=utf-8,' + csv.join('\n');
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement('a');
    link.setAttribute('href', encodedUri);
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Charts initialization
function initCharts() {
    // Check if Chart.js is available
    if (typeof Chart === 'undefined') return;

    // Initialize charts
    const userChartElement = document.getElementById('usersChart');
    if (userChartElement) {
        new Chart(userChartElement, {
            type: 'line',
            data: {
                labels: userChartData.labels,
                datasets: [{
                    label: 'Nouveaux utilisateurs',
                    data: userChartData.data,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Categories distribution chart
    const categoriesChartElement = document.getElementById('categoriesChart');
    if (categoriesChartElement) {
        new Chart(categoriesChartElement, {
            type: 'doughnut',
            data: {
                labels: categoriesChartData.labels,
                datasets: [{
                    data: categoriesChartData.data,
                    backgroundColor: [
                        '#2563eb',
                        '#10b981',
                        '#f59e0b',
                        '#ef4444',
                        '#8b5cf6',
                        '#ec4899'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }
} 