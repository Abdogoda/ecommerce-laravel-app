<?php

namespace App\Exports;

class RoleExport extends BaseExport
{
    public function getColumns(): array
    {
        return ['id', 'name', 'users_count', 'permissions_count', 'created_at'];
    }

    public function getHeadings(): array
    {
        return ['ID', 'Role Name', 'Users', 'Permissions', 'Created'];
    }

    public function getFilenamePrefix(): string
    {
        return 'roles_export';
    }

    public function formatRow($record): array
    {
        return [
            $record->id,
            $record->name,
            $record->users()->count(),
            $record->permissions()->count(),
            $record->created_at?->format('M d, Y') ?? 'N/A',
        ];
    }
}
