<?php

namespace App\Modules\Donation\Presentation\Livewire\Admin;

use App\Modules\Donation\Infrastructure\Models\Donation;
use App\Modules\Donation\Infrastructure\Models\Donor;
use App\Modules\News\Infrastructure\Models\Noticia;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Stripe\Stripe;
use Stripe\Charge;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Page extends Component
{
    use WithPagination;

    // Donaciones table properties
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 10;
    public string $search = '';
    public string $statusFilter = '';
    public string $noticiaFilter = '';

    // Donadores table properties
    public string $donorSortBy = 'total_amount';
    public string $donorSortDirection = 'desc';
    public int $donorPerPage = 5;
    public string $donorSearch = '';

    // Custom pagination page name for donadores to avoid conflicts
    protected string $donorPageName = 'donorsPage';

    protected array $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'noticiaFilter' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'donorSearch' => ['except' => ''],
        'donorSortBy' => ['except' => 'total_amount'],
        'donorSortDirection' => ['except' => 'desc']
    ];

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function sortDonors(string $column): void
    {
        if ($this->donorSortBy === $column) {
            $this->donorSortDirection = $this->donorSortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->donorSortBy = $column;
            $this->donorSortDirection = 'asc';
        }
    }

    /**
     * Cachea los datos de Stripe para evitar múltiples llamadas en una sola solicitud
     * Se limitó a los últimos 500 registros para optimizar la carga (No cargar todo de golpe)
     */
    protected function getStripeData()
    {
        return Cache::remember('donaciones_stripe_optimized_data_v2', 300, function () {
            Stripe::setApiKey(config('services.stripe.secret'));

            $charges = [];
            $hasMore = true;
            $startingAfter = null;
            $maxLimit = 500; // Optimización: Límite máximo para no cargar todo el histórico de golpe

            while ($hasMore && count($charges) < $maxLimit) {
                $params = ['limit' => 100, 'expand' => ['data.customer']];
                if ($startingAfter) {
                    $params['starting_after'] = $startingAfter;
                }

                $response = Charge::all($params);
                foreach ($response->data as $charge) {
                    $charges[] = $charge;
                }
                $hasMore = $response->has_more;
                if ($hasMore) {
                    $startingAfter = end($charges)->id;
                }
            }

            // Map payment intents to local donations to get Noticia origin
            $paymentIntentIds = collect($charges)->pluck('payment_intent')->filter()->toArray();
            $localDonations = null;
            if (!empty($paymentIntentIds)) {
                $localDonations = Donation::with('noticia')
                    ->whereIn('stripe_payment_intent_id', $paymentIntentIds)
                    ->get()
                    ->keyBy('stripe_payment_intent_id');
            }

            $emails = collect($charges)->map(function ($c) {
                return $c->billing_details->email ?? ($c->customer->email ?? null);
            })->filter()->unique()->toArray();

            $localDonors = null;
            if (!empty($emails)) {
                $localDonors = Donor::whereIn('email', $emails)
                    ->get()
                    ->keyBy('email');
            }

            $donacionesList = collect();
            $donadoresMap = [];

            foreach ($charges as $charge) {
                if ($charge->status !== 'succeeded')
                    continue;

                $status = 'completed';
                if ($charge->refunded)
                    $status = 'refunded';
                if ($charge->status === 'failed')
                    $status = 'failed';

                $name = 'Anónimo';
                $email = null;
                if ($charge->billing_details && $charge->billing_details->name) {
                    $name = $charge->billing_details->name;
                } elseif ($charge->customer && isset($charge->customer->name)) {
                    $name = $charge->customer->name;
                }

                if ($charge->billing_details && $charge->billing_details->email) {
                    $email = $charge->billing_details->email;
                } elseif ($charge->customer && isset($charge->customer->email)) {
                    $email = $charge->customer->email;
                }

                if (!$email)
                    $email = 'sin_email_' . $charge->id;

                $amount = $charge->amount / 100;
                $createdAt = clone Carbon::createFromTimestamp($charge->created);

                $localData = null;
                if ($charge->payment_intent && $localDonations && $localDonations->has($charge->payment_intent)) {
                    $localData = $localDonations->get($charge->payment_intent);
                }

                $donacion = (object) [
                    'id' => $charge->id,
                    'amount' => $amount,
                    'status' => $status,
                    'created_at' => clone $createdAt,
                    'noticia' => $localData ? $localData->noticia : null,
                    'noticia_id' => $localData ? $localData->noticia_id : null,
                    'donador' => (object) [
                        'name' => $name,
                        'email' => $email === ('sin_email_' . $charge->id) ? 'Sin email' : $email,
                    ]
                ];
                $donacionesList->push($donacion);

                if ($status === 'completed') {
                    if (!isset($donadoresMap[$email])) {
                        $localDonor = $localDonors ? $localDonors->get($email) : null;
                        $donadoresMap[$email] = (object) [
                            'id' => md5($email),
                            'name' => $name,
                            'email' => $email === ('sin_email_' . $charge->id) ? 'Sin email' : $email,
                            'total_amount' => 0,
                            'total_donations' => 0,
                            'comprobante' => $localDonor ? $localDonor->comprobante : false,
                            'created_at' => $localDonor ? $localDonor->created_at : clone $createdAt,
                            'latest_donation_at' => clone $createdAt
                        ];
                    }
                    $donadoresMap[$email]->total_amount += $amount;
                    $donadoresMap[$email]->total_donations += 1;
                    if ($createdAt > $donadoresMap[$email]->latest_donation_at) {
                        $donadoresMap[$email]->latest_donation_at = clone $createdAt;
                    }
                }
            }

            return [
                'donaciones' => $donacionesList,
                'donadores' => collect(array_values($donadoresMap)),
            ];
        });
    }

    #[Computed]
    public function donaciones(): LengthAwarePaginator
    {
        $data = clone $this->getStripeData()['donaciones'];

        if ($this->search) {
            $search = strtolower($this->search);
            $data = $data->filter(function ($d) use ($search) {
                $matchName = str_contains(strtolower($d->donador->name), $search);
                $matchEmail = str_contains(strtolower($d->donador->email), $search);
                $matchNoticia = $d->noticia && str_contains(strtolower(strip_tags($d->noticia->titulo)), $search);
                return $matchName || $matchEmail || $matchNoticia;
            });
        }

        if ($this->statusFilter) {
            $data = $data->where('status', $this->statusFilter);
        }

        if ($this->noticiaFilter !== '') {
            if ($this->noticiaFilter === 'general') {
                $data = $data->whereNull('noticia_id');
            } else {
                $data = $data->where('noticia_id', $this->noticiaFilter);
            }
        }

        $data = $this->sortDirection === 'desc'
            ? $data->sortByDesc($this->sortBy)
            : $data->sortBy($this->sortBy);

        // Fixing Livewire Pagination
        $page = $this->getPage('page');
        $sliced = $data->slice(($page - 1) * $this->perPage, $this->perPage)->values();

        return new LengthAwarePaginator($sliced, $data->count(), $this->perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => request()->query(),
            'pageName' => 'page',
        ]);
    }

    #[Computed]
    public function totalDonations()
    {
        return collect($this->getStripeData()['donaciones'])->where('status', 'completed')->sum('amount');
    }

    #[Computed]
    public function thisMonthDonations()
    {
        $startOfMonth = now()->startOfMonth();
        return collect($this->getStripeData()['donaciones'])
            ->where('status', 'completed')
            ->filter(function ($d) use ($startOfMonth) {
                return $d->created_at >= $startOfMonth;
            })
            ->sum('amount');
    }

    #[Computed]
    public function totalDonors()
    {
        return count($this->getStripeData()['donadores']);
    }

    #[Computed]
    public function recentDonationsCount()
    {
        $sevenDaysAgo = now()->subDays(7);
        return collect($this->getStripeData()['donaciones'])
            ->filter(function ($d) use ($sevenDaysAgo) {
                return $d->created_at >= $sevenDaysAgo;
            })
            ->count();
    }

    #[Computed]
    public function availableNoticias()
    {
        return Noticia::where('enable_donations', true)
            ->orderBy('titulo')
            ->get();
    }

    #[Computed]
    public function donadores(): LengthAwarePaginator
    {
        $data = clone $this->getStripeData()['donadores'];

        if ($this->donorSearch) {
            $search = strtolower($this->donorSearch);
            $data = $data->filter(function ($d) use ($search) {
                return str_contains(strtolower($d->name), $search) || str_contains(strtolower($d->email), $search);
            });
        }

        $data = $this->donorSortDirection === 'desc'
            ? $data->sortByDesc($this->donorSortBy)
            : $data->sortBy($this->donorSortBy);

        // Fixing Custom Pagination Name
        $page = $this->getPage($this->donorPageName);
        $sliced = $data->slice(($page - 1) * $this->donorPerPage, $this->donorPerPage)->values();

        return new LengthAwarePaginator($sliced, $data->count(), $this->donorPerPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => request()->query(),
            'pageName' => $this->donorPageName,
        ]);
    }

    public function render(): View
    {
        return view('livewire.admin.donation.page');
    }
}
