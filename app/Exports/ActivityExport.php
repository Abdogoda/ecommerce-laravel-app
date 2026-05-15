<?php

namespace App\Exports;

class ActivityExport extends BaseExport
{
    public function getColumns(): array
    {
        return ['id', 'description', 'causer', 'event', 'created_at'];
    }

    public function getHeadings(): array
    {
        return ['ID', 'Description', 'User', 'Event', 'Date'];
    }

    public function getFilenamePrefix(): string
    {
        return 'activities_export';
    }

    public function formatRow($record): array
    {
        return [
            $record->id,
            $record->description ?? 'N/A',
            $record->causer?->name ?? 'System',
            $record->event ?? 'N/A',
            $record->created_at->format('M d, Y H:i'),
        ];
    }
}
