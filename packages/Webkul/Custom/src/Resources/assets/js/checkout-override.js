// Override the stepForward method to skip shipping step
const originalStepForward = window.vueMixins.methods.stepForward;

window.vueMixins = window.vueMixins || {};
window.vueMixins.methods = window.vueMixins.methods || {};

window.vueMixins.methods.stepForward = function(step) {
    // Always skip shipping step
    if (step === 'shipping') {
        this.currentStep = 'payment';
        return;
    }
    
    // Call original method for other steps
    return originalStepForward.call(this, step);
};

// Override the stepProcessed method to handle shipping methods
const originalStepProcessed = window.vueMixins.methods.stepProcessed;

window.vueMixins.methods.stepProcessed = function(data) {
    // Skip processing shipping methods
    if (this.currentStep === 'shipping') {
        // If there are shipping methods but we want to skip them
        if (data && data.rates && data.rates.length > 0) {
            // Select the first shipping method automatically
            this.$axios.post(
                '{{ route('shop.checkout.onepage.shipping_methods.store') }}',
                { shipping_method: data.rates[0].method }
            ).then(response => {
                this.stepForward('payment');
            });
            return;
        }
    }
    
    // Call original method for other steps
    return originalStepProcessed.call(this, data);
};
