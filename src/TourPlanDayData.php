<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class TourPlanDayData extends Model
{
    protected $table = "tour_plan_day_data";

    public $foreignKey = 'tour_plan_day_id';

    protected $fillable = [
        'tour_plan_day_id', 'title', 'description', 'language'
    ];
}
