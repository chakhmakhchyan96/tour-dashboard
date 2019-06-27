<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class TourData extends Model
{
    protected $table = "tour_data";

    public $foreignKey = 'tour_id';

    protected $fillable = [
        'tour_id', 'language', 'short_title', 'title', 'content', 'short_content', 'duration', 'date_info',
        'gallery_text', 'meta_title', 'meta_description', 'meta_keywords'
    ];
}
