<?php

namespace App\Livewire;

use App\Models\Lead;
use App\Support\Telegram;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';

    public string $email = '';

    public string $company = '';

    public string $budget = '';

    /** @var array<int, string> */
    public array $services = [];

    public string $message = '';

    // Honeypot: real visitors never see or fill this field.
    public string $nickname = '';

    public bool $sent = false;

    public function mount(?string $service = null): void
    {
        if ($service && array_key_exists($service, config('agency.services'))) {
            $this->services = [$service];
        }

        if ($user = Auth::user()) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->company = (string) $user->company;
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:80'],
            'email' => ['required', 'email', 'max:120'],
            'company' => ['nullable', 'string', 'max:120'],
            'budget' => ['required', Rule::in(array_keys(config('agency.budgets')))],
            'services' => ['array', 'min:1'],
            'services.*' => [Rule::in(array_keys(config('agency.services')))],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ];
    }

    protected function messages(): array
    {
        return [
            'services.min' => 'Pick at least one service you are interested in.',
            'budget.required' => 'Let us know your approximate monthly budget.',
            'message.min' => 'A couple of sentences about your goals helps us prepare.',
        ];
    }

    public function updated(string $property): void
    {
        if ($property !== 'nickname' && ! str_starts_with($property, 'services.')) {
            $this->validateOnly($property);
        }
    }

    public function submit(): void
    {
        $data = $this->validate();

        if ($this->nickname !== '') {
            $this->sent = true; // Pretend success for bots.

            return;
        }

        $key = 'contact:'.request()->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('form', 'Too many requests. Please try again in a few minutes or email us directly.');

            return;
        }
        RateLimiter::hit($key, 600);

        $body = $this->formatLead($data);
        $stored = $this->storeLead($data);

        try {
            Mail::raw($body, function ($mail) use ($data) {
                $mail->to(config('agency.email'))
                    ->replyTo($data['email'], $data['name'])
                    ->subject('New lead: '.$data['name'].($data['company'] ? ' ('.$data['company'].')' : ''));
            });
            $this->notifyTelegram($body);
        } catch (\Throwable $e) {
            Log::error('Contact form delivery failed', ['error' => $e->getMessage()]);

            // The lead is safe in the admin panel even if the notification failed.
            if (! $stored) {
                $this->addError('form', 'Something went wrong while sending. Please email us at '.config('agency.email').'.');

                return;
            }
        }

        Log::info('New contact lead', ['email' => $data['email'], 'services' => $data['services']]);

        $this->reset(['budget', 'services', 'message']);
        if (! Auth::check()) {
            $this->reset(['name', 'email', 'company']);
        }
        $this->sent = true;
    }

    private function storeLead(array $data): bool
    {
        try {
            Lead::create([
                'user_id' => Auth::id(),
                'name' => $data['name'],
                'email' => $data['email'],
                'company' => $data['company'] ?: null,
                'budget' => $data['budget'],
                'services' => $data['services'],
                'message' => $data['message'],
                'ip_address' => request()->ip(),
            ]);

            return true;
        } catch (\Throwable $e) {
            Log::warning('Lead was not stored', ['error' => $e->getMessage()]);

            return false;
        }
    }

    private function formatLead(array $data): string
    {
        $services = collect($data['services'])
            ->map(fn ($slug) => config("agency.services.$slug.title"))
            ->implode(', ');

        return implode("\n", [
            'Name: '.$data['name'],
            'Email: '.$data['email'],
            'Company: '.($data['company'] ?: '-'),
            'Budget: '.config('agency.budgets.'.$data['budget']),
            'Services: '.$services,
            '',
            $data['message'],
        ]);
    }

    private function notifyTelegram(string $text): void
    {
        Telegram::notify("New lead from impactwaves.agency\n\n".$text);
    }

    public function render()
    {
        return view('livewire.contact-form', [
            'serviceOptions' => config('agency.services'),
            'budgetOptions' => config('agency.budgets'),
        ]);
    }
}
