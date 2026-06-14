<?php

namespace App\Livewire;

use App\Enums\ContactStatus;
use App\Models\Contact;
use App\Models\Location;
use App\Models\Service;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate('required|string|min:2|max:100')]
    public string $name = '';

    #[Validate('required|regex:/^[0-9+\s]{8,15}$/')]
    public string $phone = '';

    #[Validate('nullable|email')]
    public string $email = '';

    #[Validate('nullable|exists:services,id')]
    public string $service_id = '';

    #[Validate('nullable|exists:locations,id')]
    public string $location_id = '';

    #[Validate('nullable|string|max:500')]
    public string $message = '';

    public bool $submitted = false;

    public function send(): void
    {
        $this->validate();

        Contact::create([
            'name'        => $this->name,
            'phone'       => $this->phone,
            'email'       => $this->email ?: null,
            'service_id'  => $this->service_id ?: null,
            'location_id' => $this->location_id ?: null,
            'message'     => $this->message ?: null,
            'locale'      => app()->getLocale(),
            'ip_address'  => request()->ip(),
            'status'      => ContactStatus::New,
        ]);

        $this->submitted = true;
        $this->reset(['name', 'phone', 'email', 'service_id', 'location_id', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-form', [
            'services'  => Service::active()->get(),
            'locations' => Location::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
