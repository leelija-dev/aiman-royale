@extends('layout.web.main-layout')

@section('content')
<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .fashion-gradient {
        background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
    }

    .fashion-gradient-light {
        background: linear-gradient(135deg, #fdf2f8 0%, #faf5ff 100%);
    }

    .fashion-gradient-text {
        background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .sidebar-item.active {
        background: linear-gradient(135deg, #fdf2f8 0%, #faf5ff 100%);
        border-right: 3px solid #a855f7;
        color: #7c3aed;
    }

    .sidebar-item:hover:not(.active) {
        background-color: #f8fafc;
    }

    .address-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .address-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .address-card.default {
        border-color: #a855f7;
        background: linear-gradient(135deg, #fdf4ff 0%, #faf5ff 100%);
    }

    .default-badge {
        background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
    }

    .overlay-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .container-model {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 100000;
    }

    .container-model.active {
        display: block;
    }

    .content-modal {
        transform: scale(0.9);
        opacity: 0;
        transition: all 0.3s ease;
        max-height: 90vh;
        overflow-y: auto;
    }

    .content-modal.active {
        transform: scale(1);
        opacity: 1;
    }

    .input-focus:focus {
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.2);
        border-color: #a855f7;
    }
    
    /* Custom notification styles */
    .custom-notification {
        min-width: 300px;
        max-width: 400px;
    }
</style>

<section class="w-full px-4 lgg:py-12 py-6">
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                    <!-- User Profile Summary -->
                    <div class="text-center mb-8">
                        <div class="relative inline-block mb-4">
                            <div
                                class="w-20 h-20 rounded-full fashion-gradient flex items-center justify-center text-white text-xl font-bold mx-auto">
                                AJ
                            </div>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">Alex Johnson</h2>
                        <p class="text-gray-600 text-sm">Premium Member</p>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="space-y-2">
                        <a
                            href="profile.html"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-user w-5 text-center"></i>
                            <span>Profile Information</span>
                        </a>
                        <a
                            href="orders.html"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-shopping-bag w-5 text-center"></i>
                            <span>Order History</span>
                            <span
                                class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">8</span>
                        </a>
                        <a
                            href="addresses.html"
                            class="sidebar-item active flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-map-marker-alt w-5 text-center"></i>
                            <span>My Addresses</span>
                            <span
                                class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">3</span>
                        </a>
                        <a
                            href="wishlist.html"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-heart w-5 text-center"></i>
                            <span>Wishlist</span>
                            <span
                                class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">12</span>
                        </a>
                        <a
                            href="#"
                            class="sidebar-item flex items-center gap-3 p-3 rounded-lg text-gray-700">
                            <i class="fas fa-credit-card w-5 text-center"></i>
                            <span>Payment Methods</span>
                        </a>
                    </nav>

                    <!-- Address Stats -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="font-medium text-gray-900 mb-4">Address Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Addresses</span>
                                <span class="font-medium">3</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Default Address</span>
                                <span class="font-medium text-purple-600">Home</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Recent Update</span>
                                <span class="font-medium">2 days ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Page Header -->
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">My Addresses</h1>
                            <p class="text-gray-600 mt-1">
                                Manage your shipping addresses for faster checkout
                            </p>
                        </div>
                        <button
                            id="addAddressBtn"
                            class="mt-4 sm:mt-0 px-6 py-3 fashion-gradient text-white rounded-xl hover:shadow-lg transition duration-200 font-medium flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            Add New Address
                        </button>
                    </div>
                </div>

                <!-- Address Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Default Address Card -->
                    <div
                        class="address-card default bg-white rounded-2xl shadow-sm p-6 relative">
                        <div class="absolute top-4 right-4">
                            <span
                                class="default-badge text-white text-xs px-3 py-1 rounded-full font-medium">
                                <i class="fas fa-star mr-1"></i>Default
                            </span>
                        </div>

                        <div class="mb-4">
                            <h3 class="font-bold text-gray-900 text-lg">Home</h3>
                            <p class="text-gray-600 text-sm">Primary Residence</p>
                        </div>

                        <div class="space-y-2 text-gray-700">
                            <p class="font-medium">Alex Johnson</p>
                            <p>123 Fashion Avenue</p>
                            <p>Apartment 4B</p>
                            <p>New York, NY 10001</p>
                            <p>United States</p>
                            <div class="pt-2">
                                <p class="font-medium">
                                    <i class="fas fa-phone text-gray-400 mr-2"></i>
                                    +1 (555) 123-4567
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200">
                            <button
                                class="edit-address-btn flex-1 py-2 bg-purple-100 text-purple-700 rounded-xl hover:bg-purple-200 transition text-sm font-medium flex items-center justify-center gap-2"
                                data-address="home">
                                <i class="fas fa-edit"></i>
                                Edit
                            </button>
                            <button class="remove-address-btn flex-1 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium flex items-center justify-center gap-2">
                                <i class="fas fa-trash"></i>
                                Remove
                            </button>
                        </div>
                    </div>

                    <!-- Work Address Card -->
                    <div
                        class="address-card bg-white rounded-2xl shadow-sm p-6 relative">
                        <div class="mb-4">
                            <h3 class="font-bold text-gray-900 text-lg">Work</h3>
                            <p class="text-gray-600 text-sm">Office Address</p>
                        </div>

                        <div class="space-y-2 text-gray-700">
                            <p class="font-medium">Alex Johnson</p>
                            <p>456 Business District</p>
                            <p>Floor 15, Suite 1502</p>
                            <p>New York, NY 10005</p>
                            <p>United States</p>
                            <div class="pt-2">
                                <p class="font-medium">
                                    <i class="fas fa-phone text-gray-400 mr-2"></i>
                                    +1 (555) 987-6543
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200">
                            <button
                                class="edit-address-btn flex-1 py-2 bg-purple-100 text-purple-700 rounded-xl hover:bg-purple-200 transition text-sm font-medium flex items-center justify-center gap-2"
                                data-address="work">
                                <i class="fas fa-edit"></i>
                                Edit
                            </button>
                            <button
                                class="set-default-btn flex-1 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium flex items-center justify-center gap-2">
                                <i class="fas fa-star"></i>
                                Set Default
                            </button>
                        </div>
                    </div>

                    <!-- Parents Address Card -->
                    <div
                        class="address-card bg-white rounded-2xl shadow-sm p-6 relative">
                        <div class="mb-4">
                            <h3 class="font-bold text-gray-900 text-lg">
                                Parents' House
                            </h3>
                            <p class="text-gray-600 text-sm">Family Address</p>
                        </div>

                        <div class="space-y-2 text-gray-700">
                            <p class="font-medium">Alex Johnson</p>
                            <p>789 Suburban Lane</p>
                            <p>Hillside Residence</p>
                            <p>Brooklyn, NY 11201</p>
                            <p>United States</p>
                            <div class="pt-2">
                                <p class="font-medium">
                                    <i class="fas fa-phone text-gray-400 mr-2"></i>
                                    +1 (555) 456-7890
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200">
                            <button
                                class="edit-address-btn flex-1 py-2 bg-purple-100 text-purple-700 rounded-xl hover:bg-purple-200 transition text-sm font-medium flex items-center justify-center gap-2"
                                data-address="parents">
                                <i class="fas fa-edit"></i>
                                Edit
                            </button>
                            <button
                                class="set-default-btn flex-1 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium flex items-center justify-center gap-2">
                                <i class="fas fa-star"></i>
                                Set Default
                            </button>
                        </div>
                    </div>

                    <!-- Add New Address Card -->
                    <div
                        class="address-card bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border-2 border-dashed border-gray-300 p-6 flex flex-col items-center justify-center min-h-64 hover:border-purple-400 hover:bg-purple-50 transition duration-300 cursor-pointer"
                        id="addNewAddressCard">
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                                <i class="fas fa-plus text-2xl text-purple-600"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 text-lg mb-2">
                                Add New Address
                            </h3>
                            <p class="text-gray-600 text-sm">
                                Create a new shipping address
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add/Edit Address Modal -->
<div id="addressModalContainer" class="container-model z-[100000]">
    <div class="overlay-modal">
        <div class="content-modal bg-white rounded-2xl shadow-2xl w-full max-w-5xl" id="addressModalContent">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900" id="modalTitle">Add New Address</h2>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <form id="addressForm" class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address Label</label>
                        <select id="addressLabel" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus">
                            <option value="">Select Label</option>
                            <option value="home">Home</option>
                            <option value="work">Work</option>
                            <option value="parents">Parents' House</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Custom Label</label>
                        <input type="text" id="customLabel" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" placeholder="Enter custom label">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" id="firstName" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" value="Alex" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" id="lastName" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" value="Johnson" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
                    <input type="text" id="streetAddress" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" placeholder="123 Main Street" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Apartment, Suite, Unit (Optional)</label>
                    <input type="text" id="apartment" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" placeholder="Apt 4B">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                        <input type="text" id="city" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" value="New York" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
                        <select id="state" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" required>
                            <option value="NY" selected>New York</option>
                            <option value="CA">California</option>
                            <option value="TX">Texas</option>
                            <option value="FL">Florida</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ZIP Code</label>
                        <input type="text" id="zipCode" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" value="10001" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <select id="country" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" required>
                        <option value="US" selected>United States</option>
                        <option value="CA">Canada</option>
                        <option value="UK">United Kingdom</option>
                        <option value="AU">Australia</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" id="phoneNumber" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" value="+1 (555) 123-4567" required>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" id="setDefault" class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="setDefault" class="text-sm text-gray-700 cursor-pointer">
                        Set as default shipping address
                    </label>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" id="cancelBtn" class="flex-1 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 py-3 fashion-gradient text-white rounded-xl hover:shadow-lg transition font-medium">
                        Save Address
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Address Modal functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Get modal elements
        const modalContainer = document.getElementById('addressModalContainer');
        const modalContent = document.getElementById('addressModalContent');
        const addAddressBtn = document.getElementById('addAddressBtn');
        const addNewAddressCard = document.getElementById('addNewAddressCard');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const editButtons = document.querySelectorAll('.edit-address-btn');
        const setDefaultButtons = document.querySelectorAll('.set-default-btn');
        const addressForm = document.getElementById('addressForm');
        const modalTitle = document.getElementById('modalTitle');
        const removeButtons = document.querySelectorAll('.remove-address-btn');

        // Form fields
        const addressLabel = document.getElementById('addressLabel');
        const customLabel = document.getElementById('customLabel');
        const firstName = document.getElementById('firstName');
        const lastName = document.getElementById('lastName');
        const streetAddress = document.getElementById('streetAddress');
        const apartment = document.getElementById('apartment');
        const city = document.getElementById('city');
        const state = document.getElementById('state');
        const zipCode = document.getElementById('zipCode');
        const country = document.getElementById('country');
        const phoneNumber = document.getElementById('phoneNumber');
        const setDefaultCheckbox = document.getElementById('setDefault');

        // Open modal for adding new address
        function openModal() {
            modalContainer.classList.add('active');
            setTimeout(() => {
                modalContent.classList.add('active');
            }, 10);
            modalTitle.textContent = 'Add New Address';
            resetForm();
        }

        // Reset form to default values
        function resetForm() {
            addressForm.reset();
            addressLabel.value = '';
            customLabel.value = '';
            firstName.value = 'Alex';
            lastName.value = 'Johnson';
            streetAddress.value = '';
            apartment.value = '';
            city.value = 'New York';
            state.value = 'NY';
            zipCode.value = '10001';
            country.value = 'US';
            phoneNumber.value = '+1 (555) 123-4567';
            setDefaultCheckbox.checked = false;
        }

        // Open modal for editing address
        function openEditModal(addressType) {
            modalContainer.classList.add('active');
            setTimeout(() => {
                modalContent.classList.add('active');
            }, 10);
            modalTitle.textContent = 'Edit Address';
            
            // Populate form with sample data based on address type
            if (addressType === 'home') {
                addressLabel.value = 'home';
                customLabel.value = '';
                firstName.value = 'Alex';
                lastName.value = 'Johnson';
                streetAddress.value = '123 Fashion Avenue';
                apartment.value = 'Apartment 4B';
                city.value = 'New York';
                state.value = 'NY';
                zipCode.value = '10001';
                country.value = 'US';
                phoneNumber.value = '+1 (555) 123-4567';
                setDefaultCheckbox.checked = true;
            } else if (addressType === 'work') {
                addressLabel.value = 'work';
                customLabel.value = '';
                firstName.value = 'Alex';
                lastName.value = 'Johnson';
                streetAddress.value = '456 Business District';
                apartment.value = 'Floor 15, Suite 1502';
                city.value = 'New York';
                state.value = 'NY';
                zipCode.value = '10005';
                country.value = 'US';
                phoneNumber.value = '+1 (555) 987-6543';
                setDefaultCheckbox.checked = false;
            } else if (addressType === 'parents') {
                addressLabel.value = 'parents';
                customLabel.value = '';
                firstName.value = 'Alex';
                lastName.value = 'Johnson';
                streetAddress.value = '789 Suburban Lane';
                apartment.value = 'Hillside Residence';
                city.value = 'Brooklyn';
                state.value = 'NY';
                zipCode.value = '11201';
                country.value = 'US';
                phoneNumber.value = '+1 (555) 456-7890';
                setDefaultCheckbox.checked = false;
            }
        }

        // Close modal
        function closeModalFunc() {
            modalContent.classList.remove('active');
            setTimeout(() => {
                modalContainer.classList.remove('active');
            }, 300);
        }

        // Event listeners for opening modal
        addAddressBtn.addEventListener('click', openModal);
        addNewAddressCard.addEventListener('click', openModal);
        
        // Event listeners for closing modal
        closeModal.addEventListener('click', closeModalFunc);
        cancelBtn.addEventListener('click', closeModalFunc);

        // Close modal when clicking outside
        modalContainer.addEventListener('click', function(e) {
            if (e.target === modalContainer || e.target.classList.contains('overlay-modal')) {
                closeModalFunc();
            }
        });

        // Edit address buttons
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const addressType = this.getAttribute('data-address');
                openEditModal(addressType);
            });
        });

        // Set default address buttons
        setDefaultButtons.forEach(button => {
            button.addEventListener('click', function() {
                const addressCard = this.closest('.address-card');
                const addressName = addressCard.querySelector('h3').textContent;
                
                // Remove default from all cards
                document.querySelectorAll('.address-card').forEach(card => {
                    card.classList.remove('default');
                    const badge = card.querySelector('.default-badge');
                    if (badge) {
                        badge.remove();
                    }
                });
                
                // Add default to clicked card
                addressCard.classList.add('default');
                
                // Check if badge container exists, if not create it
                let badgeContainer = addressCard.querySelector('.absolute.top-4.right-4');
                if (!badgeContainer) {
                    badgeContainer = document.createElement('div');
                    badgeContainer.className = 'absolute top-4 right-4';
                    addressCard.appendChild(badgeContainer);
                }
                
                badgeContainer.innerHTML = 
                    '<span class="default-badge text-white text-xs px-3 py-1 rounded-full font-medium">' +
                    '<i class="fas fa-star mr-1"></i>Default</span>';
                
                showNotification(`${addressName} set as default address`, 'success');
            });
        });

        // Form submission
        addressForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const isEdit = modalTitle.textContent === 'Edit Address';
            closeModalFunc();
            showNotification(`Address ${isEdit ? 'updated' : 'saved'} successfully!`, 'success');
        });

        // Remove address functionality
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const addressCard = this.closest('.address-card');
                const addressName = addressCard.querySelector('h3').textContent;

                if (confirm(`Are you sure you want to remove the "${addressName}" address?`)) {
                    addressCard.style.opacity = '0';
                    addressCard.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        addressCard.remove();
                        showNotification('Address removed successfully', 'success');
                    }, 300);
                }
            });
        });

        // Prevent body scroll when modal is open
        document.addEventListener('keydown', function(e) {
            if (modalContainer.classList.contains('active') && e.key === 'Escape') {
                closeModalFunc();
            }
        });
    });

    // Notification function
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.custom-notification');
        existingNotifications.forEach(notification => {
            notification.remove();
        });

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `custom-notification fixed top-4 right-4 z-[10000] p-4 rounded-xl shadow-lg transform transition-all duration-300 ${
            type === 'error' ? 'bg-red-50 text-red-800 border border-red-200' : 
            type === 'success' ? 'bg-green-50 text-green-800 border border-green-200' :
            'bg-blue-50 text-blue-800 border border-blue-200'
        }`;
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas ${
                    type === 'error' ? 'fa-exclamation-circle text-red-500' : 
                    type === 'success' ? 'fa-check-circle text-green-500' :
                    'fa-info-circle text-blue-500'
                }"></i>
                <span class="font-medium">${message}</span>
                <button class="ml-4 text-gray-400 hover:text-gray-600 close-notification">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateX(0)';
        }, 10);

        // Close button functionality
        notification.querySelector('.close-notification').addEventListener('click', function() {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        });

        // Auto-remove after 4 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300);
            }
        }, 4000);
    }
</script>
@endsection