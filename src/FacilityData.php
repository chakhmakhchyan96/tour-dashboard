<?php

namespace AISTGlobal\TourDashboard;
use Illuminate\Database\Eloquent\Model;

class FacilityData extends Model
{
    protected $table = "facility_data";

    public $foreignKey = 'facility_id';

    protected $fillable = [
        'facility_id', 'language', 'name'
    ];
}
