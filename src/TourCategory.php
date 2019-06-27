<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class TourCategory extends Model
{
    protected $table = 'tour_categories';
    public $timestamps = false;

    protected $fillable = [
        'tour_id', 'category_id'
    ];
}
