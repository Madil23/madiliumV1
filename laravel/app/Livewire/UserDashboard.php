<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Page;
use App\Models\Block;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class UserDashboard extends Component
{
    public $page;
    public $blocks;
    public $products;
    
    // Pour l'ajout de lien
    public $newLinkTitle = '';
    public $newLinkUrl = '';

    public function mount()
    {
        // Récupérer ou créer la page par défaut
        $this->page = Page::firstOrCreate(
            ['user_id' => Auth::id()],
            ['title' => 'Ma Super Page', 'description' => 'Bienvenue !', 'username' => Auth::user()->username]
        );
        $this->loadData();
    }

    public function loadData()
    {
        $this->blocks = $this->page->blocks()->orderBy('order')->get();
        $this->products = $this->page->products()->get();
    }

    public function addLink()
    {
        $this->validate([
            'newLinkTitle' => 'required',
            'newLinkUrl' => 'required|url',
        ]);

        $this->page->blocks()->create([
            'type' => 'link',
            'content' => json_encode(['title' => $this->newLinkTitle, 'url' => $this->newLinkUrl]),
            'order' => $this->blocks->count() + 1
        ]);

        $this->newLinkTitle = '';
        $this->newLinkUrl = '';
        $this->loadData();
        
        session()->flash('success', 'Lien ajouté avec succès !');
    }

    public function render()
    {
        return view('livewire.user-dashboard')->layout('layouts.app');
    }
}
