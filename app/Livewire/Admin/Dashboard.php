<?php

namespace App\Livewire\Admin;

use App\Models\Cluster;
use App\Models\Contact;
use App\Models\Location;
use App\Models\Post;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalContacts'    => Contact::count(),
            'newContacts'      => Contact::where('status', 'new')->count(),
            'totalServices'    => Service::count(),
            'totalLocations'   => Location::count(),
            'totalPosts'       => Post::count(),
            'publishedPosts'   => Post::where('status', 'published')->count(),
            'totalClusters'    => Cluster::count(),
            'totalTestimonials'=> Testimonial::count(),
            'totalUsers'       => User::count(),
        ]);
    }
}
