<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class sections extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'section_name',
        'description',
        'created_by',
    ];

    // Logs Activity
    protected static $logName                 = 'Sections Module';
    protected static $logFillable             = true;
    protected static $logOnlyDirty            = true;
    protected static $dontSubmitEmptyLogs     = true;

    public function products() {
        return $this->hasMany(products::class, 'section_id', 'id');
    }

}
