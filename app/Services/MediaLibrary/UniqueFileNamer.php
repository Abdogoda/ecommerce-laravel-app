<?php

namespace App\Services\MediaLibrary;

use Spatie\MediaLibrary\Support\FileNamer\DefaultFileNamer;
use Illuminate\Support\Str;

class UniqueFileNamer extends DefaultFileNamer
{
    public function originalFileName(string $fileName): string
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $name      = pathinfo($fileName, PATHINFO_FILENAME);

        return Str::slug($name) . '_' . time() . '_' . uniqid() . '.' . $extension;
    }
}