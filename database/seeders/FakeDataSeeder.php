<?php

namespace Database\Seeders;

use App\Models\Cluster;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Keyword;
use App\Models\Location;
use App\Models\Pillar;
use App\Models\Post;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class FakeDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pillars (top-level content pillars)
        $pillars = Pillar::factory(3)->create();

        // 2. Clusters – 2-3 per pillar
        $pillars->each(function ($pillar) {
            Cluster::factory(3)->create(['pillar_id' => $pillar->id]);
        });

        // 3. Services – seeded by ServicesSeeder, skip fake generation

        // 4. Locations (real Kuwait neighbourhoods)
        Location::factory(20)->create();

        // 5. Testimonials – spread across locations
        Testimonial::factory(40)->create();

        // 6. Contacts – inbound enquiries
        Contact::factory(60)->create();

        // 7. Blog posts
        Post::factory(8)->create();

        // 8. FAQs
        Faq::factory(12)->create();

        // 9. Keywords
        Keyword::factory(16)->create();
    }
}
