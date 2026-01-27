{{-- @php
    // Initialize variables with default values
    $hasPosts = $latestPosts && (is_array($latestPosts) ? !empty($latestPosts) : $latestPosts->isNotEmpty());
    $featuredPost = $hasPosts ? (is_array($latestPosts) ? $latestPosts[0] : $latestPosts->first()) : null;
@endphp

@if ($hasPosts)
<section class="pt-24 bg-gradient-to-b from-gray-50 to-white">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Search Bar -->
    <form action="{{ route('blog.search') }}" method="get" class="flex justify-center items-center gap-3 mb-12 max-w-3xl mx-auto">
      <input type="text" name="q" value="{{ request('q') }}" 
             placeholder="Search for inspiring stories..." 
             class="w-full py-4 px-6 text-base border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-[#FCAF17] bg-white shadow-md placeholder-gray-400">
      <button type="submit" class="bg-[#FCAF17] text-white p-4 rounded-full hover:bg-[#FDA33B] transition-colors duration-300 shadow-md">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </button>
    </form>

    <!-- Featured Post -->
    <div class="flex flex-col lg:flex-row items-stretch gap-4 lg:gap-2 mb-20 bg-white rounded-xl border border-solid border-[#ece2e2] overflow-hidden">
      <!-- Featured Image -->
      <div class="w-full lg:w-1/2 relative">
        <img loading="lazy" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" 
             src="{{ $featuredPost && $featuredPost->featured_image && file_exists(public_path('storage/' . $featuredPost->featured_image)) 
                 ? asset('storage/' . $featuredPost->featured_image) 
                 : asset('images/main/blog_default.png') }}"
             alt="{{ $featuredPost->title ?? 'Featured post' }}">
        <div class="absolute inset-0 bg-gradient-to-t from-[#1C244B]/30 to-transparent"></div>
      </div>

      <!-- Featured Content -->
      <div class="w-full lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center transAni-fade-in-up">
        <a href="{{ route('blog.category', $featuredPost->categories->isNotEmpty() ? $featuredPost->categories[0]->slug : 'uncategorized') }}">
          <p class="uppercase text-sm tracking-wider font-bold text-[#FCAF17] mb-3 bg-[#FCAF17]/10 px-4 py-1 rounded-full inline-block">
            {{ $featuredPost->categories->isNotEmpty() ? $featuredPost->categories[0]->name : 'Uncategorized' }}
          </p>
        </a>
        <p class="text-base text-gray-500 mb-4 font-medium">
          {{ $featuredPost->published_at ? $featuredPost->published_at->format('F d, Y') : 'No date' }}
        </p>
        <a href="{{ route('blog.single-post', ['slug' => $featuredPost->slug]) }}" class="group">
          <h3 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#1C244B] mb-6 leading-tight group-hover:text-[#FCAF17] transition-colors duration-300">
            {!! $featuredPost->title ?? 'No title available' !!}
          </h3>
        </a>
        <p class="text-gray-600 text-lg leading-relaxed mb-8">
          {!! $featuredPost->excerpt ?? 'No excerpt available' !!}
        </p>
        <a href="{{ route('blog.single-post', ['slug' => $featuredPost->slug]) }}"
           class="inline-flex items-center w-fit gap-2 bg-[#FCAF17] text-white py-2 px-4 rounded-full font-bold lg:text-lg text-sm hover:bg-[#FDA33B] transition-all duration-300 shadow-md hover:shadow-lg">
          Read the Full Story
          <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </a>
      </div>
    </div>
  </div>
</section>
{{--@endforeach--}}
@php
    $gridPosts = $latestPosts->slice(1, 3); // Skip 1, take next 3
@endphp
<section class="py-16 relative">
    <div class="container mx-auto px-4">
        <div class="sm:flex block sm:text-left text-center sm:flex-row flex-col justify-between pb-4">
            <h2 class="text-3xl md:text-4xl font-bold text-secondary pb-5 animate-left-in">Latest Post</h2>
            <a href="{{ route('blog.category', ['slug' => 'latest-post']) }}" class="sm:w-auto inline-flex items-center gap-2 text-black text-base font-semibold hover:text-[#FCAF17] transition group animate-right-in">
                View All
                <svg class="w-4 h-4 text-[#FCAF17] transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 sm:text-left text-center">
            @foreach ($gridPosts as $post)

            <div class="animate-bottom-in">
                <div class="relative group w-full max-w-sm inline-block overflow-hidden xl:h-[240px] smxl:h-[200px] h-auto rounded-md">
                    <img loading="lazy" class="w-full h-auto object-cover transition-opacity duration-500 ease-in-out group-hover:opacity-30" 
                        src="{{ $post->featured_image && file_exists(public_path('storage/' . $post->featured_image)) 
                            ? asset('storage/' . $post->featured_image) 
                            : asset('images/main/blog_default.png') }}" 
                        alt="{{ $post->title }}">
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 ease-in-out">
                        <a href="{{ route('blog.single-post', ['slug' => $post->slug]) }}">
                            <button type="read-more" class="btn-primary">
                                Read More
                            </button>
                        </a>
                    </div>

                </div>
                <div class="mt-4">
                    <p class="text-xs uppercase text-gray-400"><a href="{{ route('blog.category', ['slug' => $post->slug]) }}" class=" font-semibold text-primary">
                            {{ $post->categories[0]->name }} </a><span class="ml-4">{{ date('F d, Y', strtotime($post->published_at)) }}</span>
                    </p>
                    <a href="{{ route('blog.single-post', ['slug' => $post->slug]) }}" class="group">
                        <h3 class="text-lg font-semibold mt-2 text-black group-hover:text-[#FDA33B] transition-colors duration-300 group-hover:underline">
                            {!! $post->title !!}
                        </h3>
                    </a>

                    <!-- <p class="text-gray-400 text-sm mt-2">
                        {!! $post->excerpt !!}
                    </p> -->
                    <!-- <a href="{{ route('blog.single-post', ['slug' => $post['slug']]) }}" class="text-[#FCAF17] font-samibold text-sm mt-3 inline-block hover:underline">
                        Read More...
                    </a> -->
                </div>
            </div>
            @endforeach --}}


            <!-- <div class="animate-bottom-in">
                <div class="relative group w-full max-w-sm inline-block">
                    <img loading="lazy" class="rounded-xl w-full h-auto transition-opacity duration-500 ease-in-out group-hover:opacity-30" src="{{asset('https://placehold.co/300x200')}}" alt="">

                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 ease-in-out">
                        <a href="javascript:void()">
                            <button type="read-more" class="btn-primary">
                                Read More
                            </button>
                        </a>
                    </div>

                </div>
                <div class="mt-4">
                    <p class="text-xs uppercase text-gray-400"><a href="javascript:void()" class=" font-semibold text-primary">
                            Sports </a><span class="ml-4">10 March 2023</span>
                    </p>
                    <a href="#" class="group">
                        <h3 class="text-lg font-semibold mt-2 text-black group-hover:text-[#FDA33B] transition-colors duration-300 group-hover:underline">
                            How to Be a Professional Footballer in 2023
                        </h3>
                    </a>
                    <p class="text-gray-400 text-sm mt-2">
                        Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment, survival strategies to ensure proactive
                    </p>
                    <a href="#" class="text-[#FCAF17] font-samibold text-sm mt-3 inline-block hover:underline">
                        Read More...
                    </a>
                </div>
            </div> -->


            <!-- <div class="animate-bottom-in">
                <div class="relative group w-full max-w-sm inline-block">
                    <img loading="lazy" class="rounded-xl w-full h-auto transition-opacity duration-500 ease-in-out group-hover:opacity-30" src="{{asset('https://placehold.co/300x200')}}" alt="">

                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 ease-in-out">
                        <a href="javascript:void()">
                            <button type="read-more" class="btn-primary">
                                Read More
                            </button>
                        </a>
                    </div>

                </div>
                <div class="mt-4">
                    <p class="text-xs uppercase text-gray-400"><a href="javascript:void()" class=" font-semibold text-primary">
                            Sports </a><span class="ml-4">10 March 2023</span>
                    </p>
                    <a href="#" class="group">
                        <h3 class="text-lg font-semibold mt-2 text-black group-hover:text-[#FDA33B] transition-colors duration-300 group-hover:underline">
                            How to Be a Professional Footballer in 2023
                        </h3>
                    </a>
                    <p class="text-gray-400 text-sm mt-2">
                        Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment, survival strategies to ensure proactive
                    </p>
                    <a href="#" class="text-[#FCAF17] font-samibold text-sm mt-3 inline-block hover:underline">
                        Read More...
                    </a>
                </div>
            </div class="animate-bottom-in"> -->

            {{-- <div class="block md:block lg:hidden">
                <div class="relative group w-full max-w-sm inline-block">
                    <img loading="lazy" class="rounded-xl w-full h-auto transition-opacity duration-500 ease-in-out group-hover:opacity-30" src="{{asset('https://placehold.co/300x200')}}" alt="">

                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 ease-in-out">
                        <a href="javascript:void()">
                            <button type="read-more" class="btn-primary">
                                Read More
                            </button>
                        </a>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-xs uppercase text-gray-400">
                        <a href="javascript:void()" class="font-semibold text-primary">Technology</a>
                        <span class="ml-4">15 July 2025</span>
                    </p>
                    <a href="#" class="group">
                        <h3 class="text-lg font-semibold mt-2 text-black group-hover:text-[#FDA33B] transition-colors duration-300 group-hover:underline">
                            Tablet-Only Post: Tech Trends 2025
                        </h3>
                    </a>
                    <p class="text-gray-400 text-sm mt-2">
                        Explore emerging tech innovations shaping the future. Exclusive insights curated for you.
                    </p>
                    <a href="#" class="text-[#FCAF17] font-samibold text-sm mt-3 inline-block hover:underline">
                        Read More...
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif --}}