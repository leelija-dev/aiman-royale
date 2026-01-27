@extends('Admin.layouts.master')
@section('page-title', 'Dashboard')
@section('title')
{{ config('app.name') }} - Dashboard
@endsection

@section('content')
<style>
    .btn-group .btn {
        margin-right: 5px;
    }
</style>

<div class="container-fluid mt-3">
    
   <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="px-3 py-4 text-center">
                    <h3>Welcome Admin</h3>
                   {{-- <div class="row mb-3 align-items-center">
                        <div class="col-md-6 mb-0">
                            <div class="" role="group">
                                <button class="btn btn-sm btn-primary filter-btn mb-2" data-period="today">Today</button>
                                <button class="btn btn-sm btn-info filter-btn mb-2" data-period="week">Last Week</button>
                                <button class="btn btn-sm btn-secondary filter-btn mb-2" data-period="month">Last Month</button>
                                <button class="btn btn-sm btn-warning filter-btn mb-2" data-period="year">Last Year</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-md-end justify-content-start gap-2 flex-sm-nowrap flex-wrap ">
                                <div class="dropdown w-sm-auto w-100">
                                    <button class="btn btn-sm btn-primary dropdown-toggle mb-0 w-sm-auto w-100" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                        Export
                                    </button>
                                    <ul class="dropdown-menu w-sm-auto w-100" aria-labelledby="exportDropdown" id="exportMenu">
                                        <li><button class="dropdown-item export-btn" data-export="pdf">Export to PDF</button></li>
                                        <li><button class="dropdown-item export-btn" data-export="excel">Export to Excel</button></li>
                                        <li><button class="dropdown-item export-btn" data-export="docx">Export to Word (DOCX)</button></li>
                                        <!-- <li><button class="dropdown-item export-btn" data-export="png">Export to PNG</button></li> -->

                                    </ul>
                                </div>
                                <button class="btn btn-sm btn-success filter-btn w-sm-auto w-100" data-period="custom" data-bs-toggle="modal" data-bs-target="#customDateModal">Custom</button>
                            </div>
                        </div>
                    </div>
                    <div id="filterMessage" class="alert alert-danger d-none" role="alert"></div>

                    <div class="row">
                        <div class="col-12">
                            <canvas id="profitLossChart"></canvas>
                        </div>
                    </div>
                    <div id="chartLoadingIndicator" class="text-center mt-3" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2">Loading chart data...</p>
                    </div>

                    <div class="row mt-4">
                        <div class="col-sm-6 mb-2">
                            <div class="p-3 bg-light border rounded">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div>Total Profit</div>
                                        <div class="text-muted small mt-1">Total Due: <b><span id="totalDue">0</span></b></div>
                                    </div>
                                    <strong id="totalProfit">0</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <div class="p-3 bg-light border rounded">
                                <div class="d-flex justify-content-between">
                                    <span>Total Sells</span>
                                    <strong id="totalLoss">0</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Product Bills Details</h5>
                                </div>
                                <div class="card-body">
                                    <table id="productBillsTable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Product ID</th>
                                                <th>Shop Name</th>
                                                <th>Total Amount</th>
                                                <th>Payable Amount</th>
                                                <th>Due Amount</th>
                                                <th>Date Sold</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Product Sales Details</h5>
                                </div>
                                <div class="card-body">
                                    <table id="productSalesTable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Product ID</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Quantity Sold</th>
                                                <th>Unit Price</th>

                                                <th>Date Sold</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</div> 

<!-- Custom Date Modal -->
{{-- <div class="modal fade" id="customDateModal" tabindex="-1" aria-labelledby="customDateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customDateModalLabel">Select Custom Date Range</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="modalStartDate" class="form-label">From</label>
                    <input type="date" class="form-control" id="modalStartDate">
                </div>
                <div class="mb-3">
                    <label for="modalEndDate" class="form-label">To</label>
                    <input type="date" class="form-control" id="modalEndDate">
                </div>
                <div id="modalErrorMessage" class="alert alert-danger d-none" role="alert"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="applyCustomDate">Apply Filter</button>
            </div>
        </div>
    </div>
</div>--}}
@endsection 

{{-- @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net@1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pdfmake@0.2.7/build/pdfmake.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pdfmake@0.2.7/build/vfs_fonts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-buttons@2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-buttons-bs5@2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/docx@8.0.2/build/index.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script>


<script>
    // Chart instance
    let profitLossChart = null;
    let currentChartData = null; // Store current chart data for export
    let productSalesTable = null; // DataTable instance
    let productBillsTable = null;
    let currentFilterPeriod = 'week'; // Track current filter period
    let currentStartDate = null; // Track custom start date
    let currentEndDate = null; // Track custom end date

    // Format currency in INR
    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(amount);
    }

    // Helper function to generate filename and heading based on filter period
    function generateFileInfo(exportType) {
        const now = new Date();
        const formattedDate = `${String(now.getDate()).padStart(2, '0')}-${String(now.getMonth() + 1).padStart(2, '0')}-${now.getFullYear()}`;
        let datePart = '';
        let filterDescription = '';

        if (currentFilterPeriod === 'today') {
            datePart = `Today_${formattedDate}`;
            filterDescription = `Today (${formattedDate})`;
        } else if (currentFilterPeriod === 'week') {
            const endDate = new Date(now);
            const startDate = new Date(now);
            startDate.setDate(now.getDate() - 6);
            const formattedStart = `${String(startDate.getDate()).padStart(2, '0')}-${String(startDate.getMonth() + 1).padStart(2, '0')}-${startDate.getFullYear()}`;
            const formattedEnd = formattedDate;
            datePart = `${formattedStart}_to_${formattedEnd}`;
            filterDescription = `Last Week (${formattedStart} to ${formattedEnd})`;
        } else if (currentFilterPeriod === 'month') {
            const monthName = now.toLocaleString('en-IN', {
                month: 'long'
            });
            datePart = `${monthName}_${now.getFullYear()}`;
            filterDescription = `Last Month (${monthName} ${now.getFullYear()})`;
        } else if (currentFilterPeriod === 'custom' && currentStartDate && currentEndDate) {
            datePart = `${currentStartDate}_to_${currentEndDate}`;
            filterDescription = `Custom Date (${currentStartDate} to ${currentEndDate})`;
        } else {
            datePart = formattedDate; // Fallback
            filterDescription = `Date (${formattedDate})`;
        }

        const timestamp = now.toLocaleString('en-IN');
        const heading = `Sales Report - ${filterDescription} (Generated on ${timestamp})`;

        return {
            filename: `Sales_Report_${datePart}.${exportType}`,
            heading: heading
        };
    }

    // Update the chart with new data
    function updateChart(data) {
        const ctx = document.getElementById('profitLossChart').getContext('2d');

        if (profitLossChart) {
            profitLossChart.destroy();
        }

        currentChartData = data; // Store data for export

        profitLossChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                        label: 'Profit',
                        data: data.profit,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Sales',
                        data: data.sales,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        tension: 0.3,
                        fill: true
                    },
                    // {
                    //     label: 'Bills',
                    //     data: data.bills,
                    //     borderColor: 'rgba(255, 99, 132, 1)',
                    //     backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    //     tension: 0.3,
                    //     fill: true
                    // },
                    {
                        type: 'line',
                        label: 'Profit Growth',
                        borderColor: 'rgba(100, 192, 192, 1)',
                        backgroundColor: 'rgba(100, 192, 192, 0.2)',
                        fill: false,
                        data: data.profit,
                    }


                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return formatCurrency(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += formatCurrency(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }

    // Update the stats display
    function updateStats(stats) {
        document.getElementById('totalProfit').textContent = formatCurrency(stats.total_profit || 0);
        document.getElementById('totalLoss').textContent = formatCurrency(stats.total_sales || 0);
        document.getElementById('totalDue').textContent = formatCurrency(stats.total_due || 0);
    }

    function sum(arr) {
        return (arr || []).reduce((a, b) => a + b, 0);
    }

    function showLoading() {
        document.getElementById('chartLoadingIndicator').style.display = 'block';
        document.getElementById('profitLossChart').style.display = 'none';
        document.getElementById('totalProfit').textContent = '...';
        document.getElementById('totalLoss').textContent = '...';
    }

    function hideLoading() {
        document.getElementById('chartLoadingIndicator').style.display = 'none';
        document.getElementById('profitLossChart').style.display = 'block';
    }

    function displayMessage(message, type = 'danger', target = 'filterMessage') {
        const msgDiv = document.getElementById(target);
        msgDiv.textContent = message;
        msgDiv.className = `alert alert-${type} d-block`;
    }

    function clearMessage(target = 'filterMessage') {
        const msgDiv = document.getElementById(target);
        msgDiv.textContent = '';
        msgDiv.className = `alert alert-danger d-none`;
    }

    function initializeProductSalesTable(productsData) {
        console.log(productsData);
        if (productSalesTable) {
            productSalesTable.destroy();
            $('#productSalesTable tbody').empty();
        }

        productSalesTable = $('#productSalesTable').DataTable({
            data: productsData.top_products || [],
            columns: [{
                    data: 'id',
                    title: 'Product ID'
                },
                {
                    data: 'name',
                    title: 'Name',
                    render: function(data, type, row) {
                        return data || 'N/A';
                    }
                },
                {
                    data: 'category_name',
                    title: 'Category',
                    render: function(data, type, row) {
                        return data || 'N/A';
                    }
                },
                {
                    data: 'total_quantity',
                    title: 'Quantity',
                    className: 'text-end',
                    render: function(data) {
                        return data || 0;
                    }
                },
                {
                    data: 'unit_price',
                    title: 'Avg Price',
                    className: 'text-end',
                    render: function(data) {
                        return formatCurrency(data || 0);
                    }
                },
                // {
                //     data: 'last_sold_date',
                //     title: 'Date',
                //     render: function(data) {
                //         return data ? new Date(data).toLocaleDateString() : 'N/A';
                //     }
                // }
                {
                    data: 'last_sold_date',
                    title: 'Date',
                    render: function(data) {
                        if (!data) return 'N/A';
                        const date = new Date(data);
                        const day = String(date.getDate()).padStart(2, '0');
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const year = date.getFullYear();
                        return `${day}/${month}/${year}`;
                    }
                }
            ],
            responsive: true,
            searching: false, // Disable search/filter
            paging: false, // Disable pagination
            order: [
                [3, 'desc']
            ], // Keep sorting by Quantity (descending)
            dom: 'rt', // Only show table (t) and responsive features (r)
            language: {
                emptyTable: 'No product data available for the selected period',
                zeroRecords: 'No matching products found'
            },
            initComplete: function() {
                document.getElementById('exportDropdown').disabled = false;
            }
        });
    }

    function initializeProductBillsTable(billsData) {
        console.log(billsData);
        if (productBillsTable) {
            productBillsTable.destroy();
            $('#productBillsTable tbody').empty();
        }

        productBillsTable = $('#productBillsTable').DataTable({
            data: billsData.bills || [],
            columns: [{
                    data: 'id',
                    title: 'Bill ID'
                },
                {
                    data: 'shop_name',
                    title: 'Shop Name',
                    render: function(data, type, row) {
                        return data || 'N/A';
                    }
                },
                {
                    data: 'total_amount',
                    title: 'Total Amount',
                    className: 'text-end',
                    render: function(data) {
                        return formatCurrency(data || 0);
                    }
                },
                {
                    data: 'payable_amount',
                    title: 'Payable Amount',
                    className: 'text-end',
                    render: function(data) {
                        return formatCurrency(data || 0);
                    }
                },
                {
                    data: 'dues',
                    title: 'Due Amount',
                    className: 'text-end',
                    render: function(data, type, row) {
                        return formatCurrency(data || row.total_amount || 0);
                    }
                },
                // {
                //     data: 'created_at',
                //     title: 'Date',
                //     render: function(data) {
                //         return data ? new Date(data).toLocaleDateString() : 'N/A';
                //     }
                // }
                {
                    data: 'created_at',
                    title: 'Date',
                    render: function(data) {
                        if (!data) return 'N/A';
                        const date = new Date(data);
                        const day = String(date.getDate()).padStart(2, '0');
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const year = date.getFullYear();
                        return `${day}/${month}/${year}`;
                    }
                }
            ],
            responsive: true,
            searching: false,
            paging: false,
            order: [
                [0, 'desc']
            ],
            dom: 'rt',
            language: {
                emptyTable: 'No bill data available for the selected period',
                zeroRecords: 'No matching bills found'
            },
            initComplete: function() {
                document.getElementById('exportDropdown').disabled = false;
            }
        });
    }



    // async function exportToExcel() {
    //     console.log('Export to Excel triggered');

    //     if (!productSalesTable || !productBillsTable || !currentChartData || !currentChartData.labels || !currentChartData.profit || !currentChartData.sales) {
    //         displayMessage('Data not available. Please wait for data to load and try again.');
    //         return;
    //     }

    //     // Capture chart as image
    //     let chartImageUrl = null;
    //     try {
    //         const chartCanvas = document.getElementById('profitLossChart');
    //         if (chartCanvas) {
    //             const canvas = await html2canvas(chartCanvas, {
    //                 scale: 2
    //             });
    //             chartImageUrl = canvas.toDataURL('image/png');
    //         }
    //     } catch (error) {
    //         console.error('Error capturing chart for Excel:', error);
    //         displayMessage('Failed to capture chart image for Excel.');
    //     }

    //     // Create workbook
    //     const workbook = new ExcelJS.Workbook();
    //     workbook.created = new Date();
    //     workbook.modified = new Date();

    //     // 🟦 Instructions Sheet
    //     const instructionsSheet = workbook.addWorksheet('Instructions');
    //     instructionsSheet.columns = [{
    //         header: 'Instruction',
    //         key: 'instruction',
    //         width: 80
    //     }];
    //     const {
    //         heading
    //     } = generateFileInfo('xlsx');
    //     instructionsSheet.addRows([{
    //             instruction: heading
    //         },
    //         {
    //             instruction: 'This Excel file contains chart, stats, product sales, and product bills data.'
    //         },
    //         {
    //             instruction: 'The chart is embedded in the "Chart & Stats" sheet.'
    //         }
    //     ]);
    //     instructionsSheet.getRow(1).font = {
    //         bold: true,
    //         color: {
    //             argb: 'FFFFFFFF'
    //         }
    //     };
    //     instructionsSheet.getRow(1).fill = {
    //         type: 'pattern',
    //         pattern: 'solid',
    //         fgColor: {
    //             argb: 'FF344767'
    //         }
    //     };

    //     // 🟢 Chart & Stats Sheet
    //     const chartSheet = workbook.addWorksheet('Chart & Stats');

    //     // Add chart image inside Excel (if available)
    //     if (chartImageUrl) {
    //         const imageId = workbook.addImage({
    //             base64: chartImageUrl,
    //             extension: 'png',
    //         });

    //         chartSheet.addImage(imageId, {
    //             tl: {
    //                 col: 4,
    //                 row: 4
    //             },
    //             ext: {
    //                 width: 700,
    //                 height: 350
    //             }
    //         });
    //     }

    //     // Leave space under image
    //     chartSheet.addRow([]);
    //     chartSheet.addRow([]);

    //     // Add Summary stats below chart
    //     chartSheet.addRow(['Metric', 'Value']);
    //     chartSheet.getRow(chartSheet.lastRow.number).font = {
    //         bold: true,
    //         color: {
    //             argb: 'FFFFFFFF'
    //         }
    //     };
    //     chartSheet.getRow(chartSheet.lastRow.number).fill = {
    //         type: 'pattern',
    //         pattern: 'solid',
    //         fgColor: {
    //             argb: 'FF344767'
    //         }
    //     };

    //     chartSheet.addRows([
    //         ['Total Profit', document.getElementById('totalProfit')?.textContent || 'N/A'],
    //         ['Total Sales', formatCurrency(sum(currentChartData.sales) || 0)],
    //         ['Total Products Sold', productSalesTable.data().toArray().reduce((sum, row) => sum + (parseInt(row.total_quantity) || 0), 0)],
    //         ['Total Due', formatCurrency(productBillsTable.data().toArray().reduce((sum, row) => sum + (parseFloat(row.dues || row.total_amount) || 0), 0))],
    //         ['Generated On', new Date().toLocaleString('en-IN')],
    //     ]);

    //     chartSheet.columns = [{
    //         width: 25
    //     }, {
    //         width: 35
    //     }];

    //     // 🟡 Chart Data Sheet
    //     const dataSheet = workbook.addWorksheet('Chart Data');
    //     dataSheet.columns = [{
    //             header: 'Date',
    //             key: 'date',
    //             width: 15
    //         },
    //         {
    //             header: 'Profit',
    //             key: 'profit',
    //             width: 15
    //         },
    //         {
    //             header: 'Sales',
    //             key: 'sales',
    //             width: 15
    //         }
    //     ];

    //     currentChartData.labels.forEach((label, index) => {
    //         dataSheet.addRow({
    //             date: label,
    //             profit: currentChartData.profit[index] || 0,
    //             sales: currentChartData.sales[index] || 0
    //         });
    //     });

    //     dataSheet.getRow(1).font = {
    //         bold: true,
    //         color: {
    //             argb: 'FFFFFFFF'
    //         }
    //     };
    //     dataSheet.getRow(1).fill = {
    //         type: 'pattern',
    //         pattern: 'solid',
    //         fgColor: {
    //             argb: 'FF344767'
    //         }
    //     };

    //     // 🟣 Product Sales Sheet
    //     const productSheet = workbook.addWorksheet('Product Sales');
    //     productSheet.columns = [{
    //             header: 'Product ID',
    //             key: 'id',
    //             width: 10
    //         },
    //         {
    //             header: 'Name',
    //             key: 'name',
    //             width: 20
    //         },
    //         {
    //             header: 'Category',
    //             key: 'category',
    //             width: 15
    //         },
    //         {
    //             header: 'Quantity Sold',
    //             key: 'quantity',
    //             width: 12
    //         },
    //         {
    //             header: 'Unit Price',
    //             key: 'unit_price',
    //             width: 12
    //         },
    //         {
    //             header: 'Date Sold',
    //             key: 'date_sold',
    //             width: 15
    //         }
    //     ];

    //     productSalesTable.data().toArray().forEach(row => {
    //         productSheet.addRow({
    //             id: row.id || '',
    //             name: row.name || 'N/A',
    //             category: row.category_name || 'N/A',
    //             quantity: row.total_quantity || 0,
    //             unit_price: row.unit_price || 0,
    //             date_sold: row.last_sold_date ? new Date(row.last_sold_date).toLocaleDateString() : 'N/A'
    //         });
    //     });

    //     productSheet.getRow(1).font = {
    //         bold: true,
    //         color: {
    //             argb: 'FFFFFFFF'
    //         }
    //     };
    //     productSheet.getRow(1).fill = {
    //         type: 'pattern',
    //         pattern: 'solid',
    //         fgColor: {
    //             argb: 'FF344767'
    //         }
    //     };

    //     // 🟠 Product Bills Sheet
    //     const billsSheet = workbook.addWorksheet('Product Bills');
    //     billsSheet.columns = [{
    //             header: 'Bill ID',
    //             key: 'id',
    //             width: 10
    //         },
    //         {
    //             header: 'Shop Name',
    //             key: 'shop_name',
    //             width: 20
    //         },
    //         {
    //             header: 'Total Amount',
    //             key: 'total_amount',
    //             width: 15
    //         },
    //         {
    //             header: 'Payable Amount',
    //             key: 'payable_amount',
    //             width: 15
    //         },
    //         {
    //             header: 'Due Amount',
    //             key: 'due_amount',
    //             width: 15
    //         },
    //         {
    //             header: 'Date Sold',
    //             key: 'date_sold',
    //             width: 15
    //         }
    //     ];

    //     productBillsTable.data().toArray().forEach(row => {
    //         billsSheet.addRow({
    //             id: row.id || '',
    //             shop_name: row.shop_name || 'N/A',
    //             total_amount: row.total_amount || 0,
    //             payable_amount: row.payable_amount || 0,
    //             due_amount: row.dues || row.total_amount || 0,
    //             date_sold: row.created_at ? new Date(row.created_at).toLocaleDateString() : 'N/A'
    //         });
    //     });

    //     billsSheet.getRow(1).font = {
    //         bold: true,
    //         color: {
    //             argb: 'FFFFFFFF'
    //         }
    //     };
    //     billsSheet.getRow(1).fill = {
    //         type: 'pattern',
    //         pattern: 'solid',
    //         fgColor: {
    //             argb: 'FF344767'
    //         }
    //     };

    //     // 🟠 Generate Excel file
    //     try {
    //         const buffer = await workbook.xlsx.writeBuffer();
    //         const blob = new Blob([buffer], {
    //             type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    //         });

    //         const {
    //             filename
    //         } = generateFileInfo('xlsx');
    //         const link = document.createElement('a');
    //         link.href = URL.createObjectURL(blob);
    //         link.download = filename;
    //         link.click();
    //         URL.revokeObjectURL(link.href);

    //         displayMessage(`Excel exported successfully as "${filename}"!`, 'success');
    //     } catch (error) {
    //         console.error('Error writing Excel file:', error);
    //         displayMessage('Failed to export to Excel. Please try again.');
    //     }
    // }

    async function exportToExcel() {
        console.log('Export to Excel triggered');

        if (!productSalesTable || !productBillsTable || !currentChartData || !currentChartData.labels || !currentChartData.profit || !currentChartData.sales) {
            displayMessage('Data not available. Please wait for data to load and try again.');
            return;
        }

        // Capture chart as image
        let chartImageUrl = null;
        try {
            const chartCanvas = document.getElementById('profitLossChart');
            if (chartCanvas) {
                const canvas = await html2canvas(chartCanvas, {
                    scale: 2
                });
                chartImageUrl = canvas.toDataURL('image/png');
            }
        } catch (error) {
            console.error('Error capturing chart for Excel:', error);
            displayMessage('Failed to capture chart image for Excel.');
        }

        // Create workbook
        const workbook = new ExcelJS.Workbook();
        workbook.created = new Date();
        workbook.modified = new Date();

        // 🟦 Instructions Sheet
        const instructionsSheet = workbook.addWorksheet('Instructions');
        instructionsSheet.columns = [{
            header: 'Instruction',
            key: 'instruction',
            width: 80
        }];
        const {
            heading
        } = generateFileInfo('xlsx');
        instructionsSheet.addRows([{
                instruction: heading
            },
            {
                instruction: 'This Excel file contains chart, stats, product sales, and product bills data.'
            },
            {
                instruction: 'The chart is embedded in the "Chart & Stats" sheet.'
            }
        ]);
        instructionsSheet.getRow(1).font = {
            bold: true,
            color: {
                argb: 'FFFFFFFF'
            }
        };
        instructionsSheet.getRow(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: {
                argb: 'FF344767'
            }
        };

        // 🟢 Chart & Stats Sheet
        const chartSheet = workbook.addWorksheet('Chart & Stats');

        // Add chart image inside Excel (if available)
        if (chartImageUrl) {
            const imageId = workbook.addImage({
                base64: chartImageUrl,
                extension: 'png',
            });

            chartSheet.addImage(imageId, {
                tl: {
                    col: 4,
                    row: 4
                },
                ext: {
                    width: 700,
                    height: 350
                }
            });
        }

        // Leave space under image
        chartSheet.addRow([]);
        chartSheet.addRow([]);

        // Add Summary stats below chart
        chartSheet.addRow(['Metric', 'Value']);
        chartSheet.getRow(chartSheet.lastRow.number).font = {
            bold: true,
            color: {
                argb: 'FFFFFFFF'
            }
        };
        chartSheet.getRow(chartSheet.lastRow.number).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: {
                argb: 'FF344767'
            }
        };

        // Format date in d/m/y for Generated On
        const generatedDate = new Date();
        const formattedDate = `${generatedDate.getDate()}/${generatedDate.getMonth() + 1}/${generatedDate.getFullYear() % 100}`;

        chartSheet.addRows([
            ['Total Profit', document.getElementById('totalProfit')?.textContent || 'N/A'],
            ['Total Sales', formatCurrency(sum(currentChartData.sales) || 0)],
            ['Total Products Sold', productSalesTable.data().toArray().reduce((sum, row) => sum + (parseInt(row.total_quantity) || 0), 0)],
            ['Total Due', formatCurrency(productBillsTable.data().toArray().reduce((sum, row) => sum + (parseFloat(row.dues || row.total_amount) || 0), 0))],
            ['Generated On', formattedDate],
        ]);

        chartSheet.columns = [{
            width: 25
        }, {
            width: 35
        }];

        // 🟡 Chart Data Sheet
        const dataSheet = workbook.addWorksheet('Chart Data');
        dataSheet.columns = [{
                header: 'Date',
                key: 'date',
                width: 15
            },
            {
                header: 'Profit',
                key: 'profit',
                width: 15
            },
            {
                header: 'Sales',
                key: 'sales',
                width: 15
            }
        ];

        currentChartData.labels.forEach((label, index) => {
            // Assuming labels are already in a parseable date format, convert to d/m/y
            let formattedLabel = label;
            try {
                const date = new Date(label);
                if (!isNaN(date)) {
                    formattedLabel = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear() % 100}`;
                }
            } catch (e) {
                console.warn(`Could not parse date: ${label}`);
            }
            dataSheet.addRow({
                date: formattedLabel,
                profit: currentChartData.profit[index] || 0,
                sales: currentChartData.sales[index] || 0
            });
        });

        dataSheet.getRow(1).font = {
            bold: true,
            color: {
                argb: 'FFFFFFFF'
            }
        };
        dataSheet.getRow(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: {
                argb: 'FF344767'
            }
        };

        // 🟣 Product Sales Sheet
        const productSheet = workbook.addWorksheet('Product Sales');
        productSheet.columns = [{
                header: 'Product ID',
                key: 'id',
                width: 10
            },
            {
                header: 'Name',
                key: 'name',
                width: 20
            },
            {
                header: 'Category',
                key: 'category',
                width: 15
            },
            {
                header: 'Quantity Sold',
                key: 'quantity',
                width: 12
            },
            {
                header: 'Unit Price',
                key: 'unit_price',
                width: 12
            },
            {
                header: 'Date Sold',
                key: 'date_sold',
                width: 15
            }
        ];

        productSalesTable.data().toArray().forEach(row => {
            let formattedDate = 'N/A';
            if (row.last_sold_date) {
                try {
                    const date = new Date(row.last_sold_date);
                    if (!isNaN(date)) {
                        formattedDate = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear() % 100}`;
                    }
                } catch (e) {
                    console.warn(`Could not parse product sale date: ${row.last_sold_date}`);
                }
            }
            productSheet.addRow({
                id: row.id || '',
                name: row.name || 'N/A',
                category: row.category_name || 'N/A',
                quantity: row.total_quantity || 0,
                unit_price: row.unit_price || 0,
                date_sold: formattedDate
            });
        });

        productSheet.getRow(1).font = {
            bold: true,
            color: {
                argb: 'FFFFFFFF'
            }
        };
        productSheet.getRow(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: {
                argb: 'FF344767'
            }
        };

        // 🟠 Product Bills Sheet
        const billsSheet = workbook.addWorksheet('Product Bills');
        billsSheet.columns = [{
                header: 'Bill ID',
                key: 'id',
                width: 10
            },
            {
                header: 'Shop Name',
                key: 'shop_name',
                width: 20
            },
            {
                header: 'Total Amount',
                key: 'total_amount',
                width: 15
            },
            {
                header: 'Payable Amount',
                key: 'payable_amount',
                width: 15
            },
            {
                header: 'Due Amount',
                key: 'due_amount',
                width: 15
            },
            {
                header: 'Date Sold',
                key: 'date_sold',
                width: 15
            }
        ];

        productBillsTable.data().toArray().forEach(row => {
            let formattedDate = 'N/A';
            if (row.created_at) {
                try {
                    const date = new Date(row.created_at);
                    if (!isNaN(date)) {
                        formattedDate = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear() % 100}`;
                    }
                } catch (e) {
                    console.warn(`Could not parse bill date: ${row.created_at}`);
                }
            }
            billsSheet.addRow({
                id: row.id || '',
                shop_name: row.shop_name || 'N/A',
                total_amount: row.total_amount || 0,
                payable_amount: row.payable_amount || 0,
                due_amount: row.dues || row.total_amount || 0,
                date_sold: formattedDate
            });
        });

        billsSheet.getRow(1).font = {
            bold: true,
            color: {
                argb: 'FFFFFFFF'
            }
        };
        billsSheet.getRow(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: {
                argb: 'FF344767'
            }
        };

        // 🟠 Generate Excel file
        try {
            const buffer = await workbook.xlsx.writeBuffer();
            const blob = new Blob([buffer], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });

            const {
                filename
            } = generateFileInfo('xlsx');
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = filename;
            link.click();
            URL.revokeObjectURL(link.href);

            displayMessage(`Excel exported successfully as "${filename}"!`, 'success');
        } catch (error) {
            console.error('Error writing Excel file:', error);
            displayMessage('Failed to export to Excel. Please try again.');
        }
    }

    // async function exportToDocx() {
    //     console.log('Export to DOCX triggered');

    //     if (!productSalesTable || !currentChartData || !currentChartData.labels) {
    //         displayMessage('Data not available. Please wait for data to load and try again.');
    //         return;
    //     }

    //     const {
    //         Document,
    //         Packer,
    //         Paragraph,
    //         Table,
    //         TableRow,
    //         TableCell,
    //         TextRun,
    //         AlignmentType,
    //         WidthType,
    //         ImageRun
    //     } = window.docx;

    //     // 🖼 Capture chart as image
    //     let chartImage = null;
    //     try {
    //         const chartCanvas = document.getElementById('profitLossChart');
    //         if (chartCanvas) {
    //             const canvas = await html2canvas(chartCanvas, {
    //                 scale: 2
    //             });
    //             chartImage = canvas.toDataURL('image/png');
    //         }
    //     } catch (err) {
    //         console.error('Error capturing chart image for DOCX:', err);
    //         displayMessage('Failed to capture chart image for DOCX.');
    //     }

    //     // 🟢 Title
    //     const {
    //         heading
    //     } = generateFileInfo('docx');
    //     const title = new Paragraph({
    //         children: [new TextRun({
    //             text: heading,
    //             bold: true,
    //             size: 32
    //         })],
    //         alignment: AlignmentType.CENTER,
    //         spacing: {
    //             after: 400
    //         }
    //     });

    //     // 📊 Add chart image
    //     const chartImagePara = chartImage ?
    //         new Paragraph({
    //             children: [
    //                 new ImageRun({
    //                     data: await fetch(chartImage).then(res => res.blob()),
    //                     transformation: {
    //                         width: 600,
    //                         height: 300
    //                     }
    //                 })
    //             ],
    //             alignment: AlignmentType.CENTER
    //         }) :
    //         new Paragraph({
    //             text: 'Chart not available.',
    //             alignment: AlignmentType.CENTER
    //         });

    //     // 📈 Summary table
    //     const summaryRows = [
    //         new TableRow({
    //             children: [
    //                 new TableCell({
    //                     children: [new Paragraph({
    //                         text: 'Metric',
    //                         bold: true
    //                     })]
    //                 }),
    //                 new TableCell({
    //                     children: [new Paragraph({
    //                         text: 'Value',
    //                         bold: true
    //                     })]
    //                 })
    //             ]
    //         }),
    //         new TableRow({
    //             children: [
    //                 new TableCell({
    //                     children: [new Paragraph('Total Profit')]
    //                 }),
    //                 new TableCell({
    //                     children: [new Paragraph(document.getElementById('totalProfit')?.textContent || 'N/A')]
    //                 })
    //             ]
    //         }),
    //         new TableRow({
    //             children: [
    //                 new TableCell({
    //                     children: [new Paragraph('Total Sales')]
    //                 }),
    //                 new TableCell({
    //                     children: [new Paragraph(formatCurrency(sum(currentChartData.sales) || 0))]
    //                 })
    //             ]
    //         }),
    //         new TableRow({
    //             children: [
    //                 new TableCell({
    //                     children: [new Paragraph('Total Products Sold')]
    //                 }),
    //                 new TableCell({
    //                     children: [new Paragraph(String(productSalesTable.data().toArray().reduce((s, r) => s + (parseInt(r.total_quantity) || 0), 0)))]
    //                 })
    //             ]
    //         }),
    //         new TableRow({
    //             children: [
    //                 new TableCell({
    //                     children: [new Paragraph('Generated On')]
    //                 }),
    //                 new TableCell({
    //                     children: [new Paragraph(new Date().toLocaleString('en-IN'))]
    //                 })
    //             ]
    //         }),
    //     ];

    //     const summaryTable = new Table({
    //         rows: summaryRows,
    //         width: {
    //             size: 100,
    //             type: WidthType.PERCENTAGE
    //         },
    //         alignment: AlignmentType.CENTER,
    //     });

    //     // 🟡 Chart Data Table
    //     const chartDataRows = [
    //         new TableRow({
    //             children: [
    //                 new TableCell({
    //                     children: [new Paragraph({
    //                         text: 'Date',
    //                         bold: true
    //                     })]
    //                 }),
    //                 new TableCell({
    //                     children: [new Paragraph({
    //                         text: 'Profit',
    //                         bold: true
    //                     })]
    //                 }),
    //                 new TableCell({
    //                     children: [new Paragraph({
    //                         text: 'Sales',
    //                         bold: true
    //                     })]
    //                 })
    //             ]
    //         }),
    //         ...currentChartData.labels.map((label, index) =>
    //             new TableRow({
    //                 children: [
    //                     new TableCell({
    //                         children: [new Paragraph(label)]
    //                     }),
    //                     new TableCell({
    //                         children: [new Paragraph(String(currentChartData.profit[index] || 0))]
    //                     }),
    //                     new TableCell({
    //                         children: [new Paragraph(String(currentChartData.sales[index] || 0))]
    //                     }),
    //                 ]
    //             })
    //         )
    //     ];

    //     const chartDataTable = new Table({
    //         rows: chartDataRows,
    //         width: {
    //             size: 100,
    //             type: WidthType.PERCENTAGE
    //         },
    //     });

    //     // 🟣 Product Sales Table
    //     const productData = productSalesTable.data().toArray();
    //     const productRows = [
    //         new TableRow({
    //             children: [
    //                 'Product ID', 'Name', 'Category', 'Quantity Sold', 'Unit Price', 'Total Revenue', 'Date Sold'
    //             ].map(h => new TableCell({
    //                 children: [new Paragraph({
    //                     text: h,
    //                     bold: true
    //                 })]
    //             }))
    //         }),
    //         ...productData.map(row =>
    //             new TableRow({
    //                 children: [
    //                     new TableCell({
    //                         children: [new Paragraph(String(row.id || ''))]
    //                     }),
    //                     new TableCell({
    //                         children: [new Paragraph(row.name || 'N/A')]
    //                     }),
    //                     new TableCell({
    //                         children: [new Paragraph(row.category || 'N/A')]
    //                     }),
    //                     new TableCell({
    //                         children: [new Paragraph(String(row.total_quantity || 0))]
    //                     }),
    //                     new TableCell({
    //                         children: [new Paragraph(String(row.unit_price || 0))]
    //                     }),
    //                     new TableCell({
    //                         children: [new Paragraph(String(row.total_sales || 0))]
    //                     }),
    //                     new TableCell({
    //                         children: [new Paragraph(row.last_sold ? new Date(row.last_sold).toLocaleDateString() : 'N/A')]
    //                     }),
    //                 ]
    //             })
    //         )
    //     ];

    //     const productTable = new Table({
    //         rows: productRows,
    //         width: {
    //             size: 100,
    //             type: WidthType.PERCENTAGE
    //         },
    //     });

    //     const billData = productBillsTable.data().toArray();
    //     const billRows = [
    //         new TableRow({
    //             children: [
    //                 'Bill ID', 'Shop Name', 'Total Amount', 'Payable Amount', 'Due Amount', 'Date Sold'
    //             ].map(h => new TableCell({
    //                 children: [new Paragraph({
    //                     text: h,
    //                     bold: true
    //                 })]
    //             }))
    //         }),
    //         ...billData.map(row =>
    //             new TableRow({
    //                 children: [
    //                     new TableCell({
    //                         children: [new Paragraph(String(row.id || ''))]
    //                     }),
    //                     new TableCell({
    //                         children: [new Paragraph(row.shop_name || 'N/A')]
    //                     }),
    //                     new TableCell({
    //                         children: [new Paragraph(formatCurrency(row.total_amount || 0))]
    //                     }),
    //                     new TableCell({
    //                         children: [new Paragraph(formatCurrency(row.payable_amount || 0))]
    //                     }),
    //                     new TableCell({
    //                         children: [new Paragraph(formatCurrency(row.dues || row.payable_amount || 0))]
    //                     }),
    //                     new TableCell({
    //                         children: [new Paragraph(row.created_at ? new Date(row.created_at).toLocaleDateString() : 'N/A')]
    //                     }),
    //                 ]
    //             })
    //         )
    //     ];

    //     const billTable = new Table({
    //         rows: billRows,
    //         width: {
    //             size: 100,
    //             type: WidthType.PERCENTAGE
    //         },
    //     });



    //     // 🧾 Build document
    //     const doc = new Document({
    //         sections: [{
    //             children: [
    //                 title,
    //                 chartImagePara,
    //                 new Paragraph({
    //                     text: 'Summary',
    //                     spacing: {
    //                         before: 400,
    //                         after: 200
    //                     },
    //                     bold: true
    //                 }),
    //                 summaryTable,
    //                 new Paragraph({
    //                     text: 'Chart Data',
    //                     spacing: {
    //                         before: 400,
    //                         after: 200
    //                     },
    //                     bold: true
    //                 }),
    //                 chartDataTable,
    //                 new Paragraph({
    //                     text: 'Product Sales',
    //                     spacing: {
    //                         before: 400,
    //                         after: 200
    //                     },
    //                     bold: true
    //                 }),
    //                 productTable,
    //                 new Paragraph({
    //                     text: 'Product Bills',
    //                     spacing: {
    //                         before: 400,
    //                         after: 200
    //                     },
    //                     bold: true
    //                 }),
    //                 billTable
    //             ]
    //         }]
    //     });

    //     // 📦 Save DOCX file
    //     const {
    //         filename
    //     } = generateFileInfo('docx');
    //     const blob = await Packer.toBlob(doc);
    //     saveAs(blob, filename);
    //     displayMessage(`DOCX exported successfully as "${filename}"!`, 'success');
    // }

    async function exportToDocx() {
        console.log('Export to DOCX triggered');

        if (!productSalesTable || !currentChartData || !currentChartData.labels) {
            displayMessage('Data not available. Please wait for data to load and try again.');
            return;
        }

        const {
            Document,
            Packer,
            Paragraph,
            Table,
            TableRow,
            TableCell,
            TextRun,
            AlignmentType,
            WidthType,
            ImageRun
        } = window.docx;

        // 🖼 Capture chart as image
        let chartImage = null;
        try {
            const chartCanvas = document.getElementById('profitLossChart');
            if (chartCanvas) {
                const canvas = await html2canvas(chartCanvas, {
                    scale: 2
                });
                chartImage = canvas.toDataURL('image/png');
            }
        } catch (err) {
            console.error('Error capturing chart image for DOCX:', err);
            displayMessage('Failed to capture chart image for DOCX.');
        }

        // 🟢 Title
        const {
            heading
        } = generateFileInfo('docx');
        const title = new Paragraph({
            children: [new TextRun({
                text: heading,
                bold: true,
                size: 32
            })],
            alignment: AlignmentType.CENTER,
            spacing: {
                after: 400
            }
        });

        // 📊 Add chart image
        const chartImagePara = chartImage ?
            new Paragraph({
                children: [
                    new ImageRun({
                        data: await fetch(chartImage).then(res => res.blob()),
                        transformation: {
                            width: 600,
                            height: 300
                        }
                    })
                ],
                alignment: AlignmentType.CENTER
            }) :
            new Paragraph({
                text: 'Chart not available.',
                alignment: AlignmentType.CENTER
            });

        // 📈 Summary table
        const generatedDate = new Date();
        const formattedGeneratedDate = `${generatedDate.getDate()}/${generatedDate.getMonth() + 1}/${generatedDate.getFullYear() % 100}`;

        const summaryRows = [
            new TableRow({
                children: [
                    new TableCell({
                        children: [new Paragraph({
                            text: 'Metric',
                            bold: true
                        })]
                    }),
                    new TableCell({
                        children: [new Paragraph({
                            text: 'Value',
                            bold: true
                        })]
                    })
                ]
            }),
            new TableRow({
                children: [
                    new TableCell({
                        children: [new Paragraph('Total Profit')]
                    }),
                    new TableCell({
                        children: [new Paragraph(document.getElementById('totalProfit')?.textContent || 'N/A')]
                    })
                ]
            }),
            new TableRow({
                children: [
                    new TableCell({
                        children: [new Paragraph('Total Sales')]
                    }),
                    new TableCell({
                        children: [new Paragraph(formatCurrency(sum(currentChartData.sales) || 0))]
                    })
                ]
            }),
            new TableRow({
                children: [
                    new TableCell({
                        children: [new Paragraph('Total Products Sold')]
                    }),
                    new TableCell({
                        children: [new Paragraph(String(productSalesTable.data().toArray().reduce((s, r) => s + (parseInt(r.total_quantity) || 0), 0)))]
                    })
                ]
            }),
            new TableRow({
                children: [
                    new TableCell({
                        children: [new Paragraph('Generated On')]
                    }),
                    new TableCell({
                        children: [new Paragraph(formattedGeneratedDate)]
                    })
                ]
            }),
        ];

        const summaryTable = new Table({
            rows: summaryRows,
            width: {
                size: 100,
                type: WidthType.PERCENTAGE
            },
            alignment: AlignmentType.CENTER,
        });

        // 🟡 Chart Data Table
        const chartDataRows = [
            new TableRow({
                children: [
                    new TableCell({
                        children: [new Paragraph({
                            text: 'Date',
                            bold: true
                        })]
                    }),
                    new TableCell({
                        children: [new Paragraph({
                            text: 'Profit',
                            bold: true
                        })]
                    }),
                    new TableCell({
                        children: [new Paragraph({
                            text: 'Sales',
                            bold: true
                        })]
                    })
                ]
            }),
            ...currentChartData.labels.map((label, index) => {
                let formattedLabel = label;
                try {
                    const date = new Date(label);
                    if (!isNaN(date)) {
                        formattedLabel = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear() % 100}`;
                    }
                } catch (e) {
                    console.warn(`Could not parse chart data date: ${label}`);
                }
                return new TableRow({
                    children: [
                        new TableCell({
                            children: [new Paragraph(formattedLabel)]
                        }),
                        new TableCell({
                            children: [new Paragraph(String(currentChartData.profit[index] || 0))]
                        }),
                        new TableCell({
                            children: [new Paragraph(String(currentChartData.sales[index] || 0))]
                        }),
                    ]
                });
            })
        ];

        const chartDataTable = new Table({
            rows: chartDataRows,
            width: {
                size: 100,
                type: WidthType.PERCENTAGE
            },
        });

        // 🟣 Product Sales Table
        const productData = productSalesTable.data().toArray();
        const productRows = [
            new TableRow({
                children: [
                    'Product ID', 'Name', 'Category', 'Quantity Sold', 'Unit Price', 'Total Revenue', 'Date Sold'
                ].map(h => new TableCell({
                    children: [new Paragraph({
                        text: h,
                        bold: true
                    })]
                }))
            }),
            ...productData.map(row => {
                let formattedDate = 'N/A';
                if (row.last_sold_date) {
                    try {
                        const date = new Date(row.last_sold_date);
                        if (!isNaN(date)) {
                            formattedDate = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear() % 100}`;
                        }
                    } catch (e) {
                        console.warn(`Could not parse product sale date: ${row.last_sold}`);
                    }
                }
                return new TableRow({
                    children: [
                        new TableCell({
                            children: [new Paragraph(String(row.id || ''))]
                        }),
                        new TableCell({
                            children: [new Paragraph(row.name || 'N/A')]
                        }),
                        new TableCell({
                            children: [new Paragraph(row.category_name || 'N/A')]
                        }),
                        new TableCell({
                            children: [new Paragraph(String(row.total_quantity || 0))]
                        }),
                        new TableCell({
                            children: [new Paragraph(String(row.unit_price || 0))]
                        }),
                        new TableCell({
                            children: [new Paragraph(String(row.total_sales || 0))]
                        }),
                        new TableCell({
                            children: [new Paragraph(formattedDate)]
                        }),
                    ]
                });
            })
        ];

        const productTable = new Table({
            rows: productRows,
            width: {
                size: 100,
                type: WidthType.PERCENTAGE
            },
        });

        // 🟠 Product Bills Table
        const billData = productBillsTable.data().toArray();
        const billRows = [
            new TableRow({
                children: [
                    'Bill ID', 'Shop Name', 'Total Amount', 'Payable Amount', 'Due Amount', 'Date Sold'
                ].map(h => new TableCell({
                    children: [new Paragraph({
                        text: h,
                        bold: true
                    })]
                }))
            }),
            ...billData.map(row => {
                let formattedDate = 'N/A';
                if (row.created_at) {
                    try {
                        const date = new Date(row.created_at);
                        if (!isNaN(date)) {
                            formattedDate = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear() % 100}`;
                        }
                    } catch (e) {
                        console.warn(`Could not parse bill date: ${row.created_at}`);
                    }
                }
                return new TableRow({
                    children: [
                        new TableCell({
                            children: [new Paragraph(String(row.id || ''))]
                        }),
                        new TableCell({
                            children: [new Paragraph(row.shop_name || 'N/A')]
                        }),
                        new TableCell({
                            children: [new Paragraph(formatCurrency(row.total_amount || 0))]
                        }),
                        new TableCell({
                            children: [new Paragraph(formatCurrency(row.payable_amount || 0))]
                        }),
                        new TableCell({
                            children: [new Paragraph(formatCurrency(row.dues || row.payable_amount || 0))]
                        }),
                        new TableCell({
                            children: [new Paragraph(formattedDate)]
                        }),
                    ]
                });
            })
        ];

        const billTable = new Table({
            rows: billRows,
            width: {
                size: 100,
                type: WidthType.PERCENTAGE
            },
        });

        // 🧾 Build document
        const doc = new Document({
            sections: [{
                children: [
                    title,
                    chartImagePara,
                    new Paragraph({
                        text: 'Summary',
                        spacing: {
                            before: 400,
                            after: 200
                        },
                        bold: true
                    }),
                    summaryTable,
                    new Paragraph({
                        text: 'Chart Data',
                        spacing: {
                            before: 400,
                            after: 200
                        },
                        bold: true
                    }),
                    chartDataTable,
                    new Paragraph({
                        text: 'Product Sales',
                        spacing: {
                            before: 400,
                            after: 200
                        },
                        bold: true
                    }),
                    productTable,
                    new Paragraph({
                        text: 'Product Bills',
                        spacing: {
                            before: 400,
                            after: 200
                        },
                        bold: true
                    }),
                    billTable
                ]
            }]
        });

        // 📦 Save DOCX file
        const {
            filename
        } = generateFileInfo('docx');
        const blob = await Packer.toBlob(doc);
        saveAs(blob, filename);
        displayMessage(`DOCX exported successfully as "${filename}"!`, 'success');
    }

    // Export to PDF

    // async function exportToPDF() {
    //     console.log('Export to PDF triggered');
    //     if (!productSalesTable || !productBillsTable || !currentChartData) {
    //         displayMessage('Data not available. Please wait for data to load and try again.');
    //         return;
    //     }

    //     try {
    //         const tableData = productSalesTable.data().toArray();
    //         const billData = productBillsTable.data().toArray();
    //         const chartCanvas = document.getElementById('profitLossChart');
    //         let chartImage = null;

    //         try {
    //             if (chartCanvas) {
    //                 const canvas = await html2canvas(chartCanvas, {
    //                     scale: 2
    //                 });
    //                 chartImage = canvas.toDataURL('image/png');
    //             }
    //         } catch (error) {
    //             console.error('Error capturing chart:', error);
    //         }

    //         const chartData = currentChartData.labels.map((label, index) => [
    //             label,
    //             formatCurrency(currentChartData.profit[index] || 0),
    //             formatCurrency(currentChartData.sales[index] || 0)
    //         ]);

    //         const productData = tableData.map(row => [
    //             row.id || '',
    //             row.name || 'N/A',
    //             row.category_name || 'N/A',
    //             row.total_quantity || 0,
    //             formatCurrency(row.unit_price || 0),
    //             row.last_sold_date ? new Date(row.last_sold_date).toLocaleDateString() : 'N/A'
    //         ]);


    //         const billDataFormatted = billData.map(row => [
    //             row.id || '',
    //             row.shop_name || 'N/A',
    //             formatCurrency(row.total_amount || 0),
    //             formatCurrency(row.payable_amount || 0),
    //             formatCurrency(row.dues || row.payable_amount || 0),
    //             row.created_at ? new Date(row.created_at).toLocaleDateString() : 'N/A'
    //         ]);
    //         // console.log(billData);
    //         const {
    //             heading,
    //             filename
    //         } = generateFileInfo('pdf');
    //         const docDefinition = {
    //             pageSize: 'A4',
    //             pageOrientation: 'portrait',
    //             pageMargins: [40, 40, 40, 40],
    //             content: [{
    //                     text: `📊 ${heading}`,
    //                     style: 'header',
    //                     alignment: 'center',
    //                     margin: [0, 0, 0, 20]
    //                 },
    //                 ...(chartImage ? [{
    //                     image: chartImage,
    //                     width: 450,
    //                     alignment: 'center',
    //                     margin: [0, 0, 0, 20]
    //                 }] : []),
    //                 {
    //                     text: '📈 Profit & Sales Overview',
    //                     style: 'sectionHeader',
    //                     margin: [0, 10, 0, 10]
    //                 },
    //                 {
    //                     table: {
    //                         headerRows: 1,
    //                         widths: ['auto', '*', '*'],
    //                         body: [
    //                             [{
    //                                     text: 'Date',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 },
    //                                 {
    //                                     text: 'Profit (₹)',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 },
    //                                 {
    //                                     text: 'Sales (₹)',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 }
    //                             ],
    //                             ...chartData.map(row => [{
    //                                     text: row[0],
    //                                     alignment: 'center'
    //                                 },
    //                                 {
    //                                     text: row[1],
    //                                     alignment: 'right'
    //                                 },
    //                                 {
    //                                     text: row[2],
    //                                     alignment: 'right'
    //                                 }
    //                             ])
    //                         ]
    //                     },
    //                     layout: {
    //                         fillColor: (rowIndex) => rowIndex % 2 === 0 ? '#f8f8f8' : null,
    //                         hLineColor: () => '#CCCCCC',
    //                         vLineColor: () => '#CCCCCC',
    //                         paddingTop: () => 4,
    //                         paddingBottom: () => 4
    //                     },
    //                     margin: [0, 0, 0, 20]
    //                 },
    //                 {
    //                     text: '🛒 Product Sales Details',
    //                     style: 'sectionHeader',
    //                     margin: [0, 10, 0, 10]
    //                 },
    //                 {
    //                     table: {
    //                         headerRows: 1,
    //                         widths: ['auto', '*', '*', 'auto', 'auto', 'auto'],
    //                         body: [
    //                             [{
    //                                     text: 'ID',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 },
    //                                 {
    //                                     text: 'Name',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 },
    //                                 {
    //                                     text: 'Category',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 },
    //                                 {
    //                                     text: 'Quantity',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 },
    //                                 {
    //                                     text: 'Unit Price',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 },
    //                                 {
    //                                     text: 'Date',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 }
    //                             ],
    //                             ...productData.map(row => row.map((cell, idx) => ({
    //                                 text: cell,
    //                                 alignment: [0, 1, 2].includes(idx) ? 'left' : 'right',
    //                                 style: 'tableData'
    //                             })))
    //                         ]
    //                     },
    //                     layout: {
    //                         fillColor: (rowIndex) => rowIndex % 2 === 0 ? '#f8f8f8' : null,
    //                         hLineColor: () => '#CCCCCC',
    //                         vLineColor: () => '#CCCCCC',
    //                         paddingTop: () => 4,
    //                         paddingBottom: () => 4
    //                     },
    //                     margin: [0, 0, 0, 20]
    //                 },
    //                 {
    //                     text: '🧾 Product Bills Details',
    //                     style: 'sectionHeader',
    //                     margin: [0, 10, 0, 10]
    //                 },
    //                 {
    //                     table: {
    //                         headerRows: 1,
    //                         widths: ['auto', '*', 'auto', 'auto', 'auto', 'auto'], // Updated to include 6 columns
    //                         body: [
    //                             [{
    //                                     text: 'Bill ID',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 },
    //                                 {
    //                                     text: 'Shop Name',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 },
    //                                 {
    //                                     text: 'Total Amount',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 },
    //                                 {
    //                                     text: 'Payable Amount',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 },
    //                                 {
    //                                     text: 'Due Amount',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 },
    //                                 {
    //                                     text: 'Date',
    //                                     style: 'tableHeader',
    //                                     alignment: 'center'
    //                                 }
    //                             ],
    //                             ...billDataFormatted.map(row => row.map((cell, idx) => ({
    //                                 text: cell,
    //                                 alignment: [0, 1].includes(idx) ? 'left' : 'right',
    //                                 style: 'tableData'
    //                             })))
    //                         ]
    //                     },
    //                     layout: {
    //                         fillColor: (rowIndex) => rowIndex % 2 === 0 ? '#f8f8f8' : null,
    //                         hLineColor: () => '#CCCCCC',
    //                         vLineColor: () => '#CCCCCC',
    //                         paddingTop: () => 4,
    //                         paddingBottom: () => 4
    //                     },
    //                     margin: [0, 0, 0, 20]
    //                 },
    //                 {
    //                     text: '📌 Summary Stats',
    //                     style: 'sectionHeader',
    //                     margin: [0, 10, 0, 5]
    //                 },
    //                 {
    //                     columns: [{
    //                             text: `Total Profit: ${currentChartData.profit.reduce((a, b) => a + (parseFloat(b) || 0), 0).toFixed(2)}`,
    //                             style: 'stats'
    //                         },
    //                         {
    //                             text: `Total Sales: ${currentChartData.sales.reduce((a, b) => a + (parseFloat(b) || 0), 0).toFixed(2)}`,
    //                             style: 'stats'
    //                         },
    //                         {
    //                             text: `Total Products Sold: ${tableData.reduce((sum, row) => sum + (parseInt(row.total_quantity) || 0), 0)}`,
    //                             style: 'stats'
    //                         },
    //                         {
    //                             text: `Total Due: ${formatCurrency(billData.reduce((sum, row) => sum + (parseFloat(row.dues || row.total_amount) || 0), 0))}`,
    //                             style: 'stats'
    //                         }
    //                     ],
    //                     columnGap: 10,
    //                     margin: [0, 0, 0, 10]
    //                 }
    //             ],
    //             styles: {
    //                 header: {
    //                     fontSize: 20,
    //                     bold: true,
    //                     color: '#344767'
    //                 },
    //                 subheader: {
    //                     fontSize: 12,
    //                     color: '#7b809a'
    //                 },
    //                 sectionHeader: {
    //                     fontSize: 14,
    //                     bold: true,
    //                     color: '#344767',
    //                     margin: [0, 5, 0, 5]
    //                 },
    //                 tableHeader: {
    //                     bold: true,
    //                     fillColor: '#344767',
    //                     color: 'white',
    //                     fontSize: 10,
    //                     margin: [0, 5, 0, 5]
    //                 },
    //                 stats: {
    //                     fontSize: 11,
    //                     bold: true,
    //                     color: '#344767'
    //                 }
    //             },
    //             defaultStyle: {
    //                 fontSize: 10,
    //                 color: '#344767'
    //             }
    //         };

    //         pdfMake.createPdf(docDefinition).download(filename);

    //     } catch (error) {
    //         console.error('Error generating PDF:', error);
    //         displayMessage('Failed to generate PDF. Please try again.');
    //     }
    // }
    
    async function exportToPDF() {
    console.log('Export to PDF triggered');
    if (!productSalesTable || !productBillsTable || !currentChartData) {
        displayMessage('Data not available. Please wait for data to load and try again.');
        return;
    }

    try {
        const tableData = productSalesTable.data().toArray();
        const billData = productBillsTable.data().toArray();
        const chartCanvas = document.getElementById('profitLossChart');
        let chartImage = null;

        try {
            if (chartCanvas) {
                const canvas = await html2canvas(chartCanvas, {
                    scale: 2
                });
                chartImage = canvas.toDataURL('image/png');
            }
        } catch (error) {
            console.error('Error capturing chart:', error);
        }

        const chartData = currentChartData.labels.map((label, index) => {
            let formattedLabel = label;
            try {
                const date = new Date(label);
                if (!isNaN(date)) {
                    formattedLabel = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear() % 100}`;
                }
            } catch (e) {
                console.warn(`Could not parse chart data date: ${label}`);
            }
            return [
                formattedLabel,
                formatCurrency(currentChartData.profit[index] || 0),
                formatCurrency(currentChartData.sales[index] || 0)
            ];
        });

        const productData = tableData.map(row => {
            let formattedDate = 'N/A';
            if (row.last_sold_date) {
                try {
                    const date = new Date(row.last_sold_date);
                    if (!isNaN(date)) {
                        formattedDate = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear() % 100}`;
                    }
                } catch (e) {
                    console.warn(`Could not parse product sale date: ${row.last_sold_date}`);
                }
            }
            return [
                row.id || '',
                row.name || 'N/A',
                row.category_name || 'N/A',
                row.total_quantity || 0,
                formatCurrency(row.unit_price || 0),
                formattedDate
            ];
        });

        const billDataFormatted = billData.map(row => {
            let formattedDate = 'N/A';
            if (row.created_at) {
                try {
                    const date = new Date(row.created_at);
                    if (!isNaN(date)) {
                        formattedDate = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear() % 100}`;
                    }
                } catch (e) {
                    console.warn(`Could not parse bill date: ${row.created_at}`);
                }
            }
            return [
                row.id || '',
                row.shop_name || 'N/A',
                formatCurrency(row.total_amount || 0),
                formatCurrency(row.payable_amount || 0),
                formatCurrency(row.dues || row.payable_amount || 0),
                formattedDate
            ];
        });

        const {
            heading,
            filename
        } = generateFileInfo('pdf');
        const docDefinition = {
            pageSize: 'A4',
            pageOrientation: 'portrait',
            pageMargins: [40, 40, 40, 40],
            content: [{
                    text: `${heading}`,
                    style: 'header',
                    alignment: 'center',
                    margin: [0, 0, 0, 20]
                },
                ...(chartImage ? [{
                    image: chartImage,
                    width: 450,
                    alignment: 'center',
                    margin: [0, 0, 0, 20]
                }] : []),
                {
                    text: 'Profit & Sales Overview',
                    style: 'sectionHeader',
                    margin: [0, 10, 0, 10]
                },
                {
                    table: {
                        headerRows: 1,
                        widths: ['auto', '*', '*'],
                        body: [
                            [{
                                    text: 'Date',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                },
                                {
                                    text: 'Profit (₹)',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                },
                                {
                                    text: 'Sales (₹)',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                }
                            ],
                            ...chartData.map(row => [{
                                    text: row[0],
                                    alignment: 'center'
                                },
                                {
                                    text: row[1],
                                    alignment: 'right'
                                },
                                {
                                    text: row[2],
                                    alignment: 'right'
                                }
                            ])
                        ]
                    },
                    layout: {
                        fillColor: (rowIndex) => rowIndex % 2 === 0 ? '#f8f8f8' : null,
                        hLineColor: () => '#CCCCCC',
                        vLineColor: () => '#CCCCCC',
                        paddingTop: () => 4,
                        paddingBottom: () => 4
                    },
                    margin: [0, 0, 0, 20]
                },
                {
                    text: 'Product Sales Details',
                    style: 'sectionHeader',
                    margin: [0, 10, 0, 10]
                },
                {
                    table: {
                        headerRows: 1,
                        widths: ['auto', '*', '*', 'auto', 'auto', 'auto'],
                        body: [
                            [{
                                    text: 'ID',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                },
                                {
                                    text: 'Name',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                },
                                {
                                    text: 'Category',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                },
                                {
                                    text: 'Quantity',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                },
                                {
                                    text: 'Unit Price',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                },
                                {
                                    text: 'Date',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                }
                            ],
                            ...productData.map(row => row.map((cell, idx) => ({
                                text: cell,
                                alignment: [0, 1, 2].includes(idx) ? 'left' : 'right',
                                style: 'tableData'
                            })))
                        ]
                    },
                    layout: {
                        fillColor: (rowIndex) => rowIndex % 2 === 0 ? '#f8f8f8' : null,
                        hLineColor: () => '#CCCCCC',
                        vLineColor: () => '#CCCCCC',
                        paddingTop: () => 4,
                        paddingBottom: () => 4
                    },
                    margin: [0, 0, 0, 20]
                },
                {
                    text: 'Product Bills Details',
                    style: 'sectionHeader',
                    margin: [0, 10, 0, 10]
                },
                {
                    table: {
                        headerRows: 1,
                        widths: ['auto', '*', 'auto', 'auto', 'auto', 'auto'],
                        body: [
                            [{
                                    text: 'Bill ID',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                },
                                {
                                    text: 'Shop Name',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                },
                                {
                                    text: 'Total Amount',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                },
                                {
                                    text: 'Payable Amount',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                },
                                {
                                    text: 'Due Amount',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                },
                                {
                                    text: 'Date',
                                    style: 'tableHeader',
                                    alignment: 'center'
                                }
                            ],
                            ...billDataFormatted.map(row => row.map((cell, idx) => ({
                                text: cell,
                                alignment: [0, 1].includes(idx) ? 'left' : 'right',
                                style: 'tableData'
                            })))
                        ]
                    },
                    layout: {
                        fillColor: (rowIndex) => rowIndex % 2 === 0 ? '#f8f8f8' : null,
                        hLineColor: () => '#CCCCCC',
                        vLineColor: () => '#CCCCCC',
                        paddingTop: () => 4,
                        paddingBottom: () => 4
                    },
                    margin: [0, 0, 0, 20]
                },
                {
                    text: 'Summary Stats',
                    style: 'sectionHeader',
                    margin: [0, 10, 0, 5]
                },
                {
                    columns: [{
                            text: `Total Profit: ${currentChartData.profit.reduce((a, b) => a + (parseFloat(b) || 0), 0).toFixed(2)}`,
                            style: 'stats'
                        },
                        {
                            text: `Total Sales: ${currentChartData.sales.reduce((a, b) => a + (parseFloat(b) || 0), 0).toFixed(2)}`,
                            style: 'stats'
                        },
                        {
                            text: `Total Products Sold: ${tableData.reduce((sum, row) => sum + (parseInt(row.total_quantity) || 0), 0)}`,
                            style: 'stats'
                        },
                        {
                            text: `Total Due: ${formatCurrency(billData.reduce((sum, row) => sum + (parseFloat(row.dues || row.total_amount) || 0), 0))}`,
                            style: 'stats'
                        }
                    ],
                    columnGap: 10,
                    margin: [0, 0, 0, 10]
                }
            ],
            styles: {
                header: {
                    fontSize: 20,
                    bold: true,
                    color: '#344767'
                },
                subheader: {
                    fontSize: 12,
                    color: '#7b809a'
                },
                sectionHeader: {
                    fontSize: 14,
                    bold: true,
                    color: '#344767',
                    margin: [0, 5, 0, 5]
                },
                tableHeader: {
                    bold: true,
                    fillColor: '#344767',
                    color: 'white',
                    fontSize: 10,
                    margin: [0, 5, 0, 5]
                },
                stats: {
                    fontSize: 11,
                    bold: true,
                    color: '#344767'
                }
            },
            defaultStyle: {
                fontSize: 10,
                color: '#344767'
            }
        };

        pdfMake.createPdf(docDefinition).download(filename);

    } catch (error) {
        console.error('Error generating PDF:', error);
        displayMessage('Failed to generate PDF. Please try again.');
    }
}


    // Export to PNG
    // function exportToPNG() {
    //     console.log('Export to PNG triggered');
    //     if (!productSalesTable || !currentChartData) {
    //         displayMessage('Data not available. Please wait for data to load and try again.');
    //         return;
    //     }

    //     const card = document.querySelector('.card');
    //     html2canvas(card, {
    //         scale: 2,
    //         useCORS: true
    //     }).then(canvas => {
    //         const link = document.createElement('a');
    //         const {
    //             filename
    //         } = generateFileInfo('png');
    //         link.download = filename;
    //         link.href = canvas.toDataURL('image/png');
    //         link.click();
    //     }).catch(error => {
    //         console.error('Error capturing PNG:', error);
    //         displayMessage('Failed to capture PNG export.');
    //     });
    // }

    // Global filter function
    async function filterData(period, customStartDate = null, customEndDate = null) {
        console.log(`Filtering data for period: ${period}`);
        if (period === 'custom') {
            console.log(`Custom date range: ${customStartDate || document.getElementById('modalStartDate').value} to ${customEndDate || document.getElementById('modalEndDate').value}`);
        }
        clearMessage();
        showLoading();

        // Update global filter state
        currentFilterPeriod = period;
        currentStartDate = customStartDate || (period === 'custom' ? document.getElementById('modalStartDate').value : null);
        currentEndDate = customEndDate || (period === 'custom' ? document.getElementById('modalEndDate').value : null);

        try {
            let url = `/admin/dashboard/data?period=${period}`;

            if (period === 'custom') {
                const startDate = currentStartDate;
                const endDate = currentEndDate;

                if (!startDate || !endDate) {
                    displayMessage('Please select both start and end dates.', 'danger', 'modalErrorMessage');
                    hideLoading();
                    return;
                }

                if (new Date(startDate) > new Date(endDate)) {
                    displayMessage('Start date cannot be after end date.', 'danger', 'modalErrorMessage');
                    hideLoading();
                    return;
                }

                url += `&start_date=${startDate}&end_date=${endDate}`;
            }

            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.message || 'Failed to load data');
            }

            const data = result.data;

            console.group(`Dashboard Data for ${period}:`);
            console.log('Chart Data:', {
                labels: data.labels,
                profit: data.profit,
                sales: data.sales,
                total_profit: data.total_profit,
                total_sales: data.total_sales
            });

            if (data.top_products && data.top_products.length > 0) {
                console.group('Top Selling Products:');
                data.top_products.forEach((product, index) => {
                    console.group(`#${index + 1} ${product.name || 'Unknown Product'}`);
                    console.log('Product ID:', product.id);
                    console.log('SKU:', product.sku || 'N/A');
                    console.log('Category:', product.category || 'N/A');
                    console.log('Quantity Sold:', product.total_quantity || 0);
                    console.log('Unit Price:', product.unit_price || 0);
                    console.log('Total Sales:', product.total_sales || 0);
                    console.log('Profit:', (product.total_sales - (product.unit_price * product.total_quantity)) || 0);
                    console.log('Last Sold:', product.last_sold || 'N/A');
                    console.groupEnd();
                });
                console.groupEnd();

                console.log('Product Summary:', {
                    total_products_sold: data.stats.total_products_sold || 0,
                    unique_products: data.stats.unique_products || 0,
                    top_selling_product: data.stats.top_product || 'N/A',
                    top_product_quantity: data.stats.top_product_qty || 0
                });
            } else {
                console.log('No product data available for this period.');
            }
            console.group('Bills:');
            if (data.bills && data.bills.length > 0) {
                data.bills.forEach((bill, index) => {
                    console.group(`Bill #${index + 1}`);
                    console.log('Bill ID:', bill.id);
                    console.log('Shop Name:', bill.shop_name || 'N/A');
                    console.log('Total Amount:', bill.total_amount || 0);
                    console.log('Due Amount:', bill.total_due || bill.total_amount || 0);
                    console.log('Date:', bill.created_at ? new Date(bill.created_at).toLocaleDateString() : 'N/A');
                    console.groupEnd();
                });
            } else {
                console.log('No bill data available for this period.');
            }
            console.groupEnd();

            console.groupEnd();

            updateChart(data);
            updateStats(data.stats);
            initializeProductSalesTable(data);
            initializeProductBillsTable(data);

            if (!data.bills || data.bills.length === 0) {
                displayMessage('Bill data not available for the selected period!', 'warning');
            }


            // console.groupEnd();

            // if (updateChart) {
            //     updateChart(data);
            // }

            if (typeof updateStats === 'function' && data.stats) {
                updateStats(data.stats);
            }

            if (data.bills && data.bills.length > 0) {
                console.group('Bills:');
                data.bills.forEach((bill, index) => {
                    console.group(`Bill #${index + 1}`);
                    console.log('Bill ID:', bill.id);
                    console.log('Shop Name:', bill.shop_name || 'N/A');
                    console.log('Total Amount:', bill.total_amount || 0);
                    console.log('Due Amount:', bill.total_due || bill.total_amount || 0);
                    console.log('Date:', bill.created_at ? new Date(bill.created_at).toLocaleDateString() : 'N/A');
                    console.groupEnd();
                });
                console.groupEnd();
            } else {
                console.log('No bill data available for this period.');
            }


            initializeProductSalesTable(data);
            initializeProductBillsTable(data);

            if (!data.bills || data.bills.length === 0) {
                displayMessage('Bill data not available for the selected period!', 'warning');
            }

            if (!data.top_products || data.top_products.length === 0) {
                displayMessage('Product sales data not available for the selected period!', 'warning');
            }


        } catch (error) {
            console.error('Error:', error);
            displayMessage(error.message || 'Failed to load data. Please try again.');
        } finally {
            hideLoading();
        }
    }

    // Initial load
    document.addEventListener('DOMContentLoaded', function() {
        initializeProductSalesTable([]);

        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                const period = this.getAttribute('data-period');
                if (period === 'custom') {
                    clearMessage('modalErrorMessage');
                } else {
                    filterData(period);
                }
            });
        });

        document.querySelectorAll('.export-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const exportType = this.getAttribute('data-export');
                console.log(`Export button clicked: ${exportType}`);

                if (exportType === 'pdf') {
                    exportToPDF();
                } else if (exportType === 'excel') {
                    exportToExcel();
                } else if (exportType === 'png') {
                    exportToPNG();
                } else if (exportType === 'docx') {
                    exportToDocx();
                }
            });
        });

        document.getElementById('applyCustomDate').addEventListener('click', function() {
            const startDate = document.getElementById('modalStartDate').value;
            const endDate = document.getElementById('modalEndDate').value;
            filterData('custom', startDate, endDate);
            const modal = bootstrap.Modal.getInstance(document.getElementById('customDateModal'));
            modal.hide();
        });

        filterData('week');
    });
</script>
@endpush --}}