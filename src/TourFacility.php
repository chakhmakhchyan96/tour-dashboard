<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class TourFacility extends Model
{
    protected $table = 'tour_facilities';
    public $timestamps = false;

    protected $fillable = [
        'tour_id', 'facility_id', 'type'
    ];
}
