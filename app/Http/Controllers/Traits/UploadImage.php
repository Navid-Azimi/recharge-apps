<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadImage
{
    protected function uploadImage(string $inputName): string
    {
        $uploadPath = request()->file($inputName)->store('uploads', 'public');
        return $this->getImageNameFromPath($uploadPath);
    }

    protected function deleteImage(string $imageName): bool
    {
        $path = $this->getImageUploadPath($imageName);

        if (!Storage::disk('public')->exists('uploads')) {
            throw new \Exception('The file does not exist in the storage.');
        }

        if (!Storage::disk('public')->delete($path)) {
            throw new \Exception('Error on deleting of the image file.');
        }

        return true;
    }

    private function isImageExist(string $imageName): bool
    {
        $path = $this->getImageUploadPath($imageName);
        return  Storage::disk('public')->exists($path);
    }

    private function getImageNameFromPath(string $uploadPath): string
    {
        return  str_replace('uploads/', '', $uploadPath);
    }

    private function getImageUploadPath(string $imageName): string
    {
        return "uploads/" . $imageName;
    }

    private function getRandomNameForImage($imageName): string
    {
        $randomName = Str::random(50);
        $fileExtension = substr($imageName, strrpos($imageName, '.') + 1);
        return "$randomName.$fileExtension";
    }
}
