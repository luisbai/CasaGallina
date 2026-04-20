<?php

namespace App\Modules\Program\Infrastructure\Repositories;

use App\Modules\Program\Domain\Interfaces\ProgramRepositoryInterface;
use App\Modules\Program\Infrastructure\Models\Program;

class ProgramRepository implements ProgramRepositoryInterface
{
    public function all()
    {
        return Program::all();
    }

    public function find(int $id)
    {
        return Program::with(['tags', 'multimedia', 'exhibition'])->find($id);
    }

    public function create(array $data)
    {
        return Program::create($data);
    }

    public function update(int $id, array $data)
    {
        $program = Program::find($id);
        if ($program) {
            $program->update($data);
            return $program;
        }
        return null;
    }

    public function delete(int $id)
    {
        $program = Program::find($id);
        if ($program) {
            return $program->delete();
        }
        return false;
    }

    public function getActivePrograms()
    {
        return Program::where('estado', 'public')->latest()->get();
    }
    
    public function getActiveProgramsByType(string $type)
    {
        return Program::where('estado', 'public')
            ->where('tipo', $type)
            ->with(['tags', 'multimedia'])
            ->latest() // Assuming ordering by creation or explicit field
            ->get();
    }
}
