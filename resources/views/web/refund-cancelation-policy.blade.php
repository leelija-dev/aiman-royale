@extends('layout.web.main-layout')

@section('title', 'Return & Refund Policy - Aiman Royale Luxury Fashion')

@section('content')
<!-- Return & Refund Policy Page -->
<section class="relative overflow-hidden bg-white py-8">
    <!-- Subtle Background Decor -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 right-10 w-72 h-72 bg-secondary-light/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-secondary/5 rounded-full blur-3xl"></div>
    </div>

    <div class="container mx-auto px-6 md:px-10 lg:px-16 relative z-10">
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-stone-800 mb-4">
                Return & <span class="text-secondary">Refund Policy</span> | Aiman Royale
            </h1>
            <div class="w-16 h-0.5 bg-gradient-to-r from-secondary to-secondary-light mx-auto rounded-full"></div>
            
        </div>

        <!-- Content -->
        <div class="max-w-7xl mx-auto">
            <!-- Introduction -->
            <div class="bg-secondary-light/20 border-l-4 border-secondary rounded-r-2xl p-6 mb-8">
                <p class="text-stone-700 text-sm leading-relaxed">
                    At Aiman Royale, we devote a considerable amount of time to inspecting the apparel and removing any unwanted issues that may have crept in before the final packing. Thus, it is nearly impossible for you to get dissatisfied with our product. However, if for any reason you face any discrepancy, we gladly arrange to rectify the same or exchange the defective one with another.
                </p>
                <p class="text-stone-700 text-sm leading-relaxed mt-3">
                    For clarity, please read our terms and conditions regarding our returns and exchange policies.
                </p>
            </div>

            <!-- 7-day returns -->
            <div class="mb-8">
                <h2 class="text-xl md:text-2xl font-bold text-stone-800 mb-3 pb-2 border-b border-stone-200">
                    7-day returns, with exchange and money-back policy
                </h2>
                <p class="text-stone-600 leading-relaxed">
                    For product-related issues, you can return it to us within 7 days from the date of the order delivered to get a complete refund of its price. However, if you have any issues with the dress's size specifications, we can exchange the delivered item for a properly sized one.
                </p>
            </div>

            <!-- Things to keep in mind -->
            <div class="mb-8">
                <h2 class="text-xl md:text-2xl font-bold text-stone-800 mb-3 pb-2 border-b border-stone-200">
                    Things to keep in mind
                </h2>
                <p class="text-stone-600 leading-relaxed">
                    You must not use or wear the product, or tear the packaging seal or price tag. The product you want to return or exchange must be in perfect condition; otherwise, your request will be declined.
                </p>
                <p class="text-stone-600 leading-relaxed mt-3">
                    Every outfit is delivered with a non-removable security tag - take care not to dislodge or tamper with it. Otherwise, the item will no longer be eligible for return or exchange under any circumstances.
                </p>
                <p class="text-stone-600 leading-relaxed mt-3">
                    Items can only be exchanged for the incorrect size or fit. Any other criteria will not be deemed for approval. Also, those that have already been exchanged are not meant for further return or any type of exchange.
                </p>
            </div>

            <!-- List of non-returnable / non-exchangeable items -->
            <div class="mb-8">
                <h2 class="text-xl md:text-2xl font-bold text-stone-800 mb-3 pb-2 border-b border-stone-200">
                    List of non-returnable / non-exchangeable items
                </h2>
                <p class="text-stone-600 leading-relaxed">
                    Customised apparel orders that come in two or three-piece sets.
                </p>
                <p class="text-stone-600 leading-relaxed mt-2">
                    Some paired accessories, including handbags, belts, etc.
                </p>
            </div>

            <!-- Processing options for product returns -->
            <div class="mb-8">
                <h2 class="text-xl md:text-2xl font-bold text-stone-800 mb-3 pb-2 border-b border-stone-200">
                    Processing options for product returns
                </h2>
                <p class="text-stone-600 leading-relaxed">
                    If you are dissatisfied with any of our products, drop an email to support@aimanfashion.com within a week of receiving the parcel. Our WhatsApp and real-time customer chat support system remains open 24/7 - you can lodge a complaint regarding the same over there to initiate the payment refund process at the earliest.
                </p>
            </div>

            <!-- For offline payment -->
            <div class="mb-8">
                <h2 class="text-xl md:text-2xl font-bold text-stone-800 mb-3 pb-2 border-b border-stone-200">
                    For offline payment
                </h2>
                <p class="text-stone-600 leading-relaxed">
                    If you have paid for your product through cash on delivery, we shall collect your bank account details. This will help us arrange for a refund in the case of product discrepancy.
                </p>
            </div>

            <!-- For online payment -->
            <div class="mb-8">
                <h2 class="text-xl md:text-2xl font-bold text-stone-800 mb-3 pb-2 border-b border-stone-200">
                    For online payment
                </h2>
                <p class="text-stone-600 leading-relaxed">
                    If any valid case of product return arises due to a specific discrepancy, we shall investigate the same, post-receipt of your complaint, and arrange for a quick repayment through the same portal from where the payment was processed.
                </p>
                <p class="text-stone-600 leading-relaxed mt-3">
                    In case the return is due to a specific technical error from our side, such as sending a wrong item, a damaged/defective product, we are going to replace it or return the full amount without deducting any shipping charges.
                </p>
            
                <p class="text-stone-600 leading-relaxed mt-3">
                    Sometimes, there might be an absence of a pickup facility at the provided address code. In such cases, you have to come physically to our office and hand it over to us. No overhead costs regarding travelling, etc., will be borne by us - you must arrange for your own expenses and reach our office at your own responsibility and risk. The order return portal remains open for 7 days from the date of product receipt, and afterwards, the product will not be taken back.
                </p>
                <p class="text-stone-600 leading-relaxed mt-3">
                    Once your product is deemed eligible for return (after receiving the return package, we will inspect the product to determine whether it is free from any structural damage or not, along with the intactness of the tags), we will issue the refund or store credit within 7 days. However, if it is not found appropriate for return, we will send our courier to give the product back to you. In either of the cases, the issue will be dissolved within 7 days of our receiving the return complaint or the query. We are not to be held responsible for any damage that happens during the return shipping, and no return or refund requests will be entertained thereafter (for that particular product).
                </p>
            </div>

            <!-- Frequently Asked Questions (FAQs) -->
            <div class="mb-8">
                <h2 class="text-xl md:text-2xl font-bold text-stone-800 mb-4 pb-2 border-b border-stone-200">
                    Frequently Asked Questions (FAQs)
                </h2>
                
                <!-- Q1 -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-stone-800 mb-2">How long will it take to get the refund?</h3>
                    <p class="text-stone-600 leading-relaxed">
                        Once you have submitted your product complaint (within 7 days), along with the valid reason for doing so, we will analyse it from our end. If the issue ticks all of the criteria for obtaining a refund, we will initiate the repayment process within 48 hours of approval from our respective query handling team. You can receive your refund within three to five working days at the most. A confirmation email or message upon successful payment, along with the updated bank balance details, will be sent to you from us for future reference.
                    </p>
                </div>

                <!-- Q2 -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-stone-800 mb-2">Can I call to raise a product grievance and arrange for a return or cashback?</h3>
                    <p class="text-stone-600 leading-relaxed">
                        Yes, you can dial our customer support number provided on the website and inform them about your product issue. They will guide you further regarding the required steps on how to launch a formal, written complaint on our website portal. Upon receiving your grievance, we will closely look into it and determine whether the product is eligible for a return or a refund.
                    </p>
                </div>

                <!-- Q3 -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-stone-800 mb-2">Are there any other means to report a product issue?</h3>
                    <p class="text-stone-600 leading-relaxed">
                        Absolutely, you have our WhatsApp chat support facility and a dedicated email communication system that remains open 24/7 to receive different types of queries, including return and refund requests.
                    </p>
                </div>

                <!-- Q4 -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-stone-800 mb-2">What are the criteria for product returns?</h3>
                    <p class="text-stone-600 leading-relaxed">
                        A purchased product is deemed returnable only when:
                    </p>
                    <p class="text-stone-600 leading-relaxed mt-2">
                        The price tag and other additional tags, such as the non-removable security tag, are intact and not damaged.
                    </p>
                    <p class="text-stone-600 leading-relaxed mt-1">
                        The item should not be unfolded, worn, washed, or repacked.
                    </p>
                </div>

                <!-- Q5 -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-stone-800 mb-2">What can I expect during a product return pickup?</h3>
                    <p class="text-stone-600 leading-relaxed">
                        If we find your complaint to be valid, we will send our courier executive to pick it up from your doorstep. Worry not - you will receive a confirmation message from our end on the day of pickup, along with other necessary details.
                    </p>
                </div>

                <!-- Q6 -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-stone-800 mb-2">What will happen if the pickup attempt fails?</h3>
                    <p class="text-stone-600 leading-relaxed">
                        Our courier executive will try to facilitate the pickup three consecutive times at the maximum. If the product does not get delivered within that time period, your return request automatically gets dissolved, leading to the cancellation of the pickup.
                    </p>
                </div>

                <!-- Q7 -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-stone-800 mb-2">What should I do if I receive a wrong or missing item?</h3>
                    <p class="text-stone-600 leading-relaxed">
                        If you land up in any of the above situations, you must raise a complaint regarding the same, backed up with a video proof of unboxing the item (not the product packaging). This allows us to verify your concern and arrange for a quick resolution. Remember, refund claims will not be accepted unless video proofs are attached with them.
                    </p>
                </div>

                <!-- Q8 -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-stone-800 mb-2">What must I do if the reverse pickup is not available in my location?</h3>
                    <p class="text-stone-600 leading-relaxed">
                        Such problems hardly arise, as our courier service is spread extensively throughout the country, to every area (major or minor). However, in case you face such a shipping issue, you will need to self-ship the product to us. Courier charges up to ₹1500 will be reimbursed once the product is received and verified.
                    </p>
                </div>
            </div>

            
        </div>
    </div>
</section>
@endsection