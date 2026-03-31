<div id="sizeGuideModal" class="fixed inset-0 bg-black/60 z-[30000] hidden items-start justify-center p-4 overflow-y-auto modal-overlay">
  <div class="bg-white w-full container rounded-xl shadow-2xl relative modal-container my-8">

    <!-- Header -->
    <div class="flex flex-col smxl:flex-row items-start smxl:items-center justify-between px-6 sm:px-8 py-5 border-b gap-4">
      <h2 class="text-xl sm:text-2xl font-bold">Size Guide</h2>

      <div class="flex items-center gap-4 w-fit smxl:w-auto">
        <!-- Unit Toggle -->
        <div class="flex bg-gray-100 rounded-full p-1 text-sm font-medium flex-1 smxl:flex-none w-fit">
          <button class="px-3 sm:px-4 py-1.5 rounded-full bg-black text-white transition-all active:scale-95 unit-btn active" data-unit="inches">Inches</button>
          <button class="px-3 sm:px-4 py-1.5 rounded-full text-gray-600 transition-all active:scale-95 unit-btn" data-unit="cm">cm</button>
        </div>

        <!-- Close Button -->
        <button class="text-2xl text-gray-500 hover:text-black transition-colors close-btn smxl:relative smxl:top-[0px] top-[10px] smxl:right-[0px] right-[16px] absolute">&times;</button>
      </div>
    </div>

    <!-- Content -->
    <div class="flex md:flex-row flex-col  gap-8 pt-[10px] pb-6 sm:pb-8 px-6 sm:px-8 ">

      <!-- LEFT — SIZE TABLE -->
      <div class="w-full">
        <div class="">
          <h3 class="text-lg sm:text-xl font-semibold mb-4 text-center">Size Guide</h3>

          <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
            <table class="w-full text-sm text-left">
              <thead class="bg-gray-50 text-gray-700">
                <tr>
                  <th class="p-3 border-b border-r min-w-[80px] text-center">SIZE</th>
                  <th class="p-3 border-b border-r min-w-[80px] text-center">Bust</th>
                  <th class="p-3 border-b border-r min-w-[80px] text-center">Waist</th>
                  <th class="p-3 border-b border-r min-w-[80px] text-center">Hip</th>
                  <th class="p-3 border-b border-r min-w-[80px] text-center">Armhole</th>
                  <th class="p-3 border-b border-r min-w-[80px] text-center">UK Size</th>

                </tr>
              </thead>

              <tbody class="text-gray-700">
                @foreach($sizes as $size)
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="p-3 border-b border-r font-medium text-center">{{$size->code}} ({{$size->chest_size ? floor($size->chest_size) == $size->chest_size 
                   ? (int) $size->chest_size : $size->chest_size : ''}}) </td>
                  <td class="p-3 border-b border-r text-center" data-inches="{{$size->chest_size ?? 0}}" data-cm="{{$size->chest_size * 2.54?? 0}}">{{ floor($size->chest_size) == $size->chest_size 
                   ? (int) $size->chest_size : $size->chest_size }}
                  </td>
                  <td class="p-3 border-b border-r text-center" data-inches="{{$size->waist_size ?? 0}}" data-cm="{{$size->waist_size * 2.54 ?? 0}}">{{ floor($size->waist_size) == $size->waist_size 
                  ? (int) $size->waist_size : $size->waist_size }}
                  </td>
                  <td class="p-3 border-b border-r text-center" data-inches="{{$size->hip ?? 0}}" data-cm="{{$size->hip * 2.54 ?? 0}}">{{ floor($size->hip) == $size->hip 
                  ? (int) $size->hip : $size->hip }}</td>

                  <td class="p-3 border-b border-r text-center" data-inches="{{$size->arm ?? 0}}" data-cm="{{$size->arm * 2.54 ?? 0}}"">{{ floor($size->arm) == $size->arm 
                  ? (int) $size->arm : $size->arm }}</td>

                  <td class="p-3 border-b border-r text-center" data-inches="{{$size->uk_size ?? 0}}" data-cm="{{$size->uk_size * 2.54 ?? 0}}">{{ floor($size->uk_size) == $size->uk_size 
                  ? (int) $size->uk_size : $size->uk_size }}</td>



                </tr>
                @endforeach

              </tbody>
            </table>
          </div>

          <!-- Table Legend -->
          <div class="mt-4 flex flex-wrap gap-4 text-xs text-gray-500">
            <div class="flex items-center gap-2">
              <div class="w-3 h-3 bg-white border border-gray-300"></div>
              <span>Standard sizes</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="w-3 h-3 bg-gray-50/50 border border-gray-300"></div>
              <span>Alternate sizes</span>
            </div>
          </div>
        </div>

      </div>

      <!-- RIGHT — MEASURE GUIDE WITH SCROLLABLE CONTENT -->
      <div class="lg:border-l lg:pl-8 h-[600px] lg:h-auto lg:max-h-[calc(100vh-300px)] overflow-y-auto pr-2 lg:pr-4 lgg:min-w-[380px] md:min-w-[330px] min-w-full lgg:max-w-[380px] md:max-w-[330px] max-w-full">
        <div class="sticky top-0 bg-white pt-2 pb-4 z-10">
          <h3 class="text-lg sm:text-xl font-semibold mb-2 text-center">How to Measure Yourself</h3>
        </div>

        <div class="space-y-6 pb-4">
          <!-- Image 1 -->
          <div class="measurement-step">
            <div class="flex md:justify-start justify-center  items-center gap-3 mb-3 ">
              <div class="w-7 h-7 bg-black text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
              <h4 class="font-semibold text-gray-800 text-base">Bust Measurement</h4>
            </div>
            <div class="max-h-[400px] w-auto overflow-hidden aspect-[11/12] md:mx-0 mx-auto ">


              <img src="{{asset('web/images/size-guide/bust.webp')}}"
                alt="Bust measurement guide"
                class=" w-full h-full object-cover  rounded-md mb-2 mx-auto object-top">
            </div>

            <p class="text-sm text-gray-600 px-1 mt-2 md:text-left text-center">Measure around the fullest part of your bust, keeping the tape parallel to the floor and snug but not tight.</p>
          </div>

          <!-- Image 2 -->
          <div class="measurement-step">
            <div class="flex md:justify-start justify-center  items-center gap-3 mb-3 ">
              <div class="w-7 h-7 bg-black text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
              <h4 class="font-semibold text-gray-800 text-base">Waist Measurement</h4>
            </div>
            <div class="max-h-[400px] w-auto overflow-hidden aspect-[11/12] md:mx-0 mx-auto ">
              <img src="{{asset('web/images/size-guide/waist.webp')}}"
                alt="Bust measurement guide"
                class="w-full h-full object-cover  rounded-md mb-2 mx-auto object-top">
            </div>
            <p class="text-sm text-gray-600 px-1 mt-2 md:text-left text-center">Find the smallest part of your natural waist (above belly button) and measure around it without holding your breath.</p>
          </div>

          <!-- Image 3 -->
          <div class="measurement-step">
            <div class="flex md:justify-start justify-center  items-center gap-3 mb-3 ">
              <div class="w-7 h-7 bg-black text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
              <h4 class="font-semibold text-gray-800 text-base">Hip Measurement</h4>
            </div>
            <div class="max-h-[400px] w-auto overflow-hidden aspect-[11/12] md:mx-0 mx-auto ">
              <img src="{{asset('web/images/size-guide/hip.webp')}}"
                alt="Bust measurement guide"
                class="w-full h-full object-cover  rounded-md mb-2 mx-auto object-top">
            </div>
            <p class="text-sm text-gray-600 px-1 mt-2 md:text-left text-center">Measure around the fullest part of your hips and buttocks, approximately 8 inches below your waistline.</p>
          </div>

          <!-- Image 4 -->
          <div class="measurement-step">
            <div class="flex md:justify-start justify-center  items-center gap-3 mb-3 ">
              <div class="w-7 h-7 bg-black text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">4</div>
              <h4 class="font-semibold text-gray-800 text-base">Armhole Measurement</h4>
            </div>
            <div class="max-h-[400px] w-auto overflow-hidden aspect-[11/12] md:mx-0 mx-auto ">
              <img src="{{asset('web/images/size-guide/arm-round.webp')}}"
                alt="Bust measurement guide"
                class="w-full h-full object-cover  rounded-md mb-2 mx-auto object-top">
            </div>
            <p class="text-sm text-gray-600 px-1 mt-2 md:text-left text-center">Measure from the shoulder seam down through the armpit and back up to the starting point.</p>
          </div>

          <!-- Image 5 -->
          <div class="measurement-step">
            <div class="flex md:justify-start justify-center  items-center gap-3 mb-3 ">
              <div class="w-7 h-7 bg-black text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">5</div>
              <h4 class="font-semibold text-gray-800 text-base">Shoulder Measurement</h4>
            </div>
            <div class="max-h-[400px] w-auto overflow-hidden aspect-[11/12] md:mx-0 mx-auto ">
              <img src="{{asset('web/images/size-guide/shoulder.webp')}}"
                alt="Bust measurement guide"
                class="w-full h-full object-cover  rounded-md mb-2 mx-auto object-top">
            </div>
            <p class="text-sm text-gray-600 px-1 mt-2 md:text-left text-center">Measure from the edge of one shoulder bone to the other, across the upper back while standing straight.</p>
          </div>
          <div class="measurement-step">
            <div class="flex md:justify-start justify-center  items-center gap-3 mb-3 ">
              <div class="w-7 h-7 bg-black text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">5</div>
              <h4 class="font-semibold text-gray-800 text-base">Arm Length Measurement</h4>
            </div>
            <div class="max-h-[400px] w-auto overflow-hidden aspect-[11/12] md:mx-0 mx-auto ">
              <img src="{{asset('web/images/size-guide/arm-length.webp')}}"
                alt="Bust measurement guide"
                class="w-full h-full object-cover  rounded-md mb-2 mx-auto object-top">
            </div>
            <p class="text-sm text-gray-600 px-1 mt-2 md:text-left text-center">Measure from the edge of one shoulder bone to the other, across the upper back while standing straight.</p>
          </div>
          <div class="measurement-step">
            <div class="flex md:justify-start justify-center  items-center gap-3 mb-3 ">
              <div class="w-7 h-7 bg-black text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">5</div>
              <h4 class="font-semibold text-gray-800 text-base">Height Measurement</h4>
            </div>
            <div class="max-h-[400px] w-auto overflow-hidden aspect-[11/12] md:mx-0 mx-auto ">
              <img src="{{asset('web/images/size-guide/height.webp')}}"
                alt="Bust measurement guide"
                class="w-full h-full object-cover  rounded-md mb-2 mx-auto object-top">
            </div>
            <p class="text-sm text-gray-600 px-1 mt-2 md:text-left text-center">Measure from the edge of one shoulder bone to the other, across the upper back while standing straight.</p>
          </div>

          <!-- Tips Section -->
          <!-- <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
            <h5 class="font-semibold text-blue-800 mb-3 flex items-center gap-2">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
              </svg>
              Measurement Tips
            </h5>
            <ul class="text-sm text-blue-700 space-y-2">
              <li class="flex items-start gap-2">
                <span class="text-blue-800 mt-0.5">•</span>
                <span><strong>Stand naturally:</strong> Feet together, stand straight but relaxed</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-blue-800 mt-0.5">•</span>
                <span><strong>Proper tape:</strong> Use a soft, non-stretch measuring tape</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-blue-800 mt-0.5">•</span>
                <span><strong>Tension:</strong> Keep tape snug but not tight - don't compress skin</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-blue-800 mt-0.5">•</span>
                <span><strong>Clothing:</strong> Wear form-fitting clothes or just undergarments</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-blue-800 mt-0.5">•</span>
                <span><strong>Repeat:</strong> Take each measurement 2-3 times for accuracy</span>
              </li>
            </ul>
          </div> -->

          <!-- Size Selection Help -->
          <!-- <div class="p-4 bg-amber-50 rounded-lg border border-amber-100">
            <h5 class="font-semibold text-amber-800 mb-3 flex items-center gap-2">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
              </svg>
              Choosing Your Size
            </h5>
            <p class="text-sm text-amber-700 mb-2">If your measurements fall between two sizes:</p>
            <ul class="text-sm text-amber-700 space-y-1 ml-2">
              <li class="flex items-start gap-2">
                <span class="text-amber-800 mt-0.5">→</span>
                <span>For fitted styles: Choose the larger size</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-amber-800 mt-0.5">→</span>
                <span>For loose styles: Choose the smaller size</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-amber-800 mt-0.5">→</span>
                <span>Focus on your largest measurement when deciding</span>
              </li>
            </ul>
          </div> -->
        </div>
      </div>

    </div>

    <!-- Footer Note -->
    <div class="px-6 sm:px-8 py-4 border-t bg-gray-50 text-xs sm:text-sm text-gray-500">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <p>This is a standard size guide for basic body measurements. There may be slight variations depending on the garment type and fit.</p>
        <button class="text-blue-600 hover:text-blue-800 font-medium transition-colors flex items-center gap-2 sm:self-end">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <span>Download Size Chart (PDF)</span>
        </button>
      </div>
    </div>

  </div>
</div>

<style>
  .measurement-step {
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
  }

  .measurement-step:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }

  /* Custom scrollbar for right section */
  #sizeGuideModal .overflow-y-auto::-webkit-scrollbar {
    width: 6px;
  }

  #sizeGuideModal .overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }

  #sizeGuideModal .overflow-y-auto::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
  }

  #sizeGuideModal .overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
  }

  /* Responsive adjustments */
  @media (max-width: 1023px) {
    .lg\:border-l {
      border-left: none;
    }

    .lg\:pl-8 {
      padding-left: 0;
    }

    .lg\:pr-4 {
      padding-right: 0;
    }

    .lg\:h-auto {
      height: auto;
      max-height: 500px;
    }
  }
</style>

<style>
  .measurement-step {
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
  }

  .measurement-step:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }
</style>

<style>
  /* Modal Animations */
  .modal-overlay {
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .modal-overlay.show {
    opacity: 1;
    visibility: visible;
  }

  .modal-overlay.show .modal-container {
    transform: translateY(0) scale(1);
    opacity: 1;
  }

  .modal-container {
    transform: translateY(20px) scale(0.95);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    transition-delay: 0.1s;
  }

  /* Modal closing animation */
  .modal-overlay.closing .modal-container {
    transform: translateY(20px) scale(0.95);
    opacity: 0;
  }

  /* Fade in for content */
  .modal-container>* {
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s ease-out;
    transition-delay: 0.2s;
  }

  .modal-overlay.show .modal-container>* {
    opacity: 1;
    transform: translateY(0);
  }

  /* Staggered animation for children */
  .modal-overlay.show .modal-container>*:nth-child(1) {
    transition-delay: 0.2s;
  }

  .modal-overlay.show .modal-container>*:nth-child(2) {
    transition-delay: 0.25s;
  }

  .modal-overlay.show .modal-container>*:nth-child(3) {
    transition-delay: 0.3s;
  }

  .modal-overlay.show .modal-container>*:nth-child(4) {
    transition-delay: 0.35s;
  }

  /* Prevent body scroll when modal is open */
  body.modal-open {
    overflow: hidden;
  }
</style>

<script>
  // Size Guide Modal System - Supports Multiple Triggers
  class SizeGuideModal {
    constructor() {
      this.modal = null;
      this.overlay = null;
      this.container = null;
      this.isAnimating = false;
      this.init();
    }

    init() {
      // Create modal if it doesn't exist
      if (!document.getElementById('sizeGuideModal')) {
        this.createModal();
      }

      this.modal = document.getElementById('sizeGuideModal');
      this.overlay = this.modal;
      this.container = this.modal.querySelector('.modal-container');
      this.setupEventListeners();
    }

    createModal() {
      const modalHTML = `
      <div id="sizeGuideModal" class="fixed inset-0 bg-black/60 z-50 hidden items-start justify-center p-4 overflow-y-auto modal-overlay">
        <div class="bg-white w-full max-w-6xl rounded-xl shadow-2xl relative modal-container my-8">
          <!-- Your existing modal content here -->
        </div>
      </div>
    `;
      document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    setupEventListeners() {
      // Delegate click events for all size guide triggers
      document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-size-guide-trigger]');
        if (trigger && !this.isAnimating) {
          this.openModal();
          e.preventDefault();
        }
      });

      // Close button
      document.addEventListener('click', (e) => {
        if ((e.target.closest('.close-btn') ||
            e.target.classList.contains('close-btn')) &&
          !this.isAnimating) {
          this.closeModal();
        }
      });

      // Close when clicking overlay (outside modal)
      this.overlay.addEventListener('click', (e) => {
        if (e.target === this.overlay && !this.isAnimating) {
          this.closeModal();
        }
      });

      // Close with Escape key
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' &&
          this.modal.classList.contains('show') &&
          !this.isAnimating) {
          this.closeModal();
        }
      });

      // Unit toggle functionality
      document.addEventListener('click', (e) => {
        const unitBtn = e.target.closest('.unit-btn');
        if (unitBtn && this.modal.contains(unitBtn)) {
          this.handleUnitToggle(unitBtn);
        }
      });
    }

    async openModal() {
      if (this.isAnimating) return;

      this.isAnimating = true;

      // Show modal
      this.modal.classList.remove('hidden');
      this.modal.classList.add('flex');
      document.body.classList.add('modal-open');

      // Trigger reflow to enable animation
      void this.modal.offsetWidth;

      // Start opening animation
      this.modal.classList.add('show');

      // Wait for animation to complete
      await new Promise(resolve => setTimeout(resolve, 400));

      this.isAnimating = false;
    }

    async closeModal() {
      if (this.isAnimating) return;

      this.isAnimating = true;

      // Start closing animation
      this.overlay.classList.add('closing');

      // Wait for animation to complete
      await new Promise(resolve => setTimeout(resolve, 300));

      // Hide modal
      this.modal.classList.remove('show', 'closing', 'flex');
      this.modal.classList.add('hidden');
      document.body.classList.remove('modal-open');

      this.isAnimating = false;
    }

    handleUnitToggle(clickedBtn) {
      const unitButtons = this.modal.querySelectorAll('.unit-btn');
      const measurementCells = this.modal.querySelectorAll('td[data-inches]');

      // Remove active class from all buttons
      unitButtons.forEach(btn => {
        btn.classList.remove('active', 'bg-black', 'text-white');
        btn.classList.add('text-gray-600');
      });

      // Add active class to clicked button
      clickedBtn.classList.add('active', 'bg-black', 'text-white');
      clickedBtn.classList.remove('text-gray-600');

      // Get selected unit
      const unit = clickedBtn.getAttribute('data-unit');

      // Animate measurement changes
      measurementCells.forEach((cell, index) => {
        setTimeout(() => {
          const value = cell.getAttribute(`data-${unit}`);
          // Add fade animation
          cell.style.opacity = '0.5';
          cell.style.transform = 'translateY(-2px)';

          setTimeout(() => {
            cell.textContent = unit === 'cm' ? `${value} cm` : value;
            cell.style.opacity = '1';
            cell.style.transform = 'translateY(0)';
          }, 100);
        }, index * 20); // Stagger the animations
      });
    }
  }

  // Initialize modal system when DOM is loaded
  document.addEventListener('DOMContentLoaded', () => {
    window.sizeGuideModal = new SizeGuideModal();
  });
</script>







@if(request()->route()->getName() === 'page.index')
<section id="dynamic-content-sec-1" class="w-full bg-white py-12 lg:py-20">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-gray-800 relative">

    <!-- Main Heading -->
    <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold mb-6">
      Aiman Royale - Buy Premium Traditional Indian Clothing and Ethnic Wear Online in India
    </h2>

    <!-- Intro Paragraph (Always Visible) -->
    <p class="mb-3 leading-relaxed text-base md:text-lg">
      Founded in 2007 in New Delhi, Aiman Royale embodies timeless elegance with a contemporary vision. Our brand celebrates the rich heritage of Indian craftsmanship while embracing modern aesthetics. Specializing in exquisite women's ethnic wear including designer sarees, lehengas, salwar suits, palazzo sets, and fusion ensembles, we bring you premium collections that blend tradition with contemporary style...
    </p>

    <!-- Expandable Details Section -->
    <details class="mt-2 group">
      <summary class="cursor-pointer text-secondary font-medium text-lg hover:text-primary transition-colors duration-200 flex items-center gap-2">
        <!-- Show "Read more" when closed, "Show less" when open -->
        <span class="group-open:hidden">Read more</span>
        <span  class="hidden absolute -bottom-9 sm:right-[31px] right-[19px] group-open:inline redi-sec-dyna" data-target="dynamic-content-sec-2">Show less</span>

      </summary>

      <div class="mt-4 space-y-6">
        <!-- Continued Intro Content -->
        <p class="leading-relaxed text-base md:text-lg">
          Aiman Royale has gained recognition for its impeccable craftsmanship and attention to detail. Each piece in our collection features intricate embroidery, luxurious fabrics, and contemporary silhouettes that redefine ethnic fashion. From bridal lehengas that make every bride feel like royalty to ready-to-wear sarees for modern women on-the-go, our designs cater to diverse tastes while maintaining the essence of Indian tradition.
        </p>

        <!-- Subheading -->
        <h3 class="text-xl md:text-2xl font-semibold mt-8 mb-4">
          Premium Ethnic Wear Collection for Women
        </h3>

        <p class="leading-relaxed text-base md:text-lg">
          At Aiman Royale, we understand that today's woman seeks clothing that reflects her personality while honoring her cultural roots. Our collection includes:
        </p>

        <ul class="list-disc pl-6 space-y-3 text-base md:text-lg leading-relaxed">
          <li><span class="font-medium">Designer Sarees:</span> Silk, Georgette, Chiffon, and Banarasi sarees with contemporary blouse designs</li>
          <li><span class="font-medium">Lehenga Cholis:</span> Bridal and festive lehengas with intricate embroidery and modern cuts</li>
          <li><span class="font-medium">Salwar Suits:</span> Anarkalis, straight-cut suits, and fusion styles for everyday elegance</li>
          <li><span class="font-medium">Palazzo Sets:</span> Comfortable yet stylish ensembles perfect for modern occasions</li>
          <li><span class="font-medium">Indo-Western Fusion:</span> Contemporary takes on traditional silhouettes</li>
        </ul>

        <!-- Subheading -->
        <h3 class="text-xl md:text-2xl font-semibold mt-8 mb-4">
          Why Choose Aiman Royale for Your Ethnic Wardrobe?
        </h3>

        <p class="leading-relaxed text-base md:text-lg">
          In an era where fast fashion dominates, Aiman Royale stands apart by offering heirloom-quality pieces that celebrate India's textile heritage. Our commitment to quality ensures that every garment:
        </p>

        <!-- Bullet Points -->
        <ul class="list-disc pl-6 space-y-4 text-base md:text-lg leading-relaxed mb-4">
          <li>
            Features authentic craftsmanship by skilled artisans from across India, preserving traditional techniques while incorporating modern design elements
          </li>
          <li>
            Uses premium fabrics including pure silks, organic cottons, and luxurious blends that ensure comfort without compromising on elegance
          </li>
          <li>
            Offers versatile styling options - our pieces transition seamlessly from formal weddings to casual gatherings with simple accessory changes
          </li>
          <li>
            Provides perfect fits with our tailored sizing options and customization services for special occasions
          </li>
          <li>
            Delivers exceptional value through timeless designs that remain fashionable season after season
          </li>
        </ul>

        <!-- Closing Paragraph -->
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
          <p class="leading-relaxed text-base md:text-lg text-gray-700">
            Whether you're preparing for your wedding day, attending a festive celebration, or seeking elegant everyday ethnic wear, Aiman Royale offers curated collections that blend tradition with contemporary style. Experience the perfect harmony of heritage and modernity with every piece from our collection.
          </p>
        </div>
      </div>
    </details>

  </div>
</section>

@elseif(str_contains(request()->path(), 'collections/'))
@php
    // Try to get category from URL slug
    $slug = request()->segment(2);
    $category = \App\Models\Category::where('slug', $slug)->first();
@endphp
@if($category)
<section id="dynamic-content-sec-2" class="w-full bg-white py-12 lg:py-20">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-gray-800 relative">

    <!-- Category Heading -->
    <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold mb-6">
      {{ $category->name }} - Premium {{ $category->name }} Collection by Aiman Royale
    </h2>

    <!-- Full Category Description Only -->
    <div class="prose prose-lg max-w-none">
      <div class="leading-relaxed text-base md:text-lg">
        {!! $category->description !!}
      </div>
    </div>

  </div>
</section>
@endif
@endif
<style>
   .card-shadow {
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02), 0 2px 6px rgba(0, 0, 0, 0.03);
      transition: box-shadow 0.2s ease, transform 0.2s ease;
    }
    .card-shadow:hover {
      box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.08);
    }
    .custom-scroll::-webkit-scrollbar {
      width: 5px;
    }
    .custom-scroll::-webkit-scrollbar-track {
      background: #f0edea;
      border-radius: 12px;
    }
    .custom-scroll::-webkit-scrollbar-thumb {
      background: #c0392b;
      border-radius: 12px;
    }
    .custom-scroll::-webkit-scrollbar-thumb:hover {
      background: #9a2e22;
    }
    .text-primary-dark {
      color: #bc4e3b;
      font-weight: 700;
      letter-spacing: -0.01em;
    }
    .faq-answer {
      transition: opacity 0.2s ease;
    }
    .faq-answer:not(.hidden) {
      display: block;
    }
    .faq-answer.hidden {
      display: none;
    }
    .faq-btn:focus-visible {
      outline: 2px solid #bc4e3b;
      outline-offset: 2px;
      border-radius: 12px;
    }
    @media (max-width: 640px) {
      .faq-question-text {
        font-size: 0.95rem !important;
        line-height: 1.4rem;
      }
      .faq-answer {
        font-size: 0.85rem !important;
      }
    }
    @media (min-width: 768px) {
      .faq-question-text {
        font-size: 1.05rem;
      }
    }
    @media (min-width: 1024px) {
      .faq-question-text {
        font-size: 1.1rem;
      }
    }
    .hover\:bg-rose-50\/40:hover {
      background-color: rgba(255, 228, 225, 0.5);
    }
    .loading-spinner {
      border: 2px solid #f3f3f3;
      border-top: 2px solid #bc4e3b;
      border-radius: 50%;
      width: 24px;
      height: 24px;
      animation: spin 0.8s linear infinite;
      margin: 0 auto;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    .faq-category-badge {
      background: #fef2e8;
      color: #bc4e3b;
      font-size: 0.7rem;
      padding: 0.15rem 0.6rem;
      border-radius: 20px;
      display: inline-block;
      font-weight: 500;
    }
</style>

 @php
// Check if current URL is a product page with slug
$currentPath = request()->path();
$isProductPage = false;
$productSlug = null;

if (str_contains($currentPath, 'products/')) {
    $segments = explode('/', $currentPath);
    $productsIndex = array_search('products', $segments);
    
    if ($productsIndex !== false && isset($segments[$productsIndex + 1])) {
        $productSlug = $segments[$productsIndex + 1];
        $isProductPage = !empty($productSlug);
    }
}
@endphp

@if($isProductPage)
 <div class="container mx-auto px-4 sm:px-5 lg:px-6 py-8 md:py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-10">
      
      <!-- LEFT: FAQ SECTION - Dynamic API Driven -->
      <div class="bg-white border border-gray-200/70 rounded-2xl shadow-sm overflow-hidden transition-all duration-300 card-shadow">
        <div class="p-6 md:p-7">
          <div class="text-center mb-6 border-b border-gray-100 pb-4">
            <h2 class="font-extrabold tracking-tight text-gray-800" style="font-size: clamp(1.65rem, 6vw, 2.2rem); line-height: 1.3;">
              Frequently Asked <span class="text-primary-dark">(FAQs)</span> <br class="hidden sm:block"> On {{ $productSlug ? ucfirst(str_replace('-', ' ', $productSlug)) : 'This Product' }}
            </h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">Everything you need to know about our ethnic collection</p>
          </div>

          <!-- Dynamic FAQ Container -->
          <div id="faq-dynamic-container" class="space-y-2">
            <!-- Loading State -->
            <div class="flex justify-center items-center py-12">
              <div class="loading-spinner"></div>
              <span class="ml-3 text-gray-500 text-sm">Loading FAQs...</span>
            </div>
          </div>

          <!-- Fallback / error message placeholder -->
          <div id="faq-error-msg" class="hidden text-center py-6 text-gray-500 text-sm"></div>

          <div class="mt-7 pt-2 text-center text-xs text-gray-400 border-t border-gray-100">
            <span>📘 Need more help? <a href="#" class="text-primary-dark hover:underline font-medium">Contact our fashion experts</a></span>
          </div>
        </div>
      </div>

      <!-- RIGHT: PRICE LIST - Latest Collection (Static) -->
      <div class="bg-white border border-gray-200/70 rounded-2xl shadow-sm overflow-hidden card-shadow">
        <div class="p-6 md:p-7">
          <div class="text-center mb-6 border-b border-gray-100 pb-4">
            <h2 class="font-extrabold tracking-tight text-gray-800" style="font-size: clamp(1.65rem, 6vw, 2.2rem); line-height: 1.3;">
              Latest Products <span class="text-primary-dark">Collection</span> With Price
            </h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">Handpicked luxury & festive ethnic wear</p>
          </div>

          <div class="flex justify-between font-semibold text-sm md:text-base uppercase tracking-wide text-gray-700 border-b-2 border-primary-dark/20 pb-3 mb-3">
            <span>Products List</span>
            <span>Price (INR)</span>
          </div>

          <div id="footer-latest-products-container" class="mt-2 space-y-3 text-sm md:text-[0.95rem] max-h-[540px] overflow-y-auto pr-1 custom-scroll">
            <!-- Loading state -->
            <div class="text-center py-8 text-gray-500">
              <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-primary-dark"></div>
              <p class="text-sm mt-2">Loading latest products...</p>
            </div>
          </div>

          <div class="mt-6 pt-3 flex flex-wrap justify-between items-center border-t border-gray-200 text-xs text-gray-500 gap-2">
            <span>🛍️ Prices inclusive of taxes</span>
            <span class="bg-gray-50 px-3 py-0.5 rounded-full text-primary-dark/80 border border-gray-200">Last updated: {{ date('d/m/Y') }}</span>
          </div>
          <p class="text-xs text-gray-400 mt-3 text-center">*Customization & bulk order discounts available | Shop now</p>
        </div>
      </div>

      <script>
        // Fetch and display latest products in footer
        document.addEventListener('DOMContentLoaded', function() {
          // Use product slug from server-side detection
          const productSlug = '{{ $productSlug ?? null }}';
          
          if (!productSlug) {
            return; // Exit if no product slug
          }
          
          // Use latest products API for same category
          const apiUrl = `{{ env('APP_URL', 'http://localhost') }}/api/products/latest/${productSlug}`;
          const container = document.getElementById('footer-latest-products-container');
          
          fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
              if (data.success && data.data && data.data.length > 0) {
                // Use latest products from same category
                const products = data.data.slice(0, 10); // Limit to 10 products
                
                let html = '';
                products.forEach(product => {
                  const emoji = ['✨', '🌸', '💙', '🍃', '🌻', '🌼', '🎀', '💎', '🦚', '🌟'][products.indexOf(product) % 10];
                  const price = product.price ? `₹${product.price.toLocaleString('en-IN')}` : 'Price on request';
                  const productUrl = `/products/${product.slug}`;
                  
                  html += `
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 hover:bg-rose-50/40 transition px-2 rounded-lg">
                      <a href="${productUrl}" class="text-gray-800 font-medium hover:text-primary-dark flex-1">
                        ${emoji} ${product.name}
                      </a>
                      <span class="font-bold text-primary-dark ml-2">${price}</span>
                    </div>
                  `;
                });
                
                container.innerHTML = html;
              } else {
                // Fallback message
                container.innerHTML = `
                  <div class="text-center py-8 text-gray-500">
                    <p class="text-sm">No more products available in this category.</p>
                    <p class="text-xs mt-1">Check back soon for new arrivals!</p>
                  </div>
                `;
              }
            })
            .catch(error => {
              console.error('Error fetching latest products:', error);
              container.innerHTML = `
                <div class="text-center py-8 text-red-500">
                  <p class="text-sm">Unable to load products.</p>
                  <p class="text-xs mt-1">Please refresh the page.</p>
                </div>
              `;
            });
        });
      </script>
    </div>
  </div>
@endif

  <script>
    (function() {
      // Helper: extract product slug from current URL path
      function getProductSlugFromUrl() {
        const path = window.location.pathname; // e.g., "/products/salwar-kameez" or "/products/salwar-kameez/"
        const segments = path.split('/').filter(seg => seg.length > 0);
        // Find segment after 'products' if exists, otherwise last segment as fallback
        const productsIndex = segments.findIndex(seg => seg.toLowerCase() === 'products');
        if (productsIndex !== -1 && segments.length > productsIndex + 1) {
          return segments[productsIndex + 1];
        }
        // fallback: return last segment (salwar-kameez)
        if (segments.length > 0) {
          return segments[segments.length - 1];
        }
        return null;
      }

      const slug = getProductSlugFromUrl();
      const apiUrl = `{{ env('APP_URL', 'http://localhost') }}/api/faqs/products/${slug}`;
      const container = document.getElementById('faq-dynamic-container');
      const errorDiv = document.getElementById('faq-error-msg');

      // Function to render FAQ items dynamically with accordion
      function renderFaqs(faqsData) {
        if (!faqsData || faqsData.length === 0) {
          container.innerHTML = `
            <div class="text-center py-8 text-gray-500">
              <p class="text-sm">No FAQs available for this product yet.</p>
              <p class="text-xs mt-1">Check back soon for more details!</p>
            </div>
          `;
          return;
        }

        // Build HTML for each faq with improved typography & category badge
        let faqHtml = '';
        faqsData.forEach((faq, index) => {
          const heading = faq.heading || '';
          const question = faq.question || '';
          const answer = faq.answer || '';
          const categoryName = faq.category?.category_name || 'General';
          const displayQuestion = heading && heading.trim() !== '' ? heading : question;
          const finalQuestion = displayQuestion && displayQuestion.trim() !== '' ? displayQuestion : 'Helpful information';

          // Add border-bottom except last item
          const borderClass = index !== faqsData.length - 1 ? 'border-b border-gray-100' : '';
          
          faqHtml += `
            <div class="${borderClass} py-3">
              <button class="faq-btn flex justify-between items-center w-full text-left group focus:outline-none rounded-xl px-1 py-0.5 transition-all">
                <div class="flex flex-col flex-1 pr-3">
                  <span class="faq-question-text font-semibold text-gray-800 group-hover:text-primary-dark transition-colors leading-tight">
                    ${escapeHtml(finalQuestion)}
                  </span>
                  <span class="faq-category-badge inline-block mt-1.5 w-fit">${escapeHtml(categoryName)}</span>
                </div>
                <span class="icon-span text-2xl font-semibold text-primary-dark/70 group-hover:text-primary-dark transition-colors w-7 text-center flex-shrink-0">+</span>
              </button>
              <p class="faq-answer text-sm md:text-[0.95rem] text-gray-600 mt-2 pl-1 hidden leading-relaxed">
                ${escapeHtml(answer)}
              </p>
            </div>
          `;
        });

        container.innerHTML = faqHtml;
        
        // Re-attach accordion event listeners to newly created buttons
        attachAccordionEvents();
      }

      // Helper: escape HTML to avoid XSS
      function escapeHtml(str) {
        if (!str) return '';
        return str
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/"/g, '&quot;')
          .replace(/'/g, '&#39;');
      }

      // Accordion handler
      function attachAccordionEvents() {
        const faqButtons = document.querySelectorAll('#faq-dynamic-container .faq-btn');
        
        function accordionHandler(event) {
          const button = event.currentTarget;
          const answerPara = button.nextElementSibling;
          const iconSpan = button.querySelector('.icon-span');
          
          if (!answerPara || !iconSpan) return;
          
          const isHidden = answerPara.classList.contains('hidden');
          
          if (isHidden) {
            // open
            answerPara.classList.remove('hidden');
            iconSpan.textContent = '−';
            answerPara.style.opacity = '0';
            answerPara.style.transition = 'opacity 0.2s ease';
            setTimeout(() => { answerPara.style.opacity = '1'; }, 8);
          } else {
            // close
            answerPara.classList.add('hidden');
            iconSpan.textContent = '+';
          }
        }
        
        faqButtons.forEach(btn => {
          btn.removeEventListener('click', accordionHandler);
          btn.addEventListener('click', accordionHandler);
        });
      }

      // Fetch FAQs from API
      async function fetchFaqs() {
        if (!slug) {
          // If no slug found, try a fallback message or show demo/default? But we show error gracefully.
          container.innerHTML = `
            <div class="text-center py-8 text-gray-500">
              <p class="text-sm">Unable to identify product from URL.</p>
              <p class="text-xs mt-1">Please visit a product page like /products/salwar-kameez</p>
            </div>
          `;
          return;
        }

        try {
          const response = await fetch(apiUrl, {
            method: 'GET',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            }
          });
          
          if (!response.ok) {
            throw new Error(`HTTP ${response.status}: Failed to load FAQs`);
          }
          
          const result = await response.json();
          
          // Validate API response structure as per given spec: { success: true, data: [...] }
          if (result && result.success === true && Array.isArray(result.data)) {
            renderFaqs(result.data);
          } else if (result && result.data && Array.isArray(result.data)) {
            // fallback for API that returns directly data array without success flag
            renderFaqs(result.data);
          } else {
            throw new Error('Invalid API response format');
          }
        } catch (error) {
          console.error('FAQ fetch error:', error);
          container.innerHTML = `
            <div class="text-center py-8 text-gray-500">
              <p class="text-sm text-red-500">⚠️ Unable to load FAQs at the moment.</p>
              <p class="text-xs mt-2 text-gray-400">${error.message || 'Please check API connection or try again later.'}</p>
            </div>
          `;
          errorDiv.classList.remove('hidden');
          errorDiv.innerHTML = '<span class="text-xs">💡 Tip: Ensure backend server is running at http://127.0.0.1:8000</span>';
        }
      }

      // Initial fetch
      fetchFaqs();
    })();
  </script>
  
  <!-- Additional style for category badge positioning and responsive spacing -->
  <style>
    .faq-category-badge {
      background: #fef2e8;
      color: #bc4e3b;
      font-size: 0.7rem;
      padding: 0.2rem 0.7rem;
      border-radius: 30px;
      display: inline-block;
      font-weight: 500;
      letter-spacing: 0.01em;
    }
    .faq-btn .flex-col {
      gap: 0.2rem;
    }
    .faq-btn:hover .faq-category-badge {
      background: #ffe6db;
    }
  </style>

<footer class="bg-gradient-to-b from-[#FCE7F3] to-[#FCE7F3]/80">
  <div class="container mx-auto px-4 lg:px-8 pt-6">

    <!-- Top Section with Newsletter & Instagram -->
    <div class="border-b border-[#EC4899]/30 pb-12 lg:pb-16">
      <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 items-center">

        <!-- Newsletter Section -->
        {{--
        <div class="flex-1 w-full max-w-2xl">
          <div class="text-center lg:text-left">
            <div class="inline-flex items-center gap-2 mb-3 lg:mb-4">
              <div class="w-6 h-6 rounded-full bg-gradient-to-r from-[#A10000] to-[#EC4899]"></div>
              <span class="text-sm font-semibold text-[#A10000] tracking-wider uppercase">Stay Updated</span>
            </div>
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 lg:mb-6 leading-tight">
              Subscribe to Our
              <span class="text-[#A10000]">Newsletter</span>
            </h2>
            <p class="text-gray-600 mb-6 lg:mb-8 text-sm lg:text-base">
              Get exclusive updates on new arrivals, special offers, and fashion tips delivered to your inbox.
            </p>
          </div>

          <form action="{{ route('newsletter.store') }}" method="POST">
        @csrf
        <div class="flex flex-col sm:flex-row gap-4">
          <div class="flex-1 relative group">
            <input
              type="email"
              name="email"
              class="w-full px-6 py-4 lg:py-5 bg-white/80 backdrop-blur-sm border-2 border-[#EC4899]/30 rounded-2xl lg:rounded-3xl outline-none text-gray-800 placeholder-gray-500 transition-all duration-300 focus:border-[#EC4899] focus:bg-white focus:shadow-lg focus:shadow-[#EC4899]/20"
              placeholder="Your email address" required />
            @error('email')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
            <div class="absolute inset-0 rounded-2xl lg:rounded-3xl bg-gradient-to-r from-[#A10000]/0 via-[#EC4899]/0 to-[#EC4899]/0 group-focus-within:from-[#A10000]/5 group-focus-within:via-[#EC4899]/5 group-focus-within:to-[#EC4899]/5 transition-all duration-500 -z-10"></div>
          </div>
          <button
            type="submit"
            class="px-8 py-4 lg:py-5 bg-gradient-to-r from-[#A10000] via-[#EC4899] to-[#EC4899] text-white font-semibold rounded-2xl lg:rounded-3xl hover:shadow-xl hover:shadow-[#EC4899]/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 whitespace-nowrap">
            Subscribe Now
            <span class="ml-2">→</span>
          </button>
        </div>
        </form>
      </div>
      --}}
      <!-- Newsletter Section with Enhanced Validation -->
      <div class="flex-1 w-full max-w-2xl">
        <div class="text-center lg:text-left">
          <div class="inline-flex items-center gap-2 mb-3 lg:mb-4">
            <div class="w-6 h-6 rounded-full bg-gradient-to-r from-[#A10000] to-[#EC4899]"></div>
            <span class="text-sm font-semibold text-[#A10000] tracking-wider uppercase">Stay Updated</span>
          </div>
          <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 lg:mb-6 leading-tight">
            Subscribe to Our
            <span class="text-[#A10000]">Newsletter</span>
          </h2>
          <p class="text-gray-600 mb-6 lg:mb-8 text-sm lg:text-base">
            Get exclusive updates on new arrivals, special offers, and fashion tips delivered to your inbox.
          </p>
        </div>

        <form action="{{ route('newsletter.store') }}" method="POST" novalidate id="newsletterForm">
          @csrf
          <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1 relative group">
              <input
                type="email"
                name="email"
                id="newsletterEmail"
                class="w-full px-6 py-4 lg:py-5 bg-white/80 backdrop-blur-sm border-2 border-[#EC4899]/30 rounded-2xl lg:rounded-3xl outline-none text-gray-800 placeholder-gray-500 transition-all duration-300 focus:border-[#EC4899] focus:bg-white focus:shadow-lg focus:shadow-[#EC4899]/20"
                placeholder="Your email address"
                autocomplete="off" />

            
              <div class="absolute inset-0 rounded-2xl lg:rounded-3xl bg-gradient-to-r from-[#A10000]/0 via-[#EC4899]/0 to-[#EC4899]/0 group-focus-within:from-[#A10000]/5 group-focus-within:via-[#EC4899]/5 group-focus-within:to-[#EC4899]/5 transition-all duration-500 -z-10"></div>
            </div>
            
            <button
              type="button"
              id="newsletterSubmitBtn"
              class="px-8 py-4 lg:py-5 bg-gradient-to-r from-[#A10000] via-[#EC4899] to-[#EC4899] text-white font-semibold rounded-2xl lg:rounded-3xl hover:shadow-xl hover:shadow-[#EC4899]/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed"
              onclick="validateAndSubmitNewsletter()">
              Subscribe Now
              <span class="ml-2">→</span>
            </button>
          </div>
          <!-- Error Message Container -->
              <div id="email-error" class="text-red-500 text-sm mt-1 hidden"></div>
               <!-- Success Message Container -->
              <div id="email-success" class="text-green-500 text-sm mt-1 hidden"></div>
        </form>
      </div>
      <!-- Divider - Hidden on mobile -->
      <div class="hidden lg:block w-[1px] h-40 bg-gradient-to-b from-transparent via-[#EC4899]/30 to-transparent self-stretch"></div>
      <div class="lg:hidden w-full h-[1px] bg-gradient-to-r from-transparent via-[#EC4899]/30 to-transparent"></div>

      <!-- Instagram Section -->
      <div class="flex-1 w-full">
        <div class="text-center lg:text-left">
          <div class="inline-flex items-center gap-3 mb-4 lg:mb-6">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#833AB4] via-[#E1306C] to-[#F77737] flex items-center justify-center">
              <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
              </svg>
            </div>
            <span class="text-lg font-bold text-gray-900">@AimanRoyale</span>
          </div>
          <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-6 lg:mb-8">
            Follow Our
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#833AB4] via-[#E1306C] to-[#F77737]">Instagram</span>
          </h3>
        </div>

        <div class="grid grid-cols-4 gap-3 lg:gap-4 max-w-md mx-auto lg:mx-0">
          <a href="https://www.instagram.com/aimanroyale/" target="_blank" rel="noopener noreferrer" class="relative group overflow-hidden rounded-xl lg:rounded-2xl aspect-square cursor-pointer">
            <img
              src="{{asset('web/images/product-images/dark-red-plazo-5_15_11zon.webp')}}"
              class="w-full h-19 object-cover object-center group-hover:scale-110 transition-transform duration-500"
              alt="Dark Red Plazo" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z" />
              </svg>
            </div>
          </a>

          <a href="https://www.instagram.com/aimanroyale/" target="_blank" rel="noopener noreferrer" class="relative group overflow-hidden rounded-xl lg:rounded-2xl aspect-square cursor-pointer">
            <img
              src="{{asset('web/images/product-images/glow-orange-3_18_11zon.webp')}}"
              class="w-full h-19 object-cover object-center group-hover:scale-110 transition-transform duration-500"
              alt="Glow Orange" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z" />
              </svg>
            </div>
          </a>

          <a href="https://www.instagram.com/aimanroyale/" target="_blank" rel="noopener noreferrer" class="relative group overflow-hidden rounded-xl lg:rounded-2xl aspect-square cursor-pointer">
            <img
              src="{{asset('web/images/product-images/glow-red-1_33_11zon.webp')}}"
              class="w-full h-19 object-cover object-center group-hover:scale-110 transition-transform duration-500"
              alt="Glow Red" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z" />
              </svg>
            </div>
          </a>

          <a href="https://www.instagram.com/aimanroyale/" target="_blank" rel="noopener noreferrer" class="relative group overflow-hidden rounded-xl lg:rounded-2xl aspect-square cursor-pointer">
            <img
              src="{{asset('web/images/product-images/green-plazo-4_46_11zon.webp')}}"
              class="w-full h-19 object-cover object-center group-hover:scale-110 transition-transform duration-500"
              alt="Green Plazo" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z" />
              </svg>
            </div>
          </a>
        </div>
        <p class="text-center lg:text-left text-sm text-gray-600 mt-4 lg:mt-6">
          Join <span class="font-semibold text-[#E1306C]">40K+</span> fashion enthusiasts
        </p>
      </div>
    </div>
  </div>

  <!-- Brand & Links Section -->
  <div class="py-6 lg:py-8">
    <!-- Brand Logo -->
    <div class="flex flex-col lgg:flex-row lgg:items-center lgg:justify-between mb-12 lgg:mb-16">
      <div class="mb-8 lg:mb-0">
        <div class="flex items-center gap-3 mb-4 md:justify-start justify-center">
          <a href="/">
            <img class="max-h-[100px] h-auto w-auto pointer-events-auto"
              src="{{ asset('web/images/company-logo/aiman-footer.webp') }}" alt="">
          </a>
        </div>
        <p class="text-gray-700 max-w-xl text-base lg:text-lg leading-relaxed md:mx-0 mx-auto md:text-left text-center">
          We are a fashion brand that offers the best of contemporary, ethnic Indian fashion,
          and fusion-wear styles. Redefining elegance with every stitch.
        </p>
      </div>

      <!-- Social Media Icons -->
      <div class="flex gap-4 lgg:justify-end md:justify-start justify-center items-center">
        <a href="https://www.facebook.com/AimanRoyale" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full bg-white/80 backdrop-blur-sm border border-[#EC4899]/30 flex items-center justify-center hover:bg-[#1877F2] hover:text-white hover:border-[#1877F2] transition-all duration-300 group">
          <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
          </svg>
        </a>
        <!-- <a href="https://www.instagram.com/aimanroyale/" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full bg-white/80 backdrop-blur-sm border border-[#EC4899]/30 flex items-center justify-center hover:bg-[#1DA1F2] hover:text-white hover:border-[#1DA1F2] transition-all duration-300 group">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.213c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
            </svg>
          </a> -->
        <a href="https://www.instagram.com/aimanroyale/" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full bg-white/80 backdrop-blur-sm border border-[#EC4899]/30 flex items-center justify-center hover:bg-gradient-to-r hover:from-[#833AB4] hover:via-[#E1306C] hover:to-[#F77737] hover:text-white hover:border-transparent transition-all duration-300 group">
          <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
          </svg>
        </a>
        <!-- <a href="#" class="w-12 h-12 rounded-full bg-white/80 backdrop-blur-sm border border-[#EC4899]/30 flex items-center justify-center hover:bg-[#0077B5] hover:text-white hover:border-[#0077B5] transition-all duration-300 group">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
              <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
            </svg>
          </a> -->
      </div>
    </div>

    <!-- Links Section with Accordion -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 lg:gap-6">
      <!-- Quick Links -->
      <div class="lg:col-span-1">
        <div class="accordion-header lg:cursor-default group" data-target="quick-links">
          <div class="flex items-center justify-between lg:justify-start">
            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
              <div class="w-2 h-8 bg-gradient-to-b from-[#A10000] to-[#EC4899] rounded-full"></div>
              Quick Links
            </h3>
            <svg class="lg:hidden w-5 h-5 text-gray-600 group-[.active]:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>
        <div id="quick-links" class="accordion-content mt-6 lg:mt-8 space-y-4">
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#A10000] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#EC4899] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Men's Collection</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#A10000] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#EC4899] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Women's Collection</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#A10000] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#EC4899] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">New Arrivals</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#A10000] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#EC4899] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Couples Wear</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#A10000] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#EC4899] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Kids Collection</span>
          </a>
        </div>
      </div>

      <!-- Vastram -->
      <div class="lg:col-span-1">
        <div class="accordion-header lg:cursor-default group" data-target="vastram">
          <div class="flex items-center justify-between lg:justify-start">
            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
              <div class="w-2 h-8 bg-gradient-to-b from-[#EC4899] to-[#EC4899]/60 rounded-full"></div>
              Vastram
            </h3>
            <svg class="lg:hidden w-5 h-5 text-gray-600 group-[.active]:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>
        <div id="vastram" class="accordion-content mt-6 lg:mt-8 space-y-4">
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#EC4899] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#EC4899]/60 mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Our Story</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#EC4899] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#EC4899]/60 mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Contact Us</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#EC4899] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#EC4899]/60 mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Fashion Blog</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#EC4899] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#EC4899]/60 mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Press & Media</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#EC4899] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#EC4899]/60 mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Join Our Team</span>
          </a>
        </div>
      </div>

      <!-- Policies -->
      <div class="lg:col-span-1">
        <div class="accordion-header lg:cursor-default group" data-target="policies">
          <div class="flex items-center justify-between lg:justify-start">
            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
              <div class="w-2 h-8 bg-gradient-to-b from-[#EC4899]/60 to-[#FCE7F3] rounded-full"></div>
              Policies
            </h3>
            <svg class="lg:hidden w-5 h-5 text-gray-600 group-[.active]:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>
        <div id="policies" class="accordion-content mt-6 lg:mt-8 space-y-4">
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#EC4899]/80 transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#FCE7F3] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Terms & Conditions</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#EC4899]/80 transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#FCE7F3] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Shipping Policy</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#EC4899]/80 transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#FCE7F3] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Return & Exchange</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#EC4899]/80 transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#FCE7F3] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Privacy Policy</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#EC4899]/80 transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#FCE7F3] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Payment Security</span>
          </a>
        </div>
      </div>

      <!-- My Account -->
      <div class="lg:col-span-1">
        <div class="accordion-header lg:cursor-default group" data-target="account">
          <div class="flex items-center justify-between lg:justify-start">
            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
              <div class="w-2 h-8 bg-gradient-to-b from-[#FCE7F3] to-[#A10000] rounded-full"></div>
              My Account
            </h3>
            <svg class="lg:hidden w-5 h-5 text-gray-600 group-[.active]:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>
        <div id="account" class="accordion-content mt-6 lg:mt-8 space-y-4">
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#A10000] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#A10000] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Login / Register</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#A10000] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#A10000] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Shopping Bag</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#A10000] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#A10000] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Wishlist</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#A10000] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#A10000] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Order Tracking</span>
          </a>
          <a href="#" class="flex items-center group/link text-gray-600 hover:text-[#A10000] transition-colors duration-300">
            <div class="w-1 h-1 rounded-full bg-[#A10000] mr-3 group-hover/link:w-2 group-hover/link:h-2 transition-all duration-300"></div>
            <span class="font-medium">Order History</span>
          </a>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="lg:col-span-1">
        <div class="lg:cursor-default">
          <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3 mb-8">
            <div class="w-2 h-8 bg-gradient-to-b from-[#A10000] via-[#EC4899] to-[#FCE7F3] rounded-full"></div>
            Contact Info
          </h3>
        </div>
        <div class="space-y-6">
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#A10000]/10 to-[#EC4899]/10 flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-[#A10000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <div>
              <p class="font-medium text-gray-900">Our Store</p>
              <p class="text-sm text-gray-600 mt-1">123 Fashion Street, Mumbai, India</p>
            </div>
          </div>
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#A10000]/10 to-[#EC4899]/10 flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-[#A10000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
            </div>
            <div>
              <p class="font-medium text-gray-900">Call Us</p>
              <p class="text-sm text-gray-600 mt-1">+91 98765 43210</p>
            </div>
          </div>
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#A10000]/10 to-[#EC4899]/10 flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-[#A10000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </div>
            <div>
              <p class="font-medium text-gray-900">Email Us</p>
              <p class="text-sm text-gray-600 mt-1 break-all">support@aimanfashion.com</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="space-y-2">

    <!-- LATEST ETHNIC COLLECTION -->
    <div class="w-full">
      <span class="font-semibold uppercase tracking-wide text-gray-900 block mb-2">
        Latest Ethnic Collection
      </span>
      <p class="text-gray-700 text-sm leading-relaxed">
        Premium collections like Zehn Couture, Mushk Couture '24, and The Atelier Couture featuring exquisite traditional and contemporary designs.
      </p>
    </div>

    <!-- NEW ARRIVAL -->
    <div class="w-full">
      <span class="font-semibold uppercase tracking-wide text-gray-900 block mb-2">
        New Arrival
      </span>
      <p class="text-gray-700 text-sm leading-relaxed">
        Fresh additions of salwar suits, sarees, lehengas, and men's wear showcasing latest seasonal trends and styles.
      </p>
    </div>

    <!-- BEST SELLER -->
    <div class="w-full">
      <span class="font-semibold uppercase tracking-wide text-gray-900 block mb-2">
        Best Seller
      </span>
      <p class="text-gray-700 text-sm leading-relaxed">
        Our most loved salwar suits, sarees, lehengas, gowns, and men's wear based on customer reviews and timeless appeal.
      </p>
    </div>

    <!-- MEASUREMENT -->
    <div class="w-full">
      <span class="font-semibold uppercase tracking-wide text-gray-900 block mb-2">
        Measurement
      </span>
      <p class="text-gray-700 text-sm leading-relaxed">
        Detailed guides for saree/blouse, salwar/kameez, lehenga/choli, gowns, plus size charts and maternity fitting tips.
      </p>
    </div>

  </div>

  <!-- Extended Services Row -->
  <div class="container mx-auto px-0 py-6 mt-3">
    <div class="grid grid-cols-2 sm:grid-cols-3 lgg:grid-cols-6 gap-6">
      <div class="text-center group">
        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-white to-[#FCE7F3] border border-[#EC4899]/30 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 group-hover:shadow-lg transition-all duration-300">
          <svg class="w-6 h-6 text-[#A10000]" fill="currentColor" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-width="0.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
          </svg>
        </div>
        <p class="font-semibold text-gray-900 text-sm">Cash on Delivery</p>
        <p class="text-xs text-gray-600 mt-1">Available</p>
      </div>

      <div class="text-center group">
        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-white to-[#FCE7F3] border border-[#EC4899]/30 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 group-hover:shadow-lg transition-all duration-300">
          <svg class="w-6 h-6 text-[#A10000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <p class="font-semibold text-gray-900 text-sm">Express Delivery</p>
        <p class="text-xs text-gray-600 mt-1">2-3 Days</p>
      </div>

      <div class="text-center group">
        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-white to-[#FCE7F3] border border-[#EC4899]/30 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 group-hover:shadow-lg transition-all duration-300">
          <svg class="w-6 h-6 text-[#A10000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
          </svg>
        </div>
        <p class="font-semibold text-gray-900 text-sm">Quality Checked</p>
        <p class="text-xs text-gray-600 mt-1">100% Authentic</p>
      </div>

      <div class="text-center group">
        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-white to-[#FCE7F3] border border-[#EC4899]/30 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 group-hover:shadow-lg transition-all duration-300">
          <svg class="w-6 h-6 text-[#A10000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
          </svg>
        </div>
        <p class="font-semibold text-gray-900 text-sm">EMI Options</p>
        <p class="text-xs text-gray-600 mt-1">0% Interest</p>
      </div>

      <div class="text-center group">
        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-white to-[#FCE7F3] border border-[#EC4899]/30 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 group-hover:shadow-lg transition-all duration-300">
          <svg class="w-6 h-6 text-[#A10000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
        <p class="font-semibold text-gray-900 text-sm">Bulk Orders</p>
        <p class="text-xs text-gray-600 mt-1">Custom Tailoring</p>
      </div>

      <div class="text-center group">
        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-white to-[#FCE7F3] border border-[#EC4899]/30 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 group-hover:shadow-lg transition-all duration-300">
          <svg class="w-6 h-6 text-[#A10000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
          </svg>
        </div>
        <p class="font-semibold text-gray-900 text-sm">Easy Returns</p>
        <p class="text-xs text-gray-600 mt-1">15 Days Policy</p>
      </div>
    </div>
  </div>


  <!-- Bottom Bar -->
  <div class="border-t border-[#EC4899]/30 pt-8 pb-12">
    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
      <div class="text-center md:text-left">
        <p class="text-gray-600 text-sm">
          &copy; {{now()->format('Y')}} Aiman Fashion. All rights reserved.
        </p>
        <p class="text-gray-500 text-xs mt-2">
          Crafted with ❤️ in India
        </p>
      </div>
      <div class="flex items-center gap-8">
        <div class="flex items-center gap-4">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/visa.svg" class="w-10 h-6" alt="Visa">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/mastercard.svg" class="w-10 h-6" alt="Mastercard">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/paypal.svg" class="w-10 h-6" alt="PayPal">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/razorpay.svg" class="w-10 h-6" alt="Razorpay">
        </div>
      </div>
    </div>
  </div>
  </div>
</footer>
<!-- WhatsApp Floating Button -->
<!-- Fashion WhatsApp Floating Button -->
<a href="https://wa.me/919999999999" target="_blank"
  class="fixed bottom-[7.5rem] right-4 md:bottom-6 md:right-6 z-[60] group">



  <!-- Main Button -->
  <div class="relative flex items-center justify-center w-14 h-14 md:w-16 md:h-16 rounded-full bg-green-500 shadow-[0_10px_25px_rgba(236,72,153,0.35)] hover:shadow-[0_15px_35px_rgba(236,72,153,0.5)] hover:scale-110 active:scale-95 transition-all duration-300">

    <i class="fab fa-whatsapp text-white text-2xl md:text-3xl drop-shadow"></i>

    <!-- Shine Effect -->
    <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-white/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
  </div>

  <!-- Fashion Tooltip -->
  <div class="absolute right-16 md:right-20 top-1/2 -translate-y-1/2 bg-gradient-to-r from-[#111] to-[#333] text-white text-xs px-4 py-2 rounded-full opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0 transition-all duration-300 whitespace-nowrap shadow-xl tracking-wide">
    Chat Now on WhatsApp
  </div>
</a>


<!-- Light-themed Mobile Navigation Bar -->
<div class="sticky bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-t border-gray-200/80 shadow-[0_-4px_20px_rgba(0,0,0,0.08)] md:hidden block">

  <!-- Attractive Banner -->
  <a href="/" class="w-full">
    <div class="w-full bg-gradient-to-r from-pink-500 via-red-500 to-pink-600 py-2 px-4">
      <div class="flex items-center justify-center gap-2 animate-pulse">
        <i class="fas fa-gem text-white text-sm"></i>
        <span class="text-white text-xs font-semibold tracking-wide">Custom style meets live shopping</span>
        <i class="fas fa-arrow-right text-white text-sm  ml-1"></i>
      </div>
    </div>
  </a>

  <!-- Navigation Buttons -->
  <div class="px-2 py-2 flex items-center justify-between gap-0 max-w-screen-sm mx-auto">

    <!-- Home Button -->
    <button class="nav-item flex flex-col items-center justify-center w-14 py-2 rounded-xl hover:bg-[#FCE7F3] active:scale-95 transition-all duration-300 group relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-b from-transparent to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
      <i class="fas fa-home text-xl text-gray-600 mb-1 group-hover:text-[#EC4899] group-hover:scale-110 transition-all duration-300 relative z-10"></i>
      <span class="text-[10px] font-semibold text-gray-700 group-hover:text-[#EC4899] transition-colors relative z-10">Home</span>
      <div class="absolute bottom-0 w-6 h-0.5 bg-transparent group-hover:bg-[#EC4899] rounded-full transition-all duration-300"></div>
    </button>

    <!-- Categories Button -->
    <button class="nav-item flex flex-col items-center justify-center w-14 py-2 rounded-xl hover:bg-blue-50 active:scale-95 transition-all duration-300 group relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-b from-transparent to-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
      <i class="fas fa-th-large text-xl text-gray-600 mb-1 group-hover:text-blue-600 group-hover:scale-110 transition-all duration-300 relative z-10"></i>
      <span class="text-[10px] font-semibold text-gray-700 group-hover:text-blue-600 transition-colors relative z-10">Categories</span>
      <div class="absolute bottom-0 w-6 h-0.5 bg-transparent group-hover:bg-blue-600 rounded-full transition-all duration-300"></div>
    </button>

    <!-- Trending Button (Active/Featured) -->
    <button class="nav-item mt-[-5px] active-nav flex flex-col items-center justify-center w-16 py-2  rounded-2xl bg-gradient-to-br from-[#A10000] via-[#EC4899] to-[#FF6B9D] border-2 border-white shadow-xl hover:shadow-2xl active:scale-95 transition-all duration-300 relative group">
      <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
      <div class="relative mb-0.5">
        <i class="fas fa-fire text-xl text-white group-hover:animate-pulse"></i>
        <div class="absolute -inset-2 bg-gradient-to-r from-[#EC4899] to-[#FF6B9D] rounded-full animate-ping opacity-20"></div>
        <div class="absolute -inset-1 bg-gradient-to-r from-[#EC4899] to-[#FF6B9D] rounded-full opacity-20"></div>
      </div>
      <span class="text-xs font-bold text-white drop-shadow-sm">Trending</span>
      <div class="absolute -top-1 inset-x-1/4 w-8 h-1 bg-gradient-to-r from-white/90 to-white/60 rounded-full shadow-sm"></div>
      <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 w-12 h-1 bg-gradient-to-r from-transparent via-white/40 to-transparent rounded-full blur-sm"></div>
    </button>

    <!-- Offers Button -->
    <button class="nav-item flex flex-col items-center justify-center w-14 py-2 rounded-xl hover:bg-amber-50 active:scale-95 transition-all duration-300 group relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-b from-transparent to-amber-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
      <div class="relative">
        <i class="fas fa-percent text-xl text-gray-600 mb-1 group-hover:text-amber-600 group-hover:scale-110 transition-all duration-300 relative z-10"></i>
        <div class="absolute -top-1 -right-2 w-2 h-2 bg-amber-400 rounded-full animate-pulse opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
      </div>
      <span class="text-[10px] font-semibold text-gray-700 group-hover:text-amber-600 transition-colors relative z-10">Offers</span>
      <div class="absolute bottom-0 w-6 h-0.5 bg-transparent group-hover:bg-amber-600 rounded-full transition-all duration-300"></div>
    </button>

    <!-- Book Appointment Button -->
    <button class="nav-item flex flex-col items-center justify-center w-[74px] py-2 rounded-xl hover:bg-emerald-50 active:scale-95 transition-all duration-300 group relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-b from-transparent to-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
      <i class="fas fa-calendar-check text-xl text-gray-600 mb-1 group-hover:text-emerald-600 group-hover:scale-110 transition-all duration-300 relative z-10"></i>
      <span class="text-[10px] font-semibold text-gray-700 group-hover:text-emerald-600 transition-colors text-center leading-tight px-0.5 relative z-10">Book Appointment</span>
      <div class="absolute bottom-0 w-6 h-0.5 bg-transparent group-hover:bg-emerald-600 rounded-full transition-all duration-300"></div>
    </button>

  </div>

  <!-- Safe area padding for iPhone bottom notch -->
  <div class="h-[env(safe-area-inset-bottom)] bg-gradient-to-b from-white to-gray-50/50"></div>
</div>


<!-- Add this script at the end of your HTML -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const accordionHeaders = document.querySelectorAll('.accordion-header');

    // Initialize accordion states
    accordionHeaders.forEach(header => {
      const targetId = header.getAttribute('data-target');
      const content = document.getElementById(targetId);
      const isMobile = window.innerWidth < 1024;

      if (isMobile) {
        // Collapse all on mobile initially
        content.style.maxHeight = '0';
        content.style.opacity = '0';
        content.style.overflow = 'hidden';
      } else {
        // Expand all on desktop
        content.style.maxHeight = content.scrollHeight + 'px';
        content.style.opacity = '1';
      }
    });

    // Toggle accordion on click for mobile
    accordionHeaders.forEach(header => {
      header.addEventListener('click', function(e) {
        // Only activate on mobile
        if (window.innerWidth >= 1024) return;

        const targetId = this.getAttribute('data-target');
        const content = document.getElementById(targetId);
        const icon = this.querySelector('svg');

        // Check if this accordion is already active
        const isActive = this.classList.contains('active');

        // Close all other accordions
        accordionHeaders.forEach(otherHeader => {
          if (otherHeader !== header) {
            const otherTargetId = otherHeader.getAttribute('data-target');
            const otherContent = document.getElementById(otherTargetId);
            const otherIcon = otherHeader.querySelector('svg');

            otherHeader.classList.remove('active');
            otherContent.style.maxHeight = '0';
            otherContent.style.opacity = '0';
            otherIcon.classList.remove('rotate-180');
          }
        });

        // Toggle current accordion
        if (!isActive) {
          this.classList.add('active');
          content.style.maxHeight = content.scrollHeight + 'px';
          content.style.opacity = '1';
          if (icon) icon.classList.add('rotate-180');
        } else {
          this.classList.remove('active');
          content.style.maxHeight = '0';
          content.style.opacity = '0';
          if (icon) icon.classList.remove('rotate-180');
        }
      });
    });

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
        const isMobile = window.innerWidth < 1024;

        accordionHeaders.forEach(header => {
          const targetId = header.getAttribute('data-target');
          const content = document.getElementById(targetId);
          const icon = header.querySelector('svg');

          if (isMobile) {
            // On mobile, collapse all
            header.classList.remove('active');
            content.style.maxHeight = '0';
            content.style.opacity = '0';
            if (icon) icon.classList.remove('rotate-180');
          } else {
            // On desktop, expand all
            content.style.maxHeight = content.scrollHeight + 'px';
            content.style.opacity = '1';
            if (icon) icon.classList.remove('rotate-180');
          }
        });
      }, 250);
    });
  });
</script>

<!-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    const redirectButton = document.getElementById('redi-sec-dyna');
    const targetSection = document.getElementById('dynamic-content-sec');

    if (redirectButton && targetSection) {
      redirectButton.addEventListener('click', function(e) {
        // e.preventDefault();

        const headerOffset = 80; // height of your fixed header
        const elementPosition = targetSection.getBoundingClientRect().top + window.pageYOffset;
        const offsetPosition = elementPosition - headerOffset;

        window.scrollTo({
          top: offsetPosition,
          behavior: "smooth"
        });
      });
    }
  });
</script> -->

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.redi-sec-dyna');

    buttons.forEach(function(button) {
      button.addEventListener('click', function() {
        const targetId = button.getAttribute('data-target');
        const targetSection = document.getElementById(targetId);

        if (targetSection) {
          const headerOffset = 80;
          const elementPosition = targetSection.getBoundingClientRect().top + window.pageYOffset;
          const offsetPosition = elementPosition - headerOffset;

          window.scrollTo({
            top: offsetPosition,
            behavior: "smooth"
          });
        }
      });
    });
  });
</script>
<script>
// Newsletter Validation Function
window.validateAndSubmitNewsletter = function() {
  try {
    console.log('Newsletter validation triggered');

    // Get form elements
    const form = document.getElementById('newsletterForm');
    const emailInput = document.getElementById('newsletterEmail');
    const emailError = document.getElementById('email-error');
    const emailSuccess = document.getElementById('email-success');
    const submitBtn = document.getElementById('newsletterSubmitBtn');

    // Reset previous states
    resetValidationStates(emailInput, emailError, emailSuccess);

    // Get email value
    const emailValue = emailInput.value.trim();
    
    // Validation checks
    const validationResult = validateEmail(emailValue);
    
    if (!validationResult.isValid) {
      // Show error message
      showError(emailInput, emailError, validationResult.message);
      
      // Shake animation for error
      emailInput.classList.add('animate-shake');
      setTimeout(() => {
        emailInput.classList.remove('animate-shake');
      }, 500);
      
      return false; // Don't submit
    }

    // If validation passes, disable button to prevent double submission
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Submitting... <span class="ml-2">⏳</span>';
    
    // Show success message (optional)
    showSuccess(emailSuccess, 'Valid email! Submitting...');
    
    // Submit the form after a short delay (for UX)
    setTimeout(() => {
      form.submit();
    }, 300);

    return true;

  } catch (error) {
    console.error('Newsletter validation error:', error);
    // Fallback: submit the form anyway
    const fallbackForm = document.getElementById('newsletterForm');
    if (fallbackForm) {
      fallbackForm.submit();
    }
  }
};

// Email validation function with custom messages
function validateEmail(email) {
  // Check if email is empty
  if (!email) {
    return {
      isValid: false,
      message: 'Please enter your email address.'
    };
  }

  // Check email format using regex
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    return {
      isValid: false,
      message: 'Please enter a valid email address (e.g., name@example.com).'
    };
  }

  // Check for common typos
  if (email.includes('..') || email.includes('@.') || email.includes('.@')) {
    return {
      isValid: false,
      message: 'Email address contains invalid characters or format.'
    };
  }

  // Check domain part
  const domain = email.split('@')[1];
  if (domain && !domain.includes('.')) {
    return {
      isValid: false,
      message: 'Email domain must include a dot (e.g., .com, .org).'
    };
  }

  // Check for spaces
  if (email.includes(' ')) {
    return {
      isValid: false,
      message: 'Email address cannot contain spaces.'
    };
  }

  // All validations passed
  return {
    isValid: true,
    message: 'Email is valid!'
  };
}

// Reset validation states
function resetValidationStates(emailInput, emailError, emailSuccess) {
  // Remove error states
  emailInput.classList.remove('border-red-500', 'border-green-500', 'animate-shake');
  
  // Hide error and success messages
  if (emailError) {
    emailError.classList.add('hidden');
    emailError.textContent = '';
  }
  
  if (emailSuccess) {
    emailSuccess.classList.add('hidden');
    emailSuccess.textContent = '';
  }
}

// Show error message
function showError(emailInput, emailError, message) {
  emailInput.classList.add('border-red-500');
  emailInput.classList.remove('border-green-500');
  
  if (emailError) {
    emailError.textContent = message;
    emailError.classList.remove('hidden');
    
    // Add icon to error message (optional)
    emailError.innerHTML = `⚠️ ${message}`;
  }
}

// Show success message
function showSuccess(emailSuccess, message) {
  if (emailSuccess) {
    emailSuccess.textContent = message;
    emailSuccess.classList.remove('hidden');
    
    // Add icon to success message (optional)
    emailSuccess.innerHTML = `✅ ${message}`;
  }
}

// DOM Content Loaded - Set up real-time validation
document.addEventListener('DOMContentLoaded', function() {
  console.log('Setting up real-time validation');
  
  const emailInput = document.getElementById('newsletterEmail');
  const emailError = document.getElementById('email-error');
  const emailSuccess = document.getElementById('email-success');
  const submitBtn = document.getElementById('newsletterSubmitBtn');

  if (emailInput && emailError) {
    
    // Real-time validation with debounce
    let debounceTimer;
    emailInput.addEventListener('input', function() {
      clearTimeout(debounceTimer);
      
      const emailValue = this.value.trim();
      
      // Reset styles
      this.classList.remove('border-red-500', 'border-green-500');
      emailError.classList.add('hidden');
      
      if (emailSuccess) {
        emailSuccess.classList.add('hidden');
      }
      
      // Debounce validation to improve performance
      debounceTimer = setTimeout(() => {
        if (emailValue.length > 0) {
          const validationResult = validateEmail(emailValue);
          
          if (validationResult.isValid) {
            this.classList.add('border-green-500');
            if (emailSuccess) {
              showSuccess(emailSuccess, '✓ Valid email');
            }
          } else {
            this.classList.add('border-red-500');
            if (emailError) {
              emailError.textContent = validationResult.message;
              emailError.classList.remove('hidden');
            }
          }
        }
      }, 300);
    });

    // Clear validation on focus
    emailInput.addEventListener('focus', function() {
      this.classList.remove('border-red-500', 'border-green-500');
      emailError.classList.add('hidden');
      if (emailSuccess) {
        emailSuccess.classList.add('hidden');
      }
    });

    // Validate on blur (when user leaves the input)
    emailInput.addEventListener('blur', function() {
      const emailValue = this.value.trim();
      
      if (emailValue) {
        const validationResult = validateEmail(emailValue);
        
        if (!validationResult.isValid) {
          showError(this, emailError, validationResult.message);
        } else {
          this.classList.add('border-green-500');
          if (emailSuccess) {
            showSuccess(emailSuccess, '✓ Valid email');
          }
        }
      }
    });
    
    // Prevent form submission on Enter key if invalid
    emailInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        validateAndSubmitNewsletter();
      }
    });
  }
  
  // Handle existing session errors (if any)
  @isset($errors)
    @if ($errors->has('email'))
      const errorMessage = "{{ $errors->first('email') }}";
      if (emailInput && emailError) {
        showError(emailInput, emailError, errorMessage);
      }
    @endif
  @endisset
  
  // Handle success message from session
  @if (session('success'))
    if (emailInput && emailSuccess) {
      emailInput.classList.add('border-green-500');
      showSuccess(emailSuccess, "{{ session('success') }}");
      
      // Clear input after success
      emailInput.value = '';
      
      // Hide success message after 5 seconds
      setTimeout(() => {
        emailSuccess.classList.add('hidden');
        emailInput.classList.remove('border-green-500');
      }, 5000);
    }
  @endif
});

// Add shake animation for error feedback
const style = document.createElement('style');
style.textContent = `
  @keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
  }
  .animate-shake {
    animation: shake 0.5s ease-in-out;
  }
  
  /* Success and error message styling */
  #email-error, #email-success {
    transition: all 0.3s ease;
    padding-left: 0.5rem;
    font-weight: 500;
  }
  
  #email-error {
    color: #dc2626;
  }
  
  #email-success {
    color: #059669;
  }
  
  /* Input transition effects */
  #newsletterEmail {
    transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
  }
  
  #newsletterEmail.border-green-500 {
    border-color: #10b981;
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.1);
  }
  
  #newsletterEmail.border-red-500 {
    border-color: #ef4444;
    box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.1);
  }
`;
document.head.appendChild(style);
</script>


<style>
  .accordion-content {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* Mobile border styling */
  @media (max-width: 1023px) {
    .accordion-header {
      padding: 1.25rem 0;
      border-bottom: 1px solid rgba(232, 200, 200, 0.3);
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .accordion-header:first-child {
      border-top: 1px solid rgba(232, 200, 200, 0.3);
    }

    .accordion-header:hover {
      background-color: rgba(251, 237, 236, 0.3);
    }

    .accordion-header.active {
      background-color: rgba(251, 237, 236, 0.5);
    }
  }

  /* Desktop styling */
  @media (min-width: 1024px) {
    .accordion-header {
      cursor: default;
    }

    .accordion-content {
      max-height: 500px !important;
      opacity: 1 !important;
    }
  }

  /* Hover effects for links */
  .group\/link:hover .group-hover\/link\:w-2 {
    width: 0.5rem;
  }

  .group\/link:hover .group-hover\/link\:h-2 {
    height: 0.5rem;
  }

  /* Smooth image hover effects */
  .group img {
    transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .group:hover img {
    transform: scale(1.1);
  }

  /* Gradient animations */
  @keyframes gradient-shift {
    0% {
      background-position: 0% 50%;
    }

    50% {
      background-position: 100% 50%;
    }

    100% {
      background-position: 0% 50%;
    }
  }

  .bg-gradient-animate {
    background-size: 200% 200%;
    animation: gradient-shift 3s ease infinite;
  }
</style>
{{-- @if(session('success'))
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: '{{ session('success') }}',
showConfirmButton: false,
timer: 3000
});
</script>
@endif --}}
@if (session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('success') }}",
    confirmButtonText: 'OK',
    confirmButtonColor: 'green'
  });
</script>
@endif