








<?php $__env->startSection('content'); ?>
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4 bg-gray-50">
      <div class="container mx-auto">
        <div class="flex flex-col lgg:flex-row gap-8">
          <!-- Left Column: Shipping Form -->
          <div class="flex-1 bg-white rounded-lg shadow-sm p-8">
            <nav class="text-sm text-gray-500 mb-6">
              Cart > Shipping > Payment
            </nav>
            <h1 class="text-2xl font-semibold mb-8">Shipping Address</h1>

            <form class="space-y-6">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >First Name</label
                  >
                  <input
                    type="text"
                    value="Diyansh"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >Last Name</label
                  >
                  <input
                    type="text"
                    value="Agrawal"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                  />
                </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >Email</label
                  >
                  <input
                    type="email"
                    value="diyansh@webyansh.com"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >Phone No</label
                  >
                  <input
                    type="tel"
                    value=""
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                  />
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Address 1</label
                >
                <input
                  type="text"
                  value="diyansh@webyansh.com"
                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                  placeholder="Street address"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Address 2 (optional)</label
                >
                <input
                  type="text"
                  value="diyansh@webyansh.com"
                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                  placeholder="Apartment, suite, etc."
                />
              </div>

              <div class="grid grid-cols-3 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >City</label
                  >
                  <input
                    type="text"
                    value="Bangalore"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >State</label
                  >
                  <input
                    type="text"
                    value="Karnataka"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1"
                    >Pin Code</label
                  >
                  <input
                    type="text"
                    value="560021"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                  />
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Description (optional)</label
                >
                <textarea
                  rows="3"
                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                  placeholder="Enter a description..."
                ></textarea>
              </div>
            </form>
          </div>

          <!-- Right Column: Order Summary -->
          <div class="xl:w-102 w-96">
            <div class="bg-white rounded-lg shadow-sm p-6">
              <h2 class="text-xl font-semibold mb-6">Your Cart</h2>

              <div class="space-y-6 mb-6">
                <!-- Product 1 -->
                <div class="flex gap-4">
                  <div
                    class="w-20 h-20 bg-gray-200 rounded-md flex-shrink-0 border border-gray-300"
                  ></div>
                  <div class="flex-1">
                    <p class="font-medium">Men Top Black Puffer Jacket</p>
                    <p class="text-sm text-gray-500">Mens 04 Boys</p>
                  </div>
                  <p class="font-medium">$999.00</p>
                </div>

                <!-- Product 2 -->
                <div class="flex gap-4">
                  <div
                    class="w-20 h-20 bg-gray-200 rounded-md flex-shrink-0 border border-gray-300"
                  ></div>
                  <div class="flex-1">
                    <p class="font-medium">Women Jacket</p>
                    <p class="text-sm text-gray-500">Women top</p>
                  </div>
                  <p class="font-medium">$1200.00</p>
                </div>
              </div>

              <div class="border-t pt-4 space-y-3">
                <div class="flex items-center gap-3">
                  <input
                    type="text"
                    placeholder="Discount code"
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-md focus:outline-none w-full"
                  />
                  <button
                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200"
                  >
                    Apply
                  </button>
                </div>

                <div class="space-y-2 text-sm">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span>$2199.00</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Shipping</span>
                    <span>$7.00</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Estimated taxes</span>
                    <span>$5.00</span>
                  </div>
                  <div
                    class="flex justify-between font-semibold text-base pt-2 border-t"
                  >
                    <span>Total</span>
                    <span>$2213.00</span>
                  </div>
                </div>

                <button
                  class="w-full mt-6 py-4 bg-black text-white font-medium rounded-md hover:bg-gray-900 transition"
                >
                  Continue to Payment
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.web.main-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\aiman-royal\aiman-royale\resources\views/web/checkout.blade.php ENDPATH**/ ?>