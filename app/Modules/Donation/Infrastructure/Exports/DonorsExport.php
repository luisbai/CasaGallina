<?php

namespace App\Modules\Donation\Infrastructure\Exports;

use App\Modules\Donation\Infrastructure\Models\Donor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DonorsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Donor::query()
            ->withCount(['donations as total_donations' => function($query) {
                $query->where('status', 'completed');
            }])
            ->withSum(['donations as total_amount' => function($query) {
                $query->where('status', 'completed');
            }], 'amount')
            ->with(['donations' => function($query) {
                $query->where('status', 'completed')->latest();
            }])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Email',
            'Total Donaciones',
            'Monto Total',
            'Comprobante Fiscal',
            'Fecha Registro',
            'Última Donación'
        ];
    }

    public function map($donor): array
    {
        return [
            $donor->name,
            $donor->email,
            $donor->total_donations ?? 0,
            '$' . number_format($donor->total_amount ?? 0, 2),
            $donor->comprobante ? 'Sí' : 'No',
            $donor->created_at->format('Y-m-d H:i:s'),
            $donor->donations->first()?->created_at?->format('Y-m-d H:i:s') ?? 'N/A'
        ];
    }
}
