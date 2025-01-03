@props(['post'])

<div class="max-w-4xl mx-auto px-4 py-8">
    <article class="bg-white shadow-lg rounded-lg overflow-hidden">
        @if ($post->image_url)
            <div class="w-full h-96 relative">
                <img src="{{ asset('storage/' . $post->image_url) }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover">
            </div>
        @endif

        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                {{ $post->title }}
            </h1>

            <div class="flex items-center text-gray-500 text-sm mb-6">
                <span class="mr-4">
                    <i class="far fa-user mr-2"></i>
                    {{ $post->user->name }}
                </span>
                <span>
                    <i class="far fa-calendar mr-2"></i>
                    {{ $post->created_at->format('M d, Y') }}
                </span>
            </div>

            <div class="prose max-w-none">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>
    </article>
</div>
