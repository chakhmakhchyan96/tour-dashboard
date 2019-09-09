<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class TourHotel extends Model
{
    protected $table = 'tour_hotels';
    public $timestamps = false;

    protected $fillable = [
        'tour_id', 'hotel_id'
    ];
}
