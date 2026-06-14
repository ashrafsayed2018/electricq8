<?php

namespace App\Livewire\Admin\ServiceLocations;

use App\Models\Location;
use App\Models\Service;
use App\Models\ServiceLocationPage;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Index extends Component
{
    public function generateAll(): void
    {
        $services  = Service::active()->get();
        $locations = Location::where('is_active', true)->get();
        $created   = 0;

        foreach ($services as $service) {
            foreach ($locations as $location) {
                $exists = ServiceLocationPage::where('service_id', $service->id)
                    ->where('location_id', $location->id)
                    ->exists();

                if (! $exists) {
                    $data = ['service_id' => $service->id, 'location_id' => $location->id, 'status' => 'active', 'noindex' => true];

                    foreach (['ar', 'en'] as $locale) {
                        foreach (ServiceLocationPage::autoFill($service, $location, $locale) as $field => $value) {
                            $data[$field][$locale] = $value;
                        }
                        $data['slug'][$locale] = $service->getTranslation('slug', $locale)
                            . ($locale === 'ar' ? '-في-' : '-in-')
                            . $location->getTranslation('slug', $locale);
                    }

                    ServiceLocationPage::create($data);
                    $created++;
                }
            }
        }

        session()->flash('success', "تم إنشاء {$created} صفحة جديدة بنجاح.");
    }

    public function toggleStatus(int $id): void
    {
        $page = ServiceLocationPage::findOrFail($id);
        $page->status = $page->status === 'active' ? 'inactive' : 'active';
        $page->save();
    }

    public function delete(int $id): void
    {
        ServiceLocationPage::findOrFail($id)->delete();
    }

    public function render()
    {
        $services  = Service::active()->with('serviceLocationPages')->get();
        $locations = Location::where('is_active', true)->orderBy('sort_order')->get();

        // Build lookup: [service_id][location_id] => page
        $pages = ServiceLocationPage::all()->keyBy(fn ($p) => $p->service_id . '_' . $p->location_id);

        $total    = $services->count() * $locations->count();
        $existing = ServiceLocationPage::count();
        $active   = ServiceLocationPage::where('status', 'active')->count();

        return view('livewire.admin.service-locations.index', compact(
            'services', 'locations', 'pages', 'total', 'existing', 'active'
        ));
    }
}
