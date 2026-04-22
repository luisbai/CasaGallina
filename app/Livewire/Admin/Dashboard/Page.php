<?php

namespace App\Livewire\Admin\Dashboard;

use App\Modules\Program\Infrastructure\Models\Program;
use App\Modules\Exhibition\Infrastructure\Models\Exhibition;
use App\Modules\News\Infrastructure\Models\Noticia;
use App\Modules\Publication\Infrastructure\Models\Publication;
use App\Modules\Newsletter\Infrastructure\Models\Newsletter;
use App\Modules\Donation\Infrastructure\Models\Donation as Donacion;
use App\Modules\Member\Infrastructure\Models\Member;
use App\Modules\Space\Infrastructure\Models\Space as Espacio;
use App\Modules\Tag\Infrastructure\Models\Tag;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Charge;

/**
 * Admin Dashboard component providing comprehensive overview of Casa Gallina's operations.
 *
 * Features:
 * - Key metrics and statistics for all content types
 * - Recent activity tables for quick navigation
 * - Performance optimized with caching
 * - Real-time counters using computed properties
 */
class Page extends Component
{
    #[Computed]
    public function totalProgramas()
    {
        return Cache::remember('dashboard.total_programas', 300, function () {
            return Program::count();
        });
    }

    #[Computed]
    public function activeProgramas()
    {
        return Cache::remember('dashboard.active_programas', 300, function () {
            return Program::where('estado', 'public')->count();
        });
    }

    #[Computed]
    public function totalExposiciones()
    {
        return Cache::remember('dashboard.total_exposiciones', 300, function () {
            return Exhibition::count();
        });
    }

    #[Computed]
    public function activeExposiciones()
    {
        return Cache::remember('dashboard.active_exposiciones', 300, function () {
            return Exhibition::where('estado', 'public')->count();
        });
    }

    #[Computed]
    public function totalNoticias()
    {
        return Cache::remember('dashboard.total_noticias', 300, function () {
            return Noticia::count();
        });
    }

    #[Computed]
    public function noticiasThisMonth()
    {
        return Cache::remember('dashboard.noticias_this_month', 300, function () {
            return Noticia::where('activo', true)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
        });
    }

    #[Computed]
    public function totalPublicaciones()
    {
        return Cache::remember('dashboard.total_publicaciones', 300, function () {
            return Publication::count();
        });
    }

    #[Computed]
    public function totalSubscribers()
    {
        return Cache::remember('dashboard.total_subscribers', 300, function () {
            return Newsletter::count();
        });
    }

    #[Computed]
    public function monthlyDonations()
    {
        return Cache::remember('dashboard.monthly_donations_stripe', 300, function () {
            Stripe::setApiKey(config('services.stripe.secret'));
            $startOfMonth = now()->startOfMonth()->timestamp;
            $endOfMonth = now()->endOfMonth()->timestamp;

            $charges = Charge::all([
                'created' => ['gte' => $startOfMonth, 'lte' => $endOfMonth],
                'limit' => 100, // Fetch up to 100 charges, modify if more are expected per month
            ]);

            $total = 0;
            foreach ($charges->autoPagingIterator() as $charge) {
                if ($charge->status === 'succeeded' && !$charge->refunded) {
                    $total += $charge->amount;
                }
            }

            return $total / 100; // Assuming amount is in cents
        });
    }

    #[Computed]
    public function totalMiembros()
    {
        return Cache::remember('dashboard.total_miembros', 300, function () {
            return Member::count();
        });
    }

    #[Computed]
    public function totalEspacios()
    {
        return Cache::remember('dashboard.total_espacios', 300, function () {
            return Espacio::count();
        });
    }

    #[Computed]
    public function recentNoticias()
    {
        return Cache::remember('dashboard.recent_noticias', 300, function () {
            return Noticia::latest()
                ->take(5)
                ->get(['id', 'titulo', 'activo', 'created_at']);
        });
    }

    #[Computed]
    public function recentProgramas()
    {
        return Cache::remember('dashboard.recent_programas', 300, function () {
            return Program::with('tags:id,nombre')
                ->latest()
                ->take(5)
                ->get(['id', 'titulo', 'estado', 'fecha', 'created_at']);
        });
    }

    #[Computed]
    public function recentDonaciones()
    {
        return Cache::remember('dashboard.recent_donaciones_stripe', 300, function () {
            Stripe::setApiKey(config('services.stripe.secret'));

            $charges = Charge::all(['limit' => 10, 'expand' => ['data.customer']]);
            $recent = [];

            foreach ($charges->data as $charge) {
                if ($charge->status === 'succeeded' && !$charge->refunded) {
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

                    // Create an object structure matching the original Model for the view
                    $recent[] = (object) [
                        'id' => $charge->id,
                        'amount' => $charge->amount / 100,
                        'status' => 'completed',
                        'created_at' => Carbon::createFromTimestamp($charge->created),
                        'donador' => (object) [
                            'name' => $name,
                            'email' => $email,
                        ]
                    ];

                    if (count($recent) >= 5) {
                        break;
                    }
                }
            }
            return collect($recent);
        });
    }


    #[Computed]
    public function upcomingEvents()
    {
        return Cache::remember('dashboard.upcoming_events', 300, function () {
            $upcoming = collect();

            $exposiciones = Exhibition::where('estado', 'public')
                ->whereNotNull('fecha')
                ->latest()
                ->take(3)
                ->get(['id', 'titulo', 'fecha'])
                ->map(function ($item) {
                    $item->type = 'Exposición';
                    $item->date = $item->created_at;
                    $item->route = '/admin/exposiciones';
                    return $item;
                });

            $programas = Program::where('estado', 'public')
                ->whereNotNull('fecha')
                ->latest()
                ->take(3)
                ->get(['id', 'titulo', 'fecha'])
                ->map(function ($item) {
                    $item->type = 'Programa';
                    $item->date = $item->created_at;
                    $item->route = '/admin/programa';
                    return $item;
                });

            return $upcoming->concat($exposiciones)
                ->concat($programas)
                ->sortBy('date')
                ->take(5);
        });
    }

    public function render(): View
    {
        return view('livewire.admin.dashboard.page');
    }
}