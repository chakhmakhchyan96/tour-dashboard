<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Facilities extends Model
{
    protected  $table = 'facilities';
    protected  $fillable = ['status'];
    protected  $primaryKey = 'id';

    public function data()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        return $this->hasOne(FacilityData::class, 'facility_id')->where('language', $lang);
    }

    public function allData()
    {
        return $this->hasMany(FacilityData::class, 'facility_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'resource_id')->where('resource_type', 'facility');
    }
}
