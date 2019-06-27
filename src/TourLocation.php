<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class TourLocation extends Model
{
    protected $table = "tour_locations";

    public $foreignKey = 'tour_id';

    protected $fillable = [
        'tour_id', 'language', 'short_description', 'description'
    ];
}
