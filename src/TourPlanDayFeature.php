<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class TourPlanDayFeature extends Model
{
    protected $table = "tour_plan_day_features";

    public $foreignKey = 'tour_plan_day_id';

    protected $fillable = [
        'tour_plan_day_id', 'text', 'language'
    ];
}
