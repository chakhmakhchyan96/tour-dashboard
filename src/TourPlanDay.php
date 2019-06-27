<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class TourPlanDay extends Model
{
    protected $table = "tour_plan_days";

    public $foreignKey = 'tour_plan_id';

    protected $fillable = [
        'tour_id'
    ];

    public function allFeatures()
    {
        return $this->hasMany(TourPlanDayFeature::class);
    }

    public function allData()
    {
        return $this->hasMany(TourPlanDayData::class);
    }
}
