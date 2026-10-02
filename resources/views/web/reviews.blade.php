@extends('layout.web.main-layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('web/css/reviews.css') }}">
@endsection

@section('content')
<style>
    .fashion-gradient {
        background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
    }

    .sidebar-item.active {
        background: linear-gradient(135deg, #fdf2f8 0%, #faf5ff 100%);
        border-right: 3px solid #a855f7;
        color: #7c3aed;
    }

    .sidebar-item:hover:not(.active) {
        background-color: #f8fafc;
    }
</style>

<section class="reviews-page w-full px-4 lg:py-12 py-6">
    <div class="reviews-back-bar">
        <a href="{{ url()->previous(route('web.profile')) }}"
           class="reviews-back-btn"
           aria-label="Go back"
           onclick="if (document.referrer) { event.preventDefault(); history.back(); }">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </a>
        <span class="reviews-back-title">My Reviews</span>
    </div>
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="reviews-sidebar lg:w-1/4">
                @include('components.web.profile-sidebar', ['user' => auth()->user()])
            </div>

            <div class="reviews-main lg:w-3/4">
                <div class="reviews-header bg-white rounded-2xl shadow-sm p-6 mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">My Reviews</h1>
                    <p class="text-gray-600 mt-1">Reviews you have submitted for products you purchased</p>
                </div>

                @if($reviews->count() > 0)
                    <div class="reviews-list space-y-4">
                        @foreach($reviews as $review)
                            @php
                                $product = $review->product;
                            @endphp
                            <div class="review-card bg-white rounded-2xl shadow-sm p-6">
                                <div class="flex gap-4">
                                    <div class="review-card-image">
                                        @if($product && $product->featured_image)
                                            @if(str_starts_with($product->featured_image, 'http'))
                                                <img src="{{ $product->featured_image }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ url('/img/' . $product->featured_image) }}" alt="{{ $product->name }}">
                                            @endif
                                        @else
                                            <div class="review-card-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="review-card-body">
                                        @if($product)
                                            <a href="{{ route('page.single-product', $product->slug) }}" class="review-card-title">
                                                {{ $product->name }}
                                            </a>
                                        @else
                                            <p class="review-card-title">Product unavailable</p>
                                        @endif
                                        <div class="review-card-stars" aria-label="{{ $review->rating }} out of 5 stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= (int) $review->rating ? 'is-on' : '' }}"></i>
                                            @endfor
                                        </div>
                                        @if($review->review_text)
                                            <p class="review-card-text">{{ $review->review_text }}</p>
                                        @endif
                                        <p class="review-card-date">
                                            {{ optional($review->review_date ?? $review->created_at)->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($reviews->hasPages())
                        <div class="reviews-pagination mt-8">
                            {{ $reviews->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                @else
                    <div class="reviews-empty bg-white rounded-2xl shadow-sm p-12 text-center">
                        <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-star text-purple-600 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No reviews yet</h3>
                        <p class="text-gray-600 mb-6">When you review a delivered product, it will show up here.</p>
                        <a href="{{ route('user.order-history', base64_encode(auth()->id())) }}" class="inline-flex items-center px-6 py-3 fashion-gradient text-white rounded-xl hover:shadow-lg transition font-medium">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            View Order History
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
