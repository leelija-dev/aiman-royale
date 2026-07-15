@extends('layout.web.main-layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="w-full px-4 py-8">
    <div class="container mx-auto">
        <!-- Search Section -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <h1 class="text-2xl font-bold mb-2">Track Your Order</h1>
            <p class="text-gray-600 mb-6">Enter Order ID or Waybill number to track your shipment</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 block mb-2">Order ID</label>
                    <div class="flex gap-2">
                        <input id="trackOrderId" type="text" placeholder="e.g. 1234" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        <button onclick="doTrackByOrder()" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium">Track</button>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700 block mb-2">Waybill / AWB</label>
                    <div class="flex gap-2">
                        <input id="trackWaybillId" type="text" placeholder="e.g. 85529910000173" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        <button onclick="doTrackByWaybill()" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium">Track</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracking Result -->
        <div id="trackResult" class="mt-6"></div>
    </div>
</section>

<script>
    let autoRefreshInterval = null;
    let currentTrackingId = null;
    let isTrackingByOrder = true;

    const statusStages = {
        'confirmed': { stage: 1, label: 'Order Confirmed', icon: '✓', color: 'bg-green-100 text-green-700' },
        'processing': { stage: 2, label: 'Processing', icon: '⏳', color: 'bg-blue-100 text-blue-700' },
        'packed': { stage: 2, label: 'Packed', icon: '📦', color: 'bg-blue-100 text-blue-700' },
        'shipped': { stage: 3, label: 'Shipped', icon: '🚚', color: 'bg-blue-100 text-blue-700' },
        'in transit': { stage: 3, label: 'In Transit', icon: '🚚', color: 'bg-blue-100 text-blue-700' },
        'out for delivery': { stage: 4, label: 'Out for Delivery', icon: '📍', color: 'bg-yellow-100 text-yellow-700' },
        'delivered': { stage: 5, label: 'Delivered', icon: '✓', color: 'bg-green-100 text-green-700' },
        'cancelled': { stage: 0, label: 'Cancelled', icon: '✕', color: 'bg-red-100 text-red-700' }
    };

    function doTrackByOrder() {
        const id = document.getElementById('trackOrderId').value.trim();
        if (!id) return alert('Please enter an order id');
        currentTrackingId = id;
        isTrackingByOrder = true;
        startAutoRefresh();
        fetch(`/track-order/${id}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(renderTrackingResult)
            .catch(e => { console.error(e); showError('Unable to fetch tracking details'); });
    }

    function doTrackByWaybill() {
        const way = document.getElementById('trackWaybillId').value.trim();
        if (!way) return alert('Please enter a waybill');
        currentTrackingId = way;
        isTrackingByOrder = false;
        startAutoRefresh();
        fetch(`/track-waybill/${encodeURIComponent(way)}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(renderTrackingResult)
            .catch(e => { console.error(e); showError('Unable to fetch tracking details'); });
    }

    function startAutoRefresh() {
        // Clear existing interval if any
        if (autoRefreshInterval) clearInterval(autoRefreshInterval);
        
        // Auto-refresh every 30 seconds
        autoRefreshInterval = setInterval(() => {
            if (isTrackingByOrder) {
                fetch(`/track-order/${currentTrackingId}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.json())
                    .then(renderTrackingResult)
                    .catch(e => console.error('Auto-refresh failed:', e));
            } else {
                fetch(`/track-waybill/${encodeURIComponent(currentTrackingId)}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.json())
                    .then(renderTrackingResult)
                    .catch(e => console.error('Auto-refresh failed:', e));
            }
        }, 30000); // 30 seconds
    }

    function stopAutoRefresh() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
            autoRefreshInterval = null;
        }
    }

    function showError(msg) {
        stopAutoRefresh();
        const container = document.getElementById('trackResult');
        container.innerHTML = `<div class="bg-white rounded-2xl shadow-sm p-6"><div class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">${msg}</div></div>`;
    }

    function renderTrackingResult(data) {
        const container = document.getElementById('trackResult');
        
        if (!data) return showError('No tracking data found');

        // Extract tracking info
        if (data.success && data.tracking) data = data.tracking;
        let shipments = data.ShipmentData || data.shipments || data.packages || (data && !data.Error ? data : null);

        if (!shipments || (Array.isArray(shipments) && shipments.length === 0)) {
            return showError('No tracking records available yet');
        }

        // Handle array of shipments
        if (Array.isArray(shipments)) {
            container.innerHTML = shipments.map(s => buildTrackingCard(s.Shipment || s)).join('');
        } else {
            container.innerHTML = buildTrackingCard(shipments);
        }
    }

    function buildTrackingCard(shipment) {
        const awb = shipment.AWB || shipment.waybill || shipment.waybill_number || 'N/A';
        const currentStatus = (shipment.Status && (shipment.Status.Status || shipment.Status[0] || shipment.Status)) || 'Unknown';
        const currentStage = statusStages[currentStatus.toLowerCase()] || { stage: 0, label: currentStatus, icon: '📦', color: 'bg-gray-100 text-gray-700' };
        
        const scans = shipment.Scans || [];
        const city = shipment.Consignee?.City || shipment.Destination || 'Destination City';
        
        let html = `<div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <!-- Status Update Badge -->
            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg flex items-center gap-2 text-sm text-blue-700">
                <span class="animate-pulse">🔄</span>
                <span>Auto-updating every 30 seconds...</span>
            </div>

            <!-- Header Info -->
            <div class="border-b pb-4 mb-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Shipment Tracking</h2>
                        <p class="text-sm text-gray-600">AWB: <strong>${awb}</strong></p>
                    </div>
                    <div class="text-right">
                        <div class="inline-block px-3 py-1 rounded-full ${currentStage.color} font-medium text-sm">
                            ${currentStage.icon} ${currentStage.label}
                        </div>
                    </div>
                </div>
                <p class="text-sm text-gray-700">Destination: <strong>${city}</strong></p>
            </div>

            <!-- Timeline Progress -->
            <div class="mb-6 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg">
                <div class="grid grid-cols-5 gap-2 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full ${currentStage.stage >= 1 ? 'bg-green-500' : 'bg-gray-300'} text-white flex items-center justify-center font-bold text-xs mb-1">✓</div>
                        <p class="text-xs font-medium text-gray-700">Confirmed</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full ${currentStage.stage >= 2 ? 'bg-green-500' : 'bg-gray-300'} text-white flex items-center justify-center font-bold text-xs mb-1">✓</div>
                        <p class="text-xs font-medium text-gray-700">Packed</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full ${currentStage.stage >= 3 ? 'bg-green-500' : 'bg-gray-300'} text-white flex items-center justify-center font-bold text-xs mb-1">✓</div>
                        <p class="text-xs font-medium text-gray-700">Shipped</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full ${currentStage.stage >= 4 ? 'bg-green-500' : 'bg-gray-300'} text-white flex items-center justify-center font-bold text-xs mb-1">✓</div>
                        <p class="text-xs font-medium text-gray-700">Out For Delivery</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full ${currentStage.stage >= 5 ? 'bg-green-500' : 'bg-gray-300'} text-white flex items-center justify-center font-bold text-xs mb-1">✓</div>
                        <p class="text-xs font-medium text-gray-700">Delivered</p>
                    </div>
                </div>
            </div>

            <!-- Tracking Events Timeline -->
            <div>
                <h3 class="font-bold text-gray-900 mb-4">Tracking Events</h3>
                <div class="space-y-0">`;

        if (scans && scans.length > 0) {
            scans.forEach((scan, idx) => {
                const scanData = scan.ScanDetail || scan;
                const scanDate = scanData.ScanDateTime || scanData.StatusDateTime || 'N/A';
                const scanStatus = scanData.Scan || scanData.Status || scanData.Instructions || 'Update';
                const location = scanData.Location || scanData.City || scanData.location || '';
                
                html += `<div class="flex gap-4 pb-4 ${idx < scans.length - 1 ? 'border-b' : ''}">
                    <div class="flex flex-col items-center">
                        <div class="w-3 h-3 rounded-full bg-purple-600 mt-2"></div>
                        ${idx < scans.length - 1 ? '<div class="w-0.5 h-16 bg-gray-300 mt-1"></div>' : ''}
                    </div>
                    <div class="flex-1 pt-1">
                        <p class="font-medium text-gray-900 text-sm">${scanStatus}</p>
                        <p class="text-xs text-gray-600 mt-1">${scanDate}</p>
                        ${location ? `<p class="text-xs text-gray-500 mt-0.5">${location}</p>` : ''}
                    </div>
                </div>`;
            });
        } else {
            html += `<div class="text-center py-6 text-gray-500"><p>No tracking events yet</p></div>`;
        }

        html += `</div>
            </div>
        </div>`;

        return html;
    }

    // Auto-load order tracking if order_id is in query params
    document.addEventListener('DOMContentLoaded', function() {
        const params = new URLSearchParams(window.location.search);
        const orderId = params.get('order_id');
        if (orderId) {
            document.getElementById('trackOrderId').value = orderId;
            doTrackByOrder();
        }
    });

    // Stop auto-refresh when user leaves the page
    window.addEventListener('beforeunload', stopAutoRefresh);
</script>

@endsection
