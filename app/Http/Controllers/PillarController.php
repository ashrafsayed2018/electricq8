<?php

namespace App\Http\Controllers;

use App\Models\Pillar;

class PillarController extends Controller
{
    public function show(Pillar $pillar)
    {
        $locale      = app()->getLocale();
        $correctSlug = $pillar->getTranslation('slug', $locale);
        $requested   = last(request()->segments());

        if ($requested !== $correctSlug) {
            $route = $locale === 'ar' ? 'pillars.show' : 'en.pillars.show';
            return redirect()->route($route, $correctSlug, 302);
        }

        return view('pillars.show', [
            'pillar' => $pillar->load(['clusters.services']),
        ]);
    }
}
