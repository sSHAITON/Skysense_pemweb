@props(['posts'])

<!-- component -->
<link rel="stylesheet" href="https://cdn.tailgrids.com/tailgrids-fallback.css" />


<!-- ====== Blog Section Start -->
<section class="pt-20 pb-10 lg:pb-20">
    <div class="container">
        <div class="flex flex-wrap justify-center -mx-4">
            <div class="w-full px-4">
                <div class="text-center mx-auto mb-[60px] lg:mb-20 max-w-[510px]">
                    <h2 class="font-bold text-3xl sm:text-4xl md:text-[40px] text-dark mb-4">
                        Our Recent News
                    </h2>
                    <p class="text-base text-body-color">
                        Stay updated with our latest weather insights and tips
                    </p>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap -mx-4">
            @forelse($posts as $post)
                <div class="w-full md:w-1/2 lg:w-1/3 px-4">
                    <div class="max-w-[370px] mx-auto mb-10">
                        <div class="rounded overflow-hidden mb-8 h-[200px]">
                            <img src="{{ asset('storage/' . $post->image_url) }}" alt="{{ $post->title }}"
                                class="w-full h-full object-cover" />
                        </div>
                        <div>
                            <span
                                class="bg-primary rounded inline-block text-center py-1 px-4 text-xs leading-loose font-semibold text-white mb-5">
                                {{ $post->created_at->format('M d, Y') }}
                            </span>
                            <h3>
                                <a href="{{ route('blog.show', $post->slug) }}"
                                    class="font-semibold text-xl sm:text-2xl lg:text-xl xl:text-2xl mb-4 inline-block text-dark hover:text-primary">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-base text-body-color">
                                {!! \Str::limit(strip_tags($post->content), 100) !!}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="w-full px-4">
                    <p class="text-center text-gray-500">No blog posts available yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- ====== Blog Section End -->
