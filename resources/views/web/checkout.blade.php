@extends('layout.web.main-layout')

@section('content')
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4 bg-gray-50">
  <div class="container mx-auto">
    <div class="flex flex-col lgg:flex-row gap-8">
      <!-- Left Column: Shipping Form -->
      <div class="flex-1 bg-white rounded-lg shadow-sm p-8">
        <nav class="text-sm text-gray-500 mb-6">
          Cart > Shipping > Payment
        </nav>
        <h1 class="text-2xl font-semibold mb-8">Shipping Address</h1>

        <form id="checkout-form" action="{{ route('checkout.place') }}" method="post" enctype="multipart/form-data" class="space-y-6" novalidate>
          @csrf
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">First Name<sup class="text-danger" style="color: red">*</sup></label>
              @php
              $defaultAddress = $addresses->where('is_default', 1)->first();
              $fullName = $defaultAddress->full_name ?? auth()->user()->name ?? '';
              $firstName = explode(' ', trim($fullName))[0] ?? '';
              $lastName = explode(' ', trim($fullName))[1] ?? '';
              @endphp
              <input
                type="text"
                name="firstName"
                id="firstName"
                value="{{ $firstName }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                required
                minlength="2"
                maxlength="50" />
              <p id="firstName-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid first name (minimum 2 characters)</p>
              <p id="firstName-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid first name</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Last Name<sup class="text-danger" style="color: red">*</sup></label>
              <input
                type="text"
                name="lastName"
                id="lastName"
                value="{{ $lastName }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                required
                minlength="2"
                maxlength="50" />
              <p id="lastName-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid last name (minimum 2 characters)</p>
              <p id="lastName-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid last name</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email<sup class="text-danger" style="color: red">*</sup></label>
              <input
                type="email"
                name="email"
                id="email"
                value="{{ auth()->user()->email ?? '' }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                required />
              <p id="email-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid email address</p>
              <p id="email-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid email</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Phone No<sup class="text-danger" style="color: red">*</sup></label>
              <div class="flex">
                <div class="flex-shrink-0">
                  <select
                    name="country_code_dummy"
                    class="h-full px-3 py-3 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-black bg-gray-50 cursor-not-allowed"
                    disabled
                    aria-disabled="true">
                    <option value="+91" selected>🇮🇳 +91</option>
                  </select>
                  <input type="hidden" name="country_code_dummy" value="+91" disabled>
                </div>
                <input
                  type="tel"
                  name="phone"
                  id="phone"
                  value="{{ $addresses->where('is_default', 1)->first()->phone ?? old('phone') }}"
                  class="w-full px-4 py-3 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-black"
                  placeholder="Enter 10 digit phone number"
                  required
                  maxlength="10"
                  inputmode="numeric" />
              </div>
              <p id="phone-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid 10-digit phone number</p>
              <p id="phone-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid phone number</p>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Address 1<sup class="text-danger" style="color: red">*</sup></label>
            <input
              type="text"
              name="address1"
              id="address1"
              value="{{ $addresses->where('is_default', 1)->first()->address_1 ?? old('address1') }}"
              class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
              placeholder="Street address"
              required
              minlength="5" />
            <p id="address1-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid address (minimum 5 characters)</p>
            <p id="address1-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid address</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Address 2 (optional)</label>
            <input
              type="text"
              name="address2"
              id="address2"
              value="{{ $addresses->where('is_default', 1)->first()->address_2 ?? old('address2') }}"
              class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
              placeholder="Apartment, suite, etc." />
          </div>

          <div class="grid grid-cols-3 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">City<sup class="text-danger" style="color: red">*</sup></label>
              <input
                type="text"
                name="city"
                id="city"
                value="{{ $addresses->where('is_default', 1)->first()->city ?? old('city') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                required
                minlength="2" />
              <p id="city-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid city name</p>
              <p id="city-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid city</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">State<sup class="text-danger" style="color: red">*</sup></label>
              <input
                type="text"
                name="state"
                id="state"
                value="{{ $addresses->where('is_default', 1)->first()->state ?? old('state') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                required
                minlength="2" />
              <p id="state-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid state name</p>
              <p id="state-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid state</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Pin Code<sup class="text-danger" style="color: red">*</sup></label>
              <input
                type="text"
                name="pinCode"
                id="pinCode"
                value="{{ $addresses->where('is_default', 1)->first()->pincode ?? old('pinCode') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                placeholder="Enter 6 digit pincode"
                required
                maxlength="6"
                inputmode="numeric" />
              <p id="pincode-error" class="text-red-500 text-sm mt-1 hidden">Please enter a valid 6-digit pincode</p>
              <p id="pincode-success" class="text-green-500 text-sm mt-1 hidden">✓ Valid pincode</p>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
            <textarea
              name="description"
              id="description"
              rows="3"
              class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
              placeholder="Enter a description...">{{ old('description') }}</textarea>
          </div>
        </form>
      </div>

      <!-- Right Column: Order Summary -->
      <div class="xl:w-102 lgg:w-96 w-full">
        <div class="bg-white rounded-lg shadow-sm p-6">
          <h2 class="text-xl font-semibold mb-6">Your Cart</h2>

          <div class="space-y-6 mb-6">
            @if($carts->count() > 0)
            @php
            $total = 0;
            @endphp
            @foreach($carts as $cart)
            <div class="flex gap-4">
              <div class="w-20 h-20 bg-gray-200 rounded-md flex-shrink-0 border border-gray-300 overflow-hidden">
                @if($cart->image)
                <img src="{{ asset($cart->image) }}" alt="{{ $cart->name }}" class="w-full h-19 object-cover">
                @endif
              </div>
              <div class="flex-1">
                <p class="font-medium">{{ $cart->name }}</p>
                <p class="text-sm text-gray-500">{{ $cart->size ?? 'One Size' }}, {{ $cart->color ?? 'Default' }}</p>
                <p class="text-sm text-gray-500">Qty: {{ $cart->count }}</p>
              </div>
              <p class="font-medium">{{config('app.currency')}}{{ number_format(($cart->price - (($cart->price * $cart->discount) / 100)) * $cart->count), 2 }}</p>
            </div>
            @php
            $total +=(($cart->price - (($cart->price * $cart->discount) / 100)) * $cart->count);
            $shippingCost =0;
            if($total <= 400)
              {
              $shippingCost=0;
              }
              @endphp
              @endforeach
              @else
              <p class="text-gray-500 text-center py-4">Your cart is empty</p>
              @endif
          </div>

          <div class="border-t pt-4 space-y-3">
            <div class="flex items-center gap-3">
              <input
                type="text"
                placeholder="Discount code"
                class="flex-1 px-4 py-3 border border-gray-300 rounded-md focus:outline-none w-full" />
              <button
                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                Apply
              </button>
            </div>

            <div class="space-y-2 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-600">Subtotal</span>
                <span>{{config('app.currency')}}{{ number_format($total, 2) }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600">Shipping</span>
                <span>{{config('app.currency')}}{{$shippingCost}}</span>
              </div>
              <div
                class="flex justify-between font-semibold text-base pt-2 border-t">
                <span>Total</span>
                <span>{{config('app.currency')}}{{ number_format($total+$shippingCost, 2) }}</span>
              </div>
            </div>

            <button
              type="button"
              onclick="submitForm()"
              class="w-full mt-6 py-4 bg-black text-white font-medium rounded-md hover:bg-gray-900 transition"
              @if($carts->count() == 0) disabled
              @endif
              >
              @if($carts->count() > 0)
              Place Order
              @else
              Cart is Empty
              @endif
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  (function() {
    'use strict'

    // Get all form fields
    const form = document.getElementById('checkout-form');
    const firstName = document.getElementById('firstName');
    const lastName = document.getElementById('lastName');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    const address1 = document.getElementById('address1');
    const city = document.getElementById('city');
    const state = document.getElementById('state');
    const pincode = document.getElementById('pinCode');

    // Get error and success elements
    const firstNameError = document.getElementById('firstName-error');
    const firstNameSuccess = document.getElementById('firstName-success');
    const lastNameError = document.getElementById('lastName-error');
    const lastNameSuccess = document.getElementById('lastName-success');
    const emailError = document.getElementById('email-error');
    const emailSuccess = document.getElementById('email-success');
    const phoneError = document.getElementById('phone-error');
    const phoneSuccess = document.getElementById('phone-success');
    const address1Error = document.getElementById('address1-error');
    const address1Success = document.getElementById('address1-success');
    const cityError = document.getElementById('city-error');
    const citySuccess = document.getElementById('city-success');
    const stateError = document.getElementById('state-error');
    const stateSuccess = document.getElementById('state-success');
    const pincodeError = document.getElementById('pincode-error');
    const pincodeSuccess = document.getElementById('pincode-success');

    // Validation functions
    function validateName(value) {
      const trimmed = value.trim();
      return trimmed.length >= 2 && /^[a-zA-Z\s]+$/.test(trimmed);
    }

    function validateEmail(value) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }

    function validatePhone(value) {
      const numericValue = value.replace(/\D/g, '');
      return /^[0-9]{10}$/.test(numericValue);
    }

    function validateAddress(value) {
      return value.trim().length >= 5;
    }

    function validateCityState(value) {
      const trimmed = value.trim();
      return trimmed.length >= 2 && /^[a-zA-Z\s]+$/.test(trimmed);
    }

    function validatePincode(value) {
      const numericValue = value.replace(/\D/g, '');
      return /^[0-9]{6}$/.test(numericValue);
    }

    // Generic validation function for input fields
    function validateField(input, errorEl, successEl, validationFn, errorMessage) {
      const value = input.value;
      
      if (value.trim().length === 0) {
        errorEl.classList.add('hidden');
        successEl.classList.add('hidden');
        input.classList.remove('border-red-500', 'border-green-500');
        return false;
      }

      const isValid = validationFn(value);
      
      if (isValid) {
        errorEl.classList.add('hidden');
        successEl.classList.remove('hidden');
        input.classList.remove('border-red-500');
        input.classList.add('border-green-500');
        return true;
      } else {
        errorEl.classList.remove('hidden');
        successEl.classList.add('hidden');
        input.classList.remove('border-green-500');
        input.classList.add('border-red-500');
        return false;
      }
    }

    // Real-time validation for all fields
    firstName.addEventListener('input', function() {
      validateField(this, firstNameError, firstNameSuccess, validateName);
    });

    lastName.addEventListener('input', function() {
      validateField(this, lastNameError, lastNameSuccess, validateName);
    });

    email.addEventListener('input', function() {
      validateField(this, emailError, emailSuccess, validateEmail);
    });

    phone.addEventListener('input', function() {
      // Remove non-numeric characters
      this.value = this.value.replace(/\D/g, '');
      if (this.value.length > 10) {
        this.value = this.value.slice(0, 10);
      }
      validateField(this, phoneError, phoneSuccess, validatePhone);
    });

    address1.addEventListener('input', function() {
      validateField(this, address1Error, address1Success, validateAddress);
    });

    city.addEventListener('input', function() {
      validateField(this, cityError, citySuccess, validateCityState);
    });

    state.addEventListener('input', function() {
      validateField(this, stateError, stateSuccess, validateCityState);
    });

    pincode.addEventListener('input', function() {
      // Remove non-numeric characters
      this.value = this.value.replace(/\D/g, '');
      if (this.value.length > 6) {
        this.value = this.value.slice(0, 6);
      }
      validateField(this, pincodeError, pincodeSuccess, validatePincode);
    });

    // Prevent paste of non-numeric for phone and pincode
    phone.addEventListener('paste', function(e) {
      e.preventDefault();
      const pastedText = (e.clipboardData || window.clipboardData).getData('text');
      const numericOnly = pastedText.replace(/\D/g, '');
      if (numericOnly.length > 0) {
        this.value = numericOnly.slice(0, 10);
        this.dispatchEvent(new Event('input'));
      }
    });

    pincode.addEventListener('paste', function(e) {
      e.preventDefault();
      const pastedText = (e.clipboardData || window.clipboardData).getData('text');
      const numericOnly = pastedText.replace(/\D/g, '');
      if (numericOnly.length > 0) {
        this.value = numericOnly.slice(0, 6);
        this.dispatchEvent(new Event('input'));
      }
    });

    // Blur validation
    firstName.addEventListener('blur', function() {
      if (this.value.trim().length > 0) {
        validateField(this, firstNameError, firstNameSuccess, validateName);
      }
    });

    lastName.addEventListener('blur', function() {
      if (this.value.trim().length > 0) {
        validateField(this, lastNameError, lastNameSuccess, validateName);
      }
    });

    email.addEventListener('blur', function() {
      if (this.value.trim().length > 0) {
        validateField(this, emailError, emailSuccess, validateEmail);
      }
    });

    phone.addEventListener('blur', function() {
      if (this.value.length > 0) {
        validateField(this, phoneError, phoneSuccess, validatePhone);
      }
    });

    address1.addEventListener('blur', function() {
      if (this.value.trim().length > 0) {
        validateField(this, address1Error, address1Success, validateAddress);
      }
    });

    city.addEventListener('blur', function() {
      if (this.value.trim().length > 0) {
        validateField(this, cityError, citySuccess, validateCityState);
      }
    });

    state.addEventListener('blur', function() {
      if (this.value.trim().length > 0) {
        validateField(this, stateError, stateSuccess, validateCityState);
      }
    });

    pincode.addEventListener('blur', function() {
      if (this.value.length > 0) {
        validateField(this, pincodeError, pincodeSuccess, validatePincode);
      }
    });

    // Form submission
    window.submitForm = function() {
      const form = document.getElementById('checkout-form');
      
      // Validate all fields
      const isFirstNameValid = validateField(firstName, firstNameError, firstNameSuccess, validateName);
      const isLastNameValid = validateField(lastName, lastNameError, lastNameSuccess, validateName);
      const isEmailValid = validateField(email, emailError, emailSuccess, validateEmail);
      const isPhoneValid = validateField(phone, phoneError, phoneSuccess, validatePhone);
      const isAddress1Valid = validateField(address1, address1Error, address1Success, validateAddress);
      const isCityValid = validateField(city, cityError, citySuccess, validateCityState);
      const isStateValid = validateField(state, stateError, stateSuccess, validateCityState);
      const isPincodeValid = validateField(pincode, pincodeError, pincodeSuccess, validatePincode);

      // Check if all fields are valid
      if (isFirstNameValid && isLastNameValid && isEmailValid && isPhoneValid && 
          isAddress1Valid && isCityValid && isStateValid && isPincodeValid) {
        form.submit();
      } else {
        // Scroll to the first invalid field
        const firstInvalid = document.querySelector('.border-red-500');
        if (firstInvalid) {
          firstInvalid.focus();
          firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        // Show all error messages for empty fields
        if (firstName.value.trim().length === 0) {
          firstNameError.classList.remove('hidden');
          firstName.classList.add('border-red-500');
        }
        if (lastName.value.trim().length === 0) {
          lastNameError.classList.remove('hidden');
          lastName.classList.add('border-red-500');
        }
        if (email.value.trim().length === 0) {
          emailError.classList.remove('hidden');
          email.classList.add('border-red-500');
        }
        if (phone.value.length === 0) {
          phoneError.classList.remove('hidden');
          phone.classList.add('border-red-500');
        }
        if (address1.value.trim().length === 0) {
          address1Error.classList.remove('hidden');
          address1.classList.add('border-red-500');
        }
        if (city.value.trim().length === 0) {
          cityError.classList.remove('hidden');
          city.classList.add('border-red-500');
        }
        if (state.value.trim().length === 0) {
          stateError.classList.remove('hidden');
          state.classList.add('border-red-500');
        }
        if (pincode.value.length === 0) {
          pincodeError.classList.remove('hidden');
          pincode.classList.add('border-red-500');
        }
      }
    };

    // Enter key support for form submission
    form.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        window.submitForm();
      }
    });

  })();
</script>
@endsection