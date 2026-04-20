<?php

namespace App\Modules\Space\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Space\Application\Services\SpaceService;
use App\Modules\Space\Infrastructure\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SpaceController extends Controller
{
    public function __construct(
        protected SpaceService $service
    ) {
        $this->middleware('auth');
    }

    public function index()
    {
        $espacios = $this->service->getAllSpaces();
        // Return view from new module location or reuse existing?
        // We should move views to resources/views/admin/spaces or similar
        // For now, let's reuse and I will update views later or now.
        // Let's assume we rename views folder to 'spaces'
        return view('admin.spaces.index', compact('espacios'));
    }

    public function create()
    {
        return view('admin.spaces.create');
    }

    public function edit($id)
    {
        $space = $this->service->findSpace($id);
        return view('admin.spaces.edit', ['espacio' => $space]); // Keeping variable name 'espacio' for view compatibility
    }

    public function store(Request $request)
    {
        $this->validate($request, Space::$rules);
        
        $this->service->createSpace(
            $request->input(), 
            $request->file('multimedia_id')
        );

        toastr()->success('Espacio creado', 'Éxito');

        return redirect()->route('admin.spaces.index');
    }

    public function update($id, Request $request)
    {
        $this->validate($request, Arr::except(Space::$rules, ['multimedia_id']));

        $space = $this->service->findSpace($id);

        $this->service->updateSpace(
            $space,
            $request->input(),
            $request->file('multimedia_id')
        );

        toastr()->success('Espacio actualizado', 'Éxito');

        return redirect()->route('admin.spaces.index');
    }

    public function delete($id)
    {
        $space = $this->service->findSpace($id);
        $this->service->deleteSpace($space);

        return [
            'status' => 'success',
            'message' => 'Espacio eliminado'
        ];
    }
    
    // Strategy methods...
}
