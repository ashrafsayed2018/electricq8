<?php

namespace App\Http\Controllers;

use App\Models\Cluster;

class ClusterController extends Controller
{
    public function show(Cluster $cluster)
    {
        $locale      = app()->getLocale();
        $correctSlug = $cluster->getTranslation('slug', $locale);
        $requested   = last(request()->segments());

        if ($requested !== $correctSlug) {
            $route = $locale === 'ar' ? 'clusters.show' : 'en.clusters.show';
            return redirect()->route($route, $correctSlug, 302);
        }

        return view('clusters.show', [
            'cluster'  => $cluster->load('pillar', 'services'),
        ]);
    }
}
