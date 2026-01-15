<!-- Footer -->
<footer class="bg-gray-950 text-gray-300">
  <!-- Main Footer Content -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="flex lg:flex-row flex-col gap-4">
      <!-- Brand / About -->
      <div class="lg:max-w-[350px] max-w-full">
        <div class="flex items-center mb-5">
          
          <img src="<?php echo e(asset('web/images/amarmaa-logo.webp')); ?>" class="max-h-[60px]" alt="">
          <img src="<?php echo e(asset('web/images/amarmaa-text.webp')); ?>" class="max-h-[30px]" alt="">
        </div>
        <p class="text-gray-400 leading-relaxed">
          Fresh groceries delivered fast. We partner with trusted farms and brands to bring you organic, seasonal, and everyday essentials — all in one place.
        </p>

        <div class="mt-5 space-y-2 text-sm">
          <p class="flex items-start"><span class="w-5 h-5 mr-2">📍</span>123 Market Street, Suite 500, San Francisco, CA 94105</p>
          <p class="flex items-center"><span class="w-5 h-5 mr-2">📞</span>+1 (234) 567-8900</p>
          <p class="flex items-center"><span class="w-5 h-5 mr-2">✉️</span>hello@amarmaa.in</p>
        </div>

        <!-- Socials -->
        <div class="mt-6 flex items-center gap-3">
          <a href="#" aria-label="Facebook" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/15 text-white">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.5 9.95v-7.04H7.9V12h2.6V9.8c0-2.56 1.52-3.98 3.84-3.98 1.11 0 2.28.2 2.28.2v2.5h-1.28c-1.26 0-1.65.78-1.65 1.58V12h2.81l-.45 2.91h-2.36v7.04A10 10 0 0022 12z"/></svg>
          </a>
          <a href="#" aria-label="Instagram" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/15 text-white">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm10 2a3 3 0 013 3v10a3 3 0 01-3 3H7a3 3 0 01-3-3V7a3 3 0 013-3h10zm-5 3a5 5 0 100 10 5 5 0 000-10zm6.5-.9a1.1 1.1 0 110 2.2 1.1 1.1 0 010-2.2z"/></svg>
          </a>
          <a href="#" aria-label="Twitter" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/15 text-white">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.54A4.48 4.48 0 0016 3a4.48 4.48 0 00-4.4 5.5A12.94 12.94 0 013 4s-4 9 5 13a13.38 13.38 0 01-8 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
          </a>
          <a href="#" aria-label="LinkedIn" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/15 text-white">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM.5 8h4V24h-4V8zM8.5 8h3.9v2.2h.06c.54-1.02 1.87-2.2 3.86-2.2 4.13 0 4.89 2.72 4.89 6.27V24h-4v-7.2c0-1.72-.03-3.94-2.4-3.94-2.4 0-2.77 1.87-2.77 3.8V24h-4V8z"/></svg>
          </a>
        </div>
      </div>

       <!-- Newsletter + Payments / Trust -->
    <div class="mt-12 flex flex-col  gap-6 items-center w-full">
      <!-- Newsletter -->
      <div class="w-full">
        <div class="rounded-2xl bg-gradient-to-r from-green-700/20 to-emerald-600/20 border border-white/10 p-6 sm:p-8">
          <div class="flex flex-col  items-start sm:justify-between gap-4">
            <div class="md:w-auto w-full">
              <h4 class="text-white text-lg font-semibold">Get fresh deals in your inbox</h4>
              <p class="text-sm text-gray-400">Subscribe for weekly offers, seasonal picks, and insider tips.</p>
            </div>
            <form action="#" method="post" class="md:w-auto w-full flex items-center gap-2 xxs:flex-row flex-col">
              <input type="email" name="email" required placeholder="you@example.com" class="flex-1 xxs:min-w-[220px] xxs:w-auto w-full px-4 py-2.5 rounded-xl bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400" />
              <button type="submit" class="inline-flex justify-center xxs:w-auto w-full items-center rounded-xl bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 shadow">
                Subscribe
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Payments / Trust -->
      <div class="flex flex-col items-start gap-3  w-full">
        <p class="text-sm text-gray-400">We accept</p>
        <div class="flex flex-wrap items-center gap-2">
          <span class="inline-flex items-center justify-center h-9 px-3 rounded-md bg-white text-gray-800 text-xs font-semibold">Visa</span>
          <span class="inline-flex items-center justify-center h-9 px-3 rounded-md bg-white text-gray-800 text-xs font-semibold">Mastercard</span>
          <span class="inline-flex items-center justify-center h-9 px-3 rounded-md bg-white text-gray-800 text-xs font-semibold">AmEx</span>
          <span class="inline-flex items-center justify-center h-9 px-3 rounded-md bg-white text-gray-800 text-xs font-semibold">PayPal</span>
          <span class="inline-flex items-center justify-center h-9 px-3 rounded-md bg-white text-gray-800 text-xs font-semibold">UPI</span>
        </div>
        <div class="flex items-center gap-3 text-xs text-gray-400">
          <span class="inline-flex items-center gap-1"><svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-7.778 7.778a1 1 0 01-1.414 0L3.293 11.964a1 1 0 011.414-1.414l3.102 3.101 7.07-7.07a1 1 0 011.828.707z"/></svg>Secure checkout</span>
          <span class="inline-flex items-center gap-1"><svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11H9v4h2V7zm0 6H9v2h2v-2z" clip-rule="evenodd"/></svg>Privacy-first</span>
        </div>
      </div>
    </div>
    </div>

   
  </div>

  <!-- Bottom Bar -->
  <div class="border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
      <p class="text-sm text-gray-400"> 2025 amarmaa. All rights reserved.</p>
      <div class="flex flex-wrap items-center gap-4 text-sm">
        <a href="#" class="hover:text-white">Terms</a>
        <span class="text-gray-600">•</span>
        <a href="#" class="hover:text-white">Privacy</a>
        <span class="text-gray-600">•</span>
        <a href="#" class="hover:text-white">Cookies</a>
        <span class="text-gray-600">•</span>
        <a href="#" class="hover:text-white">Sitemap</a>
      </div>
    </div>
  </div>
</footer><?php /**PATH C:\xampp\htdocs\aiman\resources\views/components/web/footer.blade.php ENDPATH**/ ?>