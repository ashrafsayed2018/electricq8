<?php

namespace App\Livewire\Admin\ServiceLocations;

use App\Models\Location;
use App\Models\Service;
use App\Models\ServiceLocationPage;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Form extends Component
{
    public ?ServiceLocationPage $serviceLocationPage = null;

    public int    $service_id  = 0;
    public int    $location_id = 0;
    public string $status      = 'active';
    public bool   $noindex     = false;

    // Translatable fields
    public string $title_ar                = '';
    public string $title_en                = '';
    public string $h1_ar                   = '';
    public string $h1_en                   = '';
    public string $meta_title_ar           = '';
    public string $meta_title_en           = '';
    public string $meta_description_ar     = '';
    public string $meta_description_en     = '';
    public string $intro_ar                = '';
    public string $intro_en                = '';
    public string $local_problem_ar        = '';
    public string $local_problem_en        = '';
    public string $local_solution_ar       = '';
    public string $local_solution_en       = '';
    public string $unique_local_content_ar = '';
    public string $unique_local_content_en = '';
    public string $cta_text_ar             = '';
    public string $cta_text_en             = '';

    public function mount(?ServiceLocationPage $serviceLocationPage = null): void
    {
        if ($serviceLocationPage && $serviceLocationPage->exists) {
            $this->serviceLocationPage       = $serviceLocationPage;
            $p                               = $serviceLocationPage;
            $this->service_id                = $p->service_id;
            $this->location_id               = $p->location_id;
            $this->status                    = $p->status;
            $this->noindex                   = (bool) $p->noindex;
            $this->title_ar                  = $p->getTranslation('title', 'ar');
            $this->title_en                  = $p->getTranslation('title', 'en');
            $this->h1_ar                     = $p->getTranslation('h1', 'ar');
            $this->h1_en                     = $p->getTranslation('h1', 'en');
            $this->meta_title_ar             = $p->getTranslation('meta_title', 'ar') ?? '';
            $this->meta_title_en             = $p->getTranslation('meta_title', 'en') ?? '';
            $this->meta_description_ar       = $p->getTranslation('meta_description', 'ar') ?? '';
            $this->meta_description_en       = $p->getTranslation('meta_description', 'en') ?? '';
            $this->intro_ar                  = $p->getTranslation('intro', 'ar') ?? '';
            $this->intro_en                  = $p->getTranslation('intro', 'en') ?? '';
            $this->local_problem_ar          = $p->getTranslation('local_problem', 'ar') ?? '';
            $this->local_problem_en          = $p->getTranslation('local_problem', 'en') ?? '';
            $this->local_solution_ar         = $p->getTranslation('local_solution', 'ar') ?? '';
            $this->local_solution_en         = $p->getTranslation('local_solution', 'en') ?? '';
            $this->unique_local_content_ar   = $p->getTranslation('unique_local_content', 'ar') ?? '';
            $this->unique_local_content_en   = $p->getTranslation('unique_local_content', 'en') ?? '';
            $this->cta_text_ar               = $p->getTranslation('cta_text', 'ar') ?? '';
            $this->cta_text_en               = $p->getTranslation('cta_text', 'en') ?? '';
        }
    }

    public function autoFill(): void
    {
        if (! $this->service_id || ! $this->location_id) return;

        $service  = Service::findOrFail($this->service_id);
        $location = Location::findOrFail($this->location_id);

        foreach (['ar', 'en'] as $locale) {
            $auto = ServiceLocationPage::autoFill($service, $location, $locale);
            foreach ($auto as $field => $value) {
                $prop = $field . '_' . $locale;
                if (property_exists($this, $prop) && empty($this->$prop)) {
                    $this->$prop = $value;
                }
            }
        }
    }

    public function save(): void
    {
        $this->validate([
            'service_id'  => 'required|integer|exists:services,id',
            'location_id' => 'required|integer|exists:locations,id',
            'title_ar'    => 'required|string|max:255',
            'title_en'    => 'required|string|max:255',
        ]);

        $data = [
            'service_id'            => $this->service_id,
            'location_id'           => $this->location_id,
            'status'                => $this->status,
            'noindex'               => $this->noindex,
            'title'                 => ['ar' => $this->title_ar,                'en' => $this->title_en],
            'h1'                    => ['ar' => $this->h1_ar,                   'en' => $this->h1_en],
            'meta_title'            => ['ar' => $this->meta_title_ar,           'en' => $this->meta_title_en],
            'meta_description'      => ['ar' => $this->meta_description_ar,     'en' => $this->meta_description_en],
            'intro'                 => ['ar' => $this->intro_ar,                'en' => $this->intro_en],
            'local_problem'         => ['ar' => $this->local_problem_ar,        'en' => $this->local_problem_en],
            'local_solution'        => ['ar' => $this->local_solution_ar,       'en' => $this->local_solution_en],
            'unique_local_content'  => ['ar' => $this->unique_local_content_ar, 'en' => $this->unique_local_content_en],
            'cta_text'              => ['ar' => $this->cta_text_ar,             'en' => $this->cta_text_en],
        ];

        if ($this->serviceLocationPage) {
            $this->serviceLocationPage->update($data);
        } else {
            ServiceLocationPage::create($data);
        }

        $this->redirect(route('admin.service-locations.index'));
    }

    public function render()
    {
        return view('livewire.admin.service-locations.form', [
            'services'  => Service::active()->get(),
            'locations' => Location::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
