<!-- Export Button Component with Dropdown Menu -->
<div class="relative" data-export-button data-table="{{ $table }}">
    <!-- Main Export Button -->
    <button
        class="btn-primary px-6 py-2 rounded-lg text-white font-medium hover:shadow-xl transition-all duration-300 flex items-center"
        type="button" onclick="toggleExportMenu(this)">
        <i class="fas fa-file-download mr-2"></i>Export
        <i class="fas fa-chevron-down ml-2 text-xs"></i>
    </button>
</div>

<script>
    function toggleExportMenu(button) {
        const container = button.closest('[data-export-button]');
        const tableValue = container.getAttribute('data-table');
        let menu = document.querySelector(`[data-export-menu="${container.getAttribute('data-export-id')}"]`);

        if (!menu) {
            // Create menu and append to body
            menu = document.createElement('div');
            menu.setAttribute('data-export-menu', container.getAttribute('data-export-id'));
            menu.className = 'fixed bg-black/95 border border-white/10 rounded-lg shadow-2xl w-56 export-menu';
            menu.style.zIndex = '99999';
            menu.innerHTML = `
                <!-- Export Displayed Data -->
                <button type="button" class="w-full text-left px-4 py-3 text-white hover:bg-white/10 transition-colors flex items-center border-b border-white/5" onclick="submitExport('${tableValue}', 'filtered')">
                    <i class="fas fa-download mr-3 text-green-400"></i>
                    <div>
                        <p class="font-medium">Export Displayed</p>
                        <p class="text-xs text-gray-400">Current filters & pagination</p>
                    </div>
                </button>

                <!-- Export All Records -->
                <button type="button" class="w-full text-left px-4 py-3 text-white hover:bg-white/10 transition-colors flex items-center" onclick="submitExport('${tableValue}', 'all')">
                    <i class="fas fa-file-excel mr-3 text-blue-400"></i>
                    <div>
                        <p class="font-medium">Export All</p>
                        <p class="text-xs text-gray-400">Entire table</p>
                    </div>
                </button>
            `;
            document.body.appendChild(menu);
        }

        // Toggle visibility and position
        if (menu.style.display === 'none' || !menu.style.display) {
            const rect = button.getBoundingClientRect();
            menu.style.display = 'block';
            menu.style.top = (rect.bottom + 10) + 'px';
            menu.style.left = (rect.right - 224) + 'px'; // 224px is width (56*4)
        } else {
            menu.style.display = 'none';
        }
    }

    // Initialize buttons with unique IDs and close menu on click outside
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-export-button]').forEach((btn, idx) => {
            btn.setAttribute('data-export-id', 'export-' + idx);
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('[data-export-button]') && !e.target.closest('[data-export-menu]')) {
            document.querySelectorAll('[data-export-menu]').forEach(menu => {
                menu.style.display = 'none';
            });
        }
    });

    function submitExport(table, mode) {
        const tableData = collectTableData();
        const filters = new URLSearchParams(window.location.search);
        const filtersObj = Object.fromEntries(filters);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

        // Create form and submit directly
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = mode === 'filtered' ? '{{ route('admin.export.filtered') }}' : '{{ route('admin.export.all') }}';

        // Add fields
        const addField = (name, value) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        };

        addField('_token', csrfToken);
        addField('table', table);
        addField('filters', JSON.stringify(filtersObj));
        if (mode === 'filtered') {
            addField('data', JSON.stringify(tableData));
        }

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    function collectTableData() {
        const rows = [];
        const table = document.querySelector('table');

        if (!table) {
            return rows;
        }

        // Get headers
        const headers = [];
        const headerCells = table.querySelectorAll('thead th');
        headerCells.forEach(cell => {
            // Skip action column
            if (!cell.textContent.includes('Action')) {
                headers.push(cell.textContent.trim());
            }
        });
        rows.push(headers);

        // Get body rows
        const bodyCells = table.querySelectorAll('tbody tr');
        bodyCells.forEach(row => {
            const cells = row.querySelectorAll('td');
            const record = [];
            cells.forEach((cell, index) => {
                // Skip action column (usually last)
                if (index < cells.length - 1) {
                    record.push(cell.textContent.trim());
                }
            });
            if (record.length > 0) {
                rows.push(record);
            }
        });

        return rows;
    }
</script>
