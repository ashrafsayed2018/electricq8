<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServiceLocationPage extends Model
{
    use HasTranslations;

    public array $translatable = [
        'title', 'slug', 'h1',
        'meta_title', 'meta_description', 'canonical_url',
        'intro', 'unique_local_content', 'local_problem', 'local_solution', 'cta_text',
    ];

    protected $fillable = [
        'service_id', 'location_id',
        'title', 'slug', 'h1',
        'meta_title', 'meta_description', 'canonical_url',
        'intro', 'unique_local_content', 'local_problem', 'local_solution', 'cta_text',
        'noindex', 'status',
    ];

    protected function casts(): array
    {
        return ['noindex' => 'boolean'];
    }

    // ── Relationships ──────────────────────────────────────────────────────

    public function service(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // ── Route binding: resolve by service-slug + location-slug pair ───────
    // Used in ServiceLocationController::show() via manual lookup, not implicit binding.

    // ── Auto-generate default content from service + location names ───────

    public static function autoFill(Service $service, Location $location, string $locale): array
    {
        $sName = $service->getTranslation('title', $locale);
        $lName = $location->getTranslation('name', $locale);

        if ($locale === 'ar') {
            return [
                'title'                => "{$sName} في {$lName}",
                'h1'                   => "فني {$sName} في {$lName}",
                'meta_title'           => "{$sName} في {$lName} | إلكتريك كويت",
                'meta_description'     => "خدمة {$sName} في {$lName} — فنيون معتمدون، استجابة خلال ساعة، ضمان 3 أشهر. اتصل الآن.",
                'intro'                => "تقدم إلكتريك كويت خدمة {$sName} في منطقة {$lName} بأعلى معايير الجودة. فنيونا المعتمدون يصلونك خلال ساعة واحدة من استلام طلبك.",
                'local_problem'        => "تعاني {$lName} من ارتفاع درجات الحرارة والرطوبة مما يزيد الحمل على أجهزة الكهرباء ويسرّع تعطّلها.",
                'local_solution'       => "فريق إلكتريك كويت في {$lName} يشخّص المشكلة ويقدم حلاً شاملاً بسعر واضح ومضمون.",
                'cta_text'             => "احجز فنيًا في {$lName} الآن",
            ];
        }

        return [
            'title'                => "{$sName} in {$lName}",
            'h1'                   => "{$sName} Technician in {$lName}",
            'meta_title'           => "{$sName} in {$lName} | ElectricQ8",
            'meta_description'     => "Professional {$sName} in {$lName} — certified technicians, 1-hour response, 3-month warranty. Call now.",
            'intro'                => "ElectricQ8 provides {$sName} in {$lName} to the highest quality standards. Our certified technicians reach you within one hour.",
            'local_problem'        => "{$lName} experiences extreme heat and humidity that accelerates AC wear and breakdowns.",
            'local_solution'       => "Our ElectricQ8 team in {$lName} diagnoses the problem and delivers a complete solution at a clear, guaranteed price.",
            'cta_text'             => "Book a Technician in {$lName} Now",
        ];
    }
}
