<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Services\ExportService;

trait ExportableTrait
{
    abstract protected function getExportQuery(): Builder;

    abstract protected function getExportClass(): string;

    public function exportAll()
    {
        $modelClass = $this->getExportQuery()->getModel()::class;
        return ExportService::exportAll($modelClass, $this->getExportClass());
    }

    public function exportFiltered()
    {
        return ExportService::exportFiltered(
            $this->getExportQuery(),
            $this->getExportClass()
        );
    }
}