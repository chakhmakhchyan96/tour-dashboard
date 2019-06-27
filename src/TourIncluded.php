<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class TourIncluded extends Model
{
    protected $table = "tour_includeds";

    public $foreignKey = 'tour_id';

    protected $fillable = [
        'tour_id', 'language', 'text'
    ];
}
