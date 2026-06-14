<?php

namespace App\Livewire\Admin\Areas;

use App\Models\Location;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Index extends Component
{
    public function delete(Location $location): void
    {
        $location->delete();
    }

    public function render()
    {
        return view('livewire.admin.areas.index', [
            'locations' => Location::orderBy('sort_order')->get(),
        ]);
    }
}
