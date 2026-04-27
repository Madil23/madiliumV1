<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboard extends Component
{
    public $totalUsers;
    public $activeShops;
    public $pendingSubscriptionsCount;
    public $chartLabels = [];
    public $usersChartData = [];
    public $shopsChartData = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadChartData();
    }

    public function loadStats()
    {
        $this->totalUsers = User::count();
        $this->activeShops = Page::where('is_ecommerce_active', true)->count();
        
        try {
            $this->pendingSubscriptionsCount = DB::table('subscriptions')->where('status', 'pending')->count();
        } catch (\Exception $e) {
            $this->pendingSubscriptionsCount = 0;
        }
    }

    public function approveSubscription($id)
    {
        try {
            DB::table('subscriptions')->where('id', $id)->update(['status' => 'active', 'updated_at' => now()]);
            $this->loadStats();
            session()->flash('success', 'Abonnement validé avec succès.');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la validation.');
        }
    }

    public function loadChartData()
    {
        // Génération des statistiques sur les 6 derniers mois
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $this->chartLabels[] = $month->translatedFormat('M Y');
            
            $this->usersChartData[] = User::whereMonth('created_at', $month->month)
                                          ->whereYear('created_at', $month->year)
                                          ->count();
                                          
            $this->shopsChartData[] = Page::where('is_ecommerce_active', true)
                                          ->whereMonth('created_at', $month->month)
                                          ->whereYear('created_at', $month->year)
                                          ->count();
        }
    }

    public function render()
    {
        $topShops = Page::with('user')
            ->where('is_ecommerce_active', true)
            ->withCount('orders')
            ->orderByDesc('orders_count')
            ->take(10)
            ->get();

        try {
            $pendingSubscriptionsList = DB::table('subscriptions')
                ->join('users', 'subscriptions.user_id', '=', 'users.id')
                ->select('subscriptions.*', 'users.name as user_name', 'users.email as user_email')
                ->where('subscriptions.status', 'pending')
                ->get();
        } catch (\Exception $e) {
            $pendingSubscriptionsList = collect();
        }

        return view('livewire.admin-dashboard', [
            'topShops' => $topShops,
            'pendingSubscriptionsList' => $pendingSubscriptionsList
        ])->layout('layouts.app');
    }
}
