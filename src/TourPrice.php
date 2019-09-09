<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class TourPrice extends Model
{
    protected $table = "tour_prices";

    public $foreignKey = 'tour_id';

    protected $fillable = [
        'tour_id', 'price', 'type', 'can_refuse'
    ];
}
