@extends('Admin.layouts.master')

@section('page-title', 'Shipping Label Generator')
@section('source', 'Shipping Label')

@section('title')
{{ config('app.name') }} - Shipping Label Generator
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6><i class="fas fa-tag me-2"></i>Generate Shipping Label</h6>
                    <p class="text-sm text-muted">Enter a waybill number to generate shipping label</p>
                </div>
                <div class="card-body px-4 pt-3 pb-4">
                    <!-- Single Label Generation -->
                    <div class="row">
                        <div class="col-md-8">
                            <form id="singleLabelForm" class="row g-3 align-items-center" onsubmit="generateSingleLabel(event)">
                                <div class="col-md-6">
                                    <label for="waybillInput" class="form-label">Waybill Number <span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control"
                                        id="waybillInput"
                                        placeholder="e.g., 85529910000416"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label for="formatSelect" class="form-label">Format</label>
                                    <select class="form-select" id="formatSelect">
                                        <option value="pdf">PDF (Download)</option>
                                        <option value="json">JSON (Preview)</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100" style="height:38px;">
                                        <i class="fas fa-download me-1"></i> Generate
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-info mb-0">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Enter a valid Delhivery waybill number to generate shipping label
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Label Generation -->
     {{--
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6><i class="fas fa-layer-group me-2"></i>Bulk Shipping Labels</h6>
                    <p class="text-sm text-muted">Enter multiple waybill numbers separated by commas</p>
                </div>
                <div class="card-body px-4 pt-3 pb-4">
                    <form id="bulkLabelForm" onsubmit="generateBulkLabels(event)">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="bulkWaybillInput" class="form-label">Waybill Numbers <span class="text-danger">*</span></label>
                                <textarea class="form-control"
                                    id="bulkWaybillInput"
                                    rows="2"
                                    placeholder="Enter multiple waybills separated by commas&#10;e.g., 85529910000416, 85529910000417, 85529910000418"
                                    required></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="bulkFormatSelect" class="form-label">Format</label>
                                <select class="form-select" id="bulkFormatSelect">
                                    <option value="pdf">PDF (Download)</option>
                                    <option value="json">JSON (Preview)</option>
                                </select>
                                <button type="submit" class="btn btn-success mt-3 w-100">
                                    <i class="fas fa-download me-1"></i> Generate Bulk Labels
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
--}}
    <!-- Recent Labels -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6><i class="fas fa-history me-2"></i>Recent Labels</h6>
                </div>
                <div class="card-body px-4 pt-3 pb-4">
                    <div id="recentLabels">
                        <p class="text-muted">No labels generated yet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 mb-0">Generating shipping label...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Store recent labels
    let recentLabels = JSON.parse(localStorage.getItem('recentShippingLabels') || '[]');

    // Display recent labels
    function displayRecentLabels() {
        const container = document.getElementById('recentLabels');
        if (recentLabels.length === 0) {
            container.innerHTML = '<p class="text-muted">No labels generated yet.</p>';
            return;
        }

        let html = '<div class="table-responsive"><table class="table table-sm"><thead><tr>';
        html += '<th>#</th><th>Waybill</th><th>Generated At</th><th>Action</th>';
        html += '</tr></thead><tbody>';

        recentLabels.slice(0, 10).forEach((label, index) => {
            html += `<tr>
                <td>${index + 1}</td>
                <td><strong>${label.waybill}</strong></td>
                <td>${new Date(label.timestamp).toLocaleString()}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="regenerateLabel('${label.waybill}')">
                        <i class="fas fa-redo"></i> Regenerate
                    </button>
                </td>
            </tr>`;
        });

        html += '</tbody></table></div>';
        container.innerHTML = html;
    }

    // Generate single label
    // function generateSingleLabel(event) {
    //     event.preventDefault();

    //     const waybill = document.getElementById('waybillInput').value.trim();
    //     const format = document.getElementById('formatSelect').value;

    //     if (!waybill) {
    //         Swal.fire({
    //             icon: 'warning',
    //             title: 'Missing Waybill',
    //             text: 'Please enter a waybill number.',
    //             confirmButtonColor: '#3085d6',
    //         });
    //         return;
    //     }

    //     generateLabel(waybill, format, 'single');
    // }
    // Generate single label
    function generateSingleLabel(event) {
        event.preventDefault();

        const waybill = document.getElementById('waybillInput').value.trim();
        const format = document.getElementById('formatSelect').value;

        if (!waybill) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Waybill',
                text: 'Please enter a waybill number.',
                confirmButtonColor: '#3085d6',
            });
            return;
        }

        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();

        // For PDF - download directly
        if (format === 'pdf') {
            // Use the download endpoint that returns PDF directly
            const url = `{{ route('shipping-label.download') }}?waybill=${encodeURIComponent(waybill)}`;
            window.open(url, '_blank');
            loadingModal.hide();

            saveRecentLabel(waybill);
            displayRecentLabels();
            return;
        }

        // For JSON preview
        fetch(`{{ route('shipping-label.generate') }}?waybill=${encodeURIComponent(waybill)}&format=json`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                loadingModal.hide();

                if (data.success) {
                    let htmlContent = `<div style="text-align: left;">
                <p><strong>Waybill:</strong> ${data.waybill}</p>`;

                    if (data.pdf_base64) {
                        // Create an embedded PDF viewer
                        htmlContent += `
                    <p><strong>PDF Preview:</strong></p>
                    <embed src="data:application/pdf;base64,${data.pdf_base64}" type="application/pdf" width="100%" height="400px" />
                    <br>
                    <a href="data:application/pdf;base64,${data.pdf_base64}" download="shipping-label-${data.waybill}.pdf" class="btn btn-primary mt-2">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                `;
                    }

                    htmlContent += `</div>`;

                    Swal.fire({
                        title: 'Shipping Label',
                        html: htmlContent,
                        width: 900,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Close'
                    });

                    saveRecentLabel(waybill);
                    displayRecentLabels();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Generation Failed',
                        text: data.message || 'Failed to generate shipping label.',
                        confirmButtonColor: '#d33',
                    });
                }
            })
            .catch(error => {
                loadingModal.hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while generating the label.',
                    confirmButtonColor: '#d33',
                });
                console.error('Error:', error);
            });
    }

    // Generate bulk labels
    function generateBulkLabels(event) {
        event.preventDefault();

        const waybillsInput = document.getElementById('bulkWaybillInput').value.trim();
        const format = document.getElementById('bulkFormatSelect').value;

        if (!waybillsInput) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Waybills',
                text: 'Please enter at least one waybill number.',
                confirmButtonColor: '#3085d6',
            });
            return;
        }

        // Split and clean waybills
        const waybills = waybillsInput.split(',').map(w => w.trim()).filter(w => w);

        if (waybills.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Input',
                text: 'Please enter valid waybill numbers.',
                confirmButtonColor: '#3085d6',
            });
            return;
        }

        generateBulkLabel(waybills, format);
    }

    // Generate single label via API
    function generateLabel(waybill, format, type) {
        // Show loading
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();

        // Build URL
        let url = `{{ route('shipping-label.generate') }}?waybill=${encodeURIComponent(waybill)}`;
        if (format === 'pdf') {
            url += '&format=pdf';
            // Open PDF in new tab
            window.open(url, '_blank');
            loadingModal.hide();

            // Save to recent
            saveRecentLabel(waybill);
            displayRecentLabels();

            return;
        }

        // For JSON preview
        url += '&format=json';

        fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                loadingModal.hide();

                if (data.success) {
                    // Display JSON data in a nice format
                    Swal.fire({
                        title: 'Shipping Label Data',
                        html: `<div style="text-align: left; max-height: 400px; overflow: auto;">
                        <pre style="background: #f5f5f5; padding: 15px; border-radius: 5px; font-size: 12px;">${JSON.stringify(data.data, null, 2)}</pre>
                    </div>`,
                        width: 800,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Close',
                        showCancelButton: true,
                        cancelButtonText: 'Download PDF',
                        preConfirm: () => {
                            // Download PDF
                            window.open(`{{ route('shipping-label.generate') }}?waybill=${encodeURIComponent(waybill)}&format=pdf`, '_blank');
                        }
                    });

                    // Save to recent
                    saveRecentLabel(waybill);
                    displayRecentLabels();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Generation Failed',
                        text: data.message || 'Failed to generate shipping label.',
                        confirmButtonColor: '#d33',
                    });
                }
            })
            .catch(error => {
                loadingModal.hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while generating the label.',
                    confirmButtonColor: '#d33',
                });
                console.error('Error:', error);
            });
    }

    // Generate bulk labels via API
    function generateBulkLabel(waybills, format) {
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();

        const waybillString = waybills.join(',');
        let url = `{{ route('shipping-label.bulk') }}?waybills=${encodeURIComponent(waybillString)}`;

        if (format === 'pdf') {
            url += '&format=pdf';
            window.open(url, '_blank');
            loadingModal.hide();

            // Save all to recent
            waybills.forEach(w => saveRecentLabel(w));
            displayRecentLabels();

            return;
        }

        url += '&format=json';

        fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                loadingModal.hide();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bulk Labels Generated',
                        text: `Successfully generated ${data.waybills ? data.waybills.length : waybills.length} labels.`,
                        confirmButtonColor: '#28a745',
                        showCancelButton: true,
                        cancelButtonText: 'Download PDF',
                        preConfirm: () => {
                            window.open(`{{ route('shipping-label.bulk') }}?waybills=${encodeURIComponent(waybillString)}&format=pdf`, '_blank');
                        }
                    });

                    // Save all to recent
                    waybills.forEach(w => saveRecentLabel(w));
                    displayRecentLabels();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Generation Failed',
                        text: data.message || 'Failed to generate bulk labels.',
                        confirmButtonColor: '#d33',
                    });
                }
            })
            .catch(error => {
                loadingModal.hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while generating labels.',
                    confirmButtonColor: '#d33',
                });
                console.error('Error:', error);
            });
    }

    // Save recent label
    function saveRecentLabel(waybill) {
        // Add to recent if not already present
        const exists = recentLabels.some(label => label.waybill === waybill);
        if (!exists) {
            recentLabels.unshift({
                waybill: waybill,
                timestamp: new Date().toISOString()
            });
            // Keep only last 20
            if (recentLabels.length > 20) {
                recentLabels = recentLabels.slice(0, 20);
            }
            localStorage.setItem('recentShippingLabels', JSON.stringify(recentLabels));
        }
    }

    // Regenerate label
    function regenerateLabel(waybill) {
        document.getElementById('waybillInput').value = waybill;
        document.getElementById('formatSelect').value = 'pdf';
        document.getElementById('singleLabelForm').dispatchEvent(new Event('submit'));
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        displayRecentLabels();
    });

    // Clear recent labels
    function clearRecentLabels() {
        if (confirm('Clear all recent labels?')) {
            recentLabels = [];
            localStorage.removeItem('recentShippingLabels');
            displayRecentLabels();
        }
    }
</script>
@endsection