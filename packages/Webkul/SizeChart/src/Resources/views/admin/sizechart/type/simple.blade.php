@php
    $isEdit = isset($sizeChart);
    $headers = $headers ?? [];
    $matrix = $matrix ?? [];
    $columnNames = $isEdit ? $headers : [];
    $existingData = $isEdit ? $matrix : [];
    
    // If we're in edit mode, ensure we have proper column names
    if ($isEdit && !empty($matrix) && empty($headers)) {
        // Get column names from the first row if headers are not set
        $firstRow = reset($matrix);
        $columnNames = array_keys($firstRow);
    }
@endphp

<div class="control-group">
    <label class="required">Size Chart</label>

    @if(!$isEdit)
    <div class="mb-10">
        <div class="control-group">
            <label for="column_names" class="required">Column Names (comma separated)</label>
            <input type="text" 
                   id="column_names" 
                   name="column_names" 
                   class="control" 
                   placeholder="e.g. Size, Chest, Waist, Length" 
                   value="{{ old('column_names', $isEdit ? implode(', ', $columnNames) : '') }}">
            <span class="control-info">Enter column names separated by commas</span>
        </div>
    </div>
    @endif

    <div class="mb-10">
        <button type="button" class="btn btn-md btn-primary" onclick="addNewRow()">
            ➕ Add Row
        </button>
    </div>

    <style>
        .action-column,
        .action-cell {
            display: none !important;
        }

        .action-column:not([style*="display: none"]) + .action-cell,
        .action-column:not([style*="display: none"]) ~ .action-cell {
            display: table-cell !important;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #f8f9fa;
        }
        .table tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.02);
        }
        .table tbody tr:hover {
            background-color: rgba(0,0,0,.05);
        }
        .control_input_t {
            width: 100%;
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
    </style>
    
    <div class="table-responsive">
        <table class="table" id="edit-sizechart-table">
            <thead>
                <tr>
                    @if($isEdit)
                        @foreach($columnNames as $header)
                            <th>{{ strtoupper($header) }}</th>
                        @endforeach
                        <th class="action-column">Action</th>
                    @else
                        <th class="action-column" style="display: none;">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if($isEdit)
                    @foreach($matrix as $rowIndex => $row)
                        <tr>
                            @foreach($columnNames as $column)
                                <td>
                                    <input type="text" 
                                           name="formname[{{ $rowIndex }}][{{ $column }}]" 
                                           class="control control_input_t" 
                                           value="{{ $row[$column] ?? '' }}"
                                           placeholder="{{ $column }}"
                                           required>
                                </td>
                            @endforeach
                            <td class="action-cell">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">
                                    ✖
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <input type="hidden" name="template_type" value="simple">
</div>

@push('scripts')
    <script>
        // Function to get column names from input or from PHP
        function getColumnNames() {
            const columnInput = document.getElementById('column_names');
            if (columnInput) {
                if (columnInput.value.trim() !== '') {
                    return columnInput.value.split(',').map(col => col.trim()).filter(Boolean);
                }
            }
            return @json($columnNames);
        }

        // Function to update table headers and rows based on column names
        function updateTable() {
            const thead = document.querySelector('#edit-sizechart-table thead tr');
            const tbody = document.querySelector('#edit-sizechart-table tbody');
            if (!thead || !tbody) return;
            
            const columnNames = getColumnNames();
            const actionColumn = thead.querySelector('.action-column');
            
            // Show/hide action column based on whether we have columns
            if (actionColumn) {
                actionColumn.style.display = columnNames.length > 0 ? '' : 'none';
            }
            
            // Save existing row data
            const rowsData = [];
            tbody.querySelectorAll('tr').forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length > 0) {
                    const rowData = {};
                    columnNames.forEach((col, index) => {
                        if (index < cells.length) {
                            const input = cells[index].querySelector('input');
                            if (input) {
                                rowData[col] = input.value;
                            }
                        }
                    });
                    rowsData.push(rowData);
                }
            });
            
            // Update headers
            thead.innerHTML = '';
            
            // Add column headers
            columnNames.forEach(col => {
                const th = document.createElement('th');
                th.textContent = col.toUpperCase();
                thead.appendChild(th);
            });
            
            // Add action header if we have columns
            if (columnNames.length > 0) {
                const newActionTh = document.createElement('th');
                newActionTh.className = 'action-column';
                newActionTh.textContent = 'Action';
                thead.appendChild(newActionTh);
            }
            
            // Clear and rebuild rows with new columns
            tbody.innerHTML = '';
            
            // Add rows with new column structure
            rowsData.forEach((rowData, rowIndex) => {
                addNewRow(rowData, rowIndex);
            });
            
            // If no rows but we have columns, add one empty row
            if (tbody.children.length === 0 && columnNames.length > 0) {
                addNewRow();
            }
        }

        // Function to add a new row with dynamic columns
        function addNewRow(rowData = null, rowIndex = null) {
            const tbody = document.querySelector('#edit-sizechart-table tbody');
            if (!tbody) return;

            const columnNames = getColumnNames();
            
            // Don't add a row if there are no columns
            if (columnNames.length === 0) {
                alert('Please add column names first');
                return;
            }
            
            const newRow = document.createElement('tr');
            const actualRowIndex = rowIndex !== null ? rowIndex : tbody.querySelectorAll('tr').length;
            
            // Add cells for each column
            columnNames.forEach(column => {
                const cell = document.createElement('td');
                cell.innerHTML = `
                    <input type="text" 
                           name="formname[${actualRowIndex}][${column}]" 
                           class="control control_input_t" 
                           value="${rowData ? (rowData[column] || '') : ''}"
                           placeholder="${column}" 
                           required>`;
                newRow.appendChild(cell);
            });
            
            // Add delete button
            const deleteCell = document.createElement('td');
            deleteCell.className = 'action-cell';
            deleteCell.innerHTML = `
                <button type="button" 
                        class="btn btn-sm btn-danger" 
                        onclick="removeRow(this)">
                    ✖
                </button>`;
            newRow.appendChild(deleteCell);
            
            if (rowIndex !== null) {
                // Insert at specific index for edit mode
                const rows = tbody.querySelectorAll('tr');
                if (rowIndex < rows.length) {
                    tbody.insertBefore(newRow, rows[rowIndex]);
                } else {
                    tbody.appendChild(newRow);
                }
            } else {
                tbody.appendChild(newRow);
            }
        }

        // Function to remove a row
        function removeRow(button) {
            const row = button.closest('tr');
            if (row) {
                row.remove();
                updateRowIndices();
            }
        }
        
        // Function to update row indices
        function updateRowIndices() {
            const tbody = document.querySelector('#edit-sizechart-table tbody');
            if (!tbody) return;
            
            const rows = tbody.querySelectorAll('tr');
            rows.forEach((row, index) => {
                const inputs = row.querySelectorAll('input');
                inputs.forEach(input => {
                    input.name = input.name.replace(/formname\[\d+\]/, `formname[${index}]`);
                });
            });
        }

        // Initialize the table when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            const columnInput = document.getElementById('column_names');
            
            // If we're in edit mode, make sure the table is properly initialized
            @if($isEdit)
                // Show the action column if we have columns
                const actionColumn = document.querySelector('.action-column');
                if (actionColumn && @json(count($columnNames) > 0)) {
                    actionColumn.style.display = '';
                }
                
                // Initialize the table with existing data
                updateTable();
            @else
                // For create mode, set up event listeners for the column input
                if (columnInput) {
                    columnInput.addEventListener('input', updateTable);
                    columnInput.addEventListener('change', updateTable);
                }
            @endif
        });
    </script>
@endpush