<?php

namespace App\Modules\Shared\Application\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Modules\Multimedia\Infrastructure\Models\Multimedia;

class ImageService
{
    /**
     * Process and store an uploaded image with resizing
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int $maxWidth
     * @param int $maxHeight
     * @param int $quality
     * @return Multimedia
     */
    public function processAndStore(
        UploadedFile $file, 
        string $directory = 'images', 
        int $maxWidth = 1200, 
        int $maxHeight = 800, 
        int $quality = 85
    ): Multimedia {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $directory . '/' . $filename;
        
        // Process the image
        $image = Image::make($file);
        
        // Get original dimensions
        $originalWidth = $image->width();
        $originalHeight = $image->height();
        
        // Calculate aspect ratio
        $aspectRatio = $originalWidth / $originalHeight;
        
        // Determine new dimensions while maintaining aspect ratio
        if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
            if ($aspectRatio > 1) {
                // Landscape orientation
                $newWidth = min($maxWidth, $originalWidth);
                $newHeight = $newWidth / $aspectRatio;
                
                if ($newHeight > $maxHeight) {
                    $newHeight = $maxHeight;
                    $newWidth = $newHeight * $aspectRatio;
                }
            } else {
                // Portrait orientation
                $newHeight = min($maxHeight, $originalHeight);
                $newWidth = $newHeight * $aspectRatio;
                
                if ($newWidth > $maxWidth) {
                    $newWidth = $maxWidth;
                    $newHeight = $newWidth / $aspectRatio;
                }
            }
            
            // Resize the image
            $image->resize($newWidth, $newHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize(); // Prevent upsizing
            });
        }
        
        // Encode with quality setting
        $encodedImage = $image->encode($file->getClientOriginalExtension(), $quality);
        
        // Store the processed image
        Storage::disk('public')->put($path, $encodedImage);
        
        // Create multimedia record
        $multimedia = Multimedia::create([
            'filename' => $path,
            'mime' => $file->getMimeType(),
            'size' => $encodedImage->filesize(),
        ]);
        
        return $multimedia;
    }
    
    /**
     * Create thumbnail version of an image
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int $width
     * @param int $height
     * @return Multimedia
     */
    public function createThumbnail(
        UploadedFile $file, 
        string $directory = 'thumbnails', 
        int $width = 300, 
        int $height = 200
    ): Multimedia {
        // Generate unique filename
        $filename = 'thumb_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $directory . '/' . $filename;
        
        // Create thumbnail
        $image = Image::make($file);
        $image->fit($width, $height, function ($constraint) {
            $constraint->upsize();
        });
        
        // Encode with high quality for thumbnails
        $encodedImage = $image->encode($file->getClientOriginalExtension(), 90);
        
        // Store the thumbnail
        Storage::disk('public')->put($path, $encodedImage);
        
        // Create multimedia record
        $multimedia = Multimedia::create([
            'filename' => $path,
            'mime' => $file->getMimeType(),
            'size' => $encodedImage->filesize(),
        ]);
        
        return $multimedia;
    }
} 