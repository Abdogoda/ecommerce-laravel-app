<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class ExportService
{
    public static function exportFiltered(Builder $query, string $exportClass): mixed
    {
        $data = $query->get();

        $export = new $exportClass();
        $export->setData($data);

        return Excel::download(
            $export,
            $export->generateFilename('xlsx')
        );
    }

    public static function exportAll(string $modelClass, string $exportClass): mixed
    {
        $data = $modelClass::all();

        $export = new $exportClass();
        $export->setData($data);

        return Excel::download(
            $export,
            $export->generateFilename('xlsx')
        );
    }

    public static function exportCustom(Builder $query, string $exportClass, string $filename = ''): mixed
    {
        $data = $query->get();

        $export = new $exportClass();
        $export->setData($data);

        if (empty($filename)) {
            $filename = $export->generateFilename('xlsx');
        }

        return Excel::download($export, $filename);
    }
}