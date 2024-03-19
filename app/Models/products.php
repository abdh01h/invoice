<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class products extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'product_name',
        'section_id',
        'description',
    ];

    // Logs Activity
    protected static $logName                 = 'Products Module';
    protected static $logFillable             = true;
    protected static $logOnlyDirty            = true;
    protected static $dontSubmitEmptyLogs     = true;

    public function sections() {
        return $this->belongsTo(sections::class, 'section_id', 'id');
    }

}
