<?php

namespace App\Exports;

class ProductExport extends BaseExport
{
    public function getColumns(): array
    {
        return ['id', 'name', 'price', 'stock', 'is_active'];
    }

    public function getHeadings(): array
    {
        return ['ID', 'Product Name', 'Price', 'Stock', 'Status'];
    }

    public function getFilenamePrefix(): string
    {
        return 'products_export';
    }

    public function formatRow($record): array
    {
        return [
            $record->id,
            $record->name,
            $record->price ?? 0,
            $record->stock ?? 0,
            $record->is_active ? 'Active' : 'Inactive',
        ];
    }
}