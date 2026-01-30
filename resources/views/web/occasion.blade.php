@extends('layout.web.main-layout')

@section('content')
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4 bg-gray-50">
    <div class="container mx-auto">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6">
            <a href="{{ route('page.index') }}" class="hover:text-black">Home</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700">{{ $occasion->name }}</span>
        </nav>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $occasion->name }}</h1>
            @if($occasion->description)
                <p class="text-gray-600 max-w-2xl mx-auto">{{ $occasion->description }}</p>
            @endif
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                        <div class="aspect-square bg-gray-200 relative overflow-hidden">
                            @if($product->images->first())
                                <img src="{{ asset('uploads/products/' . $product->images->first()->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                            <div class="flex items-center justify-between">
                                <div>
                                    @if($product->discount_price && $product->discount_price < $product->price)
                                        <span class="text-lg font-bold text-gray-900">${{ number_format($product->discount_price, 2) }}</span>
                                        <span class="text-sm text-gray-500 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                                @if($product->stock > 0)
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">In Stock</span>
                                @else
                                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Out of Stock</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-500 mb-4">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                <p class="text-gray-500">There are no products available for this occasion at the moment.</p>
            </div>
        @endif
    </div>
</section>
@endsection
