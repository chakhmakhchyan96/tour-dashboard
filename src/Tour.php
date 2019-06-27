<?php

namespace AISTGlobal\TourDashboard;

use AISTGlobal\TourDashboard\Services\DataService;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Tour extends Model
{
    protected $table = 'tours';
    protected $fillable = ['created_at', 'price', 'slug', 'status', 'age_from', 'map'];

    public function data()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        return $this->hasOne(TourData::class)->where('language', $lang);
    }

    public function allData()
    {
        return $this->hasMany(TourData::class);
    }

    public function category(){
        return $this->belongsToMany(Category::class, 'tour_categories');
    }

    public function allFeatures()
    {
        return $this->hasMany(TourFeature::class);
    }

    public function features()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        return $this->hasMany(TourFeature::class)->where('language', $lang);
    }

    public function bookings()
    {
        return $this->hasMany(TourBooking::class);
    }

    public function included()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        return $this->hasMany(TourIncluded::class)->where('language', $lang);
    }

    public function allIncluded()
    {
        return $this->hasMany(TourIncluded::class);
    }

    public function allLocations()
    {
        return $this->hasMany(TourLocation::class);
    }

    public function location()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        return $this->hasOne(TourLocation::class)->where('language', $lang);
    }

    public function allPlans()
    {
        return $this->hasMany(TourPlan::class);
    }

    public function plan()
    {
        $lang = LaravelLocalization::getCurrentLocale();
        return $this->hasOne(TourPlan::class)->where('language', $lang);
    }

    public function allPlanDays()
    {
        return $this->hasMany(TourPlanDay::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'resource_id')->where('resource_type', 'tour');
    }

    public function getImagesAttribute()
    {
        return $this->getRelationValue('images')->groupBy('key');
    }

    public static function saveData($data)
    {
        $data['slug'] = DataService::getSlug($data['title_en'], 'AISTGlobal\TourDashboard\Tour');

        if (array_key_exists('tour_id', $data)) {
            $tour = Tour::updateOrCreate(['id' => $data['tour_id']], $data);
            (new DataService())->updateData($data, $tour->id, new TourData());
        } else {
            $tour = Tour::create($data);
            (new DataService())->saveData($data, $tour->id, new TourData());
        }

        if (isset($data['image']) && $data['image']) {
            Image::saveData($data['image'], 'image', 'tour', $tour->id, 'image');
        }

        if (isset($data['background_image']) && $data['background_image']) {
            Image::saveData($data['background_image'], 'image', 'tour', $tour->id, 'background_image');
        }

        if (array_key_exists('category', $data) && $data['category']) {
            $tour->category()->sync($data['category']);
        } else {
            $tour->category()->sync([]);
        }

        return $tour->id;

    }
}
