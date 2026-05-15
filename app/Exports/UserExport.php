<?php

namespace App\Exports;

class UserExport extends BaseExport
{
    public function getColumns(): array
    {
        return ['id', 'name', 'email', 'phone', 'is_active'];
    }

    public function getHeadings(): array
    {
        return ['ID', 'Name', 'Email', 'Phone', 'Status'];
    }

    public function getFilenamePrefix(): string
    {
        return 'users_export';
    }

    public function formatRow($record): array
    {
        return [
            $record->id,
            $record->name,
            $record->email,
            $record->phone ?? 'N/A',
            $record->is_active ? 'Active' : 'Inactive',
        ];
    }
}
