<?php

namespace App\Livewire\Admin\Contacts;

use App\Enums\ContactStatus;
use App\Models\Contact;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    #[Url] public string $status = '';
    public string $locale = '';

    public function mount(string $locale = ''): void
    {
        $this->locale = $locale;
    }

    #[Computed]
    public function contacts()
    {
        return Contact::with(['service', 'location'])
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->locale, fn ($q) => $q->where('locale', $this->locale))
            ->latest()
            ->paginate(20);
    }

    public function markRead(Contact $contact): void
    {
        $contact->update(['status' => ContactStatus::Read]);
    }

    public function render()
    {
        return view('livewire.admin.contacts.index');
    }
}
