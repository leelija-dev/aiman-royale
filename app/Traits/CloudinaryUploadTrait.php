<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

trait CloudinaryUploadTrait
{
    /**
     * Upload a single image to Cloudinary
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param array $options
     * @return array|null
     */
    // public function uploadToCloudinary($file, $folder = 'products', $options = [])
    // {
    //     try {
    //         // Check if Cloudinary is configured
    //         if (!config('filesystems.disks.cloudinary')) {
    //             // Fallback to local storage if Cloudinary not configured
    //             return $this->uploadToLocal($file, $folder);
    //         }

    //         $defaultOptions = [
    //             'folder' => $folder,
    //             'quality' => 'auto',
    //             'fetch_format' => 'auto',
    //             'secure' => true,
    //         ];

    //         $uploadOptions = array_merge($defaultOptions, $options);

    //         $uploadedFile = Storage::disk('cloudinary')->put($folder, $file, $uploadOptions);

    //         // Get the Cloudinary URL
    //         $url = Storage::disk('cloudinary')->url($uploadedFile);
    //         $publicId = $uploadedFile;

    //         return [
    //             'path' => $url,
    //             'public_id' => $publicId,
    //             'folder' => $folder,
    //         ];
    //     } catch (\Exception $e) {
    //         \Log::error('Cloudinary upload failed: ' . $e->getMessage());
    //         // Fallback to local upload
    //         return $this->uploadToLocal($file, $folder);
    //     }
    // }

    public function uploadToCloudinary($file, $folder = 'products', $options = [])
    {
        try {
            // Check if Cloudinary is configured
            if (!config('filesystems.disks.cloudinary')) {
                // Fallback to local storage if Cloudinary not configured
                return $this->uploadToLocal($file, $folder);
            }

            // Prepare options - include folder structure
            $uploadOptions = [
                'folder' => $folder,
                'quality' => $options['quality'] ?? 'auto',
                'fetch_format' => $options['fetch_format'] ?? 'auto',
            ];

            // Upload using Cloudinary API directly (your working approach)
            $upload = Cloudinary::uploadApi()->upload(
                $file->getRealPath(),
                $uploadOptions
            );

            return [
                'path' => $upload['secure_url'],
                'public_id' => $upload['public_id'],
                'folder' => $folder,
            ];
        } catch (\Exception $e) {
            \Log::error('Cloudinary upload failed: ' . $e->getMessage());
            // Fallback to local upload
            return $this->uploadToLocal($file, $folder);
        }
    }

    /**
     * Fallback local upload method
     */
    private function uploadToLocal($file, $folder = 'products')
    {
        try {
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $folder = 'uploads/' . $folder;
            $uploadPath = public_path($folder);

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $file->move($uploadPath, $filename);
            $imagePath = $folder . '/' . $filename;

            return [
                'path' => asset($imagePath),
                'public_id' => null,
                'folder' => $folder,
                'local_path' => $imagePath
            ];
        } catch (\Exception $e) {
            \Log::error('Local upload failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Upload multiple images to Cloudinary
     *
     * @param array $files
     * @param string $folder
     * @param array $options
     * @return array
     */
    public function uploadMultipleToCloudinary($files, $folder = 'products', $options = [])
    {
        $uploadedImages = [];

        foreach ($files as $file) {
            $result = $this->uploadToCloudinary($file, $folder, $options);
            if ($result) {
                $uploadedImages[] = $result;
            }
        }

        return $uploadedImages;
    }

    /**
     * Delete an image from Cloudinary
     *
     * @param string $publicId
     * @return bool
     */
    // public function deleteFromCloudinary($publicId)
    // {
    //     // dd($publicId);
    //     try {
    //         // Skip if no public_id (local file)
    //         if (!$publicId) {
    //             return true;
    //         }

    //         // Check if Cloudinary is configured
    //         if (config('filesystems.disks.cloudinary')) {
    //             Storage::disk('cloudinary')->delete($publicId);
    //         }
    //         return true;
    //     } catch (\Exception $e) {
    //         \Log::error('Cloudinary delete failed: ' . $e->getMessage());
    //         return false;
    //     }
    // }
public function deleteFromCloudinary($publicId)
{
    try {
        if (!$publicId) {
            return true;
        }

        // Don't strip the path - keep the full public_id with folder structure
        // Just remove file extension if present
        $cleanPublicId = $publicId;
        if (pathinfo($publicId, PATHINFO_EXTENSION)) {
            $cleanPublicId = pathinfo($publicId, PATHINFO_FILENAME);
        }
        
        \Log::info("Attempting to delete Cloudinary image: {$cleanPublicId}");
        
        // Use the cloudinary helper with the full path
        $result = cloudinary()->uploadApi()->destroy($cleanPublicId, [
            'invalidate' => true
        ]);
        
        \Log::info('Cloudinary delete result:', ['result' => $result]);
        
        // Check the result
        if (isset($result['result']) && $result['result'] === 'ok') {
            \Log::info("Successfully deleted Cloudinary image: {$cleanPublicId}");
            return true;
        } elseif (isset($result['result']) && $result['result'] === 'not found') {
            \Log::info("Cloudinary image already deleted or not found: {$cleanPublicId}");
            return true; // Consider it success
        }
        
        \Log::warning("Cloudinary delete failed", [
            'public_id' => $cleanPublicId,
            'result' => $result
        ]);
        return false;
        
    } catch (\Exception $e) {
        \Log::error('Cloudinary delete failed: ' . $e->getMessage(), [
            'public_id' => $publicId,
            'error' => $e->getMessage()
        ]);
        return false;
    }
}

    /**
     * Delete local file
     */
    public function deleteLocalFile($path)
    {
        try {
            if ($path && file_exists(public_path($path))) {
                unlink(public_path($path));
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get optimized image URL with transformations
     *
     * @param string $publicId
     * @param array $transformations
     * @return string
     */
    public function getOptimizedImageUrl($publicId, $transformations = [])
    {
        try {
            if (!$publicId) {
                return null;
            }

            $url = Storage::disk('cloudinary')->url($publicId);

            // Cloudinary allows adding transformations directly to the URL
            if (!empty($transformations)) {
                $transformationString = implode(',', $transformations);
                $url = str_replace('/upload/', "/upload/{$transformationString}/", $url);
            }

            return $url;
        } catch (\Exception $e) {
            return null;
        }
    }
}
