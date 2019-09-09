<?php

namespace AISTGlobal\TourDashboard;

use App\Hotel; // need to fix
use App\Services\DataService;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Tour extends Model
{
    protected $table = 'tours';
    protected $fillable = ['created_at', 'price', 'slug', 'status', 'age_from', 'map', 'start_date', 'end_date', 'start_time', 'end_time'];

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

    public function facilities()
    {
        return $this->belongsToMany(Facilities::class, 'tour_facilities', 'tour_id', 'facility_id', 'id', 'id')
            ->withPivot('type');
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'tour_hotels', 'tour_id', 'hotel_id');
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

    public function reviews()
    {
        return $this->hasMany(TourReview::class);
    }

    public function prices()
    {
        return $this->hasMany(TourPrice::class);
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

        if (array_key_exists('tour_id', $data)) {
            $tour = Tour::updateOrCreate(['id' => $data['tour_id']], $data);
            (new DataService())->updateData($data, $tour->id, new TourData());
        } else {
            $data['slug'] = DataService::getSlug($data['title_en'], 'App\Tour');
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

        $keys = ['breakfast', 'lunch', 'dinner'];

        foreach ($keys as $key) {

            if (array_key_exists($key . '_price', $data) && $data[$key . '_price']) {
                $can_refuse = 0;
                if (array_key_exists($key . '_can_refuse', $data) && $data[$key . '_can_refuse']) {
                    $can_refuse = 1;
                }
                TourPrice::create([
                    'tour_id' => $tour->id,
                    'type' => $key,
                    'price' => $data[$key . '_price'],
                    'can_refuse' => $can_refuse,
                ]);
            }
        }

        return $tour->id;
    }
}
