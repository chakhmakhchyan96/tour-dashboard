<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class TourFeature extends Model
{
    protected $table = "tour_features";

    public $foreignKey = 'tour_id';

    protected $fillable = [
        'tour_id', 'language', 'key', 'value'
    ];
}
