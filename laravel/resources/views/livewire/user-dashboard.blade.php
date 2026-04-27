<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="flex gap-8">
        
        <!-- Éditeur (Gauche) -->
        <div class="w-2/3">
            <h2 class="text-2xl font-bold mb-6">Gérer ma Page (Link-in-Bio)</h2>
            
            @if(session()->has('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>
            @endif

            <!-- Formulaire Ajouter un Lien -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-lg font-bold mb-4">Ajouter un nouveau lien</h3>
                <form wire:submit.prevent="addLink" class="space-y-4">
                    <div>
                        <input type="text" wire:model="newLinkTitle" placeholder="Titre du lien" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                    </div>
                    <div>
                        <input type="url" wire:model="newLinkUrl" placeholder="https://..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Ajouter</button>
                </form>
            </div>

            <!-- Liste des Liens Existants -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4">Mes Liens</h3>
                <div class="space-y-3">
                    @forelse($blocks as $block)
                        @php $content = json_decode($block->content, true); @endphp
                        <div class="flex items-center justify-between p-4 border rounded-md bg-gray-50">
                            <div>
                                <p class="font-bold">{{ $content['title'] ?? 'Lien' }}</p>
                                <a href="{{ $content['url'] ?? '#' }}" class="text-sm text-blue-500" target="_blank">{{ $content['url'] ?? '' }}</a>
                            </div>
                            <button class="text-red-500 hover:text-red-700">Supprimer</button>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Aucun lien pour le moment.</p>
                    @endforelse
                </div>
            </div>
            
            <!-- (Placeholder) Gestion E-commerce WaaS -->
            <div class="bg-white p-6 rounded-lg shadow mt-6 opacity-75">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    🛍️ Module E-commerce WaaS
                </h3>
                <p class="text-sm text-gray-600 mb-4">Activez le mode boutique pour ajouter des produits et recevoir des commandes en Cash on Delivery.</p>
                <div class="flex items-center">
                    <input type="checkbox" disabled class="mr-2 rounded"> <span class="text-gray-500">Activer le E-commerce (à venir)</span>
                </div>
            </div>
        </div>

        <!-- Preview (Droite) -->
        <div class="w-1/3">
            <div class="sticky top-6 border-8 border-gray-900 rounded-[3rem] h-[700px] overflow-hidden bg-gray-50 shadow-2xl relative">
                <div class="absolute top-0 inset-x-0 h-6 bg-gray-900 rounded-b-xl w-32 mx-auto"></div>
                <!-- Miniatura de la page publique -->
                <div class="p-6 text-center mt-10">
                    <div class="w-24 h-24 bg-indigo-200 rounded-full mx-auto mb-4"></div>
                    <h2 class="text-xl font-bold">{{ $page->title }}</h2>
                    <p class="text-gray-500 mb-6">{{ $page->description }}</p>
                    
                    <div class="space-y-4">
                        @foreach($blocks as $block)
                            @php $content = json_decode($block->content, true); @endphp
                            <a href="#" class="block w-full py-3 px-4 bg-white border border-gray-200 rounded-[2rem] shadow-sm font-medium hover:bg-gray-50 transition">
                                {{ $content['title'] ?? 'Lien' }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
