<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Page;

class PublicWrapper extends Component
{
    public $username;
    public $page;
    public $blocks;
    public $products;

    public function mount($username)
    {
        $this->username = $username;
        // On cherche la page par le username
        $this->page = Page::where('username', $username)->firstOrFail();
        $this->blocks = $this->page->blocks()->orderBy('order')->get();
        $this->products = $this->page->products()->get();
        
        // Tracking basique des vues (incrémentation fictive pour l'exemple)
        $this->page->increment('views');
    }

    public function trackClick($blockId)
    {
        // Placeholder pour le tracking des clics
        $block = $this->blocks->where('id', $blockId)->first();
        if ($block) {
            $block->increment('clicks');
        }
    }

    public function render()
    {
        return view('livewire.public-wrapper')->layout('layouts.public');
    }
}
