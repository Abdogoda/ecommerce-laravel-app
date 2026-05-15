<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

abstract class BaseExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected Collection $data;
    protected bool $isDirectData = false;

    abstract public function getColumns(): array;

    abstract public function formatRow($record): array;

    abstract public function getHeadings(): array;

    abstract public function getFilenamePrefix(): string;

    public function setData(Collection $data): self
    {
        $this->data = $data;
        $this->isDirectData = false;
        return $this;
    }

    public function setDirectData(Collection $data): self
    {
        $this->data = $data;
        $this->isDirectData = true;
        return $this;
    }

    public function collection()
    {
        if ($this->isDirectData) {
            // Data is already formatted from frontend, return as-is
            return $this->data;
        }

        // Format data from database records
        return $this->data->map(function ($record) {
            return $this->formatRow($record);
        });
    }

    public function headings(): array
    {
        return $this->getHeadings();
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1f2937'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        return [];
    }

    public function generateFilename(string $type = 'xlsx'): string
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        return "{$this->getFilenamePrefix()}_{$timestamp}.{$type}";
    }
}