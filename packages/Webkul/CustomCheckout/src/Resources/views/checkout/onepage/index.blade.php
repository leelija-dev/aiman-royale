<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.checkout.onepage.index.checkout')" />
    <meta name="keywords" content="@lang('shop::app.checkout.onepage.index.checkout')" />
    <meta http-equiv="Permissions-Policy" content="unload=(self)" />
@endpush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false">
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.onepage.index.checkout')
    </x-slot>

    {!! view_render_event('bagisto.shop.checkout.onepage.header.before') !!}

    <!-- Page Header -->
    <div class="flex-wrap">
        <div class="flex w-full justify-between border border-b border-l-0 border-r-0 border-t-0 px-[60px] py-4 max-lg:px-8 max-sm:px-4">
            <div class="flex items-center gap-x-14 max-[1180px]:gap-x-9">
                <a
                    href="{{ route('shop.home.index') }}"
                    class="flex min-h-[30px]"
                    aria-label="@lang('shop::app.checkout.onepage.index.bagisto')">
                    <img
                        src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                        alt="{{ config('app.name') }}"
                        width="131"
                        height="29">
                </a>
            </div>

            @guest('customer')
                @include('shop::checkout.login')
            @endguest
        </div>
    </div>

    {!! view_render_event('bagisto.shop.checkout.onepage.header.after') !!}

    <!-- Page Content -->
    <div class="container px-[60px] max-lg:px-8 max-sm:px-4">
        {!! view_render_event('bagisto.shop.checkout.onepage.breadcrumbs.before') !!}

        <!-- Breadcrumbs -->
        @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
            <x-shop::breadcrumbs name="checkout" />
        @endif

        {!! view_render_event('bagisto.shop.checkout.onepage.breadcrumbs.after') !!}

        <!-- Checkout Vue Component -->
        <v-checkout>
            <!-- Shimmer Effect -->
            <x-shop::shimmer.checkout.onepage />
        </v-checkout>
    </div>

    @pushOnce('scripts')
        <script type="text/x-template" id="v-checkout-template">
            <template v-if="isLoading">
                <!-- Show shimmer effect while loading -->
                <div class="grid grid-cols-[1fr_auto] gap-8 max-lg:grid-cols-[1fr] max-md:gap-5">
                    <div class="max-sm:hidden">
                        <!-- Billing Address Shimmer -->
                        <div class="mb-7 mt-8">
                            <div class="mb-4 h-7 w-48 rounded-2xl bg-gray-100"></div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="h-12 rounded-xl bg-gray-100"></div>
                                <div class="h-12 rounded-xl bg-gray-100"></div>
                                <div class="h-12 rounded-xl bg-gray-100"></div>
                                <div class="h-12 rounded-xl bg-gray-100"></div>
                                <div class="h-12 rounded-xl bg-gray-100"></div>
                                <div class="h-12 rounded-xl bg-gray-100"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Summary Shimmer -->
                    <div class="sticky top-8 block h-max w-[442px] max-w-full max-lg:max-w-[442px] ltr:pl-8 max-lg:ltr:pl-0 rtl:pr-8 max-lg:rtl:pr-0">
                        <div class="h-96 rounded-2xl bg-gray-100"></div>
                    </div>
                </div>
            </template>

            <template v-else>
                <div class="grid grid-cols-[1fr_auto] gap-8 max-lg:grid-cols-[1fr] max-md:gap-5">
                    <!-- Hidden shipping step (required for calculations) -->
                    <div class="shipping-step">
                        <template v-if="shippingMethods.length">
                            <div v-for="(method, index) in shippingMethods" :key="index">
                                <input 
                                    type="radio" 
                                    :id="'shipping-method-' + index"
                                    v-model="selectedShippingMethod" 
                                    :value="method.method"
                                    @change="saveShippingMethod(method)"
                                >
                                <label :for="'shipping-method-' + index">
                                    @{{ method.method_title }} - @{{ method.formatted_price }}
                                </label>
                            </div>
                        </template>
                    </div>

                    <!-- Main content -->
                    <div class="overflow-y-auto max-md:grid max-md:gap-4" id="steps-container">
                        <!-- Address Step -->
                        <template v-if="['address', 'payment'].includes(currentStep)">
                            @include('shop::checkout.onepage.address')
                        </template>

                        <!-- Payment Step -->
                        <template v-if="currentStep === 'payment'">
                            <!-- Payment Methods Component -->
                            <div class="mb-7 max-md:last:!mb-0">
                                <template v-if="! paymentMethods">
                                    <!-- Payment Method shimmer Effect -->
                                    <x-shop::shimmer.checkout.onepage.payment-method />
                                </template>
                        
                                <template v-else>
                                    <div class="flex flex-wrap gap-7 max-md:gap-4 max-sm:gap-2.5">
                                        <div 
                                            class="relative cursor-pointer max-md:max-w-full max-md:flex-auto"
                                            v-for="(payment, index) in filteredPaymentMethods"
                                        >
                                            <input 
                                                type="radio" 
                                                name="payment[method]" 
                                                :value="payment.method"
                                                :id="payment.method"
                                                class="peer hidden"
                                                @change="selectPaymentMethod(payment)"
                                            >
                        
                                            <label 
                                                :for="payment.method" 
                                                class="icon-radio-unselect peer-checked:icon-radio-select absolute top-5 cursor-pointer text-2xl text-navyBlue ltr:right-5 rtl:left-5"
                                            >
                                            </label>

                                            <label 
                                                :for="payment.method" 
                                                class="block w-[190px] cursor-pointer rounded-xl border border-zinc-200 p-5 max-md:flex max-md:w-full max-md:gap-5 max-md:rounded-lg max-sm:gap-4 max-sm:px-4 max-sm:py-2.5"
                                            >
                                                <img
                                                    class="max-h-11 max-w-14"
                                                    :src="payment.image"
                                                    width="55"
                                                    height="55"
                                                    :alt="payment.method_title"
                                                    :title="payment.method_title"
                                                />

                                                <div>
                                                    <p class="mt-1.5 text-sm font-semibold max-md:mt-1 max-sm:mt-0">
                                                        @{{ payment.method_title }}
                                                    </p>
                                                    
                                                    <p class="mt-2.5 text-xs font-medium text-zinc-500 max-md:mt-1 max-sm:mt-0">
                                                        @{{ payment.description }}
                                                    </p> 
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                    <!-- Order Summary -->
                    <div class="sticky top-8 block h-max w-[442px] max-w-full max-lg:w-auto max-lg:max-w-[442px] ltr:pl-8 max-lg:ltr:pl-0 rtl:pr-8 max-lg:rtl:pr-0">
                        <!-- Desktop Summary -->
                        <div class="block max-md:hidden">
                            @include('shop::checkout.onepage.summary')
                        </div>
                        
                        <!-- Mobile Summary -->
                        <div class="hidden max-md:block">
                            @include('shop::checkout.onepage.summary')
                        </div>

                        <!-- Place Order Button -->
                        <div class="flex justify-end" v-if="canPlaceOrder">
                            <button
                                type="button"
                                class="primary-button w-max rounded-2xl bg-navyBlue px-11 py-3 max-md:mb-4 max-md:w-full max-md:max-w-full max-md:rounded-lg max-sm:py-1.5 text-white"
                                v-bind:disabled="isPlacingOrder"
                                v-on:click="placeOrder"
                            >
                                <span v-if="isPlacingOrder">Placing Order...</span>
                                <span v-else>Place Order</span>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </script>

        <script type="module">
            app.component('v-checkout', {
                template: '#v-checkout-template',

                data() {
                    return {
                        cart: null,
                        displayTax: {
                            prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",
                            subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",
                            shipping: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_shipping_amount') }}",
                        },
                        isPlacingOrder: false,
                        currentStep: 'address',
                        paymentMethods: null,
                        canPlaceOrder: false,
                        shippingMethods: [],
                        selectedShippingMethod: null,
                        selectedPaymentMethod: null,
                        isLoading: true
                    }
                },

                computed: {
                    filteredPaymentMethods() {
                        if (!this.paymentMethods) return [];
                        // Filter out all PayPal payment methods
                        return this.paymentMethods.filter(payment => {
                            return !payment.method.includes('paypal');
                        });
                    }
                },

                async mounted() {
                    await this.getCart();
                    this.isLoading = false;
                },

                methods: {
                    async getCart() {
                        try {
                            const response = await this.$axios.get("{{ route('shop.checkout.onepage.summary') }}");
                            this.cart = response.data.data;
                            
                            // If no shipping method is set, try to set free shipping
                            if (this.cart && !this.cart.shipping_method) {
                                await this.setFreeShipping();
                            }
                            
                            this.scrollToCurrentStep();
                        } catch (error) {
                            console.error('Error fetching cart:', error);
                        }
                    },

                    async setFreeShipping() {
                        try {
                            // Directly set free shipping method without estimating
                            console.log('Setting free shipping method...');
                            
                            const response = await this.$axios.post("{{ route('shop.checkout.onepage.shipping_methods.store') }}", {
                                shipping_method: 'free_free'
                            });
                            
                            console.log('Free shipping set successfully:', response.data);
                            
                            // IMPORTANT: Capture payment methods from the response
                            if (response.data && response.data.payment_methods) {
                                this.paymentMethods = response.data.payment_methods;
                                console.log('Payment methods captured:', this.paymentMethods);
                            }
                            
                            // Refresh cart data
                            await this.getCart();
                            return true;
                        } catch (error) {
                            console.error('Error setting free shipping:', error);
                            
                            // Check if error response has more details
                            if (error.response && error.response.data) {
                                console.error('Error details:', error.response.data);
                                console.error('Validation errors:', error.response.data.errors);
                                
                                // Try with different shipping method names
                                const alternativeMethods = ['free', 'flatrate_flatrate', 'tablerate_tablerate'];
                                
                                for (const method of alternativeMethods) {
                                    try {
                                        console.log(`Trying alternative shipping method: ${method}`);
                                        const altResponse = await this.$axios.post("{{ route('shop.checkout.onepage.shipping_methods.store') }}", {
                                            shipping_method: method
                                        });
                                        console.log(`Alternative method ${method} set successfully:`, altResponse.data);
                                        
                                        // Capture payment methods from alternative response
                                        if (altResponse.data && altResponse.data.payment_methods) {
                                            this.paymentMethods = altResponse.data.payment_methods;
                                            console.log('Payment methods captured from alternative:', this.paymentMethods);
                                        }
                                        
                                        await this.getCart();
                                        return true;
                                    } catch (altError) {
                                        console.log(`Alternative method ${method} failed:`, altError.response?.data?.message || altError.message);
                                    }
                                }
                            }
                            
                            return false;
                        }
                    },

                    async selectPaymentMethod(selectedMethod) {
                        try {
                            console.log('Selecting payment method:', selectedMethod);
                            
                            const response = await this.$axios.post("{{ route('shop.checkout.onepage.payment_methods.store') }}", {
                                payment: selectedMethod
                            });
                            
                            console.log('Payment method saved:', response.data);
                            
                            // Update cart data
                            if (response.data && response.data.cart) {
                                this.cart = response.data.cart;
                            }
                            
                            // Enable place order button
                            this.canPlaceOrder = true;
                            
                        } catch (error) {
                            console.error('Error saving payment method:', error);
                            
                            if (error.response && error.response.data && error.response.data.redirect_url) {
                                window.location.href = error.response.data.redirect_url;
                            }
                        }
                    },

                    async stepForward(step) {
                        // Skip shipping step
                        if (step === 'shipping') {
                            step = 'payment';
                        }

                        // If going to payment and no shipping method is set, try to set it
                        if (step === 'payment' && (!this.cart || !this.cart.shipping_method)) {
                            const success = await this.setFreeShipping();
                            if (!success) {
                                console.error('Could not set shipping method');
                                // Continue anyway to avoid blocking user
                            }
                        }
                        
                        this.currentStep = step;
                        this.canPlaceOrder = (step === 'payment');
                    },

                    async stepProcessed(data) {
                        console.log('Step processed:', data);
                        
                        if (this.currentStep === 'shipping' && data.shipping_methods) {
                            this.shippingMethods = data.shipping_methods;
                            // Auto-select free shipping if available
                            await this.setFreeShipping();
                        } else if (this.currentStep === 'payment') {
                            // Payment methods should be in the data
                            if (data && data.payment_methods) {
                                this.paymentMethods = data.payment_methods;
                                console.log('Payment methods from stepProcessed:', this.paymentMethods);
                            }
                        }
                        this.getCart();
                    },

                    scrollToCurrentStep() {
                        const container = document.getElementById('steps-container');
                        if (container) {
                            container.scrollIntoView({ 
                                behavior: 'smooth', 
                                block: 'start' 
                            });
                        }
                    },

                    async placeOrder() {
                        // Ensure shipping method is set before placing order
                        if (!this.cart.shipping_method) {
                            const success = await this.setFreeShipping();
                            if (!success) {
                                console.error('Could not set shipping method before order placement');
                                // Continue anyway - backend might handle it
                            }
                        }

                        this.isPlacingOrder = true;
                        
                        try {
                            const response = await this.$axios.post("{{ route('shop.checkout.onepage.orders.store') }}");
                            
                            if (response.data.redirect) {
                                window.location.href = response.data.redirect;
                            } else {
                                window.location.href = "{{ route('shop.checkout.onepage.success') }}";
                            }
                        } catch (error) {
                            console.error('Error placing order:', error);
                            alert('There was an error processing your order. Please try again.');
                        } finally {
                            this.isPlacingOrder = false;
                        }
                    }
                }
            });
        </script>

        <style>
            /* Hide shipping step visually but keep it in the DOM */
            .shipping-step {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
                border: 0;
            }

            /* Loading state */
            .loading-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(255, 255, 255, 0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
            }
        </style>
    @endPushOnce
</x-shop::layouts>