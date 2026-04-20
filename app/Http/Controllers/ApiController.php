<?php

namespace App\Http\Controllers;

use App\Modules\Space\Infrastructure\Models\Space as Espacio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function espacios()
    {
        return Cache::remember('espacios', now()->addDay(), function () {
            return Espacio::orderBy('created_at', 'DESC')->with('estrategias')->get();
        });
    }
}
