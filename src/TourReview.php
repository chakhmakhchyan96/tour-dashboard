<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class TourReview extends Model
{
    protected $table = "tour_reviews";

    public $foreignKey = 'tour_id';

    protected $fillable = [
        'tour_id', 'status', 'name', 'comment', 'email', 'transport', 'accommodation', 'food_beverages'
    ];
}
