<?php

namespace App\Livewire\Admin\Clusters;

use App\Models\Cluster;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Index extends Component
{
    public function delete(Cluster $cluster): void
    {
        $cluster->delete();
    }

    public function render()
    {
        return view('livewire.admin.clusters.index', [
            'clusters' => Cluster::with('pillar')->orderBy('sort_order')->get(),
        ]);
    }
}
