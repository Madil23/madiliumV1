<div class="max-w-md mx-auto py-12 px-4 sm:px-6">
    <div class="text-center mb-10">
        <!-- Avatar Placeholder -->
        <div class="w-24 h-24 bg-indigo-500 text-white rounded-full mx-auto mb-4 flex items-center justify-center text-3xl font-bold uppercase shadow-lg">
            {{ substr($page->title ?? 'U', 0, 1) }}
        </div>
        <h1 class="text-2xl font-extrabold text-gray-900">{{ $page->title }}</h1>
        <p class="text-lg text-gray-600 mt-2">{{ $page->description }}</p>
    </div>

    <!-- Liens (Link-in-bio) -->
    <div class="space-y-4 mb-10">
        @forelse($blocks as $block)
            @php $content = json_decode($block->content, true); @endphp
            <a href="{{ $content['url'] ?? '#' }}" 
               wire:click="trackClick({{ $block->id }})"
               target="_blank" 
               class="block w-full py-4 px-6 bg-white border border-gray-200 rounded-[2rem] shadow hover:shadow-md hover:scale-[1.02] transform transition duration-200 text-center text-lg font-medium text-gray-800">
                {{ $content['title'] ?? 'Lien' }}
            </a>
        @empty
            <p class="text-center text-gray-500">Aucun lien disponible.</p>
        @endforelse
    </div>

    <!-- WaaS E-commerce (Si actif) -->
    @if($page->is_ecommerce_active)
        <div class="border-t border-gray-300 pt-8 mt-8">
            <h2 class="text-xl font-bold text-gray-900 text-center mb-6">Boutique 🛍️</h2>
            <div class="grid grid-cols-2 gap-4">
                @forelse($products as $product)
                    <div class="bg-white rounded-xl shadow overflow-hidden flex flex-col">
                        <div class="h-32 bg-gray-200 flex items-center justify-center">
                            @if($product->image_path)
                                <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="object-cover h-full w-full">
                            @else
                                <span class="text-gray-400 text-sm">Image</span>
                            @endif
                        </div>
                        <div class="p-3 flex-1 flex flex-col">
                            <h3 class="font-bold text-gray-800 text-sm mb-1 leading-tight">{{ $product->name }}</h3>
                            <p class="text-indigo-600 font-extrabold mb-3">{{ number_format($product->price, 2, ',', ' ') }} DA</p>
                            <button class="mt-auto w-full bg-black text-white text-sm py-2 rounded-lg font-medium hover:bg-gray-800 transition">
                                Commander
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="col-span-2 text-center text-gray-500 text-sm">Aucun produit dans la boutique.</p>
                @endforelse
            </div>
        </div>
    @endif

    <div class="mt-12 text-center">
        <a href="#" class="text-sm font-medium text-gray-400 hover:text-gray-600">Propulsé par Madilium</a>
    </div>
</div>
