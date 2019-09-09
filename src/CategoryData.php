<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Database\Eloquent\Model;

class CategoryData extends Model
{
    protected $table = "category_data";

    public $foreignKey = 'category_id';

    protected $fillable = [
        'category_id', 'language', 'name'
    ];
}
