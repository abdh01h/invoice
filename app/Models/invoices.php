<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;

class invoices extends Model
{
    use HasFactory, SoftDeletes;
    use LogsActivity;
    use Filterable;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    // Logs Activity
    protected static $logName                 = 'Invoices Module';
    protected static $logUnguarded            = true;
    protected static $logOnlyDirty            = true;
    protected static $dontSubmitEmptyLogs     = true;

    private static $whiteListFilter = [];

    public function sections() {
        return $this->belongsTo(sections::class, 'section_id', 'id');
    }

}
