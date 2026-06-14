<?php

namespace App\Livewire\Admin\Pillars;

use App\Models\Pillar;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Index extends Component
{
    public function delete(Pillar $pillar): void
    {
        $pillar->delete();
    }

    public function render()
    {
        return view('livewire.admin.pillars.index', [
            'pillars' => Pillar::withCount('clusters')->orderBy('sort_order')->get(),
        ]);
    }
}
