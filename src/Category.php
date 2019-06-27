<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['status'];

    public function data()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        return $this->hasOne(CategoryData::class)->where('language', $lang);
    }

    public function allData()
    {
        return $this->hasMany(CategoryData::class);
    }
}
