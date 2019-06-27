<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TourPlan extends Model
{
    protected $table = "tour_plans";

    public $foreignKey = 'tour_id';

    protected $fillable = [
        'tour_id', 'language', 'description'
    ];

    public function days()
    {
        return $this->hasMany(TourPlanDay::class);
    }
}
