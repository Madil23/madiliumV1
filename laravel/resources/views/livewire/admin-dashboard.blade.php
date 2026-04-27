<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Administrateur</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stat: Utilisateurs -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500 flex items-center">
            <div class="p-3 bg-blue-100 rounded-full text-blue-500 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Total Utilisateurs</h3>
                <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
            </div>
        </div>

        <!-- Stat: Boutiques -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500 flex items-center">
            <div class="p-3 bg-green-100 rounded-full text-green-500 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Boutiques Actives</h3>
                <p class="text-2xl font-bold text-gray-800">{{ $activeShops }}</p>
            </div>
        </div>

        <!-- Stat: Abonnements -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500 flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full text-yellow-500 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Abonnements en Attente</h3>
                <p class="text-2xl font-bold text-gray-800">{{ $pendingSubscriptionsCount }}</p>
            </div>
        </div>
    </div>

    <!-- Section Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        <!-- Modèle Utilisateurs (Bar Chart) -->
        <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
            <h3 class="text-gray-700 font-bold mb-4">Inscriptions Utilisateurs (6 derniers mois)</h3>
            <div class="relative h-64 w-full">
                <canvas id="usersChart"></canvas>
            </div>
        </div>

        <!-- Modèle Boutiques (Line Chart) -->
        <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
            <h3 class="text-gray-700 font-bold mb-4">Création de Boutiques WaaS</h3>
            <div class="relative h-64 w-full">
                <canvas id="shopsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Section Performances des Boutiques -->
    <div class="mt-8 bg-white rounded-lg shadow border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-gray-800 font-bold">Performances des Boutiques (Top 10)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white text-gray-500 text-sm border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">Boutique</th>
                        <th class="px-6 py-3 font-medium">Propriétaire</th>
                        <th class="px-6 py-3 text-center font-medium">Vues</th>
                        <th class="px-6 py-3 text-center font-medium">Clics (Liens)</th>
                        <th class="px-6 py-3 text-center font-medium">Commandes</th>
                        <th class="px-6 py-3 text-right font-medium">Statut</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($topShops as $shop)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-blue-600">
                                {{ $shop->title ?: 'Boutique #' . $shop->id }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $shop->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600">
                                {{ $shop->views ?? 0 }}
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600">
                                {{ $shop->clicks ?? 0 }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold {{ $shop->orders_count > 0 ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $shop->orders_count }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Actif</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Aucune boutique E-commerce n'est actuellement active.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section Abonnements en Attente -->
    <div class="mt-8 bg-white rounded-lg shadow border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-gray-800 font-bold">Abonnements en Attente de Validation</h3>
        </div>
        
        @if(session()->has('success'))
            <div class="px-6 py-3 bg-green-50 text-green-700 text-sm font-medium border-b border-green-100">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session()->has('error'))
            <div class="px-6 py-3 bg-red-50 text-red-700 text-sm font-medium border-b border-red-100">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white text-gray-500 text-sm border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">Utilisateur</th>
                        <th class="px-6 py-3 font-medium">Email</th>
                        <th class="px-6 py-3 text-center font-medium">Date de Demande</th>
                        <th class="px-6 py-3 text-right font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($pendingSubscriptionsList as $subscription)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $subscription->user_name }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $subscription->user_email }}
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500">
                                {{ \Carbon\Carbon::parse($subscription->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="approveSubscription({{ $subscription->id }})" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-medium text-xs">
                                    Valider
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Aucun abonnement en attente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Initialisation Chart.js v3+ via CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        const labels = @json($chartLabels);
        
        // Graphique Utilisateurs (Barres)
        new Chart(document.getElementById('usersChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nouveaux Utilisateurs',
                    data: @json($usersChartData),
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // Graphique Boutiques (Lignes)
        new Chart(document.getElementById('shopsChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nouvelles Boutiques',
                    data: @json($shopsChartData),
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderColor: 'rgb(16, 185, 129)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    });
</script>
