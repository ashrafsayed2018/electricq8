<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Index extends Component
{
    public function delete(Service $service): void
    {
        $service->delete();
    }

    public function render()
    {
        return view('livewire.admin.services.index', [
            'services' => Service::orderBy('sort_order')->get(),
        ]);
    }
}
