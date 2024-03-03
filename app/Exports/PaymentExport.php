<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentExport implements FromQuery, WithStrictNullComparison, WithHeadings, WithMapping
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */

    private $rowNumber = 0;

    public function query()
    {
        return Payment::query()->select('id', 'payment_info_id', 'payment_method_types', 'amount', 'currency', 'created_at'); // Adjust this query based on your requirements
    }

    public function headings(): array
    {
        return [
            'Number',
            'ID',
            'Confirmation',
            'Type',
            'Amount',
            'Currency',
            'Created At'
        ];
    }


    public function map($record): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $record->id,
            $record->payment_info_id,
            $record->payment_method_types,
            $record->amount,
            $record->currency,
            $record->created_at,
        ];
        $i++;
    }
}
