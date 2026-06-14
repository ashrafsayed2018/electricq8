<?php

namespace App\Livewire\Admin\Analytics;

use Ashraf\Analytics\Support\AdminAnalyticsReport;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.admin')]
class Index extends Component
{
    #[Url]
    public string $range = 'last_30_days';

    public string $dateFrom = '';
    public string $dateTo   = '';

    #[Computed]
    public function report(): AdminAnalyticsReport
    {
        $report = new AdminAnalyticsReport();

        if ($this->range === 'custom' && $this->dateFrom && $this->dateTo) {
            $report->withCustomDateRange($this->dateFrom, $this->dateTo);
        }

        return $report;
    }

    #[Computed]
    public function overview(): array
    {
        return $this->report()->overview($this->range);
    }

    #[Computed]
    public function ranges(): array
    {
        return $this->report()->availableRanges();
    }

    public function render()
    {
        return view('livewire.admin.analytics.index');
    }
}
