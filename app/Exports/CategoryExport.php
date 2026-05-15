<?php

namespace App\Exports;

class CategoryExport extends BaseExport
{
    public function getColumns(): array
    {
        return ['id', 'name', 'slug', 'description', 'is_active'];
    }

    public function getHeadings(): array
    {
        return ['ID', 'Category Name', 'Slug', 'Description', 'Status'];
    }

    public function getFilenamePrefix(): string
    {
        return 'categories_export';
    }

    public function formatRow($record): array
    {
        return [
            $record->id,
            $record->name,
            $record->slug ?? 'N/A',
            $record->description ?? 'N/A',
            $record->is_active ? 'Active' : 'Inactive',
        ];
    }
}
