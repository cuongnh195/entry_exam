<?php

namespace App\Services;

use App\Enums\ImageType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
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
        $imagePath = $image->storeAs('assets/img/' . $type->value, $fileName, 'public');
        return $imagePath;
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
