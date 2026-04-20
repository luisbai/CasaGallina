<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PublicController;

use App\Http\Controllers\EspaciosController;
use App\Http\Controllers\MiembrosController;
use App\Http\Controllers\BoletinesController;
use App\Http\Controllers\PublicacionesController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\PaymentController;
use App\Livewire\Admin;

use App\Http\Controllers\Auth as AuthController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'index'])->name('index');
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/la-casa', [PublicController::class, 'casa'])->name('casa');

Route::get('/estrategia/{slug}/{id}', [PublicController::class, 'estrategia'])->name('estrategia');
Route::get('/estrategias', [PublicController::class, 'estrategias'])->name('estrategias');
Route::get('/boletines', [PublicController::class, 'boletines'])->name('boletines');

Route::get('/publicacion/{slug}/{id}', [PublicController::class, 'publicacion'])->name('publicacion');
Route::get('/publicaciones', [PublicController::class, 'publicaciones'])->name('publicaciones');
Route::get('/publicacion/{slug}/{id}/download', [PublicController::class, 'publicacionDownload'])->name('publicacion.download');
Route::get('/publicacion/{slug}/{id}/viewer', [PublicController::class, 'publicacionViewer'])->name('publicacion.viewer');

Route::post('/publicacion/{id}/contacto', [PublicController::class, 'publicacionContacto'])->name('publicacion.contacto');

Route::post('/newsletter', [PublicController::class, 'newsletter'])->name('newsletter');
Route::get('/aviso-privacidad', [PublicController::class, 'avisoPrivacidad'])->name('aviso-privacidad');

Route::get('/boletines', [PublicController::class, 'boletines'])->name('boletines');

Route::get('/donaciones', [PublicController::class, 'donaciones'])->name('donaciones');
Route::post('/donaciones/contacto', [PublicController::class, 'donacionesContacto'])->name('donaciones.contacto');
Route::post('/donaciones/checkout', [\App\Modules\Donation\Presentation\Http\Controllers\DonationController::class, 'checkout'])->name('donaciones.checkout');
Route::get('/donaciones/campaign', [PublicController::class, 'donacionesCampaign'])->name('donaciones.campaign');

// Donation type specific pages
Route::get('/donaciones/unica', [PublicController::class, 'donacionUnica'])->name('donaciones.unica');
Route::get('/donaciones/mensual', [PublicController::class, 'donacionMensual'])->name('donaciones.mensual');
Route::get('/donaciones/personalizada', [PublicController::class, 'donacionPersonalizada'])->name('donaciones.personalizada');
Route::get('/donaciones/internacional', [PublicController::class, 'donacionInternacional'])->name('donaciones.internacional');

Route::get('/programa', [PublicController::class, 'programa'])->name('programa');
Route::get('/programa/estrategia-local/{slug}', [PublicController::class, 'programaEstrategiaDetalle'])->name('programa.estrategia-local.detalle');
Route::get('/programa/estrategia-externa/{slug}', [PublicController::class, 'programaEstrategiaDetalle'])->name('programa.estrategia-externa.detalle');
Route::get('/programa/{slug}', [PublicController::class, 'programaTagDetalle'])->name('programa.tag.detalle');

Route::get('/exposicion/{slug}', [PublicController::class, 'exposicion'])->name('exposicion');
Route::get('/exposiciones', [PublicController::class, 'exposiciones'])->name('exposiciones');
Route::get('/exposicion/archivo/{archivo}/viewer', [PublicController::class, 'exposicionArchivoViewer'])->name('exposicion.archivo.viewer');

Route::get('/proyecto-artistico/{slug}/{id}', [PublicController::class, 'proyectoArtistico'])->name('proyecto-artistico');
Route::get('/proyectos-artisticos', [PublicController::class, 'proyectosArtisticos'])->name('proyectos-artisticos');

Route::get('/noticia/{slug}', [PublicController::class, 'noticia'])->name('noticia');
Route::get('/noticias', [PublicController::class, 'noticias'])->name('noticias');

// Search routes
Route::get('/busqueda', [PublicController::class, 'busqueda'])->name('search');

Route::get('/aliados', [PublicController::class, 'aliados'])->name('aliados');

Route::get('/impacto', [PublicController::class, 'impacto'])->name('impacto');

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'en'], function() {

    Route::get('/', [PublicController::class, 'index'])->name('english.index');
    Route::get('/', [PublicController::class, 'index'])->name('english.home');
    Route::get('/the-house', [PublicController::class, 'casa'])->name('english.casa');

    Route::get('/strategy/{slug}/{id}', [PublicController::class, 'estrategia'])->name('english.estrategia');
    Route::get('/strategies', [PublicController::class, 'estrategias'])->name('english.estrategias');

    Route::get('/newsletter', [PublicController::class, 'boletines'])->name('english.boletines');
    Route::get('/aviso-privacidad', [PublicController::class, 'avisoPrivacidad'])->name('english.aviso-privacidad');

    Route::get('/publication/{slug}/{id}', [PublicController::class, 'publicacion'])->name('english.publicacion');
    Route::get('/publications', [PublicController::class, 'publicaciones'])->name('english.publicaciones');
    Route::get('/publication/{slug}/{id}/viewer', [PublicController::class, 'publicacionViewer'])->name('english.publicacion.viewer');
    Route::get('/publication/{slug}/{id}/download', [PublicController::class, 'publicacionDownload'])->name('english.publicacion.download');
    Route::post('/publication/{id}/contacto', [PublicController::class, 'publicacionContacto'])->name('english.publicacion.contacto');

    Route::get('/donate', [PublicController::class, 'donaciones'])->name('english.donaciones');
    Route::get('/donate/campaign', [PublicController::class, 'donacionesCampaign'])->name('english.donaciones.campaign');

    // Donation type specific pages
    Route::get('/donate/unique', [PublicController::class, 'donacionUnica'])->name('english.donaciones.unica');
    Route::get('/donate/monthly', [PublicController::class, 'donacionMensual'])->name('english.donaciones.mensual');
    Route::get('/donate/personalized', [PublicController::class, 'donacionPersonalizada'])->name('english.donaciones.personalizada');
    Route::get('/donate/international', [PublicController::class, 'donacionInternacional'])->name('english.donaciones.internacional');

    Route::get('/program', [PublicController::class, 'programa'])->name('english.programa');
    Route::get('/program/local-strategy/{slug}', [PublicController::class, 'programaEstrategiaDetalle'])->name('english.programa.estrategia-local.detalle');
    Route::get('/program/external-strategy/{slug}', [PublicController::class, 'programaEstrategiaDetalle'])->name('english.programa.estrategia-externa.detalle');
    Route::get('/program/{slug}', [PublicController::class, 'programaTagDetalle'])->name('english.programa.tag.detalle');

    Route::get('/exhibition/{slug}', [PublicController::class, 'exposicion'])->name('english.exposicion');
    Route::get('/exhibitions', [PublicController::class, 'exposiciones'])->name('english.exposiciones');

    Route::get('/artistic-project/{slug}/{id}', [PublicController::class, 'proyectoArtistico'])->name('english.proyecto-artistico');
    Route::get('/artistic-projects', [PublicController::class, 'proyectosArtisticos'])->name('english.proyectos-artisticos');

    Route::get('/news/{slug}', [PublicController::class, 'noticia'])->name('english.noticia');
    Route::get('/news', [PublicController::class, 'noticias'])->name('english.noticias');

    // Search routes
    Route::get('/search', [PublicController::class, 'busqueda'])->name('english.search');

    Route::get('/partners', [PublicController::class, 'aliados'])->name('english.aliados');

    Route::get('/impacto', [PublicController::class, 'impacto'])->name('english.impacto');

    Route::get('/admin/login', function () {
        return view('auth.login');
    })->name('english.login');
});

/*
|--------------------------------------------------------------------------
| Rutas Admin
|--------------------------------------------------------------------------
*/

/* Auth Routes (Public) */
Route::group(['prefix' => 'admin'], function() {
    Auth::routes();
});

/* Admin Routes (Protected) */
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {

    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');

	/* Dashboard */
	Route::get('/', Admin\Dashboard\Page::class)->name('admin.index');
	Route::get('/home', Admin\Dashboard\Page::class)->name('admin.home');

	/* Estrategias */
    Route::get('/estrategias', [\App\Modules\Strategy\Presentation\Http\Controllers\StrategyController::class, 'index'])->name('admin.estrategias.index');
    Route::get('/estrategias/create', [\App\Modules\Strategy\Presentation\Http\Controllers\StrategyController::class, 'create'])->name('admin.estrategias.create');
    Route::post('/estrategias', [\App\Modules\Strategy\Presentation\Http\Controllers\StrategyController::class, 'store'])->name('admin.estrategias.store');
    Route::get('/estrategias/{id}', [\App\Modules\Strategy\Presentation\Http\Controllers\StrategyController::class, 'show'])->name('admin.estrategias.show');
    Route::get('/estrategias/{id}/edit', [\App\Modules\Strategy\Presentation\Http\Controllers\StrategyController::class, 'edit'])->name('admin.estrategias.edit');
    Route::put('/estrategias/{id}', [\App\Modules\Strategy\Presentation\Http\Controllers\StrategyController::class, 'update'])->name('admin.estrategias.update');
    Route::delete('/estrategias/{id}', [\App\Modules\Strategy\Presentation\Http\Controllers\StrategyController::class, 'delete'])->name('admin.estrategias.delete');
    Route::delete('/estrategias/{id}/image', [\App\Modules\Strategy\Presentation\Http\Controllers\StrategyController::class, 'deleteImage'])->name('admin.estrategias.images.delete');

    /* Espacios */
    Route::get('espacios', \App\Modules\Space\Presentation\Livewire\Admin\SpacePage::class)->name('admin.spaces.index'); // Mapping to SpacePage
    // Route::get('espacios/create', [EspaciosController::class, 'create'])->name('admin.espacios.create'); // Handled by Page modal
    // Route::post('espacios', [EspaciosController::class, 'store'])->name('admin.espacios.store'); // Handled by Page store
    Route::get('espacios/{id}/edit', \App\Modules\Space\Presentation\Livewire\Admin\SpaceEdit::class)->name('admin.spaces.edit'); // Corrected name to admin.spaces.edit
    // Route: 'admin.espacios.edit' is used in views, let's keep alias or update views. 
    // I updated views to use 'admin.spaces.edit'.
    // Let's check page.blade.php content I just sent. I used 'admin.spaces.edit'.
    // Legacy used 'admin.espacios.edit'.
    // I need to support both or verify usages.
    
    // Route::put('espacios/{id}', [EspaciosController::class, 'update'])->name('admin.espacios.update'); // Handled by Edit update
    // Route::get('espacios/{id}/delete', [EspaciosController::class, 'delete'])->name('admin.espacios.delete'); // Handled by Page delete

    /* Miembros del Equipo (Livewire) */
    Route::get('/miembros', \App\Modules\Member\Presentation\Livewire\Admin\MemberPage::class)->name('admin.miembros.index');

    /* Boletines (Livewire) */
    Route::get('/boletines', \App\Modules\Newsletter\Presentation\Livewire\Admin\Page::class)->name('admin.boletines.index');

    /* Publications */
    Route::get('/publicaciones', \App\Modules\Publication\Presentation\Livewire\Admin\Page::class)->name('admin.publications.index');
    Route::get('/publicaciones/create', \App\Modules\Publication\Presentation\Livewire\Admin\Form::class)->name('admin.publications.create');
    Route::get('/publicaciones/{id}/edit', \App\Modules\Publication\Presentation\Livewire\Admin\Form::class)->name('admin.publications.edit');

    /* Programa */
    Route::get('programa', \App\Modules\Program\Presentation\Livewire\Admin\ProgramPage::class)
        ->name('admin.programa');

    /* Exposiciones & Proyectos Artísticos */
    /* Exposiciones & Proyectos Artísticos */
    Route::get('exposiciones', \App\Modules\Exhibition\Presentation\Livewire\Admin\Page::class)
        ->name('admin.exhibitions.index');
    Route::get('exposiciones/create', \App\Modules\Exhibition\Presentation\Livewire\Admin\Edit::class)
        ->name('admin.exhibitions.create');
    Route::get('exposiciones/{id}/edit', \App\Modules\Exhibition\Presentation\Livewire\Admin\Edit::class)
        ->name('admin.exhibitions.edit');


    /* Tags */
    Route::get('tags', Admin\Tag\Page::class)
        ->name('admin.tags');

    /* Noticias */
    Route::get('noticias', Admin\Noticia\Page::class)
        ->name('admin.noticias');

    /* Donaciones */
    Route::get('donaciones', \App\Modules\Donation\Presentation\Livewire\Admin\Page::class)
        ->name('admin.donaciones');

    /* Homepage */
    Route::get('homepage', \App\Modules\Homepage\Presentation\Livewire\Admin\HomepagePage::class)
        ->name('admin.homepage');

    /* Formularios de Contacto */
    Route::get('formularios', \App\Modules\Contact\Presentation\Livewire\Admin\Page::class)
        ->name('admin.formularios');

});

Route::group(['prefix' => 'api'], function() {
	Route::get('/espacios', [ApiController::class, 'espacios'])->name('api.espacios');
	Route::get('/admin/estrategias/datatables', [\App\Modules\Strategy\Presentation\Http\Controllers\StrategyController::class, 'datatables'])->name('api.estrategias.datatables');
});
