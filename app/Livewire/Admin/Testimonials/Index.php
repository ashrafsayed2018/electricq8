<?php

namespace App\Livewire\Admin\Testimonials;

use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Index extends Component
{
    public function toggle(Testimonial $testimonial): void
    {
        $testimonial->update(['is_active' => !$testimonial->is_active]);
    }

    public function delete(Testimonial $testimonial): void
    {
        $testimonial->delete();
    }

    public function render()
    {
        return view('livewire.admin.testimonials.index', [
            'testimonials' => Testimonial::with('location')->latest()->get(),
        ]);
    }
}
