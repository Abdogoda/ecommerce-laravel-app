<?php

namespace App\Exports;

class NotificationExport extends BaseExport
{
    public function getColumns(): array
    {
        return ['id', 'type', 'user', 'subject', 'read_at', 'created_at'];
    }

    public function getHeadings(): array
    {
        return ['ID', 'Type', 'User', 'Subject', 'Status', 'Date'];
    }

    public function getFilenamePrefix(): string
    {
        return 'notifications_export';
    }

    public function formatRow($record): array
    {
        $data = $record->data ?? [];
        $type = $record->type ?? 'Notification';
        $type = class_basename($type);
        
        return [
            $record->id,
            $type,
            $record->notifiable?->name ?? 'N/A',
            $data['subject'] ?? 'No Subject',
            $record->read_at ? 'Read' : 'Unread',
            $record->created_at->format('M d, Y H:i'),
        ];
    }
}
