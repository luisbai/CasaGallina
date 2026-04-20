<?php

namespace App\Http\Controllers;


use App\Modules\Newsletter\Infrastructure\Models\Newsletter;
use App\Modules\Contact\Infrastructure\Models\ContactSubmission;
use App\Modules\Contact\Application\Services\ContactService;
use App\Modules\Homepage\Application\Services\HomepageService;
use App\Modules\Space\Infrastructure\Models\Space;
use App\Modules\Member\Infrastructure\Models\Member;
use App\Modules\Strategy\Infrastructure\Models\Strategy;
use App\Modules\Strategy\Application\Services\StrategyService;
use App\Modules\Exhibition\Infrastructure\Models\Exhibition;
use App\Modules\Exhibition\Application\Services\ExhibitionService;
use App\Modules\Exhibition\Infrastructure\Models\ExhibitionFile;
use App\Modules\Program\Infrastructure\Models\Program;
use App\Modules\Tag\Infrastructure\Models\Tag;
use App\Modules\News\Infrastructure\Models\Noticia;
use App\Modules\Homepage\Infrastructure\Models\HomepageBanner;
use App\Modules\Homepage\Infrastructure\Models\HomepageContent;
use App\Modules\Publication\Infrastructure\Models\Publication;
use App\Modules\Publication\Application\Services\PublicationService;
use App\Modules\Space\Infrastructure\Models\Space as Espacio;
use App\Modules\Contact\Infrastructure\Models\Lead;

use App\Modules\Donation\Infrastructure\Mail\DonationMail;
use App\Mail\NewsletterMail;
use App\Mail\LeadMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PublicController extends Controller
{

    public $language;
    protected $estrategiaService;
    protected $exposicionService;
    protected $publicationService;
    protected $homepageService;
    protected $contactService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        Request $request,
        StrategyService $estrategiaService,
        ExhibitionService $exposicionService,
        PublicationService $publicationService,
        HomepageService $homepageService,
        ContactService $contactService
    ) {
        $this->estrategiaService = $estrategiaService;
        $this->exposicionService = $exposicionService;
        $this->publicationService = $publicationService;
        $this->homepageService = $homepageService;
        $this->contactService = $contactService;

        $routeName = $request->route() ? $request->route()->getName() : '';
        if ($routeName && str_starts_with($routeName, 'english.')) {
            $this->language = 'en';
        } else {
            $this->language = 'es';
        }

        view()->share('language', $this->language);

    }

    public function programa()
    {

        $estrategias_locales_tags = Tag::with(['multimedia', 'thumbnail'])->where('type', 'programa-local')->orderBy('nombre', 'asc')->get();
        $estrategias_externas_tags = Tag::with(['multimedia', 'thumbnail'])->where('type', 'programa-externo')->orderBy('nombre', 'asc')->get();

        $exposiciones = $this->exposicionService->getPublic('exposicion')->take(6);
        $proyectos_artisticos = $this->exposicionService->getPublic('proyecto-artistico')->take(6);

        $params = compact('estrategias_locales_tags', 'estrategias_externas_tags', 'exposiciones', 'proyectos_artisticos');

        if ($this->language == 'en') {
            return view('public.english.programa', $params);
        }

        return view('public.programa', $params);
    }

    public function exposicion($slug, Request $request)
    {
        $exposicion = $this->exposicionService->findBySlugWithDetails($slug);

        if (!$exposicion) {
            abort(404, 'Exposición no encontrada');
        }

        // Get all programa tags for general use if needed, or filter as per original logic
        $programa_tags_local = Tag::with(['multimedia', 'thumbnail'])->where('type', 'programa-local')->orderBy('nombre', 'asc')->get();
        $programa_tags_external = Tag::with(['multimedia', 'thumbnail'])->where('type', 'programa-externo')->orderBy('nombre', 'asc')->get();
        $estrategias = $programa_tags_local->merge($programa_tags_external);

        $params = compact('exposicion', 'estrategias');

        if ($this->language == 'en') {
            return view('public.english.exposicion-detalle', $params);
        }

        return view('public.exposicion-detalle', $params);
    }

    public function exposiciones()
    {
        $exposiciones = $this->exposicionService->getPublic('exposicion');

        if ($this->language == 'en') {
            return view('public.english.exposiciones', compact('exposiciones'));
        }

        return view('public.exposiciones', compact('exposiciones'));
    }

    public function proyectoArtistico($slug, $id, Request $request)
    {
        $exposicion = $this->exposicionService->find($id);

        if (!$exposicion || $exposicion->type !== 'proyecto-artistico') {
            abort(404);
        }

        $params = compact('exposicion');

        if ($this->language == 'en') {
            return view('public.english.exposicion-detalle', $params);
        }

        return view('public.exposicion-detalle', $params);
    }

    public function proyectosArtisticos()
    {
        $proyectos = $this->exposicionService->getPublic('proyecto-artistico');

        if ($this->language == 'en') {
            return view('public.english.proyectos-artisticos', compact('proyectos'));
        }

        return view('public.proyectos-artisticos', compact('proyectos'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Get all programa tags (local + external) combined
        $programa_tags_local = Tag::with(['multimedia', 'thumbnail'])->where('type', 'programa-local')->orderBy('nombre', 'asc')->get();
        $programa_tags_external = Tag::with(['multimedia', 'thumbnail'])->where('type', 'programa-externo')->orderBy('nombre', 'asc')->get();
        $programa_tags = $programa_tags_local->merge($programa_tags_external);

        $publicaciones = $this->publicationService->getPublic()->take(3);
        $espacios = Espacio::where('status', 'activo')->orderBy('created_at', 'DESC')->get();
        $noticias = Noticia::with([
            'multimedia',
            'tags' => function ($query) {
                $query->where('type', 'noticia');
            }
        ])->activa()->recientes()->take(3)->get();

        // Get active banners and intro content
        $banners = $this->homepageService->getActiveBanners();
        $introContent = $this->homepageService->getIntroContent();

        $params = compact('programa_tags', 'publicaciones', 'espacios', 'noticias', 'banners', 'introContent');

        // Pass aliases for backward compatibility with stale view cache or older views
        $params['estrategias'] = $programa_tags;
        $params['estrategias_locales_tags'] = $programa_tags_local;
        $params['estrategias_externas_tags'] = $programa_tags_external;

        if ($this->language == 'en') {
            return view('public.english.index', $params);
        }

        return view('public.index', $params);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function casa()
    {
        $miembros = \Illuminate\Support\Facades\Cache::remember('members', now()->addDay(), function () {
            return Member::orderBy('orden', 'asc')->get();
        });

        $miembros_agrupados = $miembros->groupBy('tipo');

        $params = compact('miembros', 'miembros_agrupados');

        if ($this->language == 'en') {
            return view('public.english.casa', $params);
        }

        return view('public.casa', $params);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function estrategia($slug, $id)
    {
        $estrategia = $this->estrategiaService->find($id);

        if ($this->language == 'en') {
            return view('public.english.estrategia', compact('estrategia'));
        }

        return view('public.estrategia', compact('estrategia'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function boletines()
    {
        $boletines = Newsletter::orderBy('boletin_fecha', 'DESC')->get()->groupBy(function ($val) {
            return \Carbon\Carbon::parse($val->boletin_fecha)->format('Y');
        });

        if ($this->language == 'en') {
            return view('public.english.boletines', compact('boletines'));
        }

        return view('public.boletines', compact('boletines'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function estrategias()
    {
        $estrategias = Cache::remember('estrategias', now()->addWeek(), function () {
            return $this->estrategiaService->getPublic();
        });

        if ($this->language == 'en') {
            return view('public.english.estrategias', compact('estrategias'));
        }

        return view('public.estrategias', compact('estrategias'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function newsletter(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email']
        ]);

        try {
            $toEmail = 'luis@casagallina.org.mx';

            Mail::to($toEmail)->send(new NewsletterMail($request->input('email')));

            return [
                'status' => 'success',
                'message' => 'Correo enviado'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function avisoPrivacidad()
    {
        if ($this->language == 'en') {
            return view('public.english.aviso-privacidad');
        }
        return view('public.aviso-privacidad');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function publicacion($slug, $id)
    {
        $publicacion = $this->publicationService->find($id);

        if (!$publicacion) {
            abort(404);
        }

        if ($this->language == 'en') {
            return view('public.english.publicacion', compact('publicacion'));
        }

        return view('public.publicacion', compact('publicacion'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function publicaciones()
    {
        $params = Cache::remember('publicaciones', now()->addWeek(), function () {
            $publicaciones_impresas = $this->publicationService->getPublic('impreso');
            $publicaciones_digitales = $this->publicationService->getPublic('digital');

            return compact('publicaciones_impresas', 'publicaciones_digitales');
        });

        if ($this->language == 'en') {
            return view('public.english.publicaciones', $params);
        }

        return view('public.publicaciones', $params);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function publicacionDownload($slug, $id, $filename = null)
    {

        $publicacion = $this->publicationService->find($id);

        if (!$publicacion) {
            abort(404);
        }

        $multimedia = $publicacion->multimedia;
        $filename = $multimedia?->filename;

        if (!$filename) {
            \Log::warning("Publication download failed: No multimedia file associated with publication ID {$id}");
            abort(404, 'No se ha encontrado un archivo asociado a esta publicación.');
        }

        $disk = \Illuminate\Support\Facades\Storage::disk('public');

        if ($disk->exists($filename)) {
            $fileToDownload = $filename;
        } elseif ($disk->exists('cache/' . $filename)) {
            $fileToDownload = 'cache/' . $filename;
        } else {
            \Log::error("Publication download failed: File not found on disk for publication ID {$id}. Expected path: {$filename}");
            abort(404, 'El archivo físico no se encuentra en el servidor.');
        }

        if (!request()->session()->has('downloads')) {
            $publicacion->increment('downloads');
            request()->session()->put('downloads', true);
        }

        // Generate a user-friendly filename
        $extension = pathinfo($fileToDownload, PATHINFO_EXTENSION) ?: 'pdf';
        $cleanTitle = html_entity_decode(strip_tags($publicacion->titulo), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $friendlyName = \Str::slug($cleanTitle) . '.' . $extension;

        \Log::info("Serving publication download", [
            'id' => $id,
            'title' => $cleanTitle,
            'friendly_name' => $friendlyName,
            'original_path' => $fileToDownload
        ]);

        $headers = [
            'Content-Type' => $multimedia->mime ?? 'application/pdf',
        ];

        return Storage::disk('public')->download($fileToDownload, $friendlyName, $headers);
    }

    public function exposicionArchivoViewer($archivoId)
    {
        // Simple lookup, could be moved to service
        $archivo = \App\Modules\Exhibition\Infrastructure\Models\ExhibitionFile::findOrFail($archivoId);

        // Check if the file exists on disk
        if (!$archivo->fileExists()) {
            abort(404, 'El archivo no se encuentra disponible. Por favor contacte al administrador.');
        }

        if ($this->language == 'en') {
            return view('public.english.exposicion-archivo-viewer', compact('archivo'));
        }

        return view('public.exposicion-archivo-viewer', compact('archivo'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function donaciones()
    {
        if ($this->language == 'en') {
            return view('public.english.donaciones');
        }

        return view('public.donaciones');
    }

    public function donacionesContacto(Request $request)
    {
        $this->validate($request, [
            'nombre' => ['required'],
        ]);

        try {
            $toEmail = 'luis@casagallina.org.mx';

            Mail::to($toEmail)->send(new DonationMail($request->input()));

            Lead::create([
                'name' => $request->get('nombre'),
                'email' => $request->get('email'),
                'phone' => $request->get('telefono'),
                'organization' => $request->get('organizacion'),
                'category' => 'donaciones',
                'category_detail' => 'donacion-personalizada',
            ]);

            return [
                'success' => true,
            ];

        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }


    public function publicacionContacto($id, Request $request)
    {
        \Log::info('PublicacionContacto called', [
            'id' => $id,
            'request_data' => $request->all()
        ]);

        $this->validate($request, [
            'nombre' => ['required'],
        ]);

        $publicacion = $this->publicationService->find($id);

        if (!$publicacion) {
            abort(404);
        }

        \Log::info('Validation passed, publicacion found', [
            'publicacion_id' => $publicacion->id,
            'publicacion_title' => $publicacion->titulo
        ]);

        try {
            $contactSubmission = $this->contactService->create([
                'form_type' => 'publication',
                'nombre' => $request->get('nombre'),
                'email' => $request->get('email'),
                'telefono' => $request->get('telefono'),
                'organizacion' => $request->get('organizacion'),
                'publicacion_id' => $publicacion->id,
                'metadata' => [
                    'intended_action' => $request->get('intended_action'),
                    'publicacion_titulo' => strip_tags($publicacion->titulo),
                ],
            ]);

            // Notify admin
            try {
                $toEmail = 'luis@casagallina.org.mx';
                Mail::to($toEmail)->send(new LeadMail($publicacion, $request->all()));
            } catch (\Exception $e) {
                \Log::error('Error sending LeadMail notification', [
                    'error' => $e->getMessage()
                ]);
            }

            \Log::info('ContactSubmission created successfully', [
                'contact_submission_id' => $contactSubmission->id,
                'form_data' => $contactSubmission->toArray()
            ]);

            // Get the intended action
            $intendedAction = $request->get('intended_action');

            $response = [
                'success' => true,
                'intended_action' => $intendedAction,
            ];

            // Add action-specific data to response
            if ($intendedAction === 'download') {
                $friendlyName = \Str::slug(strip_tags($publicacion->titulo)) . '.pdf';
                $routeName = $this->language == 'en' ? 'english.publicacion.download' : 'publicacion.download';
                $response['download_url'] = route($routeName, [
                    'slug' => \Str::slug(strip_tags($publicacion->titulo)),
                    'id' => $publicacion->id,
                    'filename' => $friendlyName
                ]);
            } elseif ($intendedAction === 'preview') {
                $friendlyName = \Str::slug(strip_tags($publicacion->titulo)) . '.pdf';
                $routeName = $this->language == 'en' ? 'english.publicacion.viewer' : 'publicacion.viewer';
                $response['viewer_url'] = route($routeName, [
                    'slug' => \Str::slug(strip_tags($publicacion->titulo)),
                    'id' => $publicacion->id,
                    'filename' => $friendlyName
                ]);
            }

            \Log::info('Returning successful response', $response);
            return $response;
        } catch (\Exception $e) {
            \Log::error('PublicacionContacto error', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function publicacionViewer($slug, $id, $filename = null)
    {
        $publicacion = $this->publicationService->find($id);

        if (!$publicacion) {
            abort(404);
        }

        if ($this->language == 'en') {
            return view('public.english.publicacion-viewer', compact('publicacion'));
        }

        return view('public.publicacion-viewer', compact('publicacion'));
    }

    public function donacionesCampaign()
    {
        if ($this->language == 'en') {
            return view('public.english.donaciones-campaign');
        }

        return view('public.donaciones-campaign');
    }

    public function donacionUnica()
    {
        if ($this->language == 'en') {
            return view('public.english.donaciones-unica');
        }
        return view('public.donaciones-unica');
    }

    public function donacionMensual()
    {
        if ($this->language == 'en') {
            return view('public.english.donaciones-mensual');
        }
        return view('public.donaciones-mensual');
    }

    public function donacionPersonalizada()
    {
        if ($this->language == 'en') {
            return view('public.english.donaciones-personalizada');
        }
        return view('public.donaciones-personalizada');
    }

    public function donacionInternacional()
    {
        if ($this->language == 'en') {
            return view('public.english.donaciones-internacional');
        }
        return view('public.donaciones-internacional');
    }

    public function noticia($slug)
    {
        $noticia = Noticia::where('slug', $slug)->first();

        if (!$noticia) {
            abort(404);
        }

        $relacionadas = Noticia::activa()
            ->where('id', '!=', $noticia->id)
            ->recientes()
            ->take(3)
            ->get();

        if ($this->language == 'en') {
            return view('public.english.noticia', compact('noticia', 'relacionadas'));
        }

        return view('public.noticia', compact('noticia', 'relacionadas'));
    }

    public function noticias()
    {
        $noticias = Noticia::activa()->recientes()->paginate(12);

        if ($this->language == 'en') {
            return view('public.english.noticias', compact('noticias'));
        }

        return view('public.noticias', compact('noticias'));
    }

    public function aliados()
    {
        if ($this->language == 'en') {
            return view('public.english.aliados');
        }
        return view('public.aliados');
    }

    public function impacto()
    {
        if ($this->language == 'en') {
            return view('public.english.impacto');
        }
        return view('public.impacto');
    }

    public function busqueda(Request $request)
    {
        $query = $request->input('q');

        if ($this->language == 'en') {
            return view('public.english.busqueda', compact('query'));
        }
        return view('public.busqueda', compact('query'));
    }

    public function programaEstrategiaDetalle($slug)
    {
        // Determine type based on route name or request segment
        // Or simply pass the slug and let the Livewire component handle it if it searches efficiently
        // But the view expects $route_tipo

        $routeName = request()->route()->getName();
        $route_tipo = '';

        if (str_contains($routeName, 'estrategia-local')) {
            $route_tipo = 'programa-local';
        } elseif (str_contains($routeName, 'estrategia-externa')) {
            $route_tipo = 'programa-externa';
        }

        $params = compact('slug', 'route_tipo');

        if ($this->language == 'en') {
            return view('public.english.programa-detalle', $params);
        }
        return view('public.programa-detalle', $params);
    }

    public function programaTagDetalle($slug)
    {
        $route_tipo = 'tag';
        $params = compact('slug', 'route_tipo');

        if ($this->language == 'en') {
            return view('public.english.programa-detalle', $params);
        }
        return view('public.programa-detalle', $params);
    }
}
