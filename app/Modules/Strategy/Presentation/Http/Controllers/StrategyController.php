<?php

namespace App\Modules\Strategy\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Strategy\Application\Services\StrategyService;
use App\Modules\Strategy\Infrastructure\Models\Strategy;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class StrategyController extends Controller
{
    public function __construct(
        protected StrategyService $service
    ) {
        $this->middleware('auth');
    }

    public function index()
    {
        $estrategias = $this->service->getAll();
        return view('admin.estrategias.index', compact('estrategias'));
    }

    public function create()
    {
        return view('admin.estrategias.create');
    }

    public function edit($id)
    {
        $estrategia = $this->service->find($id);
        if (!$estrategia) abort(404);
        return view('admin.estrategias.edit', compact('estrategia'));
    }

    public function show($id)
    {
        $estrategia = $this->service->find($id);
        if (!$estrategia) abort(404);
        return $estrategia;
    }

    public function store(Request $request)
    {
        $this->validate($request, Strategy::$rules);

        $input = $request->input();
        
        $this->service->create(
            $input, 
            $request->file('imagenes') ?? [], 
            $request->file('destacada_multimedia_id')
        );

        toastr()->success('Estrategia creada', 'Éxito');
        return redirect()->route('admin.estrategias.index');
    }

    public function update($id, Request $request)
    {
        // Validation handled partly by service/controller but we need rules here.
        // Copying logic from original controller: exclude 'destacada_multimedia_id', 'imagenes' from required rules on update
        $rules = Strategy::$rules;
        unset($rules['destacada_multimedia_id']);
        unset($rules['imagenes']);
        
        $this->validate($request, $rules);

        $input = $request->input();

        $this->service->update(
            $id, 
            $input, 
            $request->file('imagenes') ?? [], 
            $request->file('destacada_multimedia_id')
        );

        toastr()->success('Estrategia actualizada', 'Éxito');
        return redirect()->route('admin.estrategias.index');
    }

    public function delete($id)
    {
        $this->service->delete($id);
        
        return [
            'status' => 'success',
            'message' => 'Estrategia eliminada'
        ];
    }

    public function deleteImage($id, Request $request)
    {
        $this->validate($request, [
            'multimedia_id' => ['required', 'numeric'],
            'tipo' => ['required']
        ]);

        $this->service->deleteImage(
            $id, 
            $request->input('multimedia_id'), 
            $request->input('tipo')
        );

        return [
            'status' => 'success',
            'message' => 'Imagen eliminada'
        ];
    }

    public function datatables()
    {
        $estrategias = $this->service->getAll();

        return Datatables::of($estrategias)
            ->addColumn('acciones', function ($estrategia) {
                return '<button type="button" class="btn btn-primary btn-sm" data-action="agregar-estrategia" data-estrategia="' . $estrategia->id . '">Agregar</button>';
            })
            ->rawColumns(['acciones'])
            ->make();
    }
}
