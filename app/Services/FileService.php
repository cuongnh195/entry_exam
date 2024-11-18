<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Enums\ImageType;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * Save image to storage public/assets/img/{type}
     *
     * @param UploadedFile $image
     * @param ImageType $type
     * @return string
     */
    public function saveImage(UploadedFile $image, ImageType $type = ImageType::HOTEL): string
    {
        //save image to storage public/assets/img/{type}
        $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/img/' . $type->value), $fileName);
        return $type->value.'/'.$fileName;
    }

    /**
     * Delete image from storage
     *
     * @param string $imagePath
     * @return void
     */
    public function deleteImage(string $imagePath): void
    {
        Storage::disk('public')->delete($imagePath);
    }
}
