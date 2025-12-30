<?php

namespace Webkul\Custom\View\Composers;

use Illuminate\View\View;

class CheckoutComposer
{
    public function compose(View $view)
    {
        // Set flags to control checkout flow
        $view->with([
            'hideShippingMethod' => true,
            'shouldHideShipping' => true,
            'skipShippingStep' => true
        ]);
        
        // Set global view variables
        view()->share([
            'shouldHideShipping' => true,
            'skipShippingStep' => true
        ]);
    }
}
