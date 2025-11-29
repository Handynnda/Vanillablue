<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'url_image'];


    public function setUrlImageAttribute($value)
    {
        // If already a URL string, store as-is
        if (is_string($value) && preg_match('/^https?:\/\//', $value)) {
            $this->attributes['url_image'] = $value;
            return;
        }

        // If value is a string path saved by the Cloudinary disk, resolve to secure URL
        if (is_string($value)) {
            try {
                $info = pathinfo($value);
                $dirname = isset($info['dirname']) ? str_replace('\\', '/', $info['dirname']) : '';
                $dirname = ($dirname === '.' ? '' : trim($dirname, '/'));
                $filename = $info['filename'] ?? pathinfo($value, PATHINFO_FILENAME);
                $publicId = ($dirname ? $dirname.'/' : '').$filename;

                // Assume image resources for this model
                $asset = Cloudinary::adminApi()->asset($publicId, ['resource_type' => 'image']);
                $url = $asset->offsetGet('secure_url');
                $this->attributes['url_image'] = $url ?: $value;
            } catch (\Throwable $e) {
                $this->attributes['url_image'] = $value;
            }
            return;
        }

        // If it's an uploaded file (Livewire TemporaryUploadedFile or Symfony UploadedFile)
        if (is_object($value) && method_exists($value, 'getRealPath')) {
            try {
                $upload = Cloudinary::upload($value->getRealPath());
                $this->attributes['url_image'] = $upload->getSecurePath();
                return;
            } catch (\Throwable $e) {
                // Fallback to raw path to avoid exceptions
                $this->attributes['url_image'] = (string) $value->getRealPath();
                return;
            }
        }

        // Final fallback
        $this->attributes['url_image'] = is_string($value) ? $value : (string) $value;
    }
}
