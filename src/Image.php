<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = ['resource_type', 'resource_id', 'type', 'key', 'path'];

    public function getPathAttribute($value)
    {
        if ($value)
            return config('filesystems.s3link') . "/$this->resource_type/$this->resource_id/$value";

        return config('filesystems.s3link') . '/change_this/default.jpg';
    }

    public function getThumb400Attribute()
    {
        if ($this->getOriginal('path'))
            return config('filesystems.s3link') . "/$this->resource_type/$this->resource_id/thumb/400/" . $this->getOriginal('path');

        return config('filesystems.s3link') . '/change_this/default.jpg';
    }

    public static function saveData($image, $type, $resource_type, $resource_id, $key = 'gallery')
    {
        $imageData['type'] = $type;
        $imageData['resource_type'] = $resource_type;
        $imageData['resource_id'] = $resource_id;
        $imageData['key'] = $key;
        $imageData['path'] = ImageService::savePhoto($image, "$resource_type/$resource_id");
        if ($key == 'gallery') {
            $image = Image::create($imageData);
        } else {
            $image = Image::updateOrCreate(['key' => $key, 'resource_id' => $resource_id, 'resource_type' => $resource_type] ,$imageData);
        }
        return $image;
    }
}
