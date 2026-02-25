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
                @include('components.web.profile-sidebar')
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
                    @forelse($addresses as $address)
                    <div class="address-card bg-white rounded-2xl shadow-sm p-6 relative {{ $address->is_default ? 'default' : '' }}">
                        <div class="absolute top-4 right-4">
                            @if($address->is_default)
                            <span class="default-badge text-white text-xs px-3 py-1 rounded-full font-medium">
                                <i class="fas fa-star mr-1"></i>Default
                            </span>
                            @endif
                        </div>

                        <div class="mb-4">
                            <!-- <h3 class="font-bold text-gray-900 text-lg">{{ $address->name ?? 'Untitled Address' }}</h3> -->
                            @if($address->address_type)
                            <p class="text-gray-600 text-sm">{{ ucfirst($address->address_type) }} Address</p>
                            @endif
                        </div>

                        <div class="space-y-2 text-gray-700">
                            <p class="font-medium">{{ $address->full_name ?? 'N/A' }}</p>
                            @if($address->phone)
                            <p class="font-medium">
                                <i class="fas fa-phone text-gray-400 mr-2"></i>
                                {{ $address->phone }}
                            </p>
                            @endif
                            @if($address->phone_no)
                            <p class="font-medium">
                                <i class="fas fa-phone-alt text-gray-400 mr-2"></i>
                                {{ $address->phone_no }}
                            </p>
                            @endif
                            <p>
                                <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                {{ $address->address_1 }}{{ $address->address_2 ? ', ' . $address->address_2 : '' }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                            </p>
                            @if($address->country)
                            <p class="text-sm text-gray-600">{{ $address->country }}</p>
                            @endif
                            @if($address->pincode)
                            <p class="font-medium pt-2">
                                <i class="fas fa-lock text-gray-400 mr-2"></i>
                                PIN: {{ $address->pincode }}
                            </p>
                            @endif
                            @if($address->landmark)
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-landmark text-gray-400 mr-2"></i>
                                {{ $address->landmark }}
                            </p>
                            @endif
                        </div>

                        <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200">
                            <button
                                class="edit-address-btn flex-1 py-2 bg-purple-100 text-purple-700 rounded-xl hover:bg-purple-200 transition text-sm font-medium flex items-center justify-center gap-2"
                                data-address-id="{{ $address->id }}"
                                onclick='openEditModal({{ json_encode([
                                    "id" => $address->id,
                                    "full_name" => $address->full_name,
                                    "phone" => $address->phone,
                                    "address_1" => $address->address_1,
                                    "address_2" => $address->address_2,
                                    "city" => $address->city,
                                    "state" => $address->state,
                                    "country" => $address->country,
                                    "pincode" => $address->pincode,
                                    "landmark" => $address->landmark,
                                    "address_type" => $address->address_type,
                                    "is_default" => $address->is_default
                                ]) }})'>
                                <i class="fas fa-edit"></i>
                                Edit
                            </button>
                            <button
                                class="remove-address-btn flex-1 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium flex items-center justify-center gap-2"
                                onclick="deleteAddress({{ $address->id }})">
                                <i class="fas fa-trash"></i>
                                Remove
                            </button>
                            @if(!$address->is_default)
                            <button
                                class="set-default-btn flex-1 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-sm font-medium flex items-center justify-center gap-2"
                                onclick="setDefaultAddress({{ $address->id }})">
                                <i class="fas fa-star"></i>
                                Set Default
                            </button>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                            <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-map-marker-alt text-3xl text-purple-600"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                No addresses found
                            </h3>
                            <p class="text-gray-600 mb-6">
                                Add your first address to get started
                            </p>
                            <button id="addAddressBtnEmpty" class="px-8 py-3 fashion-gradient text-white rounded-xl hover:shadow-lg transition font-medium">
                                <i class="fas fa-plus mr-2"></i>
                                Add New Address
                            </button>
                        </div>
                    </div>
                    @endforelse
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

            <form id="addressForm" class="p-6 space-y-6" method="POST" action="{{ route('addresses.store') }}" >
                @csrf
                <input type="hidden" id="addressId" name="address_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address Label</label>
                        <select id="addressLabel" name="address_type" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus">
                            <option value="">Select Label</option>
                            <option value="home">Home</option>
                            <option value="work">Work</option>
                            <option value="parents">Parents' House</option>
                            <option value="other">Other</option>
                        </select>
                        @error('address_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="fullName" name="full_name" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" placeholder="Enter full name" >
                        
                        @error('full_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address 1</label>
                    <input type="text" id="streetAddress" name="address_1" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" placeholder="123 Main Street" >
                         @error('address_1')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address 2</label>
                    <input type="text" id="apartment" name="address_2" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" placeholder="Apt 4B">
                    @error('address_2')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Landmark (Optional)</label>
                        <input type="text" id="landmark" name="landmark" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" placeholder="Near hospital, park, etc.">
                    @error('landmark')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                        <input type="text" id="country" name="country" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" placeholder="Country" >
                        @error('country')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                        <input type="text" id="city" name="city" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" placeholder="City" >
                        @error('city')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
                        <input type="text" id="state" name="state" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" placeholder="State" >
                        @error('state')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pincode</label>
                        <input type="text" id="pincode" name="pincode" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" placeholder="Enter pincode">
                        @error('pincode')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>



                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Primary Phone Number</label>
                        <input type="tel" id="phoneNumber" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" placeholder="+1 (555) 123-4567" >
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alternate Phone (Optional)</label>
                        <input type="tel" id="altPhoneNumber" name="phone_no" class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus" placeholder="+1 (555) 987-6543">
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" id="setDefault" name="is_default" class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
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
        const addAddressBtnEmpty = document.getElementById('addAddressBtnEmpty');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const addressForm = document.getElementById('addressForm');
        const modalTitle = document.getElementById('modalTitle');

        // Form fields
        const addressId = document.getElementById('addressId');
        const addressLabel = document.getElementById('addressLabel');
        const customLabel = document.getElementById('customLabel');
        const fullName = document.getElementById('fullName');
        const streetAddress = document.getElementById('streetAddress');
        const apartment = document.getElementById('apartment');
        const landmark = document.getElementById('landmark');
        const city = document.getElementById('city');
        const state = document.getElementById('state');
        const country = document.getElementById('country');
        const pincode = document.getElementById('pincode');
        const phoneNumber = document.getElementById('phoneNumber');
        const altPhoneNumber = document.getElementById('altPhoneNumber');
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
            addressId.value = '';
            addressLabel.value = '';
            fullName.value = '';
            streetAddress.value = '';
            apartment.value = '';
            landmark.value = '';
            city.value = '';
            state.value = '';
            country.value = '';
            pincode.value = '';
            phoneNumber.value = '';
            altPhoneNumber.value = '';
            setDefaultCheckbox.checked = false;

            // Update form action for create
            addressForm.action = '{{ route("addresses.store") }}';
            addressForm.method = 'POST';
            
            // Remove any existing method input
            const existingMethodInput = addressForm.querySelector('input[name="_method"]');
            if (existingMethodInput) {
                existingMethodInput.remove();
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
        if (addAddressBtn) addAddressBtn.addEventListener('click', openModal);
        if (addAddressBtnEmpty) addAddressBtnEmpty.addEventListener('click', openModal);

        // Event listeners for closing modal
        if (closeModal) closeModal.addEventListener('click', closeModalFunc);
        if (cancelBtn) cancelBtn.addEventListener('click', closeModalFunc);

        // Close modal when clicking outside
        modalContainer.addEventListener('click', function(e) {
            if (e.target === modalContainer || e.target.classList.contains('overlay-modal')) {
                closeModalFunc();
            }
        });

        // Form submission
        if (addressForm) {
            addressForm.addEventListener('submit', function(e) {
                const isEdit = modalTitle.textContent === 'Edit Address';

                // Allow form to submit normally
                // The notification will show after redirect
                console.log('Form submitting:', isEdit ? 'edit' : 'create');
            });
        }

        // Prevent body scroll when modal is open
        document.addEventListener('keydown', function(e) {
            if (modalContainer.classList.contains('active') && e.key === 'Escape') {
                closeModalFunc();
            }
        });
    });

    // Open edit modal function
    function openEditModal(addressData) {
        const modalContainer = document.getElementById('addressModalContainer');
        const modalContent = document.getElementById('addressModalContent');
        const modalTitle = document.getElementById('modalTitle');
        const addressForm = document.getElementById('addressForm');

        // Parse address data if it's a string
        if (typeof addressData === 'string') {
            try {
                addressData = JSON.parse(addressData);
            } catch (e) {
                console.error('Error parsing address data:', e);
                return;
            }
        }

        modalContainer.classList.add('active');
        setTimeout(() => {
            modalContent.classList.add('active');
        }, 10);
        modalTitle.textContent = 'Edit Address';

        // Update form for edit
        addressForm.action = '{{ route("addresses.update", ":id") }}'.replace(':id', addressData.id);
        addressForm.method = 'POST';

        // Add method spoofing for PUT
        let methodInput = addressForm.querySelector('input[name="_method"]');
        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            addressForm.appendChild(methodInput);
        }
        methodInput.value = 'PUT';

        // Populate form with address data
        document.getElementById('addressId').value = addressData.id || '';
        document.getElementById('addressLabel').value = addressData.address_type || '';
        document.getElementById('fullName').value = addressData.full_name || '';
        document.getElementById('streetAddress').value = addressData.address_1 || '';
        document.getElementById('apartment').value = addressData.address_2 || '';
        document.getElementById('landmark').value = addressData.landmark || '';
        document.getElementById('city').value = addressData.city || '';
        document.getElementById('state').value = addressData.state || '';
        document.getElementById('country').value = addressData.country || '';
        document.getElementById('pincode').value = addressData.pincode || '';
        document.getElementById('phoneNumber').value = addressData.phone || '';
        document.getElementById('altPhoneNumber').value = addressData.phone_no || '';
        document.getElementById('setDefault').checked = addressData.is_default ? true : false;
    }

    // Delete address function
    // Delete address function
   
function deleteAddress(addressId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to remove this address!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("addresses.destroy", ":id") }}'.replace(':id', addressId);
            form.style.display = 'none';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            document.body.appendChild(form);
            form.submit();
        }
    });
}
    // Set default address function
    function setDefaultAddress(addressId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("addresses.default", ":id") }}'.replace(':id', addressId);
        form.style.display = 'none';

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        document.body.appendChild(form);
        form.submit();
    }

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