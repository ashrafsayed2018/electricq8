<?php

namespace App\Livewire;

use App\Models\Location;
use Livewire\Component;

class AreaSearch extends Component
{
    public string $search = '';

    protected array $govOrder = ['capital', 'hawalli', 'farwaniya', 'jahra', 'mubarak_al_kabeer', 'ahmadi'];

    protected array $govMeta = [
        'capital'           => ['ar' => 'محافظة العاصمة',        'en' => 'Capital Governorate'],
        'hawalli'           => ['ar' => 'محافظة حولي',            'en' => 'Hawalli Governorate'],
        'farwaniya'         => ['ar' => 'محافظة الفروانية',       'en' => 'Farwaniya Governorate'],
        'jahra'             => ['ar' => 'محافظة الجهراء',         'en' => 'Jahra Governorate'],
        'mubarak_al_kabeer' => ['ar' => 'محافظة مبارك الكبير',   'en' => 'Mubarak Al-Kabeer Governorate'],
        'ahmadi'            => ['ar' => 'محافظة الأحمدي',        'en' => 'Ahmadi Governorate'],
    ];

    public function render()
    {
        $isAr = app()->getLocale() === 'ar';
        $lang = $isAr ? 'ar' : 'en';

        $locations = Location::where('is_active', true)
            ->when($this->search !== '', function ($q) use ($lang) {
                $q->where(function ($q) use ($lang) {
                    $q->where("name->{$lang}", 'like', "%{$this->search}%")
                      ->orWhere('name->ar', 'like', "%{$this->search}%")
                      ->orWhere('name->en', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('sort_order')
            ->get();

        $byGov = $locations->groupBy('governorate');

        return view('livewire.area-search', [
            'byGov'    => $byGov,
            'govOrder' => $this->govOrder,
            'govMeta'  => $this->govMeta,
            'isAr'     => $isAr,
            'lang'     => $lang,
            'total'    => $locations->count(),
        ]);
    }
}
