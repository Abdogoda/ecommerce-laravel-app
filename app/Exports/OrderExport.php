<?php

namespace App\Exports;

class OrderExport extends BaseExport
{
    public function getColumns(): array
    {
        return ['id', 'order_number', 'customer', 'total', 'status', 'created_at'];
    }

    public function getHeadings(): array
    {
        return ['ID', 'Order #', 'Customer', 'Total', 'Status', 'Date'];
    }

    public function getFilenamePrefix(): string
    {
        return 'orders_export';
    }

    public function formatRow($record): array
    {
        return [
            $record->id,
            $record->order_number ?? 'N/A',
            $record->user?->name ?? 'N/A',
            '$' . number_format($record->total ?? 0, 2),
            ucfirst($record->status ?? 'pending'),
            $record->created_at->format('M d, Y'),
        ];
    }
}
