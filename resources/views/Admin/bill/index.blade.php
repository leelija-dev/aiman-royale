@extends('Admin.layouts.master')
@section('source', 'Generate Bill')
@section('page-title', 'Bill')
@section('title')
{{ config('app.name') }} - Generate Bill
@endsection

@section('content')
<div class="container-fluid py-4 main-con-bilg ">
    <div class="row h-100">
        <div class="col-12 h-100">
            <div class="card shadow-sm border-0 h-100">
                <!-- Body -->
                <div class="p-4 h-100">
                    <div class="row g-4 h-100">
                        <!-- Left column -->
                        <div class="col-12 h-100 d-flex flex-wrap align-content-between">
                            <div class="col-12 px-0 py-0" style="height: fit-content;">
                                <div class="w-100">
                                    <div class="mb-3 position-relative">
                                        <label for="customerSearch" class="form-label fw-semibold">Customer Name<sup class="text-danger">*</sup></label>
                                        <input id="customerSearch" type="text" class="form-control" placeholder="Search by customer name" autocomplete="off">
                                        <input type="hidden" id="customerId" name="customerId">
                                        <div id="customerSearchResults" class="list-group mt-2 position-absolute w-100"></div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold mb-0">Selected Products</h6>
                                    </div>
                                </div>
                                <!-- Table for larger screens -->
                                <div class="table-responsive bill-body d-none d-lg-block">
                                    <table class="table table-hover align-middle mb-0" id="bill-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Product Code</th>
                                                <th>Product</th>
                                                <th class="text-center">Buy</th>
                                                <th class="text-center">Price</th>

                                                <th class="text-center">Stock</th>
                                                <th class="text-center" style="width:150px;">Qty</th>
                                                <th class="text-center">Subtotal</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsTbody">
                                            <tr class="text-muted small">
                                                <td colspan="7" class="text-center py-4">No products added yet.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Cards for smaller screens -->
                                <div class="bill-body d-lg-none">
                                    <div id="itemsCards" class="d-flex flex-column gap-3">
                                        <div class="text-muted small text-center py-4">No products added yet.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Summary -->
                            <div class="droped-cont-bil w-100 ">
                                <div class="px-lg-0 px-md-3 px-0 bg-white " style="border-radius: 0px 0px 10px 10px;">
                                    <div class="row spec-row-cdor px-md-0 px-3 mt-lg-4 mt-0 w-100 mx-0 pt-lg-3 pt-2 pb-2 pb-lg-0" style="height: fit-content;border-top:1px solid #514f4f ">
                                        <div class="col-md-6 px-lg-2 px-0">
                                            <div class="mb-lg-2 mb-0 position-relative">
                                                <!-- <label for="productSearch" class="form-label fw-semibold">Search Product</label> -->
                                                <input id="productSearch" type="text" class="form-control"
                                                    placeholder="Search by name or Product Code" autocomplete="off">
                                                <div id="searchResults" class="list-group mt-2 position-absolute w-100"></div>
                                            </div>
                                            {{-- <div class="mb-2">
                                        <label for="discountPercent" class="form-label fw-semibold">Discount (%)</label>
                                        <input id="discountPercent" type="number" class="form-control d-none" placeholder="Enter discount percentage (e.g., 10 for 10%)" min="0" max="100" step="1" value="0" >
                                        <div id="discountWarning" class="text-danger small mt-1" style="display:none;">
                                            Discount percentage cannot be greater than 100%!
                                        </div>
                                    </div> --}}
                                            <div class="mb-2 col-12">
                                                <label for="paymentStatus" class="form-label fw-semibold">Payment Status</label>
                                                <select name="paymentStatus" id="paymentStatus" class="form-select">
                                                    <option value="non_paid">Non Paid</option>
                                                    <option value="paid">Paid</option>
                                                    <option value="semi_paid">Semi Paid</option>
                                                </select>
                                            </div>

                                            <div class="mb-2" id="semiPaidAmountDiv" style="display: none;">
                                                <label for="semiPaidAmount" class="form-label fw-semibold">Semi Paid Amount</label>
                                                <input id="semiPaidAmount" type="number" class="form-control" placeholder="Enter amount" min="0" step="0.01">
                                                <div id="semiPaidWarning" class="text-danger small mt-1" style="display:none;">
                                                    Semi Paid amount cannot be greater than total bill after discount!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-md-2 px-0 d-flex justify-content-end align-items-end align-content-end flex-wrap">
                                            <div class="col-12 mb-lg-3 mb-md-1 mb-0">
                                                <div class="p-3 py-md-3 py-1 px-md-3 px-1 bg-light rounded border d-lg-block d-flex justify-content-between align-items-center" style="border-color: #7f7f7f !important;">
                                                    <div class="d-flex justify-content-between flex-lg-row flex-column align-items-center ">
                                                        <span class="sum-tex-r">Total Items</span>
                                                        <strong id="totalItems">0</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-lg-row flex-column align-items-center  mt-lg-2">
                                                        <span class="sum-tex-r">Subtotal</span>
                                                        <strong id="subtotalPrice">0.00</strong>
                                                    </div>
                                                    {{-- <div class="d-flex justify-content-between mt-lg-2">
                                                <span class="sum-tex-r">Discount</span>
                                                <strong id="discountPrice">0.00</strong>
                                            </div> --}}
                                                    <div class="d-flex justify-content-between flex-lg-row flex-column align-items-center  mt-lg-2">
                                                        <span class="sum-tex-r">Total Price</span>
                                                        <strong id="totalPrice">0.00</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <button id="saveBtn" class="btn mb-0 btn-primary btn-lg mt-2 mt-md-0 px-3 py-2" disabled>
                                                <i class="fas fa-save me-1"></i> Save Bill
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="dummy-scroll-block" class="d-lg-none d-block "></div>
                        </div>
                    </div><!-- row -->
                </div><!-- card-body -->
            </div>
        </div>
    </div>
    <!-- Hidden iframe for printing (never visible) -->
    <iframe id="__receiptPrintIframe" style="position:fixed; right:0; bottom:0; width:0; height:0; border:none; visibility:hidden;"></iframe>
</div>

<style>
    /* Full height layout */
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: visible;
        /* Prevent body scroll */
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    body .main-content {
        display: flex;
        flex-direction: column;
        padding-top: 1rem !important;
    }

    #productSearch {
        min-height: 50px !important;

    }

    #paymentStatus,
    #productSearch {
        border-color: #7f7f7f !important;
    }

    .sum-tex-r {
        color: #4d4d4d !important;
        font-weight: 600;
    }

    #navbarBlur {
        /* box-shadow: inset 0 0px 1px 1px rgba(254, 254, 254, 0.9), 0 20px 27px 0 rgba(0, 0, 0, 0.05) !important; */
        border-radius: 1rem !important;
        backdrop-filter: saturate(200%) blur(30px) !important;
        background-color: rgba(255, 255, 255, 0.8) !important;
    }

    #productSearch::placeholder {
        color: #525557 !important;
    }

    .main-con-bilg {
        flex: 1;
        display: flex;
        flex-direction: column;
        /* padding: 1rem 0 !important; */
    }


    body .main-content .list-group {
        max-height: 500px;
        overflow-y: auto;
        z-index: 40;
    }

    .ps--active-x>.ps__rail-x,
    .ps--active-y>.ps__rail-y {
        background-color: transparent;
        height: auto !important;
        display: none !important;

    }

    .bill-preview .alert {
        background: #f9fafc;
        border: 1px dashed #dce1e6;
    }

    .qty-input {
        /* max-width: 60px; */
        text-align: center;
        max-height: 30px;
        outline: none !important;
        box-shadow: none !important;
    }

    .price-input {

        text-align: center;
        max-height: 30px;
        outline: none !important;
        box-shadow: none !important;
    }


    .custom-input-group,
    .pr-cusin-p {
        min-width: 150px;
    }

    .qty-btn {
        margin-bottom: 0 !important;
        width: 30px;
        height: 30px;
        padding: 0;
        line-height: 1;
    }

    .price-btn {
        margin-bottom: 0 !important;
        width: 30px;
        height: 30px;
        padding: 0;
        line-height: 1;
    }

    .table th {
        font-size: 0.8rem;
        font-weight: 600;
    }

    .table td {
        vertical-align: middle;
    }

    .sku-badge {
        font-size: .75rem;
        color: #6c757d;
    }

    #searchResults .list-group-item,
    #customerSearchResults .list-group-item {
        cursor: pointer;
    }

    #searchResults .list-group-item:hover,
    #customerSearchResults .list-group-item:hover {
        background: #f6f9fc;
    }

    #searchResults .list-group-item.active,
    #customerSearchResults .list-group-item.active {
        background: #fffafa;
        border: 1px solid #777676;
        color: #666464;
        font-weight: bold;
    }

    .product-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .product-card .product-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .product-card .product-details {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .swal2-container {
        z-index: 90000;
    }



    @media screen and (min-width: 991px) {

        #navbarBlur {
            top: 2% !important;
        }

        .price-input,
        .qty-input {
            max-width: 60px;
        }

        .product-card .input-group-sm {
            max-width: 150px;
        }

    }


    @media screen and (max-width: 991px) {
        body .main-content .list-group {
            max-height: 158px !important;
            overflow-y: scroll !important;
            box-shadow: 1px 4px 16px #7170704a !important;
        }

        .price-input,
        .qty-input {
            min-width: 70px !important;
        }

        .spe-mob-jus {
            width: inherit !important;
            max-width: 200px !important;
        }

        .comb-inpu-prqt {
            gap: 1rem !important;
        }

        .droped-cont-bil {
            position: fixed !important;
            bottom: 0;
            left: 0;
            padding-bottom: 0.5rem !important;
            z-index: 8000;
            padding: 0 1.5rem;

        }

        #dummy-scroll-block {
            height: 150px !important;
            width: 100% !important;
        }
    }

    @media screen and (max-width: 767px) {
        #dummy-scroll-block {
            height: 244px !important;
            width: 100% !important;
            background: white !important;
        }

        .droped-cont-bil {
            padding: 0 11px !important;

        }

        .droped-cont-bil .spec-row-cdor {
            border-radius: 10px 10px 0px 0px !important;
            box-shadow: 2px 5px 13px #00000059 !important;
        }
    }

    @media screen and (max-width: 500px) {
        .spe-sp-prk {
            width: 100%;
        }

        .spec-bar-slas {
            display: none;
        }

        .list-group-item {
            font-size: 15px !important;
        }
    }

    @media screen and (max-width: 399px) {
        .comb-inpu-prqt {
            flex-direction: column !important;
            gap: 7px !important;
        }

        .price-input,
        .qty-input {
            max-width: 100% !important;
        }


        .spe-mob-jus {
            max-width: 100% !important;
        }
    }

    @media screen and (max-width: 373px) {
        .spe-mob-jus {
            justify-content: center !important;
        }

        .spe-mob-jus span {
            width: fit-content !important;
            min-width: auto !important;
        }

        .price-input,
        .qty-input {
            max-width: 100% !important;
        }

    }
</style>

<!-- No external assets required for the search inputs -->

<script>
    // Products data from database
    let products = JSON.parse('{!! addslashes(json_encode($products)) !!}');
    // Customers data from database
    const customers = JSON.parse('{!! addslashes(json_encode($customers)) !!}');
    const productMap = new Map();
    products.forEach(product => {
        productMap.set(String(product.id), product);
    });
    let cart = [];
    let cartIdCounter = 0;
    let selectedProduct = null;

    // Focus management variables
    let isTypingInPriceInput = false;
    let isTypingInQtyInput = false;
    let currentEditingCartId = null;
    let currentEditingField = null; // 'price' or 'quantity'

    const productSearch = document.getElementById('productSearch');
    const searchResults = document.getElementById('searchResults');
    const itemsTbody = document.getElementById('itemsTbody');
    const itemsCards = document.getElementById('itemsCards');
    const totalItemsEl = document.getElementById('totalItems');
    const subtotalPriceEl = document.getElementById('subtotalPrice');
    const totalPriceEl = document.getElementById('totalPrice');
    const saveBtn = document.getElementById('saveBtn');
    const paymentStatus = document.getElementById('paymentStatus');
    const semiPaidAmountDiv = document.getElementById('semiPaidAmountDiv');
    const semiPaidAmount = document.getElementById('semiPaidAmount');
    const customerSearch = document.getElementById('customerSearch');
    const customerSearchResults = document.getElementById('customerSearchResults');
    const customerIdInput = document.getElementById('customerId');

    let selectedCustomer = {
        id: '',
        name: '',
        address: '',
        mobile: ''
    };

    let customerHighlightedIndex = -1;

    // Customer search and selection
    function filterCustomers(term) {
        const t = term.trim().toLowerCase();
        if (!t || t.length < 3) return []; // Require at least 3 characters
        return customers.filter(c =>
            c.id.toString().includes(t) ||
            c.shop_name.toLowerCase().includes(t) ||
            (c.mobile_number && c.mobile_number.toLowerCase().includes(t))
        ).slice(0, 10);
    }

    function renderCustomerSearch() {
        const term = customerSearch.value.trim();
        const results = filterCustomers(term);
        customerSearchResults.innerHTML = '';
        customerHighlightedIndex = -1;

        // Only show "No customer found" if user typed 3+ chars and no results
        if (results.length === 0 && term.length >= 3) {
            const noResult = document.createElement('div');
            noResult.className = 'list-group-item text-center text-muted small py-3';
            noResult.textContent = 'No customer found';
            customerSearchResults.appendChild(noResult);
            return;
        }

        // If input is empty or short, just clear results and exit
        if (term.length < 3) {
            return;
        }

        // Otherwise, render matching customers
        results.forEach(c => {
            const a = document.createElement('button');
            a.type = 'button';
            a.className = 'list-group-item list-group-item-action';
            a.setAttribute('data-id', String(c.id));
            a.innerHTML = `
            <div class="d-flex justify-content-between flex-wrap ">
            <span class="pe-2" style="word-break:break-all;">${c.shop_name} - ${c.id}</span>
            <span class="text-muted">${c.mobile_number || '—'}</span>
            </div>
            <div class="text-muted small">${c.shop_address || '—'}</div>
            `;
            a.addEventListener('click', () => {
                selectedCustomer = {
                    id: c.id,
                    name: c.shop_name || 'Walk-in Customer',
                    address: c.shop_address || '',
                    mobile: c.mobile_number || ''
                };
                customerSearch.value = `${c.shop_name} - ${c.id}`;
                customerIdInput.value = c.id;
                customerSearchResults.innerHTML = '';
                validateDiscountAndSemiPaid();
            });
            customerSearchResults.appendChild(a);
        });
    }

    function highlightCustomerResult() {
        const resultItems = customerSearchResults.querySelectorAll('.list-group-item');
        resultItems.forEach((item, index) => {
            if (index === customerHighlightedIndex) {
                item.classList.add('active');
                item.scrollIntoView({
                    block: 'nearest'
                });
            } else {
                item.classList.remove('active');
            }
        });
    }

    function firstCustomerMatch() {
        const results = filterCustomers(customerSearch.value || '');
        return results.length ? results[0] : null;
    }

    customerSearch.addEventListener('input', () => {
        renderCustomerSearch();
    });

    customerSearch.addEventListener('keydown', (e) => {
        const resultItems = customerSearchResults.querySelectorAll('.list-group-item');
        if (resultItems.length === 0) {
            if (e.key === 'Enter') {
                const m = firstCustomerMatch();
                if (m) {
                    selectedCustomer = {
                        id: m.id,
                        name: m.shop_name || 'Walk-in Customer',
                        address: m.shop_address || '',
                        mobile: m.mobile_number || ''
                    };
                    customerSearch.value = m.shop_name;
                    customerIdInput.value = m.id;
                    customerSearchResults.innerHTML = '';
                    validateDiscountAndSemiPaid();
                }
            }
            return;
        }

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            customerHighlightedIndex = (customerHighlightedIndex + 1) % resultItems.length;
            highlightCustomerResult();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            customerHighlightedIndex = (customerHighlightedIndex - 1 + resultItems.length) % resultItems.length;
            highlightCustomerResult();
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (customerHighlightedIndex >= 0 && customerHighlightedIndex < resultItems.length) {
                resultItems[customerHighlightedIndex].click();
            } else {
                const m = firstCustomerMatch();
                if (m) {
                    selectedCustomer = {
                        id: m.id,
                        name: m.shop_name || 'Walk-in Customer',
                        address: m.shop_address || '',
                        mobile: m.mobile_number || ''
                    };
                    customerSearch.value = m.shop_name;
                    customerIdInput.value = m.id;
                    customerSearchResults.innerHTML = '';
                    validateDiscountAndSemiPaid();
                }
            }
        }
    });

    const currency = new Intl.NumberFormat(undefined, {
        style: 'currency',
        currency: 'INR'
    });

    // Toggle Semi Paid amount input visibility
    paymentStatus.addEventListener('change', () => {
        semiPaidAmountDiv.style.display = paymentStatus.value === 'semi_paid' ? 'block' : 'none';
        if (paymentStatus.value !== 'semi_paid') {
            semiPaidAmount.value = '';
        }
        validateDiscountAndSemiPaid();
    });

    // Handle Enter or Space key to toggle payment status dropdown
    paymentStatus.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            paymentStatus.focus();
            const event = new Event('click', {
                bubbles: true
            });
            paymentStatus.dispatchEvent(event);
            const mouseDownEvent = new Event('mousedown', {
                bubbles: true
            });
            paymentStatus.dispatchEvent(mouseDownEvent);
        }
    });

    function validateDiscountAndSemiPaid() {
        const subtotal = cart.reduce((sum, i) => sum + i.price * i.quantity, 0);
        const totalPrice = subtotal;
        const semiPaidWarning = document.getElementById('semiPaidWarning');
        let isValid = true;

        if (paymentStatus.value === 'semi_paid') {
            const semiPaidValue = parseFloat(semiPaidAmount.value) || 0;
            if (semiPaidValue > totalPrice) {
                semiPaidWarning.style.display = 'block';
                isValid = false;
            } else {
                semiPaidWarning.style.display = 'none';
            }
        } else {
            semiPaidWarning.style.display = 'none';
        }

        saveBtn.disabled = cart.length === 0 || !isValid || !selectedCustomer.id;
    }

    function filterProducts(term) {
        const t = term.trim().toLowerCase();
        if (!t || t.length < 3) return []; // Require at least 3 characters
        let matched = [];
        products.forEach(p => {
            if (p.name.toLowerCase().includes(t) || p.sku.toLowerCase().includes(t) || (p.company && p.company.toLowerCase().includes(t))) {
                const availableStocks = p.stocks.filter(s => s.quantity_in_stock > 0);
                availableStocks.forEach(s => {
                    matched.push({
                        product: p,
                        stock: s
                    });
                });
            }
        });
        return matched.slice(0, 10);
    }

    let highlightedIndex = -1;

    function renderSearch() {
        const term = productSearch.value;
        const results = filterProducts(term);
        searchResults.innerHTML = '';
        highlightedIndex = -1;

        if (results.length === 0 && term.trim().length >= 3) {
            const noResult = document.createElement('div');
            noResult.className = 'list-group-item text-center text-muted small py-3';
            noResult.textContent = 'Product or Company name not found';
            searchResults.appendChild(noResult);
            return;
        }

        results.forEach(entry => {
            const p = entry.product;
            const s = entry.stock;
            const a = document.createElement('button');
            a.type = 'button';
            a.className = 'list-group-item list-group-item-action';
            a.innerHTML = `
                <div class="d-flex justify-content-between flex-wrap gap-1">
                <div>
                <span>${p.sku} • ${p.name} - ${p.unit_amount}${p.unit}</span>
              
                <div class="text-muted small">${p.company || '—'} </div>
                </div>
                
                
                <span class="text-muted d-flex flex-wrap"><span class="spe-sp-prk">Purchased: ${currency.format(s.purchase_price)}</span> <span class="spec-bar-slas"> | </span> <span class="spe-sp-prk">Selling: ${currency.format(s.selling_price)} </span></span>
                </div>
                
                <div class="text-muted small"><strong>Availabile: ${s.quantity_in_stock} ${s.stock_quantity_unit}</strong></div>
                `;
            a.addEventListener('click', () => {
                addToCart(p, s);
                selectedProduct = p;
                productSearch.value = '';
                searchResults.innerHTML = '';
            });
            searchResults.appendChild(a);
        });
    }

    function highlightResult() {
        const resultItems = searchResults.querySelectorAll('.list-group-item');
        resultItems.forEach((item, index) => {
            if (index === highlightedIndex) {
                item.classList.add('active');
                item.scrollIntoView({
                    block: 'nearest'
                });
            } else {
                item.classList.remove('active');
            }
        });
    }

    function firstMatch() {
        const results = filterProducts(productSearch.value || '');
        return results.length ? results[0] : null;
    }

    function addToCart(p, selectedStock) {
        const sellingPrice = selectedStock.selling_price;
        const purchasePrice = selectedStock.purchase_price;
        const stock = selectedStock.quantity_in_stock;
        const stock_unit = selectedStock.stock_quantity_unit;
        const existing = cart.find(i =>
            i.product_id === p.id &&
            i.selling_price === sellingPrice &&
            i.unit === p.unit &&
            i.unit_amount === p.unit_amount
        );
        if (existing) {
            if (existing.quantity + 1 <= existing.stock) {
                existing.quantity += 1;
            } else {
                Swal.fire({
                    title: 'Stock Limit Exceeded!',
                    text: `Cannot add more ${p.name}. Only ${existing.stock} in stock for this batch.`,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }
        } else {
            cart.push({
                cart_id: ++cartIdCounter,
                product_id: p.id,
                name: p.name,
                sku: p.sku,
                company: p.company || '',
                category: p.category || '',
                selling_price: sellingPrice,
                purchase_price: purchasePrice,
                price: sellingPrice,
                quantity: 1,
                unit: p.unit,
                unit_amount: p.unit_amount,
                unit_display: `${p.unit_amount}${p.unit}`,
                stock: stock,
                stock_unit: stock_unit
            });
        }
        renderCart();
        setTimeout(() => {
            const qtyInput = document.querySelector(`[data-qty-for="${cartIdCounter}"]`);
            if (qtyInput) {
                qtyInput.focus();
                qtyInput.select();
            }
        }, 0);
    }

    function removeFromCart(cartId) {
        const idx = cart.findIndex(i => i.cart_id == cartId);
        if (idx > -1) {
            cart.splice(idx, 1);
            renderCart();
        }
    }

    function updateQuantity(cartId, qty) {
        const item = cart.find(i => i.cart_id == cartId);
        if (!item) return;
        const q = Math.max(0.01, Number(qty) || 0.01);
        if (q > item.stock) {
            Swal.fire({
                title: 'Stock Limit Exceeded!',
                text: `Cannot set quantity to ${q} for ${item.name}. Only ${item.stock} in stock.`,
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            item.quantity = item.stock;
        } else {
            item.quantity = q;
        }
        updateCartTotals();
        setTimeout(() => {
            const qtyInput = document.querySelector(`[data-qty-for="${cartId}"]`);
            if (qtyInput) {
                qtyInput.focus();
                qtyInput.select();
            }
        }, 0);
    }

    function incrementQuantity(cartId) {
        const item = cart.find(i => i.cart_id == cartId);
        if (!item) return;
        const newQuantity = parseFloat((item.quantity + 1).toFixed(2));
        if (newQuantity <= item.stock) {
            item.quantity = newQuantity;
            updateCartTotals();

            // Update ALL quantity inputs for this cart item (both table and cards)
            const qtyInputs = document.querySelectorAll(`[data-qty-for="${cartId}"]`);
            qtyInputs.forEach(input => {
                input.value = item.quantity;
            });

            // Focus and select the first found input
            if (qtyInputs.length > 0) {
                qtyInputs[0].focus();
                qtyInputs[0].select();
            }
        } else {
            Swal.fire({
                title: 'Stock Limit Exceeded!',
                text: `Cannot add more ${item.name}. Only ${item.stock} in stock.`,
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    }

    function decrementQuantity(cartId) {
        const item = cart.find(i => i.cart_id == cartId);
        if (!item) return;
        if (item.quantity > 0.01) {
            item.quantity = Math.max(0.01, parseFloat((item.quantity - 1).toFixed(2)));
            updateCartTotals();

            // Update ALL quantity inputs for this cart item (both table and cards)
            const qtyInputs = document.querySelectorAll(`[data-qty-for="${cartId}"]`);
            qtyInputs.forEach(input => {
                input.value = item.quantity;
            });

            // Focus and select the first found input
            if (qtyInputs.length > 0) {
                qtyInputs[0].focus();
                qtyInputs[0].select();
            }
        }
    }

    function formatCurrency(n) {
        return currency.format(n);
    }

    // Add this new function to update totals without re-rendering
    function updateCartTotals() {
        const totalItems = cart.reduce((sum, i) => sum + i.quantity, 0);
        const subtotalPrice = cart.reduce((sum, i) => sum + i.price * i.quantity, 0);
        const totalPrice = subtotalPrice;

        // Update summary
        totalItemsEl.textContent = totalItems % 1 === 0 ? String(totalItems) : totalItems.toFixed(2);
        subtotalPriceEl.textContent = formatCurrency(subtotalPrice);
        totalPriceEl.textContent = formatCurrency(totalPrice);

        // UPDATE ALL ROW SUBTOTALS (TABLE & CARDS)
        cart.forEach(item => {
            const cartId = item.cart_id;
            const sub = item.price * item.quantity;

            // Update TABLE row subtotal
            const tableSubtotal = document.querySelector(`#bill-table td[data-subtotal-for="${cartId}"]`);
            if (tableSubtotal) {
                tableSubtotal.innerHTML = `<strong>${formatCurrency(sub)}</strong>`;
            }

            // Update CARD subtotal
            const cardSubtotal = document.querySelector(`#itemsCards .product-card[data-cart-id="${cartId}"] .subtotal-text`);
            if (cardSubtotal) {
                cardSubtotal.innerHTML = `<strong>Subtotal: ${formatCurrency(sub)}</strong>`;
            }
        });

        validateDiscountAndSemiPaid();
    }

    function renderCart() {
        // Track currently focused input before re-render
        const activeElement = document.activeElement;
        let lastFocusedCartId = null;
        let lastFocusedField = null;

        if (activeElement) {
            if (activeElement.matches('[data-price-for]')) {
                lastFocusedCartId = Number(activeElement.dataset.priceFor);
                lastFocusedField = 'price';
            } else if (activeElement.matches('[data-qty-for]')) {
                lastFocusedCartId = Number(activeElement.dataset.qtyFor);
                lastFocusedField = 'quantity';
            }
        }

        // === RENDER TABLE (DESKTOP) ===
        itemsTbody.innerHTML = '';
        if (cart.length === 0) {
            itemsTbody.innerHTML = `<tr class="text-muted"><td colspan="8" class="text-center py-4">No products added yet.</td></tr>`;
            itemsCards.innerHTML = `<div class="text-muted small text-center py-4">No products added yet.</div>`;
        } else {
            cart.forEach(item => {
                const sub = item.price * item.quantity;
                const tr = document.createElement('tr');
                tr.innerHTML = `
                <td>${item.sku}</td>
                <td>
                    <span class="fw-semibold">${item.name} - ${item.unit_display}</span><br>
                    <div class="d-flex gap-2 align-items-center">
                        <span class="text-muted small">${item.company || '—'}</span>
                    </div>
                </td>
                <td class="text-center"><strong>${formatCurrency(item.purchase_price)}</strong></td>
                <td class="text-center">
                    <div class="input-group input-group-sm text-center justify-content-center pr-cusin-p">
                        <button class="btn btn-outline-secondary price-btn" type="button" data-price-decrement="${item.cart_id}" tabindex="0">-</button>
                        <input type="number" value="${item.price}" name="selling_Price" class="form-control text-center price-input" data-price-for="${item.cart_id}" step="0.01" tabindex="0">
                        <button class="btn btn-outline-secondary price-btn" type="button" data-price-increment="${item.cart_id}" tabindex="0">+</button>
                    </div>
                </td>
                <td class="text-center">${item.stock} ${item.unit}</td>
                <td class="text-center">
                    <div class="input-group input-group-sm custom-input-group justify-content-center">
                        <button class="btn btn-outline-secondary qty-btn" type="button" data-decrement="${item.cart_id}" tabindex="0">-</button>
                        <input type="number" min="0.01" step="0.01" max="${item.stock}" name="quantity" value="${item.quantity}" class="form-control qty-input" data-qty-for="${item.cart_id}" tabindex="0">
                        <button class="btn btn-outline-secondary qty-btn" type="button" data-increment="${item.cart_id}" tabindex="0">+</button>
                    </div>
                </td>
                <td class="text-center" data-subtotal-for="${item.cart_id}"><strong>${formatCurrency(sub)}</strong></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-danger p-1 border-0 mb-0" data-remove="${item.cart_id}" tabindex="0">
                        <i class="fa-solid fa-trash-can" style="font-size:18px;"></i>
                    </button>
                </td>
            `;
                itemsTbody.appendChild(tr);
            });

            // === RENDER CARDS (MOBILE) ===
            itemsCards.innerHTML = '';
            cart.forEach(item => {
                const sub = item.price * item.quantity;
                const card = document.createElement('div');
                card.className = 'new-product-card';
                card.innerHTML = `
                <div class="product-card" data-cart-id="${item.cart_id}">
                <div class="product-header mb-0 align-items-start"  >
                    <span class="fw-semibold" style="word-break:break-all;">${item.sku} • ${item.name}-${item.unit_display}</span>
                    <button class="btn btn-sm btn-outline-danger p-1 border-0 mb-0" data-remove="${item.cart_id}" tabindex="0">
                        <i class="fa-solid fa-trash-can" style="font-size:18px;"></i>
                    </button>
                </div>
                <div class="product-details">
                    <div>${item.company || '—'}</div>
                    <div class="d-flex gap-sm-1 flex-sm-row flex-column"><span>Purchase Price: ${formatCurrency(item.purchase_price)}</span> <span class="d-sm-block d-none">|</span> <span>Selling Price: ${formatCurrency(item.selling_price)}</span> </div>
                    <div>Stock: ${item.stock} ${item.unit}</div>
                </div>

                <div class="col-12 d-flex justify-content-between mt-2 comb-inpu-prqt">
                <!-- Price Input Group (Mobile) -->
                <div class="text-center spe-mob-jus">
                    <span class="fw-bold " style="width:fit-content;min-width:68px;">Price</span>
                    <div class="input-group mt-1 input-group-sm justify-content-end ">
                        <button class="btn btn-secondary price-btn" type="button" data-price-decrement="${item.cart_id}" tabindex="0">-</button>
                        <input type="number" value="${item.price}" name="selling_Price" class="form-control text-center price-input" data-price-for="${item.cart_id}" step="0.01" tabindex="0">
                        <button class="btn btn-primary price-btn" type="button" data-price-increment="${item.cart_id}" tabindex="0">+</button>
                    </div>
                </div>

                <!-- Quantity Input Group (Mobile) -->
                <div class="text-center spe-mob-jus">
                    <span class="fw-bold " style="width:fit-content;min-width:68px;">Quantity</span>
                    <div class="input-group mt-1 input-group-sm justify-content-end">
                        <button class="btn btn-secondary qty-btn mb-0" type="button" data-decrement="${item.cart_id}" tabindex="0">-</button>
                        <input type="number" min="0.01" step="0.01" max="${item.stock}" name="quantity" value="${item.quantity}" class="form-control qty-input" data-qty-for="${item.cart_id}" tabindex="0">
                        <button class="btn btn-primary qty-btn mb-0" type="button" data-increment="${item.cart_id}" tabindex="0">+</button>
                    </div>
                </div>
                </div>

                <div class="col-12 text-end mt-2"  >
                    <span class="subtotal-text"><strong>Subtotal: ${formatCurrency(sub)}</strong></span>
                </div>
                </div>
            `;
                itemsCards.appendChild(card);
            });
        }

        updateCartTotals();

        // === EVENT DELEGATION: REMOVE BUTTONS ===
        document.querySelectorAll('[data-remove]').forEach(btn => {
            btn.replaceWith(btn.cloneNode(true)); // Remove old listeners
        });
        document.querySelectorAll('[data-remove]').forEach(btn => {
            btn.addEventListener('click', () => removeFromCart(Number(btn.dataset.remove)));
        });


        // === PRICE INPUTS (TABLE + CARDS) ===
        document.querySelectorAll('input[name="selling_Price"]').forEach(input => {
            input.replaceWith(input.cloneNode(true));
        });
        document.querySelectorAll('input[name="selling_Price"]').forEach(input => {
            const cartId = Number(input.dataset.priceFor);
            const item = cart.find(i => i.cart_id === cartId);
            if (!item) return;

            let originalValue = input.value;

            input.addEventListener('focus', () => input.select());

            input.addEventListener('input', () => {
                const val = parseFloat(input.value);
                item.price = isNaN(val) || val < 0 ? 0 : parseFloat(val.toFixed(2));
                updateCartTotals();
            });

            input.addEventListener('blur', () => {
                if (input.value !== originalValue) originalValue = input.value;
                setTimeout(restoreFocusAfterTab, 0);
            });

            /* ---------- NEW: ENTER → QUANTITY INPUT ---------- */
            input.addEventListener('keydown', e => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const qtyInput = document.querySelector(`[data-qty-for="${cartId}"]`);
                    if (qtyInput) {
                        qtyInput.focus();
                        qtyInput.select();
                    }
                }
            });
        });

        // === QUANTITY INPUTS (TABLE + CARDS) ===
        document.querySelectorAll('[data-qty-for]').forEach(input => {
            input.replaceWith(input.cloneNode(true));
        });
        document.querySelectorAll('[data-qty-for]').forEach(input => {
            const cartId = Number(input.dataset.qtyFor);
            const item = cart.find(i => i.cart_id === cartId);
            if (!item) return;

            let originalValue = input.value;

            input.addEventListener('focus', () => {
                input.select();
            });

            input.addEventListener('input', () => {
                let q = Math.max(0.01, Number(input.value) || 0.01);
                if (q > item.stock) {
                    q = item.stock;
                    input.value = q;
                }
                item.quantity = q;
                updateCartTotals();
            });

            input.addEventListener('blur', () => {
                if (input.value !== originalValue) {
                    originalValue = input.value;
                }
                setTimeout(restoreFocusAfterTab, 0);
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    productSearch.focus();
                }
            });
        });

        // === PRICE BUTTONS ===
        document.querySelectorAll('[data-price-increment]').forEach(btn => {
            btn.replaceWith(btn.cloneNode(true));
        });
        document.querySelectorAll('[data-price-increment]').forEach(btn => {
            btn.addEventListener('click', () => {
                const cartId = Number(btn.dataset.priceIncrement);
                const item = cart.find(i => i.cart_id === cartId);
                if (item) {
                    item.price = parseFloat((item.price + 1).toFixed(2));
                    updateCartTotals();
                    document.querySelectorAll(`[data-price-for="${cartId}"]`).forEach(inp => inp.value = item.price);
                    // inp.focus();
                    // inp.select();
                }
            });
        });

        document.querySelectorAll('[data-price-decrement]').forEach(btn => {
            btn.replaceWith(btn.cloneNode(true));
        });
        document.querySelectorAll('[data-price-decrement]').forEach(btn => {
            btn.addEventListener('click', () => {
                const cartId = Number(btn.dataset.priceDecrement);
                const item = cart.find(i => i.cart_id === cartId);
                if (item) {
                    item.price = Math.max(0, parseFloat((item.price - 1).toFixed(2)));
                    updateCartTotals();
                    document.querySelectorAll(`[data-price-for="${cartId}"]`).forEach(inp => inp.value = item.price);
                    // inp.focus();
                    // inp.select();
                }
            });
        });

        // === QUANTITY BUTTONS ===
        document.querySelectorAll('[data-increment]').forEach(btn => {
            btn.replaceWith(btn.cloneNode(true));
        });
        document.querySelectorAll('[data-increment]').forEach(btn => {
            btn.addEventListener('click', () => incrementQuantity(Number(btn.dataset.increment)));
        });

        document.querySelectorAll('[data-decrement]').forEach(btn => {
            btn.replaceWith(btn.cloneNode(true));
        });
        document.querySelectorAll('[data-decrement]').forEach(btn => {
            btn.addEventListener('click', () => decrementQuantity(Number(btn.dataset.decrement)));
        });

        // === RESTORE FOCUS AFTER TAB ===
        function restoreFocusAfterTab() {

            if (!lastFocusedCartId || !lastFocusedField) return;

            const selector = lastFocusedField === 'price' ?
                `[data-price-for="${lastFocusedCartId}"]` :
                `[data-qty-for="${lastFocusedCartId}"]`;

            const newInput = document.querySelector(selector);
            if (newInput) {
                // Small delay to allow tab to register
                setTimeout(() => {
                    newInput.focus();
                    newInput.select();
                }, 10);
            }
        }

        // Trigger focus restore
        restoreFocusAfterTab();
    }

    function resetBillForm() {
        cart = [];
        cartIdCounter = 0;
        selectedProduct = null;
        productSearch.value = '';
        searchResults.innerHTML = '';
        totalItemsEl.textContent = '0';
        subtotalPriceEl.textContent = '₹0.00';
        totalPriceEl.textContent = '₹0.00';
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-save me-1"></i> Save Bill';
        paymentStatus.value = 'non_paid';
        semiPaidAmountDiv.style.display = 'none';
        semiPaidAmount.value = '';
        customerSearch.value = '';
        customerIdInput.value = '';
        selectedCustomer = {
            id: '',
            name: '',
            address: '',
            mobile: ''
        };
        customerSearchResults.innerHTML = '';
        renderCart();
    }

    function updateProductStock(cartItems) {
        cartItems.forEach(item => {
            const product = products.find(p => p.id === item.product_id);
            if (product) {
                // Try to match the exact stock entry; fall back to first stock
                const stock = product.stocks.find(s => s.purchase_price === item.purchase_price) ||
                    product.stocks.find(s => s.selling_price === item.price) ||
                    product.stocks[0];
                if (stock) {
                    const qty = parseFloat(item.quantity) || 0;
                    const current = parseFloat(stock.quantity_in_stock) || 0;
                    stock.quantity_in_stock = Math.max(0, current - qty);
                }
            }
        });
        productMap.clear();
        products.forEach(product => {
            productMap.set(String(product.id), product);
        });
    }

    function saveBill() {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        const items = cart.map(item => ({
            product_id: item.product_id,
            name: item.name,
            sku: item.sku,
            brand: item.company,
            category: item.category,
            price: parseFloat(item.price),
            purchase_price: parseFloat(item.purchase_price),
            quantity: parseFloat(item.quantity),
            stock_unit: item.stock_unit,
            unit_amount: parseFloat(item.unit_amount),
            unit: item.unit,
            unit_display: item.unit_display || `${item.unit_amount} ${item.unit}`,
            subtotal: parseFloat(item.price) * parseFloat(item.quantity),
            purches_price: item.purchase_price,

        }));

        const subtotal = items.reduce((sum, item) => sum + item.subtotal, 0);
        const total_amount = subtotal;
        const payment_status = paymentStatus.value;
        const semi_paid_amount = payment_status === 'semi_paid' ? parseFloat(semiPaidAmount.value) || 0 : 0;
        const customer_name = selectedCustomer.name || 'Walk-in Customer';
        const customer_id = selectedCustomer.id || '0';
        const paid_amount = payment_status === 'paid' ? total_amount : payment_status === 'semi_paid' ? semi_paid_amount : 0;
        const remaining_amount = payment_status === 'paid' ? 0 : payment_status === 'semi_paid' ? total_amount - semi_paid_amount : total_amount;
        const payload = {
            _token: '{{ csrf_token() }}',
            items: items,
            subtotal: subtotal,
            discount_percent: 0,
            discount_amount: 0,
            total_amount: total_amount,
            payment_status: payment_status,
            semi_paid_amount: semi_paid_amount,
            paid_amount: paid_amount,
            remaining_amount: remaining_amount,
            customer_id: customerIdInput.value
        };
        console.log(payload);
        fetch('{{ route("admin.bill.save") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const bill = {
                        id: data.bill_number,
                        date: new Date().toISOString(),
                        customer: selectedCustomer.name || 'Walk-in Customer',
                        customer_id: selectedCustomer.id || null,

                        // ADD THESE LINES:
                        shop_mobile: selectedCustomer.mobile || 'N/A',
                        shop_address: selectedCustomer.address || 'N/A',

                        items: items.map(item => ({
                            productId: item.product_id,
                            sku: item.sku,
                            productName: item.name,
                            price: item.price,
                            qty: item.quantity,
                            stock_unit: item.stock_unit,
                            total: item.subtotal
                        })),
                        subtotal: subtotal,
                        discount_percent: 0,
                        discount_amount: 0,
                        total_amount: total_amount,
                        payment_status: payment_status,
                        paid_amount: paid_amount,
                        remaining_amount: remaining_amount
                    };
                    // Update product stock quantities
                    updateProductStock(items);
                    Swal.fire({
                        title: 'Bill Saved!',
                        html: `Bill <strong>#${data.bill_number}</strong> saved successfully.`,
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fas fa-print"></i> Print Receipt',
                        cancelButtonText: 'New Bill',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Print via iframe
                            window.printBill(bill);
                            // Do NOT reset form yet — let user close print first
                        } else {
                            resetBillForm();
                        }
                    });
                } else {
                    throw new Error(data.message || 'Failed to save bill');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'An error occurred while saving the bill. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            })
            .finally(() => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-save me-1"></i> Save Bill';
            });
    }

    productSearch.addEventListener('input', () => {
        renderSearch();
    });

    productSearch.addEventListener('keydown', (e) => {
        const resultItems = searchResults.querySelectorAll('.list-group-item');
        if (resultItems.length === 0) {
            if (e.key === 'Enter') {
                const m = firstMatch();
                if (m) {
                    addToCart(m.product, m.stock);
                    selectedProduct = m.product;
                    productSearch.value = '';
                    searchResults.innerHTML = '';
                }
            }
            return;
        }

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            highlightedIndex = (highlightedIndex + 1) % resultItems.length;
            highlightResult();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            highlightedIndex = (highlightedIndex - 1 + resultItems.length) % resultItems.length;
            highlightResult();
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (highlightedIndex >= 0 && highlightedIndex < resultItems.length) {
                resultItems[highlightedIndex].click();
            } else {
                const m = firstMatch();
                if (m) {
                    addToCart(m.product, m.stock);
                    selectedProduct = m.product;
                    productSearch.value = '';
                    searchResults.innerHTML = '';
                }
            }
        }
    });

    saveBtn.addEventListener('click', saveBill);
    renderCart();
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
    window.Toast = Toast;
    window.currency = function(n) {
        return new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 2
        }).format(n);
    };

    window.billToReceiptHTML = function(bill, options = {
        paperWidth: '80mm',
        fontSize: '11px'
    }) {
        const paperWidth = options.paperWidth || '80mm';
        const fontSize = options.fontSize || '11px';
        const billDate = bill.date ? new Date(bill.date) : new Date();
        //         const rows = bill.items.map((it, index) => {
        //             const unit = it.price || 0;
        //             const line = unit * it.qty;
        //             const name = (it.productName || 'Unknown').slice(0, 28);
        //             return `
        // <tr>
        // <td>${index + 1}</td>
        // <td>${name}</td>
        // <td>${it.qty}</td>
        // <td>${window.currency(unit)}</td>
        // <td>${window.currency(line)}</td>
        // </tr>
        // `;
        const rows = bill.items.map((it, index) => {
            const unit = it.price || 0;
            const line = unit * it.qty;
            const name = it.sku ?
                `${it.sku} - ${it.productName ? it.productName : 'Unknown'}` :
                (it.productName ? it.productName : 'Unknown');
            return `
                <tr>
                    <td class="no-border" style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${index + 1}</td>
                    <td class="no-border text-start" style="word-break:break-all;text-align:left !important;color:black !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${name}</td>
                    <td class="no-border" style="color:black !important; text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${it.qty} ${it.stock_unit}</td>
                    <td class="no-border" style="color:black !important; text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${window.currency(unit)}</td>
                    <td class="no-border" style="text-align:right !important;color:black !important;  vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${window.currency(line)}</td>
                </tr>
                `;

        }).join('');
        const subtotal = bill.subtotal || 0;
        const discountPercent = bill.discount_percent || 0;
        const discountAmount = bill.discount_amount || 0;
        const total = bill.total_amount || 0;
        const paidAmount = bill.paid_amount || 0;
        const remainingAmount = bill.payment_status === 'paid' ? 0 : (bill.remaining_amount || total);
        const paymentStatusText = bill.payment_status === 'paid' ? `Paid (${window.currency(paidAmount)})` :
            bill.payment_status === 'semi_paid' ? `Semi Paid (${window.currency(paidAmount)})` :
            'Non Paid';
        const amountPayable = bill.payment_status === 'paid' ? 0 : remainingAmount;
        return `
            <div id="receipt" class="cash-memo" style=" font-family: Arial, sans-serif;
                    font-weight: 600 !important;width: 100% !important; max-width: 80mm !important; margin: 0 auto !important; padding: 0 !important; border-bottom: 1px dashed black !important; page-break-inside: avoid !important;">
            <div style="text-align:center !important; width:100% important;">
                <h5 style="font-size: 16px !important; border-bottom: 1px dashed #000 !important; margin-top: 0 !important;">CASH MEMO</h5>
               </div>
            <div class="memo-details mb-3" style="gap:0.7rem !important; display:flex !important;margin-bottom:1rem !important;margin-top:1rem !important;">
            <div style="width:50%;">
            <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Name:</strong> ${bill.customer_id ? bill.customer_id + ' - ' : ''}${bill.customer ? (bill.customer.length > 20 ? bill.customer.slice(0, 37) : bill.customer) : 'N/A'}</p>
            <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Mobile:</strong> ${bill.shop_mobile ?? 'N/A'}</p>
            <p style="font-size:14px !important;color:black !important;word-break:break-all;  line-height: 1.2 !important;"><strong>Address:</strong> ${bill.shop_address ?? 'N/A'}</p>
            </div>
            <div style="width:50%;">
            <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Bill NO:</strong> ${bill.id ?? 'N/A'}</p>
            <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Date:</strong> ${billDate.toLocaleDateString('en-IN')}</p>
            <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Time:</strong> ${billDate.toLocaleTimeString('en-IN')}</p>
            </div>
            </div>
                
            <div style="margin-top:1rem !important;">
            <table class="w-100" style="margin-bottom:1rem !important;width: 100% !important; border-collapse: collapse !important;">
            <thead>
            <tr>
            <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">NO.</th>
            <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">NAME</th>
            <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">QTY</th>
            <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">RATE</th>
            <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">TOTAL</th>
            </tr>
            </thead>
            <tbody>
            ${rows}
            </tbody>
            <tfoot>
            <tr>
            <td rowspan="4" colspan="3" class="amount-text" style="color:black !important;border-left:1px solid black !important;border-bottom:1px solid black !important;border-right:none !important;text-align:center !important;">
            <strong>Total Payable:</strong><br>
            <span class="fw-bold fs-4" style="color:black !important;font-size: 22px !important;font-weight: 600 !important;">${window.currency(total)}</span>
            </td>
                
            <td style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">Amount</td>
            <td style="color:black !important;text-align:right !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">${window.currency(subtotal)}</td>
            </tr>
            <!--<tr>
                
            <td>Discount</td>
            <td style="text-align:right !important;">${window.currency(discountAmount)}</td> 
            </tr>-->
            <tr>
                
            <td style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">Paid</td>
            <td style="color:black !important;text-align:right !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">${window.currency(paidAmount)}</td>
            </tr>
            <tr>
                
            <td class="amount-box" style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">Due</td>
            <td class="amount-box" style="color:black !important;text-align:right !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">${window.currency(total - paidAmount)}</td>
            </tr>
            </tfoot>
            </table>
            </div>
            </div>
                
            <style>
           
            @media print {
            @page {
                        size: 80mm auto;
                        margin: 3px;
                        padding: 0;
                    }
                    
                    body {
                        margin: 0 !important;
                        padding: 3px !important;
                        width: 100% !important;
                        background: white !important;
                         font-family: Arial, sans-serif;
                    font-weight: 600 !important;
                        color: black !important;
                        
                        -webkit-print-color-adjust: exact !important;
                        print-color-adjust: exact !important;
                    }
           
            }
            </style>
            `;
    };

    window.printBill = function(bill) {
        const receiptHTML = window.billToReceiptHTML(bill, {
            paperWidth: '80mm',
            fontSize: '11px'
        });

        // Create or reuse hidden iframe
        let iframe = document.getElementById('__receiptPrintIframe');
        if (!iframe) {
            iframe = document.createElement('iframe');
            iframe.id = '__receiptPrintIframe';
            iframe.style.display = 'none';
            document.body.appendChild(iframe);
        }

        const doc = iframe.contentDocument;
        doc.open();
        doc.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <style>
                    *{margin:0;padding:0;box-sizing:border-box}
                    body{font-family:Arial,sans-serif;padding:5mm;color:#000}
                    @page{size:80mm auto;margin:0}
                    @media print{body{padding:3mm}}
                </style>
            </head>
            <body>
                ${receiptHTML}
                <script>
                    // Auto-print after content loads
                    window.onload = () => setTimeout(() => window.print(), 600);
                    
                    // Fallback: if onafterprint not supported (some mobile browsers)
                    setTimeout(() => {
                        if (document.visibilityState === 'hidden') {
                            window.parent.location.reload();
                        }
                    }, 3000);

                    // AFTER PRINT (or cancel) → reload parent page
                    window.onafterprint = () => {
                        setTimeout(() => {
                            window.parent.location.reload();
                        }, 7000);
                    };

                    
                <\/script>
            </body>
            </html>
        `);
        doc.close();

        // Optional: cleanup iframe after 2 minutes
        setTimeout(() => {
            const el = document.getElementById('__receiptPrintIframe');
            if (el) el.remove();
        }, 120000);
    };
</script>

@endsection